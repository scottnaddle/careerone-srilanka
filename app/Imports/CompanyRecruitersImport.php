<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\CompanyRecruiter;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\RecruiterAccountCreated;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Cell\DefaultValueBinder;

class CompanyRecruitersImport extends DefaultValueBinder implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure, WithCustomValueBinder
{
    private $skipDuplicates;
    private $previewMode;
    private $sendWelcomeEmail;
    private $successCount = 0;
    private $skippedCount = 0;
    private $errors = [];
    private $previewData = [];
    private $createdRecruiters = []; // Store created recruiters with plain passwords

    public function __construct($skipDuplicates = true, $previewMode = false, $sendWelcomeEmail = false)
    {
        $this->skipDuplicates = $skipDuplicates;
        $this->previewMode = $previewMode;
        $this->sendWelcomeEmail = $sendWelcomeEmail;
    }

    /**
     * Custom value binder to handle telephone as string
     */
    public function bindValue(Cell $cell, $value)
    {
        // Convert telephone column to string
        if ($cell->getColumn() == 'E' && $cell->getRow() > 1) { // Column E is telephone
            $cell->setValueExplicit((string)$value, DataType::TYPE_STRING);
            return true;
        }

        // Default binding for other columns
        return parent::bindValue($cell, $value);
    }

    public function model(array $row)
    {
        // Clean and format telephone to string
        $telephone = isset($row['telephone']) ? (string) trim($row['telephone']) : '';

        // Remove any non-digit characters except plus sign for telephone
        $telephone = preg_replace('/[^0-9+]/', '', $telephone);

        $companyName = trim($row['company_name']);
        $company = Company::whereRaw('LOWER(name) = ?', [Str::lower($companyName)])
            ->whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->where('active', true)
            ->first();

        if (!$company) {
            $this->errors[] = [
                'row' => $row,
                'error' => "Company '{$companyName}' not found or not verified"
            ];
            return null;
        }

        $email = trim($row['email']);
        $existingRecruiter = CompanyRecruiter::where('email', $email)->first();

        if ($existingRecruiter && $this->skipDuplicates) {
            $this->skippedCount++;
            $this->errors[] = [
                'row' => $row,
                'error' => "Email '{$email}' already exists - skipped (duplicate)"
            ];
            return null;
        }

        if ($this->previewMode) {
            $this->previewData[] = [
                'company_name' => $company->name,
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'email' => $row['email'],
                'telephone' => $telephone,
                'status' => $existingRecruiter ? 'Will be updated' : 'New',
            ];
            return null;
        }

        $tempPassword = 'Tvec@2026';

        if ($existingRecruiter && !$this->skipDuplicates) {
            $existingRecruiter->update([
                'company_id' => $company->id,
                'first_name' => $row['first_name'],
                'last_name' => $row['last_name'],
                'telephone' => $telephone,
                'active' => true,
            ]);
            $this->successCount++;

            // Send welcome email for updated recruiter if enabled
            if ($this->sendWelcomeEmail) {
                try {
                    Mail::to($existingRecruiter->email)->send(new RecruiterAccountCreated($existingRecruiter, $tempPassword));
                } catch (\Exception $e) {
                    $this->errors[] = [
                        'row' => $row,
                        'error' => "Failed to send email to {$email}: {$e->getMessage()}"
                    ];
                }
            }

            return null;
        }

        $recruiter = new CompanyRecruiter([
            'company_id' => $company->id,
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => $row['email'],
            'username' => $row['email'],
            'telephone' => $telephone,
            'password' => bcrypt($tempPassword),
            'active' => true,
            'email_verified_at' => now(),
            'verify_at' => now(),
            'verify_by' => auth('admin')->id(),
        ]);

        $this->successCount++;

        // Store the recruiter and plain password for email sending
        $this->createdRecruiters[] = [
            'recruiter' => $recruiter,
            'plainPassword' => $tempPassword
        ];

        return $recruiter;
    }

    /**
     * Send welcome emails to all created recruiters after import
     */
    public function sendWelcomeEmails()
    {
        if (!$this->sendWelcomeEmail) {
            return;
        }

        foreach ($this->createdRecruiters as $data) {
            try {
                Mail::to($data['recruiter']->email)->send(
                    new RecruiterAccountCreated($data['recruiter'], $data['plainPassword'])
                );
            } catch (\Exception $e) {
                $this->errors[] = [
                    'row' => [],
                    'error' => "Failed to send email to {$data['recruiter']->email}: {$e->getMessage()}"
                ];
            }
        }

        // Clear the array after sending
        $this->createdRecruiters = [];
    }

    public function rules(): array
    {
        return [
            '*.company_name' => 'required|string',
            '*.first_name' => 'required|string|max:255',
            '*.last_name' => 'required|string|max:255',
            '*.email' => 'required|email',
            '*.telephone' => 'required|string|max:20',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'company_name.required' => 'Company name is required',
            'first_name.required' => 'First name is required',
            'last_name.required' => 'Last name is required',
            'email.required' => 'Email is required',
            'email.email' => 'Please enter a valid email address',
            'telephone.required' => 'Telephone is required',
            'telephone.string' => 'Telephone must be a valid phone number',
        ];
    }

    public function prepareForValidation($data, $index)
    {
        // Convert telephone to string before validation
        if (isset($data['telephone'])) {
            $data['telephone'] = (string) $data['telephone'];
        }

        return $data;
    }

    public function onFailure(Failure ...$failures)
    {
        foreach ($failures as $failure) {
            $this->errors[] = [
                'row' => $failure->values(),
                'error' => implode(', ', $failure->errors())
            ];
        }
    }

    public function getResults()
    {
        return [
            'success' => $this->successCount,
            'skipped' => $this->skippedCount,
            'errors' => $this->errors,
        ];
    }
}
