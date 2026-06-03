@extends('homepage.layouts.master')
@section('title', 'Information - Content management - Document')

@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{trans('system.information.content_management.title')}}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.information.root'), 'url' => '#'],
                ['label' => trans('system.information.content_management.title'), 'url' => route(activeGuard().'.informations.content-management.videos.list')],
                ['label' => trans('system.menu.information.content_management.document'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-6 pb-10">
            <div  class="flex flex-col gap-4">
                <form>
                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search" class="sr-only">{{trans('system.form.button.search')}}</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" placeholder="{{ __('general.Content name') }}" class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="" name="keyword" required />
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
                            <p class="text-[#706F81] text-lg dark:text-white relative flex items-center">{{trans('system.result_for')}} <span class="font-semibold px-2 py-1 bg-gray-100 rounded-xl">{{$keyword}}</span> <a href="{{route(activeGuard().'.informations.content-management.documents.list')}}" class="absolute -right-1 -top-1 pl-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>


                                </a>:</p>
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white whitespace-nowrap">{{trans('system.results', ['a' => $count])}}</p>
                        @endif

                    </div>
                    <div class="flex gap-4">
                        <select id="status" name="status" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{trans('system.table.heading.status')}}</option>

                            @foreach (\App\Enums\StatusEnumsManagement::cases() as $statusEnum)
                                @if($statusEnum->value != 1 && $statusEnum-> value != 2)
                                <option value="{{ $statusEnum->value }}" {{ $status == $statusEnum->value ? 'selected' : '' }}>
                                    {{ \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value) }}
                                </option>
                                @endif
                            @endforeach
                        </select>
                        <select id="type" name="order" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
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
                        {{trans('system.information.content_management.document.upload_document')}} <svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                            <path d="M7.5013 1.16699V12.8337M1.66797 7.00033H13.3346" stroke="white" stroke-width="1.67" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
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
                                {{trans('system.table.heading.size')}}
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
                        @forelse($documents as $key => $document)
                            <tr class="bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700">
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    {{$key+1}}
                                </td>

                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white font-semibold text-left">
                                    {{ \Str::limit($document->title, 50) }}
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    {{$document->content_type}}
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    <span>{{\App\Enums\StatusEnumsManagement::getStatusName($document->status)}}</span>
                                    <span>{{$document->status == \App\Enums\StatusEnumsManagement::NON_APPROVAL->value ? 'Reason: '.\Str::limit($document->reason,30) : ''}}</span>
                                </td>
                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                    {{$document->size != '' ? $document->size : 'N/G'}}
                                </td>

                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4]">
                                    {{date("Y-m-d", strtotime($document->created_at))}}
                                </td>
                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4]">
                                    {{$document->views}}
                                </td>
                                <td class="px-4 py-6 text-sm flex gap-2 justify-center">
                                    <a target="_blank" href="{{route(activeGuard().'.informations.content-management.documents.download', ['id' => $document->id])}}" class=" flex items-center gap-2 ">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                        </svg>
                                    </a>
                                    <button class="btn-edit text-primary" data-modal-target="edit-modal" data-modal-toggle="edit-modal" data-id="{{$document->id}}">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                        </svg>
                                    </button>
                                    <button class="btn-delete text-red-600" data-id="{{$document->id}}" data-modal-target="delete-modal" data-modal-toggle="delete-modal">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" class="" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>
                                    </button>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9">
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
            @if(count($documents) > 0)
            {{$documents->onEachSide(1)->links()}}
            @endif
        </div>
    </div>
    <!-- Main modal -->
    <div id="default-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{trans('system.information.content_management.document.form_title')}}
                    </h3>
                    <button type="button" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="default-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="flex flex-col gap-6 mt-4" action="{{route(activeGuard().'.informations.content-management.documents.post')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <input type="text" name="action" value="add" class="hidden">
                    <input type="text" name="id" value="" class="hidden">
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
                        <label for="content_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.content_name')}} <span class="text-red-600">*</span></label>
                        <input type="text" id="content_name" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED]  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="title" required />
                    </div>
                    <div>
                        <label for="introduction" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.content_introduction')}} <span class="text-red-600">*</span></label>
                        <textarea id="introduction" required rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-white dark:bg-[#1E1E1E] rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" name="intro"></textarea>

                    </div>
                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.author')}}</label>
                        <input type="text" id="author" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="author" />
                    </div>
                    <div>
                        <label for="license" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.license')}}</label>
                        <input type="text" id="license" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="license" />
                    </div>
                    <div class="w-full">
                        <label for="imageUpload" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('admin/dashboard.new_letter.thumbnail')}}<span class="text-red-600">*</span></label>

                        <input name="thumbnail"
                               id="imageUpload"
                               type="file"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
           file:mr-4 file:py-2 file:px-4
           file:rounded-full file:border-0
           file:text-sm file:font-semibold
           file:bg-blue-50 file:text-blue-700
           hover:file:bg-blue-100
           dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600" required
                        >

                        <div id="previewContainer" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>
                            <img id="previewImage" src="#" alt="Image preview" class="w-auto h-36 rounded shadow text-center" />
                        </div>
                    </div>
                    <div class="bg-white mx-auto w-full rounded-xl dark:bg-[#1E1E1E]">
                        <div x-data="dataFileDnD()" class="relative flex flex-col text-gray-400 border border-gray-200 rounded-xl">
                            <div x-ref="dnd"
                                 class="relative flex flex-col text-gray-400 rounded cursor-pointer">
                                <input accept=".doc,.docx,.pdf,image/*" type="file" name="attachment" required
                                       class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer file-upload"
                                       @change="addFiles($event)"
                                       @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                                       @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                       @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                       title="" />

                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-base dark:text-white"><span class=" text-[#464559] dark:text-white">{!! trans('system.information.content_management.document.choose_file') !!}</p>
                                </div>
                            </div>

                            <template x-if="files.length > 0">
                                <div class="grid grid-cols-4 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)"
                                     @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                             style="padding-top: 100%;" @dragstart="dragstart($event)" @dragend="fileDragging = null"
                                             :class="{'border-blue-600': fileDragging == index}" draggable="true" :data-index="index">
                                            <button class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none" type="button" @click="remove(index)">
                                                <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <template x-if="files[index].type.includes('audio/')">
                                                <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                </svg>
                                            </template>
                                            <template x-if="files[index].type.includes('application/') || files[index].type === ''">
                                                <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </template>
                                            <template x-if="files[index].type.includes('image/')">
                                                <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                     x-bind:src="loadFile(files[index])" />
                                            </template>
                                            <template x-if="files[index].type.includes('video/')">
                                                <video
                                                    class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                                    <fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
                                                </video>
                                            </template>

                                            <div class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                <span class="w-full font-bold text-gray-900 truncate"
                                      x-text="files[index].name">Loading</span>
                                                <span class="text-xs text-gray-900" x-text="humanFileSize(files[index].size)">...</span>
                                            </div>

                                            <div class="absolute inset-0 z-40 transition-colors duration-300" @dragenter="dragenter($event)"
                                                 @dragleave="fileDropping = null"
                                                 :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-right flex justify-end mt-2 w-full dark:text-white">
                        {{trans('system.information.content_management.document.hint_file')}}
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <button type="button" data-modal-hide="default-modal" class="close-modal text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:outline-none  font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{trans('system.form.button.cancel')}}</button>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">{{trans('system.form.button.submit')}}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>

    <div id="edit-modal" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border dark:border-white px-4 py-8">
                <!-- Modal header -->
                <div class="flex items-center justify-between pb-4 border-b rounded-t">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        {{trans('system.information.content_management.document.form_title')}}
                    </h3>
                    <button type="button" class="close-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="edit-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="flex flex-col gap-6 mt-4 relative" id="form-create" action="{{route(activeGuard().'.informations.content-management.documents.post')}}" method="post" enctype="multipart/form-data">
                    <div class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center bg-gray-50 dark:bg-gray-800">
                        <div role="status">
                            <svg aria-hidden="true" class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="currentColor"/><path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentFill"/></svg>
                            <span class="sr-only">Loading...</span>
                        </div>
                    </div>
                    @csrf
                    <input type="text" name="action" value="edit" class="hidden">
                    <input type="text" name="id" value="" class="hidden">

                    <div class="flex flex-col hidden block mb-2 text-sm font-medium text-[#706F81] dark:text-white" id="reason-block">
                        <span>
                            {{trans('general.Reasons for rejection of approval')}}:
                        </span>
                        <span class="reason-message text-sm text-black dark:text-white"></span>
                    </div>
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
                        <label for="content_name" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.content_name')}} <span class="text-red-600">*</span></label>
                        <input type="text" id="content_name" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="title" required />
                    </div>
                    <div>
                        <label for="introduction" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.content_introduction')}} <span class="text-red-600">*</span></label>
                        <textarea id="introduction" rows="4" class="block p-2.5 w-full text-sm bg-white dark:bg-[#1E1E1E] rounded-lg border border-[#EDEDED] focus:ring-blue-500 focus:border-blue-500  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" name="intro"></textarea>

                    </div>
                    <div>
                        <label for="author" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.author')}}</label>
                        <input type="text" id="author" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="author" />
                    </div>
                    <div>
                        <label for="license" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('system.information.content_management.document.license')}}</label>
                        <input type="text" id="license" class="bg-white dark:bg-[#1E1E1E] border border-[#EDEDED] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5  dark:border-white dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="license" />
                    </div>
                    <div class="w-full">
                        <label for="imageUpload" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{trans('admin/dashboard.new_letter.thumbnail')}}<span class="text-red-600">*</span></label>

                        <input name="thumbnail"
                               id="imageUpload-edit"
                               type="file"
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
           file:mr-4 file:py-2 file:px-4
           file:rounded-full file:border-0
           file:text-sm file:font-semibold
           file:bg-blue-50 file:text-blue-700
           hover:file:bg-blue-100
           dark:file:bg-gray-700 dark:file:text-white dark:hover:file:bg-gray-600"
                        >

                        <div id="previewContainer-edit" class="mt-4 hidden">
                            <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Preview:</p>
                            <img id="previewImage-edit" src="#" alt="Image preview" class="w-auto h-36 rounded shadow text-center" />
                        </div>
                    </div>
                    <div>
                        <p class=" btn-download flex gap-1 items-center"><span>{{trans('system.information.content_management.document.attached_file')}}</span> <span class="file-name"></span>
                        </p>
                    </div>
                    <div class="bg-white mx-auto w-full rounded-xl dark:bg-[#1E1E1E]">
                        <div x-data="dataFileDnD()" class="relative flex flex-col text-gray-400 border border-gray-200 rounded-xl">
                            <div x-ref="dnd"
                                 class="relative flex flex-col text-gray-400 rounded cursor-pointer">
                                <input accept=".doc,.docx,.pdf,image/*" type="file" name="attachment"
                                       class="absolute inset-0 z-50 w-full h-full p-0 m-0 outline-none opacity-0 cursor-pointer"
                                       @change="addFiles($event)"
                                       @dragover="$refs.dnd.classList.add('border-blue-400'); $refs.dnd.classList.add('ring-4'); $refs.dnd.classList.add('ring-inset');"
                                       @dragleave="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                       @drop="$refs.dnd.classList.remove('border-blue-400'); $refs.dnd.classList.remove('ring-4'); $refs.dnd.classList.remove('ring-inset');"
                                       title="" />
                                <div class="flex flex-col items-center justify-center py-10 text-center">
                                    <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                    </svg>
                                    <p class="mb-2 text-base dark:text-white"><span class=" text-[#464559] dark:text-white">{!! trans('system.information.content_management.document.choose_file') !!}</p>
                                </div>
                            </div>

                            <template x-if="files.length > 0">
                                <div class="grid grid-cols-4 gap-4 mt-4 md:grid-cols-6" @drop.prevent="drop($event)"
                                     @dragover.prevent="$event.dataTransfer.dropEffect = 'move'">
                                    <template x-for="(_, index) in Array.from({ length: files.length })">
                                        <div class="relative flex flex-col items-center overflow-hidden text-center bg-gray-100 border rounded cursor-move select-none"
                                             style="padding-top: 100%;" @dragstart="dragstart($event)" @dragend="fileDragging = null"
                                             :class="{'border-blue-600': fileDragging == index}" draggable="true" :data-index="index">
                                            <button class="absolute top-0 right-0 z-50 p-1 bg-white rounded-bl focus:outline-none" type="button" @click="remove(index)">
                                                <svg class="w-4 h-4 text-gray-700" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                     viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                            <template x-if="files[index].type.includes('audio/')">
                                                <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                                                </svg>
                                            </template>
                                            <template x-if="files[index].type.includes('application/') || files[index].type === ''">
                                                <svg class="absolute w-12 h-12 text-gray-400 transform top-1/2 -translate-y-2/3"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                                </svg>
                                            </template>
                                            <template x-if="files[index].type.includes('image/')">
                                                <img class="absolute inset-0 z-0 object-cover w-full h-full border-4 border-white preview"
                                                     x-bind:src="loadFile(files[index])" />
                                            </template>
                                            <template x-if="files[index].type.includes('video/')">
                                                <video
                                                    class="absolute inset-0 object-cover w-full h-full border-4 border-white pointer-events-none preview">
                                                    <fileDragging x-bind:src="loadFile(files[index])" type="video/mp4">
                                                </video>
                                            </template>

                                            <div class="absolute bottom-0 left-0 right-0 flex flex-col p-2 text-xs bg-white bg-opacity-50">
                                <span class="w-full font-bold text-gray-900 truncate"
                                      x-text="files[index].name">Loading</span>
                                                <span class="text-xs text-gray-900" x-text="humanFileSize(files[index].size)">...</span>
                                            </div>

                                            <div class="absolute inset-0 z-40 transition-colors duration-300" @dragenter="dragenter($event)"
                                                 @dragleave="fileDropping = null"
                                                 :class="{'bg-blue-200 bg-opacity-80': fileDropping == index && fileDragging != index}">
                                            </div>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>
                    </div>
                    <p class="text-xs text-right flex justify-end mt-2 w-full dark:text-white">
                        {{trans('system.information.content_management.document.hint_file')}}
                    </p>
                    <div class="grid grid-cols-2 gap-6">
                        <button type="button" data-modal-hide="edit-modal" class="close-modal text-[#9F9FAA] bg-[#EDEDED] hover:bg-gray-600 focus:outline-none  font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center">{{trans('system.form.button.cancel')}}</button>
                        <button type="submit" class="text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            {{trans('system.form.button.submit')}}</button>
                    </div>

                </form>
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
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script>
    <script src="https://unpkg.com/create-file-list"></script>
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
        const imageInputEdit = document.getElementById('imageUpload-edit');
        const previewContainerEdit = document.getElementById('previewContainer-edit');
        const previewImageEdit = document.getElementById('previewImage-edit');

        imageInputEdit.addEventListener('change', function () {
            const file = this.files[0];
            if (file) {
                const reader = new FileReader();
                previewContainerEdit.classList.remove('hidden');

                reader.addEventListener('load', function () {
                    previewImageEdit.setAttribute('src', this.result);
                });

                reader.readAsDataURL(file);
            } else {
                previewContainerEdit.classList.add('hidden');
            }
        });
    </script>
    <script>
        function dataFileDnD() {
            return {
                files: [],
                form: null,
                fileDragging: null,
                fileDropping: null,
                humanFileSize(size) {
                    const i = Math.floor(Math.log(size) / Math.log(1024));
                    return (
                        (size / Math.pow(1024, i)).toFixed(2) * 1 +
                        " " + ["B", "kB", "MB", "GB", "TB"][i]
                    );
                },
                remove() {
                    var inputFile= document.querySelector('.file-upload');
                    inputFile.value='';
                    this.files = [];
                    this.updateFormData();
                    this.updateFileInput();
                },
                drop(e) {
                    e.preventDefault();
                },
                dragenter(e) {
                    e.preventDefault();
                },
                dragstart(e) {
                },
                loadFile(file) {
                    const preview = document.querySelectorAll(".preview");
                    const blobUrl = URL.createObjectURL(file);

                    preview.forEach(elem => {
                        elem.onload = () => {
                            URL.revokeObjectURL(elem.src); // Free memory
                        };
                    });

                    return blobUrl;
                },
                addFiles(e) {
                    this.form = document.getElementById('form-create');
                    const allowedTypes = [
                        'application/msword', // .doc
                        'application/vnd.openxmlformats-officedocument.wordprocessingml.document', // .docx
                        'application/pdf', // .pdf
                        'image/jpeg', // .jpg
                        'image/png' // .png
                    ];

                    const fileList = Array.from(e.target.files);

                    // Filter allowed file types
                    const validFiles = fileList.filter(file => allowedTypes.includes(file.type));

                    // Show error message if invalid files
                    if (validFiles.length !== fileList.length) {
                        Toastify({
                            text: "{{ trans('system.event.allowed_files') }}",
                            className: "info",
                            style: {
                                background: "linear-gradient(to right, #00b09b, #96c93d)",
                            }
                        }).showToast();
                        return;
                    }

                    // Only keep the latest file (clear existing files)
                    this.files = validFiles.slice(0, 1); // Keep only one file

                    // Update form data and file input

                    this.updateFormData();
                    this.updateFileInput();
                },
                updateFormData() {
                    let formData = new FormData(this.form);

                    // Append the single file to the form data
                    if (this.files.length > 0) {
                        formData.append('files', this.files[0]);
                    }
                },
                updateFileInput() {
                    const dataTransfer = new DataTransfer();

                    // Add the single file to the DataTransfer object
                    if (this.files.length > 0) {
                        dataTransfer.items.add(this.files[0]);
                    }

                    // Update the file input element
                    const fileInput = this.form.querySelector('input[type="file"][name="attachment"]');
                    fileInput.files = dataTransfer.files;
                },
            }
        }

        $(document).ready(function () {
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

            $(".btn-delete").click(function () {
                $("#delete-modal a").attr('href', '');
                $("#delete-modal a").attr('href', '/{{activeGuard()}}/informations/content-management/documents/delete/' + $(this).data('id'));
            })

            $(".btn-edit").click(function () {
                $("#edit-modal form > .loading").removeClass('hidden');
                $("#reason-block").addClass("hidden");
                $(".reason-message").text('');
                let id = $(this).attr('data-id');
                $.ajax({
                    type:'GET',
                    url:'/{{activeGuard()}}/informations/content-management/documents/show/'+ id,
                    success:function(data) {
                        if(data.data.reason != null) {
                            $("#reason-block").removeClass("hidden");
                            $(".reason-message").text(data.data.reason);
                        }
                        $("#edit-modal form input[name='id']").val(data.data.id);
                        $("#edit-modal form input[name='title']").val(data.data.title);
                        $("#edit-modal form input[name='author']").val(data.data.author);
                        $("#edit-modal form input[name='license']").val(data.data.license);
                        $("#edit-modal form textarea[name='intro']").text(data.data.intro);
                        $("#edit-modal form select[name='category']").val(data.data.category_id);
                        $("#edit-modal #previewContainer-edit").removeClass('hidden');
                        $("#edit-modal #previewImage-edit").attr('src', data.data.thumbnail);
                        $("#edit-modal #imageUpload-edit").removeAttr('required');
                        let attachment_details = JSON.parse(data.data.attachment_details);
                        $("#edit-modal form .file-name").html(`
                            <a target="_blank" href="/{{activeGuard()}}/informations/content-management/documents/download/`+data.data.id+`" class=" flex items-center gap-2 ">`+attachment_details.filename+`
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                              <path stroke-linecap="round" class="stroke-primary" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                            </svg>
                            </a>
                        `);
                        $("#edit-modal form > .loading").addClass('hidden');
                    }
                });
            });


            $(".close-modal").click(function () {
                $("input[name='attachment']").val('');
            });
        })
    </script>
@endpush
