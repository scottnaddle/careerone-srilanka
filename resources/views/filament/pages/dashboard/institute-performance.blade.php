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

    <x-filament-panels::page>
        @php
            $user = auth('admin')->user();
        @endphp
        <div class="flex w-full justify-end">
            <select name="head_office" id="head_office" class="fi-input rounded-xl border border-gray-300">
                    @if($user->hasRole('super_admin'))
                        <option value="">{{__('admin/cgo_performance.institute_head_office')}}</option>
                        @forelse($this->head_offices as $head_office)
                            <option value="{{$head_office->head_office_code}}" @selected(request('head_office')==$head_office->head_office_code)>@if(request('head_office')==$head_office->head_office_code) @endif{{$head_office->head_office_name}} ({{$head_office->head_office_code}})</option>
                        @empty
                        @endforelse
                    @elseif($user->hasRole('naita_admin'))
                        <option value="NAITA" selected> NAITA </option>
                    @else
                    <option value="{{$user->tvet_type}}" selected> {{$user->tvet_type}} </option>
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
