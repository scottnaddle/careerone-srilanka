{{--<nav class="flex" aria-label="Breadcrumb">--}}
{{--    <ol class="inline-flex items-center space-x-1 md:space-x-1">--}}
{{--        @foreach ($items as $item)--}}
{{--            @if ($loop->last)--}}
{{--                <li class="inline-flex items-center">--}}
{{--                    <span--}}
{{--                        class="font-medium text-gray-500 text-[#464559] font-semibold text-lg dark:text-white">--}}
{{--                        {{ $item['label'] }}--}}
{{--                    </span>--}}
{{--                </li>--}}
{{--            @elseif($item['url'] === '#')--}}
{{--                <li class="inline-flex items-center dark:text-white">--}}
{{--                    <span--}}
{{--                        class="inline-flex items-center font-medium text-gray-700 hover:text-gray-900 font-semibold text-lg dark:text-white">--}}
{{--                        {{ $item['label'] }}--}}
{{--                    </span>--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                         stroke="currentColor" class="size-5">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />--}}
{{--                    </svg>--}}
{{--                </li>--}}
{{--            @else--}}
{{--                <li class="inline-flex items-center dark:text-white">--}}
{{--                    <a href="{{ $item['url'] }}"--}}
{{--                        class="inline-flex items-center font-medium text-gray-700 hover:text-gray-900 font-semibold text-lg dark:text-white">--}}
{{--                        {{ $item['label'] }}--}}
{{--                    </a>--}}
{{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"--}}
{{--                        stroke="currentColor" class="size-5">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />--}}
{{--                    </svg>--}}
{{--                </li>--}}
{{--            @endif--}}
{{--        @endforeach--}}
{{--    </ol>--}}
{{--</nav>--}}
<nav class="flex w-full overflow-hidden" aria-label="Breadcrumb">
    <ol class="inline-flex items-center space-x-1 md:space-x-1 w-full">
        @foreach ($items as $item)
            @if ($loop->last)
                <!-- Item cuối -->
                <li class="flex items-center flex-shrink-0 max-w-[150px] md:max-w-[250px] lg:max-w-[350px]">
                    <h1 class="font-medium text-gray-500 text-[#464559] font-semibold text-lg dark:text-white truncate">
                        {{ $item['label'] }}
                    </h1>
                </li>
            @elseif($item['url'] === '#')
                <!-- Item giữa không có link -->
                <li class="flex items-center flex-shrink-0 max-w-[80px] md:max-w-[250px] lg:max-w-[350px] dark:text-white">
                    <span class="flex-1 truncate font-medium text-gray-700 hover:text-gray-900 font-semibold text-lg dark:text-white">
                        {{ $item['label'] }}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5 flex-shrink-0 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </li>
            @else
                <!-- Item giữa có link -->
                <li class="flex items-center flex-shrink-0 max-w-[80px] md:max-w-[250px] lg:max-w-[350px] dark:text-white">
                    <a href="{{ $item['url'] }}"
                       class="flex-1 truncate font-medium text-gray-700 hover:text-gray-900 font-semibold text-lg dark:text-white">
                        {{ $item['label'] }}
                    </a>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                         stroke="currentColor" class="size-5 flex-shrink-0 ml-1">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                    </svg>
                </li>
            @endif
        @endforeach
    </ol>
</nav>



