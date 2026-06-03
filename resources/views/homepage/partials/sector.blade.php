<div id="sector-web" class="hidden md:block">
    <div class="flex flex-col gap-6 @if(!auth()->guard('schoolkid')->check()) md:mt-48 @endif">
        <div class="flex justify-between">
            <span class="text-[#201F36] dark:text-white text-2xl font-semibold">{{ __('general.Our sector') }}</span>
        </div>
        <div class="grid md:grid-cols-4 sm:grid-cols-2 gap-6">
            @forelse($sectors as $key => $sector)
                <div class=" flex flex-col gap-6 shadow-custom-light dark:shadow-custom-dark p-4 rounded-xl bg-white border-1 border-[#F8F8F8] dark:bg-[#1E1E1E]">
                    <a href="{{$sector['url']}}" class="flex justify-center">
                        <img src="{{$sector['thumbnail']}}" class="object-cover rounded-xl h-48" @if($key == 0) loading="eager" @else loading="lazy" @endif alt="{{ $sector['name'] ?? 'Sector thumbnail' }}">
                    </a>
                    <div class="flex flex-col gap-2" data-tooltip-target="tooltip-{{$key}}" data-tooltip-style="light">
                        <a href="{{$sector['url']}}" class="text-primary dark:text-white text-xl font-semibold hover:text-blue-600">{{\Str::limit($sector['name'], 20)}}</a>
                        {{--                        <p class="text-[#91919A] dark:text-white">{{\Str::limit($sector['short_description'], 60)}} </p>--}}
                    </div>
                    {{-- id="tooltip-{{$key}}" --}}
                    <div  role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip w-64">
                        <p class="text-primary dark:text-white text-xl font-semibold">{{$sector['name']}}</p>
                        {{--                        <p class="text-[#91919A] dark:text-white">{{$sector['short_description']}} </p>--}}
                        <div class="tooltip-arrow" data-popper-arrow></div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>
</div>
<div id="sector-mobile" class="block md:hidden">
    <div class="flex flex-col gap-6 xl:mt-32">
        <div class="flex justify-between">
            <span class="text-[#464559] text-lg font-semibold dark:text-white">{{ __('general.Our sector') }}</span>
        </div>
        <div class="glide w-full bg-white dark:bg-[#1E1E1E] rounded-md">
            <div class="glide__track" data-glide-el="track">
                <ul class="glide__slides bg-white dark:bg-[#1E1E1E] rounded-md flex items-center">
                    @forelse($sectors as $key => $sector)
                        <li class="glide__slide h-full">
                            <div class="flex flex-col gap-3  p-2 rounded-xl bg-white dark:bg-[#1E1E1E] border border-[#F8F8F8] dark:border-0">
                                <a href="{{$sector['url']}}" class="flex justify-center"><img @if($key == 0) loading="eager" @else loading="lazy" @endif src="{{$sector['thumbnail_mobile']}}" class="object-cover rounded-xl h-36 w-full" alt="{{ $sector['name'] ?? 'Sector thumbnail' }}"></a>
                                <div class="flex flex-col gap-2" data-tooltip-target="tooltip-{{$key}}" data-tooltip-style="light">
                                    <a href="{{$sector['url']}}" class="text-primary dark:text-white font-semibold">{{\Str::limit($sector['name'],20)}}</a>
                                    {{--                                <p class="text-sm text-[#91919A] dark:text-white h-9">{{\Str::limit($sector['short_description'],30)}} </p>--}}
                                </div>
                                <div id="tooltip-{{$key}}" role="tooltip" class="absolute z-10 invisible inline-block px-3 py-2 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg shadow-sm opacity-0 tooltip">
                                    <p class="text-primary dark:text-white font-semibold">{{$sector['name']}}</p>
                                    {{--                                <p class="text-sm text-[#91919A] dark:text-white">{{\Str::limit($sector['short_description'],30)}} </p>--}}
                                    <div class="tooltip-arrow" data-popper-arrow></div>
                                </div>
                            </div>
                        </li>
                    @empty
                        <p>There is no sector</p>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>

