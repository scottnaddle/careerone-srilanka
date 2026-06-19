@extends('auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            background-color: gray !important;
        }
        /* Hide tab by default */
        .tab-content {
            display: none;
        }
        .tab-content.active {
            display: flex;
        }

        /* ---------------------------------------------------
           Customize Select2 to match the Tailwind input (h-11, rounded-xl)
        --------------------------------------------------- */
        .select2-container--default .select2-selection--single {
            height: 2.75rem !important; /* h-11 */
            background-color: #F9FAFB !important;
            border: 1px solid #D1D5DB !important;
            border-radius: 0.75rem !important; /* rounded-xl */
            display: flex !important;
            align-items: center;
            padding-left: 0.5rem !important;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #111827 !important;
            font-size: 0.875rem !important;
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
            background-color: #1E1E1E !important;
            border-color: #6B7280 !important;
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #ffffff !important;
        }
        .dark .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #9ca3af !important;
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
                {{ trans('auth.choose_login_title') }}
            </a>

            @if (session()->get('error'))
                <span class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">
                    {!! session()->get('error') !!}
                </span>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/trainee1.webp" class="w-1/2 lg:w-full" alt="Trainee Icon">
                    <p class="text-primary dark:text-white font-semibold text-center text-base">{{trans('auth.You are registering membership as a Trainee.')}}</p>
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

                    <form class="w-full lg:w-1/2 leading-5" action="{{ route('trainee.auth.postRegister') }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="registrationForm">
                        @csrf

                        <div class="tab-content active flex-col gap-4" id="tab-0">
                            <div class="flex gap-2 flex-col">
                                <label for="nic" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.nic') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                @if (old('nic') != '' && !$errors->has('nic'))
                                    <div class="flex flex-col">
                                        <div class="flex gap-4 items-center">
                                            <input type="text" name="nic" id="nic" value="{{ old('nic') }}" readonly required placeholder="XXXX XXXX XXXX" maxlength="12"
                                                   class="w-full p-3 pl-4 h-11 bg-gray-50 border border-gray-300 text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                        </div>
                                        @error('nic_check_fail')
                                        <span class="text-sm text-red-600 hidden">{{ $message }}</span>
                                        @enderror
                                        @if ($errors->has('nic'))
                                            <span class="text-sm text-red-600">{{ $errors->first('nic') }}</span>
                                        @endif
                                        <small class="dark:text-white mt-1"><i>{{ trans('system.form.nic_hint') }}</i></small>
                                    </div>
                                @else
                                    <div class="flex flex-col">
                                        <div class="flex gap-4 items-center">
                                            <input type="text" name="nic" id="nic" value="" placeholder="XXXX XXXX XXXX" required maxlength="12"
                                                   class="w-full p-3 pl-4 h-11 bg-gray-50 border border-gray-300 text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">

                                            <button type="button" class="btn-check-nic text-white w-4/12 h-11 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-xl px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium flex justify-center items-center">
                                                {{ trans('system.form.button.check') }}
                                            </button>

                                            <button disabled type="button" class="hidden checking-btn text-white w-4/12 h-11 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-xl px-6 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium flex justify-center items-center">
                                                <svg aria-hidden="true" role="status" class="inline w-5 h-5 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                                    <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                                </svg>
                                            </button>

                                            <button type="button" class="btn-reset-nic text-white w-4/12 h-11 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-xl px-2 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 font-medium flex justify-center items-center hidden">
                                                {{ trans('system.form.button.reset') }}
                                            </button>
                                        </div>
                                        @error('nic_check_fail')
                                        <span class="text-sm text-red-600 hidden">{{ $message }}</span>
                                        @enderror
                                        @if ($errors->has('nic'))
                                            <span class="text-sm text-red-600">{{ $errors->first('nic') }}</span>
                                        @endif
                                        <small class="dark:text-white mt-1"><i>{{ trans('system.form.nic_hint') }}</i></small>
                                    </div>
                                @endif
                            </div>

                            <div>
                                <label for="full_name" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.full_name') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <input type="text" name="full_name" id="full_name" value="{{ old('full_name') }}" readonly required
                                       class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white cursor-not-allowed">
                                @if ($errors->has('full_name')) <span class="text-red-600 text-xs">{{ $errors->first('full_name') }}</span> @endif
                            </div>

                            <div>
                                <label for="mobile" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.mobile') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}" required placeholder="Eg: 075 555 5555"
                                       class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('mobile')) <span class="text-red-600 text-xs">{{ $errors->first('mobile') }}</span> @endif
                            </div>

                            <div>
                                <label for="recommended_by" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('general.Recommended by') }}
                                </label>
                                <select class="select2 recommended_by mb-0 w-full" id="recommended_by" name="recommended_by" data-placeholder="{{trans('auth.Please select one')}}">
                                    <option></option>
                                    @forelse($recommendedList as $user)
                                        <option value="{{$user->system}}-{{ $user->id }}" {{ old('recommended_by') == ($user->system.'-'.$user->id) ? 'selected' : '' }}>
                                            {{ strtoupper($user->system) }} - {{$user->fullName}} - @if($user->system == 'cgo'){{ $user->institute?->name. "(". $user->institute?->reg_no . ")"}} @else {{ $user->tvetType?->head_office_code}} @endif
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('recommended_by')) <span class="text-red-600 text-xs">{{ $errors->first('recommended_by') }}</span> @endif
                            </div>

                            <div class="flex justify-end pt-4">
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.next') ?? 'Next' }}
                                </button>
                            </div>
                        </div>

                        <div class="tab-content flex-col gap-4" id="tab-1">
                            <div>
                                <label for="email" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.email') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="You@email.com"
                                       class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                <span id="email-error" class="text-red-600 text-xs"></span>
                                @if ($errors->has('email')) <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span> @endif
                            </div>

                            <div>
                                <label for="password" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.password') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" required placeholder="********"
                                           class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <svg id="eye-icon-show" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path></svg>
                                        <svg id="eye-icon-hide" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path><path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path></svg>
                                    </button>
                                </div>
                                <small class="text-xs dark:text-white mt-1" id="password-feedback"><i>{{ trans('auth.password_feeback') }}</i></small>
                            </div>

                            <div>
                                <label for="repassword" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">
                                    {{ trans('system.form.confirm_password') }}<span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="repassword" id="repassword" required placeholder="{{ trans('auth.retype_password') ?? 'Retype your password' }}"
                                           class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button" id="toggle-repassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <svg id="eye-icon-show-repassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path></svg>
                                        <svg id="eye-icon-hide-repassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path><path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path></svg>
                                    </button>
                                </div>
                                <div id="repassword-feedback" class="mt-1"></div>
                                @if ($errors->has('repassword')) <span class="text-red-600 text-xs">{{ $errors->first('repassword') }}</span> @endif
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
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.mobile') }}:</span> <span id="summary-mobile" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.email') }}:</span> <span id="summary-email" class="font-medium"></span></div>
                                    <div class="sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('general.Recommended by') }}:</span> <span id="summary-recommended" class="font-medium"></span></div>
                                </div>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-gray-600 block mb-1 dark:text-gray-300">{{ trans('system.form.preferred_verification_method') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="flex gap-6">
                                    @foreach (getCodeList('verification_method') as $item)
                                        <div class="flex items-center">
                                            <input type="radio" name="verification_type" required value="{{ strtolower(str_replace('-', '', $item->code_name)) }}" {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }} class="rounded-full text-blue-600 focus:ring-blue-500 border-gray-500 verify-radio" id="hs-radio-group-{{ $item->code_id }}">
                                            <label for="hs-radio-group-{{ $item->code_id }}" class="text-sm text-gray-500 ms-2 dark:text-neutral-400">{{ $item->code_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('verification_type')) <span class="text-red-600 text-xs">{{ $errors->first('verification_type') }}</span> @endif
                            </div>

                            <div class="flex items-center bg-gray-50 p-4 rounded-xl border border-gray-200 dark:bg-[#1E1E1E] dark:border-gray-500 mt-2">
                                <input id="agree_terms" name="agree_terms" type="checkbox" required class="h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded" value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }} />
                                <label for="agree_terms" class="pl-3 block text-sm text-gray-600 dark:text-gray-300">
                                    {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Trainee 2.pdf') ]) !!}
                                </label>
                            </div>
                            @if ($errors->has('agree_terms')) <span class="text-red-600 text-xs">{{ $errors->first('agree_terms') }}</span> @endif

                            <div class="flex justify-between pt-4 gap-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.previous') ?? 'Previous' }}
                                </button>
                                <button type="submit" id="signup-button" disabled class="flex-1 text-white bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600 dark:hover:bg-blue-700 disabled-button">
                                    {{ trans('auth.sign_up') }}
                                </button>
                            </div>

                            <div class="text-sm dark:text-white mt-2 text-center">
                                {{trans('general.signup_note')}}
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div id="default-modal" tabindex="-1" aria-hidden="true"
         class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-xl max-h-full">
            <div class="relative bg-white rounded-xl shadow dark:bg-[#1E1E1E] dark:border-white">
                <div class="flex items-center justify-between pb-4 border-b border-gray-200 dark:border-gray-600 rounded-t p-4">
                    <h3 class="text-xl font-semibold dark:text-white text-center">
                        Message
                    </h3>
                    <button type="button"
                            class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                             fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                  stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <div class="flex flex-col gap-4 p-6 modal-body">
                    <h3 class="mb-5 text-lg font-normal dark:text-white text-center">
                        {{trans('general.There is no NVQ information with the NIC you entered!')}}
                        <br>
                        <span class="text-base">
                            {!! trans('general.Please click here to proceed for account registration.') !!}
                        </span>
                    </h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>

    @if (old('nic') != '' && !$errors->has('nic'))
        <script>
            window.nic_confirmed = true;
        </script>
    @else
        <script>
            window.nic_confirmed = false;
        </script>
    @endif

    <script type="module">
        // ---------------------------------------------------------
        // Modal Setup
        // ---------------------------------------------------------
        $(document).ready(function () {
            const options = {
                onHide: () => {
                    if (typeof timeoutId !== 'undefined' && timeoutId) {
                        clearTimeout(timeoutId);
                        timeoutId = null;
                    }
                },
            };
            window.modal = createModal('default-modal', options);

            function createModal($id, options = null) {
                const $targetEl = document.getElementById($id);
                const instanceOptions = {
                    id: $id,
                    override: true
                };
                return new Modal($targetEl, options, instanceOptions);
            }
        });

        // ---------------------------------------------------------
        // Global Validation Logic & Navigation
        // ---------------------------------------------------------
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

        let currentTab = 0;

        function showTab(n) {
            let tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.classList.remove("active"));
            tabs[n].classList.add("active");

            // Update Stepper
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

            // If on the Confirmation Tab -> Fill in Summary data
            if (n === 2) {
                document.getElementById('summary-nic').innerText = document.querySelector('input[name="nic"]').value || 'N/A';
                document.getElementById('summary-name').innerText = document.querySelector('input[name="full_name"]').value || 'N/A';
                document.getElementById('summary-mobile').innerText = document.querySelector('input[name="mobile"]').value || 'N/A';
                document.getElementById('summary-email').innerText = document.querySelector('input[name="email"]').value || 'N/A';

                let recommendedData = $('select[name="recommended_by"]').select2('data')[0];
                document.getElementById('summary-recommended').innerText = recommendedData && recommendedData.text ? recommendedData.text.trim() : 'N/A';

                toggleSignUpButton();
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

            // If on Tab 0, the NIC must be successfully checked first
            if (tabIndex === 0 && !window.nic_confirmed) {
                showToast("{{ trans('auth.verify_nic_first') ?? 'Please check and verify your NIC first.' }}", 'error', '#e74c3c');
                return false;
            }

            for (let i = 0; i < inputs.length; i++) {
                if (!inputs[i].checkValidity()) {
                    inputs[i].reportValidity();
                    return false;
                }
            }

            // Check password rules
            if (tabIndex === 1) {
                let pass = $('input[name="password"]').val();
                let repass = $('input[name="repassword"]').val();
                if (!window.isPasswordValid(pass, repass)) {
                    showToast("{{ trans('auth.password_validation_failed') ?? 'Please ensure passwords match and meet requirements.' }}", 'error', '#e74c3c');
                    return false;
                }
            }
            return true;
        }

        function showToast(message, type, bgColor) {
            Toastify({
                text: message,
                duration: 2000,
                className: type,
                style: { background: bgColor }
            }).showToast();
        }

        function toggleSignUpButton() {
            var allFilledAndValid = true;

            // Tab 1 & 2 requirements
            const fields = ['#nic', '#full_name', '#email', '#password', '#repassword', '#mobile'];
            fields.forEach(selector => {
                if (!$(selector).val()) allFilledAndValid = false;
            });

            // Tab 3 requirements
            var agreeTermsChecked = $('input[name="agree_terms"]').is(':checked');
            var verifyMethodChecked = $('input[name="verification_type"]:checked').length > 0;

            var passwordValue = $('input[name="password"]').val();
            var repasswordValue = $('input[name="repassword"]').val();
            var isPasswordInvalid = !window.isPasswordValid(passwordValue, repasswordValue);

            if (!window.nic_confirmed || !allFilledAndValid || !agreeTermsChecked || !verifyMethodChecked || isPasswordInvalid) {
                $('#signup-button').addClass('disabled-button').prop('disabled', true);
            } else {
                $('#signup-button').removeClass('disabled-button').prop('disabled', false);
            }
        }

        // ---------------------------------------------------------
        // Document Ready Events
        // ---------------------------------------------------------
        $(document).ready(function() {
            showTab(currentTab);

            $('.select2').select2({
                placeholder: "{{trans('auth.Please select one')}}"
            });

            // Listen for user actions across the entire form
            $('input, select').on('input change', function() {
                toggleSignUpButton();
            });

            // Verify method radio logic
            $('input[name="verification_type"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="verification_type"]').not(this).prop('checked', false);
                }
                toggleSignUpButton();
            });

            // ---------------------------------------------------------
            // Input Validation & Masks
            // ---------------------------------------------------------
            $('#nic').on('input', function () {
                let value = $(this).val().toUpperCase();
                value = value.replace(/[^0-9VX]/g, '');
                value = value.substring(0, 12);
                $(this).val(value);

                const isValidOld = /^\d{9}[VX]$/i.test(value);
                const isValidNew = /^\d{12}$/.test(value);

                if (!isValidOld && !isValidNew) {
                    $(this).addClass('border-red-500');
                } else {
                    $(this).removeClass('border-red-500');
                }

                handleNICInput();
            });

            $('input[name="mobile"]').on('input', function() {
                let value = this.value;
                if (value.startsWith('+')) {
                    value = '+' + value.substring(1).replace(/\D/g, '');
                } else {
                    value = value.replace(/\D/g, '');
                }
                if (value.startsWith('+94')) {
                    value = value.substring(0, 12);
                } else if (value.startsWith('0')) {
                    value = value.substring(0, 10);
                } else {
                    value = '';
                }
                this.value = value;
            });

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

            $('input[name="password"], input[name="repassword"]').on('input', function() {
                this.value = this.value.replace(/\s/g, '');
                validatePasswordsUI();
            });

            // ---------------------------------------------------------
            // Password Show/Hide Toggle
            // ---------------------------------------------------------
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

            $('#toggle-password').on('click', function() {
                togglePasswordVisibility('#password', '#eye-icon-show', '#eye-icon-hide');
            });
            $('#toggle-repassword').on('click', function() {
                togglePasswordVisibility('#repassword', '#eye-icon-show-repassword', '#eye-icon-hide-repassword');
            });

            // ---------------------------------------------------------
            // NIC Verification AJAX Flow
            // ---------------------------------------------------------
            function handleNICInput() {
                const nicInput = $("input[name='nic']");
                const nic = nicInput.val();
                const btnCheckNIC = $(".btn-check-nic");

                nicInput.removeClass('bg-red-50 border-red-500 text-red-900 bg-green-50 border-green-500 text-green-900 dark:text-green-400');

                if (nic !== '') {
                    btnCheckNIC.prop('disabled', false).removeClass('cursor-not-allowed');
                } else {
                    btnCheckNIC.prop('disabled', true).addClass('cursor-not-allowed');
                    $(".checking-btn").addClass('hidden');
                }
            }

            $(".btn-check-nic").on('click', function(e) {
                const nic = $("input[name='nic']").val().trim();
                const oldNICRegex = /^[0-9]{9}[vVxX]$/;
                const newNICRegex = /^[0-9]{12}$/;

                if (!nic) {
                    showToast('NIC field is empty!', 'error', '#e74c3c');
                    e.preventDefault(); return;
                }
                if (!oldNICRegex.test(nic) && !newNICRegex.test(nic)) {
                    showToast('Invalid NIC format! Please enter a valid NIC.', 'error', '#e74c3c');
                    e.preventDefault(); return;
                }

                $(".btn-check-nic").addClass('hidden');
                $(".checking-btn").removeClass('hidden');

                $.ajax({
                    url: "{{ route('trainee.auth.checkNIC') }}",
                    type: 'GET',
                    data: { nic: nic },
                    success: function(data) {
                        $(".checking-btn").addClass('hidden');

                        const nicInput = $("input[name='nic']");
                        if ($.isEmptyObject(data.error)) {
                            window.nic_confirmed = true;
                            $(".btn-reset-nic").removeClass('hidden');
                            $("#full_name").val(data.data[0]['STD_FULL_NAME']);
                            showToast(data.success, 'infor', 'linear-gradient(to right, #00b09b, #96c93d)');
                            nicInput.prop('readonly', true).addClass('bg-green-50 border-green-500 text-green-900 dark:text-green-400');
                        } else {
                            window.nic_confirmed = false;
                            nicInput.addClass('bg-red-50 border-red-500 text-red-900');
                            if(data.exists == '1') {
                                showToast(data.error, 'error', '#e74c3c');
                            } else {
                                window.modal.show();
                            }
                            $(".btn-check-nic").removeClass('hidden');
                        }
                        toggleSignUpButton();
                    },
                    error: function() {
                        $(".checking-btn").addClass('hidden');
                        $(".btn-check-nic").removeClass('hidden');
                        showToast('Error verifying NIC. Please try again.', 'error', '#e74c3c');
                    }
                });
            });

            $(".btn-reset-nic").on('click', function() {
                const nicInput = $("input[name='nic']");
                nicInput.val('').prop('readonly', false).removeClass('bg-red-50 border-red-500 text-red-900 bg-green-50 border-green-500 text-green-900 dark:text-green-400');
                $(".btn-reset-nic").addClass('hidden');
                $(".btn-check-nic").prop('disabled', true).addClass('cursor-not-allowed').removeClass('hidden');

                $("#full_name").val('');
                $("#email").val('');
                $("#password").val('');
                $("#repassword").val('');
                $("#mobile").val('');
                $("#agree_terms").prop('checked', false);
                window.nic_confirmed = false;

                toggleSignUpButton();
            });

            // ---------------------------------------------------------
            // UI Feedback for Password
            // ---------------------------------------------------------
            function validatePasswordsUI() {
                const passwordInput = document.getElementById('password');
                const repasswordInput = document.getElementById('repassword');
                const password = passwordInput.value;
                const repassword = repasswordInput.value;

                let passwordFeedback = document.getElementById('password-feedback');
                let repasswordFeedback = document.getElementById('repassword-feedback');

                passwordInput.classList.remove('border-red-500', 'border-green-500');
                repasswordInput.classList.remove('border-red-500', 'border-green-500');

                const isPasswordValid = window.isPasswordValid(password);

                if (password) {
                    if (isPasswordValid) {
                        passwordInput.classList.add('border-green-500');
                        passwordFeedback.classList.remove('text-red-600');
                        passwordFeedback.innerHTML = "<i>{{ trans('auth.password_feeback') }}</i>";
                    } else {
                        passwordInput.classList.add('border-red-500');
                        passwordFeedback.classList.add('text-red-600');
                        passwordFeedback.textContent = 'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character';
                    }
                }

                if (repassword) {
                    if (password === repassword && isPasswordValid) {
                        repasswordInput.classList.add('border-green-500');
                        repasswordFeedback.style.display = 'none';
                    } else {
                        repasswordInput.classList.add('border-red-500');
                        repasswordFeedback.style.display = 'block';
                        repasswordFeedback.className = 'text-red-600 text-xs mt-1';
                        repasswordFeedback.textContent = 'Passwords do not match';
                    }
                } else {
                    repasswordFeedback.style.display = 'none';
                }
            }
        });
    </script>
@endpush
