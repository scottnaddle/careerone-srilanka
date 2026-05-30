<x-filament-panels::page>
<div class="space-y-6" x-data="{}">
    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">PDM Dashboard</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400">Platform Development Metrics</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 dark:bg-blue-900/30 rounded-full">
            <x-filament::icon icon="heroicon-o-users" class="w-4 h-4 text-blue-600" />
            <span class="text-sm font-semibold text-blue-700 dark:text-blue-300">{{ number_format($this->getTotal()) }} participants</span>
        </div>
    </div>

    {{-- 7 Key Metrics — 2 rows --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-4">
        @php $allStats = $this->getStats(); $max = collect($allStats)->max('value') ?: 1; @endphp
        @foreach($allStats as $stat)
            <div class="group relative bg-white dark:bg-gray-800 rounded-2xl p-5 border border-gray-100 dark:border-gray-700 hover:shadow-md hover:-translate-y-0.5 transition-all duration-200">
                <div class="flex items-center gap-3 mb-3">
                    <div class="flex-shrink-0 w-9 h-9 rounded-xl bg-{{ $stat['color'] }}-50 dark:bg-{{ $stat['color'] }}-900/30 flex items-center justify-center">
                        <x-filament::icon :icon="$stat['icon']" class="w-5 h-5 text-{{ $stat['color'] }}-600 dark:text-{{ $stat['color'] }}-400" />
                    </div>
                    <span class="text-xs font-medium text-gray-400 dark:text-gray-500 leading-tight">{{ $stat['label'] }}</span>
                </div>
                <div class="text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stat['value']) }}</div>
                <p class="text-[10px] text-gray-400 dark:text-gray-500 mt-0.5">{{ $stat['sub'] }}</p>
                {{-- mini bar --}}
                <div class="mt-3 h-1 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                    <div class="h-full bg-{{ $stat['color'] }}-500 rounded-full transition-all duration-500" style="width:{{ ($stat['value']/$max)*100 }}%"></div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- OJT + Job — side by side detailed cards --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
        @php $ojt = $this->getOjtStats(); $jobs = $this->getJobsStats(); @endphp

        {{-- OJT Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-teal-500 h-1"></div>
            <div class="p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-5">OJT Programs</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-3xl font-bold text-teal-600">{{ number_format($ojt['total']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Total</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-emerald-600">{{ number_format($ojt['matched']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Matched</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-500">{{ number_format($ojt['companies']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Companies</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Job Card --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 overflow-hidden">
            <div class="bg-orange-500 h-1"></div>
            <div class="p-6">
                <h3 class="text-sm font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wide mb-5">Job Vacancies</h3>
                <div class="grid grid-cols-3 gap-4 text-center">
                    <div>
                        <div class="text-3xl font-bold text-orange-600">{{ number_format($jobs['total']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Total</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-emerald-600">{{ number_format($jobs['matched']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Matched</p>
                    </div>
                    <div>
                        <div class="text-3xl font-bold text-gray-500">{{ number_format($jobs['companies']) }}</div>
                        <p class="text-xs text-gray-400 mt-1">Companies</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Footer --}}
    <div class="text-center text-xs text-gray-400 dark:text-gray-600">
        Data as of {{ now()->format('Y-m-d H:i') }}
    </div>
</div>
</x-filament-panels::page>
