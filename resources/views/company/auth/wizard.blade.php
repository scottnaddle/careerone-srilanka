@extends('auth.layouts.master')

@section('title', 'Sign Up')

@push('css')
<style>
    .step-indicator { @apply flex items-center gap-2 px-4 py-2 rounded-full text-sm font-medium transition-colors; }
    .step-indicator.active { @apply bg-[#4984F6] text-white; }
    .step-indicator.completed { @apply bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300; }
    .step-indicator.inactive { @apply bg-gray-100 text-gray-400 dark:bg-gray-700 dark:text-gray-500; }
    .step-line { @apply flex-1 h-0.5 bg-gray-200 dark:bg-gray-600; }
    .step-line.active { @apply bg-[#4984F6]; }
    .search-results { @apply absolute z-50 w-full mt-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-600 rounded-lg shadow-lg max-h-48 overflow-y-auto; }
</style>
@endpush

@section('content')
<div class="max-w-2xl mx-auto w-full py-12 px-4 sm:px-7">
    <div class="bg-white dark:bg-[#1E1E1E] shadow-md rounded-xl px-6 sm:px-10 py-6">
        <a href="/choose-login" class="text-gray-900 dark:text-white font-medium gap-2 rounded-lg text-xl font-semibold inline-flex items-center hover:text-primary">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5"/>
            </svg>
            {{ trans('auth.choose_login_title') }}
        </a>

        <a href="/" class="flex items-center mt-4 w-fit">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo">
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo">
        </a>

        {{-- Flash Messages --}}
        @if (session('error'))
            <div class="mt-4 bg-red-100 text-red-800 px-4 py-3 rounded border border-red-400">{{ session('error') }}</div>
        @endif
        @if (session('message'))
            <div class="mt-4 bg-green-100 text-green-800 px-4 py-3 rounded border border-green-400">{{ session('message') }}</div>
        @endif

        {{-- Step Indicators --}}
        <div class="flex items-center justify-center gap-1 sm:gap-2 mt-8 mb-8">
            <div class="step-indicator active" data-indicator="1">
                <span class="hidden sm:inline w-6 h-6 rounded-full bg-white text-[#4984F6] flex items-center justify-center text-xs font-bold">1</span>
                <span>{{ __('company.step_company') }}</span>
            </div>
            <div class="step-line" data-line="1"></div>
            <div class="step-indicator inactive" data-indicator="2">
                <span class="hidden sm:inline w-6 h-6 rounded-full bg-white text-gray-400 flex items-center justify-center text-xs font-bold">2</span>
                <span>{{ __('company.step_recruiter') }}</span>
            </div>
            <div class="step-line" data-line="2"></div>
            <div class="step-indicator inactive" data-indicator="3">
                <span class="hidden sm:inline w-6 h-6 rounded-full bg-white text-gray-400 flex items-center justify-center text-xs font-bold">3</span>
                <span>{{ __('company.step_confirm') }}</span>
            </div>
        </div>

        <form id="wizard-form" action="{{ route('company.wizard.store') }}" method="POST" enctype="multipart/form-data" autocomplete="off">
            @csrf

            {{-- Step 1: Company Information --}}
            <div class="step-panel" data-panel="1">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('company.step_company') }}</h2>

                {{-- Company name with autocomplete --}}
                <div class="mb-4 relative">
                    <label for="company_name" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('auth.Company name') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="company_name" id="company_name" required
                        value="{{ old('company_name') }}"
                        placeholder="{{ __('auth.Type Name of Company and pick from list') }}"
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white"
                        autocomplete="organization">
                    <input type="hidden" name="company_id" id="company_id" value="{{ old('company_id') }}">
                    <div id="search-results" class="search-results hidden"></div>
                    <p id="selected-company-info" class="text-sm text-green-600 mt-1 hidden"></p>
                </div>

                {{-- New company fields (hidden when existing company selected) --}}
                <div id="new-company-fields">
                    <div class="mb-4">
                        <label for="office_type" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.office_type') }}
                        </label>
                        <select name="office_type" id="office_type"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                            <option value="">{{ __('auth.Please select one') }}</option>
                            @foreach(getCodeList('office_type') as $ot)
                                <option value="{{ $ot->code_id }}" {{ old('office_type') == $ot->code_id ? 'selected' : '' }}>{{ $ot->code_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="business_registration_number" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.Registration number') }}
                        </label>
                        <input type="text" name="business_registration_number" id="business_registration_number"
                            value="{{ old('business_registration_number') }}"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="district_id" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.district') }} <span class="text-red-600">*</span>
                        </label>
                        <select name="district_id" id="district_id" required
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                            <option value="">{{ __('auth.Please select one') }}</option>
                            @foreach($districts as $district)
                                <option value="{{ $district->id }}" {{ old('district_id') == $district->id ? 'selected' : '' }}>{{ $district->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="address" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.address') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="address" id="address" required
                            value="{{ old('address') }}"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="number_workers" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.number_of_workers') }}
                        </label>
                        <input type="number" name="number_workers" id="number_workers"
                            value="{{ old('number_workers', 0) }}" min="0"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="email" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.company_email') }}
                        </label>
                        <input type="email" name="email" id="email"
                            value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>

                    <div class="mb-4">
                        <label for="business_license" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('company.business_license') }}
                        </label>
                        <input type="file" name="business_license" id="business_license"
                            accept=".pdf,.jpg,.jpeg,.png"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                        <p class="text-xs text-gray-500 mt-1">PDF, JPG, PNG (max 10MB)</p>
                    </div>
                </div>
            </div>

            {{-- Step 2: Recruiter Information --}}
            <div class="step-panel hidden" data-panel="2">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('company.step_recruiter') }}</h2>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label for="first_name" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('system.form.first_name') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="first_name" id="first_name" required
                            value="{{ old('first_name') }}"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>
                    <div>
                        <label for="last_name" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                            {{ __('system.form.last_name') }} <span class="text-red-600">*</span>
                        </label>
                        <input type="text" name="last_name" id="last_name" required
                            value="{{ old('last_name') }}"
                            class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                    </div>
                </div>

                <div class="mb-4">
                    <label for="recruiter_email" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('system.form.email') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="email" name="recruiter_email" id="recruiter_email" required
                        value="{{ old('recruiter_email') }}"
                        placeholder="you@company.com"
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="password" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('system.form.password') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="password" id="password" required
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white"
                        oninput="updateStrength()">
                    {{-- Strength Meter --}}
                    <div class="mt-2">
                        <div class="h-1 bg-gray-200 dark:bg-gray-700 rounded-full overflow-hidden">
                            <div id="strength-bar" class="h-full rounded-full transition-all duration-300" style="width:0;background:#ef4444"></div>
                        </div>
                        <ul class="mt-1 space-y-0.5 text-xs" id="rules">
                            <li data-rule="length"><span class="inline-block w-4">○</span> 8-16 characters</li>
                            <li data-rule="upper"><span class="inline-block w-4">○</span> One uppercase</li>
                            <li data-rule="number"><span class="inline-block w-4">○</span> One number</li>
                            <li data-rule="special"><span class="inline-block w-4">○</span> One special char</li>
                        </ul>
                    </div>
                    <small class="text-xs text-gray-500 dark:text-gray-400">{{ __('auth.password_requirements') }}</small>
                </div>

                <div class="mb-4">
                    <label for="password_confirmation" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('system.form.confirm_password') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="telephone" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('system.form.telephone') }} <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="telephone" id="telephone" required
                        value="{{ old('telephone') }}"
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                </div>

                <div class="mb-4">
                    <label for="recommended_by" class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('general.Recommended by') }}
                    </label>
                    <select name="recommended_by" id="recommended_by"
                        class="bg-gray-50 border border-gray-300 p-3 h-10 rounded-xl w-full dark:bg-[#1E1E1E] dark:border-white dark:text-white">
                        <option value="">{{ __('auth.Please select one') }}</option>
                        @foreach($recommendedCgo as $user)
                            <option value="{{ $user->system }}-{{ $user->id }}" {{ old('recommended_by') == $user->system.'-'.$user->id ? 'selected' : '' }}>
                                CGO - {{ $user->fullName }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label class="font-medium text-gray-600 block mb-1.5 dark:text-gray-300">
                        {{ __('system.form.preferred_verification_method') }} <span class="text-red-600">*</span>
                    </label>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="verification_type" value="email" checked
                                class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('E-Mail') }}</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="verification_type" value="sms"
                                class="text-blue-600 focus:ring-blue-500">
                            <span class="text-sm text-gray-600 dark:text-gray-300">{{ __('SMS') }}</span>
                        </label>
                    </div>
                </div>
            </div>

            {{-- Step 3: Confirmation --}}
            <div class="step-panel hidden" data-panel="3">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">{{ __('company.step_confirm') }}</h2>

                <div class="space-y-4 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">{{ __('company.section_company') }}</h3>
                        <dl class="grid grid-cols-2 gap-2 text-sm">
                            <dt class="text-gray-500">{{ __('auth.Company name') }}</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" id="confirm-company-name">-</dd>
                            <dt class="text-gray-500">{{ __('company.address') }}</dt>
                            <dd class="text-gray-900 dark:text-white" id="confirm-address">-</dd>
                        </dl>
                    </div>

                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                        <h3 class="font-semibold text-gray-700 dark:text-gray-200 mb-2">{{ __('company.section_recruiter') }}</h3>
                        <dl class="grid grid-cols-2 gap-2 text-sm">
                            <dt class="text-gray-500">{{ __('system.form.name') }}</dt>
                            <dd class="text-gray-900 dark:text-white font-medium" id="confirm-recruiter-name">-</dd>
                            <dt class="text-gray-500">{{ __('system.form.email') }}</dt>
                            <dd class="text-gray-900 dark:text-white" id="confirm-email">-</dd>
                        </dl>
                    </div>
                </div>

                <div class="flex items-center mb-6">
                    <input type="checkbox" name="agree_terms" id="agree_terms" value="1" required
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="agree_terms" class="ml-3 text-sm text-gray-600 dark:text-gray-300">
                        {!! __('system.form.accept_term_message', ['file' => asset('files/T&C for Company 2.pdf')]) !!}
                    </label>
                </div>
                @error('agree_terms')
                    <p class="text-red-600 text-sm mb-4">{{ $message }}</p>
                @enderror
            </div>

            {{-- Navigation --}}
            <div class="flex justify-between mt-8 pt-4 border-t border-gray-200 dark:border-gray-600">
                <button type="button" id="btn-prev"
                    class="px-6 py-2.5 text-gray-600 bg-gray-100 hover:bg-gray-200 rounded-full font-medium dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600 hidden">
                    {{ __('system.form.button.previous') }}
                </button>
                <button type="button" id="btn-next"
                    class="px-6 py-2.5 text-white bg-[#4984F6] hover:bg-blue-800 rounded-full font-medium ml-auto">
                    {{ __('system.form.button.next') }}
                </button>
                <button type="submit" id="btn-submit"
                    class="px-6 py-2.5 text-white bg-[#4984F6] hover:bg-blue-800 rounded-full font-medium hidden ml-auto">
                    {{ __('auth.sign_up') }}
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
<script>
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        document.querySelectorAll('.step-panel').forEach(p => p.classList.add('hidden'));
        document.querySelector(`[data-panel="${step}"]`).classList.remove('hidden');

        document.querySelectorAll('.step-indicator').forEach((el, i) => {
            if (i + 1 === step) el.className = 'step-indicator active';
            else if (i + 1 < step) el.className = 'step-indicator completed';
            else el.className = 'step-indicator inactive';
        });

        document.querySelectorAll('.step-line').forEach((el, i) => {
            el.classList.toggle('active', i + 1 < step);
        });

        document.getElementById('btn-prev').classList.toggle('hidden', step === 1);
        document.getElementById('btn-next').classList.toggle('hidden', step === totalSteps);
        document.getElementById('btn-submit').classList.toggle('hidden', step !== totalSteps);

        // Update confirmation on step 3
        if (step === 3) updateConfirmation();

        currentStep = step;
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function validateStep(step) {
        const panel = document.querySelector(`[data-panel="${step}"]`);
        if (!panel) return true;

        const inputs = panel.querySelectorAll('input[required]:not([type="hidden"]), select[required]');
        let valid = true;

        inputs.forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                valid = false;
            } else {
                input.classList.remove('border-red-500');
            }
        });

        return valid;
    }

    function updateConfirmation() {
        document.getElementById('confirm-company-name').textContent =
            document.getElementById('company_name').value || document.getElementById('selected-company-info').textContent || '-';
        document.getElementById('confirm-address').textContent =
            document.getElementById('address').value || '-';
        document.getElementById('confirm-recruiter-name').textContent =
            (document.getElementById('first_name').value + ' ' + document.getElementById('last_name').value).trim() || '-';
        document.getElementById('confirm-email').textContent =
            document.getElementById('recruiter_email').value || '-';
    }

    // Company autocomplete
    let searchTimeout;
    document.getElementById('company_name').addEventListener('input', function() {
        const keyword = this.value.trim();
        document.getElementById('company_id').value = '';
        document.getElementById('selected-company-info').classList.add('hidden');
        document.getElementById('new-company-fields').classList.remove('hidden');

        clearTimeout(searchTimeout);
        if (keyword.length < 2) {
            document.getElementById('search-results').classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(`/company/wizard-search?q=${encodeURIComponent(keyword)}`)
                .then(r => r.json())
                .then(companies => {
                    const results = document.getElementById('search-results');
                    if (companies.length === 0) {
                        results.innerHTML = '<p class="px-4 py-3 text-sm text-gray-500">No companies found. Fill in details below to register a new one.</p>';
                    } else {
                        results.innerHTML = companies.map(c =>
                            `<button type="button" class="w-full text-left px-4 py-3 hover:bg-blue-50 dark:hover:bg-gray-700 border-b last:border-0"
                                onclick="selectCompany('${c.id}', '${c.name.replace(/'/g, "\\'")}', '${(c.district || '').replace(/'/g, "\\'")}')">
                                <span class="font-medium text-gray-900 dark:text-white">${c.name}</span>
                                ${c.district ? `<span class="text-sm text-gray-500 ml-2">(${c.district})</span>` : ''}
                            </button>`
                        ).join('');
                    }
                    results.classList.remove('hidden');
                });
        }, 300);
    });

    function selectCompany(id, name, district) {
        document.getElementById('company_id').value = id;
        document.getElementById('company_name').value = name;
        document.getElementById('search-results').classList.add('hidden');
        document.getElementById('selected-company-info').textContent =
            'Selected: ' + name + (district ? ' (' + district + ')' : '');
        document.getElementById('selected-company-info').classList.remove('hidden');
        document.getElementById('new-company-fields').classList.add('hidden');
    }

    // Close search on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('#company_name') && !e.target.closest('#search-results')) {
            document.getElementById('search-results').classList.add('hidden');
        }
    });

    // Navigation
    document.getElementById('btn-next').addEventListener('click', function() {
        if (validateStep(currentStep) && currentStep < totalSteps) {
            showStep(currentStep + 1);
        }
    });

    document.getElementById('btn-prev').addEventListener('click', function() {
        if (currentStep > 1) showStep(currentStep - 1);
    });

    // Password strength meter
    function updateStrength() {
        const pwd = document.getElementById('password').value;
        const rules = {
            length: pwd.length >= 8 && pwd.length <= 16,
            upper: /[A-Z]/.test(pwd),
            number: /[0-9]/.test(pwd),
            special: /[!@#$%^&*(),.?":{}|<>]/.test(pwd),
        };
        const passed = Object.values(rules).filter(Boolean).length;
        const bar = document.getElementById('strength-bar');
        const pct = (passed / 4) * 100;
        bar.style.width = pct + '%';
        bar.style.background = passed <= 1 ? '#ef4444' : passed <= 2 ? '#f59e0b' : passed <= 3 ? '#84cc16' : '#22c55e';
        document.querySelectorAll('#rules li').forEach(li => {
            const icon = li.querySelector('span');
            icon.textContent = pwd.length === 0 ? '○' : rules[li.dataset.rule] ? '✓' : '○';
            li.style.color = pwd.length === 0 ? '#9ca3af' : rules[li.dataset.rule] ? '#16a34a' : '#9ca3af';
        });
    }

    // Initialize
    showStep(1);
</script>
@endpush
