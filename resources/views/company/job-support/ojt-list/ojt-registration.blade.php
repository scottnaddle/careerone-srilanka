@extends('homepage.layouts.master')
@section('title', 'Job support - OJT List - OJT Registration')
@push('css')
    <style>
        .select2-container--default .select2-selection--single{
            height: 2.6rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('company.job_support.ojt_list.ojt_registration.root') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('homepage')],
                ['label' => 'Job support', 'url' => '#'],
                ['label' => 'OJT management', 'url' => route('company.job-support.ojt-list.list')],
                ['label' => trans('company.job_support.ojt_list.ojt_registration.breadcum'), 'url' => route('company.job-support.ojt-list.registration')]
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <form class="flex flex-col gap-6" action="{{ route('company.job-support.ojt-list.postRegistration') }}"
                    method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="flex flex-col gap-6">
                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_details')}}</p>
                        <div>
                            <label for="title" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.title') }}
                                <span class="text-red-700">*</span></label>
                            <input type="text" id="title" name="title" value="{{ old('title') }}"
                                   class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " required />
                            @if ($errors->has('title'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('title') }}</span>
                            @endif
                        </div>
                        <div class="flex flex-col md:flex-row justify-between gap-6">
{{--                            <div class="w-full md:w-1/3">--}}
{{--                                <label for="company_id"--}}
{{--                                       class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.my_page.company_name')}}<span class="text-red-700">*</span></label>--}}
{{--                                    <select name="company_id" id="company_id"--}}
{{--                                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-semibold placeholder:text-[#201F36] font-semibold" {{(isset($isHeadquarter) && !$isHeadquarter) ? 'readonly disabled': ''}}>--}}
{{--                                        <option value="">Select company information</option>--}}
{{--                                        @foreach ($companyList as $company)--}}
{{--                                            <option value="{{ $company->id }}"--}}
{{--                                                {{ ($currentCompany ?? old('company_id')) == $company->id ? 'selected' : '' }}>--}}
{{--                                                {{ $company->name }} - {{getCodeNameByCodeId('office_type', $company->office_type)}}</option>--}}
{{--                                        @endforeach--}}
{{--                                    </select>--}}
{{--                                    @if ($errors->has('company_id'))--}}
{{--                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('company_id') }}</span>--}}
{{--                                   @endif--}}
{{--                            </div>--}}
                            <div class="w-full md:w-1/2">
                                <label for="period"
                                       class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.training_period')}}<span class="text-red-700">*</span></label>
                                    <input type="text" id="period" name="period" value="{{ old('period') }}"
                                           class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 6 months" required />
                                    @if ($errors->has('period'))
                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('period') }}</span>
                                @endif
                            </div>
                            <div class="w-full md:w-1/2">
                                <label for="number_of_recruitments"
                                       class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.table.label.number_of_recruitment')}}<span class="text-red-700">*</span></label>
                                <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{ old('number_of_recruitments') }}"
                                       class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 100" required />
                                @if ($errors->has('number_of_recruitments'))
                                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('number_of_recruitments') }}</span>
                                @endif
                            </div>

                        </div>
                    </div>
                    <div class="flex flex-col gap-6">
                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.root') }}</p>
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">
                                {{ __('company.gender') }} <span class="text-red-700">*</span>
                            </label>
                            <div class="flex gap-4">
                                @foreach(getCodeList('gender') as $gender)
                                    <div class="flex items-center">
                                        <input id="gender-{{$gender->code_id}}"
                                               type="checkbox"
                                               value="{{$gender->code_id}}"
                                               name="gender[]"
                                               class="w-4 h-4 text-blue-600 rounded-full border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white" {{ in_array($gender->code_id, old('gender', [])) ? 'checked' : '' }}
                                        >
                                        <label for="gender-{{$gender->code_id}}"
                                               class="ms-2 text-xs text-[#464559] dark:text-white">
                                            {{ $gender->code_name }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            @if ($errors->has('gender'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('gender') }}</span>
                            @endif
                        </div>


{{--                        <div>--}}
{{--                            <label for="min_age"--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.age_limitation') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input type="text" id="min_age" name="min_age" value="{{ old('min_age') }}"--}}
{{--                                        minlength="2" maxlength="2"--}}
{{--                                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium font-medium"--}}
{{--                                        placeholder="{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.min_age') }}" />--}}
{{--                                    @if ($errors->has('min_age'))--}}
{{--                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('min_age') }}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input type="text" id="max_age" name="max_age" value="{{ old('max_age') }}"--}}
{{--                                        minlength="2" maxlength="2"--}}
{{--                                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium font-medium"--}}
{{--                                        placeholder="{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.max_age') }}" />--}}
{{--                                    @if ($errors->has('max_age'))--}}
{{--                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('max_age') }}</span>--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input id="age_limitation" type="checkbox" value="1" name="age_limitation"--}}
{{--                                       class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="age_limitation" class="ms-2 text-xs text-[#464559] dark:text-white">--}}
{{--                                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>

                    <div>
                        <label for="min_work_experience"
                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.required_work_experience') }}
{{--                            <span class="text-red-700">*</span>--}}
                        </label>
                        <div class="flex gap-6 mb-2">
                            <div class="w-full">
                                <input type="text" id="min_work_experience" name="min_work_experience"
                                       value="{{ old('min_work_experience') }}"
                                       class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "
                                       placeholder="Min work experience" />
                                @if ($errors->has('min_work_experience'))
                                    <span
                                        class="text-red-600 text-xs p-0 m-0">{{ $errors->first('min_work_experience') }}</span>
                                @endif
                            </div>
{{--                            <div class="w-1/2">--}}
{{--                                <input type="text" id="max_work_experience" name="max_work_experience"--}}
{{--                                    value="{{ old('max_work_experience') }}"--}}
{{--                                    class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "--}}
{{--                                    placeholder="Max work experience" required />--}}
{{--                                @if ($errors->has('max_work_experience'))--}}
{{--                                    <span--}}
{{--                                        class="text-red-600 text-xs p-0 m-0">{{ $errors->first('max_work_experience') }}</span>--}}
{{--                                @endif--}}
{{--                            </div>--}}

                        </div>
                        <div class="flex items-center">
                            <input id="not_limitation_work_experience" type="checkbox" value="1" name="work_experience_limitation"
                                   class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                            <label for="not_limitation_work_experience" class="ms-2 text-xs text-[#464559] dark:text-white">
                                {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for=""
                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.required_skills') }}<span class="text-red-700">*</span></label>

                        <input name="required_skills" id="required_skills" value="{{old('required_skills')}}"
                                class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Require skills" required>
                        @if ($errors->has('required_skills'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('required_skills') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for=""
                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.Application period') }}</label>
                        <div class="flex gap-6">
                            <div class="w-1/2">

                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-buttons datepicker-autoselect-today
                                        datepicker-format="yyyy-mm-dd"
                                        datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"
                                        type="text" name="application_starttime" id="application_starttime"
                                        class="bg-white border border-gray-300 text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.application_deadline.start_date') }}">

                                </div>
                                @if ($errors->has('application_starttime'))
                                    <span
                                        class="text-red-600 text-xs p-0 m-0">{{ $errors->first('application_starttime') }}</span>
                                @endif
                            </div>
                            <div class="w-1/2">
                                <div class="relative">
                                    <div
                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                                        </svg>
                                    </div>
                                    <input datepicker datepicker-buttons datepicker-autoselect-today
                                        datepicker-format="yyyy-mm-dd"
                                        datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"
                                        type="text" name="application_endtime" id="application_endtime"
                                        class="bg-white border border-gray-300 text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.application_deadline.end_date') }}">

                                </div>
                                @if ($errors->has('application_endtime'))
                                    <span
                                        class="text-red-600 text-xs p-0 m-0">{{ $errors->first('application_endtime') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

            <div class="flex flex-col gap-6">
                <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.root') }}</p>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.name') }}</label>
                    <input type="text" id="" name="hr_name" value="{{ old('hr_name') ?? Auth::guard(activeGuard())->user()->fullName }}"
                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 "
                        placeholder="" />
                    @if ($errors->has('hr_name'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_name') ?? Auth::guard(activeGuard())->user()->fullName }}</span>
                    @endif
                </div>
                <div class="">
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.email') }}</label>
                    <input type="email" id="email" name="hr_email" value="{{ old('hr_email') ?? Auth::guard(activeGuard())->user()->email }}"
                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " />
                    @if ($errors->has('hr_email'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_email') }}</span>
                    @endif
                </div>
                <div>
                    <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.contact_info') }}</label>
                    <input type="text" id="" name="hr_contact_info" value="{{ old('hr_contact_info') ?? Auth::guard(activeGuard())->user()->telephone }}"
                        class="border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " />
                    @if ($errors->has('hr_contact_info'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_contact_info') }}</span>
                    @endif
                </div>
            </div>
            <div class="flex w-full gap-3 items-end justify-end p-4 md:p-5 ">
                <a href="{{ route('company.job-support.ojt-list.list') }}"
                    class="w-fit text-center text-gray-500 bg-[#EDEDED] hover:bg-gray-300 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
            text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ trans('company.job_support.ojt_list.ojt_registration.cancel') }}
                </a>
                <button type="submit" id="submit-all"
                    class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('system.form.button.save') }}
                </button>
            </div>
            </form>

        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>

        $(document).ready(function() {
            $('#company_id').select2({
                placeholder: "Select company information",
                allowClear: true,
            });
            $('#not_limitation_work_experience').on('change', function () {
                const minWorkExp = $('#min_work_experience');
                const maxWorkExp = $('#max_work_experience');

                if ($(this).is(':checked')) {
                    // Disable the input fields when "Not Limitation" is checked
                    minWorkExp.val('').prop('disabled', true);
                    maxWorkExp.val('').prop('disabled', true);
                    minWorkExp.val('').addClass('bg-gray-100 cursor-not-allowed');
                    maxWorkExp.val('').addClass('bg-gray-100 cursor-not-allowed');
                    minWorkExp.prop('required', false);
                    maxWorkExp.prop('required', false);
                } else {
                    // Enable the input fields when "Not Limitation" is unchecked
                    minWorkExp.prop('disabled', false);
                    maxWorkExp.prop('disabled', false);
                    minWorkExp.removeClass('bg-gray-100 cursor-not-allowed');
                    maxWorkExp.removeClass('bg-gray-100 cursor-not-allowed');
                    minWorkExp.prop('required', true);
                    maxWorkExp.prop('required', true);
                }
            });

            $('#age_limitation').on('change', function () {
                const minAge = $('#min_age');
                const maxAge = $('#max_age');

                if ($(this).is(':checked')) {
                    // Disable the input fields when "Not Limitation" is checked
                    minAge.val('').prop('disabled', true);
                    maxAge.val('').prop('disabled', true);
                    minAge.val('').addClass('bg-gray-100 cursor-not-allowed');
                    maxAge.val('').addClass('bg-gray-100 cursor-not-allowed');
                } else {
                    // Enable the input fields when "Not Limitation" is unchecked
                    minAge.prop('disabled', false);
                    maxAge.prop('disabled', false);
                    minAge.removeClass('bg-gray-100 cursor-not-allowed');
                    maxAge.removeClass('bg-gray-100 cursor-not-allowed');
                }
            });

            $('#min_age, #max_age').on('input', function() {
                var value = $(this).val();

                var validValue = value.replace(/[^0-9.]/g, '');
                validValue = validValue.replace(/^0+/, '');
                var parts = validValue.split('.');
                if (parts.length > 2) {
                    validValue = parts[0];
                }
                $(this).val(validValue);
            });

        });
    </script>
@endpush
