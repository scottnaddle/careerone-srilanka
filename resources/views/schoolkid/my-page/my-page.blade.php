@extends('homepage.layouts.master')
@section('title', 'School Kid System - My page')

@section('content')
    <div class="flex flex-col gap-6 pb-9">
        <p class="font-semibold text-xl md:text-2xl text-[#464559] dark:text-white mt-6">{{trans('system.my_page.title')}}</p>
        <div class="grid  grid-cols-1 lg:grid-cols-1 gap-6 row">
            <div class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{trans('system.my_page.my_personal_information')}}</span>
                    <span>
                        <a title="Edit Profile" href="{{route('schoolkid.my-page.personal-information')}}" class="dark:text-white text-[#706F81] hover:text-primary">
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
                                                <a href="{{route('schoolkid.my-page.deactive-account')}}"
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


        </div>
        <div class="grid grid-cols-2 lg:grid-cols-2 gap-4 md:gap-6">
            <a href="{{ route('schoolkid.career-guidance.career-test.list') }}">
                <div class="flex flex-col px-2.5 py-2 lg:px-5 lg:py-4 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark items-center justify-between hover:bg-blue-100 dark:hover:bg-gray-700 h-full">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path class="dark:stroke-white" d="M16 7C16 6.07003 16 5.60504 15.8978 5.22354C15.6204 4.18827 14.8117 3.37962 13.7765 3.10222C13.395 3 12.93 3 12 3C11.07 3 10.605 3 10.2235 3.10222C9.18827 3.37962 8.37962 4.18827 8.10222 5.22354C8 5.60504 8 6.07003 8 7M5.2 21H18.8C19.9201 21 20.4802 21 20.908 20.782C21.2843 20.5903 21.5903 20.2843 21.782 19.908C22 19.4802 22 18.9201 22 17.8V10.2C22 9.07989 22 8.51984 21.782 8.09202C21.5903 7.71569 21.2843 7.40973 20.908 7.21799C20.4802 7 19.9201 7 18.8 7H5.2C4.07989 7 3.51984 7 3.09202 7.21799C2.71569 7.40973 2.40973 7.71569 2.21799 8.09202C2 8.51984 2 9.07989 2 10.2V17.8C2 18.9201 2 19.4802 2.21799 19.908C2.40973 20.2843 2.71569 20.5903 3.09202 20.782C3.51984 21 4.0799 21 5.2 21Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <span class="text-primary dark:text-white text-sm md:text-base font-semibold text-center break-words hover:underline w-full">{{trans('trainee.my_page.career_test')}}</span>
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


        </div>
    </div>

@endsection

