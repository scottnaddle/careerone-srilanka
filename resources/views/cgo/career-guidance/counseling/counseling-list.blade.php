@extends('homepage.layouts.master')
@section('title', 'CGO - Career Guidance - Counseling - List')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('Guidance'), 'url' => ''],
                ['label' => trans('cgo.counseling_list'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <div class="flex flex-col gap-4 md:gap-6">
                <ul class="flex flex-nowrap text-center text-gray-500 rounded-lg dark:divide-gray-700 dark:text-gray-400 p-4 sm:p-0">
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
                <div class="flex flex-col gap-4 pb-6">
                    <form method="GET" action="{{ route('cgo.career-guidance.counseling.counseling-list') }}">
                        <div class="flex flex-col padding-counseling-list">
                            <div class="flex gap-6 items-center">
                                <label for="simple-search" class="sr-only">{{ __('cgo.search') }}</label>
                                <div class="relative w-full">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                        </svg>
                                    </div>
                                    <input type="text" id="searchQuery" value="{{ request()->get('search_query') }}"
                                        name="search_query"
                                        class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                        placeholder="{{ __('general.Trainee name') }}" />
                                </div>

                                <button type="submit"
                                    class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                    {{ __('cgo.search') }}
                                </button>
                            </div>

                        </div>
                        <div class="flex flex-wrap md:flex-row justify-between items-center gap-4">
                            <div class="flex gap-4 flex-col">
                                @if (request()->query())
                                    @if ($listCounseling)
                                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">
                                            {{ trans_choice('cgo.result_choice', $listCounseling->total()) }}</p>
                                    @endif
                                @endif
                            </div>
                            <div class="flex gap-4">

                                <select id="counselingType" name="type"
                                    class="w-full md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-sm">
                                    <option value="all">{{ __('cgo.type') }}</option>
                                    @foreach (getCodeList('counselling_type') as $type)
                                        <option value="{{$type->code_id}}" @selected(request()->get('type') == strtolower($type->code_id) || (request()->get('type') == 'offline' && $type->code_id == 1))>
                                            {{ $type->code_name }}</option>
                                    @endforeach
                                </select>
                                <select id="counselingStatus" name="status"
                                    class="w-full md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 text-sm">
                                    <option value="all">{{ __('cgo.status') }}</option>
                                    @foreach (getCodeList('counselling_status') as $status)
                                        <option value="{{ $status->code_id }}" @selected(request()->get('status') == strtolower($status->code_id))>
                                            {{ $status->code_name }}</option>
                                    @endforeach
                                </select>

                            </div>
                        </div>
                    </form>
                    <div class="flex justify-start">
                        <a href="{{ route('cgo.career-guidance.counseling.create-offline') }}"
                            class="flex items-center gap-2 font-bold text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none rounded-full text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                            type="button">
                           {{__('cgo.new_counseling')}} <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14"
                                viewBox="0 0 15 14" fill="none">
                                <path d="M7.5013 1.16699V12.8337M1.66797 7.00033H13.3346" stroke="white" stroke-width="1.67"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </a>
                    </div>

                    <div
                        class="bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">

                        <div class="relative overflow-x-auto">
                            <table class="w-full text-left rtl:text-right table-auto md:table-fixed">
                                <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center">
                                    <tr>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.type') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.counseling_field') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.title') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.registration_date') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.counseling_date') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.Trainee Institute') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.trainee_name') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.status') }}
                                        </th>
                                        <th scope="col"
                                            class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.feedback') }}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($listCounseling as $counseling)

                                        <tr class=" clickable-row cursor-pointer bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700"
                                            data-href="{{ route('cgo.career-guidance.counseling.counseling-list.show', ['id' => $counseling->counseling_id]) }}">
                                            <td class="px-4 py-6 text-sm">
                                                <div class="flex gap-1 items-center">
                                                    @if ($counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'online'))
                                                        <img src="{{ asset('images/online.svg') }}" alt="Online"
                                                            class="w-3 h-3">
                                                        <span
                                                            class="text-sm text-[#7AED86]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                                                    @endif
                                                    @if (
                                                        $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'offline') ||
                                                            $counseling->counseling_type == getCodeIdByStringEn('counselling_type', 'Guidance without reservation'))
                                                        <img src="{{ asset('images/offline.svg') }}" alt="Offline"
                                                            class="w-3 h-3">
                                                        <span
                                                            class="text-sm text-[#91919A]">{{ getCodeNameByCodeId('counselling_type', $counseling->counseling_type) }}</span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white">
                                                {{ getCodeNameByCodeId('counselling_field', $counseling->counseling_field_id) }}
                                            </td>
                                            <td
                                                class="px-4 py-6 font-semibold text-sm text-[#201F36] dark:text-white max-w-80 overflow-hidden text-ellipsis hover:text-primary text-left">
                                                {{ $counseling->title }}
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                                {{ date('Y-m-d', strtotime($counseling->registration_date)) }}
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                                {{ date('Y-m-d', strtotime($counseling->available_time)) }} {{$counseling->shift ?? ''}}
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4]">
                                                {!! getInstitutes($counseling->trainee_id, true) !!}
                                            </td>
                                            <td class="px-4 py-6 font-semibold text-[#201F36] dark:text-white text-sm">
                                                {{ $counseling->traineeUser->fullname ?? $counseling->trainee_offline_firstname . ' ' . $counseling->trainee_offline_lastname }}
                                            </td>
                                            <td class="px-4 py-6 text-sm">
                                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'completed'))
                                                    <label title="{{ __('cgo.completed') }}" class="text-[#62B96A] bg-[#F5FFF1] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold block max-w-[120px] overflow-hidden text-ellipsis whitespace-nowrap">
                                                        {{ __('cgo.completed') }}
                                                    </label>
                                                @endif
                                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'request') || $counseling->status == \App\Enums\CgoCounselingStatusEnums::RE_ASSIGN->value)
                                                    <label title="{{ __('cgo.request') }}" class="text-[#91919A] bg-[#F8F8F8] dark:bg-[#282828] px-2 py-1 rounded-lg font-semibold block max-w-[120px] overflow-hidden text-ellipsis whitespace-nowrap">
                                                        {{ __('cgo.request') }}
                                                    </label>
                                                @endif
                                                @if ($counseling->status == getCodeIdByStringEn('counselling_status', 'confirm'))
                                                    <label title="{{ __('cgo.confirm') }}" class="text-primary bg-[#F6FBFF] dark:bg-[#282828] px-2 py-1 font-semibold rounded-lg block max-w-[120px] overflow-hidden text-ellipsis whitespace-nowrap">
                                                        {{ __('cgo.confirm') }}
                                                    </label>
                                                @endif
                                            </td>

                                            <td class="px-3 py-2 text-sm">
                                                <div class="flex items-center">
                                                    @if ($counseling->feedback)
                                                        @for ($i = 0; $i < $counseling->feedback; $i++)
                                                            <svg class="w-3 h-3 text-yellow-300 ms-1" aria-hidden="true"
                                                                xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                                viewBox="0 0 22 20">
                                                                <path
                                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                        @endfor
                                                        @for ($i = 5; $i > $counseling->feedback; $i--)
                                                            <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 22 20">
                                                                <path
                                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                        @endfor
                                                    @else
                                                        @for ($i = 0; $i < 5; $i++)
                                                            <svg class="w-3 h-3 ms-1 text-gray-300 dark:text-gray-500"
                                                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                                                fill="currentColor" viewBox="0 0 22 20">
                                                                <path
                                                                    d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                                                            </svg>
                                                        @endfor
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9">
                                                <div class="flex flex-col gap-4 justify-center items-center p-4">
                                                    <img src="{{asset('/images/empty-box.png')}}" class="opacity-50 h-32" alt="Empty">
                                                    <p class="dark:text-white">No record!</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                    {{--            // this renders the tailwind pagination from vendor --}}
                    @if (count($listCounseling) > 0)
                        <div class="mt-3">
                            {{ $listCounseling->onEachSide(1)->links() }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>


@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script type="module">
        $(document).ready(function() {
            let url = new URL(window.location.href);
            $('#counselingStatus').on('change', function() {
                if (url.searchParams.has('status')) {
                    url.searchParams.set('status', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('status', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            })
            $('#counselingType').on('change', function() {
                if (url.searchParams.has('type')) {
                    url.searchParams.set('type', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('type', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            })


            //clickable row
            let rows = document.querySelectorAll('.clickable-row');
            rows.forEach(row => {
                row.addEventListener('click', () => {
                    window.location.href = row.dataset.href;
                });
            });
        });
        if ('{{ Session::get("success");}}') {
            Toastify({
                text: '{{ Session::get("success");}}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }else if('{{ Session::get("error");}}'){
            Toastify({
                text: '{{ Session::get("error");}}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {} // Callback after click
            }).showToast();
        }
    </script>
@endpush
@push('css')
    <style>
        .padding-counseling-list {
            padding-bottom: 1%;
        }
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
@endpush
