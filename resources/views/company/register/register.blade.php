@extends('auth.layouts.master')

@section('title', 'Register new company')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray !important;
        }
        /* Hide default tab */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: flex;
        }

        /* ---------------------------------------------------
           Customize Select2 to match Tailwind Input (h-11, rounded-xl)
        --------------------------------------------------- */
        .select2-container--default .select2-selection--single {
            height: 2.75rem !important; /* h-11 (44px) */
            background-color: #F9FAFB !important; /* bg-gray-50 */
            border: 1px solid #D1D5DB !important; /* border-gray-300 */
            border-radius: 0.75rem !important; /* rounded-xl */
            display: flex !important;
            align-items: center;
            padding-left: 0.5rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #111827 !important; /* text-gray-900 */
            font-size: 0.875rem !important; /* sm:text-sm */
            padding-left: 0.5rem !important;
            line-height: normal !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100% !important;
            top: 0 !important;
            right: 0.75rem !important;
            display: flex;
            align-items: center;
        }

        /* Select2 for Dark Mode */
        .dark .select2-container--default .select2-selection--single {
            background-color: #1E1E1E !important; /* dark:bg-[#1E1E1E] */
            border-color: #6B7280 !important; /* dark:border-gray-500 */
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important; /* dark:text-white */
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
        }
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-col gap-2.5 w-full bg-white px-4 md:px-8 py-6 rounded-xl  dark:bg-[#1E1E1E]">
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>
        <div class="flex flex-col gap-6">
            <a href="{{ route('company.auth.register') }}" class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                </svg>
                <span class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('auth.Organisation Registration') }}</span>
            </a>

            @if (session()->get('error'))
                <span class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Left column: Unified layout matching CGO -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/company-icon.png" alt="Company Icon" class="w-1/2 md:w-full">
                    <p class="text-primary font-semibold text-center text-xl">{{ trans('auth.register_new_organization') ?? 'You are registering a new organization.' }}</p>
                </div>

                <!-- Right column: Tab-switching form -->
                <div class="w-full flex flex-col items-center justify-center gap-10 md:col-span-2">
                    <!-- Stepper -->
                    <ol class="flex items-center justify-center w-full md:w-3/4 text-sm font-medium text-center text-[#404040] dark:text-gray-400 sm:text-base">
                        <li class="stepper-item flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-[#EAEAEA] after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 md:whitespace-nowrap">
                                <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">1</span>
                                {{ trans('auth.organization_info') ?? 'Organization Info' }}
                            </span>
                        </li>
                        <li class="stepper-item flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-[#EAEAEA] after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 md:whitespace-nowrap">
                                <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">2</span>
                                {{ trans('auth.office_details') ?? 'Office Details' }}
                            </span>
                        </li>
                        <li class="stepper-item flex items-center md:whitespace-nowrap">
                            <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">3</span>
                            {{ trans('auth.confirmation') ?? 'Confirmation' }}
                        </li>
                    </ol>

                    <!-- Main form -->
                    <form class="w-full md:w-1/2 space-y-6 leading-5" action="{{ route('company.register.post-register') }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="registrationForm">
                        @csrf

                        <!-- TAB 1: Organization & Enterprise Type Selection -->
                        <div class="tab-content active flex-col gap-4" id="tab-0">
                            <div>
                                <label for="enterpriseSelect" class="text-sm font-medium text-[#404040] block dark:text-gray-300 mb-1">
                                    {{ __('auth.Company information') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <select class="select2 mb-0 w-full" id="enterpriseSelect" name="company_information" data-placeholder="{{ __('auth.Please select one') }}" required>
                                    <option></option>
                                    @foreach(getCodeList('company_information')->sortBy('code_name') as $company_information)
                                        <option value="{{$company_information->code_id}}" {{ old('company_information') == $company_information->code_id ? 'selected' : '' }}>
                                            {{$company_information->code_name}}
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('company_information')) <span class="text-red-600 text-xs">{{ $errors->first('company_information') }}</span> @endif
                            </div>

                            <!-- Ministry Fields -->
                            <div id="ministry_name_container" class="hidden">
                                <label for="ministry_name" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Ministry name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="ministry_name" id="ministry_name" value="{{ old('ministry_name') }}" placeholder="{{ __('auth.Ministry of Education, Higher Education and Vocational Education') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('ministry_name')) <span class="text-red-600 text-xs">{{ $errors->first('ministry_name') }}</span> @endif
                            </div>

                            <div id="name_of_organisation_container" class="hidden">
                                <label for="name_of_organisation" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Name of organisation under the Ministry (if applicable)') }}</label>
                                <input type="text" name="organisation_name" id="name_of_organisation" value="{{ old('organisation_name') }}" placeholder="{{ __('auth.Tertiary and Vocational Education Commission (TVEC)') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('organisation_name')) <span class="text-red-600 text-xs">{{ $errors->first('organisation_name') }}</span> @endif
                            </div>

                            <!-- Business Registration Numbers -->
                            <div id="business_registration_number_container" class="hidden flex-col">
                                <label for="business_registration_number" class="text-sm font-medium text-[#404040] block dark:text-gray-300 mb-1">{{ __('auth.Business Registration Number') }} <span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="business_registration_number" id="business_registration_number" value="{{ old('business_registration_number') }}" placeholder="XXXX XXXX XXXX" class="w-full p-3 pl-4 h-11 bg-white border border-gray-300 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('business_registration_number')) <span class="text-red-600 text-xs">{{ $errors->first('business_registration_number') }}</span> @endif
                            </div>

                            <!-- Company Name -->
                            <div id="company_name_container" class="hidden">
                                <label for="name" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Company name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{ __('auth.Type the company name') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('name')) <span class="text-red-600 text-xs">{{ $errors->first('name') }}</span> @endif
                            </div>

                            <div id="business_registration_number_container_1" class="hidden flex-col">
                                <label for="business_registration_number_1" class="text-sm font-medium text-[#404040] block dark:text-gray-300 mb-1">{{ __('auth.Registration number (if applicable)') }}</label>
                                <input type="text" name="business_registration_number_1" id="business_registration_number_1" value="{{ old('business_registration_number_1') }}" placeholder="{{ trans('auth.Type the registration number if applicable') }}" class="w-full p-3 pl-4 h-11 bg-white border border-gray-300 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('business_registration_number_1')) <span class="text-red-600 text-xs">{{ $errors->first('business_registration_number_1') }}</span> @endif
                            </div>

                            <!-- Field of Operations -->
                            <div id="field_of_operations_container" class="hidden">
                                <label for="co_business" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Field of operations') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="co_business" id="co_business" value="{{ old('co_business') }}" placeholder="{{ __('auth.Environment conservation') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('co_business')) <span class="text-red-600 text-xs">{{ $errors->first('co_business') }}</span> @endif
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">{{ trans('auth.next') ?? 'Next' }}</button>
                            </div>
                        </div>

                        <!-- TAB 2: Office Structure Details & Contacts -->
                        <div class="tab-content flex-col gap-4" id="tab-1">
                            <!-- Office Type -->
                            <div id="office_type_container" class="hidden">
                                <label class="text-sm font-medium text-[#404040] block mb-2 dark:text-gray-300">{{ __('auth.Office Type') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="flex gap-6">
                                    @foreach(getCodeList('office_type') as $office_type)
                                        <div class="flex items-center">
                                            <input type="radio" name="office_type" value="{{$office_type->code_id}}" {{ old('office_type') == $office_type->code_id ? 'checked' : '' }} class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 dark:bg-neutral-800 dark:border-neutral-700" id="office-type-{{$office_type->code_id}}">
                                            <label for="office-type-{{$office_type->code_id}}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{$office_type->code_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('office_type')) <span class="text-red-600 text-xs">{{ $errors->first('office_type') }}</span> @endif
                            </div>

                            <!-- Headquarter Selection -->
                            <div class="hidden" id="input_headquarter">
                                <label for="headquarter" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Headquarter') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <select class="select2 mb-0 w-full" id="headquarter" name="headquarter_id" data-placeholder="{{ __('auth.Please select one') }}">
                                    <option></option>
                                    @foreach($headquarters as $headquarter)
                                        <option value="{{$headquarter->id}}" {{ old('headquarter_id') == $headquarter->id ? 'selected' : '' }}>{{$headquarter->name}} - {{$headquarter->website}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('headquarter_id')) <span class="text-red-600 text-xs">{{ $errors->first('headquarter_id') }}</span> @endif
                            </div>

                            <!-- Date of Establishment -->
                            <div id="date_of_establishment_container" class="hidden">
                                <label for="dateOfEstablishment" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.Date Of Establishment') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                        </svg>
                                    </div>
                                    <input id="dateOfEstablishment" name="date_of_establishment" type="text" class="bg-white dark:bg-[#1E1E1E] border border-gray-300 text-gray-900 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full h-11 pl-4 p-2 dark:border-gray-600 dark:text-white" value="{{ old('date_of_establishment') }}">
                                </div>
                                @if ($errors->has('date_of_establishment')) <span class="text-red-600 text-xs">{{ $errors->first('date_of_establishment') }}</span> @endif
                            </div>

                            <!-- Number of Workers -->
                            <div id="number_workers_container" class="hidden">
                                <label for="number_workers" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ __('auth.The number of workers') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="number_workers" id="number_workers" value="{{ old('number_workers') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('number_workers')) <span class="text-red-600 text-xs">{{ $errors->first('number_workers') }}</span> @endif
                            </div>

                            <!-- Email Dynamic Labels -->
                            <div>
                                <label for="email" class="text-sm font-medium text-[#404040] dark:text-gray-300 block mb-1 hidden" id="email-default-label">{{__('auth.E-mail')}}</label>
                                <label for="email" class="text-sm font-medium text-[#404040] dark:text-gray-300 block mb-1 hidden" id="email-government-label">{{__('auth.E-mail (official email for recruitment)')}}</label>
                                <label for="email" class="text-sm font-medium text-[#404040] dark:text-gray-300 block mb-1 hidden" id="email-non-government-label">{{__('auth.E-mail (your organisation’s email)')}}</label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="organisation@email.com" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('email')) <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span> @endif
                            </div>

                            <!-- District -->
                            <div>
                                <label for="districtSelect" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{__('auth.District')}}<span class="text-red-600 p-1 text-center">*</span></label>
                                <select class="select2 mb-0 w-full" id="districtSelect" name="district" data-placeholder="{{__('auth.Please select one')}}" required>
                                    <option></option>
                                    @foreach($districts as $district)
                                        <option value="{{$district->id}}" {{ old('district') == $district->id ? 'selected' : '' }}>{{$district->name}}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('district')) <span class="text-red-600 text-xs">{{ $errors->first('district') }}</span> @endif
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{__('auth.Address')}}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="address" id="address" value="{{ old('address') }}" class="bg-white border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white" required>
                                @if ($errors->has('address')) <span class="text-red-600 text-xs">{{ $errors->first('address') }}</span> @endif
                            </div>

                            <div class="flex justify-between pt-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">{{ trans('auth.previous') ?? 'Previous' }}</button>
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">{{ trans('auth.next') ?? 'Next' }}</button>
                            </div>
                        </div>

                        <!-- TAB 3: Review Confirmation & Document Attachment -->
                        <div class="tab-content flex-col gap-4" id="tab-2">
                            <!-- Summary information table -->
                            <div class="bg-[#F8F9FA] dark:bg-[#2A2A2A] p-5 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">
                                    {{ trans('auth.review_information') ?? 'Review Your Information' }}
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="col-span-1 sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ __('auth.Company name') }}:</span> <span id="summary-org-name" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ __('auth.Company information') }}:</span> <span id="summary-enterprise-type" class="font-medium"></span></div>
                                    <div class="col-span-1 sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ __('auth.E-mail') }}:</span> <span id="summary-email" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ __('auth.District') }}:</span> <span id="summary-district" class="font-medium"></span></div>
                                    <div class="col-span-1 sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ __('auth.Address') }}:</span> <span id="summary-address" class="font-medium"></span></div>
                                </div>
                            </div>

                            <!-- Attached File -->
                            <div id="attached_file_container" class="hidden">
                                <label for="attached_file" class="text-sm font-medium text-[#404040] dark:text-gray-300 block mb-1.5 hidden" id="attachment-label-default">{{__('auth.Attached file (Business License)')}}</label>
                                <label for="attached_file" class="text-sm font-medium text-[#404040] dark:text-gray-300 block mb-1.5 hidden" id="attachment-label-non-government">{{__('auth.Attached file (Certificate)')}}</label>
                                <input class="relative bg-white m-0 block w-full rounded-xl border border-gray-300 px-3 py-2 text-sm focus:border-primary focus:outline-none dark:border-white/70 dark:text-white" id="attached_file" type="file" name="attached_file[]" accept=".pdf, image/*" multiple />
                                <span class="text-red-600 text-xs block mt-1" id="attached_file_error">{{ $errors->first('attached_file') }}</span>
                            </div>

                            <div class="flex justify-between pt-4 gap-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">{{ trans('auth.previous') ?? 'Previous' }}</button>
                                <button type="submit" id="signup-button" disabled class="flex-1 text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 disabled-button">
                                    {{__('auth.Sign up')}}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        let currentTab = 0;

        function showTab(n) {
            let tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.classList.remove("active"));
            tabs[n].classList.add("active");

            // Update the Stepper to show the colored progress flow
            let steps = document.querySelectorAll(".stepper-item");
            steps.forEach((step, index) => {
                if (index <= n) {
                    step.classList.add("text-blue-600", "dark:text-blue-500");
                    step.classList.remove("text-[#404040]", "dark:text-gray-400");
                } else {
                    step.classList.remove("text-blue-600", "dark:text-blue-500");
                    step.classList.add("text-[#404040]", "dark:text-gray-400");
                }
            });

            // Automatically map the review summary information when entering Tab 3
            if (n === 2) {
                let enterpriseVal = $("#enterpriseSelect").val();
                let orgName = 'N/A';
                if (enterpriseVal == 1) {
                    orgName = document.getElementById('ministry_name').value;
                } else {
                    orgName = document.getElementById('name').value;
                }

                document.getElementById('summary-org-name').innerText = orgName || 'N/A';
                document.getElementById('summary-email').innerText = document.getElementById('email').value || 'N/A';
                document.getElementById('summary-address').innerText = document.getElementById('address').value || 'N/A';

                let entData = $('#enterpriseSelect').select2('data')[0];
                document.getElementById('summary-enterprise-type').innerText = entData && entData.text ? entData.text.trim() : 'N/A';

                let districtData = $('#districtSelect').select2('data')[0];
                document.getElementById('summary-district').innerText = districtData && districtData.text ? districtData.text.trim() : 'N/A';

                if (typeof window.toggleSignUpButton === "function") {
                    window.toggleSignUpButton();
                }
            }
        }

        window.nextPrev = function(n) {
            if (n === 1 && !validateFormTab(currentTab)) return false;
            currentTab = currentTab + n;
            showTab(currentTab);
        }

        function validateFormTab(tabIndex) {
            let tabs = document.querySelectorAll(".tab-content");
            let inputs = tabs[tabIndex].querySelectorAll("input[required], select[required]");
            for (let i = 0; i < inputs.length; i++) {
                if (!inputs[i].checkValidity()) {
                    inputs[i].reportValidity();
                    return false;
                }
            }

            // Custom logic to check the select2 fields or show/hide radios on each tab
            if (tabIndex === 0) {
                if (!$('#enterpriseSelect').val()) {
                    alert("{{ trans('auth.please_select_enterprise_type') ?? 'Please select Company information type.' }}");
                    return false;
                }
            }
            if (tabIndex === 1) {
                if (!$('#districtSelect').val()) {
                    alert("{{ trans('auth.please_select_district') ?? 'Please select your District.' }}");
                    return false;
                }
                // If it is a branch office type but no headquarter has been selected
                if (!$("#input_headquarter").hasClass('hidden') && !$("#headquarter").val()) {
                    alert("{{ trans('auth.please_select_headquarter') ?? 'Please select Headquarter office.' }}");
                    return false;
                }
            }
            return true;
        }
    </script>

    <script type="module">
        $(document).ready(function() {
            showTab(currentTab);

            $('.select2').select2({
                placeholder: "{{__('auth.Please select one')}}"
            });

            let datepickerEl = document.getElementById('dateOfEstablishment');
            if (datepickerEl) {
                new Datepicker(datepickerEl, {
                    format: 'yyyy-mm-dd',
                    maxDate: new Date(),
                    autohide: true
                });
            }

            window.toggleOfficeType = function() {
                const val = $("#enterpriseSelect").val();
                const containers = {
                    ministry: $("#ministry_name_container"),
                    organisation: $("#name_of_organisation_container"),
                    businessReg: $("#business_registration_number_container"),
                    businessReg1: $("#business_registration_number_container_1"),
                    company: $("#company_name_container"),
                    officeType: $("#office_type_container"),
                    establishment: $("#date_of_establishment_container"),
                    workers: $("#number_workers_container"),
                    file: $("#attached_file_container"),
                    operations: $("#field_of_operations_container"),
                    emailDefaultLabel: $("#email-default-label"),
                    emailGovernmentLabel: $("#email-government-label"),
                    emailNonGovernmentLabel: $("#email-non-government-label"),
                    attachmentLabelDefault: $("#attachment-label-default"),
                    attachmentLabelNonGovernment: $("#attachment-label-non-government")
                };

                Object.values(containers).forEach(container => {
                    container.addClass('hidden');
                    container.find('[required]').prop('required', false);
                });

                $('#name, #ministry_name, #co_business, #business_registration_number, #number_workers, #dateOfEstablishment').prop('required', false);
                $("input[name='office_type']").prop('required', false);
                $("#headquarter").prop('required', false);

                if (val == 1) {
                    containers.ministry.removeClass('hidden');
                    containers.organisation.removeClass('hidden');
                    containers.emailGovernmentLabel.removeClass('hidden');
                    $('#ministry_name').prop('required', true);
                }
                else if (val == '' || [4, 5, 7].includes(Number(val))) {
                    [containers.businessReg, containers.company, containers.officeType,
                        containers.establishment, containers.workers, containers.file, containers.emailDefaultLabel].forEach(c => c.removeClass('hidden'));

                    $('#name, #business_registration_number, #dateOfEstablishment, #number_workers').prop('required', true);
                    $("input[name='office_type']").prop('required', true);
                    containers.attachmentLabelDefault.removeClass('hidden');
                }
                else if ([2, 3, 6].includes(Number(val))) {
                    [containers.businessReg1, containers.company, containers.officeType,
                        containers.file, containers.operations, containers.emailNonGovernmentLabel].forEach(c => c.removeClass('hidden'));

                    containers.attachmentLabelNonGovernment.removeClass('hidden');
                    $('#name, #co_business').prop('required', true);
                    $("input[name='office_type']").prop('required', true);
                }

                // Handle Headquarter
                const officeType = $("input[name='office_type']:checked").val();
                if (officeType == 2 && (val == '' || [2, 3, 4, 5, 6, 7].includes(Number(val)))) {
                    $("#input_headquarter").removeClass('hidden');
                    $("#headquarter").prop('required', true);
                } else {
                    $("#input_headquarter").addClass('hidden');
                    $("#headquarter").prop('required', false);
                }
            };

            window.toggleSignUpButton = function() {
                const enterpriseVal = $("#enterpriseSelect").val();
                let isValid = true;

                if (!$('#districtSelect').val() || !$('#address').val() || !$('#email').val()) {
                    isValid = false;
                }

                if (enterpriseVal == 1) {
                    if (!$('#ministry_name').val()) isValid = false;
                } else if (enterpriseVal && enterpriseVal != '') {
                    if (!$('#name').val()) isValid = false;
                }

                if (enterpriseVal == '' || [4, 5, 7].includes(Number(enterpriseVal))) {
                    const officeType = $("input[name='office_type']:checked").val();
                    if (!officeType || !$('#dateOfEstablishment').val() || !$('#number_workers').val() || !$('#business_registration_number').val()) {
                        isValid = false;
                    }
                    if (officeType == 2 && !$("#headquarter").val()) isValid = false;
                }
                else if ([2, 3, 6].includes(Number(enterpriseVal))) {
                    const officeType = $("input[name='office_type']:checked").val();
                    if (!officeType || !$('#co_business').val()) {
                        isValid = false;
                    }
                    if (officeType == 2 && !$("#headquarter").val()) isValid = false;
                }

                $('#signup-button').toggleClass('disabled-button', !isValid).prop('disabled', !isValid);
            };

            window.toggleOfficeType();
            window.toggleSignUpButton();

            $("#enterpriseSelect").on("change", function() {
                window.toggleOfficeType();
                setTimeout(window.toggleSignUpButton, 100);

                // Ajax to update the headquarter list
                $.ajax({
                    type:'GET',
                    url:'/company/register/get-headquarter?company_information='+ $(this).val(),
                    success: function(data) {
                        $('#headquarter').empty().append('<option></option>');
                        $.each(data.data, function(index, item) {
                            let website = item.website ? ' - ' + item.website : '';
                            $('#headquarter').append('<option value="' + item.id + '">' + item.name + website + '</option>');
                        });
                        $('#headquarter').trigger('change');
                    }
                });
            });

            $("input[name='office_type']").change(function() {
                const val = $(this).val();
                const entVal = $("#enterpriseSelect").val();
                if (val == 2 && (entVal == '' || [2, 3, 4, 5, 6, 7].includes(Number(entVal)))) {
                    $("#input_headquarter").removeClass('hidden');
                    $("#headquarter").prop('required', true);
                } else {
                    $("#input_headquarter").addClass('hidden');
                    $("#headquarter").prop('required', false);
                }
                window.toggleSignUpButton();
            });

            $('input, select').on('input change', function() {
                window.toggleSignUpButton();
            });

            $('#dateOfEstablishment').on('change', function() {
                setTimeout(window.toggleSignUpButton, 100);
            });
        });
    </script>
@endpush
