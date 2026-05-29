

<x-filament-panels::form wire:submit="search">
    @if (session()->get('message'))
<span
    class="bg-green-100 text-green-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-green-400 border border-green-400">{!! session()->get('message') !!}</span>
@endif

@if (session()->get('error'))
<span
    class="bg-red-100 text-red-800 text-base font-medium px-2.5 py-3 rounded dark:bg-[#1E1E1E] dark:text-red-400 border border-red-400">{!! session()->get('error') !!}</span>
@endif
<div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
    <div class="flex items-center">
        <label for="status" class="text-lg font-semibold text-[#464559]">Membership Status</label>
    </div>
    <div class="flex gap-4">
        <input type="text" id="input1" wire:model="input1" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium" placeholder="Search">
        <select id="option"  wire:model="option1" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A]">
            <option value="option1">Option 1</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
        <select id="option" wire:model="option2" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium">
            <option value="option1">Option 2</option>
            <option value="option2">Option 2</option>
            <option value="option3">Option 3</option>
        </select>
      
        <!-- Button with increased width -->
        <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">Search</button>
    </div>

    <div class="flex items-center gap-4 flex justify-between">
        <label for="option" class="text-lg font-semibold text-[#706F81]">3 Result</label>
        <button type="button" data-dropdown-toggle="accesibility-dropdown-menu"
        class="inline-flex items-center font-semibold justify-center px-2 py-1 md:px-4 md:py-2 rounded-xl cursor-pointer bg-[#F9FBFF] text-[#4984F6] dark:text-white">
        {{ trans('Recently') }} <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" class="w-4 h-4 ml-2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
        </svg>
    </button>

    </div>
</div>
</x-filament-panels::form>
