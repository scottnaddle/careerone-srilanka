@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.root') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.job_support.trainee_list.root'), 'url' => route('cgo.job-support.trainee-list.list')],
                ['label' => trans('cgo.job_support.trainee_list.job_match.root'), 'url' => route('cgo.job-support.trainee-list.job-match', ['trainee'=>$trainee->id])],
                ['label' => \Str::limit($jobDetail->title, 30), 'url' => route('cgo.job-support.trainee-list.list')]
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] ">
                <!-- Back Button -->
                <div class="flex items-center mb-4 pt-6 px-6">
                    <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_details')}}</p>
                </div>
{{--                <form id="form-submit" class="flex flex-col gap-6" action="{{ route('cgo.job-support.trainee-list.match-job') }}"--}}
{{--                    method="POST">--}}
{{--                    @csrf--}}
{{--                    <input value="{{ $trainee->id }}" name="trainee_id" hidden />--}}
{{--                    <input value="{{ $jobDetail->id }}" name="job_id" hidden />--}}
{{--                    <input value="{{ Auth::guard(activeGuard())->user()->id }}" name="created_by" hidden />--}}
{{--                    <input value="true" name="redirect" hidden />--}}
{{--                    <div>--}}
{{--                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.title') }}--}}
{{--                            <span class="text-red-700">*</span></label>--}}
{{--                        <input type="text" id=""--}}
{{--                            class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            value="{{ $jobDetail->title }}" readonly disabled required />--}}
{{--                    </div>--}}
{{--                    <div class="grid gap-4 grid-cols-2">--}}
{{--                        --}}{{--Job type--}}
{{--                        <div>--}}
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.job_type') }}--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('job_type') as $type)--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <input id="formal" type="checkbox"--}}
{{--                                               value="{{$type->code_id}}"--}}
{{--                                               {{ $jobDetail->job_type == $type->code_id ? 'checked' : '' }}--}}
{{--                                               disabled--}}
{{--                                               class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700--}}
{{--                                       dark:border-white bg-gray-100">--}}
{{--                                        <label for="formal" class="ms-2 text-xs text-[#464559] dark:text-white">{{ $type->code_name }}</label>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        --}}{{--Job location--}}
{{--                        <div>--}}
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Job location--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('job_location') as $location)--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <input id="location-{{$location->id}}" type="checkbox"--}}
{{--                                               value="{{$location->code_id}}"--}}
{{--                                               {{ $jobDetail->job_location == $location->code_id ? 'checked' : '' }}--}}
{{--                                               disabled--}}
{{--                                               class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700--}}
{{--                                       dark:border-white bg-gray-100">--}}
{{--                                        <label for="location-{{$location->id}}" class="ms-2 text-xs text-[#464559] dark:text-white">{{ $location->code_name }}</label>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">--}}
{{--                        --}}{{-- Job/Occupation--}}
{{--                        <div>--}}
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('cgo.job_support.ojt_list.filter.sector')}}--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-full">--}}
{{--                                    <input id="sector_id"--}}
{{--                                           disabled--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                        dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"--}}
{{--                                           value="{{$jobDetail->sector->name}}"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full">--}}
{{--                            <label for="period"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('cgo.job_support.ojt_list.table.label.number_of_recruitment')}}<span class="text-red-700">*</span></label>--}}
{{--                            <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{ $jobDetail->number_of_recruitments }}"--}}
{{--                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg: 100" required disabled />--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.job_detail.work_condition.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.work_condition.working_day') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="text" id=""--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        value="{{ convertDays($jobDetail->working_day) }}" disabled />--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input disabled type="text"--}}
{{--                                            value="{{ $jobDetail->start_date != '' ? date('Y-m-d', strtotime($jobDetail->start_date)) : '' }}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                            placeholder="{{ trans('cgo.job_support.trainee_list.job_detail.work_condition.select_date') }}" name="start_date">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                                <path--}}
{{--                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.work_condition.working_hour') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="time" id="start_time"--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        min="09:00" max="18:00" value="{{ $jobDetail->start_time }}"--}}
{{--                                        name="start_time" disabled />--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="time" id="end_time"--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        min="09:00" max="18:00" value="{{ $jobDetail->end_time }}"--}}
{{--                                        name="end_time" disabled />--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.work_condition.salary_per_month') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="${{ $jobDetail->min_salary }}" disabled />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="${{ $jobDetail->max_salary }}" disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="discuss" type="radio" value="" name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="discuss"--}}
{{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.discussion_available') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.gender.root') }}</label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="male" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                    <label for="male" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.gender.male') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="female" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                    <label for="female"--}}
{{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.gender.female') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="na" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                    <label for="na" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.gender.na') }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">--}}
{{--                                {{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.age_limitation') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $jobDetail->min_age }}" disabled />--}}
{{--                                <input type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $jobDetail->max_age }}" readonly disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="notage" type="radio" value="" name="age"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="notage" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.required_work_experience') }} <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $jobDetail->min_work_experience }}" disabled />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $jobDetail->max_work_experience }}" disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="default-radio-1" type="radio" value="" name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="default-radio-1"--}}
{{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">--}}
{{--                                {{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.required_skills') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="{{ $jobDetail->required_skills }}" disabled />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.application_deadline.root') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input disabled type="text"--}}
{{--                                            value="{{ $jobDetail->application_starttime != '' ? date("Y-m-d", strtotime($jobDetail->application_starttime)) : ''}}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white text-[#201F36] dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  font-medium placeholder-font-medium"--}}
{{--                                            name="application_starttime">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"--}}
{{--                                                viewBox="0 0 20 20">--}}
{{--                                                <path--}}
{{--                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input disabled type="text"--}}
{{--                                            value="{{ $jobDetail->application_endtime != '' ? date("Y-m-d", strtotime($jobDetail->application_endtime)) : '' }}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium" name="application_endtime">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"--}}
{{--                                                viewBox="0 0 20 20">--}}
{{--                                                <path--}}
{{--                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.name') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" disabled value="{{ $jobDetail->hr_name }}" />--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <label for="email"--}}
{{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.email') }}</label>--}}
{{--                            <input readonly type="email" id="email"--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $jobDetail->hr_email }}" disabled />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.contact_info') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $jobDetail->hr_contact_info }}" disabled />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.about_the_role') }}</p>--}}
{{--                        <div>--}}

{{--                            <label for="message"--}}
{{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.trainee_list.job_detail.application_requirements.hr_information.role') }}</label>--}}
{{--                            <textarea readonly id="message" rows="4"--}}
{{--                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white font-medium"--}}
{{--                                placeholder="" disabled>{{ $jobDetail->roles }}</textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex justify-end">--}}
{{--                        @if ($jobDetail->checkMatched($jobDetail->id, $trainee->id))--}}
{{--                            <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal"--}}
{{--                                class="py-2.5 px-4 text-white bg-[#F34550] hover:bg-red-800 text-sm font-medium rounded-full">{{ trans('cgo.job_support.trainee_list.job_detail.unmatch') }}</button>--}}
{{--                        @else--}}
{{--                            <button type="submit"--}}
{{--                                class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">{{ trans('cgo.job_support.trainee_list.job_detail.match') }}</button>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                </form>--}}
                <x-job-details :job="$jobDetail" />
                <div id="delete-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div
                            class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between pb-4 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                                    Alert
                                </h3>
                                <button type="button"
                                    class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="delete-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="flex flex-col gap-4">
                                <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                                    {{ trans('cgo.job_support.trainee_list.job_detail.unmatch_confirm_modal.message') }}</h3>
                                <div class="flex justify-center gap-4">
                                    <a href="" id="confirm_unmatch"
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        {{ trans('cgo.job_support.trainee_list.job_detail.unmatch_confirm_modal.confirm') }}
                                    </a>
                                    <button data-modal-hide="delete-modal" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                        {{ trans('cgo.job_support.trainee_list.job_detail.unmatch_confirm_modal.cancel') }}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        $('#confirm_unmatch').click(function(e) {
            e.preventDefault();
            $('#form-submit').submit();
        })
    </script>
@endpush
