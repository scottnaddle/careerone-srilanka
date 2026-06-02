@extends('schoolkid.auth.layouts.master')

@section('title', 'Sign Up')
<link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
<link href="{{ asset('css/filepond/filepond.css') }}" rel="stylesheet" />
@push('css')
    <style>
        .disabled-button { pointer-events: none; background-color: gray; }
        .step-content { display: none; }
        .step-content.active { display: block; }
        .search-results { @apply absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto; }
    </style>
@endpush

@section('content')
    <div class="w-full max-w-2xl mx-auto py-16 md:py-24 px-4">
        <div class="bg-white dark:bg-gray-800 shadow-xl border border-gray-100/80 dark:border-gray-700 rounded-2xl p-8 md:p-10">
            <div class="flex flex-col gap-6">
                <a href="/choose-login"
                   class="inline-flex items-center gap-2 text-sm font-medium text-gray-500 hover:text-primary dark:text-gray-400 dark:hover:text-primary transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                    </svg>
                    {{ trans('auth.choose_login_title') }}
                </a>

                <a href="/" class="flex items-center w-fit">
                    <img src="{{asset('/images/careerone-logo.png')}}" class="h-8 md:h-10 block dark:hidden" alt="Careerone Logo" />
                    <img src="{{asset('/images/careerone-logo-dark.png')}}" class="h-8 md:h-10 hidden dark:block" alt="Careerone Logo" />
                </a>
                @if (session()->get('error'))
                    <span class="block bg-green-50 text-green-700 text-sm font-medium px-4 py-3 rounded-xl border border-green-200 dark:bg-green-900/20 dark:text-green-400 dark:border-green-800">{{ session()->get('error') }}</span>
                @endif

                {{-- Step Indicator --}}
                @php $steps = [
                    ['label' => 'Personal Info', 'fields' => 4],
                    ['label' => 'Contact & Location', 'fields' => 4],
                    ['label' => 'Account Setup', 'fields' => 4],
                ]; @endphp
                <x-step-indicator :steps="$steps" :currentStep="0" id="step-indicator" />

                {{-- Form --}}
                <form class="space-y-5 leading-5" action="{{ route('schoolkid.auth.postRegister') }}" method="POST"
                      enctype="multipart/form-data" autocomplete="off">
                    @csrf
                    <input type="hidden" name="current_step" id="current_step_input" value="0">

                    {{-- === STEP 1: PERSONAL INFO === --}}
                    <div class="step-content active" data-step="0">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">{{ 'Personal Information' }}</h3>
                        <div class="space-y-4">
                            {{-- Name Row --}}
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label for="first_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        {{ trans('system.form.first_name') }}<span class="text-red-500 ml-0.5">*</span>
                                    </label>
                                    <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Your first name">
                                    @if ($errors->has('first_name'))
                                        <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('first_name') }}</span>
                                    @endif
                                </div>
                                <div>
                                    <label for="last_name" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                        {{ trans('system.form.last_name') }}<span class="text-red-500 ml-0.5">*</span>
                                    </label>
                                    <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Your last name">
                                    @if ($errors->has('last_name'))
                                        <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('last_name') }}</span>
                                    @endif
                                </div>
                            </div>

                            {{-- Email --}}
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.email') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                    placeholder="You@email.com"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                <span id="email-error" class="text-red-500 text-xs mt-1 block"></span>
                                @if ($errors->has('email'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            {{-- Gender --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.gender') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="flex gap-6">
                                    @foreach(getCodeList('gender') as $gender)
                                        <div class="flex items-center">
                                            <input type="radio" name="gender" value="{{$gender->code_id}}"
                                                {{ old('gender') == $gender->code_id ? 'checked' : '' }}
                                                class="shrink-0 w-4 h-4 border-gray-300 text-primary focus:ring-primary/30 dark:bg-gray-700 dark:border-gray-600"
                                                id="gender-{{$gender->code_id}}" required>
                                            <label for="gender-{{$gender->code_id}}"
                                                class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{$gender->code_name}}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('gender'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('gender') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- === STEP 2: CONTACT & LOCATION === --}}
                    <div class="step-content" data-step="1">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Contact & Location</h3>
                        <div class="space-y-4">
                            {{-- Contact Address --}}
                            <div>
                                <label for="contact_address" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.contact_address') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address') }}"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" placeholder="Your contact address">
                                @if ($errors->has('contact_address'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('contact_address') }}</span>
                                @endif
                            </div>

                            {{-- District --}}
                            <div>
                                <label for="district_id" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.district') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <select class="select2 block w-full" id="districtSelect" name="district_id" style="width: 100%"
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
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('district_id') }}</span>
                                @endif
                            </div>

                            {{-- Mobile --}}
                            <div>
                                <label for="mobile" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.mobile') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <input type="text" name="mobile" id="mobile" value="{{ old('mobile') }}"
                                    placeholder="Eg: 075 555 5555"
                                    class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400" required>
                                @if ($errors->has('mobile'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('mobile') }}</span>
                                @endif
                            </div>

                            {{-- Recommended by --}}
                            <div>
                                <label for="recommended_by" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('general.Recommended by') }}
                                </label>
                                <select class="select2 block w-full" id="recommended_by" name="recommended_by" style="width: 100%"
                                    data-placeholder="{{trans('auth.Please select one')}}">
                                    <option></option>
                                    @forelse($recommendedList as $user)
                                        <option value="{{$user->system}}-{{ $user->id }}" {{ old('recommended_by') == $user->system.'-'.$user->id ? 'selected' : '' }}>
                                            {{ strtoupper($user->system) }} - {{$user->fullName}} @if($user->system == 'cgo')- {{ $user->institute?->name. "(". $user->institute?->reg_no . ")"}} @else - {{ $user->tvetType?->head_office_code}} @endif
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                                @if ($errors->has('recommended_by'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('recommended_by') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- === STEP 3: ACCOUNT SETUP === --}}
                    <div class="step-content" data-step="2">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-5">Account Setup</h3>
                        <div class="space-y-4">
                            {{-- Password --}}
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.password') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="password" id="password" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all pr-12 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="toggle-password"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
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
                                <small class="text-xs text-gray-500 dark:text-gray-400 mt-1 block"><i>{{ trans('auth.password_feeback') }}</i></small>
                                @if ($errors->has('password'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            {{-- Confirm Password --}}
                            <div>
                                <label for="repassword" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.confirm_password') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="relative">
                                    <input type="password" name="repassword" id="repassword" placeholder="&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;&#8226;"
                                        class="block w-full px-4 py-3 text-sm text-gray-900 bg-gray-50 border-2 border-gray-200 rounded-xl placeholder-gray-400 focus:border-primary focus:ring-2 focus:ring-primary/20 focus:outline-none transition-all pr-12 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:placeholder-gray-400">
                                    <button type="button" id="toggle-repassword"
                                        class="absolute inset-y-0 right-0 flex items-center pr-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300 transition-colors">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5" id="eye-icon-show-repassword">
                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                        </svg>
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 hidden" id="eye-icon-hide-repassword">
                                            <path fill-rule="evenodd" d="M3.28 2.22a.75.75 0 0 0-1.06 1.06l14.5 14.5a.75.75 0 1 0 1.06-1.06l-1.745-1.745a10.029 10.029 0 0 0 3.3-4.38 1.651 1.651 0 0 0 0-1.185A10.004 10.004 0 0 0 9.999 3a9.956 9.956 0 0 0-4.744 1.194L3.28 2.22ZM7.752 6.69l1.092 1.092a2.5 2.5 0 0 1 3.374 3.373l1.091 1.092a4 4 0 0 0-5.557-5.557Z" clip-rule="evenodd"></path>
                                            <path d="m10.748 13.93 2.523 2.523a9.987 9.987 0 0 1-3.27.547c-4.258 0-7.894-2.66-9.337-6.41a1.651 1.651 0 0 1 0-1.186A10.007 10.007 0 0 1 2.839 6.02L6.07 9.252a4 4 0 0 0 4.678 4.678Z"></path>
                                        </svg>
                                    </button>
                                </div>
                                <div id="repassword-feedback"></div>
                                @if ($errors->has('repassword'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('repassword') }}</span>
                                @endif
                            </div>

                            {{-- Verification Method --}}
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-1.5">
                                    {{ trans('system.form.preferred_verification_method') }}<span class="text-red-500 ml-0.5">*</span>
                                </label>
                                <div class="flex gap-6">
                                    @foreach(getCodeList('verification_method') as $item)
                                        <div class="flex items-center">
                                            <input type="radio" name="verification_type"
                                                value="{{ strtolower(str_replace('-', '', $item->code_name)) }}"
                                                {{ old('verification_type') == strtolower(str_replace('-', '', $item->code_name)) ? 'checked' : '' }}
                                                class="shrink-0 w-4 h-4 border-gray-300 text-primary focus:ring-primary/30 dark:bg-gray-700 dark:border-gray-600"
                                                id="verify-{{ $item->code_id }}">
                                            <label for="verify-{{ $item->code_id }}"
                                                class="text-sm text-gray-600 dark:text-gray-400 ml-2">{{ $item->code_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                                @if ($errors->has('verification_type'))
                                    <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('verification_type') }}</span>
                                @endif
                            </div>

                            {{-- Terms --}}
                            <div class="flex items-start">
                                <input id="agree_terms" name="agree_terms" type="radio"
                                    class="mt-0.5 w-4 h-4 shrink-0 text-primary focus:ring-primary/30 border-gray-300 dark:bg-gray-700 dark:border-gray-600"
                                    value="1" {{ old('agree_terms') == '1' ? 'checked' : '' }} />
                                <label for="agree_terms" class="ml-3 text-sm text-gray-600 dark:text-gray-400">
                                    {!! trans('system.form.accept_term_message', ['file' => asset('files/T&C for Trainee 2.pdf')]) !!}
                                </label>
                            </div>
                            @if ($errors->has('agree_terms'))
                                <span class="text-red-500 text-xs mt-1 block">{{ $errors->first('agree_terms') }}</span>
                            @endif
                        </div>
                    </div>

                    {{-- Navigation Buttons --}}
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-700">
                        <button type="button" id="prev-step"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-medium text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full transition-all dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 opacity-50 pointer-events-none">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.75 19.5 8.25 12l7.5-7.5"/></svg>
                            Back
                        </button>
                        <button type="button" id="next-step"
                            class="inline-flex items-center gap-2 px-6 py-2.5 text-sm font-semibold text-white bg-primary hover:bg-primary/90 rounded-full transition-all shadow-md">
                            Next
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.25 4.5l7.5 7.5-7.5 7.5"/></svg>
                        </button>
                        <button type="submit" id="signup-button" disabled
                            class="hidden w-full py-3.5 px-6 text-base font-semibold text-white bg-primary hover:bg-primary/90 focus:ring-4 focus:ring-primary/30 rounded-full transition-all duration-200 shadow-lg shadow-primary/20 disabled:opacity-50 disabled:cursor-not-allowed">
                            {{ trans('auth.sign_up') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="{{ asset('js/select2.js') }}" type="module"></script>

    <script type="module">
        $(document).ready(function() {
            // Restore step from sessionStorage on validation error
            let savedStep = sessionStorage.getItem('schoolkid_signup_step');
            let currentStep = (savedStep !== null && savedStep !== '') ? parseInt(savedStep) : {{ old('current_step', 0) }};
            const totalSteps = {{ count($steps) }};

            // Auto-navigate to step with validation errors
            function getFirstErrorStep() {
                for (let s = 0; s < totalSteps; s++) {
                    const content = $(`.step-content[data-step="${s}"]`);
                    const errors = content.find('.text-red-500, .text-red-600').filter(function() {
                        return $(this).text().trim().length > 0;
                    });
                    if (errors.length > 0) {
                        return s;
                    }
                }
                return null;
            }

            const errorStep = getFirstErrorStep();
            if (errorStep !== null) {
                currentStep = errorStep;
                sessionStorage.setItem('schoolkid_signup_step', currentStep);
            }

            function updateSteps() {
                // Update step indicator
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

                // Show/hide steps
                $('.step-content').removeClass('active').hide();
                $(`.step-content[data-step="${currentStep}"]`).addClass('active').show();

                // Buttons
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

                // Save step to sessionStorage
                sessionStorage.setItem('schoolkid_signup_step', currentStep);
                $('#current_step_input').val(currentStep);
            }

            // Next
            $('#next-step').click(function() {
                if (currentStep < totalSteps - 1) {
                    currentStep++;
                    updateSteps();
                    $('html, body').animate({ scrollTop: $('.step-content').offset().top - 100 }, 300);
                }
            });

            // Prev
            $('#prev-step').click(function() {
                if (currentStep > 0) {
                    currentStep--;
                    updateSteps();
                    $('html, body').animate({ scrollTop: $('.step-content').offset().top - 100 }, 300);
                }
            });

            // Initialize Select2
            $('.select2').select2({ placeholder: "{{trans('auth.Please select one')}}" });

            // Password validation
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
                const fields = ['#first_name', '#last_name', '#email', '#contact_address', '#mobile', '#districtSelect'];
                const allFilled = fields.every(s => $(s).val());
                const agreeChecked = $('#agree_terms').is(':checked');
                const verifyChecked = $('input[name="verification_type"]:checked').length > 0;
                const genderChecked = $('input[name="gender"]:checked').length > 0;
                const pw = $('#password').val();
                const rpw = $('#repassword').val();
                const pwOk = isPasswordValid(pw, rpw);

                if (allFilled && agreeChecked && verifyChecked && genderChecked && pwOk) {
                    $('#signup-button').removeClass('disabled-button').prop('disabled', false);
                } else {
                    $('#signup-button').addClass('disabled-button').prop('disabled', true);
                }
            }

            toggleSignUpButton();
            $('input, select').on('input change', toggleSignUpButton);

            // Password toggle
            $('#toggle-password').click(function() {
                const inp = $('#password');
                const show = $('#eye-icon-show');
                const hide = $('#eye-icon-hide');
                if (inp.attr('type') === 'password') { inp.attr('type', 'text'); show.addClass('hidden'); hide.removeClass('hidden'); }
                else { inp.attr('type', 'password'); show.removeClass('hidden'); hide.addClass('hidden'); }
            });
            $('#toggle-repassword').click(function() {
                const inp = $('#repassword');
                const show = $('#eye-icon-show-repassword');
                const hide = $('#eye-icon-hide-repassword');
                if (inp.attr('type') === 'password') { inp.attr('type', 'text'); show.addClass('hidden'); hide.removeClass('hidden'); }
                else { inp.attr('type', 'password'); show.removeClass('hidden'); hide.addClass('hidden'); }
            });

            // Mobile input validation
            $('input[name="mobile"]').on('input', function() {
                let value = $(this).val();
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
                $(this).val(value);
            });

            // Email validation
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

            // Password strength validation
            const validationRules = [
                { test: (v) => v.length >= 8 && v.length <= 16, message: '8-16 characters' },
                { test: (v) => /[A-Z]/.test(v), message: '1 uppercase' },
                { test: (v) => /[!@#$%^&*(),.?":{}|<>]/.test(v), message: '1 special char' },
                { test: (v) => /[0-9]/.test(v), message: '1 number' }
            ];

            function validatePasswordStrength(password) {
                return validationRules.every(rule => rule.test(password));
            }

            $('#password, #repassword').on('input', function() {
                const passwordInput = document.getElementById('password');
                const repasswordInput = document.getElementById('repassword');
                const password = passwordInput.value;
                const repassword = repasswordInput.value;

                let feedback = document.getElementById('password-feedback');
                if (!feedback) {
                    feedback = document.createElement('div');
                    feedback.id = 'password-feedback';
                    feedback.className = 'text-red-500 text-xs mt-1';
                    passwordInput.parentNode.appendChild(feedback);
                }

                let repassFeedback = document.getElementById('repassword-feedback');
                if (!repassFeedback) {
                    repassFeedback = document.createElement('div');
                    repassFeedback.id = 'repassword-feedback';
                    repassFeedback.className = 'text-red-500 text-xs mt-1';
                    repasswordInput.parentNode.appendChild(repassFeedback);
                }

                passwordInput.classList.remove('border-red-500', 'border-green-500');
                repasswordInput.classList.remove('border-red-500', 'border-green-500');

                if (password) {
                    if (validatePasswordStrength(password)) {
                        passwordInput.classList.add('border-green-500');
                        feedback.textContent = '';
                    } else {
                        passwordInput.classList.add('border-red-500');
                        feedback.textContent = 'Password must be 8-16 characters with 1 uppercase, 1 number, and 1 special character';
                    }
                } else {
                    feedback.textContent = '';
                }

                if (repassword) {
                    if (password === repassword && validatePasswordStrength(password)) {
                        repasswordInput.classList.add('border-green-500');
                        repassFeedback.textContent = '';
                    } else {
                        repasswordInput.classList.add('border-red-500');
                        repassFeedback.textContent = 'Passwords do not match';
                    }
                } else {
                    repassFeedback.textContent = '';
                }
            });

            // Clear sessionStorage on successful form submission
            $('#signup-button').on('click', function() {
                if (!$(this).prop('disabled')) {
                    sessionStorage.removeItem('schoolkid_signup_step');
                }
            });

            updateSteps();
        });
    </script>
@endpush
