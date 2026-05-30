@extends('homepage.layouts.master')
@section('title', 'CareerOne - Sri Lanka')
@push('preload')
    <link rel="preload" as="image" href="{{asset('images/testnow.webp')}}">
@endpush

@section('content')
<div class="flex flex-col">
    {{-- ========================================
         1. HERO SECTION
    ======================================== --}}
    <section class="relative bg-gradient-to-br from-slate-900 via-blue-950 to-indigo-950 overflow-hidden">
        {{-- Background pattern --}}
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-0 left-0 w-full h-full" style="background-image: radial-gradient(circle at 20% 80%, rgba(73,132,246,0.3) 0%, transparent 50%), radial-gradient(circle at 80% 20%, rgba(99,102,241,0.3) 0%, transparent 50%)"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 md:py-32">
            <div class="text-center max-w-3xl mx-auto">
                <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-sm border border-white/10 text-blue-200 text-sm mb-8">
                    <span class="w-2 h-2 rounded-full bg-green-400 animate-pulse"></span>
                    {{ __('general.Platform is now open to public') }}
                </div>

                <h1 class="text-4xl md:text-6xl lg:text-7xl font-bold text-white leading-tight mb-6">
                    {{ __('general.Connecting Competencies') }}<br>
                    <span class="bg-gradient-to-r from-blue-400 to-indigo-300 bg-clip-text text-transparent">{{ __('general.With Opportunities') }}</span>
                </h1>

                <p class="text-lg md:text-xl text-blue-200/80 mb-10 max-w-2xl mx-auto leading-relaxed">
                    {{ __('general.Sri Lanka premier career platform connecting trainees, companies, and guidance officers to build the future workforce.') }}
                </p>

                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="/choose-login"
                        class="inline-flex items-center justify-center px-8 py-4 bg-white text-slate-900 font-semibold rounded-full hover:bg-blue-50 transition-all duration-300 shadow-lg shadow-white/10">
                        {{ __('general.Get Started') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    </a>
                    <a href="/about-us"
                        class="inline-flex items-center justify-center px-8 py-4 border-2 border-white/20 text-white font-semibold rounded-full hover:bg-white/10 transition-all duration-300">
                        {{ __('general.Learn More') }}
                    </a>
                </div>
            </div>

            {{-- Stats row in hero --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mt-20 max-w-4xl mx-auto">
                <div class="text-center p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/5">
                    <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($stats['trainees'] ?? 0) }}+</div>
                    <div class="text-sm text-blue-300 mt-1">{{ __('general.Active Trainees') }}</div>
                </div>
                <div class="text-center p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/5">
                    <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($stats['companies'] ?? 0) }}+</div>
                    <div class="text-sm text-blue-300 mt-1">{{ __('general.Verified Companies') }}</div>
                </div>
                <div class="text-center p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/5">
                    <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($stats['jobs'] ?? 0) }}+</div>
                    <div class="text-sm text-blue-300 mt-1">{{ __('general.Active Jobs') }}</div>
                </div>
                <div class="text-center p-4 rounded-2xl bg-white/5 backdrop-blur-sm border border-white/5">
                    <div class="text-2xl md:text-3xl font-bold text-white">{{ number_format($stats['cgos'] ?? 0) }}+</div>
                    <div class="text-sm text-blue-300 mt-1">{{ __('general.Career Officers') }}</div>
                </div>
            </div>
        </div>

        {{-- Wave divider --}}
        <div class="absolute bottom-0 left-0 w-full">
            <svg viewBox="0 0 1440 100" fill="none" class="w-full h-auto"><path fill="rgb(249 250 251)" d="M0 50C240 100 480 0 720 50C960 100 1200 0 1440 50V100H0V50Z" class="dark:hidden"/><path fill="rgb(17 24 39)" d="M0 50C240 100 480 0 720 50C960 100 1200 0 1440 50V100H0V50Z" class="hidden dark:block"/></svg>
        </div>
    </section>

    {{-- ========================================
         2. WHO ARE YOU?
    ======================================== --}}
    <section class="bg-gray-50 dark:bg-gray-900 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('general.Who Are You?') }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('general.Choose your path and get started') }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 lg:gap-8">
                {{-- Trainee --}}
                <a href="{{ route('trainee.auth.login') }}" class="group relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-blue-500/10 rounded-bl-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center mb-5 group-hover:bg-blue-200 dark:group-hover:bg-blue-800/50 transition-colors">
                            <svg class="w-7 h-7 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.26 10.147a60.438 60.438 0 0 0-.491 6.347A48.62 48.62 0 0 1 12 20.904a48.62 48.62 0 0 1 8.232-4.41 60.46 60.46 0 0 0-.491-6.347m-15.482 0a50.636 50.636 0 0 0-2.658-.813A59.906 59.906 0 0 1 12 3.493a59.903 59.903 0 0 1 10.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.717 50.717 0 0 1 12 13.489"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.Trainee') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-4">{{ __('general.Find courses, jobs, and career guidance') }}</p>
                        <span class="inline-flex items-center text-blue-600 dark:text-blue-400 font-medium text-sm group-hover:gap-2 transition-all">
                            {{ __('general.Get Started') }} <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>

                {{-- Company --}}
                <a href="{{ route('company.auth.login') }}" class="group relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-green-500/10 rounded-bl-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-green-100 dark:bg-green-900/50 flex items-center justify-center mb-5 group-hover:bg-green-200 dark:group-hover:bg-green-800/50 transition-colors">
                            <svg class="w-7 h-7 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 21h16.5M4.5 3h15M5.25 3v18m13.5-18v18M9 6.75h1.5m-1.5 3h1.5m-1.5 3h1.5m3-6H15m-1.5 3H15m-1.5 3H15M9 21v-3.375c0-.621.504-1.125 1.125-1.125h3.75c.621 0 1.125.504 1.125 1.125V21"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.Company') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-4">{{ __('general.Post jobs, find skilled talent') }}</p>
                        <span class="inline-flex items-center text-green-600 dark:text-green-400 font-medium text-sm group-hover:gap-2 transition-all">
                            {{ __('general.Get Started') }} <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>

                {{-- CGO --}}
                <a href="{{ route('cgo.auth.login') }}" class="group relative bg-white dark:bg-gray-800 rounded-3xl p-8 shadow-lg hover:shadow-2xl transition-all duration-500 hover:-translate-y-2 border border-gray-100 dark:border-gray-700 overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-purple-500/10 rounded-bl-full -mr-8 -mt-8 group-hover:scale-150 transition-transform duration-500"></div>
                    <div class="relative">
                        <div class="w-14 h-14 rounded-2xl bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center mb-5 group-hover:bg-purple-200 dark:group-hover:bg-purple-800/50 transition-colors">
                            <svg class="w-7 h-7 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197"/></svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ __('general.CGO') }}</h3>
                        <p class="text-gray-500 dark:text-gray-400 text-sm leading-relaxed mb-4">{{ __('general.Guide trainees to success') }}</p>
                        <span class="inline-flex items-center text-purple-600 dark:text-purple-400 font-medium text-sm group-hover:gap-2 transition-all">
                            {{ __('general.Get Started') }} <svg class="w-4 h-4 ml-1 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </span>
                    </div>
                </a>
            </div>
        </div>
    </section>

    {{-- ========================================
         3. SECTORS
    ======================================== --}}
    @if(count($sectors) > 0)
    <section class="bg-white dark:bg-gray-950 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">{{ __('general.Explore by Sector') }}</h2>
                <p class="text-gray-500 dark:text-gray-400 text-lg">{{ __('general.Discover opportunities in your industry') }}</p>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($sectors as $sector)
                <a href="{{ $sector['url'] }}"
                    class="group flex items-center gap-4 p-5 rounded-2xl border border-gray-100 dark:border-gray-800 bg-gray-50 dark:bg-gray-900 hover:bg-blue-50 dark:hover:bg-blue-950 hover:border-blue-200 dark:hover:border-blue-800 transition-all duration-300">
                    <div class="w-12 h-12 rounded-xl bg-white dark:bg-gray-800 flex items-center justify-center shadow-sm group-hover:shadow-md transition-shadow">
                        <img src="{{ $sector['thumbnail'] }}" class="w-7 h-7" alt="{{ $sector['name'] }}">
                    </div>
                    <span class="font-semibold text-gray-900 dark:text-white">{{ $sector['name'] }}</span>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ========================================
         4. PSYCHOLOGICAL TEST CTA
    ======================================== --}}
    <section class="bg-gradient-to-r from-blue-600 to-indigo-700 py-16 md:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center gap-10">
                <div class="flex-1 text-white">
                    <h2 class="text-3xl md:text-4xl font-bold mb-4">{{ __('general.Occupational Psychological Test') }}</h2>
                    <p class="text-blue-100 text-lg leading-relaxed mb-8">{{ __('general.Career platform job psychology tests objectively measure various psychological characteristics such as individual abilities, interests, and personalities to help you understand yourself and help you choose a career field that is more suitable for your individual characteristics.') }}</p>
                    <a href="{{route('testnow.list')}}"
                        class="inline-flex items-center px-8 py-4 bg-white text-blue-700 font-semibold rounded-full hover:bg-blue-50 transition-all duration-300 shadow-lg">
                        {{ __('general.Test now') }}
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
                <div class="flex-shrink-0">
                    <img src="{{asset('images/testnow.webp')}}" alt="Career Test" class="w-64 md:w-80 rounded-3xl shadow-2xl">
                </div>
            </div>
        </div>
    </section>

    {{-- ========================================
         5. RECENT JOBS
    ======================================== --}}
    @if(count($recent_jobs) > 0)
    <section class="bg-gray-50 dark:bg-gray-900 py-16 md:py-24">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white">{{trans('system.recent_job')}}</h2>
                </div>
                <a href="{{ Auth::guard('company')->check() ? route('company.job-support.job-vacancy.list') : route('homepage.job-list') }}"
                    class="hidden sm:inline-flex items-center text-blue-600 dark:text-blue-400 font-medium hover:underline">
                    {{trans('system.action.view_more')}} <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @forelse($recent_jobs as $job)
                <a href="{{route('homepage.job-detail', ['job_id' => $job->id, 'slug' => $job->slug])}}"
                    class="group bg-white dark:bg-gray-800 rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden border border-gray-100 dark:border-gray-700">
                    <div class="relative h-40 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600 flex items-center justify-center">
                        <img src="{{ $job->company->logo ? asset($job->company->logo) : asset('uploads/logo_default.png') }}"
                            class="w-20 h-20 object-contain rounded-xl" alt="Company logo" loading="lazy">
                        <span class="absolute top-3 right-3 px-2.5 py-1 bg-white/90 dark:bg-gray-800/90 text-xs font-medium rounded-full text-gray-700 dark:text-gray-300">
                            {{ getCodeNameByCodeId('job_status', $job->status) }}
                        </span>
                    </div>
                    <div class="p-5">
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-2 line-clamp-2">{{ Str::limit($job->title, 40) }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-3">{{ Str::limit($job->company->name, 20) }}</p>
                        <div class="flex items-center justify-between text-xs text-gray-400 dark:text-gray-500">
                            <span>{{ convertDays($job->working_day) }}</span>
                            <span class="font-medium text-gray-700 dark:text-gray-300">{{ getCodeNameByCodeId('job_type', $job->job_type) }}</span>
                        </div>
                    </div>
                </a>
                @empty
                <p class="col-span-full text-center text-gray-500 py-12">{{ __('general.There is no recent job') }}</p>
                @endforelse
            </div>
        </div>
    </section>
    @endif

    {{-- ========================================
         6. NEWS & EVENTS
    ======================================== --}}
    @include('homepage.partials.news')

    {{-- Popup modal (kept from original) --}}
    @if(isset($popups) && count($popups) > 0)
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 w-full z-50 hidden h-[calc(100%-1rem)] max-h-full w-fit md:w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-4xl rounded-2xl bg-white dark:bg-gray-800">
            <div class="relative rounded bg-white dark:bg-gray-800" style="height:70vh">
                <div id="default-carousel" class="relative w-full" style="height:90%" data-carousel="static">
                    <div class="relative overflow-hidden rounded-lg h-full">
                        @forelse($popups as $popup)
                            @php
                                $locale = App::getLocale();
                                $title = ($locale === 'en') ? $popup->title : ($popup->{'title_' . $locale} ?? $popup->title);
                            @endphp
                            <div class="hidden duration-700 ease-in-out overflow-y-auto mt-4" data-carousel-item>
                                <div class="space-y-6 p-6 pt-0">
                                    @if (!empty($title))
                                        <h2 class="text-xl font-bold mb-4 text-center dark:text-white">{{ $title }}</h2>
                                    @endif
                                    @if ($popup->image)
                                        <div class="flex justify-center w-full">
                                            <img src="{{ asset('storage/' . $popup->image) }}" alt="Popup Image" class="rounded-lg mb-4">
                                        </div>
                                    @endif
                                    @if(!empty($popup->message))
                                        <div class="dark:text-white justify-center">{!! $popup->message !!}</div>
                                    @endif
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="absolute z-30 flex -translate-x-1/2 left-1/2 bottom-0 space-x-3">
                        @forelse($popups as $key => $popup)
                            <button type="button" class="w-3 h-3 rounded-full border" data-carousel-slide-to="{{$key}}"></button>
                        @empty
                        @endforelse
                    </div>
                    <button type="button" class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-prev>
                        <span class="inline-flex absolute bottom-0 left-4 items-center justify-center w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 hover:bg-white border shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 1 1 5l4 4"/></svg>
                        </span>
                    </button>
                    <button type="button" class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer" data-carousel-next>
                        <span class="inline-flex absolute bottom-0 right-4 items-center justify-center w-10 h-10 rounded-full bg-white/80 dark:bg-gray-800/80 hover:bg-white border shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 6 10"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"/></svg>
                        </span>
                    </button>
                </div>
            </div>
            <div class="m-4 mt-1 flex justify-between items-center">
                <div class="flex items-center justify-start">
                    <input id="dontShow" type="checkbox" class="mr-2">
                    <label for="dontShow" class="text-sm text-gray-700 dark:text-white">{{trans('general.Do not open for one day')}}</label>
                </div>
                <div>
                    <button data-modal-hide="modalEl" type="button"
                        class="text-white bg-gray-500 hover:bg-gray-600 font-medium rounded-full text-sm px-10 py-2.5 text-center">
                        {{trans('system.form.button.close')}}
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const $targetEl = document.getElementById('modalEl');
        const modal = new Modal($targetEl, { placement: 'center-center', backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40', closable: true });
        const hideUntil = localStorage.getItem('popupHideUntil');
        if (!hideUntil || new Date(hideUntil) < new Date()) modal.show();
        const checkbox = document.getElementById('dontShow');
        if (checkbox) checkbox.addEventListener('change', () => {
            if (checkbox.checked) { const tomorrow = new Date(); tomorrow.setDate(tomorrow.getDate() + 1); localStorage.setItem('popupHideUntil', tomorrow.toISOString()); }
            else localStorage.removeItem('popupHideUntil');
        });
    });
    </script>
    @endif
</div>
@endsection
