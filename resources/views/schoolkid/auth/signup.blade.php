@extends('schoolkid.auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray;
        }
    </style>
@endpush


@section('content')
    <div class="max-w-2xl mx-auto w-screen leading-9 py-24 px-7 flex h-auto mb-10 items-start">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md  space-y-6 border-gray-200 rounded-lg px-10 py-5 ">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                   class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-lg text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.png')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.png')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('error'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif

                <form class="space-y-6 leading-5" action="{{ route('schoolkid.auth.postRegister') }}" method="POST"
                      enctype="multipart/form-data" autocomplete="off">
                    @csrf

                    <div>
                        <label for="first_name"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.first_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                               class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-none block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="Your first name">
                        @if ($errors->has('first_name'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('first_name') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="last_name"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.last_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                               class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-none block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="Your last name">
                        @if ($errors->has('last_name'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('last_name') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="email"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.email') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="email" name="email" id="email" value="{{ old('email') }}"
                               placeholder="You@email.com"
                               class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                        @if ($errors->has('email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                        @endif
                        <span id="email-error" class="text-red-600 text-xs p-0 m-0"></span>
                    </div>
                    <div>
                        <label for="contact_address"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.contact_address') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address') }}"
                               class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-none block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="Your contact address">
                        @if ($errors->has('contact_address'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('contact_address') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="district_id"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.district') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <select class="select2 district mb-0" id="districtSelect" name="district_id" style="width: 100%"
                                data-placeholder="{{trans('auth.Please select one')}}">
                            <option></option>
                            @forelse($districts as $district)
                                <option value="{{ $district->id }}"
                                    {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('district_id'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('district_id') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="office_type"
                               class=" font-medium text-[#706F81] block mb-1.5 dark:text-gray-300">{{ trans('system.form.gender') }}<span class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach(getCodeList('gender') as $gender)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="gender" value="{{$gender->code_id}}" {{ old('gender') == $gender->code_id ? 'checked' : '' }}
                                    class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                           id="gender-{{$gender->code_id}}" required>
                                    <label for="gender-{{$gender->code_id}}"
                                           class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{$gender->code_name}}</label>
                                </div>
                            @endforeach
                        </div>

                        @if ($errors->has('office_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('office_type') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="password"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="********"
                                   class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer dark:text-white"
                                  id="toggle-password">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-600" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                          d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5 hidden text-gray-600" id="eye-icon-hide">
                                    <path fill-rule="evenodd"
                                          d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                          clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <small class="text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{ trans('auth.password_feeback') }}</i></small>
                        @if ($errors->has('password'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="repassword"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.confirm_password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="repassword" id="repassword" placeholder="{{trans('Retype your password')}}"
                                   class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                            <span class="absolute inset-y-0 right-0 flex items-center pr-3 cursor-pointer dark:text-white"
                                  id="toggle-repassword">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5 text-gray-600"
                                     id="eye-icon-show-repassword">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                          d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                          clip-rule="evenodd"></path>
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                     stroke-width="1.5" stroke="currentColor" class="size-5 hidden text-gray-600"
                                     id="eye-icon-hide-repassword">
                                    <path fill-rule="evenodd"
                                          d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                          clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </span>
                        </div>
                        <div id="repassword-feedback"></div>
                        @if ($errors->has('repassword'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('repassword') }}</span>
                        @endif
                    </div>
                    <div>
                        <label for="mobile"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.mobile') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                               placeholder="Eg: 075 555 5555"
                               class="border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" required>
                        @if ($errors->has('mobile'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('mobile') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="recommended_by"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('general.Recommended by') }}
                        </label>

                        <select class="select2 recommended_by mb-0 rounded-lg " id="recommended_by" name="recommended_by" style="width: 100%"
                                data-placeholder="{{trans('auth.Please select one')}}">
                            <option></option>
                            @forelse($recommendedList as $user)
                                <option value="{{$user->system}}-{{ $user->id }}">
                                    {{ strtoupper($user->system) }} - {{$user->fullName}} - @if($user->system == 'cgo'){{ $user->institute?->name. "(". $user->institute?->reg_no . ")"}} @else {{ $user->tvetType?->head_office_code}} @endif</option>
                            @empty
                            @endforelse
                        </select>
                        @if ($errors->has('recommended_by'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('recommended_by') }}</span>
                        @endif
                    </div>


                    <div>
                        <label for="verify_method"
                               class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach(getCodeList('verification_method') as $item)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="verification_type"
                                           value="{{ strtolower(str_replace('-', '', $item->code_name)) }}"
                                           class="rounded-full shrink-0 border-gray-500 text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                           id="hs-radio-group-{{$item->code_id}}"
                                        {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}>
                                    <label for="hs-radio-group-{{$item->code_id}}"
                                           class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{$item->code_name}}</label>
                                </div>
                            @endforeach
                        </div>



                        @if ($errors->has('verification_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('verification_type') }}</span>
                        @endif
                    </div>


                    <div class="flex items-center">
                        <input id="agree_terms" name="agree_terms" type="checkbox"
                               value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }}
                               class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded" />
                        <label for="agree_terms" class="pl-3 block text-sm text-gray-500">
                            {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Trainee 2.pdf') ]) !!}
                        </label>
                    </div>
                    @if ($errors->has('agree_terms'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('agree_terms') }}</span>
                    @endif


                    <button type="submit" id="signup-button" disabled
                            class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('auth.sign_up') }}
                    </button>
                    <div class="text-sm dark:text-white mt-2">
                        {{trans('general.signup_note')}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>


    <script type="module">

        $(document).ready(function() {
            $('input[name="verification_type"]').on('change', function() {
                // If this checkbox is checked, uncheck the others
                if ($(this).is(':checked')) {
                    $('input[name="verification_type"]').not(this).prop('checked', false);
                }

                // Call the toggle function to check the button state
                toggleSignUpButton();
            });
            // Initialize Select2
            $('.select2').select2({
                placeholder: "{{trans('auth.Please select one')}}"
            });

            // Validate Telephone Input
            $('input[name="telephone"]').on('input', function() {
                validateTelephoneInput(this);
            });
            // Validate Telephone Input
            $('input[name="mobile"]').on('input', function() {
                validateMobileInput(this);
            });

            // Toggle visibility of password fields
            $('#toggle-password').on('click', function() {
                togglePasswordVisibility('#password', '#eye-icon-show', '#eye-icon-hide');
            });

            $('#toggle-repassword').on('click', function() {
                togglePasswordVisibility('#repassword', '#eye-icon-show-repassword',
                    '#eye-icon-hide-repassword');
            });



            // Toggle the sign-up button based on form completion
            $('input, select').on('input change', function() {
                toggleSignUpButton();
            });

            // Initialize the toggle for the sign-up button
            toggleSignUpButton();

            // Helper Functions
            function togglePasswordVisibility(passwordSelector, showIconSelector, hideIconSelector) {
                const passwordInput = $(passwordSelector);
                const showIcon = $(showIconSelector);
                const hideIcon = $(hideIconSelector);

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    showIcon.addClass('hidden');
                    hideIcon.removeClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    showIcon.removeClass('hidden');
                    hideIcon.addClass('hidden');
                }
            }



            function toggleSignUpButton() {
                const fields = [ '#first_name', '#last_name', '#contact_address', '#email', '#password', '#repassword', '#mobile', '#districtSelect'];
                const agreeTermsChecked = $('#agree_terms').is(':checked');
                const verificationTypeChecked = $('input[name="verification_type"]:checked').length > 0;
                const allFieldsFilled = fields.every(selector => $(selector).val());
                let genderValue = $("input[name='gender']:checked").val();
                const signupButton = $('#signup-button');

                if (!allFieldsFilled || !agreeTermsChecked || !verificationTypeChecked || !genderValue) {
                    signupButton.addClass('disabled-button').prop('disabled', true);
                } else {
                    signupButton.removeClass('disabled-button').prop('disabled', false);
                }
            }

            function showToast(message, type, bgColor) {
                Toastify({
                    text: message,
                    duration: 2000,
                    className: type,
                    style: {
                        background: bgColor
                    }
                }).showToast();
            }
            function validateTelephoneInput(input) {
                let value = input.value;
                if (value.length >= 1 && value.charAt(0) !== "0") {
                    value = "";
                }
                value = value.replace(/\D/g, '');
                value = value.substring(0, 10);
                input.value = value;
            }
            function validateMobileInput(input) {
                let value = input.value;

                // Cho phép "+" chỉ ở đầu và loại bỏ các ký tự không phải số
                if (value.startsWith('+')) {
                    value = '+' + value.substring(1).replace(/\D/g, '');
                } else {
                    value = value.replace(/\D/g, '');
                }

                // Kiểm tra xem có bắt đầu đúng không
                if (value.startsWith('+94')) {
                    value = value.substring(0, 12); // +94 + 9 chữ số
                } else if (value.startsWith('0')) {
                    value = value.substring(0, 10); // 0 + 9 chữ số
                } else {
                    // Không bắt đầu bằng +94 hoặc 0 => ngăn nhập
                    value = '';
                }

                input.value = value;
            }
        });
        $(document).ready(function() {
            $('#email').on('input', function() {
                const email = $(this).val();
                const errorSpan = $('#email-error');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email === '') {
                    errorSpan.text('Email cannot be blank.');
                } else if (!emailRegex.test(email)) {
                    errorSpan.text('Email is not in correct format.');
                } else {
                    errorSpan.text('');
                }
            });
        });
        const validationRules = [
            {
                test: (value) => value.length >= 8 && value.length <= 16,
                message: 'Password must be 8-16 characters long'
            },
            {
                test: (value) => /[A-Z]/.test(value),
                message: 'Must contain at least 1 uppercase letter'
            },
            {
                test: (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value),
                message: 'Must contain at least 1 special character'
            },
            {
                test: (value) => /[0-9]/.test(value),
                message: 'Must contain at least 1 number'
            }
        ];

        // Function to validate password
        function validatePassword(password) {
            return validationRules.every(rule => rule.test(password));
        }

        // Function to validate both passwords
        function validatePasswords() {
            const passwordInput = document.getElementById('password');
            const repasswordInput = document.getElementById('repassword');
            const password = passwordInput.value;
            const repassword = repasswordInput.value;

            // Get or create feedback elements
            let passwordFeedback = document.getElementById('password-feedback');
            passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
            let repasswordFeedback = document.getElementById('repassword-feedback');
            repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0';

            if (!passwordFeedback) {
                passwordFeedback = document.createElement('div');
                passwordFeedback.id = 'password-feedback';
                passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
                passwordInput.parentNode.insertBefore(passwordFeedback, passwordInput.nextSibling);
            }

            if (!repasswordFeedback) {
                repasswordFeedback = document.createElement('div');
                repasswordFeedback.id = 'repassword-feedback';
                repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0';
                repasswordInput.parentNode.insertBefore(repasswordFeedback, repasswordInput.nextSibling);
            }

            // Reset classes
            passwordInput.classList.remove('border-red-500', 'border-green-500');
            repasswordInput.classList.remove('border-red-500', 'border-green-500');

            // Validate main password
            const isPasswordValid = validatePassword(password);

            if (password) {
                if (isPasswordValid) {
                    passwordInput.classList.add('border-green-500');
                    passwordFeedback.classList.remove('text-red-600');
                    // passwordFeedback.style.display = 'none';
                } else {
                    passwordInput.classList.add('border-red-500');
                    passwordFeedback.style.display = 'block';
                    passwordFeedback.textContent = 'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character';
                }
            } else {
                // passwordFeedback.style.display = 'none';
            }

            // Validate repassword
            if (repassword) {
                if (password === repassword && isPasswordValid) {
                    repasswordInput.classList.add('border-green-500');
                    repasswordFeedback.style.display = 'none';
                } else {
                    repasswordInput.classList.add('border-red-500');
                    repasswordFeedback.style.display = 'block';
                    repasswordFeedback.textContent = 'Passwords do not match';
                }
            } else {
                repasswordFeedback.style.display = 'none';
            }

            return isPasswordValid && password === repassword;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const repasswordInput = document.getElementById('repassword');

            passwordInput.addEventListener('input', validatePasswords);
            repasswordInput.addEventListener('input', validatePasswords);
        });
    </script>
@endpush
