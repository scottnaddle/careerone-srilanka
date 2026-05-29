<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Models\AdminUser;
use App\Models\District;
use App\Models\Institute;
use App\Models\TvetHeadquater;
use App\Models\TvetType;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\VerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function register()
    {
        // $tvet_headquaters = TvetHeadquater::all();
        $tvet_types = TvetType::all();
        $districts = District::all();
        $institutes = Institute::orderBy('name', 'asc')->get();
        return view('admin.auth.signup', compact( 'institutes', 'districts', 'tvet_types'));
    }
    /**
     * Store a new user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        if (property_exists($this->checkNIC($request)->getData(), 'error')) return back()->withInput()->withErrors(['nic_check_fail' => 'NIC check fail!']);
        $request->validate([
            'nic' => 'string|max:250|unique:admin_users|nullable',
            'firstname' => 'required|string|max:100',
            'lastname' => 'required|string|max:100',
            'email' => 'required|email|max:250|unique:admin_users',
            'password' => 'required|confirmed',
            'phone' => 'required|unique:admin_users,phone',
            'accept_term' => 'required',
            'verification_type' => 'required',
        ]);
        $verification_type = $request->verification_type;
        $admin_user = new AdminUser();
        $admin_user->nic = $request->nic;
        $admin_user->first_name = $request->firstname;
        $admin_user->last_name = $request->lastname;
        $admin_user->username = $request->email;
        $admin_user->email = $request->email;
        $admin_user->password = bcrypt($request->password);
        $admin_user->phone = $request->phone;
        $admin_user->role = 'admin';
        // $admin_user->tvet_headquater_id = $request->tvet_headquater;
        $admin_user->tvet_type = $request->tvet_type;
        $admin_user->active = false;
        // $admin_user->district_id = $request->district;
        // $admin_user->institute_id = $request->institute;
        $admin_user->save();
        $admin_user->assignRole('admin');
        $token = base64_encode($request->email);
        switch ($verification_type) {
            case Constant::email:
                $admin_user->sendEmailVerify($token);
                break;
            case Constant::sms:
                $admin_user->sendSMSVerify($token);
                break;
        }
        return redirect()->route('verification.verify', ['u_type' => 'admin', 'token' => $token, 'verification_method' => $verification_type])->with('message', 'Sent');

    }

    //    protected function sendEmailVerificationNotification(Model $user): void
    //    {
    //        if (! $user instanceof MustVerifyEmail) {
    //            return;
    //        }
    //
    //        if ($user->hasVerifiedEmail()) {
    //            return;
    //        }
    //
    //        if (! method_exists($user, 'notify')) {
    //            $userClass = $user::class;
    //
    //            throw new Exception("Model [{$userClass}] does not have a [notify()] method.");
    //        }
    //
    //        $notification = new VerifyEmail();
    //        $notification->url = Filament::getVerifyEmailUrl($user);
    //
    //        $user->notify($notification);
    //    }

    public function checkNIC(Request $request)
    {
        return response()->json([
            'success' => 'NIC confirmed!',
        ]);
    }


    ///Logout
    public function logout(Request $request)
    {
        \Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/auth/login');
    }
}
