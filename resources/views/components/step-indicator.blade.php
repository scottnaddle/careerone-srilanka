<div class="mb-8">
    <div class="flex items-center justify-between">
        @foreach($steps as $index => $step)
            <div class="flex items-center flex-1 {{ $loop->last ? '' : '' }}">
                <div class="flex items-center gap-3">
                    <div class="step-indicator-dot w-10 h-10 rounded-full flex items-center justify-center text-sm font-bold transition-all duration-300 shrink-0
                        @if($index < $currentStep) bg-primary text-white shadow-md shadow-primary/30
                        @elseif($index == $currentStep) bg-primary text-white ring-4 ring-primary/20 shadow-lg shadow-primary/30 scale-110
                        @else bg-gray-100 dark:bg-gray-700 text-gray-400 dark:text-gray-500 border-2 border-gray-200 dark:border-gray-600
                        @endif">
                        @if($index < $currentStep)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.5 12.75l6 6 9-13.5"/></svg>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="text-sm font-medium hidden sm:block
                        @if($index <= $currentStep) text-gray-900 dark:text-white
                        @else text-gray-400 dark:text-gray-500
                        @endif">
                        {{ $step['label'] }}
                    </span>
                </div>
                @if(!$loop->last)
                    <div class="flex-1 h-0.5 mx-4 transition-all duration-300
                        @if($index < $currentStep) bg-primary
                        @else bg-gray-200 dark:bg-gray-700
                        @endif">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</div>
