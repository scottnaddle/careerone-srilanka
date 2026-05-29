@extends('homepage.layouts.master')
@section('title', 'FAQ')
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
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.information.root'), 'url' => '#'],
                ['label' => 'FAQ', 'url' => route('informations.notices.index', ['#faq'])],
                ['label' => trans('system.details'), 'url' => '#'],
            ]" />
        </div>
        <div class="tab-container card mb-2 ">
            {{--        <div class="nav-button"> --}}
            {{--            <a href="{{ route('informations.notices.index', ['#faq']) }}" class="flex items-center gap-2 text-lg font-semibold w-fit "> --}}
            {{--                <i> --}}
            {{--                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none"> --}}
            {{--                        <path d="M15.5 6L9.5 12L15.5 18" stroke="#354052" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> --}}
            {{--                    </svg> --}}
            {{--                </i> --}}
            {{--                {{ $faq->nav_title }} --}}
            {{--            </a> --}}
            {{--        </div> --}}
            <div class="faq-container ml-5">
                <div class="faq-title">
                    <h1>{{ $faq->nav_title }}</h1>
                </div>
                <div class="faq-content">
                    @foreach ($faq as $each)
                        <div class="faq-item mb-5">
                            <div class="faq-question">
                                <h2>{{ $each->ordinals }}. {{ $each->question }}</h2>
                            </div>
                            <div class="faq-answer text-[#706F81]">
                                <p class="text-[#706F81]">{!! Str::limit(strip_tags($each->answer), 250) !!}
                                @if($each->url != '' || strlen($each->answer) > 200)
                                        <a href="{{route('informations.faqs.get-article', ['id'=>$each->id])}}" target="_blank" class="underline text-primary">{{__('admin/dashboard.counseling.table.view_more')}}</a>
                                @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
@endpush
