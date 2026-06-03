@extends('homepage.layouts.master')
@section('title', 'Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('homepage')],
            ['label' => 'Job Support', 'url' => '#'],
            ['label' => 'OJT list', 'url' => route('trainee.job-support.ojt.ojt-list')],
            ['label' => \Str::limit($ojt->title,50), 'url' => '#'],
        ]" />
        </div>
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('trainee.job_support.ojt_list.ojt_details.root') }}</p>--}}

        <div class="w-full mx-auto bg-white dark:bg-[#1E1E1E] rounded-lg shadow-md p-6">
            <!-- Back Button -->
            <div class="flex items-center mb-4">
                 <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_details')}}</p>
            </div>
{{--            <!-- Job Details Header -->--}}
{{--            <div class="flex items-center gap-6">--}}
{{--                @if ($ojt->company->logo)--}}
{{--                <img  class="w-16 h-16 rounded-full" src="{{ asset($ojt->company->logo) }}"--}}
{{--                    alt="{{ $ojt->company->name }}">--}}
{{--            @else--}}
{{--                <img  class="w-16 h-16 rounded-full" src="{{ asset('uploads/logo_default.png') }}"--}}
{{--                    alt="{{ $ojt->company->name }}">--}}
{{--            @endif--}}
{{--                <div class="flex-1">--}}
{{--                    <h2 class="text-xl font-bold">{{ optional($ojt)->title }}</h2>--}}
{{--                    <p class="text-sm text-gray-500">Posted on {{ optional($ojt)->created_at }}  by {{$ojt->owner->fullName}}</p>--}}
{{--                </div>--}}
{{--                <div class="ml-auto">--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <!-- Job Information -->--}}
{{--            <div class="mt-6 text-sm text-gray-700">--}}
{{--                <div class="grid grid-cols-2 gap-x-12 gap-y-4">--}}
{{--                    <p class="font-semibold">Company Name:</p>--}}
{{--                    <p>{{$ojt->company->name}}</p>--}}

{{--                    <p class="font-semibold">Period:</p>--}}
{{--                    <p>{{$ojt->period}}</p>--}}
{{--                    <p class="font-semibold">Number of Recruitments:</p>--}}
{{--                    <p>{{ $ojt->number_of_recruitments }}</p>--}}

{{--                    <p class="font-semibold">{{ __('company.gender') }}:</p>--}}
{{--                    <p> @foreach(getCodeList('gender') as $gender)--}}
{{--                            @if (optional($ojt)->gender == $gender->code_id )--}}
{{--                            {{ $gender->code_name }}--}}
{{--                            @endif--}}
{{--                        @endforeach</p>--}}
{{--                    @if (!empty($ojt->min_age) || !empty($ojt->max_age))--}}
{{--                        <p class="font-semibold">{{ __('company.age_limitation') }}:</p>--}}
{{--                        <p>--}}
{{--                            {{ optional($ojt)->min_age ?? '' }}--}}
{{--                            @if (!empty($ojt->min_age) && !empty($ojt->max_age))--}}
{{--                                ---}}
{{--                            @endif--}}
{{--                            {{ optional($ojt)->max_age ?? '' }}--}}
{{--                        </p>--}}
{{--                    @endif--}}
{{--                        @if (!empty($ojt->min_work_experience) || !empty($ojt->max_work_experience))--}}
{{--                        <p class="font-semibold">{{ __('company.required_work_experience') }}:</p>--}}
{{--                        <p>--}}
{{--                            {{ optional($ojt)->min_work_experience ?? '' }}--}}
{{--                            @if (!empty($ojt->min_work_experience) && !empty($ojt->max_work_experience))--}}
{{--                                {{ ' - ' }}--}}
{{--                            @endif--}}
{{--                            {{ optional($ojt)->max_work_experience ?? '' }}--}}
{{--                        </p>--}}
{{--                    @endif--}}

{{--                    <p class="font-semibold">Required skills:</p>--}}
{{--                    <p>{{$ojt->required_skills}}</p>--}}

{{--                @if (!empty($ojt->application_starttime) || !empty($ojt->application_endtime))--}}
{{--                    <p class="font-semibold">{{ __('company.application_deadline') }}:</p>--}}
{{--                    <p>--}}
{{--                        {{ optional($ojt)->application_starttime ?? '' }}--}}
{{--                        @if (!empty($ojt->application_starttime) && !empty($ojt->application_endtime))--}}
{{--                            {{ ' to ' }}--}}
{{--                        @endif--}}
{{--                        {{ optional($ojt)->application_endtime ?? '' }}--}}
{{--                    </p>--}}
{{--                @endif--}}

{{--                    <p class="font-semibold">{{ __('company.email') }}:</p>--}}
{{--                    <p>{{ optional($ojt)->hr_email }}</p>--}}
{{--                    <p class="font-semibold">{{ __('company.contact_info') }}:</p>--}}
{{--                    <p>{{ optional($ojt)->hr_contact_info }}</p>--}}

{{--                </div>--}}
{{--            </div>--}}
            <x-o-j-t-details :ojt="$ojt" :trainee="$trainee" :hasApplied="$hasApplied" :hasApproved="$hasApproved" :hasEnough="$hasEnough" />
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script> --}}
    <script>
        $(document).ready(function () {
            function applyHandler(e) {
                e.preventDefault();
                let button = $(this);
                let ojtId = button.data('ojt-id');
                let traineeId = button.data('trainee-id');
                toggleLoadingOverlay();

                $.ajax({
                    url: '{{ route("trainee.job-support.ojt.ojt-apply") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        ojt_id: ojtId,
                        trainee_id: traineeId
                    },
                    success: function (response) {
                        showToast(response.message ?? 'Applied successfully!', 3000, response.status ?? 'success');
                        toggleLoadingOverlay();

                        if (response.status === 'success') {
                            button.replaceWith(`
                                <div class="flex flex-col gap-6 items-end">
                                <span class="text-sm text-primary flex gap-1 items-center font-semibold read-cv">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                        <path d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675" stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                Applied
                                </span>
                                </div>
                            `);
                        }
                    },
                    error: function (xhr) {
                        let res = xhr.responseJSON;
                        showToast(res?.message ?? 'Apply failed!', 3000, res?.status ?? 'error');
                        toggleLoadingOverlay();
                    }
                });
            }

            function unapplyHandler(e) {
                e.preventDefault();
                let button = $(this);
                let id = button.data('id');
                toggleLoadingOverlay();

                $.ajax({
                    url: '{{ route("trainee.job-support.ojt.ojt-unapply") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function (response) {
                        showToast(response.message ?? 'Unapplied successfully!', 3000, response.status ?? 'success');
                        toggleLoadingOverlay();

                        if (response.status === 'success') {
                            button.replaceWith(`
                                <button type="button"
                                        class="apply-btn py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full"
                                        data-ojt-id="${response.ojt_id}"
                                        data-trainee-id="${response.trainee_id}">
                                    Apply
                                </button>
                            `);
                        }
                    },
                    error: function (xhr) {
                        let res = xhr.responseJSON;
                        showToast(res?.message ?? 'Unapply failed!', 3000, res?.status ?? 'error');
                        toggleLoadingOverlay();
                    }
                });
            }

            // Use event delegation so new buttons work without rebinding
            $(document).on('click', '.apply-btn', applyHandler);
            $(document).on('click', '.unapply-btn', unapplyHandler);
        });
    </script>

    <script>
        function showToast(message='Success', dru, status) {
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
                onClick: function () {
                } // Callback after click
            }).showToast();
        }
    </script>
@endpush
