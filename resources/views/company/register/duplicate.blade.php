@extends('auth.layouts.master')

@section('title', 'Duplicated company information')

@section('content')
    <div class="flex flex-col gap-2.5 w-full bg-white px-4 md:px-8 py-6 rounded-xl  dark:bg-[#1E1E1E]">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Back Button -->
            <a href="{{ route('company.auth.register') }}"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                </svg>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('auth.company_register') }}</span>
            </a>

            @if (session()->get('error'))
                <span class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
            @endif

            <!-- Synchronized 3-column layout -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left column: Brand Icon -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/company-icon.png" alt="Company Icon" class="w-1/2 md:w-full">
                    <p class="text-primary dark:text-white font-semibold text-center text-base">{{ trans('auth.duplicate_company_warning') ?? 'The system detected that this company information already exists.' }}</p>
                </div>

                <!-- Right column: Detailed duplicate information content -->
                <div class="w-full flex flex-col gap-6 md:col-span-2">

                    <div class="space-y-6 leading-5">
                        <div class="flex gap-3 flex-col">
                            <div class="flex flex-col gap-2">
                                <h3 class="text-lg md:text-xl text-red-600 dark:text-red-400 font-semibold">
                                    {{ trans('auth.duplicate_company_message') }}
                                </h3>
                                @if($company->services)
                                    <p class="text-[#91919A] dark:text-gray-400 text-sm" id="expertise_heading_block">
                                        {{ $company->services }}
                                    </p>
                                @endif
                            </div>

                            <!-- Detailed table of the existing company information, keeping your data logic intact -->
                            <div class="bg-[#F8F9FA] dark:bg-[#2A2A2A] p-5 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm space-y-3">
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="col-span-1 sm:col-span-2">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.name') }}:</span>
                                        <span class="font-semibold text-gray-900 dark:text-white ml-1 break-words">{{ $company->name ?? 'N/G' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('company.my_page.business_registration_number') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->business_registration_number ?? 'N/G' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.table.label.office_type') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ getCodeNameByCodeId('office_type', $company->office_type) ?? 'N/G' }}</span>
                                    </div>

                                    <div class="col-span-1 sm:col-span-2">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.company_information') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ getCodeNameByCodeId('company_information', $company->company_information) ?? 'N/G' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.ds_division') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ ($company->dsDivision ? $company->dsDivision->ds_name : '') ?? 'N/G' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.enterprise') }}:</span>
                                        <span class="font-medium text-primary dark:text-blue-400 ml-1 break-words">{{ getCodeNameByCodeId('Enterprise_type', $company->enterprise_id) ?? 'No information' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.owner') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->name_of_representation ?? '' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.number_of_workers') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->number_workers ?? 0 }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.email') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->email }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.telephone') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->hotline ?? '' }}</span>
                                    </div>

                                    <div class="col-span-1 sm:col-span-2">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.co_business') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->co_business ?? '' }}</span>
                                    </div>

                                    <div>
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.founded') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ date('Y-m-d', strtotime($company->date_of_establishment)) }}</span>
                                    </div>

                                    <div class="col-span-1 sm:col-span-2">
                                        <span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('trainee.job_support.company.company_details.location') }}:</span>
                                        <span class="font-medium text-gray-900 dark:text-white ml-1 break-words">{{ $company->getDistrict() . '. ' . $company->address }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation button group below the form -->
                        <div class="flex flex-col sm:flex-row gap-4 justify-between w-full pt-4">
                            <a href="/company/register"
                               class="w-full sm:w-1/2 text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-5 py-3 text-center transition block">
                                {{ __('auth.continue_register_other_company') }}
                            </a>
                            <a href="/company/auth/signup"
                               class="w-full sm:w-1/2 text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-5 py-3 text-center transition block">
                                {{ __('auth.continue_register_account') }}
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
