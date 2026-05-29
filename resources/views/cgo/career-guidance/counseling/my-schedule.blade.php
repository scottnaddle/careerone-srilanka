@extends('homepage.layouts.master')
@section('title', 'CGO - Career Guidance - Guidance - My Schedule')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.career_guidance.root'), 'url' => '#'],
                ['label' => 'Guidance List', 'url' => route('cgo.career-guidance.counseling.counseling-list')],
                ['label' => trans('cgo.my_schedule'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <div  class="flex flex-col gap-4 md:gap-6">
                <ul class="flex flex-nowrap text-center text-gray-500 rounded-xl dark:divide-gray-700 dark:text-gray-400 p-4 sm:p-0">
                    <li class="flex-1">
                        <a href="{{ route('cgo.career-guidance.counseling.my-schedule') }}"
                           class="text-sm sm:text-lg {{ Request::is('cgo/career-guidance/counseling/my-schedule') ? 'bg-primary text-white font-semibold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-l-xl focus:ring-2 focus:ring-blue-300 focus:outline-none hover:font-bold">
                            {{trans('cgo.my_schedule')}}
                        </a>
                    </li>
                    <li class="flex-1">
                        <a href="{{ route('cgo.career-guidance.counseling.counseling-list') }}"
                           class="text-sm sm:text-lg {{ Request::is('cgo/career-guidance/counseling/counseling-list') ? 'bg-primary text-white font-semibold' : 'text-[#91919A] bg-[#F8F8F8]' }} inline-block w-full p-4 rounded-r-xl focus:ring-2 focus:ring-blue-300 focus:outline-none dark:primary  hover:font-bold" aria-current="page">
                            {{trans('cgo.counseling_list')}}
                        </a>
                    </li>
                </ul>


                <div class="flex flex-col gap-4">
                    {{-- <div class="flex flex-col p-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                        <div class="flex justify-between">
                            <span class="text-xl text-primary dark:text-white flex justify-center items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Weekly</span>

                        </div>

                        <div class="overflow-x-auto">
                            <table class="w-full text-left rtl:text-right border-collapse table-auto">
                                <thead class="bg-[#F5F7FA] dark:bg-[#282828]">
                                    <tr class="border border-white">
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-center border border-white">
                                            <p class="font-bold text-primary text-xs sm:text-sm dark:text-white">{{ $currentDate->format('M') }}</p>
                                            <p class="font-medium text-medium text-primary text-xs sm:text-sm dark:text-white">{{ $currentDate->year }}</p>
                                        </th>
                                        @foreach( $listWorkingDayCurrentWeek as $workingDay )
                                        <th scope="col" class="px-2 sm:px-4 py-2 text-center border border-white">
                                            <p class="font-bold text-primary text-xs sm:text-sm dark:text-white">{{ $workingDay['dayName'] }}</p>
                                            <p class="font-medium text-medium text-primary text-xs sm:text-sm dark:text-white">{{ $workingDay['dayNumber'] }}</p>
                                        </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr class="bg-white dark:bg-[#1E1E1E] border border-[#F8F8F8]">
                                        <td class="px-2 sm:px-4 py-2 border border-[#F8F8F8] font-medium text-xs sm:text-sm text-[#706F81] dark:text-white">
                                            AM
                                        </td>
                                        @foreach( $listScheduleCounseling['weekly']['listScheduleCounselingAm'] as $day => $weeklyCounselingPerDay )
                                            @if( !empty($weeklyCounselingPerDay['items']) )
                                                <td class="px-2 py-1 border border-[#F8F8F8]">
                                                    <div class="flex flex-col gap-1">
                                                        <ul class="max-w-md space-y-1 list-disc list-inside text-xs">
                                                            @foreach($weeklyCounselingPerDay['items'] as $counseling)
                                                                <li class="text-[#464559] dark:text-white">
                                                                    {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="flex justify-end">
                                                            <a href="{{route('cgo.career-guidance.counseling.counseling-list')."?startdate=".$weeklyCounselingPerDay['date']."&&enddate=".$weeklyCounselingPerDay['date'] }}" class="text-primary dark:text-white underline text-xs">More</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="px-2 py-1 border border-[#F8F8F8]">
                                                    <div class="flex flex-col gap-1">
                                                        <ul class="max-w-md space-y-1 list-disc list-inside text-xs">
                                                            <li class="text-[#464559] dark:text-white">
                                                                None
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr class="bg-white dark:bg-[#1E1E1E]">
                                        <td class="px-2 sm:px-4 py-2 border border-[#F8F8F8] font-medium text-xs sm:text-sm text-[#706F81] dark:text-white">
                                            PM
                                        </td>
                                        @foreach( $listScheduleCounseling['weekly']['listScheduleCounselingPm'] as $day => $weeklyCounselingPerDay )
                                            @if( !empty($weeklyCounselingPerDay['items']) )
                                                <td class="px-2 py-1 border border-[#F8F8F8]">
                                                    <div class="flex flex-col gap-1">
                                                        <ul class="max-w-md space-y-1 list-disc list-inside text-xs">
                                                            @foreach($weeklyCounselingPerDay['items'] as $counseling)
                                                                <li class="text-[#464559] dark:text-white">
                                                                    {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                        <div class="flex justify-end">
                                                            <a href="{{route('cgo.career-guidance.counseling.counseling-list')."?startdate=".$weeklyCounselingPerDay['date']."&&enddate=".$weeklyCounselingPerDay['date'] }}" class="text-primary dark:text-white underline text-xs">More</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            @else
                                                <td class="px-2 py-1 border border-[#F8F8F8]">
                                                    <div class="flex flex-col gap-1">
                                                        <ul class="max-w-md space-y-1 list-disc list-inside text-xs">
                                                            <li class="text-[#464559] dark:text-white">
                                                                None
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            @endif
                                        @endforeach
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                    </div> --}}

                    <div class="flex flex-col p-4 sm:p-5 gap-4 sm:gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl flex-1 shadow-custom-light dark:shadow-custom-dark">
                        <div class="flex justify-between items-center">
                            <span class="text-lg sm:text-xl text-primary dark:text-white font-semibold flex items-center">
                                <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{ __('cgo.Monthly')}}
                            </span>
                        </div>
                        <div class="flex justify-between mt-2">
                            <a id="previous-month" href="#" class="text-xs sm:text-sm font-semibold text-primary dark:text-white hover:text-blue-500 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 mr-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                </svg>
                                {{ __('cgo.Previous Month')}}
                            </a>
                            <a id="next-month" href="#" class="text-xs sm:text-sm font-semibold text-primary dark:text-white hover:text-blue-500 flex items-center">
                                {{ __('cgo.Next Month')}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 ml-1">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>






                        <div x-data="app()" x-init="[initDate(), getNoOfDays()]" x-cloak>
                            <div class="container mx-auto px-2 sm:px-4 py-2">

                                <!-- <div class="font-bold text-gray-800 text-lg sm:text-xl mb-4">
                                    Schedule Tasks
                                </div> -->

                                <div class="bg-white rounded-lg shadow-custom-light dark:shadow-custom-light overflow-hidden">

                                    <div class="flex items-center justify-between p-2 relative">
                                        <div class="text-center w-full flex justify-center text-base sm:text-lg text-primary">
                                            <span x-text="MONTH_NAMES[month]" class="text-base sm:text-lg"></span>
                                            <span x-text="year" class="ml-1 text-base sm:text-lg font-bold"></span>
                                        </div>
                                    </div>

                                    <div class="-mx-1 -mb-1">
                                        <div class="flex flex-wrap">
                                            <template x-for="(day, index) in DAYS" :key="index">
                                                <div style="width: 14.28%" class="px-2 sm:px-4 bg-[#F5F7FA] py-4 sm:py-6">
                                                    <div x-text="day" class="text-xs sm:text-sm uppercase tracking-wide font-bold text-center text-primary"></div>
                                                </div>
                                            </template>
                                        </div>

                                        <div class="flex flex-wrap border border-[#EDEDED]">
                                            <template x-for="blankday in blankdays">
                                                <div style="width: 14.28%; height: 100px" class="text-center border border-[#EDEDED] px-2 sm:px-4 pt-2"></div>
                                            </template>
                                            <template x-for="(date, dateIndex) in no_of_days" :key="dateIndex">
                                                <div style="width: 14.28%; height: 100px" class="px-2 sm:px-4 pt-2 border border-[#EDEDED] relative text-center">
                                                    <div x-text="date" class="inline-flex w-5 sm:w-6 h-5 sm:h-6 items-center justify-center cursor-pointer text-center leading-none rounded-full transition ease-in-out duration-100"
                                                        :class="{'bg-blue-500 text-white': isToday(date) == true, 'text-gray-700 hover:bg-blue-200': isToday(date) == false }"></div>
                                                    <div style="height: 60px;" class="overflow-y-auto mt-1 flex gap-2 sm:gap-4 justify-center">
                                                        <template x-for="event in events.filter(e => new Date(e.event_date).toDateString() ===  new Date(year, month, date).toDateString() )">
                                                            <div class="flex gap-1 items-center">
                                                                <p x-text="event.event_title" class="text-xs sm:text-sm truncate leading-tight text-[#706F81]"></p>
                                                                <div class="w-2 h-2 rounded-full"
                                                                    :class="{
                                                                        'bg-[#578BEF]': event.event_theme === 'confirm',
                                                                        'bg-[#9F9FAA]': event.event_theme === 'waiting',
                                                                        'bg-[#62B96A]': event.event_theme === 'completed',
                                                                        'bg-[#F34550]': event.event_theme === 'cancel'
                                                                    }"></div>
                                                            </div>
                                                        </template>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="flex flex-wrap gap-4">
                            <div class="flex items-center gap-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <circle cx="6.5" cy="6" r="6" fill="#4984F6" />
                                    </svg>
                                </span>
                                <span class="text-xs dark:text-white">{{ __('cgo.confirm') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <circle cx="6.5" cy="6" r="6" fill="#9F9FAA" />
                                    </svg>
                                </span>
                                <span class="text-xs dark:text-white">{{ __('cgo.request') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <circle cx="6.5" cy="6" r="6" fill="#62B96A" />
                                    </svg>
                                </span>
                                <span class="text-xs dark:text-white">{{ __('cgo.completed') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="12" viewBox="0 0 13 12" fill="none">
                                        <circle cx="6.5" cy="6" r="6" fill="#F34550" />
                                    </svg>
                                </span>
                                <span class="text-xs dark:text-white">{{ __('cgo.canceled') }}</span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/alpinejs/3.14.1/cdn.js" defer></script>
    <script>
        const MONTH_NAMES = [
            '{{ __('cgo.schedule.january') }}', '{{ __('cgo.schedule.february') }}', '{{ __('cgo.schedule.march') }}',
            '{{ __('cgo.schedule.april') }}', '{{ __('cgo.schedule.may') }}', '{{ __('cgo.schedule.june') }}',
            '{{ __('cgo.schedule.july') }}', '{{ __('cgo.schedule.august') }}', '{{ __('cgo.schedule.september') }}',
            '{{ __('cgo.schedule.october') }}', '{{ __('cgo.schedule.november') }}', '{{ __('cgo.schedule.december') }}'
        ];
        const DAYS = [
            '{{ __('cgo.schedule.sun') }}', '{{ __('cgo.schedule.mon') }}', '{{ __('cgo.schedule.tue') }}',
            '{{ __('cgo.schedule.wed') }}', '{{ __('cgo.schedule.thu') }}', '{{ __('cgo.schedule.fri') }}',
            '{{ __('cgo.schedule.sat') }}'
        ];

        function app() {
            return {
                month: @json($listScheduleCounseling['current_month']),
                year: @json($listScheduleCounseling['current_year']),
                no_of_days: [],
                blankdays: [],
                days: DAYS,

                events: [
                    @foreach($listScheduleCounseling['monthly'] as $counselingPerDay)
                    {
                        @php
                            $date = \Carbon\Carbon::parse($counselingPerDay->day);
                        @endphp
                        event_date: new Date({{ $date->year }}, {{ $date->month - 1 }}, {{ $date->day }}),
                        event_title: "{{ $counselingPerDay->count }}",
                        event_theme:
                            @switch($counselingPerDay->status)
                                @case(\App\Enums\CgoCounselingStatusEnums::CONFIRM->value)
                                    'confirm'
                                    @break
                                @case(\App\Enums\CgoCounselingStatusEnums::CANCELED->value)
                                    'cancel'
                                    @break
                                @case(\App\Enums\CgoCounselingStatusEnums::REQUEST->value)
                                    'waiting'
                                    @break
                                @case(\App\Enums\CgoCounselingStatusEnums::COMPLETED->value)
                                    'completed'
                                    @break
                                @default
                                    'default'
                            @endswitch
                    },
                    @endforeach
                ],

                event_title: '',
                event_date: '',
                event_theme: 'blue',

                themes: [
                    { value: "confirm", label: "Confirm Theme" },
                    { value: "cancel", label: "Cancel Theme" },
                    { value: "waiting", label: "Waiting Theme" },
                    { value: "completed", label: "Complete Theme" }
                ],
                getUpdatedDate() {
                    let updatedDate = new Date(this.year, this.month);
                    return updatedDate.toISOString().split('T')[0];
                },
                initDate() {
                    let today = new Date(this.year, this.month,0,1);
                    this.month = today.getMonth();
                    this.year = today.getFullYear();
                    this.datepickerValue = new Date(this.year, this.month, today.getDate()).toDateString();
                    this.getNoOfDays();
                },

                isToday(date) {
                    let today = new Date();
                    const d = new Date(this.year, this.month, date);
                    return today.toDateString() === d.toDateString();
                },

                getNoOfDays() {
                    let daysInMonth = new Date(this.year, this.month + 1, 0).getDate();
                    let dayOfWeek = new Date(this.year, this.month).getDay();
                    let blankdaysArray = [];
                    for (let i = 1; i <= dayOfWeek; i++) {
                        blankdaysArray.push(i);
                    }

                    let daysArray = [];
                    for (let i = 1; i <= daysInMonth; i++) {
                        daysArray.push(i);
                    }

                    this.blankdays = blankdaysArray;
                    this.no_of_days = daysArray;
                },
            }
        }
    </script>
<script>
    document.getElementById('previous-month').addEventListener('click', function (e) {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        let currentDate = new Date(urlParams.get('date') || new Date().toISOString());
        currentDate.setMonth(currentDate.getMonth() - 1);
        const formattedDate = currentDate.toISOString().split('T')[0];
        window.location.href = window.location.pathname + '?date=' + formattedDate;
    });
    document.getElementById('next-month').addEventListener('click', function (e) {
        e.preventDefault();
        const urlParams = new URLSearchParams(window.location.search);
        let currentDate = new Date(urlParams.get('date') || new Date().toISOString());
        currentDate.setMonth(currentDate.getMonth() + 1);
        const formattedDate = currentDate.toISOString().split('T')[0];
        window.location.href = window.location.pathname + '?date=' + formattedDate;
    });
</script>
@endpush
