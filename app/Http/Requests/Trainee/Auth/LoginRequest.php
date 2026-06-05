<?php

namespace App\Http\Requests\Trainee\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
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
            'email' => 'required|email|exists:trainee_users,email',
            'password' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'email.exists' => 'Email is not registered',
            'email.email' => 'Your email is invalid!',
            'password.required' => 'Password is required!',
            'password.min' => 'Password must contains at least 8 characters!',
            'password.max' => 'Password cannot be longer than 32 characters',
        ];
    }
}
