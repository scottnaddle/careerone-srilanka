<x-filament-widgets::widget>
    <x-filament::card>
        <div class="relative w-full h-full min-h-[300px]">

            <div wire:loading.flex wire:target="dateRange, resetDateRange"
                 class="absolute inset-0 z-50 items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm rounded-lg">
                <div class=" rounded-xl flex flex-col items-center space-y-4 transition-all scale-105">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-primary-500 border-t-transparent"></div>
                </div>
            </div>

            <div class="filament-widgets-cgo-counseling-stats" wire:loading.class="opacity-50 blur-[2px]" wire:target="dateRange, resetDateRange">

                <div class="mb-4">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h2 class="text-lg font-semibold text-primary dark:text-blue-400">
                                {{trans('admin/performance.CGO Counseling Statistics')}}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{trans('admin/performance.Comprehensive overview of career guidance and job support counseling services')}}
                            </p>
                        </div>

                        <div class="flex items-center gap-2">
                            <div class="relative">
                                <select wire:model.live="dateRange"
                                        wire:loading.attr="disabled"
                                        class="text-sm rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer">
                                    <option value="all_time">{{trans('admin/performance.All Time')}}</option>
                                    <option value="this_month">{{trans('admin/performance.This Month')}}</option>
                                    <option value="last_month">{{trans('admin/performance.Last Month')}}</option>
                                    <option value="this_year">{{trans('admin/performance.This Year')}}</option>

                                    @foreach($this->getAvailableYears() as $year)
                                        <option value="year_{{ $year }}">{{ $year }}</option>
                                    @endforeach
                                </select>
                            </div>

                            @if($dateRange !== 'this_month')
                                <button wire:click="resetDateRange"
                                        wire:loading.attr="disabled"
                                        class="text-xs px-2 py-1 bg-gray-100 dark:bg-gray-800 rounded-md hover:bg-gray-200 dark:hover:bg-gray-700 transition font-medium text-gray-700 dark:text-gray-300 disabled:opacity-50 border border-gray-200 dark:border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>


                                </button>
                            @endif
                        </div>
                    </div>

                    <div class="flex flex-wrap gap-2 mt-2">
                        @if($this->hasHeadOfficeFilter())
                            <div class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium bg-blue-50 text-blue-700 rounded-md dark:bg-blue-950 dark:text-blue-300 border border-blue-100 dark:border-blue-900">
                                <x-heroicon-o-building-office class="w-3.5 h-3.5" />
                                <span>{{trans('admin/performance.Head Office')}}: {{ $this->getCurrentHeadOfficeFilter() }}</span>
                            </div>
                        @endif

