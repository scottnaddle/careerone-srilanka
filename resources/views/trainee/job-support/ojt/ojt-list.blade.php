@extends('homepage.layouts.master')
@section('title', 'Trainee - OJT List')

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
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('trainee.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('trainee.menu.job_support.ojt_list'), 'url' => '#'],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5">
        <form action="{{ url()->current() }}" method="GET" class="flex flex-col gap-6">
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
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                        placeholder="{{ __('general.OJT title') }}" />
                </div>
                <button type="submit"
                    class="px-6 lg:px-12 py-2 font-medium text-white bg-primary rounded-full hover:bg-blue-800 shadow-xs">
                    {{ trans('trainee.job_support.ojt_list.search') }}
                </button>
            </div>
            <div class="flex justify-between items-center">
                @if (
                    (request()->has('sector') && request()->query('sector') != 'all') ||
                        (request()->has('title') && request()->query('title') != '') ||
                        (request()->has('district') && request()->query('district') != 'all'))
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">
                        {{ $ojts->total() }} {{ trans('trainee.job_support.ojt_list.filterResults') }}
                    </p>
                @else
                    <p></p>
                @endif
                <div class="flex gap-2">
                    <div class="mt-2 flex gap-4 float-right">
                        <select id="job_type" name="job_type"
                            class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                            <option value="recently" @selected(request()->input('job_type') == 'recently')>
                                {{ trans('trainee.job_support.ojt_list.filter.recently') }}</option>
                            <option value="oldest" @selected(request()->input('job_type') == 'oldest')>
                                {{ trans('trainee.job_support.ojt_list.filter.oldest') }}</option>
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
                            class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{trans('trainee.job_support.ojt_list.table.ojt_title')}}
                        </th>
                        <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-base">
                            {{trans('trainee.job_support.ojt_list.table.company_name')}}
                        </th>
                        <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-base text-left">
                            {{trans('trainee.job_support.ojt_list.table.required_skills')}}
                        </th>
                        <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-base text-left">
                            {{trans('trainee.job_support.ojt_list.table.required_work_experience')}}
                        </th>
                        <th scope="col"
                            class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                            {{trans('trainee.job_support.ojt_list.table.closing_date')}}
                        </th>
                        <th scope="col"
                            class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap text-left">
                            {{trans('trainee.job_support.ojt_list.table.status')}}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ojts as $item)
                        <tr class="bg-white text-white dark:bg-[#1E1E1E] border-b dark:text-white border-[#F8F8F8] dark:border-gray-700 text-center">
                            <td scope="row" class="text-left">
                                <a class="dark:hover:text-primary px-4 py-6 text-sm text-[#201F36] dark:text-white w-1/6 font-semibold whitespace-nowrap hover:text-primary"
                                   href="{{ route('trainee.job-support.ojt.ojt-detail', ['id' => $item->id, 'slug' => $item->slug]) }}">
                                    {{ \Str::limit($item->title, 25) }}</a>
                            </td>
                            <td scope="row" class="px-4 py-6 text-sm text-[#201F36] dark:text-white w-1/6">
                                {{ \Str::limit($item->company->name, 20) }}
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-left">
                                {{ \Str::limit($item->required_skills, 20) }}
                            </td>
                            <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-left">
                                @if($item->work_experience_limitation)
                                    Not limit
                                @else
                                    {{ \Str::limit($item->min_work_experience.' - '.$item->max_work_experience, 20) }}
                                @endif
                            </td>
                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                {{ $item->application_endtime != null ? date("Y-m-d", strtotime($item->application_endtime)) : '' }}
                            </td>
                            <td class="px-4 py-6 text-sm text-center">
                                @if ($item->application_endtime != null && \Carbon\Carbon::parse($item->registration_date)->format('Y-m-d') >= $item->application_endtime)
                                    <label
                                        class="text-[#706F81] bg-[#ECECEC] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                             viewBox="0 0 8 9" fill="none">
                                            <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                        </svg> {{ trans('cgo.job_support.trainee_list.ojt_match.table.label.status.close') }}</label>
                                @else
                                    <label
                                        class="text-primary bg-[#E9F5FF] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                             viewBox="0 0 8 9" fill="none">
                                            <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                        </svg> {{ trans('cgo.job_support.trainee_list.ojt_match.table.label.status.progress') }}</label>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
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
        {{ $ojts->onEachSide(1)->links() }}
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        // Handle sort dropdown
        $('#job_type').on('change', function() {
            let url = new URL(window.location.href);
            if (url.searchParams.has('job_type')) {
                url.searchParams.set('job_type', this.value);
            } else {
                url.searchParams.append('job_type', this.value);
            }
            url.searchParams.delete('page');
            window.location.href = url.href;
        });

        // Toast notification function
        function showToast(message, duration, status) {
            const bgColor = status === 'success' ?
                'linear-gradient(to right, #00b09b, #96c93d)' :
                status === 'error' ?
                'linear-gradient(to right, #db4a4a, #bb7f7f)' :
                '#9e9d9d';

            Toastify({
                text: message,
                duration: duration,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: bgColor,
                }
            }).showToast();
        }

        // Display session messages if they exist
        @if(Session::has('success'))
            showToast('{{ Session::get('success') }}', 3000, 'success');
        @elseif(Session::has('error'))
            showToast('{{ Session::get('error') }}', 3000, 'error');
        @endif
    </script>
@endpush
