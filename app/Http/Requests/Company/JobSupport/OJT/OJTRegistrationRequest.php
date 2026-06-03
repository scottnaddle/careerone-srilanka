<?php

namespace App\Http\Requests\Company\JobSupport\OJT;

use Illuminate\Foundation\Http\FormRequest;

class OJTRegistrationRequest extends FormRequest
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

    protected function timeToMinutes($time)
    {
        list($hours, $minutes) = explode(':', $time);
        return ($hours * 60) + $minutes;
    }
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'min_age' => 'nullable|numeric|min:15|max:99',
            'max_age' => 'nullable|numeric|min:15|max:99|gte:min_age',
            'min_work_experience' => 'nullable',
            'max_work_experience' => 'nullable',
            'required_skills' => 'required',
            'gender' => 'required',
            'application_starttime' => 'nullable|date',
            'application_endtime' => [
                'nullable',
                'date',
                function ($attribute, $value, $fail) {
                    if ($this->application_starttime && $value < $this->application_starttime) {
                        $fail('The application end time must be after or equal to the application start time.');
                    }
                },
            ],
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.max' => 'Title cannot be longer than 255 characters',
            'min_age.required' => 'Min age is required!',
            'min_age.max' => 'Min age cannot be exceed 99!',
            'min_age.min' => 'Min age must be bigger than 15',
            'min_age.numeric' => 'Min age must be a number!',
            'max_age.max' => 'Max age cannot be exceed 99!',
            'max_age.min' => 'Max age must be bigger than 15!',
            'max_age.required' => 'Max age is required!',
            'max_age.gte' => 'Max age must be bigger or equal then min age!',
            'min_age.numeric' => 'Min age must be a number!',
            'working_day.required' => 'Working day is required!',
            'min_work_experience.required' => 'Min work experience is required!',
            'min_work_experience.min' => 'Min work experience must be bigger than 1 characters!',
            'min_work_experience.max' => 'Min work experience cannot be longer than 20 characters',
            'max_work_experience.required' => 'Max work experience is required!',
            'max_work_experience.min' => 'Max work experience must be bigger than 1 characters!',
            'max_work_experience.max' => 'Max work experience cannot be longer than 20 characters',
            'gender.required' => 'Gender is required!',
            'start_time.required' => 'Start time is required!',
            'end_time.required' => 'End time is required!',
            'end_time.date_format' => 'The end time must be in the format HH:MM!',
            'required_skills.required' => 'Required skills is required!',
            'application_starttime.required' => 'Application start time is required!',
            'application_endtime.required' => 'Application end time is required!',
            'application_endtime.after_or_equal' => 'Application end time must be greater the application start time!',
            'min_salary.required' => 'Min salary is required!',
            'min_salary.max' => 'Min salary cannot be exceed 9.999.999!',
            'min_salary.min' => 'Min salary must be bigger than 0!',
            'min_salary.numeric' => 'Min salary age must be a number!',
            'max_salary.required' => 'Max salary is required!',
            'max_salary.max' => 'Max salary cannot be exceed 9.999.999!',
            'max_salary.min' => 'Max salary must be bigger than 0',
            'max_salary.numeric' => 'Max salary age must be a number!',
            'number_of_recruitment.required' => 'Number of recruitments is required!',
            'number_of_recruitment.max' => 'Number of recruitments cannot be exceed 9.999.999!',
            'number_of_recruitment.min' => 'Number of recruitments must be bigger than 0',
            'max_salary.gte' => 'Max salary must be bigger or equal then min salary!',
            'hr_name.required' => 'HR name is required!',
            'hr_name.min' => 'HR name must be bigger than 6 characters!',
            'hr_name.max' => 'HR name cannot be longer than 50 characters',
            'hr_email.required' => 'HR email is required!',
            'hr_email.min' => 'HR email must be bigger than 6 characters!',
            'hr_email.max' => 'HR email cannot be longer than 100 characters',
            'hr_contact_info.required' => 'HR contact information is required!',
            'hr_contact_info.min' => 'HR contact information must be bigger than 6 characters!',
            'hr_contact_info.max' => 'HR contact information cannot be longer than 255 characters',
            'roles.required' => 'Role is required!',
        ];
    }
}
