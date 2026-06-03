<?php

namespace App\Http\Requests\SchoolKid\Auth;

use App\Models\SchoolKid;
use Illuminate\Foundation\Http\FormRequest;
class MailConfirmRequest extends FormRequest
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
            'email' => [
                'required',
                'email',
                function ($attribute, $value, $fail) {
                    $user = SchoolKid::where('email', $value)->first();
                    if (!$user) {
                        $fail('You are not a member!');
                    } elseif (!$user->isFullyVerified()) {
                        $fail('You are not fully verified!');
                    }
                },
            ],
        ];
    }

    public function messages() {
        return [
            'email.required' => trans('general.Email is required'),
            'email.email' => trans('general.Email is invalid'),
//            'email.exists' => 'You are not a member!',
        ];
    }
}
