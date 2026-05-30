<x-filament-panels::page>
    <div class="space-y-8">
        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">PDM Dashboard</h1>
            <p class="text-gray-500 dark:text-gray-400 mt-1">Platform Development Metrics — Total Users: {{ number_format($this->getTotal()) }}</p>
        </div>

        {{-- Stats Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($this->getStats() as $stat)
                <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-lg p-6 border border-gray-100 dark:border-gray-700 hover:shadow-xl transition-shadow">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">{{ $stat['label'] }}</span>
                        <x-filament::icon
                            :icon="$stat['icon']"
                            class="w-8 h-8 text-{{ $stat['color'] }}-500 dark:text-{{ $stat['color'] }}-400"
                        />
                    </div>
                    <div class="text-4xl font-bold text-gray-900 dark:text-white">
                        {{ number_format($stat['value']) }}
                    </div>
                    <div class="mt-2 h-2 bg-gray-100 dark:bg-gray-700 rounded-full overflow-hidden">
                        @php
                            $max = collect($this->getStats())->max('value') ?: 1;
                            $pct = ($stat['value'] / $max) * 100;
                        @endphp
                        <div class="h-full bg-{{ $stat['color'] }}-500 rounded-full transition-all" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Summary Card --}}
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
