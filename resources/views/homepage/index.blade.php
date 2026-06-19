@extends('homepage.layouts.master')
@section('title', 'TVET System - Homepage')
@push('preload')
    <link rel="preload" as="image" href="{{asset('images/testnow.webp')}}">
@endpush
@section('content')
    <div class="flex flex-col gap-6 md:gap-9 mt-6">
            @include('homepage.partials.carousel')

        {{--    Section our sector    --}}
            @include('homepage.partials.sector')
        {{--Section content--}}
        <div class="flex flex-col gap-6">
            <div class="flex justify-between">
                <span class="text-[#201F36] dark:text-white text-lg xl:text-2xl font-semibold">{{trans('system.recent_content')}}</span>
                <span class="">
                    <a href="/career-guidance/career-information/contents/{{base64_encode($contentCategory->id)}}" class="flex gap-2 text-sm md:text-base text-primary items-center dark:text-white hover:text-blue-600">{{trans('system.action.view_more')}}
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                    </a>
                </span>
            </div>
            @if(count($contents) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @forelse($contents as $content)
                    <div class="relative flex gap-3 p-4 flex-col shadow-custom-light dark:shadow-custom-dark rounded-xl border border-gray-50 dark:border-white h-96 bg-white dark:bg-[#1E1E1E]">
                        @if($content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value)
                            <div class="flex items-center justify-between">
                                <a href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}" class="dark:text-white font-semibold hover:text-primary h-12 w-5/6">{{\Str::limit($content->title, 30)}}</a>
                                <div class="w-1/6 flex justify-end">
                                    <img src="/images/approved-by-expert.webp" class="h-12 w-fit" alt="Approved by Industry Expert">
                                </div>
                            </div>
                        @else
                            <a href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}" class="dark:text-white font-semibold hover:text-primary h-12">{{\Str::limit($content->title, 30)}}</a>
                        @endif
                        @if($content->content_type == 'video')
                            <iframe
                                id="yt-iframe-{{ $content->id }}"
                                class="w-full h-full rounded-t-xl youtube-iframe"
                                src="{{ getYoutubeEmbedUrl($content->video_url) }}?enablejsapi=1&autoplay=0&rel=0"
                                frameborder="0"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                                referrerpolicy="strict-origin-when-cross-origin">
                            </iframe>
                        @else
                            <a class="flex justify-center" href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}"><img src="{{asset($content->thumbnail)}}" class="rounded h-52 object-contain" alt="Thumbnail content"></a>
                        @endif
                        <p class="text-[#91919A] dark:text-white text-sm gap-1 break-words h-32">
                            {!! substr($content->intro, 0, 100) !!}{{ strlen($content->intro) > 100 ? '...' : '' }}
                        </p>
                        <div class="flex justify-between gap-4 items-center h-8">
                            @if($content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value || $content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value)
                                <span class="text-xs text-primary flex items-center w-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                    <path d="M4.66665 8.49996L7.99998 11.8333L14.6666 5.16663M1.33331 8.49996L4.66665 11.8333M7.99998 8.49996L11.3333 5.16663" stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> {{\App\Enums\StatusEnumsManagement::getStatusName(\App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value)}}
                                </span>
                            @else
                                <span class=" w-1/2"></span>
                            @endif
                            <div class="flex gap-2 items-center justify-end w-1/2">
                                    <span class="flex items-center gap-1 text-xs w-fit justify-end dark:text-white text-[#464559]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{$content->views}}</span>
                                    </span>
                                <span class="flex items-center gap-1 text-xs w-fit justify-end dark:text-white text-[#464559]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                               2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                                               C13.09 3.81 14.76 3 16.5 3
                                               19.58 3 22 5.42 22 8.5
                                               c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>{{$content->likes}}</span>
                                    </span>
                            </div>

                        </div>
                    </div>
                @empty
                @endforelse

            </div>
            @endif

        </div>
        {{--    End section our sector    --}}
{{--        <div class="flex flex-col sm:flex-row items-center relative h-[40rem] sm:h-[25rem] md:h-[27rem] lg:h-[30rem] w-full bg-white  dark:bg-[#1E1E1E] justify-center md:justify-between rounded-xl xl:gap-24 px-4 py-2 md:px-6 md:py-4 lg:px-10 lg:py-6 xl:px-16 xl:py-6">--}}
{{--            <div class="flex flex-col gap-4 md:gap-6 w-full h-full justify-center mb-4">--}}
{{--                <p class="text-primary dark:text-white text-xl md:text-2xl lg:text-3xl xl:text-4xl font-semibold">{{ __('general.Occupational Psychological Test') }}:<br>--}}
{{--                    </p>--}}
{{--                <p class="text-[#706F81]  dark:text-white text-base md:text-sm lg:text-base">{{ __('general.Career platform job psychology tests objectively measure various psychological characteristics such as individual abilities, interests, and personalities to help you understand yourself and help you choose a career field that is more suitable for your individual characteristics.') }}--}}
{{--                </p>--}}
{{--                <div>--}}
{{--                    <a href="{{route('testnow.list')}}" class="px-4 py-1.5 lg:py-3 lg:px-8 bg-primary rounded-full text-white text-base xl:text-lg font-semibold">{{ __('general.Test now') }}</a>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <img src="{{asset('images/testnow.png')}}" alt="" class="rounded-xl w-full sm:w-64 md:w-72 xl:w-auto h-auto">--}}
{{--        </div>--}}
        <div class="flex flex-col sm:flex-row items-center bg-white  dark:bg-[#1E1E1E] justify-center md:justify-between rounded-xl p-4 sm:px-8 xl:px-16 xl:py-6 shadow-custom-light dark:shadow-custom-dark gap-4">
            <div class="flex flex-col gap-4 md:gap-6 w-full h-full justify-center mb-4">
                <p class="text-primary dark:text-white text-xl md:text-2xl lg:text-3xl xl:text-4xl font-semibold">{{ __('general.Occupational Psychological Test') }}:<br>
                </p>
                <p class="text-[#706F81]  dark:text-white text-base md:text-sm lg:text-base">{{ __('general.Career platform job psychology tests objectively measure various psychological characteristics such as individual abilities, interests, and personalities to help you understand yourself and help you choose a career field that is more suitable for your individual characteristics.') }}
                </p>
                <div>
                    <a href="{{route('testnow.list')}}" class="px-4 py-1.5 lg:py-3 lg:px-8 bg-primary rounded-full text-white text-base xl:text-lg font-semibold truncate max-w-[70%] lg:w-full hover:bg-blue-600">{{ __('general.Test now') }}</a>
                </div>

            </div>
            <img src="{{asset('images/testnow.webp')}}" alt="Test now" class="rounded-xl sm:w-1/2 xl:w-full">
        </div>

        {{--Section Hot job--}}
        <div class="flex flex-col gap-6">
            <div class="flex justify-between">
                <span class="text-[#201F36] dark:text-white text-lg xl:text-2xl font-semibold">{{trans('system.recent_job')}}</span>
                <span class="">
                    @if(Auth::guard('company')->check())
                        <a href="{{route('company.job-support.job-vacancy.list')}}" class="flex gap-2 text-sm md:text-base text-primary items-center dark:text-white hover:text-blue-600">{{trans('system.action.view_more')}}
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                    </a>
                    @else
                    <a href="{{route('homepage.job-list')}}" class="flex gap-2 text-sm md:text-base text-primary items-center dark:text-white hover:text-blue-600">{{trans('system.action.view_more')}}
                        <span>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </span>
                    </a>
                    @endif
                </span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
                @forelse($recent_jobs as $recent_job)
                <div class="flex md:flex-col shadow-custom-light dark:shadow-custom-dark gap-6 justify-around p-4 rounded-xl bg-white dark:bg-[#1E1E1E] border border-[#F8F8F8] dark:border-0">
                        <div class="flex justify-center bg-[#FBFBFB] rounded-xl relative w-1/3 md:w-full">
                            <label for="" class="max-w-[70%] bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-sm rounded m-2 truncate">{{getCodeNameByCodeId('job_status', $recent_job->status)}}</label>
                            @if($recent_job->company->logo != '')
                            <img src="{{asset($recent_job->company->logo)}}" loading="lazy" class="rounded-xl object-cover md:h-36 lg:h-48" alt="Company logo">
                            @else
                            <img class="rounded-xl object-cover md:h-36 lg:h-48" loading="lazy" src="{{asset('uploads/logo_default.png')}}" alt="Company logo">
                            @endif
                        </div>
                        <div class="w-2/3 md:w-full">
                            <div class="flex flex-col gap-3 justify-around">
                                <a href="{{route('homepage.job-detail', ['job_id' => $recent_job->id,'slug' => $recent_job->slug])}}" class="md:text-xl font-semibold dark:text-white hover:text-blue-600">{{\Str::limit($recent_job->title,35)}}</a>
                                <p class="text-[#706F81] dark:text-white text-sm md:text-base font-semibold">{{\Str::limit($recent_job->company->name,15)}}</p>
                                <span class="text-[#91919A] text-sm md:text-sm dark:text-white">
                                    {{convertDays($recent_job->working_day)}}
                                </span>
                                <div class="flex justify-between items-center">
                                    <span class="text-[#91919A] md:text-sm text-xs dark:text-white">
                                        @if(!empty($recent_job->min_salary))
                                            {{ $recent_job->min_salary }} {{ $recent_job->salary_currency ?? '' }}
                                        @endif
                                    </span>
                                    <span class="text-[#464559] font-medium dark:text-white text-xs md:text-sm">
                                        {{ getCodeNameByCodeId('job_type', $recent_job->job_type) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="w-full dark:text-white">{{ __('general.There is no recent job') }}</p>
                @endforelse
            </div>
        </div>
            @include('homepage.partials.news')
    </div>

    @if(isset($popups) && count($popups) > 0)
        <!-- Unified Popups Modal -->
        <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 w-full z-50 hidden h-[calc(100%-1rem)] max-h-full w-fit md:w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative w-full max-w-6xl bg-gradient-to-br from-cyan-50 via-purple-50 to-white dark:from-gray-900 dark:via-gray-800 dark:to-gray-950 rounded-2xl shadow-2xl border border-white/60 dark:border-gray-800 overflow-hidden h-[85vh] lg:h-[75vh] flex flex-col transition duration-300">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 border-b border-gray-100 dark:border-gray-800">
                    <h3 class="text-sm font-bold text-gray-400 dark:text-gray-500 tracking-wide uppercase">{{ __('general.Announcements') }}</h3>
                    <button type="button" class="text-gray-400 hover:text-gray-800 dark:text-gray-500 dark:hover:text-white transition z-10 p-2 rounded-full hover:bg-black/5 dark:hover:bg-white/5" data-modal-hide="modalEl">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal body / Carousel wrapper -->
                <div id="default-carousel" class="relative w-full flex-1 overflow-y-auto" data-carousel="static">
                    <!-- Carousel wrapper -->
                    <div class="relative overflow-hidden h-full">
                        @forelse($popups as $key => $popup)
                            @php
                                $locale = \App::getLocale();
                                if ($popup->is_success_recognition) {
                                    $title = __('general.Success Stories & Stats');
                                } else {
                                    if ($locale === 'en') {
                                        $title = $popup->title;
                                    } else {
                                        $translatedTitle = $popup->{'title_' . $locale} ?? null;
                                        $title = $translatedTitle ?: $popup->title;
                                    }
                                }
                            @endphp

                            @if($popup->is_success_recognition)
                                <!-- Success & Recognition Slide -->
                                <div class="hidden duration-700 ease-in-out overflow-y-auto p-6 md:p-8" data-carousel-item="{{ $key === 0 ? 'active' : '' }}">
                                    @if(!empty($title))
                                        <div class="text-center mb-6">
                                            <h2 class="text-xl md:text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-purple-650 dark:from-blue-400 dark:to-purple-400 tracking-wide uppercase">{{ $title }}</h2>
                                        </div>
                                    @endif

                                    @if(!empty($popup->message))
                                        <div class="mb-6 bg-blue-50/50 dark:bg-blue-950/20 border border-blue-100 dark:border-blue-900/40 rounded-xl p-4 text-xs md:text-sm text-gray-700 dark:text-gray-300">
                                            {!! $popup->message !!}
                                        </div>
                                    @endif

                                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 items-stretch">
                                        <!-- Column 1: PLATFORM SUCCESS STORIES -->
                                        <div class="flex flex-col bg-white/70 dark:bg-gray-800/40 backdrop-blur-md rounded-2xl p-6 border border-white/80 dark:border-gray-750 shadow-sm justify-between min-h-[350px]">
                                            <div>
                                                <div class="flex items-center gap-3">
                                                    <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shrink-0">
                                                        <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M19 4h-3V2H8v2H5C3.9 4 3 4.9 3 6v3c0 2.2 1.8 4 4 4h1.7c.8 1.8 2.3 3.2 4.3 3.7V19H10c-.6 0-1 .4-1 1v2h6v-2c0-.6-.4-1-1-1h-3v-2.3c2-.5 3.5-1.9 4.3-3.7H17c2.2 0 4-1.8 4-4V6c0-1.1-.9-2-2-2zM7 11c-1.1 0-2-.9-2-2V6h2v5zm12-2c0 1.1-.9 2-2 2h-2V6h2v3z"/>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-base font-bold text-gray-800 dark:text-white tracking-wide uppercase">{{ __('general.Platform Success Stories') }}</h3>
                                                </div>
                                                <!-- Live text summary -->
                                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-3 font-semibold">
                                                    {{ __('general.Over :count trainees successfully placed in jobs & OJT opportunities, connecting :candidates candidates with top organizations!', ['count' => $placedCount, 'candidates' => $traineeCount]) }}
                                                </p>

                                                <!-- Success Stories Slider -->
                                                <div class="relative h-40 mt-4 overflow-hidden border-t border-gray-100 dark:border-gray-700/50 pt-4">
                                                    <!-- Story 1 -->
                                                    <div class="success-story-slide absolute inset-0 flex flex-col transition-all duration-700 opacity-100 transform translate-x-0 mt-4" data-slide-index="0">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-10 h-10 rounded-full bg-blue-100 dark:bg-blue-900 flex items-center justify-center text-blue-600 dark:text-blue-300 font-bold shrink-0">DP</div>
                                                            <div>
                                                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Dilshan Perera</h4>
                                                                <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ __('general.success_story_1_role') }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-xs italic text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                                            {{ __('general.success_story_1_message') }}
                                                        </p>
                                                    </div>
                                                    <!-- Story 2 -->
                                                    <div class="success-story-slide absolute inset-0 flex flex-col transition-all duration-700 opacity-0 transform translate-x-8 mt-4" data-slide-index="1">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-10 h-10 rounded-full bg-purple-100 dark:bg-purple-900 flex items-center justify-center text-purple-600 dark:text-purple-300 font-bold shrink-0">FR</div>
                                                            <div>
                                                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Fathima Rizna</h4>
                                                                <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ __('general.success_story_2_role') }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-xs italic text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                                            {{ __('general.success_story_2_message') }}
                                                        </p>
                                                    </div>
                                                    <!-- Story 3 -->
                                                    <div class="success-story-slide absolute inset-0 flex flex-col transition-all duration-700 opacity-0 transform translate-x-8 mt-4" data-slide-index="2">
                                                        <div class="flex items-center gap-3">
                                                            <div class="w-10 h-10 rounded-full bg-emerald-100 dark:bg-emerald-900 flex items-center justify-center text-emerald-600 dark:text-emerald-300 font-bold shrink-0">SS</div>
                                                            <div>
                                                                <h4 class="text-xs font-bold text-gray-800 dark:text-white">Sajith Silva</h4>
                                                                <p class="text-[10px] text-gray-400 dark:text-gray-500">{{ __('general.success_story_3_role') }}</p>
                                                            </div>
                                                        </div>
                                                        <p class="text-xs italic text-gray-600 dark:text-gray-300 mt-2 line-clamp-3">
                                                            {{ __('general.success_story_3_message') }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Column 2: TOP PERFORMERS RECOGNITION -->
                                        <div class="flex flex-col bg-white/70 dark:bg-gray-800/40 backdrop-blur-md rounded-2xl p-6 border border-white/80 dark:border-gray-750 shadow-sm min-h-[350px] relative overflow-hidden">
                                            <div class="flex items-center gap-3 mb-2">
                                                <div class="w-10 h-10 rounded-xl bg-blue-600 flex items-center justify-center shadow-md shrink-0">
                                                    <svg class="w-5 h-5 text-yellow-350 fill-current" viewBox="0 0 24 24">
                                                        <path d="M12 17.27L18.18 21l-1.64-7.03L22 9.24l-7.19-.61L12 2 9.19 8.63 2 9.24l5.46 4.73L5.82 21z"/>
                                                    </svg>
                                                </div>
                                                <h3 class="text-base font-bold text-gray-800 dark:text-white tracking-wide uppercase">{{ __('general.Top Performers Recognition') }}</h3>
                                            </div>
                                            <p class="text-[11px] text-gray-400 dark:text-gray-500 font-semibold mb-4">{{ __('general.Top Counselors') }}</p>

                                            <!-- Podium container -->
                                            <div class="flex items-end justify-between w-full gap-2 px-1 flex-1 mt-4">
                                                <!-- 2nd Place -->
                                                <div class="flex flex-col items-center w-1/3">
                                                    <div class="relative">
                                                        <img src="{{ $topCgos[1]->profile_image ? asset($topCgos[1]->profile_image) : asset('images/avatar.png') }}" class="w-12 h-12 rounded-full border-2 border-gray-300 object-cover shadow-sm">
                                                        <span class="absolute -top-1 -left-1 bg-gray-400 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold shadow border border-white">2</span>
                                                    </div>
                                                    <p class="text-[11px] font-semibold mt-1 text-center text-gray-800 dark:text-white truncate w-full">{{ $topCgos[1]->first_name }} {{ substr($topCgos[1]->last_name, 0, 1) }}.</p>
                                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-medium">{{ $topCgos[1]->completed_count }} {{ __('general.Guidance') }}</p>
                                                    <div class="w-full bg-gradient-to-t from-gray-200 to-gray-150 dark:from-gray-700 dark:to-gray-650 h-14 rounded-t-lg mt-1 shadow-sm flex items-center justify-center">
                                                        <span class="text-gray-400 dark:text-gray-550 font-bold text-sm">II</span>
                                                    </div>
                                                </div>

                                                <!-- 1st Place (Winner) -->
                                                <div class="flex flex-col items-center w-1/3">
                                                    <div class="relative scale-110 -translate-y-1">
                                                        <img src="{{ $topCgos[0]->profile_image ? asset($topCgos[0]->profile_image) : asset('images/avatar.png') }}" class="w-14 h-14 rounded-full border-2 border-yellow-400 object-cover shadow-md">
                                                        <span class="absolute -top-1 -left-1 bg-yellow-400 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold shadow border border-white">1</span>
                                                    </div>
                                                    <p class="text-[11px] font-bold mt-1 text-center text-gray-900 dark:text-white truncate w-full">{{ $topCgos[0]->first_name }} {{ substr($topCgos[0]->last_name, 0, 1) }}.</p>
                                                    <p class="text-[9px] text-yellow-600 dark:text-yellow-450 font-bold">{{ $topCgos[0]->completed_count }} {{ __('general.Guidance') }}</p>
                                                    <div class="w-full bg-gradient-to-t from-yellow-350 to-yellow-200 dark:from-yellow-600 dark:to-yellow-500 h-20 rounded-t-lg mt-1 shadow-md flex items-center justify-center">
                                                        <span class="text-yellow-700 dark:text-yellow-100 font-black text-base">I</span>
                                                    </div>
                                                </div>

                                                <!-- 3rd Place -->
                                                <div class="flex flex-col items-center w-1/3">
                                                    <div class="relative">
                                                        <img src="{{ $topCgos[2]->profile_image ? asset($topCgos[2]->profile_image) : asset('images/avatar.png') }}" class="w-12 h-12 rounded-full border-2 border-amber-600 object-cover shadow-sm">
                                                        <span class="absolute -top-1 -left-1 bg-amber-700 text-white rounded-full w-4 h-4 flex items-center justify-center text-[10px] font-bold shadow border border-white">3</span>
                                                    </div>
                                                    <p class="text-[11px] font-semibold mt-1 text-center text-gray-800 dark:text-white truncate w-full">{{ $topCgos[2]->first_name }} {{ substr($topCgos[2]->last_name, 0, 1) }}.</p>
                                                    <p class="text-[9px] text-gray-400 dark:text-gray-500 font-medium">{{ $topCgos[2]->completed_count }} {{ __('general.Guidance') }}</p>
                                                    <div class="w-full bg-gradient-to-t from-amber-600/30 to-amber-500/20 dark:from-amber-750/30 dark:to-amber-650/20 h-10 rounded-t-lg mt-1 shadow-sm flex items-center justify-center">
                                                        <span class="text-amber-600 dark:text-amber-500 font-bold text-sm">III</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Column 3: CAREER GROWTH KIT -->
                                        <div class="flex flex-col bg-white/70 dark:bg-gray-800/40 backdrop-blur-md rounded-2xl p-5 border border-cyan-100 dark:border-cyan-950/40 shadow-sm relative justify-between min-h-[350px]">
                                            <div>
                                                <div class="flex items-center gap-3 mb-4">
                                                    <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-cyan-500 to-blue-600 flex items-center justify-center shadow-md shrink-0">
                                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-base font-bold text-gray-800 dark:text-white tracking-wide uppercase">{{ __('general.Career Growth Kit') }}</h3>
                                                </div>

                                                <!-- Guided Steps -->
                                                <div class="flex flex-col gap-3 relative z-10">
                                                    <!-- Step 1: Career Test -->
                                                    <a href="{{ route('testnow.list') }}" class="group block p-3 bg-gradient-to-r from-indigo-50/50 to-indigo-100/30 dark:from-indigo-950/10 dark:to-indigo-900/5 hover:from-indigo-50 hover:to-indigo-100 dark:hover:from-indigo-950/20 dark:hover:to-indigo-900/10 rounded-xl border border-indigo-100/60 dark:border-indigo-900/30 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-8 h-8 rounded-lg bg-indigo-600 text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center justify-between gap-1">
                                                                    <h4 class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition-colors">{{ __('general.1. Discover Your Match') }}</h4>
                                                                    <span class="text-[9px] bg-indigo-150 text-indigo-800 dark:bg-indigo-950 dark:text-indigo-300 font-extrabold px-1.5 py-0.5 rounded-md uppercase tracking-wider shrink-0 scale-90">{{ __('general.Start') }}</span>
                                                                </div>
                                                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('general.Take the career test to find the career path matching your personality and interests.') }}</p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- Step 2: Digital Portfolio -->
                                                    @php
                                                        $portfolioUrl = activeGuard() == 'trainee' ? route('trainee.career-guidance.portfolio.get-portfolio') : '/choose-login';
                                                    @endphp
                                                    <a href="{{ $portfolioUrl }}" class="group block p-3 bg-gradient-to-r from-blue-50/50 to-blue-100/30 dark:from-blue-950/10 dark:to-blue-900/5 hover:from-blue-50 hover:to-blue-100 dark:hover:from-blue-950/20 dark:hover:to-blue-900/10 rounded-xl border border-blue-100/60 dark:border-blue-900/30 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-8 h-8 rounded-lg bg-blue-600 text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/>
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center justify-between gap-1">
                                                                    <h4 class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ __('general.2. Showcase Your Skills') }}</h4>
                                                                    <span class="text-[9px] bg-blue-150 text-blue-800 dark:bg-blue-950 dark:text-blue-300 font-extrabold px-1.5 py-0.5 rounded-md uppercase tracking-wider shrink-0 scale-90">{{ __('general.Build') }}</span>
                                                                </div>
                                                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('general.Create a digital portfolio to display your certificates, skills, and stand out.') }}</p>
                                                            </div>
                                                        </div>
                                                    </a>

                                                    <!-- Step 3: Professional Counseling -->
                                                    @php
                                                        $counselingUrl = activeGuard() == 'trainee' ? route('trainee.career-guidance.counseling.counseling-request') : '/choose-login';
                                                    @endphp
                                                    <a href="{{ $counselingUrl }}" class="group block p-3 bg-gradient-to-r from-teal-50/50 to-teal-100/30 dark:from-teal-950/10 dark:to-teal-900/5 hover:from-teal-50 hover:to-teal-100 dark:hover:from-teal-950/20 dark:hover:to-teal-900/10 rounded-xl border border-teal-100/60 dark:border-teal-900/30 transition-all duration-200 hover:-translate-y-0.5 shadow-sm">
                                                        <div class="flex items-start gap-3">
                                                            <div class="w-8 h-8 rounded-lg bg-teal-600 text-white flex items-center justify-center shrink-0 shadow-sm group-hover:scale-105 transition-transform duration-200">
                                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                                                </svg>
                                                            </div>
                                                            <div class="flex-1">
                                                                <div class="flex items-center justify-between gap-1">
                                                                    <h4 class="text-xs font-bold text-gray-800 dark:text-white group-hover:text-teal-600 dark:group-hover:text-teal-400 transition-colors">{{ __('general.3. Professional Counseling') }}</h4>
                                                                    <span class="text-[9px] bg-teal-150 text-teal-800 dark:bg-teal-950 dark:text-teal-300 font-extrabold px-1.5 py-0.5 rounded-md uppercase tracking-wider shrink-0 scale-90">{{ __('general.Book') }}</span>
                                                                </div>
                                                                <p class="text-[10px] text-gray-500 dark:text-gray-400 mt-1 leading-relaxed">{{ __('general.Schedule a 1-on-1 counseling session with our expert career guidance officers.') }}</p>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </div>

                                                @if($popup->image)
                                                    <div class="mt-4 flex justify-center max-h-24 overflow-hidden rounded-xl border border-gray-100 dark:border-gray-850 shadow-inner">
                                                        <img src="{{ asset('storage/' . $popup->image) }}" alt="Success Recognition Image" class="w-full object-cover">
                                                    </div>
                                                @endif
                                            </div>

                                            <!-- Graphical rising chart in bottom right -->
                                            <div class="absolute bottom-2 right-2 opacity-5 dark:opacity-10 pointer-events-none">
                                                <svg class="w-24 h-24 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 18L9 11.25l4.306 4.307a11.95 11.95 0 015.814-5.519l2.74-1.22m0 0l-5.94-2.28m5.94 2.28l-2.28 5.941" />
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <!-- Standard Popup Slide -->
                                <div class="hidden duration-700 ease-in-out overflow-y-auto p-6 md:p-8" data-carousel-item="{{ $key === 0 ? 'active' : '' }}">
                                    <div class="space-y-6 max-w-4xl mx-auto bg-white/50 dark:bg-gray-800/30 backdrop-blur-md rounded-2xl p-6 md:p-8 border border-white/60 dark:border-gray-800/60 shadow-md">
                                        @if (!empty($title))
                                            <h2 class="text-xl md:text-2xl font-bold mb-4 text-center text-gray-800 dark:text-white">{{ $title }}</h2>
                                        @endif

                                        @if ($popup->image)
                                            <div class="flex justify-center w-full max-h-[300px] overflow-hidden rounded-lg">
                                                <img src="{{ asset('storage/' . $popup->image) }}" alt="Popup Image" class="max-w-full max-h-full object-contain rounded-lg">
                                            </div>
                                        @endif

                                        @if(!empty($popup->message))
                                            <div class="dark:text-white text-gray-700 text-sm leading-relaxed">{!! $popup->message !!}</div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        @empty
                        @endforelse
                    </div>

                    @if(count($popups) > 1)
                        <!-- Slider indicators -->
                        <div class="absolute z-30 flex -translate-x-1/2 left-1/2 bottom-4 space-x-3 rtl:space-x-reverse">
                            @foreach($popups as $key => $popup)
                                <button type="button" class="w-3 h-3 rounded-full border border-gray-300 dark:border-gray-650 bg-white dark:bg-gray-850" aria-current="{{ $key === 0 ? 'true' : 'false' }}" aria-label="Slide {{$key}}" data-carousel-slide-to="{{$key}}"></button>
                            @endforeach
                        </div>
                        <!-- Slider controls -->
                        <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none text-gray-500 dark:text-white" data-carousel-prev>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 border border-gray-200 dark:border-gray-750">
                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                </svg>
                                <span class="sr-only">Previous</span>
                            </span>
                        </button>
                        <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none text-gray-500 dark:text-white" data-carousel-next>
                            <span class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 border border-gray-200 dark:border-gray-750">
                                <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                </svg>
                                <span class="sr-only">Next</span>
                            </span>
                        </button>
                    @endif
                </div>

                <!-- Footer: Checkbox & Close -->
                <div class="px-6 py-4 bg-gray-50/80 dark:bg-gray-900/60 border-t border-gray-150 dark:border-gray-800 flex justify-between items-center text-xs md:text-sm">
                    <label class="flex items-center gap-2 cursor-pointer text-gray-600 dark:text-gray-300">
                        <input type="checkbox" id="dontShow" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                        <span>{{trans('general.Do not open for one day')}}</span>
                    </label>
                    <button data-modal-hide="modalEl" type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none font-medium rounded-full text-xs sm:w-auto px-10 py-3 text-center transition">
                        {{trans('system.form.button.close')}}
                    </button>
                </div>
            </div>
        </div>

        <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const $targetEl = document.getElementById('modalEl');
                const options = {
                    placement: 'center-center',
                    backdrop: 'dynamic',
                    backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                    closable: true,
                    onHide: () => {
                        console.log('modal is hidden');
                    },
                    onShow: () => {
                        console.log('modal is shown');
                    },
                    onToggle: () => {
                        console.log('modal has been toggled');
                    },
                };

                const modal = new Modal($targetEl, options);

                // Check if popup was hidden for 1 day
                const hideUntil = localStorage.getItem('popupHideUntil');
                const now = new Date();

                if (!hideUntil || new Date(hideUntil) < now) {
                    modal.show();
                }

                const checkbox = document.getElementById('dontShow');
                if (checkbox) {
                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            const tomorrow = new Date();
                            tomorrow.setDate(tomorrow.getDate() + 1);
                            localStorage.setItem('popupHideUntil', tomorrow.toISOString());
                        } else {
                            localStorage.removeItem('popupHideUntil');
                        }
                    });
                }

                // Slideshow logic for Success Stories inside the slide
                let currentSlide = 0;
                const slides = document.querySelectorAll('.success-story-slide');
                if (slides.length > 0) {
                    setInterval(() => {
                        slides[currentSlide].classList.remove('opacity-100', 'translate-x-0');
                        slides[currentSlide].classList.add('opacity-0', 'translate-x-8');
                        
                        currentSlide = (currentSlide + 1) % slides.length;
                        
                        slides[currentSlide].classList.remove('opacity-0', 'translate-x-8');
                        slides[currentSlide].classList.add('opacity-100', 'translate-x-0');
                    }, 4000);
                }
            });
        </script>
    @endif
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Glide.js/3.5.0/glide.min.js"></script>
    <script>
        var sliders = document.querySelectorAll('.glide');

        for (var i = 0; i < sliders.length; i++) {
            var glide = new Glide(sliders[i], {
                type: 'carousel',
                startAt: 0,
                perView: 4,
                gap: 8,
                breakpoints: {
                    1440: {
                        perView: 4,
                    },
                    1024: {
                        perView: 4,
                    },
                    768: {
                        perView: 3,
                    },
                    500: {
                        perView: 1.5,
                    }
                }
            });

            glide.mount();
        }
    </script>
@endpush
