<x-filament::widget>
    <x-filament::card>
        {{-- Header & Filters --}}
        <div class="mb-6">
            <div class="flex flex-col items-start w-full justify-between gap-4 sm:flex-row sm:items-center mb-2">
                <div>
                    <h2 class="flex items-center gap-2 text-lg font-semibold text-primary dark:text-blue-400">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        {{trans('admin/performance.NVQ Level Breakdown')}}
                    </h2>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{trans('admin/performance.Student distribution across NVQ Levels 1-7')}}
                    <span class="text-xs text-gray-400 opacity-75">{{trans('admin/performance.(Multiple NVQ levels per student counted separately)')}}</span>
                </p>
            </div>

            {{-- Dropdown Filters --}}
                <div class="flex items-center gap-2">
                    <div class="relative">
                        <select wire:model.live="dateRange"
                                wire:loading.attr="disabled"
                                class="text-sm rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-700 dark:text-gray-300 focus:ring-primary-500 focus:border-primary-500 disabled:opacity-50 disabled:cursor-not-allowed cursor-pointer w-36">
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

            {{-- Badges --}}
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

        <div class="relative min-h-[300px]">
            {{-- Loading Overlay --}}
            <div wire:loading.flex wire:target="dateRange, resetDateRange"
                 class="absolute inset-0 z-50 items-center justify-center bg-white/60 dark:bg-gray-900/60 backdrop-blur-sm rounded-lg">
                <div class="rounded-xl flex flex-col items-center space-y-4 transition-all scale-105">
                    <div class="animate-spin rounded-full h-10 w-10 border-4 border-primary-500 border-t-transparent"></div>
                </div>
            </div>

            {{-- 2 Column Layout --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6" wire:loading.class="opacity-50 blur-[2px]" wire:target="dateRange, resetDateRange">

                {{-- Chart Column with AlpineJS --}}
                <div class="h-full" style="min-height: 450px;">
                    <div wire:ignore
                         class="h-full w-full"
                         x-data="{
                             chart: null,
                             init() {
                                 this.loadChart();

                                 Livewire.on('updateNvqChart', (event) => {
                                     let data = event[0]?.data || event?.data;
                                     if (!data) return;
                                     if(this.chart) {
                                         this.chart.updateOptions({ labels: data.labels, colors: data.colors });
                                         this.chart.updateSeries(data.values);
                                     }
                                 });
                             },
                             loadChart() {
                                 if (typeof ApexCharts === 'undefined') {
                                     setTimeout(() => this.loadChart(), 200);
                                     return;
                                 }

                                 const chartData = @js($this->chartData);
                                 if (!chartData.values || chartData.values.length === 0) return;

                                 const isDarkMode = document.documentElement.classList.contains('dark');
                                 const textColor = isDarkMode ? '#9ca3af' : '#374151';

                                 const options = {
                                     chart: { type: 'pie', height: '100%', toolbar: { show: false }, background: 'transparent' },
                                     series: chartData.values,
                                     labels: chartData.labels,
                                     colors: chartData.colors,
                                     dataLabels: {
                                        enabled: true,
                                        formatter: function(val, opts) {
                                            // opts.seriesIndex gives us the index of the current slice
                                            // opts.w.globals.series[opts.seriesIndex] gives us the actual value
                                            const value = opts.w.globals.series[opts.seriesIndex];
                                            const total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                            return percentage > 5 ? percentage + '%' : '';
                                        },
                                        style: { fontSize: '12px', colors: ['#fff'], fontWeight: 'bold' },
                                        dropShadow: { enabled: false }
                                    },
                                     tooltip: {
                                         theme: isDarkMode ? 'dark' : 'light',
                                         y: {
                                             formatter: function(val, { w }) {
                                                 const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                                 const percentage = total > 0 ? ((val / total) * 100).toFixed(1) : 0;
                                                 return val.toLocaleString() + ' students (' + percentage + '%)';
                                             }
                                         }
                                     },
                                     legend: {
                                         show: true, position: 'bottom', fontSize: '12px',
                                         labels: { colors: textColor },
                                         formatter: function(seriesName, opts) {
                                             const value = opts.w.globals.series[opts.seriesIndex];
                                             const total = opts.w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                             const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                                             return seriesName + ': ' + value.toLocaleString() + ' (' + percentage + '%)';
                                         }
                                     },
                                     stroke: { show: true, width: 2, colors: [isDarkMode ? '#1f2937' : '#ffffff'] }
                                 };

                                 this.chart = new ApexCharts(this.$refs.chartElement, options);
                                 this.chart.render();
                             }
                         }">
                        <div x-ref="chartElement" style="height: 450px; width: 100%;"></div>
                    </div>
                </div>

                {{-- Stats and Table Column --}}
                <div class="flex flex-col gap-4">
                    {{-- Summary Statistics --}}
                    <div class="grid grid-cols-2 md:grid-cols-5 gap-3">
                        <div class="p-3 text-center rounded-lg bg-blue-50 dark:bg-blue-900/30">
                            <div class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ number_format($this->totalStudents) }}</div>
                            <div class="text-xs text-blue-700 dark:text-blue-300">{{trans('admin/performance.Total Trainees')}}</div>
                        </div>
                        <div class="p-3 text-center rounded-lg bg-green-50 dark:bg-green-900/30">
                            <div class="text-xl font-bold text-green-600 dark:text-green-400">{{ number_format($this->totalStudents - ($this->nvqData['No NVQ']['count'] ?? 0)) }}</div>
                            <div class="text-xs text-green-700 dark:text-green-300">{{trans('admin/performance.With NVQ')}}</div>
                        </div>
                        <div class="p-3 text-center rounded-lg bg-gray-50 dark:bg-gray-800/50">
                            <div class="text-xl font-bold text-gray-600 dark:text-gray-300">{{ number_format($this->nvqData['No NVQ']['count'] ?? 0) }}</div>
                            <div class="text-xs text-gray-700 dark:text-gray-400">{{trans('admin/performance.No NVQ')}}</div>
                        </div>
                        <div class="p-3 text-center rounded-lg bg-purple-50 dark:bg-purple-900/30">
                            <div class="text-xl font-bold text-purple-600 dark:text-purple-400">{{ number_format($this->averageLevel) }}</div>
                            <div class="text-xs text-purple-700 dark:text-purple-300">{{trans('admin/performance.Avg Level')}}</div>
                        </div>
                        <div class="p-3 text-center rounded-lg bg-orange-50 dark:bg-orange-900/30">
                            <div class="text-xl font-bold text-orange-600 dark:text-orange-400">{{ $this->mostPopularLevel }}</div>
                            <div class="text-xs text-orange-700 dark:text-orange-300">{{trans('admin/performance.Most Popular')}}</div>
                        </div>
                    </div>

                    {{-- Detailed Table --}}
                    <div class="overflow-x-auto border border-gray-200 dark:border-gray-700 rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                            <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 dark:text-gray-400 uppercase">{{trans('admin/performance.Level')}}</th>
                                <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 dark:text-gray-400 uppercase">{{trans('admin/performance.Students')}}</th>
                                <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 dark:text-gray-400 uppercase">%</th>
                                <th class="px-3 py-2 text-xs font-medium tracking-wider text-left text-gray-500 dark:text-gray-400 uppercase">{{trans('admin/performance.Distribution')}}</th>
                            </tr>
                            </thead>
                            <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                            @foreach($this->nvqData as $level => $data)
                                <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors">
                                    <td class="px-3 py-2 text-sm font-medium text-gray-900 dark:text-gray-200 whitespace-nowrap">
                                        <div class="flex items-center gap-2">
                                            <div class="w-2 h-2 rounded-full shadow-sm" style="background-color: {{ $data['color'] }}"></div>
                                            {{ $level }}
                                        </div>
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap">
                                        {{ number_format($data['count']) }}
                                    </td>
                                    <td class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400 whitespace-nowrap font-semibold">
                                        {{ $data['percentage'] }}%
                                    </td>
                                    <td class="px-3 py-2 w-full max-w-[200px]">
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-2 overflow-hidden rounded-full bg-gray-200 dark:bg-gray-700">
                                                <div class="h-full rounded-full transition-all duration-1000 ease-out shadow-sm" style="width: {{ $data['percentage'] }}%; background-color: {{ $data['color'] }}"></div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Note --}}
                    @if(isset($this->nvqData['No NVQ']) && $this->nvqData['No NVQ']['count'] > 0)
                        <div class="mt-4 p-3 text-xs text-gray-600 dark:text-gray-400 bg-gray-50 dark:bg-gray-800/50 rounded-lg border border-gray-200 dark:border-gray-700">
                            <div class="flex items-start gap-2">
                                <svg class="w-4 h-4 mt-0.5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span>{{trans('admin/performance."No NVQ" represents trainees who have not passed any NVQ program or do not exist in the Skill Passport system.')}}</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </x-filament::card>
</x-filament::widget>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endpush
