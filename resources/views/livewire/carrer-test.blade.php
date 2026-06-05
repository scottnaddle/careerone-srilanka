<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<style>
    .career-wrapper {
        padding: 24px;
        background: #f8fafc;
    }

    .career-search-container {
        display: flex;
        justify-content: flex-end;
        margin-bottom: 20px;
        position: relative;
    }

    .career-search-box {
        width: 300px;
        padding: 12px 20px 12px 45px;
        border: 2px solid #4984F6;
        border-radius: 50px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
        box-shadow: 0 2px 8px rgba(73, 132, 246, 0.1);
    }

    .career-search-box:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 4px 12px rgba(73, 132, 246, 0.2);
    }

    .career-search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #4984F6;
        width: 20px;
        height: 20px;
    }

    .career-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: white;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.08);
    }

    .career-table thead tr:first-child th {
        background: #E7EFFF;
        color: #4984F6;
        font-weight: 600;
        padding: 14px;
        text-align: center;
    }

    .career-table thead tr:last-child th {
        background: #E7EFFF;
        color: #4984F6;
        padding: 14px;
        font-weight: 600;
    }

    .career-table tbody td {
        padding: 14px;
        border-bottom: 1px solid #E7EFFF;
        color: #475569;
        text-align: center;
    }

    .career-table tbody tr:last-child td {
        border-bottom: none;
    }

    .career-table tbody tr:hover {
        background-color: #F8FAFF;
    }

    .career-align-left {
        text-align: center !important;
    }

    .career-details-link {
        color: #4984F6;
        text-decoration: none;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 4px;
        font-weight: 500;
        transition: color 0.2s ease;
    }

    .career-details-link:hover {
        color: #2563eb;
    }

    .career-pagination {
        margin-top: 20px;
        display: flex;
        justify-content: center;
        gap: 8px;
    }

    .career-pagination .paginate_button {
        padding: 8px 16px;
        border-radius: 8px;
        background: white;
        border: 1px solid #4984F6;
        color: #4984F6;
        cursor: pointer;
        transition: all 0.2s ease;
    }

    .career-pagination .paginate_button.current {
        background: #4984F6;
        color: white;
    }

    .career-pagination .paginate_button:hover:not(.current) {
        background: #E7EFFF;
    }

    .career-pagination .paginate_button.disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

</style>

{{--<div class="career-wrapper w-full">--}}
<div class="relative overflow-x-auto sm:rounded-lg rounded-table">
{{--    <div class="career-search-container">--}}
{{--        <input type="search" class="career-search-box" id="careerSearchInput"--}}
{{--            wire:model.defer="searchInstitute"--}}
{{--            placeholder="{{ __('admin/career_test.career_test.search') }}...">--}}

