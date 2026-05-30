<div id="header-web" class="hidden md:block">
    {{-- Utility bar: thin strip with accessibility, language, sign in --}}
    <div class="bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto flex items-center justify-end gap-4 px-4 sm:px-6 lg:px-8 h-9 text-xs">
            @include('homepage.partials.accessibility.accessibility-pc')

            @if(activeGuard() != '' && Auth::guard(activeGuard())->check())
                {{-- User avatar + name --}}
                <button type="button" class="flex items-center gap-2 text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400" id="user-menu-button"
                    data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                    @if(Auth::guard(activeGuard())->user()->profile_image)
                        <img class="w-6 h-6 rounded-full object-cover" src="{{ Auth::guard(activeGuard())->user()->profile_image }}" alt="user photo">
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/></svg>
                    @endif
                    <span class="hidden lg:inline">{{ Str::limit(Auth::guard(activeGuard())->user()->fullName, 20) }}</span>
                </button>
                <div class="z-50 hidden my-4 w-52 text-base list-none bg-white divide-y divide-gray-100 rounded-xl dark:bg-gray-800 shadow-lg" id="user-dropdown">
                    <ul aria-labelledby="user-menu-button">
                        <li><a href="{{route(activeGuard().'.my-page.my-page')}}" class="block px-4 py-2.5 text-sm hover:bg-primary hover:text-white rounded-t-xl font-medium dark:hover:bg-primary dark:text-white">{{trans('system.menu.my_page')}}</a></li>
                        <li><a href="{{route(activeGuard().'.auth.logout')}}" class="block px-4 py-2.5 text-sm hover:text-white rounded-b-xl font-medium hover:bg-primary dark:hover:bg-primary dark:text-white">{{trans('system.menu.sign_out')}}</a></li>
                    </ul>
                </div>
            @else
                <a href="/choose-login" class="text-primary dark:text-blue-400 font-medium hover:underline">{{trans('system.menu.sign_in')}}</a>
            @endif
        </div>
    </div>

    {{-- Main navigation: logo + menu items --}}
    <div class="bg-white dark:bg-gray-950 border-b border-gray-100 dark:border-gray-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 sm:px-6 lg:px-8 h-16">
            {{-- Logo --}}
            <a href="/" class="flex items-center gap-3">
                <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 dark:hidden" alt="Careerone Logo">
                <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 hidden dark:block" alt="Careerone Logo">
            </a>

            {{-- Menu --}}
            <ul class="flex items-center gap-1">
                @foreach ($items as $item)
                    <li>
                        @if (isset($item['children']) && count($item['children']) > 0)
                            <button id="dropdownNavbarLink{{ $loop->index }}"
                                data-dropdown-toggle="dropdownNavbar{{ $loop->index }}"
                                data-dropdown-trigger="hover"
                                class="flex items-center gap-1 px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                                {{ $item['label'] }}
                                <svg class="w-3 h-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                            </button>
                            <div id="dropdownNavbar{{ $loop->index }}" class="z-40 hidden w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700">
                                <ul class="py-2 text-sm">
                                    @foreach ($item['children'] as $child)
                                        <li>
                                            @if (isset($child['children']) && count($child['children']) > 0)
                                                <button id="submenu{{ $loop->parent->index }}-{{ $loop->index }}"
                                                    data-dropdown-toggle="submenu{{ $loop->parent->index }}-{{ $loop->index }}"
                                                    data-dropdown-trigger="hover" data-dropdown-placement="right-start"
                                                    class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200 font-medium">
                                                    {{ $child['label'] }}
                                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                                </button>
                                                <div id="submenu{{ $loop->parent->index }}-{{ $loop->index }}" class="z-50 hidden w-56 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700">
                                                    <ul class="py-2 text-sm">
                                                        @foreach ($child['children'] as $grandchild)
                                                            <li><a href="{{ $grandchild['link'] }}" class="block px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200 font-medium">{{ $grandchild['label'] }}</a></li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @else
                                                <a href="{{ $child['link'] }}" class="block px-4 py-2.5 hover:bg-gray-50 dark:hover:bg-gray-700 dark:text-gray-200 font-medium">{{ $child['label'] }}</a>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <a href="{{ $item['link'] }}" class="px-3 py-2 text-sm font-medium text-gray-600 dark:text-gray-300 hover:text-primary dark:hover:text-blue-400 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">{{ $item['label'] }}</a>
                        @endif
                    </li>
                @endforeach
            </ul>

            {{-- Institution logos --}}
            <div class="hidden lg:flex items-center gap-5 pl-6 ml-6 border-l border-gray-200 dark:border-gray-700">
                <img src="{{asset('/images/NIElogo.webp')}}" class="h-8" alt="NIE Logo" loading="lazy">
                <img src="{{asset('/images/TVEClogo.png')}}" class="h-7" alt="TVEC Logo" loading="lazy">
            </div>
        </div>
    </div>
