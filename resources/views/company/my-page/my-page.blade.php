@extends('homepage.layouts.master')
@section('title', 'Company - My page')

@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('company.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.my_page'), 'url' => '#'],
        ]" />
    </div>
    <div class="flex flex-col gap-6">

        <div class="grid  grid-cols-1 lg:grid-cols-2 gap-6">

            <div class=" flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.my_company_information')}}</span>
                    <span>
                        <a title="Edit Company Information" href="{{route('company.my-page.company-information', ['id' => $company->id])}}" class=" text-[#C9CCD4] dark:text-white hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="flex items-center gap-6">
                    <div class="w-1/3 h-52">
                        <div class="flex flex-col gap-2 justify-center h-full items-center">
                            @if(isset($company->logo) && $company->logo != '')
                                <img src="{{asset($company->logo)}}" alt="Company logo" class="w-full rounded-xl object-cover">
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="">
                                    <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21" />
                                </svg>
                            @endif
                            {{--<div class="flex">
                                <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900">Deactive account</button>
                            </div>--}}
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
                                                Are you sure deactive your account?</h3>
                                            <p class="dark:text-white text-center text-sm">After you deactive your account, you can not login to our system!</p>
                                            <div class="flex justify-center gap-4">
                                                <a href="{{route('company.my-page.deactive-account')}}"
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
                    <div class="flex flex-col gap-4 w-2/3">
                        <div class="flex gap-5">
                            <span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="18" viewBox="0 0 19 18" fill="none">
                                <path d="M12.8337 4.83333C12.8337 4.05836 12.8337 3.67087 12.7485 3.35295C12.5173 2.49022 11.8434 1.81635 10.9807 1.58519C10.6628 1.5 10.2753 1.5 9.50033 1.5C8.72535 1.5 8.33786 1.5 8.01995 1.58519C7.15721 1.81635 6.48335 2.49022 6.25218 3.35295C6.16699 3.67087 6.16699 4.05836 6.16699 4.83333M3.83366 16.5H15.167C16.1004 16.5 16.5671 16.5 16.9236 16.3183C17.2372 16.1586 17.4922 15.9036 17.652 15.59C17.8337 15.2335 17.8337 14.7668 17.8337 13.8333V7.5C17.8337 6.56658 17.8337 6.09987 17.652 5.74335C17.4922 5.42975 17.2372 5.17478 16.9236 5.01499C16.5671 4.83333 16.1004 4.83333 15.167 4.83333H3.83366C2.90024 4.83333 2.43353 4.83333 2.07701 5.01499C1.7634 5.17478 1.50844 5.42975 1.34865 5.74335C1.16699 6.09987 1.16699 6.56658 1.16699 7.5V13.8333C1.16699 14.7668 1.16699 15.2335 1.34865 15.59C1.50844 15.9036 1.7634 16.1586 2.07701 16.3183C2.43353 16.5 2.90024 16.5 3.83366 16.5Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="text-[#464559] dark:text-white">{{$company->name}}</span>
                        </div>
{{--                        <div class="flex gap-5">--}}
{{--                            <span>--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                              <path stroke-linecap="round" stroke="#91919A" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />--}}
{{--                            </svg>--}}

{{--                            </span>--}}
{{--                            <span class="text-[#464559] dark:text-white">{{\Str::limit($company->short_bio,100) ?? 'No information'}}</span>--}}
{{--                        </div>--}}
                        <div class="flex gap-4">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                            <path d="M18.417 15L12.8813 10M8.11937 10L2.58369 15M2.16699 5.83337L8.97109 10.5962C9.52207 10.9819 9.79756 11.1748 10.0972 11.2495C10.3619 11.3154 10.6387 11.3154 10.9034 11.2495C11.2031 11.1748 11.4786 10.9819 12.0296 10.5962L18.8337 5.83337M6.16699 16.6667H14.8337C16.2338 16.6667 16.9339 16.6667 17.4686 16.3942C17.939 16.1545 18.3215 15.7721 18.5612 15.3017C18.8337 14.7669 18.8337 14.0668 18.8337 12.6667V7.33337C18.8337 5.93324 18.8337 5.23318 18.5612 4.6984C18.3215 4.22799 17.939 3.84554 17.4686 3.60586C16.9339 3.33337 16.2338 3.33337 14.8337 3.33337H6.16699C4.76686 3.33337 4.0668 3.33337 3.53202 3.60586C3.06161 3.84554 2.67916 4.22799 2.43948 4.6984C2.16699 5.23318 2.16699 5.93324 2.16699 7.33337V12.6667C2.16699 14.0668 2.16699 14.7669 2.43948 15.3017C2.67916 15.7721 3.06161 16.1545 3.53202 16.3942C4.0668 16.6667 4.76686 16.6667 6.16699 16.6667Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                            <span class="text-[#464559] dark:text-white">{{$company->email ?? 'No information'}}</span>
                        </div>
                        <div class="flex gap-4">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                            <path d="M13 13.75V15.8333C13 16.6099 13 16.9981 12.8731 17.3044C12.704 17.7128 12.3795 18.0373 11.9711 18.2064C11.6649 18.3333 11.2766 18.3333 10.5 18.3333C9.72343 18.3333 9.33515 18.3333 9.02886 18.2064C8.62048 18.0373 8.29602 17.7128 8.12687 17.3044C8 16.9981 8 16.6099 8 15.8333V13.75M13 13.75C15.2074 12.7855 16.75 10.4795 16.75 7.91663C16.75 4.46485 13.9518 1.66663 10.5 1.66663C7.04822 1.66663 4.25 4.46485 4.25 7.91663C4.25 10.4795 5.79262 12.7855 8 13.75M13 13.75H8" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                            <span class="text-[#464559] dark:text-white">{{getCodeNameByCodeId('Enterprise_type', $company->enterprise_id) ?? 'No information'}}</span>
                        </div>
                        <div class="flex gap-4">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                            <path d="M10.5003 1.66663C12.5847 3.94859 13.7693 6.90999 13.8337 9.99996C13.7693 13.0899 12.5847 16.0513 10.5003 18.3333M10.5003 1.66663C8.41593 3.94859 7.23137 6.90999 7.16699 9.99996C7.23137 13.0899 8.41593 16.0513 10.5003 18.3333M10.5003 1.66663C5.89795 1.66663 2.16699 5.39759 2.16699 9.99996C2.16699 14.6023 5.89795 18.3333 10.5003 18.3333M10.5003 1.66663C15.1027 1.66663 18.8337 5.39759 18.8337 9.99996C18.8337 14.6023 15.1027 18.3333 10.5003 18.3333M2.58367 7.49996H18.417M2.58366 12.5H18.417" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                            @if(filter_var($company->website, FILTER_VALIDATE_URL))
                            <a href="{{$company->website}}" target="_blank" class="text-[#464559] dark:text-white text-primary underline">{{\Str::limit($company->website,35)  ?? 'No information'}}</a>
                            @else
                            <p href="{{$company->website}}" target="_blank" class="text-[#464559] dark:text-white">{{$company->website  ?? 'No information'}}</p>
                            @endif
                        </div>
                        <div class="flex gap-4">
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
                            <path d="M10.4997 10.4166C11.8804 10.4166 12.9997 9.29734 12.9997 7.91663C12.9997 6.53591 11.8804 5.41663 10.4997 5.41663C9.11896 5.41663 7.99967 6.53591 7.99967 7.91663C7.99967 9.29734 9.11896 10.4166 10.4997 10.4166Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M10.4997 18.3333C12.1663 15 17.1663 12.8485 17.1663 8.33329C17.1663 4.65139 14.1816 1.66663 10.4997 1.66663C6.81778 1.66663 3.83301 4.65139 3.83301 8.33329C3.83301 12.8485 8.83301 15 10.4997 18.3333Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                            <span class="text-[#464559] dark:text-white">{{$company->getDistrict() ?? 'No information'}}</span>
                        </div>
                    </div>
                </div>


            </div>

            <div class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.my_personal_information')}}</span>
                    <span>
                        <a title="Edit Personal Information" href="{{route('company.my-page.personal-information')}}" class=" text-[#C9CCD4] dark:text-white hover:text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                              <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col md:flex-row gap-4 items-center justify-center xl:justify-start">
                        @if($user->profile_image)
                            <img class="w-14 h-14 rounded-full object-cover" src="{{ asset($user->profile_image) }}" alt="user photo">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-12">
                                <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif
                        <div class="flex flex-col gap-1.5 items-start">
                            <p class="text-xl text-black dark:text-white font-semibold">{{\Str::limit($user->fullName,30)}}</p>
                            <p class="text-[#91919A] text-sm">
                                <span>{{$user->company->name}}</span>
                            </p>
                        </div>
                        <div class="flex flex-col gap-4 ml-4">
                            <div class="flex gap-5 items-center">
                                <span class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21" fill="none">
                                        <path d="M7.48356 7.87767C8.06356 9.08569 8.85422 10.2179 9.85553 11.2192C10.8568 12.2205 11.9891 13.0112 13.1971 13.5912C13.301 13.6411 13.3529 13.666 13.4187 13.6852C13.6523 13.7533 13.9392 13.7044 14.137 13.5627C14.1927 13.5228 14.2403 13.4752 14.3356 13.3799C14.6269 13.0886 14.7726 12.9429 14.9191 12.8477C15.4715 12.4885 16.1837 12.4885 16.7361 12.8477C16.8825 12.9429 17.0282 13.0886 17.3196 13.3799L17.4819 13.5423C17.9248 13.9852 18.1462 14.2066 18.2665 14.4444C18.5058 14.9174 18.5058 15.476 18.2665 15.9489C18.1462 16.1867 17.9248 16.4082 17.4819 16.851L17.3506 16.9824C16.9092 17.4238 16.6886 17.6444 16.3885 17.813C16.0556 18 15.5385 18.1345 15.1567 18.1333C14.8126 18.1323 14.5774 18.0655 14.107 17.932C11.5792 17.2146 9.19387 15.8608 7.20388 13.8709C5.2139 11.8809 3.86017 9.49557 3.1427 6.96774C3.00919 6.49737 2.94244 6.26218 2.94141 5.91806C2.94028 5.53621 3.07475 5.01913 3.26176 4.68621C3.4303 4.38618 3.65098 4.16551 4.09233 3.72416L4.22369 3.59279C4.66656 3.14992 4.888 2.92849 5.12581 2.8082C5.59878 2.56898 6.15734 2.56898 6.6303 2.8082C6.86812 2.92849 7.08955 3.14992 7.53242 3.59279L7.69481 3.75518C7.98615 4.04652 8.13182 4.19219 8.22706 4.33867C8.58622 4.89108 8.58622 5.60323 8.22706 6.15564C8.13182 6.30212 7.98615 6.44779 7.69481 6.73913C7.59955 6.83439 7.55192 6.88202 7.51206 6.9377C7.37038 7.13556 7.32146 7.42244 7.38957 7.65607C7.40873 7.72181 7.43367 7.77376 7.48356 7.87767Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span class="dark:text-white text-sm">{{formatPhoneNumber($user->telephone)}}</span>
                            </div>
                            <div class="flex gap-5 items-center">
                                <span  class="dark:text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 21 21" fill="none">
                                    <path d="M18.417 15.5L12.8813 10.5M8.11937 10.5L2.58369 15.5M2.16699 6.33337L8.97109 11.0962C9.52207 11.4819 9.79756 11.6748 10.0972 11.7495C10.3619 11.8154 10.6387 11.8154 10.9034 11.7495C11.2031 11.6748 11.4786 11.4819 12.0296 11.0962L18.8337 6.33337M6.16699 17.1667H14.8337C16.2338 17.1667 16.9339 17.1667 17.4686 16.8942C17.939 16.6545 18.3215 16.2721 18.5612 15.8017C18.8337 15.2669 18.8337 14.5668 18.8337 13.1667V7.83337C18.8337 6.43324 18.8337 5.73318 18.5612 5.1984C18.3215 4.72799 17.939 4.34554 17.4686 4.10586C16.9339 3.83337 16.2338 3.83337 14.8337 3.83337H6.16699C4.76686 3.83337 4.0668 3.83337 3.53202 4.10586C3.06161 4.34554 2.67916 4.72799 2.43948 5.1984C2.16699 5.73318 2.16699 6.43324 2.16699 7.83337V13.1667C2.16699 14.5668 2.16699 15.2669 2.43948 15.8017C2.67916 16.2721 3.06161 16.6545 3.53202 16.8942C4.0668 17.1667 4.76686 17.1667 6.16699 17.1667Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                                <span  class="dark:text-white text-sm">{{$user->email}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 justify-center">
                        <div class="w-1/2 bg-[#E3EEFF] dark:bg-[#383838] flex flex-col gap-2 py-2 px-4 lg:py-4 lg:px-8 justify-center rounded-xl bg-opacity-50 xs:items-center">
                            <a href="{{route('company.job-support.candidate-list.list', ['apply_type' => 'apply'])}}" class="text-primary text-sm md:text-base">{{trans('company.my_page.job_applicant')}}</a>
                            <span class="font-semibold text-primary text-lg md:text-xl">{{$jobApplicantNotReads->count()}}/{{$allJobApplicants->count()}}</span>
                        </div>
                        <div class="w-1/2 bg-[#E3EEFF] dark:bg-[#383838] flex flex-col gap-2 py-2 px-4 lg:py-4 lg:px-8 justify-center rounded-xl bg-opacity-50 xs:items-center">
                            <a href="{{route('company.job-support.candidate-list.list', ['apply_type' => 'job_match'])}}" class="text-primary text-sm md:text-base">{{trans('company.my_page.requested_job_match')}} </a>
                            <span class="font-semibold text-primary text-lg md:text-xl">{{$jobMatchNotReads->count()}}/{{$allJobMatchs->count()}}</span>
                        </div>
                    </div>
                </div>
            </div>


        </div>

        <div class="grid  grid-cols-1 md:grid-cols-2 gap-6">
            <div class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.qna')}}</span>
                    <span class="">
                        <a href="{{ route('informations.qnas.list') }}" class="text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary flex items-center gap-1">{{trans('system.action.view_more')}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base  whitespace-nowrap">
                                {{trans('company.my_page.title')}}
                            </th>
                            <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{trans('company.my_page.registration_date')}}
                            </th>
                            <th scope="col" class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{trans('company.my_page.action')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($qnas as $index => $item)
                            <tr
                                class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                                <td class="px-4 py-3 text-sm text-[#201F36] dark:text-white text-left">
                                    <a href="{{ route('informations.qnas.reply', ['slug' => $item->slug]) }}"
                                       class="dark:text-white font-semibold text-left hover:text-primary">
                                        {!! Str::limit($item->title, 30, '...') !!}
                                        {{ $item->allRepliesCount() ? '(' . $item->allRepliesCount() . ')' : '(0)' }}
                                    </a>
                                </td>
                                <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] dark:text-white">
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
                                           class="inline-flex w-fit items-center text-sm leading-4 justify-center font-medium px-6 py-1 text-white rounded-full cursor-pointer bg-primary">
                                            Reply
                                        </a>

                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse

                        </tbody>

                    </table>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.event')}}</span>
                    <span class="">
                        <a href="{{ route('informations.events.event')}}" class="text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary flex items-center gap-1">{{trans('system.action.view_more')}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                {{trans('company.my_page.title')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center whitespace-nowrap">
                                {{trans('company.my_page.registration_date')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($events as $item)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                <td class="px-3 py-3 font-semibold text-sm text-[#201F36] dark:text-white hover:text-primary">
                                    <a href="{{ route('informations.events.detail', ['slug' => $item->slug]) }}"
                                       class="dark:text-white">
                                        {!! Str::limit($item->title, 30, '...') !!}
                                    </a>
                                </td>
                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
                                    {{ $item->created_at->format('Y-m-d') }}
                                </td>
                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                    <a href="{{ route('informations.events.detail', ['slug' => $item->slug]) }}" class="text-primary flex items-center hover:text-primary">{{trans('system.action.view_more')}} <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                            <path d="M6.5 12L10.5 8L6.5 4" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
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
            <div class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.job_information')}}</span>
                    <span class="">
                        <a href="{{route('company.job-support.job-vacancy.list')}}" class="text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary flex items-center gap-1">{{trans('system.action.view_more')}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{trans('company.my_page.job_title')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{trans('company.my_page.company_name')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center whitespace-nowrap">
                                {{trans('company.my_page.registration_date')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($jobs as $item)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                <td scope="row" class="px-4 py-3 font-semibold text-sm  w-1/3 text-left whitespace-nowrap ">
                                    <a href="{{route('company.job-support.job-vacancy.show', ['job_id' => $item->id, 'slug' => $item->slug])}}"
                                       class="text-[#201F36] dark:text-white hover:text-primary dark:hover:text-primary">{!! Str::limit($item->title,25) !!}</a>
                                </td>
                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center font-medium whitespace-nowrap">
                                    {{ \Str::limit($item->company->name, 20) }}
                                </td>
                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center whitespace-nowrap">
                                    {{ $item->created_at->format('Y-m-d') }}
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="3">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.my_page.retained_trainee')}}</span>
                    <span class="">
                        <a href="{{route('company.job-support.trainee-list.list')}}" class="text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary flex items-center gap-1">{{trans('system.action.view_more')}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                {{trans('company.my_page.title')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                {{trans('company.my_page.details')}}
                            </th>
{{--                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">--}}

{{--                            </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($keepTrainees as $keep)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                <td class="px-3 py-3 font-semibold text-sm text-[#201F36] dark:text-white">
                                    {{\Str::limit($keep->trainee->fullName, 15)}}
                                </td>
                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
{{--                                    {!! getSumaryTraining($keep->trainee->id) !!}--}}
                                    {!! \Str::limit(strip_tags(getNewestTrainingInformationOfTrainee($keep->trainee->id)),55) !!}
                                </td>
{{--                                <td class="px-3 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">--}}
{{--                                    <a href="#" class="text-primary flex py-2 items-center">{{trans('system.action.view_more')}} <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">--}}
{{--                                            <path d="M6.5 12L10.5 8L6.5 4" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                </td>--}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
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
            <div class="p-4 bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                <div class="flex justify-between">
                    <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>{{trans('company.ojt_information')}}</span>
                    <span class="">
                        <a href="{{route('company.job-support.ojt-list.list')}}" class="text-[#91919A] flex dark:text-[#C9CCD4] hover:text-primary flex items-center gap-1">{{trans('system.action.view_more')}}
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="size-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </span>
                </div>
                <div class="relative overflow-x-auto h-full">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                        <tr>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                {{trans('company.my_page.job_title')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                {{trans('company.my_page.company_name')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                {{trans('company.my_page.status')}}
                            </th>
                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">
                                {{trans('company.my_page.matched')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                            @forelse($ojts as $ojt)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                <td class="px-4 py-3 font-semibold text-sm text-[#201F36] dark:text-white text-left">
                                    <a class="dark:hover:text-primary text-sm text-[#201F36] dark:text-white w-1/6 font-semibold whitespace-nowrap  hover:text-primary"
                                       href="{{ route('company.job-support.ojt-list.detail', ['slug' => $ojt->slug]) }}">
                                        {{ \Str::limit($ojt->title, 25) }}</a>
                                </td>
                                <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center font-medium">
                                    {{ \Str::limit($ojt->company->name,20) }}
                                </td>
                                <td class="px-4 py-3 text-sm">
                                    @if ($ojt->status)
                                        <label
                                            class="text-primary bg-[#E9F5FF] px-2 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                 viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="#4984F6" />
                                            </svg>In Progress</label>
                                    @else
                                        <label
                                            class="text-[#706F81] bg-[#ECECEC] px-2 rounded-lg font-semibold flex items-center gap-2 whitespace-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="8" height="9"
                                                 viewBox="0 0 8 9" fill="none">
                                                <circle cx="4" cy="4.49023" r="4" fill="#706F81" />
                                            </svg> Closed</label>
                                    @endif

                                </td>
                                <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4] text-center">
                                    {!!  (int)$ojt->ojt_matches_count !!}
                                </td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="4">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="flex flex-col gap-6 justify-between">
{{--                <div class="rounded-xl flex justify-between bg-white px-6 py-4 items-center shadow-custom-light dark:shadow-custom-dark">--}}
{{--                    <div class="w-1/2 flex flex-col gap-2 px-6 py-8">--}}
{{--                        <p class="text-[#4984F6] text-xl md:text-2xl lg:text-3xl font-semibold">{{trans('company.my_page.publish_new_job')}}</p>--}}
{{--                        <p class="text-[#706F81] text-sm pt-2 pb-2"></p>--}}
{{--                        <div class="flex justify-start">--}}
{{--                            <a href="{{route('company.job-support.job-vacancy.create')}}" class="px-4 py-1.5 text-white bg-primary rounded-3xl">{{trans('company.my_page.publish')}}</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="w-1/2 flex justify-end pr-6">--}}
{{--                        <img src="{{ asset('images/publish_job.png') }}" alt="Publish new job"--}}
{{--                             class="w-72 h-auto object-contain">--}}
{{--                    </div>--}}

{{--                </div>--}}
                <div class="rounded-xl flex items-center overflow-hidden shadow-lg"
                     style="background: linear-gradient(260.84deg, #EBEBEB 0.92%, #FFFFFF 100.01%);">
                    <div class="w-1/2 flex flex-col gap-2 px-6">
                        <p class="text-[#4984F6] text-xl md:text-2xl lg:text-3xl font-semibold">{{trans('company.my_page.publish_new_job')}}</p>
                        <p class="text-[#706F81] text-sm pt-2 pb-2"></p>
                        <div class="flex justify-start">
                            <a href="{{route('company.job-support.job-vacancy.create')}}"
                               class="px-4 py-1.5 text-white bg-primary rounded-3xl">{{trans('company.my_page.publish')}}</a>
                        </div>
                    </div>
                    <div class="w-1/2 flex justify-end p-4">
                        <img src="{{ asset('images/publish_job.png') }}" alt="Register Guidance"
                             class="w-56 h-auto object-contain">
                    </div>
                </div>
{{--                <div class="bg-cover rounded-xl  shadow-custom-light dark:shadow-custom-dark" style="background-image: url('{{asset("images/bg-blue.png")}}')">--}}
{{--                    <div class="flex flex-col gap-4 pl-7 py-8 md:pl-8 md:py-9 lg:pl-9 lg:py-10 xl:pl-14 xl:py-16">--}}
{{--                        <p class="text-white text-xl md:text-2xl lg:text-3xl font-semibold">Get the latest news</p>--}}
{{--                        <p class="text-white text-xs md:text-base">Technical and Vocational Education Training</p>--}}
{{--                        <div class="flex justify-start">--}}
{{--                            <a href="{{ route('informations.notices.index', ['#notice']) }}" class="text-primary hover:text-white border border-primary hover:bg-primary font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-primary bg-white">Notice</a>--}}
{{--                            <a href="{{ route('guideline.guideline', ['#company']) }}" class="text-primary hover:text-white border border-primary hover:bg-primary font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:hover:bg-primary bg-white">User Manual</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
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
    </div>

@endsection
