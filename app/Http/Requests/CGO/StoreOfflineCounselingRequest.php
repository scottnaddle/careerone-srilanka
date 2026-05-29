<?php

namespace App\Http\Requests\CGO;

use App\Enums\CgoCounselingStatusEnums;
use App\Models\CgoCounseling;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StoreOfflineCounselingRequest extends FormRequest
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
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // $this->merge([
        //     'available_time' => \Illuminate\Support\Carbon::createFromFormat('H:i Y-m-d', $this->available_hour . ':' . $this->available_minute . ' ' . $this->available_date),
        // ]);
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
            'detail_information' => 'required|string|max:1000',
            'counseling_field_id' => 'required|integer',
            'trainee_nic' => ["required","string","regex:/^[0-9]{9}[A-Z]$|^[0-9]{12}$/",function ($attribute, $value, $fail) {
                $conflict = CgoCounseling::query()
                                        ->where('status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
//                                         ->where('available_time', $this->available_time)
                                        ->whereDate('available_time', $this->available_date)
                                         ->where('trainee_nic', $value)
                                         ->exists();
                if ($conflict) {
                    $fail($this->messages()['trainee_nic.conflict']);
                }
            }],
            'trainee_offline_lastname' => 'required|string|max:25',
            'trainee_offline_firstname' => 'required|string|max:25',
            // 'available_hour' => ["required","string","regex:/^([1-9]|1[0-9]|2[0-4])$/"],
            // 'available_minute' => ["required","string","regex:/^(00|30)$/"],
            'available_time' => [
                function ($attribute, $value, $fail) {
                    $conflict = CgoCounseling::query()
                                             ->join('cgo_counseling_assign_histories', 'cgo_counseling_assign_histories.counseling_id', '=', 'cgo_counselings.id')
                                             ->where('status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
                                             ->where('cgo_counseling_assign_histories.assignee_to', Auth::guard('cgo')->user()->id)
                                             ->where('available_time', $value)
                                             ->exists();

                    if ($conflict) {
                        $fail($this->messages()['available_time.conflict']);
                    }
                },
            ],
            'available_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $date = Carbon::parse($value);
                    if ($date->isWeekend()) {
                        $fail('The selected date cannot be a Saturday or Sunday.');
                    }
                },
            ],
        ];
        //TODO: Implement available_minute and available_hour by configuring instead of hardcoding
    }

    public function messages()
    {
        return [
            'title.required' => 'Title is required!',
            'title.string' => 'Title must be a string!',
            'title.max' => 'Title cannot be longer than 50 characters!',
            'detail_information.required' => 'Description is required!',
            'detail_information.string' => 'Description must be a string!',
            'detail_information.max' => 'Description cannot be longer than 1000 characters!',
            'status.required' => 'Status is required!',
            'status.string' => 'Status must be a string!',
            'counseling_field_id.required' => 'Counseling Field ID is required!',
            'counseling_field_id.integer' => 'Counseling Field ID must be an integer!',
            'trainee_nic.required' => 'Trainee NIC is required!',
            'trainee_nic.string' => 'Trainee NIC must be a string!',
            'trainee_nic.regex' => 'The trainee NIC must be 9 digits followed by an uppercase letter, or 12 digits.',
            'trainee_nic.conflict' => 'This trainee already has a counseling session at this time!',
            'trainee_offline_lastname.required' => 'Trainee Last Name is required!',
            'trainee_offline_lastname.string' => 'Trainee Last Name must be a string!',
            'trainee_offline_lastname.max' => 'Trainee Last Name cannot be longer than 25 characters!',
            'trainee_offline_firstname.required' => 'Trainee First Name is required!',
            'trainee_offline_firstname.string' => 'Trainee First Name must be a string!',
            'trainee_offline_firstname.max' => 'Trainee First Name cannot be longer than 25 characters!',
            'available_hour.required' => 'Available Hour is required!',
            'available_hour.string' => 'Available Hour must be a string!',
            'available_hour.regex' => 'Available Hour must be between 1 and 24!',
            'available_minute.required' => 'Available Minute is required!',
            'available_minute.string' => 'Available Minute must be a string!',
            'available_minute.regex' => 'Available Minute must be either 00 or 30!',
            'available_time.conflict' => 'The selected time is already taken!',
            'trainee_nic.already_exits' => 'You have already registered before !',
        ];
    }
}
