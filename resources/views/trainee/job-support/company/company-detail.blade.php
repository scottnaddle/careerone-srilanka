@extends('homepage.layouts.master')
@section('title', 'Job support - Company list - Event List')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')

    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
            ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('trainee.menu.job_support.company_list'), 'url' => route('trainee.job-support.company.company-list')],
            ['label' => $company->name, 'url' => route('trainee.job-support.company.company-list')],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">

                <form
                    action="{{ route('trainee.job-support.company.detail', ['id' => $company->id, 'slug' => $company->slug]) }}"
                    method="GET">
                    <div class="flex gap-3 flex-col">
                        <div class="flex flex-col gap-3">
                            <div class="flex justify-between">
                                <p class="text-xl md:text-2xl text-[#464559] dark:text-white font-semibold">{{trans('trainee.job_support.company.company_details.company_introduction')}}</p>
                                @if (activeGuard() != '' && Auth::guard(activeGuard())->check())
                                    <button onclick="handleMarkCompany(this)" id="mark-company"
                                        data-company-id="{{ $company->id }}" class="content-end self-end" type="button"
                                        title="Bookmark company"
                                        data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21"
                                            viewBox="0 0 15 18"
                                            class="{{ $company->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6 md:size-7 lg:size-8"
                                            fill="none">
                                            <path
                                                d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"
                                                stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                @endif
                            </div>
                            <p class="text-[#91919A] dark:text-white" id="expertise_heading_block">
                                {{ $company->services }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 p-3 w-full">

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.name') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->name ?? 'N/G' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.table.label.office_type') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ getCodeNameByCodeId('office_type', $company->office_type) ?? 'N/G' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{trans('trainee.job_support.company.company_details.company_information')}}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ getCodeNameByCodeId('company_information', $company->company_information) ?? 'N/G' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{trans('trainee.job_support.company.company_details.ds_division')}}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ ($company->dsDivision ? $company->dsDivision->ds_name : '') ?? 'N/G' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.enterprise') }}</span>
                                <span
                                    class="text-[#706F81] hover:underline hover:text-primary w-full sm:w-1/2 dark:text-white break-words">{{getCodeNameByCodeId('Enterprise_type', $company->enterprise_id) ?? 'No information'}}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.owner') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->name_of_representation ?? '' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.number_of_workers') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->number_workers ?? 0 }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.email') }}</span>
                                <span class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->email }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{trans('trainee.job_support.company.company_details.telephone')}}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->hotline ?? 'N/G' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.co_business') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->co_business ?? '' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.founded') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ date('Y-m-d', strtotime($company->date_of_establishment)) }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full sm:w-1/2  dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.location') }}</span>
                                <span
                                    class="text-[#706F81] w-full sm:w-1/2 dark:text-white break-words">{{ $company->getDistrict() . '. ' . $company->address }}</span>
                            </div>
                        </div>
                    </div>

                </form>
                <div class="flex justify-between items-center">
                    <p class="text-2xl text-[#464559] dark:text-white font-semibold">
                        {{ trans('trainee.job_support.company.company_details.recruiting') }}</p>
                    <a href="{{ route('trainee.job-support.company.job-post', ['id' => $company->id, 'slug' => $company->slug]) }}"
                        class="text-primary hover:underline hover:cursor-pointer">{{ trans('trainee.job_support.company.company_details.see_all') }}</a>
                </div>

                @if (isset($jobs))
                    <div class="grid md:grid-cols-2 xl:grid-cols-4 sm:grid-cols-1 gap-6">
                        @forelse($jobs as $job)
{{--                            <div--}}
{{--                                class="flex md:flex-col shadow-custom-light dark:shadow-custom-dark gap-3 justify-around px-3 py-2.5 rounded-xl bg-white  dark:bg-[#1E1E1E] border border-[#F8F8F8] dark:border-0">--}}
{{--                                <div class="flex justify-center bg-[#FBFBFB] rounded-xl">--}}
{{--                                    @if ($job->company->logo != '')--}}
{{--                                        <img src="{{ asset($job->company->logo) }}" class="rounded-xl object-cover lg:h-48"--}}
{{--                                            alt="">--}}
{{--                                    @else--}}
{{--                                        <img class=" rounded-xl object-cover lg:h-48"--}}
{{--                                            src="{{ asset('uploads/logo_default.png') }}" alt="">--}}
{{--                                    @endif--}}
{{--                                </div>--}}
{{--                                <div class="w-full">--}}
{{--                                    <div class="flex flex-col gap-1 justify-around">--}}
{{--                                        <a href="{{ route('trainee.job-support.company.job-detail', ['id' => $job->id, 'slug' => $job->slug]) }}"--}}
{{--                                            class="md:text-xl font-semibold dark:text-white">{{ \Str::limit($job->title, 35) }}</a>--}}
{{--                                        <p class="text-[#706F81]  dark:text-white text-sm md:text-base font-semibold">--}}
{{--                                            {{ \Str::limit($job->company->name, 15) }}</p>--}}
{{--                                        <span class="text-[#91919A] text-sm md:text-sm dark:text-white">--}}
{{--                                            {{ convertDays($job->working_day) }}--}}
{{--                                        </span>--}}
{{--                                        <div class="flex justify-between items-center">--}}
{{--                                            <span class="text-[#91919A] md:text-sm text-xs dark:text-white">--}}
{{--                                                @if ($job->min_salary && $job->max_salary)--}}
{{--                                                    {{ $job->min_salary }} - {{ $job->max_salary }}--}}
{{--                                                    {{ $job->salary_currency }}--}}
{{--                                                    @endif @if ($job->discussion_salary)--}}
{{--                                                        - Discussion--}}
{{--                                                    @endif--}}
{{--                                            </span>--}}
{{--                                            <span class="text-[#464559] font-medium  dark:text-white text-xs md:text-sm ">--}}
{{--                                                {{ getCodeNameByCodeId('job_type', $job->job_type) }}--}}
{{--                                            </span>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="flex md:flex-col shadow-custom-light dark:shadow-custom-dark gap-6 justify-around p-4 rounded-xl bg-white dark:bg-[#1E1E1E] border border-[#F8F8F8] dark:border-0">
                                <div class="flex justify-center bg-[#FBFBFB] rounded-xl relative w-1/3 md:w-full">
                                    <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-xs md:text-sm rounded m-2 overflow-hidden truncate w-12 md:w-fit">{{getCodeNameByCodeId('job_status', $job->status)}}</label>
                                    @if($job->company->logo != '')
                                        <img src="{{asset($job->company->logo)}}" class="rounded-xl object-cover md:h-36 lg:h-48" alt="Company logo">
                                    @else
                                        <img class="rounded-xl object-cover md:h-36 lg:h-48" src="{{asset('uploads/logo_default.png')}}" alt="Company logo">
                                    @endif
                                </div>
                                <div class="w-2/3 md:w-full">
                                    <div class="flex flex-col gap-3 justify-around">
                                        <a href="{{route('homepage.job-detail', ['job_id' => $job->id,'slug' => $job->slug])}}" class="md:text-xl font-semibold dark:text-white">{{\Str::limit($job->title,35)}}</a>
                                        <p class="text-[#706F81] dark:text-white text-sm md:text-base font-semibold">{{\Str::limit($job->company->name,15)}}</p>
                                        <span class="text-[#91919A] text-sm md:text-sm dark:text-white">
                                    {{convertDays($job->working_day)}}
                                </span>
                                        <div class="flex justify-between items-center">
                                    <span class="text-[#91919A] md:text-sm text-xs dark:text-white">
                                        {{($job->min_salary) ? $job->min_salary.' -' : ''}} {{$job->max_salary}} {{$job->salary_currency ?? ''}}
                                    </span>
                                            <span class="text-[#464559] font-medium dark:text-white text-xs md:text-sm">
                                        {{ getCodeNameByCodeId('job_type', $job->job_type) }}
                                    </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="w-full dark:text-white">{{ __('general.There is no recent job') }}</p>
                        @endforelse
                    </div>
                @else
                    <p>{{ trans('trainee.job_support.company.company_details.no_record_found') }}</p>
                @endif

                <div class="flex justify-between items-center">
                    <p class="text-2xl text-[#464559] dark:text-white font-semibold">
                        {{ trans('trainee.job_support.company.company_details.events') }}</p>
                    <a href="{{ route('trainee.job-support.company.event-list', ['id' => $company->id, 'slug' => $company->slug]) }}"
                        class="text-primary hover:underline hover:cursor-pointer">{{ trans('trainee.job_support.company.company_details.see_all') }}</a>
                </div>

                @if (isset($events) && $events->count())
                    <div class="grid grid-cols-1 gap-6 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
                        @forelse($events as $key => $event)
                            <div
                                class="flex flex-col gap-4 border-2 border-[#F8F8F8] p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark hover:bg-blue-100 dark:hover:bg-gray-700">
                                <div class="flex-shrink-0">
                                    @if (file_exists($event->thumbnail))
                                        <img src="{{ $event->thumbnail }}" class="w-full h-44 object-cover rounded-xl"
                                            alt="Event thumbnail">
                                    @else
                                        <img src="{{ asset('images/post.png') }}"
                                            class="w-full h-32 object-cover rounded-xl" alt="Event thumbnail">
                                    @endif
                                </div>
                                <div class="flex flex-col gap-3 w-full">
                                    <a href="{{ route('trainee.job-support.company.event-detail', ['company' => $company, 'id' => $event->id, 'slug' => $event->slug]) }}"
                                        class="text-[#464559] dark:text-white text-lg font-semibold hover:text-primary">{{ \Str::limit($event->title, 30) }}</a>
                                    @php
                                        $detailsText = strip_tags($event->details);
                                        $shortText = substr($detailsText, 0, 50);
                                    @endphp

                                    <p class="text-[#91919A] dark:text-white text-sm">
                                        {{ $shortText }}{{ strlen($detailsText) > 50 ? '...' : '' }}
                                    </p>
                                    <div class="flex justify-end">
                                        <a href="{{ route('trainee.job-support.company.event-detail', ['company' => $company, 'id' => $event->id, 'slug' => $event->slug]) }}"
                                            class="text-primary underline text-sm">{{ trans('trainee.job_support.company.company_details.readmore') }}</a>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="col-span-full text-center text-gray-500 dark:text-white">
                                {{ trans('trainee.job_support.company.company_details.no_event_available') }}</p>
                        @endforelse
                    </div>
                @else
                    <p class="dark:text-white">{{ trans('trainee.job_support.company.company_details.no_record_found') }}
                    </p>
                @endif



            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        function showMap(latitude, longitude) {
            var cooord = {
                lat: latitude,
                long: longitude
            };
            new google.maps.Map(document.getElementById('map'));
        }
    </script>
    <script>
        let url = new URL(window.location.href);
        $('#job_type').on('change', function() {
            if (url.searchParams.has('job_type')) {
                url.searchParams.set('job_type', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('job_type', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });

        if (url.searchParams.has('title') && !url.searchParams.get('title')) {
            url.searchParams.delete('title');
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
    <script>
        function handleMarkCompany(button) {
            toggleLoadingOverlay();
            const traineeId = button.getAttribute('data-trainee-id');
            const companyId = button.getAttribute('data-company-id');
            $.ajax({
                url: '{{ route('trainee.job-support.company.mark-company') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    trainee_id: traineeId,
                    company_id: companyId,
                },
                success: function(response) {
                    if (response.action == 'mark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                    } else {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                    }
                    Toastify({
                        text: response.message,
                        duration: 3000,
                        newWindow: true,
                        close: true,
                        gravity: "top", // `top` or `bottom`
                        position: "right", // `left`, `center` or `right`
                        stopOnFocus: true, // Prevents dismissing of toast on hover
                        style: {
                            background: "linear-gradient(to right, #00b09b, #96c93d)",
                        },
                        onClick: function() {} // Callback after click
                    }).showToast();
                    toggleLoadingOverlay();
                },
                error: function(xhr, status, error) {
                    console.error('Error:', error);
                    toggleLoadingOverlay();
                }
            });
        }
    </script>
    <script>
        if ('{{ Session::get('success') }}') {
            Toastify({
                text: '{{ Session::get('success') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        } else if ('{{ Session::get('error') }}') {
            Toastify({
                text: '{{ Session::get('error') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }
    </script>
@endpush
