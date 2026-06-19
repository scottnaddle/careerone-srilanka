
<div class="p-6 space-y-6 bg-white mt-4 rounded-xl">

<style>
    table thead tr th span{
        color:blue;
    }
    #search-status{
        background-color: #F9FBFF;
        color: #4984F6;
        border: none;
    }
</style>
<x-filament::breadcrumbs :breadcrumbs="[
    '/admin/overview' => 'Admin',
    'javascript:void(0)' => 'Membership',
    'javascript:void(1)' => 'Company',
    'javascript:void(2)' => 'Company List',
]" />
    <div class="flex items-center justify-between">
        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            Company List
        </h1>

        {{-- Add the Create button here if needed --}}
        @if($this->getCreateAction())
            <div>
                {{ $this->getCreateAction() }}
            </div>
        @endif
    </div>

    {{-- <div class="flex items-center">
        <label for="status" class="text-lg font-semibold text-[#464559]">{{ __('admin/company.company') }}</label>
    </div> --}}

    <!-- Add the table rendering here -->
        {{ $this->table }}

</div>
