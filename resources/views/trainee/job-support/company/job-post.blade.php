@extends('homepage.layouts.master')
@section('title', 'Trainee - Job Post')

@section('content')
    <style>
        .parent {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            padding: 10px;
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
            padding: 0 10px;
        }
    </style>
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
            ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('trainee.menu.job_support.company_list'), 'url' => route('trainee.job-support.company.company-list')],
            [
                'label' => $company->name,
                'url' => route('trainee.job-support.company.detail', ['id' => $company->id, 'slug' => $company->slug]),
            ],
            ['label' => __('trainee.menu.job_support.job_post_list'), 'url' => '#'],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5">
        {{--        <a class="w-fit text-xl text-[#464559] font-semibold flex gap-2 items-center dark:text-white hover:text-primary dark:hover:text-primary" href="{{ route('trainee.job-support.company.detail', ['id' => $company->id, 'slug' => $company->slug])}}"> --}}
        {{--            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-5"> --}}
        {{--                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /> --}}
        {{--            </svg> --}}
        {{--            {{ __('trainee.menu.job_support.job_post_list') }} --}}
        {{--        </a> --}}
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col gap-6 ">
            <div class="flex flex-row gap-4">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="text" name="title" id="search" value="{{ request('title') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                        placeholder="{{ __('general.Job title') }}" />

                </div>
                <button type="submit"
                    class="px-6 lg:px-12 py-2 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                    {{ __('company.search') }}
                </button>
            </div>
            <div class="flex justify-between items-center">
                @if (
                    (request()->has('status') && request()->query('status') != '') ||
                        (request()->has('title') && request()->query('title') != ''))
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $jobs->count() }} Results</p>
                @else
                    <p></p>
                @endif
                <select id="filterStatus" name="job_type"
                    class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <option value="recently">{{trans('trainee.job_support.ojt_list.filter.recently')}}</option>
                    <option value="oldest" @selected(request()->input('job_type') == 'oldest')>{{trans('trainee.job_support.ojt_list.filter.oldest')}}</option>
                </select>
            </div>
        </form>
        <div class="relative overflow-x-auto">
            @forelse ($jobs as $item)
                <div
                    class="parent border p-3 md:p-4 rounded-2xl shadow mt-4 cursor-pointer hover:bg-blue-100 dark:hover:bg-gray-700">
                    <div class="child1 bg-[#FBFBFB] flex h-20 p-2 rounded w-20">
                        @if (file_exists($item->company->logo))
                            <img class=" object-cover rounded" src="{{ asset($item->company->logo) }}"
                                alt="{{ $item->company->name }}">
                        @else
                            <img class=" object-cover rounded" src="{{ asset('uploads/logo_default.png') }}"
                                alt="{{ $item->company->name }}">
                        @endif

                    </div>
                    <div class="child2 flex flex-col justify-around relative">
                        <a href="{{ route('trainee.job-support.company.job-detail', ['id' => $item->id, 'slug' => $item->slug]) }}"
                            class="text-[#464559] hover:text-primary w-full dark:text-white text-lg font-semibold truncate"
                            title="{{ $item->title }}">{{ $item->title }}</a>
                        <span class="text-[#706F81] text-base dark:text-white">{{ $item->company->name }}</span>
                        <span class="text-[#91919A] text-sm flex gap-1.5 items-center">
                            {{ getCodeNameByCodeId('job_type', $item->job_type)}}
                        </span>
                    </div>
                    <div class="child3 flex flex-col gap-3 items-end ">
                        <button onclick="handleKeepTrainee(this)" id="keep-trainee" data-job-id="{{ $item->id }}"
                            title="Bookmark job" data-trainee-id="{{ Auth::guard(activeGuard())->user()->id }}">

                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="21" viewBox="0 0 15 18"
                                class="{{ $item->isMarkByTrainee(Auth::guard(activeGuard())->user()->id) ? 'fill-primary' : '' }} size-6 md:size-7 lg:size-8"
                                fill="none">
                                <path
                                    d="M1.6665 5.5C1.6665 4.09987 1.6665 3.3998 1.93899 2.86502C2.17867 2.39462 2.56112 2.01217 3.03153 1.77248C3.56631 1.5 4.26637 1.5 5.6665 1.5H9.33317C10.7333 1.5 11.4334 1.5 11.9681 1.77248C12.4386 2.01217 12.821 2.39462 13.0607 2.86502C13.3332 3.3998 13.3332 4.09987 13.3332 5.5V16.5L7.49984 13.1667L1.6665 16.5V5.5Z"
                                    stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </button>

                        <span class="text-[#464559] dark:text-white flex flex-col">
                            @if ($item->discussion_salary)
                                <span class="text-[#464559] dark:text-white">Discussion</span>
                            @endif
                            {{ $item->min_salary ? $item->min_salary . ' -' : '' }} {{ $item->max_salary }}
                            {{ $item->salary_currency ?? '' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="flex flex-col gap-4 justify-center items-center p-4">
                    <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                    <p class="dark:text-white">No record!</p>
                </div>
            @endforelse
        </div>
        {{ $jobs->onEachSide(1)->links() }}
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        let url = new URL(window.location.href);
        $('#filterStatus').on('change', function() {
            if (url.searchParams.has('job_type')) {
                url.searchParams.set('job_type', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('job_type', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.btn-bookmark-job').on('click', function() {
                $buttonEl = $(this);
                let svgElement = $buttonEl.find('svg');
                svgElement.addClass('fill-primary');
            });
        });
    </script>
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
