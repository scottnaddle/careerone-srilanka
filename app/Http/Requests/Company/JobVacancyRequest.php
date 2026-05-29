<?php

namespace App\Http\Requests\Company;

use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class JobVacancyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
	    if (auth()->guard('company')->check()) {
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
	        'title' => 'required|max:255',
	        'job_type' => 'required',
	        'sector_id' => 'required',
	        'attach_file.*' => 'nullable|file|mimes:jpg,png,pdf|max:2048',
	        'min_salary' => 'nullable|numeric|min:0|max:2147483647',
			'gender'=>'required',
	        'max_salary' => 'nullable|numeric|min:0|max:2147483647|gte:min_salary',
            'hr_name' => 'nullable|max:255',
            'hr_email' => 'nullable|max:100',
            'hr_contact_info' => 'nullable|max:255',
            'number_of_recruitments' => 'required|numeric|max:2147483647'
        ];
    }

	/**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array<string, string>
	 */
	public function messages()
	{
		return [
			'title.required' => __('company.title_is_required'),
			'job_type.required' => __('company.job_type_is_required'),
			'sector_id.required' => __('company.sector_is_required'),
			'attach_file.*.file' => __('company.attach_file_file'),
			'attach_file.*.mimes' => __('company.attach_file_mimes'),
			'attach_file.*.max' => __('company.attach_file_max'),
			'min_salary.numeric' => __('company.inputvaluenumeric'),
            'min_salary.min' => __('company.min_value', ['name' => 'min salary', 'number' => 0]),
            'min_salary.max' => __('company.max_value', ['name' => 'max salary']),
			'max_salary.numeric' => __('company.inputvaluenumeric'),
            'max_salary.min' =>__('company.min_value', ['name' => 'max salary', 'number' => 0]),
            'max_salary.max' => __('company.max_value', ['name' => 'max salary']),
            'max_salary.gte' => __('company.bigger_than_field', ['bigger' => 'max salary', 'smaller' => 'min salary']),
            'hr_name.max' => __('company.validate_max_input', ['name' => 'Name', 'num_char' => '255']),
            'hr_email.max' => __('company.validate_max_input', ['name' => 'Email', 'num_char' => '100']),
            'hr_contact_info.max' => __('company.validate_max_input', ['name' => 'Contact info', 'num_char' => '255']),
            'number_of_recruitments.max' => __('company.max_value', ['name' => 'number of recruitments']),
		];
	}

	public function withValidator(Validator $validator)
	{
		$validator->after(function ($validator) {
			// Working hours
			$start_time = $this->input('start_time');
			$end_time = $this->input('end_time');

			if ($start_time && $end_time && strtotime($start_time) >= strtotime($end_time)) {
				$validator->errors()->add('end_time', __('company.end_time_greater_than_start_time'));
			}

			// Age limitation
			$min_age = $this->input('min_age');
			$max_age = $this->input('max_age');
			$not_limit_age = filter_var($this->input('not_limit_age'), FILTER_VALIDATE_BOOLEAN);

            if ($min_age && $min_age < 16) {
                $validator->errors()->add('min_age', __('company.minimum_age_greater_than_or_equal_to_15'));
            }
            if ($max_age && $max_age < 16) {
                $validator->errors()->add('max_age', __('company.minimum_age_greater_than_or_equal_to_15'));
            }
            if ($min_age && $min_age > 100) {
                $validator->errors()->add('min_age', __('company.maximum_age_less_than_or_equal_to_100'));
            }
            if ($max_age && $max_age > 100) {
                $validator->errors()->add('max_age', __('company.maximum_age_less_than_or_equal_to_100'));
            }
            if ($min_age && $max_age && $min_age >= $max_age) {
                $validator->errors()->add('max_age', __('company.max_age_greater_than_min_age'));
            }


			// Salary per month
			$min_salary = $this->input('min_salary');
			$max_salary = $this->input('max_salary');
			$discussion_salary = filter_var($this->input('discussion_salary'), FILTER_VALIDATE_BOOLEAN);

//			if (!$discussion_salary) {
            if ($min_salary > 999999999) {
                $validator->errors()->add('min_salary', __('company.inputvaluetoolarge'));
            }
            if ($max_salary > 999999999) {
                $validator->errors()->add('max_salary', __('company.inputvaluetoolarge'));
            }
//			}

			// Required work experience
			$not_limit_experience = filter_var($this->input('not_limit_experience'), FILTER_VALIDATE_BOOLEAN);
			$min_work_experience = $this->input('min_work_experience');

			if (!$not_limit_experience) {
				if (!$min_work_experience) {
					$validator->errors()->add('min_work_experience', __('company.work_experience_required'));
				}
			}

			// Application deadline
			$application_starttime = $this->input('application_starttime');
			$application_endtime = $this->input('application_endtime');
			if ($application_starttime && $application_endtime) {
				$startDateTime = Carbon::parse($application_starttime)->format('Y-m-d') ;
				$endDateTime = Carbon::parse($application_endtime)->format('Y-m-d') ;

				if ($startDateTime && $endDateTime && $startDateTime >= $endDateTime) {
					$validator->errors()->add('application_endtime', __('company.application_endtime_greater_than_application_starttime'));
				}
			}
		});
	}
}
