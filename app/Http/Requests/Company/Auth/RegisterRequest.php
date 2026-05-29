<?php

namespace App\Http\Requests\Company\Auth;

use App\Models\Company;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'password' => 'required',
            'repassword' => 'required|same:password',
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'email' => 'required|unique:company_recruiters,email|min:2|max:100',
            'telephone' => ['required','unique:company_recruiters,telephone'],
            'verification_type' => 'required',
            'agree_terms' => 'accepted',
            'company' => [
                'required'
            ],
            'company_id' => [
                'required',
                'exists:companies,id',
//                function ($attribute, $value, $fail) {
//                    $company = Company::where('id', $value)->first();
//                    if ($company) {
//                        if (is_null($company->verified_at) || is_null($company->verified_at) ) {
//                            $fail('The selected company must be verified by Admin.');
//                        }
//                    }
//                },
            ]
        ];
    }

    /**
     * Get the error messages that return from the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages()
    {
        return [
            'password.required' => 'Password is required!',
            'password.regex' => 'Password must contains at least 1 special character and 1 number',
            'password.min' => 'Password must contains at least 8 characters!',
            'password.max' => 'Password cannot be longer than 32 characters',
            'repassword.required' => 'Please confirm the password!',
            'repassword.same' => 'Password does not match!',
            'first_name.required' => 'First name is required!',
            'last_name.required' => 'Last name is required!',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email existed!',
            'telephone.required' => 'Telephone is required!',
            'telephone.regex' => 'Telephone is invalid!',
            'telephone.unique' => 'Telephone existed!',
            'verification_type.required' => 'Please select a verification type',
            'agree_terms.accepted' => 'Please agree with our terms to continue using system!',
            'company.exists' => 'The company is not exist in system!'
        ];
    }
}
