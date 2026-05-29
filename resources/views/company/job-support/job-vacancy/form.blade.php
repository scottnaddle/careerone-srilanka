@extends('homepage.layouts.master')
@section('title', 'Company - Job support - Job Vacancy - Publish Job')

@push('css')
    <style>
        input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(0%) brightness(0%);
        }

        .dark input[type="time"]::-webkit-calendar-picker-indicator {
            filter: invert(100%) brightness(200%);
        }
    </style>
@endpush
@section('content')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ __('company.job_vacancy') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('homepage')],
                ['label' => 'Job support', 'url' => '#'],
                ['label' => __('company.job_vacancy'), 'url' => route('company.job-support.job-vacancy.list')],
                ['label' => __('company.my_page.publish_job'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">

                <form class="flex flex-col gap-6"
                      enctype="multipart/form-data"
                        @if( optional($job)->id )
                          action="{{ route('company.job-support.job-vacancy.update', ['job_id' => $job->id]) }}"
                          method="post">
                          @method('PUT')
                      @else
                          action="{{ route('company.job-support.job-vacancy.store') }}"
                          method="post">
                          @method('POST')
                      @endif

                    @csrf
                    <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.job_details') }}</p>
                    {{--Title--}}
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.title') }}
                            <span class="text-red-700">*</span></label>
                        <input type="text" id="" name="title"
                               class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                               value="{{ old('title', optional($job)->title) }}" required />
                        @if ($errors->has('title'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4">
                        {{--Job type--}}
                        <div>
                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.Employment type')}}
                                <span class="text-red-700">*</span></label>
                            <div class="flex gap-6">
                                <div class="w-full">
                                    <select id=""
                                            name="job_type"
                                            class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]" required>
                                        @forelse(getCodeList('job_type') as $type)
                                            <option {{ old('job_type', optional($job)->job_type) == $type->code_id ? 'selected' : '' }} value="{{$type->code_id}}">{{$type->code_name }}</option>
                                        @empty
                                            <option>{{ __('company.none') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @if ($errors->has('job_type'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('job_type') }}</span>
                            @endif
                        </div>

                        <div class="col-span-2">
                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.job_location') }}
                                <span class="text-red-700">*</span></label>
                            <input type="text" id="" name="job_location"
                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                   value="{{ old('job_location', optional($job)->job_location) }}" placeholder="{{trans('company.eg: 354/2 Elvitigala Mawatha, Colombo 00500')}}" required />
                            @if ($errors->has('job_location'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('job_location') }}</span>
                            @endif
                        </div>


                        {{--                    Job location--}}
{{--                        <div>--}}
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_location')}}--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('job_location') as $location)--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <input id="job-location-{{$location->code_id}}" type="radio"--}}
{{--                                               value="{{$location->code_id}}"--}}
{{--                                               {{ old('job_location', optional($job)->job_location) == $location->code_id ? 'checked' : '' }}--}}
{{--                                               name="job_location"--}}
{{--                                               class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white" required>--}}
{{--                                        <label for="job-location-{{$location->code_id}}" class="ms-2 text-xs text-[#464559] dark:text-white">{{ $location->code_name }}</label>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}
{{--                            @if ($errors->has('job_location'))--}}
{{--                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('job_location') }}</span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        {{-- Job/Occupation--}}
                        <div>
                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.industry')}}
                                <span class="text-red-700">*</span></label>
                            <div class="flex gap-6">
                                <div class="w-full flex flex-col gap-1">
                                    <select id="sector_id"
                                            name="sector_id"
                                            class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]" required>
                                        @forelse($sectors as $sector)
                                            <option {{ old('sector_id', optional($job)->sector_id) == $sector->id ? 'selected' : '' }} value="{{$sector->id}}">{{$sector->name}}</option>
                                        @empty
                                            <option>{{ __('company.none') }}</option>
                                        @endforelse
                                    </select>
                                    <input type="text" id="" name="sector_information"
                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                           value="{{ old('sector_information', optional($job)->sector_information) }}" placeholder="{{trans('company.eg: The industry relevant to the job vacancy')}}" required />
                                </div>
                            </div>
                            @if ($errors->has('sector_id'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('sector_id') }}</span>
                            @endif
                        </div>
                        <div class="w-full">
                            <label for="period"
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.job_support.ojt_list.table.label.number_of_recruitment') }}<span class="text-red-700">*</span></label>
                            <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{ old('number_of_recruitments', optional($job)->number_of_recruitments) }}"
                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 100" required />
                            @if ($errors->has('number_of_recruitments'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('number_of_recruitments') }}</span>
                            @endif
                        </div>
                    </div>
                    {{-- Job Role--}}
                    <div class="flex flex-col gap-6">
                        <div>
                            <label for="message"
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.job_role') }} <span class="text-red-700">*</span></label>
                            <textarea id="message" rows="4"
                                      name="roles"
                                      class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white"
                                      placeholder="{{trans('company.eg: overview of the role, its purpose and context within the organisation)')}}" required>{{ old('roles', optional($job)->roles) }}</textarea>
                        </div>
                    </div>

                    {{-- Work condition--}}
                    <div class="flex flex-col gap-6">
                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.work_condition') }}</p>
                        {{--work type--}}
                        <div>
                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.work_type') }}
                                <span class="text-red-700">*</span></label>
                            <div class="flex gap-6">
                                <div class="w-full">
                                    <select id=""
                                            name="work_type"
                                            class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]" required>
                                        @forelse(getCodeList('work_type') as $type)
                                            <option {{ old('work_type', optional($job)->work_type) == $type->code_id ? 'selected' : '' }} value="{{$type->code_id}}">{{$type->code_name }}</option>
                                        @empty
                                            <option>{{ __('company.none') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div>
                            @if ($errors->has('work_type'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('work_type') }}</span>
                            @endif
                        </div>
                        {{-- Working day--}}
                        <div>
                            <label for="working_day"
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.working_day') }}</label>
                            <div class="flex gap-6">
                                <div class="w-1/2">
                                    <input type="text"
                                           value="{{ old('working_day', optional($job)->working_day) }}"
                                           class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] "
                                           placeholder="{{ trans('company.eg: Weekdays, Weekends') }}" id="working_day" name="working_day">
                                </div>
                                <div class="w-1/2">
                                    <div class="relative">
                                        <input type="text"
                                               value="{{ old('start_date', optional($job)->start_date) }}"
                                               class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] "
                                               placeholder="{{ __('company.select_date') }}" id="start_date" name="start_date">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg
                                            focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-white dark:placeholder-text-white dark:text-white
                                            dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]">
                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        {{-- Working hours--}}
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.working_hours') }}</label>
                            <div class="flex gap-6">
                                <div class="w-1/2">
                                    <input type="time" id="start_time"
                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                           value="{{ old('start_time', optional($job)->start_time) }}"
                                           name="start_time" />
                                    @if ($errors->has('start_time'))
                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('start_time') }}</span>
                                    @endif
                                </div>
                                <div class="w-1/2">
                                    <input type="time" id="end_time"
                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                           value="{{ old('end_time', optional($job)->end_time) }}"
                                           name="end_time" />
                                    @if ($errors->has('end_time'))
                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('end_time') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.salary_type')}}
                                    </label>
                                <div class="flex gap-6">
                                    <div class="w-full flex flex-col gap-1">
                                        <select id="salary_type_id"
                                                name="salary_type"
                                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]">
                                            @forelse(getCodeList('salary_type') as $salary_type)
                                                <option {{ old('salary_type', optional($job)->salary_type) == $salary_type->code_id ? 'selected' : '' }} value="{{$salary_type->code_id}}">{{$salary_type->code_name}}</option>
                                            @empty
                                                <option>{{ __('company.none') }}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                @if ($errors->has('salary_type'))
                                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('salary_type') }}</span>
                                @endif
                            </div>
                            {{-- Salary per month--}}
                            <div class="w-full">
                                <label for=""
                                       class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.salary') }}</label>
                                <div class=" mb-2 w-full">
                                    <div class="">
                                        <div class="flex relative">
                                            <!-- Currency Selector Button -->
                                            <button id="dropdown-currency-button" class="h-full flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-xl focus:outline-none focus:ring-gray-100 dark:bg-[#1E1E1E] dark:text-white dark:border-white" type="button">
                                                {{optional($job)->salary_currency ?? 'LKR'}} <!-- Default currency symbol -->
                                            </button>

                                            <!-- Hidden Input for Currency -->
                                            <input type="hidden" id="currency" name="salary_currency" value="{{optional($job)->salary_type ?? 'LKR'}}">

                                            <!-- Salary Input -->
                                            <div class="relative w-full">
                                                <input type="text" id="min_salary" name="min_salary" inputmode="decimal" pattern="^\d+(\.\d{1,2})?$" step="0.01"
                                                       class="border border-[#EDEDED] text-[#201F36] text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                       value="{{ old('min_salary', optional($job)->min_salary) }}"
                                                       placeholder="{{ __('company.Minimum salary') }}" />
                                                @if ($errors->has('min_salary'))
                                                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('min_salary') }}</span>
                                                @endif
                                            </div>

                                            <!-- Currency Dropdown Menu -->
                                            <div id="dropdown-currency" class="hidden absolute bg-white divide-y divide-gray-100 rounded-lg shadow w-32 dark:bg-gray-700 top-12">
                                                <ul class="text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdown-currency-button">
                                                    <li class="rounded-t-lg">
                                                        <button type="button" class="currency-option inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white rounded-t-lg" data-symbol="$">
                                                            $ <!-- Dollar option -->
                                                        </button>
                                                    </li>
                                                    <li class="rounded-b-lg">
                                                        <button type="button" class="currency-option inline-flex w-full px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-gray-600 dark:hover:text-white rounded-b-lg" data-symbol="LKR">
                                                            LKR <!-- Rupee option -->
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    {{--                                <div class="w-1/2">--}}
                                    {{--                                    <input type="text" id="max_salary"--}}
                                    {{--                                           name="max_salary"--}}
                                    {{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
                                    {{--                                           placeholder="{{ __('company.max_salary') }}"--}}
                                    {{--                                           value="{{ old('max_salary', optional($job)->max_salary) }}" />--}}
                                    {{--                                    @if ($errors->has('max_salary'))--}}
                                    {{--                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('max_salary') }}</span>--}}
                                    {{--                                    @endif--}}
                                    {{--                                </div>--}}

                                </div>
                                <div class="flex items-center">
                                    <input type="hidden" name="discussion_salary" value="false">
                                    <input id="discuss" type="checkbox" value="true" {{ old('discussion_salary', optional($job)->discussion_salary) == 'true' ? 'checked' : '' }} name="discussion_salary"
                                           class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">
                                    <label for="discuss"
                                           class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('company.negotiable') }}</label>
                                </div>

                            </div>
                        </div>


                    </div>
                    {{-- Application Requirements--}}
                    <div class="flex flex-col gap-6">
                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.application_requirements') }}</p>
                        {{-- Gender--}}
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">
                                {{ __('company.gender') }}
                                <span class="text-red-700">*</span>
                            </label>
                            <div class="flex gap-4">
                                @foreach(getCodeList('gender') as $gender)
                                <div class="flex items-center">
                                    <input id="gender-{{$gender->code_id}}"
                                           type="checkbox"
                                           value="{{$gender->code_id}}"
                                           name="gender[]"
                                           {{ in_array($gender->code_id, old('gender', optional($job)->gender ? json_decode($job->gender, true) : [])) ? 'checked' : '' }}
                                           class="w-4 h-4 text-blue-600 rounded-full border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
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

                        {{-- Required work experience--}}
                        <div>
                            <label for="min_work_experience" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">
                                {{ __('company.required_work_experience') }} <span class="text-red-700">*</span>
                            </label>
                            <div class="flex gap-6 mb-2">
                                <input type="text" id="min_work_experience"
                                       name="min_work_experience"
                                       placeholder=""
                                       class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
               dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ old('min_work_experience', optional($job)->min_work_experience) }}" required />
                            </div>
                            <div class="flex items-center">
                                <input type="hidden" name="not_limit_experience" value="false">
                                <input id="not_limit_experience" type="checkbox" value="true"
                                       {{ old('not_limit_experience', optional($job)->not_limit_experience) == 'true' ? 'checked' : '' }}
                                       name="not_limit_experience"
                                       class="rounded-full w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">
                                <label for="not_limit_experience"
                                       class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ __('company.not_limitation') }}</label>
                            </div>
                            @if ($errors->has('min_work_experience'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('min_work_experience') }}</span>
                            @endif
                        </div>
{{--                        NVQ level--}}
                        <div>
                            <label for="nvq_level" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">
                                {{ __('company.NVQ requirements / Preferred qualifications') }}
                            </label>
                            <div class="flex gap-6 mb-2">
                                <input type="text" id="nvq_level"
                                       name="nvq_level"
                                       placeholder=""
                                       class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
               dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       value="{{ old('nvq_level', optional($job)->nvq_level) }}" />
                            </div>
                            @if ($errors->has('nvq_level'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('nvq_level') }}</span>
                            @endif
                        </div>


                        {{-- Required skills--}}
                        <div>
                            <label for="required_skills"
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.required_skills') }}</label>
                            <textarea id="required_skills" rows="4"
                                      name="required_skills"
                                      class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white"
                                      placeholder="{{ __('company.e.g. vocational / technical skills, soft skills, language skills, certifications etc.') }}">{{ old('required_skills', optional($job)->required_skills) }}</textarea>
                        </div>
                        {{-- Application deadline--}}
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.Application period') }}</label>
                            <div class="flex gap-6">
                                {{-- Start date--}}
                                <div class="w-1/2">
                                    <div class="relative">
                                        <input type="text"
                                               value="{{ old('application_starttime', optional($job)->application_starttime) }}"
                                               class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36]"
                                               placeholder="{{ __('company.starting_date') }}" id="application_starttime" name="application_starttime">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]">
                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                                {{-- End date--}}
                                <div class="w-1/2">
                                    <div class="relative">
                                        <input type="text"
                                               value="{{ old('application_endtime', optional($job)->application_endtime) }}"
                                               class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36]"
                                               placeholder="{{ __('company.end_date') }}" id="application_endtime" name="application_endtime">
                                        <div
                                            class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-semibold placeholder:text-[#201F36] font-semibold">
                                            <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"
                                                 xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                 viewBox="0 0 20 20">
                                                <path
                                                    d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                    </div>
                                    @if ($errors->has('application_endtime'))
                                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('application_endtime') }}</span>
                                    @endif
                                </div>

                            </div>

                        </div>
                    </div>
                    {{-- Inquiries--}}
                    <div class="flex flex-col gap-6">
                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.inquiries') }}</p>
                        {{-- Name--}}
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.name')}}</label>
                            <input type="text" id=""
                                   name="hr_name"
                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                   placeholder="" value="{{ old('hr_name', optional($job)->hr_name) ?? Auth::guard(activeGuard())->user()->fullName }}" />
                            @if ($errors->has('hr_name'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_name') }}</span>
                            @endif
                        </div>
                        {{-- Email--}}
                        <div class="">
                            <label for="email"
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.email') }}</label>
                            <input type="email" id="email"
                                   name="hr_email"
                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                   value="{{ old('hr_email', optional($job)->hr_email) ?? Auth::guard(activeGuard())->user()->email }}" />
                            @if ($errors->has('hr_email'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_email') }}</span>
                            @endif
                        </div>
                        {{-- Contact info--}}
                        <div>
                            <label for=""
                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.contact_info') }}</label>
                            <input type="text" id=""
                                   name="hr_contact_info"
                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36]"
                                   value="{{ old('hr_contact_info', optional($job)->hr_contact_info) ?? Auth::guard(activeGuard())->user()->telephone }}" />
                            @if ($errors->has('hr_contact_info'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('hr_contact_info') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Attach file--}}
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">{{ __('company.attach_file') }}</label>
                        <input class="block w-full text-sm text-gray-900 border border-[#EDEDED] rounded-lg cursor-pointer dark:text-gray-400 focus:outline-none
                        dark:border-gray-600 dark:placeholder-gray-400 mb-1" name="attach_file[]" accept=".jpg,.png,.pdf"  id="file_input" type="file" multiple>
                        <span class="dark:text-white text-xs">{{trans('company.You may upload the job vacancy as a PDF or image file.')}}</span>
                        @foreach ($errors->messages() as $key => $error)
                            @if (Str::startsWith($key, 'attach_file.'))
                                <span class="text-red-600 text-xs p-0 m-0">{{ $error[0] }}</span>
                                @break
                            @endif
                        @endforeach

                        @if( optional($job)->id )
                            <div id="attachments-list" class="mb-3">
                                <div id="attachments-list">
                                    @foreach($job->attachments as $attachment)
                                        <div class="attachment-item mt-4 flex flex-wrap gap-4">
                                            <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px;
                                            display: flex;
                                            padding: 6px;
                                            align-items: center;
                                            gap: 6px;">
                                                {{ $attachment }}
                                                <button type="button" class="btn btn-danger btn-sm delete-attachment align-content-center" data-file="{{ $attachment }}">
                                                    <svg width="9" height="9"  aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                                    </svg>
                                                </button>

                                            </span>
                                        </div>
                                    @endforeach
                                    <input type="hidden" id="files-deleted" name="files_deleted">
                                </div>
                            </div>
                        @endif


                    </div>
                    @if( optional($job)->id )
                    {{-- Change status --}}
                            <div class="mb-3">
                                <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.status') }}
                                    <span class="text-red-700">*</span></label>
                                <div class="flex">
                                    <div class="w-full">
                                        <select id=""
                                                name="status"
                                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">

                                            @foreach( $states as $k => $status)
                                                <option {{ old('status', optional($job)->status) == $k ? 'selected' : '' }}
                                                        value="{{$k}}">{{$status}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                    @endif

                    {{-- Submit button--}}
                    <div class="flex gap-6 justify-end">
                        <a type="button" href="{{ route('company.job-support.job-vacancy.list') }}" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:outline-none  font-medium rounded-full text-sm w-full
                        sm:w-auto
                        px-5 py-2.5 text-center close-upload-modal">{{ __('company.cancel') }}</a>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('company.submit') }}</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script src="{{ asset('js/select2.js') }}" type="module"></script>

    <script type="module">
        $(document).ready(function() {
            // Select2 Multiple
            // $('#working_day').select2({
            //     placeholder: "Select working day",
            //     allowClear: true,
            // });

            // Datepicker
            let startDate = document.getElementById('start_date');
            let applicationStarttime = document.getElementById('application_starttime');
            let applicationEndtime = document.getElementById('application_endtime');

            let today = new Date();

            let startDatePicker = new Datepicker(startDate, {
                format: 'yyyy-mm-dd',
                minDate: today,
                autohide: true,
                color: '#f00',
            });
            let applicationStarttimePicker = new Datepicker(applicationStarttime, {
                format: 'yyyy-mm-dd',
                minDate: today,
                autohide: true
            });
            let applicationEndtimePicker = new Datepicker(applicationEndtime, {
                format: 'yyyy-mm-dd',
                minDate: today,
                autohide: true
            });
        // Toggle dropdown visibility
            $('#dropdown-currency-button').on('click', function(e) {
                e.stopPropagation();
                $('#dropdown-currency').toggleClass('hidden');
            });

            // Set currency symbol, update hidden input, and close dropdown
            $('.currency-option').on('click', function() {
                var symbol = $(this).data('symbol');
                $('#dropdown-currency-button').text(symbol); // Update button text with selected currency
                $('#currency').val(symbol); // Update hidden input with selected currency
                $('#dropdown-currency').addClass('hidden'); // Close dropdown
            });

            // Close dropdown if clicked outside
            $(document).on('click', function(e) {
                if (!$(e.target).closest('#dropdown-currency-button, #dropdown-currency').length) {
                    $('#dropdown-currency').addClass('hidden');
                }
            });
            // Validate salary input
            $('#min_salary, #max_salary').on('input', function() {
                var value = $(this).val();

                var validValue = value.replace(/[^0-9.]/g, '');

                var parts = validValue.split('.');
                if (parts.length > 2) {
                    validValue = parts[0] + '.' + parts[1];
                }
                $(this).val(validValue);
            });

            const minAgeInput = $('#min_age');
            const maxAgeInput = $('#max_age');
            const notAgeCheckbox = $('#notage');

            function toggleAgeInputs() {
                if (notAgeCheckbox.is(':checked')) {
                    minAgeInput.val('').prop('disabled', true).addClass('cursor-not-allowed bg-gray-100');
                    maxAgeInput.val('').prop('disabled', true).addClass('cursor-not-allowed bg-gray-100');
                } else {
                    minAgeInput.prop('disabled', false).removeClass('cursor-not-allowed bg-gray-100');
                    maxAgeInput.prop('disabled', false).removeClass('cursor-not-allowed bg-gray-100');
                }
            }

            // Initial check on page load
            toggleAgeInputs();

            // Listen for changes on the checkbox
            notAgeCheckbox.on('change', toggleAgeInputs);


            const workExperienceInput = $('#min_work_experience');
            const notLimitExperienceCheckbox = $('#not_limit_experience');

            function toggleExperienceInput() {
                if (notLimitExperienceCheckbox.is(':checked')) {
                    workExperienceInput.val('').prop('disabled', true).addClass('cursor-not-allowed bg-gray-100');
                } else {
                    workExperienceInput.prop('disabled', false).removeClass('cursor-not-allowed bg-gray-100');
                }
            }

            // Initial check on page load
            toggleExperienceInput();

            // Listen for changes on the checkbox
            notLimitExperienceCheckbox.on('change', toggleExperienceInput);
        });
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.delete-attachment').forEach(button => {
                button.addEventListener('click', function () {
                    const file = this.getAttribute('data-file');
                    const fileDeletedInput = document.querySelector('#files-deleted');

                    // Add the file name to the hidden input's value
                    fileDeletedInput.value += file + ';';

                    // Hide the attachment item
                    this.parentElement.parentElement.style.display = 'none';
                });
            });
        });
    </script>

@endpush
