@extends('homepage.layouts.master')
@section('title', 'CGO - Career Test - List')

@section('content')
<div class="py-6">
    <x-breadcrumb :items="[
        ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
        ['label' => trans('cgo.menu.career_guidance.root'), 'url' => '#'],
        ['label' => trans('cgo.career_guidance.career_test.title'), 'url' => ''],
    ]" />
</div>
    <div class="flex flex-col gap-5 bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-6 mb-6">
        <div class="w-full flex gap-0">
            <form class=" flex flex-col gap-4 w-full" method="get">
                <div class="flex flex-col">
                    <div class="flex gap-6 items-center">
                        <label for="simple-search" class="sr-only">{{trans('system.form.button.search')}}</label>
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                </svg>
                            </div>
                            <input type="text" name="keyword" id="simple-search" class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="{{ __('general.Trainee name') }}" required value="{{$keyword}}" />
                        </div>
                        <button type="submit" class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                            {{trans('system.form.button.search')}}
                        </button>
                    </div>
                </div>


                <div class="flex justify-between w-full gap-4 items-center">
                    <div class="flex gap-4 flex-col">
                        @if($keyword != '')
                            <p class="text-[#706F81] text-lg dark:text-white relative flex items-center">{{trans('system.result_for')}} <span class="font-semibold px-2 py-1 bg-gray-100 rounded-xl">{{$keyword}}</span> <a href="{{route('cgo.career-guidance.career-test.list')}}" class="absolute -right-1 -top-1 pl-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>


                                </a>:</p>
                            <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{trans('system.results', ['a' => $count])}}</p>
                        @endif

                    </div>
                    <div class="flex gap-4">
                        <select id="type"
                            class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            name="test_type">
                            <option value="all">{{ trans('system.filter.career_test_type') }}</option>
                            @forelse(getCodeList('career_test_type') as $careerTest)
                                <option value="{{ $careerTest->code_id}}"
                                    {{ $careerTest->code_id == $test_type ? 'selected' : '' }}>{{ $careerTest->code_name }}
                                </option>
                            @empty
                            @endforelse
                        </select>
{{--                        <select id="type" class="bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="type">--}}
{{--                            <option value="all">{{trans('system.filter.all')}}</option>--}}
{{--                            <option value="1" {{($type == 1) ? 'selected' : ''}}>{{trans('system.filter.online')}}</option>--}}
{{--                            <option value="0" {{($type == 0) ? 'selected' : ''}}>{{trans('system.filter.offline')}}</option>--}}
{{--                        </select>--}}
                    </div>

                </div>
            </form>
        </div>

        <div class="flex flex-col pb-5 gap-6 bg-white dark:bg-[#1E1E1E] rounded-xl shadow-custom-light dark:shadow-custom-dark">

            @if($errors->any())
                <p class="text-red-600">{{$errors->first()}}</p>
            @endif
            <div class="relative overflow-x-auto">
                <table class="w-full text-sm text-left rtl:text-right dark:text-white">
                    <thead class="text-base text-primary bg-[#F9FBFF] dark:bg-[#383838] dark:text-white">
                        <tr class="text-center">
                            <th scope="col" class="px-6 py-3 font-semibold">
                                {{trans('system.table.heading.career_test_type')}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-left">
                                {{trans('system.table.heading.trainee_institution')}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold text-left">
                                {{trans('system.table.heading.trainee_name')}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold">
                                {{trans('system.table.heading.date_of_test')}}
                            </th>
                            <th scope="col" class="px-6 py-3 font-semibold">
                                {{trans('system.table.heading.result')}}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($results as $result)
                        <tr class="bg-white border-b dark:bg-[#1E1E1E] dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700 text-center">
                            <td scope="row" class="px-6 py-4 font-medium text-black whitespace-nowrap dark:text-white">
                                {{getCodeNameByCodeId('career_test_type', $result->test_type)}}
{{--                                {{$result->careerTest->test_name}}--}}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                {{$result->institute != '' ? $result->institute->name : 'N/G'}}
                            </td>
                            <td class="px-6 py-4 font-semibold text-left">
                                {{$result->trainee_name}}
                            </td>
                            <td class="px-6 py-4  font-medium text-[#706F81]">
                                {{date("Y-m-d", strtotime($result->created_at))}}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <span class="flex justify-center">
                                    @if($result->attachment == '' && $result->result != '')
                                    <a href="{{route('cgo.career-guidance.career-test.view-result', ['id' => $result->id])}}" target="_blank" class="flex gap-1 text-sm text-primary items-center dark:text-white">{{trans('system.action.view_more')}}
                                        <span>
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                              <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                            </svg>
                                        </span>
                                    </a>
                                    @else
                                        <a href="{{route('cgo.career-guidance.career-test.download-result', ['id' => $result->id])}}" target="_blank" class="text-primary text-xs md:text-sm flex items-center gap-1">{{trans('system.action.view')}}  <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                            </svg>
                                        </a>
                                    @endif
                                </span>
                            </td>
                        </tr>
                        @empty
                            <tr>
                                <td colspan="5">
                                    <div class="flex flex-col gap-4 justify-center items-center p-4">
                                        <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="Empty">
                                        <p class="dark:text-white">No record!</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $results->onEachSide(1)->links() }}
                </div>
            </div>
        </div>
    </div>

@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $(document).on("change","select[name='type']",function() {

                let value = $(this).val();
                let url = new URL(window.location.href);
                let param = new URLSearchParams(url.search);
                if (param.has('type')){
                    param.delete('type');
                }
                param.append('type',value);
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?'+ param.toString();
            });
            $(document).on("change","select[name='test_type']",function() {
                let value = $(this).val();
                let url = new URL(window.location.href);
                let param = new URLSearchParams(url.search);
                if (param.has('test_type')){
                    param.delete('test_type');
                }
                param.append('test_type',value);
                window.location.href = location.protocol + '//' + location.host + location.pathname + '?'+ param.toString();
            });
        });
    </script>
@endpush
