@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job/Career Information - Contents')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('cgo.career_guidance.job_information.career_expert_interview.root'), 'url' => '/career-guidance/career-information/contents/' . base64_encode($category->id)],
                ['label' => $category->name, 'url' => '#'],
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
                    <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ $contents->count() }}
                        {{ trans('cgo.career_guidance.job_information.career_expert_interview.filterResults') }}</p>
                @else
                    <p></p>
                @endif
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @forelse($contents as $content)
                        <div class="relative flex gap-3 p-4 flex-col shadow-custom-light dark:shadow-custom-dark rounded-xl border border-gray-50 dark:border-white h-96">
                            @if($content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value)
                                <div class="flex items-center justify-between">
                                    <a href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}" class="dark:text-white font-semibold hover:text-primary h-12 w-5/6">{{\Str::limit($content->title, 30)}}</a>
                                    <div class="w-1/6 flex justify-end">
                                        <img src="/images/approved-by-expert.webp" class="h-12 w-fit" alt="Approved by Industry Expert">
                                    </div>
                                </div>
                            @else
                            <a href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}" class="dark:text-white font-semibold hover:text-primary h-12">{{\Str::limit($content->title, 30)}}</a>
                            @endif
                            @if($content->content_type == 'video')
                                <iframe
                                    id="yt-iframe-{{ $content->id }}"
                                    class="w-full h-full rounded-t-xl youtube-iframe"
                                    src="{{ getYoutubeEmbedUrl($content->video_url) }}?enablejsapi=1&autoplay=0&rel=0"
                                    frameborder="0"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                    allowfullscreen
                                    referrerpolicy="strict-origin-when-cross-origin">
                                </iframe>
                            @else
                                <a class="flex justify-center" href="{{route('career-guidance.career-information.contents.details', ['id' => base64_encode($content->id)])}}"><img src="{{asset($content->thumbnail)}}" class="rounded h-52 object-contain" alt="Thumbnail content"></a>
                            @endif
                            <p class="text-[#91919A] dark:text-white text-sm gap-1 break-words h-32">
                                {!! substr($content->intro, 0, 100) !!}{{ strlen($content->intro) > 100 ? '...' : '' }}
                            </p>
                            <div class="flex justify-between gap-4 items-center h-8">
                                @if($content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value || $content->status == \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value)
                                <span class="text-xs text-primary flex items-center w-1/2">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                    <path d="M4.66665 8.49996L7.99998 11.8333L14.6666 5.16663M1.33331 8.49996L4.66665 11.8333M7.99998 8.49996L11.3333 5.16663" stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> {{\App\Enums\StatusEnumsManagement::getStatusName(\App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value)}}
                                </span>
                                @else
                                    <span class=" w-1/2"></span>
                                @endif
                                <div class="flex gap-2 items-center justify-end w-1/2">
                                    <span class="flex items-center gap-1 text-xs w-fit justify-end dark:text-white text-[#464559]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                            <path d="M10 12.5a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5Z"></path>
                                            <path fill-rule="evenodd" d="M.664 10.59a1.651 1.651 0 0 1 0-1.186A10.004 10.004 0 0 1 10 3c4.257 0 7.893 2.66 9.336 6.41.147.381.146.804 0 1.186A10.004 10.004 0 0 1 10 17c-4.257 0-7.893-2.66-9.336-6.41ZM14 10a4 4 0 1 1-8 0 4 4 0 0 1 8 0Z" clip-rule="evenodd"></path>
                                        </svg>
                                        <span>{{$content->views}}</span>
                                    </span>
                                    <span class="flex items-center gap-1 text-xs w-fit justify-end dark:text-white text-[#464559]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke=" " class="size-4" id="eye-icon-show">
                                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5
                                               2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09
                                               C13.09 3.81 14.76 3 16.5 3
                                               19.58 3 22 5.42 22 8.5
                                               c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                        </svg>
                                        <span>{{$content->likes}}</span>
                                    </span>
                                </div>

                            </div>
                        </div>
                    @empty
                        <div class="flex flex-col gap-4 justify-center items-center p-4 col-span-4">
                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">
                            <p class="dark:text-white">No record!</p>
                        </div>
                    @endforelse

                </div>
                @if ($contents->count() > 0)
                    {{ $contents->onEachSide(1)->links() }}
                @endif
            </div>
        </div>
    </div>
@endsection
