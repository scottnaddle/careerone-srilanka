<div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg p-6">
    <!-- Job Details Header -->
    <div class="flex items-center gap-6">
        @if ($job->company->logo)
            <img class="w-16 h-16 rounded-full" src="{{ asset($job->company->logo) }}" alt="{{ $job->company->name }}">
        @else
            <img class="w-16 h-16 rounded-full" src="{{ asset('uploads/logo_default.png') }}" alt="{{ $job->company->name }}">
        @endif
        <div class="flex-1">
            <h2 class="text-xl font-bold dark:text-white">{{ optional($job)->title }}</h2>
            <p class="text-sm text-gray-500 dark:text-white">Posted on {{ optional($job)->created_at }} by {{ optional($job->companyRecruiter)->fullName }}</p>
        </div>
    </div>

    <!-- Job Information -->
    <div class="mt-6 text-sm text-gray-700">
        <div class="grid grid-cols-2 gap-x-12 gap-y-4 break-words">
            <p class="font-semibold dark:text-white">{{ __('company.name') }}:</p>
            <p class="dark:text-white">{{ optional($job->company)->name }}</p>

            <p class="font-semibold dark:text-white">{{ __('company.Employment type') }}:</p>
            <p class="dark:text-white">{{ getCodeNameByCodeId('job_type', $job->job_type) }}</p>
            <p class="font-semibold dark:text-white">{{ __('company.job_location') }}:</p>
            {{--            <p class="dark:text-white">{{ getCodeNameByCodeId('job_location', $job->job_location) }}</p>--}}
            <p class="dark:text-white">{{ $job->job_location }}</p>




            <p class="font-semibold dark:text-white">{{ __('company.industry') }}:</p>
            <div class="flex flex-col gap-1">
                <p class="dark:text-white">{{ optional($job->sector)->name }}</p>
                <span class="dark:text-white text-sm">{{ $job->sector_information }}</span>
            </div>

            <p class="font-semibold dark:text-white">{{ __('company.job_role') }}:</p>
            @if(optional($job)->roles)
                <div class="dark:text-white w-full ">
                    {!! nl2br(e(optional($job)->roles)) !!}
                </div>

                {{--                <textarea class="dark:text-white rounded-lg w-full" disabled cols="4">{{ optional($job)->roles }}</textarea>--}}
            @else
                <p></p>
            @endif
            <p class="font-semibold dark:text-white">{{ __('company.work_type') }}:</p>
            <p class="dark:text-white">{{ getCodeNameByCodeId('work_type', $job->work_type) }}</p>
            <p class="font-semibold dark:text-white">{{ __('company.working_day') }}:</p>
            <p class="dark:text-white">{{ optional($job)->working_day }}</p>

            <p class="font-semibold dark:text-white">{{ __('company.working_hours') }}:</p>
            <p class="dark:text-white"> {{ optional($job)->start_time ?? '' }} - {{ optional($job)->end_time ?? '' }}</p>

            <p class="font-semibold dark:text-white">{{ __('company.starting_date') }}:</p>
            <p class="dark:text-white"> {{ optional($job)->start_date ?? '' }}</p>

            <p class="font-semibold dark:text-white">{{ __('company.salary_type') }}:</p>
            <p class="dark:text-white"> {{ $job->salary_type != null ? getCodeNameByCodeId('salary_type',$job->salary_type ) : '' }}</p>

