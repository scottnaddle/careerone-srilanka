<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<style>
    /* Container for search and date filter */
    .filter-container {
        display: flex;
        justify-content: center;
        gap: 1rem;
        margin-bottom: 1.5rem;
    }

    /* Search input styling */
    .search-container,
    .date-container {
        position: relative;
        max-width: 250px;
    }

    .search-container input,
    .date-container input {
        padding: 0.75rem 1rem 0.75rem 2.5rem;
        width: 100%;
        border-radius: 9999px;
        /* Fully rounded */
        border: 2px solid #4984F6;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        outline: none;
        transition: border-color 0.3s;
    }

    .search-container input:focus,
    .date-container input:focus {
        border-color: #3567d4;
    }

    .search-icon,
    .date-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        color: #9ca3af;
        font-size: 1.1rem;
    }

    /* Table styling */
    .rounded-table {
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #dfe6f2;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        background-color: #FFFFFF;
    }

    /* Table header */
    .rounded-table thead th {
        background-color: #E7EFFF;
        color: #4984F6;
        font-weight: 600;
        padding: 14px;
        /* Increased padding */
        text-align: center;
    }

    /* Table rows */
    .rounded-table tbody tr {
        border-bottom: 1px solid #dfe6f2;
        transition: background-color 0.3s;
    }

    .rounded-table tbody tr:hover {
        background-color: #f0f6ff;
    }

    /* Table cells */
    .rounded-table tbody td {
        padding: 14px;
        /* Increased padding */
        text-align: center;
        color: #4a5568;
    }

    /* Scrollable column cells */
    .scrollable-column {
        display: flex;
        overflow-x: auto;
        max-width: 250px;
        white-space: nowrap;
    }

    .scrollable-cell {
        min-width: 80px;
        padding: 8px;
        text-align: center;
        background-color: #F9FBFF;
        color: #4a5568;
        font-size: 0.9rem;
    }

    .dataTables_info {
        padding-left: 10px;
    }

    /* Pagination container styling */
    .dataTables_paginate {
        display: flex;
        justify-content: center;
        margin-top: 0.5rem;
        /* Adjust this value to move it closer to the table */
        position: relative;
        top: -5px;
        /* Moves pagination up slightly */
    }

    /* Individual pagination button styling */
    .dataTables_paginate .paginate_button {
        padding: 0.4rem 0.8rem;
        margin: 0 0.2rem;
        background-color: #4984F6;
        color: white;
        border: 1px solid #4984F6;
        border-radius: 6px;
        cursor: pointer;
        font-size: 0.9rem;
        transition: background-color 0.3s;
    }

    /* Hover effect for pagination buttons */
    .dataTables_paginate .paginate_button:hover {
        background-color: #2e6ab3;
    }

    /* Active page styling */
    .dataTables_paginate .paginate_button.current {
        background-color: #1c4d91;
        color: white;
        font-weight: bold;
    }

    /* Disabled button styling */
    .dataTables_paginate .paginate_button.disabled {
        background-color: #ccc;
        color: #666;
        cursor: default;
    }

    /* Responsive adjustments */
    @media (max-width: 640px) {

        .rounded-table thead th,
        .rounded-table tbody td {
            padding: 10px;
            font-size: 0.85rem;
        }

        .scrollable-column {
            max-width: 180px;
        }
    }

    /* Date range indicator */
    .date-range-indicator {
        display: inline-block;
        background-color: #E7EFFF;
        color: #4984F6;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 10px;
    }

    /* Total records styling - same as career test */
    .total-records-container {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 16px;
        padding: 8px 16px;
        background-color: #F9FBFF;
        border-radius: 8px;
        border-left: 4px solid #4984F6;
    }

    .total-records-label {
        font-weight: 600;
        color: #706F81;
    }

    .total-records-value {
        font-weight: 700;
        color: #4984F6;
        font-size: 1.2rem;
    }

    /* Access scope indicator */
    .access-scope-indicator {
        display: inline-block;
        background-color: #E8F5E9;
        color: #2E7D32;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 0.9rem;
        margin-bottom: 10px;
        margin-left: 10px;
        border-left: 4px solid #2E7D32;
    }

    .access-scope-indicator i {
        margin-right: 4px;
    }
</style>

@php
    $countCounselingType = $showCounselingType->count();
    $countCounselingField = $showCounselingField->count();
    $totalColumns = 4 + $countCounselingType + $countCounselingField; // 4 fixed columns: No, District, Counseling, and Action
@endphp

