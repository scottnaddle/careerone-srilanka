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
        .truncate-multiline {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            line-height: 1.5rem;
            max-height: 3rem;
        }
    </style>
@endpush
@section('content')
    <div class="py-4 md:py-6">
        <x-breadcrumb :items="[
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.information.root'), 'url' => '#'],
            ['label' => trans('system.information.event.public_event_list'), 'url' => ''],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-7 mb-10">
        <div class="flex gap-4 justify-center flex-col items-center">

            <form action="{{ route('get-public-event') }}" method="GET"
                class="mx-auto flex gap-4 justify-center items-center w-full">
                <div class="relative w-full">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                        </svg>
                    </div>
                    <input type="search" id="default-search" name="title" placeholder="{{ __('general.Event Title') }}"
                        value="{{ request()->query('title') }}"
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
            <div class="flex justify-between w-full">
                <div class="flex items-center whitespace-nowrap">
                    @if ((request()->has('title') && request()->query('title') != '') || request()->has('event_type') && request()->query('event_type') != 'all')
                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">
                            {{ trans('system.results', ['a' => $events->total()]) }}</p>
                    @else
                        <p></p>
                    @endif
                </div>
                <div class="flex flex-col md:flex-row w-full gap-4 items-end justify-end">
                    <select id="event_type" name="event_type"
                            class="w-fit md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="all">{{trans('system.information.event.type.title')}}</option>

                        @foreach (getCodeList('event_type') as $event_type)
                            <option value="{{ $event_type->code_id }}" @selected(request()->input('event_type') == $event_type->code_id)>
                                {{ $event_type->code_name }}</option>
                        @endforeach
                    </select>
                    <select id="sort_by" name="sort_by"
                            class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 w-fit">
                        <option value="recently" @selected(request()->input('sort_by') == 'recently')>{{trans('system.filter.recently')}}</option>
                        <option value="oldest" @selected(request()->input('sort_by') == 'oldest')>{{trans('system.filter.oldest')}}</option>
                    </select>
                </div>
            </div>

        </div>
        <div class="flex flex-col gap-4">
            @if (session()->has('success'))
                <div
                    class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
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

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6">
                @forelse($events as $event)
                    <div
                        class=" flex flex-col gap-2 md:gap-4 border border-[#F8F8F8] md:p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark dark:border-white">
                        <div class="h-48 items-center flex justify-center relative">
                            <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-xs rounded">{{getCodeNameByCodeId('event_type', $event->event_type)}}</label>

                            <img src="{{ asset( $event->thumbnail) }}" class="rounded-t-xl object-cover h-full lg:h-48 w-full" alt="">

                        </div>
                        <div class="flex flex-col gap-2 md:gap-3 w-full justify-between h-full px-2">
                            <div class="flex flex-col gap-2 md:gap-3">
                                <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"
                                    class="text-[#464559] dark:text-white text-xl font-semibold hover:text-primary dark:hover:text-primary truncate-multiline">
                                     {{ \Str::limit($event->title, 50) }}
                                 </a>
                                <div class="flex justify-between">
                                    <span class="text-xs flex items-center gap-1 text-primary break-words"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg> {{ date('Y-m-d', strtotime($event->created_at)) }}</span>
                                    <span class="text-xs flex items-center text-primary break-words"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        {{ \Str::limit($event->author->fullName, 10) }}</span>
                                </div>
                                <p class="text-[#91919A] dark:text-white text-sm gap-1 break-words">
                                    {!! substr(strip_tags($event->details), 0, 120) !!}{{ strlen(strip_tags($event->details)) > 120 ? '...' : '' }}
                                </p>
                            </div>
                            <div class="flex justify-end mr-1 mb-1">
                                <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"
                                    class="text-primary underline text-sm">{{ trans('system.action.view_more') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full flex flex-col gap-4 justify-center items-center p-8">
                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                        <p class="dark:text-white">{{ __('system.messages.no_items') }}</p>
                    </div>
                @endforelse
            </div>
            <div class="mt-3">
                {{ $events->onEachSide(1)->links() }}
            </div>

        </div>
    </div>

@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <script>
        let url = new URL(window.location.href);
        $('#event_type').on('change', function() {
            if (url.searchParams.has('event_type')) {
                url.searchParams.set('event_type', this.value);
                url.searchParams.delete('page');
            } else {url.searchParams.append('event_type', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
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
