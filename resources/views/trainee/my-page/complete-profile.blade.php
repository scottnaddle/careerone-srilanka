@extends('auth.layouts.master')

@section('title', 'Complete Your Profile')

@push('css')
<style>
    .select2-container--default .select2-selection--single {
        @apply dark:bg-[#1E1E1E] rounded-xl border border-gray-300 text-sm h-12 flex items-center;
    }
</style>
@endpush

@section('content')
<div class="min-h-screen flex items-start justify-center py-12 px-4">
    <div class="max-w-md w-full">
        <div class="text-center mb-6">
            <a href="/" class="inline-block">
                <img src="{{asset('/images/careerone-logo.webp')}}" class="h-10 mx-auto block dark:hidden" alt="Careerone Logo">
                <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-10 mx-auto hidden dark:block" alt="Careerone Logo">
            </a>
        </div>

        <div class="bg-white dark:bg-[#1E1E1E] shadow-lg rounded-2xl px-6 py-8">
            <div class="text-center mb-6">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <h1 class="text-xl font-bold text-gray-900 dark:text-white">
                    {{ __('trainee.my_page.verified_title') }}
                </h1>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                    {{ __('trainee.my_page.complete_profile_desc') }}
                </p>
            </div>

            @if ($errors->any())
                <div class="mb-4 bg-red-50 dark:bg-red-900/20 text-red-700 dark:text-red-400 px-4 py-3 rounded-xl text-sm border border-red-200">
                    {{ __('system.form.fix_errors') }}
                </div>
            @endif

            <form action="{{ route('trainee.my-page.complete-profile.store') }}" method="POST" class="space-y-4">
                @csrf

                {{-- NIC --}}
                <div>
                    <label for="nic" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        NIC Number
                    </label>
                    <input type="text" name="nic" id="nic"
                        value="{{ old('nic', $user->nic) }}"
                        placeholder="e.g. 200012345678"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors @error('nic') border-red-500 @enderror">
                    @error('nic')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Full Name --}}
                <div>
                    <label for="full_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Full Name <span class="text-red-600">*</span>
                    </label>
                    <input type="text" name="full_name" id="full_name" required
                        value="{{ old('full_name', $user->full_name === $user->email ? '' : $user->full_name) }}"
                        placeholder="Your full name"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors @error('full_name') border-red-500 @enderror">
                    @error('full_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Mobile --}}
                <div>
                    <label for="mobile" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        Mobile Number
                    </label>
                    <input type="text" name="mobile" id="mobile"
                        value="{{ old('mobile', $user->mobile) }}"
                        placeholder="+94 XX XXX XXXX"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors">
                    @error('mobile')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- District --}}
                <div>
                    <label for="district_id" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1.5">
                        District
                    </label>
                    <select name="district_id" id="district_id"
                        class="w-full h-12 px-4 border-2 border-gray-200 dark:border-gray-600 rounded-xl bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-white focus:border-[#4984F6] focus:ring-0 focus:outline-none transition-colors">
                        <option value="">{{ __('auth.Please select one') }}</option>
                        @foreach($districts as $district)
                            <option value="{{ $district->id }}" {{ old('district_id', $user->district_id) == $district->id ? 'selected' : '' }}>
                                {{ $district->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit"
                    class="w-full h-12 bg-[#4984F6] hover:bg-blue-700 text-white font-semibold rounded-xl transition-colors text-lg">
                    {{ __('trainee.my_page.complete_profile_cta') }}
                </button>

                <p class="text-center text-sm text-gray-500 dark:text-gray-400">
                    <a href="{{ route('trainee.my-page.my-page') }}" class="text-[#4984F6] hover:underline">
                        {{ __('trainee.my_page.skip_for_now') }}
                    </a>
                </p>
            </form>
        </div>
    </div>
</div>
@endsection
