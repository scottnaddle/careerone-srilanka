<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
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
            'title' => 'required|max:255',
            'event_type' => 'required',
            'details' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after_or_equal:start_time',
            // 'thumbnail' => 'mimes:jpg,jpeg,png,bmp,tiff',
           'thumbnail' => 'required|mimes:jpg,jpeg,png,bmp,tiff',
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.max' => 'Title cannot be longer than 255 characters',
            'details.required' => 'Details is required!',
            'start_time.required' => 'Start time is required!',
            'end_time.required' => 'End time is required!',
            'event_type.required' => 'Event type is required!',
            'end_time.after_or_equal' => 'The end time must be a date after or equal to start time!',
            'thumbnail.required' => 'Thumbnail is required!',
            'thumbnail.mimes' => 'Thumbnail is only accept image!'
        ];
    }
}
