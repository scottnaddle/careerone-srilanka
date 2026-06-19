@extends('homepage.layouts.master')
@section('title', 'TVET System - Homepage')

@section('content')
    <div class="flex flex-col gap-6 mt-6">
{{--    <p class="text-[#464559] font-semibold text-2xl dark:text-white">Test list</p>--}}
    <x-breadcrumb :items="[
        ['label' => __('system.menu.home'), 'url' => route('homepage')],
        ['label' => __('system.career_test'), 'url' => route('testnow.list')]
    ]" />
    <div class="bg-white dark:bg-[#1E1E1E] flex flex-col px-4 py-5 gap-6 justify-center items-center mb-16 rounded-xl">
        <div class="flex flex-col gap-4 items-center justify-center xl:w-[95%]">
            <p class="text-primary text-2xl md:text-3xl xl:text-4xl text-center font-semibold">{{ __('general.Occupational Psychological Test')}}:</p>
{{--            <p class="text-primary text-2xl md:text-3xl xl:text-4xl text-center font-semibold">{{ __('general.Finding Your True North')}}</p>--}}
            <p class="text-[#706F81] text-base md:text-base dark:text-white text-center">{{ __('general.Career platform job psychology tests objectively measure various psychological characteristics such as individual abilities, interests, and personalities to help you understand yourself and help you choose a career field that is more suitable for your individual characteristics.')}}</p>
        </div>
        <div class="w-full mx-auto flex flex-col gap-6 justify-center mb-6 px-6">
            <div class="flex flex-col gap-6">
                <p class="text-primary font-semibold text-2xl">{{__('general.Career Tests')}}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-2 py-3 md:px-4 md:py-6 justify-between items-center rounded-xl">
                        <div class="gap-2 flex flex-col items-center justify-center">
                            <img src="{{asset('images/test1.webp')}}" alt="Career Interest Test" class="h-64 object-cove rounded-xl">
                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{ __('general.Career Interest Test') }}</p>
                        </div>
                        <a href="{{route('testnow.attempt', ['id' => 1])}}" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">{{ __('general.Test now') }}</a>
                    </div>
                    <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-2 py-3 md:px-4 md:py-6 justify-between items-center rounded-xl">
                        <div class="gap-2 flex flex-col items-center justify-center">
                            <img src="{{asset('images/test2.webp')}}" alt="Career Key Test" class="h-64 object-cove rounded-xl">
                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{ __('general.Career Key Test') }}</p>
                        </div>
                        <a href="{{route('testnow.attempt', ['id' => 2])}}" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">{{ __('general.Test now') }}</a>
                    </div>
                </div>
            </div>
            <div class="flex flex-col gap-6">
                <p class="text-primary font-semibold text-2xl">{{__('general.NIE Tests')}}</p>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                    <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-2 py-3 md:px-4 md:py-6 justify-between items-center rounded-xl">
                            <div class="gap-2 flex flex-col items-center justify-center">
                                <img src="{{asset('images/test3.webp')}}" alt="Interest and Ability Test" class="h-64 object-cove rounded-xl">
                                <p class="text-base md:text-2xl text-primary font-semibold text-center">{{ __('general.Interest and Ability Test') }}</p>
                            </div>
                            <a href="https://guidance.nie.ac.lk/ctest/moreinfo4.html" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">{{ __('general.Test now') }}</a>
                    </div>
                    <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-2 py-3 md:px-4 md:py-6 justify-between items-center rounded-xl">
                        <div class="gap-2 flex flex-col items-center justify-center">
                            <img src="{{asset('images/test4.webp')}}" alt="Interest, Ability and Personality Test" class="h-64 object-cove rounded-xl">
                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{ __('general.Interest, Ability and Personality Test') }}</p>
                        </div>
                        <a href="https://guidance.nie.ac.lk/ctest/moreinfo5.html" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">{{ __('general.Test now') }}</a>

                    </div>
                </div>
                <p class="dark:text-white">{{trans('general.After taking the NIE test, you need to upload the results to the career platform to be used for guidance.')}}</p>
            </div>
{{--            @forelse($careerTests as $careerTest)--}}
{{--                <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-2 py-3 md:px-4 md:py-6 justify-between items-center rounded-xl">--}}
{{--                    @if($careerTest->test_type == 3)--}}
{{--                        <div class="gap-2 flex flex-col items-center justify-center">--}}
{{--                            <img src="{{asset('images/test3.png')}}" alt="" class="h-64 object-cove rounded-xl">--}}
{{--                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{$careerTest->test_name}}</p>--}}
{{--                        </div>--}}
{{--                        <a href="https://www.lankaeducator.com/ctest/moreinfo4.html" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
{{--                    @elseif($careerTest->test_type == 4)--}}
{{--                        <div class="gap-2 flex flex-col items-center justify-center">--}}
{{--                            <img src="{{asset('images/test4.png')}}" alt="" class="h-64 object-cover rounded-xl">--}}
{{--                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{$careerTest->test_name}}</p>--}}
{{--                        </div>--}}
{{--                        <a href="https://www.lankaeducator.com/ctest/moreinfo5.html" target="_blank" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
{{--                    @elseif($careerTest->test_type == 1)--}}
{{--                        <div class="gap-2 flex flex-col items-center justify-center">--}}
{{--                            <img src="{{asset('images/test1.png')}}" alt="" class="h-64 object-cover rounded-xl">--}}
{{--                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{$careerTest->test_name}}</p>--}}
{{--                        </div>--}}
{{--                        <a href="{{route('testnow.attempt', ['id' => $careerTest->id])}}" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
{{--                    @elseif($careerTest->test_type == 2)--}}
{{--                        <div class="gap-2 flex flex-col items-center justify-center">--}}
{{--                            <img src="{{asset('images/test2.png')}}" alt="" class="h-64 object-cover rounded-xl">--}}
{{--                            <p class="text-base md:text-2xl text-primary font-semibold text-center">{{$careerTest->test_name}}</p>--}}
{{--                        </div>--}}
{{--                        <a href="{{route('testnow.attempt', ['id' => $careerTest->id])}}" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-base md:text-lg px-2.5 py-1.5 md:px-5 md:py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
{{--                    @endif--}}

{{--                </div>--}}
{{--            @empty--}}
{{--                <p>There is no test</p>--}}
{{--            @endforelse--}}
            {{--            <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-4 py-6 justify-center items-center rounded-xl">--}}
            {{--                <div class="gap-2 flex flex-col items-center justify-center">--}}
            {{--                    <img src="{{asset('images/Rectangle 219.png')}}" alt="">--}}
            {{--                    <p class="text-2xl text-primary font-semibold text-center">Career Key Test</p>--}}
            {{--                </div>--}}
            {{--                <a href="{{route('testnow.attempt')}}" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-lg px-5 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
            {{--            </div>--}}
            {{--            <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-4 py-6 justify-center items-center rounded-xl">--}}
            {{--                <div class="gap-2 flex flex-col items-center justify-center">--}}
            {{--                    <img src="{{asset('images/Rectangle 219.png')}}" alt="">--}}
            {{--                    <p class="text-2xl text-primary font-semibold text-center">Interest and Ability Test</p>--}}
            {{--                </div>--}}
            {{--                <a href="{{route('testnow.attempt')}}" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-lg px-5 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
            {{--            </div>--}}
            {{--            <div class="w-full flex flex-col bg-[#E8F1FF] gap-6 px-4 py-6 justify-center items-center rounded-xl">--}}
            {{--                <div class="gap-2 flex flex-col items-center justify-center">--}}
            {{--                    <img src="{{asset('images/Rectangle 219.png')}}" alt="">--}}
            {{--                    <p class="text-2xl text-primary font-semibold text-center">Interest, Ability and Personality Test</p>--}}
            {{--                </div>--}}
            {{--                <a href="{{route('testnow.attempt')}}" class="w-full text-white bg-primary hover:bg-blue-700 focus:ring-4 focus:ring-blue-300  rounded-full text-lg px-5 py-3 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center">Test now</a>--}}
            {{--            </div>--}}
        </div>
    </div>



    </div>

@endsection
