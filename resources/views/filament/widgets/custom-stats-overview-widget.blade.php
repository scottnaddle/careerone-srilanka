{{-- resources/views/filament/widgets/custom-stats-overview-widget.blade.php --}}
@php
    $columns = $this->getColumns();
@endphp

<x-filament-widgets::widget class="fi-wi-stats-overview">
    <div
        @if ($pollingInterval = $this->getPollingInterval())
            wire:poll.{{ $pollingInterval }}
        @endif
        @class([
            'fi-wi-stats-overview-stats-ctn grid gap-4',
            'md:grid-cols-1' => $columns === 1,
            'md:grid-cols-2' => $columns === 2,
            'md:grid-cols-3' => $columns === 3,
//            'md:grid-cols-2 xl:grid-cols-4' => ($columns === 4 || $columns === 3),
            'md:grid-cols-2 xl:grid-cols-4' => ($columns === 4),
        ])
    >
        @foreach ($this->getCachedStats() as $stat)
            <a
                href="{{ $stat->getUrl() }}"
                class="custom-stats-overview-widget relative rounded-xl p-5 transition-all duration-200 hover:shadow-lg {{ $stat->getColor() }} shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10"
            >
                <div class="hidden bg-[#4984F6] bg-[#309358] bg-[#FFB13D] bg-[#EF519D] bg-[#E65858]"></div>

                <div class="flex items-center justify-between gap-2">
                    <div class="flex items-center gap-3 min-w-0">
                        <div class="custom-stats-overview-widget-value text-2xl font-semibold tracking-tight text-white dark:text-white whitespace-nowrap">
                            {{ $stat->getValue() }}
                        </div>

                        <div class="flex flex-col gap-1 min-w-0">
                            <span class="custom-stats-overview-widget-label text-sm font-medium text-white dark:text-white truncate">
                                {{ $stat->getLabel() }}
                            </span>
                            <span class="custom-stats-overview-widget-description text-xs text-white/90 dark:text-white/90 truncate">
                                {{ $stat->getDescription() }}
                            </span>
                        </div>
                    </div>

                    <div class="flex-shrink-0">
                        <x-filament::icon
                            icon="heroicon-m-arrow-right"
                            class="fi-wi-stats-overview-stat-icon h-5 w-5 text-white dark:text-white"
                        />
                    </div>
                </div>
            </a>
        @endforeach
    </div>
</x-filament-widgets::widget>
