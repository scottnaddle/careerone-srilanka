
<div class="mx-auto p-4">
    <div class="space-y-3 bg-white rounded-xl dark:bg-gray-950 ">
        <div class="flex flex-col gap-6 p-4 ">
            <a href="/admin/trainees"
                class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">Trainee Detail</h3>
            </a>

            {{-- <a href="/" class="flex items-center rtl:space-x-reverse">
                <img src="{{asset('images/careerone-logo.png')}}" class="sm:h-8 md:h-12" alt="TVET Logo" />
            </a> --}}
            <div class="flex justify-end ">
                <x-filament::button
                    tag="a"
                    href="{{ $this->getResource()::getUrl('edit', ['record' => $record]) }}"
                    icon="heroicon-o-pencil-square"
                    color="primary"
                >
                    {{ __('Edit') }}
                </x-filament::button>
            </div>

            <x-filament-panels::page>
            <div class="col-span-1  ">
                <div class="flex justify-between">
                    <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                        Sign-up information
                    </span>
                    <svg class="h-5 w-5 text-[#C9CCD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="3" />
                        <path
                            d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                    </svg>
                </div>
            </div>
            <x-filament-panels::form wire:submit="authenticate">
                {{ $this->form->schema($this->getFirstFormSchema()) }}

                <div class="col-span-1 ">
                    <div class="flex justify-between">
                        <span class="text-lg font-semibold text-blue-500 leading-6 truncate">
                            Basic information
                        </span>
                        <svg class="h-5 w-5 text-[#C9CCD4]" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3" />
                            <path
                                d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z" />
                        </svg>
                    </div>
                </div>

                {{ $this->form->schema($this->getSecondFormSchema()) }}

                {{-- <div>
                    <p class="text-lg font-semibold text-blue-500 leading-6">Activity summary</p>
                </div>
                <div class="gap-4">
                        <div class="col-span-1 w-1/4 max-w-xs">
                            <div class="flex justify-between">
                                <span class="text-medium  text-gray-600 truncate">
                                    Career test:
                                </span>
                                <span class="text-base font-semibold text-gray-900 truncate">
                                    4.6/5
                                </span>
                            </div>
                        </div>
                        <div class="col-span-1 w-1/4 max-w-xs">
                            <div class="flex justify-between">
                                <span class="text-medium text-gray-600 truncate">
                                    Counseling:
                                </span>
                                <span class="text-base font-semibold text-gray-900 truncate">
                                    38
                                </span>
                            </div>
                        </div>
                        <div class="col-span-1 w-1/4 max-w-xs">
                            <div class="flex justify-between">
                                <span class=" text-medium text-gray-600 truncate dark:text-white">
                                    Job Applied:
                                </span>
                                <span class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    50
                                </span>
                            </div>
                        </div>
                        <div class="col-span-1 w-1/4 max-w-xs">
                            <div class="flex justify-between">
                                <span class=" text-medium text-gray-600 truncate dark:text-white">
                                    Q&A:
                                </span>
                                <span class="text-base font-semibold text-gray-900 truncate dark:text-white">
                                    10/70
                                </span>
                            </div>
                        </div>
                </div> --}}
                <p class="text-lg font-semibold text-blue-500 leading-6 truncate">TVEC Education</p>
                <div class="grid grid-cols-1  tvec-information">
                    <div
                        class="example-information bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                        <div class="flex flex-col gap-4 w-full h-full">

                            <div class="flex  flex-col gap-4 w-full h-full" id="course_block">
                                @if (!empty($this->traineeInformation))
                                    @foreach ($this->traineeInformation as $item)
                                        <div class="flex gap-4 items-baseline">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                viewBox="0 0 10 10" fill="none">
                                                <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                            </svg>
                                            <div class="flex flex-col gap-2">
                                                <p class="dark:text-white"><span
                                                        class="text-xl font-semibold">{{ $item->INSTITUTE->INSTITUTE_NAME }}</span>
                                                    <span>(Industry sector: {{ $item->COURSE->INDUSTRY_SECTOR }}
                                                        )</span></p>
                                                <p draggable="false" class="dark:text-white"><span
                                                        class="font-semibold">Course name:
                                                        {{ $item->COURSE->COURSE_NAME }}</span> <span
                                                        class="text-sm">({{ $item->COURSE->START_DATE }} -
                                                        {{ $item->COURSE->END_DATE }})</span></p>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                    <p class="text-lg font-semibold text-blue-500 leading-6 truncate pt-5 pb-5" id="nvq_type">NVQ
                        Qualification</p>
                    <div
                        class="example-information bg-white dark:bg-[#1E1E1E] flex w-full items-center p-5 rounded-xl shadow-custom-light dark:shadow-custom-dark border border-gray-300 dark:border-white">
                        <div class="flex flex-col gap-4 w-full h-full">

                            <div class="flex flex-col gap-4 w-full h-full" id="qualification_block">
                                @if (!empty($this->traineeCertificate))
                                    @foreach ($this->traineeCertificate as $item)
                                        <div class="flex flex-col gap-2" bis_skin_checked="1">
                                            <p>
                                                <span
                                                    class="text-[#464559] text-xl font-semibold dark:text-white">{{ $item->QUALIFICATION_NAME }}</span>
                                                <span
                                                    class="text-[#706F81] dark:text-white">({{ $item->QUALIFICATION_LEVEL }})</span>
                                            </p>
                                            <p>
                                                <span
                                                    class="text-[#91919A] dark:text-white">{{ $item->EFFECTIVE_DATE }}</span>
                                            </p>
                                        </div>
                                    @endforeach
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
                <div class="mt-auto flex justify-end space-x-2">
                    <div class="font-medium text-center text-gray-500 dark:text-gray-300">
                        @if ($record->UserReActive()->whereNull('reactive_account_requests.confirmed_at')->first())
                            <button type="button" onclick="confirmApprovalActive(event)"
                                wire:click="handleApprovalActive" wire:loading.attr="disabled"
                                class="bg-blue-500 text-white px-4 py-2 rounded-xl font-semibold text-sm items-center flex items-center gap-1">
                                <span wire:loading class="flex items-center justify-center">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                                         viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                                stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                              d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                                        </path>
                                    </svg>
                                </span>
                                <span>{{ __('Approval Active') }}</span>

                            </button>
                        @endif
                    </div>
                </div>
            </x-filament-panels::form>
        </x-filament-panels::page>
            {{ \Filament\Support\Facades\FilamentView::renderHook(\Filament\View\PanelsRenderHook::AUTH_LOGIN_FORM_AFTER, scopes: $this->getRenderHookScopes()) }}
        </div>
    </div>
    <style>
        .fi-ac-btn-action {
            border-radius: 9999px !important;
        }
    </style>
    <script>
        $(document).ready(function() {



        });
    </script>
</div>
