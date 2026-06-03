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
                ['label' => trans('cgo.menu.information.content_management.peer_content_list'), 'url' => '#'],
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
                            <button type="submit" class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
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
                        <select id="status" name="category" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="all" >{{trans('system.table.heading.category')}}</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @if($categoryId == $category->id) selected @endif>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
{{--                        <select id="status" name="status" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}
{{--                            <option value="all" {{ $status == 'all' ? 'selected' : '' }}>{{trans('system.table.heading.status')}}</option>--}}

{{--                            @foreach (\App\Enums\StatusEnumsManagement::cases() as $statusEnum)--}}
{{--                                <option value="{{ $statusEnum->value }}" {{ $status == $statusEnum->value ? 'selected' : '' }}>--}}
{{--                                    {{ \App\Enums\StatusEnumsManagement::getStatusName($statusEnum->value) }}--}}
{{--                                </option>--}}
{{--                            @endforeach--}}
{{--                        </select>--}}
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
                                {{trans('system.table.heading.category')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.content_type')}}
                            </th>
                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">
                                {{trans('system.table.heading.registration_date')}}
                            </th>
{{--                            <th scope="col" class="px-4 py-6 text-primary dark:text-white font-semibold text-sm">--}}
{{--                                {{trans('system.table.heading.status')}}--}}
{{--                            </th>--}}
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($contents as $key => $item)
                            <tr class=" dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center hover:bg-blue-100 dark:hover:bg-gray-700 @if(!$item->hasUserResponded(Auth::guard('cgo')->id())) bg-gray-50 @else bg-white @endif">
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white @if(!$item->hasUserResponded(Auth::guard('cgo')->id())) font-semibold @endif">
                                    {{$key+1}}
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white font-semibold text-left">
                                    <a href="{{route('cgo.informations.content-management.peer-review.details', ['id' => base64_encode($item->content->id), 'peer_id' => base64_encode($item->id)])}}" class="hover:text-primary hover:underline"> {{ \Str::limit($item->content->title, 50) }}</a>
                                </td>

                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white  @if(!$item->hasUserResponded(Auth::guard('cgo')->id())) font-semibold @endif">
                                    {{$item->content->category->name}}
                                </td>
                                <td scope="row"  class="px-4 py-6 text-sm text-[#464559] dark:text-white @if(!$item->hasUserResponded(Auth::guard('cgo')->id())) font-semibold @endif">
                                    @if($item->content->content_type == 'video')
                                        {{trans('admin/dashboard.content.video')}}
                                    @else
                                        {{trans('admin/dashboard.content.document')}}
                                    @endif
                                </td>
                                <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4] @if(!$item->hasUserResponded(Auth::guard('cgo')->id())) font-semibold @endif">
                                    {{date("Y-m-d", strtotime($item->created_at))}}
                                </td>
{{--                                <td class="px-4 py-6 text-sm flex gap-2 justify-center">--}}

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
            @if(count($contents) > 0)
                {{$contents->onEachSide(1)->links()}}
            @endif
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {

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

            $(document).on("change","select[name='category']",function() {
                let value = $(this).val();
                let url = new URL(window.location.href);
                let param = new URLSearchParams(url.search);
                if (param.has('category')){
                    param.delete('category');
                }
                param.append('category',value);

                if (param.has('page')){
                    param.delete('page');
                }
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?'+ param.toString();
            });

        })
    </script>
@endpush
