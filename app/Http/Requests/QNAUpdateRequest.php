<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class QNAUpdateRequest extends FormRequest
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
//            'title' => 'required|max:255|unique:q_n_a_s,title,' . $this->qNA->id,
            'title' => 'required|max:255',
            'description' => 'required|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.max' => 'Title cannot be longer than 255 characters',
            'title.unique' => 'Title is existed!',
            'description.required' => 'Description is required!',
            'description.max' => 'Description cannot be longer than 1000 characters'
        ];
    }
}
