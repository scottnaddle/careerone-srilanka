@extends('homepage.layouts.master')
@section('title', 'CareerOne - Sri Lanka')
@push('preload')
    <link rel="preload" as="image" href="{{asset('images/testnow.webp')}}">
@endpush

@section('content')
<div class="flex flex-col">
    {{-- ========================================
         1. BANNER CAROUSEL
    ======================================== --}}
    @include('homepage.partials.carousel')



    {{-- ========================================
         2. SECTORS
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
         3. PSYCHOLOGICAL TEST CTA
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
         4. RECENT JOBS
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
         5. NEWS & EVENTS
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
