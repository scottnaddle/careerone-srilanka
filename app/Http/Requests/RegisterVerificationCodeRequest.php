<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterVerificationCodeRequest extends FormRequest
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
            'code' => 'required|min:6|max:6|exists:verification_codes,code',
            'u_type' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'code.required' => 'Code is required!',
            'code.exists' => 'The code is invalid!',
            'code.min' => 'Code should be at least 6 characters',
            'code.max' => 'Code is max 6 characters!'
        ];
    }
}
