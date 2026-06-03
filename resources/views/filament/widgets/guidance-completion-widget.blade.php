<x-filament-widgets::widget>
    <x-filament::card>
        <div class="relative w-full h-full min-h-[300px]">

            <div wire:loading.flex wire:target="dateRange, resetDateRange"
                 class="absolute inset-0 z-50 items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm rounded-lg">
                <div class="rounded-xl flex flex-col items-center space-y-4 transition-all scale-105">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-primary-500 border-t-transparent"></div>
                </div>
            </div>

            <div class="filament-widgets-guidance-completion" wire:loading.class="opacity-50 blur-[2px]" wire:target="dateRange, resetDateRange">

                <div class="mb-6">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <h2 class="text-lg font-semibold text-primary dark:text-blue-400">
                                {{trans('admin/performance.Guidance Completion Rates')}}
                            </h2>
                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                {{trans('admin/performance.Progress indicators showing percentage of students receiving psychometric tests, career guidance, and employment support')}}
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

                        <div class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium bg-purple-50 text-purple-700 rounded-md dark:bg-purple-950 dark:text-purple-300 border border-purple-100 dark:border-purple-900">
                            <x-heroicon-o-calendar class="w-3.5 h-3.5" />
                            <span>{{trans('admin/performance.Period')}}: {{ $this->getDateRangeLabel() }}</span>
                            @if($this->getDateRangeDescription())
                                <span class="text-xs opacity-75">
                                    ({{ $this->getDateRangeDescription() }})
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @php
                        $colors = [
                            'psychometric' => ['bg' => 'bg-blue-50/50 dark:bg-blue-950/30', 'border' => 'border-blue-200 dark:border-blue-800', 'text' => 'text-blue-600 dark:text-blue-400', 'icon' => 'heroicon-o-academic-cap'],
                            'career' => ['bg' => 'bg-green-50/50 dark:bg-green-950/30', 'border' => 'border-green-200 dark:border-green-800', 'text' => 'text-green-600 dark:text-green-400', 'icon' => 'heroicon-o-chart-bar'],
                            'employment' => ['bg' => 'bg-orange-50/50 dark:bg-orange-950/30', 'border' => 'border-orange-200 dark:border-orange-800', 'text' => 'text-orange-600 dark:text-orange-400', 'icon' => 'heroicon-o-briefcase'],
                        ];
                    @endphp

                    <div class="rounded-xl {{ $colors['psychometric']['bg'] }} border {{ $colors['psychometric']['border'] }} p-6 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Psychometric Tests')}}</p>
                                <p class="text-3xl font-bold {{ $colors['psychometric']['text'] }} mt-1">
                                    {{ $stats['psychometric']['percentage'] ?? 0 }}%
                                </p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">{{trans('admin/performance.Total')}}:</span> {{ number_format($stats['psychometric']['count'] ?? 0) }} {{trans('admin/performance.test takers')}}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">{{trans('admin/performance.Trainees')}}:</span> {{ number_format($stats['psychometric']['trainee_count'] ?? 0) }}
                                        <span class="text-gray-400 mx-1">|</span>
                                        <span class="font-medium">{{trans('admin/performance.Guests')}}:</span> {{ number_format($stats['psychometric']['guest_count'] ?? 0) }}
                                    </p>
                                </div>
                            </div>
                            <div class="p-3 rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                                <x-dynamic-component :component="$colors['psychometric']['icon']" class="w-6 h-6 {{ $colors['psychometric']['text'] }}" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl {{ $colors['career']['bg'] }} border {{ $colors['career']['border'] }} p-6 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Career Guidance')}}</p>
                                <p class="text-3xl font-bold {{ $colors['career']['text'] }} mt-1">
                                    {{ $stats['career_guidance']['percentage'] ?? 0 }}%
                                </p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">{{trans('admin/performance.Total')}}:</span> {{ number_format($stats['career_guidance']['total_count'] ?? 0) }} {{trans('admin/performance.trainees')}}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        <span class="font-medium">{{trans('admin/performance.Completed')}}:</span> {{ number_format($stats['career_guidance']['completed_count'] ?? 0) }} {{trans('admin/performance.trainees')}}
                                    </p>
                                </div>
                            </div>
                            <div class="p-3 rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                                <x-dynamic-component :component="$colors['career']['icon']" class="w-6 h-6 {{ $colors['career']['text'] }}" />
                            </div>
                        </div>
                    </div>

                    <div class="rounded-xl {{ $colors['employment']['bg'] }} border {{ $colors['employment']['border'] }} p-6 transition-all hover:-translate-y-1 hover:shadow-md">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm font-medium text-gray-600 dark:text-gray-400">{{trans('admin/performance.Portfolio')}}</p>
                                <p class="text-3xl font-bold {{ $colors['employment']['text'] }} mt-1">
                                    {{ $stats['employment_support']['percentage'] ?? 0 }}%
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2 font-medium">
                                    {{ number_format($stats['employment_support']['count'] ?? 0) }} / {{ number_format($stats['total_trainees'] ?? 0) }} {{trans('admin/performance.trainees')}}
                                </p>
                            </div>
                            <div class="p-3 rounded-xl bg-white dark:bg-gray-800 shadow-sm">
                                <x-dynamic-component :component="$colors['employment']['icon']" class="w-6 h-6 {{ $colors['employment']['text'] }}" />
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </x-filament::card>
</x-filament-widgets::widget>
