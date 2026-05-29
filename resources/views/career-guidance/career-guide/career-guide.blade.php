@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Career Guide')
@push('css')
    <style>
        .active {
            background-color: #4984f6;
            color: white;
        }
    </style>
@endpush
@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('system.menu.career_guidance.job_information.root'), 'url' => '#'],
                ['label' => trans('system.menu.career_guidance.job_information.employment_supporting'), 'url' => '#']
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-6 pb-10">
            <div class="flex flex-col gap-4">
                <div class="mb-2 ">
                    <ul class="md:h-24 rounded-lg grid grid-cols-1 lg:grid-cols-3 -mb-px text-base md:text-lg xl:text-xl font-medium text-center w-full justify-around items-center bg-[#F5F7FA]"
                        id="default-styled-tab" data-tabs-toggle="#default-styled-tab-content"
                        data-tabs-active-classes="text-white bg-primary font-semibold"
                        data-tabs-inactive-classes="dark:border-transparent text-[#91919A] hover:text-gray-600 dark:text-white"
                        role="tablist">
                        @foreach ($tabs as $tab => $content)
                            <li class="w-full" role="presentation">
                                <button
                                    class="tab-button md:h-24 inline-block py-4 rounded-lg w-full text-center hover:text-white hover:bg-primary"
                                    id="tab-button-{{ $tab + 1 }}" type="button" data-tab="{{ $loop->index + 1 }}"
                                    onclick="showTab({{ $tab + 1 }}, this)">{{ $content->name }}</button>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <!-- Tabs Content -->
                <div class="tab-content w-full">
                        <div class="flex flex-col gap-4">
                            <div class="tab-pane  w-full grid grid-cols-1 md:grid-cols-4 gap-4"
                                 id="tab-content">
                                @forelse ($results as $careerGuidance)
                                    <div class="flex flex-col gap-4 p-2 dark:border dark:border-white rounded-xl justify-center w-fit shadow-custom-light dark:shadow-custom-dark">
                                        <span class="px-2">
                                            <div class="relative w-full h-56 rounded-t-xl bg-cover bg-center" style="background-image: url('{{asset($careerGuidance->thumbnail)}}');">
                                                <div class="absolute inset-0 flex items-center justify-center button-play-video">
                                                    <button onclick="playVideo()" class=" bg-gray-300 p-3 rounded-xl text-white flex items-center justify-center play-button">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="1.43em" height="1em" viewBox="0 0 256 180"><path fill="#f00" d="M250.346 28.075A32.18 32.18 0 0 0 227.69 5.418C207.824 0 127.87 0 127.87 0S47.912.164 28.046 5.582A32.18 32.18 0 0 0 5.39 28.24c-6.009 35.298-8.34 89.084.165 122.97a32.18 32.18 0 0 0 22.656 22.657c19.866 5.418 99.822 5.418 99.822 5.418s79.955 0 99.82-5.418a32.18 32.18 0 0 0 22.657-22.657c6.338-35.348 8.291-89.1-.164-123.134"/><path fill="#fff" d="m102.421 128.06l66.328-38.418l-66.328-38.418z"/></svg>
                                                    </button>
                                                </div>
                                                <iframe id="youtubeIframe" class="w-full h-56 rounded-t-xl hidden" src="{{ getYoutubeEmbedUrl($careerGuidance->video_url) }}" frameborder="0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin"></iframe>
                                            </div>
                                        </span>
                                        <div class="flex flex-col gap-2 px-4">
                                            <button data-modal-target="show-video-modal" data-modal-toggle="show-video-modal" type="button" data-title="{{$careerGuidance->title}}" data-intro="{{$careerGuidance->intro}}" data-source="{{ getYoutubeEmbedUrl($careerGuidance->video_url) }}" data-slug="{{$careerGuidance->slug}}"  class="open-video text-[#201F36] dark:text-white font-semibold text-lg break-words whitespace-normal" onclick="clickked(event)">{{\Str::limit($careerGuidance->title, 30)}}</button>
                                            <p class="flex gap-4 text-[#464559] dark:text-white text-sm flex justify-between items-center">
                                                <span>{{date('Y-m-d H:i:s', strtotime($careerGuidance->created_at))}}</span>
                                                <span>{{ \Str::limit($careerGuidance->getAuthor('cgo', $careerGuidance->created_by)->fullName, 10) }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="flex flex-col gap-4 justify-center items-center p-4 col-span-4">
                                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                    @if($results && $results->count() > 10)
                        <div class="flex justify-end">
                            <a href="{{route('career-guidance.career-guide.view-more', ['id'=>$tabId])}}" class="text-primary underline">View more</a>
                        </div>
                    @endif

                </div>
                @if($results && $results->count() > 10)
                 {{ $tabs->onEachSide(1)->links() }}
                @endif

            </div>

        </div>
        <div id="show-video-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative p-4 w-full max-w-2xl max-h-full">
                <!-- Modal content -->
                <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between pb-4 border-b rounded-t">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            Video details
                        </h3>
                        <button type="button"
                            class="close-video-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="show-video-modal">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="flex flex-col gap-4">
                        <p class="title text-xl font-semibold dark:text-white break-words whitespace-normal"> </p>
                        <iframe class="w-full" height="315" src="" frameborder="0" allowfullscreen></iframe>
                        <p class="intro dark:text-white"></p>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        const $targetEl = document.getElementById('show-video-modal');
        // options with default values
        const options = {
            placement: 'bottom-right',
            backdrop: 'dynamic',
            backdropClasses: 'bg-gray-900/50 dark:bg-gray-900/80 fixed inset-0 z-40',
            closable: true,
            onHide: () => {
            },
            onShow: () => {
            },
            onToggle: () => {
            },
        };

        // instance options object
        const instanceOptions = {
            id: 'show-video-modal',
            override: true
        };

        const modalEdit = new Modal($targetEl, options, instanceOptions);
    </script>
    <script>
        function clickked(event) {
            const element = event.currentTarget;

            // Sử dụng jQuery để cập nhật nội dung của modal
            $("#show-video-modal .title").html($(element).data('title'));
            $("#show-video-modal .intro").html($(element).data('intro'));
            $("#show-video-modal iframe").attr('src', getSrc($(element).data('source')));

            // Hiển thị modal nếu cần
            modalEdit.show();
        }
        $(document).ready(function() {

            $('.close-video-modal').click(function() {
                modalEdit.hide();
            })

        })
        $(document).ready(function() {
            const hash = window.location.hash;
            const queryTab = new URLSearchParams(window.location.search).get('tab');
            const index = hash ? parseInt(hash.replace('#tab-', '')) : queryTab ? parseInt(queryTab) : 1;
            const button = document.getElementById(`tab-button-${index}`);
            button.classList.add('active');
        });

        function getSrc(url) {
            let p =
                /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if (url.match(p)) {
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
                const match = url.match(regExp)
                const ID = (match && match[2].length === 11) ? match[2] : null
                return 'https://www.youtube.com/embed/' + ID
            } else {
                return url;
            }
        }


        function showTab(index, button) {
            const panes = document.querySelectorAll('.tab-pane');
            const buttons = document.querySelectorAll('.tab-button');
            let url = new URL(window.location.href);

            panes.forEach((pane, idx) => {
                pane.classList.toggle('block', idx == index);
                pane.classList.toggle('hidden', idx != index);
            });

            buttons.forEach(btn => {
                btn.classList.remove('active');
            });

            button.classList.add('active');

            if (url.searchParams.has('tab')) {
                url.searchParams.set('tab', index);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('tab', index);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;

        }
        function playVideo() {
            $('#youtubeIframe').removeClass('hidden');
            $('.button-play-video').remove()

        }
    </script>
@endpush
