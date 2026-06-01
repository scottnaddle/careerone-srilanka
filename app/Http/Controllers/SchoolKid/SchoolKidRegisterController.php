<?php

namespace App\Http\Controllers\SchoolKid;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\SchoolKid\Auth\RegisterRequest;
use App\Models\AdminUser;
use App\Models\CgoUser;
use App\Models\District;
use App\Models\SchoolKid;
use Illuminate\Http\Request;

class SchoolKidRegisterController extends Controller
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

        $recommendedAdmin = AdminUser::where('active', true)
            ->get()
            ->map(function ($admin) {
                $admin->system = 'admin';
                $admin->uid = 'admin_' . $admin->id;
                return $admin;
            });

        $recommendedList = $recommendedCgo->concat($recommendedAdmin);
        $districts = District::orderBy('name', 'asc')->get();
        return view('schoolkid.auth.signup', compact('recommendedList', 'districts'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $verificationMethod = $request->verification_type;
        $data = $request->except(['_token', 'verification_type', 'accept_terms']);
        $password = bcrypt($request->password);

        $userData = $this->buildManualUserData($data, $password);

        $user = SchoolKid::create($userData);


        // Send verification
        $token = base64_encode($request->email);
        $this->sendVerification($user, $token, $verificationMethod);

        return redirect()->route('verification.verify', [
            'u_type' => 'schoolkid',
            'token' => $token,
            'verification_method' => $verificationMethod
        ])->with('message', 'Sent');
    }

    private function buildManualUserData($data, $password)
    {
        $recommendedBy = $data['recommended_by'] ?? null;
        $system = null;
        $userId = null;
        if ($recommendedBy && str_contains($recommendedBy, '-')) {
            [$system, $userId] = explode('-', $recommendedBy);
        }
        return [
            'username' => $data['email'],
            'email' => $data['email'],
            'password' => $password,
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'contact_address' => $data['contact_address'],
            'gender' => $data['gender'],
            'mobile' => $data['mobile'],
            'district_id' => $data['district_id'],
            'recommended_by_user_id' => $userId,
            'recommended_by_user_system' => $system,
        ];
    }

    private function sendVerification($user, $token, $method)
    {
        match ($method) {
            Constant::email => $user->sendEmailVerify($token),
            Constant::sms => $user->sendSMSVerify($token),
            default => null
        };
    }
}
