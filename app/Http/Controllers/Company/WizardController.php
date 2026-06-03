<?php

namespace App\Http\Controllers\Company;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Auth\RegisterRequest;
use App\Http\Requests\Company\RegisterCompanyRequest;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\District;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WizardController extends Controller
{
    /**
     * Show the 3-step wizard signup form.
     */
    public function signup()
    {
        $recommendedCgo = CgoUser::where('active', true)
            ->get()
            ->map(function ($cgo) {
                $cgo->system = 'cgo';
                $cgo->uid = 'cgo_' . $cgo->id;
                return $cgo;
            });

        $districts = District::orderBy('name')->get();

        return view('company.auth.wizard', compact('recommendedCgo', 'districts'));
    }

    /**
     * Handle the wizard submission — creates Company + Recruiter in one transaction.
     */
    public function store(Request $request)
    {
        $request->validate([
            // Company fields
            'company_name' => 'required|string|max:255',
            'company_id' => 'nullable|exists:companies,id',
            'office_type' => 'nullable|string',
            'business_registration_number' => 'nullable|string|max:100',
            'address' => 'required|string|max:500',
            'district_id' => 'required|exists:districts,id',
            'number_workers' => 'nullable|integer|min:0',
            'email' => 'nullable|email|max:150',
            'type_of_organisation' => 'nullable|string|max:100',
            'business_license' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',

            // Recruiter fields
            'first_name' => 'required|string|max:60',
            'last_name' => 'required|string|max:60',
            'recruiter_email' => 'required|email|max:150|unique:company_recruiters,email',
            'password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'confirmed',
            ],
            'telephone' => 'required|string|max:20',
            'verification_type' => 'required|string',
            'agree_terms' => 'required|accepted',
            'recommended_by' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Step 1: Create or find company
            $company = $this->findOrCreateCompany($request);

            // Step 2: Create recruiter
            $recruiter = $this->createRecruiter($request, $company);

            // Step 3: Send verification
            $token = base64_encode($request->recruiter_email);
            $verificationMethod = $request->verification_type;

            match ($verificationMethod) {
                Constant::email => $recruiter->sendEmailVerify($token),
                Constant::sms => $recruiter->sendSMSVerify($token),
                default => null,
            };

            DB::commit();

            return redirect()->route('verification.verify', [
                'u_type' => 'company',
                'token' => $token,
                'verification_method' => $verificationMethod,
            ])->with('message', __('system.messages.verification_sent'));
        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Registration failed. Please try again.');
        }
    }

    /**
     * AJAX search for existing companies.
     */
    public function searchCompanies(Request $request)
    {
        $keyword = $request->get('q', '');
        if (strlen($keyword) < 2) {
            return response()->json([]);
        }

        $companies = Company::with('district')
            ->where('name', 'ILIKE', '%' . $keyword . '%')
            ->whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->where('active', true)
            ->orderBy('name')
            ->limit(8)
            ->get()
            ->map(function ($company) {
                return [
                    'id' => $company->id,
                    'name' => $company->name,
                    'district' => $company->district?->name,
                    'br_number' => $company->business_registration_number,
                ];
            });

        return response()->json($companies);
    }

    /**
     * Find existing company or create a new one.
     */
    private function findOrCreateCompany(Request $request): Company
    {
        // If user selected an existing company
        if ($request->filled('company_id')) {
            $company = Company::findOrFail($request->company_id);

            // Optionally update address/district if different
            if ($request->address && $company->address !== $request->address) {
                $company->address = $request->address;
                $company->save();
            }

            return $company;
        }

        // Register new company
        $company = new Company();
        $company->name = $request->company_name;
        $company->slug = Str::slug($request->company_name);
        $company->office_type = $request->office_type;
        $company->business_registration_number = $request->business_registration_number;
        $company->address = $request->address;
        $company->district_id = $request->district_id;
        $company->number_workers = $request->number_workers ?? 0;
        $company->email = $request->email;
        $company->active = false;

        // Handle business license upload
        if ($request->hasFile('business_license')) {
            $folderName = Str::slug($request->company_name, '-', 'ta');
            $path = $request->file('business_license')->store(
                "company/business_licenses/{$folderName}",
                'public'
            );
            $company->attachment_details = json_encode([
                ['path' => 'storage/' . $path, 'name' => $request->file('business_license')->getClientOriginalName()],
            ]);
        }

        $company->save();
        return $company;
    }

    /**
     * Create recruiter account linked to company.
     */
    private function createRecruiter(Request $request, Company $company): CompanyRecruiter
    {
        $recommendedBy = $request->recommended_by ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }

        $recruiter = new CompanyRecruiter();
        $recruiter->first_name = $request->first_name;
        $recruiter->last_name = $request->last_name;
        $recruiter->telephone = $request->telephone;
        $recruiter->email = $request->recruiter_email;
        $recruiter->username = $request->recruiter_email;
        $recruiter->verify_at = null;
        $recruiter->verify_by = null;
        $recruiter->company_id = $company->id;
        $recruiter->password = bcrypt($request->password);
        $recruiter->active = false;
        $recruiter->recommended_by_user_id = $userId;
        $recruiter->recommended_by_user_system = $system;
        $recruiter->save();

        return $recruiter;
    }
}
