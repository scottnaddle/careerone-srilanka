@extends('homepage.layouts.master')
@section('title', 'Trainee System - My page')

@section('content')
    <div class="flex flex-col gap-6 pb-9">
        <p class="font-semibold text-xl md:text-2xl text-[#464559] dark:text-white mt-6">{{trans('system.my_page.title')}}</p>

        {{-- Profile Completion Banner --}}
        @if(empty($user->full_name) || $user->full_name === $user->email || empty($user->nic))
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-6">
            <div class="flex items-start gap-4">
                <div class="flex-shrink-0 w-12 h-12 bg-blue-100 dark:bg-blue-800 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-300">{{ __('trainee.my_page.complete_profile_title') }}</h3>
                    <p class="text-sm text-blue-700 dark:text-blue-400 mt-1">{{ __('trainee.my_page.complete_profile_desc') }}</p>
                    <a href="{{ route('trainee.my-page.personal-information') }}"
                        class="inline-flex items-center gap-2 mt-3 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-xl transition-colors">
                        {{ __('trainee.my_page.complete_profile_cta') }}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div class="grid  grid-cols-1 lg:grid-cols-2 gap-6 row">
            <div class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{trans('system.my_page.my_personal_information')}}</span>
                    <span>
                        <a title="Edit Profile" href="{{route('trainee.my-page.personal-information')}}" class="dark:text-white text-[#706F81] hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col gap-4 items-center justify-center xl:justify-start">
                        @if($user->profile_image)
                            <img class="w-14 h-14 rounded-full object-cover" src="{{ asset($user->profile_image) }}" alt="user photo">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12 md:size-14">
                                <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif
                        <div class="flex flex-col gap-1.5 items-center">
                            <p class="text-xl text-black dark:text-white font-semibold">{{\Str::limit($user->fullName,30)}}</p>
                            <div class="flex gap-5 items-center">
                                <span class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21" fill="none">
                                        <path class="dark:stroke-white" d="M7.48356 7.87767C8.06356 9.08569 8.85422 10.2179 9.85553 11.2192C10.8568 12.2205 11.9891 13.0112 13.1971 13.5912C13.301 13.6411 13.3529 13.666 13.4187 13.6852C13.6523 13.7533 13.9392 13.7044 14.137 13.5627C14.1927 13.5228 14.2403 13.4752 14.3356 13.3799C14.6269 13.0886 14.7726 12.9429 14.9191 12.8477C15.4715 12.4885 16.1837 12.4885 16.7361 12.8477C16.8825 12.9429 17.0282 13.0886 17.3196 13.3799L17.4819 13.5423C17.9248 13.9852 18.1462 14.2066 18.2665 14.4444C18.5058 14.9174 18.5058 15.476 18.2665 15.9489C18.1462 16.1867 17.9248 16.4082 17.4819 16.851L17.3506 16.9824C16.9092 17.4238 16.6886 17.6444 16.3885 17.813C16.0556 18 15.5385 18.1345 15.1567 18.1333C14.8126 18.1323 14.5774 18.0655 14.107 17.932C11.5792 17.2146 9.19387 15.8608 7.20388 13.8709C5.2139 11.8809 3.86017 9.49557 3.1427 6.96774C3.00919 6.49737 2.94244 6.26218 2.94141 5.91806C2.94028 5.53621 3.07475 5.01913 3.26176 4.68621C3.4303 4.38618 3.65098 4.16551 4.09233 3.72416L4.22369 3.59279C4.66656 3.14992 4.888 2.92849 5.12581 2.8082C5.59878 2.56898 6.15734 2.56898 6.6303 2.8082C6.86812 2.92849 7.08955 3.14992 7.53242 3.59279L7.69481 3.75518C7.98615 4.04652 8.13182 4.19219 8.22706 4.33867C8.58622 4.89108 8.58622 5.60323 8.22706 6.15564C8.13182 6.30212 7.98615 6.44779 7.69481 6.73913C7.59955 6.83439 7.55192 6.88202 7.51206 6.9377C7.37038 7.13556 7.32146 7.42244 7.38957 7.65607C7.40873 7.72181 7.43367 7.77376 7.48356 7.87767Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="dark:text-white text-sm">{{trans('trainee.my_page.mobile_1')}}: {{ $user->mobile != '' ?  $user->mobile : "N/G" }}</span>
                            </div>
                            <div class="flex gap-5 items-center">
                                <span class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21" fill="none">
                                        <path class="dark:stroke-white" d="M7.48356 7.87767C8.06356 9.08569 8.85422 10.2179 9.85553 11.2192C10.8568 12.2205 11.9891 13.0112 13.1971 13.5912C13.301 13.6411 13.3529 13.666 13.4187 13.6852C13.6523 13.7533 13.9392 13.7044 14.137 13.5627C14.1927 13.5228 14.2403 13.4752 14.3356 13.3799C14.6269 13.0886 14.7726 12.9429 14.9191 12.8477C15.4715 12.4885 16.1837 12.4885 16.7361 12.8477C16.8825 12.9429 17.0282 13.0886 17.3196 13.3799L17.4819 13.5423C17.9248 13.9852 18.1462 14.2066 18.2665 14.4444C18.5058 14.9174 18.5058 15.476 18.2665 15.9489C18.1462 16.1867 17.9248 16.4082 17.4819 16.851L17.3506 16.9824C16.9092 17.4238 16.6886 17.6444 16.3885 17.813C16.0556 18 15.5385 18.1345 15.1567 18.1333C14.8126 18.1323 14.5774 18.0655 14.107 17.932C11.5792 17.2146 9.19387 15.8608 7.20388 13.8709C5.2139 11.8809 3.86017 9.49557 3.1427 6.96774C3.00919 6.49737 2.94244 6.26218 2.94141 5.91806C2.94028 5.53621 3.07475 5.01913 3.26176 4.68621C3.4303 4.38618 3.65098 4.16551 4.09233 3.72416L4.22369 3.59279C4.66656 3.14992 4.888 2.92849 5.12581 2.8082C5.59878 2.56898 6.15734 2.56898 6.6303 2.8082C6.86812 2.92849 7.08955 3.14992 7.53242 3.59279L7.69481 3.75518C7.98615 4.04652 8.13182 4.19219 8.22706 4.33867C8.58622 4.89108 8.58622 5.60323 8.22706 6.15564C8.13182 6.30212 7.98615 6.44779 7.69481 6.73913C7.59955 6.83439 7.55192 6.88202 7.51206 6.9377C7.37038 7.13556 7.32146 7.42244 7.38957 7.65607C7.40873 7.72181 7.43367 7.77376 7.48356 7.87767Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="dark:text-white text-sm">{{trans('trainee.my_page.mobile_2')}}: {{ $user->telephone != '' ? $user->telephone : "N/G" }}</span>
                            </div>
                            <div class="flex gap-5 items-center">
                                <span  class="dark:text-white">
                                    <span  class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21" fill="none">
                                    <path class="dark:stroke-white" d="M18.417 15.5L12.8813 10.5M8.11937 10.5L2.58369 15.5M2.16699 6.33337L8.97109 11.0962C9.52207 11.4819 9.79756 11.6748 10.0972 11.7495C10.3619 11.8154 10.6387 11.8154 10.9034 11.7495C11.2031 11.6748 11.4786 11.4819 12.0296 11.0962L18.8337 6.33337M6.16699 17.1667H14.8337C16.2338 17.1667 16.9339 17.1667 17.4686 16.8942C17.939 16.6545 18.3215 16.2721 18.5612 15.8017C18.8337 15.2669 18.8337 14.5668 18.8337 13.1667V7.83337C18.8337 6.43324 18.8337 5.73318 18.5612 5.1984C18.3215 4.72799 17.939 4.34554 17.4686 4.10586C16.9339 3.83337 16.2338 3.83337 14.8337 3.83337H6.16699C4.76686 3.83337 4.0668 3.83337 3.53202 4.10586C3.06161 4.34554 2.67916 4.72799 2.43948 5.1984C2.16699 5.73318 2.16699 6.43324 2.16699 7.83337V13.1667C2.16699 14.5668 2.16699 15.2669 2.43948 15.8017C2.67916 16.2721 3.06161 16.6545 3.53202 16.8942C4.0668 17.1667 4.76686 17.1667 6.16699 17.1667Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                </span>
                                <span  class="dark:text-white text-sm">{{$user->email}}</span>
                            </div>
                            <p class="text-[#91919A] text-sm">
                                <button data-popover-target="popover-summary-training-information" type="button" class="text-primary dark:text-white text-sm underline">View summary profile</button>
{{--                                <span>{{isset($user->institute->name) ?? $user->institute->name}}</span>--}}
{{--                                <span>|</span>--}}
{{--                                <span>{{isset($user->district->name) ?? $user->district->name}}</span>--}}
                            </p>
                            <div data-popover id="popover-summary-training-information" role="tooltip" class="p-4 bg-gray-100 absolute z-10 invisible inline-block w-auto text-sm text-gray-500 transition-opacity duration-300 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 dark:text-gray-400 dark:bg-gray-800 dark:border-gray-600">
                                {!! getSumaryTraining($user->id) !!}
                                <div data-popper-arrow></div>
                            </div>
                        </div>
                        <div class="flex flex-col gap-4">
                            <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Deactive account</button>
                        </div>
                            <div id="delete-modal" tabindex="-1" aria-hidden="true"
                                 class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                                <div class="relative p-4 w-full max-w-2xl max-h-full">
                                    <!-- Modal content -->
                                    <div
                                        class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                                        <!-- Modal header -->
                                        <div class="flex items-center justify-between pb-4 border-b rounded-t">
                                            <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                                                {{ trans('system.delete_modal.title') }}
                                            </h3>
                                            <button type="button"
                                                    class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                                    data-modal-hide="delete-modal">
                                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                     fill="none" viewBox="0 0 14 14">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                </svg>
                                                <span class="sr-only">Close modal</span>
                                            </button>
                                        </div>
                                        <!-- Modal body -->
                                        <div class="flex flex-col gap-4">
                                            <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                                 aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                 viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                      stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class=" text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                                                {{trans('trainee.my_page.deactive_msg1')}}</h3>
                                            <p class="dark:text-white text-center text-sm">{{trans('trainee.my_page.deactive_msg2')}}</p>
                                            <div class="flex justify-center gap-4">
                                                <a href="{{route('trainee.my-page.deactive-account')}}"
                                                   class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                                    {{ trans('system.delete_modal.yes') }}
                                                </a>
                                                <button data-modal-hide="delete-modal" type="button"
                                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ trans('system.delete_modal.no') }}</button>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col p-2 lg:p-4 gap-1 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark order-first lg:order-last">
                <label class="flex items-center cursor-pointer gap-2 justify-between bg-[#FAFAFA] p-2 rounded-xl">
                    <input type="checkbox" value="" class="sr-only peer" onclick="togglePublicPortfolio(this)" {{$user->public_portfolio == 1 ? "checked" : ""}}>
                    <span class="font-semibold w-5/6 text-xs md:text-sm font-medium text-gray-900">{{trans('trainee.my_page.public_portfolio_message')}}</span>
                    <div class="w-1/6 relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
                <label class="flex items-center cursor-pointer gap-2 justify-between bg-[#FAFAFA] p-2 rounded-xl">
                    <input type="checkbox" value="" class="sr-only peer" onclick="toggleOpenToWork(this)" {{$user->open_to_work == 1 ? "checked" : ""}}>
                    <span class="font-semibold w-5/6 text-xs md:text-sm font-medium text-gray-900"> {{trans('trainee.my_page.open_to_work_message')}}</span>
                    <div class="w-1/6 relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:w-5 after:h-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600"></div>
                </label>
                <div class="flex justify-center mt-8">
                    {!! checkSkillPassportInformation($user->nic) !!}
                </div>

            </div>

        </div>
        <div class="grid grid-cols-3 lg:grid-cols-6 gap-4 md:gap-6">
            <a href="{{ route('trainee.career-guidance.career-test.list') }}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M16 7C16 6.07003 16 5.60504 15.8978 5.22354C15.6204 4.18827 14.8117 3.37962 13.7765 3.10222C13.395 3 12.93 3 12 3C11.07 3 10.605 3 10.2235 3.10222C9.18827 3.37962 8.37962 4.18827 8.10222 5.22354C8 5.60504 8 6.07003 8 7M5.2 21H18.8C19.9201 21 20.4802 21 20.908 20.782C21.2843 20.5903 21.5903 20.2843 21.782 19.908C22 19.4802 22 18.9201 22 17.8V10.2C22 9.07989 22 8.51984 21.782 8.09202C21.5903 7.71569 21.2843 7.40973 20.908 7.21799C20.4802 7 19.9201 7 18.8 7H5.2C4.07989 7 3.51984 7 3.09202 7.21799C2.71569 7.40973 2.40973 7.71569 2.21799 8.09202C2 8.51984 2 9.07989 2 10.2V17.8C2 18.9201 2 19.4802 2.21799 19.908C2.40973 20.2843 2.71569 20.5903 3.09202 20.782C3.51984 21 4.0799 21 5.2 21Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.career_test')}}</span>
                </div>
            </a>

            <a href="{{route('trainee.career-guidance.counseling.counseling-history')}}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M6.09436 11.2288C6.03221 10.8282 5.99996 10.4179 5.99996 10C5.99996 5.58172 9.60525 2 14.0526 2C18.4999 2 22.1052 5.58172 22.1052 10C22.1052 10.9981 21.9213 11.9535 21.5852 12.8345C21.5154 13.0175 21.4804 13.109 21.4646 13.1804C21.4489 13.2512 21.4428 13.301 21.4411 13.3735C21.4394 13.4466 21.4493 13.5272 21.4692 13.6883L21.8717 16.9585C21.9153 17.3125 21.9371 17.4895 21.8782 17.6182C21.8266 17.731 21.735 17.8205 21.6211 17.8695C21.4911 17.9254 21.3146 17.8995 20.9617 17.8478L17.7765 17.3809C17.6101 17.3565 17.527 17.3443 17.4512 17.3448C17.3763 17.3452 17.3245 17.3507 17.2511 17.3661C17.177 17.3817 17.0823 17.4172 16.893 17.4881C16.0097 17.819 15.0524 18 14.0526 18C13.6344 18 13.2237 17.9683 12.8227 17.9073M7.63158 22C10.5965 22 13 19.5376 13 16.5C13 13.4624 10.5965 11 7.63158 11C4.66668 11 2.26316 13.4624 2.26316 16.5C2.26316 17.1106 2.36028 17.6979 2.53955 18.2467C2.61533 18.4787 2.65322 18.5947 2.66566 18.6739C2.67864 18.7567 2.68091 18.8031 2.67608 18.8867C2.67145 18.9668 2.65141 19.0573 2.61134 19.2383L2 22L4.9948 21.591C5.15827 21.5687 5.24 21.5575 5.31137 21.558C5.38652 21.5585 5.42641 21.5626 5.50011 21.5773C5.5701 21.5912 5.67416 21.6279 5.88227 21.7014C6.43059 21.8949 7.01911 22 7.63158 22Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.guidance')}}</span>
                </div>
            </a>

            <a href="{{route('trainee.career-guidance.portfolios.show')}}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M12.5 2H15.2C16.8802 2 17.7202 2 18.362 2.32698C18.9265 2.6146 19.3854 3.07354 19.673 3.63803C20 4.27976 20 5.11984 20 6.8V17.2C20 18.8802 20 19.7202 19.673 20.362C19.3854 20.9265 18.9265 21.3854 18.362 21.673C17.7202 22 16.8802 22 15.2 22H8.8C7.11984 22 6.27976 22 5.63803 21.673C5.07354 21.3854 4.6146 20.9265 4.32698 20.362C4 19.7202 4 18.8802 4 17.2V16.5M16 13H11.5M16 9H12.5M16 17H8M6 10V4.5C6 3.67157 6.67157 3 7.5 3C8.32843 3 9 3.67157 9 4.5V10C9 11.6569 7.65685 13 6 13C4.34315 13 3 11.6569 3 10V6" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.portfolio')}}</span>
                </div>
            </a>

            <a href="{{route('get-public-event')}}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M14 11H8M10 15H8M16 7H8M20 10.5V6.8C20 5.11984 20 4.27976 19.673 3.63803C19.3854 3.07354 18.9265 2.6146 18.362 2.32698C17.7202 2 16.8802 2 15.2 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H11.5M22 22L20.5 20.5M21.5 18C21.5 19.933 19.933 21.5 18 21.5C16.067 21.5 14.5 19.933 14.5 18C14.5 16.067 16.067 14.5 18 14.5C19.933 14.5 21.5 16.067 21.5 18Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.event')}}</span>
                </div>
            </a>

            <a href="{{route('trainee.job-support.job-list.job-list')}}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M20 12.5V6.8C20 5.11984 20 4.27976 19.673 3.63803C19.3854 3.07354 18.9265 2.6146 18.362 2.32698C17.7202 2 16.8802 2 15.2 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H12M14 11H8M10 15H8M16 7H8M14.5 19L16.5 21L21 16.5" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.job_list')}}</span>
                </div>
            </a>

            <a href="{{route('informations.qnas.list')}}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M20 9.5V6.8C20 5.11984 20 4.27976 19.673 3.63803C19.3854 3.07354 18.9265 2.6146 18.362 2.32698C17.7202 2 16.8802 2 15.2 2H8.8C7.11984 2 6.27976 2 5.63803 2.32698C5.07354 2.6146 4.6146 3.07354 4.32698 3.63803C4 4.27976 4 5.11984 4 6.8V17.2C4 18.8802 4 19.7202 4.32698 20.362C4.6146 20.9265 5.07354 21.3854 5.63803 21.673C6.27976 22 7.11984 22 8.8 22H14M14 11H8M10 15H8M16 7H8M16.5 15.0022C16.6762 14.5014 17.024 14.079 17.4817 13.81C17.9395 13.5409 18.4777 13.4426 19.001 13.5324C19.5243 13.6221 19.999 13.8942 20.3409 14.3004C20.6829 14.7066 20.87 15.2207 20.8692 15.7517C20.8692 17.2506 18.6209 18 18.6209 18M18.6499 21H18.6599" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.qa')}}</span>
                </div>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6">
            <a href="{{route('trainee.career-guidance.counseling.counseling-history')}}">
                <div class="flex flex-col px-2.5 py-2 lg:p-5 gap-6 rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-start bg-[#F4F8FF] justify-between hover:bg-blue-200">
                    <div class="flex items-center justify-between w-full">
                        <!-- Phần văn bản và số ở bên trái -->
                        <div class="flex flex-col justify-start">
                            <span class="text-primary text-sm md:text-base hover:underline h-10 md:h-auto">{{trans('trainee.my_page.my_guidance')}}</span>

                            <div class="flex items-center justify-start w-full">
                                <span class="font-bold text-xl text-primary text-left">
                                    {{ optional($user->cgoCounseling)->count() ?? 0 }}
                                </span>
                            </div>
                        </div>

                        <!-- Phần SVG ở bên phải -->
                        <span class="flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="100" viewBox="0 0 68 43" fill="none">
                                <path d="M59.0261 8.26041L60.6953 12.1085L61.9043 12.09L63.0826 15.0053C63.0826 15.0053 62.2541 16.6545 63.506 17.0066C64.7579 17.3525 66.691 15.413 66.691 15.413C66.691 15.413 62.7573 5.88239 62.0577 5.77121C61.3519 5.65385 59.0261 8.26041 59.0261 8.26041Z" fill="#4984F6"/>
                                <path d="M59.872 8.72975L61.1791 11.5339L62.4556 11.5093L63.6891 14.5914C63.6891 14.5914 62.8115 16.3456 64.131 16.71C65.4504 17.0744 67.5001 15.0114 67.5001 15.0114C67.5001 15.0114 63.6523 9.8539 62.6336 4.80755C61.891 4.69637 59.872 8.72975 59.872 8.72975Z" fill="#4984F6"/>
                                <path d="M63.6284 3.64026C64.2114 5.17208 65.1197 6.24682 65.6658 6.03682C66.212 5.82681 66.1813 4.41236 65.6045 2.88054C65.0215 1.34873 64.1132 0.273976 63.567 0.477807C63.0209 0.687814 63.0454 2.10227 63.6284 3.64026Z" fill="#4984F6"/>
                                <path d="M55.0929 2.8495L62.4756 0.0205865C63.0218 -0.18942 64.065 1.23122 64.8076 3.18922C65.5501 5.14723 65.7097 6.90758 65.1635 7.11758L57.7808 9.94651L55.0929 2.8495Z" fill="#4984F6"/>
                                <path d="M40.3997 13.2576L39.9087 11.9544L35.975 1.55282C35.975 1.55282 37.3742 1.18224 43.1245 2.55346C48.2365 3.77644 54.987 2.887 55.0975 2.84377C55.6437 2.63376 56.687 4.05438 57.4295 6.01239C58.1721 7.97039 58.3316 9.73076 57.7855 9.94076C57.6627 9.99018 51.9984 13.8321 49.0159 18.1187C45.6283 22.9921 44.3396 23.653 44.3396 23.653L40.3997 13.2576Z" fill="#76A5FF"/>
                                <path d="M38.2528 13.3258C35.9454 7.22323 34.9635 1.93598 36.0681 1.51596C37.1727 1.09595 39.9343 5.69758 42.2418 11.794C44.5493 17.8965 45.5312 23.1838 44.4265 23.6038C43.328 24.03 40.5603 19.4283 38.2528 13.3258Z" fill="#4984F6"/>
                                <path d="M39.9834 14.5051L42.61 13.7948C42.4013 13.1833 42.1743 12.5532 41.9288 11.917C41.6895 11.2932 41.4501 10.6817 41.2108 10.0887L38.7929 11.355L39.9834 14.5051Z" fill="#4984F6"/>
                                <path d="M38.904 13.1216C39.2354 13.9925 39.7202 14.6102 39.9841 14.5114C40.2541 14.4064 40.205 13.6219 39.8736 12.751C39.5422 11.8801 39.0574 11.2624 38.7935 11.3613C38.5235 11.4601 38.5726 12.2507 38.904 13.1216Z" fill="#4984F6"/>
                                <path d="M9.33609 26.3252L7.52775 30.494L6.21803 30.4739L4.94155 33.6322C4.94155 33.6322 5.83907 35.4188 4.48282 35.8002C3.12656 36.175 1.03235 34.0738 1.03235 34.0738C1.03235 34.0738 5.29392 23.749 6.05183 23.6286C6.81638 23.5014 9.33609 26.3252 9.33609 26.3252Z" fill="#4984F6"/>
                                <path d="M8.41754 26.834L7.00145 29.8719L5.61859 29.8452L4.2823 33.1842C4.2823 33.1842 5.233 35.0846 3.80362 35.4793C2.37423 35.8741 0.153687 33.6392 0.153687 33.6392C0.153687 33.6392 4.32219 28.0519 5.4258 22.585C6.23025 22.4645 8.41754 26.834 8.41754 26.834Z" fill="#4984F6"/>
                                <path d="M4.35 21.3204C3.71841 22.9798 2.73445 24.1441 2.14276 23.9166C1.55106 23.6891 1.5843 22.1568 2.20924 20.4973C2.84083 18.8379 3.82476 17.6735 4.41646 17.8944C5.00816 18.1219 4.98158 19.6542 4.35 21.3204Z" fill="#4984F6"/>
                                <path d="M13.5953 20.4631L5.59737 17.3984C5.00567 17.1709 3.87547 18.7099 3.07102 20.8311C2.26658 22.9523 2.09373 24.8593 2.68543 25.0868L10.6833 28.1515L13.5953 20.4631Z" fill="#4984F6"/>
                                <path d="M29.5133 31.7385L30.0452 30.3266L34.3068 19.0582C34.3068 19.0582 32.791 18.6568 26.5615 20.1423C21.0235 21.4672 13.7103 20.5036 13.5907 20.4568C12.999 20.2293 11.8688 21.7683 11.0643 23.8894C10.2599 26.0106 10.087 27.9177 10.6787 28.1452C10.8117 28.1987 16.9481 32.3608 20.1791 37.0046C23.849 42.2842 25.2451 43.0001 25.2451 43.0001L29.5133 31.7385Z" fill="#76A5FF"/>
                                <path d="M31.84 31.8125C34.3398 25.2014 35.4035 19.4735 34.2068 19.0185C33.0101 18.5635 30.0184 23.5486 27.5186 30.153C25.0189 36.7641 23.9551 42.492 25.1518 42.947C26.3419 43.4087 29.3403 38.4236 31.84 31.8125Z" fill="#4984F6"/>
                                <path d="M29.9645 33.0901L27.119 32.3206C27.3451 31.6582 27.591 30.9756 27.857 30.2864C28.1163 29.6106 28.3755 28.9481 28.6348 28.3058L31.2542 29.6775L29.9645 33.0901Z" fill="#4984F6"/>
                                <path d="M31.1339 31.5914C30.7749 32.5349 30.2497 33.204 29.9638 33.0969C29.6713 32.9832 29.7245 32.1334 30.0835 31.1899C30.4425 30.2464 30.9677 29.5772 31.2536 29.6843C31.5461 29.7914 31.4929 30.6479 31.1339 31.5914Z" fill="#4984F6"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
            <a href="{{ route('trainee.job-support.job-list.job-list', ['status_job' => 'matched']) }}">
                <div class="flex flex-col px-2.5 py-2 lg:p-5 gap-6 rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-start bg-[#F4F8FF] justify-between hover:bg-blue-200">
                    <div class="flex items-center justify-between w-full">
                        <!-- Phần văn bản và số ở bên trái -->
                        <div class="flex flex-col justify-start">
                            <span class="text-primary text-sm md:text-base hover:underline h-10 md:h-auto">{{trans('trainee.my_page.job_match')}}</span>
                            <div class="flex items-center justify-start w-full">
                                <span class="font-bold text-xl text-primary">{{ $user->jobMatches->count() }}</span>
                            </div>
                        </div>

                        <!-- Phần SVG ở bên phải -->
                        <span class="flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="100" viewBox="0 0 68 43" fill="none">
                                <path d="M15.9601 37.1094L0.935301 53.2648C0.319835 53.9277 0.362109 54.9589 1.0298 55.5687C1.69873 56.1786 2.73943 56.1367 3.35489 55.4751L18.3797 39.3184L15.9601 37.1094Z" fill="#7E88AA"/>
                                <path opacity="0.25" d="M15.9614 37.1094L0.936596 53.2661C0.319887 53.9289 0.362162 54.9577 1.03109 55.5687C1.45881 55.9593 2.03946 56.0813 2.56541 55.9457C1.28598 54.9589 2.08298 53.7934 2.08298 53.7934L15.3248 39.5538L17.0742 40.7217L18.3798 39.3184L15.9614 37.1094Z" fill="#A4ABC4"/>
                                <path d="M13.8251 39.9184L15.7287 41.6556C16.3852 42.2556 16.4275 43.2695 15.822 43.92L5.46723 55.0538C4.86171 55.7043 3.83842 55.7462 3.18192 55.1462L1.27833 53.409C0.621829 52.809 0.579555 51.7951 1.18507 51.1446L11.5398 40.0108C12.1453 39.3603 13.1686 39.3197 13.8251 39.9184Z" fill="#586491"/>
                                <path d="M14.9469 37.5763C22.7154 44.6654 34.8047 44.1799 41.9578 36.4922C49.1022 28.8044 48.6123 16.8156 40.8437 9.72783C33.0851 2.64866 20.9959 3.13407 13.8415 10.8219C6.68969 18.5183 7.18828 30.4885 14.9469 37.5763ZM17.0208 13.7233C22.5513 7.76769 31.9139 7.387 37.9255 12.8769C43.9372 18.3667 44.3115 27.6438 38.7797 33.5908C33.2492 39.5463 23.8867 39.9184 17.875 34.4285C11.8646 28.9473 11.4804 19.6702 17.0208 13.7233Z" fill="#7E88AA"/>
                                <path opacity="0.5" d="M17.8762 34.4273C23.8866 39.9172 33.2492 39.5463 38.7809 33.5895C44.3114 27.6426 43.9371 18.3655 37.9267 12.8756C31.9163 7.38578 22.5537 7.76647 17.022 13.722C11.4803 19.6702 11.8645 28.9473 17.8762 34.4273Z" fill="white"/>
                                <path d="M49.0551 11.7244L30.1367 2.40887L16.8248 28.952L35.7432 38.2676L49.0551 11.7244Z" fill="#4984F6"/>
                                <path opacity="0.5" d="M45.5483 15.4725C47.3149 15.2782 42.8903 21.5302 42.2076 20.51C41.5269 19.4874 44.1888 15.6214 45.5483 15.4725Z" fill="#4984F6"/>
                                <path opacity="0.5" d="M44.8424 14.7859C44.6812 15.8328 46.7701 14.5122 46.8582 13.9854C46.9439 13.4567 45.0727 13.2877 44.8424 14.7859Z" fill="#4984F6"/>
                                <path opacity="0.5" d="M35.7487 38.2845L16.8246 28.96L18.8359 24.9458C22.9866 29.7704 32.3557 33.1333 34.6172 32.0571C37.6058 30.6177 38.1083 25.9127 38.1083 25.9127C38.1083 25.9127 39.5023 26.7971 41.0167 27.7534L35.7487 38.2845Z" fill="#4984F6"/>
                            </svg>
                        </span>
                    </div>
                </div>
            </a>
            <a href="{{route('trainee.job-support.job-list.job-list', ['status_job' => 'applied'])}}">
                <div class="flex flex-col px-2.5 py-2 lg:p-5 gap-6 rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-start bg-[#F4F8FF] justify-between hover:bg-blue-200">
                    <div class="flex items-center justify-between w-full">
                        <!-- Phần văn bản và số ở bên trái -->
                        <div class="flex flex-col justify-start">
                            <span class="text-primary text-sm md:text-base hover:underline h-10 md:h-auto">{{trans('trainee.my_page.applied_job')}}</span>
                            <div class="flex items-center justify-start w-full">
                                <span class="font-bold text-xl text-primary">{{ $user->jobApplies->count() }}</span>
                            </div>
                        </div>

                        <!-- Phần SVG ở bên phải -->
                        <span class="flex justify-end">
                            <svg xmlns="http://www.w3.org/2000/svg" width="150" height="100" viewBox="0 0 68 43" fill="none">
                                <path d="M5.6662 49.1262C24.8768 47.2964 43.036 47.2156 44.7625 49.1262C46.4891 51.0369 42.0583 51.9479 42.1346 53.0425C42.2109 54.137 45.5533 55.3676 43.331 55.8462C41.1099 56.3248 33.0073 54.3423 30.8371 54.7517C28.6668 55.1623 14.4871 56.7508 10.205 55.5729C8.44163 55.0878 9.25659 52.6062 5.02796 52.1866C0.68491 51.7554 4.20538 49.2661 5.6662 49.1262Z" fill="#F0F2F7"/>
                                <path d="M35.5706 5.01207V47.1784C35.5706 49.9462 33.3469 52.1853 30.6096 52.1853H11.3151C8.57778 52.1853 6.35413 49.9462 6.35413 47.1784V5.01207C6.35413 2.24427 8.57778 0 11.3151 0H30.6096C33.3469 0 35.5706 2.24427 35.5706 5.01207Z" fill="#CACFDD"/>
                                <path d="M30.4912 1.86444H27.581C27.361 1.86444 14.5645 1.86444 14.3446 1.86444H11.4344C9.63411 1.86444 8.17456 3.33752 8.17456 5.15578V47.0334C8.17456 48.8504 9.63411 50.3235 11.4344 50.3235H30.4912C32.2915 50.3235 33.7523 48.8504 33.7523 47.0334V5.15578C33.751 3.33752 32.2915 1.86444 30.4912 1.86444Z" fill="white"/>
                                <path d="M24.8729 18.7794H19.7136C19.5445 18.7794 19.4072 18.9179 19.4072 19.0886C19.4072 19.2593 19.5445 19.3978 19.7136 19.3978H24.8729C25.042 19.3978 25.1793 19.2593 25.1793 19.0886C25.1793 18.9179 25.042 18.7794 24.8729 18.7794Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M27.038 16.7775H30.7339C30.903 16.7775 31.0403 16.6389 31.0403 16.4682V16.4618C31.0403 16.2912 30.903 16.1526 30.7339 16.1526H27.038C26.8689 16.1526 26.7316 16.2912 26.7316 16.4618V16.4682C26.7316 16.6389 26.8689 16.7775 27.038 16.7775Z" fill="#CACFDD"/>
                                <path d="M19.7124 16.7775H25.7922C25.9613 16.7775 26.0986 16.6389 26.0986 16.4683V16.4619C26.0986 16.2912 25.9613 16.1526 25.7922 16.1526H19.7124C19.5433 16.1526 19.406 16.2912 19.406 16.4619V16.4683C19.406 16.6389 19.5433 16.7775 19.7124 16.7775Z" fill="#CACFDD"/>
                                <path d="M19.9386 15.085H30.5063C30.8013 15.085 31.0391 14.8437 31.0391 14.5473V14.5358C31.0391 14.2381 30.8 13.9981 30.5063 13.9981H19.9386C19.6436 13.9981 19.4059 14.2393 19.4059 14.5358V14.5473C19.4059 14.8437 19.6449 15.085 19.9386 15.085Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M30.7327 17.4666H24.0897C23.9206 17.4666 23.7833 17.6052 23.7833 17.7759V17.7823C23.7833 17.9529 23.9206 18.0915 24.0897 18.0915H30.7327C30.9018 18.0915 31.0391 17.9529 31.0391 17.7823V17.7759C31.0404 17.6039 30.9031 17.4666 30.7327 17.4666Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M19.7124 18.0915H22.9328C23.1019 18.0915 23.2392 17.9529 23.2392 17.7822V17.7758C23.2392 17.6052 23.1019 17.4666 22.9328 17.4666H19.7124C19.5433 17.4666 19.406 17.6052 19.406 17.7758V17.7822C19.406 17.9529 19.5433 18.0915 19.7124 18.0915Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M17.0348 13.1512H11.4331C11.1305 13.1512 10.8851 13.3989 10.8851 13.7043V19.9123C10.8851 20.2177 11.1305 20.4653 11.4331 20.4653H17.0348C17.3374 20.4653 17.5828 20.2177 17.5828 19.9123V13.7043C17.5828 13.4002 17.3374 13.1512 17.0348 13.1512Z" fill="#CACFDD"/>
                                <path d="M24.8729 29.7017H19.7136C19.5445 29.7017 19.4072 29.8402 19.4072 30.0109C19.4072 30.1816 19.5445 30.3201 19.7136 30.3201H24.8729C25.042 30.3201 25.1793 30.1816 25.1793 30.0109C25.1793 29.8402 25.042 29.7017 24.8729 29.7017Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M27.038 27.6998H30.7339C30.903 27.6998 31.0403 27.5612 31.0403 27.3906V27.3842C31.0403 27.2135 30.903 27.0749 30.7339 27.0749H27.038C26.8689 27.0749 26.7316 27.2135 26.7316 27.3842V27.3906C26.7316 27.5612 26.8689 27.6998 27.038 27.6998Z" fill="#CACFDD"/>
                                <path d="M19.7124 27.6998H25.7922C25.9613 27.6998 26.0986 27.5612 26.0986 27.3906V27.3842C26.0986 27.2135 25.9613 27.0749 25.7922 27.0749H19.7124C19.5433 27.0749 19.406 27.2135 19.406 27.3842V27.3906C19.406 27.5612 19.5433 27.6998 19.7124 27.6998Z" fill="#CACFDD"/>
                                <path d="M19.9386 26.0073H30.5063C30.8013 26.0073 31.0391 25.7661 31.0391 25.4697V25.4582C31.0391 25.1605 30.8 24.9205 30.5063 24.9205H19.9386C19.6436 24.9205 19.4059 25.1617 19.4059 25.4582V25.4697C19.4059 25.7661 19.6449 26.0073 19.9386 26.0073Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M30.7327 28.3877H24.0897C23.9206 28.3877 23.7833 28.5263 23.7833 28.697V28.7034C23.7833 28.8741 23.9206 29.0126 24.0897 29.0126H30.7327C30.9018 29.0126 31.0391 28.8741 31.0391 28.7034V28.697C31.0404 28.5263 30.9031 28.3877 30.7327 28.3877Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M19.7124 29.0139H22.9328C23.1019 29.0139 23.2392 28.8753 23.2392 28.7046V28.6982C23.2392 28.5276 23.1019 28.389 22.9328 28.389H19.7124C19.5433 28.389 19.406 28.5276 19.406 28.6982V28.7046C19.406 28.8753 19.5433 29.0139 19.7124 29.0139Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M17.0348 24.0736H11.4331C11.1305 24.0736 10.8851 24.3213 10.8851 24.6267V30.8347C10.8851 31.1401 11.1305 31.3877 11.4331 31.3877H17.0348C17.3374 31.3877 17.5828 31.1401 17.5828 30.8347V24.6267C17.5828 24.3226 17.3374 24.0736 17.0348 24.0736Z" fill="#CACFDD"/>
                                <path d="M24.8729 40.6241H19.7136C19.5445 40.6241 19.4072 40.7627 19.4072 40.9334C19.4072 41.104 19.5445 41.2426 19.7136 41.2426H24.8729C25.042 41.2426 25.1793 41.104 25.1793 40.9334C25.1793 40.7627 25.042 40.6241 24.8729 40.6241Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M27.038 38.6223H30.7339C30.903 38.6223 31.0403 38.4837 31.0403 38.3131V38.3066C31.0403 38.136 30.903 37.9974 30.7339 37.9974H27.038C26.8689 37.9974 26.7316 38.136 26.7316 38.3066V38.3131C26.7316 38.4837 26.8689 38.6223 27.038 38.6223Z" fill="#CACFDD"/>
                                <path d="M19.7124 38.6223H25.7922C25.9613 38.6223 26.0986 38.4837 26.0986 38.313V38.3066C26.0986 38.136 25.9613 37.9974 25.7922 37.9974H19.7124C19.5433 37.9974 19.406 38.136 19.406 38.3066V38.313C19.406 38.4837 19.5433 38.6223 19.7124 38.6223Z" fill="#CACFDD"/>
                                <path d="M19.9386 36.9298H30.5063C30.8013 36.9298 31.0391 36.6886 31.0391 36.3922V36.3806C31.0391 36.0829 30.8 35.843 30.5063 35.843H19.9386C19.6436 35.843 19.4059 36.0842 19.4059 36.3806V36.3922C19.4059 36.6886 19.6449 36.9298 19.9386 36.9298Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M30.7327 39.3102H24.0897C23.9206 39.3102 23.7833 39.4487 23.7833 39.6194V39.6258C23.7833 39.7965 23.9206 39.9351 24.0897 39.9351H30.7327C30.9018 39.9351 31.0391 39.7965 31.0391 39.6258V39.6194C31.0404 39.4487 30.9031 39.3102 30.7327 39.3102Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M19.7124 39.9363H22.9328C23.1019 39.9363 23.2392 39.7977 23.2392 39.627V39.6206C23.2392 39.45 23.1019 39.3114 22.9328 39.3114H19.7124C19.5433 39.3114 19.406 39.45 19.406 39.6206V39.627C19.406 39.7977 19.5433 39.9363 19.7124 39.9363Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M17.0348 34.996H11.4331C11.1305 34.996 10.8851 35.2437 10.8851 35.549V41.757C10.8851 42.0624 11.1305 42.3101 11.4331 42.3101H17.0348C17.3374 42.3101 17.5828 42.0624 17.5828 41.757V35.549C17.5828 35.2437 17.3374 34.996 17.0348 34.996Z" fill="#CACFDD"/>
                                <path d="M12.2849 18.1916H16.183C16.0584 17.4179 15.4913 16.7943 14.7527 16.5915C14.9739 16.4298 15.1176 16.1668 15.1176 15.8704C15.1176 15.3776 14.7222 14.9786 14.2339 14.9786C13.7457 14.9786 13.3503 15.3776 13.3503 15.8704C13.3503 16.1668 13.494 16.4286 13.7152 16.5915C12.9765 16.7943 12.4095 17.4166 12.2849 18.1916Z" fill="white"/>
                                <path d="M14.9497 14.5114C14.2238 14.1072 13.3097 14.3728 12.9092 15.1055C12.5646 15.7368 12.7121 16.5054 13.2232 16.9661L11.9353 19.322C11.887 19.4105 11.9188 19.5209 12.0065 19.5696L12.2786 19.7211C12.3663 19.7698 12.4756 19.7377 12.5239 19.6492L13.8118 17.2933C14.4704 17.4845 15.1938 17.2009 15.5397 16.5696C15.9389 15.8395 15.6757 14.9169 14.9497 14.5114ZM15.2422 16.4066C14.9319 16.9738 14.2251 17.1804 13.6631 16.8673C13.1011 16.5542 12.8965 15.8395 13.2067 15.2723C13.5169 14.7051 14.2238 14.4985 14.787 14.8129C15.3477 15.1247 15.5524 15.8382 15.2422 16.4066Z" fill="#CACFDD"/>
                                <path d="M12.2849 29.3321H16.183C16.0584 28.5584 15.4913 27.9348 14.7527 27.732C14.9739 27.5703 15.1176 27.3073 15.1176 27.0109C15.1176 26.5181 14.7222 26.1191 14.2339 26.1191C13.7457 26.1191 13.3503 26.5181 13.3503 27.0109C13.3503 27.3073 13.494 27.5691 13.7152 27.732C12.9765 27.9348 12.4095 28.5571 12.2849 29.3321Z" fill="white"/>
                                <path d="M14.9497 25.6533C14.2238 25.2491 13.3097 25.5147 12.9092 26.2474C12.5646 26.8787 12.7121 27.6473 13.2232 28.108L11.9353 30.4639C11.887 30.5524 11.9188 30.6628 12.0065 30.7115L12.2786 30.863C12.3663 30.9117 12.4756 30.8796 12.5239 30.7911L13.8118 28.4352C14.4704 28.6264 15.1938 28.3428 15.5397 27.7115C15.9389 26.9801 15.6757 26.0575 14.9497 25.6533ZM15.2422 27.5472C14.9319 28.1144 14.2251 28.321 13.6631 28.0079C13.1011 27.6948 12.8965 26.9801 13.2067 26.4129C13.5169 25.8458 14.2238 25.6392 14.787 25.9535C15.3477 26.2654 15.5524 26.9801 15.2422 27.5472Z" fill="#CACFDD"/>
                                <path d="M12.2849 40.4726H16.183C16.0584 39.6989 15.4913 39.0753 14.7527 38.8725C14.9739 38.7109 15.1176 38.4478 15.1176 38.1514C15.1176 37.6587 14.7222 37.2596 14.2339 37.2596C13.7457 37.2596 13.3503 37.6587 13.3503 38.1514C13.3503 38.4478 13.494 38.7096 13.7152 38.8725C12.9765 39.0753 12.4095 39.6976 12.2849 40.4726Z" fill="white"/>
                                <path d="M14.9497 36.7938C14.2238 36.3896 13.3097 36.6552 12.9092 37.3879C12.5646 38.0192 12.7121 38.7878 13.2232 39.2485L11.9353 41.6044C11.887 41.6929 11.9188 41.8033 12.0065 41.852L12.2786 42.0035C12.3663 42.0522 12.4756 42.0201 12.5239 41.9316L13.8118 39.5757C14.4704 39.7669 15.1938 39.4833 15.5397 38.852C15.9389 38.1206 15.6757 37.198 14.9497 36.7938ZM15.2422 38.6877C14.9319 39.2549 14.2251 39.4615 13.6631 39.1484C13.1011 38.8353 12.8965 38.1206 13.2067 37.5534C13.5169 36.9863 14.2238 36.7797 14.787 37.094C15.3477 37.4059 15.5524 38.1206 15.2422 38.6877Z" fill="#CACFDD"/>
                                <g opacity="0.5">
                                <path d="M30.1212 5.92181H11.8018C10.7148 5.92181 9.83374 6.81105 9.83374 7.90817V7.94923C9.83374 9.04634 10.7148 9.93558 11.8018 9.93558H30.1212C31.2083 9.93558 32.0893 9.04634 32.0893 7.94923V7.90817C32.0893 6.81105 31.2083 5.92181 30.1212 5.92181Z" fill="#CACFDD"/>
                                </g>
                                <g opacity="0.5">
                                <path d="M25.9624 45.3947H15.963C15.3693 45.3947 14.8887 45.8797 14.8887 46.479V46.5008C14.8887 47.1001 15.3693 47.5851 15.963 47.5851H25.9624C26.5562 47.5851 27.0368 47.1001 27.0368 46.5008V46.479C27.0368 45.881 26.5549 45.3947 25.9624 45.3947Z" fill="#CACFDD"/>
                                </g>
                                <path d="M30.8572 6.97921C30.4275 6.74053 29.8884 6.89708 29.652 7.3308C29.4485 7.70292 29.5363 8.15844 29.8376 8.43047L29.076 9.82143C29.0481 9.87404 29.0659 9.93949 29.118 9.96772L29.2795 10.0575C29.3316 10.0858 29.3964 10.0678 29.4244 10.0152L30.186 8.62423C30.575 8.73715 31.0022 8.56906 31.2069 8.19694C31.4421 7.76323 31.2857 7.21916 30.8572 6.97921ZM31.0289 8.09813C30.8458 8.43304 30.4275 8.55494 30.0957 8.37016C29.7638 8.18539 29.6431 7.76322 29.8261 7.42832C30.0092 7.09341 30.4275 6.97151 30.7593 7.15628C31.0924 7.34234 31.2132 7.76322 31.0289 8.09813Z" fill="#CACFDD"/>
                                <path d="M45.4975 43.239C45.4022 42.7 45.2649 42.1534 45.0818 41.6068C45.0716 41.576 45.0411 41.558 45.0157 41.5683C44.2961 41.8288 43.5816 41.9327 42.9026 41.9263C42.8785 41.9263 42.8569 41.9468 42.8543 41.9737C42.8263 42.4395 42.7577 42.8861 42.6509 43.3083C42.6445 43.3326 42.6661 43.3557 42.6979 43.3621C43.5714 43.511 44.4995 43.5097 45.4441 43.3083C45.4785 43.3006 45.5026 43.2685 45.4975 43.239Z" fill="#F0F2F7"/>
                                <path d="M42.6495 43.316C43.1098 43.1941 43.5344 43.0003 43.9158 42.7463C43.9502 42.7232 43.9908 42.709 44.0328 42.7052C44.0748 42.7013 44.1167 42.709 44.1536 42.727C44.5617 42.922 45.0105 43.1004 45.5 43.248C44.9889 43.1209 44.5185 42.9593 44.09 42.7758C44.0557 42.7617 44.0163 42.7642 43.9845 42.7835C43.5776 43.0285 43.1301 43.2095 42.6495 43.316Z" fill="#CACFDD"/>
                                <path d="M45.1018 41.6684C44.8361 42.0456 44.5145 42.378 44.147 42.6526C44.114 42.6783 44.0733 42.6924 44.0313 42.6962C43.9894 42.7001 43.9487 42.6911 43.9118 42.6731C43.5177 42.4691 43.1643 42.2497 42.8502 42.0277C43.1833 42.2381 43.5571 42.4422 43.9741 42.6269C44.0072 42.641 44.0466 42.6385 44.0771 42.6179C44.4674 42.3575 44.812 42.0379 45.1018 41.6684Z" fill="#CACFDD"/>
                                <path d="M3.73619 6.78541C3.99047 7.45266 4.20025 8.15584 4.36171 8.88981C4.37061 8.93087 4.349 8.97065 4.3134 8.97835C3.3357 9.17724 2.46989 9.54679 1.71596 10.0139C1.68799 10.0305 1.64985 10.0216 1.63077 9.99334C1.2875 9.4929 0.913717 9.03994 0.51323 8.64216C0.490346 8.61906 0.497971 8.578 0.529755 8.55105C1.40574 7.79141 2.44192 7.16266 3.63066 6.74435C3.67516 6.72895 3.7222 6.7482 3.73619 6.78541Z" fill="#F0F2F7"/>
                                <path d="M0.505615 8.63443C1.10062 8.45864 1.70453 8.3855 2.29827 8.40988C2.35294 8.41245 2.40634 8.4009 2.45592 8.37652C2.50551 8.35214 2.54619 8.31493 2.5767 8.27001C2.90218 7.77343 3.28487 7.27042 3.73112 6.77383C3.24545 7.26272 2.82844 7.76445 2.47245 8.25975C2.44448 8.29953 2.39871 8.32262 2.34912 8.32262C1.73504 8.32519 1.11334 8.42656 0.505615 8.63443Z" fill="#CACFDD"/>
                                <path d="M4.34393 8.8063C3.79596 8.56634 3.21494 8.41364 2.6212 8.35719C2.56653 8.35205 2.51186 8.36232 2.46355 8.3867C2.41397 8.41108 2.37328 8.44829 2.34658 8.4932C2.04272 8.98851 1.7948 9.47354 1.59265 9.93549C1.82404 9.47483 2.10629 8.99235 2.44829 8.50218C2.47499 8.46369 2.52076 8.44059 2.56907 8.44316C3.17425 8.46882 3.77307 8.59201 4.34393 8.8063Z" fill="#CACFDD"/>
                                <path d="M44.7066 51.1257L34.7742 40.2446C34.6799 40.1431 34.5259 40.1368 34.4253 40.2288L33.1618 41.4025C33.0612 41.4977 33.0549 41.6532 33.1461 41.7547L43.0785 52.6357C43.4933 53.0893 44.1911 53.1179 44.6406 52.6991C45.0932 52.2867 45.1215 51.5793 44.7066 51.1257Z" fill="#4984F6"/>
                                <path opacity="0.25" d="M34.6044 40.0638L44.7065 51.1288C45.1214 51.5825 45.0931 52.2867 44.6436 52.7055C44.3576 52.9719 43.9647 53.0576 43.6127 52.9624C44.4739 52.2867 43.9364 51.4873 43.9364 51.4873L35.0319 41.7357L33.8563 42.5351L32.9794 41.5739L34.6044 40.0638Z" fill="#2F50CD"/>
                                <path d="M36.0407 41.9865L34.7614 43.1761C34.3214 43.5853 34.2931 44.2801 34.6985 44.7273L41.6606 52.3536C42.0661 52.8009 42.7545 52.8262 43.1977 52.417L44.4769 51.2274C44.917 50.8182 44.9453 50.1234 44.5398 49.6761L37.5777 42.0499C37.1691 41.6058 36.4839 41.5773 36.0407 41.9865Z" fill="#4377EC"/>
                                <path d="M34.5448 31.1562C31.9202 28.2821 27.4821 28.1013 24.6344 30.747C21.7835 33.3958 21.6044 37.8783 24.2258 40.7524C26.8503 43.6265 31.2885 43.8073 34.1393 41.1585C36.987 38.5096 37.1724 34.0335 34.5448 31.1562ZM33.0643 39.9815C30.8578 42.034 27.4224 41.8944 25.3919 39.6675C23.3614 37.4437 23.4997 33.9764 25.7062 31.9239C27.9127 29.8714 31.3482 30.0142 33.3787 32.2411C35.4123 34.4649 35.2708 37.9322 33.0643 39.9815Z" fill="#4984F6"/>
                                <path opacity="0.5" d="M33.064 39.9814C30.8575 42.0338 27.422 41.8942 25.3916 39.6673C23.3611 37.4435 23.4994 33.9762 25.7059 31.9237C27.9124 29.8712 31.3479 30.014 33.3783 32.2409C35.412 34.4647 35.2705 37.932 33.064 39.9814Z" fill="white"/>
                                <path opacity="0.5" d="M25.1026 33.8207C24.5777 35.1118 25.1026 39.6102 27.196 39.718C29.2893 39.8227 28.7047 38.2397 27.4883 37.5006C26.275 36.7583 25.3729 33.1545 25.1026 33.8207Z" fill="#CACFDD"/>
                                <path opacity="0.5" d="M25.6466 32.6533C25.3471 33.2656 25.8988 34.0555 26.1101 33.4401C26.3182 32.8278 25.9209 32.0982 25.6466 32.6533Z" fill="#CACFDD"/>
                                </svg>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </div>

@endsection
@push('js')
    <script>
        function togglePublicPortfolio(attr) {
            let status = 0;
            if(attr.checked) {
                status = 1;
            }
            window.location.href = "/trainee/my-page/public-portfolio/?status="+status;
        }

        function toggleOpenToWork(attr) {
            let status = 0;
            if(attr.checked) {
                status = 1;
            }
            window.location.href = "/trainee/my-page/open-to-work/?status="+status;
        }
    </script>
@endpush
