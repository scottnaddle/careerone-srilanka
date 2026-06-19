<x-filament-panels::page>
<div class="flex flex-col gap-6 bg-white p-4 rounded-xl relative">
    {{-- Unified Loading Overlay for PdmDashboard --}}
    <div wire:loading.delay wire:target="dateRange, startDate, endDate" class="absolute inset-0 bg-[#808080c7] dark:bg-gray-950/40 backdrop-blur-[2px] flex items-center justify-center rounded-xl z-30 transition-all duration-300">
        <div class="flex flex-col items-center justify-center gap-3 bg-white/80 dark:bg-gray-900/80 px-8 py-5 rounded-xl ring-1 ring-gray-950/5 dark:ring-white/10 w-full h-full">
            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/>
                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/>
            </svg>
            <span class="sr-only">Loading...</span>
        </div>
    </div>

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4  bg-blue-100 dark:bg-gray-900 p-4 rounded-xl shadow-sm ring-1 ring-gray-950/5 dark:ring-white/10">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('admin/dashboard.pdm.title') }}</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('admin/dashboard.pdm.subtitle') }}</p>
        </div>
        <div class="flex flex-wrap items-center gap-3">
            
            <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 rounded-full">
                <x-filament::icon icon="heroicon-o-users" class="w-4 h-4 text-blue-600" />
                <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">{{ number_format($this->getTotal()) }} {{ __('admin/dashboard.pdm.participants') }}</span>
            </div>
            {{-- Period select dropdown --}}
            <div class="flex items-center gap-2">
                <label for="pdm-date-range" class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ __('admin/dashboard.pdm.period') }}:</label>
                <select 
                    id="pdm-date-range"
                    wire:model.live="dateRange"
                    class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 pl-3 pr-8"
                >
                    <option value="all">{{ __('admin/dashboard.pdm.all_time') }}</option>
                    <option value="today">{{ __('admin/dashboard.pdm.today') }}</option>
                    <option value="yesterday">{{ __('admin/dashboard.pdm.yesterday') }}</option>
                    <option value="7days">{{ __('admin/dashboard.pdm.last_7_days') }}</option>
                    <option value="30days">{{ __('admin/dashboard.pdm.last_30_days') }}</option>
                    <option value="90days">{{ __('admin/dashboard.pdm.last_90_days') }}</option>
                    <option value="this_month">{{ __('admin/dashboard.pdm.this_month') }}</option>
                    <option value="last_month">{{ __('admin/dashboard.pdm.last_month') }}</option>
                    <option value="this_year">{{ __('admin/dashboard.pdm.this_year') }}</option>
                    @for ($y = now()->year - 1; $y >= 2025; $y--)
                        <option value="{{ $y }}">{{ __('admin/dashboard.pdm.year') }} {{ $y }}</option>
                    @endfor
                    <option value="custom">{{ __('admin/dashboard.pdm.custom_date') }}</option>
                </select>
            </div>

            <div class="flex items-center gap-2 {{ $dateRange === 'custom' ? '' : 'hidden' }}" wire:key="pdm-start-date-container">
                <label for="pdm-start-date" class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ __('admin/dashboard.pdm.start') }}:</label>
                <input 
                    type="date"
                    id="pdm-start-date"
                    wire:model.live="startDate"
                    class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 px-3"
                />
            </div>
            <div class="flex items-center gap-2 {{ $dateRange === 'custom' ? '' : 'hidden' }}" wire:key="pdm-end-date-container">
                <label for="pdm-end-date" class="text-xs text-gray-500 dark:text-gray-400 font-medium">{{ __('admin/dashboard.pdm.end') }}:</label>
                <input 
                    type="date"
                    id="pdm-end-date"
                    wire:model.live="endDate"
                    class="rounded-lg border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-xs text-gray-900 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 py-1.5 px-3"
                />
            </div>
            
        </div>
    </div>

    {{-- Metrics grid --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4">
        @php $allStats = $this->getStats(); $max = collect($allStats)->max('value') ?: 1; @endphp
        @foreach($allStats as $stat)
            <a href="{{ $stat['link'] }}" class="group bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 block no-underline">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center group-hover:scale-110 transition-transform">
                        <x-filament::icon :icon="$stat['icon']" class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" />
                    </div>
                    <span class="text-xs font-semibold text-gray-700 dark:text-gray-300 leading-tight">{{ $stat['label'] }}</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white group-hover:text-{{ $stat['color'] }}-600 transition-colors">{{ is_numeric($stat['value']) ? number_format($stat['value']) : $stat['value'] }}</div>
                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $stat['sub'] }}</p>
            </a>
        @endforeach
    </div>

    {{-- OJT + Job --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @php $ojt = $this->getOjtStats(); $jobs = $this->getJobsStats(); @endphp
        <a href="/admin/o-j-t-s" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden block no-underline hover:shadow-md transition-shadow group">
            <div class="bg-teal-500 h-1"></div>
            <div class="p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-5 group-hover:text-teal-600 transition-colors">{{ __('admin/dashboard.pdm.ojt_programs') }} →</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div><div class="text-3xl font-bold text-teal-600">{{ number_format($ojt['total']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.total') }}</p></div>
                    <div><div class="text-3xl font-bold text-emerald-600">{{ number_format($ojt['matched']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.matched') }}</p></div>
                    <div><div class="text-3xl font-bold text-gray-500">{{ number_format($ojt['companies']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.companies') }}</p></div>
                </div>
            </div>
        </a>
        <a href="/admin/jobs" class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden block no-underline hover:shadow-md transition-shadow group">
            <div class="bg-orange-500 h-1"></div>
            <div class="p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-5 group-hover:text-orange-600 transition-colors">{{ __('admin/dashboard.pdm.job_vacancies') }} →</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div><div class="text-3xl font-bold text-orange-600">{{ number_format($jobs['total']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.total') }}</p></div>
                    <div><div class="text-3xl font-bold text-emerald-600">{{ number_format($jobs['matched']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.matched') }}</p></div>
                    <div><div class="text-3xl font-bold text-gray-500">{{ number_format($jobs['companies']) }}</div><p class="text-xs text-gray-400 mt-1">{{ __('admin/dashboard.pdm.companies') }}</p></div>
                </div>
            </div>
        </a>
    </div>

    

    <div class="text-center text-xs text-gray-400 dark:text-gray-600">{{ __('admin/dashboard.pdm.data_as_of') }} {{ now()->format('Y-m-d H:i') }}</div>
</div>
{{-- Google Analytics Integration --}}
    <div>
        @livewire(\App\Filament\Widgets\GoogleAnalyticsWidget::class)
    </div>
</x-filament-panels::page>
