<x-filament-panels::page>
<div>
    <style>
        table thead tr th span {
            color: blue;
        }

        #search-time {
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;
        }
        .highlight {
            font-weight: bold;
            color: #fff;
            background-color: #388E3C;
            padding: 0.2rem 0.4rem;
            border-radius: 0.25rem;
        }
    </style>
    <style>

        </style>

    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            'javascript:void(0)' => 'Information',
            'javascript:void(1)' => 'Events',
            'javascript:void(2)' => 'Event List',
        ]" />
                     <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                        {{__('admin/dashboard.event.title')}}
                     </h1>
        <div class="flex items-center justify-between mt-4 mb-4">
            @if(auth('admin')->user()->hasRole('super_admin'))
            <div class="flex gap-2">
                <a href="{{route('filament.admin.resources.information.content.event-lists.create')}}">
                    <button id="recent-button"
                    style="background-color: #3B82F6; color:#ffffff"
                    class="flex items-center rounded-xl border block p-2.5 bg-[#3B82F6] hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    {{ __('admin/dashboard.event.new_event') }}
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke-width="1.5" stroke="currentColor" class="h-6 w-6 ml-2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4.5v15m7.5-7.5h-15" />
                    </svg>
                </button>
                </a>

            </div>
                @endif
        </div>
        <!-- Add the table rendering here -->
        <div>
            {{ $this->table }}
        </div>
    </div>
</div>
        </x-filament-panels::page>
