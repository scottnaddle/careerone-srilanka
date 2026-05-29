@extends('homepage.layouts.master')
@section('title', 'ICT')

@section('content')
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold"></p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('homepage')],
            ['label' => 'Our sector', 'url' => '#'],
            ['label' => 'Tourism', 'url' => '#']
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 lg:gap-8">
            {{--            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold mt-4 md:mt-8 lg:mt-13" href="{{route('homepage')}}">--}}
            {{--                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">--}}
            {{--                    <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
            {{--                </svg>--}}
            {{--                ICT--}}
            {{--            </a>--}}
            <div class="flex flex-col gap-6 items-center px-4 lg:px-16">
                <p class="text-primary dark:text-white text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-center font-semibold">Tourism</p>
                {{--                <p class="text-[#706F81] dark:text-white text-sm md:text-base">--}}
                {{--                    Lorem ipsum dolor sit amet consectetur. Mattis dolor in blandit tempor accumsan ultrices malesuada diam tempor. Adipiscing fermentum senectus mi etiam cursus viverra at leo. Sollicitudin amet diam fringilla ornare odio platea. Eget pharetra nulla gravida nibh iaculis convallis tortor. Consectetur et--}}
                {{--                </p>--}}
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <img src="{{asset('images/sector/tourism/6.webp')}}" class="rounded-xl" alt="Tourism">
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap:4 md:gap-0 items-center px-4 lg:px-8">
                <div class="w-[90%] flex flex-col gap-6">
                    <p class="text-[#464559] dark:text-white text-2xl md:text-3xl lg:text-4xl font-semibold">Introduction to Sri Lanka’s Tourism and Hospitality Job catagory</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">Sri Lanka, often called the "Pearl of the Indian Ocean," is a captivating destination where
                        golden beaches meet lush landscapes, and ancient history blends seamlessly with modern
                        luxury. This diverse island is not only a cultural treasure trove but also a rapidly growing hub
                        for global tourism and hospitality. As millions of tourists visit each year, the tourism and
                        hospitality sector stand at the heart of Sri Lanka’s economic growth, fueling job creation,
                        innovation, and cross-cultural exchange. From world-class resorts and cutting-edge culinary
                        experiences to immersive cultural tours and unforgettable events, this sector offers a wealth of
                        opportunities for those eager to build dynamic careers in an industry that is as varied as it is
                        vibrant. </p>
                </div>
                <div>
                    <img src="{{asset('images/sector/tourism/5.webp')}}" class="rounded-xl" alt="Tourism">
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Job Opportunities and Career Pathways</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    Common entry-level positions include roles like Front Desk Clerk, Event Co-ordinator, Tour
                    Operator, Housekeeper, and restaurant staff. As professionals gain experience, they can
                    advance to higher management roles, including Hotel or Resort Manager, Tourism Marketing
                    Manager, and Food & Beverages Manager, Head Chef, Events Manager, Travel Agency
                    Manager, Tourist Information Centre Manager, Accountant or Sales Manager, and Guest
                    Relations Manager. Moreover, there are increasing opportunities for entrepreneurs, especially
                    within the travel, event management, and accommodation fields, driven by the rising influx of
                    international tourists, and the expanding domestic market.
                </p>
            </div>
            <div class="flex flex-col gap-16 px-4 lg:px-8">
                <img src="{{asset('images/sector/tourism/4.webp')}}" class="rounded-xl" alt="Tourism">
                <div class="flex flex-col gap-6">
                    <p class="text-2xl font-semibold text-[#464559] dark:text-white">Essential Components of the Thriving Tourism Industry</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                        Event Management has become a crucial aspect of Sri Lanka's tourism growth, especially with
                        the rise of MICE tourism. As Sri Lanka continues to establish itself as a premier destination
                        for business travel, the demand for conferences, corporate events, incentive trips, and
                        exhibitions has surged. Culinary operations and food & beverage services are other essential
                        components. With the rise in demand for both local and international cuisine, there are
                        abundant opportunities whether it is in fine dining restaurants, hotels, casual cafes, or catering
                        services. The rise in demand for food festivals and gastronomy tours further highlights the
                        importance of culinary expertise in the tourism job catagory.
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Job catagory Growth and Employment Prospects</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    Tourism in Sri Lanka is one of the fastest-growing industries, with the country continuously
                    attracting increasing numbers of tourists. As a result, the demand for qualified professionals
                    across all segments of the hospitality and tourism industry is expected to rise. The industry is
                    also seeing continuous growth in niche markets such as eco-tourism ensuring that the tourism
                    industry’s growth does not come at the expense of Sri Lanka’s natural resources, wellness
                    tourism, and heritage tourism. These areas offer unique opportunities for professionals skilled
                    in sustainable tourism management, cultural heritage preservation, and tourism-led
                    regeneration.
                </p>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    For more or updated information of occupation visit this website: <a class="hover:text-primary underline dark:text-white break-words" href="https://www.nvq.gov.lk/Report_Inquires/Search_Skill.php
" target="_blank">https://www.nvq.gov.lk/Report_Inquires/Search_Skill.php
                    </a>
                </p>
            </div>
        </div>
    </div>
@endsection
