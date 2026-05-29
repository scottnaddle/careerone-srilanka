<div>
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

<div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
    <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            'javascript:void(0)' => 'Membership',
            'javascript:void(1)' => 'Administrator',
            'javascript:void(2)' => 'Administrator Approval List',
        ]" />
                     <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                        Administrator Approval List
                     </h1>
    {{-- <div class="flex items-center">
        <label for="status" class="text-lg font-semibold text-[#464559]">Administrator</label>
    </div> --}}
{{--    <form action="{{ url()->current() }}">--}}
{{--        <div class="flex items-center gap-4">--}}
{{--            <!-- Input 1 -->--}}
{{--            <input type="text" --}}
{{--                   value="{{ request()->query('search') }}" --}}
{{--                   name="search" --}}
{{--                   id="input1" --}}
{{--                   wire:model.debounce.500ms="search" --}}
{{--                   class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium" --}}
{{--                   placeholder="Search">--}}
{{--            --}}
{{--            <!-- Date Picker -->--}}
{{--            <input type="date" --}}
{{--                   id="datePicker" --}}
{{--                   value="{{ request()->query('datePicker') }}" --}}
{{--                   name="datePicker" --}}
{{--                   class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium ">--}}
{{--            --}}
{{--            <!-- Search Button -->--}}
{{--            <button type="submit" --}}
{{--                    wire:click="handleSearch" --}}
{{--                    class="px-6 py-2 bg-blue-500 text-white font-medium rounded-full">--}}
{{--                Search--}}
{{--            </button>--}}
{{--        </div>--}}
{{--    </form>--}}

    <div>

    </div>
     <x-filament-panels::page class="w-full">

    </x-filament-panels::page>
</div>
</div>

