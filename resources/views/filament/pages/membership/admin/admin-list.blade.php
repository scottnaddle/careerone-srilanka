<x-filament-panels::page>
<div>
    <style>
        table thead tr th span {
            color: blue;
        }

        #search-status {
            background-color: #F9FBFF;
            color: #4984F6;
            border: none;
        }
    </style>
    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            'javascript:void(0)' => 'Membership',
            'javascript:void(1)' => 'Administrator',
            'javascript:void(2)' => 'Administrator List',
        ]" />
                     <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                       Administrator List
                     </h1>
        {{-- <div class="flex items-center">
            <label for="status" class="text-lg font-semibold text-[#464559]">Administrator</label>
        </div> --}}

        <!-- Add the table rendering here -->
        <div>
            {{ $this->table }}
        </div>

    </div>
</div>
        </x-filament-panels::page>