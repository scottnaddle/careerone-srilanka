<div class="my-6 flex flex-col gap-5">
    <style>
        table thead tr th span {
            color: blue;
        }

        #search-time {
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;
            width: 7.5rem;
        }
    </style>
    <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
        <div class="flex flex-col gap-4">
            <x-breadcrumb :items="[
                ['label' => 'Admin', 'url' => '/admin/overview'],
                ['label' => 'Job support', 'url' => '#'],
                ['label' => $this->company->name, 'url' => '/admin/company-jobs'],
                ['label' => 'Job list', 'url' => ''],
            ]" />
{{--            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold"--}}
{{--                href="/admin/company-jobs">--}}
{{--                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">--}}
{{--                    <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2"--}}
{{--                        stroke-linecap="round" stroke-linejoin="round" />--}}
{{--                </svg>--}}
{{--                {{ $this->company->name }}--}}
{{--            </a>--}}
            <form action="{{ url()->current() }}" id="filter-form">
                <div class="flex flex-col gap-6">
                    <div class="flex gap-6 items-center">
                        <label for="simple-search"
                            class="sr-only">{{ trans('cgo.job_support.company_list.job_list.search') }}</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                </svg>
                            </div>
                            <input type="text" name="title" value="{{ request('title') }}" id="simple-search"
                                class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                placeholder="{{ __('general.Job title') }}" />
                        </div>
                        <button type="submit"
                            class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-[#4984F6] rounded-full hover:bg-blue-800  shadow-xs">
                            {{ trans('cgo.job_support.company_list.job_list.search') }}
                        </button>
                    </div>
                    <div class="flex justify-between items-center">
                        @if (request()->has('title') && request()->query('title') != '')
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white">
                                {{ $this->company->jobs->total() }} {{ trans('cgo.filterResult') }}
                            </p>
                        @else
                            <p></p>
                        @endif

                        <div class="flex gap-4">
                            <!-- Select search-time -->
                            <select id="status" name="search-time"
                                class="bg-[#F8F8F8] text-[#4984F6] font-semibold border border-[#EDEDED] text-base rounded-xl
                                focus:border-[#4984F6] block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="recently" @selected(request()->input('search-time') == 'recently')>
                                    Recent
                                </option>
                                <option value="oldest" @selected(request()->input('search-time') == 'oldest')>
                                    Old
                                </option>
                            </select>

                            <!-- Select status -->
                            <select id="status" name="status"
                                class="bg-[#F8F8F8] text-[#4984F6] font-semibold border border-[#EDEDED] text-base rounded-xl
                                focus:border-[#4984F6] block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white
                                dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="">{{ trans('Status') }}</option>
                                @foreach ($jobStatuses as $key => $value)
                                    <option value="{{ $key }}" @selected( request()->has('status') && request()->input('status') == $key)>
                                        {{ $value }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                </div>
            </form>
            <div class="relative overflow-x-auto">
                <table class="w-full text-left rtl:text-right table-auto">
                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                {{ trans('cgo.job_support.company_list.job_list.table.label.job_title') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                {{ trans('cgo.job_support.company_list.job_list.table.label.registration_date') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                {{ trans('cgo.job_support.company_list.job_list.table.label.end_date') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                Status
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                {{ trans('cgo.job_support.company_list.job_list.table.label.applied') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                {{ trans('cgo.job_support.company_list.job_list.table.label.matched') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                Unread
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">
                                Selected
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-[#4984F6] dark:text-[#FFFFFF] font-semibold text-base">

                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($this->company->jobs->isEmpty())
                            <tr>
                                <td colspan="9" class="text-center py-6 text-sm text-[#201F36] dark:text-white">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                </td>
                            </tr>
                        @else
                            @foreach ($this->company->jobs as $job)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td scope="row" class="px-4 py-6 font-semibold text-sm text-left">
                                        <a href="{{ route('filament.admin.resources.company-jobs.view-job-details', ['record' => $this->company->id, 'job' => $job->id]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-[#4984F6] dark:hover:text-[#4984F6]">
                                            {{ \Str::limit($job->title, 12) }}</a>
                                    </td>

                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->created_at != '' ? date('Y-m-d', strtotime($job->created_at)) : 'N/G' }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->application_endtime != '' ? date('Y-m-d', strtotime($job->application_endtime)) : 'N/G' }}
                                    </td>


                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        @php
                                      $statusColors = [
                                        0 => ['text' => '#5a5252', 'bg' => '#F0F0F0'],
                                        1 => ['text' => '#4984F6', 'bg' => '#E9F5FF'],
                                        2 => ['text' => '#47b347', 'bg' => '#e4fde4'],
                                    ];

                                        $status = $job->status ?? 0;
                                        $color = $statusColors[$status] ?? $statusColors[0];
                                    @endphp
                                        <label style="color: {{ $color['text'] }}; background-color: {{ $color['bg'] }};"  class="text-[{{ $color['text'] }}] bg-[{{ $color['bg'] }}] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9" viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="{{ $color['text'] }}" />
                                            </svg>
                                            {{{ \App\Enums\JobStatusEnum::getNameByKey($status) }}}
                                        </label>
                                    </td>

                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->applies->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->matches->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->matches->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->matches->count() }}
                                    </td>

                                    <td>
                                        <a class="text-sm text-[#4984F6] flex gap-2 items-center font-semibold hover:underline"
                                            href="{{ route('filament.admin.resources.company-jobs.view-job-candidate', ['record' => $this->company->id, 'job' => $job->id]) }}">
                                            View more
                                            <svg xmlns="http://www.w3.org/2000/svg" width="6" height="10"
                                                viewBox="0 0 6 10" fill="none">
                                                <path d="M1 9L5 5L1 1" stroke="#4984F6" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>

                </table>

            </div>
            {{--            // this renders the tailwind pagination from vendor --}}
            @if(count($this->company->jobs) > 0)
                <div class="flex justify-end w-full">
                    {{ $this->company->jobs->onEachSide(1)->links('pagination::custom-pagination-admin') }}
                </div>
            @endif
        </div>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusDropdown = document.getElementById('search-time');
            statusDropdown.addEventListener('change', function() {
                let params = new URLSearchParams(window.location.search);
                params.set('status', statusDropdown.value);
                let url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;
                window.location.href = url;
            });
        });
        document.addEventListener('DOMContentLoaded', function() {

            const form = document.getElementById('filter-form');

            form.addEventListener('submit', function(e) {
                e.preventDefault();

                let formData = new FormData(form);
                let params = new URLSearchParams();
                formData.forEach((value, key) => {
                    if (value !== null && value.trim() !== '') {
                        params.append(key, value);
                    }
                });

                let url = `${window.location.origin}${window.location.pathname}?${params.toString()}`;
                window.location.href = url;
            });
        });
    </script>
</div>
