<button type="button" data-dropdown-toggle="language-dropdown-menu-mobile" class="inline-flex items-center font-medium justify-center text-sm text-[#91919A] dark:text-white rounded-xl cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 dark:hover:text-white">
    <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none">
        <path d="M3.54883 4.16667H9.38216M7.71549 2.5V4.16667C7.71549 7.84833 5.84966 10.8333 3.54883 10.8333M4.38216 7.5C4.38216 9.28667 6.84216 10.7567 9.96549 10.8333M10.2155 16.6667L13.5488 9.16667L16.8822 16.6667M16.1322 15H10.9655" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
    </svg>
</button>
<!-- Dropdown -->
<div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl shadow dark:bg-[#1E1E1E]"
    id="language-dropdown-menu-mobile">
    <ul class="py-2 font-medium" role="none">
        <li>
{{--            <a href="{{ route('setLocale', ['lang' => 'en']) }}"--}}
            <a href="/select-language/en"
                class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-400 hover:bg-gray-100  dark:hover:bg-gray-600 dark:hover:text-white"
                role="menuitem">
                <div class="inline-flex items-center {{App::getLocale() =='en' ? 'text-primary dark:text-white' : ''}}">

                    {{ trans('system.language.english') }}
                </div>
            </a>
        </li>
        <li>
{{--            <a href="{{ route('setLocale', ['lang' => 'sn']) }}"--}}
            <a href="/select-language/sn"
                class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-400 hover:bg-gray-100  dark:hover:bg-gray-600 dark:hover:text-white"
                role="menuitem">
                <div class="inline-flex items-center {{App::getLocale() =='sn' ? 'text-primary dark:text-white' : ''}}">

                    {{ trans('system.language.sinhala') }}
                </div>
            </a>
        </li>
        <li>
{{--            <a href="{{ route('setLocale', ['lang' => 'tm']) }}"--}}
            <a href="/select-language/tm"
                class="block px-4 py-2 text-sm text-gray-900 dark:text-gray-400 hover:bg-gray-100  dark:hover:bg-gray-600 dark:hover:text-white"
                role="menuitem">
                <div class="inline-flex items-center {{App::getLocale() =='tm' ? 'text-primary dark:text-white' : ''}}">

                    {{ trans('system.language.tamil') }}
                </div>
            </a>
        </li>

    </ul>
</div>

<button type="button" data-dropdown-toggle="accesibility-dropdown-menu-mobile"
    class="inline-flex items-center font-semibold justify-center text-[#91919A] hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-white rounded-xl cursor-pointer dark:bg-[#383838]">
    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
        class="size-6">
        <path stroke-linecap="round" stroke-linejoin="round" stroke="currentColor"
            d="M4.5 12a7.5 7.5 0 0 0 15 0m-15 0a7.5 7.5 0 1 1 15 0m-15 0H3m16.5 0H21m-1.5 0H12m-8.457 3.077 1.41-.513m14.095-5.13 1.41-.513M5.106 17.785l1.15-.964m11.49-9.642 1.149-.964M7.501 19.795l.75-1.3m7.5-12.99.75-1.3m-6.063 16.658.26-1.477m2.605-14.772.26-1.477m0 17.726-.26-1.477M10.698 4.614l-.26-1.477M16.5 19.794l-.75-1.299M7.5 4.205 12 12m6.894 5.785-1.149-.964M6.256 7.178l-1.15-.964m15.352 8.864-1.41-.513M4.954 9.435l-1.41-.514M12.002 12l-3.75 6.495" />
    </svg>

</button>
<!-- Dropdown -->
<div class="w-52 z-50 hidden w-48 my-4 text-base list-none bg-white border border-gray-100 divide-y divide-gray-100 rounded-xl dark:bg-[#1E1E1E]"
    id="accesibility-dropdown-menu-mobile">
    <ul class="py-2 pr-3 font-medium" role="none">
        <li>
            <label class="inline-flex flex-row-reverse justify-between items-center cursor-pointer w-full">
                <button id="" type="button"
                    class="theme-toggle text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl text-sm p-2.5">
                    <svg id="" class="w-5 h-5 hidden theme-toggle-dark-icon" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                    </svg>
                    <svg id="" class="w-5 h-5 hidden theme-toggle-light-icon" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path
                            d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                            fill-rule="evenodd" clip-rule="evenodd"></path>
                    </svg>
                </button>
                <span
                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ trans('system.accessibility.dark_mode') }}</span>
            </label>


        </li>
        <li>
            <label class="inline-flex items-center cursor-pointer justify-between w-full py-2.5">
                <input type="checkbox" value="" id="" class="sr-only peer contrast-toggle">
                <span
                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ trans('system.accessibility.increase_contrast') }}</span>
                <div
                    class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>

            </label>
        </li>

        <li>
            <label class="inline-flex items-center cursor-pointer justify-between w-full py-2.5">
                <input type="checkbox" value="" id="" class="sr-only peer invert-toggle">
                <span
                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ trans('system.accessibility.invert_color') }}</span>
                <div
                    class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>

            </label>
        </li>

        <li>
            <label class="inline-flex items-center cursor-pointer justify-between w-full py-2.5">
                <input type="checkbox" value="" id="" class="sr-only peer zoom-toggle">
                <span
                    class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">{{ trans('system.accessibility.zoom') }}</span>
                <div
                    class="relative w-11 h-6 bg-gray-400 peer-focus:outline-none rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600">
                </div>

            </label>
        </li>

    </ul>
