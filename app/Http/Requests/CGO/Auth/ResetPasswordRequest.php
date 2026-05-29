<?php

namespace App\Http\Requests\CGO\Auth;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email|exists:cgo_users',
            'password' => 'required',
        ];
    }

    public function messages() {
        return [
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',
            'email.exists' => 'Email is not exist!',
            'password.required' => 'Password is required!',
            'password.string' => 'Password is invalid!',
            'password.min' => 'Password must contains at least 8 characters!',
            'password.max' => 'Password cannot be longer than 32 characters',
            'password.regex' => 'Password must contains at least 1 special character and 1 number',
        ];
    }
}
