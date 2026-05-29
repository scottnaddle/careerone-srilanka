<div class="flex flex-col gap-4">
    <p class="text-xl font-semibold text-[#464559] dark:text-white break-words">{{$content->title}} <span class="text-sm px-2.5 py-1 rounded shadow-xs text-white bg-primary h-fit whitespace-nowrap">
                    {{ $content->category?->name }}
                </span></p>
    <div class="flex justify-between items-center">
        <div class="flex gap-4">
            <p class="text-xs font-semibold text-primary flex gap-1 justify-center items-center dark:text-white">
                            <span><svg width="16" height="16" viewBox="0 0 17 16" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                        stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                        stroke-linejoin="round" />
                                </svg>
                            </span>{{ date("Y-m-d", strtotime($content->created_at)) }}
            </p>

            <p class="text-xs font-semibold text-primary flex gap-1 justify-center items-center  dark:text-white">
                            <span><svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                                       xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                    stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                    stroke-linejoin="round" />
                            </svg>
                            </span>{{ $content->getAuthor($content->system, $content->created_by)->fullName ??'No Name' }}
            </p>
        </div>
        <div class="flex gap-4 items-center text-primary">
                        <span class="flex items-center gap-1 text-xs justify-end dark:text-white text-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                            </svg>
                            <span>{{$content->views}}</span>
                        </span>
            <button class="flex items-center gap-1 text-xs justify-end dark:text-white text-primary like" data-id="{{ $content->id }}" data-type="{{$type}}">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                   2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                                   C13.09 3.81 14.76 3 16.5 3
                                   19.58 3 22 5.42 22 8.5
                                   c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                            </svg>
                            <span class="like-count">{{$content->likes}}</span>
                        </button>
        </div>
    </div>
    <div class="flex flex-col gap-4">
        @if($content->content_type == 'video')
            <iframe
                id="yt-iframe-{{ $content->id }}"
                class="w-full h-96 rounded-xl youtube-iframe"
                src="{{ getYoutubeEmbedUrl($content->video_url) }}?enablejsapi=1&autoplay=0&rel=0"
                frameborder="0"
                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen
                referrerpolicy="strict-origin-when-cross-origin">
            </iframe>
        @else
{{--            <div>--}}
{{--                <img src="{{asset($content->thumbnail)}}" class="w-auto h-96 text-center click-zoom" alt="Content thumbnail">--}}
{{--            </div>--}}
        {{--        <div class="border border-gray-300 dark:border-white rounded-xl px-2 py-1">--}}
        {{--            <p class="btn-download flex gap-1 items-center">--}}
        {{--                <span>Attached file:</span>--}}
        {{--                <span class="file-name dark:text-white">--}}
        {{--                @php--}}
        {{--                    $isContent = $type == 'content';--}}
        {{--                    $filename = $isContent--}}
        {{--                        ? json_decode($content->attachment_details)->filename ?? 'Download'--}}
        {{--                        : basename($content->attachment_details);--}}
        {{--                    $url = $isContent--}}
        {{--                        ? "/cgo/informations/content-management/documents/download/{$content->id}"--}}
        {{--                        : "/cgo/informations/content-management/resource/download/{$content->id}";--}}
        {{--                @endphp--}}

        {{--                <a target="_blank" href="{{ $url }}" class="flex items-center gap-2">--}}
        {{--                    {{ $filename }}--}}
        {{--                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"--}}
        {{--                         stroke-width="1.5" stroke="currentColor" class="size-5">--}}
        {{--                        <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round"--}}
        {{--                              d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />--}}
        {{--                    </svg>--}}
        {{--                </a>--}}
        {{--            </span>--}}
        {{--            </p>--}}
        {{--        </div>--}}
        @if(auth()->guard('admin')->check())
            <div>
                <img src="{{asset($content->thumbnail)}}" class="w-auto h-96 text-center click-zoom" alt="Content thumbnail">
            </div>
        @endif
        <x-file-viewer :id="$content->id" />

        @endif
    </div>
    <div class="dark:text-white text-[#706F81] break-words">
        {{$content->intro}}
    </div>

    <script>
        $(document).ready(function () {
            $(".like").click(function () {
                toggleLoadingOverlay();
                const button = $(this);
                const contentId = button.data("id");
                const contentType = button.data("type");

                $.ajax({
                    url: "/informations/contents/like/" + contentId + "/" + contentType,
                    type: "GET",
                    data: {
                    },
                    success: function (response) {
                        if (response.success) {
                            button.find(".like-count").text(response.likes);
                        } else {
                            alert("Something went wrong!");
                        }
                        toggleLoadingOverlay();
                    },
                    error: function () {
                        alert("Error occurred while liking the content.");
                    }
                });
            });
        })


    </script>

</div>
