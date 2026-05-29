@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - OJT List - Trainee Match')

@section('content')
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.root')}}</p> --}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.menu.job_support.job_list'), 'url' => route('cgo.job-support.job-list.list')],
                ['label' => trans('cgo.job_support.ojt_list.trainee_match.root'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold"
                    href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                        <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2"
                            stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ $job->title }}
                </a>
            <form class="flex flex-col w-full gap-4"
                action="{{ route('cgo.job-support.job-list.trainee-match', ['slug' => $job->slug]) }}" method="GET">
                <div class="flex gap-6 items-center">
                    <label for="simple-search" class="sr-only">Search</label>
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                            </svg>
                        </div>
                        <input type="text" id="simple-search" name="search" value="{{ request('search') }}"
                            class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            placeholder="{{ __('general.Trainee name') }}" />
                    </div>
                    <button type="submit"
                        class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                        {{ trans('cgo.job_support.ojt_list.trainee_match.search') }}
                    </button>
                </div>

            </form>
            <div class="flex justify-between items-center">
                @if (request()->has('search') && request()->query('search') != '')
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $trainees->total() }}
                        {{ trans('cgo.job_support.ojt_list.trainee_match.filterResults') }}</p>
                @else
                    <p></p>
                @endif
                {{--                <select id="trainee_type" name="trainee_type" --}}
                {{--                    class="bg-[#F8F8F8] font-semibold border border-gray-300 text-[#706F81] text-sm rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"> --}}
                {{--                    <option value="all" @selected(request()->get('trainee_type') == strtolower(trans('cgo.job_support.ojt_list.trainee_match.filter.all')))>{{ trans('cgo.job_support.ojt_list.trainee_match.filter.all') }}</option> --}}
                {{--                    <option value="keep" @selected(request()->get('trainee_type') == strtolower(trans('cgo.job_support.ojt_list.trainee_match.filter.keep')))>{{ trans('cgo.job_support.ojt_list.trainee_match.filter.keep') }}</option> --}}
                {{--                    <option value="unkeep" @selected(request()->get('trainee_type') == strtolower(trans('cgo.job_support.ojt_list.trainee_match.filter.unkeep')))>{{ trans('cgo.job_support.ojt_list.trainee_match.filter.unkeep') }}</option> --}}
                {{--                </select> --}}
            </div>
            <div class="flex flex-col divide-y divide-inherit dark:divide-white lg:divide-y-0">
                @foreach ($trainees as $item)
                    <div
                        class="flex flex-col gap-5 lg:flex-row justify-between lg:px-5 py-2 md:py-3 hover:bg-blue-100 dark:hover:bg-gray-700 rounded-xl">
                        <div class="flex gap-6 items-center">
                            @if (isset($item->profile_image))
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
                                <p class="flex gap-3">
                                    <a href="javascript:void(0)"
                                        data-url="{{ route('cgo.job-support.trainee-list.information', $item->id) }}"
                                        data-modal-target="default-modal" data-modal-toggle="default-modal"
                                        class="ajax-call text-primary font-semibold hover:text-blue-700 dark:hover:text-white">{{ $item->fullName }}</a>
                                    {{--                                    <span class="text-[#464559] dark:text-white">|</span> --}}
                                    {{--                                    <span --}}
                                    {{--                                        class="text-[#464559] dark:text-white">{{ \Carbon\Carbon::parse($item->created_at)->diffForHumans(['parts' => 1, 'short' => false, 'syntax' => \Carbon\Carbon::DIFF_ABSOLUTE]) }}</span> --}}
                                </p>
                                <p class="text-[#706F81]  gap-3 dark:text-white">
                                    {!! getNewestTrainingInformationOfTrainee($item->id) !!}
                                </p>
                                {{--                                <p class="text-sm text-[#706F81] dark:text-white"> --}}
                                {{--                                    {{ trans('cgo.job_support.ojt_list.trainee_match.updated') }} {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }} --}}
                                {{--                                </p> --}}
                            </div>
                        </div>
                        <div
                            class="flex gap-6 items-center justify-center md:justify-start lg:justify-center md:justify-end lg:justify-center md:justify-start lg:justify-center">
                            {{-- <a href="{{ route('cgo.job-support.ojt-list.trainee-information', ['slug' => $job->slug, 'trainee' => $item]) }}"
                                class="whitespace-nowrap px-4 lg:px-6 py-2 lg:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-700 shadow-xs hover:text-white text-center">
                                {{ trans('cgo.job_support.ojt_list.trainee_match.ojt_match_button')}}
                            </a> --}}
                            <input onchange="handleCheckboxChange(this)"
                                {{ $job->checkMatched($job->id, $item->id) ? 'checked' : '' }} id="checked-checkbox"
                                type="checkbox" value="{{ $job->id }}" data-trainee-id="{{ $item->id }}"
                                data-matched-by="{{ $job->checkMatched($job->id, $item->id) ? getCGOIdMatchedTraineeToJob($item->id, $job->id) : Auth::guard(activeGuard())->user()->id }}"
                                data-system="{{ activeGuard() }}"
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-[#1E1E1E] dark:border-gray-600 {{ $job->checkMatched($job->id, $item->id) && getCGOIdMatchedTraineeToJob($item->id, $job->id) != Auth::guard(activeGuard())->user()->id ? 'cursor-not-allowed' : '' }}"
                                {{ $job->checkMatched($job->id, $item->id) && getCGOIdMatchedTraineeToJob($item->id, $job->id) != Auth::guard(activeGuard())->user()->id ? 'disabled="disabled"' : '' }}>

                            </div>
                    </div>
                    <hr class="w-full h-px my-4 bg-gray-100 border-0 dark:bg-gray-500 ">
                @endforeach

            </div>

            {{--            //cái này gọi tailwind pagination trong vendor ra --}}
            {{ $trainees->onEachSide(1)->links() }}
        </div>
    </div>

    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true"
        class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative w-full max-w-4xl max-h-full">
            <!-- Modal content -->
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
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
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
                        <img class="w-32 h-32 rounded-full" id="avatar" src="{{ asset('/images/user-default.svg') }}"
                            alt="user photo">
                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold"
                                id="trainee-name-heading"></p>
                            {{--                            <div class="text-[#91919A] dark:text-white" id="summary_training_block"> --}}

                            {{--                            </div> --}}
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
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        let url = new URL(window.location.href);
        $('#trainee_type').on('change', function() {
            if (url.searchParams.has('trainee_type')) {
                url.searchParams.set('trainee_type', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('trainee_type', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });

    </script>
        <script>
            function handleCheckboxChange(checkbox) {
                toggleLoadingOverlay();
                const job_id = checkbox.value;
                const traineeId = checkbox.getAttribute('data-trainee-id');
                const matched_by = checkbox.getAttribute('data-matched-by');
                const system = checkbox.getAttribute('data-system');
                $.ajax({
                    url: '{{ route('cgo.job-support.job-list.match-trainee') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        job_id: job_id,
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
                        console.error('Error:', error);
                        toggleLoadingOverlay();
                    }
                });

            }
        </script>
    <script type="module">
        $(document).ready(function() {
            $('.ajax-call').on('click', function() {
                let url = $(this).data('url');
                $(".loading").removeClass('hidden');

                $.ajax({
                    url: url,
                    type: 'GET',
                    success: function(response) {
                        $('#trainee-email').text(response.trainee_user.email);
                        $('#trainee-name').text(response.trainee_user.full_name);
                        $('#trainee-phone').text((response.trainee_user.mobile != null &&
                                response.trainee_user.mobile != '') ? response.trainee_user
                            .mobile : response.trainee_user.telephone);
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
                        if (response.trainee_certificates != null && response
                            .trainee_certificates.length > 0) {
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
                        if (response.trainee_information != null && response.trainee_information
                            .length > 0) {
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
                        //                         if(response.trainee_resume.length > 0) {
                        //                             response.trainee_resume.forEach(function(attachment) {
                        //                                 attachmentDiv += `
                    //                                 <div class="flex flex-col gap-4">
                    //                                     <div class="flex gap-4 items-center">
                    //                                         <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                    //                                             <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                    //                                         </svg>
                    //                                         <div class="flex flex-col gap-2">
                    //                                             <p>
                    //                                                 <a href="/trainee/preview-cv?cid=`+btoa(attachment.id)+`" target="_blank" class="text-[#464559] text-xl font-semibold dark:text-white dark:text-white hover:text-primary dark:hover:text-primary flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    //   <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                    // </svg>
                    //  Resume</a>
                    //                                             </p>
                    //                                         </div>
                    //                                     </div>
                    //                                 </div>`;
                        //                             });
                        //                         }else {
                        //                             attachmentDiv += `<span class="dark:text-white">No CV attachment</span>`;
                        //                         }

                        if (response.trainee_portfolio != '') {
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
