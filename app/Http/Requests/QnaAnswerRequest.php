<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QnaAnswerRequest extends FormRequest
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
            'answer' => 'required|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'answer.required' => 'The message cannot be empty',
            'answer.max' => 'Message cannot be longer than 1000 characters'
        ];
    }
}
