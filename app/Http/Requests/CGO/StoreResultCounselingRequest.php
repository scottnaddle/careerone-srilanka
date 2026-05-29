<?php

namespace App\Http\Requests\CGO;

use Illuminate\Foundation\Http\FormRequest;

class StoreResultCounselingRequest extends FormRequest
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
        //TODO: Implement authorize() method
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'result' => 'required|string|max:1000',
        ];
    }

    public function messages()
    {
        return [
            'result.required' => 'Result is required!',
            'result.string' => 'Result must be a string!',
            'result.max' => 'Result cannot be longer than 1000 characters!',
        ];
    }
}
