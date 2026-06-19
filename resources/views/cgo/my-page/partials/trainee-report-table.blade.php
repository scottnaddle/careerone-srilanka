@php
    if (!function_exists('safe_print')) {
        function safe_print($val) {
            if (is_array($val)) {
                $localeVal = $val[App::getLocale()] ?? array_values($val)[0] ?? '';
                return is_array($localeVal) ? json_encode($val) : (string) $localeVal;
            }
            if (is_object($val) && !method_exists($val, '__toString')) {
                return json_encode($val);
            }
            return (string) $val;
        }
    }
@endphp
<div class="relative overflow-x-auto">
    <table class="w-full text-left rtl:text-right table-auto">
        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center">
            <tr>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.name') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.NIC') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.email') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.Mobile') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.Portfolio') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">{{ __('cgo.nvq_levels') }}</th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 sort-header whitespace-nowrap select-none" data-sort="career_test" data-direction="{{ request('sort') == 'career_test' && request('direction') == 'desc' ? 'asc' : 'desc' }}">
                    <div class="flex items-center justify-center gap-1">
                        {{ __('cgo.Career Tests') }}
                        <span class="text-xs">
                            @if(request('sort') == 'career_test')
                                {{ request('direction') == 'asc' ? '▲' : '▼' }}
                            @else
                                <span class="opacity-30">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
</svg>

                                </span>
                            @endif
                        </span>
                    </div>
                </th>
                <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base cursor-pointer hover:bg-gray-200 dark:hover:bg-gray-700 sort-header whitespace-nowrap select-none" data-sort="counseling" data-direction="{{ request('sort') == 'counseling' && request('direction') == 'desc' ? 'asc' : 'desc' }}">
                    <div class="flex items-center justify-center gap-1">
                        {{ __('cgo.Counselings') }}
                        <span class="text-xs">
                            @if(request('sort') == 'counseling')
                                {{ request('direction') == 'asc' ? '▲' : '▼' }}
                            @else
                                <span class="opacity-30"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15 12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
</svg>
</span>
                            @endif
                        </span>
                    </div>
                </th>
            </tr>
        </thead>
        <tbody>
            @forelse ($traineeReports as $trainee)
                <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                    <td class="px-4 py-3 text-sm font-semibold text-[#201F36] dark:text-white text-left">
                        @php
                            $fullName = $trainee->full_name ?? $trainee->first_name . ' ' . $trainee->last_name;
                        @endphp
                        {{ safe_print($fullName) }}
                    </td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">{{ $trainee->nic }}</td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">{{ $trainee->email }}</td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">{{ $trainee->mobile }}</td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                        @if($trainee->portfolio)
                            <span class="text-[#62B96A] font-semibold">{{ safe_print(__('cgo.Yes')) }}</span>
                        @else
                            <span class="text-[#91919A]">{{ safe_print(__('cgo.No')) }}</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                        @if($trainee->nvqs && $trainee->nvqs->count() > 0)
                            <ul class="text-left space-y-1">
                                @foreach($trainee->nvqs as $n)
                                    @php
                                        $nName = safe_print($n->name);
                                        $nLevel = safe_print($n->level);
                                    @endphp
                                    <li class="flex items-start gap-1">
                                        <span class="leading-tight">- {{ $nName }} ({{ $nLevel }})</span>
                                    </li>
                                @endforeach
                            </ul>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">{{ $trainee->career_test_count }}</td>
                    <td class="px-4 py-3 text-sm text-[#706F81] dark:text-[#C9CCD4]">{{ $trainee->cgo_counseling_count }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">
                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                            @php
                                        $noRecordTrans = safe_print(trans('cgo.job_support.ojt_list.no_record'));
                            @endphp
                            <p class="dark:text-white">{{ $noRecordTrans }}</p>
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@if ($traineeReports->hasPages())
    <div class="mt-4 flex justify-end trainee-pagination">
        {{ $traineeReports->appends(request()->except('page'))->links() }}
    </div>
@endif
