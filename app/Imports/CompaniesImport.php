<?php

namespace App\Imports;

use App\Models\Company;
use App\Models\District;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CompaniesImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    protected int $imported = 0;
    protected array $failed = [];
    protected $officeTypes;
    protected $companyInfos;

    public function __construct()
    {
        Log::info('=== COMPANIES IMPORT INITIALIZED ===');

        try {
            $this->officeTypes = collect(getCodeList('office_type'));
            $this->companyInfos = collect(getCodeList('company_information'));

            Log::info('Code lists loaded successfully', [
                'office_types_count' => $this->officeTypes->count(),
                'office_types_sample' => $this->officeTypes->take(3)->toArray(),
                'company_infos_count' => $this->companyInfos->count(),
                'company_infos_sample' => $this->companyInfos->take(3)->toArray(),
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to load code management list', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            $this->officeTypes = collect([]);
            $this->companyInfos = collect([]);
        }

        Log::info('=== INITIALIZATION COMPLETE ===');
    }

    public function collection(Collection $rows)
    {
        Log::info('=== START PROCESSING COLLECTION ===');
        Log::info('Total rows received: ' . $rows->count());

        // Log the first row to see headers
        if ($rows->isNotEmpty()) {
            $firstRow = $rows->first();
            Log::info('First row (headers):', [
                'original_keys' => array_keys($firstRow->toArray()),
                'full_first_row' => $firstRow->toArray()
            ]);
        }

        foreach ($rows as $rowIndex => $row) {
            Log::info("=== PROCESSING ROW INDEX: {$rowIndex} (Excel Row: " . ($rowIndex + 2) . ") ===");

            // Convert row to array and log original data
            $originalRowArray = $row->toArray();
            Log::info('Original row data:', $originalRowArray);

            // Normalize all row keys
            $rowData = collect($row)->mapWithKeys(function ($value, $key) {
                $normalizedKey = trim(strtolower(str_replace(' ', '_', $key)));
                Log::info("Normalizing key: '{$key}' => '{$normalizedKey}'");
                return [$normalizedKey => $value];
            })->toArray();

            Log::info('Normalized row data:', $rowData);
            Log::info('Available keys after normalization:', array_keys($rowData));

            $companyName = $rowData['company_name'] ?? null;

            Log::info('Company name check:', [
                'value' => $companyName,
                'is_empty' => empty($companyName),
                'length' => strlen(trim($companyName ?? '')),
                'will_skip' => (empty($companyName) || strlen(trim($companyName ?? '')) < 2)
            ]);

            if (empty($companyName) || strlen(trim($companyName)) < 2) {
                Log::info("Skipping row {$rowIndex} - No valid company name");
                continue;
            }

            DB::beginTransaction();

            try {
                // 1. District Processing
                $districtName = $rowData['district'] ?? null;
                Log::info('District processing:', [
                    'raw_value' => $districtName,
                    'column_exists' => isset($rowData['district']),
                    'all_keys' => array_keys($rowData)
                ]);

                $districtId = null;

                if (!empty($districtName)) {
                    $cleanDistrictName = strtolower(trim($districtName));
                    Log::info('Looking for district:', [
                        'search_term' => $cleanDistrictName,
                        'original' => $districtName
                    ]);

                    $district = District::whereRaw('LOWER(name) = ?', [$cleanDistrictName])
                        ->orWhereRaw('LOWER(name) LIKE ?', ['%' . $cleanDistrictName . '%'])
                        ->first();

                    if ($district) {
                        Log::info('District found:', [
                            'id' => $district->id,
                            'name' => $district->name
                        ]);
                    } else {
                        Log::warning('District not found:', [
                            'search_term' => $cleanDistrictName
                        ]);
                    }

                    if (!$district) {
                        $availableDistricts = District::select('name')->limit(10)->get()->pluck('name')->toArray();
                        Log::error('District lookup failed', [
                            'searched' => $districtName,
                            'available_sample' => $availableDistricts
                        ]);
                        throw new \Exception("District '{$districtName}' was not found in the system. Available districts include: " . implode(', ', array_slice($availableDistricts, 0, 5)));
                    }
                    $districtId = $district->id;
                } else {
                    Log::error('District is empty');
                    throw new \Exception("The 'District' column is mandatory and cannot be empty.");
                }

                // 2. Office Type Mapping
                $officeTypeText = trim($rowData['office_type'] ?? '');
                Log::info('Office type processing:', [
                    'raw_value' => $officeTypeText,
                    'column_exists' => isset($rowData['office_type'])
                ]);

                $officeTypeCode = null;
                if (!empty($officeTypeText) && $this->officeTypes->isNotEmpty()) {
                    $officeTypeCode = $this->officeTypes->first(function ($item) use ($officeTypeText) {
                        $match = strtolower(trim($item['code_name'])) === strtolower($officeTypeText);
                        Log::info("Comparing office type", [
                            'input' => strtolower($officeTypeText),
                            'db_value' => strtolower(trim($item['code_name'])),
                            'match' => $match
                        ]);
                        return $match;
                    })['code_id'] ?? null;

                    Log::info('Office type mapping result:', [
                        'input' => $officeTypeText,
                        'found_code' => $officeTypeCode
                    ]);
                }

                // 3. Company Information Mapping
                $companyInfoText = trim($rowData['company_information'] ?? '');
                Log::info('Company information processing:', [
                    'raw_value' => $companyInfoText,
                    'column_exists' => isset($rowData['company_information'])
                ]);

                $companyInfoCode = null;
                if (!empty($companyInfoText) && $this->companyInfos->isNotEmpty()) {
                    $companyInfoCode = $this->companyInfos->first(function ($item) use ($companyInfoText) {
                        $match = strtolower(trim($item['code_name'])) === strtolower($companyInfoText);
                        Log::info("Comparing company info", [
                            'input' => strtolower($companyInfoText),
                            'db_value' => strtolower(trim($item['code_name'])),
                            'match' => $match
                        ]);
                        return $match;
                    })['code_id'] ?? null;

                    Log::info('Company info mapping result:', [
                        'input' => $companyInfoText,
                        'found_code' => $companyInfoCode
                    ]);
                }

                // 4. Address Validation
                $address = $rowData['address'] ?? null;
                Log::info('Address processing:', [
                    'raw_value' => $address,
                    'column_exists' => isset($rowData['address']),
                    'is_empty' => empty($address)
                ]);

                if (empty($address)) {
                    Log::error('Address is empty');
                    throw new \Exception("The 'Address' column is mandatory and cannot be empty.");
                }

                // 5. Prepare company data for creation
                $companyData = [
                    'name' => trim($companyName),
                    'business_registration_number' => $rowData['business_registration_number'] ?? null,
                    'email' => $rowData['email'] ?? null,
                    'office_type' => $officeTypeCode,
                    'company_information' => $companyInfoCode,
                    'district_id' => $districtId,
                    'address' => trim($address),
                    'slug' => Str::slug($companyName . '-' . uniqid()),
                    'active' => true,
                    'verified_by' => auth('admin')->id(),
                    'verified_at' => now(),
                ];

                Log::info('Creating company with data:', $companyData);

                Company::create($companyData);

                DB::commit();
                $this->imported++;

                Log::info("✓ Successfully imported row {$rowIndex} (Excel row " . ($rowIndex + 2) . "): {$companyName}");

            } catch (\Exception $e) {
                DB::rollBack();

                Log::error("✗ Failed to import row {$rowIndex} (Excel row " . ($rowIndex + 2) . ")", [
                    'company_name' => $companyName ?? 'N/A',
                    'error_message' => $e->getMessage(),
                    'error_class' => get_class($e),
                    'error_file' => $e->getFile(),
                    'error_line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ]);

                $this->failed[] = [
                    'row' => $rowIndex + 2,
                    'error' => $e->getMessage()
                ];
            }
        }

        Log::info('=== PROCESSING COMPLETE ===');
        Log::info('Import summary:', [
            'total_rows_processed' => $rows->count(),
            'successfully_imported' => $this->imported,
            'failed' => count($this->failed),
            'failures' => $this->failed
        ]);
        Log::info('=== END OF IMPORT ===');
    }

    public function getImportedCount(): int
    {
        return $this->imported;
    }

    public function getFailedCount(): int
    {
        return count($this->failed);
    }

    public function getFailures(): array
    {
        return $this->failed;
    }
}
