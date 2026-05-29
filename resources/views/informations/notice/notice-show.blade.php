@extends('homepage.layouts.master')
@section('title', 'Notice')
@push('css')
    <style>

        .ck-editor__editable_inline {
            min-height: 200px;
        }

        #container {
            width: 1000px;
            margin: 20px auto;
        }

        .ck-editor__editable[role="textbox"] {
            /* Editing area */
            min-height: 200px;
        }

        .ck-content .image {
            /* Block images */
            max-width: 80%;
            margin: 20px auto;
        }
    </style>


@endpush
@section('content')
{{--    <p class="text-3xl py-4 text-[#464559] font-semibold dark:text-white">{{  }}</p>--}}
    <div class="py-6">
        <x-breadcrumb :items="[
            ['label' => trans('system.menu.home'), 'url' => route('homepage')],
            ['label' => trans('system.menu.information.root'), 'url' => '#'],
            ['label' => __('cgo.notice'), 'url' => route('informations.notices.index')],
            ['label' =>'Detail', 'url' => '#'],
        ]" />
    </div>
    <div class="flex flex-col gap-5 bg-white rounded-xl p-6 mb-10 dark:bg-[#1E1E1E] dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
        <div class="flex flex-col gap-5 border border-gray-300 dark:border-white p-4 rounded-xl">
            <div class="text-primary text-2xl font-semibold dark:text-white flex items-center gap-1">{{$notice->title}} <span class="text-sm px-2.5 py-1 rounded shadow-xs text-white bg-primary">
                    {{ getCodeNameByCodeId('notice_type', $notice->type) }}
                </span>
            </div>
            <div class="flex gap-10">
                <p class="text-xs font-semibold text-primary flex gap-1 justify-center items-center dark:text-white">
                    <span><svg width="16" height="16" viewBox="0 0 17 16" fill="none"
                               xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14.5 6.66634H2.5M11.1667 1.33301 V3.99967M5.83333 1.33301V3.99967M5.7 14.6663H11.3C12.4201 14.6663 12.9802 14.6663 13.408 14.4484C13.7843 14.2566 14.0903 13.9506 14.282 13.5743C14.5 13.1465 14.5 12.5864 14.5 11.4663V5.86634C14.5 4.74624 14.5 4.18618 14.282 3.75836C14.0903 3.38204 13.7843 3.07607 13.408 2.88433C12.9802 2.66634 12.4201 2.66634 11.3 2.66634H5.7C4.5799 2.66634 4.01984 2.66634 3.59202 2.88433C3.21569 3.07607 2.90973 3.38204 2.71799 3.75836C2.5 4.18618 2.5 4.74624 2.5 5.86634V11.4663C2.5 12.5864 2.5 13.1465 2.71799 13.5743C2.90973 13.9506 3.21569 14.2566 3.59202 14.4484C4.01984 14.6663 4.5799 14.6663 5.7 14.6663Z"
                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                stroke-linejoin="round" />
                        </svg>
                    </span>{{ date("Y-m-d", strtotime($notice->created_at)) }}
                </p>

                <p class="text-xs font-semibold text-primary flex gap-1 justify-center items-center  dark:text-white">
                    <span><svg width="16" height="16" viewBox="0 0 15 14" fill="none"
                               xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5.4987 9.33333H4.4987C3.56832 9.33333 3.10313 9.33333 2.7246 9.44816C1.87233 9.70669 1.20539 10.3736 0.946858 11.2259C0.832031 11.6044 0.832031 12.0696 0.832031 13M9.16536 4C9.16536 5.65685 7.82222 7 6.16536 7C4.50851 7 3.16536 5.65685 3.16536 4C3.16536 2.34315 4.50851 1 6.16536 1C7.82222 1 9.16536 2.34315 9.16536 4ZM6.83203 13L8.8996 12.4093C8.99861 12.381 9.04812 12.3668 9.09429 12.3456C9.13529 12.3268 9.17427 12.3039 9.21064 12.2772C9.25159 12.2471 9.288 12.2107 9.36081 12.1379L13.6654 7.83336C14.1256 7.37311 14.1256 6.62689 13.6654 6.16665C13.2051 5.70642 12.4589 5.70642 11.9987 6.16666L7.69414 10.4712C7.62133 10.544 7.58492 10.5804 7.55486 10.6214C7.52816 10.6578 7.50522 10.6967 7.4864 10.7377C7.4652 10.7839 7.45105 10.8334 7.42276 10.9324L6.83203 13Z"
                                stroke="#4F92ED" stroke-width="1.5" stroke-linecap="round" class="dark:stroke-white"
                                stroke-linejoin="round" />
                        </svg>
                    </span>{{ $notice->author->fullName ??'No Name' }}
                </p>
            </div>
            <div class="ck-content min-h-72 rounded-xl p-4 dark:bg-white">
                {!! $notice->description !!}
            </div>
        </div>


    </div>

@endsection
@push('js')

@endpush
