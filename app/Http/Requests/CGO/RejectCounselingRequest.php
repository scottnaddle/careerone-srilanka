<?php

namespace App\Http\Requests\CGO;

use Illuminate\Foundation\Http\FormRequest;

class RejectCounselingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if (auth()->guard('cgo')->check()) {
            return true;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cancel_reason' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'cancel_reason.required' => 'Cancel reason is required!',
            'cancel_reason.string' => 'Cancel reason must be a string!',
            'cancel_reason.max' => 'Cancel reason cannot be longer than 1000 characters!',
        ];
    }
}