<div>

    <div class="flex w-full justify-between items-center mb-4">
        <div class="flex items-center gap-2">
            <span class="font-semibold text-[#706F81] dark:text-gray-300">Total records:</span>
            <span class="font-bold text-blue-600 dark:text-blue-400">{{ $totalRecords }}</span>
        </div>
        <div class="flex items-center justify-between gap-4">
            <label for="search-status" class="text-lg font-semibold text-[#706F81] flex justify-between items-center w-full">
                @if (request()->query() && count(request()->query()) > 0)

                    <button type="button" class="flex items-center text-red-700 text-sm"
                            onclick="window.location.href = window.location.origin + window.location.pathname;">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                             stroke="currentColor" class="size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                        </svg>
                        {{ trans('system.remove_filter') }}
                    </button>
                @endif
            </label>
        </div>
    </div>

    <div class="relative overflow-x-scroll sm:rounded-lg rounded-table" style="overflow-x: auto !important;">
        <table id="tableCounseling" class="min-w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-sm text-[#4984F6] bg-[#F9FBFF] dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th rowspan="2" scope="col" class="px-6 py-3 border-b border-white border-x">{{__('admin/dashboard.counseling.no')}}</th>
                <th rowspan="2" scope="col" class="px-6 py-3 border-b border-white border-x">{{__('admin/dashboard.counseling.table.district')}}</th>
                <th rowspan="2" scope="col" class="px-6 py-3 border-b border-white border-x">{{__('admin/dashboard.counseling.table.counseling')}}</th>
                <th colspan="{{ $countCounselingType }}" scope="col"
                    class="px-6 py-3 text-center border-b border-white border-x">{{__('admin/dashboard.counseling.table.counseling_type')}}</th>
                <th colspan="{{ $countCounselingField }}" scope="col"
                    class="px-6 py-3 text-center border-b border-white">{{__('admin/dashboard.counseling.table.counseling_field')}}</th>
                <th rowspan="2" scope="col" class="px-6 py-3 border-b border-white border-x">{{__('cgo.action')}}</th>
            </tr>
            <tr>
                @foreach ($showCounselingType as $item)
                    <th scope="col" class="px-6 py-3 border-b border-white bg-[#E7EFFF] border-x">{{ $item->code_name }}</th>
                @endforeach
                @foreach ($showCounselingField as $item)
                    <th scope="col" class="px-6 py-3 border-b border-white bg-[#E7EFFF] border-x">{{ $item->code_name }}</th>
                @endforeach
            </tr>
            </thead>
            <tbody>
            @php
                $hasRecords = false;
            @endphp

            @php
                $hasRecords = false;
                $rowNumber = 1; // Separate counter variable
            @endphp

            @foreach ($districts as $item)
                @if($item->counselings->count() > 0)
                    @php
                        $hasRecords = true;
                    @endphp
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="px-6 py-4 border-b border-white">{{ $rowNumber++ }}</th>
                        <th scope="row"
                            class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white border-b border-white">
                            {{ $item->name }}
                        </th>
                        <td class="px-6 py-4 border-b border-white font-semibold text-blue-600">{{ $item->counselings->count() }}</td>
                        @foreach ($showCounselingType as $type)
                            <td class="px-6 py-4 border-b border-white bg-[#F9FBFF]">
                                {{ $item->countCounselingFCodeId($type->code_id, 'counseling_type', $startDate, $endDate) }}
                            </td>
                        @endforeach
                        @foreach ($showCounselingField as $field)
                            <td class="px-6 py-4 border-b border-white bg-[#F9FBFF]">
                                {{ $item->countCounselingFCodeId($field->code_id, 'counseling_field_id', $startDate, $endDate) }}
                            </td>
                        @endforeach
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                            <a href="/admin/counseling-lists?tableFilters[location][value]={{$item->id}}&tableFilters[custom_date_range][startDate]={{$startDate}}&tableFilters[custom_date_range][endDate]={{$endDate}}"
                               class="font-medium text-blue-600 dark:text-blue-500 hover:underline flex items-center gap-1">
                                <svg style="--c-400:var(--primary-400);--c-600:var(--primary-600);" wire:loading.remove.delay.default="1" wire:target="mountTableAction('viewMore', '45')" class="fi-link-icon h-4 w-4 text-custom-600 dark:text-custom-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"></path>
                                </svg>
                                {{ __('system.action.view_more') }}
                            </a>
                        </td>
                    </tr>
                @endif
            @endforeach

            @if (!$hasRecords)
                <tr>
                    <td colspan="{{ $totalColumns }}" class="px-6 py-4 text-center">
                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                            <p class="dark:text-white">{{ trans('cgo.job_support.company_list.no_record') }}</p>
                        </div>
                    </td>
                </tr>
            @endif
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('#tableCounseling').DataTable({
            paging: true,
            searching: true,
            ordering: true,
            lengthChange: false,
            pageLength: 10,
            responsive: true,
            scrollX: true,
            scrollCollapse: true,
            language: {
                search: '', // Remove "Search:" label
                zeroRecords: '{{ __('system.no_records') }}',
                info: '{{ __('system.showing_page') }} _START_ - _END_ / _TOTAL_',
                infoEmpty: '{{ __('system.no_records') }}',
                infoFiltered: '({{ __('system.filtered_from') }} _MAX_ {{ __('system.total_records') }})',
            },
            initComplete: function() {
                // Add search input container
                $('#tableCounseling_filter').html(`
                    <div class="filter-container pt-4 pr-2 flex items-center space-x-2">
                        <input type="search" placeholder="{{__('admin/dashboard.counseling.table.search')}}..." aria-label="Search" id="tableSearchInput" class="border px-3 py-2 rounded">
                    </div>
                `);

                // Link search input to DataTable search functionality
                $('#tableSearchInput').on('keyup', function() {
                    $('#tableCounseling').DataTable().search($(this).val()).draw();
                });
            }
        // DataTable is initialized here
        // No exportData function needed here anymore as Alpine handles it on the button directly.
    });
</script>
