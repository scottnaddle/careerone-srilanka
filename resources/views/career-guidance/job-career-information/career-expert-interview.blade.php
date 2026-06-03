@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job/Career Information - Career Expert Interview')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('cgo.career_guidance.job_information.career_expert_interview.root'), 'url' => '#'],
                ['label' => trans('system.menu.career_guidance.job_information.career_expert_interview'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-6 pb-10">
            <div class="flex flex-col gap-4">
                {{-- <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold">
                    <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{ trans('cgo.career_guidance.job_information.career_expert_interview.breadcum') }}
                </span> --}}
                <form>
                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                            stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" name="search"
                                    value="{{ request()->query('search') }}"
                                    class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                    placeholder="{{ __('general.Title') }}" />
                            </div>
                            <button type="submit"
                                class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                {{ trans('cgo.career_guidance.job_information.career_expert_interview.search') }}
                            </button>
                        </div>
                    </div>
                </form>
                @if (request()->has('search') && request()->query('search') != '')
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $careerExpertInterviews->total() }}
                        {{ trans('cgo.career_guidance.job_information.career_expert_interview.filterResults') }}</p>
                @else
                    <p></p>
                @endif



{{--                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">--}}
{{--                    @forelse ($careerExpertInterviews as $item)--}}
{{--                        <div class="flex flex-col gap-4 p-2 dark:border dark:border-white rounded-xl justify-center w-full shadow-custom-light dark:shadow-custom-dark">--}}
{{--                            <div class="relative w-full h-56 rounded-t-xl">--}}
{{--                                <!-- Layer để bắt click -->--}}
{{--                                <div--}}
{{--                                    class="absolute inset-0 z-10 cursor-pointer"--}}
{{--                                    onclick="handleVideoClick(this, 'career_expert_interview', '{{ $item->id }}')"--}}
{{--                                ></div>--}}

{{--                                <!-- iframe nằm dưới -->--}}
{{--                                <iframe--}}
{{--                                    class="w-full h-full rounded-t-xl iframe"--}}
{{--                                    src="{{ getYoutubeEmbedUrl($item->video_url) }}?enablejsapi=1"--}}
{{--                                    frameborder="0" allowfullscreen--}}
{{--                                    referrerpolicy="strict-origin-when-cross-origin">--}}
{{--                                </iframe>--}}
{{--                            </div>--}}
{{--                            <div class="flex flex-col gap-2 px-4">--}}
{{--                                <button data-modal-target="show-video-modal" data-modal-toggle="show-video-modal" type="button" data-title="{{$item->title}}" data-intro="{{$item->intro}}" data-source="{{ getYoutubeEmbedUrl($item->video_url) }}" data-slug="{{$item->slug}}"  class="open-video text-[#201F36] dark:text-white font-semibold text-lg break-words whitespace-normal">{{\Str::limit($item->title, 30)}}</button>--}}
{{--                                <p class="flex gap-4 text-[#464559] dark:text-white text-sm flex justify-between items-center">--}}
{{--                                    <span>{{date('Y-m-d H:i:s', strtotime($item->created_at))}}</span>--}}
{{--                                    <span>{{ \Str::limit($item->owner->fullName, 10) }}</span>--}}
{{--                                </p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    @empty--}}
{{--                        <div class="flex flex-col gap-4 justify-center items-center p-4 col-span-4">--}}
{{--                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">--}}
{{--                            <p class="dark:text-white">No record!</p>--}}
{{--                        </div>--}}
{{--                    @endforelse--}}

{{--                </div>--}}
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @forelse ($careerExpertInterviews as $item)
                        <div class="flex flex-col gap-4 p-2 dark:border dark:border-white rounded-xl justify-center w-full shadow-custom-light dark:shadow-custom-dark">
                            <div class="relative w-full h-56 rounded-t-xl">
                                <!-- Thêm lớp overlay để bắt sự kiện click -->
                                <div class="absolute inset-0 z-10 cursor-pointer youtube-overlay"
                                     data-content-type="career_expert_interview"
                                     data-content-id="{{ $item->id }}"></div>

                                <!-- Iframe với ID duy nhất -->
                                <iframe
                                    id="yt-iframe-{{ $item->id }}"
                                    class="w-full h-full rounded-t-xl youtube-iframe"
                                    src="{{ getYoutubeEmbedUrl($item->video_url) }}?enablejsapi=1&autoplay=0&rel=0"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    referrerpolicy="strict-origin-when-cross-origin">
                                </iframe>
                            </div>
                            <div class="flex flex-col gap-2 px-4">
                                <div class="flex items-center justify-between">
                                    <button data-modal-target="show-video-modal" data-modal-toggle="show-video-modal" type="button"
                                            data-title="{{$item->title}}" data-intro="{{$item->intro}}"
                                            data-source="{{ getYoutubeEmbedUrl($item->video_url) }}" data-slug="{{$item->slug}}" data-content-id="{{$item->id}}" data-views="{{$item->views}}" data-author="{{$item->owner->fullName}}" data-created-at="{{date('Y-m-d', strtotime($item->created_at))}}"
                                            class="open-video text-[#201F36] dark:text-white font-semibold text-lg break-words whitespace-normal w-5/6 hover:text-primary">
                                        {{\Str::limit($item->title, 20)}}
                                    </button>
                                    <span class="flex items-center gap-1 text-xs w-1/6 justify-end dark:text-white text-[#464559]">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                            </svg>
                                            <span>{{$item->views}}</span>
                                        </span>
                                </div>
                                <p class="flex gap-4 text-[#464559] dark:text-white text-sm flex justify-between items-center">
                                    <span class="flex gap-1 items-center"><svg width="16" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                                stroke-linejoin="round" />
                                            </svg>{{date('Y-m-d', strtotime($item->created_at))}}</span>
                                    <span class="flex gap-1 items-center"><svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                                               xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                                stroke-linejoin="round" />
                                        </svg>{{ \Str::limit($item->owner->fullName, 10) }}</span>
                                </p>

                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col gap-4 justify-center items-center p-4 col-span-4">
                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">
                            <p class="dark:text-white">No record!</p>
                        </div>
                    @endforelse
                </div>
                <div id="show-video-modal" tabindex="-1" aria-hidden="true"
                    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-2xl max-h-full">
                        <!-- Modal content -->
                        <div
                            class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                            <!-- Modal header -->
                            <div class="flex items-center justify-between pb-4 border-b rounded-t">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Video details
                                </h3>
                                <button type="button"
                                    class="close-video-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                    data-modal-hide="show-video-modal">
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
                                <p class="title text-xl font-semibold dark:text-white break-words whitespace-normal"> </p>
                                <p class="flex gap-4 text-[#464559] dark:text-white text-sm flex justify-between items-center meta-information">
                                    <span class="flex items-center gap-4">
                                        <span class="flex items-center gap-1">
                                        <span>
                                            <svg width="16" height="16" viewBox="0 0 17 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                                stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                        <span class="created-at"></span>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <span><svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                                                   xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                                stroke-linejoin="round" />
                                        </svg>
                                        </span>
                                        <span class="author"></span>
                                    </span>
                                    </span>

                                    <span class="flex items-center gap-1">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                                <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                                <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                            </svg>
                                        </span>
                                        <span class="views"></span>
                                    </span>

                                </p>
                                <iframe class="w-full" height="315" src="" frameborder="0"
                                    allowfullscreen></iframe>
                                <p class="intro dark:text-white"></p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            {{--            //cái này gọi tailwind pagination trong vendor ra --}}
           @if ($careerExpertInterviews->count() > 0)
            {{ $careerExpertInterviews->onEachSide(1)->links() }}
          @endif

        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        // Track currently playing iframe
        let currentPlayingIframe = null;
        let currentOverlay = null;

        $(".open-video").click(function() {
            // Pause any currently playing video
            if (currentPlayingIframe) {
                pauseCurrentVideo();
            }

            // Open new video in modal
            $("#show-video-modal .title").html($(this).data('title'));
            $("#show-video-modal .intro").html($(this).data('intro'));
            $("#show-video-modal .created-at").html($(this).data('created-at'));
            $("#show-video-modal .author").html($(this).data('author'));
            $("#show-video-modal .views").html($(this).data('views'));
            $("#show-video-modal iframe").attr('src', getSrc($(this).data('source')));
            let contentId = $(this).data('content-id');
            postLog('career_expert_interview', contentId);

        });

        // Handle video interactions
        $('.youtube-overlay').on('click', function(e) {
            e.stopPropagation();
            var overlay = $(this);
            var contentType = overlay.data('content-type');
            var contentId = overlay.data('content-id');
            var iframe = overlay.next();

            // Pause any currently playing video
            if (currentPlayingIframe && currentPlayingIframe[0] !== iframe[0]) {
                pauseCurrentVideo();
            }

            handleVideoInteraction(overlay, iframe, contentType, contentId);
            currentPlayingIframe = iframe;
            currentOverlay = overlay;
        });

        $('.youtube-iframe').on('click', function(e) {
            e.stopPropagation();
            var iframe = $(this);
            var overlay = iframe.prev();
            var contentType = overlay.data('content-type');
            var contentId = overlay.data('content-id');

            // Pause any currently playing video
            if (currentPlayingIframe && currentPlayingIframe[0] !== iframe[0]) {
                pauseCurrentVideo();
            }

            handleVideoInteraction(overlay, iframe, contentType, contentId);
            currentPlayingIframe = iframe;
            currentOverlay = overlay;
        });

        // Click outside handler
        $(document).on('click', function(e) {
            // If click is not on an iframe or overlay, and we have a playing video
            if (currentPlayingIframe &&
                !$(e.target).closest('.youtube-iframe, .youtube-overlay').length) {
                pauseCurrentVideo();
            }
        });

        // Pause video when modal is closed
        $('[data-modal-hide="show-video-modal"]').on('click', function() {
            if (currentPlayingIframe) {
                pauseCurrentVideo();
            }
        });

        function pauseCurrentVideo() {
            if (currentPlayingIframe && currentPlayingIframe.length) {
                currentPlayingIframe[0].contentWindow.postMessage(
                    JSON.stringify({ event: 'command', func: 'pauseVideo', args: [] }),
                    '*'
                );

                if (currentOverlay && currentOverlay.length) {
                    currentOverlay.show();
                }

                currentPlayingIframe = null;
                currentOverlay = null;
            }
        }
    });

    function getSrc(url) {
        let p =
            /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
        if (url.match(p)) {
            const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/;
            const match = url.match(regExp);
            const ID = (match && match[2].length === 11) ? match[2] : null;
            return 'https://www.youtube.com/embed/' + ID;
        } else {
            return url;
        }
    }

    function handleVideoInteraction(overlay, iframe, contentType, contentId) {
        overlay.hide();
        iframe[0].contentWindow.postMessage(
            JSON.stringify({ event: 'command', func: 'playVideo', args: [] }),
            '*'
        );
        postLog(contentType, contentId);
    }

    function postLog(contentType, contentId) {
        $.ajax({
            url: '/log-content-view',
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: JSON.stringify({
                content_type: contentType,
                content_id: contentId
            }),
            keepalive: true,
            contentType: 'application/json',
            success: function(response) {
                if (!response.success) {
                    console.error('Logging failed:', response.message);
                }
            },
            error: function(xhr) {
                console.error('Request failed:', xhr.responseText);
            }
        });
    }
</script>
@endpush
