<div id="header-web" class="hidden md:block">
    <div class="flex flex-col gap-6 ">
        @include('homepage.partials.top-header')

        <nav class="">
            <div class="flex flex-col text-center text-[#201F36] dark:text-white bg-white dark:bg-[#1E1E1E] rounded-xl py-4 px-7">
                <div class="flex justify-end">
                    <div class="flex items-center space-x-6 rtl:space-x-reverse">
                        @include('homepage.partials.accessibility.accessibility-pc')
                        @if(activeGuard() != '' && Auth::guard(activeGuard())->check())
                            <button type="button" class="flex justify-center items-center text-sm bg-white  antialiased rounded-full md:me-0 dark:bg-[#1E1E1E] dark:text-white" id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                                <span class="sr-only">Open user menu</span>
                                @if(Auth::guard(activeGuard())->user()->profile_image)
                                    <img class="w-9 h-9 rounded-full object-cover" src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}" alt="user photo" loading="lazy">
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-10">
                                        <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>
                                @endif
                                <div class="p-2">
                                    <span class="block text-sm text-[#464559] dark:text-white font-semibold">{{\Str::limit(Auth::guard(activeGuard())->user()->fullName, 20)}}</span>
                                    <span class="block text-xs  text-[#706F81] truncate dark:text-white">{{Auth::guard(activeGuard())->user()->email}}</span>
                                </div>
                            </button>
                            <!-- Dropdown menu -->
                            <div class="z-50 hidden my-4 w-52 text-base list-none bg-white divide-y divide-gray-100 rounded-xl  dark:bg-[#1E1E1E] dark:divide-gray-600 shadow-custom-light dark:shadow-custom-dark" id="user-dropdown">

                                <ul class="" aria-labelledby="user-menu-button">
                                    <li>
                                        <a href="{{route(activeGuard().'.my-page.my-page')}}" class="block px-4 py-2 text-sm text-[#464559] hover:bg-primary hover:text-white hover:rounded-t-xl font-medium dark:hover:bg-primary dark:text-white dark:hover:text-white">{{trans('system.menu.my_page')}}</a>
                                    </li>
                                    {{--                            <li>--}}
                                    {{--                                <a href="/cgo/download-user-manual/{{app()->getLocale()}}" class="block px-4 py-2 text-sm text-[#464559] hover:bg-primary hover:text-white font-medium dark:hover:bg-primary dark:text-white dark:hover:text-white">{{trans('system.menu.download_user_manual')}}</a>--}}
                                    {{--                            </li>--}}
                                    <li>
                                        <a href="{{route(activeGuard().'.auth.logout')}}" class="block px-4 py-2 text-sm text-[#464559] hover:text-white  hover:rounded-b-xl font-medium hover:bg-primary dark:hover:bg-primary dark:text-white dark:hover:text-white">{{trans('system.menu.sign_out')}}</a>
                                    </li>
                                </ul>
                            </div>
                        @else
                            <a href="/choose-login" class="text-white w-full bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
     px-3 py-1.5 md:px-12 md:py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 md:text-xl font-medium">{{trans('system.menu.sign_in')}}
                            </a>
                        @endif
                    </div>
                </div>
                <ul class="flex flex-wrap gap-9 text-lg items-center">
                    @foreach ($items as $item)
                        <li class="box-border h-7">
                            @if (isset($item['children']) && count($item['children']) > 0)
                                <button id="dropdownNavbarLink{{ $loop->index }}"
                                        data-dropdown-toggle="dropdownNavbar{{ $loop->index }}"
                                        data-dropdown-trigger="click"
                                        class="flex items-center justify-between w-full py-2 px-3 text-[#201F36] dark:text-white md:hover:bg-transparent md:border-0 hover:text-blue-500 hover:border-b-4 hover:border-blue-500 md:hover:text-blue-500 md:p-0 md:w-auto md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent font-semibold">
                                    {{ $item['label'] }}
                                    <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="m1 1 4 4 4-4"/>
                                    </svg>
                                </button>
                                <!-- Dropdown menu -->
                                <div id="dropdownNavbar{{ $loop->index }}"
                                     class="w-auto min-w-52 z-40 hidden font-normal bg-white dark:bg-[#1E1E1E] divide-y divide-gray-100 rounded-xl shadow dark:bg-[#1E1E1E] dark:divide-gray-600">
                                    <ul class="text-sm text-gray-700 dark:text-white dark:bg-[#1E1E1E] rounded-xl">
                                        @foreach ($item['children'] as $child)
                                            <li class="">
                                                @if (isset($child['children']) && count($child['children']) > 0)
                                                    <button id="dropdownNavbarLink{{ $loop->parent->index }}-{{ $loop->index }}"
                                                            data-dropdown-toggle="dropdownNavbar{{ $loop->parent->index }}-{{ $loop->index }}"
                                                            data-dropdown-trigger="hover" data-dropdown-placement="right-start" type="button"
                                                            class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary dark:hover:bg-primary hover:text-white dark:text-white dark:bg-[#1E1E1E] font-medium {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                                        {{ $child['label'] }}
                                                        <svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4"></path>
                                                        </svg>
                                                    </button>
                                                    <div id="dropdownNavbar{{ $loop->parent->index }}-{{ $loop->index }}"
                                                         class=" z-40 hidden font-normal bg-white dark:bg-[#1E1E1E] divide-y divide-gray-100 rounded-xl shadow dark:bg-[#1E1E1E] dark:divide-gray-600">
                                                        <ul class="text-sm text-gray-700 dark:text-white w-auto min-w-52 dark:bg-[#1E1E1E] rounded-xl">
                                                            @foreach ($child['children'] as $grandchild)
                                                                <li class="">
                                                                    <a href="{{ $grandchild['link'] }}"
                                                                       class="text-left flex px-4 py-2.5 hover:bg-primary dark:hover:bg-primary hover:text-white dark:text-white dark:bg-[#1E1E1E] font-medium {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                                                        {{ $grandchild['label'] }}
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                @else
                                                    <a href="{{ $child['link'] }}"
                                                       class="flex px-4 py-2.5 hover:bg-primary dark:hover:bg-primary hover:text-white dark:text-white dark:bg-[#1E1E1E] font-medium {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                                        {{ $child['label'] }}
                                                    </a>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <a href="{{ $item['link'] }}"
                                   class="inline-block hover:text-blue-500 dark:hover:text-blue-500 hover:border-b-4 hover:border-blue-500 text-[#201F36] dark:text-white font-semibold {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}">
                                    {{ $item['label'] }}
                                </a>
                            @endif
                        </li>
                    @endforeach
                </ul>


            </div>

        </nav>

    </div>
</div>
<div id="header-mobile" class="block md:hidden">
    <nav class="bg-white border-gray-200 dark:bg-[#1E1E1E] rounded-xl">
        <div class="max-w-screen-xl flex justify-between mx-auto py-4 px-1">
            <div class="flex gap-1">
                <button data-collapse-toggle="navbar-multi-level" type="button" class="btn-toggle-menu w-auto flex items-center justify-start text-sm text-gray-500 rounded-xl xl:hidden hover:bg-gray-100 focus:ring-2 focus:ring-gray-200 dark:text-white dark:hover:bg-gray-700" aria-controls="navbar-multi-level" aria-expanded="false">
                    <span class="sr-only">Open main menu</span>
                    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" class="dark:fill-white">
                        <path d="M3.28418 10H18.2842M3.28418 5H18.2842M3.28418 15H13.2842" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
                <a href="#" class="flex items-center rtl:space-x-reverse">
                    <img src="{{asset('images/careerone-logo.webp')}}" class="h-8 block dark:hidden" alt="TVET Logo" loading="lazy" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 hidden dark:block" alt="TVET Logo" loading="lazy" />
                </a>
            </div>
            <div class="flex gap-3 items-center">

                <div class="hidden xl:hidden md:w-[40%] w-[85%] fixed z-50 top-0 left-0 h-[100vh] bg-white p-6 dark:bg-[#1E1E1E] overflow-y-auto" id="navbar-multi-level">
                    <div class="border-b border-gray-300 pb-6 flex justify-between items-center">
{{--                        <a href="#" class="flex items-center rtl:space-x-reverse">--}}
{{--                            <img src="{{asset('images/careerone-logo.webp')}}" loading="lazy" class="h-8 block dark:hidden" alt="TVET Logo" />--}}
{{--                            <img src="{{asset('/images/careerone-logo-dark.webp')}}" loading="lazy" class="h-8 hidden dark:block" alt="TVET Logo" />--}}
{{--                        </a>--}}
                        <nav class="bg-white dark:bg-[#1E1E1E] border-gray-200 rounded-xl w-full">
                            <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
                                <a href="/" class="flex items-center rtl:space-x-reverse">
                                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" loading="lazy" />
                                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" loading="lazy" />
                                </a>

                                <div class="flex items-center gap-2 rtl:space-x-reverse">
                                    <img src="{{asset('/images/NIElogo.webp')}}" class="h-8 md:h-12 block" alt="NIE Logo" loading="lazy" />
                                    <img src="{{asset('/images/TVEClogo.png')}}" class="h-8 md:h-12 block" alt="TVEC Logo" loading="lazy" />
                                </div>
                            </div>
                        </nav>

                        <button  type="button" class="dark:text-white btn-toggle-close-menu w-10 h-10 flex items-center justify-center text-sm text-gray-500 rounded-xl xl:hidden hover:bg-gray-100 focus:ring-2 focus:ring-gray-200 dark:text-white dark:hover:bg-gray-700 ">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    @if(!Auth::guard(activeGuard())->check())
                        <div class="flex justify-center mt-6 gap-4">
                            <a href="/choose-login"
                               class="text-white bg-primary hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full
     px-6 py-1.5 md:px-12 md:py-3 text-center dark:hover:bg-blue-700 dark:focus:ring-blue-800 md:text-xl font-medium">{{trans('system.menu.sign_in')}}
                            </a>
                        </div>
                    @endif

                    <ul class="flex flex-col font-medium md:p-0 mt-6 rounded-xl md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 bg-white dark:bg-[#1E1E1E] dark:text-white"
                        id="accordion-collapse-sub-1"
                        style="margin-left: 0 !important;"
                        data-accordion="collapse"
                        data-active-classes="text-primary dark:text-white"
                        data-inactive-classes="text-[#706F81] dark:text-white">
                        @foreach ($items as $item)
                            @if (isset($item['children']))
                                <li class="py-2">
                                    <h2 id="accordion-{{ md5($item['label']) }}-heading" class="dark:text-white">
                                        <button type="button"
                                                class="flex text-[#706F81] dark:text-white !dark:text-white items-center justify-between w-full font-medium rtl:text-right font-semibold dark:focus:ring-gray-800 hover:text-primary gap-3 gap-1 rounded"
                                                data-accordion-target="#accordion-{{ md5($item['label']) }}"
                                                aria-expanded="false"
                                                aria-controls="accordion-{{ md5($item['label']) }}">
                                            <span>{{ $item['label'] }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-{{ md5($item['label']) }}" class="hidden" aria-labelledby="accordion-{{ md5($item['label']) }}-heading">
                                        <ul class="pl-4 py-2"
                                            id="accordion-collapse-sub-1-{{ md5($item['label']) }}"
                                            data-accordion="collapse"
                                            data-active-classes="text-primary dark:text-white"
                                            data-inactive-classes="text-[#706F81] dark:text-white">
                                            @foreach ($item['children'] as $child)
                                                @if (isset($child['children']))
                                                    <li class="py-2">
                                                        <h2 id="accordion-{{ md5($child['label']) }}-heading" class="dark:text-white">
                                                            <button type="button"
                                                                    class="flex text-[#706F81] dark:text-white !dark:text-white items-center justify-between w-full font-medium rtl:text-right font-semibold dark:focus:ring-gray-800 hover:text-primary gap-3 text-sm !hover:text-primary dark:bg-[#1E1E1E] rounded p-1 dark:text-white"
                                                                    data-accordion-target="#accordion-{{ md5($child['label']) }}"
                                                                    aria-expanded="false"
                                                                    aria-controls="accordion-{{ md5($child['label']) }}">
                                                                <span>{{ $child['label'] }}</span>
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                                                </svg>
                                                            </button>
                                                        </h2>
                                                        <div id="accordion-{{ md5($child['label']) }}" class="hidden" aria-labelledby="accordion-{{ md5($child['label']) }}-heading">
                                                            <ul class="pl-4 py-2"
                                                                id="accordion-collapse-sub-1-1-{{ md5($item['label']) }}"
                                                                data-accordion="collapse">
                                                                @foreach ($child['children'] as $subchild)
                                                                    <li class="py-2">
                                                                        <a href="{{ $subchild['link'] }}"
                                                                        class="block w-full text-[#706F81] dark:text-white hover:text-primary text-sm dark:text-white font-medium"
                                                                        aria-current="page">
                                                                            {{ $subchild['label'] }}
                                                                        </a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </li>
                                                @else
                                                    <li class="py-2">
                                                        <a href="{{ $child['link'] }}"
                                                        class="p-1 block w-full text-[#706F81] dark:text-white hover:text-primary text-sm font-medium"
                                                        aria-current="page">
                                                            {{ $child['label'] }}
                                                        </a>
                                                    </li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </li>
                            @else
                                <li class="py-2">
                                    <a href="{{ $item['link'] }}"
                                    class="block w-full text-[#706F81] dark:text-white hover:text-primary font-semibold dark:text-white p-1"
                                    aria-current="page">
                                        {{ $item['label'] }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    </ul>



                </div>

                @include('homepage.partials.accessibility.accessibility-mobile')
                {{--User drop down--}}
                @if(activeGuard() != '' && Auth::guard(activeGuard())->check())
                    <button type="button" class="flex text-sm bg-white dark:bg-gray-800 h-8 w-8 rounded-full md:me-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600" id="user-menu-button-mobile" aria-expanded="false" data-dropdown-toggle="user-dropdown-mobile" data-dropdown-placement="bottom">
                        <span class="sr-only">Open user menu</span>
                        @if(Auth::guard(activeGuard())->user()->profile_image)
                            <img class="w-8 h-8 rounded-full object-cover" src="{{ asset(Auth::guard(activeGuard())->user()->profile_image) }}" alt="user photo" loading="lazy">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-8">
                                <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                        @endif
                    </button>
                    <!-- Dropdown menu -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow dark:bg-[#1E1E1E] dark:divide-gray-600" id="user-dropdown-mobile">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">{{\Str::limit(Auth::guard(activeGuard())->user()->fullName, 15)}}</span>
                            <span class="block text-sm  text-gray-500 truncate dark:text-white">{{\Str::limit(Auth::guard(activeGuard())->user()->email,15)}}</span>
                        </div>
                        <ul class="py-2" aria-labelledby="user-menu-button-mobile">
                            <li>
                                <a href="{{route(activeGuard().'.my-page.my-page')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white dark:hover:text-white">{{trans('system.menu.my_page')}}</a>
                            </li>
                            {{--                        <li>--}}
                            {{--                            <a href="/trainee/download-user-manual/{{app()->getLocale()}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white dark:hover:text-white">{{trans('system.menu.download_user_manual')}}</a>--}}
                            {{--                        </li>--}}
                            <li>
                                <a href="{{route(activeGuard().'.auth.logout')}}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-white dark:hover:text-white">{{trans('auth.sign_out')}}</a>
                            </li>
                        </ul>
                    </div>
                @endif
            </div>
        </div>

    </nav>

</div>




