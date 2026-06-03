@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.root') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.job_support.job_list.root'), 'url' => route('cgo.job-support.job-list.list')],
                ['label' => \Str::limit($jobDetail->title, 30), 'url' => route('cgo.job-support.job-list.list')]
            ]" />
        </div>

        <div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg shadow-md">
            <!-- Back Button -->
            <div class="flex items-center mb-4 pt-6 px-6">
                <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_details')}}</p>
            </div>
            <x-job-details :job="$jobDetail" />
{{--            <!-- Job Details Header -->--}}
{{--            <div class="flex items-center gap-6">--}}
{{--                @if ($jobDetail->company->logo)--}}
{{--                <img  class="w-16 h-16 rounded-full" src="{{ asset($jobDetail->company->logo) }}"--}}
{{--                    alt="{{ $jobDetail->company->name }}">--}}
{{--            @else--}}
{{--                <img  class="w-16 h-16 rounded-full" src="{{ asset('uploads/logo_default.png') }}"--}}
{{--                    alt="{{ $jobDetail->company->name }}">--}}
{{--            @endif--}}
{{--                <div class="flex-1">--}}
{{--                    <h2 class="text-xl font-bold">{{ optional($jobDetail)->title }}</h2>--}}
{{--                    <p class="text-sm text-gray-500">Posted on {{ optional($jobDetail)->created_at }}  by {{$jobDetail->companyRecruiter->fullName}}</p>--}}
{{--                </div>--}}
{{--                --}}{{-- <div class="ml-auto">--}}
{{--                    <button onclick="handleKeepTrainee(this)" id="keep-trainee" data-job-id="{{ $jobDetail->id }}" title="Bookmark job"--}}
{{--                        data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}" type="button">--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 15 18"--}}
{{--                         class="{{ $jobDetail->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6 md:size-7 lg:size-8"--}}
{{--                         fill="none">--}}
{{--                        <path--}}
{{--                            d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"--}}
{{--                            stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                    </svg>--}}
{{--                </button>--}}
{{--                </div> --}}
{{--            </div>--}}
{{--        --}}
{{--            <!-- Job Information -->--}}
{{--            <div class="mt-6 text-sm text-gray-700">--}}
{{--                <div class="grid grid-cols-2 gap-x-12 gap-y-4">--}}
{{--                    <p class="font-semibold">Company Name:</p>--}}
{{--                    <p>{{$jobDetail->company->name}}</p>--}}
{{--        --}}
{{--                    <p class="font-semibold">Job Type:</p>--}}
{{--                    <p>{{{getCodeNameByCodeId('job_type', $jobDetail->job_type)}}}</p>--}}
{{--    --}}
{{--                    <p class="font-semibold">Job location:</p>--}}
{{--                    <p>{{{getCodeNameByCodeId('job_location', $jobDetail->job_location)}}}</p>--}}
{{--                    --}}
{{--                    <p class="font-semibold">{{ __('company.occupation') }}:</p>--}}
{{--                    <p>{{$jobDetail->sector->name}}</p>--}}
{{--    --}}
{{--                    <p class="font-semibold">Number of Recruitments:</p>--}}
{{--                    <p>{{ $jobDetail->number_of_recruitments }}</p>--}}
{{--                    <p class="font-semibold">Working day:</p>--}}
{{--                    <p>--}}
{{--                        {{ convertDays($jobDetail->working_day) }}--}}
{{--                    </p>--}}
{{--    --}}
{{--                    <p class="font-semibold">Working hourse:</p>--}}
{{--                    <p>{{ optional($jobDetail)->start_date }}</p>--}}
{{--                @if (!empty($jobDetail->min_salary) || !empty($jobDetail->max_salary))--}}
{{--                    <p class="font-semibold">{{ __('company.salary_per_month') }}:</p>--}}
{{--                    <p>--}}
{{--                        {{ $jobDetail->salary_currency ?? '' }}--}}
{{--                        {{ $jobDetail->min_salary ?? '' }}--}}
{{--                        @if (!empty($jobDetail->min_salary) && !empty($jobDetail->max_salary))--}}
{{--                            – --}}
{{--                        @endif--}}
{{--                        {{ $jobDetail->max_salary ?? '' }}--}}
{{--                    </p>--}}
{{--                @endif--}}
{{--                --}}
{{--                    <p class="font-semibold">{{ __('company.gender') }}:</p>--}}
{{--                    <p> @foreach(getCodeList('gender') as $gender) --}}
{{--                            @if (optional($jobDetail)->gender == $gender->code_id )--}}
{{--                            {{ $gender->code_name }}--}}
{{--                            @endif--}}
{{--                        @endforeach</p>--}}
{{--                    @if (!empty($jobDetail->min_age) || !empty($jobDetail->max_age))--}}
{{--                        <p class="font-semibold">{{ __('company.age_limitation') }}:</p>--}}
{{--                        <p>--}}
{{--                            {{ optional($jobDetail)->min_age ?? '' }} --}}
{{--                            @if (!empty($jobDetail->min_age) && !empty($jobDetail->max_age))--}}
{{--                                - --}}
{{--                            @endif--}}
{{--                            {{ optional($jobDetail)->max_age ?? '' }}--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                    --}}
{{--                    <p class="font-semibold">{{ __('company.required_work_experience') }}:</p>--}}
{{--                    <p>{{ optional($jobDetail)->min_work_experience }}</p>--}}
{{--    --}}
{{--                @if (!empty($jobDetail->application_starttime) || !empty($jobDetail->application_endtime))--}}
{{--                    <p class="font-semibold">{{ __('company.application_deadline') }}:</p>--}}
{{--                    <p>--}}
{{--                        {{ optional($jobDetail)->application_starttime ?? '' }}--}}
{{--                        @if (!empty($jobDetail->application_starttime) && !empty($jobDetail->application_endtime))--}}
{{--                            {{ ' to ' }}--}}
{{--                        @endif--}}
{{--                        {{ optional($jobDetail)->application_endtime ?? '' }}--}}
{{--                    </p>--}}
{{--                @endif--}}
{{--                --}}
{{--                    <p class="font-semibold">{{ __('company.email') }}:</p>--}}
{{--                    <p>{{ optional($jobDetail)->hr_email }}</p>--}}
{{--                    <p class="font-semibold">{{ __('company.contact_info') }}:</p>--}}
{{--                    <p>{{ optional($jobDetail)->hr_contact_info }}</p>   --}}
{{--    --}}
{{--                </div>--}}
{{--            </div>--}}
{{--        --}}
{{--            <!-- About the Role -->--}}
{{--            <div class="mt-8">--}}
{{--                <h3 class="font-bold text-lg text-gray-900">About the Role</h3>--}}
{{--                <p class="mt-4 text-sm text-gray-700 leading-relaxed">--}}
{{--                    {{$jobDetail->role}}--}}
{{--                </p>--}}
{{--               --}}
{{--            </div>--}}
            {{-- <div>
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">{{ __('company.attach_file') }}</label>
                <div id="attachments-list" class="mb-3">
                    <div id="attachments-list">
                        <div class="attachment-item mt-4 flex flex-wrap gap-4">
                            @foreach($jobDetail->attachments as $attachment)
                                <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px;
                                        display: flex;
                                        padding: 6px;
                                        align-items: center;
                                        gap: 6px;">
                                            {{ $attachment }}
                                            <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $jobDetail->id, 'filename' => $attachment]) }}" type="button" class="btn btn-danger btn-sm delete-attachment align-content-center" >
                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </a>
                                        </span>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div> --}}

        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
@endpush
