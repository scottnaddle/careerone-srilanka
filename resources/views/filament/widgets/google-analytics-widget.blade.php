<x-filament-widgets::widget class="fi-wi-google-analytics">
    @if (!$isConfigured)
        {{-- UNCONFIGURED CONFIGURATION WARNING BOX --}}
        <div class="fi-section rounded-xl bg-white p-6 shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
            <div class="flex items-start gap-4">
                <div class="flex h-12 w-12 shrink-0 items-center justify-center rounded-lg bg-amber-500/10 text-amber-500">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z" />
                    </svg>
                </div>
                <div class="flex-1">
                    <h3 class="text-base font-semibold leading-6 text-gray-950 dark:text-white">
                        Google Analytics configuration is incomplete
                    </h3>
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                        To display Google Analytics reports in the Admin Dashboard, you need to configure the Property ID and the Google Service Account credentials file.
                    </p>
                    @if ($configError)
                        <div class="mt-3 rounded-md bg-rose-50 dark:bg-rose-950/30 p-3 text-xs font-mono text-rose-600 dark:text-rose-400 border border-rose-100 dark:border-rose-900/50">
                            <strong>Error Details:</strong> {{ $configError }}
                        </div>
                    @endif
                    <div class="mt-4 border-t border-gray-100 dark:border-gray-800 pt-4">
                        <h4 class="text-xs font-bold uppercase tracking-wider text-gray-400 dark:text-gray-500">Quick Guide:</h4>
                        <ol class="mt-2 list-decimal list-inside text-xs text-gray-600 dark:text-gray-400 space-y-1.5">
                            <li>Go to the <a href="https://console.cloud.google.com/" target="_blank" class="text-primary-600 dark:text-primary-400 underline font-medium">Google Cloud Console</a>, create a <strong>Service Account</strong>, and download the private key in <strong>JSON</strong> format.</li>
                            <li>Go to the GA4 Admin Console and add that Service Account email as a user with <strong>Viewer</strong> role to the Property.</li>
                            <li>Copy the GA4 <strong>Property ID</strong> (e.g., 123456789).</li>
                            <li>Open your <code class="bg-gray-100 dark:bg-gray-800 px-1 py-0.5 rounded font-mono text-gray-800 dark:text-gray-200">.env</code> file and configure the following:</li>
                        </ol>
                        <pre class="mt-3 rounded-lg bg-gray-950 p-3 text-xs font-mono text-gray-200 overflow-x-auto">
GA_PROPERTY_ID=123456789
GA_CREDENTIALS_JSON_PATH=storage/app/analytics/service-account.json
# Or paste the raw credentials JSON string directly here:
GA_CREDENTIALS_JSON=
GA_SSL_VERIFY=false</pre>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- FULL SYNCHRONIZED DASHBOARD VIEW --}}
        <div class="grid grid-cols-1 gap-6 relative bg-white p-4 rounded-xl">
            {{-- Unified Full-Section Loading Overlay --}}
            <div wire:loading.delay wire:target="dateRange, activeMetric, activeDimension" class="absolute inset-0 bg-[#808080c7] dark:bg-gray-950/40 backdrop-blur-[2px] flex items-center justify-center rounded-xl z-30 transition-all duration-300">
                <div class="flex flex-col items-center justify-center gap-3 bg-white/80 dark:bg-gray-900/80 px-8 py-5 rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 w-full h-full">
                    <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                                    <span class="sr-only">Loading...</span>
                </div>
            </div>
            
            {{-- HEADER BAR & TIME PERIOD FILTER --}}
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 bg-blue-100 dark:bg-gray-900 p-4 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
                <div class="flex items-center gap-3">
                    <div class="p-2 rounded-lg shadow-md" style="color: {{ $metricColor }}">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
  <path stroke-linecap="round" stroke-linejoin="round" d="M3 13.125C3 12.504 3.504 12 4.125 12h2.25c.621 0 1.125.504 1.125 1.125v6.75C7.5 20.496 6.996 21 6.375 21h-2.25A1.125 1.125 0 0 1 3 19.875v-6.75ZM9.75 8.625c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125v11.25c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V8.625ZM16.5 4.125c0-.621.504-1.125 1.125-1.125h2.25C20.496 3 21 3.504 21 4.125v15.75c0 .621-.504 1.125-1.125 1.125h-2.25a1.125 1.125 0 0 1-1.125-1.125V4.125Z" />
