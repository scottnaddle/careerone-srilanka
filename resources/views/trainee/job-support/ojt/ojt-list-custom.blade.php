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

        .tab-button {
            /*font-family: Poppins;*/
            font-size: 16px;
            font-style: normal;
            font-weight: 500;
            line-height: 24px;
        }

        .active {
            --tw-bg-opacity: 1;
            background-color: rgb(28 100 242 / var(--tw-bg-opacity));
            --tw-text-opacity: 1;
            color: rgb(255 255 255 / var(--tw-text-opacity));
            border-radius: .5rem;
        }

        .unactive {
            --tw-text-opacity: 1;
            color: rgb(107 114 128 / var(--tw-text-opacity));

        }

        .unactive:hover {
            --tw-text-opacity: 1;
            color: rgb(55 65 81 / var(--tw-text-opacity));
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
        <div class="flex flex-col gap-4">
            <div class="space-y-5">
                @if (activeGuard() != '' && Auth::guard('trainee')->check())
                    <div class="grid grid-cols-3 bg-gray-50 rounded-lg shadow">
                        <button value="" name="status_ojt"
                            class="text-sm sm:text-lg p-4 focus:outline-none w-full text-center rounded-l-lg hover:font-bold @if (request()->get('status_ojt') == '') bg-primary text-white font-bold @else text-[#91919A] bg-[#F8F8F8] @endif ">{{ trans('trainee.job_support.job_list.all') }}</button>
                        <button value="applied" name="status_ojt"
                            class="text-sm sm:text-lg p-4 focus:outline-none w-full text-center hover:font-bold @if (request()->get('status_ojt') == 'applied') bg-primary text-white font-bold @else text-[#91919A] bg-[#F8F8F8] @endif ">{{ trans('trainee.job_support.job_list.applied') }}</button>
                        <button value="matched" name="status_ojt"
                            class="text-sm sm:text-lg p-4 focus:outline-none w-full text-center rounded-r-lg hover:font-bold  @if (request()->get('status_ojt') == 'matched') bg-primary text-white font-bold  @else text-[#91919A] bg-[#F8F8F8] @endif">{{ trans('trainee.job_support.job_list.matched') }}</button>
                    </div>
                @endif
                <div class="flex flex-row gap-4">

                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="title" id="input-search" value="{{ request('title') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            placeholder="{{ __('general.OJT title') }}" />

                    </div>
                    <button id="btn-search"
                        class="flex items-center gap-2 font-semibold text-white bg-[#4984F6] hover:bg-blue-600 focus:ring-4 focus:outline-none
                    rounded-full text-sm px-6 lg:px-12 py-2 text-center dark:bg-[#4984F6] dark:hover:bg-blue-700 dark:focus:ring-blue-800 w-fit">
                        {{ __('company.search') }}
                    </button>
                </div>

            </div>

            <div class="flex flex-col flex-col-reverse gap-2 md:flex-row md:justify-between items-center">
                @php
                    $queryParameters = request()->except(['page', 'sort_by', 'status_ojt']);

                    $hasFilters = collect($queryParameters)
                        ->filter(function ($value) {
                            return !is_null($value) && $value !== '';
                        })
                        ->isNotEmpty();
                @endphp

                @if ($hasFilters)
                    <div class="flex gap-1 flex-col">
                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $ojts->total() }} Results</p>
                        <button type="button" class="flex items-center text-red-700 text-sm whitespace-nowrap"
                            onclick="window.location.href = window.location.origin + window.location.pathname;"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            {{ trans('system.remove_filter') }}</button>
                    </div>
                @else
                    <p></p>
                @endif
                <div class="mt-2 flex gap-4 float-right flex-wrap w-full md:flex-row md:justify-end">
                    <select id="status" name="status"
                        class="w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit text-sm">
                        <option value="">{{ __('company.status') }}</option>
                        @forelse(getCodeList('job_status') as $job_status)
                            <option value="{{ $job_status->code_id }}"
                                {{ request()->input('status') != '' && $job_status->code_id == request()->input('status') ? 'selected' : '' }}>
                                {{ $job_status->code_name }}</option>
                        @empty
                        @endforelse
                    </select>
                    <button value="all" name="district-modal" id="district-modal" type="button"
                        data-modal-target="default-modal"
                        class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit text-sm">
                        <span>
                            @php

                                $locationText = trans('trainee.job_support.ojt_list.filter.location');
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
                        <svg width="20" height="20" viewBox="0 0 16 16" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" />
                        </svg>
                    </button>
                    <select id="filterStatus" name="sort_by"
                        class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit text-sm">
                        <option value="desc" @selected(request()->input('sort_by') == 'desc')>
                            {{ trans('trainee.job_support.ojt_list.filter.recently') }}</option>
                        <option value="asc" @selected(request()->input('sort_by') == 'asc')>
                            {{ trans('trainee.job_support.ojt_list.filter.oldest') }}</option>
                    </select>
                    {{-- @if (activeGuard() == 'trainee')
                        <select id="bookmark" name="bookmark"
                            class="w-auto md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit text-sm">
                            <option value="all">{{ trans('trainee.job_support.company.filter.bookmark.root') }}</option>
                            <option value="mark" @selected(request()->input('bookmark') == 'mark')>
                                {{ trans('trainee.job_support.company.filter.bookmark.mark') }}</option>
                            <option value="unmark" @selected(request()->input('bookmark') == 'unmark')>
                                {{ trans('trainee.job_support.company.filter.bookmark.unmark') }}</option>
                        </select>
                    @endif --}}

                </div>
            </div>
        </div>
        <div class="relative overflow-x-auto">
            @forelse ($ojts as $item)
                <div
                    class="parent border border-gray-300 p-3 md:p-4 rounded-xl shadow-custom-light dark:shadow-custom-dark mt-4 cursor-pointer hover:bg-blue-100 dark:hover:bg-gray-700">
                    <div class="child1 bg-[#FBFBFB] flex h-20 p-2 rounded w-32 md:w-48 relative">
                        @if ($item->company->logo)
                            <img class=" object-cover rounded" src="{{ asset($item->company->logo) }}"
                                alt="{{ $item->title }}">
                        @else
                            <img class=" object-cover rounded" src="{{ asset('uploads/logo_default.png') }}"
                                alt="{{ $item->title }}">
                        @endif
                            @if ($item->status == \App\Enums\JobStatusEnum::PROGRESS->value)
                                <label
                                    class="text-primary max-w-[96%] bg-[#E9F5FF] px-1 md:px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center absolute right-1 text-xs md:text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                         viewBox="0 0 8 9" fill="none">
                                        <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                    </svg>
                                    <span class="truncate">{{ getCodeNameByCodeId('job_status', $item->status) }}</span>
                                </label>
                            @elseif($item->status == \App\Enums\JobStatusEnum::CANCEL->value)
                                <label
                                    class="text-[#706F81] max-w-[96%] bg-[#ECECEC] px-1 md:px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center absolute right-1 left-1 text-xs md:text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                         viewBox="0 0 8 9" fill="none">
                                        <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                    </svg>
                                    <span class="truncate">{{ getCodeNameByCodeId('job_status', $item->status) }}</span>
                                </label>
                            @elseif($item->status == \App\Enums\JobStatusEnum::COMPLETED->value)
                                <label
                                    class="text-green-500 max-w-[96%] bg-green-100 px-1 md:px-4 py-1 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap justify-center absolute right-1 left-1 text-xs md:text-sm">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                         viewBox="0 0 8 9" fill="none">
                                        <circle cx="4" cy="4.49023" r="4" fill="#057a2e" />
                                    </svg>
                                    <span class="truncate">{{ getCodeNameByCodeId('job_status', $item->status) }}</span>
                                </label>
                            @endif
                    </div>
                    <div class="child2 flex flex-col justify-around relative">
                        @if (activeGuard() != '' && Auth::guard('trainee')->check())
                            <div class="flex gap-2 justify-between">
                                <a href="{{ route('trainee.job-support.ojt.ojt-detail', ['id' => $item->id, 'slug' => $item->slug]) }}"
                                    class="text-[#464559] dark:text-white w-fit text-lg font-semibold truncate hover:text-primary"
                                    title="{{ $item->title }}">{{ $item->title }}</a>
                            </div>
                        @else
                            <a href="{{ route('homepage.job-detail', ['job_id' => $item->id, 'slug' => $item->slug]) }}"
                                class="text-[#464559] dark:text-white w-full text-lg font-semibold truncate hover:text-primary text-sm md:text-base"
                                title="{{ $item->title }}">{{ $item->title }}</a>
                        @endif
                        <span class="text-[#706F81] dark:text-white text-sm md:text-base">{{ $item->company->name }}</span>
                        <span class="text-[#91919A] dark:text-white text-xs md:text-sm flex gap-1.5 items-center">
                            <span>
                                {{ getCodeNameByCodeId('job_type', $item->job_type) }}
                            </span>
                        </span>
                        @php
                            $statusOjt = request()->query('status_ojt');
                        @endphp
                        @if (!empty($statusOjt) && $statusOjt == 'matched')
                            @php
                                $matched = \App\Models\OjtTraineeApply::where('ojt_id', $item->id)
                                    ->where('trainee_id', Auth::guard('trainee')->user()->id)
                                    ->where('apply_type', \App\Enums\TypeTraineeApply::OJT_MATCH)
                                    ->first();
                            @endphp

                                <span class="text-sm px-2.5 py-1 rounded shadow-xs text-white bg-primary w-fit">
                                {{ \App\Enums\TypeTraineeApply::getNameByKey('ojt_match') }}
                                {{ getCGOName($matched->trainee_id, $matched->ojt_id,'ojt') }} -
                                {{ $matched->matchedBy->institute->name }}
                        </span>
                        @endif
                    </div>
                    <div class="child3 flex flex-col gap-3 items-end ">
                        @if (activeGuard() != '' && Auth::guard(activeGuard())->check() && activeGuard() == 'trainee')
                            <div class="flex gap-1">
                                @php
                                    $statusOjt = request()->query('status_ojt');
                                @endphp

                                    @php
                                        $applyType = null;

                                        if ($statusOjt == 'matched') {
                                            $applyType = [\App\Enums\TypeTraineeApply::OJT_MATCH];
                                        } elseif ($statusOjt == 'applied') {
                                            $applyType = [\App\Enums\TypeTraineeApply::APPLY];
                                        } else {
                                            $applyType = [
                                                \App\Enums\TypeTraineeApply::APPLY,
                                                \App\Enums\TypeTraineeApply::OJT_MATCH,
                                            ];
                                        }

                                        $apply = \App\Models\OjtTraineeApply::where('ojt_id', $item->id)
                                            ->where('trainee_id', Auth::guard('trainee')->user()->id)
                                            ->whereIn('apply_type', $applyType)
                                            ->first();
                                    @endphp
                                    <div class="flex gap-1">
                                        <span
                                            class="text-sm text-primary flex gap-1 items-center font-semibold read-cv {{ empty($apply->read) ? 'hidden' : '' }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17"
                                                viewBox="0 0 16 17" fill="none">
                                                <path
                                                    d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675"
                                                    stroke="#4984F6" stroke-width="1.5" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            Read
                                        </span>
                                        <div class="flex gap-2">
                                            <span
                                                class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold flex flex-col justify-center {{ empty($apply->selected) || !empty($apply->employeed) ? 'hidden' : '' }} selected-cv">{{trans('company.Selected')}}</span>
                                            <span
                                                class="text-sm text-red-600 px-2 py-1 rounded-xl font-semibold flex flex-col justify-center bg-red-100 {{ empty($apply->unselect_at) ? 'hidden' : '' }} selected-cv">{{trans('company.Unselected')}}</span>
                                            <span
                                                class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold flex flex-col justify-center  {{ empty($apply->employeed) ? 'hidden' : '' }} employeed-trainee">{{trans('admin/status.approved')}}</span>
                                        </div>
                                    </div>

                            </div>
                            <span class="text-[#464559] dark:text-white">
                                @if ($item->min_salary && $item->max_salary)
                                    {{ $item->min_salary }} - {{ $item->max_salary }} {{ $item->salary_currency }}
                                    @endif @if ($item->discussion_salary)
                                        - Discussion
                                    @endif
                            </span>
                        @endif

                    </div>

                </div>
            @empty
                <div class="flex flex-col gap-4 justify-center items-center">
                    <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                </div>
            @endforelse
        </div>
        {{ $ojts->appends(request()->query())->onEachSide(1)->links() }}
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
                <div class="px-6 md:px-12 py-4 flex flex-col gap-6">
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
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 h-96 overflow-y-auto" id="data-tab-1"
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
                <div class="px-6 md:px-12 py-4 flex flex-col gap-6 overflow-y-auto h-[70vh] md:h-full">
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
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 h-96 overflow-y-auto" id="sector-data-tab-1"
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
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        let url = new URL(window.location.href);
        $('#bookmark').on('change', function() {
            if (url.searchParams.has('bookmark')) {
                url.searchParams.set('bookmark', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('bookmark', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
        $('select[name=sort_by]').on('change', function() {
            if (url.searchParams.has('sort_by')) {
                url.searchParams.set('sort_by', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('sort_by', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });

        $('#status').on('change', function() {
            if (url.searchParams.has('status')) {
                url.searchParams.set('status', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('status', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;

        });
    </script>
    <script>
        $(document).ready(function() {
            let url = new URL(window.location.href);
            $('button[name=status_ojt]').on('click', function() {
                url.searchParams.set('status_ojt', $(this).val());
                url.searchParams.delete('page');
                window.location.href = url.href;
            });
            $('#btn-search').on('click', function() {
                url.searchParams.set('title', $('#input-search').val());
                url.searchParams.delete('page');
                window.location.href = url.href;
            })
            // Handle job bookmark
            $('.btn-bookmark-job').on('click', function() {
                const svgElement = $(this).find('svg');
                svgElement.addClass('fill-primary');
            });

            // Handle modal opening
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

            // Handle sector toggle (currently empty, may be added later)
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
        });

        // Function to clear modal content
        function clearModalContent() {
            $('#tab-1').empty();
            $('#tab-2').empty();
            $('#data-tab-1').empty();
            $('#data-tab-2').empty();
            $('#sector-tab-1').empty();
            $('#sector-data-tab-1').empty();
        }

        // Function to add a province to the modal
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
            appendOptionAll($('#data-tab-2'), districtFilter === '' || districtFilter === null, 'district', url);
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

        // Function to add a district to the modal
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
            const html = itemOptionSlect('sector' + index, 'sector', sector.name, isSelected, `data-index="${index}"`);
            $('#sector-data-tab-1').append(html);
        }

        function handleSectorClick(sectors, index, url) {
            toggleSelected($('.sector'), $(`#sector${index}`));

            url.searchParams.set('sector', sectors[index].id);
            url.searchParams.delete('page');
        }

        // Function to toggle selected state
        function toggleSelected(allEl, selectedEl) {
            allEl.find('svg.inline-block').removeClass('inline-block').addClass('hidden');
            allEl.removeClass('text-[#4984F6] font-semibold dark:text-[#4984F6]').addClass(
                'text-[#706F81] dark:text-white font-normal');
            selectedEl.find('svg').removeClass('hidden').addClass('inline-block');
            selectedEl.removeClass('text-[#706F81] dark:text-white font-normal').addClass(
                'text-[#4984F6] font-semibold dark:text-[#4984F6]');
        }

        // Handle saving trainee to job
        function handleKeepTrainee(button) {
            console.log(button)
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

        // Display Toast notification
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

        // Create modal
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
    </script>
@endpush
