@extends('homepage.layouts.master')
@section('title', 'ICT')

@section('content')
    <div class="mb-6 flex flex-col">
{{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold"></p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('homepage')],
            ['label' => 'Our sector', 'url' => '#'],
            ['label' => 'ICT', 'url' => '#']
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
                <p class="text-primary dark:text-white text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-center font-semibold">ICT</p>
{{--                <p class="text-[#706F81] dark:text-white text-sm md:text-base">--}}
{{--                    Lorem ipsum dolor sit amet consectetur. Mattis dolor in blandit tempor accumsan ultrices malesuada diam tempor. Adipiscing fermentum senectus mi etiam cursus viverra at leo. Sollicitudin amet diam fringilla ornare odio platea. Eget pharetra nulla gravida nibh iaculis convallis tortor. Consectetur et--}}
{{--                </p>--}}
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
{{--                <img src="{{asset('images/sector.png')}}" class="rounded-xl" alt="">--}}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap:4 md:gap-0 items-center px-4 lg:px-8">
                <div class="w-[90%] flex flex-col gap-6">
                    <p class="text-[#464559] dark:text-white text-2xl md:text-3xl lg:text-4xl font-semibold">Introduction to Sri Lanka’s Information and Communication Technology Job catagory</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">ICT plays a critical role in today’s digital economy, impacting nearly every job catagory by providing
                        solutions for businesses, government, healthcare, finance, education, and beyond. The sector
                        has grown significantly due to investments in digital infrastructure, and an increasing emphasis
                        on tech education. These factors have enabled Sri Lanka to attract numerous multinational
                        companies and work on projects for global clients, particularly in markets such as the United
                        States, the United Kingdom, and the Asia-Pacific region. As digital technology rapidly expands
                        across industries in Sri Lanka, ICT continues to create diverse career opportunities for skilled
                        professionals, particularly those with expertise in technical fields, innovation, and digital
                        problem-solving.</p>
                </div>
                <div>
                    <img src="{{asset('images/sector/ict/2.webp')}}" class="rounded-xl" alt="ICT">
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Careers in Information and Cyber Security</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    Given that organisations today store vast amounts of sensitive information: financial records,
                    personal data, and intellectual property – cybersecurity professionals play a central role in
                    defending networks, systems, and applications against an ever-evolving landscape of cyber
                    threats. This field is crucial for protecting the interests of public and private entities in sectors
                    like finance, healthcare, telecommunications, and government, where data breaches could have
                    severe consequences. Careers in Cyber Security include roles like: Cybersecurity Specialist,
                    Security Analyst, Penetration Tester, and Security Engineer.
                </p>
            </div>
            <div class="flex flex-col gap-16 px-4 lg:px-8">
                <img src="{{asset('images/sector/ict/1.webp')}}" class="rounded-xl" alt="ICT">
                <div class="flex flex-col gap-6">
                    <p class="text-2xl font-semibold text-[#464559] dark:text-white">Careers in Computer System Design and Software Development</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                        System Design, and Software Development are other core areas within ICT. System Designers
                        and Software Developers are responsible for creating and optimising applications that
                        streamline business operations, enhance user experiences, and support industry-specific needs.
                        Professionals in this field focus on programming, software testing, and application deployment,
                        ensuring that systems run efficiently and are user-friendly. These skills are critical for building
                        software solutions that meet both client and consumer needs in an increasingly digital world.
                        This is a high-demand field with roles like: Software Engineer, Quality Assurance Engineer,
                        Full-Stack Developer, Front-End/Back-End Developer, Database Administrator, UX/UI
                        Designer, Systems Analyst, DevOps Engineer, Mobile Application Developer, Technical
                        Support Specialist etc.
                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">ICT Job catagory Growth and Economic Impact</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    The sector has become one of the country’s leading service exports, with numerous job
                    prospects for roles such as Software Developers, Network Engineers, and Business Analysts.
                    The rise of global digital transformation has led international companies to outsource IT and
                    software development needs to skilled professionals in Sri Lanka, creating a vibrant job market
                    for ICT talent. Also, there is high demand for Graphic Designers, 3D Animators, and VFX
                    Artists
                </p>
                <img src="{{asset('images/sector/ict/4.webp')}}" class="rounded-xl" alt="ICT">
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Career Progression in ICT</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    Career paths in ICT can be diverse, with professionals moving from entry-level roles, such as
                    Technicians or Junior Developers, to specialised positions, including Cybersecurity Analysts,
                    Data scientists, and Systems Architects. By gaining experience and pursuing continuous skill
                    development, ICT professionals can also advance to senior roles, such as Project Managers,
                    Chief Information Officers, or Lead Security Architects. Professionals entering this field can
                    look forward to rewarding, impactful careers that span multiple industries, support digital
                    innovation, and meet the evolving needs of a digital society.
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
