<?php

namespace App\Http\Requests\CGO;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCounselingRequest extends FormRequest
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
            'title' => 'required|string|max:50',
            'description' => 'required|string',
            'status' => 'required|string',
            'counseling_field_id' => 'required|integer',
        ];
    }
}
