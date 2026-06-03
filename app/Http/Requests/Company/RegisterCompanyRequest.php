<?php


namespace App\Http\Requests\Company;

use Illuminate\Foundation\Http\FormRequest;

class RegisterCompanyRequest extends FormRequest {
    public function authorize(): bool {
        return true;
    }

    public function rules(): array {
        $companyInformation = $this->input('company_information');
        $officeType = $this->input('office_type');

        $rules = [
            'company_information' => 'required',
            'district'            => 'required',
            'address'             => 'required',
            'attached_file.*'     => 'nullable|mimes:jpg,jpeg,png,pdf,docx|max:2048'
        ];

        // Validation based on company information type
        if ($companyInformation == 1) {
            // Ministry/Organization
            $rules['ministry_name'] = 'required|string|max:255';
            $rules['organisation_name'] = 'nullable|string|max:255';
        } else if (in_array($companyInformation, ['', 4, 5, 7])) {
            // Business registration types
            $rules['name'] = 'required|string|max:255';
            $rules['office_type'] = 'required';
            $rules['date_of_establishment'] = 'required|date';
            $rules['number_workers'] = 'required|integer|min:1';
            $rules['business_registration_number'] = 'required|string|max:255';

            if ($officeType == 2) {
                $rules['headquarter_id'] = 'required';
            }
        } else if (in_array($companyInformation, [2, 3, 6])) {
            // Other organization types
            $rules['name'] = 'required|string|max:255';
            $rules['office_type'] = 'required';
            $rules['co_business'] = 'required|string|max:255';
            $rules['business_registration_number_1'] = 'required|string|max:255';

            if ($officeType == 2) {
                $rules['headquarter_id'] = 'required';
            }
        }

        return $rules;
    }

    public function messages(): array {
        return [
            'ministry_name.required'                  => 'The ministry name is required.',
            'name.required'                           => 'The organisation name is required.',
            'co_business.required'                    => 'The field of operations is required.',
            'business_registration_number.required'   => 'The business registration number is required.',
            'business_registration_number_1.required' => 'The registration number is required.',
            'office_type.required'                    => 'Please select an office type.',
            'date_of_establishment.required'          => 'The date of establishment is required.',
            'number_workers.required'                 => 'The number of workers is required.',
            'headquarter_id.required'                 => 'Please select a headquarter for branch office.',
            'district.required'                       => 'Please select a district.',
            'address.required'                        => 'The address is required.',
        ];
    }
}
//
//namespace App\Http\Requests\Company;
//
//use Illuminate\Foundation\Http\FormRequest;
//
//class RegisterCompanyRequest extends FormRequest
//{
//    /**
//     * Determine if the user is authorized to make this request.
//     */
//    public function authorize(): bool
//    {
//        return true;
//    }
//
//    /**
//     * Get the validation rules that apply to the request.
//     *
//     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
//     */
//    public function rules(): array
//    {
//        $rules = [
//            'name' => 'required|string|max:255',
//            'office_type' => 'required',
//            'date_of_establishment' => 'required|date',
////            'name_of_representative' => 'required|string|max:255',
//            'number_workers' => 'required',
//            'district' => 'required',
//            'address' => 'required',
//            // 'hotline'=>'required',
//            // 'ds_id'=>'required',
//        ];
//
//        if (!$this->has('id'))
//        {
//            $rules += ['attached_file.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:2048'];
//        }else {
//            $rules += ['attached_file.*' => 'mimes:jpg,jpeg,png,pdf,docx|max:2048'];
//        }
//        if ($this->office_type == 2) {
//            $rules += ['headquarter_id' => 'required'];
//        }
//        return $rules;
//    }
//
//}
