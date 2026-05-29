<?php

namespace App\Http\Requests\CGO\Auth;

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
            'nic' => ['string', 'nullable', 'regex:/^(?:\d{9}[VXvx]|\d{12})$/', 'unique:cgo_users,nic'],
            'password' => 'required',
            'repassword' => 'required|same:password',
            'first_name' => 'required|min:2|max:100',
            'last_name' => 'required|min:2|max:100',
            'email' => 'required|unique:cgo_users,email|min:2|max:100',
            'telephone' => ['required','unique:cgo_users,telephone'],
            'district_id' => 'required',
            'institute_id' => 'required',
            'verification_type' => 'required',
            'agree_terms' => 'accepted',
            'attached_file' => 'mimes:png,jpg,jpeg,pdf',
        ];
    }
    public function validated($key = null, $default = null)
    {
        $validated = parent::validated($key, $default);

        if (session()->has('temp_file')) {
            $validated['attached_file'] = session('temp_file');
            session()->forget('temp_file');
        }

        return $validated;
    }

    /**
     * Get the error messages that return from the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function messages()
    {
        return [
//            'nic.required' => 'Public official ID number is required!',
//            'nic.unique' => 'Public official ID number existed!',
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
            'institute_id.required' => 'Institute is required!',
            'district_id.required' => 'District is required!',
            'verification_type.required' => 'Please select a verification type',
            'agree_terms.accepted' => 'Please agree with our terms to continue using system!',
            'attached_file.required' => 'Attached file is required!',
            'attached_file.mimes' => 'Attached file only allows image or pdf file',
        ];
    }
}