</svg>

                    </div>
                    <div>
                        <h2 class="text-lg font-bold tracking-tight text-gray-950 dark:text-white">Google Analytics</h2>
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.ga.traffic_realtime') }}</p>
                    </div>
                </div>
                
                {{-- Time range filter dropdown --}}
                <div class="flex items-center gap-2">
                    <label for="ga-date-range" class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ __('admin/dashboard.ga.period') }}:</label>
                    <select 
                        id="ga-date-range"
                        wire:model.live="dateRange"
                        class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 pl-3 pr-8"
                    >
                        @foreach ($this->getDateRanges() as $key => $label)
                            <option value="{{ $key }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            {{-- 4 OVERVIEW STAT CARDS GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                
                {{-- Active Users Card --}}
                <div 
                    wire:click="$set('activeMetric', 'activeUsers')"
                    class="cursor-pointer transition-all duration-300 rounded-xl p-5 shadow-sm border ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between hover:scale-[1.02] {{ $activeMetric === 'activeUsers' ? 'bg-blue-50/50 dark:bg-blue-950/20 border-blue-500/50 dark:border-blue-400/50' : 'bg-white dark:bg-gray-900 border-transparent' }}"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.ga.active_users') }}</span>
                        <span class="p-1.5 rounded-lg {{ $activeMetric === 'activeUsers' ? 'bg-blue-500 text-white' : 'bg-blue-500/10 text-blue-500' }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ number_format($overview['activeUsers'] ?? 0) }}
                        </span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ __('admin/dashboard.ga.active_users_desc') }}</p>
                    </div>
                </div>

                {{-- Page Views Card --}}
                <div 
                    wire:click="$set('activeMetric', 'screenPageViews')"
                    class="cursor-pointer transition-all duration-300 rounded-xl p-5 shadow-sm border ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between hover:scale-[1.02] {{ $activeMetric === 'screenPageViews' ? 'bg-emerald-50/50 dark:bg-emerald-950/20 border-emerald-500/50 dark:border-emerald-400/50' : 'bg-white dark:bg-gray-900 border-transparent' }}"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.ga.page_views') }}</span>
                        <span class="p-1.5 rounded-lg {{ $activeMetric === 'screenPageViews' ? 'bg-emerald-500 text-white' : 'bg-emerald-500/10 text-emerald-500' }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ number_format($overview['screenPageViews'] ?? 0) }}
                        </span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ __('admin/dashboard.ga.page_views_desc') }}</p>
                    </div>
                </div>

                {{-- Sessions Card --}}
                <div 
                    wire:click="$set('activeMetric', 'sessions')"
                    class="cursor-pointer transition-all duration-300 rounded-xl p-5 shadow-sm border ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between hover:scale-[1.02] {{ $activeMetric === 'sessions' ? 'bg-amber-50/50 dark:bg-amber-950/20 border-amber-500/50 dark:border-amber-400/50' : 'bg-white dark:bg-gray-900 border-transparent' }}"
                >
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.ga.sessions') }}</span>
                        <span class="p-1.5 rounded-lg {{ $activeMetric === 'sessions' ? 'bg-amber-500 text-white' : 'bg-amber-500/10 text-amber-500' }}">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ number_format($overview['sessions'] ?? 0) }}
                        </span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ __('admin/dashboard.ga.sessions_desc') }}</p>
                    </div>
                </div>

                {{-- Avg Engagement Time Card --}}
                <div class="rounded-xl p-5 shadow-sm bg-white dark:bg-gray-900 ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.ga.avg_engagement') }}</span>
                        <span class="p-1.5 rounded-lg bg-purple-500/10 text-purple-500">
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </span>
                    </div>
                    <div class="mt-4">
                        <span class="text-2xl font-bold tracking-tight text-gray-950 dark:text-white">
                            {{ $overview['averageSessionDuration'] ?? '0s' }}
                        </span>
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-1">{{ __('admin/dashboard.ga.avg_engagement_desc') }}</p>
                    </div>
                </div>

            </div>

            {{-- CHART TREND AND DETAIL BREAKDOWN LAYOUT --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                {{-- TREND LINE CHART CONTAINER (1/2 WIDTH) --}}
                <div class="relative bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between">

                    <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                {{ __('admin/dashboard.ga.trend_chart') }}
                            </h3>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">
                                {{ $metricLabel }} {{ __('admin/dashboard.ga.trend_chart_desc') }}
                            </p>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="h-3.5 w-3.5 rounded-full" style="background-color: {{ $metricColor }}"></span>
                            <span class="text-xs font-semibold text-gray-700 dark:text-gray-300">{{ $metricLabel }}</span>
                        </div>
                    </div>

                    {{-- Canvas chart wrapper (Managed by Alpine.js and Chart.js) --}}
                    <div 
                        x-data="{
                            chart: null,
                            labels: @js($chartLabels),
                            values: @js($chartValues),
                            metricLabel: @js($metricLabel),
                            metricColor: @js($metricColor),
                            
                            init() {
                                if (typeof Chart === 'undefined') {
                                    // Dynamically load Chart.js UMD build from CDN if not present
                                    const script = document.createElement('script');
                                    script.src = 'https://cdn.jsdelivr.net/npm/chart.js@4.4.3/dist/chart.umd.min.js';
                                    script.onload = () => this.drawChart();
                                    document.head.appendChild(script);
                                } else {
                                    this.drawChart();
                                }
                            },
                            
                            drawChart() {
                                if (typeof Chart === 'undefined') {
                                    return;
                                }
                                this.$nextTick(() => {
                                    const canvas = this.$refs.canvas;
                                    if (!canvas) return;
                                    const ctx = canvas.getContext('2d');
                                    if (!ctx) return;

                                    if (this.chart) {
                                        this.chart.destroy();
                                    }
                                    
                                    const gradient = ctx.createLinearGradient(0, 0, 0, 300);
                                    gradient.addColorStop(0, this.metricColor + '25');
                                    gradient.addColorStop(1, this.metricColor + '00');
        
                                    this.chart = new Chart(ctx, {
                                        type: 'line',
                                        data: {
                                            labels: this.labels,
                                            datasets: [{
                                                label: this.metricLabel,
                                                data: this.values,
                                                borderColor: this.metricColor,
                                                backgroundColor: gradient,
                                                borderWidth: 2.5,
                                                fill: true,
                                                tension: 0.35,
                                                pointBackgroundColor: this.metricColor,
                                                pointBorderColor: '#ffffff',
                                                pointBorderWidth: 1.5,
                                                pointRadius: 3,
                                                pointHoverRadius: 6,
                                                pointHoverBackgroundColor: this.metricColor,
                                                pointHoverBorderColor: '#ffffff',
                                                pointHoverBorderWidth: 2,
                                            }]
                                        },
                                        options: {
                                            responsive: true,
                                            maintainAspectRatio: false,
                                            interaction: {
                                                mode: 'index',
                                                intersect: false,
                                            },
                                            plugins: {
                                                legend: { display: false },
                                                tooltip: {
                                                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                                                    titleFont: { size: 12, weight: 'bold' },
                                                    bodyFont: { size: 12 },
                                                    padding: 10,
                                                    cornerRadius: 8,
                                                    borderColor: 'rgba(255, 255, 255, 0.1)',
                                                    borderWidth: 1,
                                                    displayColors: false,
                                                    callbacks: {
                                                        label: function(context) {
                                                            return context.dataset.label + ': ' + Number(context.parsed.y).toLocaleString('en-US');
                                                        }
                                                    }
                                                }
                                            },
                                            scales: {
                                                x: {
                                                    grid: { display: false },
                                                    ticks: { 
                                                        color: '#9ca3af',
                                                        font: { size: 10 }
                                                    }
                                                },
                                                y: {
                                                    grid: { 
                                                        color: 'rgba(156, 163, 175, 0.1)',
                                                        drawBorder: false
                                                    },
                                                    ticks: { 
                                                        color: '#9ca3af',
                                                        font: { size: 10 },
                                                        callback: function(value) {
                                                            return value >= 1000 ? (value / 1000) + 'k' : value;
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    });
                                });
                            },
                            
                            updateChart(data) {
                                this.labels = data.labels || [];
                                this.values = data.values || [];
                                this.metricColor = data.color || '#3b82f6';
                                this.metricLabel = data.label || '';
                                this.drawChart();
                            }
                        }"
                        x-on:analytics-data-updated.window="updateChart($event.detail)"
                        class="h-72 w-full mt-4"
                        wire:ignore
                    >
                        <canvas x-ref="canvas"></canvas>
                    </div>

                </div>

                {{-- TOP DIMENSIONS BREAKDOWN TABLE (1/2 WIDTH) --}}
                <div class="relative bg-white dark:bg-gray-900 rounded-xl p-6 shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10 flex flex-col justify-between">

                    <div>
                        {{-- Table header & Dimension selector dropdown --}}
                        <div class="flex justify-between items-center border-b border-gray-100 dark:border-gray-800 pb-4 mb-4">
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{ __('admin/dashboard.ga.breakdown') }}
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ __('admin/dashboard.ga.breakdown_desc') }}</p>
                            </div>
                            
                            <select 
                                wire:model.live="activeDimension"
                                class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-amber-500 focus:ring-amber-500 py-1 px-2 pr-6"
                            >
                                @foreach ($this->getDimensionsList() as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Breakdown list data --}}
                        @if (empty($breakdown))
                            <div class="flex flex-col items-center justify-center py-12 text-center">
                                <svg class="h-8 w-8 text-gray-300 dark:text-gray-600 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0a2 2 0 01-2 2H6a2 2 0 01-2-2m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5" />
                                </svg>
                                <span class="text-xs text-gray-400">{{ __('admin/dashboard.ga.no_data') }}</span>
                            </div>
                        @else
                            <div class="space-y-4 max-h-[300px] overflow-y-auto pr-1">
                                @php
                                    $maxValue = max(array_column($breakdown, 'value') ?: [1]);
                                @endphp
                                @foreach ($breakdown as $item)
                                    @php
                                        $percent = $maxValue > 0 ? ($item['value'] / $maxValue) * 100 : 0;
                                    @endphp
                                    <div class="group flex flex-col gap-1.5">
                                        <div class="flex justify-between items-center text-xs">
                                            <span class="font-medium text-gray-700 dark:text-gray-300 truncate w-3/4" title="{{ $item['label'] }}">
                                                {{ $item['label'] }}
                                            </span>
                                            <span class="font-bold text-gray-950 dark:text-white">
                                                {{ number_format($item['value']) }}
                                            </span>
                                        </div>
                                        {{-- Tiny progress bar showing item percentage representation --}}
                                        <div class="w-full bg-gray-100 dark:bg-gray-800 rounded-full h-1.5 overflow-hidden">
                                            <div 
                                                class="h-full rounded-full transition-all duration-500 ease-out" 
                                                style="width: {{ $percent }}%; background-color: {{ $metricColor }};"
                                            ></div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>

                </div>

            </div>

        </div>
    @endif
</x-filament-widgets::widget>
