@extends('cgo.auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
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

        /* ---------------------------------------------------
           Tùy chỉnh Select2 để khớp với Input Tailwind (h-11, rounded-xl)
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
                {{ trans('auth.choose_login_title') }}
            </a>

            @if (session()->get('error'))
                <span class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
            @endif
            @if(session()->has('success'))
                <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Cột bên trái: Brand Icon & Thông tin -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/companny-user-icon.webp" class="w-1/2 lg:w-full" alt="Company Icon">
                    <p class="text-primary font-semibold text-center text-xl">{{ trans('auth.register_membership_company') ?? 'You are registering membership as a Company.' }}</p>
                </div>

                <!-- Cột bên phải: Giao diện Form các bước -->
                <div class="w-full flex flex-col items-center justify-center gap-10 md:col-span-2">
                    <!-- Stepper -->
                    <ol class="flex items-center justify-center w-full md:w-3/4 text-sm font-medium text-center text-[#404040] dark:text-gray-400 sm:text-base">
                        <li class="stepper-item flex md:w-full items-center text-blue-600 sm:after:content-[''] after:w-full after:h-1 after:border-b after:border-[#EAEAEA] after:hidden sm:after:inline-block after:mx-6 xl:after:mx-10">
                            <span class="flex items-center after:content-['/'] sm:after:hidden after:mx-2 after:text-gray-200 md:whitespace-nowrap">
                                <span class="me-2 rounded-full border border-current w-6 h-6 flex items-center justify-center text-xs">1</span>
                                {{ trans('auth.personal_info') ?? 'Company Info' }}
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

                    <!-- Form Chính -->
                    <form class="w-full lg:w-1/2" action="{{ route('company.auth.postRegister') }}" method="POST" enctype="multipart/form-data" autocomplete="off" id="registrationForm">
                        @csrf
                        <input type="text" name="company_id" class="hidden" id="company_id" value="{{old('company_id')}}">

                        <!-- TAB 1: Company Info -->
                        <div class="tab-content active flex-col gap-4" id="tab-0">
                            <div>
                                <label for="company" class="text-sm font-medium text-[#404040] block dark:text-gray-300 mb-1">
                                    {{ __('auth.Company name') }} <span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="company" id="company" value="{{ old('company') }}" required
                                           placeholder="{{ __('auth.Type Name of Company and click Check') }}"
                                           class="w-3/4 p-3 pl-4 h-11 bg-gray-50 border border-gray-300 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button"
                                            class="w-1/4 checkCompanyButton text-white bg-[#4984F6] hover:bg-blue-800 rounded-xl flex items-center justify-center px-2 h-11 text-center dark:bg-blue-600 text-xs font-medium">
                                        <span class="truncate w-full text-center">{{ trans('system.form.button.check') }}</span>
                                    </button>
                                    <button type="button" class="w-1/4 btn-reset text-white bg-gray-500 hover:bg-gray-600 rounded-xl flex items-center justify-center px-2 h-11 text-center text-xs font-medium hidden">
                                        <span class="truncate w-full text-center">{{ trans('system.form.button.reset') }}</span>
                                    </button>
                                </div>
                                @if ($errors->has('company')) <span class="text-red-600 text-xs block mt-1">{{ $errors->first('company') }}</span> @endif
                                @if ($errors->has('company_id')) <span class="text-red-600 text-xs block mt-1">{{ $errors->first('company_id') }}</span> @endif
                            </div>

                            <div>
                                <label for="first_name" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.first_name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" required placeholder="E.g: Saman" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('first_name')) <span class="text-red-600 text-xs">{{ $errors->first('first_name') }}</span> @endif
                            </div>

                            <div>
                                <label for="last_name" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.last_name') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" required placeholder="E.g: Gamage" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('last_name')) <span class="text-red-600 text-xs">{{ $errors->first('last_name') }}</span> @endif
                            </div>

                            <div>
                                <label for="telephone" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.telephone') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}" required placeholder="Eg: 0129 084 713" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                @if ($errors->has('telephone')) <span class="text-red-600 text-xs">{{ $errors->first('telephone') }}</span> @endif
                            </div>

                            <div>
                                <label for="recommended_by" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('general.Recommended by') }}</label>
                                <select class="select2 recommended_by mb-0 w-full" id="recommended_by" name="recommended_by" data-placeholder="{{ trans('auth.please_select_one') }}">
                                    <option></option>
                                    @foreach($recommendedList as $user)
                                        <option value="{{ $user->system }}-{{ $user->id }}">
                                            {{ strtoupper($user->system) }} - {{ $user->fullName }} - @if($user->system == 'cgo'){{ $user->institute?->name. "(". $user->institute?->reg_no . ")"}} @else {{ $user->tvetType?->head_office_code}} @endif
                                        </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('recommended_by')) <span class="text-red-600 text-xs">{{ $errors->first('recommended_by') }}</span> @endif
                            </div>

                            <!-- Button TAB 1 -->
                            <div class="flex justify-end pt-4">
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.next') ?? 'Next' }}
                                </button>
                            </div>
                        </div>

                        <!-- TAB 2: Account Info -->
                        <div class="tab-content flex-col gap-4" id="tab-1">
                            <div>
                                <label for="email" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.email') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}" required placeholder="You@email.com" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                <span id="email-error" class="text-red-600 text-xs"></span>
                                @if ($errors->has('email')) <span class="text-red-600 text-xs">{{ $errors->first('email') }}</span> @endif
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
                                <small class="text-xs dark:text-white" id="password-feedback"><i>{{ trans('auth.password_rules') ?? 'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character' }}</i></small>
                                @if ($errors->has('password')) <span class="text-red-600 text-xs">{{ $errors->first('password') }}</span> @endif
                            </div>

                            <div>
                                <label for="repassword" class="text-sm font-medium text-[#404040] block mb-1 dark:text-gray-300">{{ trans('system.form.confirm_password') }}<span class="text-red-600 p-1 text-center">*</span></label>
                                <div class="relative">
                                    <input type="password" name="repassword" id="repassword" required placeholder="{{ trans('auth.retype_password') ?? 'Retype your password' }}" class="bg-gray-50 border p-3 pl-4 h-11 border-gray-300 text-gray-900 sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-[#1E1E1E] dark:border-gray-500 dark:text-white">
                                    <button type="button" id="toggle-repassword" class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500">
                                        <svg id="eye-icon-show-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5"><path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path><path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path></svg>
                                        <svg id="eye-icon-hide-confirm" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5 hidden"><path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path><path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path></svg>
                                    </button>
                                </div>
                                <div id="repassword-feedback"></div>
                                @if ($errors->has('repassword')) <span class="text-red-600 text-xs">{{ $errors->first('repassword') }}</span> @endif
                                <div class="error_repassword text-red-600 text-xs pt-1"></div>
                            </div>

                            <!-- Button TAB 2 -->
                            <div class="flex justify-between pt-4">
                                <button type="button" onclick="nextPrev(-1)" class="text-gray-700 bg-gray-200 hover:bg-gray-300 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.previous') ?? 'Previous' }}
                                </button>
                                <button type="button" onclick="nextPrev(1)" class="text-white bg-[#4984F6] hover:bg-blue-700 font-medium rounded-xl text-md px-8 py-2.5">
                                    {{ trans('auth.next') ?? 'Next' }}
                                </button>
                            </div>
                        </div>

                        <!-- TAB 3: Confirmation -->
                        <div class="tab-content flex-col gap-4" id="tab-2">
                            <!-- Thông tin tóm tắt -->
                            <div class="bg-[#F8F9FA] dark:bg-[#2A2A2A] p-5 rounded-xl border border-gray-200 dark:border-gray-600 shadow-sm">
                                <h3 class="text-lg font-semibold text-gray-800 dark:text-white mb-4 border-b border-gray-200 dark:border-gray-600 pb-2">
                                    {{ trans('auth.review_information') ?? 'Review Your Information' }}
                                </h3>
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm text-gray-700 dark:text-gray-300">
                                    <div class="col-span-1 sm:col-span-2"><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.company_name') ?? 'Company Name' }}:</span> <span id="summary-company" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.full_name') ?? 'Representative Name' }}:</span> <span id="summary-name" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.telephone') }}:</span> <span id="summary-telephone" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('system.form.email') }}:</span> <span id="summary-email" class="font-medium"></span></div>
                                    <div><span class="font-medium text-gray-500 dark:text-gray-400">{{ trans('general.Recommended by') ?? 'Recommended By' }}:</span> <span id="summary-recommended" class="font-medium"></span></div>
                                </div>
                            </div>

                            <!-- Chọn phương thức Verify -->
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

                            <!-- Đồng ý điều khoản -->
                            <div class="flex items-center bg-gray-50 p-4 rounded-xl border border-gray-200 dark:bg-[#1E1E1E] dark:border-gray-500 mt-2">
                                <input id="agree_terms" name="agree_terms" type="checkbox" required class="mt-1 h-4 w-4 shrink-0 text-blue-600 focus:ring-blue-500 border-gray-500 rounded" value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }} />
                                <label for="agree_terms" class="pl-3 block text-sm text-gray-600 dark:text-gray-300">
                                    {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Company 2.pdf') ]) !!}
                                </label>
                            </div>
                            @if ($errors->has('agree_terms')) <span class="text-red-600 text-xs">{{ $errors->first('agree_terms') }}</span> @endif

                            <!-- Button TAB 3 -->
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

    <!-- Modal cấu trúc dữ liệu tìm kiếm Company -->
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-10rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <div class="max-w-2xl mx-auto w-full flex flex-col h-auto justify-start">
                    <div class="bg-white shadow-md border space-y-6 border-gray-200 rounded-xl px-10 py-5 dark:bg-gray-800 dark:border-gray-700">
                        <div class="flex flex-col gap-6">
                            <a href="{{route('company.auth.register')}}" data-modal-hide="modalEl"
                               class="text-gray-900 border-gray-200 font-medium rounded-xl text-sm w-fit text-center inline-flex items-center">
                                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7" />
                                </svg>
                                <span class="text-xl font-semibold text-gray-900 dark:text-white">{{trans('auth.Organisation Registration')}}</span>
                            </a>
                            <a href="/" class="flex items-center rtl:space-x-reverse w-fit">
                                <img src="/images/TVET.svg" alt="TVET Logo" />
                            </a>
                            <div class="flex flex-col gap-4">
                                <label for="modal_company" class="font-medium text-gray-600 block dark:text-gray-300 mb-2">
                                    {{trans('general.Company')}} <span class="text-red-600 p-1 text-center">*</span>
                                </label>
                                <div class="flex gap-4 mb-1">
                                    <input type="text" name="modal_company_input" placeholder="" class="w-5/6 p-3 pl-4 h-11 bg-gray-50 border border-[#EDEDED] text-[#91919A] sm:text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                                    <button type="button" class="checkCompanyButton text-white w-1/6 bg-[#4984F6] hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 rounded-xl flex items-center justify-center px-2 py-1 text-center dark:bg-blue-600 text-xs font-medium">
                                        {{trans('system.form.button.search')}}
                                    </button>
                                </div>
                                <div class="relative overflow-x-auto">
                                    <div class="loading flex items-center justify-center w-full h-32">
                                        <div role="status">
                                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                            <span class="sr-only">{{trans('system.form.loading')}}</span>
                                        </div>
                                    </div>
                                    <table class="w-full text-left rtl:text-right table-auto hidden">
                                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white">
                                        <tr>
                                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{trans('system.form.id')}}</th>
                                            <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base text-center">{{trans('system.form.company_name')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-body"></tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="{{route('company.register.get-form')}}" class="w-full text-white bg-[#4984F6] hover:bg-blue-800 font-medium rounded-xl text-xl px-5 py-3 text-center dark:bg-blue-600">{{trans('system.form.button.register_new_company')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script>
        // Các quy tắc và hàm cấu trúc xác thực Password (Global Scope)
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

        // Hàm Global quản lý Chuyển đổi các Tab và cập nhật Stepper
        let currentTab = 0;

        function showTab(n) {
            let tabs = document.querySelectorAll(".tab-content");
            tabs.forEach(tab => tab.classList.remove("active"));
            tabs[n].classList.add("active");

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

            // Khi chuyển dịch tới Tab xác nhận thông tin (Tab cuối)
            if (n === 2) {
                document.getElementById('summary-company').innerText = document.querySelector('input[name="company"]').value || 'N/A';
                document.getElementById('summary-name').innerText = (document.querySelector('input[name="first_name"]').value + ' ' + document.querySelector('input[name="last_name"]').value).trim() || 'N/A';
                document.getElementById('summary-telephone').innerText = document.querySelector('input[name="telephone"]').value || 'N/A';
                document.getElementById('summary-email').innerText = document.querySelector('input[name="email"]').value || 'N/A';

                let recommendedData = $('select[name="recommended_by"]').select2('data')[0];
                document.getElementById('summary-recommended').innerText = recommendedData && recommendedData.text ? recommendedData.text : 'N/A';

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

            // Ép buộc kiểm tra mã định danh Company ID tại bước đầu tiên
            if (tabIndex === 0) {
                let companyId = document.getElementById("company_id").value;
                if (!companyId) {
                    alert("{{ trans('auth.please_check_company_first') ?? 'Please check and select your Company name first.' }}");
                    return false;
                }
            }

            // Kiểm tra tính hợp lệ của hệ thống Password tại bước 2
            if (tabIndex === 1) {
                let pass = $('input[name="password"]').val();
                let repass = $('input[name="repassword"]').val();
                if (!window.isPasswordValid(pass, repass)) {
                    alert("{{ trans('auth.password_validation_failed') ?? 'Please ensure passwords match and meet the requirements.' }}");
                    return false;
                }
            }
            return true;
        }

        function validateTelephoneInput(input) {
            let value = input.value.replace(/\D/g, '');
            if (value.length >= 1 && value.charAt(0) !== "0") {
                value = "";
            }
            input.value = value.substring(0, 10);
        }
    </script>

    <script type="module">
        $(document).ready(function() {
            showTab(currentTab);

            document.getElementById('telephone').oninput = function() {
                validateTelephoneInput(this);
            };

            $('input[name="password"], input[name="repassword"]').on('input', function() {
                this.value = this.value.replace(/\s/g, '');
            });

            $('.select2').select2({
                placeholder: "{{ trans('auth.please_select_one') ?? 'Please select one' }}",
                allowClear: true,
                width: '100%'
            });

            // Logic quản lý trạng thái nút bấm Đăng ký cuối cùng
            window.toggleSignUpButton = function() {
                var companyValue = $('input[name="company"]').val();
                var companyId = $('#company_id').val();
                var firstNameValue = $('input[name="first_name"]').val();
                var lastNameValue = $('input[name="last_name"]').val();
                var emailValue = $('input[name="email"]').val();
                var passwordValue = $('input[name="password"]').val();
                var repasswordValue = $('input[name="repassword"]').val();
                var telephoneValue = $('input[name="telephone"]').val();
                var agreeTermsChecked = $('input[name="agree_terms"]').is(':checked');
                var verifyMethodChecked = $('input[name="verification_type"]:checked').length > 0;

                var isPasswordInvalid = !window.isPasswordValid(passwordValue, repasswordValue);

                var anyFieldEmptyOrNull = !companyValue || !companyId || !firstNameValue || !lastNameValue || !emailValue ||
                    !passwordValue || !repasswordValue || !telephoneValue || !agreeTermsChecked || !verifyMethodChecked;

                if (anyFieldEmptyOrNull || isPasswordInvalid) {
                    $('#signup-button').addClass('disabled-button').prop('disabled', true);
                } else {
                    $('#signup-button').removeClass('disabled-button').prop('disabled', false);
                }
            };

            function toggleCheckButton() {
                let companyValue = $('input[name="company"]').val();
                if (!companyValue) {
                    $('.checkCompanyButton').addClass('disabled-button cursor-not-allowed').prop('disabled', true);
                } else {
                    $('.checkCompanyButton').removeClass('disabled-button cursor-not-allowed').prop('disabled', false);
                }
            }

            window.toggleSignUpButton();
            toggleCheckButton();

            $('input, select').on('input change', function() {
                window.toggleSignUpButton();
                toggleCheckButton();
            });

            // Đồng bộ hoá dữ liệu nhập giữa ô tìm kiếm chính và ô input trong Modal
            $("input[name='company']").on('input', function() {
                $("input[name='modal_company_input']").val($(this).val());
            });
            $("input[name='modal_company_input']").on('input', function() {
                $("input[name='company']").val($(this).val());
                toggleCheckButton();
            });

            if ($('input[name="company"]').val().trim() !== '' && $('#company_id').val().trim() !== '') {
                $('.btn-reset').removeClass('hidden');
                $('.checkCompanyButton').addClass('hidden');
            }

            // Gắn khung Modal Flowbite
            const $targetEl = document.getElementById('modalEl');
            const options = { placement: 'center-center', backdrop: 'fixed', closable: true };
            window.modal = new Modal($targetEl, options);

            $(".checkCompanyButton").click(function (e) {
                e.preventDefault();
                $("#company_id").val('');
                $(".loading").removeClass('hidden');
                $("table").addClass('hidden');
                let keyword = $("input[name='company']").val();

                if(keyword != '') {
                    window.modal.show();
                    $.ajax({
                        type:'GET',
                        url:'/company/search/'+ keyword,
                        success:function(data) {
                            $(".table-body").html('');
                            let datas = data.data;
                            if(datas.length > 0) {
                                for(let i = 0; i < datas.length; i++) {
                                    let company_name = `<span class="dark:text-white">${datas[i].name} (${datas[i].district.name})</span>`;
                                    if(datas[i].verified_at == null && data.verified_by == null) {
                                        company_name += ` <span class="rounded-lg bg-gray-400 text-white px-2 py-1 text-xs">{{trans('company.pending_approval')}}</span>`;
                                    }
                                    if(datas[i].is_belongs_to_naita == true) {
                                        company_name += `
                                                    <span class="rounded-lg bg-blue-100 text-primary px-2 py-1 text-xs">NAITA</span>`;
                                    }

                                    $("#modalEl .table-body").append(`
                                        <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                            <td class="px-3 py-2 font-semibold text-sm text-[#201F36] dark:text-white">${datas[i].id}</td>
                                            <td class="px-3 py-2 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                                <div class="flex justify-between items-center">
                                                    <div class="text-left flex justify-between w-full">${company_name}</div>
                                                    <button type="button" class="btn-copy ml-2 text-blue-600 underline hover:text-blue-800" data-copy-id="${datas[i].id}" data-copy-name="${datas[i].name}">
                                                        {{trans('company.Select')}}
                                    </button>
                                </div>
                            </td>
                        </tr>
`);
                                }
                            } else {
                                $("#modalEl .table-body").append(`
                                    <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700">
                                        <td class="px-3 py-2 font-semibold text-sm text-[#201F36] dark:text-white">{{trans('company.not_found')}}</td>
                                    </tr>`);
                            }
                            $(".loading").addClass('hidden');
                            $("table").removeClass('hidden');
                        }
                    });
                } else {
                    alert("{{ trans('auth.please_insert_keyword') ?? 'Please insert company keyword!' }}");
                }
            });

            // Toggle Password hiển thị trực quan
            $('#toggle-password').click(function() {
                const passwordInput = $('input[name="password"]');
                $('#eye-icon-show').toggleClass('hidden');
                $('#eye-icon-hide').toggleClass('hidden');
                passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
            });

            $('#toggle-repassword').click(function() {
                const repasswordInput = $('input[name="repassword"]');
                $('#eye-icon-show-confirm').toggleClass('hidden');
                $('#eye-icon-hide-confirm').toggleClass('hidden');
                repasswordInput.attr('type', repasswordInput.attr('type') === 'password' ? 'text' : 'password');
            });
        });

        // Xử lý sự kiện khi chọn công ty từ Modal
        $(document).on('click', '.btn-copy', function(e) {
            let name = $(this).data('copy-name');
            let id = $(this).data('copy-id');
            if(name != '') {
                $("input[name='company']").val(name).attr('readonly', 'true').addClass('border-green-700');
                $("input[name='modal_company_input']").val(name);
                $("#company_id").val(id);
                $('.checkCompanyButton').addClass('hidden');
                $('.btn-reset').removeClass('hidden');
                window.modal.hide();
                window.toggleSignUpButton();
            }
        });

        $(document).on('click', '.btn-reset', function(e) {
            $("input[name='company']").val('').removeAttr('readonly').removeClass('border-green-700');
            $("input[name='modal_company_input']").val('');
            $("#company_id").val('');
            $('.btn-reset').addClass('hidden');
            $('.checkCompanyButton').removeClass('hidden');
            window.toggleSignUpButton();
        });

        // Xác thực Email real-time
        $(document).ready(function() {
            $('input[name="email"]').on('input', function() {
                const email = $(this).val();
                const errorSpan = $('#email-error');
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

                if (email === '') {
                    errorSpan.text("{{ trans('auth.email_blank') ?? 'Email cannot be blank.' }}");
                } else if (!emailRegex.test(email)) {
                    errorSpan.text("{{ trans('auth.email_invalid') ?? 'Email is not in correct format.' }}");
                } else {
                    errorSpan.text('');
                }
            });
        });

        // Khớp mật khẩu gõ lại dữ liệu hình ảnh phản hồi
        function validatePasswords() {
            const passwordInput = document.querySelector('input[name="password"]');
            const repasswordInput = document.querySelector('input[name="repassword"]');
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
                } else {
                    passwordInput.classList.add('border-red-500');
                }
            }

            if (repassword) {
                if (password === repassword && isPasswordValid) {
                    repasswordInput.classList.add('border-green-500');
                    if (repasswordFeedback) repasswordFeedback.style.display = 'none';
                    $(".error_repassword").html('');
                } else {
                    repasswordInput.classList.add('border-red-500');
                    $(".error_repassword").html("{{ trans('auth.passwords_not_match') ?? 'Confirmation password not match!' }}");
                }
            }
            return isPasswordValid && password === repassword;
        }

        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.querySelector('input[name="password"]');
            const repasswordInput = document.querySelector('input[name="repassword"]');
            passwordInput.addEventListener('input', validatePasswords);
            repasswordInput.addEventListener('input', validatePasswords);
        });
    </script>
@endpush
