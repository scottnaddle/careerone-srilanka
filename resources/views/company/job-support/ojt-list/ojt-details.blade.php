@extends('homepage.layouts.master')
@section('title', 'Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('company.menu.home'), 'url' => route('homepage')],
                ['label' => trans('company.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('company.menu.job_support.ojt_list'), 'url' => route('company.job-support.ojt-list.list')],
                ['label' => \Str::limit($ojt->title, 30), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <div class="flex items-center mb-4">
                    <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_details')}}</p>
                </div>
{{--                <form class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_details')}}</p>--}}
{{--                    <div>--}}
{{--                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.title')}}</label>--}}
{{--                        <input type="text" id=""--}}
{{--                            class="bg-[#F5F7FA] border border-[#EDEDED] bg-[#F5F7FA] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            value="{{ $ojt->title }}" readonly required disabled />--}}
{{--                    </div>--}}
{{--                    <div class="flex justify-between gap-6">--}}
{{--                        <div class="w-full md:w-1/3">--}}
{{--                            <label for="company_id"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.table.label.company')}}<span class="text-red-700">*</span></label>--}}
{{--                            <select name="company_id" id="company_id"--}}
{{--                                    class=" bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 font-semibold" required disabled readonly="">--}}
{{--                                @foreach ($companyList as $company)--}}
{{--                                    <option value="{{ $company->id }}"--}}
{{--                                        {{ $ojt->company_id == $company->id ? 'selected' : '' }}>--}}
{{--                                        {{ $company->name }} - {{ ucwords(str_replace('_', ' ', $company->office_type)) }}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                            @if ($errors->has('company_id'))--}}
{{--                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('company_id') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/3">--}}
{{--                            <label for="period"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.training_period')}}<span class="text-red-700">*</span></label>--}}
{{--                            <input type="text" id="period" name="period" value="{{$ojt->period}}"--}}
{{--                                   class="bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 6 months" required readonly disabled />--}}
{{--                            @if ($errors->has('period'))--}}
{{--                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('period') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                        <div class="w-full md:w-1/3">--}}
{{--                            <label for="period"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.number_of_recruitments')}}<span class="text-red-700">*</span></label>--}}
{{--                            <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{$ojt->number_of_recruitments}}"--}}
{{--                                   class="bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 100" required readonly disabled />--}}
{{--                            @if ($errors->has('number_of_recruitments'))--}}
{{--                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('number_of_recruitments') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                    </div>--}}


{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.root')}}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.gender.root')}}</label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('gender') as $gender)--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="" type="radio" value="{{$gender->code_id}}" name="gender"--}}
{{--                                        {{ $ojt->gender == $gender->code_id ? 'checked' : '' }}--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="" class="ms-2 text-xs text-[#464559] dark:text-white">{{$gender->code_name}}</label>--}}
{{--                                </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.age_limitation')}}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $ojt->min_age }}" disabled />--}}
{{--                                <input type="text" id=""--}}
{{--                                    class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $ojt->max_age }}" readonly disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input id="age_limitation" disabled type="checkbox" {{$ojt->age_limitation ? 'checked' : ''}} value="1" name="age_limitation"--}}
{{--                                       class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="age_limitation" class="ms-2 text-xs text-[#464559] dark:text-white">--}}
{{--                                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                                </label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.required_work_experience')}} <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $ojt->min_work_experience }}" disabled />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $ojt->max_work_experience }}" disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input id="not_limitation_work_experience" disabled type="checkbox" {{$ojt->work_experience_limitation ? 'checked' : ''}} value="1" name="work_experience_limitation"--}}
{{--                                       class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="not_limitation_work_experience" class="ms-2 text-xs text-[#464559] dark:text-white">--}}
{{--                                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                                </label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.required_skills')}}</label>--}}
{{--                            <input name="required_skills" id="required_skills" value="{{$ojt->required_skills}}" class="bg-[#F5F7FA] border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Require skills" readonly disabled>--}}

{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.application_deadline.root')}}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                                fill="none" viewBox="0 0 24 24">--}}
{{--                                                <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                    stroke-linejoin="round" stroke-width="2"--}}
{{--                                                    d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <input disabled datepicker datepicker-autoselect-today--}}
{{--                                            datepicker-format="yyyy-mm-dd"--}}
{{--                                            value="{{  $ojt->application_starttime ? \Carbon\Carbon::parse($ojt->application_starttime)->format('Y-m-d') : '' }}"--}}
{{--                                            datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"--}}
{{--                                            type="text" name="application_starttime" id="application_starttime"--}}
{{--                                            class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                                xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                                fill="none" viewBox="0 0 24 24">--}}
{{--                                                <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                    stroke-linejoin="round" stroke-width="2"--}}
{{--                                                    d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <input disabled datepicker datepicker-autoselect-today--}}
{{--                                            datepicker-format="yyyy-mm-dd"--}}
{{--                                            value="{{$ojt->application_endtime ? \Carbon\Carbon::parse($ojt->application_endtime)->format('Y-m-d') : ''}}"--}}
{{--                                            datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"--}}
{{--                                            type="text" name="application_endtime" id="application_endtime"--}}
{{--                                            class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.root')}}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.name')}}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" disabled value="{{ $ojt->hr_name }}" />--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <label for="email"--}}
{{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.email')}}</label>--}}
{{--                            <input readonly type="email" id="email"--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $ojt->hr_email }}" disabled />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.contact_info')}}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $ojt->hr_contact_info }}" disabled />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
                <x-o-j-t-details :ojt="$ojt" />
            </div>
        </div>
    </div>
@endsection
@push('js')
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script> --}}
@endpush
