@extends('auth.layouts.master')

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
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5 ">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                    class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('error'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('error') !!}</span>
                @endif

                <form class="space-y-6 leading-5" action="{{ route('cgo.auth.postRegister') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <div class="flex flex-col">
                        <label for="nic" class="text-sm font-medium text-gray-600 block dark:text-gray-300 mb-2">
                            {{ trans('system.form.nic') }}<span class="text-red-600 p-1 text-center">*</span></label>
                        <div class="flex gap-4 mb-1">
                            <input type="text" name="nic" id="nic" value="{{ old('nic') }}"
                                placeholder="XXXX XXXX XXXX" pattern="\d{9}[VXvx]|\d{12}"
                                class="w-full p-3 pl-4 h-9 bg-gray-50 border border-gray-300 text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
                            {{--                            <a href="" --}}
                            {{--                                class="text-white w-1/6 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full flex items-center justify-center --}}
                            {{--                         px-2 py-1 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 text-xs font-medium">{{trans('system.form.button.confirm')}} --}}
                            {{--                            </a> --}}
                        </div>
                        @if ($errors->has('nic'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('nic') }}</span>
                        @endif
                        <small class="dark:text-white"><i>{{ trans('system.form.nic_hint') }}</i></small>
                    </div>


                    <div>
                        <label for="first_name"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.first_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                            placeholder="E.g: Saman"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
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
                            placeholder="E.g: Gamage"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
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
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
                        <span id="email-error" class="text-red-600 text-xs p-0 m-0"></span>
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('email') }}</span>
                            </span>
                        @endif
                    </div>

                    <div>
                        <label for="password"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" placeholder="********"
                                class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Eye Icon for Show Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <!-- Eye Icon for Hide Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 hidden" id="eye-icon-hide">
                                    <path fill-rule="evenodd"
                                        d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                        clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <small class=" text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{ trans('auth.password_feeback') }}</i></small>
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
                                class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
                            <button type="button" id="toggle-password-confirm"
                                class="absolute inset-y-0 right-0 flex items-center pr-3">
                                <!-- Eye Icon for Show Confirm Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show-confirm">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
                                <!-- Eye Icon for Hide Confirm Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5 hidden"
                                    id="eye-icon-hide-confirm">
                                    <path fill-rule="evenodd"
                                        d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z"
                                        clip-rule="evenodd"></path>
                                    <path
                                        d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z">
                                    </path>
                                </svg>
                            </button>
                        </div>
                        <div id="repassword-feedback"></div>
                        @if ($errors->has('repassword'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('repassword') }}</span>
                        @endif
                    </div>

                    <div>
                        <label for="telephone"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.telephone') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                            placeholder="Eg: 0129 084 713"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-500 dark:placeholder-white dark:text-white">
                        @if ($errors->has('telephone'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('telephone') }}</span>
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
                        <label for="institute_id"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.institute') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <select class="select2 mb-0" id="instituteSelect" name="institute_id" style="width: 100%"
                            data-placeholder="{{trans('auth.Please select one')}}">
                            <option></option>
                            @if (old('institute_id'))
                                {{-- Giữ lại các options hiện tại nếu có lỗi validation --}}
                                @foreach ($institutes as $institute)
                                    <option value="{{ $institute->id }}"
                                        {{ old('institute_id') == $institute->id ? 'selected' : '' }}>
                                        {{ $institute->name ."( ".$institute->reg_no ." )" }}
                                    </option>
                                @endforeach
                            @endif
                        </select>

                        @if ($errors->has('institute_id'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('institute_id') }}</span>
                        @endif
                    </div>

                    <div> <label for="attached_file"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.attach_file') }}
                        </label> <input
                            class="relative bg-gray-50 m-0 block w-full min-w-0 flex-auto cursor-pointer rounded-xl border border-gray-300 bg-transparent bg-clip-padding px-3 py-[0.32rem] text-xs font-normal text-surface transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:me-3 file:cursor-pointer file:overflow-hidden file:rounded-none file:border-0 file:border-e file:border-solid file:border-inherit file:bg-transparent file:px-3  file:py-[0.32rem] file:text-surface focus:border-primary focus:text-gray-700 focus:shadow-inset focus:outline-none dark:border-white/70 dark:text-white  file:dark:text-white"
                            id="attached_file" type="file" name="attached_file" accept=".pdf, image/*" />
                        {{-- @if ($errors->has('attached_file'))                                 <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('attached_file') }}</span>                             @endif --}} <span class="text-red-600 text-xs p-0 m-0"
                            id="attached_file_error">{{ $errors->first('attached_file') }}</span> </div>

                    <div>
                        <label for="verify_method"
                            class="text-sm font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            @foreach (getCodeList('verification_method') as $item)
                                <div class="flex items-center justify-center">
                                    <input type="radio" name="verification_type"
                                        value="{{ strtolower(str_replace('-', '', $item->code_name)) }}"
                                        {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}
                                        class="rounded-full shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                        id="hs-radio-group-{{ $item->code_id }}">
                                    <label for="hs-radio-group-{{ $item->code_id }}"
                                        class="text-sm text-gray-500 ms-3 dark:text-neutral-400">{{ $item->code_name }}</label>
                                </div>
                            @endforeach
                        </div>

                        @if ($errors->has('verification_type'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('verification_type') }}</span>
                        @endif
                    </div>


                    <div class="flex items-center">
                        <input id="agree_terms" name="agree_terms" type="radio"
                        class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded"
                        value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }} />
                        <label for="agree_terms" class="pl-3 block text-sm text-gray-500">
                            {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for CGO 2.pdf')]) !!}
                        </label>
                    </div>
                    @if ($errors->has('agree_terms'))
                        <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('agree_terms') }}</span>
                    @endif


                    <button type="submit" id="signup-button" disabled
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('auth.sign_up') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script src="{{ asset('js/filepond/filepond.js') }}" type="module"></script>
    <script>
        // Hàm validateTelephoneInput
        function validateTelephoneInput(input) {
            let value = input.value;
            if (value.length >= 1 && value.charAt(0) !== "0") {
                value = "";
            }
            value = value.replace(/\D/g, '');
            value = value.substring(0, 10);
            input.value = value;
        }
        document.getElementById('telephone').oninput = function() {
            validateTelephoneInput(this);
        };
    </script>
    <script type="module">
        $(document).ready(function() {
            $('#nic').on('input', function() {
                const maxLength = 12;
                let value = $(this).val();

                if (value.length > maxLength) {
                    $(this).val(value.substring(0, maxLength));
                }
            });
        });
        $(document).ready(function() {
            $('#attached_file').on('change', function() {
                const allowedTypes = ['application/pdf', 'image/jpeg', 'image/png', 'image/gif'];
                const file = this.files[0];
                const errorSpan = $('#attached_file_error');

                if (file && !allowedTypes.includes(file.type)) {
                    errorSpan.text('Only PDF and image files are allowed.');
                    $(this).val(''); // Clear the input
                } else {
                    errorSpan.text(''); // Clear the error message
                }
            });
            $('#password').on('input', function() {
                // Remove all spaces from the input value
                this.value = this.value.replace(/\s/g, '');
            });
            $('#repassword').on('input', function() {
                // Remove all spaces from the input value
                this.value = this.value.replace(/\s/g, '');
            });

            $('.select2').select2({
                placeholder: "{{trans('auth.Please select one')}}"
            });

            function isPasswordValid(password, repassword = null) {
                const validationRules = [
                    (value) => value.length >= 8 && value.length <= 16, // length check
                    (value) => /[A-Z]/.test(value), // uppercase check
                    (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value), // special char check
                    (value) => /[0-9]/.test(value) // number check
                ];

                // Kiểm tra các rule cho password chính
                const isMainPasswordValid = validationRules.every(rule => rule(password));

                // Nếu không có repassword, chỉ trả về kết quả validate password chính
                if (repassword === null) {
                    return isMainPasswordValid;
                }

                // Nếu có repassword, kiểm tra cả khớp password và các rule
                return isMainPasswordValid && password === repassword;
            }


            function toggleSignUpButton() {
                // Get the values of all input fields
                // var nicValue = $('#nic').val();
                var firstNameValue = $('#first_name').val();
                var lastNameValue = $('#last_name').val();
                var emailValue = $('#email').val();
                var passwordValue = $('#password').val();
                var repasswordValue = $('#repassword').val();
                var telephoneValue = $('#telephone').val();
                var districtValue = $('#districtSelect').val();
                var instituteValue = $('#instituteSelect').val();
                var agreeTermsChecked = $('#agree_terms').is(':checked');
                // var fileValue = $('#attached_file').val();

                var isPasswordInvalid = !isPasswordValid(passwordValue, repasswordValue);

                // Check if all input fields are empty or null
                var anyFieldEmptyOrNull = !firstNameValue || !lastNameValue || !
                    emailValue || !
                    passwordValue || !repasswordValue || !telephoneValue || !districtValue || !instituteValue ||
                    !
                    agreeTermsChecked;
                // Disable or enable the Sign up button based on the condition
                if (anyFieldEmptyOrNull || isPasswordInvalid) {
                    $('#signup-button').addClass('disabled-button');
                    $('#signup-button').prop('disabled', true);
                } else {
                    $('#signup-button').removeClass('disabled-button');
                    $('#signup-button').prop('disabled', false);
                }
            }


            toggleSignUpButton();

            $('input, select').on('input change', function() {
                toggleSignUpButton();
            });


            $('#toggle-password').click(function() {
                const passwordInput = $('#password');
                const eyeIconShow = $('#eye-icon-show');
                const eyeIconHide = $('#eye-icon-hide');

                if (passwordInput.attr('type') === 'password') {
                    passwordInput.attr('type', 'text');
                    eyeIconShow.addClass('hidden');
                    eyeIconHide.removeClass('hidden');
                } else {
                    passwordInput.attr('type', 'password');
                    eyeIconShow.removeClass('hidden');
                    eyeIconHide.addClass('hidden');
                }
            });

            $('#toggle-password-confirm').click(function() {
                const confirmInput = $('#repassword');
                const eyeIconShowConfirm = $('#eye-icon-show-confirm');
                const eyeIconHideConfirm = $('#eye-icon-hide-confirm');

                if (confirmInput.attr('type') === 'password') {
                    confirmInput.attr('type', 'text');
                    eyeIconShowConfirm.addClass('hidden');
                    eyeIconHideConfirm.removeClass('hidden');
                } else {
                    confirmInput.attr('type', 'password');
                    eyeIconShowConfirm.removeClass('hidden');
                    eyeIconHideConfirm.addClass('hidden');
                }
            });


        });


        $(document).ready(function() {
            let selectedDistrictId = $('#districtSelect').val();

            // Khởi tạo select2
            $('#instituteSelect').select2({
                placeholder: "{{trans('auth.Please select one')}}",
                allowClear: true,
                width: '100%'
            });

            if (selectedDistrictId) {
                loadInstitutes(selectedDistrictId);
            } else {
                $('#instituteSelect').prop('disabled', true);
            }

            $('#instituteSelect').on('click focus', function() {
                if ($(this).prop('disabled')) {
                    alert('Please choose District before selecting Institute.');
                }
            });

            $('#districtSelect').on('change', function() {
                let districtId = $(this).val();
                $('#instituteSelect').empty().append('<option></option>').prop('disabled', true);

                if (districtId) {
                    loadInstitutes(districtId);
                }
            });

            function loadInstitutes(districtId) {
                $.ajax({
                    url: `/api/trainee/district/${districtId}/institutes`,
                    type: 'GET',
                    beforeSend: function() {
                        $('#instituteSelect').empty().append('<option>Loading...</option>');
                    },
                    success: function(data) {
                        $('#instituteSelect').empty().append('<option></option>');
                        if (data.length > 0) {
                            let oldValue = "{{ old('institute_id') }}"; // Lấy giá trị cũ từ Laravel

                            data.forEach(function(institute) {
                                let selected = oldValue == institute.id ? 'selected' : '';
                                $('#instituteSelect').append(
                                    `<option value="${institute.id}" ${selected}>${institute.name} (${institute.reg_no})</option>`
                                );
                            });
                            $('#instituteSelect').prop('disabled', false);

                            // Trigger change để Select2 cập nhật giao diện
                            $('#instituteSelect').trigger('change');
                        }
                    },
                    error: function() {
                        alert('error.');
                    }
                });
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

        const validationRules = [{
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

            // if (!passwordFeedback) {
            //     passwordFeedback = document.createElement('div');
            //     passwordFeedback.id = 'password-feedback';
            //     passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
            //     passwordInput.parentNode.insertBefore(passwordFeedback, passwordInput.nextSibling);
            // }

            // if (!repasswordFeedback) {
            //     repasswordFeedback = document.createElement('div');
            //     repasswordFeedback.id = 'repassword-feedback';
            //     repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0';
            //     repasswordInput.parentNode.insertBefore(repasswordFeedback, repasswordInput.nextSibling);
            // }

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
                    passwordFeedback.textContent =
                        'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character';
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
