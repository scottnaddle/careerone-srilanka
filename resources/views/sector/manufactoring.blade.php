@extends('homepage.layouts.master')
@section('title', 'CGO - Guideline')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <div class="">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('homepage')],
                ['label' => 'Our sector', 'url' => '#'],
                ['label' => 'Manufacturing', 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-10 lg:gap-16">
            {{--            <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold mt-4 md:mt-8 lg:mt-13" href="{{route('homepage')}}"> --}}
            {{--                <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none"> --}}
            {{--                    <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/> --}}
            {{--                </svg> --}}
            {{--                CGO --}}
            {{--            </a> --}}
            <div class="flex flex-col gap-6 items-center px-4 lg:px-16">
                <p
                    class="text-primary dark:text-white text-2xl md:text-3xl lg:text-4xl xl:text-5xl text-center font-semibold">
                    Manufacturing</p>
                {{--                <p class="text-[#706F81] dark:text-white text-sm md:text-base"> --}}
                {{--                    Lorem ipsum dolor sit amet consectetur. Mattis dolor in blandit tempor accumsan ultrices malesuada diam tempor. Adipiscing fermentum senectus mi etiam cursus viverra at leo. Sollicitudin amet diam fringilla ornare odio platea. Eget pharetra nulla gravida nibh iaculis convallis tortor. Consectetur et --}}
                {{--                </p> --}}
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap:4 md:gap-0 items-center px-4 lg:px-8">
                <div class="w-[90%] flex flex-col gap-6">
                    <p class="text-[#464559] dark:text-white text-2xl md:text-3xl lg:text-4xl font-semibold">Introduction to
                        Sri Lanka's Manufacturing Job catagory</p>
                    <p class="text-[#706F81] dark:text-white text-sm md:text-base">Manufacturing is a cornerstone of Sri
                        Lanka's industrial growth, blending traditional craftsmanship with modern innovation. It spans fields
                        such as engineering, material sciences, automation, and creative industries, all of which contribute
                        to local and global markets. From producing essential goods to pioneering innovations, manufacturing
                        plays a pivotal role in shaping modern lifestyles. The sector not only drives economic stability but
                        also acts as a catalyst for technological advancements, enabling industries to stay competitive in an
                        ever-evolving global landscape</p>
                </div>
                <div>
                    <img src="{{ asset('images/sector/manufactoring/2.webp') }}" class="rounded-xl" alt="Manufacturing">
                </div>
            </div>
            <div class="flex flex-col gap-6 px-4 lg:px-8">
                <img src="{{ asset('images/sector/manufactoring/3.webp') }}" class="rounded-xl" alt="Manufacturing">
                <p class="text-2xl font-semibold text-[#464559] dark:text-white text-center">Key Fields and Career
                    Opportunities </p>

                <p class="text-[#706F81] dark:text-white text-sm md:text-base">
                    <b>Engineering and Automation: </b>Roles such as Computer Numerically Controlled (CNC) Manufacturing
                    operators,
                    automation engineers, and robotics specialists focus on optimising production processes, integrating
                    artificial intelligence, and reducing human error, making them essential in advanced production
                    facilities. Opportunities also exist for those interested in robotics installation, maintenance, and
                    programming, especially in industries like automotive, electronics, and precision engineering.<br><br>

                    <b>Material Processing and Sustainability: </b>Careers in Polymer Technology, Welding Technology, and Chemical
                    Process Technology focus on transforming raw materials into innovative products. Job roles like polymer
                    engineers, welding supervisors, and chemical technologists are essential in industries ranging from
                    construction to textile dyeing and finishing. These industries drive advancements in material
                    sustainability, ensuring products meet environmental and economic standards.<br><br>
                    <b>Creative and Artistic</b> Fields:Industries like Jewellery Design and Manufacturing Technology and Digital Media Technology
                    combine artistry with technology, opening pathways for roles such as jewellery designers, CAD
                    technicians, graphic designers, and digital content creators. These careers cater to markets like
                    fashion, luxury goods, advertising, and fine art.<br><br>

                    <b>Traditional Manufacturing and Electronics: </b>Production
                    Technology and Electronic Technology continue to provide stable career roles such as production
                    supervisors, assembly line operators, and electronics engineers. These fields are vital for
                    manufacturing a wide range of consumer goods and industrial systems, including household appliances and
                    communication equipment.<br><br>

                   <b>Media and Post-Production: </b>Growth of Television Programme Production and Post-
                    Production Technology has created opportunities in media-related manufacturing. Roles like video
                    editors, sound engineers, and post-production supervisors are in demand as the industry evolves to meet
                    global content standards. Such professionals contribute to producing high-quality content for broadcast,
                    digital platforms, and entertainment industries.<br><br>

                    <b>Apparel and Footwear Manufacturing: </b>As a global leader
                    in garment production, Sri Lanka’s Apparel sector supports careers in production management, quality
                    assurance, textile technology, and fashion design. Roles such as fabric technologists, production
                    supervisors, garment technologists, merchandiser,fashion designer,bespoke tailor, and technicians,
                    executives, or managers related to apparel and footwear production.<br><br>

                   <b> Food and Seafood Technology: </b> Aiming to develop and preserve safe, high-quality food products,
                    careers include:food technologists, quality assurance managers, and production supervisors.With rising
                    global demand for high-quality food products, there are career progressions in research, regulatory
                    compliance, and international trade.<br><br>
                    <b>Career Progressions</b>
                    Career progression is robust, with opportunities to advance from technical roles to
                    leadership positions. Additionally, the sector supports entrepreneurship, enabling skilled individuals
                    to establish independent ventures.<br><br> Entry-Level Roles: welders, machine operators, technicians, and
                    assemblers.<br><br>

                    Technical Experts: CAD/CAM specialists, CNC operators, material engineers, and process
                    analysts.<br><br>

                   Supervisory and Managerial Positions: production supervisors, quality assurance managers,
                    automation engineers, and plant managers.<br><br>

                    Creative Professionals:jewellery designers, digital
                    animators, and graphic artists.<br><br>

                    Emerging Careers: Robotic Process Automation (RPA) specialists,
                    mechatronics engineers, and specialists in 3D printing and advanced manufacturing techniques.
                   <br><br>
                    <b>Future Outlook and SectorGrowth</b><br><br>
                    Sri Lanka’s manufacturing sector is evolving into a hub of innovation, blending advanced technologies  with  sustainable  practices.As  industries  evolve,  the  demand  for  technological leadership  and  skilled  professionals in  fields  like  automation,  digital  media,  and  advanced material processing will continue to rise,paving the way for a tech-driven industrial future in Sri Lanka.

                </p>
                <div>
                    <img src="{{ asset('images/sector/manufactoring/1.webp') }}" class="rounded-xl w-full" alt="Manufacturing">
                </div>
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
