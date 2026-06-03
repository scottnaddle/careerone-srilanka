@extends('homepage.layouts.master')
@section('title', 'Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
                ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('trainee.menu.job_support.company_list'), 'url' => route('trainee.job-support.company.company-list')],
                [
                    'label' => $jobDetail->company->name,
                    'url' => route('trainee.job-support.company.detail', [
                        'id' => $jobDetail->company->id,
                        'slug' => $jobDetail->company->slug,
                    ]),
                ],
                ['label' => \Str::limit($jobDetail->title, 30), 'url' => '#'],
            ]" />
        </div>

        <div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg shadow-md">
            <!-- Back Button -->
            <div class="flex items-center mb-4 pt-6 px-6">
                <p class="text-xl text-[#464559] dark:text-white font-semibold">Job details</p>
            </div>
            <!-- Job Details Header -->
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
{{--                <div class="ml-auto">--}}
{{--                    <button onclick="handleBookmarkJob(this)" id="keep-trainee" data-job-id="{{ $jobDetail->id }}"--}}
{{--                        title="Bookmark job" data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}" type="button">--}}

{{--                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 15 18"--}}
{{--                            class="{{ $jobDetail->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6 md:size-7 lg:size-8"--}}
{{--                            fill="none">--}}
{{--                            <path--}}
{{--                                d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"--}}
{{--                                stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </div>--}}
{{--            </div>--}}

            <!-- Job Information -->
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
{{--                    @foreach ($jobDetail->working_day as $day)--}}
{{--                   <p>{{ $working_day[$day] ?? '' }}</p>--}}
{{--                @endforeach--}}
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
{{--            <div>--}}
{{--                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"--}}
{{--                    for="file_input">{{ __('company.attach_file') }}</label>--}}
{{--                <div id="attachments-list" class="mb-3">--}}
{{--                    <div id="attachments-list">--}}
{{--                        <div class="attachment-item mt-4 flex flex-wrap gap-4">--}}
{{--                            @foreach ($jobDetail->attachments as $attachment)--}}
{{--                                <span class="text-white bg-[#4984F6] p-2 rounded-full font-we"--}}
{{--                                    style="border-radius: 6px;--}}
{{--                            display: flex;--}}
{{--                            padding: 6px;--}}
{{--                            align-items: center;--}}
{{--                            gap: 6px;">--}}
{{--                                    {{ $attachment }}--}}
{{--                                    <a href="{{ route('company.job-support.job-vacancy.download-attachment', ['job_id' => $jobDetail->id, 'filename' => $attachment]) }}"--}}
{{--                                        type="button"--}}
{{--                                        class="btn btn-danger btn-sm delete-attachment align-content-center">--}}
{{--                                        <svg width="13" height="12" viewBox="0 0 13 12"--}}
{{--                                            fill="none" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                            <path d="M11 10.5H2M9.5 5.5L6.5 8.5M6.5 8.5L3.5 5.5M6.5 8.5V1.5"--}}
{{--                                                stroke="#ffffff" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                                stroke-linejoin="round" />--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                </span>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
            <x-job-details :job="$jobDetail" />
            <div class="flex justify-end p-6">
                @if (isset($jobDetail->statusApply) && !empty($jobDetail->statusApply))
                    <div class="flex flex-col gap-6 items-end">
                        <span class="text-sm text-primary flex gap-1 items-center font-semibold read-cv">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                viewBox="0 0 16 17" fill="none">
                                <path
                                    d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675"
                                    stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                            {{ $jobDetail->statusApply }}
                        </span>
                    </div>
                @else
                    <button id="apply" name="apply" {{ !empty($traineeApply->id) ? 'disabled' : '' }}
                        class="px-6 lg:px-12 py-2 md:py-3 font-semibold text-white bg-primary rounded-full hover:bg-blue-800 shadow-xs text-center">Apply</button>
                @endif
            </div>
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
                                Are you sure
                                you want to unmatch this job?</h3>
                            <div class="flex justify-center gap-4">
                                <a href="" id="confirm_unmatch"
                                    class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </a>
                                <button data-modal-hide="delete-modal" type="button"
                                    class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">No,
                                    cancel</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script>
    <script>
        $(".btn-readmore").click(function() {
            let answer = $(this).data('answer');
            $("#article-answer").html(answer);
            $(this).addClass('hidden');
            // $("form input[name='id']")
            $('.btn-showless').removeClass('hidden');
        });
        $(".btn-showless").click(function() {
            let summary = $(this).data('summary');
            $("#article-answer").html(summary);
            $(this).addClass('hidden');
            $('.btn-readmore').removeClass('hidden');
        });
    </script>
    <script>
        $('#confirm_unmatch').click(function(e) {
            e.preventDefault();
            $('#form-submit').submit();
        })
    </script>
    <script>
        $('#apply').on('click', function() {
            toggleLoadingOverlay();
            let $clickedElement = $(this);
            $(this).addClass('cursor-not-allowed');
            $(this).attr('disabled', 'disabled');
            $.ajax({
                url: '{{ route('trainee.job-support.job-list.toggle-apply') }}',
                type: 'PUT',
                data: {
                    _token: '{{ csrf_token() }}',
                    job_id: {{ $jobDetail->id }},

                },
                success: function(response) {
                    showToast(response.message, 3000, response.status);
                    window.location.href =
                        '{{ route('trainee.job-support.company.job-post', ['id' => $jobDetail->company_id, 'slug' => $jobDetail->company->slug]) }}';
                    toggleLoadingOverlay();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toggleLoadingOverlay();
                }
            });
        })
        if ('{{ Session::get('success') }}') {
            Toastify({
                text: '{{ Session::get('success') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {}
            }).showToast();
        } else if ('{{ Session::get('error') }}') {
            Toastify({
                text: '{{ Session::get('error') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {}
            }).showToast();
        }
    </script>
    <script>
        function handleBookmarkJob(button) {
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
                    console.error('Error:', error);
                    toggleLoadingOverlay();
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
                    bg_color = 'linear-gradient(to right, #db4a4a, #bb7f7f)';
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
    </script>
@endpush
