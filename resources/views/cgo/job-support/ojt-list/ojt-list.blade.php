@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - OJT List')

@push('css')
    <style>
        .checkbox:checked {
            transform: scale(1.25);
        }

        input[type="checkbox"]:checked {
            background-color: white;
            /* White background */
            border-color: white;
            background-image: url('data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="black" class="check-icon"%3E%3Cpath d="M20.292 5.292a1 1 0 011.416 1.416l-11 11a1 1 0 01-1.416 0l-5-5a1 1 0 011.416-1.416L10 14.585l9.292-9.293z" /%3E%3C/svg%3E');
            background-size: 100% 100%;
            background-position: center;
            background-repeat: no-repeat;
        }

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
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.root') }}</p> --}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.menu.job_support.ojt_list'), 'url' => route('cgo.job-support.ojt-list.list')],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                {{-- @if (Auth::guard(activeGuard())->check())
                    <a href="{{ route('cgo.job-support.ojt-list.registration') }}"
                        class="inline-flex w-fit items-center text-xs leading-4 justify-center font-medium px-4 py-2.5 text-white rounded-full cursor-pointer bg-primary">
                        OJT Registration
                        <svg class="w-4 h-4 text-white dark:text-white ms-2" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                            viewBox="0 0 24 24">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 12h14m-7 7V5" />
                        </svg>

                    </a>
                @endif --}}
                <form action="{{ route('cgo.job-support.ojt-list.list') }}" method="GET">

                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search"
                                class="sr-only">{{ trans('cgo.job_support.ojt_list.search') }}</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" value="{{ request('title') }}" name="title"
                                    class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                    placeholder="{{ __('general.OJT title') }}" />
                            </div>
                            <button type="submit"
                                class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                {{ trans('cgo.job_support.ojt_list.search') }}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="flex flex-row justify-between items-center gap-4">
                    <div class="">
                        @if (
                            (request()->has('title') && request()->query('title') != '') ||
                                (request()->has('district') && request()->query('district') != 'all') ||
                                (request()->has('sector') && request()->query('sector') != 'all') ||
                                (request()->has('nvq_level') && request()->query('nvq_level') != 'all' && request()->query('nvq_level') != ''))
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white whitespace-nowrap">{{ $ojts->total() }}
                                {{ trans('cgo.job_support.ojt_list.filterResults') }}</p>
                        @else
                            <p></p>
                        @endif
                    </div>
                    <div class="flex flex-wrap md:flex-row w-full gap-4 items-end justify-end">
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
                            class="company w-fit font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-semibold placeholder:text-[#201F36]"
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
{{--                        <select id="sort_by" name="sort_by"--}}
{{--                            class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">--}}
{{--                            <option value="">{{ trans('cgo.job_support.ojt_list.filter.sort') }}</option>--}}
{{--                            <option value="desc" @selected(request()->input('sort_by') == 'desc')>{{ trans('cgo.job_support.ojt_list.filter.recently') }}</option>--}}
{{--                            <option value="asc" @selected(request()->input('sort_by') == 'asc')>{{ trans('cgo.job_support.ojt_list.filter.oldest') }}</option>--}}
{{--                        </select>--}}

                        <select id="sort_by" name="sort_by"
                                class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="desc" @selected(request()->input('sort_by') == 'desc')>
                                {{ trans('cgo.job_support.job_list.filter.recently') }}</option>
                            <option value="asc" @selected(request()->input('sort_by') == 'asc')>
                                {{ trans('cgo.job_support.job_list.filter.oldest') }}</option>
                        </select>

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
                    <!-- Modal toggle -->
{{--                    <div class="flex md:hidden">--}}
{{--                        <button--}}
{{--                            class="text-base block p-2.5 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"--}}
{{--                            type="button" data-modal-target="defaultModal" data-modal-toggle="defaultModal">--}}
{{--                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 48 48"--}}
{{--                                fill="none">--}}
{{--                                <path--}}
{{--                                    d="M0 12C0 5.37258 5.37258 0 12 0H36C42.6274 0 48 5.37258 48 12V36C48 42.6274 42.6274 48 36 48H12C5.37258 48 0 42.6274 0 36V12Z"--}}
{{--                                    fill="#282828" />--}}
{{--                                <path--}}
{{--                                    d="M24 16.25C23.5858 16.25 23.25 16.5858 23.25 17C23.25 17.4142 23.5858 17.75 24 17.75V16.25ZM32 17.75C32.4142 17.75 32.75 17.4142 32.75 17C32.75 16.5858 32.4142 16.25 32 16.25V17.75ZM24 30.25C23.5858 30.25 23.25 30.5858 23.25 31C23.25 31.4142 23.5858 31.75 24 31.75V30.25ZM32 31.75C32.4142 31.75 32.75 31.4142 32.75 31C32.75 30.5858 32.4142 30.25 32 30.25V31.75ZM24 24.75C24.4142 24.75 24.75 24.4142 24.75 24C24.75 23.5858 24.4142 23.25 24 23.25V24.75ZM16 23.25C15.5858 23.25 15.25 23.5858 15.25 24C15.25 24.4142 15.5858 24.75 16 24.75L16 23.25ZM24 17.75L32 17.75V16.25L24 16.25V17.75ZM24 31.75H32V30.25H24V31.75ZM24 23.25L16 23.25L16 24.75L24 24.75V23.25ZM15.25 17C15.25 18.5188 16.4812 19.75 18 19.75V18.25C17.3096 18.25 16.75 17.6904 16.75 17H15.25ZM18 19.75C19.5188 19.75 20.75 18.5188 20.75 17H19.25C19.25 17.6904 18.6904 18.25 18 18.25V19.75ZM20.75 17C20.75 15.4812 19.5188 14.25 18 14.25V15.75C18.6904 15.75 19.25 16.3096 19.25 17H20.75ZM18 14.25C16.4812 14.25 15.25 15.4812 15.25 17H16.75C16.75 16.3096 17.3096 15.75 18 15.75V14.25ZM15.25 31C15.25 32.5188 16.4812 33.75 18 33.75V32.25C17.3096 32.25 16.75 31.6904 16.75 31H15.25ZM18 33.75C19.5188 33.75 20.75 32.5188 20.75 31H19.25C19.25 31.6904 18.6904 32.25 18 32.25V33.75ZM20.75 31C20.75 29.4812 19.5188 28.25 18 28.25V29.75C18.6904 29.75 19.25 30.3096 19.25 31H20.75ZM18 28.25C16.4812 28.25 15.25 29.4812 15.25 31H16.75C16.75 30.3096 17.3096 29.75 18 29.75V28.25ZM32.75 24C32.75 22.4812 31.5188 21.25 30 21.25V22.75C30.6904 22.75 31.25 23.3096 31.25 24H32.75ZM30 21.25C28.4812 21.25 27.25 22.4812 27.25 24H28.75C28.75 23.3096 29.3096 22.75 30 22.75V21.25ZM27.25 24C27.25 25.5188 28.4812 26.75 30 26.75V25.25C29.3096 25.25 28.75 24.6904 28.75 24H27.25ZM30 26.75C31.5188 26.75 32.75 25.5188 32.75 24H31.25C31.25 24.6904 30.6904 25.25 30 25.25V26.75Z"--}}
{{--                                    fill="#878787" />--}}
{{--                            </svg>--}}
{{--                        </button>--}}


{{--                        <!-- Main modal -->--}}
{{--                        <form action="{{ route('cgo.job-support.ojt-list.list') }}" method="GET" id="defaultModal"--}}
{{--                            tabindex="-1" aria-hidden="true"--}}
{{--                            class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-modal md:h-full">--}}
{{--                            <div class="relative w-full h-full max-w-md md:h-auto">--}}
{{--                                <!-- Modal content -->--}}
{{--                                <div class="relative rounded-lg shadow">--}}
{{--                                    <div class="bg-gray-900 dark:bg-[#2E2E2E] p-4 rounded-lg">--}}
{{--                                        <div class="flex items-start justify-between py-4 rounded-t">--}}
{{--                                            <h2 class="text-2xl font-bold mb-4 text-white">Filter</h2>--}}
{{--                                            <button type="button"--}}
{{--                                                class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white"--}}
{{--                                                data-modal-toggle="defaultModal">--}}
{{--                                                <svg aria-hidden="true" class="w-5 h-5" fill="currentColor"--}}
{{--                                                    viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">--}}
{{--                                                    <path fill-rule="evenodd"--}}
{{--                                                        d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"--}}
{{--                                                        clip-rule="evenodd"></path>--}}
{{--                                                </svg>--}}
{{--                                                <span class="sr-only">Close modal</span>--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-6">--}}
{{--                                            <h3 class="font-semibold text-lg mb-2 text-white">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.mobileFilter.nvq_level') }}</h3>--}}
{{--                                            <ul class="space-y-2">--}}
{{--                                                @foreach ($nvqs as $index => $nvq)--}}
{{--                                                    <li class="@if ($index >= 10) hidden nvq-hidden @endif">--}}
{{--                                                        <label class="flex items-center">--}}
{{--                                                            <input type="checkbox" value="{{ $nvq->id }}"--}}
{{--                                                                @checked(is_array(request('nvq_level')) && in_array($nvq->id, request('nvq_level'))) name="nvq_level[]"--}}
{{--                                                                class="w-5 h-5 form-checkbox text-white bg-transparent border-white border-2 rounded focus:ring-0">--}}
{{--                                                            <span--}}
{{--                                                                class="ml-3 text-white font-normal text-base">{{ $nvq->name }}</span>--}}
{{--                                                        </label>--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                            <div class="flex justify-end">--}}
{{--                                                <a href="#" id="read-more-link"--}}
{{--                                                    class="text-white text-sm hover:underline mt-2">{{ trans('cgo.job_support.ojt_list.mobileFilter.readmore') }}</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-6">--}}
{{--                                            <h3 class="font-semibold text-lg mb-2 text-white">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.mobileFilter.district') }}</h3>--}}
{{--                                            <ul class="space-y-2">--}}
{{--                                                @foreach ($districts as $index => $district)--}}
{{--                                                    <li--}}
{{--                                                        class="@if ($index >= 10) hidden district-hidden @endif">--}}
{{--                                                        <label class="flex items-center">--}}
{{--                                                            <input type="checkbox" value="{{ $district->id }}"--}}
{{--                                                                @checked(is_array(request('district')) && in_array($district->id, request('district'))) name="district[]"--}}
{{--                                                                class="w-5 h-5 form-checkbox text-white bg-transparent border-white border-2 rounded focus:ring-0">--}}
{{--                                                            <span--}}
{{--                                                                class="ml-3 text-white font-normal text-base">{{ $district->name }}</span>--}}
{{--                                                        </label>--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                            <div class="flex justify-end">--}}
{{--                                                <a href="#" id="read-more-link-district"--}}
{{--                                                    class="text-white text-sm hover:underline mt-2">{{ trans('cgo.job_support.ojt_list.mobileFilter.readmore') }}</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="mb-6">--}}
{{--                                            <h3 class="font-semibold text-lg mb-2 text-white">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.mobileFilter.sector') }}</h3>--}}
{{--                                            <ul class="space-y-2">--}}
{{--                                                @foreach ($sectors as $index => $sector)--}}
{{--                                                    <li--}}
{{--                                                        class="@if ($index >= 10) hidden sector-hidden @endif">--}}
{{--                                                        <label class="flex items-center">--}}
{{--                                                            <input type="checkbox" value="{{ $sector->id }}"--}}
{{--                                                                @checked(is_array(request('sector')) && in_array($sector->id, request('sector'))) name="sector[]"--}}
{{--                                                                class="w-5 h-5 form-checkbox text-white bg-transparent border-white border-2 rounded focus:ring-0">--}}
{{--                                                            <span--}}
{{--                                                                class="ml-3 text-white font-normal text-base">{{ $sector->name }}</span>--}}
{{--                                                        </label>--}}
{{--                                                    </li>--}}
{{--                                                @endforeach--}}
{{--                                            </ul>--}}
{{--                                            <div class="flex justify-end">--}}
{{--                                                <a href="#" id="read-more-link-sector"--}}
{{--                                                    class="text-white text-sm hover:underline mt-2">{{ trans('cgo.job_support.ojt_list.mobileFilter.readmore') }}</a>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}

{{--                                        <div class="flex items-center space-x-4 rounded-b dark:border-gray-600">--}}
{{--                                            <button type="submit"--}}
{{--                                                class="bg-primary dark:bg-white dark:text-black py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.mobileFilter.apply') }}--}}
{{--                                            </button>--}}
{{--                                            <button type="button" id="reset-btn"--}}
{{--                                                class="py-2.5 px-5 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-primary-700 focus:z-10 focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">--}}
{{--                                                {{ trans('cgo.job_support.ojt_list.mobileFilter.reset') }}--}}
{{--                                            </button>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <!-- Modal header -->--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </form>--}}
{{--                    </div>--}}



                </div>
                <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold">
                    <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                    {{ trans('cgo.job_support.ojt_list.root') }}
                </span>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap w-1/3">
                                    {{ trans('cgo.job_support.ojt_list.table.label.ojt_title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.company') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-pre-line">
                                    {!! trans('general.Number Of Recruitments')  !!}
                                </th>
{{--                                <th scope="col"--}}
{{--                                    class="px-4 py-6 text-primary dark:text-white font-semibold text-base whitespace-nowrap">--}}
{{--                                    {{ trans('cgo.job_support.ojt_list.table.label.required_skills') }}--}}
{{--                                </th>--}}
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.closing_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.status.root') }}
                                </th>
                                <th scope="col" colspan="3"
                                    class="px-4 py-2 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('cgo.job_support.ojt_list.table.label.ojt_match') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ojts as $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                    <td scope="row"
                                        class="text-left px-2 py-6 font-semibold text-sm text-[#201F36] dark:text-white w-1/3 hover:text-primary">
                                        <a
                                            href="{{ route('cgo.job-support.ojt-list.ojt_detail', ['id' => $item->id]) }}" data-tooltip-target="full-text-{{$item->id}}" data-tooltip-style="light" class="dark:text-white">{{ \Str::limit($item->title, 20) }}</a>
                                        <div id="full-text-{{$item->id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                            {{$item->title}}
                                            <div class="tooltip-arrow" data-popper-arrow></div>
                                        </div>
                                    </td>
                                    <td scope="row" class="px-2 py-6 text-sm text-[#201F36] dark:text-white">
                                        {{ \Str::limit($item->company->name, 25) }}
                                    </td>
{{--                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-left">--}}
{{--                                        @if ($item->work_experience_limitation)--}}
{{--                                        {{ trans('cgo.job_support.ojt_list.not_limitation') }}--}}
{{--                                        @else--}}
{{--                                            @if (!empty($item->min_work_experience) && !empty($item->max_work_experience))--}}
{{--                                                {{ \Str::limit($item->min_work_experience . ' - ' . $item->max_work_experience, 20) }}--}}
{{--                                            @elseif (!empty($item->min_work_experience))--}}
{{--                                                {{\Str::limit($item->min_work_experience)}}--}}
{{--                                            @elseif (!empty($item->max_work_experience))--}}
{{--                                                {{\Str::limit($item->max_work_experience)}}--}}
{{--                                            @endif--}}
{{--                                        @endif--}}
{{--                                    </td>--}}
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white text-center">
                                        {{$item->number_of_recruitments}}
                                    </td>
{{--                                    <td scope="row"--}}
{{--                                        class="px-2 py-6 font-semibold text-sm text-[#201F36] dark:text-white hover:text-primary">--}}
{{--                                        {{ \Str::limit($item->required_skills, 20) }}--}}
{{--                                    </td>--}}
                                    <td class="px-2 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {{ $item->application_endtime != null ? date("Y-m-d", strtotime($item->application_endtime)) : '' }}
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
                                    <td class="px-2 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        <a href="{{ route('cgo.job-support.ojt-list.trainee-match', ['slug' => $item->slug]) }}"
                                            class="whitespace-nowrap py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">{{ trans('cgo.job_support.ojt_list.table.trainee_match_button') }}
                                        </a>
                                    </td>
                                    <td class="px-2 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4] justify-center">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('cgo.job-support.ojt-list.list-matched', ['slug' => $item->slug]) }}"
                                               class="whitespace-nowrap text-primary text-sm font-medium flex items-center gap-1 justify-center dark:text-primary hover:text-blue-900 dark:hover:text-primary">{{ trans('cgo.job_support.ojt_list.table.list_matched') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M6.5 12.001L10.5 8.00098L6.5 4.00098" stroke="currentColor"
                                                          stroke-width="2" stroke-linecap="round"
                                                          class="hover:stroke-blue-900 dark:hover:stroke-primary"
                                                          stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                            <span class="dark:text-white">{{$item->matched?->count()}}</span>
                                        </div>

                                    </td>
                                    <td class="px-2 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4] justify-center">
                                        <div class="flex flex-col gap-1">
                                            <a href="{{ route('cgo.job-support.ojt-list.list-applied', ['slug' => $item->slug]) }}"
                                               class="whitespace-nowrap text-primary text-sm font-medium flex items-center gap-1 justify-center dark:text-primary hover:text-blue-900 dark:hover:text-primary">{{ trans('cgo.job_support.ojt_list.table.list_applied') }}
                                                <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16"
                                                     viewBox="0 0 17 16" fill="none">
                                                    <path d="M6.5 12.001L10.5 8.00098L6.5 4.00098" stroke="currentColor"
                                                          stroke-width="2" stroke-linecap="round"
                                                          class="hover:stroke-blue-900 dark:hover:stroke-primary"
                                                          stroke-linejoin="round" />
                                                </svg>
                                            </a>
                                            <span class="dark:text-white">{{$item->applied?->count()}}</span>
                                        </div>

                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">{{ trans('cgo.job_support.ojt_list.no_record') }}</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse


                        </tbody>
                    </table>

                </div>
                {{ $ojts->onEachSide(1)->links() }}
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        $(document).ready(function() {
            $('#nvq_level').select2({
                placeholder: "Select NVQ",
                allowClear: true
            });

            $('#nvq_level').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('nvq_level')) {
                    url.searchParams.set('nvq_level', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('nvq_level', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });
            // Handle the Select2 unselect event (for clearing the selection with the X button)
            $('#nvq_level').on('select2:unselect', function(e) {
                let url = new URL(window.location.href);

                // Remove the 'nvq_level' parameter when the selection is cleared
                if (url.searchParams.has('nvq_level')) {
                    url.searchParams.delete('nvq_level');
                    url.searchParams.append('nvq_level', 'all');
                    url.searchParams.delete('page'); // Remove page parameter
                }
                window.location.href = url.href; // Redirect to updated URL
            });

            $('#district').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('district')) {
                    url.searchParams.set('district', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('district', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });

            $('#sector').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('sector')) {
                    url.searchParams.set('sector', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('sector', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });
        })
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

            // Handle sort_by selection change
            $('#sort_by').on('change', function() {
                let url = new URL(window.location.href);
                if (url.searchParams.has('sort_by')) {
                    url.searchParams.set('sort_by', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('sort_by', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            });

            // Confirm deletion in modal
            $(".btn-delete").click(function() {
                $("#delete-modal a").attr('href', '/company/job-support/ojt-list/delete/' + $(this).data(
                    'id'));
            });
            let url = new URL(window.location.href);

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


            // Function to toggle the selected state
            function toggleSelected(allEl, selectedEl) {
                allEl.find('svg.inline-block').removeClass('inline-block').addClass('hidden');
                allEl.removeClass('text-[#4984F6] font-semibold dark:text-[#4984F6]').addClass(
                    'text-[#706F81] dark:text-white font-normal');
                selectedEl.find('svg').removeClass('hidden').addClass('inline-block');
                selectedEl.removeClass('text-[#706F81] dark:text-white font-normal').addClass(
                    'text-[#4984F6] font-semibold dark:text-[#4984F6]');
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
        });
    </script>
    <script>
        document.getElementById('read-more-link').addEventListener('click', function(event) {
            event.preventDefault();
            // Toggle the visibility of the hidden items
            let hiddenItems = document.querySelectorAll('.nvq-hidden');
            hiddenItems.forEach(function(item) {
                item.classList.toggle('hidden');
            });

            // Change the "Read more" text to "Show less" when expanded
            if (this.textContent === 'Read more') {
                this.textContent = 'Show less';
            } else {
                this.textContent = 'Read more';
            }
        });

        document.getElementById('read-more-link-district').addEventListener('click', function(event) {
            event.preventDefault();
            // Toggle the visibility of the hidden items
            let hiddenItems = document.querySelectorAll('.district-hidden');
            hiddenItems.forEach(function(item) {
                item.classList.toggle('hidden');
            });

            // Change the "Read more" text to "Show less" when expanded
            if (this.textContent === 'Read more') {
                this.textContent = 'Show less';
            } else {
                this.textContent = 'Read more';
            }
        });

        document.getElementById('read-more-link-sector').addEventListener('click', function(event) {
            event.preventDefault();
            // Toggle the visibility of the hidden items
            let hiddenItems = document.querySelectorAll('.sector-hidden');
            hiddenItems.forEach(function(item) {
                item.classList.toggle('hidden');
            });

            // Change the "Read more" text to "Show less" when expanded
            if (this.textContent === 'Read more') {
                this.textContent = 'Show less';
            } else {
                this.textContent = 'Read more';
            }
        });

        document.getElementById('reset-btn').addEventListener('click', function(event) {
            event.preventDefault();
            // Get all checkboxes in the document and uncheck them
            let checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
        });


    </script>
@endpush
