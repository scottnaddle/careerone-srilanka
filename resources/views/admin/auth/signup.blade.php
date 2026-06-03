@extends('cgo.auth.layouts.master')

@section('title', 'Admin Sign Up')

<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />

@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray !important;
        }
        /* Ẩn tab mặc định */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: flex;
        }

        /* Tùy chỉnh Select2 để khớp với Input Tailwind (h-11, rounded-xl) */
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

        /* Select2 cho chế độ Dark Mode */
        .dark .select2-container--default .select2-selection--single {
            background-color: #1E1E1E !important; /* dark:bg-[#1E1E1E] */
            border-color: #6B7280 !important; /* dark:border-gray-500 */
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important; /* dark:text-white */
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important; /* placeholder color */
        }
    </style>
@endpush

@section('content')
    <div class="flex flex-col gap-2.5 w-full bg-white px-4 md:px-8 py-6 rounded-xl dark:bg-[#1E1E1E]">
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <a href="/choose-login"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Choose login
            </a>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-4">
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/admin.svg" class="w-1/4 lg:w-full" alt="Admin Icon">
                    <p class="text-primary dark:text-white font-semibold text-center text-base">You are registering membership as an Administrator.</p>
                </div>

                <div class="w-full flex flex-col items-center justify-center gap-10 md:col-span-2">

                    <ol class="flex items-center justify-center w-full md:w-3/4 text-sm font-medium text-center text-[#404040] dark:text-gray-400 sm:text-base">
                        <li class="stepper-item flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-[#EAEAEA] after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 md:whitespace-nowrap">
                                <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">1</span>
                                {{ trans('auth.personal_info') ?? 'Personal Info' }}
                            </span>
                        </li>
                        <li class="stepper-item flex md:w-full items-center after:content-[''] after:w-full after:h-1 after:border-b after:border-[#EAEAEA] after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 md:whitespace-nowrap">
                                <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">2</span>
                                {{ trans('auth.account_info') ?? 'Account Info' }}
                            </span>
                        </li>
                        <li class="stepper-item flex items-center md:whitespace-nowrap">
                            <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">3</span>
                            {{ trans('auth.confirmation') ?? 'Confirmation' }}
                        </li>
                    </ol>

                    <form class="w-full lg:w-1/2 leading-5" action="{{ route('admin.auth.register-user') }}" method="POST" autocomplete="off" id="registrationForm">
                        @csrf

                        <div class="tab-content active flex-col gap-4" id="tab-0">
                            <div>
                                <label for="nic" class="text-sm font-medium text-[#404040] block dark:text-gray-300 mb-1">
                                    {{ trans('system.form.nic') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <input type="text" name="nic" id="nic" value="{{ old('nic') }}" required
                                       placeholder="{{ trans('system.form.nic_hint') }}" pattern="\d{9}[VXvx]|\d{12}"
                                       class="w-full p-3 pl-4 h-11 bg-gray-50 border border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('nic')) <span class="text-red-600 text-xs mt-1 block">{{ $errors->first('nic') }}</span> @endif
                            </div>

                            <div>
                                <label for="firstname" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.first_name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="firstname" id="firstname" value="{{ old('firstname') }}" required placeholder="E.g: Saman" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('firstname')) <span class="text-red-600 text-xs mt-1 block">{{ $errors->first('firstname') }}</span> @endif
                            </div>

                            <div>
                                <label for="lastname" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.last_name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="lastname" id="lastname" value="{{ old('lastname') }}" required placeholder="E.g: Gamage" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('lastname')) <span class="text-red-600 text-xs mt-1 block">{{ $errors->first('lastname') }}</span> @endif
                            </div>

                            <div>
                                <label for="telephone-input" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.telephone') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="phone" id="telephone-input" value="{{ old('phone') }}" required placeholder="Eg: 0129 084 713" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('phone')) <span class="text-red-600 text-xs mt-1 block">{{ $errors->first('phone') }}</span> @endif
                            </div>

                            <div>
                                <label for="tvet_type" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.tvet_type') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <select class="select2 mb-0 w-full" id="tvet_type" name="tvet_type" data-placeholder="{{trans('auth.Please select one')}}">
                                    <option value=""></option>
                                    @forelse($tvet_types as $tvet_type)
                                        <option value="{{ $tvet_type->head_office_code }}" {{ $tvet_type->head_office_code == old('tvet_type') ? 'selected' : '' }}>
                                            {{ $tvet_type->head_office_name }}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('tvet_type')) <span class="text-red-600 text-xs mt-1 block">{{ $errors->first('tvet_type') }}</span> @endif
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.next') ?? 'Next' }}
                                </button>
                            </div>
                        </div>

                        <div class="tab-content flex-col gap-4" id="tab-1">
                            <div>
                                <label for="email" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.email') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="You@email.com" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                <span id="email-error" class="text-red-600 text-xs p-0 m-0"></span>
                                @if ($errors->has('email')) <span class="text-red-600 text-xs block">{{ $errors->first('email') }}</span> @endif
                            </div>

                            <div>
                                <label for="password" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.password') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required placeholder="********" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <svg id="eye-icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path></svg>
                                        <svg id="eye-icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path><path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path></svg>
                                    </button>
                                </div>
                                <small class="text-xs p-0 m-0 dark:text-white" id="password-feedback"><i>{{trans('auth.password_feeback')}}</i></small>
                                @if ($errors->has('password')) <span class="text-red-600 text-xs block">{{ $errors->first('password') }}</span> @endif
                            </div>

                            <div>
                                <label for="password_confirmation" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.confirm_password') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="relative">
                                    <input type="password" name="password_confirmation" id="password_confirmation" required placeholder="{{ trans('auth.Retype your password') ?? 'Retype your password' }}" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button" id="toggle-password-confirm" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <svg id="eye-icon-show-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path></svg>
                                        <svg id="eye-icon-hide-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path><path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path></svg>
                                    </button>
                                </div>
                                <div id="repassword-feedback"></div>
                            </div>

                            <div class="flex justify-between pt-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.previous') ?? 'Previous' }}
                                </button>
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.next') ?? 'Next' }}
                                </button>
                            </div>
                        </div>

                        <div class="tab-content flex-col gap-4" id="tab-2">

                            <div class="bg-[#F8F9FA] dark:bg-[#2A2A2A] p-5 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">
                                    {{ trans('auth.review_information') ?? 'Review Your Information' }}
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.nic') }}:</span> <span id="summary-nic" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.full_name') }} :</span> <span id="summary-name" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.telephone') }}:</span> <span id="summary-telephone" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.email') }}:</span> <span id="summary-email" class="font-medium"></span></div>
                                    <div class="sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.tvet_type') }}:</span> <span id="summary-tvet" class="font-medium"></span></div>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 block mb-1 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="flex gap-6 mt-2">
                                    <div class="flex items-center">
                                        <input type="radio" name="verification_type" value="email" class="rounded-full text-blue-600 focus:ring-blue-500 border-gray-500 verify-radio dark:bg-[#1E1E1E]" id="hs-radio-group-1" required {{ old('verification_type') === 'email' ? 'checked' : '' }}>
                                        <label for="hs-radio-group-1" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{ trans('system.form.email') }}</label>
                                    </div>
                                    <div class="flex items-center">
                                        <input type="radio" name="verification_type" value="sms" class="rounded-full text-blue-600 focus:ring-blue-500 border-gray-500 verify-radio dark:bg-[#1E1E1E]" id="hs-radio-group-2" required {{ old('verification_type') === 'sms' ? 'checked' : '' }}>
                                        <label for="hs-radio-group-2" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{ trans('system.form.sms') }}</label>
                                    </div>
                                </div>
                                @if ($errors->has('verification_type')) <span class="text-red-600 text-xs block mt-1">{{ $errors->first('verification_type') }}</span> @endif
                            </div>

                            <div class="flex items-center bg-gray-50 p-4 rounded-xl border border-gray-200 dark:bg-[#1E1E1E] dark:border-gray-500 mt-2">
                                <input id="accept_term" name="accept_term" type="checkbox" required class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded" value="1" {{ old('accept_term') == '1' ? 'checked' : '' }} />
                                <label for="accept_term" class="pl-3 block text-sm text-gray-600 dark:text-gray-300">
                                    {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Administrator 2.pdf')]) !!}
                                </label>
                            </div>
                            @if ($errors->has('accept_term')) <span class="text-red-600 text-xs block mt-1">{{ $errors->first('accept_term') }}</span> @endif

                            <div class="flex justify-between pt-4 gap-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.previous') ?? 'Previous' }}
                                </button>
                                <button type="submit" id="signup-button" disabled class="flex-1 text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 disabled-button">
                                    {{ trans('auth.sign_up') }}
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
        // Validate Password Rules
        const validationRules = [
            { test: (value) => value.length >= 8 && value.length <= 16 },
            { test: (value) => /[A-Z]/.test(value) },
            { test: (value) => /[!@#$%^&*(),.?":{}|<>]/.test(value) },
            { test: (value) => /[0-9]/.test(value) }
        ];

        window.isPasswordValid = function(password, repassword = null) {
            const isMainPasswordValid = validationRules.every(rule => rule.test(password));
            if (repassword === null) return isMainPasswordValid;
            return isMainPasswordValid && password === repassword;
        };

        // Chuyển Tab (Stepper logic)
        let currentTab = 0;

        function showTab(n) {
            let tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.classList.remove("active"));
            tabs[n].classList.add("active");

            // Cập nhật giao diện thanh quy trình (Stepper)
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

            // Gán dữ liệu sang màn hình xác nhận (Tab 3)
            if (n === 2) {
                document.getElementById('summary-nic').innerText = document.querySelector('input[name="nic"]').value || 'N/A';
                document.getElementById('summary-name').innerText = (document.querySelector('input[name="firstname"]').value + ' ' + document.querySelector('input[name="lastname"]').value).trim() || 'N/A';
                document.getElementById('summary-telephone').innerText = document.querySelector('input[name="phone"]').value || 'N/A';
                document.getElementById('summary-email').innerText = document.querySelector('input[name="email"]').value || 'N/A';

                let tvetData = $('select[name="tvet_type"]').select2('data')[0];
                document.getElementById('summary-tvet').innerText = tvetData && tvetData.text ? tvetData.text : 'N/A';

                if (typeof toggleSignUpButton === "function") {
                    toggleSignUpButton();
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

            // Kiểm tra thủ công select2 Tab 0
            if (tabIndex === 0) {
                let tvet = $('select[name="tvet_type"]').val();
                if (!tvet) {
                    alert("Please select your TVET Type.");
                    return false;
                }
            }

            // Kiểm tra quy tắc password Tab 1
            if (tabIndex === 1) {
                let pass = $('input[name="password"]').val();
                let repass = $('input[name="password_confirmation"]').val();
                if (!window.isPasswordValid(pass, repass)) {
                    alert("Please ensure passwords match and meet the requirements.");
                    return false;
                }
            }
            return true;
        }
    </script>

    <script type="module">
        $(document).ready(function() {
            showTab(currentTab);

            // Giới hạn NIC
            $('input[name="nic"]').on('input', function() {
                const maxLength = 12;
                let value = $(this).val();
                if (value.length > maxLength) {
                    $(this).val(value.substring(0, maxLength));
                }
            });

            // Validation Input Telephone
            $('input[name="phone"]').on('input', function() {
                let value = $(this).val().replace(/\D/g, '');
                if (value.length > 0 && value.charAt(0) !== '0') {
                    value = '';
                }
                $(this).val(value.substring(0, 10));
            });

            $('input[name="password"], input[name="password_confirmation"]').on('input', function() {
                this.value = this.value.replace(/\s/g, '');
            });

            $('.select2').select2({
                placeholder: "{{ trans('auth.Please select one') ?? 'Please select one' }}"
            });

            // Vô hiệu hoá/ Kích hoạt nút Submit an toàn
            window.toggleSignUpButton = function() {
                var nicValue = $('input[name="nic"]').val();
                var firstNameValue = $('input[name="firstname"]').val();
                var lastNameValue = $('input[name="lastname"]').val();
                var emailValue = $('input[name="email"]').val();
                var passwordValue = $('input[name="password"]').val();
                var repasswordValue = $('input[name="password_confirmation"]').val();
                var phoneValue = $('input[name="phone"]').val();
                var tvetValue = $('select[name="tvet_type"]').val();
                var acceptTermsChecked = $('input[name="accept_term"]').is(':checked');
                var verifyMethodChecked = $('input[name="verification_type"]:checked').length > 0;

                var isPasswordInvalid = !window.isPasswordValid(passwordValue, repasswordValue);

                var anyFieldEmptyOrNull = !nicValue || !firstNameValue || !lastNameValue || !emailValue ||
                    !passwordValue || !repasswordValue || !phoneValue || !tvetValue ||
                    !acceptTermsChecked || !verifyMethodChecked;

                if (anyFieldEmptyOrNull || isPasswordInvalid) {
                    $('#signup-button').addClass('disabled-button').prop('disabled', true);
                } else {
                    $('#signup-button').removeClass('disabled-button').prop('disabled', false);
                }
            };

            window.toggleSignUpButton();

            // Trigger events for form inputs
            $('input, select').on('input change', function() {
                window.toggleSignUpButton();
            });

            // Toggle logic con mắt của mật khẩu
            $('#toggle-password').click(function() {
                const passwordInput = $('input[name="password"]');
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
                const confirmInput = $('input[name="password_confirmation"]');
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

        // Email regex
        $(document).ready(function() {
            $('input[name="email"]').on('input', function() {
                const email = $(this).val();
                const errorSpan = $('#email-error');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email === '') {
                    errorSpan.text("Email cannot be blank.");
                } else if (!emailRegex.test(email)) {
                    errorSpan.text("Email is not in correct format.");
                } else {
                    errorSpan.text('');
                }
            });
        });

        // Mật khẩu Feedback
        function validatePasswords() {
            const passwordInput = document.querySelector('input[name="password"]');
            const repasswordInput = document.querySelector('input[name="password_confirmation"]');
            const password = passwordInput.value;
            const repassword = repasswordInput.value;

            let passwordFeedback = document.getElementById('password-feedback');
            passwordFeedback.className = 'text-red-600 text-xs p-0 m-0';
            let repasswordFeedback = document.getElementById('repassword-feedback');
            repasswordFeedback.className = 'text-red-600 text-xs p-0 m-0 mt-1 block';

            passwordInput.classList.remove('border-red-500', 'border-green-500');
            repasswordInput.classList.remove('border-red-500', 'border-green-500');

            const isPasswordValid = window.isPasswordValid(password);

            if (password) {
                if (isPasswordValid) {
                    passwordInput.classList.add('border-green-500');
                    passwordFeedback.classList.remove('text-red-600');
                } else {
                    passwordInput.classList.add('border-red-500');
                    passwordFeedback.style.display = 'block';
                    passwordFeedback.textContent = "{{ trans('auth.password_feeback') }}";
                }
            }

            if (repassword) {
                if (password === repassword && isPasswordValid) {
                    repasswordInput.classList.add('border-green-500');
                    repasswordFeedback.style.display = 'none';
                } else {
                    repasswordInput.classList.add('border-red-500');
                    repasswordFeedback.style.display = 'block';
                    repasswordFeedback.textContent = "Passwords do not match";
                }
            } else {
                repasswordFeedback.style.display = 'none';
            }
            return isPasswordValid && password === repassword;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const repasswordInput = document.querySelector('input[name="password_confirmation"]');
            passwordInput.addEventListener('input', validatePasswords);
            repasswordInput.addEventListener('input', validatePasswords);
        });
    </script>
@endpush
