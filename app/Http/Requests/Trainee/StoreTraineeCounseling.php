<?php

namespace App\Http\Requests\Trainee;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\CgoCounselingStatusEnums;
use App\Models\CgoCounseling;
class StoreTraineeCounseling extends FormRequest
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
            'trainee_nic' => [function ($attribute, $value, $fail) {
                $conflict = CgoCounseling::query()
                                        ->where('status', '!=', getCodeIdByStringEn('counselling_status', 'cancel'))
                                         ->whereDate('available_time', $this->available_date)
                                         ->where('trainee_nic', $value)
                                         ->exists();
                if ($conflict) {
                    $fail($this->messages()['trainee_nic.already_exits']);
                }
            }],
            'title' => 'required|string|max:200',
            'available_date' => 'required|date|after_or_equal:today',
            //'am_pm' => 'required',
            'detail_information' => 'required|string|max:1000',
            'trainee_attachment' => 'nullable|file|mimes:pdf,jpg,png|max:2048',
        ];
    }
}
