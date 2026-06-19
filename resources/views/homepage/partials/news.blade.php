<div id="event-web" class="hidden md:block">
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex justify-between">
            <span class="text-[#201F36] dark:text-white text-2xl font-semibold">{{ __('general.Event') }}</span>
            <span class="">
            <a href="{{ route('get-public-event') }}"
               class="flex gap-2 text-primary dark:text-white items-center hover:text-blue-600">{{trans('system.action.view_more')}}
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </a>
        </span>
        </div>
        {{--    <div class="grid md:grid-cols-2 sm:grid-cols-1 gap-6"> --}}
{{--        <div class="grid grid-rows-1 md:grid-cols-2 grid-flow-col gap-6 grid-rows-subgrid">--}}
{{--            @forelse($events as $key => $event)--}}
{{--                @if ($key == 0)--}}
{{--                    <div--}}
{{--                        class="row-span-3 flex flex-col gap-6 border-1 border-[#F8F8F8] p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark justify-between">--}}
{{--                        <div class="flex flex-col md:gap-4 lg:gap-6 h-fit">--}}
{{--                            <div class="w-full h-64 rounded-xl relative">--}}
{{--                                <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-sm rounded m-2">{{getCodeNameByCodeId('event_type', $event->event_type)}}</label>--}}
{{--                                @if (file_exists($event->thumbnail))--}}
{{--                                    <img loading="lazy" src="{{ $event->thumbnail }}" class="w-full h-full rounded-xl object-cover" alt="Event thumbnail">--}}
{{--                                @else--}}
{{--                                    <img loading="lazy" src="{{ asset('images/post.png') }}" class="w-full h-full rounded-xl" alt="Event thumbnail">--}}
{{--                                @endif--}}
{{--                            </div>--}}
{{--                            <div class="flex flex-col gap-3 w-full">--}}
{{--                                <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"--}}
{{--                                   class="text-[#464559] dark:text-white text-3xl font-semibold">{{ \Str::limit($event->title, 80) }}</a>--}}
{{--                                <div class="flex justify-between ">--}}
{{--                                    <span class="text-sm flex items-center gap-1 text-[#464559] break-words dark:text-white"><svg--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                            stroke-width="1.5" stroke="currentColor" class="size-4">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />--}}
{{--                                        </svg> {{ date('Y-m-d', strtotime($event->created_at)) }}</span>--}}
{{--                                    <span class="text-sm gap-1 flex items-center text-[#464559] break-words dark:text-white"><svg--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                            stroke-width="1.5" stroke="currentColor" class="size-4">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />--}}
{{--                                        </svg>--}}
{{--                                        {{ \Str::limit($event->author->fullName, 20) }}</span>--}}
{{--                                </div>--}}
{{--                                <p class="text-[#91919A] dark:text-white break-words">--}}
{{--                                    {!! strip_tags(substr($event->details, 0, 200)) !!}--}}
{{--                                </p>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <div class="flex justify-end">--}}
{{--                            <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"--}}
{{--                               class="text-primary underline text-xl">{{ trans('system.read_more') }}</a>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @else--}}
{{--                    <div--}}
{{--                        class="row-span-1 h-fit flex gap-4 border-1 border-[#F8F8F8] p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark">--}}
{{--                        <div class="w-52 h-28 rounded-xl relative">--}}
{{--                            <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-xs rounded m-1">{{getCodeNameByCodeId('event_type', $event->event_type)}}</label>--}}
{{--                            @if (file_exists($event->thumbnail))--}}
{{--                                <img loading="lazy" src="{{ $event->thumbnail }}" class="w-full h-full rounded-xl object-cover" alt="">--}}
{{--                            @else--}}
{{--                                <img loading="lazy" src="{{ asset('images/post.png') }}" class="w-full h-full rounded-xl object-cover" alt="">--}}
{{--                            @endif--}}
{{--                        </div>--}}

{{--                        <div class="flex flex-col gap-3 w-full justify-between">--}}
{{--                            <div class="flex flex-col gap-3">--}}
{{--                                <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"--}}
{{--                                   class="text-[#464559] dark:text-white text-xl font-semibold">{{ \Str::limit($event->title, 50) }}</a>--}}
{{--                                <div class="flex justify-between">--}}
{{--                                    <span class="text-xs flex items-center gap-1 text-[#464559] break-words dark:text-white text-nowrap"><svg--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                            stroke-width="1.5" stroke="currentColor" class="size-3">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />--}}
{{--                                        </svg> {{ date('Y-m-d', strtotime($event->created_at)) }}</span>--}}
{{--                                    <span class="text-xs flex items-center text-[#464559] break-words dark:text-white"><svg--}}
{{--                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
{{--                                            stroke-width="1.5" stroke="currentColor" class="size-3">--}}
{{--                                            <path stroke-linecap="round" stroke-linejoin="round"--}}
{{--                                                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />--}}
{{--                                        </svg>--}}
{{--                                        {{ \Str::limit($event->author->fullName, 20) }}</span>--}}
{{--                                </div>--}}
{{--                                <p class="text-[#91919A] dark:text-white text-sm break-words">--}}
{{--                                    {!! strip_tags(substr($event->details, 0, 20)) !!}{{ strlen(strip_tags($event->details)) > 20 ? '...' : '' }}--}}
{{--                                </p>--}}
{{--                            </div>--}}

{{--                            <div class="flex justify-end">--}}
{{--                                <a href="{{ route('informations.events.detail', ['slug' => $event->slug]) }}"--}}
{{--                                   class="text-primary underline text-sm">{{ trans('system.read_more') }}</a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--            @empty--}}
{{--                <p class="dark:text-white">{{ __('general.There is no event') }}</p>--}}
{{--            @endforelse--}}
{{--        </div>--}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @if($mainEvent != null)
            <div
                class="flex flex-col gap-6 border-1 border-[#F8F8F8] p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark justify-between">
                <div class="flex flex-col md:gap-4 lg:gap-6 h-fit">
                    <div class="w-full h-64 rounded-xl relative">
                        <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-sm rounded m-2">{{getCodeNameByCodeId('event_type', $mainEvent->event_type)}}</label>
                        @if (file_exists($mainEvent->thumbnail))
                            <img loading="lazy" src="{{ $mainEvent->thumbnail }}" class="w-full h-full rounded-xl object-cover" alt="Event thumbnail">
                        @else
                            <img loading="lazy" src="{{ asset('images/post.png') }}" class="w-full h-full rounded-xl" alt="Event thumbnail">
                        @endif
                    </div>
                    <div class="flex flex-col gap-3 w-full">
                        <a href="{{ route('informations.events.detail', ['slug' => $mainEvent->slug]) }}"
                           class="text-[#464559] dark:text-white text-3xl font-semibold hover:text-blue-600">{{ \Str::limit($mainEvent->title, 80) }}</a>
                        <div class="flex justify-between ">
                            <span class="text-sm flex items-center gap-1 text-[#464559] break-words dark:text-white text-primary"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                </svg> {{ date('Y-m-d', strtotime($mainEvent->created_at)) }}</span>
                            <span class="text-sm gap-1 flex items-center text-primary break-words dark:text-white"><svg
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                {{ \Str::limit($mainEvent->author->fullName, 20) }}</span>
                        </div>
                        <p class="text-[#91919A] dark:text-white break-words">
                            {!! strip_tags(substr($mainEvent->details, 0, 200)) !!}
                        </p>
                    </div>

                </div>
                <div class="flex justify-end">
                    <a href="{{ route('informations.events.detail', ['slug' => $mainEvent->slug]) }}"
                       class="text-primary underline text-xl">{{ trans('system.read_more') }}</a>
                </div>
            </div>
            @endif
            @if(count($newestEvents) > 0)
            <div class="flex flex-col gap-4 ">
                @forelse($newestEvents as $newestEvent)
                    <div
                        class="h-fit flex gap-4 border-1 border-[#F8F8F8] p-4 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark">
                        <div class="w-52 h-28 rounded-xl relative">
                            <label for="" class="bg-primary opacity-57 p-1 text-white absolute right-1 top-1 text-xs rounded m-1">{{getCodeNameByCodeId('event_type', $newestEvent->event_type)}}</label>
                            @if (file_exists($newestEvent->thumbnail))
                                <img loading="lazy" src="{{ $newestEvent->thumbnail }}" class="w-full h-full rounded-xl object-cover" alt="">
                            @else
                                <img loading="lazy" src="{{ asset('images/post.png') }}" class="w-full h-full rounded-xl object-cover" alt="">
                            @endif
                        </div>

                        <div class="flex flex-col gap-3 w-full justify-between">
                            <div class="flex flex-col gap-3">
                                <a href="{{ route('informations.events.detail', ['slug' => $newestEvent->slug]) }}"
                                   class="text-[#464559] dark:text-white text-xl font-semibold hover:text-blue-600">{{ \Str::limit($newestEvent->title, 50) }}</a>
                                <div class="flex justify-between">
                                    <span class="text-xs flex items-center gap-1 text-[#464559] break-words dark:text-white text-nowrap text-primary"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg> {{ date('Y-m-d', strtotime($newestEvent->created_at)) }}</span>
                                    <span class="text-xs flex items-center text-primary break-words dark:text-white"><svg
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-3">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>
                                        {{ \Str::limit($newestEvent->author->fullName, 20) }}</span>
                                </div>
                                <p class="text-[#91919A] dark:text-white text-sm break-words">
                                    {!! strip_tags(substr($newestEvent->details, 0, 20)) !!}{{ strlen(strip_tags($newestEvent->details)) > 20 ? '...' : '' }}
                                </p>
                            </div>

                            <div class="flex justify-end">
                                <a href="{{ route('informations.events.detail', ['slug' => $newestEvent->slug]) }}"
                                   class="text-primary underline text-sm">{{ trans('system.read_more') }}</a>
                            </div>
                        </div>
                    </div>
                @empty
                @endforelse
            </div>
                @endif
        </div>
    </div>
</div>
<div id="event-mobile" class="block md:hidden">
    <div class="flex flex-col gap-3 xl:mt-32 mb-4">
        <div class="flex justify-between">
            <span class="text-[#464559] text-lg font-semibold dark:text-white">{{ __('general.Event') }}</span>
            <span class="">
            <a href="{{ route('get-public-event') }}" class="flex gap-2 text-primary text-sm items-center dark:text-white hover:text-blue-600">{{trans('system.action.view_more')}}
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                      <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </span>
            </a>
        </span>
        </div>
        <div class="glide w-full bg-white dark:bg-[#1E1E1E] rounded-md">
            <div class="glide__track rounded-xl p-4" data-glide-el="track">
                <ul class="glide__slides bg-white dark:bg-[#1E1E1E] rounded-md flex items-center">
                    @php
                        $events = collect();

                        if ($mainEvent) {
                            $events->push($mainEvent);
                        }

                        $events = $events->merge($newestEvents);
                    @endphp
                    @forelse($events as $event)
                        <li class="glide__slide dark:border dark:border-white rounded-xl">
                            <div class="flex flex-col border border-[#F8F8F8] bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark dark:border-0">
                                @if (file_exists($event->thumbnail))
                                    <img loading="lazy" src="{{ $event->thumbnail }}" class="w-full rounded-t-xl h-36 object-cover" alt="Event thumbnail">
                                @else
                                    <img loading="lazy" src="{{  asset('images/post.png') }}" class="w-full rounded-t-xl h-36  object-cover" alt="Event thumbnail">
                                @endif
                                <div class="flex flex-col gap-1 p-2">
                                    <div class="flex flex-col gap-2">
                                        <a href="#" class="text-[#464559] text-base font-semibold dark:text-white">{!! Str::limit($event->title, 20, ' ...') !!}</a>
                                        <p class="text-[#91919A] text-sm dark:text-white break-words">
                                            {!! strip_tags(substr($event->details,0, 30)) !!}
                                        </p>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-xs flex items-center gap-1 text-primary break-words text-nowrap">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ date('Y-m-d', strtotime($event->created_at)) }}
                                        </span>
                                        <span class="text-xs flex items-center text-primary break-words max-w-full">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke-width="1.5" stroke="currentColor" class="size-3">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                            </svg>
                                            <span class="">
                                                {{ $event->author->fullName }}
                                            </span>
                                        </span>
                                    </div>
                                    <div class="flex justify-end">
                                        <a href="{{route('informations.events.detail', ['slug' => $event->slug])}}" class="text-primary underline text-sm">{{ trans('system.read_more') }}</a>
                                    </div>
                                </div>

                            </div>
                        </li>
                    @empty
                        <p class="dark:text-white">{{ __('There is no event') }}</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
