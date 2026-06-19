<style>
    .table-widget .fi-ta-header div:first-child h3 {
        padding-left: 0.5rem;
        color: #4984F6 !important;
        border-left: 2px solid #4984F6;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
    }

    .table-widget table thead tr span {

        color: #4984F6 !important;
    }

    .table-widget .fi-ta-ctn {
        min-height: 450px;
    }

    .chart-widget header h3 {
        padding-left: 0.5rem;
        color: #4984F6 !important;
        border-left: 2px solid #4984F6;
        font-size: 18px;
        font-style: normal;
        font-weight: 600;
        line-height: 24px;
    }

    .view-more-button {
        background-color: #ffffff !important;
        color: #91919A !important;
        cursor: pointer;
        border: none;
        box-shadow: none;
        padding-top: 0;
        padding-bottom: 0;
    }

    .view-more-button svg {
        color: #91919A !important;
    }

    .custom-select {
        background-image: url('data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' fill=\'none\' viewBox=\'0 0 24 24\' stroke=\'%234984F6\'%3E%3Cpath stroke-linecap=\'round\' stroke-linejoin=\'round\' stroke-width=\'2\' d=\'M6 9l6 6 6-6\'/%3E%3C/svg%3E') !important;
        background-repeat: no-repeat;
        background-position: right 0.75rem center;
        background-size: 1.5rem 1.5rem;
    }
</style>
<div>
    {{-- <div>
        <div class="p-6 space-y-6 bg-white mt-4 rounded-xl dark:bg-[#1E1E1E]">
            <div class="flex gap-4">
                <div class="relative w-full">

                    <input type="text" id="keywords_search"
                        class="border border-gray-300 text-[#91919A] font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Search" />
                    <button type="button" class="absolute inset-y-0 end-0 flex items-center pe-3">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M21 21L15 15M3 10C3 10.9193 3.18106 11.8295 3.53284 12.6788C3.88463 13.5281 4.40024 14.2997 5.05025 14.9497C5.70026 15.5998 6.47194 16.1154 7.32122 16.4672C8.1705 16.8189 9.08075 17 10 17C10.9193 17 11.8295 16.8189 12.6788 16.4672C13.5281 16.1154 14.2997 15.5998 14.9497 14.9497C15.5998 14.2997 16.1154 13.5281 16.4672 12.6788C16.8189 11.8295 17 10.9193 17 10C17 9.08075 16.8189 8.1705 16.4672 7.32122C16.1154 6.47194 15.5998 5.70026 14.9497 5.05025C14.2997 4.40024 13.5281 3.88463 12.6788 3.53284C11.8295 3.18106 10.9193 3 10 3C9.08075 3 8.1705 3.18106 7.32122 3.53284C6.47194 3.88463 5.70026 4.40024 5.05025 5.05025C4.40024 5.70026 3.88463 6.47194 3.53284 7.32122C3.18106 8.1705 3 9.08075 3 10Z"
                                stroke="#C9CCD4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </button>
                </div>
                <select id="district" wire:model="district"
                    class="border border-gray-300 text-[#91919A] font-medium rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="">District</option>
                    @foreach ($this->districts() as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
                <!-- Button with increased width -->
                <button type="submit" class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">Search</button>
            </div>

            <div class="flex justify-between items-center">
                @if (true)
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">3 Results</p>
                @else
                    <p></p>
                @endif
                <select name="period"
                    class="custom-select bg-[#F9FBFF] font-semibold border-none text-[#4984F6] text-base rounded-xl focus:border-primary block dark:bg-gray-500/20 dark:placeholder-white dark:text-[#4984F6] dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <option value="period">Period</option>
                </select>
                <select name="sort_by"
                    class="custom-select bg-[#F9FBFF] font-semibold border-none text-[#4984F6] text-base rounded-xl focus:border-primary block dark:bg-gray-500/20 dark:placeholder-white dark:text-[#4984F6] dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                    <option value="recently" @selected(request()->input('sort_by') == 'recently')>Order of inquiry</option>
                </select>
            </div>
        </div>
    </div> --}}
    <x-filament-panels::page>
        @php
            $user = auth('admin')->user();
        @endphp
        <div class="flex w-full justify-end">
            <select name="head_office" id="head_office" class="fi-input rounded-xl border border-gray-300">
                @if($user->hasRole('super_admin'))
                    <option value="">{{__('admin/cgo_performance.institute_head_office')}}</option>
                    @forelse($this->head_offices as $head_office)
                    <option value="{{$head_office->head_office_code}}" @selected(request('head_office')==$head_office->head_office_code)>{{$head_office->head_office_name}} ({{$head_office->head_office_code}})</option>
                    @empty
                    @endforelse
                @else
                    <option value="{{$user->tvet_type}}" selected>{{$user->tvet_type}} </option>
                @endif
            </select>
        </div>
        <script src="{{asset('/js/jquery-3.7.1.min.js')}}"></script>
        <script>
            $(document).ready(function () {
                let url = new URL(window.location.href);
                $('#head_office').on('change', function() {
                    if (url.searchParams.has('head_office')) {
                        url.searchParams.set('head_office', this.value);
                        url.searchParams.delete('page');
                    } else {
                        url.searchParams.append('head_office', this.value);
                        url.searchParams.delete('page');
                    }
                    window.location.href = url.href;
                })
            });
        </script>

    </x-filament-panels::page>
</div>
