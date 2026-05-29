<div class="my-6 flex flex-col gap-5">
    <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
        <div class="flex flex-col gap-4">
            <form class="flex flex-col gap-6">
{{--                <p class="text-xl text-[#464559] dark:text-white font-semibold">OJT details</p>--}}
                <x-breadcrumb :items="[
                    ['label' => 'Admin', 'url' => '/admin/overview'],
                    ['label' => 'Job support', 'url' => '#'],
                    ['label' => 'OJT list', 'url' => '/admin/o-j-t-s'],
                    ['label' => 'OJT details', 'url' => '#'],
                ]" />
                <x-o-j-t-details :ojt="$ojt" />
{{--                <div>--}}
{{--                    <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Title</label>--}}
{{--                    <input type="text" id=""--}}
{{--                           class="bg-[#F5F7FA] border border-[#EDEDED] bg-[#F5F7FA] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                           value="{{ $ojt->title }}" readonly required disabled />--}}
{{--                </div>--}}
{{--                <div class="flex justify-between gap-6">--}}
{{--                    <div class="w-full md:w-1/3">--}}
{{--                        <label for="company_id"--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Company name<span class="text-red-700">*</span></label>--}}
{{--                        <select name="company_id" id="company_id"--}}
{{--                                class=" bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 font-semibold" required disabled readonly="">--}}
{{--                            @foreach ($this->companyList as $company)--}}
{{--                                <option value="{{ $company->id }}"--}}
{{--                                    {{ $ojt->company_id == $company->id ? 'selected' : '' }}>--}}
{{--                                    {{ $company->name }} - {{ ucwords(str_replace('_', ' ', $company->office_type)) }}</option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
{{--                        @if ($errors->has('company_id'))--}}
{{--                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('company_id') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="w-full md:w-1/3">--}}
{{--                        <label for="period"--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('company.job_support.ojt_list.training_period')}}<span class="text-red-700">*</span></label>--}}
{{--                        <input type="text" id="period" name="period" value="{{$ojt->period}}"--}}
{{--                               class="bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 6 months" required readonly disabled />--}}
{{--                        @if ($errors->has('period'))--}}
{{--                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('period') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}
{{--                    <div class="w-full md:w-1/3">--}}
{{--                        <label for="period"--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Number of Recruitments<span class="text-red-700">*</span></label>--}}
{{--                        <input type="number" min="1" id="number_of_recruitments" name="number_of_recruitments" value="{{$ojt->number_of_recruitments}}"--}}
{{--                               class="bg-[#F5F7FA] border border-gray-300 text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 " placeholder="eg: 100" required readonly disabled />--}}
{{--                        @if ($errors->has('number_of_recruitments'))--}}
{{--                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('number_of_recruitments') }}</span>--}}
{{--                        @endif--}}
{{--                    </div>--}}

{{--                </div>--}}


{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">Application Requirements</p>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Gender</label>--}}
{{--                        <div class="flex gap-4">--}}
{{--                            @foreach(getCodeList('gender') as $gender)--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="" type="radio" value="{{$gender->code_id}}" name="gender"--}}
{{--                                           {{ $ojt->gender == $gender->code_id ? 'checked' : '' }}--}}
{{--                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="" class="ms-2 text-xs text-[#464559] dark:text-white">{{$gender->code_name}}</label>--}}
{{--                                </div>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Age--}}
{{--                            limitation</label>--}}
{{--                        <div class="flex gap-6 mb-2">--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   value="{{ $ojt->min_age }}" disabled />--}}
{{--                            <input type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   placeholder="" value="{{ $ojt->max_age }}" readonly disabled />--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input id="age_limitation" disabled type="checkbox" {{$ojt->age_limitation ? 'checked' : ''}} value="1" name="age_limitation"--}}
{{--                                   class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                            <label for="age_limitation" class="ms-2 text-xs text-[#464559] dark:text-white">--}}
{{--                                {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Required work--}}
{{--                            experience <span class="text-red-700">*</span></label>--}}
{{--                        <div class="flex gap-6 mb-2">--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   value="{{ $ojt->min_work_experience }}" disabled />--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   placeholder="" value="{{ $ojt->max_work_experience }}" disabled />--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input id="not_limitation_work_experience" disabled type="checkbox" {{$ojt->work_experience_limitation ? 'checked' : ''}} value="1" name="work_experience_limitation"--}}
{{--                                   class="rounded-full w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                            <label for="not_limitation_work_experience" class="ms-2 text-xs text-[#464559] dark:text-white">--}}
{{--                                {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                            </label>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Required--}}
{{--                            skills</label>--}}
{{--                        <input name="required_skills" id="required_skills" value="{{$ojt->required_skills}}" class="bg-[#F5F7FA] border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Require skills" readonly disabled>--}}

{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Application--}}
{{--                            deadline</label>--}}
{{--                        <div class="flex gap-6">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <div class="relative">--}}
{{--                                    <div--}}
{{--                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                        <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                             fill="none" viewBox="0 0 24 24">--}}
{{--                                            <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                  stroke-linejoin="round" stroke-width="2"--}}
{{--                                                  d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <input disabled datepicker datepicker-autoselect-today--}}
{{--                                           datepicker-format="yyyy-mm-dd"--}}
{{--                                           value="{{  $ojt->application_starttime ? \Carbon\Carbon::parse($ojt->application_starttime)->format('Y-m-d') : '' }}"--}}
{{--                                           datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"--}}
{{--                                           type="text" name="application_starttime" id="application_starttime"--}}
{{--                                           class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <div class="relative">--}}
{{--                                    <div--}}
{{--                                        class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                        <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                             xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                             fill="none" viewBox="0 0 24 24">--}}
{{--                                            <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                  stroke-linejoin="round" stroke-width="2"--}}
{{--                                                  d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                    <input disabled datepicker datepicker-autoselect-today--}}
{{--                                           datepicker-format="yyyy-mm-dd"--}}
{{--                                           value="{{$ojt->application_endtime ? \Carbon\Carbon::parse($ojt->application_endtime)->format('Y-m-d') : ''}}"--}}
{{--                                           datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}"--}}
{{--                                           type="text" name="application_endtime" id="application_endtime"--}}
{{--                                           class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">Inquiries</p>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Name</label>--}}
{{--                        <input readonly type="text" id=""--}}
{{--                               class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                               placeholder="" disabled value="{{ $ojt->hr_name }}" />--}}
{{--                    </div>--}}
{{--                    <div class="">--}}
{{--                        <label for="email"--}}
{{--                               class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>--}}
{{--                        <input readonly type="email" id="email"--}}
{{--                               class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                               value="{{ $ojt->hr_email }}" disabled />--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                               class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Contact info</label>--}}
{{--                        <input readonly type="text" id=""--}}
{{--                               class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                               value="{{ $ojt->hr_contact_info }}" disabled />--}}
{{--                    </div>--}}
{{--                </div>--}}
            </form>

        </div>
{{--        <div class="flex flex-col gap-4">--}}
{{--            <form class="flex flex-col gap-6">--}}
{{--                <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                    {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.pageTitle') }}</p>--}}
{{--                <div>--}}
{{--                    <label for=""--}}
{{--                        class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.title') }}--}}
{{--                        <span class="text-red-700">*</span></label>--}}
{{--                    <input type="text" id=""--}}
{{--                        class="border border-[#EDEDED] bg-[#F5F7FA] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                        value="{{ $ojt->title }}" readonly required />--}}
{{--                </div>--}}


{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                        {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.work_condition.root') }}</p>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.work_condition.working_day') }}</label>--}}
{{--                        <div class="flex gap-6">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                    class="border border-[#EDEDED] text-[#201F36] bg-[#F5F7FA] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    value="{{ $ojt->working_day }}" readonly />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <div class="relative">--}}
{{--                                    <input disabled datepicker datepicker-format="yyyy-dd-mm" type="text"--}}
{{--                                        value="{{ \Carbon\Carbon::parse($ojt->application_endtime)->format('Y M d') }}"--}}
{{--                                        class="border border-gray-300 bg-[#F5F7FA] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                        placeholder="Select date" name="working_date">--}}
{{--                                    <div--}}
{{--                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.work_condition.working_hour') }}</label>--}}
{{--                        <div class="flex gap-6">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <input readonly type="time" id="start_time"--}}
{{--                                    class="border  bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    min="09:00" max="18:00" value="{{ $ojt->start_time }}" name="start_time" />--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <input readonly type="time" id="end_time"--}}
{{--                                    class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                    min="09:00" max="18:00" value="{{ $ojt->end_time }}" name="end_time" />--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.work_condition.salary_per_month') }}</label>--}}
{{--                        <div class="flex gap-6 mb-2">--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="${{ $ojt->min_salary }}" readonly />--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" value="${{ $ojt->max_salary }}" readonly />--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input disabled id="discuss" type="radio"--}}
{{--                                {{ $ojt->discussion_available ? 'checked' : '' }} name="default-radio"--}}
{{--                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                            <label for="discuss"--}}
{{--                                class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.discussion_available') }}</label>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                </div>--}}

{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                        {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.root') }}--}}
{{--                    </p>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.gender.root') }}</label>--}}
{{--                        <div class="flex gap-4">--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="male" type="radio" value="" name="gender"--}}
{{--                                    {{ $ojt->gender == 1 ? 'checked' : '' }}--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="male"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.gender.male') }}</label>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="female" type="radio" value="" name="gender"--}}
{{--                                    {{ $ojt->gender == 0 ? 'checked' : '' }}--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="female"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.gender.female') }}</label>--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="na" type="radio" value="" name="gender"--}}
{{--                                    {{ $ojt->gender == 2 ? 'checked' : '' }}--}}
{{--                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="na"--}}
{{--                                    class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.gender.na') }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.age_limitation') }}</label>--}}
{{--                        <div class="flex gap-6 mb-2">--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $ojt->min_age }}" readonly />--}}
{{--                            <input type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" value="{{ $ojt->max_age }}" readonly />--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input disabled id="notage" type="radio" value="" name="age"--}}
{{--                                {{ $ojt->age_limitation ? 'checked' : '' }}--}}
{{--                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                            <label for="notage"--}}
{{--                                class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.not_limitation') }}</label>--}}
{{--                        </div>--}}

{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.required_work_experience') }}<span--}}
{{--                                class="text-red-700">*</span></label>--}}
{{--                        <div class="flex gap-6 mb-2">--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                value="{{ $ojt->min_work_experience }}" readonly />--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                placeholder="" value="{{ $ojt->max_work_experience }}" readonly />--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <input disabled id="default-radio-1" type="radio" value="" name="default-radio"--}}
{{--                                {{ $ojt->work_experience_limitation ? 'checked' : '' }}--}}
{{--                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                            <label for="default-radio-1"--}}
{{--                                class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.not_limitation') }}</label>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.required_skills') }}</label>--}}
{{--                        <input readonly type="text" id=""--}}
{{--                            class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            placeholder="{{ $ojt->required_skills }}" readonly />--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.application_deadline.root') }}</label>--}}
{{--                        <div class="flex gap-6">--}}
{{--                            <div class="w-1/2">--}}
{{--                                <div class="relative">--}}
{{--                                    <input disabled datepicker type="text" datepicker-format="yyyy-mm-dd"--}}
{{--                                        value="{{ \Carbon\Carbon::parse($ojt->application_starttime)->format('Y M d') }}"--}}
{{--                                        class="border bg-[#F5F7FA] border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                        placeholder="{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.application_deadline.select_date') }}"--}}
{{--                                        name="application_starttime">--}}
{{--                                    <div--}}
{{--                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"--}}
{{--                                            viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="w-1/2">--}}
{{--                                <div class="relative">--}}
{{--                                    <input disabled datepicker datepicker-format="yyyy-mm-dd" type="text"--}}
{{--                                        value="{{ \Carbon\Carbon::parse($ojt->application_endtime)->format('Y M d') }}"--}}
{{--                                        class="border bg-[#F5F7FA] border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-[#201F36] font-medium placeholder-font-medium"--}}
{{--                                        placeholder="{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_deadline.select_date') }}"--}}
{{--                                        name="application_endtime">--}}
{{--                                    <div--}}
{{--                                        class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium">--}}
{{--                                        <svg class="w-4 h-4 text-[#201F36] dark:text-gray-400" aria-hidden="true"--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="currentColor"--}}
{{--                                            viewBox="0 0 20 20">--}}
{{--                                            <path--}}
{{--                                                d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />--}}
{{--                                        </svg>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                        {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.root') }}--}}
{{--                    </p>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.name') }}</label>--}}
{{--                        <input readonly type="text" id=""--}}
{{--                            class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            placeholder="" readonly value="{{ $ojt->hr_name }}" />--}}
{{--                    </div>--}}
{{--                    <div class="">--}}
{{--                        <label for="email"--}}
{{--                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.email') }}</label>--}}
{{--                        <input readonly type="email" id="email"--}}
{{--                            class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            value="{{ $ojt->hr_email }}" readonly />--}}
{{--                    </div>--}}
{{--                    <div>--}}
{{--                        <label for=""--}}
{{--                            class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.contact_info') }}</label>--}}
{{--                        <input readonly type="text" id=""--}}
{{--                            class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                            value="{{ $ojt->hr_contact_info }}" readonly />--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="flex flex-col gap-6">--}}
{{--                    <p class="text-xl text-[#464559] dark:text-white font-semibold">--}}
{{--                        {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.job_role') }}--}}
{{--                    </p>--}}
{{--                    <div>--}}

{{--                        <label for="message"--}}
{{--                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.application_requirements.hr_information.role') }}</label>--}}
{{--                        <textarea readonly id="message" rows="4"--}}
{{--                            class="block bg-[#F5F7FA] p-2.5 w-full text-sm text-gray-900 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-white font-medium"--}}
{{--                            placeholder="" readonly>{{ $ojt->roles }}</textarea>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                @if ($ojt->attachFiles() !== null)--}}
{{--                    <div>--}}
{{--                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">--}}
{{--                            {{ trans('cgo.job_support.trainee_list.ojt_match.ojt_detail.attached_file') }}</label>--}}
{{--                        <div class="flex gap-2">--}}
{{--                            @foreach ($ojt->attachFiles as $attachment)--}}
{{--                                <a href="{{ route('company.job-support.ojt-list.ojt-detail.download', ['id' => $attachment->id]) }}"--}}
{{--                                    class="inline-flex w-fit items-center text-xs leading-4 justify-center font-medium px-4 py-2.5 text-[#706F81] rounded-md cursor-pointer bg-[#F5F7FA]">--}}
{{--                                    {{ $attachment->file_name }} <svg xmlns="http://www.w3.org/2000/svg"--}}
{{--                                        class="ms-2" width="13" height="12" viewBox="0 0 13 12"--}}
{{--                                        fill="none">--}}
{{--                                        <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5"--}}
{{--                                            stroke="#706F81" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                            stroke-linejoin="round" />--}}
{{--                                    </svg>--}}

{{--                                </a>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            </form>--}}
{{--        </div>--}}
    </div>
</div>
