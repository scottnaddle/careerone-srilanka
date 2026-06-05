<x-filament-panels::page>
<div>
    <style>

        #search-time{
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;
        }
    </style>

    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            '' => 'Career Guidance',
            '/admin/counselings' => 'Guidance',
        ]" />
        <div class="flex items-center">
            <label for="status" class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">{{__('admin/dashboard.counseling.title')}}</label>
        </div>
        <form method="get" action="{{ url()->current() }}">
            <!-- Date picker section -->
            <div class="flex gap-4 items-center mb-6">
                <!-- First Date Picker -->
                <div class="flex-1">
                    <input
                        type="date"
                        id="datePicker1"
                        value="{{ request()->query('startDate') }}"
                        name="startDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div class="flex-1">
                    <input
                        type="date"
                        id="datePicker2"
                        value="{{ request()->query('endDate') }}"
                        name="endDate"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500"
                    />
                </div>
                <div class="flex-3">
                    <button
                        type="submit"
                        class="w-full px-4 py-2 bg-blue-500 text-white rounded-full hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-300 transition-colors">
                        {{ __('admin/company.search') }}
                    </button>
                </div>
            </div>

            <!-- Filter Section -->
            <div class="flex items-center justify-between gap-4 mt-4">
                <label for="search-status" class="text-lg font-semibold text-[#706F81] flex justify-between items-center w-full">
                    @if (request()->query())
                        {{ __('admin/company.result') }}
                        <button type="button" class="flex items-center text-red-700 text-sm"
                                onclick="window.location.href = window.location.origin + window.location.pathname;"><svg
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                            {{ trans('system.remove_filter') }}</button>
                    @endif
                </label>

            </div>
        </form>
    <livewire:counseling-all-search />
</div>
</div>
        </x-filament-panels::page>