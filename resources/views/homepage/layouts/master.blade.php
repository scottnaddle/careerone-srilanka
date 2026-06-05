<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - {{ env('APP_NAME', 'TVEC SYSTEM') }}</title>
    <base href="{{ asset('/') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="{{ asset('js/jquery-3.7.1.min.js') }}"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="{{asset('js/flowbite.min.js')}}" defer></script>
    <script src="https://js.pusher.com/4.4/pusher.min.js" defer></script>
    <!-- Include Datepicker JS -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/glide.core.min.css') }}" media="print" onload="this.media='all'">
    <link rel="stylesheet" href="{{ asset('css/ckeditor5.css') }}" media="print" onload="this.media='all'">
    @stack('preload')
    <meta name="description" content="CareerOne Sri Lanka - Your gateway to vocational training and career opportunities. Explore NVQ courses, career guidance, and job opportunities to build your future.">
    <meta name="keywords" content="CareerOne, Sri Lanka, vocational training, NVQ, career guidance, job portal, skills development, training programs, TVEC">
    <meta name="author" content="CareerOne Sri Lanka">
    <meta property="og:title" content="CareerOne Sri Lanka - Vocational Training & Career Opportunities">
    <meta property="og:description" content="Find the best vocational training programs, NVQ courses, and career guidance in Sri Lanka. CareerOne connects you to the right opportunities.">
    <meta property="og:url" content="https://careerone.gov.lk">
    <meta property="og:type" content="website">
    <meta property="og:image" content="{{asset('images/Launcing-Banner.jpg')}}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="CareerOne Sri Lanka - Build Your Future">
    <meta name="twitter:description" content="Explore NVQ courses, career guidance, and job opportunities in Sri Lanka. Start your career journey with CareerOne.">
    <meta name="twitter:image" content="{{asset('images/Launcing-Banner.jpg')}}">
    @stack('css')
    <script src="{{ asset('/firebase-messaging-sw.js') }}"></script>
    <script>

        // It's best to inline this in `head` to avoid FOUC (flash of unstyled content) when changing pages or themes
        if (
            localStorage.getItem('color-theme') === 'dark' ||
            (!('color-theme' in localStorage) &&
                window.matchMedia('(prefers-color-scheme: dark)').matches)
        ) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    <style>
        .loader {
            border-top-color: #3498db;
            -webkit-animation: spinner 1.5s linear infinite;
            animation: spinner 1.5s linear infinite;
        }

        @-webkit-keyframes spinner {
            0% {
                -webkit-transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(360deg);
            }
        }

        @keyframes spinner {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        .click-zoom {
            cursor: zoom-in;
            transition: 0.2s;
        }

        .zoom-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .zoom-overlay img {
            width: auto;
            height: auto;
            max-width: 90vw;
            max-height: 90vh;
            object-fit: contain;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(255, 255, 255, 0.3);
        }
    </style>
</head>

<body class="mx-auto p-3 bg-white xl:bg-[#F5F7FA] md:p-4 xl:p-0 dark:bg-[#282828] pt-4 overflow-x-hidden">
    <div id="loading-overlay"
        class=" hidden fixed top-0 left-0 right-0 bottom-0 w-full h-screen z-50 overflow-hidden bg-gray-700 opacity-75 flex flex-col items-center justify-center">
        <div class="loader ease-linear rounded-full border-4 border-t-4 border-gray-200 h-12 w-12 mb-4"></div>
        <h2 class="text-center text-white text-xl font-semibold">{{ __('main.loading_overlay_title') }}</h2>
        <p class="w-1/3 text-center text-white">{{ __('main.loading_overlay_description') }}</p>
    </div>
    <div class="max-w-[1440px] xl:px-[54px] mx-auto md:pt-4">
{{--        @if (activeGuard() == '')--}}
{{--            @desktop--}}
{{--                @include('homepage.partials.header-guest')--}}
        <x-frontpage-menu />
{{--            @elsedesktop--}}
{{--                @include('homepage.partials.header-guest-mobile')--}}
{{--            @enddesktop--}}
{{--        @else--}}
{{--            @desktop--}}
{{--                @include('homepage.partials.' . activeGuard() . '.header')--}}
{{--            @elsedesktop--}}
{{--                @include('homepage.partials.' . activeGuard() . '.header-mobile')--}}
{{--            @enddesktop--}}
{{--        @endif--}}
        <div class=" mx-auto">
            @yield('content')
        </div>
    </div>
    @include('homepage.partials.footer')
    <button id="to-top-button" onclick="goToTop()" title="Go To Top"
        class="hidden fixed z-50 bottom-16 right-3 p-2.5 bg-blue-50 rounded-full border-0 hover:bg-blue-300 hover:text-white active:text-white font-semibold transition-colors duration-300">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
            <path d="M7 11L12 6L17 11M7 17L12 12L17 17" stroke="#4984F6" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
        <span class="sr-only">Go to top</span>
    </button>
    <script>
        function toggleLoadingOverlay() {
            const loadingOverlay = document.getElementById('loading-overlay');
            if (loadingOverlay.classList.contains('hidden')) {
                loadingOverlay.classList.remove('hidden');
            } else {
                loadingOverlay.classList.add('hidden');
            }
        }
        $(document).ready(function() {
            $('.click-zoom').css('cursor', 'zoom-in');

            $('.click-zoom').on('click', function () {
                const src = $(this).attr('src');
                const overlay = $('<div class="zoom-overlay"></div>');
                const zoomedImg = $('<img>').attr('src', src);

                overlay.append(zoomedImg);
                $('body').append(overlay);

                // Click to close
                overlay.on('click', function () {
                    $(this).remove();
                });
            });
        });

    </script>
    @stack('js')
    @if (Auth::guard(activeGuard())->check())
    <script>
        window.Laravel = {!! json_encode([
            'user' => [
                'nic' => Auth::guard(activeGuard())->user()->nic,

            ],
        ]) !!};
        function markAsRead(element, notificationId) {
                $.ajax({
                    url: '{{ route("notifications.markAsRead") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: notificationId
                    },
                    success: function() {
                        $(element).find('.unread-indicator').remove();
                        $(element).removeClass('bg-gray-300 dark:bg-gray-900').addClass('bg-gray-200 dark:bg-gray-800');
                    }
                });
            }
    </script>
      <script src="{{ asset('js/notification/notification-realtime.js') }}" defer></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                // Disable the submit button to prevent multiple clicks
                $(this).find('button[type="submit"]').attr('disabled', 'disabled');
            });



        });

    </script>
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-L1J13W9FK4"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-L1J13W9FK4');
    </script>
@endif
</body>

</html>
