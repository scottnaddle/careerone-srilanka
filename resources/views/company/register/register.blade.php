@extends('auth.layouts.master')

@section('title', 'Register new company')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray;
        }

        .select2-container--default .select2-selection--single:is(.dark *) {
            background: #1E1E1E;
            border-color: #fff;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered:is(.dark *) {
            color: #fff !important;
        }
        .select2-container--default .select2-selection--single{
            background-color: #f9fafb;
            height: 3rem !important;
            font-size: 12px !important;
            padding-top: 0 !important;
            padding-bottom: 0!important;
            border-radius: 0.75rem; border-width: 2px !important; border-color: #e5e7eb !important;
        }
        .select2-selection__rendered {
            color: #000000 !important;
            height: 100% !important;
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-top: 0.75rem !important;
            padding-bottom: 0.75rem !important;
            padding-left: 1rem !important;
            font-size: 12px !important;
            line-height: 20px !important;
        }
        .select2-selection__arrow {
            height: 100% !important;
        }
    </style>
@endpush
@section('content')
    <div class="max-w-2xl min-w-[40rem] mx-auto w-full leading-9 py-24 px-7 flex h-auto mb-10 items-start">
        <div class="bg-white shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5 dark:bg-gray-800 dark:border-gray-700 w-full">
            <div class="flex flex-col gap-6">
                <a href="{{ route('company.auth.register') }}" class="text-gray-900 bg-white border-gray-200 font-medium rounded-xl text-sm w-fit text-center inline-flex items-center">
                    <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                    </svg>
                    <span class="text-xl font-semibold text-gray-900 dark:text-white">{{__('auth.Organisation Registration')}}</span>
                </a>

                @if (session()->get('error'))
                    <span class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif

                <form class="space-y-6 leading-5" action="{{ route('company.register.post-register') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div>
                        <label for="type_of_enterprise" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Company information')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <select class="select2 mb-0 bg-white" id="enterpriseSelect" name="company_information" style="width: 100%" data-placeholder="{{__('auth.Please select one')}}" required>
                            <option></option>
                            @forelse(getCodeList('company_information')->sortBy('code_name') as $company_information)
                                <option value="{{$company_information->code_id}}" {{ old('company_information') == $company_information->code_id ? 'selected' : '' }}>
                                    {{$company_information->code_name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('company_information'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('company_information') }}</span>
                        @endif
                    </div>

                    <!-- Ministry Fields -->
                    <div id="ministry_name_container" class="hidden">
                        <label for="ministry_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Ministry name')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="ministry_name" id="ministry_name" value="{{ old('ministry_name') }}" placeholder="{{__('auth.Ministry of Education, Higher Education and Vocational Education')}}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        @if ($errors->has('ministry_name'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('ministry_name') }}</span>
                        @endif
                    </div>

                    <div id="name_of_organisation_container" class="hidden">
                        <label for="name_of_organisation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Name of organisation under the Ministry (if applicable)')}}
                        </label>
                        <input type="text" name="organisation_name" id="name_of_organisation" value="{{ old('organisation_name') }}" placeholder="{{__('auth.Tertiary and Vocational Education Commission (TVEC)')}}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        @if ($errors->has('organisation_name'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('organisation_name') }}</span>
                        @endif
                    </div>
                    <!-- Business Registration Numbers -->
                    <div class="flex flex-col hidden" id="business_registration_number_container">
                        <label for="business_registration_number" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Business Registration Number')}} <span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="flex gap-4 mb-1">
                            <input type="text" name="business_registration_number" id="business_registration_number" value="{{ old('business_registration_number') }}"
                                   placeholder="XXXX XXXX XXXX"
                                   class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        </div>
                        @if ($errors->has('business_registration_number'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('business_registration_number') }}</span>
                        @endif
                    </div>
                    <!-- Company Fields -->
                    <div id="company_name_container" class="hidden">
                        <label for="name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Company name')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" placeholder="{{__('auth.Type the company name')}}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
{{--                        <span class="text-xs italic dark:text-white">{{__('auth.Enter the exact company name mentioned in the business registration certificate')}}</span>--}}
                        @if ($errors->has('name'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('name') }}</span>
                        @endif
                    </div>



                    <div class="flex flex-col hidden" id="business_registration_number_container_1">
                        <label for="business_registration_number_1" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Registration number (if applicable)')}}
                        </label>
                        <div class="flex gap-4 mb-1">
                            <input type="text" name="business_registration_number_1" id="business_registration_number_1" value="{{ old('business_registration_number_1') }}"
                                   placeholder="{{trans('auth.Type the registration number if applicable')}}"
                                   class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        </div>
                        @if ($errors->has('business_registration_number_1'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('business_registration_number_1') }}</span>
                        @endif
                    </div>

                    <!-- Field of Operations -->
                    <div id="field_of_operations_container" class="hidden">
                        <label for="co_business" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Field of operations')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="co_business" id="co_business" value="{{ old('co_business') }}" placeholder="{{__('auth.Environment conservation')}}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        @if ($errors->has('co_business'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('co_business') }}</span>
                        @endif
                    </div>

                    <!-- Office Type -->
                    <div id="office_type_container" class="hidden">
                        <label for="office_type" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Office Type')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach(getCodeList('office_type') as $office_type)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="office_type" value="{{$office_type->code_id}}" {{ old('office_type') == $office_type->code_id ? 'checked' : '' }}
                                    class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                           id="office-type-{{$office_type->code_id}}">
                                    <label for="office-type-{{$office_type->code_id}}" class="text-sm text-gray-500 ms-3 dark:text-neutral-400">
                                        {{$office_type->code_name}}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                        @if ($errors->has('office_type'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('office_type') }}</span>
                        @endif
                    </div>

                    <!-- Headquarter -->
                    <div class="hidden" id="input_headquarter">
                        <label for="headquarter" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Headquarter')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <select class="select2 mb-0 bg-white" id="headquarter" name="headquarter_id" style="width: 100%" data-placeholder="{{__('auth.Please select one')}}">
                            <option></option>
                            @forelse($headquarters as $headquarter)
                                <option value="{{$headquarter->id}}" {{ old('headquarter_id') == $headquarter->id ? 'selected' : '' }}>
                                    {{$headquarter->name}} - {{$headquarter->website}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('headquarter_id'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('headquarter_id') }}</span>
                        @endif
                    </div>

                    <!-- Date of Establishment -->
                    <div id="date_of_establishment_container" class="hidden">
                        <label for="default-datepicker" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Date Of Establishment')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center pe-3.5 pointer-events-none justify-end right-0">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z"/>
                                </svg>
                            </div>
                            <input id="dateOfEstablishment" name="date_of_establishment" type="text" class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" value="{{ old('date_of_establishment') }}">
                        </div>
                        @if ($errors->has('date_of_establishment'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('date_of_establishment') }}</span>
                        @endif
                    </div>

                    <!-- Number of Workers -->
                    <div id="number_workers_container" class="hidden">
                        <label for="number_workers" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.The number of workers')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="number_workers" id="number_workers" value="{{ old('number_workers') }}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        @if ($errors->has('number_workers'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('number_workers') }}</span>
                        @endif
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 hidden" id="email-default-label">
                            {{__('auth.E-mail')}}
                        </label>
                        <label for="email" class="font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 hidden" id="email-government-label">
                            {{__('auth.E-mail (official email for recruitment)')}}
                        </label>
                        <label for="email" class="font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 hidden" id="email-non-government-label">
                            {{__('auth.E-mail (your organisation’s email)')}}
                        </label>

                        <input type="email" name="email" id="email" value="{{ old('email') }}" placeholder="organisation@email.com"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                        @if ($errors->has('email'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <!-- District -->
                    <div>
                        <label for="district_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.District')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <select class="select2 mb-0" id="districtSelect" name="district" style="width: 100%" data-placeholder="{{__('auth.Please select one')}}" required>
                            <option></option>
                            @forelse($districts as $district)
                                <option value="{{$district->id}}" {{ old('district') == $district->id ? 'selected' : '' }}>
                                    {{$district->name}}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('district'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('district') }}</span>
                        @endif
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                            {{__('auth.Address')}}<span class="text-red-500 ml-0.5">*</span>
                        </label>
                        <input type="text" name="address" id="address" value="{{ old('address') }}"
                               class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" required>
                        @if ($errors->has('address'))
                            <span class="mt-1 text-xs text-red-500">{{ $errors->first('address') }}</span>
                        @endif
                    </div>

                    <!-- Attached File -->
                    <div id="attached_file_container" class="hidden">
                        <label for="attached_file" class="font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 hidden" id="attachment-label-default">
                            {{__('auth.Attached file (Business License)')}}
                        </label>
                        <label for="attached_file" class="font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 hidden" id="attachment-label-non-government">
                            {{__('auth.Attached file (Certificate)')}}
                        </label>
                        <input class="block w-full cursor-pointer rounded-xl border-2 border-gray-200 bg-gray-50 px-4 py-3 text-sm text-gray-500 file:mr-4 file:rounded-full file:border-0 file:bg-primary file:px-4 file:py-2 file:text-sm file:font-semibold file:text-white hover:file:bg-primary/90 transition-all dark:border-gray-600 dark:bg-gray-700 dark:text-gray-400"
                               id="attached_file" type="file" name="attached_file[]" accept=".pdf, image/*" multiple />
                        <span class="mt-1 text-xs text-red-500" id="attached_file_error">{{ $errors->first('attached_file') }}</span>
                    </div>

                    <button type="submit" id="signup-button" disabled
                            class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                        {{__('auth.Sign up')}}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script type="module">
        $(document).ready(function() {
            // Initialize select2
            $('.select2').select2({
                placeholder: "{{__('auth.Please select one')}}"
            });

            // Initialize datepicker
            let datepickerEl = document.getElementById('dateOfEstablishment');
            let today = new Date();
            if (datepickerEl) {
                new Datepicker(datepickerEl, {
                    format: 'yyyy-mm-dd',
                    maxDate: today,
                    autohide: true
                });
            }

            function toggleOfficeType() {
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

                // Hide all containers and remove required attributes
                Object.values(containers).forEach(container => {
                    container.addClass('hidden');
                    container.find('[required]').prop('required', false);
                });

                // Remove required from all fields
                $('#name, #ministry_name, #co_business, #business_registration_number, #number_workers, #dateOfEstablishment').prop('required', false);
                $("input[name='office_type']").prop('required', false);
                $("#headquarter").prop('required', false);

                // Show containers based on enterprise type
                if (val == 1) {
                    // Ministry/Organization
                    containers.ministry.removeClass('hidden');
                    containers.organisation.removeClass('hidden');
                    containers.emailGovernmentLabel.removeClass('hidden');
                    containers.emailDefaultLabel.addClass('hidden');
                    containers.emailNonGovernmentLabel.addClass('hidden');
                    $('#ministry_name').prop('required', true);
                }
                else if (val == '' || [4, 5, 7].includes(Number(val))) {
                    // Business registration types
                    [containers.businessReg, containers.company, containers.officeType,
                        containers.establishment, containers.workers, containers.file, containers.emailDefaultLabel].forEach(c => c.removeClass('hidden'));

                    $('#name, #business_registration_number, #dateOfEstablishment, #number_workers').prop('required', true);
                    $("input[name='office_type']").prop('required', true);
                    containers.emailGovernmentLabel.addClass('hidden');
                    containers.emailNonGovernmentLabel.addClass('hidden');
                    containers.attachmentLabelDefault.removeClass('hidden');
                }
                else if ([2, 3, 6].includes(Number(val))) {
                    // Other organization types - SỬA Ở ĐÂY
                    [containers.businessReg1, containers.company, containers.officeType,
                        containers.file, containers.operations, containers.emailNonGovernmentLabel].forEach(c => c.removeClass('hidden'));

                    // Ẩn number workers container cho trường hợp 2,3,6
                    containers.workers.addClass('hidden');
                    containers.establishment.addClass('hidden');
                    containers.emailDefaultLabel.addClass('hidden');
                    containers.emailGovernmentLabel.addClass('hidden');
                    containers.attachmentLabelDefault.addClass('hidden');
                    containers.attachmentLabelNonGovernment.removeClass('hidden');

                    $('#name, #co_business').prop('required', true);
                    $("input[name='office_type']").prop('required', true);
                }

                // Handle headquarter visibility
                const officeType = $("input[name='office_type']:checked").val();
                if (officeType == 2 && (val == '' || [2, 3, 4, 5, 6, 7].includes(Number(val)))) {
                    $("#input_headquarter").removeClass('hidden');
                    $("#headquarter").prop('required', true);
                } else {
                    $("#input_headquarter").addClass('hidden');
                    $("#headquarter").prop('required', false);
                }
            }
            function toggleSignUpButton() {
                const enterpriseVal = $("#enterpriseSelect").val();
                let isValid = true;

                // Always required fields
                if (!$('#districtSelect').val() || !$('#address').val()) {
                    isValid = false;
                }

                // Check name/ministry name based on enterprise type
                if (enterpriseVal == 1) {
                    if (!$('#ministry_name').val()) {
                        isValid = false;
                    }
                } else if (enterpriseVal && enterpriseVal != '') {
                    if (!$('#name').val()) {
                        isValid = false;
                    }
                }

                // Check specific fields based on enterprise type
                if (enterpriseVal == '' || [4, 5, 7].includes(Number(enterpriseVal))) {
                    const officeType = $("input[name='office_type']:checked").val();
                    if (!officeType || !$('#dateOfEstablishment').val() ||
                        !$('#number_workers').val() || !$('#business_registration_number').val()) {
                        isValid = false;
                    }
                    if (officeType == 2 && !$("#headquarter").val()) {
                        isValid = false;
                    }
                }
                else if ([2, 3, 6].includes(Number(enterpriseVal))) {
                    const officeType = $("input[name='office_type']:checked").val();
                    // SỬA Ở ĐÂY: Chỉ kiểm tra co_business
                    if (!officeType || !$('#co_business').val()) {
                        isValid = false;
                    }
                    if (officeType == 2 && !$("#headquarter").val()) {
                        isValid = false;
                    }
                }

                // Update button state
                $('#signup-button').toggleClass('disabled-button', !isValid).prop('disabled', !isValid);
            }


            // Initialize
            toggleOfficeType();
            toggleSignUpButton();

            // Event listeners
            $("#enterpriseSelect").on("change", function() {
                toggleOfficeType();
                setTimeout(toggleSignUpButton, 100);
                getHeadQuarter($(this).val());
            });
            function getHeadQuarter(companyInformation) {
                $.ajax({
                    type:'GET',
                    url:'/company/register/get-headquarter?company_information='+companyInformation,
                    success: function(data) {
                        // Xóa option cũ
                        $('#headquarter').empty();

                        // Thêm option rỗng (placeholder)
                        $('#headquarter').append('<option></option>');

                        // Duyệt dữ liệu từ server trả về và thêm vào select
                        $.each(data.data, function(index, item) {
                            let website = item.website ? ' - ' + item.website : '';
                            $('#headquarter').append(
                                '<option value="' + item.id + '">' + item.name  + website + '</option>'
                            );
                        });
                        $('#headquarter').trigger('change');
                    }
                });
            }
            $("input[name='office_type']").change(function() {
                const val = $(this).val();
                if (val == 2 && ($("#enterpriseSelect").val() == '' || [2, 3, 4, 5, 6, 7].includes(Number($("#enterpriseSelect").val())))) {
                    $("#input_headquarter").removeClass('hidden');
                    $("#headquarter").prop('required', true);

                } else {
                    $("#input_headquarter").addClass('hidden');
                    $("#headquarter").prop('required', false);
                }
                toggleSignUpButton();
            });

            // Listen to all input changes
            $('input, select').on('input change', function() {
                toggleSignUpButton();
            });

            // Special handling for select2
            $('.select2').on('change', function() {
                toggleSignUpButton();
            });

            // Special handling for datepicker
            $('#dateOfEstablishment').on('change', function() {
                setTimeout(toggleSignUpButton, 100);
            });
        });
    </script>
@endpush
