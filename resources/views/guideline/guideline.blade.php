@extends('homepage.layouts.master')
@section('title', 'Guideline')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('general.User Manual') }}</p>
        <div class="bg-white dark:bg-[#1E1E1E] p-4 rounded-xl">
            <div class="mb-4">
                <ul class="flex flex-wrap font-medium text-center" id="default-tab" data-tabs-toggle="#default-tab-content"
                    role="tablist">
                    <li class="me-2" role="presentation">
                        <a href="#trainee"
                            class="tab flex items-center p-2.5 gap-4 rounded-sm font-semibold bg-gray-100 border-b-2"
                            id="trainee-tab" data-tabs-target="#trainee" role="tab" aria-controls="trainee"
                            aria-selected="true">
                            <img src="{{ asset('images/trainee.webp') }}" class="h-8 w-8" alt="Trainee"> {{trans('system.trainee')}}
                        </a>
                    </li>
                    <li class="me-2" role="presentation">
                        <a href="#cgo"
                            class="tab flex items-center p-2.5 gap-4 rounded-sm font-semibold bg-gray-100 border-b-2"
                            id="cgo-tab" data-tabs-target="#cgo" role="tab" aria-controls="cgo" aria-selected="false">
                            <img src="{{ asset('images/cgo.webp') }}" class="h-8 w-8" alt="CGO">{{trans('system.cgo')}}
                        </a>

                    </li>
                    <li class="me-2" role="presentation">
                        <a href="#company"
                            class="tab flex items-center p-2.5 gap-4 rounded-sm font-semibold bg-gray-100 border-b-2"
                            id="company-tab" data-tabs-target="#company" role="tab" aria-controls="company"
                            aria-selected="false">
                            <img src="{{ asset('images/company.webp') }}" class="h-8 w-8" alt="Company">{{trans('system.company')}}
                        </a>
                    </li>
                   {{-- <li class="me-2" role="presentation">
                       <a href="#tvec"
                           class="tab flex items-center p-2.5 gap-4 rounded-sm font-semibold bg-gray-100 border-b-2"
                           id="tvec-tab" data-tabs-target="#tvec" role="tab" aria-controls="cgo"
                           aria-selected="false">
                           <img src="{{ asset('images/admin.png') }}" class="h-8 w-8" alt=""> TVEC
                       </a>
                   </li> --}}
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-4 rounded-lg flex flex-col xl:flex-row gap-4 xl:gap-16" id="trainee" role="tabpanel"
                    aria-labelledby="trainee-tab">
                    <div class="w-full xl:w-1/3 relative">
                        <img src="{{ asset('images/guideline/trainee.webp') }}" class="w-full object-cover rounded-xl"
                            alt="Trainee">
                        <div class="absolute top-0 p-6 flex flex-col gap-4">
                            <p class="text-primary text-2xl md:text-3xl font-semibold">{{trans('system.trainee')}}</p>
                            <p class="text-primary">
                                {{trans('system.guideline_trainee')}}
                            </p>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3 flex flex-col gap-4 md:gap-8">
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">1.
                                    </span>{{ trans('general.Career Guidance') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Career Test') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Request counselling') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Portfolio management') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">2.
                                    </span>{{ trans('general.Job support') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Job information') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.OJT information') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">3.
                                    </span>{{ trans('general.Information') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Employment support') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Job / Career Information') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Event and Q&A') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col xl:flex-row gap-4 justify-between items-center">
                            <div class="w-full">
                                <a href="/trainee/download-user-manual/{{app()->getLocale()}}">
                                    <button
                                        class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center gap-2">{{trans('system.menu.download_user_manual')}} <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                                                                                                                                                          stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>

                                    </button>
                                </a>
                            </div>

                            <div class="w-full">
                                <a href="https://careerone.gov.lk/informations/faqs/1" target="_blank"
                                   class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center gap-2">{{trans('general.Watch User Guide')}}</a>
                            </div>

                        </div>
                    </div>

                </div>

                <div class="hidden p-4 rounded-lg flex flex-col xl:flex-row gap-4 xl:gap-16" id="cgo"
                    role="tabpanel" aria-labelledby="cgo-tab">
                    <div class="w-full xl:w-1/3 relative">
                        <img src="{{ asset('images/guideline/cgo.webp') }}" class="w-full object-cover rounded-xl"
                            alt="CGO">
                        <div class="absolute top-0 p-6 flex flex-col gap-4">
                            <p class="text-primary text-2xl md:text-3xl font-semibold">{{trans('system.cgo')}}</p>
                            <p class="text-primary">
                                {{trans('system.guideline_cgo')}}
                            </p>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3 flex flex-col gap-4 md:gap-8">
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span
                                        class="text-primary">1.</span>{{ trans('general.Career Guidance') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Counselling') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Content management') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Event planning') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">2.
                                    </span>{{ trans('general.Job support') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Job matching') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.OJT management') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">3.
                                    </span>{{ trans('general.Information') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Employment support') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Job / Career Information') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Event and Q&A') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col xl:flex-row w-full gap-4 flex-col md:flex-row">
                        <div class="w-full">
                        <a href="javascript:void(0);"
                        onclick="openModal()"
                        class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-12 py-3 flex items-center gap-2">
                         {{ trans('system.menu.download_user_manual') }}
                         <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                              stroke-width="1.5" stroke="currentColor" class="size-5">
                             <path stroke-linecap="round" stroke-linejoin="round"
                                   d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                         </svg>
                        </a></div>
                        <div class="w-full">
                            <a href="https://careerone.gov.lk/informations/faqs/5" target="_blank"
                               class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center gap-2">{{trans('general.Watch User Guide')}}</a>
                        </div>
                        </div>

                     <!-- Modal -->
                     <div id="downloadModal" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                        <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-md relative">
                          <button onclick="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                              <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                          </button>

                          <h2 class="text-xl font-bold text-gray-700 mb-6 text-center">Select File to Download</h2>

                          <div class="flex flex-col gap-4">
                            <a href="/cgo/download-user-manual/{{app()->getLocale()}}"
                               class="bg-[#4984F6] hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-center">
                              {{ trans('system.menu.download_user_manual') }}
                            </a>
                            <a href="{{route('cgo.download-user-manual-simple', ['language'=>app()->getLocale()])}}"
                               class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl text-center">
                              {{ trans('system.menu.download_user_manual') }} Simple
                            </a>
                          </div>
                        </div>
                      </div>


                    </div>

                </div>

                <div class="hidden p-4 rounded-lg flex flex-col xl:flex-row gap-4 xl:gap-16" id="company"
                    role="tabpanel" aria-labelledby="company-tab">
                    <div class="w-full xl:w-1/3 relative">
                        <img src="{{ asset('images/guideline/company.webp') }}" class="w-full object-cover rounded-xl"
                            alt="Company">
                        <div class="absolute top-0 p-6 flex flex-col gap-4">
                            <p class="text-primary text-2xl md:text-3xl font-semibold">{{trans('system.company')}}</p>
                            <p class="text-primary">
                                {{trans('system.guideline_company')}}
                            </p>
                        </div>
                    </div>
                    <div class="w-full md:w-2/3 flex flex-col gap-4 md:gap-8">
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">1.
                                    </span>{{ trans('general.Job support') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Providing jobs') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Recruitment of trainees') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.OJT management') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex w-full flex-col md:flex-row">
                            <div class="flex items-start w-full md:w-1/2">
                                <p class="text-xl md:text-2xl font-semibold dark:text-white"><span class="text-primary">2.
                                    </span>{{ trans('general.Information') }}</p>
                            </div>
                            <div class="flex flex-col items-start w-full md:w-1/2">
                                <ul class="text-gray-500 list-disc list-inside dark:text-gray-400">
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Employment support') }}
                                    </li>
                                    <li class="text-sm md:text-base text-[#706F81] dark:text-white">
                                        {{ trans('general.Event and Q&A') }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="flex flex-col xl:flex-row w-full gap-4 flex-col md:flex-row">
                            <div class="w-full">
                                <a href="javascript:void(0);"
                                onclick="openModalCompany()"
                                class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-base px-12 py-3 flex items-center gap-2">
                                 {{ trans('system.menu.download_user_manual') }}
                                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                      stroke-width="1.5" stroke="currentColor" class="size-5">
                                     <path stroke-linecap="round" stroke-linejoin="round"
                                           d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3"/>
                                 </svg>
                             </a>

                             <!-- Modal -->
                             <div id="downloadModalCompany" class="fixed inset-0 bg-black bg-opacity-50 hidden justify-center items-center z-50">
                                <div class="bg-white rounded-2xl shadow-lg p-8 w-11/12 max-w-md relative">
                                  <button onclick="closeModalCompany()" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                      <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                  </button>

                                  <h2 class="text-xl font-bold text-gray-700 mb-6 text-center">Select File to Download</h2>

                                  <div class="flex flex-col gap-4">
                                    <a href="{{route('company.download-user-manual', ['language'=>app()->getLocale()])}}"
                                       class="bg-[#4984F6] hover:bg-blue-700 text-white font-semibold py-3 rounded-xl text-center">
                                      {{ trans('system.menu.download_user_manual') }}
                                    </a>
                                    <a href="{{route('company.download-user-manual-simple', ['language'=>app()->getLocale()])}}"
                                       class="bg-green-500 hover:bg-green-600 text-white font-semibold py-3 rounded-xl text-center">
                                      {{ trans('system.menu.download_user_manual') }} Simple
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="w-full">
                                <a href="https://careerone.gov.lk/informations/faqs/2" target="_blank"
                                   class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                    text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 flex items-center gap-2">{{trans('general.Watch User Guide')}}</a>
                            </div>

                        </div>

                    </div>

                </div>
                <div class="hidden p-4 rounded-lg flex flex-col xl:flex-row gap-4 xl:gap-16" id="tvec"
                    role="tabpanel" aria-labelledby="tvec-tab">
                    <div class="w-full xl:w-1/3 relative">
                        <img src="{{ asset('images/guideline/logoTVEC.png') }}" class="w-full object-cover rounded-xl"
                            alt="TVEC">
                        {{-- <div class="absolute top-0 p-6 flex flex-col gap-4">
                            <p class="text-primary text-2xl md:text-3xl">Company</p>
                            <p class="text-primary">
                                Support career development and
                                employment for self-growth as a
                                future growth engine
                            </p>
                        </div> --}}
                    </div>
                    <div class="w-full md:w-2/3 flex flex-col gap-4 md:gap-8">
                        <div class="w-full md:w-2/3 flex flex-col gap-4 md:gap-8">
                            <!-- Dashboard Section -->
                            <div class="menu-section flex w-full flex-col md:flex-row" style="animation-delay: 0s">
                                <div class="flex items-start w-full md:w-1/2">
                                    <p class="text-xl md:text-2xl font-semibold dark:text-white">
                                        <span class="text-[#4984F6] dark:text-white">1. </span>Dashboard
                                    </p>
                                </div>
                                <div class="flex flex-col items-start w-full md:w-1/2">
                                    <ul class="text-gray-500 list-disc list-inside">
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Overview</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">CGO Performance</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Institute Performance</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Company Performance</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Career Guidance Section -->
                            <div class="menu-section flex w-full flex-col md:flex-row" style="animation-delay: 0.2s">
                                <div class="flex items-start w-full md:w-1/2">
                                    <p class="text-xl md:text-2xl font-semibold dark:text-white">
                                        <span class="text-[#4984F6] dark:text-white">2. </span>Career Guidance
                                    </p>
                                </div>
                                <div class="flex flex-col items-start w-full md:w-1/2">
                                    <ul class="text-gray-500 list-disc list-inside">
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Career Test</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Counseling</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Job Support Section -->
                            <div class="menu-section flex w-full flex-col md:flex-row" style="animation-delay: 0.4s">
                                <div class="flex items-start w-full md:w-1/2">
                                    <p class="text-xl md:text-2xl font-semibold dark:text-white">
                                        <span class="text-[#4984F6] dark:text-white">3. </span>Job Support
                                    </p>
                                </div>
                                <div class="flex flex-col items-start w-full md:w-1/2">
                                    <ul class="text-gray-500 list-disc list-inside">
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Job Posting</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">OJT List</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Company List</li>
                                    </ul>
                                </div>
                            </div>

                            <!-- Information Section -->
                            <div class="menu-section flex w-full flex-col md:flex-row" style="animation-delay: 0.6s">
                                <div class="flex items-start w-full md:w-1/2">
                                    <p class="text-xl md:text-2xl font-semibold dark:text-white">
                                        <span class="text-[#4984F6] dark:text-white">4. </span>Information
                                    </p>
                                </div>
                                <div class="flex flex-col items-start w-full md:w-1/2">
                                    <ul class="text-gray-500 list-disc list-inside">
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] p-1 dark:text-white">Content
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Content List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Content Approval List</li>
                                            </ul>
                                        </li>
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] p-1 dark:text-white">Events
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Event List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Event Approval List</li>
                                            </ul>
                                        </li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Q&A</li>
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Notice</li>
                                    </ul>
                                </div>
                            </div>
                            <div class="menu-section flex w-full flex-col md:flex-row" style="animation-delay: 0.6s">
                                <div class="flex items-start w-full md:w-1/2">
                                    <p class="text-xl md:text-2xl font-semibold dark:text-white">
                                        <span class="text-[#4984F6] dark:text-white">5. </span>Membership
                                    </p>
                                </div>
                                <div class="flex flex-col items-start w-full md:w-1/2">
                                    <ul class="text-gray-500 list-disc list-inside">
                                        <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Trainee</li>
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] p-1 dark:text-white">Cgo
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Cgo List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Cgo Approval List</li>
                                            </ul>
                                        </li>
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] p-1 dark:text-white">Company
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Company List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] p-1 dark:text-white">Company Approval List</li>
                                            </ul>
                                        </li>
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] dark:text-white p-1">Administrator
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81] dark:text-white p-1">Administrator List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] dark:text-white p-1">Administrator Approval List</li>
                                            </ul>
                                        </li>
                                        <li class="menu-item has-submenu text-sm md:text-base text-[#706F81] dark:text-white p-1">Company Recruiter <span id="content"></span>
                                            <ul class="submenu">
                                                <li class="menu-item text-sm md:text-base text-[#706F81]  dark:text-white p-1">Company Recruiter List</li>
                                                <li class="menu-item text-sm md:text-base text-[#706F81] dark:text-white p-1">Company Recruiter Approval List</li>
                                            </ul>
                                        </li>

                                    </ul>
                                </div>
                            </div>

                            <!-- Download Button -->
                            <a href="#" class="w-fit text-center text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300
                                font-medium rounded-full text-base px-12 py-3 flex items-center gap-2 transition-colors">
                                Download user manual
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" class="w-5 h-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

            </div>


        </div>
    </div>
@endsection
@push('css')
    <style>
        .submenu-active {
            display: block !important;
        }

        .rotate-180 {
            transform: rotate(180deg);
        }
    </style>
        <style>
            .menu-section {
                opacity: 0;
                transform: translateY(20px);
                animation: fadeInUp 0.5s forwards;
            }

            @keyframes fadeInUp {
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .menu-item:hover {
                background-color: rgba(73, 132, 246, 0.1);
                border-radius: 4px;
            }

            .submenu {
                display: block;
                padding-left: 20px;
            }

            .submenu.active {
                display: block;
            }

            .has-submenu::after {
                font-size: 10px;
                padding-left: 20px;
            }
            .dark-mode {
                background-color: #1a1a1a;
                color: white;
            }
        </style>
@endpush
@push('js')
<script>
    function openModal() {
      $('#downloadModal').removeClass('hidden').addClass('flex');
    }
    function closeModal() {
      $('#downloadModal').addClass('hidden').removeClass('flex');
    }
    function openModalCompany() {
      $('#downloadModalCompany').removeClass('hidden').addClass('flex');
    }
    function closeModalCompany() {
      $('#downloadModalCompany').addClass('hidden').removeClass('flex');
    }
  </script>
    <script>
        $(document).ready(function() {
            const hash = window.location.hash;
            if (hash) {
                const $tabLink = $(`a[href="${hash}"]`);
                const $tabContent = $(hash);

                if ($tabLink.length && $tabContent.length) {
                    // Remove active classes from other tabs
                    $('[role="tab"]').removeClass("bg-gray-100 border-primary").attr("aria-selected", "false");
                    $('[role="tabpanel"]').addClass("hidden");

                    // Activate the selected tab and content
                    $tabLink.addClass("bg-gray-100 border-primary").attr("aria-selected", "true");
                    $tabContent.removeClass("hidden");
                }
            }
            $(".tab").click(function() {
                $(".tab").removeClass("bg-gray-100 border-primary").attr("aria-selected", "false");
                $(this).addClass("bg-gray-100 border-primary").attr("aria-selected", "true");
            });
        });

        function toggleSubmenu(menuId) {
            const submenu = document.getElementById(menuId);
            submenu.classList.toggle('submenu-active');

            // Toggle arrow rotation
            const button = submenu.previousElementSibling.querySelector('svg');
            button.classList.toggle('rotate-180');
        }
    </script>
    <script>
        // Handle submenu toggles
        document.querySelectorAll('.has-submenu').forEach(item => {
            item.addEventListener('click', (e) => {
                e.preventDefault();
                const submenu = item.querySelector('.submenu');
                submenu.classList.toggle('active');
            });
        });

        // Add hover effect for menu items
        document.querySelectorAll('.menu-item').forEach(item => {
            item.addEventListener('mouseenter', () => {
                item.style.transition = 'background-color 0.3s';
            });
        });

        // Optional: Add dark mode toggle
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
        }

        // Add fade-in animation on scroll
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        });

        document.querySelectorAll('.menu-section').forEach((el) => observer.observe(el));
    </script>
@endpush
