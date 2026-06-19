@extends('homepage.layouts.master')
@section('title', 'Job support - Trainee List - OJT Match')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
            ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('cgo.menu.job_support.trainee_list'), 'url' => route('cgo.job-support.trainee-list.list')],
            ['label' => trans('cgo.job_support.ojt_list.table.label.ojt_match'), 'url' => '#'],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold"
                    href="{{ route('cgo.job-support.trainee-list.list') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                        <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ trans('cgo.job_support.trainee_list.ojt_match.breadcum') }}
                </a>
                <form>
                    <div>
                        <label for="" class="block mb-2 text-sm font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.trainee_name') }}</label>
                        <input type="text" id="" value="{{ $trainee->fullName }}"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly />
                    </div>
                    <div class="flex flex-col">
                        <label for="website" class="block mb-2 text-sm font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.root') }}</label>
                        <div class="grid gap-6 mb-6 md:grid-cols-2 lg:grid-cols-4 items-center">
                            <div class="relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="company" name="title" value="{{ request('title') }}"
                                    class="ps-10 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.ojt_name_placeholder') }}" />
                            </div>
                            <div>
                                <select id="district" name="district"
                                    class="border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all" {{ request()->get('district') == 'all' ? 'selected' : '' }}>
                                        {{ trans('cgo.job_support.trainee_list.ojt_match.search_position.district') }}
                                    </option>
                                    @foreach ($districts as $district)
                                        <option value="{{ $district->id }}"
                                            {{ request()->get('district') == $district->id ? 'selected' : '' }}>
                                            {{ $district->name }}</option>
                                    @endforeach

                                </select>
                            </div>
                            <div>
                                <select id="sector" name="sector"
                                    class="border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all">{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.sector') }}</option>
                                    @foreach ($sectors as $sector)
                                        <option value="{{ $sector->id }}"
                                            {{ request()->get('sector') == $sector->id ? 'selected' : '' }}>
                                            {{ $sector->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <button type="submit"
                                    class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs w-full text-center">
                                    {{ trans('cgo.job_support.trainee_list.ojt_match.search_position.search') }}
                                </button>
                            </div>
                        </div>
                        <div class="flex justify-between items-center">
                            @if (
                                (request()->has('title') && request()->query('title') != '') ||
                                    (request()->has('district') && request()->query('district') != 'all') ||
                                    (request()->has('sector') && request()->query('sector') != 'all'))
                                <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $ojts->total() }}
                                    {{ trans('cgo.job_support.trainee_list.ojt_match.search_position.filterResults') }}</p>
                            @else
                                <p></p>
                            @endif
                            <select id="job_type"
                                class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="all">{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.filter.all') }}</option>
                                <option value="match" @selected(request()->get('job_type') == 'match')>{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.filter.match') }}</option>
                                <option value="unmatch" @selected(request()->get('job_type') == 'unmatch')>{{ trans('cgo.job_support.trainee_list.ojt_match.search_position.filter.unmatch') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.company') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap w-1/3">
                                    {{ trans('cgo.job_support.ojt_list.table.label.ojt_title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{trans('cgo.job_support.job_list.job_detail.application_requirements.required_work_experience')}}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{trans('cgo.job_support.job_list.job_detail.application_requirements.required_skills')}}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.registration_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.status.root') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.ojt_match') }}
                                </th>
                                <th>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ojts as $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 ">
                                    <td scope="row" class="px-2 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ \Str::limit($item->company->name, 25) }}
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-6 font-semibold text-sm text-[#201F36] dark:text-white w-1/3 hover:text-primary">
                                        <a
                                            href="{{ route('cgo.job-support.ojt-list.ojt_detail', ['id' => $item->id]) }}" data-tooltip-target="full-text-{{$item->id}}" data-tooltip-style="light">{{ \Str::limit($item->title, 20) }}</a>
                                        <div id="full-text-{{$item->id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                            {{$item->title}}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-left">
                                        @if ($item->work_experience_limitation)
                                            Not limit
                                        @else
                                            {{ \Str::limit($item->min_work_experience . ' - ' . $item->max_work_experience, 20) }}
                                        @endif
                                    </td>
                                    <td scope="row"
                                        class="px-2 py-6 font-semibold text-sm text-[#201F36] dark:text-white hover:text-primary">
                                        {{ \Str::limit($item->required_skills, 20) }}
                                    </td>
                                    <td class="px-2 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {{ \Carbon\Carbon::parse($item->registration_date)->format('Y-m-d') }}
                                    </td>
                                    <td class="px-2 py-6 text-sm">
                                        @if (
                                            $item->application_endtime != null &&
                                                \Carbon\Carbon::parse($item->registration_date)->format('Y-m-d') >= $item->application_endtime)
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

                                    <td class="px-4 py-6 text-sm text-center text-[#706F81] dark:text-[#C9CCD4]">
                                        <input onchange="handleCheckboxChange(this)"
                                            {{ $trainee->isMatchOJT($item->id) ? 'checked' : '' }} id="checked-checkbox"
                                            type="checkbox" value="{{ $item->id }}"
                                            data-trainee-id="{{ $trainee->id }}"
                                            data-matched-by="{{ $trainee->isMatchOJT($item->id) ? getCGOIdMatchedTraineeToOJT($trainee->id, $item->id) : Auth::guard(activeGuard())->user()->id }}"
                                            data-system="{{ activeGuard() }}"
                                            class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-[#1E1E1E] dark:border-gray-600 {{$trainee->isMatchOJT($item->id) && getCGOIdMatchedTraineeToOJT($trainee->id, $item->id) != Auth::guard(activeGuard())->user()->id ? 'cursor-not-allowed' : '' }}" {{$trainee->isMatchOJT($item->id) && getCGOIdMatchedTraineeToOJT($trainee->id, $item->id) != Auth::guard(activeGuard())->user()->id ? 'disabled="disabled"' : '' }}>
                                    </td>

                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>

                </div>
                {{--            // this renders the tailwind pagination from vendor --}}
                {{ $ojts->onEachSide(1)->links() }}

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
            const ojt_id = checkbox.value;
            const traineeId = checkbox.getAttribute('data-trainee-id');
            const matched_by = checkbox.getAttribute('data-matched-by');
            const system = checkbox.getAttribute('data-system');
            $.ajax({
                url: '{{ route('cgo.job-support.ojt-list.match-trainee') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    ojt_id: ojt_id,
                    trainee_id: traineeId,
                    matched_by: matched_by,
                    system: system
                },
                success: function(response) {

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
                    Toastify({
                        text: error,
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
                }
            });

        }
    </script>
@endpush
