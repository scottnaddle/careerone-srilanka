@extends('homepage.layouts.master')
@section('title', 'Event')
@push('css')
    <style>
        .title-column {
            width: 1%;
            white-space: nowrap;
        }

        .disabled-button {
            pointer-events: none;
        }


        a[disabled="disabled"] {
            pointer-events: none;
        }
    </style>
@endpush
@section('content')
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.information.root'), 'url' => '#'],
            ['label' => trans('system.information.event.title'), 'url' => ''],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-7 mb-10">
        <div class="flex gap-4 justify-center items-center">

            <form action="{{ route('informations.events.event') }}" method="GET"
                class="mx-auto flex gap-4 justify-center items-center w-full">

                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="title" value="{{ request()->query('title') }}" placeholder="{{ __('general.Event Title') }}"
                        class="block w-full p-3 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
                {{-- <input type="hidden" id="dropdown-value" name="searchType"> --}}

                <div>
                    <button type="submit"
                        class="w-fit text-white bg-[#4984F6] hover:bg-blue-800 text-base focus:ring-4 focus:ring-blue-300 font-medium rounded-full
                     px-15 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{ trans('system.form.button.search') }}
                    </button>
                </div>
            </form>

        </div>
        <div class="flex flex-col gap-4">
            @if (session()->has('success'))
                <div
                    class="alert alert-success text-green-600 dark:text-black font-semibold bg-green-200 px-4 py-2 rounded-xl">
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
            <div class="flex justify-between items-center">
                @if ((request()->has('title') && request()->query('title') != '') || request()->has('type') && request()->query('type') != 'all' || request()->has('status') && request()->query('status') != 'all')
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white whitespace-nowrap">
                        {{ trans('system.results', ['a' => $events->total()]) }}</p>
                @else
                    <p></p>
                @endif
                <div class="flex flex-wrap md:flex-row w-full gap-4 items-end justify-end">
                    <select id="eventType" name="type"
                            class="w-fit md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="all">{{trans('system.information.event.type.title')}}</option>

                        @foreach (getCodeList('event_type') as $event_type)
                            <option value="{{ $event_type->code_id }}" @selected(request()->input('type') == $event_type->code_id)>
                                {{ $event_type->code_name }}</option>
                        @endforeach
                    </select>
                    <select id="status" name="status" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ trans('system.filter.status.title') }}</option>

                        @foreach (\App\Enums\StatusEnumsManagement::cases() as $statusEnum)
                            <option value="{{ $statusEnum->value }}" {{ $status == $statusEnum->value ? 'selected' : '' }}>
                                {{ \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value) }}
                            </option>
                        @endforeach
                    </select>
                    <select id="sort_by" name="sort_by"
                            class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                        <option value="recently" @selected(request()->input('sort_by') == 'recently')>{{trans('system.filter.recently')}}</option>
                        <option value="oldest" @selected(request()->input('sort_by') == 'oldest')>{{trans('system.filter.oldest')}}</option>
                    </select>

                </div>
            </div>
            @if (activeGuard() != 'trainee' && Auth::guard(activeGuard())->check())
                <a href="{{ route('informations.events.create') }}"
                    class="inline-flex w-fit items-center text-xs leading-4 justify-center font-medium px-4 py-2.5 text-white rounded-full cursor-pointer bg-primary">
                    {{ trans('system.information.event.new_event') }} <svg class="w-4 h-4 text-white dark:text-white ms-2"
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                        viewBox="0 0 24 24">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5 12h14m-7 7V5" />
                    </svg>

                </a>
            @endif

            <div class="relative overflow-x-auto">
                <table class="w-full text-left rtl:text-right table-auto">
                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ trans('system.table.heading.no') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ trans('system.table.heading.type') }}
                            </th>
                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ trans('system.table.heading.title') }}
                            </th>

                            <th scope="col"
                                class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                {{ trans('system.table.heading.registration_date') }}
                            </th>
                            @if (activeGuard() != 'trainee' && Auth::guard(activeGuard())->check())
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.status') }}
                                </th>
                            @endif
                            @if (activeGuard() != 'trainee' && Auth::guard(activeGuard())->check())
                                <th scope="col"
                                    class="px-4 py-3 text-primary dark:text-white font-semibold text-base whitespace-nowrap">
                                    {{ trans('system.table.heading.action') }}
                                </th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($events as $index => $item)
                            <tr
                                class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center  hover:bg-blue-100 dark:hover:bg-gray-700">
                                <td class="px-4 py-6 font-medium text-sm text-[#464559] dark:text-white">
                                    {{ $events->firstItem() + $index }}
                                </td>
                                <td class="px-4 py-6 font-medium text-sm text-[#464559] dark:text-white">
                                    {{ getCodeNameByCodeId('event_type',$item->event_type) }}
                                </td>


                                <td class="px-3 py-4 text-sm font-semibold text-[#201F36] dark:text-white text-left w-auto whitespace-nowrap">
                                    @php
                                        $isOwner =
                                            Auth::guard(activeGuard())->check() &&
                                            Auth::guard(activeGuard())->user()->id == $item->created_by &&
                                            activeGuard() == $item->system;

                                        $isGuest = (!Auth::guard(activeGuard())->check() || activeGuard() == 'trainee');
                                    @endphp
                                    <a href="{{ route('informations.events.detail', ['slug' => $item->slug]) }}"
                                        class="dark:text-white hover:text-primary dark:hover:text-primary" data-tooltip-target="full-text-{{$item->id}}" data-tooltip-style="light">
                                        {!! Str::limit($item->title, 40, '...') !!}
                                    </a>
                                    <div id="full-text-{{$item->id}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                        {{$item->title}}
                                        <div class="tooltip-arrow" data-popper-arrow></div>
                                    </div>
                                </td>

                                <td class="px-4 py-6 font-medium text-sm text-[#464559] dark:text-white">
                                    {{ date("Y-m-d", strtotime($item->created_at)) }}
                                </td>
                                @if (activeGuard() != 'trainee' && Auth::guard(activeGuard())->check())
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white whitespace-nowrap">
                                        @if ($item->status == \App\Enums\StatusEnumsManagement::PENDING_APPROVAL->value)
                                            <label
                                                class="bg-gray-100 text-gray-800 text-sm font-semibold px-2.5 py-0.5 rounded dark:bg-[#282828] dark:text-white whitespace-nowrap">{{ \App\Enums\StatusEnumsManagement::getStatusName($item->status) }}</label>
                                        @endif

                                        @if ($item->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value)
                                            <label
                                                class=" text-red-600 text-sm dark:bg-[#282828] font-semibold px-2.5 py-0.5 rounded ">{{ \App\Enums\StatusEnumsManagement::getStatusName($item->status) }}</label>
                                        @endif
                                        @if ($item->status == \App\Enums\StatusEnumsManagement::APPROVED->value)
                                            <label
                                                class="bg-[#F2F9FF] text-primary text-sm font-semibold px-2.5 py-0.5 rounded dark:bg-[#282828] dark:text-blue-300">{{ \App\Enums\StatusEnumsManagement::getStatusName($item->status) }}</label>
                                        @endif

                                    </td>
                                @endif
                                @if (activeGuard() != 'trainee' && Auth::guard(activeGuard())->check())
                                    <td class="px-4 py-6 text-sm text-[#201F36] dark:text-white">
                                        <div class="flex gap-3 justify-center">
                                            {{-- <button data-modal-target="popup-modal" data-modal-toggle="popup-modal"
                                            class="block text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
                                            type="button">
                                            Toggle modal
                                        </button> --}}
                                            @php
                                                $isOwner =
                                                    Auth::guard(activeGuard())->user()->id == $item->created_by &&
                                                    activeGuard() == $item->system;
                                            @endphp
                                            @if ($isOwner && $item->status != 2)
                                                <a title="Edit" href="{{ route('informations.events.edit', ['event' => $item->id]) }}"
                                                    class=""><svg width="22" height="22" viewBox="0 0 22 22"
                                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17 9.5003L13 5.5003M1.5 21.0003L4.88437 20.6243C5.29786 20.5783 5.5046 20.5553 5.69785 20.4928C5.86929 20.4373 6.03245 20.3589 6.18289 20.2597C6.35245 20.1479 6.49955 20.0008 6.79373 19.7066L20 6.5003C21.1046 5.39573 21.1046 3.60487 20 2.5003C18.8955 1.39573 17.1046 1.39573 16 2.5003L2.79373 15.7066C2.49955 16.0008 2.35246 16.1478 2.24064 16.3174C2.14143 16.4679 2.06301 16.631 2.00751 16.8025C1.94496 16.9957 1.92198 17.2024 1.87604 17.6159L1.5 21.0003Z"
                                                            stroke="#4984F6" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </a>
                                                <button title="Delete" type="button" data-modal-target="delete-modal"
                                                        data-id="{{ $item->id }}" data-modal-toggle="delete-modal"
                                                        class="btn-delete">
                                                    <svg width="20" height="23" viewBox="0 0 20 23" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14 5.5V4.7C14 3.5799 14 3.01984 13.782 2.59202C13.5903 2.21569 13.2843 1.90973 12.908 1.71799C12.4802 1.5 11.9201 1.5 10.8 1.5H9.2C8.07989 1.5 7.51984 1.5 7.09202 1.71799C6.71569 1.90973 6.40973 2.21569 6.21799 2.59202C6 3.01984 6 3.5799 6 4.7V5.5M8 11V16M12 11V16M1 5.5H19M17 5.5V16.7C17 18.3802 17 19.2202 16.673 19.862C16.3854 20.4265 15.9265 20.8854 15.362 21.173C14.7202 21.5 13.8802 21.5 12.2 21.5H7.8C6.11984 21.5 5.27976 21.5 4.63803 21.173C4.07354 20.8854 3.6146 20.4265 3.32698 19.862C3 19.2202 3 18.3802 3 16.7V5.5"
                                                            stroke="#F34550" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            @else
                                            <div class="relative group">
                                                <svg title="Edit" width="22" height="22" viewBox="0 0 22 22"
                                                    class="cursor-not-allowed" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M17 9.5003L13 5.5003M1.5 21.0003L4.88437 20.6243C5.29786 20.5783 5.5046 20.5553 5.69785 20.4928C5.86929 20.4373 6.03245 20.3589 6.18289 20.2597C6.35245 20.1479 6.49955 20.0008 6.79373 19.7066L20 6.5003C21.1046 5.39573 21.1046 3.60487 20 2.5003C18.8955 1.39573 17.1046 1.39573 16 2.5003L2.79373 15.7066C2.49955 16.0008 2.35246 16.1478 2.24064 16.3174C2.14143 16.4679 2.06301 16.631 2.00751 16.8025C1.94496 16.9957 1.92198 17.2024 1.87604 17.6159L1.5 21.0003Z"
                                                        stroke="#91919A" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="absolute left-1/2 -translate-x-1/2 bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                   Edit
                                                </span>
                                            </div>
                                            <div class="relative group">
                                                <svg title="Delete" width="20" height="23" viewBox="0 0 20 23"
                                                    class="cursor-not-allowed" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M14 5.5V4.7C14 3.5799 14 3.01984 13.782 2.59202C13.5903 2.21569 13.2843 1.90973 12.908 1.71799C12.4802 1.5 11.9201 1.5 10.8 1.5H9.2C8.07989 1.5 7.51984 1.5 7.09202 1.71799C6.71569 1.90973 6.40973 2.21569 6.21799 2.59202C6 3.01984 6 3.5799 6 4.7V5.5M8 11V16M12 11V16M1 5.5H19M17 5.5V16.7C17 18.3802 17 19.2202 16.673 19.862C16.3854 20.4265 15.9265 20.8854 15.362 21.173C14.7202 21.5 13.8802 21.5 12.2 21.5H7.8C6.11984 21.5 5.27976 21.5 4.63803 21.173C4.07354 20.8854 3.6146 20.4265 3.32698 19.862C3 19.2202 3 18.3802 3 16.7V5.5"
                                                        stroke="#91919A" stroke-width="2" stroke-linecap="round"
                                                        stroke-linejoin="round" />
                                                </svg>
                                                <span class="absolute left-1/2 -translate-x-1/2 bottom-8 px-2 py-1 text-xs text-white bg-gray-800 rounded-md opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                                   Delete
                                                </span>
                                            </div>

                                            @endif

                                        </div>
                                    </td>
                                @endif
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="6">
                                        <div class="flex flex-col gap-4 justify-center items-center p-4">
                                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">
                                            <p class="dark:text-white">No record!</p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse

                    </tbody>

                </table>

                <div class="mt-3">
                    {{ $events->onEachSide(1)->links() }}
                </div>
                <div id="delete-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div
                            class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between pb-4 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                                    {{ trans('system.delete_modal.title') }}
                                </h3>
                                <button type="button"
                                    class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="delete-modal">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                    </svg>
                                    <span class="sr-only">Close modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="flex flex-col gap-4">
                                <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200"
                                    aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">
                                    {{ trans('system.delete_modal.content') }}</h3>
                                <div class="flex justify-center gap-4">
                                    <a href=""
                                        class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                        {{ trans('system.delete_modal.yes') }}
                                    </a>
                                    <button data-modal-hide="delete-modal" type="button"
                                        class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{ trans('system.delete_modal.no') }}</button>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

@endsection
@push('js')
    <script>
        $(".btn-delete").click(function() {
            $("#delete-modal a").attr('href', '');
            $("#delete-modal a").attr('href', '/informations/events/delete/' + $(this).data(
                'id'));
        });

        let url = new URL(window.location.href);
        $('#eventType').on('change', function() {
            if (url.searchParams.has('type')) {
                url.searchParams.set('type', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('type', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        })
        $('#status').on('change', function() {
            if (url.searchParams.has('status')) {
                url.searchParams.set('status', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('status', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        })

        $('select[name=sort_by]').on('change', function() {
            if (url.searchParams.has('sort_by')) {
                url.searchParams.set('sort_by', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('sort_by', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
    </script>
@endpush
