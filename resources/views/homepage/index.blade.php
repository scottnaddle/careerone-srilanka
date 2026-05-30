@extends('homepage.layouts.master')
@section('title', 'TVET System - Homepage')
@push('preload')
    <link rel="preload" as="image" href="{{asset('images/testnow.webp')}}">
@endpush
@section('content')
    <div class="flex flex-col gap-6 md:gap-9 mt-6">
            @include('homepage.partials.carousel')

            {{-- Who Are You? Section --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 md:gap-6 mt-16 md:mt-24">
                <a href="/choose-login"
                    class="group flex flex-col items-center p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 bg-white dark:bg-[#1E1E1E] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-blue-50 dark:bg-blue-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-[#4984F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489a50.702 50.702 0 0 1 7.74-3.342M6.75 15a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Zm0 0v-3.675A55.378 55.378 0 0 1 12 8.443m-7.007 11.55A5.981 5.981 0 0 0 6.75 15.75v-1.5"/></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.Trainee') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">{{ __('general.Find courses, jobs, and career guidance') }}</p>
                    <span class="mt-3 text-[#4984F6] text-sm font-medium group-hover:underline">{{ __('general.Get Started') }} →</span>
                </a>
                <a href="/choose-login"
                    class="group flex flex-col items-center p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 bg-white dark:bg-[#1E1E1E] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-green-50 dark:bg-green-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.Company') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">{{ __('general.Post jobs, find skilled talent') }}</p>
                    <span class="mt-3 text-green-600 text-sm font-medium group-hover:underline">{{ __('general.Get Started') }} →</span>
                </a>
                <a href="/choose-login"
                    class="group flex flex-col items-center p-6 md:p-8 rounded-2xl shadow-lg border border-gray-100 dark:border-gray-700 bg-white dark:bg-[#1E1E1E] hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-purple-50 dark:bg-purple-900/30 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8 md:w-10 md:h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z"/></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.CGO') }}</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center">{{ __('general.Guide trainees to success') }}</p>
                    <span class="mt-3 text-purple-600 text-sm font-medium group-hover:underline">{{ __('general.Get Started') }} →</span>
                </a>
            </div>

            {{-- Trust Bar --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 md:p-8 text-white shadow-lg">
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">{{ number_format($stats['trainees']) }}+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">{{ __('general.Active Trainees') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">{{ number_format($stats['companies']) }}+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">{{ __('general.Verified Companies') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">{{ number_format($stats['jobs']) }}+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">{{ __('general.Active Jobs') }}</div>
                </div>
                <div class="text-center">
                    <div class="text-2xl md:text-3xl font-bold">{{ number_format($stats['cgos']) }}+</div>
                    <div class="text-sm md:text-base text-blue-100 mt-1">{{ __('general.Career Officers') }}</div>
                </div>
            </div>

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
                    <a href="{{route('testnow.list')}}" class="px-4 py-1.5 lg:py-3 lg:px-8 bg-primary rounded-full text-white text-base xl:text-lg font-semibold truncate max-w-[70%] lg:w-full">{{ __('general.Test now') }}</a>
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
                                <a href="{{route('homepage.job-detail', ['job_id' => $recent_job->id,'slug' => $recent_job->slug])}}" class="md:text-xl font-semibold dark:text-white">{{\Str::limit($recent_job->title,35)}}</a>
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
{{--        <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed justify-center items-center z-50 hidden h-[calc(100%-1rem)] max-h-full w-fit pr-3 md:w-full overflow-y-auto overflow-x-hidden bottom-0">--}}
            <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 w-full z-50 hidden h-[calc(100%-1rem)] max-h-full w-fit md:w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
            <div class="relative max-h-full w-full max-w-4xl rounded-xl  bg-white dark:bg-[#1E1E1E]" style="">
                <!-- Modal content -->
                <div class="relative rounded bg-white dark:bg-[#1E1E1E]" style="height:70vh; " >
                    <!-- Modal header -->
{{--                    <div class=" flex items-start justify-end rounded-t-xl p-5 pb-0 dark:border-gray-600">--}}

{{--                        <button type="button" class=" ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="modalEl">--}}
{{--                            <svg class="h-6 w-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">--}}
{{--                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />--}}
{{--                            </svg>--}}
{{--                            <span class="sr-only">Close modal</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}

                    <!-- Modal body -->
                        <div id="default-carousel" class="relative w-full" style="height:90%" data-carousel="static">
                            <!-- Carousel wrapper -->
                            <div class="relative overflow-hidden rounded-lg h-full">
                                @forelse($popups as $popup)
                                    @php
                                        $locale = \App::getLocale();

                                        if ($locale === 'en') {
                                            $title = $popup->title;
                                        } else {
                                            $translatedTitle = $popup->{'title_' . $locale} ?? null;
                                            $title = $translatedTitle ?: $popup->title;
                                        }
                                    @endphp
                                    <div class="hidden duration-700 ease-in-out overflow-y-auto mt-4" data-carousel-item>
                                        <div class="space-y-6 p-6 pt-0 rounded-b-xl">
                                            @if (!empty($title))
                                                <h2 class="text-xl font-bold mb-4 text-center dark:text-white">{{ $title }}</h2>
                                            @endif

                                            @if ($popup->image)
                                                <div class="flex justify-center w-full">
                                                    <img src="{{ asset('storage/' . $popup->image) }}" alt="Popup Image" class="rounded-lg mb-4">
                                                </div>
                                            @endif

                                            @if(!empty($popup->message))
                                                <div class="dark:text-white justify-center ">{!! $popup->message !!}</div>
                                            @endif
                                        </div>
                                    </div>

                                @empty
                                @endforelse
                            </div>
                            <!-- Slider indicators -->
                            <div class="absolute z-30 flex -translate-x-1/2 left-1/2 bottom-0 space-x-3 rtl:space-x-reverse">
                                @forelse($popups as $key => $popup)
                                <button type="button" class="w-3 h-3 rounded-full border " aria-current="true" aria-label="Slide {{$key}}" data-carousel-slide-to="{{$key}}"></button>
                                @empty
                                @endforelse
                            </div>
                            <!-- Slider controls -->
                            <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none text-gray-500 dark:text-white" data-carousel-prev>
                                <span class="inline-flex absolute bottom-0 left-4 items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none border">
                                    <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                                    </svg>
                                    <span class="sr-only">Previous</span>
                                </span>
                                                    </button>
                                                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none  text-gray-500 dark:text-white" data-carousel-next>
                                <span class="inline-flex absolute bottom-0 right-4 items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none border">
                                    <svg class="w-4 h-4 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                                    </svg>
                                    <span class="sr-only">Next</span>
                                </span>
                            </button>
                        </div>


                    <!-- Modal footer -->
{{--                    <div class="flex items-center space-x-2 rtl:space-x-reverse rounded-b-xl border-t border-gray-200 p-6 dark:border-gray-600 justify-end">--}}
{{--                        <button type="button" class="rounded-lg border border-gray-200 bg-white px-5 py-2.5 text-sm font-medium text-gray-500 hover:bg-gray-100 hover:text-gray-900 focus:z-10 focus:outline-none focus:ring-4 focus:ring-blue-300 dark:border-gray-500 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"> Close </button>--}}
{{--                    </div>--}}
                </div>
                <div class=" m-4 mt-1 flex justify-between items-center">
                    <div class="flex items-center justify-start">
                        <input id="dontShow" type="checkbox" class="mr-2">
                        <label for="dontShow" class="text-sm text-gray-700 dark:text-white"> {{trans('general.Do not open for one day')}}</label>
                    </div>
                    <div>
                        <button data-modal-hide="modalEl" type="button" class="text-white bg-gray-500 hover:bg-gray-600 focus:outline-none font-medium rounded-full text-sm sm:w-auto px-10 py-2.5 text-center">
                            {{trans('system.form.button.close')}}</button>
                    </div>
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
