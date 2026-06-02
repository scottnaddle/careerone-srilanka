@extends('auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button { pointer-events: none; background-color: gray; }
        .step-content { display: none; }
        .step-content.active { display: block; }
    </style>
@endpush

@section('content')
    <div class="w-full max-w-2xl mx-auto py-16 md:py-24 px-4">
        <div class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100/80 dark:border-gray-700 rounded-2xl p-8 md:p-10">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center w-fit">
                    <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-10 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-10 hidden dark:block" alt="Careerone Logo" />
                </a>

                @if (session()->get('error'))
                    <span class="block bg-red-50 text-red-700 text-sm font-medium px-4 py-3 rounded-xl border border-red-200 dark:bg-red-900/20 dark:text-red-400 dark:border-red-800">{{ session()->get('error') }}</span>
                @endif
                @if (session()->get('message'))
                    <div class="block bg-green-50 text-green-700 text-sm font-medium px-4 py-3 rounded-xl border border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800">{{ session()->get('message') }}</div>
                @endif
                @if (session()->has('success'))
                    <div class="block bg-green-50 text-green-700 text-sm font-medium px-4 py-3 rounded-xl border border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800">{{ session()->get('success') }}</div>
                @endif

                {{-- Step Indicator --}}
                @php $steps = [
                    ['label' => trans('auth.Company Info'), 'fields' => 2],
                    ['label' => trans('auth.Personal Info'), 'fields' => 4],
                    ['label' => trans('auth.Account Setup'), 'fields' => 4],
                ]; @endphp
                <x-step-indicator :steps="$steps" :currentStep="0" id="step-indicator" />

                {{-- Form --}}
                <form class="space-y-5" action="{{ route('company.auth.postRegister') }}" method="POST"
                    enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="text" name="company_id" class="hidden" id="company_id" value="{{old('company_id')}}">

                    {{-- === STEP 1: COMPANY INFO === --}}
                    <div class="step-content active" data-step="0">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">{{ trans('auth.Company Information') }}</h3>
                        <div class="space-y-4">
                            {{-- Company Name --}}
                            <div>
                                <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{__('auth.Company name')}} <span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="flex gap-2">
                                    <input type="text" name="company" id="company" value="{{ old('company') }}"
                                        placeholder=" {{__('auth.Type Name of Company and click Check')}}"
                                        class="flex-1 px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="checkCompanyBtn"
                                        class="checkCompanyButton px-5 py-3 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-full transition-all shrink-0">
                                        {{ trans('system.form.button.check') }}
                                    </button>
                                    <button type="button" id="resetCompanyBtn"
                                        class="btn-reset px-5 py-3 text-sm font-semibold text-white bg-gray-400 hover:bg-gray-500 rounded-full transition-all shrink-0 hidden">
                                        {{ trans('system.form.button.reset') }}
                                    </button>
                                </div>
                                @if ($errors->has('company'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('company') }}</p>
                                @endif
                                @if ($errors->has('company_id'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('company_id') }}</p>
                                @endif
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{trans('system.form.email')}}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="You@email.com"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                @if ($errors->has('email'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('email') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- === STEP 2: PERSONAL INFO === --}}
                    <div class="step-content" data-step="1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">{{ trans('auth.Personal Information') }}</h3>
                        <div class="space-y-4">
                            {{-- Name Row --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        {{trans('system.form.first_name')}}<span class="text-red-500 ml-0.5">*</span>
                                    </label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                        placeholder="E.g: Saman"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    @if ($errors->has('first_name'))
                                        <p class="mt-1 text-xs text-red-500">{{ $errors->first('first_name') }}</p>
                                    @endif
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        {{trans('system.form.last_name')}}<span class="text-red-500 ml-0.5">*</span>
                                    </label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                        placeholder="E.g: Gamage"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    @if ($errors->has('last_name'))
                                        <p class="mt-1 text-xs text-red-500">{{ $errors->first('last_name') }}</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Telephone --}}
                            <div>
                                <label for="telephone" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{trans('system.form.telephone')}}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <input type="text" name="telephone" id="telephone" value="{{ old('telephone') }}"
                                    placeholder="Eg: 0129 084 713"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                @if ($errors->has('telephone'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('telephone') }}</p>
                                @endif
                            </div>

                            {{-- Recommended By --}}
                            <div>
                                <label for="recommended_by" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('general.Recommended by') }}
                                </label>
                                <select class="select2 recommended_by block w-full" id="recommended_by" name="recommended_by" style="width:100%"
                                    data-placeholder="{{trans('auth.Please select one')}}">
                                    <option></option>
                                    @forelse($recommendedList as $user)
                                        <option value="{{$user->system}}-{{ $user->id }}">
                                            {{ strtoupper($user->system) }} - {{$user->fullName}} - @if($user->system == 'cgo'){{ $user->institute?->name. "(\". $user->institute?->reg_no . ")"}} @else {{ $user->tvetType?->head_office_code}} @endif
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('recommended_by'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('recommended_by') }}</p>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- === STEP 3: ACCOUNT SETUP === --}}
                    <div class="step-content" data-step="2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">{{ trans('auth.Account Setup') }}</h3>
                        <div class="space-y-4">
                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{trans('system.form.password')}}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all pr-12 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="toggle-password" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="eye-icon-show">
                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden" id="eye-icon-hide">
                                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <small class="text-xs text-gray-400 dark:text-gray-500 mt-1 block" id="password-feedback"><i>{{trans('auth.Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character')}}</i></small>
                                @if ($errors->has('password'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('password') }}</p>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="repassword" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{trans('system.form.confirm_password')}}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="repassword" id="repassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all pr-12 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="toggle-repassword" class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="eye-icon-show-confirm">
                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden" id="eye-icon-hide-confirm">
                                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="repassword-feedback" class="error_repassword text-red-500 text-xs mt-1"></div>
                                @if ($errors->has('repassword'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('repassword') }}</p>
                                @endif
                            </div>

                            {{-- Verification Method --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{trans('system.form.preferred_verification_method')}}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="flex gap-6">
                                    @foreach(getCodeList('verification_method') as $item)
                                    <div class="flex items-center">
                                        <input type="checkbox" name="verification_type" value="{{strtolower(str_replace('-', '', $item->code_name))}}"
                                        {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}
                                            class="w-4 h-4 shrink-0 border-gray-300 text-primary focus:ring-primary/30 dark:bg-gray-700 dark:border-gray-600"
                                            id="verify-{{$item->code_id}}">
                                        <label for="verify-{{$item->code_id}}"
                                            class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{$item->code_name}}</label>
                                    </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('verification_type'))
                                    <p class="mt-1 text-xs text-red-500">{{ $errors->first('verification_type') }}</p>
                                @endif
                            </div>

                            {{-- Terms --}}
                            <div class="flex items-start">
                                <input id="agree_terms" name="agree_terms" type="checkbox"
                                    class="mt-0.5 w-4 h-4 shrink-0 text-primary focus:ring-primary/30 border-gray-300 rounded dark:bg-gray-700 dark:border-gray-600"
                                    value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }} />
                                <label for="agree_terms" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                    {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Company 2.pdf') ]) !!}
                                </label>
                            </div>
                            @if ($errors->has('agree_terms'))
                                <p class="mt-1 text-xs text-red-500">{{ $errors->first('agree_terms') }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" id="prev-step"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full transition-all dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 opacity-50 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                            {{ trans('system.form.button.back') }}
                        </button>
                        <button type="button" id="next-step"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-full transition-all shadow-md">
                            {{ trans('system.form.button.next') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </button>
                        <button type="submit" id="signup-button" disabled
                            class="hidden w-full py-3.5 px-6 text-base font-semibold text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/30 rounded-full transition-all duration-200 shadow-lg shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed">
                            {{trans('auth.sign_up')}}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Company Search Modal --}}
    <div id="modalEl" tabindex="-1" aria-hidden="true" class="fixed left-0 right-0 top-0 z-50 hidden h-[calc(100%-10rem)] max-h-full w-full overflow-y-auto overflow-x-hidden p-4 md:inset-0">
        <div class="relative max-h-full w-full max-w-2xl">
            <div class="relative rounded-lg bg-white shadow dark:bg-gray-700">
                <div class="max-w-2xl mx-auto w-screen flex flex-col h-auto justify-start">
                    <div class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100/80 dark:border-gray-700 rounded-2xl p-8 space-y-6">
                        <div class="flex flex-col gap-4">
                            <a href="{{route('company.auth.register')}}" data-modal-hide="modalEl"
                               class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/></svg>
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">{{trans('auth.Organisation Registration')}}</span>
                            </a>
                            <a href="/" class="flex items-center w-fit">
                                <img src="/images/TVET.svg" alt="TVET Logo" class="h-10" />
                            </a>
                            <div class="flex flex-col gap-4">
                                <label for="company" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1">
                                    {{trans('general.Company')}} <span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="flex gap-4">
                                    <input type="text" id="modalCompanyInput" name="company" value="{{ old('company') }}"
                                           placeholder=""
                                           class="flex-1 px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="modalSearchBtn"
                                            class="px-5 py-3 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-full transition-all shrink-0">
                                        {{trans('system.form.button.search')}}
                                    </button>
                                </div>
                                <div class="relative overflow-x-auto">
                                    <div class="loading flex items-center justify-center w-full h-32 hidden">
                                        <div role="status">
                                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-primary" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
                                            </svg>
                                            <span class="sr-only">{{trans('system.form.loading')}}</span>
                                        </div>
                                    </div>
                                    <table class="w-full text-left rtl:text-right table-auto hidden">
                                        <thead class="bg-gray-50 dark:bg-gray-700">
                                            <tr>
                                                <th scope="col" class="px-4 py-2.5 text-sm font-semibold text-primary dark:text-white">{{trans('system.form.id')}}</th>
                                                <th scope="col" class="px-4 py-2.5 text-sm font-semibold text-primary dark:text-white text-center">{{trans('system.form.company_name')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-body"></tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="{{route('company.register.get-form')}}"
                                class="w-full py-3.5 px-6 text-base font-semibold text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/30 rounded-full transition-all duration-200 shadow-lg shadow-primary/20 text-center block">
                                {{trans('system.form.button.register_new_company')}}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="{{ asset('js/select2.js') }}" type="module"></script>
    <script type="module">
        function validateTelephoneInput(input) {
            let value = input.value;
            if (value.length >= 1 && value.charAt(0) !== "0") { value = ""; }
            value = value.replace(/\D/g, '');
            value = value.substring(0, 10);
            input.value = value;
        }
        document.getElementById('telephone').oninput = function() { validateTelephoneInput(this); };
    </script>
    <script type="module">
        $(document).ready(function() {
            let currentStep = 0;
            const totalSteps = {{ count($steps) }};

            // Step indicator update function (same pattern as CGO)
            function updateSteps() {
                $('.step-indicator-dot').each(function(i) {
                    const dot = $(this);
                    dot.removeClass('bg-primary text-white ring-4 ring-primary/20 shadow-lg shadow-primary/30 scale-110 bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 border-2 border-gray-200 dark:border-gray-600');
                    if (i < currentStep) {
                        dot.addClass('bg-primary text-white shadow-md shadow-primary/30');
                        dot.html('<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.5 12.75l6 6 9-13.5"/></svg>');
                    } else if (i === currentStep) {
                        dot.addClass('bg-primary text-white ring-4 ring-primary/20 shadow-lg shadow-primary/30 scale-110');
                        dot.text(i + 1);
                    } else {
                        dot.addClass('bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 border-2 border-gray-200 dark:border-gray-600');
                        dot.text(i + 1);
                    }
                });

                $('.step-content').removeClass('active').hide();
                $(`.step-content[data-step="${currentStep}"]`).addClass('active').show();

                const prevBtn = $('#prev-step');
                const nextBtn = $('#next-step');
                const submitBtn = $('#signup-button');

                if (currentStep === 0) {
                    prevBtn.addClass('opacity-50 pointer-events-none');
                } else {
                    prevBtn.removeClass('opacity-50 pointer-events-none');
                }

                if (currentStep === totalSteps - 1) {
                    nextBtn.hide();
                    submitBtn.removeClass('hidden').show();
                } else {
                    nextBtn.show();
                    submitBtn.hide();
                }
            }

            $('#next-step').click(function() {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateSteps();
                    $('html, body').animate({ scrollTop: $('.step-content').offset().top - 100 }, 300);
                }
            });

            $('#prev-step').click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateSteps();
                    $('html, body').animate({ scrollTop: $('.step-content').offset().top - 100 }, 300);
                }
            });

            $('.select2').select2({ placeholder: "{{trans('auth.Please select one')}}" });

            // Verification type: ensure only one checkbox
            $('input[name="verification_type"]').on('change', function() {
                if ($(this).is(':checked')) {
                    $('input[name="verification_type"]').not(this).prop('checked', false);
                }
                toggleSignUpButton();
            });

            // Modal setup
            const $targetEl = document.getElementById('modalEl');
            window.modal = new Modal($targetEl, {
                placement: 'center-center',
                backdrop: 'fixed',
                backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
                closable: true,
            });

            function isPasswordValid(password, repassword = null) {
                const rules = [
                    (v) => v.length >= 8 && v.length <= 16,
                    (v) => /[A-Z]/.test(v),
                    (v) => /[!@#$%^&*(),.?\":{}|<>]/.test(v),
                    (v) => /[0-9]/.test(v)
                ];
                const mainOk = rules.every(r => r(password));
                return repassword === null ? mainOk : (mainOk && password === repassword);
            }

            function toggleSignUpButton() {
                const fields = { '#company': '', '#email': '', '#first_name': '', '#last_name': '', '#telephone': '', '#password': '', '#repassword': '' };
                const allFilled = Object.keys(fields).every(s => $(s).val());
                const agreeChecked = $('#agree_terms').is(':checked');
                const verifyChecked = $('input[name="verification_type"]:checked').length > 0;
                const pw = $('#password').val();
                const rpw = $('#repassword').val();
                const pwOk = isPasswordValid(pw, rpw);

                if (allFilled && agreeChecked && verifyChecked && pwOk) {
                    $('#signup-button').removeClass('disabled-button').prop('disabled', false);
                } else {
                    $('#signup-button').addClass('disabled-button').prop('disabled', true);
                }
            }

            toggleSignUpButton();
            $('input, select').on('input change', function() {
                toggleSignUpButton();
                toggleCheckButton();
            });

            function toggleCheckButton() {
                const companyVal = $('#company').val();
                if (!companyVal) {
                    $('.checkCompanyButton').addClass('disabled-button cursor-not-allowed').prop('disabled', true);
                } else {
                    $('.checkCompanyButton').removeClass('disabled-button cursor-not-allowed').prop('disabled', false);
                }
            }
            toggleCheckButton();

            // Sync company input across form and modal
            $("input[name='company']").on('input', function() {
                let value = $(this).val();
                $("input[name='company']").not(this).val(value);
            });

            if ($('#company').val().trim() !== '' && $('#company_id').val().trim() !== '') {
                $('.btn-reset').removeClass('hidden');
                $('.checkCompanyButton').addClass('hidden');
            }

            // Company search
            $("#checkCompanyBtn, #modalSearchBtn").click(function (e) {
                e.preventDefault();
                $("#company_id").val('');
                $(".loading").removeClass('hidden');
                $("table").addClass('hidden');
                let keyword = $("input[name='company']").val();
                if(keyword != '') {
                    window.modal.show();
                    $.ajax({
                        type:'GET', url:'/company/search/'+ keyword,
                        success:function(data) {
                            $(".table-body").html('');
                            let datas = data.data;
                            if(datas.length > 0) {
                                for(let i = 0; i < datas.length; i++) {
                                    let company_name = `<span class="dark:text-white">${datas[i].name} (${datas[i].district.name})</span>`;
                                    if(datas[i].verified_at == null && data.verified_by == null) {
                                        company_name += `<span class="rounded-lg bg-gray-400 text-white px-2 py-1 text-xs">{{trans('company.pending_approval')}}</span>`;
                                    }
                                    $(".table-body").append(`
                                        <tr class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
                                            <td class="px-3 py-2 font-semibold text-sm text-gray-900 dark:text-white">${datas[i].id}</td>
                                            <td class="px-3 py-2 text-sm text-gray-600 dark:text-gray-300">
                                                <div class="flex justify-between items-center">
                                                    <div>${company_name}</div>
                                                    <button class="btn-copy ml-2 text-primary hover:text-primary/80 underline text-sm font-medium" data-copy-id="${datas[i].id}" data-copy-name="${datas[i].name}">
                                                        {{trans('company.Select')}}
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    `);
                                }
                            } else {
                                $(".table-body").append(`<tr><td colspan="2" class="px-3 py-4 text-sm text-gray-500 text-center">{{trans('company.not_found')}}</td></tr>`);
                            }
                            $(".loading").addClass('hidden');
                            $("table").removeClass('hidden');
                        }
                    });
                } else {
                    Toastify({ text: "Please insert company keyword!", duration: 2000, className: "error", style: { background: "#e74c3c" } }).showToast();
                }
            });

            // Password toggle
            $('#toggle-password').click(function() {
                const inp = $('#password'); const show = $('#eye-icon-show'); const hide = $('#eye-icon-hide');
                if (inp.attr('type') === 'password') { inp.attr('type', 'text'); show.addClass('hidden'); hide.removeClass('hidden'); }
                else { inp.attr('type', 'password'); show.removeClass('hidden'); hide.addClass('hidden'); }
            });
            $('#toggle-repassword').click(function() {
                const inp = $('#repassword'); const show = $('#eye-icon-show-confirm'); const hide = $('#eye-icon-hide-confirm');
                if (inp.attr('type') === 'password') { inp.attr('type', 'text'); show.addClass('hidden'); hide.removeClass('hidden'); }
                else { inp.attr('type', 'password'); show.removeClass('hidden'); hide.addClass('hidden'); }
            });

            // Confirm password mismatch
            $('#repassword').on('input', function() {
                let value = $(this).val();
                if($("#password").val() && value != $("#password").val()) {
                    $(".error_repassword").html('Confirmation password not match!');
                } else {
                    $(".error_repassword").html('');
                }
            });

            // Copy/Select company from modal
            $(document).on('click', '.btn-copy', function(event) {
                let name = $(this).data('copy-name');
                let id = $(this).data('copy-id');
                if(name != '') {
                    $("input[name='company']").val(name);
                    $("#company_id").val(id);
                    $("input[name='company']").attr('readonly', 'true');
                    $("input[name='company']").addClass('border-green-500');
                    $('.checkCompanyButton').addClass('hidden');
                    $('.btn-reset').removeClass('hidden');
                    window.modal.hide();
                }
            });

            $(document).on('click', '.btn-reset', function(event) {
                $("input[name='company']").val('').removeAttr('readonly').removeClass('border-green-500');
                $('.btn-reset').addClass('hidden');
                $('.checkCompanyButton').removeClass('hidden');
            });

            // Real-time password validation
            const validationRules = [
                { test: (v) => v.length >= 8 && v.length <= 16, msg: '8-16 characters' },
                { test: (v) => /[A-Z]/.test(v), msg: '1 uppercase' },
                { test: (v) => /[!@#$%^&*(),.?":{}|<>]/.test(v), msg: '1 special char' },
                { test: (v) => /[0-9]/.test(v), msg: '1 number' }
            ];

            function validatePasswords() {
                const pw = document.getElementById('password');
                const rpw = document.getElementById('repassword');
                const fb = document.getElementById('password-feedback');
                const rfb = document.getElementById('repassword-feedback');
                pw.classList.remove('border-red-500', 'border-green-500');
                rpw.classList.remove('border-red-500', 'border-green-500');

                const valid = validationRules.every(r => r.test(pw.value));
                if (pw.value) {
                    pw.classList.add(valid ? 'border-green-500' : 'border-red-500');
                    fb.style.display = valid ? 'none' : 'block';
                }
                if (rpw.value) {
                    const match = pw.value === rpw.value && valid;
                    rpw.classList.add(match ? 'border-green-500' : 'border-red-500');
                    rfb.textContent = match ? '' : 'Passwords do not match';
                }
            }

            document.getElementById('password').addEventListener('input', validatePasswords);
            document.getElementById('repassword').addEventListener('input', validatePasswords);

            updateSteps();
        });
    </script>
@endpush
