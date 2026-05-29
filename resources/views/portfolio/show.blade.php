@extends('homepage.layouts.master')
@section('title', 'Portfolio Preview')

@section('content')
    <div class="border rounded mt-6">
        <div class="h-12 bg-primary sticky top-0 w-full flex items-center z-10 px-4 rounded-t">
            <div class="mx-auto max-w-[1440px] flex justify-end w-full">
                <div class="flex justify-end gap-4 items-center">
                    <a href="{{route('trainee.career-guidance.portfolio.export-portfolio',['pid' => $portfolio->id])}}" target="_blank" class="text-white text-xl flex items-center gap-1 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                        </svg>
                        PDF </a>
                    <a href="{{route('trainee.career-guidance.portfolios.edit')}}" class="text-white text-xl flex items-center gap-1 hover:underline"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"></path>
                        </svg>
                        {{trans('system.form.button.edit')}}</a>
                </div>
            </div>
        </div>
        <div class="max-w-[1440px] xl:px-[54px] mx-auto  bg-white dark:bg-[#1E1E1E]">
            <div class="max-w-[1440px] xl:px-[54px] mx-auto">
                <div class=" mx-auto">
                    <div class="bg-white dark:bg-[#1E1E1E] my-6 rounded-xl">
                        <div class="p-4 flex flex-col gap-6">
                            <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center  justify-center rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="w-full bg-white dark:bg-[#1E1E1E] transform duration-200 easy-in-out rounded-xl">
                                    <div class=" h-64 overflow-hidden">
                                        <img class="w-full rounded-t-xl" src="{{$portfolioDatas['cover_photo'] ?? 'https://images.unsplash.com/photo-1605379399642-870262d3d051?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'}}" alt="background cover" />
                                    </div>
                                    <div class="flex justify-start px-5  -mt-12" id="trainee_avatar">
                                        <img class="h-32 w-32 bg-white p-1 rounded-full  " src="{{$portfolioDatas['avatar'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'}}" alt="avatar" />
                                    </div>
                                    <div class="pb-5 flex justify-between" data-gjs-removable="false">
                                        <div class="text-left px-5">
                                            <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold tvec-information" data-gjs-editable="false" data-gjs-removable="false" id="trainee-name-heading">
                                                {{$portfolioDatas['fullname']}}</p>
                                            <p class="text-[#706F81] dark:text-white example-information" id="trainee-short-bio">{{$portfolioDatas['description']}}</p>
                                            <p class="text-[#91919A] dark:text-white tvec-information" id="latest_training_information"> {{$portfolioDatas['summary'] ?? ''}} </p>
                                        </div>
                                        <div class="h-20 pr-4 tvec-information" id="skills_passport_card">

                                        </div>
                                        <style>
                                            #skills_passport_card>img {
                                                filter: none !important;
                                            }
                                        </style>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold" data-gjs-editable="false" data-gjs-removable="false">{{trans('portfolio.Basic Information')}}</p>
                                    <div class="flex gap-6 flex-col lg:flex-row" data-gjs-editable="false" data-gjs-removable="false">
                                        <div class="flex flex-col gap-4">
                                            <div class="flex gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M16.6654 17.5C16.6654 16.337 16.6654 15.7555 16.5218 15.2824C16.1987 14.217 15.365 13.3834 14.2996 13.0602C13.8265 12.9167 13.245 12.9167 12.082 12.9167H7.91537C6.7524 12.9167 6.17091 12.9167 5.69775 13.0602C4.63241 13.3834 3.79873 14.217 3.47556 15.2824C3.33203 15.7555 3.33203 16.337 3.33203 17.5M13.7487 6.25C13.7487 8.32107 12.0698 10 9.9987 10C7.92763 10 6.2487 8.32107 6.2487 6.25C6.2487 4.17893 7.92763 2.5 9.9987 2.5C12.0698 2.5 13.7487 4.17893 13.7487 6.25Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-sm text-[#464559] dark:text-white tvec-information" id="trainee-name">{{$portfolioDatas['basic_information']['fullname']}}</span>
                                            </div>
                                            <div class="flex gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-sm text-[#464559] dark:text-white tvec-information" id="trainee-phone">{{$portfolioDatas['basic_information']['phone']}}</span>
                                            </div>
                                        </div>
                                        <div class="flex flex-col gap-4">
                                            <div class="flex gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M17.9179 14.9997L12.3823 9.99967M7.62035 9.99967L2.08466 14.9997M1.66797 5.83301L8.47207 10.5959C9.02304 10.9816 9.29853 11.1744 9.59819 11.2491C9.86288 11.3151 10.1397 11.3151 10.4044 11.2491C10.7041 11.1744 10.9796 10.9816 11.5305 10.5959L18.3346 5.83301M5.66797 16.6663H14.3346C15.7348 16.6663 16.4348 16.6663 16.9696 16.3939C17.44 16.1542 17.8225 15.7717 18.0622 15.3013C18.3346 14.7665 18.3346 14.0665 18.3346 12.6663V7.33301C18.3346 5.93288 18.3346 5.23281 18.0622 4.69803C17.8225 4.22763 17.44 3.84517 16.9696 3.60549C16.4348 3.33301 15.7348 3.33301 14.3346 3.33301H5.66797C4.26784 3.33301 3.56777 3.33301 3.03299 3.60549C2.56259 3.84517 2.18014 4.22763 1.94045 4.69803C1.66797 5.23281 1.66797 5.93288 1.66797 7.33301V12.6663C1.66797 14.0665 1.66797 14.7665 1.94045 15.3013C2.18014 15.7717 2.56259 16.1542 3.03299 16.3939C3.56777 16.6663 4.26784 16.6663 5.66797 16.6663Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-sm text-[#464559] dark:text-white tvec-information" id="trainee-email">{{$portfolioDatas['basic_information']['email']}}</span>
                                            </div>
                                            <div class="flex gap-4">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 20 20" fill="none">
                                                    <path d="M9.9987 10.417C11.3794 10.417 12.4987 9.2977 12.4987 7.91699C12.4987 6.53628 11.3794 5.41699 9.9987 5.41699C8.61799 5.41699 7.4987 6.53628 7.4987 7.91699C7.4987 9.2977 8.61799 10.417 9.9987 10.417Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M9.9987 18.3337C11.6654 15.0003 16.6654 12.8489 16.6654 8.33366C16.6654 4.65176 13.6806 1.66699 9.9987 1.66699C6.3168 1.66699 3.33203 4.65176 3.33203 8.33366C3.33203 12.8489 8.33203 15.0003 9.9987 18.3337Z" stroke="#91919A" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                                <span class="text-sm text-[#464559] dark:text-white tvec-information" id="trainee-address">{{$portfolioDatas['basic_information']['address']}}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.About me')}}</p>
                                    <p class="text-lg text-[#706F81] dark:text-white  whitespace-pre-line break-words" id="trainee-basic-information">{{$portfolioDatas['about_me']}}</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 tvec-information">
                                <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                    <div class="flex flex-col gap-4 w-full h-full">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.TVEC Education')}}</p>
                                        <div class="flex  flex-col gap-4 w-full h-full" id="course_block">
                                            @forelse($portfolioDatas['tvec_educations'] as $tvecCourse)
                                                <div class="flex gap-4 items-baseline">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                            <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex flex-col gap-2 dark:text-white">
                                                        <p class="">
                                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{$tvecCourse['institute']}} </span>
                                                            <span class="text-[#706F81]  dark:text-white"> ({{trans('portfolio.Industry sector')}}: {{$tvecCourse['industry_sector']}})</span>
                                                        </p>
                                                        <p class="dark:text-white"><span class="font-semibold">{{trans('portfolio.Course name')}}: {{$tvecCourse['course_name']}}</span> <span class="text-sm">({{date("F j, Y", strtotime($tvecCourse['from']))}} - {{date("F j, Y", strtotime($tvecCourse['to']))}})</span></p>

                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                                <div class="bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                    <div class="flex flex-col gap-4 w-full h-full">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold" id="nvq_type">{{trans('portfolio.NVQ Qualification')}}</p>
                                        <div class="flex flex-col gap-4 w-full h-full" id="qualification_block">
                                            @forelse($portfolioDatas['nvq_educations'] as $nvq)
                                                <div class="flex gap-4 items-baseline">
                                                    <div>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                            <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                                        </svg>
                                                    </div>
                                                    <div class="flex flex-col gap-2">
                                                        <p>
                                                            <span class="text-[#464559] text-xl font-semibold dark:text-white">{{$nvq['qualification_name']}}</span>
                                                            <span class="text-[#706F81] dark:text-white">({{$nvq['level']}})</span>
                                                        </p>
                                                        <p>
                                                            <span class="text-[#91919A] dark:text-white">{{date("F j, Y", strtotime($nvq['effective_date']))}}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="example-information bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="flex flex-col gap-4 w-full h-full">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.Education')}}</p>
                                    <ol class="relative border-s border-primary">
                                        @forelse($portfolioDatas['educations'] as $education)
                                            <li class="mb-10 ms-4">
                                                <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5 "></div>
                                                <p>
                                                        <span class="text-[#464559] text-xl font-semibold dark:text-white">
                                                            {{ $education['school_name'] }}
                                                        </span>

                                                    @if(!empty($education['district']))
                                                        <span class="text-[#706F81] dark:text-white">
                                                        ({{ $education['district'] }})
                                                    </span>
                                                    @endif
                                                </p>
                                                <p>
                                                    <span class="text-[#91919A] dark:text-white text-sm">{{date("F Y", strtotime($education['from'])) ?? ""}} - {{date("F Y", strtotime($education['to'])) ?? ""}}</span>
                                                </p>
                                                @if(!empty($education['field']))
                                                    <p class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">{{trans('portfolio.Field of Study')}}: </span> {{ $education['field'] }}</p>
                                                @endif
                                                @if(!empty($education['results']))
                                                    <div>
                                                        <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Skills')}}:</p>
                                                        <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $education['results'] }}</p>
                                                    </div>
                                                @endif
                                                @if(!empty($education['description']))
                                                    <div>
                                                        <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Description')}}:</p>
                                                        <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $education['description'] }}</p>
                                                    </div>
                                                @endif
                                            </li>
                                        @empty
                                        @endforelse
                                    </ol>
                                </div>
                            </div>
                            <div class="example-information bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.OJT Experience')}}</p>
                                    <div id="ojt-experience">
                                        <ol class="relative border-s border-primary">
                                            @forelse($portfolioDatas['ojt_experiences'] as $ojt)
                                                <li class="mb-10 ms-4">
                                                    <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5 "></div>

                                                    <p>
                                                        <span class="text-[#464559] text-xl font-semibold dark:text-white">
                                                            {{ $ojt['title'] }}
                                                        </span>

                                                        @if(!empty($ojt['district']))
                                                            <span class="text-[#706F81] dark:text-white">
                                                        ({{ $ojt['district'] }})
                                                    </span>
                                                        @endif
                                                    </p>
                                                    <p>
                                                        <span class="text-[#91919A] dark:text-white text-sm">{{date("F Y", strtotime($ojt['from'])) ?? ''}} - {{date("F Y", strtotime($ojt['to'])) ?? ''}}</span>
                                                    </p>
                                                    <p class="text-[#464559] dark:text-white"><span class="font-semibold dark:text-white">{{trans('portfolio.Organisation')}}: </span> {{ $ojt['organization'] }}</p>
                                                    @if(!empty($ojt['skills']))
                                                        <div >
                                                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Skills')}}:</p>
                                                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $ojt['skills'] }}</p>
                                                        </div>
                                                    @endif
                                                    @if(!empty($ojt['description']))
                                                        <div >
                                                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Description')}}:</p>
                                                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $ojt['description'] }}</p>
                                                        </div>
                                                    @endif
                                                </li>
                                            @empty
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="example-information bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.Experience')}}</p>
                                    <div id="experience">
                                        <ol class="relative border-s border-primary">
                                            @forelse($portfolioDatas['experiences'] as $experience)
                                                <li class="mb-10 ms-4">
                                                    <div class="absolute w-3 h-3 bg-primary rounded-full mt-1.5 -start-1.5 "></div>

                                                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $experience['job_title'] }}</h3>
                                                    <p class="text-md font-medium text-gray-700 dark:text-gray-300">{{ $experience['company'] }} <span v-if="experience.district">• {{ $experience['district'] }}</span></p>
                                                    <time class="mb-2 text-sm font-normal text-gray-400 dark:text-white">
                                                        {{ date('F Y', strtotime($experience['start_date'])) }}
                                                        -
                                                        {{ $experience['is_current'] ? 'Present' : date('F Y', strtotime($experience['end_date'])) }}
                                                    </time>
                                                    @if($experience['skills'])
                                                        <div  class="my-2">
                                                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Skills')}}:</p>
                                                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $experience['skills'] }}</p>
                                                        </div>
                                                    @endif
                                                    @if($experience['description'])
                                                        <div class="my-2">
                                                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Description')}}:</p>
                                                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $experience['description'] }}</p>
                                                        </div>
                                                    @endif
                                                </li>
                                            @empty
                                            @endforelse
                                        </ol>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                                <div class="example-information bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
                                    <div class="flex flex-col gap-4">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.Skills')}}</p>
                                        <div class="flex  flex-wrap gap-4" id="expertise_block">
                                            <div class="flex flex-col gap-4">
                                                @forelse($portfolioDatas['skills'] as $skill)
                                                    <div class="flex gap-4 items-baseline">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                            <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                                        </svg>
                                                        <div class="flex flex-col gap-2">
                                                            <p>
                                                                <span class="text-[#464559] text-xl font-semibold dark:text-white">{{$skill['name']}}</span>
                                                            </p>
                                                            <p>
                                                                <span class="text-[#91919A] dark:text-white whitespace-pre-line">{{$skill['description']}}</span>
                                                            </p>
                                                        </div>
                                                    </div>
                                                @empty
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="example-information bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.Language')}}</p>
                                    <div class="flex  flex-wrap gap-4" id="language_block">
                                        <div class="flex flex-wrap gap-4">
                                            @forelse($portfolioDatas['languages'] as $language)
                                                <label class="text-[#CF9090] bg-[#FFF7F7] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg">{{$language}}</label>
                                            @empty
                                            @endforelse
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 gap-6 " id="evidence">
                                <div class="bg-white dark:bg-[#1E1E1E] flex flex-col gap-4 w-full shadow-custom-light dark:shadow-custom-dark p-5 rounded-xl border border-gray-300 dark:border-white">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{trans('portfolio.Supporting Documents')}}</p>
                                    <div class="flex flex-col gap-5" id="evidence_block">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
                                            @forelse($portfolioDatas['evidences'] as $evidence)
                                                <div class="mb-10 p-4 border border-gray-300 dark:border-white rounded-xl example-information">
                                                    <div class="h-96 overflow-hidden flex justify-center border-b border-gray-300 dark:border-white">
                                                        <img src="{{$evidence['attachment_path']}}" class="object-cover object-center h-full w-auto !filter-none rounded-xl pb-4">
                                                    </div>
                                                    <h2 class="title-font text-2xl font-medium text-gray-900 mt-6 mb-2 dark:text-white break-words">
                                                        {{ $evidence['document_type'] }}: {{ $evidence['name'] }}
                                                    </h2>

                                                    <div class="mb-1">
                                                        <span class="font-semibold dark:text-white">{{trans('portfolio.Issued by')}}: </span>
                                                        <span class="dark:text-gray-300 break-words">{{ $evidence['issuing_organisation'] }}</span>
                                                    </div>

                                                    <div class="mb-1">
                                                        <span class="font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Issue Date')}}: </span>
                                                        <span class="text-sm font-medium dark:text-white"> {{ date('F Y', strtotime($evidence['issue_date'])) }}</span>
                                                    </div>
                                                    @if($evidence['validity_period'])
                                                        <div class="mb-1">
                                                            <span class="font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Valid until')}}: </span>
                                                            <span class="text-sm font-medium dark:text-white"> {{ date('F Y', strtotime($evidence['validity_period'])) }}</span>
                                                        </div>
                                                    @endif
                                                    @if($evidence['description'])
                                                        <div v-if="evidence.description" class="mb-1">
                                                            <p class=" font-semibold text-gray-700 dark:text-gray-300">{{trans('portfolio.Description')}}:</p>
                                                            <p class="text-gray-500 dark:text-gray-400 whitespace-pre-line ml-2 break-words">{{ $evidence['description'] }}</p>
                                                        </div>
                                                    @endif
                                                </div>
                                            @empty
                                            @endforelse

                                        </div>
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
