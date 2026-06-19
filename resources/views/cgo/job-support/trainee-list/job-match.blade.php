@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Trainee List - Job Match')

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.trainee_list.job_match.root') }}</p> --}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                [
                    'label' => trans('cgo.job_support.trainee_list.root'),
                    'url' => route('cgo.job-support.trainee-list.list'),
                ],
                [
                    'label' => trans('cgo.job_support.trainee_list.job_match.root'),
                    'url' => route('cgo.job-support.trainee-list.job-match', ['trainee' => $trainee->id]),
                ],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                {{--                <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold" --}}
                {{--                    href="{{ route('cgo.job-support.trainee-list.list') }}"> --}}
                {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none"> --}}
                {{--                        <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" --}}
                {{--                            stroke-linecap="round" stroke-linejoin="round" /> --}}
                {{--                    </svg> --}}
                {{--                    {{ trans('cgo.job_support.trainee_list.job_match.breadcum') }} --}}
                {{--                </a> --}}
                <form action="{{ route('cgo.job-support.trainee-list.job-match', ['trainee' => $trainee]) }}" method="GET">
                    <div>
                        <label for=""
                            class="block mb-2 text-sm font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_match.trainee_name') }}</label>
                        <input type="text" id=""
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $trainee->fullName }}" required readonly />
                    </div>
                    <div class="flex flex-col">
                        <label for="website"
                            class="block mb-2 text-sm font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.job_match.search_position.root') }}
                        </label>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4 items-center">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="name" name="title" value="{{ request('title') }}"
                                    class="ps-10 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ __('general.Job title') }}" />
                            </div>
                            <div>
                                <select id="sector" name="sector"
                                    class="border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all" {{ request('sector') == 'all' ? 'selected' : '' }}>
                                        {{ __('company.industry') }}
                                    </option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ request('sector') == $sector->id ? 'selected' : '' }}>{{ $sector->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <select id="district" name="district"
                                    class="border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all" {{ request('district') == 'all' ? 'selected' : '' }}>
                                        {{ trans('cgo.job_support.trainee_list.job_match.search_position.district') }}
                                    </option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ request('district') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs w-full text-center">
                                    {{ trans('cgo.job_support.trainee_list.job_match.search_position.search') }}
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            @if (
                                (request()->has('title') && request()->query('title') != '') ||
                                    (request()->has('district') && request()->query('district') != 'all') ||
                                    (request()->has('sector') && request()->query('sector') != 'all') ||
                                    (request()->has('job_type') && request()->query('job_type') != 'all'))
                                <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $jobs->total() }}
                                    {{ trans('cgo.job_support.trainee_list.job_match.search_position.filterResults') }}</p>
                            @else
                                <p></p>
                            @endif
                            </p>
                            <select id="job_type"
                                class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="all">
                                    {{ trans('cgo.job_support.trainee_list.job_match.search_position.filter.all') }}
                                </option>
                                <option value="match" @selected(request()->get('job_type') == 'match')>
                                    {{ trans('cgo.job_support.trainee_list.job_match.search_position.filter.match') }}
                                </option>
                                <option value="unmatch" @selected(request()->get('job_type') == 'unmatch')>
                                    {{ trans('cgo.job_support.trainee_list.job_match.search_position.filter.unmatch') }}
                                </option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.job_title') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.company') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.registration_date') }}
                                </th>
{{--                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">--}}
{{--                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.end_date') }}--}}
{{--                                </th>--}}
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.job_list.table.label.status') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.applied') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.matched') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.shortlist') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.trainee_list.job_match.table.label.job_match') }}
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $item)
                                {{-- @if (!$item->checkEmployed($item->id, $trainee->id)) --}}
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                                    <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/3 text-left">
                                        <a href="{{ route('cgo.job-support.trainee-list.job-match.job-details', ['trainee' => $trainee, 'slug' => $item->slug]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary"
                                            data-tooltip-target="full-text-{{ $item->id }}" data-tooltip-style="light">
                                            {{ $item->title }}</a>
                                        <div id="full-text-{{ $item->id }}" role="tooltip"
                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                            {{ $item->title }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->company->name }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->created_at ? date('Y-m-d', strtotime($item->created_at)) : '' }}
                                    </td>
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">--}}
{{--                                        {{ $item->application_endtime ? date('Y-m-d', strtotime($item->application_endtime)) : '' }}--}}
{{--                                    </td>--}}
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        @if ($item->application_endtime != null && date('Y-m-d') >= $item->application_endtime)
                                            <label
                                                class="text-[#706F81] bg-[#ECECEC] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                                </svg>
                                                {{ trans('cgo.job_support.trainee_list.ojt_match.table.label.status.close') }}</label>
                                        @else
                                            <label
                                                class="text-primary bg-[#E9F5FF] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                                </svg>
                                                {{ trans('cgo.job_support.trainee_list.ojt_match.table.label.status.progress') }}</label>
                                        @endif
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->appliesWithCondition('apply_type', \App\Enums\TypeTraineeApply::APPLY)->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white"
                                        id="matched-count-{{ $item->id }}">
                                        {{ $item->appliesTypeMatch->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white"
                                        id="matched-count-{{ $item->id }}">
                                        {{ $item->checkJobMatchEmployed($item->id, $trainee->id) ? 'Y' : '0' }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        <input id="checked-checkbox-{{ $item->id }}"
                                            {{ $item->checkMatched($item->id, $trainee->id) ? 'checked' : '' }}
                                            data-created-by={{ $item->checkMatched($item->id, $trainee->id) ? getCGOIdMatchedTraineeToJob($trainee->id, $item->id) : Auth::guard(activeGuard())->user()->id }}
                                            data-trainee-id={{ $trainee->id }} type="checkbox"
                                            value="{{ $item->id }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-[#1E1E1E] dark:border-gray-600 {{$item->checkMatched($item->id, $trainee->id) && getCGOIdMatchedTraineeToJob($trainee->id, $item->id) != Auth::guard(activeGuard())->user()->id ? 'cursor-not-allowed' : '' }}" {{$item->checkMatched($item->id, $trainee->id) && getCGOIdMatchedTraineeToJob($trainee->id, $item->id) != Auth::guard(activeGuard())->user()->id ? 'disabled="disabled"' : '' }}
                                            onchange="handleCheckboxChange(this)">
                                    </td>
                                </tr>
                                {{-- @endif --}}
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">{{ trans('cgo.no_record') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>
                    </table>

                </div>
                {{--            // this renders the tailwind pagination from vendor --}}
                {{ $jobs->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
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
    </script>

    <script>
        function handleCheckboxChange(checkbox) {
            toggleLoadingOverlay();
            const jobId = checkbox.value;
            const isChecked = checkbox.checked;
            const traineeId = checkbox.getAttribute('data-trainee-id');
            const created_by = checkbox.getAttribute('data-created-by');
            $.ajax({
                url: '{{ route('cgo.job-support.trainee-list.trainee-match') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    job_id: jobId,
                    trainee_id: traineeId,
                    created_by: created_by
                },
                success: function(response) {
                    if (response.status == 'success') {
                        var countElement = $('#matched-count-' + jobId);
                        var currentCount = parseInt(countElement.text());
                        if (response.action == 'unmatch') {
                            countElement.text(currentCount - 1);
                        } else {
                            countElement.text(currentCount + 1);
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
                        location.reload();
                    } else {
                        Toastify({
                            text: response.message,
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
                    toggleLoadingOverlay();

                },
                error: function(xhr, status, error) {
                    toggleLoadingOverlay();
                }

            });

        }
    </script>
@endpush