{{--        --}}{{-- <button wire:click="searchInstitute" class="career-search-button">--}}
{{--            Tìm kiếm--}}
{{--        </button> --}}
{{--    </div>--}}

    <table id="careerTable" class="career-table text-sm">
        <thead>
            <tr>
                <th rowspan="2" class="px-6 py-3 border-b border-white border-x">{{ __('admin/career_test.career_test.no') }}</th>
                <th rowspan="2" class="px-6 py-3 border-b border-white border-x">{{ __('admin/career_test.career_test.institute') }}</th>
                <th colspan="{{ $carrerTestType->count() }}" class="px-6 py-3 text-center border-b border-white border-x">
                    {{ __('admin/career_test.career_test.career_test_type') }}</th>
                <th colspan="2" class="px-6 py-3 border-b border-white border-x">{{ __('admin/career_test.career_test.member_type') }}</th>
                <th colspan="2" class="px-6 py-3 border-white border-x"></th>
            </tr>
            <tr>
                @foreach ($carrerTestType as $index => $item)
                    <th class="px-6 py-3 border-b border-white border-x">{{ $item->code_name }}</th>
                @endforeach
                <th class="px-6 py-3 border-b border-white border-x">{{ __('admin/career_test.career_test.member') }}</th>
                <th class="px-6 py-3 border-b border-white border-x">{{ __('admin/career_test.career_test.non_member') }}</th>
                <th class="px-6 py-3 border-b border-white border-x"></th>
            </tr>
        </thead>
{{--        <tbody>--}}
{{--            @foreach ($institue as $index => $item)--}}
{{--                @if($item->countCareerTestByInstituteMember($startDate, $endDate)['member'] > 0 || $item->countCareerTestByInstituteMember($startDate, $endDate)['non_member'] > 0)--}}
{{--                <tr>--}}
{{--                    <td>{{ $institue->firstItem() + $index }}</td>--}}
{{--                    <td class="career-align-left"><a href="{{ route('filament.admin.resources.career-tests.show-id', ['record' => $item->id]) }}">{{ $item->name }}</a> </td>--}}
{{--                    @foreach ($carrerTestType as $index1 => $item2)--}}
{{--                        <td>{{ $item->countCareerTestByInstitute($startDate, $endDate, $item2->code_id)['member'] + $item->countCareerTestByInstitute($startDate, $endDate, $item2->code_id)['non_member'] }}--}}
{{--                        </td>--}}
{{--                    @endforeach--}}
{{--                    <td class="career-align-left">{{ $item->countCareerTestByInstituteMember($startDate, $endDate)['member'] }}--}}
{{--                    </td>--}}
{{--                    <td class="career-align-left">--}}
{{--                        {{ $item->countCareerTestByInstituteMember($startDate, $endDate)['non_member'] }}</td>--}}
{{--                    <td>--}}
{{--                        <a class="career-details-link whitespace-nowrap flex items-center gap-1"--}}
{{--                           href="{{ route('filament.admin.resources.career-tests.show-id', ['record' => $item->id]) }}">--}}
{{--                            {{ __('admin/career_test.career_test.view_details') }}--}}
{{--                            <span>&gt;</span>--}}
{{--                        </a>--}}
{{--                    </td>--}}
{{--                </tr>--}}
{{--                @endif--}}
{{--            @endforeach--}}
{{--        </tbody>--}}
        <tbody>
        @php
            $hasRecords = false;
        @endphp

        @foreach ($institue as $index => $item)
            @if ($item->countCareerTestByInstituteMember($startDate, $endDate)['member'] > 0 || $item->countCareerTestByInstituteMember($startDate, $endDate)['non_member'] > 0)
                @php
                    $hasRecords = true;
                @endphp
                <tr>
                    <td>{{ $institue->firstItem() + $index }}</td>
                    <td class="career-align-left">
                        <a href="{{ route('filament.admin.resources.career-tests.show-id', ['record' => $item->id]) }}">
                            {{ $item->name }}
                        </a>
                    </td>
                    @foreach ($carrerTestType as $index1 => $item2)
                        <td>
                            {{ $item->countCareerTestByInstitute($startDate, $endDate, $item2->code_id)['member'] + $item->countCareerTestByInstitute($startDate, $endDate, $item2->code_id)['non_member'] }}
                        </td>
                    @endforeach
                    <td class="career-align-left">
                        {{ $item->countCareerTestByInstituteMember($startDate, $endDate)['member'] }}
                    </td>
                    <td class="career-align-left">
                        {{ $item->countCareerTestByInstituteMember($startDate, $endDate)['non_member'] }}
                    </td>
                    <td>
                        <a class="career-details-link whitespace-nowrap flex items-center gap-1"
                           href="{{ route('filament.admin.resources.career-tests.show-id', ['record' => $item->id]) }}">
                            {{ __('admin/career_test.career_test.view_details') }}
                            <span>&gt;</span>
                        </a>
                    </td>
                </tr>
            @endif
        @endforeach

        @if (!$hasRecords)
            <tr>
                <td colspan="9">
                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                        <p class="dark:text-white">No record!</p>
                    </div>
                </td>
            </tr>
        @endif
        </tbody>

    </table>

    <div class="career-pagination">
        {{ $institue->links('pagination::custom-pagination-admin') }}
    </div>
</div>

<script>
    // $(document).ready(function() {
    //     var table = $('#careerTable').DataTable({
    //         paging: true,
    //         searching: true,
    //         ordering: true,
    //         lengthChange: false,
    //         pageLength: 10,
    //         responsive: true,
    //         dom: 't<"career-pagination"p>',
    //         language: {
    //             search: '',
    //             paginate: {
    //                 next: '›',
    //                 previous: '‹'
    //             }
    //         }
    //     });

    //     $('#careerSearchInput').on('keyup', function() {
    //         table.search($(this).val()).draw();
    //     });
    // });
    $(document).ready(function() {
        $("#careerSearchInput").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".career-table tbody tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
            });

            // Update empty state message
            if ($(".career-table tbody tr:visible").length === 0) {
                if ($(".no-results-message").length === 0) {
                    $(".career-table tbody").append(
                        '<tr class="no-results-message"><td colspan="100%" style="text-align: center; padding: 20px;">Không tìm thấy kết quả</td></tr>'
                    );
                }
            } else {
                $(".no-results-message").remove();
            }
        });
    });
</script>
