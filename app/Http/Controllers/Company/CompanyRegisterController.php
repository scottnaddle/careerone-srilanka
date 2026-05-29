<?php

namespace App\Http\Controllers\Company;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\Company\Auth\RegisterRequest;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\Company;
use App\Models\CompanyRecruiter;
use App\Models\TemporatyFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CompanyRegisterController extends Controller
{
    public function register()
    {
        $recommendedCgo = CgoUser::where('active', true)
            ->get()
            ->map(function ($cgo) {
                $cgo->system = 'cgo';
                $cgo->uid = 'cgo_' . $cgo->id;
                return $cgo;
            });

//        $recommendedAdmin = AdminUser::where('active', true)
//            ->get()
//            ->map(function ($admin) {
//                $admin->system = 'admin';
//                $admin->uid = 'admin_' . $admin->id;
//                return $admin;
//            });

//        $recommendedList = $recommendedCgo->concat($recommendedAdmin);
        $recommendedList = $recommendedCgo;
        return view('company.auth.signup', compact('recommendedList'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $recommendedBy = $request->recommended_by ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        $company = Company::where('id', $request->company_id)->first();
        $verification_method = $request->verification_type;
        $recruiter = new CompanyRecruiter();
        $recruiter->first_name = $request->first_name;
        $recruiter->last_name = $request->last_name;
        $recruiter->telephone = $request->telephone;
        $recruiter->email = $request->email;
        $recruiter->username = $request->email;
        $recruiter->verify_at = null;
        $recruiter->verify_by = null;
        $recruiter->company_id = $company->id;
        $recruiter->password = bcrypt($request->password);
        $recruiter->active = false;
        $recruiter->recommended_by_user_id = $userId;
        $recruiter->recommended_by_user_system = $system;
        $recruiter->save();
        $token = base64_encode($request->email);
        switch ($verification_method) {
            case Constant::email:
                $recruiter->sendEmailVerify($token);
                break;
            case Constant::sms:
                $recruiter->sendSMSVerify($token);
                break;
        }
        return redirect()->route('verification.verify', ['u_type' => 'company', 'token' => $token, 'verification_method' => $verification_method])->with('message', 'sended');
    }

}
