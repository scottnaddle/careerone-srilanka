<x-filament-panels::page>
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">PDM Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Platform Development Metrics — Total Participants: {{ number_format($this->getTotal()) }}</p>
        </div>

        {{-- 6 Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->getStats() as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</span>
                        <x-filament::icon :icon="$stat['icon']" class="w-6 h-6 text-{{ $stat['color'] }}-500" />
                    </div>
                    <div class="text-3xl font-bold text-gray-900 dark:text-white">{{ number_format($stat['value']) }}</div>
                    <p class="text-xs text-gray-400 mt-1">{{ $stat['sub'] }}</p>
                    @php $max = collect($this->getStats())->max('value') ?: 1; @endphp
                    <div class="mt-3 h-1.5 bg-gray-100 dark:bg-gray-700 rounded-full">
                        <div class="h-full bg-{{ $stat['color'] }}-500 rounded-full" style="width:{{ ($stat['value']/$max)*100 }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- OJT + Job Vacancy Section --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @php $ojt = $this->getOjtStats(); $jobs = $this->getJobsStats(); @endphp
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-briefcase" class="w-5 h-5 text-teal-500" />
                    OJT Programs
                </h2>
                <div class="flex items-end gap-6">
                    <div>
                        <div class="text-4xl font-bold text-teal-600">{{ number_format($ojt['total']) }}</div>
                        <p class="text-sm text-gray-400 mt-1">Total</p>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600">{{ number_format($ojt['matched']) }}</div>
                        <p class="text-sm text-gray-400 mt-1">Matched</p>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                    <x-filament::icon icon="heroicon-o-briefcase" class="w-5 h-5 text-orange-500" />
                    Job Vacancies
                </h2>
                <div class="flex items-end gap-6">
                    <div>
                        <div class="text-4xl font-bold text-orange-600">{{ number_format($jobs['total']) }}</div>
                        <p class="text-sm text-gray-400 mt-1">Total</p>
                    </div>
                    <div>
                        <div class="text-4xl font-bold text-green-600">{{ number_format($jobs['matched']) }}</div>
                        <p class="text-sm text-gray-400 mt-1">Matched</p>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-gray-500">{{ number_format($jobs['companies']) }}</div>
                        <p class="text-sm text-gray-400 mt-1">Companies</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Platform Summary --}}
        <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl shadow-lg p-8 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-lg font-semibold opacity-90">Platform Summary</h2>
                    <p class="text-4xl font-bold mt-2">{{ number_format($this->getTotal()) }}</p>
                    <p class="text-blue-100 mt-1">Total platform participants</p>
                </div>
                <x-filament::icon icon="heroicon-o-globe-alt" class="w-16 h-16 opacity-30" />
            </div>
        </div>
    </div>
</x-filament-panels::page>
