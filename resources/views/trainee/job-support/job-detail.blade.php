@extends('homepage.layouts.master')
@section('title', 'Trainee - Job Detail')

@section('content')
    <style>
        .parent {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            /*padding: 10px;*/
        }

        .child1,
        .child3 {
            flex: 0 0 auto;
            white-space: nowrap;
        }

        .child2 {
            flex: 1;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            /*padding: 0 10px;*/
        }
        .job-roles {
            display: -webkit-box;
            -webkit-box-orient: vertical;
            overflow: hidden;
            -webkit-line-clamp: 2;
            line-clamp: 2;
            text-overflow: ellipsis;
            max-height: calc(1.5em * 2);
            line-height: 1.5em;
        }

    </style>
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
            ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('trainee.menu.job_support.job_list'), 'url' => route('trainee.job-support.job-list.job-list')],
            ['label' => __('trainee.menu.job_support.job_detail'), 'url' => '#'],
        ]" />
    </div>

    {{-- new --}}
    <div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg shadow-md ">
        <!-- Back Button -->
        <div class="flex items-center mb-4 px-6 pt-6 dark:text-white">
            <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('trainee.menu.job_support.job_detail')}}</p>
        </div>
        <!-- Job Details Header -->
{{--        <div class="flex items-center gap-6">--}}
{{--            @if ($job->company->logo)--}}
{{--            <img  class="w-16 h-16 rounded-full" src="{{ asset($job->company->logo) }}"--}}
{{--                alt="{{ $job->company->name }}">--}}
{{--        @else--}}
{{--            <img  class="w-16 h-16 rounded-full" src="{{ asset('uploads/logo_default.png') }}"--}}
{{--                alt="{{ $job->company->name }}">--}}
{{--        @endif--}}
{{--            <div class="flex-1">--}}
{{--                <h2 class="text-xl font-bold">{{ optional($job)->title }}</h2>--}}
{{--                <p class="text-sm text-gray-500">Posted on {{ optional($job)->created_at }}  by {{$job->companyRecruiter->fullName}}</p>--}}
{{--            </div>--}}
{{--            <div class="ml-auto">--}}
{{--                <button onclick="handleKeepTrainee(this)" id="keep-trainee" data-job-id="{{ $job->id }}" title="Bookmark job"--}}
{{--                    data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}" type="button">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 15 18"--}}
{{--                     class="{{ $job->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6 md:size-7 lg:size-8"--}}
{{--                     fill="none">--}}
{{--                    <path--}}
{{--                        d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"--}}
{{--                        stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                </svg>--}}
{{--            </button>--}}
{{--            </div>--}}
{{--        </div>--}}

        <!-- Job Information -->
{{--        <div class="mt-6 text-sm text-gray-700">--}}
{{--            <div class="grid grid-cols-2 gap-x-12 gap-y-4">--}}
{{--                <p class="font-semibold">{{trans('trainee.job_support.company.company_details.name')}}:</p>--}}
{{--                <p>{{$job->company->name}}</p>--}}

{{--                <p class="font-semibold">{{trans('trainee.job_support.company.company_details.job_details.job_type')}}:</p>--}}
{{--                <p>{{{getCodeNameByCodeId('job_type', $job->job_type)}}}</p>--}}

{{--                <p class="font-semibold">{{trans('trainee.job_support.job_list.job_location')}}:</p>--}}
{{--                <p>{{{getCodeNameByCodeId('job_location', $job->job_location)}}}</p>--}}

{{--                <p class="font-semibold">{{ __('company.occupation') }}:</p>--}}
{{--                <p>{{$job->sector->name}}</p>--}}

{{--                <p class="font-semibold">{{trans('trainee.job_support.job_list.number_of_recruitment')}}</p>--}}
{{--                <p>{{ $job->number_of_recruitments }}</p>--}}
{{--                <p class="font-semibold">{{trans('trainee.job_support.company.company_details.job_details.working_day')}}:</p>--}}
{{--                <p>@foreach($job->working_day as $day)--}}
{{--                    <span >{{ $working_day[$day] ?? '' }}</span>--}}
{{--                @endforeach</p>--}}

{{--                <p class="font-semibold">{{trans('trainee.job_support.company.company_details.job_details.working_hours')}}:</p>--}}
{{--                <p>{{ optional($job)->start_date }}</p>--}}
{{--            @if (!empty($job->min_salary) || !empty($job->max_salary))--}}
{{--                <p class="font-semibold">{{ __('company.salary_per_month') }}:</p>--}}
{{--                <p>--}}
{{--                    {{ $job->salary_currency ?? '' }}--}}
{{--                    {{ $job->min_salary ?? '' }}--}}
{{--                    @if (!empty($job->min_salary) && !empty($job->max_salary))--}}
{{--                        –--}}
{{--                    @endif--}}
{{--                    {{ $job->max_salary ?? '' }}--}}
{{--                </p>--}}
{{--            @endif--}}

{{--            <p class="font-semibold">{{ __('company.gender') }}:</p>--}}
{{--            <p>--}}
{{--                @php--}}
{{--                    $genderValues = is_array(optional($job)->gender) --}}
{{--                        ? optional($job)->gender --}}
{{--                        : (is_string(optional($job)->gender) --}}
{{--                            ? json_decode(optional($job)->gender, true) --}}
{{--                            : (is_numeric(optional($job)->gender) --}}
{{--                                ? [(string)optional($job)->gender] --}}
{{--                                : []--}}
{{--                              )--}}
{{--                          );--}}
{{--                    $genderNames = [];--}}
{{--                    foreach (getCodeList('gender') as $gender) {--}}
{{--                        if (in_array((string) $gender->code_id, $genderValues)) {--}}
{{--                            $genderNames[] = $gender->code_name;--}}
{{--                        }--}}
{{--                    }--}}
{{--                @endphp--}}
{{--                {{ implode(', ', $genderNames) }}--}}
{{--            </p>--}}
{{--                @if (!empty($job->min_age) || !empty($job->max_age))--}}
{{--                    <p class="font-semibold">{{ __('company.age_limitation') }}:</p>--}}
{{--                    <p>--}}
{{--                        {{ optional($job)->min_age ?? '' }}--}}
{{--                        @if (!empty($job->min_age) && !empty($job->max_age))--}}
{{--                            ---}}
{{--                        @endif--}}
{{--                        {{ optional($job)->max_age ?? '' }}--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--                <p class="font-semibold">{{ __('company.required_work_experience') }}:</p>--}}
{{--                <p>{{ optional($job)->min_work_experience }}</p>--}}

{{--            @if (!empty($job->application_starttime) || !empty($job->application_endtime))--}}
{{--                <p class="font-semibold">{{ __('company.application_deadline') }}:</p>--}}
{{--                <p>--}}
{{--                    {{ optional($job)->application_starttime ?? '' }}--}}
{{--                    @if (!empty($job->application_starttime) && !empty($job->application_endtime))--}}
{{--                        {{ ' to ' }}--}}
{{--                    @endif--}}
{{--                    {{ optional($job)->application_endtime ?? '' }}--}}
{{--                </p>--}}
{{--            @endif--}}

{{--                <p class="font-semibold">{{ __('company.email') }}:</p>--}}
{{--                <p>{{ optional($job)->hr_email }}</p>--}}
{{--                <p class="font-semibold">{{ __('company.contact_info') }}:</p>--}}
{{--                <p>{{ optional($job)->hr_contact_info }}</p>--}}

{{--            </div>--}}
{{--        </div>--}}

{{--        <!-- About the Role -->--}}
{{--        <div class="mt-8">--}}
{{--            <h3 class="font-bold text-lg text-gray-900">About the Role</h3>--}}
{{--            <p class="mt-4 text-sm text-gray-700 leading-relaxed">--}}
{{--                {{$job->role}}--}}
{{--            </p>--}}

{{--        </div>--}}
{{--        <div>--}}
{{--            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">{{ __('company.attach_file') }}</label>--}}
{{--            <div id="attachments-list" class="mb-3">--}}
{{--                <div id="attachments-list">--}}
{{--                    <div class="attachment-item mt-4 flex flex-wrap gap-4">--}}
{{--                        @foreach($job->attachments as $attachment)--}}
{{--                            <span class="text-white bg-[#4984F6] p-2 rounded-full font-we" style="border-radius: 6px;--}}
{{--                                    display: flex;--}}
{{--                                    padding: 6px;--}}
{{--                                    align-items: center;--}}
{{--                                    gap: 6px;">--}}
{{--                                        {{ $attachment }}--}}
{{--                                        <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $job->id, 'filename' => $attachment]) }}" type="button" class="btn btn-danger btn-sm delete-attachment align-content-center" >--}}
{{--                                            <svg width="13" height="12" viewBox="0 0 13 12" fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5" stroke="#ffffff" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                            </svg>--}}
{{--                                        </a>--}}
{{--                                    </span>--}}
{{--                        @endforeach--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
        <x-job-details :job="$job" />
        <!-- Apply Button -->
            <div class="flex justify-end px-6 pb-6">
                @if(isset($job->statusApply) && !empty($job->statusApply))
                    <div class="flex flex-col gap-6 items-end">
                    <span class="text-sm text-primary flex gap-1 items-center font-semibold read-cv">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                            <path d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675" stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                       {{ $job->statusApply }}
                    </span>
                    </div>
                @else 
                <button id="apply" name="apply" {{ !empty($traineeApply->id) ? 'disabled' : '' }} class="px-6 lg:px-12 py-2 md:py-3 font-semibold text-white bg-primary rounded-full hover:bg-blue-800 shadow-xs text-center">Apply</button>
                @endif
            </div>
    </div>
    {{-- end new --}}
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script>
        function handleKeepTrainee(button) {
            toggleLoadingOverlay();
            const traineeId = button.getAttribute('data-trainee-id');
            const jobId = button.getAttribute('data-job-id');
            $.ajax({
                url: '{{ route('trainee.job-support.job-list.mark') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    trainee_id: traineeId,
                    job_id: jobId,
                },
                success: function(response) {
                    let status = false;
                    if (response.action == 'mark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                        status = true;
                    } else if (response.action == 'unmark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                        status = true;
                    }
                    if (status) {
                        showToast(response.message, 3000, response.status);
                    } else {
                        showToast(response.message, 3000, response.status);
                    }
                    toggleLoadingOverlay();
                },
                error: function(xhr, status, error) {
                    toggleLoadingOverlay();
                    console.error('Error:', error);
                }
            });
        }
        function showToast(message, dru, status) {
            let bg_color = '#9e9d9d';
            switch (status) {
                case 'success':
                    bg_color = 'linear-gradient(to right, #00b09b, #96c93d)';
                    break;
                case 'error':
                    bg_color = 'linear-gradient(to right, #db4a4a, #e74c3c)';
                    break;

            }
            Toastify({
                text: message,
                duration: dru,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: bg_color,
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }
        $(document).ready(function() {
            const jobRoles = $('#job-roles');

            if (jobRoles.prop('scrollHeight') > jobRoles.height()) {
                $('#see-all').removeClass('hidden');
            }

            $('#see-all').on('click', function() {
                jobRoles.css({
                    '-webkit-line-clamp': 'unset',
                    'max-height': 'none'
                });
                $(this).addClass('hidden');
                $('#see-less').removeClass('hidden');
            });
            $('#see-less').on('click', function() {
                jobRoles.css({
                    '-webkit-line-clamp': '2',
                    'max-height': 'calc(1.5em * 2)'
                });
                $(this).addClass('hidden');
                $('#see-all').removeClass('hidden');
            })
            $('#apply').on('click', function () {
                toggleLoadingOverlay();
                let $clickedElement = $(this);
                $(this).addClass('cursor-not-allowed');
                $(this).attr('disabled', 'disabled');
                $.ajax({
                    url: '{{ route('trainee.job-support.job-list.toggle-apply') }}',
                    type: 'PUT',
                    data: {
                        _token: '{{ csrf_token() }}',
                        job_id: {{ $job->id }},

                    },
                    success: function(response) {
                        showToast(response.message, 3000, response.status);
                        if (response.action !== 'cancel')
                            window.location.href = '{{ route('trainee.job-support.job-list.job-list') }}';
                        toggleLoadingOverlay();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        toggleLoadingOverlay();
                    }
                });
            })
        });

    </script>
@endpush
