<x-filament-panels::page>
    <div>
        <div class="flex flex-col gap-4 md:gap-6 my-6 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light shadow-custom-dark p-4">
            <x-filament::breadcrumbs :breadcrumbs="[
            '/admin/overview' => 'Admin',
            '' => 'Career Guidance',
            '/admin/career-tests' => 'Career Test',
        ]" />

            <div class="flex justify-between items-center">
                <p class="fi-header-heading text-2xl font-bold tracking-tight text-gray-950 dark:text-white sm:text-3xl">
                    {{__('admin/career_test.career_test.title')}}
                </p>
            </div>

            @if (session()->has('success'))
                <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                    {{ session()->get('success') }}
                </div>
            @endif

            @if ($errors->any())
                {!! implode(
                    '',
                    $errors->all(
                        '<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>',
                    ),
                ) !!}
            @endif

            @php
                $careerTestList = $this->getCareerTestTraineeResult();
                $results = $careerTestList['results'];
                $count = $careerTestList['count'];
                $careerTestTypes = $careerTestList['career_test_types'];

                $activePeriod = request()->query('period', 'this_month');
                $startMonth = request()->query('startMonth', date('m'));
                $startYear = request()->query('startYear', date('Y'));
                $endMonth = request()->query('endMonth', date('m'));
                $endYear = request()->query('endYear', date('Y'));

                // Lấy startDate và endDate từ query parameters để truyền cho Livewire
                $startDate = request()->query('startDate');
                $endDate = request()->query('endDate');

                // Nếu không có startDate/endDate trong URL, tính từ period
                if (!$startDate || !$endDate) {
                    [$startDate, $endDate] = $this->getDateRangeFromPeriod($activePeriod);
                    if ($startDate && $endDate) {
                        $startDate = $startDate->format('Y-m-d');
                        $endDate = $endDate->format('Y-m-d');
                    }
                }
            @endphp

            <form method="get" action="{{ url()->current() }}" id="filterForm">
                <!-- Period Dropdown Button -->
                <div class="relative flex gap-4 items-center justify-between w-full mb-4">
                    <button type="button"
                            id="periodButton"
                            onclick="togglePeriodDropdown()"
                            class="px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 flex items-center gap-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span id="selectedPeriodText">{{ $this->getPeriodLabel($activePeriod) }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <!-- Export Button -->
                    <button onclick="exportData(event)" style="background-color: #16a34a"
                            class="px-4 py-2 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-300 transition-colors flex items-center gap-2">
                        {{trans('admin/performance.Export')}}
                    </button>

                    <!-- Period Dropdown Menu -->
                    <div id="periodDropdown"
                         class="hidden absolute left-0 top-full mt-2 w-48 bg-white dark:bg-gray-800 rounded-lg shadow-lg border border-gray-200 dark:border-gray-700 z-50">
                        <div class="py-1">
                            <button type="button" onclick="selectPeriod('today')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.Today')}}</button>
                            <button type="button" onclick="selectPeriod('this_week')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.This Week')}}</button>
                            <button type="button" onclick="selectPeriod('this_month')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.This Month')}}</button>
                            <button type="button" onclick="selectPeriod('last_month')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.Last Month')}}</button>
                            <button type="button" onclick="selectPeriod('this_quarter')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.This Quarter')}}</button>
                            <button type="button" onclick="selectPeriod('this_year')" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.This Year')}}</button>
                            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>
                            <button type="button" onclick="toggleCustomRange()" class="block w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700">{{trans('admin/performance.Custom Range')}}</button>
                        </div>
                    </div>
                </div>

                <!-- Hidden inputs để lưu period và dates -->
                <input type="hidden" name="period" id="period" value="{{ $activePeriod }}">
                <input type="hidden" name="startDate" id="startDate" value="{{ $startDate }}">
                <input type="hidden" name="endDate" id="endDate" value="{{ $endDate }}">

                <!-- Custom Range Picker (ẩn khi không phải custom) -->
                <div id="customRangeContainer" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end mb-6 {{ $activePeriod != 'custom' ? 'hidden' : '' }}">
                    <div class="flex flex-col md:col-span-2">
                        <label class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">From</label>
                        <div class="flex gap-2">
                            <select name="startMonth" id="startMonth" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $startMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                            <select name="startYear" id="startYear" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500">
                                @for($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ $startYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="flex flex-col md:col-span-2">
                        <label class="text-base font-semibold text-gray-700 dark:text-gray-300 mb-1">To</label>
                        <div class="flex gap-2">
                            <select name="endMonth" id="endMonth" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500">
                                @for($m = 1; $m <= 12; $m++)
                                    <option value="{{ sprintf('%02d', $m) }}" {{ $endMonth == sprintf('%02d', $m) ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endfor
                            </select>
                            <select name="endYear" id="endYear" class="w-full px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] focus:ring-2 focus:ring-blue-500">
                                @for($y = date('Y') - 5; $y <= date('Y') + 1; $y++)
                                    <option value="{{ $y }}" {{ $endYear == $y ? 'selected' : '' }}>{{ $y }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2 md:col-span-1">
                        <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">{{trans('admin/performance.Apply')}}</button>
                        <button type="button" onclick="cancelCustomRange()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">{{trans('admin/performance.Cancel')}}</button>
                    </div>
                </div>

                <!-- Results Summary -->
                <div class="flex w-full justify-between items-center">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold text-[#706F81] dark:text-gray-300">{{trans('admin/performance.Total records')}}:</span>
                        <span class="font-bold text-blue-600 dark:text-blue-400">{{ $count }}</span>
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
            </form>

            <!-- Results Table - Truyền startDate và endDate vào Livewire -->
            @livewire('carrer-test', [
            'startDate' => $startDate,
            'endDate' => $endDate
            ])
        </div>
    </div>

    @push('scripts')
        <script>
            // Hàm toggle dropdown
            function togglePeriodDropdown() {
                const dropdown = document.getElementById('periodDropdown');
                dropdown.classList.toggle('hidden');
            }

            // Hàm đóng dropdown
            function closePeriodDropdown() {
                const dropdown = document.getElementById('periodDropdown');
                if (!dropdown.classList.contains('hidden')) {
                    dropdown.classList.add('hidden');
                }
            }

            // Xử lý click bên ngoài để đóng dropdown
            document.addEventListener('click', function(event) {
                const dropdown = document.getElementById('periodDropdown');
                const periodButton = document.getElementById('periodButton');

                // Nếu dropdown đang mở và click không phải vào button hoặc dropdown
                if (!dropdown.classList.contains('hidden') &&
                    !dropdown.contains(event.target) &&
                    !periodButton.contains(event.target)) {
                    dropdown.classList.add('hidden');
                }
            });

            // Xử lý phím ESC để đóng dropdown
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closePeriodDropdown();
                }
            });

            function selectPeriod(period) {
                document.getElementById('period').value = period;
                closePeriodDropdown(); // Đóng dropdown sau khi chọn

                // Update button text
                const periodText = {
                    'today': 'Today',
                    'this_week': 'This Week',
                    'this_month': 'This Month',
                    'last_month': 'Last Month',
                    'this_quarter': 'This Quarter',
                    'this_year': 'This Year'
                };
                document.getElementById('selectedPeriodText').textContent = periodText[period] || period;

                // Hide custom range if not custom
                if (period !== 'custom') {
                    document.getElementById('customRangeContainer').classList.add('hidden');

                    // Tính toán và set startDate, endDate dựa trên period
                    const dates = calculateDatesFromPeriod(period);
                    if (dates) {
                        document.getElementById('startDate').value = dates.startDate;
                        document.getElementById('endDate').value = dates.endDate;
                    }

                    // Submit form
                    document.getElementById('filterForm').submit();
                }
            }

            function calculateDatesFromPeriod(period) {
                const now = new Date();
                let startDate, endDate;

                switch(period) {
                    case 'today':
                        startDate = new Date(now.getFullYear(), now.getMonth(), now.getDate());
                        endDate = new Date(now.getFullYear(), now.getMonth(), now.getDate(), 23, 59, 59);
                        break;
                    case 'this_week':
                        // Lấy thứ 2 đầu tuần
                        const firstDay = now.getDate() - now.getDay() + (now.getDay() === 0 ? -6 : 1);
                        startDate = new Date(now.getFullYear(), now.getMonth(), firstDay);
                        endDate = new Date(now.getFullYear(), now.getMonth(), firstDay + 6, 23, 59, 59);
                        break;
                    case 'this_month':
                        startDate = new Date(now.getFullYear(), now.getMonth(), 1);
                        endDate = new Date(now.getFullYear(), now.getMonth() + 1, 0, 23, 59, 59);
                        break;
                    case 'last_month':
                        startDate = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                        endDate = new Date(now.getFullYear(), now.getMonth(), 0, 23, 59, 59);
                        break;
                    case 'this_quarter':
                        const quarter = Math.floor(now.getMonth() / 3);
                        startDate = new Date(now.getFullYear(), quarter * 3, 1);
                        endDate = new Date(now.getFullYear(), (quarter + 1) * 3, 0, 23, 59, 59);
                        break;
                    case 'this_year':
                        startDate = new Date(now.getFullYear(), 0, 1);
                        endDate = new Date(now.getFullYear(), 11, 31, 23, 59, 59);
                        break;
                    default:
                        return null;
                }

                if (startDate && endDate) {
                    return {
                        startDate: formatDate(startDate),
                        endDate: formatDate(endDate)
                    };
                }
                return null;
            }

            function formatDate(date) {
                const year = date.getFullYear();
                const month = String(date.getMonth() + 1).padStart(2, '0');
                const day = String(date.getDate()).padStart(2, '0');
                return `${year}-${month}-${day}`;
            }

            function toggleCustomRange() {
                document.getElementById('period').value = 'custom';
                document.getElementById('selectedPeriodText').textContent = 'Custom Range';
                closePeriodDropdown(); // Đóng dropdown
                document.getElementById('customRangeContainer').classList.remove('hidden');
            }

            function cancelCustomRange() {
                document.getElementById('customRangeContainer').classList.add('hidden');
                selectPeriod('this_month');
            }

            function exportData(event) {
                // Ngăn event bubbling để không ảnh hưởng đến dropdown
                event.stopPropagation();

                const form = document.getElementById('filterForm');
                const formData = new FormData(form);
                const params = new URLSearchParams(formData).toString();

                // Hiển thị loading indicator
                const exportBtn = event.currentTarget;
                const originalText = exportBtn.innerHTML;
                exportBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2 inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Exporting...';
                exportBtn.disabled = true;

                // Tạo link download
                window.location.href = '{{ url()->current() }}/export?' + params;

                // Restore button sau 2 giây
                setTimeout(() => {
                    exportBtn.innerHTML = originalText;
                    exportBtn.disabled = false;
                }, 2000);
            }

            // Xử lý submit form custom range
            document.addEventListener('DOMContentLoaded', function() {
                const filterForm = document.getElementById('filterForm');
                if (filterForm) {
                    filterForm.addEventListener('submit', function(e) {
                        const period = document.getElementById('period').value;

                        // Nếu là custom range, tính startDate và endDate từ month/year
                        if (period === 'custom') {
                            e.preventDefault(); // Tạm thời ngăn submit để tính toán

                            const startMonth = document.getElementById('startMonth').value;
                            const startYear = document.getElementById('startYear').value;
                            const endMonth = document.getElementById('endMonth').value;
                            const endYear = document.getElementById('endYear').value;

                            // Tạo date objects
                            const startDate = new Date(startYear, parseInt(startMonth) - 1, 1);
                            const endDate = new Date(endYear, parseInt(endMonth) - 1, 1);
                            endDate.setMonth(endDate.getMonth() + 1);
                            endDate.setDate(0); // Last day of month

                            document.getElementById('startDate').value = formatDate(startDate);
                            document.getElementById('endDate').value = formatDate(endDate);

                            // Submit form sau khi đã tính toán
                            filterForm.submit();
                        }
                    });
                }
            });
        </script>
    @endpush
</x-filament-panels::page>
