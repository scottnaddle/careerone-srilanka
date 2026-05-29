@extends('homepage.layouts.master')
@section('title', 'CGO - Guideline')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <div class="">
            <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('homepage')],
            ['label' => 'Our sector', 'url' => '#'],
            ['label' => 'Construction', 'url' => '#']
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-10 lg:gap-16">
            {{--            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold mt-4 md:mt-8 lg:mt-13" href="{{route('homepage')}}">--}}
            {{--                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">--}}
            {{--                    <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>--}}
            {{--                </svg>--}}
            {{--                CGO--}}
            {{--            </a>--}}
            <div class="flex flex-col gap-6 items-center px-4 lg:px-16">
                <p class="text-primary dark:text-white text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-center font-semibold">Construction</p>
                {{--                <p class="text-[#706F81] dark:text-white text-sm md:text-base">--}}
                {{--                    Lorem ipsum dolor sit amet consectetur. Mattis dolor in blandit tempor accumsan ultrices malesuada diam tempor. Adipiscing fermentum senectus mi etiam cursus viverra at leo. Sollicitudin amet diam fringilla ornare odio platea. Eget pharetra nulla gravida nibh iaculis convallis tortor. Consectetur et--}}
                {{--                </p>--}}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap:4 md:gap-0 items-center px-4 lg:px-8">
                <div class="w-[90%] flex flex-col gap-6">
                    <p class="text-[#464559] dark:text-white text-2xl md:text-3xl lg:text-4xl font-semibold">Introduction to Sri Lanka’s Construction Job catagory</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">As a developing country with ambitious infrastructure goals, Sri Lanka relies on construction
                        to support urbanisation, enhance connectivity, and stimulate industrial growth. While country
                        continues to urbanise, the consistent demand for buildings, roads, bridges, ports, residential
                        and commercial spaces, and other essential infrastructure is driving rapid expansion in the
                        sector.
                    </p>
                </div>
                <div>
                    <img src="{{asset('images/sector/construction/1.webp')}}" class="rounded-xl" alt="Construction">
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <img src="{{asset('images/sector/construction/3.webp')}}" class="rounded-xl" alt="Construction">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Job Opportunities</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    The construction industry in Sri Lanka offers diverse career opportunities across several
                    specialised fields. Building Construction professionals, including construction managers,
                    site supervisors, and quality control engineers, are needed to oversee residential, commercial,
                    and industrial projects. Drafting Technologists creating detailed technical drawings across
                    fields like engineering and architecture, and Quantity Surveyors managing project costs,
                    contracts, and budgeting to maintain financial efficiency, are other key roles. Interior Design
                    Technology has gained importance as the demand for functional and eco-friendly spaces grows,
                    creating roles for Interior Designers skilled in sustainable materials and green building
                    concepts, for both residential and commercial spaces. Building Services Engineers play a
                    critical role in installing and maintaining essential systems like HVAC, plumbing, electrical,
                    and fire safety to ensure buildings are efficient and safe. Construction Equipment
                    Maintenance professionals are vital for keeping heavy machinery in optimal condition,
                    particularly for large infrastructure projects like roads and bridges. Additionally, Construction
                    Risk Officers are in demand, especially for small and medium projects, to manage risks
                    involving safety, budget, and scheduling, ensuring successful project completion.

                </p>
            </div>
            <div class="flex flex-col gap-16 px-4 lg:px-8">
                <img src="{{asset('images/sector/construction/2.webp')}}" class="rounded-xl" alt="Construction">
                <div class="flex flex-col gap-6">
                    <p class="text-2xl font-semibold text-[#464559] dark:text-white">Career Paths and Progression</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                        The construction sector offers a range of career paths, with professionals advancing from
                        technical roles to managerial positions. Building Construction Technologists can advance to
                        roles such as construction managers or project coordinators, overseeing large-scale projects.
                        Interior Designers may progress from junior roles to senior project managers or design
                        consultants, or even venture into entrepreneurship. Building Services Engineers have a path to
                        senior technical roles, including consultancy positions in HVAC, plumbing, and electrical
                        systems. Construction Equipment Technologists can advance to maintenance supervisor roles
                        or establish their own repair businesses. Risk Officers can move into senior risk management
                        positions or specialised roles in safety and contract administration, supporting project success
                        and compliance. Further, Drafting Technologists can advance to senior draughtspersons or
                        drawing office managers.

                    </p>
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <img src="{{asset('images/sector/construction/5.webp')}}" class="rounded-xl" alt="Construction">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white">Future Outlook and Industry Growth</p>
                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    Sri Lanka's construction industry is expected to continue its growth trajectory, driven by both
                    public and private sector investment in infrastructure and urban development. Key examples
                    of this growth include the Colombo Port City Project, a major urban development initiative
                    expected to transform Colombo into a financial hub. Large infrastructure projects like the
                    Central Expressway and the Jaffna Railway Upgrading Project also demonstrate the ongoing
                    need for skilled professionals in fields such as construction management, building services,
                    and construction equipment maintenance. Additionally, the rise in green building and energy-
                    efficient technologies will further expand opportunities for professionals specialising in
                    sustainable construction practices. The sector’s growth is not limited to large-scale projects.
                    The demand for small and medium construction projects, particularly in the residential sector,
                    is expected to remain strong. Whether through hands-on technical roles or management
                    positions, the future of the industry promises job security, career progression, and the chance
                    to contribute to the nation’s growth.

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
