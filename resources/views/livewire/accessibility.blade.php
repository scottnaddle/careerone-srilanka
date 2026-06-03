<div>
    <script src="https://unpkg.com/flowbite@latest/dist/flowbite.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <button type="button" data-dropdown-toggle="accesibility-dropdown-menu"
            class="inline-flex items-center font-semibold justify-center px-2 py-1 md:px-4 md:py-2 text-primary rounded-xl cursor-pointer bg-[#F5F7FA] text-primary dark:bg-[#383838] dark:text-white">
        {{ trans('system.accessibility.title') }} <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                       stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>

    </button>
    <!-- Dropdown -->
    <div class="w-52 z-50 hidden w-48 my-4 text-base list-none bg-white border border-gray-100 divide-y divide-gray-100 rounded-xl dark:bg-[#1E1E1E]"
         id="accesibility-dropdown-menu">
        <ul class="py-2 pr-3 font-medium" role="none">
            <li>
                <label class="inline-flex flex-row-reverse justify-between items-center cursor-pointer w-full">
                    <button id="" type="button"
                            class="theme-toggle text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-xl text-sm p-2.5">
                        <svg id="" class="w-5 h-5 hidden theme-toggle-dark-icon" fill="currentColor" viewBox="0 0 20 20"
                             xmlns="http://www.w3.org/2000/svg">
                            <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                        </svg>
                        <svg id="theme-toggle-light-icon" class="w-5 h-5 hidden theme-toggle-light-icon" fill="currentColor" viewBox="0 0 20 20"
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
    <button type="button" data-dropdown-toggle="language-dropdown-menu"
            class="inline-flex items-center font-semibold justify-center px-2 py-1 md:px-4 md:py-2 text-primary rounded-xl cursor-pointer bg-white border border-[#F5F7FA] text-primary dark:bg-[#1E1E1E] dark:text-white">
        @if (App::getLocale() == 'en')
            {{ trans('system.language.english') }}
        @else
            @if (App::getLocale() == 'sn')
                {{ trans('system.language.sinhala') }}
            @else
                {{ trans('system.language.tamil') }}
            @endif
        @endif
        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
             class="w-4 h-4 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>

    </button>
    <!-- Dropdown -->
    <div class="w-52 z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-xl  dark:bg-[#1E1E1E]"
         id="language-dropdown-menu">
        <ul class="py-2 font-medium" role="none">
            <li>
                <a href="/select-language/en"
                   class="block px-4 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-t-xl {{App::getLocale() =='en' ? 'text-primary dark:text-white' : ''}}"
                   role="menuitem">
                    <div class="inline-flex items-center text-center">
                        {{ trans('system.language.english') }}
                    </div>
                </a>
            </li>
            <li>
                <a href="/select-language/sn"
                   class="block px-4 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white {{App::getLocale() =='sn' ? 'text-primary  dark:text-white' : ''}}"
                   role="menuitem">
                    <div class="inline-flex items-center text-center">
                        {{ trans('system.language.sinhala') }}
                    </div>
                </a>
            </li>
            <li>
                <a href="/select-language/tm"
                   class="block px-4 py-2 text-sm text-gray-900 hover:bg-primary hover:text-white dark:text-gray-400 dark:hover:bg-[#383838] dark:hover:text-white hover:rounded-b-xl {{App::getLocale() =='tm' ? 'text-primary  dark:text-white' : ''}}"
                   role="menuitem">
                    <div class="inline-flex items-center text-center">
                        {{ trans('system.language.tamil') }}
                    </div>
                </a>
            </li>
        </ul>
    </div>

</div>
