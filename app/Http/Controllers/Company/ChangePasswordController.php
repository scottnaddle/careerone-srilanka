<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('company.auth');
    }

    public function showForm()
    {
        return view('company.my-page.change-password');
    }

    public function update(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => [
                'required',
                'string',
                'min:8',
                'max:16',
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
                'regex:/[!@#$%^&*(),.?":{}|<>]/',
                'confirmed',
            ],
        ]);

        $user = Auth::guard('company')->user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => __('auth.password_incorrect')]);
        }

        $user->password = bcrypt($request->new_password);
        $user->save();

        return back()->with('message', __('auth.password_changed'));
    }
}
