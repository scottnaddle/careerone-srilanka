@extends('company.auth.layouts.master')

@section('title', 'Company Sign In')

@section('content')
    <div class="max-w-2xl mx-auto w-screen py-24 flex flex-col h-full justify-start">
        <div
            class="bg-white dark:bg-[#1E1E1E] shadow-md space-y-6 border-gray-200 rounded-xl px-10 py-5">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                   class="text-gray-900 dark:text-white border-gray-200 font-medium gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
                </a>
                <div>
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white leading-9">{{trans('auth.welcome_back')}}</h2>
                    <p class="text-base font-normal text-gray-400 dark:text-white leading-6">{{trans('auth.sign_in_to_continue')}}</p>
                </div>
                @if (session()->get('message'))
                    <span
                        class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
                @endif

                @if (session()->get('error'))
                    <span
                        class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
                @endif
                <form class="leading-5" action="{{ route('company.auth.postLogin') }}" method="POST"  autocomplete="off">
                    @csrf
                    <div class="mb-6">
                        <label for="email"
                            class="text-normal font-medium text-[#706F81] block mb-1.5 dark:text-gray-300 leading-6">
                            {{trans('system.form.email')}}<span class="text-red-600 p-1 text-center">*</span></label>
                        <input type="text" name="email" id="email"
                            class="bg-gray-50 border border-gray-300 py-2 px-4 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                        @if ($errors->has('email'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="mb-3">
                        <label for="password"
                               class="text-normal font-medium text-gray-500 block mb-1.5 dark:text-gray-300 leading-6">
                            {{ trans('system.form.password') }}<span class="text-red-600 p-1 text-center">*</span></label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                   class="bg-gray-50 border border-gray-300 py-2 px-4 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full p-1 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-gray-400 dark:text-white">
                            <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 dark:text-white">
                                <!-- Eye Icon for Show Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5" id="eye-icon-show">
                                    <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                    <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                </svg>
                                <!-- Eye Icon for Hide Password -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden" id="eye-icon-hide">
                                    <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                    <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                </svg>
                            </button>
                        </div>

                        @if ($errors->has('password'))
                            <span class="text-red-600 text-xs p-0 m-0">{{ $errors->first('password') }}</span>
                        @endif
                    </div>
                    <div class="flex items-start mb-6">
                        <a href="{{ route('company.auth.forgotPassword') }}"
                            class="text-sm text-primary hover:underline ml-auto dark:text-blue-500">{{trans('system.form.forgot_password')}}</a>
                    </div>
                    <button type="submit"
                        class="w-full text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                        text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 mb-8">{{trans('auth.sign_in')}}
                    </button>
                    <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-300">
                        {{trans('auth.dont_have_account')}}  <a href="{{ route('company.auth.register') }}"
                            class="text-primary hover:underline dark:text-blue-500">{{trans('auth.sign_up')}}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script>
         $(document).ready(function () {
            $('#nic').on('input', function () {
                const maxLength = 12;
                let value = $(this).val();

                if (value.length > maxLength) {
                    $(this).val(value.substring(0, maxLength));
                }
            });
        });
        $(document).ready(function() {
            // $('#password').on('input', function() {
            //     // Remove all spaces from the input value
            //     this.value = this.value.replace(/\s/g, '');
            // });
            $('#toggle-password').click(function() {
                const passwordInput = $('#password');
                const eyeIconShow = $('#eye-icon-show');
                const eyeIconHide = $('#eye-icon-hide');

                // Toggle password visibility
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
        });
    </script>
@endpush
