@extends('homepage.layouts.master')
@section('title', 'Information - Content management - Video')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.information.root'), 'url' => '#'],
                ['label' => trans('system.information.content_management.title'), 'url' => route(activeGuard().'.informations.content-management.videos.list')],
                ['label' => trans('system.menu.information.content_management.video'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-6 pb-10">
            <div  class="flex flex-col gap-4">
                <form action="{{route(activeGuard().'.informations.content-management.videos.list')}}" method="get">
                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
{{--                            <select id="nvq" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                                <option value="all">All</option>--}}
{{--                                <option value="online">1</option>--}}
{{--                                <option value="offline">2</option>--}}
{{--                            </select>--}}
                            <label for="simple-search" class="sr-only">{{trans('system.form.button.search')}}</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" placeholder="{{ __('general.Content name') }}" name="keyword" class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="" value="{{$keyword}}" required />
                            </div>
                            <button type="submit" class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                {{trans('system.form.button.search')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="flex justify-between items-center">
                    <div class="flex gap-4 flex-col">
                        @if($keyword != '')
                            <p class="text-[#706F81] text-lg dark:text-white relative flex items-center">{{trans('system.result_for')}} <span class="font-semibold px-2 py-1 bg-gray-100 rounded-xl">{{$keyword}}</span> <a href="{{route(activeGuard().'.informations.content-management.videos.list')}}" class="absolute -right-1 -top-1 pl-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>


                                </a>:</p>
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white whitespace-nowrap">{{trans('system.results', ['a' => $count])}}</p>
                        @endif

                    </div>
                    <div class="flex gap-4">
                        <select id="type" name="status" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{ trans('system.filter.status.title') }}</option>

                            @foreach (\App\Enums\StatusEnumsManagement::cases() as $statusEnum)
                                @if($statusEnum->value != 1 && $statusEnum-> value != 2)
                                <option value="{{ $statusEnum->value }}" {{ $status == $statusEnum->value ? 'selected' : '' }}>
                                    {{ \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value) }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        <select id="order" name="order" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="desc" {{$order == 'desc' ? 'selected' : ''}}>{{trans('system.filter.recently')}}</option>
                            <option value="asc" {{$order == 'asc' ? 'selected' : ''}}>{{trans('system.filter.oldest')}}</option>
                        </select>
                    </div>
                </div>
                @if(session()->has('success'))
                    <div class="alert alert-success text-green-600 dark:text-white font-semibold bg-green-200 px-4 py-2 rounded-xl">
                        {{ session()->get('success') }}
                    </div>
                @endif
                @if($errors->any())
                    {!! implode('', $errors->all('<div class="alert alert-danger text-red-600 dark:text-red font-semibold bg-red-200 px-4 py-2 rounded-xl">:message</div>')) !!}
                @endif
                <!-- Modal toggle -->
                <div class="flex justify-start">
                    <button data-modal-target="default-modal" data-modal-toggle="default-modal" class="flex items-center gap-2 font-bold text-white bg-primary hover:bg-blue-600 focus:ring-4 focus:outline-none rounded-full text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">
                        {{trans('system.information.content_management.video.upload_video')}} <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                            <path d="M7.5013 1.16699V12.8337M1.66797 7.00033H13.3346" stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
{{--                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">--}}

{{--                    @forelse($videos as $video)--}}
{{--                    <div class="flex flex-col gap-4 dark:border dark:border-white py-2 rounded-xl  hover:bg-blue-100 dark:hover:bg-gray-700 shadow-custom-light dark:shadow-custom-dark">--}}
{{--                        <span class="px-2">--}}
{{--                            <iframe class="w-full h-56 rounded-t-xl" src="{{ getYoutubeEmbedUrl($video->video_url) }}" frameborder="0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" ></iframe>--}}
{{--                        </span>--}}
{{--                        <div class="flex flex-col gap-2 px-4">--}}
{{--                            <button data-modal-target="show-video-modal" data-modal-toggle="show-video-modal" type="button" data-title="{{$video->title}}" data-intro="{{$video->intro}}" data-source="{{ getYoutubeEmbedUrl($video->video_url) }}" data-slug="{{$video->slug}}" data-approval=" {{$video->status == \App\Enums\StatusEnumsManagement::APPROVED->value ? true : false}}" data-status=" {{\App\Enums\StatusEnumsManagement::getStatusName($video->status)}}" data-reason="{{$video->reason}}" class="open-video text-[#201F36] dark:text-white font-semibold text-lg break-words whitespace-normal">{{\Str::limit($video->title, 30)}}</button>--}}
{{--                            <p class="flex gap-4 text-[#464559] dark:text-white text-sm">--}}
{{--                                <span>{{date('Y-m-d H:i:s', strtotime($video->created_at))}}</span>--}}
{{--                            </p>--}}
{{--                            <div class="flex justify-between items-center">--}}
{{--                                <p class="text-[#706F81] text-xs dark:text-white flex items-center gap-2">--}}

{{--                                    {{trans('system.filter.status.title')}}: {{ \App\Enums\StatusEnumsManagement::getStatusName($video->status) }}--}}
{{--                                </p>--}}
{{--                                <p class="text-[#706F81] text-xs dark:text-white">By: {{$video->getAuthor(activeGuard(), $video->created_by)->first_name . ' ' . $video->getAuthor(activeGuard(), $video->created_by)->last_name}}</p>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    @empty--}}
{{--                        <div class="flex flex-col gap-4 justify-center items-center p-4  col-span-1 md:col-span-4">--}}
{{--                            <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">--}}
{{--                            <p class="dark:text-white">No record!</p>--}}
{{--                        </div>--}}
{{--                    @endforelse--}}
{{--                </div>--}}

                <div class="relative overflow-x-auto">
                    <table class="w-full text-left rtl:text-right table-auto">
                        <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center shadow-md">
                        <tr>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{ __('cgo.No.') }}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.title')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.file_type')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.status')}}
                            </th>

                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.registration_date')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.number_of_views')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.action')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($videos as $key => $document)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    {{$key+1}}
                                </td>
                                @php
                                    $approvedStatuses = [
//                                        \App\Enums\StatusEnumsManagement::APPROVED_BY_PEER_REVIEW->value,
                                        \App\Enums\StatusEnumsManagement::APPROVED_BY_ADMIN->value,
                                        \App\Enums\StatusEnumsManagement::APPROVED_BY_ASSOCIATION->value,
                                    ];
                                @endphp
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white font-semibold text-left">
                                    <button data-modal-target="show-video-modal" data-modal-toggle="show-video-modal" type="button" data-title="{{$document->title}}" data-intro="{{$document->intro}}" data-source="{{ getYoutubeEmbedUrl($document->video_url) }}" data-slug="{{$document->slug}}" data-approval="{{ in_array($document->status, $approvedStatuses) ? 'true' : 'false' }}" data-status=" {{\App\Enums\StatusEnumsManagement::getStatusName($document->status)}}" data-reason="{{$document->reason}}" class="open-video text-[#201F36] dark:text-white font-semibold break-words whitespace-normal">{{\Str::limit($document->title, 50)}}</button>
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    {{$document->content_type}}
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    <span>{{\App\Enums\StatusEnumsManagement::getStatusName($document->status)}}</span>
                                    <span>{{$document->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value ? 'Reason: '.\Str::limit($document->reason,30) : ''}}</span>
                                </td>

                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4]">
                                    {{date("Y-m-d", strtotime($document->created_at))}}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4]">
                                    {{$document->views}}
                                </td>
                                <td class="px-4 py-6 text-sm flex gap-2 justify-center">
                                    <button class="btn-edit text-primary" data-modal-target="default-modal" data-modal-toggle="default-modal"  data-title="{{$document->title}}" data-intro="{{$document->intro}}" data-source="{{ getYoutubeEmbedUrl($document->video_url) }}" data-slug="{{$document->slug}}" data-approval="{{ in_array($document->status, $approvedStatuses) ? 'true' : 'false' }}" data-status=" {{\App\Enums\StatusEnumsManagement::getStatusName($document->status)}}" data-reason="{{$document->reason}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button class="btn-delete text-red-600" data-modal-target="delete-modal" data-modal-toggle="delete-modal" type="button" data-title="{{$document->title}}" data-intro="{{$document->intro}}" data-source="{{ getYoutubeEmbedUrl($document->video_url) }}" data-slug="{{$document->slug}}" data-approval="{{ in_array($document->status, $approvedStatuses) ? 'true' : 'false' }}" data-status=" {{\App\Enums\StatusEnumsManagement::getStatusName($document->status)}}" data-reason="{{$document->reason}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>


                                </td>
{{--                                <td class="px-4 py-6 text-sm flex gap-2 justify-center">--}}
{{--                                    <a target="_blank" href="{{route(activeGuard().'.informations.content-management.documents.download', ['id' => $document->id])}}" class=" flex items-center gap-2 ">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                                            <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}
{{--                                    <button class="btn-edit {{$document->status == \App\Enums\StatusEnumsManagement::APPROVED->value ? 'cursor-not-allowed text-gray-400 dark:text-white' : 'text-primary'}}" data-modal-target="edit-modal" data-modal-toggle="edit-modal" data-id="{{$document->id}}" {{$document->status == \App\Enums\StatusEnumsManagement::APPROVED->value ? 'disabled' : ''}}>--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />--}}
{{--                                        </svg>--}}
{{--                                    </button>--}}
{{--                                    <button class="btn-delete {{$document->status == \App\Enums\StatusEnumsManagement::APPROVED->value ? 'cursor-not-allowed text-gray-400 dark:text-white' : 'text-red-600'}}" data-id="{{$document->id}}" data-modal-target="delete-modal" data-modal-toggle="delete-modal" {{$document->status == \App\Enums\StatusEnumsManagement::APPROVED->value ? 'disabled' : ''}}>--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />--}}
{{--                                        </svg>--}}
{{--                                    </button>--}}

{{--                                </td>--}}
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                </div>

            </div>
            @if(count($videos) > 0)
            {{$videos->onEachSide(1)->links()}}
            @endif
        </div>
    </div>
    <!-- Main modal -->
    <div id="default-modal" data-modal-backdrop="static" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white modal-title">
                        {{trans('system.information.content_management.video.form_title')}}
                    </h3>
                    <button type="button" class="close-upload-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="flex flex-col gap-6 mt-4 relative" enctype="multipart/form-data" method="post" action="{{route(activeGuard().'.informations.content-management.videos.post')}}">
                    <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                        <div role="status">
                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @csrf
                    <input type="text" name="action" value="add" class="hidden">
                    <input type="text" name="id" value="add" class="hidden">
                    @if(activeGuard() == 'cgo' && Auth::guard('cgo')->check())
                    <div>
                        <label for="category" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.category')}} <span class="text-red-600">*</span></label>
                        <select id="category" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED]  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="category" required >
                            <option value="">{{trans('system.information.content_management.video.choose_category')}}</option>
                            @foreach($categories as $category)
                                <option value="{{$category->id}}">{{$category->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div>
                        <label for="title" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.content_name')}} <span class="text-red-600">*</span></label>
                        <input type="text" id="title" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED]  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="title" required />
                    </div>
{{--                    <div class="w-full">--}}
{{--                        <label for="imageUpload" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('admin/dashboard.new_letter.thumbnail')}}<span class="text-red-600">*</span></label>--}}

{{--                        <input name="thumbnail"--}}
{{--                            id="imageUpload"--}}
{{--                            type="file"--}}
{{--                            accept="image/*"--}}
{{--                            class="block w-full text-sm text-gray-500--}}
{{--           file:mr-4 file:py-2 file:px-4--}}
{{--           file:rounded-full file:border-0--}}
{{--           file:text-sm file:font-semibold--}}
{{--           file:bg-blue-50 file:text-blue-700--}}
{{--           hover:file:bg-blue-100--}}
{{--           dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600" required--}}
{{--                        >--}}

{{--                        <div id="previewContainer" class="mt-4 hidden">--}}
{{--                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>--}}
{{--                            <img id="previewImage" src="#" alt="Image preview" class="w-auto h-36 rounded shadow text-center" />--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div>
                        <label for="url_video" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.url_video')}} <span class="text-red-600">*</span></label>
                        <input type="text" id="url_video" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="video_url" required />
                    </div>
                    <div>
                        <label for="introduction" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.video.content_introduction')}} <span class="text-red-600">*</span></label>
                        <textarea id="introduction" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white dark:bg-[#1E1E1E] rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" name="intro" required></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <button type="button" data-modal-hide="default-modal" class="text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:outline-none  font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center close-upload-modal">{{trans('system.form.button.cancel')}}</button>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{trans('system.form.button.submit')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="show-video-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{trans('system.information.content_management.video.form_title_details')}}
                    </h3>
                    <button type="button" class="close-video-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="show-video-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col border-b border-gray-100 py-2">
                        <div class="flex text-sm">
                            Status:&nbsp <span id="status" class="dark:text-white"></span>
                        </div>
                        <span id="reason" class="dark:text-white text-sm"></span>
                    </div>
                    <p class="title text-xl font-semibold dark:text-white break-words whitespace-normal" > </p>
                    <iframe class="w-full" height="315" src="" frameborder="0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" ></iframe>
                    <p class="intro"></p>

                </div>
                <div class="flex flex-col gap-4 mt-4 border-t pt-4">
                    <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal" class="btn-delete w-full py-2.5 px-4 text-white bg-[#F34550] hover:bg-red-800 text-sm font-medium rounded-full text-center" data-modal-hide="show-video-modal">{{trans('system.form.button.delete')}}</button>
                    <button type="button" data-modal-target="default-modal" data-modal-toggle="default-modal" class="btn-edit py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block w-full text-center" data-modal-hide="show-video-modal">{{trans('system.form.button.edit')}}</button>
                </div>
            </div>
        </div>
    </div>

    <div id="delete-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white text-center">
                        {{trans('system.delete_modal.title')}}
                    </h3>
                    <button type="button" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="delete-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="flex flex-col gap-4">
                    <svg class="mt-6 mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                    </svg>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400 text-center">{{trans('system.delete_modal.content')}}</h3>
                    <div class="flex justify-center gap-4">
                        <a href="" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                            {{trans('system.delete_modal.yes')}}
                        </a>
                        <button data-modal-hide="delete-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">{{trans('system.delete_modal.no')}}</button>
                    </div>

                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        const imageInput = document.getElementById('imageUpload');
        const previewContainer = document.getElementById('previewContainer');
        const previewImage = document.getElementById('previewImage');

        imageInput.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                previewContainer.classList.remove('hidden');

                reader.addEventListener('load', function () {
                    previewImage.setAttribute('src', this.result);
                });

                reader.readAsDataURL(file);
            } else {
                previewContainer.classList.add('hidden');
            }
        });
    </script>
    <script>
        $(document).ready(function () {

            $(".open-video").click(function () {
                // Set modal title and intro text
                $("#show-video-modal .title").html($(this).data('title'));
                $("#show-video-modal .intro").html($(this).data('intro'));

                // Set iframe source to video URL
                $("#show-video-modal iframe").attr('src', $(this).data('source'));
                $("#show-video-modal #status").html($(this).data('status'));
                if($(this).data('reason') != '') {
                    $("#show-video-modal #reason").html('Reason: '+$(this).data('reason'));
                }


                // Conditional handling based on approval status
                if ($(this).data('approval') == true) {
                    // Disable buttons if approval is true
                    $(".btn-delete").attr('disabled', 'true').addClass('cursor-not-allowed');
                    $(".btn-edit").attr('disabled', 'true').addClass('cursor-not-allowed');
                } else {
                    // Enable and set data attributes for delete/edit buttons if approval is false
                    $(".btn-delete").removeAttr('disabled').attr('data-slug', $(this).data('slug')).removeClass('cursor-not-allowed');
                    $(".btn-edit").removeAttr('disabled').attr('data-slug', $(this).data('slug')).removeClass('cursor-not-allowed');
                }
            });

            $(".close-video-modal").click(function () {
                // Clear modal content and iframe src
                $("#show-video-modal .title").html('');
                $("#show-video-modal .intro").html('');
                $("#show-video-modal iframe").attr('src', '');

                // Reset delete and edit buttons
                $(".btn-delete").removeAttr('disabled').removeAttr('data-slug').removeClass('cursor-not-allowed');
                $(".btn-edit").removeAttr('disabled').removeAttr('data-slug').removeClass('cursor-not-allowed');
            });
            $(".btn-delete").click(function () {
                $("#delete-modal a").attr('href', '');
                $("#delete-modal a").attr('href', '/{{activeGuard()}}/informations/content-management/videos/delete/' + $(this).data('slug'));
            });

            $(".btn-edit").click(function () {
                $("#default-modal form>.loading").removeClass('hidden');
                $("#default-modal .modal-title").html('Edit content');
                let slug = $(this).attr('data-slug');
                $.ajax({
                    type:'GET',
                    url:'/{{activeGuard()}}/informations/content-management/videos/show/'+ slug,
                    success:function(data) {
                        $("#default-modal form input[name='action']").val('edit');
                        $("#default-modal form input[name='id']").val(data.data.id);
                        $("#default-modal form input[name='title']").val(data.data.title);
                        $("#default-modal form input[name='video_url']").val(data.data.video_url);
                        $("#default-modal form textarea[name='intro']").text(data.data.intro);
                        $("#default-modal form select[name='category']").val(data.data.category_id);
                        $("#previewContainer").removeClass('hidden');
                        $("#default-modal #previewImage").attr('src', data.data.thumbnail);
                        $("#imageUpload").removeAttr('required');
                        $("#default-modal form>.loading").addClass('hidden');
                    }
                });
            });

            $(".close-upload-modal").click(function () {
                $("#default-modal .modal-title").html('Upload video');
                $("#default-modal form")[0].reset();
                $("#default-modal form textarea").text('');
                $("#imageUpload").attr('required');
                $("#previewContainer").addClass('hidden');
                $("#default-modal #previewImage").attr('src', "");
            })


            $(document).on("change","select[name='status']",function() {
                let value = $(this).val();
                let url = new URL(window.location.href);
                let param = new URLSearchParams(url.search);
                if (param.has('status')){
                    param.delete('status');
                }
                param.append('status',value);
                if (param.has('page')){
                    param.delete('page');
                }
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?'+ param.toString();
            });

            $(document).on("change","select[name='order']",function() {
                let value = $(this).val();
                let url = new URL(window.location.href);
                let param = new URLSearchParams(url.search);
                if (param.has('order')){
                    param.delete('order');
                }
                param.append('order',value);
                if (param.has('page')){
                    param.delete('page');
                }
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?'+ param.toString();
            });
        })
        function getSrc(url) {
            let p = /^(?:https?:\/\/)?(?:m\.|www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\/|watch\?v=|watch\?.+&v=))((\w|-){11})(?:\S+)?$/;
            if(url.match(p)){
                const regExp = /^.*(youtu.be\/|v\/|u\/\w\/|embed\/|watch\?v=|&v=)([^#&?]*).*/
                const match = url.match(regExp)
                const ID = (match && match[2].length === 11) ? match[2] : null
                return 'https://www.youtube.com/embed/' + ID
            }else {
                return url;
            }

        }
    </script>
@endpush
