@extends('homepage.layouts.master')
@section('title', 'CGO - Career Guidance - Guidance - Create Offline')
@push('css')
    <style>
        .select2-container--default .select2-selection--single {
            padding: 1.25rem .75rem 1.25rem 1rem !important;
        }
    </style>
@endpush
@section('content')
    <div class="my-6 flex flex-col gap-5">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('cgo.counseling_list'), 'url' => route('cgo.career-guidance.counseling.counseling-list')],
                ['label' => trans('cgo.new_counseling'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">

            <form action="{{ route('cgo.career-guidance.counseling.store-offline') }}" id="create-offline-cgo-counseling-form" class="flex flex-col" method="POST">
                @method('POST')
                @csrf
                <label for="" class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ __('cgo.counseling_type') }} <span class="text-red-700">*</span></label>
                <div class="flex items-center mb-4">
                    <input id="default-radio-type" checked type="radio" value="1" name="guidance_type"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                    <label for="default-radio-type"
                           class="sm:text-base text-base font-medium text-black block ms-2 dark:text-white mr-4">{{getCodeNameByCodeId('counselling_type', 3)}}</label>
                           <input id="default-radio-type_2" type="radio" value="2" name="guidance_type"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                    <label for="default-radio-type_2"
                           class="sm:text-base text-base font-medium text-black block ms-2 dark:text-white">{{getCodeNameByCodeId('counselling_type', 2)}}</label>
                </div>
                  @if ($errors->has('counseling_type'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('counseling_type') }}</span>
                    @endif
                <label for="date_range"
                       class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('cgo.date')}} <span class="text-red-700">*</span>
                </label>
                {{-- gap-4 --}}
                <div class="col-start-2 col-end-5 mb-4 flex items-center space-x-4" id="add-show">
                    <div class="relative w-10/12">
                        <div class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />
                            </svg>
                        </div>
                        <input datepicker datepicker-autoselect-today datepicker-format="yyyy-mm-dd"
                               value="{{ \Carbon\Carbon::parse(old('available_date'))->format('Y-m-d') }}"
                               datepicker-min-date="{{ \Carbon\Carbon::parse(now())->format('Y-m-d') }}" type="text"
                               name="available_date" id="available_date"
                               class="bg-white border border-gray-300 text-gray-900 p-2 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="2024-04-26">
                    </div>
                    <div id="am-pm-selection" class="w-2/12">
                        <select id="am_pm" name="am_pm"
                                class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2 w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </div>
                    @if ($errors->has('available_date'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_date') }}</span>
                    @endif
                </div>


                <!-- Show error message if any -->
                @if ($errors->has('available_date'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_date') }}</span>
                @endif
                @if ($errors->has('available_hour'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_hour') }}</span>
                @endif
                @if ($errors->has('available_minute'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_minute') }}</span>
                @endif
                @if ($errors->has('available_time'))
                    <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('available_time') }}</span>
                @endif



                {{-- <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                   class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white ">Institute</label>
                            <input type="text" id="" name="institute"
                                   class="cursor-not-allowed mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value=" {{ $instituteName }} " required readonly disabled/>
                        </div>
                    </div>
                </div>
                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                   class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white ">District</label>
                            <input type="text" id="" name="institute"
                                   class="cursor-not-allowed mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value=" {{ $districts->name }} " required readonly disabled/>
                        </div>

                    </div>
                </div> --}}

                <label for="" class="sm:text-base text-base font-medium text-black block dark:text-white lable-custom-padding">{{trans('cgo.guidance_field')}} <span class="text-red-700">*</span></label>
                <div class="flex mb-4 flex-col md:flex-row">
                    @foreach( getCodeList('counselling_field') as $field )
                        <div class="flex items-center me-4">
                        <input id="default-radio-{{$field->code_id}}" type="radio" {{old('counseling_field_id') == $field->code_id ? 'checked' : ''}} value="{{ $field->code_id }}" name="counseling_field_id" required
                               class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">
                        <label for="default-radio-{{$field->code_id}}"
                               class="sm:text-base text-base font-medium text-black block dark:text-white ms-2">{{ $field->code_name }}</label>
                        </div>
                    @endforeach
                        @if ($errors->has('counseling_field_id'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('counseling_field_id') }}</span>
                        @endif
                </div>

                <div class="grid gap-2 mb-6 md:grid-cols-3">

                    <div class="flex flex-col">
                        <label for="trainee_nic"
                               class="text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('cgo.trainee_nic')}} <span class="text-red-700">*</span></label>
                        <div class="relative">
                            <input type="text" id="trainee_nic" name="trainee_nic" oninput="this.value = this.value.toUpperCase()"
                                   class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                   value="{{ old('trainee_nic') }}" pattern="^[0-9]{9}[A-Z]|[0-9]{12}$" required/>
                            <button type="button" id="check-trainee" disabled
                                    class="absolute flex items-center justify-center right-0 bottom-0 h-full rounded-r-lg min-w-16 text-white bg-[#4984F6] hover:bg-blue-800  font-medium
                    text-base px-2 py-1 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 text-sm"><span class="loading-spinner hidden w-4 h-4 border-2 border-white border-t-transparent rounded-full animate-spin"></span>
                                <span class="btn-text">{{ __('system.form.button.check') }}</span>
                            </button>
                        </div>

                        @if ($errors->has('trainee_nic'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_nic') }}</span>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <label for="telephone" class="text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('cgo.trainee_mobile')}}</label>
                        <input value="{{ old('trainee_offline_mobile') }}" type="text" id="trainee_offline_mobile" name="trainee_offline_mobile" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @if ($errors->has('trainee_offline_mobile'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_mobile') }}</span>
                        @endif
                    </div>
                    <div class="flex flex-col">
                        <label for="email" class="text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('cgo.trainee_email')}}</label>
                        <input value="{{ old('trainee_offline_email') }}" type="text" id="trainee_offline_email" name="trainee_offline_email" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        @if ($errors->has('trainee_offline_email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_email') }}</span>
                        @endif
                    </div>
                </div>

                <div class="grid gap-2 mb-6 md:grid-cols-2">
                    <div class="flex flex-col">
                        <label for="first_name" class="text-base font-medium text-black block mb-1 dark:text-white">{{ __('cgo.first_name') }} <span class="text-red-700">*</span></label>
                        <input value="{{ old('trainee_offline_firstname') }}" type="text" id="trainee_offline_firstname" name="trainee_offline_firstname" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg: John" required />
                        @if ($errors->has('trainee_offline_firstname'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_firstname') }}</span>
                        @endif
                    </div>

                    <div class="flex flex-col">
                        <label for="last_name" class="text-base font-medium text-black block mb-1 dark:text-white">{{ __('cgo.last_name') }} <span class="text-red-700">*</span></label>
                        <input value="{{ old('trainee_offline_lastname') }}" type="text" id="trainee_offline_lastname" name="trainee_offline_lastname" class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="eg: Doe" required />
                        @if ($errors->has('trainee_offline_lastname'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_lastname') }}</span>
                        @endif
                    </div>
                </div>




                <div class="col-start-2 col-end-5 mb-4">
                    <div class="flex flex-col">
                        <label for="trainee_offline_institute"
                               class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{trans('cgo.trainee_information')}} </label>
                        <textarea id="trainee_offline_institute" name="trainee_offline_institute" maxlength="1000"
                                  class="mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg
                               focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E]
                               dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                               dark:focus:border-blue-500" >{{ old('trainee_offline_institute') }}</textarea>

                        @if ($errors->has('trainee_offline_institute'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('trainee_offline_institute') }}</span>
                        @endif
                    </div>
                </div>
                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <label for="title" class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">
                            {{ __('cgo.title') }} <span class="text-red-700">*</span>
                        </label>
                        <select id="title" name="title" required
                                class="mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled selected>{{__('cgo.Select a title')}}</option>
                            @foreach(getCodeList('counselling_title') as $title)
                                <option value="{{ $title->code_name }}" {{ old('title') == $title->code_name ? 'selected' : '' }}>
                                    {{ $title->code_name }}
                                </option>
                            @endforeach
                        </select>

                        @if ($errors->has('title'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('title') }}</span>
                        @endif
                    </div>
                </div>


                <div class="col-start-2 col-end-5 mb-4">
                    <div>
                        <div>
                            <label for=""
                                   class="sm:text-base text-base font-medium text-black block mb-1.5 dark:text-white">{{ __('cgo.description') }} <span class="text-red-700">*</span></label>
                            <textarea type="" id="" name="detail_information" maxlength="1000"
                                   class="mb-2 border border-gray-300 text-[#706F81] text-base rounded-lg
                                   focus:ring-blue-500 focus:border-blue-500 block w-full p-2 dark:bg-[#1E1E1E]
                                   dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500
                                   dark:focus:border-blue-500" required>{{ old('detail_information') }}</textarea>
                        </div>
                        @if ($errors->has('detail_information'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('detail_information') }}</span>
                        @endif
                    </div>
                </div>


                <div class="flex gap-3 justify-end m-4">
                    <button type="submit" id="confirm-counseling-button"
                            class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                text-base px-12 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ __('cgo.submit') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        $(document).ready(function() {
            $('#districts').select2({
                placeholder: "Select Districts",
                allowClear: true
            });
            const now = new Date();
            let currentHour = now.getHours();
            let currentMinute = now.getMinutes();

            // If the minutes are greater than or equal to 30, move to the next hour
            if (currentMinute >= 30) {
                currentHour += 1;
                currentMinute = 0; // Reset minute comparison as we'll be filtering based on the next hour
            }

            // Store original hour and minute options for resetting later
            const originalHours = $('#available_hour').html();
            const originalMinutes = $('#available_minute').html();

            // Function to update the available hours and minutes based on the selected date
            function updateAvailableTimes() {
                const selectedDate = new Date($('#available_date').val());
                const isToday = selectedDate.toDateString() === now.toDateString();

                if (isToday) {
                    // Reset hours and remove past hours if today is selected
                    $('#available_hour').html(originalHours); // Reset the hour options to original
                    $('#available_hour option').each(function() {
                        const hour = parseInt($(this).val());
                        if (hour < currentHour) {
                            $(this).remove();  // Remove past hour options
                        } else {
                            $(this).show();  // Show valid hour options
                        }
                    });

                    // Update minutes based on the selected hour
                    updateMinutes();
                } else {
                    // If a future date is selected, show all hours and minutes
                    $('#available_hour').html(originalHours);  // Reset hour options
                    $('#available_minute').html(originalMinutes);  // Reset minute options
                }
            }

            // Function to hide past minutes if the selected hour is the current hour
            function updateMinutes() {
                const selectedHour = parseInt($('#available_hour').val());
                $('#available_minute').html(originalMinutes); // Reset the minute options to original
                $('#available_minute option').each(function() {
                    const minute = parseInt($(this).val());
                    if (selectedHour === currentHour && minute < currentMinute) {
                        $(this).remove();  // Hide past minutes
                    } else {
                        $(this).show();  // Show valid minutes
                    }
                });
            }
            updateAvailableTimes();
            // Trigger updates when the date or hour changes
            $('#available_date').on('hide', function(event) {
                updateAvailableTimes();
            });

            $('#available_hour').on('change', function() {
                updateMinutes(); // Update minutes when hour changes
            });

            // Initial setup for minutes if the current hour is selected on page load
            if (parseInt($('#available_hour').val()) === currentHour) {
                updateMinutes();
            }


            $('#trainee_nic').on('input', function() {
                let pattern = /^[0-9]{9}[A-Z]|[0-9]{12}$/;
                if (pattern.test($(this).val())) {
                    $('#check-trainee').prop('disabled', false);
                } else {
                    $('#check-trainee').prop('disabled', true);
                }
            });


            $('#check-trainee').on('click', function() {
                let $button = $(this);
                let $spinner = $button.find('.loading-spinner');
                let $btnText = $button.find('.btn-text');
                let nic = $('#trainee_nic').val();
                $spinner.removeClass('hidden');
                $btnText.addClass('hidden');
                $.ajax({
                    url: '/cgo/career-guidance/counseling/create-offline/get-trainee-info/'+nic,
                    type: 'GET',
                    success: function(response) {
                        if (response.success) {
                            $('#trainee_offline_mobile').val(response.mobile ?? '');
                            $('#trainee_offline_email').val(response.email ?? '');
                            $('#trainee_offline_firstname').val(response.first_name ?? '');
                            $('#trainee_offline_lastname').val(response.last_name ?? '');
                        } else {
                            alert('Can not find trainee information.');
                        }
                    },
                    error: function() {
                        alert('Đã xảy ra lỗi. Vui lòng thử lại.');
                    },
                    complete: function() {
                        // Hide loading
                        $spinner.addClass('hidden');
                        $btnText.removeClass('hidden');
                    }
                });
            });
        });
    </script>
    <script>
        document.getElementById('create-offline-cgo-counseling-form').addEventListener('submit', function () {
            event.preventDefault();

            if (this.checkValidity()) {
                toggleLoadingOverlay();
                this.submit();
            } else {
                this.reportValidity();
            }
        });
    </script>

@endpush
@push('css')
<style>
   .lable-custom-padding{
        padding-bottom: 0.5rem;
 }
   .loading-spinner {
       border: 2px solid #ffffff;
       border-top-color: transparent;
       border-radius: 50%;
       width: 1rem;
       height: 1rem;
       animation: spin 0.75s linear infinite;
   }
   @keyframes spin {
       to {
           transform: rotate(360deg);
       }
   }
</style>

@endpush
