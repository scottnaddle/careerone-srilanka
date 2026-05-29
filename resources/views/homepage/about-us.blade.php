@extends('homepage.layouts.master')
@section('title', 'TVET System - About us')

@section('content')
    <div class="py-4 md:py-6">
        <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.about_us'), 'url' => '#'],
                ['label' => trans('system.menu.about_career_platform'), 'url' => '#'],
            ]" />
    </div>
    <div class="flex flex-col gap-4 md:gap-6 lg:gap-16 bg-white dark:bg-[#1E1E1E] rounded-xl mb-6 py-10">
        <div class="grid md:grid-cols-2 gap-6 sm:grid-cols-1 md:mt-5 lg:mt-10 px-4 lg:px-10">
            <div class="flex flex-col gap-6 w-full md:w-10/12 md:justify-self-start">
                <p class="text-2xl lg:text-4xl text-[#464559] dark:text-white font-semibold">{!! __('general.CareerOne Platform')!!}</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    {!! __('general.Career One is a Sri Lankan platform that provides comprehensive solutions to Sri Lankan career seekers.
                    The “TVET Career Platform Project in Sri Lanka“ aims to use the Sri Lanka ICT-based Career Platform to provide high-quality career guidance for trainees with high-level vocational skills throughout Sri Lanka. Project objectives is providing quality career development guidance for vocational skills education trainees and Improving employment of graduates of vocational skills  education and training in Sri Lanka') !!}
                </p>
                <div>
                    <a href="cgo/download-training-document/{{app()->getLocale()}}" target="_blank" class="text-white bg-primary rounded-3xl px-8 py-3 shadow-md">{{ trans('system.read_more') }}</a>
                </div>

            </div>
            <div class="grid order-first md:order-last grid-cols-2 gap-6 w-full md:w-10/12 md:justify-self-end">
                <div class="flex-col flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 55 55" fill="none">
                        <path d="M48.1247 22.9163H43.5413V9.16634H45.833V4.58301H9.16634V9.16634H11.458V22.9163H6.87467C6.26689 22.9163 5.68399 23.1578 5.25422 23.5876C4.82445 24.0173 4.58301 24.6002 4.58301 25.208V45.833H50.4163V25.208C50.4163 24.6002 50.1749 24.0173 49.7451 23.5876C49.3154 23.1578 48.7325 22.9163 48.1247 22.9163ZM32.083 41.2497V32.083H22.9163V41.2497H16.0413V9.16634H38.958V41.2497H32.083Z" fill="#4984F6"/>
                        <path d="M20.625 13.75H25.2083V18.3333H20.625V13.75ZM29.7917 13.75H34.375V18.3333H29.7917V13.75ZM20.625 22.9167H25.2083V27.5H20.625V22.9167ZM29.7917 22.9167H34.375V27.5H29.7917V22.9167Z" fill="#4984F6"/>
                    </svg>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">{{$countInstitute}}+</span>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">Institution</span>
{{--                    <span class="text-[#706F81] dark:text-white">Sollicitudin amet diam</span>--}}
                </div>
                <div class="flex-col flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <path d="M23.5 8.39982C23.5 9.83199 22.9205 11.2055 21.8891 12.2182C20.8576 13.2309 19.4587 13.7998 18 13.7998C16.5413 13.7998 15.1424 13.2309 14.1109 12.2182C13.0795 11.2055 12.5 9.83199 12.5 8.39982C12.5 6.96765 13.0795 5.59414 14.1109 4.58144C15.1424 3.56874 16.5413 2.99982 18 2.99982C19.4587 2.99982 20.8576 3.56874 21.8891 4.58144C22.9205 5.59414 23.5 6.96765 23.5 8.39982ZM32.6667 11.9998C32.6667 12.9546 32.2804 13.8703 31.5927 14.5454C30.9051 15.2205 29.9725 15.5998 29 15.5998C28.0275 15.5998 27.0949 15.2205 26.4073 14.5454C25.7196 13.8703 25.3333 12.9546 25.3333 11.9998C25.3333 11.045 25.7196 10.1294 26.4073 9.45423C27.0949 8.7791 28.0275 8.39982 29 8.39982C29.9725 8.39982 30.9051 8.7791 31.5927 9.45423C32.2804 10.1294 32.6667 11.045 32.6667 11.9998ZM25.3333 24.5998C25.3333 22.6903 24.5607 20.8589 23.1854 19.5086C21.8102 18.1584 19.9449 17.3998 18 17.3998C16.0551 17.3998 14.1898 18.1584 12.8146 19.5086C11.4393 20.8589 10.6667 22.6903 10.6667 24.5998V29.9998H25.3333V24.5998ZM10.6667 11.9998C10.6667 12.9546 10.2804 13.8703 9.59273 14.5454C8.90509 15.2205 7.97246 15.5998 7 15.5998C6.02754 15.5998 5.09491 15.2205 4.40728 14.5454C3.71964 13.8703 3.33333 12.9546 3.33333 11.9998C3.33333 11.045 3.71964 10.1294 4.40728 9.45423C5.09491 8.7791 6.02754 8.39982 7 8.39982C7.97246 8.39982 8.90509 8.7791 9.59273 9.45423C10.2804 10.1294 10.6667 11.045 10.6667 11.9998ZM29 29.9998V24.5998C29.0027 22.7697 28.5294 20.9693 27.625 19.369C28.4378 19.1648 29.2874 19.1455 30.1089 19.3127C30.9305 19.4799 31.7022 19.8291 32.3654 20.3337C33.0286 20.8382 33.5656 21.4849 33.9356 22.2242C34.3055 22.9635 34.4986 23.7761 34.5 24.5998V29.9998H29ZM8.375 19.369C7.4707 20.9693 6.99743 22.7697 7 24.5998V29.9998H1.5V24.5998C1.49965 23.7755 1.69152 22.962 2.0609 22.2218C2.43029 21.4815 2.96739 20.8341 3.63104 20.3292C4.29469 19.8242 5.06727 19.4752 5.88957 19.3087C6.71187 19.1423 7.56207 19.1629 8.375 19.369Z" fill="#4984F6"/>
                    </svg>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">{{$countCGO}}+</span>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">CGO</span>
{{--                    <span class="text-[#706F81] dark:text-white">Sollicitudin amet diam</span>--}}
                </div>
                <div class="flex-col flex gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" viewBox="0 0 36 36" fill="none">
                        <path d="M24 11.9998C24 15.3148 21.315 17.9998 18 17.9998C14.685 17.9998 12 15.3148 12 11.9998L12.165 10.5898L7.5 8.24982L18 2.99982L28.5 8.24982V15.7498H27V8.99982L23.835 10.5898L24 11.9998ZM18 20.9998C24.63 20.9998 30 23.6848 30 26.9998V29.9998H6V26.9998C6 23.6848 11.37 20.9998 18 20.9998Z" fill="#4984F6"/>
                    </svg>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">{{$countTrainee}}+</span>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">Trainee</span>
{{--                    <span class="text-[#706F81] dark:text-white">Sollicitudin amet diam</span>--}}
                </div>
                <div class="flex-col flex gap-2">
                    <div class="w-auto h-10">
                        <svg width="36" height="36" class="fill-primary" viewBox="0 0 32 32" xmlns="http://www.w3.org/2000/svg"><g id="_x30_1_sales"/><g id="_x30_2_megaphone"/><g id="_x30_3_target"/><g id="_x30_4_briefcase">
                                <path d="m31 10v5.27c0 1.48-1.11 2.76-2.58 2.96l-9.42 1.35v-1.58c0-.55-.45-1-1-1h-4c-.55 0-1 .45-1 1v1.58l-9.42-1.35c-1.47-.2-2.58-1.48-2.58-2.96v-5.27c0-1.65 1.35-3 3-3h24c1.65 0 3 1.35 3 3zm-2.29 10.21-9.71 1.39v2.4c0 .55-.45 1-1 1h-4c-.55 0-1-.45-1-1v-2.4l-9.71-1.39c-.45-.06-.89-.19-1.29-.37v8.16c0 1.65 1.35 3 3 3h22c1.65 0 3-1.35 3-3v-8.16c-.4.18-.84.31-1.29.37zm-7.71-16.21c0-1.65-1.35-3-3-3h-4c-1.65 0-3 1.35-3 3v1h2v-1c0-.55.45-1 1-1h4c.55 0 1 .45 1 1v1h2z"/></g><g id="_x30_5_graph"/><g id="_x30_6_email_marketing"/><g id="_x30_7_mobile_payment"/><g id="_x30_8_chat"/><g id="_x30_9_email"/><g id="_x31_0_shopping_online"/><g id="_x31_1_browser"/><g id="_x31_2_content"/><g id="_x31_3_blogging"/><g id="_x31_4_link"/><g id="_x31_5_web_development"/><g id="_x31_6_target_dollar"/><g id="_x31_7_reward"/><g id="_x31_8_website_love"/><g id="_x31_9_pay_per_click"/><g id="_x32_0_growth"/><g id="_x32_1_form"/><g id="_x32_2_mailing"/><g id="_x32_3_protection"/><g id="_x32_4_search"/><g id="_x32_5_chat_speech_bubble"/></svg>
                    </div>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">{{$countCompany}}+</span>
                    <span class="text-primary text-xl md:text-2xl font-semibold dark:text-white">Company</span>
                </div>
            </div>
        </div>
        <div class="grid grid-cols-3 lg:grid-cols-7 px-4 lg:px-10 gap-6 mt-4">
            <div class="flex flex-col gap-6 items-center">
                <a href="https://skillsmin.gov.lk" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/NIElogo.webp')}}" class="w-14 object-cover" alt="NIE">
                    </div>
                </a>
                <a href="https://skillsmin.gov.lk" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    Ministry
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://www.tvec.gov.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/1. TVEC_Logo.webp')}}" class="w-14 object-cover" alt="TVEC">
                    </div>
                </a>
                <a href="https://www.tvec.gov.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    TVEC
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://dtet.gov.lk/en/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/2. DTET_Logo.webp')}}" class="w-14 object-cover" alt="DTET">
                    </div>
                </a>
                <a href="https://dtet.gov.lk/en/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    DTET
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://naita.gov.lk" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/3. NAITA_Logo.webp')}}" class="w-14 object-cover" alt="NAITA">
                    </div>
                </a>
                <a href="https://naita.gov.lk" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    NAITA
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://uovt.ac.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="px-2 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/4. Univotec logo.webp')}}" class="w-full object-cover" alt="UNIVOTEC">
                    </div>
                </a>
                <a href="https://uovt.ac.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    UoVT
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://course.vta.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/5. VTA_Logo.webp')}}" class="w-14 object-cover" alt="VTA">
                    </div>
                </a>
                <a href="https://course.vta.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    VTA
                </a>
            </div>
            <div class="flex flex-col gap-6 items-center">
                <a href="https://ocu.ac.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white" target="_blank">
                    <div class="p-7 rounded-full bg-blue-100 h-32 w-32 flex items-center justify-center">
                        <img src="{{asset('images/organization-logo/6. Ocean University_Logo.webp')}}" class="w-14 object-cover" alt="Ocean University">
                    </div>
                </a>
                <a href="https://ocu.ac.lk/" class="font-semibold text-xl hover:text-primary hover:underline dark:text-white text-center" target="_blank">
                    Ocean University
                </a>
            </div>
        </div>

    </div>

@endsection
