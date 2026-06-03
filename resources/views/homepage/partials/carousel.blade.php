<div id="carousel-web" class="hidden md:block">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-xl sm:h-[25rem] md:h-[27rem] lg:h-[30rem] xl:h-[39rem]">
            <!-- Item 1 -->
            @forelse($banners as $key => $banner)
                @push('preload')
                    <link rel="preload" as="image" href="{{$banner->bannerImage->original_url ?? ''}}">
                @endpush
                <div class="hidden duration-4000 ease-in-out" @if($key == 0) data-carousel-item="active" @else data-carousel-item @endif>
                    <img src="{{$banner->bannerImage->original_url ?? ''}}" @if($key ==0) loading="eager" @else loading="lazy" @endif class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 h-full" alt="...">
                    <div class="absolute md:top-[130px] md:left-16 flex flex-col gap-4 w-1/2">
                        {{--                <p class="text-black md:text-5xl font-medium">Welcome to </p>--}}
                        <p class="text-primary md:text-5xl font-bold">{!! $banner->title !!}</p>
                        <p class="text-[#706F81] text-base md:text-lg">{!! $banner->description !!}</p>
                    </div>
                </div>
            @empty
            @endif

        </div>

        <!-- Slider controls -->
        <button type="button" class="absolute pb-8 top-0 start-0 z-30 flex items-end justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>
                <span class="inline-flex items-center border border-white justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>
                    </svg>
                    <span class="sr-only">Previous</span>
                </span>
        </button>
        <button type="button" class="absolute pb-8 top-0 end-0 z-30 flex items-end justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>
                <span class="inline-flex border border-white items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-800/30 group-hover:bg-white/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">
                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>
                    </svg>
                    <span class="sr-only">Next</span>
                </span>
        </button>
        <!-- Slider indicators -->
        <div class="absolute z-30 flex flex-col  top-[40%] right-0 rtl:space-x-reverse gap-4 mr-8">
            @foreach($banners as $key => $banner)
                <button type="button" class="w-4 h-4 rounded-full desk-indicator" aria-current="true" aria-label="Slide {{$key+1}}" data-carousel-slide-to="{{$key+1}}"></button>
            @endforeach
        </div>
        <div class="w-full relative flex justify-center z-40">
            @if(activeGuard() == '')
                <div class="absolute -top-24 flex flex-col rounded-xl bg-white dark:bg-[#1E1E1E] w-[50%]  py-8 shadow-custom-light dark:shadow-custom-dark">
                    <p class="text-xl text-black dark:text-white font-semibold text-center pb-4">{{ __('general.User Manual') }}</p>
                    <div class="grid grid-cols-3">
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="/guideline#trainee"><img src="{{asset('images/1.webp')}}" alt="Trainee" class="w-28 h-28 rounded-full p-6 border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                            <a href="/guideline#trainee" class="text-center"><span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">{{ __('general.Trainee') }}</span></a>
                        </div>
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="/guideline#cgo"><img src="{{asset('images/2.webp')}}" alt="CGO" class="w-28 h-28 rounded-full p-6 border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                            <a href="/guideline#cgo" class="text-center"><span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">{{ __('general.CGO') }}</span></a>
                        </div>
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="/guideline#company"><img src="{{asset('images/3.webp')}}" alt="Company" class="w-28 h-28 rounded-full p-6 border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                            <a href="/guideline#company" class="text-center"><span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">{{ __('general.Company/ Other organisation') }}</span></a>
                        </div>
                    </div>

                </div>
            @elseif(activeGuard() == 'trainee')
                <div class="absolute -top-24 flex flex-col rounded-xl bg-white dark:bg-[#1E1E1E] w-[50%] py-8 shadow-custom-light dark:shadow-custom-dark">
                    <p class="text-xl text-black dark:text-white font-semibold text-center pb-4">{{ __('general.Favourited Service') }}</p>
                    <div class="grid grid-cols-3">
                        <!-- Guidance -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/guidance.webp') }}" alt="Guidance Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('trainee.career-guidance.counseling.counseling-history') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Guidance') }}
                                </span>
                            </a>
                        </div>
                        <!-- Portfolio -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.career-guidance.portfolio.get-portfolio') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/portfolio.webp') }}" alt="Portfolio Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('trainee.career-guidance.portfolio.get-portfolio') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Portfolio') }}
                                </span>
                            </a>
                        </div>
                        <!-- Job Post List -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.job-support.job-list.job-list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/job-post-list.webp') }}" alt="Job Post List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('trainee.job-support.job-list.job-list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Job post list') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @elseif(activeGuard() == 'cgo')
                <div class="absolute -top-24 flex flex-col rounded-xl bg-white dark:bg-[#1E1E1E] w-[50%] py-8 shadow-custom-light dark:shadow-custom-dark">
                    <p class="text-xl text-black dark:text-white font-semibold text-center pb-4">{{ __('general.Favourited Service') }}</p>
                    <div class="grid grid-cols-3">
                        <!-- Guidance -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/guidance.webp') }}" alt="Guidance Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('cgo.career-guidance.counseling.counseling-list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Guidance') }}
                                </span>
                            </a>
                        </div>
                        <!-- Trainee List -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('cgo.job-support.trainee-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/trainee-list.webp') }}" alt="Trainee List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('cgo.job-support.trainee-list.list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Trainee list') }}
                                </span>
                            </a>
                        </div>
                        <!-- Event -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('informations.events.event') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/event.webp') }}" alt="Event Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('informations.events.event') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Event') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @elseif(activeGuard() == 'company')
                <div class="absolute -top-24 flex flex-col rounded-xl bg-white dark:bg-[#1E1E1E] w-[50%] py-8 shadow-custom-light dark:shadow-custom-dark">
                    <p class="text-xl text-black dark:text-white font-semibold text-center pb-4">
                        {{ __('general.Favourited Service') }}
                    </p>
                    <div class="grid grid-cols-3">
                        <!-- Job Vacancy -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.job-vacancy.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/job-vacancy.webp') }}" alt="Job Vacancy Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('company.job-support.job-vacancy.list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Job vacancy') }}
                                </span>
                            </a>
                        </div>
                        <!-- OJT -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.ojt-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/ojt.webp') }}" alt="OJT Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('company.job-support.ojt-list.list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.OJT') }}
                                </span>
                            </a>
                        </div>
                        <!-- Trainee List -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.trainee-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/trainee-list.webp') }}" alt="Trainee List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a class="text-center" href="{{ route('company.job-support.trainee-list.list') }}">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Trainee list') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>

            @endif
        </div>
    </div>
