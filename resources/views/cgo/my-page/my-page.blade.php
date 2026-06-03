@extends('homepage.layouts.master')
@section('title', 'CGO - My page')

@section('content')
    <div class="flex flex-col gap-6 pb-9">
        <p class="font-semibold text-2xl text-[#464559] dark:text-white mt-6">{{ trans('system.my_page.title') }}</p>
        <div class="grid  grid-cols-1 lg:grid-cols-2 gap-6">
            <div
                class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('system.my_page.my_personal_information') }}
                    </span>
                    <span>
                        <a title="Edit Profile" href="{{ route('cgo.my-page.personal-information') }}"
                            class="text-[#91919A] flex dark:text-white hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 items-center justify-center xl:justify-start">
                        <div class="flex flex-col items-center gap-4">
                            @if ($user->profile_image)
                                <img class="w-16 h-16 rounded-full object-cover" src="{{ asset($user->profile_image) }}"
                                    alt="user photo">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-12">
                                    <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"
                                        d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                            @endif
{{--                            <div class="flex">--}}
{{--                                <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal"--}}
{{--                                    class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Deactive--}}
{{--                                    account</button>--}}
{{--                            </div>--}}
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
                                                    <path stroke="currentColor" stroke-linecap="round"
                                                        stroke-linejoin="round" stroke-width="2"
                                                        d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
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
                                                    stroke-width="2"
                                                    d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                            </svg>
                                            <h3 class=" text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                                                Are you sure deactive your account?</h3>
                                            <p class="dark:text-white text-center text-sm">After you deactive your account,
                                                you can not login to our system!</p>
                                            <div class="flex justify-center gap-4">
                                                <a href="{{ route('cgo.my-page.deactive-account') }}"
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


                        <div class="flex flex-col gap-1.5 items-center lg:items-start">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= $statistics['averageFeedback']; $i++)
                                    <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                @endfor
                                @for ($i = 1; $i <= 5 - $statistics['averageFeedback']; $i++)
                                    <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                                        <path
                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                    </svg>
                                @endfor
                            </div>
                            <p class="text-lg text-black dark:text-white font-semibold break-all w-full">
                                {{ \Str::limit($user->fullName, 30) }}
                            </p>

                            <p class="text-[#91919A] text-sm">
                                <span>{{ $user->institute->name }}</span>
                                <span>|</span>
                                <span>{{ $user->district->name }}</span>
                            </p>

                        </div>
                        <div class="flex flex-col gap-4  items-center lg:items-start">
                            <div class="flex gap-5 items-center">
                                <span class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 21 21" fill="none">
                                        <path
                                            d="M7.48356 7.87767C8.06356 9.08569 8.85422 10.2179 9.85553 11.2192C10.8568 12.2205 11.9891 13.0112 13.1971 13.5912C13.301 13.6411 13.3529 13.666 13.4187 13.6852C13.6523 13.7533 13.9392 13.7044 14.137 13.5627C14.1927 13.5228 14.2403 13.4752 14.3356 13.3799C14.6269 13.0886 14.7726 12.9429 14.9191 12.8477C15.4715 12.4885 16.1837 12.4885 16.7361 12.8477C16.8825 12.9429 17.0282 13.0886 17.3196 13.3799L17.4819 13.5423C17.9248 13.9852 18.1462 14.2066 18.2665 14.4444C18.5058 14.9174 18.5058 15.476 18.2665 15.9489C18.1462 16.1867 17.9248 16.4082 17.4819 16.851L17.3506 16.9824C16.9092 17.4238 16.6886 17.6444 16.3885 17.813C16.0556 18 15.5385 18.1345 15.1567 18.1333C14.8126 18.1323 14.5774 18.0655 14.107 17.932C11.5792 17.2146 9.19387 15.8608 7.20388 13.8709C5.2139 11.8809 3.86017 9.49557 3.1427 6.96774C3.00919 6.49737 2.94244 6.26218 2.94141 5.91806C2.94028 5.53621 3.07475 5.01913 3.26176 4.68621C3.4303 4.38618 3.65098 4.16551 4.09233 3.72416L4.22369 3.59279C4.66656 3.14992 4.888 2.92849 5.12581 2.8082C5.59878 2.56898 6.15734 2.56898 6.6303 2.8082C6.86812 2.92849 7.08955 3.14992 7.53242 3.59279L7.69481 3.75518C7.98615 4.04652 8.13182 4.19219 8.22706 4.33867C8.58622 4.89108 8.58622 5.60323 8.22706 6.15564C8.13182 6.30212 7.98615 6.44779 7.69481 6.73913C7.59955 6.83439 7.55192 6.88202 7.51206 6.9377C7.37038 7.13556 7.32146 7.42244 7.38957 7.65607C7.40873 7.72181 7.43367 7.77376 7.48356 7.87767Z"
                                            stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </span>
                                <span class="dark:text-white text-sm">{{ formatPhoneNumber($user->telephone) }}</span>
                            </div>
                            <div class="flex gap-5 items-center">
                                <span class="dark:text-white">
                                    <span class="dark:text-white">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 21 21" fill="none">
                                            <path
                                                d="M18.417 15.5L12.8813 10.5M8.11937 10.5L2.58369 15.5M2.16699 6.33337L8.97109 11.0962C9.52207 11.4819 9.79756 11.6748 10.0972 11.7495C10.3619 11.8154 10.6387 11.8154 10.9034 11.7495C11.2031 11.6748 11.4786 11.4819 12.0296 11.0962L18.8337 6.33337M6.16699 17.1667H14.8337C16.2338 17.1667 16.9339 17.1667 17.4686 16.8942C17.939 16.6545 18.3215 16.2721 18.5612 15.8017C18.8337 15.2669 18.8337 14.5668 18.8337 13.1667V7.83337C18.8337 6.43324 18.8337 5.73318 18.5612 5.1984C18.3215 4.72799 17.939 4.34554 17.4686 4.10586C16.9339 3.83337 16.2338 3.83337 14.8337 3.83337H6.16699C4.76686 3.83337 4.0668 3.83337 3.53202 4.10586C3.06161 4.34554 2.67916 4.72799 2.43948 5.1984C2.16699 5.73318 2.16699 6.43324 2.16699 7.83337V13.1667C2.16699 14.5668 2.16699 15.2669 2.43948 15.8017C2.67916 16.2721 3.06161 16.6545 3.53202 16.8942C4.0668 17.1667 4.76686 17.1667 6.16699 17.1667Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </span>
                                <span class="dark:text-white text-sm break-words">{{ $user->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center">
                        <div
                            class="w-1/2 bg-[#E3EEFF] dark:bg-[#383838] flex flex-col gap-2 py-2 px-4 lg:py-4 lg:px-8 justify-center rounded-xl bg-opacity-50 xs:items-center">
                            <span class="text-primary text-sm md:text-base">{{trans('cgo.online')}}
                                ({{ $statistics['onlineCounselingRequested'] }})</span>
                            @if ($statistics['onlineCounselingRequested'] == 0)
                                <span
                                    class="font-semibold text-primary text-lg md:text-xl">{{ trans('system.no_reservation') }}</span>
                            @else
                                <a href="{{ route('cgo.career-guidance.counseling.counseling-list', ['type' => '2', 'status' => '1']) }}"><span
                                        class="font-semibold text-primary text-lg md:text-xl">{{ trans('system.action.view_more') }}</span></a>
                            @endif
                        </div>
                        <div
                            class="w-1/2 bg-[#E3EEFF] dark:bg-[#383838] flex flex-col gap-2 py-2 px-4 lg:py-4 lg:px-8 justify-center rounded-xl bg-opacity-50 xs:items-center">
                            <span class="text-primary text-sm md:text-base">{{trans('cgo.offline')}}
                                ({{ $statistics['offlineCounselingRequested'] }}) </span>
                            @if ($statistics['offlineCounselingRequested'] == 0)
                                <span
                                    class="font-semibold text-primary text-lg md:text-xl">{{ trans('system.no_reservation') }}</span>
                            @else
                                <a
                                    href="{{ route('cgo.career-guidance.counseling.counseling-list', ['type' => 'offline', 'status' => '1']) }}"><span
                                        class="font-semibold text-primary text-lg md:text-xl">{{ trans('system.action.view_more') }}</span></a>
                            @endif
                        </div>
                    </div>

                </div>
            </div>

            <div
                class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('system.my_page.my_schedule') }}
                    </span>
                    <span class="">
                        <a href="{{ route('cgo.career-guidance.counseling.my-schedule') }}"
                            class="flex items-center gap-1 text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>


                <div class="overflow-x-auto">
                    <table class="w-full text-left rtl:text-right border-collapse table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828]">
                            <tr class="border border-white">
                                <th scope="col" class="px-2 sm:px-4 py-2 text-center border border-white">
                                    <p class="font-bold text-primary text-xs sm:text-sm dark:text-white">
                                        {{ $schedule['currentDate']->format('M') }}</p>
                                    <p class="font-medium text-medium text-primary text-xs sm:text-sm dark:text-white">
                                        {{ $schedule['currentDate']->year }}</p>
                                </th>
                                @foreach ($schedule['listWorkingDayCurrentWeek'] as $workingDay)
                                    <th scope="col" class="px-2 sm:px-4 py-2 text-center border border-white">
                                        <p class="font-bold text-primary text-xs sm:text-sm dark:text-white">
                                            {{ $workingDay['dayName'] }}</p>
                                        <p class="font-medium text-medium text-primary text-xs sm:text-sm dark:text-white">
                                            {{ $workingDay['dayNumber'] }}</p>
                                    </th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>

                            <tr class="bg-white dark:bg-[#1E1E1E]">
                                <!-- Header cho cột PM -->
                                <td
                                    class="px-2 sm:px-4 py-2 border border-[#F8F8F8] font-medium text-xs sm:text-sm text-[#706F81] dark:text-white">

                                </td>

                                @foreach ($schedule['listScheduleCounseling']['weekly'] as $day => $weeklyCounselingPerDay)
                                    @if (!empty($weeklyCounselingPerDay['items']))
                                        <td class="px-2 py-1 border border-[#F8F8F8]">
                                            <div class="flex items-center gap-1">
                                                <div class=" gap-1">
                                                    @foreach ($weeklyCounselingPerDay['count_by_status'] as $key => $value)
                                                        <div class="relative flex items-center gap-1 group">
                                                            <!-- Colored Dot -->
                                                            <span
                                                                class="text-xs sm:text-sm font-medium text-[#464559] dark:text-white">
                                                                {{ $value }}
                                                            </span>
                                                            <span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" width="13"
                                                                    height="12" viewBox="0 0 13 12" fill="none">
                                                                    <circle cx="6.5" cy="6" r="6"
                                                                        fill="{{ match ($key) {
                                                                            \App\Enums\CgoCounselingStatusEnums::CONFIRM->value => '#4984F6',
                                                                            \App\Enums\CgoCounselingStatusEnums::REQUEST->value => '#9F9FAA',
                                                                            \App\Enums\CgoCounselingStatusEnums::COMPLETED->value => '#62B96A',
                                                                            \App\Enums\CgoCounselingStatusEnums::CANCELED->value => '#F34550',
                                                                            default => '#9F9FAA',
                                                                        } }}" />
                                                                </svg>
                                                            </span>
                                                            <div
                                                                class="absolute left-1/2 -translate-x-1/2 -top-8 opacity-0 group-hover:opacity-100 transition-opacity duration-200 bg-black text-white text-xs rounded-md px-2 py-1">
                                                                {{ match ($key) {
                                                                    \App\Enums\CgoCounselingStatusEnums::REQUEST->value => 'Request',
                                                                    \App\Enums\CgoCounselingStatusEnums::CONFIRM->value => 'Confirmed',
                                                                    \App\Enums\CgoCounselingStatusEnums::COMPLETED->value => 'Completed',
                                                                    \App\Enums\CgoCounselingStatusEnums::CANCELED->value => 'Canceled',
                                                                    default => 'Unknown Status',
                                                                } }}
                                                            </div>

                                                            <!-- Count -->

                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </td>
                                    @else
                                        <!-- No counseling -->
                                        <td class="px-2 py-1 border border-[#F8F8F8]">
                                            <div class="flex flex-col gap-1">
                                                {{-- <ul class="max-w-md space-y-1 list-disc list-inside text-xs">
                                                    <li class="text-[#464559] dark:text-white">
                                                        {{ trans('cgo.none') }}
                                                    </li>
                                                </ul> --}}
                                            </div>
                                        </td>
                                    @endif
                                @endforeach


                            </tr>

                        </tbody>
                    </table>

                </div>
                <div class="flex flex-wrap gap-4 show-example mt-auto">
                    <div class="flex items-center gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"
                                fill="none">
                                <circle cx="6.5" cy="6" r="6" fill="#4984F6" />
                            </svg>
                        </span>
                        <span class="text-xs dark:text-white">{{ __('cgo.confirm') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"
                                fill="none">
                                <circle cx="6.5" cy="6" r="6" fill="#9F9FAA" />
                            </svg>
                        </span>
                        <span class="text-xs dark:text-white">{{ __('cgo.request') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"
                                fill="none">
                                <circle cx="6.5" cy="6" r="6" fill="#62B96A" />
                            </svg>
                        </span>
                        <span class="text-xs dark:text-white">{{ __('cgo.completed') }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12"
                                fill="none">
                                <circle cx="6.5" cy="6" r="6" fill="#F34550" />
                            </svg>
                        </span>
                        <span class="text-xs dark:text-white">{{__('cgo.cancel')}}</span>
                    </div>
                </div>
            </div>

        </div>
        <div
            class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
            <div class="flex justify-between items-center">
                <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                    <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                    {{ trans('system.my_page.counseling_status') }}
                </span>
                <span class="">
                    <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}"
                        class="flex items-center gap-1 text-[#91919A] flex dark:text-white hover:text-primary">{{ trans('system.action.view_more') }}
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                            stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </a>
                </span>
            </div>
            <div
                class="bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">

                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.type') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.counseling_field') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.registration_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.counseling_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    Trainee Institute
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.trainee_name') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.status') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ __('cgo.feedback') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($counselings as $counseling)

                                <tr class=" clickable-row cursor-pointer bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700"
                                    data-href="{{ route('cgo.career-guidance.counseling.counseling-list.show', ['id' => $counseling->counseling_id]) }}">
                                    <td class="px-4 py-6 text-sm">
                                        <div class="flex gap-1 items-center">
                                            @if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'online'))
                                                <img src="{{ asset('images/online.svg') }}" alt="Online"
                                                    class="w-3 h-3">
                                                <span
                                                    class="text-sm text-[#7AED86]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                                            @endif
                                            @if (
                                                $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'offline') ||
                                                    $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                                                <img src="{{ asset('images/offline.svg') }}" alt="Offline"
                                                    class="w-3 h-3">
                                                <span
                                                    class="text-sm text-[#91919A]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white">
                                        {{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }}
                                    </td>
                                    <td class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white max-w-80 whitespace-nowrap overflow-hidden text-ellipsis hover:text-primary text-left">
                                        {{ Str::limit($counseling->title, 30) }}
                                    </td>

                                    <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {{ date('Y-m-d', strtotime($counseling->registration_date)) }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {{ date('Y-m-d', strtotime($counseling->available_time)) }}
                                        {{ $counseling->shift ?? '' }}
                                    </td>
                                    <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {!! getInstitutes($counseling->trainee_id, true) !!}
                                    </td>
                                    <td class="px-4 py-6 font-semibold text-[#201F36] dark:text-white text-sm">
                                        {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}
                                    </td>
                                    <td class="px-4 py-6 text-sm">
                                        @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
                                            <label
                                                class="text-[#62B96A] bg-[#F5FFF1] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ __('cgo.completed') }}</label>
                                        @endif
                                        @if (
                                            $counseling->status == getCodeIdByStringEn('counselling_status', 'request') ||
                                                $counseling->status == \App\Enums\CgoCounselingStatusEnums::RE_ASSIGN->value)
                                            <label
                                                class="text-[#91919A] bg-[#F8F8F8] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ __('cgo.request') }}</label>
                                        @endif
                                        @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                                            <label
                                                class="text-primary bg-[#F6FBFF] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg">{{ __('cgo.confirm') }}</label>
                                        @endif
                                    </td>
                                    <td class="px-3 py-2 text-sm">
                                        <div class="flex items-center">
                                            @if ($counseling->feedback)
                                                @for ($i = 0; $i < $counseling->feedback; $i++)
                                                    <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true"
                                                        xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                        viewBox="0 0 22 20">
                                                        <path
                                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                @endfor
                                                @for ($i = 5; $i > $counseling->feedback; $i--)
                                                    <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 22 20">
                                                        <path
                                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                @endfor
                                            @else
                                                @for ($i = 0; $i < 5; $i++)
                                                    <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500"
                                                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                        fill="currentColor" viewBox="0 0 22 20">
                                                        <path
                                                            d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                    </svg>
                                                @endfor
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">
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
            </div>
            {{--            <div class="relative overflow-x-auto"> --}}
            {{--                <table class="w-full text-left rtl:text-right table-auto"> --}}
            {{--                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center"> --}}
            {{--                    <tr> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.type') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.counseling_field') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.title') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.registration_date') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.counseling_date') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.trainee_instruction') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.trainee_name') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.status') }} --}}
            {{--                        </th> --}}
            {{--                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base"> --}}
            {{--                            {{ __('cgo.feedback') }} --}}
            {{--                        </th> --}}
            {{--                    </tr> --}}
            {{--                    </thead> --}}
            {{--                    <tbody> --}}
            {{--                    @forelse( $counselings as $counseling ) --}}
            {{--                        <tr class=" clickable-row cursor-pointer bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center" --}}
            {{--                            data-href="{{ route('cgo.career-guidance.counseling.counseling-list.show', ['id' => $counseling->counseling_id]) }}"> --}}
            {{--                            <td class="px-4 py-6 text-sm"> --}}
            {{--                                <div class="flex gap-1 items-center"> --}}
            {{--                                    @if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'online')) --}}
            {{--                                        <img src="{{asset('images/online.svg')}}" alt="" class="w-3 h-3"> --}}
            {{--                                        <span class="text-sm text-[#7AED86]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span> --}}
            {{--                                    @endif --}}
            {{--                                    @if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'offline') || $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'Counseling without reservation')) --}}
            {{--                                        <img src="{{asset('images/offline.svg')}}" alt="" class="w-3 h-3"> --}}
            {{--                                        <span class="text-sm text-[#91919A]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span> --}}
            {{--                                    @endif --}}
            {{--                                </div> --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white"> --}}
            {{--                                {{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white max-w-80 whitespace-nowrap overflow-hidden text-ellipsis"> --}}
            {{--                                {{ $counseling->title }} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]"> --}}
            {{--                                {{ date('Y-m-d', strtotime($counseling->registration_date)) }} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]"> --}}
            {{--                                {{ date('Y-m-d', strtotime($counseling->available_time)) }} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]"> --}}
            {{--                                {{$counseling->traineeUser ? getInstitutes($counseling->trainee_id, true) : ($counseling->trainee_offline_institute ?? 'N/G')}} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 font-semibold text-[#201F36] dark:text-white text-sm"> --}}
            {{--                                {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname}} --}}
            {{--                            </td> --}}
            {{--                            <td class="px-4 py-6 text-sm"> --}}
            {{--                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'complete')) --}}
            {{--                                    <label class="text-[#62B96A] bg-[#F5FFF1] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ getCodeNameByCodeId('counselling_status', $counseling->status) }}</label> --}}
            {{--                                @endif --}}
            {{--                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'request')) --}}
            {{--                                    <label class="text-[#91919A] bg-[#F8F8F8] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold">{{ getCodeNameByCodeId('counselling_status', $counseling->status) }}</label> --}}
            {{--                                @endif --}}
            {{--                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm')) --}}
            {{--                                    <label class="text-primary bg-[#F6FBFF] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg">{{ getCodeNameByCodeId('counselling_status', $counseling->status) }}</label> --}}
            {{--                                @endif --}}
            {{--                            </td> --}}
            {{--                            <td class="px-3 py-2 text-sm"> --}}
            {{--                                <div class="flex items-center"> --}}
            {{--                                    @if ($counseling->feedback) --}}
            {{--                                        @for ($i = 0; $i < $counseling->feedback; $i++) --}}
            {{--                                            <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"> --}}
            {{--                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/> --}}
            {{--                                            </svg> --}}
            {{--                                        @endfor --}}
            {{--                                        @for ($i = 5; $i > $counseling->feedback; $i--) --}}
            {{--                                            <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"> --}}
            {{--                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/> --}}
            {{--                                            </svg> --}}
            {{--                                        @endfor --}}
            {{--                                    @else --}}
            {{--                                        @for ($i = 0; $i < 5; $i++) --}}
            {{--                                            <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20"> --}}
            {{--                                                <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z"/> --}}
            {{--                                            </svg> --}}
            {{--                                        @endfor --}}
            {{--                                    @endif --}}
            {{--                                </div> --}}
            {{--                            </td> --}}
            {{--                        </tr> --}}
            {{--                    @empty --}}
            {{--                        <tr> --}}
            {{--                            <td colspan="9"> --}}
            {{--                                <div class="flex flex-col gap-4 justify-center items-center p-4"> --}}
            {{--                                    <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt=""> --}}
            {{--                                    <p class="dark:text-white">No record!</p> --}}
            {{--                                </div> --}}
            {{--                            </td> --}}
            {{--                        </tr> --}}
            {{--                    @endforelse --}}

            {{--                    </tbody> --}}
            {{--                </table> --}}
            {{--            </div> --}}
        </div>

        <div class="grid  grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('system.information.qna.title') }}
                    </span>
                    <span class="">
                        <a href="{{ route('informations.qnas.list') }}"
                            class="flex items-center gap-1 text-[#91919A] flex dark:text-white hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base  whitespace-nowrap">
                                    {{ trans('system.table.heading.title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.registration_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.action') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($recentItems['qnas'] as $index => $item)
                                <tr
                                    class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                                    <td class="px-4 py-3 text-sm text-[#201F36] dark:text-white text-left">
                                        <a href="{{ route('informations.qnas.reply', ['slug' => $item->slug]) }}"
                                            class="dark:text-white font-semibold text-left hover:text-primary">
                                            {!! Str::limit($item->title, 30, '...') !!}
                                            {{ $item->replies ? '(' . $item->replies->count() . ')' : '(0)' }}
                                        </a>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-[#201F36] dark:text-white">
                                        {{ $item->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-4 py-3 text-sm text-[#201F36] dark:text-white">
                                        <div class="flex gap-3 justify-center">
                                            {{-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                            class="block text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">
                                            Toggle modal
                                        </button> --}}
                                            <a href="{{ route('informations.qnas.reply', ['slug' => $item->slug]) }}"
                                                class="inline-flex w-fit items-center text-sm leading-4 justify-center font-medium px-6 py-2 text-white rounded-full cursor-pointer bg-primary">
                                                {{ trans('system.action.reply') }}
                                            </a>

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
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
            </div>
            <div
                class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('company.my_page.event') }}
                    </span>
                    <span class="">
                        <a href="{{ route('informations.events.event') }}"
                            class="text-[#91919A] flex items-center gap-1 dark:text-white hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('system.table.heading.title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center whitespace-nowrap">
                                    {{ trans('system.table.heading.registration_date') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentItems['events'] as $item)
                                <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                    <td
                                        class="px-3 py-3 font-semibold text-sm text-[#201F36] dark:text-white hover:text-primary">
                                        <a href="{{ route('informations.events.detail', ['slug' => $item->slug]) }}"
                                            class="dark:text-white">
                                            {!! Str::limit($item->title, 30, '...') !!}
                                        </a>
                                    </td>
                                    <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
                                        {{ $item->created_at->format('Y-m-d') }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        <a href="{{ route('informations.events.detail', ['slug' => $item->slug]) }}"
                                            class="text-primary flex items-center hover:text-primary gap-1">{{ trans('system.action.view_more') }}
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="2" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
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
            </div>
        </div>
        <div class="grid  grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('system.my_page.job_information') }}
                    </span>
                    <span class="">
                        <a href="{{ route('cgo.job-support.job-list.list') }}"
                            class="flex items-center gap-1 text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.job_title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.company_name') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center whitespace-nowrap">
                                    {{ trans('system.table.heading.registration_date') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentItems['jobs'] as $item)
                                <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                    <td scope="row"
                                        class="px-4 py-3 font-semibold text-sm  w-1/3 text-left whitespace-nowrap ">
                                        <a href="{{ route('cgo.job-support.job-list.job-details', ['slug' => $item->slug]) }}"
                                            class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary">{!! Str::limit($item->title, 25) !!}</a>
                                    </td>
                                    <td
                                        class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center font-medium whitespace-nowrap">
                                        {{ \Str::limit($item->company->name, 20) }}
                                    </td>
                                    <td
                                        class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center whitespace-nowrap">
                                        {{ $item->created_at->format('Y-m-d') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
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
            </div>
            <div
                class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{__('company.my_page.retained_trainee')}}
                    </span>
                    <span class="">
                        <a href="{{ route('cgo.job-support.trainee-list.list', ['trainee_type' => 'keep']) }}"
                            class="text-[#91919A] flex items-center gap-1 dark:text-[#C9CCD4] hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                    {{ trans('system.table.heading.title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                    {{ trans('system.table.heading.details') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">

                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentItems['keepTrainees'] as $keep)
                                <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                    <td class="px-3 py-3 font-semibold text-sm text-[#201F36] dark:text-white">
                                        {{ \Str::limit($keep->trainee->fullName, 30) }}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
                                        {!! \Str::limit(strip_tags(getNewestTrainingInformationOfTrainee($keep->trainee->id)),55) !!}
                                    </td>
                                    <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                        {{--                                    <a href="#" class="text-primary flex py-2 items-center">{{trans('system.action.view_more')}} <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg> --}}
                                        {{--                                    </a> --}}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
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
            </div>
        </div>
        <div class="grid  grid-cols-1 md:grid-cols-2 gap-6">
            <div
                class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold">
                        <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>
                        {{ trans('system.my_page.ojt_information') }}
                    </span>
                    <span class="">
                        <a href="{{ route('cgo.job-support.ojt-list.list') }}"
                            class="flex items-center gap-1 text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary">{{ trans('system.action.view_more') }}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                            <tr>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                    {{ trans('system.table.heading.job_title') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                    {{ trans('system.table.heading.company_name') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                    {{ trans('system.table.heading.status') }}
                                </th>
                                <th scope="col"
                                    class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                    {{ trans('system.table.heading.matches') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentItems['ojts'] as $ojt)
                                <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                    <td class="px-3 py-3 font-semibold text-sm text-[#201F36] dark:text-white text-left">
                                        {!! Str::limit($ojt->title, 25) !!}
                                    </td>
                                    <td
                                        class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center font-medium">
                                        {{ \Str::limit($ojt->company->name, 20) }}
                                    </td>
                                    <td class="px-4 py-3 text-sm">
                                        @if ($ojt->status)
                                            <label
                                                class="text-primary bg-[#E9F5FF] px-2 rounded-lg font-semibold flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                                </svg> Progress</label>
                                        @else
                                            <label
                                                class="text-[#706F81] bg-[#ECECEC] px-2 rounded-lg font-semibold flex items-center gap-2">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                    viewBox="0 0 8 9" fill="none">
                                                    <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                                </svg> Close</label>
                                        @endif

                                    </td>
                                    <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
                                        {!! (int) $ojt->ojt_matches_count !!}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
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
            </div>
            <div class="flex flex-col gap-6">
                <div class="rounded-xl flex items-center overflow-hidden shadow-custom-light dark:shadow-custom-dark"
                    style="background: linear-gradient(260.84deg, #EBEBEB 0.92%, #FFFFFF 100.01%);">
                    <div class="w-1/2 flex flex-col gap-2 px-6">
                        <p class="text-[#4984F6] text-xl md:text-2xl lg:text-3xl font-semibold">{{ __('cgo.Register a new Guidance') }}</p>
                        <div class="flex justify-start">
                            <a href="{{ route('cgo.career-guidance.counseling.create-offline') }}"
                                class="px-4 py-1.5 text-white bg-primary rounded-3xl">{{ __('cgo.Register') }}</a>
                        </div>
                    </div>
                    <div class="w-1/2 flex justify-end py-4 pr-4">
                        <img src="{{ asset('images/guidanceImage.webp') }}" alt="Register Guidance"
                            class="w-56 h-auto object-contain">
                    </div>
                </div>
                <div class="bg-cover rounded-xl shadow-custom-light dark:shadow-custom-dark" style="background-image: url('{{ asset('images/bg-blue.png') }}')">
                    <div class="flex flex-col gap-4 px-6 py-8">
                        <p class="text-white text-xl md:text-2xl lg:text-3xl font-semibold">{{ __('cgo.Get the latest news') }}</p>
                        <p class="text-white text-xs md:text-base">{{ __('cgo.Technical and Vocational Education Training') }}</p>
                        <div class="flex justify-start">
                            <a href="{{ route('informations.notices.index', ['#notice']) }}"
                                class="text-primary hover:text-white border border-primary hover:bg-primary font-medium px-4 mr-2 py-1.5 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-primary bg-white rounded-3xl">{{__('menu.notice')}}</a>

                            <a href="{{ route('guideline.guideline', ['#cgo']) }}"
                                class="text-primary hover:text-white border border-primary hover:bg-primary font-medium px-4 py-1.5 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-primary bg-white rounded-3xl">{{__('cgo.User Manual')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @endsection
    @push('js')
        <script>
            $(document).ready(function() {
                //clickable row
                let rows = document.querySelectorAll('.clickable-row');
                rows.forEach(row => {
                    row.addEventListener('click', () => {
                        window.location.href = row.dataset.href;
                    });
                });
            });
        </script>
    @endpush
