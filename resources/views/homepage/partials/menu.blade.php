<div class=" text-center text-[#91919A] bg-white rounded-xl">
    <ul class="flex flex-wrap gap-9 py-5 px-7 text-lg items-center">
        <li class="box-border h-7">
            <a href="{{ route('homepage.index') ?? '/' }}"
                class="inline-block hover:text-blue-500 hover:border-b-4 hover:border-blue-500 text-[#91919A] {{ request()->routeIs('homepage.index') ? 'text-blue-500 border-b-4 border-blue-500' : '' }}"
                @if(request()->routeIs('homepage.index')) aria-current="page" @endif>{{ __('system.menu.home') }}</a>
        </li>
        <li class="box-border h-7">
            <a href="{{ route('homepage.about-us') }}"
                class="inline-block hover:text-blue-500 hover:border-b-4 hover:border-blue-500 text-[#91919A] box-border {{ request()->routeIs('homepage.about-us') ? 'text-blue-500 border-b-4 border-blue-500' : '' }}"
                @if(request()->routeIs('homepage.about-us')) aria-current="page" @endif>{{ __('system.menu.about_us') }}</a>
        </li>
        @if (activeGuard() != '' && Auth::guard(activeGuard())->check())
            <li class="box-border h-7">
                <button id="dropdownNavbarLink1" data-dropdown-toggle="dropdownNavbar1" data-dropdown-trigger="click"
                    class="flex items-center justify-between w-full py-2 px-3 text-[#91919A] md:hover:bg-transparent md:border-0 hover:text-blue-500 hover:border-b-4 hover:border-blue-500 md:hover:text-blue-500 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('system.menu.career_guidance.root') }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg></button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar1"
                    class="z-40 hidden font-normal bg-white divide-y w-fit divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E] dark:divide-gray-600">
                    <ul class="text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                        <li class="">
                            <a href="{{ route('cgo.career-guidance.career-test.list') }}"
                                class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.career_test') }}</a>
                        </li>
                        <li>
                            <button id="doubleDropdownButton1" data-dropdown-toggle="doubleDropdown1"
                                data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.counseling') }}<svg
                                    class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg></button>
                            <div id="doubleDropdown1"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E]">
                                <ul class="text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="doubleDropdownButton">
                                    <li class="">
                                        <a href="{{ route('cgo.career-guidance.counseling.index', ['#my-schedule']) }}" class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.counseling_my_schedule') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="{{ route('cgo.career-guidance.counseling.index', ['#counseling-list']) }}"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.counseling_list') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.counseling_waiting') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <button id="doubleDropdownButton2" data-dropdown-toggle="doubleDropdown2"
                                data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.employment.root') }}<svg
                                    class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg></button>
                            <div id="doubleDropdown2"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E]">
                                <ul class="text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="doubleDropdownButton">
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.employment.employment_policy') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.employment.news_letter') }}</a>
                                    </li>

                                </ul>
                            </div>
                        </li>
                        <li>
                            <button id="doubleDropdownButton3" data-dropdown-toggle="doubleDropdown3"
                                data-dropdown-trigger="click" data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.job_information.root') }}<svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg></button>
                            <div id="doubleDropdown3"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E]">
                                <ul class="text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="doubleDropdownButton">
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.job_information.job_outlook') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.job_information.career_expert_interview') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.career_guidance.counseling_waiting') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a href="#" class="flex px-4 py-2.5 hover:bg-primary hover:text-white">Career
                                Guide</a>
                        </li>
                    </ul>
                </div>
            </li>
        @endif

        @if (activeGuard() != '' && Auth::guard(activeGuard())->check())
            <li class="box-border h-7">
                <button id="dropdownNavbarLink2" data-dropdown-toggle="dropdownNavbar2" data-dropdown-trigger="click"
                    class="flex items-center justify-between w-full py-2 px-3 text-[#91919A] md:hover:bg-transparent md:border-0 hover:text-blue-500 hover:border-b-4 hover:border-blue-500 md:hover:text-blue-500 md:p-0 md:w-auto dark:text-white md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('system.menu.' . activeGuard() . '.job_support.root', 'Job support') }} <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg></button>
                <!-- Dropdown menu -->
                <div id="dropdownNavbar2"
                    class="z-40 hidden font-normal bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E] dark:divide-gray-600">
                    <ul class="text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">
                        <li class="">
                            <a href="#" class="flex px-4 py-2.5 hover:bg-primary hover:text-white">Trainee
                                list</a>
                        </li>
                        <li class="">
                            <a href="#" class="flex px-4 py-2.5 hover:bg-primary hover:text-white">Company
                                list</a>
                        </li>

                    </ul>
                </div>
            </li>
        @endif


        <li class="box-border h-7">
            <button id="dropdownNavbarLink3" data-dropdown-toggle="dropdownNavbar3" data-dropdown-trigger="click"
                class="flex items-center justify-between w-full py-2 px-3 text-[#91919A] md:hover:bg-transparent md:border-0 hover:text-blue-500 hover:border-b-4 hover:border-blue-500 md:hover:text-blue-500 md:p-0 md:w-auto md:dark:hover:text-blue-500 dark:focus:text-white dark:border-gray-700 dark:hover:bg-gray-700 md:dark:hover:bg-transparent">{{ __('system.menu.information.root') }}<svg
                    class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 10 6">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m1 1 4 4 4-4" />
                </svg></button>
            <!-- Dropdown menu -->
            <div id="dropdownNavbar3"
                class="z-40 hidden font-normal bg-white divide-y w-fit divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E] dark:divide-gray-600">
                <ul class="text-sm text-gray-700 dark:text-gray-400" aria-labelledby="dropdownLargeButton">

                    @if (Auth::guard('cgo')->check())
                        <li>
                            <button id="doubleDropdownButton1" data-dropdown-toggle="doubleDropdownContentManagement"
                                data-dropdown-placement="right-start" type="button"
                                class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.content_management.root') }}<svg class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="m1 9 4-4-4-4" />
                                </svg></button>
                            <div id="doubleDropdownContentManagement"
                                class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E]">
                                <ul class="text-sm text-gray-700 dark:text-gray-200"
                                    aria-labelledby="doubleDropdownButton">
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.content_management.video') }}</a>
                                    </li>
                                    <li class="">
                                        <a href="#"
                                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.content_management.document') }}</a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endif

                    <li>
                        <a href="{{ route('informations.events.event') }}"
                            class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.event') }}</a>
                    </li>
                    <li>
                        <a href="{{ route('informations.qnas.list') }}" class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.qna') }}</a>
                    </li>
                    <li>
                        <button id="doubleDropdownButton2" data-dropdown-toggle="doubleDropdownNotice"
                            data-dropdown-placement="right-start" type="button"
                            class="flex items-center justify-between w-full px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.notice.root') }}<svg
                                class="w-2.5 h-2.5 ms-3 rtl:rotate-180" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 9 4-4-4-4" />
                            </svg></button>
                        <div id="doubleDropdownNotice"
                            class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow  dark:bg-[#1E1E1E]">
                            <ul class="text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="doubleDropdownButton">
                                <li class="">
                                    <a href="{{ route('cgo.infomation.notices.index', ['#notice']) }}"
                                        class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.notice.notice') }}</a>
                                </li>
                                <li class="">
                                    <a href="{{ route('cgo.infomation.notices.index', ['#faq']) }}"
                                        class="flex px-4 py-2.5 hover:bg-primary hover:text-white">{{ __('system.menu.information.notice.faq') }}</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                </ul>
            </div>
        </li>
    </ul>
</div>
