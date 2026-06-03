
<div class="filament-page">

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

    <div class="p-6 space-y-6 bg-white mt-4 rounded-xl shadow-sm dark:bg-gray-800">
        <x-filament-panels::page>
        <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            'javascript:void(0)' => 'Membership',
            'javascript:void(1)' => 'Company',
            'javascript:void(2)' => 'Company Approval List',
        ]" />

        <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
            Company Approval List
        </h1>

{{--        <form method="" action="{{ url()->current() }}" class="space-y-4">--}}
{{--            <div class="grid grid-cols-7 gap-4">--}}
{{--                <!-- Sector Select -->--}}
{{--                <select id="sector" name="sector" --}}
{{--                        class="col-span-3 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] w-full">--}}
{{--                    <option value="">{{ __('admin/company.sector') }}</option>--}}
{{--                    @foreach ($this->getSector() as $sector)--}}
{{--                        <option value="{{ $sector->id }}" @selected(request()->query('sector') == $sector->id)>--}}
{{--                            {{ $sector->name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--        --}}
{{--                <!-- District Select -->--}}
{{--                <select id="district" name="district" --}}
{{--                        class="col-span-3 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] w-full">--}}
{{--                    <option value="">{{ __('admin/company.district') }}</option>--}}
{{--                    @foreach ($this->getDistrict() as $district)--}}
{{--                        <option value="{{ $district->id }}" @selected(request()->query('district') == $district->id)>--}}
{{--                            {{ $district->name }}--}}
{{--                        </option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--        --}}
{{--                <!-- Search Button -->--}}
{{--                <button type="submit" --}}
{{--                        class="col-span-1 px-6 py-2 bg-blue-500 text-white font-medium rounded-full w-full">--}}
{{--                    {{ __('admin/company.search') }}--}}
{{--                </button>--}}
{{--            </div>--}}
{{--        </form>--}}
    </x-filament-panels::page>
    </div>

</div>
