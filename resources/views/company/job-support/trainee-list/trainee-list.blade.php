@extends('homepage.layouts.master')
@section('title', 'Company - Job support - Trainee List')
@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <style>
        .select2-container--default .select2-selection--single {
            padding: 1.3rem .75rem 1.3rem 1rem !important;
            background: #f8f8f8;
        }

        .select2-container .select2-selection {
            font-size: 16px !important;
            font-weight: 600 !important;
            border-color: #EDEDED !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #4984F6 !important;
        }

        .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #fff !important;
            /* White placeholder for dark mode */
        }
    </style>
@endpush
@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('company.menu.home'), 'url' => route('homepage')],
            ['label' => trans('company.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('company.menu.job_support.trainee_list'), 'url' => route('company.job-support.trainee-list.list')],
        ]" />
    </div>
    <div class="mb-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <form class="flex flex-col w-full gap-4" action="{{ route('company.job-support.trainee-list.list') }}"
                method="GET">
                <div class="flex gap-6 items-center">
                    <label for="simple-search" class="sr-only">{{ trans('company.job_support.trainee_list.search') }}</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" name="search" id="simple-search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            placeholder="{{ __('general.Trainee name') }}" />
                    </div>
                    <button type="submit"
                        class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                        {{ trans('company.job_support.trainee_list.search') }}
                    </button>
                </div>
                <div class="flex flex-col md:flex-row gap-3 justify-between md:items-center">
                    <div class="flex flex-col">
                        @if (
                        (request()->has('search') && request()->query('search') != '') ||
                            (request()->has('institute') && request()->query('institute') != 'all') ||
                            (request()->has('nvq_level') && request()->query('nvq_level') != 'all') ||
                            (request()->has('district') && request()->query('district') != 'all') ||
                            (request()->has('province') && request()->query('province') != 'all'))
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $trainees->total() }}
                                {{ trans('company.job_support.trainee_list.filterResults') }}</p>
                            <button type="button" class="flex items-center text-red-700 text-sm"
                                    onclick="window.location.href = window.location.origin + window.location.pathname;"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                </svg>
                                {{trans('system.remove_filter')}}</button>
                        @else
                            <p></p>
                        @endif
                    </div>


                    <div class="flex flex-row flex-wrap md:justify-end items-center gap-4">
                        {{--                        <select id="nvq_level" --}}
                        {{--                            class="w-96 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-primary text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> --}}
                        {{--                            <option value="">{{ trans('company.job_support.trainee_list.filter.nvq_level') }}</option> --}}
                        {{--                            @foreach ($nvqs as $nvq) --}}
                        {{--                                <option value="{{ $nvq->id }}" @selected(request()->get('nvq_level') == $nvq->id)>{{ $nvq->name }} --}}
                        {{--                                    ({{ $nvq->level }}) --}}
                        {{--                                </option> --}}
                        {{--                            @endforeach --}}
                        {{--                        </select> --}}
                        {{--                        <button value="all" name="sector" id="sector-modal-open" type="button" --}}
                        {{--                            data-modal-target="default-modal" --}}
                        {{--                            class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-primary text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit"> --}}
                        {{--                            <span> --}}
                        {{--                                @php --}}
                        {{--                                    $sectorText = trans('trainee.job_support.ojt_list.filter.sector_nvq'); --}}

                        {{--                                    if (optional($subsectorFilter)->id) { --}}
                        {{--                                        $sectorText = "{$sectorsFilter->name}/{$subsectorFilter->name}"; --}}
                        {{--                                    } elseif (optional($sectorsFilter)->id) { --}}
                        {{--                                        $sectorText = $sectorsFilter->name; --}}
                        {{--                                    } --}}
                        {{--                                @endphp --}}
                        {{--                                {{ $sectorText }} --}}
                        {{--                            </span> --}}
                        {{--                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none" --}}
                        {{--                                xmlns="http://www.w3.org/2000/svg"> --}}
                        {{--                                <path d="M4 6L8 10L12 6" class="stroke-[#91919A] dark:stroke-white" stroke-width="2" --}}
                        {{--                                    stroke-linecap="round" stroke-linejoin="round" /> --}}
                        {{--                            </svg> --}}
                        {{--                        </button> --}}
                        <button value="all" name="institute-modal" id="institute-modal" type="button"
                            data-modal-target="default-modal"
                            class="flex justify-around space-x-1 bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-primary text-base rounded-xl focus:border-primary p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                            <span>

                                {{ $chooseInstitute != '' ? \Str::limit(optional($chooseInstitute)->name, 10) : 'Institute' }}
                            </span>
                            <svg width="20" height="20" viewBox="0 0 16 16" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path d="M4 6L8 10L12 6" stroke="#91919A" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round" />
                            </svg>
                        </button>
                    </div>
                </div>
            </form>
            <div class="flex flex-col divide-inherit dark:divide-white lg:divide-y-0">
                @forelse ($trainees as $item)
                    <div>
                        <div
                            class="flex flex-col gap-5 lg:flex-row justify-between lg:px-5 py-2 md:py-3 hover:bg-blue-100 dark:hover:bg-gray-700 rounded-xl">
                            <div class="flex gap-6 items-center">
                                @if ($item->profile_image)
                                    <img class="w-16 h-16 rounded-full object-cover" src="{{ asset($item->profile_image) }}"
                                        alt="user photo">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-16">
                                        <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                            d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                @endif
                                <div class="flex flex-col gap-1">
                                    {{--                                    <span --}}
                                    {{--                                        class="bg-primary text-white text-xs font-medium px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300 w-fit">Open --}}
                                    {{--                                        to work</span> --}}
                                    <p class="flex gap-3">
                                        <button type="button"
                                            data-url="{{ route('cgo.job-support.trainee-list.information', $item->id) }}"
                                            data-trainee-id="{{ $item->id }}"
                                            data-keeper-id="{{ Auth::guard(activeGuard())->user()->id }}"
                                            data-system="{{ activeGuard() }}"
                                            data-status="{{ $item->isKeep() ? 'favorite' : 'unkeep' }}"
                                            data-modal-target="default-modal" data-modal-toggle="default-modal"
                                            class="ajax-call text-primary font-semibold hover:text-blue-700 dark:hover:text-white">{{ $item->full_name }}</button>
                                        {{--                                        <span class="text-[#464559] dark:text-white">|</span> --}}
                                        {{--                                        <span --}}
                                        {{--                                            class="text-[#464559] dark:text-white">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['parts' => 1, 'short' => false, 'syntax' => \Carbon\Carbon::DIFF_ABSOLUTE]) }} --}}
                                        {{--                                        </span> --}}
                                    </p>
                                    <p class="text-[#706F81]  gap-3 dark:text-white text-sm">
                                        {{-- @foreach (json_decode($item->traineeInformation->expertise) as $expertise)
                                        {{ $expertise->name }} |
                                    @endforeach --}}
                                        {!! getNewestTrainingInformationOfTrainee($item->id) !!}
                                    </p>
{{--                                    <p class="text-sm text-[#706F81] dark:text-white">--}}
{{--                                        {{ trans('company.job_support.trainee_list.updated') }}--}}
{{--                                        {{ \Carbon\Carbon::parse($item->updated_at)->diffForHumans() }}--}}
{{--                                    </p>--}}
                                </div>
                            </div>
                            <div
                                class="flex gap-6 items-end justify-center md:justify-start lg:justify-center md:justify-end lg:justify-center md:justify-start lg:justify-center">
                                @if ($item->isKeep())
                                <div class="bg-[#E0ECFF] px-4 py-1 text-[#4984F6] border border-[#4984F6] rounded-md font-semibold flex items-center gap-1 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="#4984F6" width="24px" height="24px"
                                        class="transition duration-300 group-hover:fill-white">
                                        <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                    </svg>

                                </div>
                                @endif
                            </div>
                        </div>
                        <hr class="w-full h-px m-4 bg-gray-100 border-0 dark:bg-gray-500">
                    </div>
                @empty
                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                        <p class="dark:text-white">No record!</p>
                    </div>
                @endforelse

            </div>
            {{--            //cái này gọi tailwind pagination trong vendor ra --}}
            {{ $trainees->onEachSide(1)->links() }}
        </div>
    </div>

    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-4xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">

                <div
                    class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                    <div role="status">
                        <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                            viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                fill="currentColor" />
                            <path
                                d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                fill="currentFill" />
                        </svg>
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
                <form class="px-4 md:px-12 py-4 flex flex-col gap-6" method="POST"
                    action="{{ route('cgo.job-support.trainee-list.keeptrainee') }}">
                    @csrf
                    <input type="text" id="keeper-id" name="keeper_id" hidden>
                    <input type="text" id="system" name="system" hidden>
                    <input type="text" id="trainee-id" name="trainee_id" hidden>
                    <input type="text" value="true" name="redirect" hidden>
                    <div class="flex flex-col lg:flex-row gap-6 items-center border-b pb-4">
                        <img class="w-32 h-32 rounded-full" id="avatar" src="{{ asset('/images/user-default.svg') }}"
                            alt="user photo">
                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold"
                                id="trainee-name-heading"></p>
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
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-name">Amila
                                            Lanka</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-phone"></span>
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
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-email">r</span>
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
                                        <span class="text-sm text-[#464559] dark:text-white" id="trainee-address">123
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
                                {{--                                <div class="flex flex-col gap-4"> --}}
                                {{--                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold"> --}}
                                {{--                                        {{ trans('company.job_support.trainee_list.modal_content.attachment') }}</p> --}}
                                {{--                                    <div id="attachment_block"> --}}

                                {{--                                    </div> --}}

                                {{--                                </div> --}}
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                        {{ trans('company.job_support.trainee_list.modal_content.portfolio') }}</p>
                                    <div id="portfolio_block">
                                        <p class="dark:text-white">No information</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="flex gap-6 dark:border-gray-600 md:flex-row items-end justify-center md:justify-end md:items-end">
                        <button type="button" data-modal-hide="default-modal"
                            class="text-center text-gray-500 bg-[#EDEDED] hover:bg-gray-500 hover:text-black focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-base sm:text-sm px-12 py-2 md:px-20 dark:hover:bg-gray-300 dark:focus:ring-blue-800">{{ trans('company.job_support.trainee_list.cancel') }}
                        </button>
                        <button type="submit" id="submit-all"
                            class="text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                                text-base sm:text-sm px-12 py-2 md:px-20 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('company.job_support.trainee_list.favorite') }}
                        </button>
                    </div>
                </form>

                {{-- Modal footer --}}

            </div>

        </div>

    </div>

    <div id="filter-modal" tabindex="-1" aria-hidden="true"
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
                                    <button class="filter-tab inline-block p-4 border-b-2 rounded-t-lg" id="tab-province"
                                        data-tabs-target="#data-tab-province" type="button" role="tab"
                                        aria-controls="tab-province" aria-selected="false"></button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button
                                        class="filter-tab inline-block p-4 border-b-2 rounded-t-lg hover:text-gray-600 hover:border-gray-300 dark:hover:text-gray-300"
                                        id="tab-district" data-tabs-target="#data-tab-district" type="button"
                                        role="tab" aria-controls="tab-district" aria-selected="false"></button>
                                </li>
                                <li class="me-2" role="presentation">
                                    <button class="filter-tab inline-block p-4 border-b-2 rounded-t-lg"
                                        id="tab-divisional" data-tabs-target="#data-tab-divisional" type="button"
                                        role="tab" aria-controls="tab-divisional" aria-selected="false">Another
                                        Tab</button>
                                </li>

                                <li class="me-2" role="presentation">
                                    <button class="filter-tab inline-block p-4 border-b-2 rounded-t-lg" id="tab-institute"
                                        data-tabs-target="#data-tab-institute" type="button" role="tab"
                                        aria-controls="tab-institute" aria-selected="false">Another Tab</button>

                                </li>
                            </ul>
                        </div>
                        <div id="default-styled-tab-content" class="w-full relative">
                            <div id="loading" class="flex items-center justify-center w-full h-full border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700 top-0 absolute z-60 hidden">
                                <div role="status">
                                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                                </div>
                            </div>
                            <div class="p-4 rounded-lg bg-gray-50 dark:bg-gray-800 space-y-2 h-96 overflow-y-auto" id="data-tab-province"
                                role="tabpanel" aria-labelledby="profile-tab">

                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-96 overflow-y-auto" id="data-tab-district"
                                role="tabpanel" aria-labelledby="dashboard-tab">

                            </div>
                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-96 overflow-y-auto" id="data-tab-divisional"
                                role="tabpanel" aria-labelledby="dashboard-tab">

                            </div>


                            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800 h-96 overflow-y-auto" id="data-tab-institute"
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
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        let url = new URL(window.location.href);
        $(document).ready(function() {
            $('#nvq_level').select2({
                placeholder: "Select NVQ",
                allowClear: true
            });
            $('#institute').select2({
                placeholder: "Select Institute",
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

        })
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const selectButton = document.getElementById('btn-save');
            const instituteTab = document.getElementById('tab-institute');
            const allTabs = document.querySelectorAll('.filter-tab');
            let activeTabId = 'tab-institute';


            allTabs.forEach((tab) => {
                tab.addEventListener('click', function() {
                    activeTabId = tab.id;
                });
            });

        });
    </script>
    <script>
        $(document).ready(function() {
            $('#institute-modal').on('click', function() {
                $("#loading").removeClass('hidden');
                const modal = createModal('filter-modal', {
                    onHide: () => {
                        clearModalContent();
                    },
                    closable: false,
                });

                // Set up modal content
                $('#title-modal').text('Institute');
                $('#tab-province').text('Province');
                $('#tab-district').text('District');
                $('#tab-divisional').text('Divisional Secretariat');
                $('#tab-institute').text('Institute');

                const provinces = [];
                window.provincesLoaded = false;
                async function loadProvinces() {
                    console.log(window.provincesLoaded);
                    if (window.provincesLoaded == false) {
                        try {
                            const response = await fetch('/api/get-provinces?institute=1');
                            const result = await response.json();

                            if (result.success) {
                                window.provincesLoaded = true;
                                provinces.push(...result.data);
                                let provinceFilter = url.searchParams.get('province');

                                appendOptionAll($('#data-tab-province'), provinceFilter === '' || provinceFilter === null, 'province', url);

                                provinces.forEach((province, index) => {
                                    const isSelected = url.searchParams.get('province') == province.id;
                                    appendProvince(province, index, isSelected);

                                    $(`#province${index}`).on('click', function (e) {
                                        handleProvinceClick(provinces, index, url);
                                    });

                                    if (isSelected) {
                                        $(`#province${index}`).trigger('click');
                                    }
                                });
                                $("#loading").addClass('hidden');
                            } else {
                                console.error('API returned error:', result.message);
                            }
                        } catch (error) {
                            console.error('Error fetching provinces:', error);
                        }

                    }
                    $("#loading").addClass('hidden');

                }

                loadProvinces();



                $('#tab-province').trigger('click');

                const selectButton = $('#btn-save');
                const instituteTab = $('#tab-institute');


                const allTabs = $('.filter-tab');
                let activeTabId = 'tab-province';

                allTabs.each(function() {
                    $(this).on('click', function() {
                        activeTabId = $(this).attr('id');
                    });
                });

                $(selectButton).off('click').on('click', function(e) {
                    if (activeTabId === 'tab-institute') {
                        window.location.href = url.href;
                    } else {
                        $(instituteTab).trigger('click');
                    }
                });


                instituteTab.on('click', function() {
                    onInstituteTabClicked(provinces);
                });



                $('#btn-cancel, #btn-close').on('click', function() {
                    modal.hide();
                });

                modal.show();
            });

            function onInstituteTabClicked(provinces) {
                $('#data-tab-institute').empty();
                let search = `<div class="flex relative items-center py-2">
                            <input type="text" id="institute_search" name="institute_search" id="simple-search" value=""
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:border-blue-500 block w-full ps-5 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            placeholder="Institute name" />
                                <div role="status" class="loading hidden absolute right-1">
                                <svg aria-hidden="true" class="inline w-6 h-6 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                </svg>
                                <span class="sr-only">Loading...</span>
                            </div>
                        </div>`;
                $('#data-tab-institute').append(search);
                let provinceFilter = url.searchParams.get('province');
                let districtFilter = url.searchParams.get('district');
                let divisionalFilter = url.searchParams.get('divisional_secretariat');
                let ownership = url.searchParams.get('ownership');
                let activeStatus = url.searchParams.get('status');

                let province = provinces.find(province => province.id === provinceFilter);

                let listInstitutes = [];
                async function loadInstitutes() {
                    try {
                        const response = await fetch('/api/get-institutes');
                        const result = await response.json();

                        if (result.success) {
                            listInstitutes.push(...result.data);

                        } else {
                            console.error('API returned error:', result.message);
                        }
                    } catch (error) {
                        console.error('Error fetching provinces:', error);
                    }
                }

                if (!provinceFilter) {
                    listInstitutes = @json($institutes);
                    // loadInstitutes();
                }

                if (divisionalFilter && districtFilter && province) {
                    let district = province.districts.find(d => d.id === districtFilter);
                    if (district) {
                        let divisionalSecretariat = district.divisional_secretariats.find(ds => ds.ds_code ===
                            divisionalFilter);
                        if (divisionalSecretariat && divisionalSecretariat.institutes) {
                            listInstitutes = divisionalSecretariat.institutes;
                        }
                    }
                } else if (districtFilter && province) {
                    let district = province.districts.find(d => d.id === districtFilter);
                    if (district && district.institutes) {
                        listInstitutes = district.institutes;
                    }
                } else if (provinceFilter && province && province.institutes) {
                    listInstitutes = province.institutes;
                }

                // if (ownership) {
                //     listInstitutes = listInstitutes.filter(institute => institute.ownership === ownership);
                // }

                // if (activeStatus) {
                //     listInstitutes = listInstitutes.filter(institute => institute.active_status === activeStatus);
                // }

                listInstitutes.forEach((institute, instituteIdx) => {
                    const isSelected = url.searchParams.get('institute') == institute.id;
                    appendInstitute(listInstitutes, institute, isSelected, url);

                    if (isSelected) {
                        $(`#institute${institute.id}`).trigger('click');
                    }
                });

                let typingTimer;

                $('#institute_search').on('keyup', function() {
                    clearTimeout(typingTimer);
                    let searchValue = $(this).val().toLowerCase();
                    $('.loading').removeClass('hidden');
                    typingTimer = setTimeout(function() {
                        $('.institute').each(function() {
                            let instituteName = $(this).text().toLowerCase();
                            $(this).toggle(instituteName.includes(
                                searchValue));
                            $('.loading').addClass('hidden');
                        });
                    }, 2000);
                });

            }


            $('#sector-modal-open').on('click', function() {
                const modal = createModal('sector-modal', {
                    onHide: () => {
                        clearModalContent();
                    },
                    closable: false,
                });
                $('#title-sector-modal').text('Job catagory');
                $('#sector-tab-1').text('Job catagory');
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


            // Hàm để làm sạch nội dung modal
            function clearModalContent() {
                $('#tab-province').empty();
                $('#tab-district').empty();
                $('#data-tab-province').empty();
                $('#data-tab-district').empty();
                $('#data-tab-divisional').empty();
                $('#data-tab-ownership').empty();
                $('#data-tab-institute').empty();
                $('#sector-tab-1').empty();
                $('#sector-data-tab-1').empty();
            }

            function appendProvince(province, index, isSelected) {
                const html = itemOptionSlect('province' + index, 'province', province.name, isSelected,
                    `data-index="${index}"`);
                $('#data-tab-province').append(html);
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
                        url.searchParams.delete('ownership');
                        url.searchParams.delete('status');
                        $('#data-tab-district').empty();
                        $('#data-tab-divisional_secretariat').empty();
                    } else if (nameFilter == 'district') {
                        url.searchParams.delete('district');
                        url.searchParams.delete('divisional_secretariat');
                        url.searchParams.delete('ownership');
                        url.searchParams.delete('status');
                        $('#data-tab-divisional_secretariat').empty();
                    } else if (nameFilter == 'divisional_secretariat') {
                        url.searchParams.delete('divisional_secretariat');
                        url.searchParams.delete('ownership');
                        url.searchParams.delete('status');
                    }

                    toggleSelected($(`.${nameFilter}`), $(this));
                });
            }

            // Xử lý khi click vào province
            function handleProvinceClick(provinces, index, url) {
                toggleSelected($('.province'), $(`#province${index}`));
                // $('#tab-district').trigger('click');
                url.searchParams.set('province', provinces[index].id);
                url.searchParams.delete('page');

                $('#data-tab-district').empty();
                $('#data-tab-divisional').empty();
                $('#data-tab-institute').empty();
                let districtFilter = url.searchParams.get('district');
                let divisionalFilter = url.searchParams.get('divisional_secretariat');

                let flag = false;
                let dsFlag = false;
                appendOptionAll($('#data-tab-district'), districtFilter === '' || districtFilter === null,
                    'district', url);



                provinces[index].districts.forEach((district, idx) => {
                    const isSelected = districtFilter == district.id;
                    if (isSelected) {
                        appendOptionAll($('#data-tab-divisional'), divisionalFilter === '' ||
                            divisionalFilter === null,
                            'divisional_secretariat', url);
                        district.divisional_secretariats.forEach((divisional, idx) => {
                            const isSelectedDS = divisionalFilter == divisional.ds_code;
                            if (isSelectedDS) {
                                dsFlag = true;
                            }
                            appendDivisionalSecretariats(district.divisional_secretariats,
                                divisional, idx,
                                isSelectedDS, url);

                            $(`#divisional_secretariat${idx}`).on('click', function(e) {
                                handleDivisionalClick(district.divisional_secretariats, idx,
                                    url);
                            });

                        });
                        flag = true;
                    }
                    appendDistrict(provinces[index].districts, district, idx, isSelected, url);

                    $(`#district${idx}`).on('click', function(e) {
                        handleDistrictClick(provinces[index].districts, idx, url);
                    });
                });



                if (!flag) {
                    url.searchParams.delete('district');
                }
            }

            function handleDistrictClick(districts, index, url) {
                toggleSelected($('.district'), $(`#district${index}`));

                url.searchParams.set('district', districts[index].id);
                url.searchParams.delete('page');

                $('#data-tab-divisional').empty();
                $('#data-tab-institute').empty();
                let divisionalFilter = url.searchParams.get('divisional_secretariat');
                let flag = false;
                appendOptionAll($('#data-tab-divisional'), divisionalFilter === '' || divisionalFilter === null,
                    'divisional_secretariat', url);

                districts[index].divisional_secretariats.forEach((divisional, idx) => {
                    const isSelected = divisionalFilter == divisional.id;
                    if (isSelected) {
                        flag = true;
                    }
                    appendDivisionalSecretariats(districts[index].divisional_secretariats, divisional, idx,
                        isSelected,
                        url);

                    $(`#divisional_secretariat${idx}`).on('click', function(e) {
                        handleDivisionalClick(districts[index].divisional_secretariats, idx, url);
                    });

                });

                if (!flag) {
                    url.searchParams.delete('divisional_secretariat');
                }
            }


            function handleDivisionalClick(divisionals, index, url) {
                toggleSelected($('.divisional_secretariat'), $(`#divisional_secretariat${index}`));

                url.searchParams.set('divisional_secretariat', divisionals[index].ds_code);
                url.searchParams.delete('page');

                $('#data-tab-institute').empty();


                if (!flag) {
                    url.searchParams.delete('institute');
                }
            }


            function handleInstituteClick(institutes, index, url) {}

            function appendActiveStatus(statuses, status, isSelected, url) {
                const html = itemOptionSlect(
                    `status${status.id}`,
                    'status',
                    status.name,
                    isSelected,
                    `data-index="${status.id}" data-status-id="${status.id}"`
                );
                $('#data-tab-status').append(html);

                $(`#status${status.id}`).off('click').on('click', function() {
                    toggleSelected($('.status'), $(this));
                    url.searchParams.set('status', $(this).data('status-id'));
                });
            }

            function appendInstitute(institutes, institute, isSelected, url) {

                const html = itemOptionSlect('institute' + institute.id, 'institute', institute.name + '('+institute.reg_no+')', isSelected,
                    `data-index="${institute.id}" data-institute-id="${institute.id}"`);
                $('#data-tab-institute').append(html);
                $(`#institute${institute.id}`).off('click').on('click', function() {
                    toggleSelected($('.institute'), $(this));
                    url.searchParams.set('institute', $(this).data('institute-id'));
                    url.searchParams.delete('page');
                });
            }

            // Hàm để thêm district vào modal
            function appendDistrict(districts, district, index, isSelected, url) {
                const html = itemOptionSlect('district' + index, 'district', district.name, isSelected,
                    `data-index="${index}" data-district-id="${district.id}"`);
                $('#data-tab-district').append(html);
                $(`#district${index}`).off('click').on('click', function() {
                    toggleSelected($('.district'), $(this));
                    url.searchParams.set('district', $(this).data('district-id'));

                    handleDistrictClick(districts, index, url);
                });
            }

            function appendDivisionalSecretariats(divisionals, divisional, index, isSelected, url) {
                const html = itemOptionSlect('divisional_secretariat' + index, 'divisional_secretariat', divisional
                    .ds_name,
                    isSelected, `data-index="${index}" data-divisional-secretariat-id="${divisional.ds_code}"`);
                $('#data-tab-divisional').append(html);

                $(`#divisional_secretariat${index}`).off('click').on('click', function() {
                    toggleSelected($('.divisional_secretariat'), $(this));
                    url.searchParams.set('divisional_secretariat', $(this).data(
                        'divisional-secretariat-id'));
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

            function itemOptionSlect(id, name, title, isSelected, data = '') {
                return `
                <span id="${id}" ${data}
                        class="${name} flex justify-between w-full cursor-pointer
                                hover:text-[#4984F6] hover:font-semibold
                                dark:hover:text-[#4984F6]
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

    <script type="module">
        $(document).ready(function() {
            $('.ajax-call').on('click', function() {
                $(".loading").removeClass('hidden');
                let url = $(this).data('url');
                let keeper_id = $(this).data('keeper-id');
                let trainee_id = $(this).data('trainee-id');
                let system = $(this).data('system');
                let status = $(this).data('status');

                if (status === 'favorite') {
                    $('#submit-all').text('UnFavorite');
                } else {
                    $('#submit-all').text('Favorite');
                }

                $('#trainee-id').val(trainee_id);
                $('#keeper-id').val(keeper_id);
                $('#system').val(system);

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#trainee-email').text(response.trainee_user.email);
                        $('#trainee-name').text(response.trainee_user.full_name);
                        $('#trainee-phone').text((response.trainee_user.telephone != null &&
                                response.trainee_user.telephone != '') ? response
                            .trainee_user.telephone : response.trainee_user.mobile);
                        $('#summary_training_block').html(response.trainee_user
                            .sumary_training);
                        $('#trainee-name-heading').text(response.trainee_user.full_name);
                        let src = '';
                        if (response.trainee_user.profile_image) {
                            src = response.trainee_user.profile_image;
                        } else {
                            src = '/images/user-default.svg';
                        }
                        $('#avatar').attr('src', src);
                        $('#trainee-address').text(response.trainee_user.contact_address);
                        let certificateBlock = $('#certificate_block');
                        let educationBlock = $('#education_block');
                        let attachmentBlock = $('#attachment_block');
                        certificateBlock.empty();
                        educationBlock.empty();
                        attachmentBlock.empty();
                        let certificateDiv = ``;
                        let educationDiv = ``;
                        if (response.trainee_certificates != null && response.trainee_certificates.length > 0) {
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
                        } else {
                            certificateDiv +=
                                `<span class="dark:text-white">No information</span>`;
                        }
                        if (response.trainee_information != null && response.trainee_information.length > 0) {
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
                        } else {
                            educationDiv +=
                                `<span class="dark:text-white">No information</span>`;
                        }
                        //                         let attachmentDiv = ``;
                        //                         if (response.trainee_resume.length > 0) {
                        //                             response.trainee_resume.forEach(function(attachment) {
                        //                                 attachmentDiv += `
                    //                                 <div class="flex flex-col gap-4">
                    //                                     <div class="flex gap-4 items-baseline items-center">
                    //                                         <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                    //                                             <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                    //                                         </svg>
                    //                                         <div class="flex flex-col gap-2">
                    //                                             <p>
                    //                                                 <a href="/trainee/preview-cv?cid=` + btoa(attachment.id) + `" target="_blank" class="text-[#464559] text-xl font-semibold dark:text-white dark:text-white hover:text-primary dark:hover:text-primary flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    //   <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                    // </svg>
                    //  Resume</a>
                    //                                             </p>
                    //                                         </div>
                    //                                     </div>
                    //                                 </div>`;
                        //                             });
                        //                         } else {
                        //                             attachmentDiv +=
                        //                                 `<span class="dark:text-white">No CV attachment</span>`;
                        //                         }
                        if (response.trainee_portfolio != '' && response
                            .trainee_portfolio_public) {
                            $("#portfolio_block").html(
                                '<a class="dark:text-white underline text-primary" href="' +
                                response.trainee_portfolio + '" target="_blank">View</a>');
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
@endpush
