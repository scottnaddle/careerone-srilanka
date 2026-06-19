<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\RegisterCompanyRequest;
use App\Imports\CompaniesImport;
use App\Models\CoBusiness;
use App\Models\Company;
use App\Models\District;
use App\Models\Enterprise;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class RegisterNewCompany extends Controller
{
    public function getRegisterForm() {
        $districts = District::all();
//        $co_businesses = CoBusiness::all();
//        $enterprises = Enterprise::all();
        $headquarters = Company::where('office_type', 1)->get(); // Only headquarter
        return view('company.register.register', compact('districts', 'headquarters'));
    }
    public function getHeadQuarter(Request $request) {
        $company_information = $request->company_information ?? '';
        if ($company_information) {
            $headQuarters = Company::where('office_type', 1)->where('company_information', $company_information)->get();
        }else {
            $headQuarters = Company::where('office_type', 1)->get();
        }
        return [
            'status' => true,
            'data' => $headQuarters
        ];
    }
    public function getSearch($keyword) {
        $companies = Company::with('district')->where('name', 'ILIKE', '%'.$keyword.'%')
            ->where(function ($query) {
                $query
                    // Group 1: Approved
                    ->where(function ($q) {
                        $q->whereNotNull('verified_by')
                            ->whereNotNull('verified_at')
                            ->where('active', true);
                    })
                    // Group 2: Pending approval
                    ->orWhere(function ($q) {
                        $q->whereNull('verified_by')
                            ->whereNull('verified_at')
                            ->where('active', false);
                    });
            })
            ->get();
        $msg = '';
        if ($companies == ''){
            $msg = 'Not found';
        }
        return [
            'status' => true,
            'data' => $companies,
            'message' => $msg
        ];
    }
    public function postRegister(RegisterCompanyRequest $request)
    {
//        dd($request->all());
        // Determine the company name based on the enterprise type
        $companyName = $request->company_information == 1 ? $request->ministry_name : $request->name;

        // Determine the business registration number based on the enterprise type
        $businessRegistrationNumber = $request->company_information == 1 ? null :
            (in_array($request->company_information, [2, 3, 6]) ?
                $request->business_registration_number_1 : $request->business_registration_number);

        $checkDuplicate = $this->checkCompanyInformation($companyName, $businessRegistrationNumber);
        if ($checkDuplicate['exists'] == true && $checkDuplicate['company'] != null) {
            $company = $checkDuplicate['company'];
            return view('company.register.duplicate', compact('company'));
        }

        $company = new Company();

        // Handle the company name for each type
        if ($request->company_information == 1) {
            // Ministry/Organization
            $company->co_business = $request->organisation_name;
        } else {
            // Other types
            $company->co_business = $request->co_business;
        }


        $company->name = $companyName;
        $company->slug = \Str::slug($companyName, '-', 'ta');
        $company->office_type = $request->office_type;
        $company->date_of_establishment = $request->date_of_establishment;
        $company->business_registration_number = $businessRegistrationNumber;
        $company->name_of_representation = $request->name_of_representative;
        $company->number_workers = $request->number_workers ?? 0;
        $company->enterprise_id = $request->type_of_enterprise;
        $company->company_information = $request->company_information;
        $company->email = $request->email;
        $company->headquarter_id = $request->headquarter_id;
        $company->website = $request->website;
        $company->district_id = $request->district;
        $company->address = $request->address;
        $company->active = false;

        // Store business license
        $companyFolderName = Str::slug($companyName, '-', 'ta');
        if ($request->file('attached_file')) {
            $attachedFiles = $request->file('attached_file');
            $storedFiles = [];
            $storage_path = storage_path('app/public/company/business_licenses/'.$companyFolderName.'/');

            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }

            foreach ($attachedFiles as $key => $file) {
                $fullName = $file->getClientOriginalName();
                $file->move($storage_path, $fullName);
                $storedFiles[$key+1]['path'] = 'storage/company/business_licenses/'.$companyFolderName.'/'.$fullName;
                $storedFiles[$key+1]['name'] = $fullName;
            }
            $company->attachment_details = json_encode($storedFiles);
        }

        // Store Logo
        if ($request->file('logo')) {
            $storage_path = storage_path('app/public/company/logos/'.$companyFolderName.'/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $file = $request->logo;
            $fullName = $file->getClientOriginalName();
            $file->move($storage_path, $fullName);
            $company->logo = 'storage/company/logos/'.$companyFolderName.'/'.$fullName;
        }

        if ($company->save()) {
//            return redirect('choose-login')->with('success', 'Register Company successful, Please wait confirmation from Admin!');
            return redirect()->route('company.auth.register')->withInput(['company_id' => $company->id, 'company' => $company->name]);
//            return redirect()->route('company.auth.register')->with('success', 'Register Company successful, Please wait confirmation from Admin!');
        }

        return back()->with('error', 'Failed to register company. Please try again.');
    }

    /*
     * Ensure Company is not duplicate*/
    public function checkCompanyInformation($company_name, $business_registration_number) {
        $normalizedNumber = strtolower(str_replace(' ', '', $business_registration_number));

        $company = Company::whereRaw("LOWER(REPLACE(business_registration_number, ' ', '')) = ?", [$normalizedNumber])
            ->whereNotNull('verified_by')
            ->whereNotNull('verified_at')
            ->first();

        return [
            'exists' => $company !== null,
            'company' => $company
        ];
    }

    public function importCompanies(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls',
        ]);

        Excel::import(new CompaniesImport, $request->file('file'));

        return response()->json(['message' => 'Companies imported successfully']);
    }
}
