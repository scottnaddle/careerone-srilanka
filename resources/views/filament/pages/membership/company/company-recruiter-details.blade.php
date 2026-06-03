<x-filament::page>
    <div class="flex flex-col">
        <div class="flex items-center">
                            <span class="text-medium  text-gray-600 truncate">
                                {{ __('admin/company.status') }}:
                            </span>
            <span class="text-base font-semibold text-gray-900 truncate flex items-center">
                            @if ($record->isFullyVerified())
                    <span style="font-size:12px; color: #4984F6; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;">
                                    <svg class="h-4 w-4 inline-block mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>
                                        <path d="M7 12l5 5l10 -10"/>
                                        <path d="M2 12l5 5m5 -5l5 -5"/>
                                    </svg>
                                    {{ __('admin/company.approved') }}
                                </span>
                @else
                    <span style="font-size:12px; color: #F34550; padding: 0.2rem 0.4rem; border-radius: 0.25rem; font-weight:600; display: inline-flex; align-items: center;">
                                    <svg class="h-4 w-4 inline-block mr-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z"/>
                                        <line x1="18" y1="6" x2="6" y2="18"/>
                                        <line x1="6" y1="6" x2="18" y2="18"/>
                                    </svg>
                                   {{ __('admin/status.rejected') }}
                                </span>
                @endif
                            </span>
        </div>
        @if($record->reason != null)
            <span class="dark:text-white flex gap-1 items-center">Reason: {{$record->reason}}</span>
        @endif
    </div>

    {{ $this->form }}
</x-filament::page>