{{--            @if (!empty($job->min_salary) || !empty($job->max_salary))--}}
{{--                <p class="font-semibold dark:text-white">{{ __('company.salary_per_month') }}:</p>--}}
{{--                <p class="dark:text-white">--}}
{{--                    {{ $job->salary_currency ?? '' }}--}}
{{--                    {{ $job->min_salary ?? '' }}--}}
{{--                    @if (!empty($job->min_salary) && !empty($job->max_salary))--}}
{{--                        –--}}
{{--                    @endif--}}
{{--                    {{ $job->max_salary ?? '' }}--}}
{{--                    @if(optional($job)->discussion_salary == true)--}}
{{--                        ({{ trans('company.negotiable') }})--}}
{{--                    @endif--}}
{{--                </p>--}}
{{--            @endif--}}
            @if (!empty($job->min_salary))
                <p class="font-semibold dark:text-white">{{ __('company.salary_per_month') }}:</p>
                <p class="dark:text-white">
                    {{ $job->salary_currency ?? '' }}
                    {{ $job->min_salary }}
                    @if(optional($job)->discussion_salary == true)
                        ({{ trans('company.negotiable') }})
                    @endif
                </p>
            @endif

            <p class="font-semibold dark:text-white">{{ __('company.gender') }}:</p>
            <p class="dark:text-white">
                @php
                    $genderValues = is_array(optional($job)->gender)
                        ? optional($job)->gender
                        : (is_string(optional($job)->gender)
                            ? json_decode(optional($job)->gender, true)
                            : (is_numeric(optional($job)->gender)
                                ? [(string)optional($job)->gender]
                                : []
                            )
                        );
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
{{--                {{ optional($job)->min_age ?? '' }}--}}
{{--                @if (!empty($job->min_age) && !empty($job->max_age))--}}
{{--                    ---}}
{{--                @endif--}}
{{--                {{ optional($job)->max_age ?? '' }}--}}
{{--                @if(optional($job)->not_limit_age == true)--}}
{{--                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}--}}
{{--                @endif--}}
{{--            </p>--}}

            <p class="font-semibold dark:text-white">{{ __('company.required_work_experience') }}:</p>
            <p class="dark:text-white">{{ optional($job)->min_work_experience }} @if(optional($job)->not_limit_experience == true)
                    {{ trans('company.job_support.ojt_list.ojt_registration.not_limitation') }}
                @endif</p>

            <p class="font-semibold dark:text-white">{{ __('company.NVQ requirements / Preferred qualifications') }}:</p>
            <p class="dark:text-white">{{ optional($job)->nvq_level ?? '' }}</p>




            <p class="font-semibold dark:text-white">{{ __('company.required_skills') }}:</p>
            @if( optional($job)->required_skills)
                <div class="dark:text-white  w-full ">
                    {!! nl2br(e(optional($job)->required_skills)) !!}
                </div>

{{--                <textarea class="dark:text-white rounded-lg w-full" disabled cols="4">{{ optional($job)->required_skills }}</textarea>--}}
            @else
                <p></p>
            @endif

            <p class="font-semibold dark:text-white">
                {{ trans('company.Application period') }}</p>
                <p class="dark:text-white">
                @if(optional($job)->application_starttime)
                                {{ \Carbon\Carbon::parse($job->application_starttime)->format('Y-m-d') }}
                @if(optional($job)->application_endtime)
                    - {{ \Carbon\Carbon::parse($job->application_endtime)->format('Y-m-d') }}
                @endif
                @endif
            </p>


            <p class="font-semibold dark:text-white">{{ __('company.email') }}:</p>
            <p class="dark:text-white">{{ optional($job)->hr_email }}</p>

            <p class="font-semibold dark:text-white">{{ __('company.contact_info') }}:</p>
            <p class="dark:text-white">{{ optional($job)->hr_contact_info }}</p>
        </div>
    </div>

    <!-- About the Role -->
    <div class="mt-8 grid grid-cols-2 gap-x-12 gap-y-4 items-center">
        <h3 class="font-bold text-lg text-gray-900 dark:text-white">{{trans('company.job_support.ojt_list.table.label.number_of_recruitment')}}</h3>
        <p class="mt-2 font-bold text-lg text-gray-700 leading-relaxed dark:text-white">
            {{ $job->number_of_recruitments }}
        </p>
    </div>

    <!-- Attachments -->
    <div class="mt-6">
        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('company.attach_file') }}</label>
        <div id="attachments-list" class="mb-3">
            <div class="attachment-item mt-4 flex flex-wrap gap-4">
                @if($job->attachments != '')
                @forelse($job->attachments as $attachment)
                    <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px; display: flex; padding: 6px; align-items: center; gap: 6px;">
                        {{ $attachment }}
                        <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $job->id, 'filename' => $attachment]) }}" class="btn btn-danger btn-sm delete-attachment">
                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </a>
                    </span>
                @empty
                @endforelse
                @endif
            </div>
        </div>
    </div>
</div>
