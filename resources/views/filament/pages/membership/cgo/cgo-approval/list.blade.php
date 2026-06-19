<style>
    table thead tr th span {
        color: blue;
    }

    #search-time {
        background-color: #F9FBFF;
        color: #4984F6;
        border: none;
    }
</style>

<div class="p-6 space-y-6 bg-white mt-4 rounded-xl">
    <x-filament::breadcrumbs :breadcrumbs="[
        '/admin/overview' => 'Admin',
        'javascript:void(0)' => 'Membership',
        'javascript:void(1)' => 'CGO',
        'javascript:void(2)' => 'CGO Approval List',
    ]" />
     <h1 class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
        CGO Approval List
     </h1>
    {{-- <div class="flex items-center">
        <label for="status" class="text-lg font-semibold text-[#464559]">CGO Approval List</label>
    </div> --}}
{{--    <form method="get" action="{{ url()->current() }}">--}}
{{--        <div class="flex gap-4">--}}
{{--            <!-- Largest input -->--}}
{{--            <input type="text" name="search"--}}
{{--                class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium"--}}
{{--                value="{{request()->query('search')}}"--}}
{{--                placeholder="Search">--}}
{{--            <select id="TVET_type" name="TVET_type"--}}
{{--                class="w-1/4 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A]">--}}
{{--                <option value="">{{__('admin/dashboard.cgo.tvet_type')}}</option>--}}
{{--                @foreach ($this->getTVET() as $tvet)--}}
{{--                    <option value="{{ $tvet->head_office_code }}" @selected(request()->query('TVET_type') == $tvet->head_office_code)>{{ $tvet->head_office_name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}
{{--            <select id="institute" name="institute"--}}
{{--                class="w-1/4 px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium">--}}
{{--                <option value="">{{__('admin/dashboard.cgo.institute_name')}}</option>--}}
{{--                @foreach ($this->getInstitute() as $institute)--}}
{{--                    <option value="{{ $institute->id }}" @selected(request()->query('institute') == $institute->id)>{{ $institute->name }}</option>--}}
{{--                @endforeach--}}
{{--            </select>--}}

{{--            <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-center text-white rounded-full">{{__('system.form.button.search')}}</button>--}}
{{--        </div>--}}

{{--        <div class="flex items-center gap-4 flex justify-between mt-4">--}}
{{--            <label for="option" class="text-lg font-semibold text-[#706F81]">--}}
{{--                @if (request()->query())--}}
{{--                     {{ $this->totalCgo}} {{ __('admin/company.result') }}--}}
{{--                @endif--}}
{{--            </label>--}}
{{--            <select id="search-time" name="search-time" class="font-semibold border text-base rounded-xl block">--}}
{{--                <option @selected(request()->query('search-time') == 'recently') value="recently">Recently</option>--}}
{{--                <option @selected(request()->query('search-time') == 'oldset') value="oldset">Older</option>--}}
{{--            </select>--}}
{{--        </div>--}}
{{--    </form>--}}
    <div></div>
    <x-filament-panels::page class="w-full"></x-filament-panels::page>
</div>

