@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job/Career Information - Career Expert Interview')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <p class="text-2xl text-[#464559] dark:text-white font-semibold">Job/Career Information</p>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-6 pb-10">
            <div class="flex flex-col gap-4">
                <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold">
                    <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>Career expert interview
                </span>
                <form method="GET" action="{{ route('trainee.career-guidance.job-career-information.career-expert-interview') }}">
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
                                <input type="text" id="simple-search" name="title"
                                       value="{{ request()->query('title') }}"
                                       class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                       placeholder="" />
                            </div>
                            <button type="submit"
                                    class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                Search
                            </button>
                        </div>
                    </div>
                </form>
                @if (request()->has('title') && request()->query('title') != '')
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $careerExpertInterviews->total() }}
                        Results</p>
                @else
                    <p></p>
                @endif



                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    @foreach ($careerExpertInterviews as $item)
                        <div class="flex flex-col gap-4 pb-2 dark:border dark:border-white rounded-xl justify-center w-fit">
                            <button type="button" data-modal-target="show-video-modal" data-modal-toggle="show-video-modal"
                                    data-title="{{ $item->title }}" data-intro="{{ $item->intro }}"
                                    data-source="{{ $item->video_url }}" data-slug="{{ $item->slug }}" class="open-video">
                                <img src="{{ asset($item->thumbnail) }}" alt="" class="rounded-xl">
                            </button>

                            <div class="flex flex-col gap-2 px-4">
                                <p class="text-[#201F36] dark:text-white font-semibold text-lg">{{ $item->title }}</p>
                                <p class="flex gap-4 text-[#464559] dark:text-white text-sm">
                                    <span>{{ $item->created_at }}</span>
                                    <span>07 : 26 : 09</span>
                                </p>
                                <div class="flex justify-between items-center">
                                    <p class="text-[#706F81] text-xs dark:text-white flex items-center gap-2">
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                 stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M15.91 11.672a.375.375 0 0 1 0 .656l-5.603 3.113a.375.375 0 0 1-.557-.328V8.887c0-.286.307-.466.557-.327l5.603 3.112Z" />
                                            </svg>
                                        </span>
                                        <span>Play time: 07 : 26 : 09</span>
                                    </p>
                                    <p class="text-[#706F81] text-xs dark:text-white">{{ $item->owner->first_name }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach

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
                                <iframe class="w-full" height="315" src="" frameborder="0"
                                        allowfullscreen></iframe>
                                <p class="intro dark:text-white"></p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
            {{--            //cái này gọi tailwind pagination trong vendor ra --}}
            {{ $careerExpertInterviews->onEachSide(1)->links() }}
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {

            $(".open-video").click(function() {
                $("#show-video-modal .title").html($(this).data('title'));
                $("#show-video-modal .intro").html($(this).data('intro'));
                $("#show-video-modal iframe").attr('src', getSrc($(this).data('source')));
                $(".btn-delete").attr('data-slug', $(this).attr('data-slug'));
                $(".btn-edit").attr('data-slug', $(this).attr('data-slug'));
            });

        })

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
    </script>
@endpush
