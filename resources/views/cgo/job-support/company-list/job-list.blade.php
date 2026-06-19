@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Company list - Job List')

@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.company_list.job_list.root') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.menu.job_support.company_list'), 'url' => route('cgo.job-support.company-list.list')],
                ['label' =>  $company->name, 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <form action="{{ route('cgo.job-support.company-list.job-list', ['company' => $company]) }}" method="GET">
                    <div class="flex flex-col gap-6">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search" class="sr-only">{{ trans('cgo.job_support.company_list.job_list.search') }}</label>
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
                                class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                {{ trans('cgo.job_support.company_list.job_list.search') }}
                            </button>
                        </div>
                        <div class="flex justify-between items-center">
                            @if (request()->has('title') && request()->query('title') != '')
                                <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $jobs->total() }}
                                    {{ trans('cgo.filterResult') }}</p>
                            @else
                                <p></p>
                            @endif
                            <select id="job_type"
                                class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="recently" @selected(request()->input('job_type') == 'recently')>{{ trans('cgo.job_support.company_list.filter.recently') }}</option>
                                <option value="oldest" @selected(request()->input('job_type') == 'oldest')>{{ trans('cgo.job_support.company_list.filter.oldest') }}</option>
                            </select>
                        </div>
                    </div>
                </form>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.job_title') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.company_name') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.registration_date') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.end_date') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.applied') }}
                                </th>
                                <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('cgo.job_support.company_list.job_list.table.label.matched') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($jobs as $job)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/3 text-left">
                                        <a href="{{ route('cgo.job-support.company-list.job-list.job-details', ['slug' => $job->slug]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary">
                                            {{ $job->title }}</a>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->company->name }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->application_starttime != '' ? date('Y-m-d', strtotime($job->application_starttime)) : 'N/G' }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->application_endtime != '' ? date('Y-m-d', strtotime($job->application_endtime)) : 'N/G' }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->appliesTypeApply->count() }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $job->appliesTypeMatch->count() }}
                                    </td>
                                </tr>
                            @endforeach


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
@endpush
