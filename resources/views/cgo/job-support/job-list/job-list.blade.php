@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Job List')
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            padding: 1.35rem .75rem 1.35rem 1.25rem !important;
            background: #f8f8f8;
            border-radius: 0.75rem;
        }

        .select2-container .select2-selection {
            font-size: 16px !important;
            font-weight: 600 !important;
            color: #706F81 !important;
            font-weight: 600 !important;
            border-color: #EDEDED !important;
        }

        .select2-selection__placeholder {
            color: #706F81 !important;
            font-weight: 600 !important;
        }

        /* Dark mode styles */
        .dark .select2-selection__placeholder {
            color: #ffffff !important;
            font-weight: 600 !important;
        }
    </style>
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.job_support.job_list.root'), 'url' => route('cgo.job-support.job-list.list')],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 w-full flex flex-col gap-5">
            <div class="flex w-full flex-col gap">
                <form action="{{ route('cgo.job-support.job-list.list') }}" method="GET">
                    <div class="flex w-full flex-col">
                        <!-- Title, Location, and Industry Buttons in the same row -->
                        <div class="flex w-full gap-6 mb-6 items-center">
                            <!-- Job Title Input -->
                            <div class="flex-1 relative">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" name="title" id="company"
                                    class="ps-10 border w-full border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="{{ __('general.Job title') }}" value="{{ request('title') }}" />
                            </div>


                            <div>
                                <button type="submit"
                                    class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs w-full text-center">
                                    {{ trans('cgo.job_support.job_list.search') }}
                                </button>
                            </div>
                        </div>

                        <!-- Job Type Select -->
                        <div class="flex justify-between items-center mb-6">
                            @if (request()->has('title') || request()->has('district') || request()->has('sector'))
                                <p class="text-[#706F81] text-lg font-semibold dark:text-white  whitespace-nowrap">{{ $jobs->total() }}
                                    {{ trans('cgo.job_support.job_list.filterResult') }}</p>
                            @else
                                <p></p>
                            @endif

                            <div class="mt-2 flex gap-4 float-right">


                                <!-- Industry Button -->
                                <div>
                                    <button value="all" name="sector" id="sector-modal-open" type="button"
                                            data-modal-target="default-modal"
                                            class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                                    <span>
                                        @php
                                            $sectorText = 'Industry';
                                            if (optional($subsectorFilter)->id) {
                                                $sectorText = "{$sectorsFilter->name}/{$subsectorFilter->name}";
                                            } elseif (optional($sectorsFilter)->id) {
                                                $sectorText = $sectorsFilter->name;
                                            }
                                        @endphp
                                        {{ $sectorText }}
                                    </span>
                                        <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                <!-- Location Button -->
                                <div>
                                    <button value="all" name="district-modal" id="district-modal" type="button"
                                            data-modal-target="default-modal"
                                            class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                                    <span>
                                        @php
                                            $locationText = trans('company.job_support.trainee_list.filter.district');
                                            if (optional($divisionalFilter)->id) {
                                                $locationText = "{$provinceFilter->name}/{$districtsFilter->name}/{$divisionalFilter->ds_name}";
                                            } elseif (optional($districtsFilter)->id) {
                                                $locationText = "{$provinceFilter->name}/{$districtsFilter->name}";
                                            } elseif (optional($provinceFilter)->id) {
                                                $locationText = $provinceFilter->name;
                                            }
                                        @endphp
                                        {{ $locationText }}
                                    </span>
                                        <svg width="20" height="20" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </button>
                                </div>
                                <select
                                    class="company w-fit font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-semibold placeholder:text-[#201F36] text-sm"
                                    id="companySelect" name="company_id" data-placeholder="{{trans('cgo.job_support.ojt_list.filter.company')}}">
                                    <option value="">{{ trans('cgo.job_support.ojt_list.filter.company') }}</option>
                                    @forelse($companies as $company)
                                        <option value="{{ $company->id }}" @selected(request()->input('company_id') == $company->id)>
                                            {{ $company->name }} - {{ getCodeNameByCodeId('office_type', $company->office_type) }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                <select id="status" name="status"
                                        class="w-fit md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">{{ trans('cgo.job_support.ojt_list.filter.status') }}</option>
                                    <option value="completed" @selected(request()->input('status') == 'completed')>{{ trans('cgo.job_support.ojt_list.filter.completed') }}</option>
                                    <option value="progress" @selected(request()->input('status') == 'progress')>{{ trans('cgo.job_support.ojt_list.filter.progress') }}</option>
                                    <option value="cancel" @selected(request()->input('status') == 'cancel')>{{ trans('cgo.job_support.ojt_list.filter.cancel') }}</option>
                                </select>
                                <!-- Job Type Select -->
                                <select id="job_type"
                                    class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="desc" @selected(request()->input('job_type') == 'desc')>
                                        {{ trans('cgo.job_support.job_list.filter.recently') }}</option>
                                    <option value="asc" @selected(request()->input('job_type') == 'asc')>
                                        {{ trans('cgo.job_support.job_list.filter.oldest') }}</option>
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
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.job_list.table.label.job_title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('general.Company') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-pre-line">
                                    {!! trans('general.Number Of Recruitments')  !!}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.closing_date') }}
                                </th>
{{--                                <th scope="col"--}}
{{--                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">--}}
{{--                                    {{ trans('cgo.job_support.job_list.table.label.end_date') }}--}}
{{--                                </th>--}}
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.job_list.table.label.status') }}
                                </th>
{{--                                <th scope="col"--}}
{{--                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">--}}
{{--                                    {{ trans('cgo.job_support.job_list.table.label.applied') }}--}}
{{--                                </th>--}}
{{--                                <th scope="col"--}}
{{--                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">--}}
{{--                                    {{ trans('cgo.job_support.job_list.table.label.matched') }}--}}
{{--                                </th>--}}
                                <th scope="col" colspan="3"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.job_list.table.label.job_match') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($jobs as $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td scope="row" class="px-4 py-6 font-semibold text-sm  w-1/6 text-left">
                                        <a href="{{ route('cgo.job-support.job-list.job-details', ['slug' => $item->slug]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary"
                                            data-tooltip-target="full-text-{{ $item->id }}"
                                            data-tooltip-style="light">{{ \Str::limit($item->title, 35) }}</a>
                                        <div id="full-text-{{ $item->id }}" role="tooltip"
                                            class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                            {{ $item->title }}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ \Str::limit($item->company->name, 15) }}
                                    </td>

                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-center">
                                        {{$item->number_of_recruitments}}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->application_endtime ? date('Y-m-d', strtotime($item->application_endtime)) : '' }}
                                    </td>
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">--}}
{{--                                        {{ $item->application_endtime ? date('Y-m-d', strtotime($item->application_endtime)) : '' }}--}}
{{--                                    </td>--}}
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        @if ($item->status == \App\Enums\JobStatusEnum::PROGRESS->value)
                                            <label
                                                class="text-primary bg-[#E9F5FF] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                                </svg>
                                                {{ getCodeNameByCodeId('job_status', $item->status) }}</label>
                                        @elseif($item->status == \App\Enums\JobStatusEnum::CANCEL->value)
                                            <label
                                                class="text-[#706F81] bg-[#ECECEC] px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                                </svg>
                                                {{ getCodeNameByCodeId('job_status', $item->status) }}</label>
                                        @elseif($item->status == \App\Enums\JobStatusEnum::COMPLETED->value)
                                            <label
                                                class="text-green-500 bg-green-100 px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#057a2e" />
                                                </svg>
                                                {{ getCodeNameByCodeId('job_status', $job->status) }}</label>
                                        @endif
                                    </td>
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">--}}
{{--                                        {{ $item->appliesTypeApply->count() }}--}}
{{--                                    </td>--}}
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">--}}
{{--                                        {{ $item->appliesTypeMatch->count() }}--}}
{{--                                    </td>--}}
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">--}}
{{--                                        <div--}}
{{--                                            class="flex gap-6 items-center justify-center md:justify-start lg:justify-center md:justify-end lg:justify-center md:justify-start lg:justify-center">--}}
{{--                                            <a href="{{ route('cgo.job-support.job-list.candidate-list', ['job_id' => $item->id, 'slug' => $item->slug]) }}"--}}
{{--                                                class="whitespace-nowrap px-4 lg:px-6 py-2 lg:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-700 shadow-xs hover:text-white text-center">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.table.trainee_match_button') }}--}}
{{--                                            </a>--}}
{{--                                        </div>--}}
{{--                                    </td>--}}
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        <div
                                            class="flex gap-6 items-center justify-center md:justify-start lg:justify-center md:justify-end lg:justify-center md:justify-start lg:justify-center">
                                            <a href="{{ route('cgo.job-support.job-list.trainee-match', ['slug' => $item->slug]) }}"
                                               class="whitespace-nowrap px-4 lg:px-6 py-2 lg:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-700 shadow-xs hover:text-white text-center">
                                                {{ trans('cgo.job_support.ojt_list.table.trainee_match_button') }}
                                            </a>
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        <a href="{{ route('cgo.job-support.job-list.list-matched', ['job_id' => $item->id, 'slug' => $item->slug]) }}"
                                           class="whitespace-nowrap text-primary text-sm font-medium flex items-center gap-1 justify-center dark:text-primary hover:text-blue-900 dark:hover:text-primary">{{ trans('cgo.job_support.ojt_list.table.list_matched') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                 viewBox="0 0 17 16" fill="none">
                                                <path d="M6.5 12.001L10.5 8.00098L6.5 4.00098" stroke="currentColor"
                                                      stroke-width="2" stroke-linecap="round"
                                                      class="hover:stroke-blue-900 dark:hover:stroke-primary"
                                                      stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <span class="dark:text-white text-center">
                                            {{ $item->appliesTypeMatch->count() }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        <a href="{{ route('cgo.job-support.job-list.list-applied', ['job_id' => $item->id, 'slug' => $item->slug]) }}"
                                           class="whitespace-nowrap text-primary text-sm font-medium flex items-center gap-1 justify-center dark:text-primary hover:text-blue-900 dark:hover:text-primary">{{ trans('cgo.job_support.ojt_list.table.list_applied') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                 viewBox="0 0 17 16" fill="none">
                                                <path d="M6.5 12.001L10.5 8.00098L6.5 4.00098" stroke="currentColor"
                                                      stroke-width="2" stroke-linecap="round"
                                                      class="hover:stroke-blue-900 dark:hover:stroke-primary"
                                                      stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                        <span class="dark:text-white text-center">
                                            {{ $item->appliesTypeApply->count() }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32"
                                                alt="Empty">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
                <div class="mt-6">
                    {{ $jobs->onEachSide(1)->links() }}
                </div>
            </div>

        </div>
    </div>
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white" id="title-modal"></h3>
                    <button id="btn-close" type="button"
                        class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663" stroke="white"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-12 py-4 flex flex-col gap-6">
                    <div class="flex flex-col items-start border-b pb-4">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
                            <ul class="flex flex-wrap -mb-px text-sm text-center font-semibold" id="default-styled-tab"
                                data-tabs-toggle="#default-styled-tab-content"
                                data-tabs-active-classes="text-[#4984F6] hover:text-[#4984F6] dark:text-[#4984F6] dark:hover:text-[#4984F6] border-[#4984F6] dark:border-[#4984F6]"
                                data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                                role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="tab-1"
                                        data-tabs-target="#data-tab-1" type="button" role="tab"
                                        aria-controls="tab-1" aria-selected="false"></button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="tab-2" data-tabs-target="#data-tab-2" type="button" role="tab"
                                        aria-controls="tab-2" aria-selected="false"></button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content" class="w-full">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 " id="data-tab-1"
                                role="tabpanel" aria-labelledby="profile-tab">

                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="data-tab-2"
                                role="tabpanel" aria-labelledby="dashboard-tab">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-2 py-4 pt-8 gap-2 md:gap-6 md:px-12">
                    <button id="btn-cancel" type="button"
                        class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-500 hover:text-white focus:outline-none font-medium rounded-full text-sm sm:w-auto px-5 py-2.5 text-center close-upload-modal">Cancel</button>
                    <button id="btn-save" type="button"
                        class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">Select</button>
                </div>
            </div>
        </div>
    </div>

    <div id="sector-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white" id="title-modal"></h3>
                    <button id="sector-btn-close" type="button"
                        class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                            fill="none">
                            <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663" stroke="white"
                                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-12 py-4 flex flex-col gap-6">
                    <div class="flex flex-col items-start border-b pb-4">
                        <div class="mb-4 border-b border-gray-200 dark:border-gray-700 w-full">
                            <ul class="flex flex-wrap -mb-px text-sm text-center font-semibold" id="default-styled-tab"
                                data-tabs-toggle="#default-styled-tab-content"
                                data-tabs-active-classes="text-[#4984F6] hover:text-[#4984F6] dark:text-[#4984F6] dark:hover:text-[#4984F6] border-[#4984F6] dark:border-[#4984F6]"
                                data-tabs-inactive-classes="dark:border-transparent text-gray-500 hover:text-gray-600 dark:text-gray-400 border-gray-100 hover:border-gray-300 dark:border-gray-700 dark:hover:text-gray-300"
                                role="tablist">
                                <li class="me-2" role="presentation">
                                    <button class="inline-block p-4 border-b-2 rounded-t-lg" id="sector-tab-1"
                                        data-tabs-target="#sector-data-tab-1" type="button" role="tab"
                                        aria-controls="sector-tab-1" aria-selected="false"></button>
                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content" class="w-full">
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 " id="sector-data-tab-1"
                                role="tabpanel" aria-labelledby="profile-tab">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex justify-end px-2 py-4 pt-8 gap-2 md:gap-6 md:px-12">
                    <button id="sector-btn-cancel" type="button"
                        class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-500 hover:text-white focus:outline-none font-medium rounded-full text-sm sm:w-auto px-5 py-2.5 text-center close-upload-modal">Cancel</button>
                    <button id="sector-btn-save" type="button"
                        class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">Select</button>
                </div>
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
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        $(document).ready(function() {
            $('.company').select2({
                placeholder: "{{trans('cgo.job_support.ojt_list.filter.company')}}",
                allowClear: true
            }).val($('#companySelect').val()).trigger('change');

            $('#companySelect').on('change', function() {
                let selectedCompany = $(this).val();
                let url = new URL(window.location.href);

                if (url.searchParams.has('company_id')) {
                    url.searchParams.set('company_id', selectedCompany);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('company_id', selectedCompany);
                    url.searchParams.delete('page');
                }

                window.location.href = url.href;
            });

            // Handle status selection change
            $('#status').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('status')) {
                    url.searchParams.set('status', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('status', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });
            {{--$('#district-modal').on('click', function() {--}}
            {{--    const modal = createModal('default-modal', {--}}
            {{--        onHide: () => {--}}
            {{--            clearModalContent();--}}
            {{--        },--}}
            {{--        closable: false,--}}
            {{--    });--}}
            {{--    //Set up modal content--}}
            {{--    $('#title-modal').text('Location');--}}
            {{--    $('#tab-1').text('Province');--}}
            {{--    $('#tab-2').text('District');--}}
            {{--    const provinces = @json($provinces);--}}
            {{--    let provinceFilter = url.searchParams.get('province');--}}
            {{--    appendOptionAll($('#data-tab-1'), provinceFilter === '' || provinceFilter === null,--}}
            {{--        'province', url);--}}
            {{--    provinces.forEach((province, index) => {--}}
            {{--        const isSelected = url.searchParams.get('province') == province.id;--}}
            {{--        appendProvince(province, index, isSelected);--}}

            {{--        $(`#province${index}`).on('click', function(e) {--}}
            {{--            handleProvinceClick(provinces, index, url);--}}
            {{--        });--}}

            {{--        if (isSelected) {--}}
            {{--            $(`#province${index}`).trigger('click');--}}
            {{--        }--}}
            {{--    });--}}

            {{--    $('#provinces-tab').trigger('click');--}}

            {{--    $('#btn-save').on('click', function() {--}}
            {{--        window.location.href = url.href;--}}
            {{--    });--}}

            {{--    $('#btn-cancel, #btn-close').on('click', function() {--}}
            {{--        modal.hide();--}}
            {{--    });--}}
            {{--    modal.show();--}}
            {{--});--}}
            $('#district-modal').on('click', function() {
                const modal = createModal('default-modal', {
                    onHide: () => {
                        clearModalContent();
                    },
                    closable: false,
                });

                // Set up modal content
                $('#title-modal').text('{{ trans('trainee.job_support.ojt_list.filter.location') }}');
                $('#tab-1').text('Province');
                $('#tab-2').text('District');

                // Make the AJAX call to fetch provinces
                fetch('/api/get-provinces')
                    .then(response => response.json())
                    .then(result => {
                        if (result.success) {
                            const provinces = result.data;
                            let provinceFilter = url.searchParams.get('province');

                            // Append "All" option
                            appendOptionAll($('#data-tab-1'), provinceFilter === '' || provinceFilter === null,
                                'province', url);

                            // Iterate through provinces and append each one to the modal
                            provinces.forEach((province, index) => {
                                const isSelected = url.searchParams.get('province') == province.id;
                                appendProvince(province, index, isSelected);

                                // Handle province click event
                                $(`#province${index}`).on('click', function() {
                                    handleProvinceClick(provinces, index, url);
                                });

                                // Trigger click on selected province
                                if (isSelected) {
                                    $(`#province${index}`).trigger('click');
                                }
                            });

                            // Trigger the provinces tab
                            $('#provinces-tab').trigger('click');
                        } else {
                            console.error('API returned error:', result.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching provinces:', error);
                    });

                // Button save action
                $('#btn-save').on('click', function() {
                    window.location.href = url.href;
                });

                // Button cancel or close action
                $('#btn-cancel, #btn-close').on('click', function() {
                    modal.hide();
                });

                // Show modal
                modal.show();
            });

            // Xử lý toggle sector (tạm thời rỗng, có thể thêm sau)
            $('#sector-modal-open').on('click', function() {
                const modal = createModal('sector-modal', {
                    onHide: () => {
                        clearModalContent();
                    },
                    closable: false,
                });
                $('#title-sector-modal').text('Job category');
                $('#sector-tab-1').text('Job category');
                const sectors = @json($sectors);
                let sectorFilter = url.searchParams.get('sector');
                appendOptionAll($('#sector-data-tab-1'), sectorFilter === '' || sectorFilter === null,
                    'sector', url);
                sectors.forEach((sector, index) => {
                    const isSelected = url.searchParams.get('sector') == sector.id;
                    appendSector(sector, index, isSelected);

                    $(`#sector${index}`).on('click', function(e) {
                        handleSectorClick(sectors, index, url);
                    });

                    if (isSelected) {
                        $(`#sector${index}`).trigger('click');
                    }
                })
                $('#sector-btn-save').off('click').on('click', function() {
                    window.location.href = url.href;
                });

                $('#sector-btn-cancel, #sector-btn-close').off('click').on('click', function() {
                    modal.hide();
                });
                modal.show();
            });

            function clearModalContent() {
                $('#tab-1').empty();
                $('#tab-2').empty();
                $('#data-tab-1').empty();
                $('#data-tab-2').empty();
                $('#sector-tab-1').empty();
                $('#sector-data-tab-1').empty();
            }

            // Hàm để thêm province vào modal
            function appendProvince(province, index, isSelected) {
                const html = itemOptionSlect('province' + index, 'province', province.name, isSelected,
                    `data-index="${index}"`);
                $('#data-tab-1').append(html);
            }

            function appendOptionAll(dataTabEl, isSelected, nameFilter, url) {
                let optionAllId = makeid(10);
                const html = itemOptionSlect(optionAllId, nameFilter, 'All', isSelected);
                dataTabEl.append(html);
                $(`#${optionAllId}`).on('click', function() {
                    if (nameFilter == 'province') {
                        url.searchParams.delete('province');
                        url.searchParams.delete('district');
                        url.searchParams.delete('divisional_secretariat');
                        $('#data-tab-3').empty();
                        $('#data-tab-2').empty();
                    } else if (nameFilter == 'district') {
                        url.searchParams.delete('district');
                        url.searchParams.delete('divisional_secretariat');
                        $('#data-tab-3').empty();
                    } else {
                        url.searchParams.delete('sector');
                    }

                    toggleSelected($(`.${nameFilter}`), $(this));
                });
            }

            function handleProvinceClick(provinces, index, url) {
                toggleSelected($('.province'), $(`#province${index}`));
                $('#tab-2').trigger('click');
                url.searchParams.set('province', provinces[index].id);
                url.searchParams.delete('page');

                $('#data-tab-2').empty();
                let districtFilter = url.searchParams.get('district');
                let flag = false;
                let indexDis = -1;
                appendOptionAll($('#data-tab-2'), districtFilter === '' || districtFilter === null, 'district',
                    url);
                provinces[index].districts.forEach((district, idx) => {
                    const isSelected = districtFilter == district.id;
                    if (isSelected) {
                        flag = true;
                        indexDis = idx;
                    }
                    appendDistrict(provinces[index].districts, district, idx, isSelected, url);


                });
                if (!flag) {
                    url.searchParams.delete('district');
                } else {
                    handleDistrictClick(provinces[index].districts, indexDis, url);
                }
            }

            function handleDistrictClick(districts, index, url) {
                toggleSelected($('.district'), $(`#district${index}`));

                url.searchParams.set('district', districts[index].id);
                url.searchParams.delete('page');

            }

            // Hàm để thêm district vào modal
            function appendDistrict(districts, district, index, isSelected, url) {
                const html = itemOptionSlect('district' + index, 'district', district.name, isSelected,
                    `data-index="${index}" data-district-id="${district.id}"`);
                $('#data-tab-2').append(html);
                $(`#district${index}`).off('click').on('click', function() {
                    toggleSelected($('.district'), $(this));
                    url.searchParams.set('district', $(this).data('district-id'));

                    handleDistrictClick(districts, index, url);
                });
            }

            function appendSector(sector, index, isSelected) {
                const html = itemOptionSlect('sector' + index, 'sector', sector.name, isSelected,
                    `data-index="${index}"`);
                $('#sector-data-tab-1').append(html);
            }

            function handleSectorClick(sectors, index, url) {
                toggleSelected($('.sector'), $(`#sector${index}`));

                url.searchParams.set('sector', sectors[index].id);
                url.searchParams.delete('page');
            }

            // Hàm để toggle trạng thái chọn
            function toggleSelected(allEl, selectedEl) {
                allEl.find('svg.inline-block').removeClass('inline-block').addClass('hidden');
                allEl.removeClass('text-[#4984F6] font-semibold dark:text-[#4984F6]').addClass(
                    'text-[#706F81] dark:text-white font-normal');
                selectedEl.find('svg').removeClass('hidden').addClass('inline-block');
                selectedEl.removeClass('text-[#706F81] dark:text-white font-normal').addClass(
                    'text-[#4984F6] font-semibold dark:text-[#4984F6]');
            }

            // Xử lý lưu trainee vào job
            function handleKeepTrainee(button) {
                const traineeId = button.getAttribute('data-trainee-id');
                const jobId = button.getAttribute('data-job-id');
                toggleLoadingOverlay();
                $.ajax({
                    url: '{{ route('trainee.job-support.job-list.mark') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        trainee_id: traineeId,
                        job_id: jobId,
                    },
                    success: function(response) {
                        const svgElement = button.querySelector('svg');
                        if (response.action === 'mark' || response.action === 'unmark') {
                            svgElement.classList.toggle('fill-primary');
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

            function itemOptionSlect(id, name, title, isSelected, data = '') {
                return `
                <span id="${id}" ${data}
                        class="${name} flex justify-between w-full cursor-pointer
                                hover:text-[#4984F6] hover:font-semibold
                                dark:hover:text-[#4984F6] 1
                                ${isSelected ?
                'text-[#4984F6] dark:text-[#4984F6] font-semibold' :
                'text-[#706F81] dark:text-white font-normal'
            }">
                    ${title}
                    <svg class="${isSelected ? 'inline-block' : 'hidden'}" width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.5 6.00006L9.5 17.0001L4.5 12.0001" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                    `;
            }

            // Hiển thị thông báo Toast
            function showToast(message, duration, status) {
                const bgColor = status === 'success' ?
                    'linear-gradient(to right, #00b09b, #96c93d)' :
                    status === 'error' ?
                    'linear-gradient(to right, #db4a4a, #bb7f7f)' :
                    '#9e9d9d';

                Toastify({
                    text: message,
                    duration: duration,
                    newWindow: true,
                    close: true,
                    gravity: "top",
                    position: "right",
                    stopOnFocus: true,
                    style: {
                        background: bgColor,
                    },
                    onClick: function() {}
                }).showToast();
            }

            // Tạo modal
            function createModal(id, options = null) {
                clearModalContent();
                const targetEl = document.getElementById(id);
                const instanceOptions = {
                    id: id,
                    override: true
                };
                return new Modal(targetEl, options, instanceOptions);
            }

            function makeid(length) {
                let result = '';
                const characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
                const charactersLength = characters.length;
                let counter = 0;
                while (counter < length) {
                    result += characters.charAt(Math.floor(Math.random() * charactersLength));
                    counter += 1;
                }
                return result;
            }
        })
    </script>
@endpush
