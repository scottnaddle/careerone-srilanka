@extends('admin/auth/layouts/master')

@section('title', 'Admin Sign Up')

@section('content')
    <div class="max-w-2xl mx-auto w-screen leading-9 my-20">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5 ">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                    class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    Choose login
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>

                <form class="space-y-3" action="{{ route('admin.auth.register-user') }}" method="post">
                    {{ csrf_field() }}
                    <div class="flex gap-2 flex-col">
                        <label for="nic" class=" font-medium text-gray-600 block dark:text-gray-300">
                            {{ trans('system.form.nic') }}</label>
                        <div class="flex flex-col">
                            <div class="flex gap-4 items-center">
                                <input type="text" name="nic" id="nic"
                                    class="w-full p-3 pl-4 h-9 bg-gray-50 border border-gray-300 text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                    value="{{ old('nic') }}" placeholder="{{ trans('system.form.nic_hint') }}"
                                    pattern="\d{9}[VXvx]|\d{12}">
                                {{--                                <a href="javascript:void(0)" --}}
                                {{--                                   class="btn-check-nic text-white w-3/12 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full --}}
                                {{--                         px-2 py-0.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800  font-medium flex justify-center items-center">Confirm --}}
                                {{--                                </a> --}}
                                {{--                                <button disabled type="button" class="hidden checking-btn text-white text-white  w-3/12 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-full --}}
                                {{--                         px-6 py-0.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium flex justify-center items-center"> --}}
                                {{--                                    <svg aria-hidden="true" role="status" class="inline w-4 h-4 me-3 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"> --}}
                                {{--                                        <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB"/> --}}
                                {{--                                        <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor"/> --}}
                                {{--                                    </svg> --}}
                                {{--                                    Checking --}}
                                {{--                                </button> --}}
                            </div>
                            {{--                            @error('nic_check_fail') --}}
                            {{--                            <span class="text-sm text-red-600 hidden">{{ $message }}</span> --}}
                            {{--                            @enderror --}}
                            @if ($errors->has('nic'))
                                <span class="help-block">
                                    <span class="text-sm text-red-600">{{ $errors->first('nic') }}</span>
                                </span>
                            @endif
                            <span class="nic-check-message text-sm hidden dark:text-white"></span>
                        </div>
                    </div>
                    {{--                    <div> --}}
                    {{--                        <label for="username" --}}
                    {{--                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">Username<span class="text-red-600 p-1 text-center">*</span> --}}
                    {{--                        </label> --}}
                    {{--                        <input type="text" name="username" id="username" --}}
                    {{--                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" --}}
                    {{--                            required> --}}
                    {{--                    </div> --}}
                    <div>
                        <label for="email"
                            class=" font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.email') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="email" id="email"
                            class="bg-gray-50 w-full  border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            required value="{{ old('email') }}">
                        @if ($errors->has('email'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('email') }}</span>
                            </span>
                        @endif
                        <span id="email-error" class="text-red-600 text-xs p-0 m-0"></span>
                    </div>

                    <div>
                        <label for="password"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                placeholder="********" required>
                            <button type="button" id="toggle-password"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
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
                        <small class=" text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{trans('auth.password_feeback')}}</i></small>
                        @if ($errors->has('password'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('password') }}</span>
                            </span>
                        @endif
                    </div>

                    <div>
                        <label for="password_confirmation"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.confirm_password') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                required placeholder="{{trans('auth.Retype your password')}}">
                            <button type="button" id="toggle-password-confirm"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show-confirm">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd"
                                        d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z"
                                        clip-rule="evenodd"></path>
                                </svg>
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
                    </div>

                    <div>
                        <label for="firstname"
                            class=" font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.first_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="firstname" id="firstname"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            value="{{ old('firstname') }}" required placeholder="E.g: Saman">
                        @if ($errors->has('firstname'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('firstname') }}</span>
                            </span>
                        @endif
                    </div>
                    <div>
                        <label for="lastname"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.last_name') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="lastname" id="lastname"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            value="{{ old('lastname') }}" placeholder="E.g: Gamage" required>
                        @if ($errors->has('lastname'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('lastname') }}</span>
                            </span>
                        @endif
                    </div>


                    <div>
                        <label for="phone"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.telephone') }}<span
                                class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <input type="text" name="phone" id="telephone-input"
                            class="bg-gray-50 border p-3 pl-4 h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                            {{ old('phone') }} required placeholder="Eg: 0129 084 713" value="{{ old('phone') }}">
                        @if ($errors->has('phone'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('phone') }}</span>
                            </span>
                        @endif
                    </div>



                    <div>
                        <label for="tvet_type"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.tvet_type') }}<span
                                class="text-red-600 p-1 text-center">*</span></label>
                        <select name="tvet_type" id="tvet_type"
                            class="bg-gray-50 border h-9 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white">
                            <option value="">{{trans('auth.Please select one')}}</option>
                            @forelse($tvet_types as $tvet_type)
                                <option value="{{ $tvet_type->head_office_code }}"
                                    {{ $tvet_type->head_office_code == old('tvet_type') ? 'selected' : '' }}>
                                    {{ $tvet_type->head_office_name }}</option>
                            @empty
                            @endforelse
                        </select>
                    </div>

                    <div>
                        <label for="verify_method"
                            class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}
                            <span class="text-red-600 p-1 text-center">*</span>
                        </label>
                        <div class="flex gap-6">
                            <div class="flex items-center justify-center">
                                <input type="radio" name="verification_type" value="email"
                                    class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="hs-radio-group-1" required
                                    {{ old('verification_type') === 'email' ? 'checked' : '' }}>
                                <label for="hs-radio-group-1"
                                    class="text-sm text-gray-500 ms-1.5 dark:text-neutral-400">{{ trans('system.form.email') }}</label>
                            </div>
                            <div class="flex items-center justify-center">
                                <input type="radio" name="verification_type" value="sms"
                                    class="shrink-0 border-gray-500 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-800 dark:border-neutral-700 dark:checked:bg-blue-500 dark:checked:border-blue-500 dark:focus:ring-offset-gray-800"
                                    id="hs-radio-group-2" required
                                    {{ old('verification_type') === 'sms' ? 'checked' : '' }}>
                                <label for="hs-radio-group-2"
                                    class="text-sm text-gray-500 ms-1.5 dark:text-neutral-400">{{ trans('system.form.sms') }}</label>
                            </div>
                        </div>

                        @if ($errors->has('verification_type'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('verification_type') }}</span>
                            </span>
                        @endif

                    </div>

                    <div class="flex flex-col gap-2">
                        <div class="flex items-center mt-4">
                            <input id="accept_term" name="accept_term" type="checkbox"
                                class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-300 rounded"
                                required />
                            <label for="accept_term" class="pl-3 block text-sm text-gray-500">
                                {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Administrator 2.pdf')]) !!}
                            </label>
                        </div>
                        @if ($errors->has('accept_term'))
                            <span class="help-block">
                                <span class="text-sm text-red-600">{{ $errors->first('accept_term') }}</span>
                            </span>
                        @endif
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('auth.sign_up') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
    @section('js')
        <script>
            $(document).ready(function() {
                $('#nic').on('input', function() {
                    const maxLength = 12;
                    let value = $(this).val();

                    if (value.length > maxLength) {
                        $(this).val(value.substring(0, maxLength));
                    }
                });
            });

            function validateTelephoneInput(input) {
                let value = input.value;
                if (value.length >= 1 && value.charAt(0) !== "0") {
                    value = "";
                }
                value = value.replace(/\D/g, '');
                value = value.substring(0, 10);
                input.value = value;
            }
            document.getElementById('telephone-input').oninput = function() {
                validateTelephoneInput(this);
            };
        </script>
        <script>
            $(document).ready(function() {
                $('#toggle-password').click(function() {
                    const passwordInput = $('#password');
                    const eyeIconShow = $('#eye-icon-show');
                    const eyeIconHide = $('#eye-icon-hide');

                    // Toggle password visibility
                    if (passwordInput.attr('type') === 'password') {
                        passwordInput.attr('type', 'text');
                        eyeIconShow.addClass('hidden'); // Hide show icon
                        eyeIconHide.removeClass('hidden'); // Show hide icon
                    } else {
                        passwordInput.attr('type', 'password');
                        eyeIconShow.removeClass('hidden'); // Show show icon
                        eyeIconHide.addClass('hidden'); // Hide hide icon
                    }
                });

                $('#toggle-password-confirm').click(function() {
                    const passwordConfirmInput = $('#password_confirmation');
                    const eyeIconShowConfirm = $('#eye-icon-show-confirm');
                    const eyeIconHideConfirm = $('#eye-icon-hide-confirm');

                    // Toggle password visibility
                    if (passwordConfirmInput.attr('type') === 'password') {
                        passwordConfirmInput.attr('type', 'text');
                        eyeIconShowConfirm.addClass('hidden'); // Hide show icon
                        eyeIconHideConfirm.removeClass('hidden'); // Show hide icon
                    } else {
                        passwordConfirmInput.attr('type', 'password');
                        eyeIconShowConfirm.removeClass('hidden'); // Show show icon
                        eyeIconHideConfirm.addClass('hidden'); // Hide hide icon
                    }
                });
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
                const repasswordInput = document.getElementById('password_confirmation');
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
                        passwordFeedback.textContent =
                            {{trans('auth.password_feeback')}};
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
                const repasswordInput = document.getElementById('password_confirmation');

                passwordInput.addEventListener('input', validatePasswords);
                repasswordInput.addEventListener('input', validatePasswords);
            });
        </script>
    @endsection

@endsection
