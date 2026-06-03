@props(['ojt', 'trainee', 'hasApplied', 'hasApproved', 'hasEnough'])
<div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg p-2">
    <!-- Job Details Header -->
    <div class="flex items-center gap-6">
        @if ($ojt->company->logo)
            <img class="w-16 h-16 rounded-full" src="{{ asset($ojt->company->logo) }}" alt="{{ $ojt->company->name }}">
        @else
            <img class="w-16 h-16 rounded-full" src="{{ asset('uploads/logo_default.png') }}"
                alt="{{ $ojt->company->name }}">
        @endif
        <div class="flex-1">
            <h2 class="text-xl font-bold dark:text-white">{{ optional($ojt)->title }}</h2>
            <p class="text-sm text-gray-500 dark:text-white">Posted on {{ optional($ojt)->created_at }} by
                {{ optional($ojt->owner)->fullName }}</p>
        </div>
    </div>

    <!-- OJT Information -->
    <div class="mt-6 text-sm text-gray-700">
        <div class="grid grid-cols-2 gap-x-12 gap-y-4 break-words">
            <p class="font-semibold dark:text-white">{{ __('company.name') }}:</p>
            <p class="dark:text-white">{{ optional($ojt->company)->name }}</p>

            <p class="font-semibold dark:text-white">{{ trans('company.job_support.ojt_list.training_period') }}:</p>
            <p class="dark:text-white">{{ $ojt->period }}</p>

            {{--            <p class="font-semibold dark:text-white">{{trans('company.job_support.ojt_list.ojt_registration.application_requirements.number_of_recruitments')}}:</p> --}}
            {{--            <p class="dark:text-white">{{ $ojt->number_of_recruitments }}</p> --}}

            <p class="font-semibold dark:text-white">{{ __('company.gender') }}:</p>
            <p class="dark:text-white">
                @php
                    $genderValues = is_array(optional($ojt)->gender)
                        ? optional($ojt)->gender
                        : (is_string(optional($ojt)->gender)
                            ? json_decode(optional($ojt)->gender, true)
                            : (is_numeric(optional($ojt)->gender)
                                ? [(string) optional($ojt)->gender]
                                : []));
                    $genderNames = [];
                    foreach (getCodeList('gender') as $gender) {
                        if (in_array((string) $gender->code_id, $genderValues)) {
                            $genderNames[] = $gender->code_name;
                        }
                    }
                @endphp
                {{ implode(', ', $genderNames) }}
            </p>

