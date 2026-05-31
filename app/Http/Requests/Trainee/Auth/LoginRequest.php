<?php

namespace App\Http\Requests\Trainee\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required', 'string', function ($attribute, $value, $fail) {
                if (filter_var($value, FILTER_VALIDATE_EMAIL)) {
                    if (!\App\Models\TraineeUser::where('email', $value)->exists()) {
                        $fail('Email is not registered');
                    }
                } else {
                    if (!\App\Models\TraineeUser::where('nic', $value)->exists()) {
                        $fail('NIC is not registered');
                    }
                }
            }],
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email or NIC is required!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must contains at least 8 characters!',
            'password.max' => 'Password cannot be longer than 32 characters',
        ];
    }
}
