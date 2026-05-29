<?php

namespace App\Http\Requests\Trainee\Auth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nic' => ['nullable', 'string', 'regex:/^(?:\d{9}[VXvx]|\d{12})$/', 'unique:trainee_users,nic'],
            'password' => ['required', 'string', 'min:8', 'max:16', 'regex:/[A-Z]/', 'regex:/[0-9]/', 'regex:/[!@#$%^&*(),.?":{}|<>]/'],
            'repassword' => 'required|same:password',
            'full_name' => 'nullable|min:2|max:100',
            'first_name' => 'nullable|min:2|max:20',
            'last_name' => 'nullable|min:2|max:20',
            'email' => ['required', 'email', 'unique:trainee_users,email', 'min:2', 'max:100'],
            'mobile' => ['nullable', 'unique:trainee_users,mobile'],
            'verification_type' => 'nullable|string',
            'agree_terms' => 'accepted',
        ];
    }

    public function messages()
    {
        return [
            'nic.unique' => trans('validation.nic_unique'),
            'password.required' => 'Password is required!',
            'password.min' => 'Password must be at least 8 characters.',
            'password.max' => 'Password cannot be longer than 16 characters.',
            'password.regex' => 'Password must include 1 uppercase, 1 number, and 1 special character.',
            'repassword.required' => 'Please confirm the password!',
            'repassword.same' => 'Password does not match!',
            'email.required' => 'Email is required!',
            'email.unique' => 'This email is already registered.',
            'email.email' => 'Please enter a valid email address.',
            'mobile.unique' => 'This phone number is already registered.',
            'agree_terms.accepted' => 'Please agree to the terms to continue.',
        ];
    }
}