</div>

{{-- Mobile menu (unchanged) --}}
<div id="header-mobile" class="block md:hidden">
    <div class="flex flex-col">
        <div class="flex items-center justify-between px-2 py-2 bg-gray-50 dark:bg-gray-900 border-b border-gray-100 dark:border-gray-800">
            <div class="flex items-center gap-3">
                @include('homepage.partials.accessibility.accessibility-mobile')
            </div>
            @if(activeGuard() != '' && Auth::guard(activeGuard())->check())
                <a href="{{route(activeGuard().'.my-page.my-page')}}" class="text-sm text-gray-600 dark:text-gray-300">
                    {{ Str::limit(Auth::guard(activeGuard())->user()->fullName, 15) }}
                </a>
            @else
                <a href="/choose-login" class="text-sm text-primary dark:text-blue-400 font-medium">{{trans('system.menu.sign_in')}}</a>
            @endif
        </div>

        <nav class="bg-white dark:bg-gray-950 px-4 py-3 flex items-center justify-between">
            <a href="/" class="flex items-center gap-3">
                <img src="{{asset('/images/careerone-logo.webp')}}" class="h-6 dark:hidden" alt="Careerone Logo">
                <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-6 hidden dark:block" alt="Careerone Logo">
            </a>
            <button id="mobile-menu-btn" class="text-gray-600 dark:text-gray-300 p-2">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </nav>

        <div id="mobile-menu" class="hidden bg-white dark:bg-gray-950 border-t border-gray-100 dark:border-gray-800 px-4 py-4">
            @foreach ($items as $item)
                @if (isset($item['children']) && count($item['children']) > 0)
                    <details class="group mb-2">
                        <summary class="flex items-center justify-between py-2 text-sm font-medium text-gray-700 dark:text-gray-300 cursor-pointer">{{ $item['label'] }}
                            <svg class="w-4 h-4 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </summary>
                        <div class="pl-4 border-l-2 border-gray-100 dark:border-gray-700 ml-2 mt-1">
                            @foreach ($item['children'] as $child)
                                @if (isset($child['children']))
                                    <details class="mb-1">
                                        <summary class="py-1.5 text-sm text-gray-600 dark:text-gray-400 cursor-pointer">{{ $child['label'] }}</summary>
                                        <div class="pl-3 border-l border-gray-100 dark:border-gray-700">
                                            @foreach ($child['children'] as $grandchild)
                                                <a href="{{ $grandchild['link'] }}" class="block py-1.5 text-sm text-gray-500 dark:text-gray-400">{{ $grandchild['label'] }}</a>
                                            @endforeach
                                        </div>
                                    </details>
                                @else
                                    <a href="{{ $child['link'] }}" class="block py-1.5 text-sm text-gray-600 dark:text-gray-400">{{ $child['label'] }}</a>
                                @endif
                            @endforeach
                        </div>
                    </details>
                @else
                    <a href="{{ $item['link'] }}" class="block py-2 text-sm font-medium text-gray-700 dark:text-gray-300">{{ $item['label'] }}</a>
                @endif
            @endforeach
        </div>
    </div>
</div>

@push('js')
<script>
    document.getElementById('mobile-menu-btn')?.addEventListener('click', function() {
        document.getElementById('mobile-menu').classList.toggle('hidden');
    });
</script>
@endpush
