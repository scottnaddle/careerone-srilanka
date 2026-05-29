<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Http\Requests\Company\RegisterCompanyRequest;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\DeviceToken;
use App\Models\District;
use App\Models\DivisionalSecretariats;
use App\Models\Job;
use App\Models\KeepTrainee;
use App\Models\OJT;
use App\Models\QNA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class MyPageController extends Controller
{
    public function __construct()
    {
        $this->middleware('company.auth');
    }

    public function index(Request $request) {
        $user = Auth::guard(activeGuard())->user();
        $company = Company::where('id', $user->company_id)->first();
        $qnas = QNA::latest()->take(5)->get();
        $events = $company->events()->take(5)->get();
        $jobs = Job::where('company_id', $company->id)->latest()->take(5)->get();
        $keepTrainees = KeepTrainee::where('system', 'company')->where('keeper_id', Auth::guard('company')->user()->id)->latest()->take(5)->get();
        $allJobApplicants = $company->traineeApplied->where('apply_type', 'apply');
        $allJobMatchs = $company->traineeApplied->where('apply_type', 'job_match');
        $jobApplicantNotReads = $allJobApplicants->whereNull('read');
        $jobMatchNotReads = $allJobMatchs->whereNull('read');
        $ojts = OJT::where('company_id', $company->id)->latest()->take(5)->withCount('ojtMatches')->get();
        return view('company.my-page.my-page', compact('user', 'qnas', 'events', 'jobs', 'keepTrainees', 'ojts','company', 'allJobApplicants', 'jobApplicantNotReads', 'allJobMatchs', 'jobMatchNotReads'));
    }

    public function getPersonalInformation() {
        $user = Auth::guard(activeGuard())->user();
        return view('company.my-page.personal-information', compact('user'));
    }

    public function getCompanyInformation($id) {
        $company = Company::where('id', $id)->first();
        $districts = District::all();
        $ds_divisions = DivisionalSecretariats::where('dist_id', $company->district_id)->get();
        $headquarters = Company::where('office_type', 1)->get();
        return view('company.my-page.company-information', compact('company', 'districts', 'ds_divisions', 'headquarters'));
    }

    public function postCompanyInformation(RegisterCompanyRequest $request)
    {
        $company = Company::find($request->id);
    
        if (!$company) {
            return back()->withErrors(['notfound' => 'Cannot find the company']);
        }
    
        $company->fill([
            'name'                         => $request->name,
            'office_type'                 => $request->office_type,
            'date_of_establishment'      => $request->date_of_establishment,
            'business_registration_number' => $request->business_registration_number,
            'name_of_representation'     => $request->name_of_representative,
            'number_workers'             => $request->number_workers,
            'hotline'                     => $request->hotline,
            'email'                       => $request->email,
            'co_business'                => $request->co_business,
            'sns_channel'                => $request->sns_channel,
            'website'                    => $request->website,
            'services'                   => $request->services,
            'short_bio'                  => $request->short_bio,
            'district_id'                => $request->district,
            'ds_id'                      => $request->ds_id,
            'company_information'        => $request->company_information,
            'address'                    => $request->address,
            'headquarter_id'             => $request->office_type == 2 ? $request->headquarter_id : null,
        ]);
    
        $companyFolderName = Str::slug($company->name);
    
        // 📎 Business License Handling
        if ($request->hasFile('attached_file')) {
            $storedFiles = [];
            $folder = "company/business_licenses/{$companyFolderName}";
            $storagePath = storage_path("app/public/{$folder}");
    
            if (!file_exists($storagePath)) {
                mkdir($storagePath, 0755, true);
            }
    
            foreach ($request->file('attached_file') as $index => $file) {
                $fileName = $file->getClientOriginalName();
                $file->move($storagePath, $fileName);
    
                $storedFiles[] = [
                    'path' => "storage/{$folder}/{$fileName}",
                    'name' => $fileName,
                ];
            }
    
            $existingAttachments = json_decode($company->attachment_details, true) ?? [];
            $company->attachment_details = json_encode(array_merge($existingAttachments, $storedFiles));
        }
    
        // 🖼️ Logo Handling (convert to WebP)
        if ($request->hasFile('avatar')) {
            $folder = "company/logos/{$companyFolderName}";
            $company->logo = env('APP_URL') . '/' . saveImageAsWebp($request->file('avatar'), $folder);
        }
    
        $company->save();
    
        return redirect()
            ->route('company.my-page.company-information', ['id' => $company->id])
            ->with('success', __('system.form.saved'));
    }
    

    public function removeAttachment(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'path' => 'required|max:255',
            'id' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $company = Company::where('id', $request->id)->first();
        if ($company) {
            $attachment_details = json_decode($company->attachment_details);
            $new_attachment_details = [];
            foreach ($attachment_details as $key => $attachment_detail) {
                if ($attachment_detail->path != $request->path){
                    $new_attachment_details[$key]['path'] = $attachment_detail->path;
                    $new_attachment_details[$key]['name'] = $attachment_detail->name;
                }
            }
            $company->attachment_details = json_encode($new_attachment_details);
            $company->save();
            //remove in folder
            $path = $request->path;
            if (file_exists($path)) {
                @unlink($path);
            }
            return 'success';
        }


    }

    public function postPersonalInformation(Request $request) {
        // validate incoming request
        $validator = \Validator::make($request->all(), [
            'first_name' => 'required|max:20',
            'last_name' => 'required|max:20',
            'email' => 'required|max:100|email',
            'telephone' => 'required',
            'avatar' => 'image|max:1024'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }
        $user = CompanyRecruiter::where('id', Auth::guard('company')->user()->id)->first();
        if (!$user) {
            return back()->withErrors(['notfound' => 'Can not find the user']);
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->telephone = $request->telephone;
        if ($user->email != $request->email) {
            $user->email_verified_at = null;
            $user->email = $request->email;
            $user->save();
            // Send verification email to new address
            $token = base64_encode($user->email);
            $user->sendEmailVerify($token);
            return redirect()->route('verification.isnotverified', ['u_type' => 'company', 'token' => $token])
                ->with('message', __('auth.email_changed_verify'));
        }
        if ($request->file('avatar')) {
            $storage_path = storage_path('app/public/'.activeGuard().'/avatar/'.$user->id.'/');
            if (!Storage::exists($storage_path)) {
                Storage::makeDirectory($storage_path);
            }
            $fullName = $request->file('avatar')->getClientOriginalName();
            $request->file('avatar')->move($storage_path, $fullName);
            $user->profile_image = 'storage/'.activeGuard().'/avatar/'.$user->id.'/'.$fullName;
        }
        $user->save();
        return redirect()->route('company.my-page.personal-information')->with('success', __('system.form.saved'));
    }

    public function deActiveAccount()
    {
        $user = CompanyRecruiter::where('id', Auth::guard('company')->user()->id)->first();
        if ($user) {

            $user->active = false;
            $user->save();

            if (isset(Auth::guard('company')->user()->id)) {
                DeviceToken::where('user_id', Auth::guard('company')->user()->id)
                    ->where('system', 'company')
                    ->delete();
            }
            Auth::guard('company')->logout();
            //Logout from CAS
            session()->invalidate();
            session()->regenerateToken();

            return redirect()->route('homepage');
        }
        return redirect()->back();
    }

    public function getDivision(Request $request)
    {
        $dsDivisions = DivisionalSecretariats::where('dist_id', $request->district_id)->get();
        return response()->json($dsDivisions);
    }
}
