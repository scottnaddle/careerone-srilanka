<div class="mx-auto w-full">

    <div class="my-6 flex flex-col gap-5">
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <a href="{{url()->previous()}}"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{ $this->jobData->title }}</h3>
            </a>
            <div class="flex flex-col gap-4">
                <x-job-details :job="$this->jobData" />
            </div>
        </div>
    </div>
    <div>
        <div class="flex flex-col gap-6 p-4 ">
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
</div>
