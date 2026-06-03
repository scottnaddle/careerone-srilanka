@extends('homepage.layouts.master')
@section('title', 'FAQ - Details')
@push('css')
    <style>
        .nav-tab-title h1 {
            color: #464559;
            text-align: right;

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

        .nav-button a {
            color: #464559;
        }

        .faq-container {
            display: flex;
            flex-direction: column;
            gap: 24px;
        }

        .faq-container .faq-title h1 {
            color: #4984F6;
            font-size: 30px;
            font-style: normal;
            font-weight: 600;
            line-height: 36px;
        }

        .faq-container .faq-content .faq-item {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            gap: 9px;
        }

        .faq-container .faq-content .faq-item .faq-question h2 {
            color: #201F36;
            font-size: 20px;
            font-style: normal;
            font-weight: 600;
            line-height: 28px;
        }
    </style>
@endpush
@section('content')
    <div class="flex flex-col mb-6">
        <div class="py-4 md:py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.information.root'), 'url' => '#'],
                ['label' => 'FAQ', 'url' => route('informations.notices.index', ['#faq'])],
                ['label' => trans('system.details'), 'url' => '#'],
                ['label' => $article->faq->category_name, 'url' => route('informations.faqs.show', ['id'=>$article->faq->id])],
                ['label' =>  $article->question , 'url' => '#'],
            ]" />
        </div>
        <div class="tab-container card mb-2 dark:bg-[#1E1E1E]">
            <div class="faq-container">
                <div class="faq-content">
                        <div class="faq-item mb-5">
                            <div class="faq-question">
                                <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold capitalize hover:text-primary"
                                   href="{{route('informations.faqs.show', ['id'=>$article->faq->id])}}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                         stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                    {{ $article->question }}
                                </a>
                            </div>

                            @if($article->url != '')
                                <div class="flex flex-col gap-4  py-2 rounded-xl">
                                    <p class="dark:text-white font-semibold">{{trans('admin/dashboard.career_expert_interview.table.video_url')}}:</p>
                                    <span class="">
                                        <iframe class="w-96 h-56 rounded-xl" src="{{ getYoutubeEmbedUrl($article->url) }}" frameborder="0" allowfullscreen referrerpolicy="strict-origin-when-cross-origin" ></iframe>
                                    </span>

                                </div>
                            @endif

                            @if (!empty($article->answer))
                                <div class="faq-answer text-[#706F81] bg-white rounded-lg p-4 w-full">
                                    <p class="text-[#706F81]">{!! $article->answer !!}
                                    </p>
                                </div>
                            @endif
                        </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