{{--            <p class="font-semibold dark:text-white">{{ __('company.age_limitation') }}:</p>--}}
{{--            <p class="dark:text-white">--}}
{{--                {{ optional($ojt)->min_age ?? '' }}--}}
{{--                @if (!empty($ojt->min_age) && !empty($ojt->max_age))--}}
{{--                    ---}}
{{--                @endif--}}
{{--                {{ optional($ojt)->max_age ?? '' }}--}}
{{--                @if (optional($ojt)->age_limitation == true)--}}
{{--                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                @endif--}}
{{--            </p>--}}

            <p class="font-semibold dark:text-white">{{ __('company.required_work_experience') }}:</p>
            @if ($ojt->work_experience_limitation)
                <p class="dark:text-white">{{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}
                </p>
            @else
                <p>{{ optional($ojt)->min_work_experience }} @if (optional($ojt)->not_limit_experience == true)
                        {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}
                    @endif
                </p>
            @endif

            <p class="font-semibold dark:text-white">
                {{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.required_skills') }}:
            </p>
            <p class="dark:text-white">{{ optional($ojt)->required_skills }}</p>



            <p class="font-semibold dark:text-white">
                {{ trans('company.Application period') }}</p>
            <p class="dark:text-white">
                @if(optional($ojt)->application_starttime)
                    {{ \Carbon\Carbon::parse($ojt->application_starttime)->format('Y-m-d') }}
                    @if(optional($ojt)->application_endtime)
                        - {{ \Carbon\Carbon::parse($ojt->application_endtime)->format('Y-m-d') }}
                    @endif
                @endif
            </p>

            {{--            <p class="font-semibold dark:text-white">{{ __('company.job_role') }}:</p> --}}
            {{--            <p class="dark:text-white">{{ optional($ojt)->roles }}</p> --}}

            {{--            <p class="font-semibold dark:text-white">{{ __('company.email') }}:</p> --}}
            {{--            <p class="dark:text-white">{{ optional($ojt)->hr_email }}</p> --}}

            {{--            <p class="font-semibold dark:text-white">{{ __('company.contact_info') }}:</p> --}}
            {{--            <p class="dark:text-white">{{ optional($ojt)->hr_contact_info }}</p> --}}
        </div>
    </div>
    <div class="mt-8 grid grid-cols-2 gap-x-12 gap-y-4 items-center">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">
            {{ trans('company.job_support.ojt_list.table.label.number_of_recruitment') }}</h3>
        <p class="mt-2 text-lg font-bold text-gray-700 leading-relaxed dark:text-white">
            {{ $ojt->number_of_recruitments }}
        </p>
        @if(auth('admin')->check())
        <p class="font-semibold dark:text-white">{{ trans('company.number_apply_by_trainee') }}:</p>
        <p class="dark:text-white">{{ optional($ojt)->applied?->count() ?? '' }}</p>

        <p class="font-semibold dark:text-white">{{ trans('company.number_matched_by_cgo') }}:</p>
        <p class="dark:text-white">{{ optional($ojt)->matched?->count() ?? '' }}</p>

        <p class="font-semibold dark:text-white">{{ trans('company.number_final') }}:</p>
        <p class="dark:text-white">{{ optional($ojt)->finalList?->count() ?? '' }}</p>
        @endif
    </div>
    {{--    <div> --}}
    {{--        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">{{ __('company.attach_file') }}</label> --}}
    {{--        <div id="attachments-list" class="mb-3"> --}}
    {{--            <div id="attachments-list"> --}}
    {{--                <div class="attachment-item mt-4 flex flex-wrap gap-4"> --}}
    {{--                    @foreach ($ojt->attachFiles as $attachment) --}}
    {{--                        <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px; --}}
    {{--                                        display: flex; --}}
    {{--                                        padding: 6px; --}}
    {{--                                        align-items: center; --}}
    {{--                                        gap: 6px;"> --}}
    {{--                                            {{ $attachment }} --}}
    {{--                                            <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $ojt->id, 'filename' => $attachment]) }}" type="button" class="btn btn-danger btn-sm delete-attachment align-content-center" > --}}
    {{--                                                <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"> --}}
    {{--                                                <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/> --}}
    {{--                                                </svg> --}}
    {{--                                            </a> --}}
    {{--                                        </span> --}}
    {{--                    @endforeach --}}
    {{--                </div> --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
    <!-- About the Role -->
    {{--    <div class="mt-8"> --}}
    {{--        <h3 class="font-bold text-lg text-gray-900">{{ trans('company.job_support.ojt_list.ojt_registration.application_requirements.hr_information.job_role') }}</h3> --}}
    {{--        <p class="mt-4 text-sm text-gray-700 leading-relaxed"> --}}
    {{--            {{ $ojt->role }} --}}
    {{--        </p> --}}
    {{--    </div> --}}

    <!-- Attachments -->
    {{--    <div class="mt-6"> --}}
    {{--        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('company.attach_file') }}</label> --}}
    {{--        <div id="attachments-list" class="mb-3"> --}}
    {{--            <div class="attachment-item mt-4 flex flex-wrap gap-4"> --}}
    {{--                @foreach ($ojt->attachments as $attachment) --}}
    {{--                    <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px; display: flex; padding: 6px; align-items: center; gap: 6px;"> --}}
    {{--                        {{ $attachment }} --}}
    {{--                        <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $ojt->id, 'filename' => $attachment]) }}" class="btn btn-danger btn-sm delete-attachment"> --}}
    {{--                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg"> --}}
    {{--                                <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/> --}}
    {{--                            </svg> --}}
    {{--                        </a> --}}
    {{--                    </span> --}}
    {{--                @endforeach --}}
    {{--            </div> --}}
    {{--        </div> --}}
    {{--    </div> --}}
</div>



<div class="flex flex-col gap-1 justify-end px-6 pb-6">
    @if (isset($ojt->statusApply) && !empty($ojt->statusApply))
        <div class="flex flex-col gap-6 items-end">
            <span class="text-sm text-primary flex gap-1 items-center font-semibold read-cv">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17"
                    fill="none">
                    <path
                        d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675"
                        stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                {{ $ojt->statusApply }}
            </span>
        </div>
    @else
        @if (!empty($trainee) && empty($hasApproved))
            <div class="text-end">
                @if (!$hasApplied)
                    <button
                        class="apply-btn py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full @if (isset($hasEnough) && $hasEnough == true) cursor-not-allowed @endif"
                        data-ojt-id="{{ $ojt->id }}" data-trainee-id="{{ $trainee->id }}" @if (isset($hasEnough) && $hasEnough == true) disabled @endif>
                        {{ __('trainee.job_support.ojt_list.ojt_details.apply') }}
                    </button>
                @endif
            </div>
        @endif
            @if (isset($hasEnough) && $hasEnough == true)
            <div class="text-end dark:text-white italic">
                {{ __('general.OJT Application is closed') }}
            </div>
        @endif
    @endif
</div>
