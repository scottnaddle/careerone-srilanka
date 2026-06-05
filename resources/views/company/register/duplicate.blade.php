@extends('company.auth.layouts.master')

@section('title', 'Duplicated company information')

@section('content')
    <div class="max-w-2xl min-w-[40rem] mx-auto w-full leading-9 py-24 px-7 flex h-auto mb-10 items-start">
        <div
            class="bg-white shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5 dark:bg-gray-800 dark:border-gray-700 w-full">
            <div class="flex flex-col gap-6">
                <a href="{{ route('company.auth.register') }}"
                   class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl text-sm w-fit text-center inline-flex items-center">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                         xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="m15 19-7-7 7-7" />
                    </svg>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">{{__('auth.company_register')}}</span>
                </a>

                @if (session()->get('error'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif

                <div class="space-y-6 leading-5" >
                    <div class="flex gap-3 flex-col">
                        <div class="flex flex-col gap-3">
                            <div class="flex justify-between">
                                <p class="text-base md:text-xl text-[#464559] dark:text-white font-semibold">{{trans('auth.duplicate_company_message')}}</p>

                            </div>
                            <p class="text-[#91919A] dark:text-white" id="expertise_heading_block">
                                {{ $company->services }}
                            </p>
                        </div>
                        <div class="flex flex-col gap-3 p-3 w-full">

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.name') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->name ?? 'N/G' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{trans('company.my_page.business_registration_number')}}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->business_registration_number ?? '' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.table.label.office_type') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ getCodeNameByCodeId('office_type', $company->office_type) ?? 'N/G' }}</span>
                            </div>

                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{trans('trainee.job_support.company.company_details.company_information')}}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ getCodeNameByCodeId('company_information', $company->company_information) ?? 'N/G' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{trans('trainee.job_support.company.company_details.ds_division')}}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ ($company->dsDivision ? $company->dsDivision->ds_name : '') ?? 'N/G' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.enterprise') }}</span>
                                <span
                                   class="text-[#706F81] hover:underline hover:text-primary w-full  dark:text-white break-words">{{getCodeNameByCodeId('Enterprise_type', $company->enterprise_id) ?? 'No information'}}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.owner') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->name_of_representation ?? '' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.number_of_workers') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->number_workers ?? 0 }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.email') }}</span>
                                <span class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->email }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{trans('trainee.job_support.company.company_details.telephone')}}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->hotline ?? '' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.co_business') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->co_business ?? '' }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.founded') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ date('Y-m-d', strtotime($company->date_of_establishment)) }}</span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 w-full">
                                <span
                                    class="text-[#464559] font-medium w-full   dark:text-white break-words">{{ trans('trainee.job_support.company.company_details.location') }}</span>
                                <span
                                    class="text-[#706F81] w-full  dark:text-white break-words">{{ $company->getDistrict() . '. ' . $company->address }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="flex gap-4 items-center flex-col">
                        <a href="/company/register"
                           class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('auth.continue_register_other_company')}}
                        </a>
                        <a href="/company/auth/signup"
                           class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{__('auth.continue_register_account')}}
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
