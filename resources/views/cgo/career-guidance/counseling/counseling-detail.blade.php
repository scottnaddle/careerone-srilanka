@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Counseling - Create Offline')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.career_guidance.counseling.root'), 'url' => '#'],
                ['label' => trans('cgo.counseling_list'), 'url' => route('cgo.career-guidance.counseling.counseling-list')],
                ['label' => trans('cgo.Details'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}"
                class="flex items-center gap-2 text-[#464559] dark:text-white text-xl font-semibold w-fit">
                <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" class="dark:stroke-white"
                        stroke-linecap="round" stroke-linejoin="round" />
                </svg>
                {{ $counseling->traineeUser->fullName ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}</a>
            @if (session()->has('success'))
                <div
                    class="alert alert-success text-green-600 dark:text-black font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif
            @if ($errors->any())
                {!! implode(
                    '',
                    $errors->all(
                        '<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>',
                    ),
                ) !!}
            @endif
{{--            @if ($counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Counseling without reservation'))--}}
                <div class="flex items-start justify-between">
                    <div class="flex flex-col lg:flex-row gap-6 border-b ">
                        <div class="flex flex-col gap-4 items-center justify-center">
                            @if ($counseling->traineeUser && $counseling->traineeUser->profile_image != '')
                                <img class="w-32 h-32 rounded-full" src="{{ asset($counseling->traineeUser->profile_image) }}"
                                     alt="user photo">
                            @else
                                <img class="w-32 h-32 rounded-full" src="{{ asset('/images/user-default.svg') }}"
                                     alt="user photo">
                            @endif
                            <div class="flex-col flex items-center justify-center gap-2">
                                <p class="text-[#464559] dark:text-white text-xl font-semibold" id="trainee-name-heading">
                                    {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}</p>
                                @if($counseling->trainee_id)
                                    <p class="text-[#706F81] dark:text-white text-sm" id="trainee-short-bio">
                                        <button data-popover-target="popover-summary-training-information" type="button"
                                                class="text-primary dark:text-white text-sm underline">View summary profile</button>
                                    </p>
                                    <div data-popover id="popover-summary-training-information" role="tooltip"
                                         class="p-4 bg-gray-100 absolute z-10 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">

                                        {!! getSumaryTraining($counseling->trainee_id) !!}

                                        <div data-popper-arrow></div>
                                    </div>
                                @else
                                    <p class="dark:text-white text-sm">NIC: {{$counseling->trainee_nic}}</p>
                                @endif
                            </div>
                            @if ($counseling->traineeUser &&
                                ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm') ||
                                    $counseling->status == getCodeIdByStringEn('counselling_status', 'completed')))
                                <a href="{{ route('cgo.job-support.trainee-list.job-match', ['trainee' => $counseling->traineeUser->id]) }}"
                                   class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                        text-base px-8 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Job
                                    match</a>
                            @else
                            @endif

                        </div>
                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <p class="text-[#91919A] dark:text-white" id="expertise_heading_block"></p>
                        </div>
                        <div class="flex flex-col gap-4 p-4 sm:pl-20">
                            <div class="py-6 flex flex-col gap-9">
                                <div class="py-4 border-b">
                                    <span class="text-primary font-semibold">Status:</span>
                                    <div class="mt-2 text-sm">
                                        @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
                                            <label
                                                class="text-[#62B96A] bg-[#F5FFF1] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ __('cgo.completed') }}</label>
                                        @endif
                                        @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'request'))
                                            <label
                                                class="text-[#91919A] bg-[#F8F8F8] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ __('cgo.request') }}</label>
                                        @endif
                                        @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                                            <label
                                                class="text-primary bg-[#F6FBFF] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg">{{ __('cgo.confirm') }}</label>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <div class="flex flex-col gap-4 lg:flex-row">
                                        <div class="flex flex-col gap-4">
                                            <div class="flex items-center gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M14.168 12.0833V9.57866C14.168 9.4291 14.168 9.35431 14.1452 9.28829C14.1251 9.22991 14.0922 9.17673 14.049 9.1326C14.0001 9.08271 13.9332 9.04927 13.7994 8.98238L10.0013 7.08331M3.33464 7.91664V13.5888C3.33464 13.8987 3.33464 14.0537 3.38298 14.1894C3.42573 14.3093 3.49539 14.4179 3.58662 14.5067C3.68981 14.6072 3.8307 14.6718 4.11243 14.8009L9.44576 17.2454C9.65013 17.339 9.75231 17.3859 9.85875 17.4043C9.95308 17.4207 10.0495 17.4207 10.1439 17.4043C10.2503 17.3859 10.3525 17.339 10.5568 17.2454L15.8902 14.8009C16.1719 14.6718 16.3128 14.6072 16.416 14.5067C16.5072 14.4179 16.5769 14.3093 16.6196 14.1894C16.668 14.0537 16.668 13.8987 16.668 13.5888V7.91664M1.66797 7.08331L9.70316 3.06571C9.81248 3.01105 9.86714 2.98372 9.92447 2.97297C9.97525 2.96344 10.0274 2.96344 10.0781 2.97297C10.1355 2.98372 10.1901 3.01105 10.2994 3.06571L18.3346 7.08331L10.2994 11.1009C10.1901 11.1556 10.1355 11.1829 10.0781 11.1936C10.0274 11.2032 9.97525 11.2032 9.92447 11.1936C9.86714 11.1829 9.81248 11.1556 9.70316 11.1009L1.66797 7.08331Z"
                                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                @if($counseling->trainee_id)
                                                    <span class="text-sm text-[#464559] dark:text-white" id="trainee-school"><button
                                                            data-popover-target="popover-summary-institute" type="button"
                                                            class="text-primary dark:text-white text-sm underline">View
                                                    Institutes</button></span>
                                                    <div data-popover id="popover-summary-institute" role="tooltip"
                                                         class="p-4 items-center bg-gray-100 absolute z-10 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                                        {!! getInstitutes($counseling->trainee_id) !!}
                                                        <div data-popper-arrow></div>
                                                    </div>
                                                @else
                                                    <span class="text-sm text-[#464559] dark:text-white" id="trainee-school">{{\Str::limit($counseling->trainee_offline_institute, 50)  ?? 'N/G'}}</span>
                                                @endif
                                            </div>
                                            <div class="flex items-center gap-4 dark:text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87037 6.6356 6.82145 6.92248 6.88953 7.15608C6.90874 7.22184 6.93369 7.27367 6.98356 7.37779Z"
                                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                {{ $counseling->traineeUser ?
                                                    ($counseling->traineeUser->mobile ?? $counseling->traineeUser->telephone ?? $counseling->trainee_offline_mobile ?? 'N/G') :
                                                    ($counseling->trainee_offline_mobile ?? 'N/G') }}
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-4">
                                            <div class="flex items-center gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M13.8257 11.2418C15.1521 11.7909 16.0738 13.0434 16.268 14.4989C16.2779 14.5723 16.2828 14.609 16.284 14.6388C16.2982 14.9981 16.0131 15.3015 15.6538 15.3015H4.34625C4.01721 15.3015 3.74154 15.0259 3.74154 14.6968C3.74254 14.6513 3.74514 14.618 3.75519 14.5647C3.95078 13.0951 4.88689 11.8218 6.19262 11.2525M13.8257 11.2418C13.1286 10.9511 12.3992 10.7333 11.6538 10.5918M13.8257 11.2418C14.454 10.8236 14.9903 10.2911 15.4097 9.67001C15.8291 9.04891 16.1222 8.35073 16.2735 7.61555M11.6538 10.5918C11.1873 10.5011 10.6934 10.4525 10.1825 10.4525C9.67156 10.4525 9.17773 10.5011 8.7112 10.5918M11.6538 10.5918C12.1687 9.83784 12.5 8.87702 12.5 7.83317C12.5 5.54709 10.4852 3.75001 7.91667 3.75001C6.57083 3.75001 5.37027 4.27643 4.54097 5.13056C3.71167 5.98469 3.33334 7.11317 3.33334 8.33334C3.33334 9.37718 3.66464 10.338 4.17949 11.0918M8.7112 10.5918C8.35562 11.1041 7.85781 11.5133 7.2683 11.7771M8.7112 10.5918C9.19101 11.3076 10.0416 11.7811 10.9979 11.8405C10.9951 12.6698 10.9965 13.3302 10.995 14.0485M7.2683 11.7771C6.4413 12.1572 5.52796 12.3515 4.59189 12.3332M7.2683 11.7771C7.18746 11.8146 7.10662 11.8522 7.02578 11.8888M7.02578 11.8888C6.26874 12.2354 5.4385 12.4325 4.59189 12.3332M7.02578 11.8888C7.18824 12.1064 7.18824 12.3936 7.02578 12.6112L6.71826 13.0224C6.61489 13.1646 6.4752 13.2753 6.31322 13.3437L5.79665 13.5571C5.39132 13.7251 4.90999 13.6609 4.59323 13.3888C4.22916 13.0776 4.02873 12.5963 4.02873 12.0905V10.5711C4.02873 10.0654 4.22916 9.58407 4.59323 9.27288C4.90999 9.00076 5.39132 8.93651 5.79665 9.10448L6.31322 9.31794C6.4752 9.38632 6.61489 9.49704 6.71826 9.63927L7.02578 10.0505C7.18824 10.2681 7.18824 10.5553 7.02578 10.7729L6.71826 11.1841C6.7056 11.2013 6.69177 11.2164 6.67699 11.2292C6.5421 11.3461 6.39191 11.4488 6.22999 11.5356L5.79665 11.7489C5.72913 11.7804 5.65432 11.7946 5.57916 11.7914H5.57584M7.2683 11.7771C7.2683 11.7771 7.2683 11.7771 7.2683 11.7771M7.2683 11.7771C7.2683 11.7771 7.2683 11.7771 7.2683 11.7771M7.2683 11.7771C7.2683 11.7771 7.2683 11.7771 7.2683 11.7771M7.2683 11.7771C7.2683 11.7771 7.2683 11.7771 7.2683 11.7771M7.2683 11.7771C7.2683 11.7771 7.2683 11.7771 7.2683 11.7771Z"
                                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-sm text-[#464559] dark:text-white" id="trainee-email">
                                                {{ $counseling->traineeUser ? $counseling->traineeUser->email : ($counseling->trainee_offline_email ?? 'N/G') }}</span>
                                            </div>
                                            <div class="flex items-center gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                     viewBox="0 0 20 20" fill="none">
                                                    <path
                                                        d="M7.58317 16.6666H6.58317C4.47191 16.6666 3.41675 16.6666 2.7087 16.2264C2.0808 15.8361 1.61918 15.2437 1.40801 14.5311C1.16675 13.7246 1.29428 12.7137 1.54933 10.692L1.81009 8.61323C2.08131 6.51097 2.21691 5.45984 2.77804 4.65413C3.27047 3.94433 3.99222 3.40614 4.83222 3.12236C5.76265 2.8067 6.81996 2.8067 8.93458 2.8067H11.0653C13.1799 2.8067 14.2372 2.8067 15.1676 3.12236C16.0076 3.40614 16.7294 3.94433 17.2218 4.65413C17.7829 5.45984 17.9185 6.51097 18.1898 8.61323L18.4505 10.692C18.7056 12.7137 18.8331 13.7246 18.5918 14.5311C18.3807 15.2437 17.9191 15.8361 17.2912 16.2264C16.5832 16.6666 15.528 16.6666 13.4167 16.6666H12.4167M11.6667 13.3333C11.6667 14.4379 10.7713 15.3333 9.66671 15.3333C8.56214 15.3333 7.66671 14.4379 7.66671 13.3333C7.66671 12.2288 8.56214 11.3333 9.66671 11.3333C10.7713 11.3333 11.6667 12.2288 11.6667 13.3333Z"
                                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                @if ($counseling->traineeUser && $counseling->traineeUser->public_portfolio == 1)
                                                    @if ($counseling->traineeUser->portfolio)
                                                        <a href="{{ route('trainee.career-guidance.portfolio.preview-portfolio', ['pid' => $counseling->traineeUser->portfolio->id]) }}"
                                                           target="_blank"
                                                           class="text-sm text-primary dark:text-white underline"
                                                           id="portfolio">Portfolio</a>
                                                    @else
                                                        <span class="text-sm text-[#464559] dark:text-white" id="portfolio">No
                                                        Portfolio</span>
                                                    @endif
                                                @else
                                                    <span class="text-sm text-[#464559] dark:text-white" id="portfolio">No
                                                    Public Portfolio</span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if($counseling->traineeUser)
                                <div class="flex flex-wrap gap-6">
                                    @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                                        <a href="https://fastercapital.com/content/Career-guidance-and-counseling-Navigating-Your-Career-Path--A-Comprehensive-Guide.html" target="_blank" class="text-primary text-xl font-semibold underline">Counselling
                                            Questionnaire</a>
                                    @endif
                                    @if ($counseling->traineeUser && $counseling->traineeUser->careerTest && $counseling->traineeUser->careerTest->count() > 0)
                                        <a target="_blank"
                                           href="{{ route('cgo.career-guidance.career-test.list', ['keyword' => $counseling->traineeUser->fullName]) }}"
                                           class="text-primary text-xl font-semibold underline">Career Test Result</a>
                                    @endif
                                    @if ($counseling->status == \App\Enums\CgoCounselingStatusEnums::CONFIRM->value)
                                        <button class="text-primary text-xl font-semibold underline trainee-name-btn whitespace-nowrap ajax-call text-primary font-semibold hover:text-blue-700 dark:hover:text-white" data-url="{{ route('cgo.job-support.trainee-list.information', $counseling->trainee_id) }}"
                                                data-modal-target="default-modal" data-modal-toggle="default-modal"
                                                data-full-name="{{ $counseling->traineeUser->fullName }}"
                                                data-limited-name="{{ \Str::limit($counseling->traineeUser->fullName, 13) }}">Resume (CV)</button>
                                        {{--                                <button class="text-primary text-xl font-semibold underline" data-modal-target="searchModal" data-modal-toggle="searchModal">TVET Courses</button>--}}
                                    @endif
                                </div>
                            @endif
                            @if ($counseling->status == \App\Enums\CgoCounselingStatusEnums::CONFIRM->value)
                                <button class="text-primary text-xl font-semibold underline" data-modal-target="searchModal" data-modal-toggle="searchModal">{{ __('cgo.TVET Courses')}}</button>
                            @endif
                        </div>
                    </div>
                    @if($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                        <div class="flex items-start justify-end">
                            <button type="button" class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                    text-base px-4 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 whitespace-nowrap" data-modal-target="change-cgo-modal" data-modal-toggle="change-cgo-modal">{{trans('cgo.change_cgo')}}</button>
                        </div>
                    @endif
                </div>
{{--            @endif--}}

            <h3 class="text-lg font-semibold text-[#4984F6]">{{trans('cgo.requested_information')}}</h3>

            <div class="flex gap-6 flex-col lg:flex-row">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{trans('cgo.requested_date')}}</label>
                    <input type="text" id="" name="requested_date" maxlength="50"
                        class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ date('Y-m-d', strtotime($counseling->created_at)) }}" readonly disabled>
                </div>
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white mb-5">{{trans('cgo.type')}}</label>
                        @php
                        $type = $counseling->counseling_type;
                        $typeMap = [
                            getCodeIdByStringEn('counselling_type', 'online') => ['icon' => 'online.svg', 'color' => '#7AED86'],
                            getCodeIdByStringEn('counselling_type', 'offline') => ['icon' => 'offline.svg', 'color' => '#91919A'],
                            getCodeIdByStringEn('counselling_type', 'Guidance without reservation') => ['icon' => 'offline.svg', 'color' => '#91919A'],
                        ];
                    @endphp
                    
                    @if (isset($typeMap[$type]))
                        <div class="flex gap-1 items-center">
                            <img src="{{ asset('images/' . $typeMap[$type]['icon']) }}" alt="Type" class="w-3 h-3">
                            <span class="text-sm text-[{{ $typeMap[$type]['color'] }}]">
                                {{ getCodeNameByCodeId('counselling_type', $type) }}
                            </span>
                        </div>
                    @endif
                    
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.counseling_field') }}</label>
                        <input type="text" id="" name="title" maxlength="50"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }}" readonly disabled>
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.title') }}</label>
                    <input type="text" id="" name="title" maxlength="50"
                        class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="{{ $counseling->title }}" readonly disabled>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{trans('cgo.location')}}</label>
                        <textarea type="text" id="" name="location" maxlength="50" rows="2"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            readonly disabled>{{ $counseling->district->name ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                               class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{trans('cgo.institute')}}</label>
                        <textarea type="text" id="" name="institute" maxlength="50" rows="2"
                                  class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                  readonly disabled>{{ $counseling->institute->name ?? '' }}</textarea>
                    </div>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.detail_information') }}</label>
                    <textarea type="" id="" name="detail_information" maxlength="1000" rows="6"
                        class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                       dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                       dark:focus:border-blue-500"
                        readonly disabled>{{ $counseling->detail_information }}</textarea>
                </div>
            </div>

            <div class="col-start-2 col-end-5">
                <div>
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">
                            {{ __('cgo.available_time') }}
                        </label>
                        <input type="text" id="available_time" name="available_time"
                            class="mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            value="{{ $counseling->available_time ? date('Y-m-d', strtotime($counseling->available_time)) : '' }} {{$counseling->shift != '' ? '('.strtoupper($counseling->shift).')' : ''}}" readonly disabled>
                    </div>

                </div>
            </div>
            @if ($counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                <ul class="space-y-3">
                    <label for=""
                        class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('Attach File') }}</label>
                    @forelse ($counseling->counselingAttachment as $file)
                        <li
                            class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 dark:bg-[#282828] dark:text-white">
                            <span class="flex-grow">{{ $file->file_name }}</span>
                            <a href="{{ route('cgo.career-guidance.counseling.attachments.download', ['id' => $file->id]) }}"
                                class="flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                <i class="fas fa-download mr-2"></i>
                                Download
                            </a>
                        </li>
                    @empty
                        <p class="dark:text-white">No file selected</p>
                    @endforelse

                </ul>
            @endif
            {{--                button form --}}
            @if (
                ($counseling->status == getCodeIdByStringEn('counselling_status', 'request') ||
                    $counseling->status == \App\Enums\CgoCounselingStatusEnums::RE_ASSIGN->value) &&
                    Auth::guard('cgo')->user()->id == $assigneeToId)
                <div class="flex gap-3 justify-end">

                    @if ($rejectCount <= 3)
                        <button type="button" data-modal-target="deny-counseling-modal"
                            data-modal-toggle="deny-counseling-modal"
                            class="w-fit text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">
                            {{ __('cgo.deny') }}
                        </button>
                    @endif


                    <button type="submit" id="confirm-counseling-button" data-counseling-id="{{ $counseling->id }}" data-available_date="{{$counseling->available_time}}"
                    class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('cgo.confirm') }}</button>
                </div>
                <!-- Main modal -->
                @if ($rejectCount <= 3)
                    <div id="deny-counseling-modal" tabindex="-1" aria-hidden="true"
                        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                        <div class="relative p-4 w-full max-w-md max-h-full">
                            <!-- Modal content -->
                            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                                <!-- Modal header -->
                                <div
                                    class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ __('cgo.counseling_cancel') }}
                                    </h3>
                                    <button type="button"
                                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-toggle="deny-counseling-modal">
                                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                            fill="none" viewBox="0 0 14 14">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                        </svg>
                                        <span class="sr-only">Close modal</span>
                                    </button>
                                </div>
                                <div class="px-5 pt-5 justify-center items-center space-y-4">
                                    <p
                                        class="dark:text-white leading-relaxed text-gray-500 font-[400] dark:text-gray-400 text-base">
                                        {{trans('cgo.cancel_message')}}</p>
                                    <p
                                        class="text-[#201F36] dark:text-white text-xl text-center md:text-2xl font-semibold">
                                        {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}
                                    </p>
                                </div>
                                <!-- Modal body -->
                                <form id="form-deny-counseling" class="p-4 md:p-5 form-deny-counseling"
                                    action="{{ route('cgo.career-guidance.counseling.counseling-list.reject', ['id' => $counseling->id]) }}"
                                    method="POST">
                                    @csrf
                                    <div class="grid gap-4 mb-4 grid-cols-2">
                                        <div class="col-span-2 relative">

                                            <textarea required id="cancel_reason" name="cancel_reason" rows="4" maxlength="800"
                                                class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-600 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                placeholder="Reason"></textarea>
                                            <span id="error-message"></span>
                                        </div>
                                    </div>
                                    <div class="flex gap-3 justify-between items-center">
                                        <button type="button" data-modal-toggle="deny-counseling-modal"
                                            class="text-center w-1/2 text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ __('cgo.cancel') }}
                                        </button>

                                        <button type="submit"
                                            class="text-center w-1/2 text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('cgo.confirm') }}</button>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                @endif
            @endif

            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                <form id="form-submit-counseling"
                    action="{{ route('cgo.career-guidance.counseling.store-result-counseling', ['id' => $counseling->id]) }}"
                    method="POST">
                    @csrf
                    <div class="col-start-2 col-end-5">
                        <div>
                            <label for=""
                            class="sm:text-base text-base font-semibold text-[#4984F6] block mb-1.5 dark:text-white">
                            {{ __('cgo.cgo_final') }} <span style="color: red">*</span>
                        </label>

                            <textarea type="" id="" name="result" maxlength="1000" rows="6" required
                                class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                       dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                       dark:focus:border-blue-500">{{ old('result', $counseling->result ?? '') }}</textarea>
                        </div>
                        @if ($errors->has('result'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('result') }}</span>
                        @endif
                    </div>

                    <div class="col-start-2 col-end-5 suggested-information hidden">
                        <div class="">
                            <label for=""
                                   class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.suggested_training_information') }}</label>
                            <div class="border p-1 font-semibold dark:text-white">
                                {{trans('cgo.institutes')}}
                            </div>
                            <div class="institute-container dark:text-white">

                            </div>
                            <div class="border p-1 font-semibold dark:text-white">
                                {{trans('cgo.nvq_courses')}}
                            </div>
                            <div class=" nvq-course-container dark:text-white">

                            </div>
                            <div class="border p-1 font-semibold dark:text-white">
                                {{trans('cgo.tvec_courses')}}
                            </div>
                            <div class="tvec-course-container dark:text-white">

                            </div>
                        </div>
                    </div>

                    <div class="flex mt-10 gap-3 justify-end">
                        <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}"
                            class="w-fit text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                    text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ __('cgo.cancel') }}
                        </a>
                        <input type="hidden" name="temporaty_save_flag" id="temporaty_save_flag" value="false">
                        <a href="javascript:void(0)" id="temporary-save-button"
                                class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
        text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{ __('cgo.temporary_save') }}
                        </a>
                        <button type="submit" id="submit-counseling-button"
                            class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('cgo.submit') }}</button>
                    </div>
                </form>
            @endif

            @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
                <div class="col-start-2 col-end-5">
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.result') }}
                        </label>
                        <textarea type="" id="" name="result" maxlength="1000" rows="6"
                            class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                       focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                       dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                       dark:focus:border-blue-500"
                            readonly disabled>{{ $counseling->result }}</textarea>
                    </div>
                </div>
                @if ($counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                <div class="col-start-2 col-end-5">

                    <div class="col-start-2 col-end-5">
                        <div class="">
                            <label for=""
                                   class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('cgo.suggested_training_information') }}</label>
                            @if($counseling->suggested_institutes != null && count(json_decode($counseling->suggested_institutes)) > 0)
                            <div class="border p-2 font-semibold rounded-t-xl dark:text-white">
                                {{trans('cgo.institutes')}}
                            </div>
                            <div class="">
                                @forelse(json_decode($counseling->suggested_institutes) as $item)
                                    <div class="border p-2">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                            @if($counseling->suggested_nvq_courses != null && count(json_decode($counseling->suggested_nvq_courses)) > 0)
                            <div class="border p-2 font-semibold dark:text-white">
                                {{trans('cgo.nvq_courses')}}
                            </div>
                            <div class="">
                                @forelse(json_decode($counseling->suggested_nvq_courses) as $item)
                                    <div class="border p-2">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                            @if($counseling->suggested_tvec_courses != null && count(json_decode($counseling->suggested_tvec_courses)) > 0)
                            <div class="border p-2 font-semibold dark:text-white">
                                {{trans('cgo.tvec_courses')}}
                            </div>
                            <div class=" rounded-b-xl">
                                @forelse(json_decode($counseling->suggested_tvec_courses) as $item)
                                    <div class="border p-2 {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                        <p class="dark:text-white text-sm">{{$item->text}}</p>
                                    </div>
                                @empty
                                @endforelse
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @if ($counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Counseling without reservation'))
                <div class="col-start-2 col-end-5">
                    <div>
                        <label for=""
                            class="sm:text-base text-base font-semibold text-[#464559] block mb-1.5 dark:text-white">{{ __('Feedback of Trainee') }}
                        </label>
                        <textarea type="" id="" name="result" maxlength="1000" rows="6"
                            class=" mb-2 border border-[#EDEDED] text-[#706F81] text-base rounded-lg
                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                   dark:border-gray-600 dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                   dark:focus:border-blue-500"
                            readonly disabled>{{ $counseling->trainee_feedback }}</textarea>
                    </div>
                </div>
                @endif
            @endif

            @if (
                $counseling->status == getCodeIdByStringEn('counselling_status', 'completed') &&
                    $counseling->counseling_type != getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                <div class="flex flex-col items-center justify-center gap-6">
                    <!-- Trainee Info -->
                    <div class="flex flex-col gap-1 items-center">
                        <p class="text-[#706F81] dark:text-white text-base md:text-lg text-center">
                            {{trans('cgo.feedback_message')}}
                        </p>
                        <p class="text-[#201F36] dark:text-white text-xl md:text-2xl font-semibold text-center">
                            {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname .' '.$counseling->trainee_offline_lastname }}
                        </p>
                    </div>

                    <!-- Star Ratings -->
                    <div class="flex flex-wrap gap-4 md:gap-6 justify-center">
                        @if ($counseling->feedback)
                            @for ($i = 0; $i < $counseling->feedback; $i++)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#FCC75E" />
                                    </svg>
                                </button>
                            @endfor
                            @for ($i = 5; $i > $counseling->feedback; $i--)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#F5F7FA" />
                                    </svg>
                                </button>
                            @endfor
                        @else
                            @for ($i = 0; $i < 5; $i++)
                                <button type="button">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="43" height="42"
                                        viewBox="0 0 43 42" fill="none">
                                        <path
                                            d="M21.5 0L27.4496 12.8111L41.4722 14.5106L31.1266 24.1279L33.8435 37.9894L21.5 31.122L9.15651 37.9894L11.8734 24.1279L1.52781 14.5106L15.5504 12.8111L21.5 0Z"
                                            fill="#F5F7FA" />
                                    </svg>
                                </button>
                            @endfor
                        @endif
                    </div>

                    <!-- Feedback Messages -->
                    <div class="flex flex-wrap gap-2 md:gap-4 w-full md:w-1/3 justify-center">
                        @if ($counseling->feedback_message)
                            @foreach (json_decode($counseling->feedback_message) as $feedback)
                                <button type="button"
                                    class="text-white bg-primary hover:bg-blue-700 font-medium rounded-lg text-base px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                                    {{ __("cgo.$feedback") }}
                                </button>
                            @endforeach
                        @endif
                        @foreach ($counseling->missing_feedback as $miss_feedback)
                            <button type="button"
                                class="py-2.5 px-5 me-2 mb-2 text-base font-medium text-[#91919A] focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                {{ __("cgo.$miss_feedback") }}
                            </button>
                        @endforeach
                    </div>
                </div>

            @endif
            @endif
        </div>
    </div>
    <div id="searchModal" tabindex="-1" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-1rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-5xl">
            <!-- Modal content -->
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <!-- Modal header -->
                <div class="flex items-start justify-between rounded-t border-b p-5 dark:border-gray-600">
                    <div class="flex flex-col gap-2">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white lg:text-2xl"> {{trans('cgo.tvec_information')}} </h3>
                        <p class="dark:text-white text-base font-semibold">{{trans('cgo.choose_tvec_information')}}</p>
                    </div>

                    <button type="button" class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="searchModal">
                        <svg class="h-3 w-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="px-6">
                    <div class="flex flex-col gap-4 py-4 divide-y">


                        <div class="flex flex-col gap-4 py-4">
                            <label class="font-semibold text-primary" for="institute-search">{{trans('cgo.select_institute')}}:</label>
                            <select id="institute-search"
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white" multiple>

                            </select>
                        </div>
                        <div class="flex flex-col gap-4 py-4">
                            <label class="font-semibold text-primary" for="tvec-course-search">{{trans('cgo.select_tvec_course')}}:</label>
                            <select id="tvec-course-search"
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white" multiple>

                            </select>
                        </div>
                        <div class="flex flex-col gap-4 py-4">
                            <label class="font-semibold text-primary" for="nvq-course-search">{{trans('cgo.select_nvq_course')}}:</label>
                            <select id="nvq-course-search"
                                    class="block w-full rounded-md border-gray-300 bg-gray-50 text-gray-900 text-sm shadow-sm focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-800 dark:border-gray-700 dark:placeholder-gray-400 dark:text-white" multiple>

                            </select>
                        </div>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex flex-col md:flex-row justify-between items-center p-6 border-t border-gray-200 gap-2">
                    <a href="https://nvq.gov.lk/Insreg_Home/Insreg_Institute_Select_Search.php" target="_blank" class="font-semibold text-primary hover:underline" > {{trans('cgo.go_to_tvec_site')}} </a>
                    <div class="flex flex-col md:flex-row items-center gap-4">
                        <button type="button" id="btn-close"  class="w-fit rounded-full border border-gray-200 bg-white px-12 py-3 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"  data-modal-hide="searchModal" > {{trans('cgo.close')}} </button>
                        <button type="button" id="btn-reset" class="w-fit rounded-full border border-gray-200 bg-white px-12 py-3 text-base font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"> {{trans('cgo.reset')}} </button>
                        <button type="button" id="btn-done" class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
        text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"> {{trans('cgo.done')}} </button>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div id="default-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <div role="status">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white">
                        Resume
                    </h3>
                    <button type="button"
                            class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
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
                    <div class="flex flex-col lg:flex-row gap-6 items-center border-b pb-4">
                        <img class="w-32 h-32 rounded-full" id="avatar" src="{{asset('/images/user-default.svg')}}" alt="user photo">
                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold"
                               id="trainee-name-heading"></p>
                            {{--                            <div class="text-[#91919A] dark:text-white" id="summary_training_block">--}}

                            {{--                            </div>--}}
                        </div>
                    </div>
                    <div class="py-6 flex flex-col gap-9">
                        <div class="flex flex-col gap-4">
                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                {{ trans('company.job_support.trainee_list.modal_content.basic_information') }}</p>
                            <div class="flex gap-6 flex-col lg:flex-row">
                                <div class="flex flex-col gap-4">
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M16.6654 17.5C16.6654 16.337 16.6654 15.7555 16.5218 15.2824C16.1987 14.217 15.365 13.3834 14.2996 13.0602C13.8265 12.9167 13.245 12.9167 12.082 12.9167H7.91537C6.7524 12.9167 6.17091 12.9167 5.69775 13.0602C4.63241 13.3834 3.79873 14.217 3.47556 15.2824C3.33203 15.7555 3.33203 16.337 3.33203 17.5M13.7487 6.25C13.7487 8.32107 12.0698 10 9.9987 10C7.92763 10 6.2487 8.32107 6.2487 6.25C6.2487 4.17893 7.92763 2.5 9.9987 2.5C12.0698 2.5 13.7487 4.17893 13.7487 6.25Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-name"></span>
                                    </div>
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-sm text-[#464559] dark:text-white"
                                              id="trainee-phone"></span>
                                    </div>
                                </div>
                                <div class="flex flex-col gap-4">
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M17.9179 14.9997L12.3823 9.99967M7.62035 9.99967L2.08466 14.9997M1.66797 5.83301L8.47207 10.5959C9.02304 10.9816 9.29853 11.1744 9.59819 11.2491C9.86288 11.3151 10.1397 11.3151 10.4044 11.2491C10.7041 11.1744 10.9796 10.9816 11.5305 10.5959L18.3346 5.83301M5.66797 16.6663H14.3346C15.7348 16.6663 16.4348 16.6663 16.9696 16.3939C17.44 16.1542 17.8225 15.7717 18.0622 15.3013C18.3346 14.7665 18.3346 14.0665 18.3346 12.6663V7.33301C18.3346 5.93288 18.3346 5.23281 18.0622 4.69803C17.8225 4.22763 17.44 3.84517 16.9696 3.60549C16.4348 3.33301 15.7348 3.33301 14.3346 3.33301H5.66797C4.26784 3.33301 3.56777 3.33301 3.03299 3.60549C2.56259 3.84517 2.18014 4.22763 1.94045 4.69803C1.66797 5.23281 1.66797 5.93288 1.66797 7.33301V12.6663C1.66797 14.0665 1.66797 14.7665 1.94045 15.3013C2.18014 15.7717 2.56259 16.1542 3.03299 16.3939C3.56777 16.6663 4.26784 16.6663 5.66797 16.6663Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-sm text-[#464559] dark:text-white"
                                              id="trainee-email"></span>
                                    </div>
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M9.9987 10.417C11.3794 10.417 12.4987 9.2977 12.4987 7.91699C12.4987 6.53628 11.3794 5.41699 9.9987 5.41699C8.61799 5.41699 7.4987 6.53628 7.4987 7.91699C7.4987 9.2977 8.61799 10.417 9.9987 10.417Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path
                                                d="M9.9987 18.3337C11.6654 15.0003 16.6654 12.8489 16.6654 8.33366C16.6654 4.65176 13.6806 1.66699 9.9987 1.66699C6.3168 1.66699 3.33203 4.65176 3.33203 8.33366C3.33203 12.8489 8.33203 15.0003 9.9987 18.3337Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-address">
                                           </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-6 flex-col">
                            <div class="flex flex-col gap-4 w-full">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                        {{ trans('company.job_support.trainee_list.modal_content.education') }}</p>
                                    <div id="education_block"></div>


                                </div>
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                        {{ trans('company.job_support.trainee_list.modal_content.certificate') }}</p>
                                    <div id="certificate_block">

                                    </div>

                                </div>
                                {{--                                <div class="flex flex-col gap-4">--}}
                                {{--                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">--}}
                                {{--                                        {{ trans('company.job_support.trainee_list.modal_content.attachment') }}</p>--}}
                                {{--                                    <div id="attachment_block">--}}

                                {{--                                    </div>--}}

                                {{--                                </div>--}}
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                        {{ trans('company.job_support.trainee_list.modal_content.portfolio') }}</p>
                                    <div id="portfolio_block">
                                        <p class="dark:text-white">{{trans('cgo.no_information')}}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
    <div id="change-cgo-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <div role="status">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-primary dark:bg-[#383838] px-6 py-4">
                    <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white">
                        {{trans('cgo.change_cgo')}}
                    </h3>
                    <button type="button"
                            class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="change-cgo-modal">
                        <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                             fill="none">
                            <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663" stroke="white"
                                  stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 flex flex-col gap-6 h-full overflow-y-auto">
                    @if(isset($CGOList))
                        <form method="post" action="{{route('cgo.career-guidance.counseling.change-cgo')}}" class="flex flex-col gap-4">
                            @csrf
                            <input type="text" name="counseling_id" value="{{$counseling->id}}" class="hidden">
                            <div class="flex flex-col gap-3">
                                <label for="cgo"
                                       class=" text-base font-medium text-gray-600 block dark:text-white">{{trans('cgo.select_cgo')}}
                                    <span class="text-red-700">*</span></label>
                                <select id="cgo" name="cgo_id" required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="" disabled selected>{{trans('cgo.select_cgo')}}</option>
                                    @forelse($CGOList as $cgo)
                                        <option value="{{ $cgo->id }}">{{ $cgo->fullName }} - {{$cgo->institute->name}}
                                        </option>
                                    @empty
                                    @endif
                                </select>
                                <span class="italic text-sm dark:text-white">{{trans('cgo.note_change_cgo')}}</span>
                            </div>
                            <div class="flex justify-end gap-4">
                                <button type="button"
                                   class="w-fit text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                    text-base px-12 py-3 dark:hover:bg-gray-300 dark:focus:ring-blue-800" data-modal-hide="change-cgo-modal">{{ __('cgo.cancel') }}
                                </button>
                                <button type="submit"
                                        class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                            text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('system.form.button.submit') }}</button>
                            </div>
                        </form>
                    @endif
                        <script>
                            $(document).ready(function () {
                                $("#cgo").select2();
                            })
                        </script>
                </div>
            </div>
        </div>
    </div>
    @endif


    <div id="counseling-modal" class="fixed inset-0 flex items-center justify-center z-50 hidden bg-black bg-opacity-50">
        <div class="bg-white rounded-lg p-6 w-full max-w-md shadow-lg">
            <h2 class="text-xl font-semibold mb-4">{{trans('cgo.confirm_counseling')}}</h2>

            <label for="counseling-date" class="block text-sm font-medium text-gray-700 mb-2">
                {{ __('cgo.available_time') }}
            </label>
            <input type="date" id="counseling-date" name="date"
                class="w-full border border-gray-300 rounded-lg p-2 mb-4 focus:ring-blue-500 focus:border-blue-500">

            <!-- Modal Actions -->
            <div class="flex justify-end space-x-4">
                <button id="cancel-modal" class="bg-gray-300 text-gray-700 px-4 py-2 rounded hover:bg-gray-400">
                    {{trans('system.form.button.cancel')}}
                </button>
                <button id="submit-counseling" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                    {{trans('cgo.confirm')}}
                </button>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .lable-custom-padding {
            padding-bottom: 0.5rem;
        }

        .select2-container--default .select2-selection--single {
            padding: 1.25rem .75rem 1.25rem 1rem !important;
        }
        .select2-search__field {
            width: 100% !important;
            height: 2.25rem !important;
            border: 1px solid;
            overflow: hidden;
        }
        .select2-container .select2-search--inline {
            display: contents !important;
        }
    </style>
@endpush
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script type="module">
        $(document).ready(function() {

            $('#temporary-save-button').on('click', function () {
                $('#temporaty_save_flag').val("true");
                if($('#result').val() != '') {
                    // Submit form
                    $('#form-submit-counseling').submit();
                }else {
                    alert('Please fill result!');
                }

            });

            // Set the modal menu element
            const $targetEl = document.getElementById('searchModal');

// Options with default values
            const options = {
                placement: 'bottom-right',
                backdrop: 'dynamic',
                backdropClasses:
                    'bg-gray-900\\/50 dark:bg-gray-900\\/80 fixed inset-0 z-40', // Escaped slashes
                closable: true,
                onHide: () => {
                    console.log('modal is hidden');
                    // Remove the backdrop manually

                },
                onShow: () => {
                    console.log('modal is shown');
                },
                onToggle: () => {
                    console.log('modal has been toggled');
                },
            };

// Instance options object
            const instanceOptions = {
                id: 'searchModal',
                override: true,
            };

// Initialize the modal

            const search_modal = new Modal($targetEl, options, instanceOptions);
            $(document).ready(function () {
                $('#confirm-counseling-button').on('click', function (event) {
                event.preventDefault();

                const availableDate = $('#confirm-counseling-button').data('available_date');
                const formattedDate = new Date(availableDate).toISOString().split('T')[0];

                console.log(formattedDate);
                $('#counseling-date').val(formattedDate);

                $('#counseling-modal').removeClass('hidden').addClass('flex');
            });





    // Close the modal
    $('#cancel-modal').on('click', function () {
        $('#counseling-modal').removeClass('flex').addClass('hidden');
    });

    // Submit the date via AJAX
        $('#submit-counseling').on('click', function () {
            const selectedDate = $('#counseling-date').val();
            if (!selectedDate) {
                alert('Please select a date.');
                return;
            }

            const requestData = {
                date: selectedDate,
                id: $('#confirm-counseling-button').data('counseling-id'),
            };

            toggleLoadingOverlay();
            $.ajax({
                url: "{{ route(name: 'api.cgo.career-guidance.counseling.confirm-counseling') }}",
                type: "POST",
                data: requestData,
                success: function (response) {
                    toggleLoadingOverlay(); // Optional: Hide loading spinner
                    if (response.status === 'success') {
                        window.location.reload();
                    } else {
                        alert('Failed to confirm counseling.');
                    }
                },
                error: function (response) {
                    toggleLoadingOverlay(); // Optional: Hide loading spinner
                    alert('An error occurred. Please try again.');
                },
            });

            // Close modal after submission
            $('#counseling-modal').removeClass('flex').addClass('hidden');
        });
    });


            $('#form-submit-counseling').on('submit', function() {
                event.preventDefault();

                if (this.checkValidity()) {
                    toggleLoadingOverlay();
                    this.submit();
                } else {
                    this.reportValidity();
                }
            })

            function initializeSelect2(selector, apiEndpoint, placeholderText) {
                $(selector).select2({
                    ajax: {
                        url: apiEndpoint,
                        dataType: 'json',
                        delay: 200, // Delay for search queries (ms)
                        data: function (params) {
                            return {
                                search: params.term // The search term
                            };
                        },
                        processResults: function (data) {
                            return {
                                results: data.results // Map to the "results" key in the response
                            };
                        },
                        cache: true // Cache results for better performance
                    },
                    placeholder: placeholderText,
                    minimumInputLength: 1, // Trigger search after typing 1 character
                    multiple: true, // Enable multiple selection
                    width: '100%', // Ensure it takes full width of the parent container
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.error(`Error fetching data from ${apiEndpoint}:`, textStatus, errorThrown);
                    }
                });
            }

            $(document).ready(function() {
                initializeSelect2('#institute-search', '/api/cgo/search-institutes', '{{__('cgo.Search by institute name or registration number...')}} ');
                initializeSelect2('#nvq-course-search', '/api/cgo/search-nvq-course', '{{__('cgo.Search by course name or registration number...')}} ');
                initializeSelect2('#tvec-course-search', '/api/cgo/search-tvec-course', '{{__('cgo.Search by course name or registration number...')}} ');
            });

            // Handle "Done" button click
            $('#btn-done').on('click', function () {
                // Get selected values from all select2 dropdowns
                const selectedInstitutes = $('#institute-search').select2('data');
                const selectedNVQCourses = $('#nvq-course-search').select2('data');
                const selectedTVECCourses = $('#tvec-course-search').select2('data');

                // Map to get IDs and text for each selection
                const institutes = selectedInstitutes.map(item => ({ id: item.id, text: item.text }));
                const nvqCourses = selectedNVQCourses.map(item => ({ id: item.id, text: item.text }));
                const tvecCourses = selectedTVECCourses.map(item => ({ id: item.id, text: item.text }));

                // Check if all three are empty
                if (institutes.length === 0 && nvqCourses.length === 0 && tvecCourses.length === 0) {
                    alert('Please select at least one option from the dropdowns.');
                    return; // Exit the function early
                }

                // Generate HTML for each category
                const generateHTML = (data, inputName) => {
                    let html = '';
                    data.forEach(item => {
                        html += `
                            <div class="border p-1">
                                <p class="dark:text-white text-sm">${item.text}</p>
                            </div>`;
                    });
                    html += `<input type="hidden" name="${inputName}" value='${JSON.stringify(data)}'>`;
                    return html;
                };

                // Update containers with generated HTML
                $(".institute-container").html(generateHTML(institutes, 'suggested_institutes'));
                $(".nvq-course-container").html(generateHTML(nvqCourses, 'suggested_nvq_courses'));
                $(".tvec-course-container").html(generateHTML(tvecCourses, 'suggested_tvec_courses'));

                // Show the suggested information section
                $('.suggested-information').removeClass('hidden');

                $("#btn-close").trigger("click");

            });

// Handle "Reset" button click
            $('#btn-reset').on('click', function () {
                // Reset all select2 dropdowns
                $('#institute-search').val(null).trigger('change');
                $('#nvq-course-search').val(null).trigger('change');
                $('#tvec-course-search').val(null).trigger('change');

                // Clear the containers
                $(".institute-container").html('');
                $(".nvq-course-container").html('');
                $(".tvec-course-container").html('');

                // Optionally, hide the suggested information section
                $('.suggested-information').addClass('hidden');
            });

            $('.ajax-call').on('click', function() {
                let url = $(this).data('url');
                $(".loading").removeClass('hidden');
                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#default-modal #trainee-email').text(response.trainee_user.email);
                        $('#default-modal #trainee-name').text(response.trainee_user.full_name);
                        $('#default-modal #trainee-phone').text((response.trainee_user.mobile != null && response.trainee_user.mobile != '') ? response.trainee_user.mobile : response.trainee_user.telephone);
                        $('#default-modal #summary_training_block').html(response.trainee_user.sumary_training);
                        $('#default-modal #trainee-name-heading').text(response.trainee_user.full_name);
                        let src = '';
                        if(response.trainee_user.profile_image) {
                            src = response.trainee_user.profile_image;
                        }else {
                            src = '/images/user-default.svg';
                        }
                        $('#default-modal #avatar').attr('src', src);
                        $('#default-modal #trainee-address').text(response.trainee_user.contact_address);
                        let certificateBlock = $('#default-modal #certificate_block');
                        let educationBlock = $('#default-modal #education_block');
                        let attachmentBlock = $('#default-modal #attachment_block');
                        certificateBlock.empty();
                        educationBlock.empty();
                        attachmentBlock.empty();
                        let certificateDiv = ``;
                        let educationDiv = ``;
                        if(response.trainee_certificates != null && response.trainee_certificates.length > 0) {
                            response.trainee_certificates.forEach(function(certificate) {
                                certificateDiv += `
                            <div class="flex flex-col gap-4">
                                <div class="flex gap-4 items-baseline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                                    </svg>
                                    <div class="flex flex-col gap-2">
                                        <p>
                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">${certificate.QUALIFICATION_NAME} - ${certificate.QUALIFICATION_LEVEL}</span>
                                            <span class="text-[#706F81] dark:text-white">(${certificate.EFFECTIVE_DATE})</span>
                                        </p>
                                    </div>
                                </div>
                            </div>`;
                            });
                        }else {
                            certificateDiv += `<span class="dark:text-white">No information</span>`;
                        }
                        if(response.trainee_information != null && response.trainee_information.length > 0) {
                            response.trainee_information.forEach(function(information) {
                                educationDiv += `
                            <div class="flex  flex-col gap-4">
                                <div class="flex gap-4 items-baseline">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                        <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                                    </svg>
                                    <div class="flex flex-col gap-2">
                                        <p>
                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">${information.institute.INSTITUTE_NAME}</span>
                                            <span class="text-[#706F81]  dark:text-white">(Industry sector: ${information.education.INDUSTRY_SECTOR})</span>
                                        </p>
                                        <p>
                                            <span class="text-[#91919A] dark:text-white">Course name: ${information.education.COURSE_NAME} (${information.education.START_DATE} - ${information.education.END_DATE})</span>
                                        </p>
                                    </div>
                                </div>
                            </div>`;

                            });
                        }else {
                            educationDiv += `<span class="dark:text-white">No information</span>`;
                        }
                        //CGO only see trainee's portfolio has public, but Company can view if trainee applied
                        if(response.trainee_portfolio != '') {
                            $("#default-modal #portfolio_block").html('<a class="dark:text-white underline text-primary" href="'+response.trainee_portfolio+'" target="_blank">View</a>');
                        }
                        certificateBlock.append(certificateDiv);
                        educationBlock.append(educationDiv);
                        // attachmentBlock.append(attachmentDiv);
                        $(".loading").addClass('hidden');

                    },
                    error: function(xhr, status, error) {
                        $(".loading").addClass('hidden');
                        alert('Error: ' + error);
                    }
                });
            });
        });
    </script>

    <script>
        var errorMessage = document.getElementById('error-message');
        errorMessage.style.display = 'none';
        document.getElementById('cancel_reason').addEventListener('input', function() {
            var charCount = this.value.length;
            // var charCountElement = document.getElementById('char-count');


            // charCountElement.textContent = charCount;

            if (charCount >= 900) {
                errorMessage.style.display = 'block';
            } else {
                errorMessage.style.display = 'none';
            }
        });

        document.getElementById('form-deny-counseling').addEventListener('submit', function(event) {
            var charCount = document.getElementById('cancel_reason').value.length;
            if (charCount > 1000) {
                event.preventDefault(); // Prevent form submission
                alert('The form cannot be submitted because the character limit of 1000 has been exceeded.');
            }
        });
    </script>
@endpush

