@extends('homepage.layouts.master')
@section('title', 'Notice')
@push('css')
    <style>
        .nav-tab-title h1 {
            color: #464559;
            text-align: right;

            /* 30px/Semibold */
            font-family: Poppins;
            font-size: 30px;
            font-style: normal;
            font-weight: 600;
            line-height: 36px;
            /* 120% */
        }

        .tab-container {
            display: flex;
            padding: 20px 16px 48px 16px;
            flex-direction: column;
            gap: 24px;
            border-radius: 8px;
            background: #FFF;
            overflow: hidden;
        }

        /* css for tab switcher */

        .tab-switch {
            position: relative;
        }

        /* .tab-switch:after {
            content: "";
            position: absolute;
            width: 50%;
            top: 0;
            transition: left cubic-bezier(0.18, 1.14, 0.5, 1.18) 0.5s;
            border-radius: 10px;
            box-shadow: 0 2px 15px 0 rgba(0, 0, 0, .1);
            background-color: #4984F6;
            height: 100%;
            z-index: 0;
        } */

        .tab-switch.left:after {
            left: 0;
        }

        .tab-switch.right:after {
            left: 50%;
        }

        .tab-switch .btn-tab {
            display: inline-block;
            width: 50%;
            padding: 16px 10px;
            z-index: 1;
            position: relative;
            cursor: pointer;
            transition: color 200ms;
            font-size: 20px;
            font-style: normal;
            line-height: 28px;
            user-select: none;
            color: var(--text-base);
            border-radius: 10px;
        }

        .tab-switch .btn-tab[aria-selected="true"] {
            color: #FFF;
            background-color:  #4984F6;
            font-weight: 700;
        }
        .tab-switch .btn-tab[aria-selected="false"] {
            color: var(--neutral-typography-4, #91919A);
            font-family: Poppins;
            font-size: 20px;
            font-style: normal;
            font-weight: 400;
            line-height: 28px;
        }

        .tab-wrapper {
            border-radius: 10px;
            background: #F5F7FA;
            width: 100%;
            color: #91919A;
            cursor: pointer;
            gap: 10px;
            flex: 1 0 0;
            justify-content: center;
            align-items: center;
        }



        /* css for tab content */

        .tab-faq-content {
            display: flex;
            align-items: center;
            gap: 3.5%;
            row-gap: 32px;
            flex-wrap: wrap;
            align-content: space-around;
            justify-content: center;
        }

        .faq-node-container {
            display: flex;
            height: 180px;
            padding: 10px;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            border-radius: 1rem;
            /* box-shadow: 7px 7px 10.2px 0px rgba(232, 232, 232, 0.25); */
            cursor: pointer;
            -webkit-user-select: none;
            /* Safari */
            -ms-user-select: none;
            /* IE 10 and IE 11 */
            user-select: none;
            /* Standard syntax */
        }

        .faq-node-container .faq-title {
            height: 20%;
            margin: 0.5rem 0;
            border-radius: 0.3rem;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .faq-node-container .faq-title p {
            color: #FFF;
            font-family: Poppins;
            font-size: 24px;
            font-style: normal;
            font-weight: 600;
            line-height: 36px;
            text-align: center;
        }

        .faq-node-container .faq-desc {
            height: 15%;
            margin: 0.5rem 0;
            align-items: center;
            justify-content: center;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .faq-node-container .faq-desc p {
            color: #FFF;
            font-family: Poppins;
            font-size: 14px;
            font-style: normal;
            font-weight: 400;
            line-height: 22px;
            text-align: center;
        }

        .faq-node-container .faq-articles-wrapper {
            display: flex;
            height: 22%;
            margin-top: 1.5rem;
            width: 43%;
            border-radius: 5rem;
            align-items: center;
            justify-content: center;
            border: 1px solid #FFF;
        }

        .faq-node-container .faq-articles-wrapper p {
            color: #FFF;
            font-family: Poppins;
            font-size: 18px;
            font-style: normal;
            font-weight: 600;
            line-height: 24px;
        }
        .p-2_5 {
            padding: .625rem;
        }


    </style>
@endpush
@section('content')
    <div class="flex flex-col mb-6">
        <div class="flex nav-tab-title dark:text-white"></div>
        <div class="tab-container card mb-2 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            <div class=" border-gray-200 dark:border-gray-700 tab-wrapper">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center tab-switch" id="default-tab" data-tabs-toggle="#default-tab-content" role="tablist">
                    <li class="btn-tab" data-tabs-target="#notice"  role="tab" aria-controls="notice" aria-selected="false">{{__('system.menu.information.notice.notice')}}
                    </li>
                    <li class="btn-tab"  data-tabs-target="#faq" role="tab" aria-controls="faq" aria-selected="false">{{__('system.menu.information.notice.faq')}}
                    </li>
                </ul>
            </div>
            <div id="default-tab-content">
                <div class="hidden p-2_5" id="notice" role="tabpanel" aria-labelledby="notice-tab">
                    <div class="tab_panel_notice">
                        <form method="GET" action="{{ route('informations.notices.index', ['#notice']) }}">
                            <div class="flex flex-col pb-6">
                                <div class="flex gap-6 items-center">
                                    <label for="simple-search" class="sr-only">{{ __('cgo.search') }}</label>
                                    <div class="relative w-full">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                            </svg>
                                        </div>
                                        <input type="text" id="searchQuery" value="{{ request()->get('search_query') }}" name="search_query" class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="{{ __('general.Title') }}" />
                                    </div>
                                    <button type="submit" class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                        {{ __('cgo.search') }}
                                    </button>
                                </div>
                            </div>

                        <div class="flex justify-between items-center pb-6">
                            <div class="flex gap-4 flex-col">
                                @if(request()->query())
                                    @if($listNotices)
                                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{ trans_choice('cgo.result_choice',$listNotices -> total())}}</p>
                                    @endif
                                @endif
                            </div>
                            <div class="flex gap-4">
                                <select id="noticeType" name="type" class="w-full md:w-auto bg-[#F8F8F8] font-semibold border border-[#EDEDED] text-[#706F81] text-base rounded-xl focus:border-primary block p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="all">{{ __('cgo.type') }}</option>
                                    @foreach(getCodeList('notice_type') as $type)
                                        <option value="{{ strtolower($type->code_id) }}" @selected(request()->get('type') == strtolower($type->code_id))>{{ $type->code_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        </form>
                        <div class="bg-white dark:bg-[#1E1E1E] shadow-custom-light dark:shadow-custom-dark rounded-xl gap-6 flex flex-col">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-left rtl:text-right table-auto">
                                    <thead class="bg-[#F5F7FA] dark:bg-[#282828] dark:text-white text-center">
                                    <tr>
                                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.no_dot') }}
                                        </th>
                                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.type') }}
                                        </th>
                                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.title') }}
                                        </th>
                                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.registration_date') }}
                                        </th>
                                        <th scope="col" class="px-4 py-2.5 text-primary dark:text-white font-semibold text-base">
                                            {{ __('cgo.action') }}
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse( $listNotices as $index => $notice )
                                        <tr class=" bg-white dark:bg-[#1E1E1E] border-b border-[#F8F8F8] dark:border-gray-700 text-center">
                                            <td class="px-4 py-6  text-sm text-[#464559] dark:text-white">
                                                {{ ($listNotices->currentPage() - 1) * $listNotices->perPage() + $index + 1 }}
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#464559] dark:text-white">
                                                {{ getCodeNameByCodeId('notice_type', $notice->type)}}
                                            </td>
                                            <td align="left" class="">
                                            <a class="px-4 py-6 font-semibold text-sm text-[#201F36] max-w-80 dark:text-white whitespace-nowrap overflow-hidden text-ellipsis" href="{{ route('informations.notices.show', ['id' => $notice->id]) }}">  {{ Str::limit($notice->title, 50) }}</a>
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#464559] dark:text-[#C9CCD4]">
                                                {{ date('Y-m-d', strtotime($notice->created_at)) }}
                                            </td>
                                            <td class="px-4 py-6 text-sm text-[#706F81] dark:text-[#C9CCD4] flex justify-center items-center">
                                                <a href="{{ route('informations.notices.show', ['id' => $notice->id]) }}" class="text-primary flex py-2 items-center">{{ __('cgo.view_more') }} <svg xmlns="http://www.w3.org/2000/svg" width="17" height="16" viewBox="0 0 17 16" fill="none">
                                                        <path d="M6.5 12L10.5 8L6.5 4" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg></a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="flex flex-col gap-4 justify-center items-center p-4">
                                                    <img src="{{ asset('/images/empty-box.png') }}" class="opacity-50 h-32" alt="">
                                                    <p class="dark:text-white">No record!</p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse

                                    </tbody>
                                </table>

                            </div>
                        </div>
                        @if( count($listNotices) > 0  )
                            <div class="mt-3">
                                {{ $listNotices->links() }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="hidden p-2_5" id="faq" role="tabpanel" aria-labelledby="faq-tab">
                    <div class="tab_panel_faq">
                        <div class="skeleton-container">
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                            <div class="faq-skeleton">
                                <div class="line-title"></div>
                                <div class="line-desc"></div>
                                <div class="articles"></div>
                            </div>
                        </div>
                        <div class="tab-faq-content hidden"></div>
                    </div>
                </div>
            </div>

        </div>


    </div>

@endsection

@push('js')
    <script>

        function titleCase(str) {
            return str.toLowerCase().split(' ').map(function(word) {
                if (word === 'faq') return 'faq';
                return word.replace(word[0], word[0].toUpperCase());
            }).join(' ');
        }

        let defaultTitle = '{{trans('system.menu.information.notice.notice')}}';
        let titleByFragment = window.location.hash;
        if(titleByFragment == '#notice') {
            title = '{{trans('system.menu.information.notice.notice')}}';
        }else {
            title = '{{trans('system.menu.information.notice.faq')}}';
        }
        // let title = titleByFragment ? titleCase(titleByFragment.replace('#', '')) : defaultTitle;
        let addTitle = document.querySelector('.nav-tab-title');
        addTitle.innerHTML =
            `
        <div class="py-6">
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-1">
                    <li class="inline-flex items-center dark:text-white">
                        <a href="http://sri-lanka.local.com" class="inline-flex items-center font-medium text-gray-700 hover:text-gray-900 font-semibold text-base md:text-xl dark:text-white">
                            {{trans('system.menu.home')}}
                        </a>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                        </svg>
                    </li>
                    <li class="inline-flex items-center dark:text-white">
                        <span class="inline-flex items-center font-medium text-gray-700 hover:text-gray-900 font-semibold text-base md:text-xl dark:text-white">{{trans('system.menu.information.root')}}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"></path>
                        </svg>
                    </li>
                    <li class="inline-flex items-center">
                        <span class="font-medium text-gray-500 text-[#464559] font-semibold text-base md:text-xl dark:text-white">`+title+`</span>
                    </li>
                </ol>
            </nav>
        </div>`;

    </script>
    <script type="module">


        $(document).ready(function() {
            let skeletonContainer = $(".skeleton-container");
            let tabPanelFaq = $(".tab_panel_faq");
            let tabFaqContent = $(".tab-faq-content");
            let url = new URL(window.location.href);

            $('#noticeType').on('change', function() {
                if (url.searchParams.has('type')) {
                    url.searchParams.set('type', this.value);
                    url.searchParams.delete('page');
                } else {
                    url.searchParams.append('type', this.value);
                    url.searchParams.delete('page');
                }
                window.location.href = url.href;
            })
            $.ajax({
                url: "{{ route('informations.faqs.list') }}",
                type: "GET",
                success: function(response) {
                    skeletonContainer.remove();
                    tabFaqContent.removeClass("hidden");
                    let i = 0;
                    response.data.forEach(function(faq) {
                        i++;
                        let bgColor = i % 2 === 0 ? "bg-[#3B6BC9]" : "bg-[#4984F6]";
                        let details = '{{trans('system.details')}}';
                        let shortDescription = faq['description'].length > 100
                            ? faq['description'].substring(0, 100) + "..."
                            : faq['description'];
                        tabFaqContent.append(`
                            <div class="faq-node-container w-full md:w-1/3 ` + bgColor + `" data-faqid="` + faq['id'] + `" >
                            <div class="faq-title">
                                <p>` + faq['category_name'] + `</p>
                            </div>
                            <div class="faq-desc">
                                <p>` + shortDescription + `</p>
                            </div>
                            <div class="faq-articles-wrapper">
                                <p>` + faq['faq_article_count'] + ` ${details}</p>
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                                    <path d="M7 17L17 7M17 7V17M17 7H7" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </div>
                        </div>
                        `);
                    });

                    let faqNodeContainer = $(".faq-node-container");
                    faqNodeContainer.on("click", function() {
                        let faqId = $(this).attr("data-faqid");
                        window.location.href = "{{ route('informations.faqs.show', ':id') }}"
                            .replace(':id', faqId);
                    });
                }
            });
        })
    </script>
@endpush
