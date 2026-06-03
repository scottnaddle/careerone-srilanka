<?php

namespace App\Http\Requests\Trainee\Auth;

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
            'nic' => ['string', 'regex:/^(?:\d{9}[VXvx]|\d{12})$/', 'unique:trainee_users,nic'],
            'password' => 'required',
            'repassword' => 'required|same:password',
//            'full_name' => 'required|min:2|max:100',
//            'first_name' => 'required|min:2|max:20',
//            'last_name' => 'required|min:2|max:20',
            'email' => ['required', 'unique:trainee_users,email', 'min:2', 'max:100'],
//            'telephone' => 'required|regex:/^\+94\d{9}$/|unique:trainee_users,telephone',
            'mobile' => ['required','unique:trainee_users,mobile'],
//            'district_id' => 'required',
//            'institute_id' => 'required',
//            'nvq_id' => 'required',
//            'occupation_id' => 'required',
            'verification_type' => 'required',
            'agree_terms' => 'accepted',
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
            'nic.required' => trans('validation.nic_required'),
            'nic.unique' => trans('validation.nic_unique'),
            'password.required' => 'Password is required!',
            'password.regex' => 'Password must contains text, at least 1 special character and 1 number, min 8 characters',
            'password.min' => 'Password must contains at least 8 characters!',
            'password.max' => 'Password cannot be longer than 32 characters',
            'repassword.required' => 'Please confirm the password!',
            'repassword.same' => 'Password does not match!',
            'full_name.required' => 'Full name is required!',
//            'first_name.required' => 'First name is required!',
//            'last_name.required' => 'Last name is required!',
            'email.required' => 'Email is required!',
            'email.unique' => 'Email existed!',
            'mobile.required' => 'Telephone is required!',
            'mobile.regex' => 'Telephone is invalid!',
            'mobile.unique' => 'Telephone existed!',
            'verification_type.required' => 'Please select a verification type',
            'agree_terms.accepted' => 'Please agree with our terms to continue using system!',
        ];
    }
}
