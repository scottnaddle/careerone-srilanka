@extends('cgo.auth.layouts.master')

@section('title', 'Forgot Password')

@push('css')
    <style>
        .disabled-button {
            pointer-events: none;
            opacity: 0.6;
        }
        /* Override Filament button styling */
        .fi-ac-btn-action {
            border-radius: 0.75rem !important;
            background-color: #4984F6 !important;
            font-size: 1.25rem !important;
            line-height: 1.75rem !important;
            padding: 0.75rem 1.25rem !important;
            font-weight: 500 !important;
        }
        .fi-ac-btn-action:hover {
            background-color: #1e40af !important;
        }
        .fi-input-wrp .fi-fo-text-input {
            border-radius: 0.75rem !important;
            height: 2.75rem !important;
            padding: 0.75rem 1rem 0.75rem 1rem !important;
            border-color: #d1d5db !important;
        }
        .dark .fi-input-wrp .fi-fo-text-input {
            background-color: #1E1E1E !important;
            border-color: #6b7280 !important;
            color: white !important;
        }
        .fi-input-wrp label {
            font-size: 0.875rem !important;
            font-weight: 500 !important;
            color: #404040 !important;
            margin-bottom: 0.25rem !important;
            display: block !important;
        }
        .dark .fi-input-wrp label {
            color: #d1d5db !important;
        }
        .fi-input-wrp .text-danger-600 {
            font-size: 0.75rem !important;
        }
        .fi-simple-main {
            border: 0 !important;
            box-shadow: unset !important;
            padding: 1rem !important;
        }
        .fi-simple-main-ctn {
            align-items: start !important;
        }
        .fi-input {
            padding-top: 10px;
            padding-bottom: 10px;
        }
        /* Custom notification styling */
        .custom-notification {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 9999;
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        .custom-notification.success {
            background-color: #f0fdf4;
            border: 1px solid #4ade80;
            color: #166534;
        }
        .custom-notification.error {
            background-color: #fef2f2;
            border: 1px solid #f87171;
            color: #991b1b;
        }
        .dark .custom-notification.success {
            background-color: #1E1E1E;
            border: 1px solid #4ade80;
            color: #4ade80;
        }
        .dark .custom-notification.error {
            background-color: #1E1E1E;
            border: 1px solid #f87171;
            color: #f87171;
        }
        .fi-simple-layout {
            background-image: url(/images/bg-auth.webp);
            background-size: cover;
        }
        .dark .fi-simple-main {
            background-color: transparent !important;
        }
        .fi-simple-main {
            background-color: transparent !important;
            padding: 0 !important;
        }

    </style>
@endpush

@section('content')
    <div class="flex flex-col gap-2.5 w-full max-w-xl bg-white px-4 md:px-8 py-6 rounded-xl dark:bg-[#1E1E1E]">
        <!-- Logo -->
        <a href="/" class="flex w-full justify-start py-5">
            <img src="{{asset('/images/careerone-logo.webp')}}" class="h-8 md:h-12 block dark:hidden" alt="Careerone Logo" />
            <img src="{{asset('/images/careerone-logo-dark.webp')}}" class="h-8 md:h-12 hidden dark:block" alt="Careerone Logo" />
        </a>

        <div class="flex flex-col gap-6">
            <!-- Back Button -->
            <a href="/choose-login"
               class="text-[#404040] dark:text-white border-gray-200 gap-2 rounded-xl text-xl font-semibold w-fit text-center inline-flex items-center hover:text-primary dark:hover:text-primary">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="size-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                {{ trans('auth.choose_login_title') }}
            </a>

            <div class="flex flex-col gap-6 mt-4">
                <!-- Icon and Welcome Message -->
                <div class="flex flex-col items-center justify-center gap-4">
                    <img src="/images/admin.svg" alt="Admin Icon">
                    <h2 class="text-2xl font-semibold text-gray-900 dark:text-white text-center">{{ trans('auth.forgot_password') }}</h2>
                    <p class="text-primary dark:text-white font-semibold text-center text-base">Reset your Admin account password.</p>
                </div>

                <!-- Form Container -->
                <div class="w-full flex flex-col items-center justify-center gap-6 md:col-span-2">
                    <div class="w-full flex flex-col gap-4 leading-5">
                        <!-- Custom Notifications -->
                        <div id="notification-container"></div>

                        <!-- Filament Form - Single root element wrapper -->
                        <div>
                            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_BEFORE, scopes: $this->getRenderHookScopes()) }}

                            <x-filament-panels::form id="form" wire:submit="request">
                                {{ $this->form }}

                                <div class="pt-4">
                                    <x-filament-panels::form.actions
                                        :actions="$this->getCachedFormActions()"
                                        :full-width="$this->hasFullWidthFormActions()"
                                    />
                                </div>
                            </x-filament-panels::form>

                            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_PASSWORD_RESET_REQUEST_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
                        </div>

                        <!-- Back to Login Link -->
                        <div class="text-sm font-medium text-center text-gray-500 dark:text-gray-300 mt-2">
                            <a href="/admin/auth/login" class="text-primary hover:underline dark:text-blue-500">{{ trans('auth.sign_in') }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('livewire:initialized', function () {
            // Listen for Filament notifications
            Livewire.on('notify', (data) => {
                showNotification(data[0].message, data[0].status);
            });

            // Also listen for session flash messages
            @if (session()->get('message'))
            showNotification('{!! session()->get('message') !!}', 'success');
            @endif

            @if (session()->get('error'))
            showNotification('{!! session()->get('error') !!}', 'error');
            @endif
        });

        function showNotification(message, type) {
            const container = document.getElementById('notification-container');
            if (!container) return;

            const notification = document.createElement('div');
            notification.className = `custom-notification ${type} rounded-xl px-4 py-3 shadow-lg mb-3`;
            notification.innerHTML = `
                <div class="flex items-start gap-3">
                    <div class="flex-shrink-0">
                        ${type === 'success' ?
                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>' :
                '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>'
            }
                    </div>
                    <div class="flex-1 text-sm font-medium">${message}</div>
                    <button onclick="this.parentElement.parentElement.remove()" class="flex-shrink-0 ml-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            `;

            container.appendChild(notification);

            // Auto remove after 5 seconds
            setTimeout(() => {
                if (notification && notification.remove) {
                    notification.remove();
                }
            }, 5000);
        }

        // Also capture any AJAX form errors
        $(document).ready(function() {
            $(document).ajaxComplete(function(event, xhr, settings) {
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    for (let field in xhr.responseJSON.errors) {
                        showNotification(xhr.responseJSON.errors[field][0], 'error');
                    }
                }
            });
        });
    </script>
@endpush