</div>

@if (activeGuard() != '' && Auth::guard(activeGuard())->check())
    <button id="dropdownNotificationButtonMobile" data-dropdown-toggle="dropdownNotificationMobile"
        class="relative inline-flex items-center text-sm font-medium text-center text-gray-500 hover:text-gray-900 focus:outline-none dark:hover:text-white dark:text-white"
        type="button">
        <svg xmlns="http://www.w3.org/2000/svg" width="21" height="20" viewBox="0 0 21 20" fill="none"
            class="dark:fill-white">
            <path
                d="M8.01127 17.5C8.59888 18.0187 9.37075 18.3334 10.2161 18.3334C11.0615 18.3334 11.8334 18.0187 12.421 17.5M15.2161 6.66669C15.2161 5.3406 14.6893 4.06884 13.7517 3.13115C12.814 2.19347 11.5422 1.66669 10.2161 1.66669C8.89004 1.66669 7.61827 2.19347 6.68059 3.13115C5.74291 4.06884 5.21612 5.3406 5.21612 6.66669C5.21612 9.24184 4.56651 11.005 3.84084 12.1712C3.22873 13.1549 2.92267 13.6468 2.93389 13.784C2.94632 13.9359 2.9785 13.9939 3.10093 14.0847C3.2115 14.1667 3.70995 14.1667 4.70683 14.1667H15.7254C16.7223 14.1667 17.2207 14.1667 17.3313 14.0847C17.4537 13.9939 17.4859 13.9359 17.4984 13.784C17.5096 13.6468 17.2035 13.1549 16.5914 12.1712C15.8657 11.005 15.2161 9.24184 15.2161 6.66669Z"
                stroke="#91919A" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>

        @if (Auth::guard(activeGuard())->user()->unreadNotifications->count() > 0)
        <div
            class="absolute block w-3 h-3 bg-red-500 border-2 border-white rounded-full top-0 start-2.5 dark:border-gray-900">
        </div>
    @endif
    </button>

    <!-- Dropdown menu -->
    <div id="dropdownNotificationMobile"
        class="z-60 hidden w-full max-w-sm bg-white divide-y divide-gray-100 rounded-xl shadow dark:bg-[#1E1E1E] dark:divide-gray-700"
        aria-labelledby="dropdownNotificationButton" style="z-index:99">
        <div
            class="block px-4 py-2 font-medium text-center text-gray-700 rounded-t-lg bg-gray-50 dark:bg-[#1E1E1E] dark:text-white">
            {{ trans('system.notifications') }}
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700 overflow-y-auto max-h-96 show-notification">
            @foreach (Auth::guard(activeGuard())->user()->notifications->take(7) as $notification)
            @php
                $isRead = $notification->read_at !== null;
                $messageKey = $notification->data['message']['key'] ?? $notification->data['message']['message'];
                $messageParams = $notification->data['message']['params'] ?? [];
                $translatedMessage = __($messageKey, $messageParams);
            @endphp
            <a href="{{ $notification->data['message']['href'] ?? '' }}"
                class="flex px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-700 notification-item {{ $isRead ? 'bg-white dark:bg-gray-800' : 'bg-gray-300 dark:bg-gray-900' }}"
                data-id="{{ $notification->id }}" onclick="markAsRead(this, '{{ $notification->id }}')">
                {!! $notification->data['message']['icon'] ?? '' !!}
                <div class="w-full ps-3">
                    <div class="flex justify-between items-start">
                        <div class="text-gray-900 text-sm dark:text-white text-left">
                            {{ $translatedMessage }}
                        </div>
                    </div>
                    <div class="text-xs text-blue-700 dark:text-blue-500 mt-1 text-left">
                        {{ \Carbon\Carbon::parse($notification->created_at)->diffForHumans() }}
                    </div>
                </div>
            </a>
        @endforeach
        </div>
        <a href="{{ route('notifications.notification') }}"
            class="block py-2 text-sm font-medium text-center text-gray-900 rounded-b-lg bg-gray-50 hover:bg-gray-100 dark:bg-[#1E1E1E] dark:hover:bg-gray-700 dark:text-white">
            <div class="inline-flex items-center">
                <svg class="w-4 h-4 me-2 text-gray-500 dark:text-white" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 14">
                    <path
                        d="M10 0C4.612 0 0 5.336 0 7c0 1.742 3.546 7 10 7 6.454 0 10-5.258 10-7 0-1.664-4.612-7-10-7Zm0 10a3 3 0 1 1 0-6 3 3 0 0 1 0 6Z" />
                </svg>
                View all
            </div>
        </a>
    </div>

@endif
