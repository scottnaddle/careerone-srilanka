@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Guidance - Create Offline')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('trainee.menu.home'), 'url' => route('homepage')],
                ['label' => trans('trainee.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('trainee.guidance_request'), 'url' => '#']
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <ul
                class="flex flex-nowrap text-center text-gray-500 rounded-lg  dark:divide-gray-700 dark:text-gray-400 sm:p-0">
                <li class="flex-1">
                    <a href="{{ route('trainee.career-guidance.counseling.counseling-request') }}"
                        class="text-sm sm:text-lg {{ Request::is('trainee/career-guidance/counseling/counseling-request') ? 'bg-primary text-white font-bold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-l-xl focus:ring-4 focus:ring-blue-300 focus:outline-none ">
                        {{ __('trainee.Request')}}
                    </a>
                </li>
                <li class="flex-1">
                    <a href="{{ route('trainee.career-guidance.counseling.counseling-history') }}"
                        class="text-sm sm:text-lg {{ Request::is('trainee.career-guidance.counseling.counseling-history') ? 'bg-primary text-white font-bold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-r-xl focus:ring-4 focus:ring-blue-300 focus:outline-none  dark:primary "
                        aria-current="page">
                        {{ __('trainee.History')}}
                    </a>
                </li>
            </ul>
            @if($errors->any())
                {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}
            @endif
            <form action="{{ route('trainee.career-guidance.counseling.store-online') }}"
                id="create-online-trainee-counseling-form" class="flex flex-col" method="POST"
                enctype="multipart/form-data">

                @method('POST')
                @csrf
                @if ($errors->has('trainee_nic'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_date') }}</span>
                @endif
                <label for="" class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white">
                    {{ __('cgo.counseling_type') }}
                    <span class="text-red-700">*</span>
                </label>
                <div class="flex items-center mb-4">
                    @foreach(getCodeList('counselling_type') as $type)
                        @if($type->code_id != 3)
                            <div class="flex items-center me-4">
                                <input id="default-radio-{{$type->code_id}}" type="radio" value="{{$type->code_id}}" name="counseling_check_status" {{old('counseling_check_status') == $type->code_id ? 'checked' : ''}}
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                                <label for="default-radio-{{$type->code_id}}"
                                    class="sm:text-base text-base font-medium text-black block ms-2 dark:text-white">
                                    {{$type->code_name}}
                                </label>
                            </div>
                        @endif
                    @endforeach

                </div>

                <label for=""
                    class="text-sm text-base font-medium text-gray-600 block dark:text-white lable-custom-padding">{{ __('cgo.counseling_field') }} <span class="text-red-700">*</span></label>
                <div class="flex mb-4 flex-wrap">
                    @foreach (getCodeList('counselling_field') as $field)
                        <div class="flex items-center me-4">
                            <input id="default-radio-field-{{ $field->code_id }}" type="radio" {{old('counseling_field_id') == $field->code_id ? 'checked' : ''}}
                                value="{{ $field->code_id }}" name="counseling_field_id" required
                                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                            <label for="default-radio-field-{{ $field->code_id }}"
                                class="sm:text-base text-base font-medium text-black block dark:text-white ms-2">{{ $field->code_name }}</label>
                        </div>
                    @endforeach
                    @if ($errors->has('counseling_field_id'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('counseling_field_id') }}</span>
                    @endif
                </div>

                @if ($errors->has('trainee_offline_firstname'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_firstname') }}</span>
                @endif
                @if ($errors->has('trainee_offline_lastname'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_lastname') }}</span>
                @endif

                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white">{{ __('cgo.title') }}
                                <span class="text-red-700">*</span></label>
                            <input type="text" id="" name="title" maxlength="50"
                                class="mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                value="{{ old('title') }}" required />
                        </div>
                        @if ($errors->has('title'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for="districts"
                                class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white">{{ __('trainee.job_support.company.filter.district') }}
                                <span class="text-red-700">*</span></label>
                            <select id="districts" name="districts" required
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled selected>{{trans('trainee.select_district')}}</option>
                                @foreach ($districts as $item)
                                    <option value="{{ $item->id }}" @selected(old('districts') == $item->id)>{{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                </div>
                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white">{{ __('general.Desired Institute') }}</label>
                            <select id="institute" disabled name="institute"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" selected>{{trans('trainee.select_institute')}}</option>
                            </select>
                        </div>
                        @if ($errors->has('institute'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('institute') }}</span>
                        @endif
                    </div>
                </div>
                <label for="date_range"
                    class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white"><span id="date-label">{{ __('trainee.Available Date') }}</span> <span
                        class="text-red-700">*</span>
                </label>

                <div class="col-start-2 col-end-5 mb-4 flex items-center space-x-4" id="add-show">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                            </svg>
                        </div>
                        <input datepicker datepicker-autoselect-today datepicker-format="yyyy-mm-dd"
                            value="{{ \Carbon\Carbon::parse(old('available_date'))->format('Y-m-d') }}"
                            datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}" type="text"
                            name="available_date" id="available_date"
                            class="bg-white border border-gray-300 text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="2024-04-26">
                    </div>
                    @if ($errors->has('available_date'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_date') }}</span>
                    @endif
                </div>


                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                class="text-sm text-base font-medium text-gray-600 block mb-1.5 dark:text-white">{{ __('trainee.Detailed information') }}
                                <span class="text-red-700">*</span></label>
                            <textarea type="" id="" name="detail_information" maxlength="1000"
                                class="mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E]
                                   dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                                   dark:focus:border-blue-500"
                                required>{{ old('detail_information') }}</textarea>
                        </div>
                        @if ($errors->has('detail_information'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('detail_information') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-start-2 col-end-5 mb-4">

                    <label class="block mb-2 text-sm text-base font-medium text-gray-600 dark:text-white"
                        for="trainee_attachment">{{trans('system.form.attach_file')}}</label>
                    <input
                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400"
                        id="trainee_attachment" name ="trainee_attachment" type="file">

                </div>
                @if ($errors->has('trainee_attachment'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_attachment') }}</span>
                @endif

                <div class="flex gap-3 justify-end m-4">
                    <button type="submit" id="confirm-counseling-button"
                        class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('system.form.button.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
         document.addEventListener('DOMContentLoaded', function () {
        const today = new Date().toISOString().split('T')[0];
        const inputDate = document.getElementById('available_date');

        inputDate.addEventListener('change', function () {
            if (this.value === today) {
                this.value = '';
            }
        });
    });
        $(document).ready(function() {
             const amPmSelection = `
            <div id="am-pm-selection">
                <select id="am_pm" name="am_pm"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-24 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="AM">AM</option>
                    <option value="PM">PM</option>
                </select>
            </div>`;

             // Get the PHP-generated value for 'offline' mode into a JavaScript variable
             const offlineCodeId = {{ json_encode(getCodeIdByStringEn('counselling_type', 'offline')) }};

             // Check initial value and append amPmSelection if value matches 'offline' code ID
             if ($('input[name="counseling_check_status"]:checked').val() == offlineCodeId) {
             $('#add-show').append(amPmSelection);
             $("#date-label").html('Available date');
                 } else {
                     $("#date-label").html('{{__('system.form.Proposed Career Guidance Date')}}');
                 }

                     // Event listener for changes to counseling_check_status
                 $('input[name="counseling_check_status"]').change(function() {
                 if ($(this).val() == offlineCodeId) {
                    if ($('#am-pm-selection').length === 0) {
                        $('#add-show').append(amPmSelection);
                    }
                     $("#date-label").html('Available date');
                 } else {
                     $('#am-pm-selection').remove();
                     $("#date-label").html('{{__('system.form.Proposed Career Guidance Date')}}');
                 }
                });



            $("#districts").on("change", function () {
                let districtId = $(this).val();

                if (!districtId) return; // Exit if no district is selected
                $("#institute").attr('disabled', 'disabled')
                $.ajax({
                    url: `/trainee/get-institutes/${districtId}`,
                    type: "GET",
                    dataType: "json",
                    success: function (data) {
                        let instituteSelect = $("#institute");
                        instituteSelect.empty().append('<option value="" disabled selected>Select Institute</option>').removeAttr('disabled');

                        $.each(data, function (index, institute) {
                            instituteSelect.append(`<option value="${institute.id}">${institute.name} (${institute.reg_no})</option>`);
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("Error loading institutes:", error);
                    }
                });
            });
         });


    $(document).ready(function() {
            $('#districts').select2({
                placeholder: "{{trans('trainee.select_district')}}",
                allowClear: true
            });
            $('#institute').select2({
                placeholder: "{{trans('trainee.select_institute')}}",
                allowClear: true
            });

            $('#create-offline-cgo-counseling-form').submit(function(e) {
                e.preventDefault();

                if (this.checkValidity()) {
                    toggleLoadingOverlay();
                    this.submit();
                } else {
                    this.reportValidity();
                }
            });
        });
    </script>
@endpush
@push('css')
    <style>
        .lable-custom-padding {
            padding-bottom: 0.5rem;
        }

        .select2-container--default .select2-selection--single {
            padding: 1.25rem .75rem 1.25rem 1rem !important;
        }
    </style>
@endpush