{{--                        <div class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium bg-purple-50 text-purple-700 rounded-md dark:bg-purple-950 dark:text-purple-300 border border-purple-100 dark:border-purple-900">--}}
{{--                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />--}}
{{--                            <span>Period: {{ $this->getDateRangeLabel() }}</span>--}}
{{--                            @if($this->getDateRangeDescription())--}}
{{--                                <span class="text-xs opacity-75">--}}
{{--                                    ({{ $this->getDateRangeDescription() }})--}}
{{--                                </span>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    <div class="rounded-xl bg-blue-50 dark:bg-blue-950/50 p-6 border border-blue-200 dark:border-blue-800 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Total Sessions')}}</p>
                                <p class="text-3xl font-bold text-blue-600 dark:text-blue-400 mt-1">
                                    {{ number_format($stats['total_counseling'] ?? 0) }}
                                </p>
                            </div>
                            <div class="p-3 rounded-xl bg-blue-100 dark:bg-blue-900/50 shadow-sm">
                                <x-heroicon-o-chat-bubble-left-right class="w-6 h-6 text-blue-600 dark:text-blue-400" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-green-50 dark:bg-green-950/50 p-6 border border-green-200 dark:border-green-800 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Completed')}}</p>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">
                                        {{ number_format($stats['completed_counseling'] ?? 0) }}
                                    </p>
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-green-100 dark:bg-green-900 text-green-700 dark:text-green-300">
                                        {{ $stats['completion_rate'] ?? 0 }}%
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 rounded-xl bg-green-100 dark:bg-green-900/50 shadow-sm">
                                <x-heroicon-o-check-circle class="w-6 h-6 text-green-600 dark:text-green-400" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl bg-red-50 dark:bg-red-950/50 p-6 border border-red-200 dark:border-red-800 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Cancelled')}}</p>
                                <div class="flex items-baseline gap-2 mt-1">
                                    <p class="text-3xl font-bold text-red-600 dark:text-red-400">
                                        {{ number_format($stats['cancelled_counseling'] ?? 0) }}
                                    </p>
                                    <span class="text-xs font-semibold px-2 py-0.5 rounded-full bg-red-100 dark:bg-red-900 text-red-700 dark:text-red-300">
                                        {{ $stats['cancel_rate'] ?? 0 }}%
                                    </span>
                                </div>
                            </div>
                            <div class="p-3 rounded-xl bg-red-100 dark:bg-red-900/50 shadow-sm">
                                <x-heroicon-o-x-circle class="w-6 h-6 text-red-600 dark:text-red-400" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mb-5">
                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <x-heroicon-o-tag class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                        </div>
                        {{trans('admin/performance.By Counseling Field')}}
                    </h3>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        @foreach($stats['stats_by_field'] ?? [] as $fieldId => $field)
                            @php
                                $bgClass = match($fieldId) {
                                    1 => 'bg-blue-50/50 dark:bg-blue-950/30 border-blue-100 dark:border-blue-900',
                                    2 => 'bg-emerald-50/50 dark:bg-emerald-950/30 border-emerald-100 dark:border-emerald-900',
                                    3 => 'bg-amber-50/50 dark:bg-amber-950/30 border-amber-100 dark:border-amber-900',
                                    4 => 'bg-violet-50/50 dark:bg-violet-950/30 border-violet-100 dark:border-violet-900',
                                    default => 'bg-gray-50/50 dark:bg-gray-950/30 border-gray-100 dark:border-gray-900'
                                };
                                $textClass = match($fieldId) {
                                    1 => 'text-blue-700 dark:text-blue-400',
                                    2 => 'text-emerald-700 dark:text-emerald-400',
                                    3 => 'text-amber-700 dark:text-amber-400',
                                    4 => 'text-violet-700 dark:text-violet-400',
                                    default => 'text-gray-700 dark:text-gray-400'
                                };
                            @endphp
                            <div class="rounded-xl {{ $bgClass }} p-4 border transition-all hover:shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-sm {{ $textClass }}">{{ $field['name'] }}</h4>
                                    <span class="text-xs font-bold {{ $textClass }} bg-white dark:bg-gray-900 px-2.5 py-1 rounded-full shadow-sm">
                                        {{ number_format($field['total'] ?? 0) }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">{{trans('admin/performance.Completed')}}</span>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ number_format($field['completed'] ?? 0) }} <span class="font-normal opacity-70">({{ $field['completion_rate'] ?? 0 }}%)</span></span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">{{trans('admin/performance.Cancelled')}}</span>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ number_format($field['cancelled'] ?? 0) }} <span class="font-normal opacity-70 text-red-500">({{ $field['cancel_rate'] ?? 0 }}%)</span></span>
                                    </div>
                                    <div class="mt-3 pt-1">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-1000 ease-out"
                                                 style="width: {{ $field['completion_rate'] ?? 0 }}%; background-color: {{ $field['color'] }};">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div>
                    <h3 class="text-md font-semibold text-gray-800 dark:text-gray-200 mb-4 flex items-center gap-2">
                        <div class="p-1.5 bg-gray-100 dark:bg-gray-800 rounded-lg">
                            <x-heroicon-o-clock class="w-4 h-4 text-gray-600 dark:text-gray-400" />
                        </div>
                        {{trans('admin/performance.By Counseling Type')}}
                    </h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @foreach($stats['stats_by_type'] ?? [] as $typeId => $type)
                            @php
                                $bgClass = match($typeId) {
                                    1 => 'bg-cyan-50/50 dark:bg-cyan-950/30 border-cyan-100 dark:border-cyan-900',
                                    2 => 'bg-pink-50/50 dark:bg-pink-950/30 border-pink-100 dark:border-pink-900',
                                    3 => 'bg-indigo-50/50 dark:bg-indigo-950/30 border-indigo-100 dark:border-indigo-900',
                                    default => 'bg-gray-50/50 dark:bg-gray-950/30 border-gray-100 dark:border-gray-900'
                                };
                                $textClass = match($typeId) {
                                    1 => 'text-cyan-700 dark:text-cyan-400',
                                    2 => 'text-pink-700 dark:text-pink-400',
                                    3 => 'text-indigo-700 dark:text-indigo-400',
                                    default => 'text-gray-700 dark:text-gray-400'
                                };
                            @endphp
                            <div class="rounded-xl {{ $bgClass }} p-4 border transition-all hover:shadow-sm">
                                <div class="flex items-center justify-between mb-3">
                                    <h4 class="font-semibold text-sm {{ $textClass }}">{{ $type['name'] }}</h4>
                                    <span class="text-xs font-bold {{ $textClass }} bg-white dark:bg-gray-900 px-2.5 py-1 rounded-full shadow-sm">
                                        {{ number_format($type['total'] ?? 0) }}
                                    </span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">{{trans('admin/performance.Completed')}}</span>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ number_format($type['completed'] ?? 0) }} <span class="font-normal opacity-70">({{ $type['completion_rate'] ?? 0 }}%)</span></span>
                                    </div>
                                    <div class="flex justify-between items-center text-xs">
                                        <span class="text-gray-500 dark:text-gray-400 font-medium">{{trans('admin/performance.Cancelled')}}</span>
                                        <span class="font-bold text-gray-700 dark:text-gray-300">{{ number_format($type['cancelled'] ?? 0) }} <span class="font-normal opacity-70 text-red-500">({{ $type['cancel_rate'] ?? 0 }}%)</span></span>
                                    </div>
                                    <div class="mt-3 pt-1">
                                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-1.5 overflow-hidden">
                                            <div class="h-1.5 rounded-full transition-all duration-1000 ease-out"
                                                 style="width: {{ $type['completion_rate'] ?? 0 }}%; background-color: {{ $type['color'] }};">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
