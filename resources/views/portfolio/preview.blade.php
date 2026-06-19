<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portfolio - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <base href="{{ asset('/') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css'])
    <style>
        body {
            font-family: 'Outfit', sans-serif;
        }
        .no-break {
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .-start-1\.5 {
            inset-inline-start: -0.313rem;
        }
        @media print {
            .no-print {
                display: none !important;
            }
            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .supporting-docs-section {
                page-break-before: always !important;
                break-before: page !important;
            }
        }
    </style>
</head>
@php
$careerFieldsMapping = [
    'A' => ['name' => '(A) Agriculture, Hunting & Forestry', 'icon' => '🌾'],
    'B' => ['name' => '(B) Fishing', 'icon' => '🎣'],
    'C' => ['name' => '(C) Mining & Quarrying', 'icon' => '⛏️'],
    'D' => ['name' => '(D) Manufacturing', 'icon' => '🏭'],
    'E' => ['name' => '(E) Electricity, Gas & Water', 'icon' => '⚡'],
    'F' => ['name' => '(F) Construction', 'icon' => '🏗️'],
    'G' => ['name' => '(G) Wholesale & Retail Trade', 'icon' => '🛒'],
    'H' => ['name' => '(H) Hotels & Restaurants', 'icon' => '🏨'],
    'I' => ['name' => '(I) Transport, Storage & Communication', 'icon' => '🚚'],
    'J' => ['name' => '(J) Financial Intermediation', 'icon' => '💰'],
    'K' => ['name' => '(K) Real Estate & Business Activities', 'icon' => '🏢'],
    'L' => ['name' => '(L) Public Administration', 'icon' => '🏛️'],
    'M' => ['name' => '(M) Education', 'icon' => '📚'],
    'N' => ['name' => '(N) Health & Social Work', 'icon' => '🏥'],
    'O' => ['name' => '(O) Other Community Services', 'icon' => '🤝'],
    'P' => ['name' => '(P) Private Households', 'icon' => '🏠'],
    'Q' => ['name' => '(Q) Extra-territorial Organizations', 'icon' => '🌐'],
    'ICT' => ['name' => 'Information & Communication Technology', 'icon' => '💻'],
];

if (!function_exists('formatPortfolioDate')) {
    function formatPortfolioDate($dateStr, $format = "M Y") {
        if (empty($dateStr)) {
            return '';
        }
        $timestamp = strtotime($dateStr);
        if ($timestamp === false || $timestamp < 0) {
            return '';
        }
        return date($format, $timestamp);
    }
}

if (!function_exists('formatPortfolioDateRange')) {
    function formatPortfolioDateRange($from, $to, $format = "M Y") {
        $fromFormatted = formatPortfolioDate($from, $format);
        $toFormatted = formatPortfolioDate($to, $format);
        
        if (empty($fromFormatted) && empty($toFormatted)) {
            return '';
        }
        
        if (!empty($fromFormatted) && empty($toFormatted)) {
            return $fromFormatted . ' - ' . __('Present');
        }
        
        if (empty($fromFormatted) && !empty($toFormatted)) {
            return $toFormatted;
        }
        
        return $fromFormatted . ' - ' . $toFormatted;
    }
}
@endphp
<body class="mx-auto p-3 bg-white xl:bg-[#F5F7FA] md:p-4 xl:p-0 dark:bg-[#282828]">
<div class="h-16 bg-[#323B49] sticky top-0 w-full flex items-center z-10 px-6 rounded-t no-print shadow-md border-b border-[#434F61]">
    <div class="mx-auto max-w-[1200px] flex justify-between items-center w-full">
        <span class="text-white/80 font-bold text-sm tracking-widest uppercase flex items-center gap-2">
            <svg class="w-5 h-5 text-[#4984F6]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            Candidate Portfolio
        </span>
        <div class="flex justify-end gap-3 items-center">
            <a href="{{route('trainee.career-guidance.portfolio.export-portfolio',['pid' => $portfolio->id, 'lang' => app()->getLocale() ?? 'en'])}}" target="_blank" class="flex items-center gap-2 px-4 py-1.5 bg-white/10 hover:bg-white/20 border border-white/20 rounded-full text-white text-[13px] font-semibold transition-all duration-300 shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"></path>
                </svg>
                <span>Export PDF</span>
            </a>
            @if(auth('trainee')->check())
            <a href="{{route('trainee.career-guidance.portfolios.edit')}}" class="flex items-center gap-2 px-4 py-1.5 bg-[#4984F6] hover:bg-blue-600 rounded-full text-white text-[13px] font-semibold transition-all duration-300 shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10"></path>
                </svg>
                <span>Edit Portfolio</span>
            </a>
            @endif
        </div>
    </div>
</div>

    <div class="max-w-[1200px] mx-auto bg-white dark:bg-[#1E1E1E] my-6 rounded-xl shadow-md overflow-hidden border border-gray-200 dark:border-gray-800">
        
        <!-- Header Section (Dark Slate Background) -->
        <div class="bg-[#323B49] dark:bg-[#202731] text-white px-8 py-12 flex flex-col md:flex-row items-center relative">
            <div class="md:ml-[33.33%] pl-0 md:pl-16 text-center md:text-left">
                <h1 class="text-3xl md:text-5xl font-extrabold tracking-wide uppercase text-white mb-2">{{$portfolioDatas['basic_information']['fullname'] ?? ''}}</h1>
                <p class="text-sm md:text-lg tracking-widest uppercase text-gray-300 font-medium">{{$portfolioDatas['headline'] ?? $portfolioDatas['summary'] ?? ''}}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3">
            
            <!-- Left Column (Sidebar, Light Gray Background) -->
            <div class="md:col-span-1 bg-[#EBEBEB] dark:bg-[#2A2A2A] border-r border-gray-200 dark:border-gray-800 px-6 pb-8 md:px-8 relative">
                
                <!-- Avatar Overlapping Header -->
                <div class="flex justify-center mb-6 relative mt-[-90px] md:mt-[-110px] z-20">
                    <div class="w-44 h-44 md:w-52 md:h-52 rounded-full bg-gray-100 overflow-hidden border-[6px] border-white dark:border-[#2A2A2A] shadow-lg">
                        <img src="{{$portfolioDatas['avatar'] ?? 'https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&ixlib=rb-1.2.1&auto=format&fit=crop&w=2000&q=80'}}" class="w-full h-full object-cover" alt="Avatar">
                    </div>
                </div>

                <div class="mb-6"></div>

                <!-- CONTACT Section -->
                <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-700">
                    <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase pb-2 border-b-2 border-[#323B49] dark:border-gray-600 mb-4">CONTACT</h2>
                    <div class="space-y-4">
                        <div class="flex items-center gap-3">
                            <svg class="w-[18px] h-[18px] text-[#323B49] dark:text-gray-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path></svg>
                            <span class="text-[14px] font-medium text-gray-700 dark:text-gray-200">{{$portfolioDatas['basic_information']['phone'] ?? ''}}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-[18px] h-[18px] text-[#323B49] dark:text-gray-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                            <span class="text-[14px] font-medium text-gray-700 dark:text-gray-200 break-all">{{$portfolioDatas['basic_information']['email'] ?? ''}}</span>
                        </div>
                        <div class="flex items-center gap-3">
                            <svg class="w-[18px] h-[18px] text-[#323B49] dark:text-gray-300 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path></svg>
                            <span class="text-[14px] font-medium text-gray-700 dark:text-gray-200">{{$portfolioDatas['basic_information']['district'] ?? ''}}</span>
                        </div>
                    </div>
                </div>

                <!-- CAREER GOALS Section -->
                @if(!empty($portfolioDatas['short_term_goals']) || !empty($portfolioDatas['long_term_goals']))
                <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-700 no-break">
                    <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase pb-2 border-b-2 border-[#323B49] dark:border-gray-600 mb-4">{{trans('portfolio.Career Goals')}}</h2>
                    <div class="flex flex-col gap-4">
                        @if(!empty($portfolioDatas['short_term_goals']))
                        <div class="bg-white/60 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h3 class="font-bold text-[#323B49] dark:text-blue-300 mb-1.5 flex items-center gap-2 text-[14px]">
                                <svg class="w-4 h-4 text-[#323B49] dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                {{trans('portfolio.Short-term Goals')}}
                            </h3>
                            <p class="text-[13px] text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{$portfolioDatas['short_term_goals']}}</p>
                        </div>
                        @endif
                        
                        @if(!empty($portfolioDatas['long_term_goals']))
                        <div class="bg-white/60 dark:bg-gray-800 rounded-xl p-4 border border-gray-200 dark:border-gray-700">
                            <h3 class="font-bold text-[#323B49] dark:text-blue-300 mb-1.5 flex items-center gap-2 text-[14px]">
                                <svg class="w-4 h-4 text-[#323B49] dark:text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                                {{trans('portfolio.Long-term Goals')}}
                            </h3>
                            <p class="text-[13px] text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">{{$portfolioDatas['long_term_goals']}}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- SKILLS Section -->
                <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-700 no-break">
                    <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase pb-2 border-b-2 border-[#323B49] dark:border-gray-600 mb-4">{{trans('portfolio.Skills')}}</h2>
                    <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 text-sm space-y-2">
                        @forelse($portfolioDatas['technical_skills'] ?? [] as $skill)
                        <li>
                            <span class="font-semibold text-gray-800 dark:text-gray-200">{{$skill['name'] ?? ''}}</span>
                        </li>
                        @empty
                        @endforelse
                    </ul>
                </div>

                <!-- LANGUAGES Section -->
                <div class="mb-6 pb-6 border-b border-gray-300 dark:border-gray-700 no-break">
                    <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase pb-2 border-b-2 border-[#323B49] dark:border-gray-600 mb-4">{{trans('portfolio.Language')}}</h2>
                    <ul class="list-disc pl-5 text-gray-700 dark:text-gray-300 text-sm space-y-2">
                        @forelse($portfolioDatas['languages'] ?? [] as $lang)
                        <li class="font-semibold text-gray-800 dark:text-gray-200">{{$lang}}</li>
                        @empty
                        @endforelse
                    </ul>
                </div>

                <!-- REFERENCES Section -->
                @if(!empty($portfolioDatas['references']))
                <div class="no-break mt-6">
                    <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase pb-2 border-b-2 border-[#323B49] dark:border-gray-600 mb-4">{{trans('portfolio.References')}}</h2>
                    <div class="space-y-4">
                        @foreach($portfolioDatas['references'] as $ref)
                        <div>
                            <h3 class="font-bold text-gray-800 dark:text-gray-200 text-sm">{{$ref['name'] ?? ''}}</h3>
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{$ref['title'] ?? ''}}</p>
                            @if(!empty($ref['company']))
                            <p class="text-xs text-gray-600 dark:text-gray-400">{{$ref['company']}}</p>
                            @endif
                            @if(!empty($ref['phone']))
                            <p class="text-xs text-gray-500 dark:text-gray-400">Phone: {{$ref['phone']}}</p>
                            @endif
                            @if(!empty($ref['email']))
                            <p class="text-xs text-gray-500 dark:text-gray-400">Email: {{$ref['email']}}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- Right Column (Timeline Content, White Background) -->
            <div class="md:col-span-2 bg-white dark:bg-[#1E1E1E] pl-10 pr-6 md:pl-16 md:pr-12 py-12 relative">
                
                <!-- Timeline Vertical Line (Spans all sections) -->
                <div class="absolute left-[28px] md:left-[36px] top-[60px] bottom-[60px] w-0.5 bg-gray-200 dark:bg-gray-800 z-0"></div>

                <!-- Section: PROFILE -->
                @if(!empty($portfolioDatas['about_me']))
                <div class="relative mb-10 z-10 no-break">
                    <!-- Icon Circle -->
                    <div class="absolute left-[-28px] md:left-[-48px] top-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#323B49] text-white flex items-center justify-center z-20">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-4 pl-4 md:pl-0">
                        <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase shrink-0">{{trans('portfolio.About me')}}</h2>
                        <div class="flex-grow h-[1px] bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    <p class="text-gray-600 dark:text-gray-300 text-[14px] leading-relaxed whitespace-pre-line">{{$portfolioDatas['about_me']}}</p>
                </div>
                @endif

                <!-- Section: CAREER INTERESTS -->
                @if(!empty($portfolioDatas['career_interests']['career_fields']))
                <div class="relative mb-10 z-10 no-break">
                    <!-- Icon Circle -->
                    <div class="absolute left-[-28px] md:left-[-48px] top-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#323B49] text-white flex items-center justify-center z-20">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M5 4a1 1 0 00-2 0v7.268a2 2 0 000 3.464V16a1 1 0 102 0v-1.268a2 2 0 000-3.464V4zM11 4a1 1 0 10-2 0v1.268a2 2 0 000 3.464V16a1 1 0 102 0V8.732a2 2 0 000-3.464V4zM16 3a1 1 0 011-1v7.268a2 2 0 010 3.464V16a1 1 0 11-2 0v-1.268a2 2 0 010-3.464V4a1 1 0 011-1z"></path></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-6 pl-4 md:pl-0">
                        <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase shrink-0">{{trans('portfolio.Career Fields of Interest')}}</h2>
                        <div class="flex-grow h-[1px] bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    
                    <div class="relative pl-6">
                        <!-- Small Circle on Timeline Line -->
                        <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                        
                        <div class="flex flex-wrap gap-3">
                            @foreach($portfolioDatas['career_interests']['career_fields'] as $fieldCode)
                                @if(isset($careerFieldsMapping[$fieldCode]))
                                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-800 dark:text-gray-200 text-xs font-semibold border border-gray-200 dark:border-gray-700">
                                    <span class="text-sm">{{ $careerFieldsMapping[$fieldCode]['icon'] }}</span>
                                    {{ $careerFieldsMapping[$fieldCode]['name'] }}
                                </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif

                <!-- Section: EXPERIENCE -->
                @if(!empty($portfolioDatas['experiences']) || !empty($portfolioDatas['ojt_experiences']))
                <div class="relative mb-10 z-10">
                    <!-- Icon Circle -->
                    <div class="absolute left-[-28px] md:left-[-48px] top-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#323B49] text-white flex items-center justify-center z-20">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd"></path><path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.86 24.86 0 0110 15a24.86 24.86 0 01-8-1.308z"></path></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-6 pl-4 md:pl-0">
                        <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase shrink-0">{{trans('portfolio.Experience')}}</h2>
                        <div class="flex-grow h-[1px] bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($portfolioDatas['experiences'] ?? [] as $work)
                        <div class="relative pl-6 mb-6 no-break">
                            <!-- Small Circle on Timeline Line -->
                            <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-1">
                                <h3 class="font-bold text-[#323B49] dark:text-gray-100 text-[15px]">{{$work['company'] ?? ''}}</h3>
                                <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ formatPortfolioDateRange($work['start_date'] ?? '', $work['end_date'] ?? '', 'M Y') }}</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 font-semibold mb-1">{{$work['job_title'] ?? ''}}</p>
                            @if(!empty($work['description']))
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{$work['description']}}</p>
                            @endif
                        </div>
                        @endforeach

                        @foreach($portfolioDatas['ojt_experiences'] ?? [] as $ojt)
                        <div class="relative pl-6 mb-6 no-break">
                            <!-- Small Circle on Timeline Line -->
                            <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-1">
                                <h3 class="font-bold text-[#323B49] dark:text-gray-100 text-[15px]">{{$ojt['organization'] ?? ''}}</h3>
                                <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ formatPortfolioDateRange($ojt['from'] ?? '', $ojt['to'] ?? '', 'M Y') }}</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 font-semibold mb-1">{{$ojt['title'] ?? ''}} ({{trans('portfolio.OJT Experience')}})</p>
                            @if(!empty($ojt['description']))
                            <p class="text-[13px] text-gray-500 dark:text-gray-400 leading-relaxed whitespace-pre-line">{{$ojt['description']}}</p>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Section: EDUCATION -->
                @if(!empty($portfolioDatas['tvec_educations']) || !empty($portfolioDatas['educations']))
                <div class="relative mb-10 z-10">
                    <!-- Icon Circle -->
                    <div class="absolute left-[-28px] md:left-[-48px] top-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#323B49] text-white flex items-center justify-center z-20">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.986 8.986 0 00-2.308-1.543 1 1 0 00-.866 1.8 10.986 10.986 0 013.174 2.122 1 1 0 001.393.003l1.8-1.696A1 1 0 007.8 13.06l-.8-.8v-2.14l3-.833 3 .833v2.14l-.8.8a1 1 0 00.1 1.443l1.8 1.696a1 1 0 001.393-.003 10.986 10.986 0 013.174-2.122 1 1 0 00-.866-1.8 8.986 8.986 0 00-2.308 1.543V10.12l1.69-1.026a1 1 0 00.56-.9v-1.74a1 1 0 00-1-1h-6.24L10.39 2.08z"></path></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-6 pl-4 md:pl-0">
                        <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase shrink-0">{{trans('portfolio.Education')}}</h2>
                        <div class="flex-grow h-[1px] bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($portfolioDatas['tvec_educations'] ?? [] as $tvec)
                        <div class="relative pl-6 mb-6 no-break">
                            <!-- Small Circle on Timeline Line -->
                            <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-1">
                                <h3 class="font-bold text-[#323B49] dark:text-gray-100 text-[15px]">{{$tvec['course_name'] ?? ''}}</h3>
                                <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ formatPortfolioDateRange($tvec['from'] ?? '', $tvec['to'] ?? '', 'M Y') }}</span>
                            </div>
                            <p class="text-[12px] text-gray-600 dark:text-gray-400 font-medium">
                                <strong>{{$tvec['institute'] ?? ''}}</strong>
                                @if(!empty($tvec['industry_sector']))
                                 | {{trans('portfolio.Industry sector')}}: {{$tvec['industry_sector']}}
                                @endif
                            </p>
                        </div>
                        @endforeach

                        @foreach($portfolioDatas['educations'] ?? [] as $edu)
                        <div class="relative pl-6 mb-6 no-break">
                            <!-- Small Circle on Timeline Line -->
                            <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-1">
                                <h3 class="font-bold text-[#323B49] dark:text-gray-100 text-[15px]">{{$edu['field'] ?? ''}}</h3>
                                <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ formatPortfolioDateRange($edu['from'] ?? '', $edu['to'] ?? '', 'M Y') }}</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 font-medium">{{$edu['school_name'] ?? ''}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Section: NVQ QUALIFICATION -->
                @if(!empty($portfolioDatas['nvq_educations']))
                <div class="relative mb-10 z-10">
                    <!-- Icon Circle -->
                    <div class="absolute left-[-28px] md:left-[-48px] top-0 w-8 h-8 md:w-10 md:h-10 rounded-full bg-[#323B49] text-white flex items-center justify-center z-20">
                        <svg class="w-4 h-4 md:w-5 md:h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                    </div>
                    <div class="flex items-center gap-4 mb-6 pl-4 md:pl-0">
                        <h2 class="text-lg font-bold tracking-wider text-[#323B49] dark:text-white uppercase shrink-0">{{trans('portfolio.NVQ Qualification')}}</h2>
                        <div class="flex-grow h-[1px] bg-gray-200 dark:bg-gray-700"></div>
                    </div>
                    
                    <div class="space-y-6">
                        @foreach($portfolioDatas['nvq_educations'] ?? [] as $nvq)
                        <div class="relative pl-6 mb-6 no-break">
                            <!-- Small Circle on Timeline Line -->
                            <div class="absolute left-[-17px] md:left-[-33px] top-[6px] w-3 h-3 rounded-full border-2 border-[#323B49] bg-white dark:bg-[#1E1E1E] z-20"></div>
                            
                            <div class="flex flex-col sm:flex-row sm:justify-between items-start sm:items-center mb-1">
                                <h3 class="font-bold text-[#323B49] dark:text-gray-100 text-[15px]">{{$nvq['qualification_name'] ?? ''}} ({{$nvq['level'] ?? ''}})</h3>
                                <span class="text-xs font-semibold text-gray-500 whitespace-nowrap">{{ formatPortfolioDate($nvq['effective_date'] ?? '', 'M Y') }}</span>
                            </div>
                            <p class="text-[13px] text-gray-600 dark:text-gray-400 font-medium">{{trans('portfolio.NVQ Qualification')}}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

            </div>
        </div>
    </div>

    <!-- Evidences (Supporting Documents) - Separate Page Block -->
    @if(!empty($portfolioDatas['evidences']))
    <div class="max-w-[1200px] mx-auto bg-white dark:bg-[#1E1E1E] my-6 rounded-xl shadow-sm p-4 md:p-8 supporting-docs-section no-break">
        <div class="mb-2">
            <h2 class="text-3xl font-bold text-gray-900 dark:text-white mb-6">{{trans('portfolio.Supporting Documents')}}</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 print:grid-cols-1 gap-6 print:gap-12">
                @foreach($portfolioDatas['evidences'] as $evidence)
                <div class="border border-gray-200 dark:border-gray-700 rounded-2xl overflow-hidden bg-white dark:bg-gray-800 shadow-sm flex flex-col no-break">
                    @if(!empty($evidence['attachment_path']))
                    <div class="h-48 print:h-[600px] overflow-hidden bg-gray-100 dark:bg-gray-900 flex items-center justify-center border-b border-gray-200 dark:border-gray-700 p-2">
                        <img src="{{ $evidence['attachment_path'] }}" alt="Document" class="w-full h-full object-contain cursor-pointer hover:opacity-90 transition-opacity" onclick="openImageModal('{{ $evidence['attachment_path'] }}')">
                    </div>
                    @endif
                    <div class="p-5 flex flex-col flex-1">
                        <span class="text-xs font-semibold text-[#4984F6] uppercase tracking-wider mb-2">{{ !empty($evidence['document_type']) ? __($evidence['document_type']) : __('Document') }}</span>
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-1">{{ $evidence['name'] ?? '' }}</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">{{ $evidence['issuing_organisation'] ?? '' }}</p>
                        
                        <div class="mt-auto">
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-1">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                <span>{{ trans('portfolio.Issue Date') }}: {{ !empty($evidence['issue_date']) ? date("M Y", strtotime($evidence['issue_date']."-01")) : 'N/A' }}</span>
                            </div>
                            @if(!empty($evidence['validity_period']))
                            <div class="flex items-center text-sm text-gray-500 dark:text-gray-400 mb-3">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                <span>{{ trans('portfolio.Valid until') }}: {{ date("M Y", strtotime($evidence['validity_period']."-01")) }}</span>
                            </div>
                            @else
                            <div class="mb-2"></div>
                            @endif
                            @if(!empty($evidence['description']))
                            <p class="text-sm text-gray-700 dark:text-gray-300 line-clamp-3">{{ $evidence['description'] }}</p>
                            @endif
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif

    <!-- Image Modal for Supporting Documents -->
    <div id="image-modal" class="fixed inset-0 bg-black/80 flex items-center justify-center z-[999] hidden no-print" onclick="closeImageModal()">
        <div class="absolute top-4 right-4 text-white text-3xl cursor-pointer hover:text-gray-300 font-bold p-2 z-[1000]">&times;</div>
        <div class="max-w-[90%] max-h-[90%] flex justify-center items-center relative" onclick="event.stopPropagation()">
            <img id="modal-img" src="" alt="Zoomed Document" class="max-w-full max-h-[90vh] rounded-lg shadow-2xl object-contain">
        </div>
    </div>
</body>
<script>
    function openImageModal(imgSrc) {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-img');
        if (modal && modalImg) {
            modalImg.src = imgSrc;
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeImageModal() {
        const modal = document.getElementById('image-modal');
        if (modal) {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }
    }

    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            closeImageModal();
        }
    });
</script>
</html>
