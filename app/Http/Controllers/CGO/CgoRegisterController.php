<?php

namespace App\Http\Controllers\CGO;

use App\Constant\Constant;
use App\Http\Controllers\Controller;
use App\Http\Requests\CGO\Auth\RegisterRequest;
use App\Models\CgoUser;
use App\Models\District;
use App\Models\Institute;
use App\Models\TemporatyFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CgoRegisterController extends Controller
{
    public function register()
    {
        $institutes = Institute::where('active_status', 'ILIKE', 'Active')->get();
        $districts = District::get();
        return view('cgo.auth.signup', compact('institutes', 'districts'));
    }

    public function postRegister(RegisterRequest $request)
    {
        $request->merge(['password' => bcrypt($request->password)]);
        $verification_method = $request->verification_type;
        $data = $request->except(['_token', 'verification_type', 'accept_terms']);
        $data['verify_at'] = null;
        $data['verify_by'] = null;
        $data['attached_file'] = '';
        $user = CgoUser::create($data);
        if ($request->has('attached_file')) {
            $attached_file = $request->file('attached_file');
            $storage_path = storage_path('app/public/' . activeGuard() . '/' . 'attached_file/' . $user->id);
            $filename = pathinfo($attached_file->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $attached_file->getClientOriginalExtension();
            $fileNameToStore = $filename . '.' . $extension;
            $attached_file->move($storage_path, $fileNameToStore);
            $path = 'storage/' . activeGuard() . '/' . 'attached_file/' . $user->id . '/' . $fileNameToStore;
            $user->update([
                'attached_file' => $path
            ]);
        }


        $token = base64_encode($request->email);
        switch ($verification_method) {
            case Constant::email:
                $user->sendEmailVerify($token);
                break;
            case Constant::sms:
                $user->sendSMSVerify($token);
                break;
        }
        return redirect()->route('verification.verify', ['u_type' => 'cgo', 'token' => $token, 'verification_method' => $verification_method])->with('message', 'Verification code has been sent');
        // return redirect()->route('cgo.auth.login');
    }
}