</div>
<div id="carousel-mobile" class="block md:hidden">
    <div id="default-carousel" class="relative w-full" data-carousel="slide">
        <!-- Carousel wrapper -->
        <div class="relative h-48 sm:h-[25rem] md:h-[27rem] lg:h-[30rem] overflow-hidden rounded-xl xl:h-[39rem]">
            <!-- Item 1 -->
            @forelse($banners as $key => $banner)
                @push('preload')
                    <link rel="preload" as="image" href="{{$banner->bannerImage->original_url ?? ''}}">
                @endpush
                <div class="hidden duration-4000 ease-in-out"  @if($key == 0) data-carousel-item="active" @else data-carousel-item @endif>
                    <img src="{{$banner->bannerImage->original_url ?? ''}}" @if($key == 0) loading="eager" @else loading="lazy" @endif class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2 h-full" alt="...">
                    <div class=" flex flex-col gap-2 h-full absolute pt-4 pl-4">
                        {{--                <p class="text-black font-medium text-sm">Welcome to </p>--}}
                        <p class="text-primary text-xl font-bold  w-1/2">{!! $banner->title !!}</p>
                        <p class="text-[#706F81] text-xs w-2/3">{!! $banner->description !!}</p>
                    </div>
                </div>
            @empty
            @endif
            {{--        <!-- Item 2 -->--}}
            {{--        <div class="hidden duration-4000 ease-in-out" data-carousel-item>--}}
            {{--            <img src="{{asset('images/woman-mobile.png')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">--}}
            {{--            <div class=" flex flex-col gap-2 h-full absolute w-1/2 pt-6 pl-6">--}}
            {{--                <p class="text-black font-medium text-sm">Welcome to </p>--}}
            {{--                <p class="text-primary text-2xl font-bold leading-9">TVET Career <br> Platform</p>--}}
            {{--                <p class="text-[#706F81] text-xs">Technical and Vocational Education Training</p>--}}
            {{--            </div>--}}
            {{--        </div>--}}
            {{--        <!-- Item 3 -->--}}
            {{--        <div class="hidden duration-4000 ease-in-out" data-carousel-item>--}}
            {{--            <img src="{{asset('images/woman-mobile.png')}}" class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2" alt="...">--}}
            {{--            <div class=" flex flex-col gap-2 h-full absolute w-1/2 pt-6 pl-6">--}}
            {{--                <p class="text-black font-medium text-sm">Welcome to </p>--}}
            {{--                <p class="text-primary text-2xl font-bold leading-9">TVET Career <br> Platform</p>--}}
            {{--                <p class="text-[#706F81] text-xs">Technical and Vocational Education Training</p>--}}
            {{--            </div>--}}
            {{--        </div>--}}
        </div>
        <!-- Slider indicators -->

        <div class=" z-30 gap-2 flex justify-center mt-4">
            @foreach($banners as $key => $banner)
                <button type="button" class="w-4 h-1 bg-gray-100 indicator rounded" aria-current="true" aria-label="Slide {{$key+1}}" data-carousel-slide-to="{{$key+1}}"></button>
            @endforeach

        </div>
        <!-- Slider controls -->
        {{--    <button type="button" class="absolute pb-8 top-0 start-0 z-30 flex items-end justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-prev>--}}
        {{--                <span class="inline-flex items-center border border-white justify-center w-10 h-10 rounded-full bg-white dark:bg-[#1E1E1E]/30 dark:bg-gray-800/30 group-hover:bg-white dark:bg-[#1E1E1E]/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">--}}
        {{--                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">--}}
        {{--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/>--}}
        {{--                    </svg>--}}
        {{--                    <span class="sr-only">Previous</span>--}}
        {{--                </span>--}}
        {{--    </button>--}}
        {{--    <button type="button" class="absolute pb-8 top-0 end-0 z-30 flex items-end justify-center h-full px-4 cursor-pointer group focus:outline-none" data-carousel-next>--}}
        {{--                <span class="inline-flex border border-white items-center justify-center w-10 h-10 rounded-full bg-white dark:bg-[#1E1E1E]/30 dark:bg-gray-800/30 group-hover:bg-white dark:bg-[#1E1E1E]/50 dark:group-hover:bg-gray-800/60 group-focus:ring-4 group-focus:ring-white dark:group-focus:ring-gray-800/70 group-focus:outline-none">--}}
        {{--                    <svg class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">--}}
        {{--                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/>--}}
        {{--                    </svg>--}}
        {{--                    <span class="sr-only">Next</span>--}}
        {{--                </span>--}}
        {{--    </button>--}}
        @if(activeGuard() == '')
            <div class="w-full z-40 pt-6">
                <p class="text-lg font-semibold dark:text-white">{{ __('general.User Manual') }}</p>
                <div class="flex rounded-xl bg-white dark:bg-[#1E1E1E] justify-around gap-4 mt-4 py-4 justify-between items-center">
                    <div class="flex flex-col gap-2.5 items-center">
                        <a href="/guideline#trainee"><img src="{{asset('images/1.webp')}}" alt="" class="w-28 object-cover p-6 rounded-full border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                        <a href="/guideline#trainee"><span class="text-sm text-[#464559] font-semibold dark:text-white">{{ __('general.Trainee') }}</span></a>
                    </div>
                    <div class="flex flex-col gap-2.5 items-center">
                        <a href="/guideline#cgo"><img src="{{asset('images/2.webp')}}" alt="" class="w-28 object-cover p-6 rounded-full border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                        <a href="/guideline#cgo"><span class="text-sm text-[#464559] font-semibold dark:text-white">{{ __('general.CGO') }}</span></a>
                    </div>
                    <div class="flex flex-col gap-2.5 items-center">
                        <a href="/guideline#company"><img src="{{asset('images/3.webp')}}" alt="" class="w-28 object-cover p-6 rounded-full border-1 border-[#F3F8FF] bg-[#EAF3FF]"></a>
                        <a href="/guideline#company"><span class="text-sm text-[#464559] font-semibold dark:text-white">{{ __('general.Company') }}</span></a>
                    </div>
                </div>
            </div>
        @elseif(activeGuard() == 'trainee')
            <div class="w-full z-40 py-6">
                <p class="text-lg font-semibold dark:text-white text-center">{{ __('general.Favourited Service') }}</p>
                <div class="flex rounded-xl bg-white dark:bg-[#1E1E1E] justify-around gap-4 mt-4 py-4 justify-between items-center">
                    <div class="grid grid-cols-3">
                        <!-- Guidance -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/guidance.svg') }}" alt="Guidance Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Guidance') }}
                                </span>
                            </a>
                        </div>
                        <!-- Portfolio -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.career-guidance.portfolio.get-portfolio') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/portfolio.svg') }}" alt="Portfolio Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('trainee.career-guidance.portfolio.get-portfolio') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Portfolio') }}
                                </span>
                            </a>
                        </div>
                        <!-- Job Post List -->
                        <div class="flex flex-col gap-2.5 items-center">
                            <a href="{{ route('trainee.job-support.job-list.job-list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/job-post-list.svg') }}" alt="Job Post List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('trainee.job-support.job-list.job-list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Job post list') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(activeGuard() == 'cgo')
            <div class="w-full z-40 py-6">
                <p class="text-lg font-semibold dark:text-white">{{ __('general.Favourited Service') }}</p>
                <div class="flex rounded-xl bg-white dark:bg-[#1E1E1E] justify-around gap-4 mt-4 py-4 justify-between items-center">
                    <div class="grid grid-cols-3">
                        <!-- Guidance -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/guidance.svg') }}" alt="Guidance Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Guidance') }}
                                </span>
                            </a>
                        </div>
                        <!-- Trainee List -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('cgo.job-support.trainee-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/trainee-list.svg') }}" alt="Trainee List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('cgo.job-support.trainee-list.list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Trainee list') }}
                                </span>
                            </a>
                        </div>
                        <!-- Event -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('informations.events.event') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/event.svg') }}" alt="Event Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('informations.events.event') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Event') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @elseif(activeGuard() == 'company')
            <div class="w-full z-40 py-6">
                <p class="text-lg font-semibold dark:text-white">{{ __('general.Favourited Service') }}</p>
                <div class="flex rounded-xl bg-white dark:bg-[#1E1E1E] justify-around gap-4 mt-4 py-4 justify-between items-center">
                    <div class="grid grid-cols-3">
                        <!-- Job Vacancy -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.job-vacancy.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/job-vacancy.svg') }}" alt="Job Vacancy Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('company.job-support.job-vacancy.list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Job vacancy') }}
                                </span>
                            </a>
                        </div>
                        <!-- OJT -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.ojt-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/ojt.svg') }}" alt="OJT Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('company.job-support.ojt-list.list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.OJT') }}
                                </span>
                            </a>
                        </div>
                        <!-- Trainee List -->
                        <div class="flex flex-col gap-2 items-center">
                            <a href="{{ route('company.job-support.trainee-list.list') }}">
                                <div class="relative flex items-center justify-center w-28 h-28 rounded-full bg-[#EAF3FF]">
                                    <div class="absolute w-24 h-24 rounded-full bg-[#F3F8FF]"></div>
                                    <img src="{{ asset('images/trainee-list.svg') }}" alt="Trainee List Icon" class="relative z-10 w-12 h-12">
                                </div>
                            </a>
                            <a href="{{ route('company.job-support.trainee-list.list') }}" class="text-center">
                                <span class="text-lg text-[#464559] dark:text-white font-semibold hover:text-primary">
                                    {{ __('general.Trainee list') }}
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

</div>
