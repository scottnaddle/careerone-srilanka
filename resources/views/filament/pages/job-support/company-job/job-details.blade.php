<div class="mx-auto w-full">

    <div class="my-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <x-breadcrumb :items="[
                        ['label' => 'Admin', 'url' => '/admin/overview'],
                        ['label' => 'Job support', 'url' => '#'],
                        ['label' => $this->job->company->name, 'url' => '/admin/company-jobs/'.$this->job->company->id.'/view'],
                        ['label' => $this->job->title, 'url' => '#'],
                    ]" />
{{--            <a href="/admin/jobs"--}}
{{--                class="text-gray-900  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">--}}
{{--                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"--}}
{{--                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                        d="m15 19-7-7 7-7" />--}}
{{--                </svg>--}}
{{--                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{ $job->title }}</h3>--}}
{{--            </a>--}}
            <div class="flex flex-col gap-4">
                    <x-job-details :job="$this->job" />
{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">Job details</p>--}}

{{--                    --}}{{--Title--}}
{{--                    <div>--}}
{{--                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.title') }}--}}
{{--                            <span class="text-red-700">*</span></label>--}}
{{--                        <input type="text" disabled--}}
{{--                               class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white--}}
{{--                               dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                               value="{{ optional($this->job)->title }}"  />--}}
{{--                    </div>--}}
{{--                    <div class="grid gap-6 grid-cols-2">--}}
{{--                        --}}{{--Job type--}}
{{--                        <div>--}}
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.job_type') }}--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('job_type') as $type)--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <input id="formal" type="checkbox"--}}
{{--                                               value="{{$type->code_id}}"--}}
{{--                                               {{ $this->job->job_type == $type->code_id ? 'checked' : '' }}--}}
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
{{--                                               {{ $this->job->job_location == $location->code_id ? 'checked' : '' }}--}}
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
{{--                            <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.occupation') }}--}}
{{--                                <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-full">--}}
{{--                                    <input id="sector_id"--}}
{{--                                           disabled--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                        dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                           value="{{$this->job->sector->name}}"/>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="w-full">--}}
{{--                            <label for="period"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Number of Recruitments<span class="text-red-700">*</span></label>--}}
{{--                            <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{ $this->job->number_of_recruitments }}"--}}
{{--                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500  bg-gray-100" placeholder="eg: 100" required disabled />--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    --}}{{-- Work condition--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.work_condition') }}</p>--}}
{{--                        --}}{{-- Working day--}}
{{--                        <div>--}}
{{--                            <label for="working_day"--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.working_day') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2 flex border align-items-center gap-4 border-[#EDEDED] text-[#201F36] text-sm rounded-lg px-2 bg-gray-100 overflow-x-auto dark:bg-[#1E1E1E] ">--}}
{{--                                    @foreach($this->job->working_day as $day)--}}
{{--                                        <span class="text-[#4984F6] align-items-center" style="margin: auto 0; font-weight: 500;">{{ $this->working_day[$day] ?? '' }}</span>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2 flex flex-row items-center rounded-lg border border-[#EDEDED] text-[#201F36] bg-gray-100 dark:bg-[#1E1E1E]--}}
{{--                                        dark:border-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                    <div class="p-2.5">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <span class="text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5">{{ optional($this->job)->start_date != ''  ? optional($this->job)->start_date : 'N/G'}}</span>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        --}}{{-- Working hours--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.working_hours') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input type="time" id="start_time"--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                           dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                           value="{{ optional($this->job)->start_time }}"--}}
{{--                                           disabled />--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input type="time" id="end_time"--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                           dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                           value="{{ optional($this->job)->end_time }}"--}}
{{--                                           disabled />--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{-- Salary per month--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.salary_per_month') }}</label>--}}
{{--                            <div class="grid grid-cols-2 gap-6 mb-2">--}}
{{--                                <div class="flex relative">--}}
{{--                                    <!-- Currency Selector Button -->--}}
{{--                                    <button id="dropdown-currency-button" disabled class="flex-shrink-0 z-10 inline-flex items-center py-2.5 px-4 text-sm font-medium text-center text-gray-900 bg-gray-100 border border-gray-300 rounded-l-xl focus:ring-4 focus:outline-none focus:ring-gray-100 dark:bg-[#1E1E1E] dark:text-white dark:border-white" type="button">--}}
{{--                                        {{$this->job->salary_currency}}--}}
{{--                                    </button>--}}

{{--                                    <!-- Salary Input -->--}}
{{--                                    <div class="relative w-full">--}}
{{--                                        <input type="text" id="min_salary" name="min_salary" inputmode="decimal" pattern="^\d+(\.\d{1,2})?$" step="0.01"--}}
{{--                                               class="border border-[#EDEDED] text-[#201F36] text-sm rounded-r-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                       dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-100"--}}
{{--                                               value="{{ $this->job->min_salary }}"--}}
{{--                                               placeholder="{{ __('company.min_salary') }}" disabled />--}}
{{--                                        @if ($errors->has('min_salary'))--}}
{{--                                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('min_salary') }}</span>--}}
{{--                                        @endif--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <input type="text" id="max_salary"--}}
{{--                                       disabled--}}
{{--                                       name="max_salary"--}}
{{--                                       class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                       dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-100"--}}
{{--                                       value="{{ optional($this->job)->max_salary }}"  readonly />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input type="hidden" name="discussion_salary" value="false">--}}
{{--                                <input id="discuss" disabled type="checkbox" value="true" {{ optional($this->job)->discussion_salary == 'true' ? 'checked' : '' }} name="discussion_salary"--}}
{{--                                       class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2--}}
{{--                                       dark:border-white bg-gray-100 dark:bg-gray-700">--}}
{{--                                <label for="discuss"--}}
{{--                                       class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ __('company.discussion_available') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{-- Application Requirements--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.application_requirements') }}</p>--}}
{{--                        --}}{{-- Gender--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.gender') }}</label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                @foreach(getCodeList('gender') as $gender)--}}
{{--                                    <div class="flex items-center">--}}
{{--                                        <input disabled id="gender-{{$gender->code_id}}" type="radio" value="{{$gender->code_id}}" {{ optional($this->job)->gender == $gender->code_id ? 'checked': '' }} name="gender"--}}
{{--                                               class="w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700--}}
{{--                                           dark:border-white bg-gray-100">--}}
{{--                                        <label for="gender-{{$gender->code_id}}" class="ms-2 text-xs text-[#464559] dark:text-white">{{ $gender->code_name }}</label>--}}
{{--                                    </div>--}}
{{--                                @endforeach--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        --}}{{-- Age limitation--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.age_limitation') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <div class="w-full">--}}
{{--                                    <input type="number" min="18" id=""--}}
{{--                                           name="min_age"--}}
{{--                                           disabled--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                       dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-100"--}}
{{--                                           value="{{ optional($this->job)->min_age }}" />--}}
{{--                                </div>--}}
{{--                                <div class="w-full">--}}
{{--                                    <input type="number" min="18" id=""--}}
{{--                                           name="max_age"--}}
{{--                                           disabled--}}
{{--                                           class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                       dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-100"--}}
{{--                                           value="{{ optional($this->job)->max_age }}" />--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input type="hidden" name="not_limit_age" value="false">--}}
{{--                                <input id="notage" disabled type="checkbox" value="true" {{ optional($this->job)->not_limit_age == 'true' ? 'checked' : '' }} name="not_limit_age" class="rounded-full w-4 h-4--}}
{{--                                text-blue-600--}}
{{--                                border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white bg-gray-100">--}}
{{--                                <label for="notage" class="ms-2 text-xs text-[#464559] dark:text-white">{{ __('company.not_limitation') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        --}}{{-- Required work experience--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.required_work_experience') }} <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input type="text" id=""--}}
{{--                                       disabled--}}
{{--                                       name="min_work_experience"--}}
{{--                                       class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]--}}
{{--                                       dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 bg-gray-100"--}}
{{--                                       value="{{ optional($this->job)->min_work_experience }}" />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input type="hidden" name="not_limit_experience" value="false">--}}
{{--                                <input id="default-radio-1" disabled type="checkbox" value="true" {{ optional($this->job)->not_limit_experience == 'true' ? 'checked' : '' }} name="not_limit_experience"--}}
{{--                                       class="rounded-full w-4 h-4 text-blue-600  border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2--}}
{{--                                       dark:border-white bg-gray-100 dark:bg-gray-700">--}}
{{--                                <label for="default-radio-1"--}}
{{--                                       class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ __('company.not_limitation') }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        --}}{{-- Required skills--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.required_skills') }}</label>--}}
{{--                            <textarea id="required_skills" rows="4"--}}
{{--                                      name="required_skills"--}}
{{--                                      class="block p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 bg-gray-100 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white"--}}
{{--                                      placeholder="" disabled readonly>{{ $this->job->required_skills }}</textarea>--}}
{{--                        </div>--}}
{{--                        --}}{{-- Application deadline--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.application_deadline') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                --}}{{-- Start date--}}
{{--                                <div class="w-1/2 flex flex-row items-center rounded-lg border border-[#EDEDED] text-[#201F36] bg-gray-100 dark:bg-[#1E1E1E]--}}
{{--                                        dark:border-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                    <div class="p-2.5">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <span class="text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5">{{ optional($this->job)->application_starttime ? date('Y-m-d', strtotime(optional($this->job)->application_starttime)) : 'N/G' }}</span>--}}
{{--                                    </div>--}}

{{--                                </div>--}}
{{--                                --}}{{-- End date--}}
{{--                                <div class="w-1/2 flex flex-row items-center rounded-lg border border-[#EDEDED] text-[#201F36] bg-gray-100 dark:bg-[#1E1E1E]--}}
{{--        dark:border-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                    <div class="p-2.5">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <span class="text-sm  focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5">{{ optional($this->job)->application_endtime ? date('Y-m-d', strtotime(optional($this->job)->application_endtime)) : 'N/G' }}</span>--}}
{{--                                    </div>--}}

{{--                                </div>--}}

{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{-- Inquiries--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.inquiries') }}</p>--}}
{{--                        --}}{{-- Name--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.name')}}</label>--}}
{{--                            <input type="text" id=""--}}
{{--                                   disabled--}}
{{--                                   name="hr_name"--}}
{{--                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white--}}
{{--                                   dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                   value="{{ optional($this->job)->hr_name }}" />--}}
{{--                        </div>--}}
{{--                        --}}{{-- Email--}}
{{--                        <div class="">--}}
{{--                            <label for="email"--}}
{{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('company.email') }}</label>--}}
{{--                            <input type="email" id="email"--}}
{{--                                   disabled--}}
{{--                                   name="hr_email"--}}
{{--                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white--}}
{{--                                   dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                   value="{{ optional($this->job)->hr_email }}" />--}}
{{--                        </div>--}}
{{--                        --}}{{-- Contact info--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ __('company.contact_info') }}</label>--}}
{{--                            <input type="text" id=""--}}
{{--                                   disabled--}}
{{--                                   name="hr_contact_info"--}}
{{--                                   class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white--}}
{{--                                   dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:text-[#201F36] bg-gray-100"--}}
{{--                                   value="{{ optional($this->job)->hr_contact_info }}" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{-- Job Role--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ __('company.job_role') }}</p>--}}
{{--                        --}}{{-- Role--}}
{{--                        <div>--}}
{{--                            <label for="message"--}}
{{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('company.role') }}</label>--}}
{{--                            <textarea id="message" rows="4"--}}
{{--                                      name="roles"--}}
{{--                                      disabled--}}
{{--                                      class="block p-2.5 w-full text-sm text-gray-900 bg-gray-100 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E]--}}
{{--                                      dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white">{{ optional($this->job)->roles }}</textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    --}}{{-- Attach file--}}
{{--                    <div>--}}
{{--                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">{{ __('company.attach_file') }}</label>--}}
{{--                        <div id="attachments-list" class="mb-3">--}}
{{--                            <div id="attachments-list">--}}
{{--                                <div class="attachment-item mt-4 flex flex-wrap gap-4">--}}
{{--                                    @foreach($this->job->attachments as $attachment)--}}
{{--                                        <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px;--}}
{{--                                        display: flex;--}}
{{--                                        padding: 6px;--}}
{{--                                        align-items: center;--}}
{{--                                        gap: 6px;">--}}
{{--                                            {{ $attachment }}--}}
{{--                                            <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $this->job->id, 'filename' => $attachment]) }}" type="button" class="btn btn-danger btn-sm delete-attachment align-content-center" >--}}
{{--                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                                </svg>--}}
{{--                                            </a>--}}
{{--                                        </span>--}}
{{--                                    @endforeach--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
                {{--                <form class="flex flex-col gap-6">--}}

                {{--                    <div>--}}
                {{--                        <label for=""--}}
                {{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.job_type') }}--}}
                {{--                            <span class="text-red-700">*</span></label>--}}
                {{--                        <div class="flex gap-4 justify-between">--}}
                {{--                            <div class="w-1/2 flex gap-4">--}}
                {{--                                @foreach(getCodeList('job_type', $this->job->job_type) as $this->job_type)--}}
                {{--                                    <div class="flex items-center">--}}
                {{--                                        <input disabled id="" type="radio"--}}
                {{--                                               {{ $this->job->job_type == $this->job_type->code_id ? 'checked' : '' }}--}}
                {{--                                               value="" name="job_type"--}}
                {{--                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                        <label for="" style=" margin-left: 5px;"--}}
                {{--                                               class="ms-2 text-xs text-[#464559] dark:text-white">{{$this->job_type->code_name}}</label>--}}
                {{--                                    </div>--}}
                {{--                                @endforeach--}}
                {{--                            </div>--}}
                {{--                            <div class="w-1/2 flex gap-4">--}}
                {{--                                @foreach(getCodeList('job_location', $this->job->job_location) as $this->job_location)--}}
                {{--                                    <div class="flex items-center">--}}
                {{--                                        <input disabled id="" type="radio"--}}
                {{--                                               {{ $this->job->job_location == $this->job_location->code_id ? 'checked' : '' }}--}}
                {{--                                               value="" name="job_location"--}}
                {{--                                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                        <label for="" style=" margin-left: 5px;"--}}
                {{--                                               class="ms-2 text-xs text-[#464559] dark:text-white">{{$this->job_location->code_name}}</label>--}}
                {{--                                    </div>--}}
                {{--                                @endforeach--}}
                {{--                            </div>--}}

                {{--                    </div>--}}

                {{--                    <div>--}}
                {{--                        <label for=""--}}
                {{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.sector') }}--}}
                {{--                            <span class="text-red-700">*</span></label>--}}
                {{--                        <div class="flex  gap-6">--}}
                {{--                            <div class="w-1/2">--}}
                {{--                                <select id="countries" disabled--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium font-medium opacity-100 cursor-not-allowed">--}}
                {{--                                    @foreach ($this->getSectors() as $sector)--}}
                {{--                                        <option value="{{ $sector->id }}"--}}
                {{--                                            {{ $sector->id == $this->job->sector_id ? 'selected' : '' }}>--}}
                {{--                                            {{ $sector->name }}--}}
                {{--                                        </option>--}}
                {{--                                    @endforeach--}}
                {{--                                </select>--}}
                {{--                            </div>--}}
                {{--                            <div class="w-1/2">--}}
                {{--                                <select id="countries" disabled--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium font-medium opacity-100 cursor-not-allowed">--}}
                {{--                                    @foreach ($this->getDistricts() as $district)--}}
                {{--                                        <option value="{{ $district->id }}"--}}
                {{--                                            {{ $district->id == $this->job->company->district ? 'selected' : '' }}>--}}
                {{--                                            {{ $district->name }}--}}
                {{--                                        </option>--}}
                {{--                                    @endforeach--}}
                {{--                                </select>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}
                {{--                    </div>--}}

                {{--                    <div class="flex flex-col gap-6">--}}
                {{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
                {{--                            {{ trans('cgo.job_support.job_list.job_detail.work_condition.root') }}</p>--}}
                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.working_day') }}</label>--}}
                {{--                            <div class="flex gap-6">--}}
                {{--                                <div class="w-1/2">--}}
                {{--                                    <input readonly type="text" id=""--}}
                {{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                        value="{{ convertDays($this->job->working_day) }}" readonly />--}}
                {{--                                </div>--}}
                {{--                                <div class="w-1/2">--}}
                {{--                                    <div class="relative">--}}
                {{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
                {{--                                            value="{{ \Carbon\Carbon::parse($this->job->application_endtime)->format('Y M d') }}"--}}
                {{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
                {{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.work_condition.select_date') }}"--}}
                {{--                                            name="working_date">--}}
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

                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.working_hour') }}</label>--}}
                {{--                            <div class="flex gap-6">--}}
                {{--                                <div class="w-1/2">--}}
                {{--                                    <input readonly type="time" id="start_time"--}}
                {{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                        min="09:00" max="18:00" value="{{ $this->job->start_time }}"--}}
                {{--                                        name="start_time" />--}}
                {{--                                </div>--}}
                {{--                                <div class="w-1/2">--}}
                {{--                                    <input readonly type="time" id="end_time"--}}
                {{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                        min="09:00" max="18:00" value="{{ $this->job->end_time }}"--}}
                {{--                                        name="end_time" />--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}

                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.salary_per_month') }}</label>--}}
                {{--                            <div class="flex gap-6 mb-2">--}}
                {{--                                <input readonly type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    value="${{ $this->job->min_salary }}" readonly />--}}
                {{--                                <input readonly type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    placeholder="" value="${{ $this->job->max_salary }}" readonly />--}}
                {{--                            </div>--}}
                {{--                            <div class="flex items-center">--}}
                {{--                                <input disabled id="discuss" type="radio" value="" name="default-radio"--}}
                {{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
                {{--                                <label for="discuss" style=" margin-left: 5px;"--}}
                {{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.discussion_available') }}</label>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}

                {{--                    </div>--}}

                {{--                    <div class="flex flex-col gap-6">--}}
                {{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
                {{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.root') }}</p>--}}
                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.root') }}</label>--}}
                {{--                            <div class="flex gap-4">--}}
                {{--                                <div class="flex items-center">--}}
                {{--                                    <input disabled id="male" type="radio" value="" name="gender"--}}
                {{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                    <label for="male"--}}
                {{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.male') }}</label>--}}
                {{--                                </div>--}}
                {{--                                <div class="flex items-center">--}}
                {{--                                    <input disabled id="female" type="radio" value="" name="gender"--}}
                {{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                    <label for="female"--}}
                {{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.female') }}</label>--}}
                {{--                                </div>--}}
                {{--                                <div class="flex items-center">--}}
                {{--                                    <input disabled id="na" type="radio" value="" name="gender"--}}
                {{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                    <label for="na"--}}
                {{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.na') }}</label>--}}
                {{--                                </div>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}

                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.age_limitation') }}</label>--}}
                {{--                            <div class="flex gap-6 mb-2">--}}
                {{--                                <input readonly type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    value="{{ $this->job->min_age }}" readonly />--}}
                {{--                                <input type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    placeholder="" value="{{ $this->job->max_age }}" readonly />--}}
                {{--                            </div>--}}
                {{--                            <div class="flex items-center">--}}
                {{--                                <input disabled id="notage" type="radio" value="" name="age"--}}
                {{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
                {{--                                <label for="notage" style=" margin-left: 5px;"--}}
                {{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.not_limitation') }}</label>--}}
                {{--                            </div>--}}

                {{--                        </div>--}}

                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.required_work_experience') }}<span--}}
                {{--                                    class="text-red-700">*</span></label>--}}
                {{--                            <div class="flex gap-6 mb-2">--}}
                {{--                                <input readonly type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    value="{{ $this->job->min_work_experience }}" readonly />--}}
                {{--                                <input readonly type="text" id=""--}}
                {{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                    placeholder="" value="{{ $this->job->max_work_experience }}" readonly />--}}
                {{--                            </div>--}}
                {{--                            <div class="flex items-center">--}}
                {{--                                <input disabled id="default-radio-1" type="radio" value=""--}}
                {{--                                    name="default-radio"--}}
                {{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
                {{--                                <label for="default-radio-1" style=" margin-left: 5px;"--}}
                {{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.not_limitation') }}</label>--}}
                {{--                            </div>--}}
                {{--                        </div>--}}

                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.required_skills') }}</label>--}}
                {{--                            <input readonly type="text" id=""--}}
                {{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                placeholder="{{ $this->job->required_skills }}" readonly />--}}
                {{--                        </div>--}}
                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.root') }}</label>--}}
                {{--                            <div class="flex gap-6">--}}
                {{--                                <div class="w-1/2">--}}
                {{--                                    <div class="relative">--}}
                {{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
                {{--                                            value="{{ \Carbon\Carbon::parse($this->job->application_starttime)->format('Y M d') }}"--}}
                {{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
                {{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.select_date') }}"--}}
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
                {{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
                {{--                                            value="{{ \Carbon\Carbon::parse($this->job->application_endtime)->format('Y M d') }}"--}}
                {{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
                {{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.select_date') }}"--}}
                {{--                                            name="application_endtime">--}}
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
                {{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
                {{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.root') }}--}}
                {{--                        </p>--}}
                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.name') }}</label>--}}
                {{--                            <input readonly type="text" id=""--}}
                {{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                placeholder="" readonly value="{{ $this->job->hr_name }}" />--}}
                {{--                        </div>--}}
                {{--                        <div class="">--}}
                {{--                            <label for="email"--}}
                {{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.email') }}</label>--}}
                {{--                            <input readonly type="email" id="email"--}}
                {{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                value="{{ $this->job->hr_email }}" readonly />--}}
                {{--                        </div>--}}
                {{--                        <div>--}}
                {{--                            <label for=""--}}
                {{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.contact_info') }}</label>--}}
                {{--                            <input readonly type="text" id=""--}}
                {{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
                {{--                                value="{{ $this->job->hr_contact_info }}" readonly />--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                    <div class="flex flex-col gap-6">--}}
                {{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
                {{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.about_the_role') }}--}}
                {{--                        </p>--}}
                {{--                        <div>--}}

                {{--                            <label for="message"--}}
                {{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.role') }}</label>--}}
                {{--                            <textarea readonly id="message" rows="4"--}}
                {{--                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white font-medium"--}}
                {{--                                placeholder="" readonly>{{ $this->job->roles }}</textarea>--}}
                {{--                        </div>--}}
                {{--                    </div>--}}
                {{--                </form>--}}

            </div>
{{--            <div class="flex flex-col gap-4">--}}

{{--                <form class="flex flex-col gap-6">--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.job_type') }}--}}
{{--                            <span class="text-red-700">*</span></label>--}}
{{--                        <div class="flex gap-4">--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="formal" type="radio"--}}
{{--                                    {{ $job->job_type == trans('cgo.job_support.job_list.job_detail.contract_type.permanent') ? 'checked' : '' }}--}}
{{--                                    value="" name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="formal" style=" margin-left: 5px;"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.contract_type.permanent') }}</label>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="contract-base"--}}
{{--                                    {{ $job->job_type == trans('cgo.job_support.job_list.job_detail.contract_type.contract_base') ? 'checked' : '' }}--}}
{{--                                    type="radio" value="" name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="contract-base" style=" margin-left: 5px;"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.contract_type.contract_base') }}--}}
{{--                                </label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.sector') }}--}}
{{--                            <span class="text-red-700">*</span></label>--}}
{{--                        <div class="flex gap-6">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <select id="countries" disabled--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                    @foreach ($this->getSectors() as $sector)--}}
{{--                                        <option value="{{ $sector->id }}"--}}
{{--                                            {{ $sector->id == $job->sector_id ? 'selected' : '' }}>--}}
{{--                                            {{ $sector->name }}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <select id="countries" disabled--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                    @foreach ($this->getDistricts() as $district)--}}
{{--                                        <option value="{{ $district->id }}"--}}
{{--                                            {{ $district->id == $job->company->district ? 'selected' : '' }}>--}}
{{--                                            {{ $district->name }}</option>--}}
{{--                                    @endforeach--}}
{{--                                </select>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                            {{ trans('cgo.job_support.job_list.job_detail.work_condition.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.working_day') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="text" id=""--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        value="{{ convertDays($job->working_day) }}" readonly />--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
{{--                                            value="{{ \Carbon\Carbon::parse($job->application_endtime)->format('Y M d') }}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.work_condition.select_date') }}"--}}
{{--                                            name="working_date">--}}
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

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.working_hour') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="time" id="start_time"--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        min="09:00" max="18:00" value="{{ $job->start_time }}"--}}
{{--                                        name="start_time" />--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <input readonly type="time" id="end_time"--}}
{{--                                        class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                        min="09:00" max="18:00" value="{{ $job->end_time }}"--}}
{{--                                        name="end_time" />--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.work_condition.salary_per_month') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="${{ $job->min_salary }}" readonly />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="${{ $job->max_salary }}" readonly />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="discuss" type="radio" value="" name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="discuss" style=" margin-left: 5px;"--}}
{{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.discussion_available') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.root') }}</label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="male" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="male"--}}
{{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.male') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="female" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="female"--}}
{{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.female') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="na" type="radio" value="" name="gender"--}}
{{--                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="na"--}}
{{--                                        class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.gender.na') }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.age_limitation') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $job->min_age }}" readonly />--}}
{{--                                <input type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $job->max_age }}" readonly />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="notage" type="radio" value="" name="age"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="notage" style=" margin-left: 5px;"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.required_work_experience') }}<span--}}
{{--                                    class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $job->min_work_experience }}" readonly />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    placeholder="" value="{{ $job->max_work_experience }}" readonly />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="default-radio-1" type="radio" value=""--}}
{{--                                    name="default-radio"--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="default-radio-1" style=" margin-left: 5px;"--}}
{{--                                    class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.required_skills') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="{{ $job->required_skills }}" readonly />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.root') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
{{--                                            value="{{ \Carbon\Carbon::parse($job->application_starttime)->format('Y M d') }}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.select_date') }}"--}}
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
{{--                                        <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
{{--                                            value="{{ \Carbon\Carbon::parse($job->application_endtime)->format('Y M d') }}"--}}
{{--                                            class="border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                            placeholder="{{ trans('cgo.job_support.job_list.job_detail.application_requirements.application_deadline.select_date') }}"--}}
{{--                                            name="application_endtime">--}}
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
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.root') }}--}}
{{--                        </p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.name') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" readonly value="{{ $job->hr_name }}" />--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <label for="email"--}}
{{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.email') }}</label>--}}
{{--                            <input readonly type="email" id="email"--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $job->hr_email }}" readonly />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.contact_info') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $job->hr_contact_info }}" readonly />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                            {{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.about_the_role') }}--}}
{{--                        </p>--}}
{{--                        <div>--}}

{{--                            <label for="message"--}}
{{--                                class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.job_list.job_detail.application_requirements.hr_information.role') }}</label>--}}
{{--                            <textarea readonly id="message" rows="4"--}}
{{--                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white font-medium"--}}
{{--                                placeholder="" readonly>{{ $job->roles }}</textarea>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}

{{--            </div>--}}
        </div>
    </div>
    <div>
        <div class="flex flex-col gap-6 p-4 ">
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
</div>
