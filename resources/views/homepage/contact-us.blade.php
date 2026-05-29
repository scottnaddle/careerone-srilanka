@extends('homepage.layouts.master')
@section('title', 'Contact us')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-4 md:py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.about_us'), 'url' => '#'],
                ['label' => trans('system.menu.contact_us'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-7 md:px-14 pb-7 flex flex-col gap-4 md:gap-6 pb-10">
            <div  class="flex flex-col gap-4 md:gap-6  mt-6">
                <p class="text-primary text-xl md:text-2xl lg:text-3xl font-semibold">{{ __('general.Get in touch')}}</p>
                <p class="text-sm md:text-base xl:text-lg text-[#475467] dark:text-white">{{ __('general.Our friendly team would love to hear from you.')}}</p>
            </div>
            <div class="flex flex-col md:flex-row gap-6 md:gap-16">
                <div class="flex flex-col md:gap-12 gap-6 w-full md:w-3/12">
                    <div class="flex gap-4 items-start">
                        <span class="p-3 rounded-full bg-[#EDF6FF]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M22.5 6C22.5 4.9 21.6 4 20.5 4H4.5C3.4 4 2.5 4.9 2.5 6M22.5 6V18C22.5 19.1 21.6 20 20.5 20H4.5C3.4 20 2.5 19.1 2.5 18V6M22.5 6L12.5 13L2.5 6" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div class="flex-col flex gap-4 w-full">
                            <p class="text-xl font-semibold text-[#201F36] dark:text-white">{{trans('general.email')}}</p>
                            <p class="text-sm md:text-base text-[#464559] dark:text-white">{{ __('general.Our friendly team is here to help.')}}</p>
                            <p class="text-sm md:text-base text-primary font-semibold w-full overflow-auto">careerone@tvec.gov.lk</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="p-3 rounded-full bg-[#EDF6FF]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M21.5 10C21.5 17 12.5 23 12.5 23C12.5 23 3.5 17 3.5 10C3.5 7.61305 4.44821 5.32387 6.13604 3.63604C7.82387 1.94821 10.1131 1 12.5 1C14.8869 1 17.1761 1.94821 18.864 3.63604C20.5518 5.32387 21.5 7.61305 21.5 10Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M12.5 13C14.1569 13 15.5 11.6569 15.5 10C15.5 8.34315 14.1569 7 12.5 7C10.8431 7 9.5 8.34315 9.5 10C9.5 11.6569 10.8431 13 12.5 13Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div class="flex-col flex gap-4 w-full">
                            <p class="text-xl font-semibold text-[#201F36] dark:text-white">{{ __('general.Office')}}</p>
                            <p class="text-sm md:text-base text-[#464559] dark:text-white">{{ __('general.Come say hello at our office HQ.')}}</p>
                            <p class="text-sm md:text-base text-primary font-semibold">354/2 Elvitigala Mawatha, <br> Colombo 00500, Sri Lanka</p>
                        </div>
                    </div>
                    <div class="flex gap-4 items-start">
                        <span class="p-3 rounded-full bg-[#EDF6FF]">
                            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="24" viewBox="0 0 25 24" fill="none">
                            <path d="M22.4994 16.92V19.92C22.5006 20.1985 22.4435 20.4741 22.332 20.7293C22.2204 20.9845 22.0567 21.2136 21.8515 21.4018C21.6463 21.5901 21.404 21.7335 21.1402 21.8227C20.8764 21.9119 20.5968 21.945 20.3194 21.92C17.2423 21.5856 14.2864 20.5341 11.6894 18.85C9.27327 17.3146 7.22478 15.2661 5.68945 12.85C3.99942 10.2412 2.94769 7.27097 2.61944 4.17997C2.59446 3.90344 2.62732 3.62474 2.71595 3.3616C2.80457 3.09846 2.94702 2.85666 3.13421 2.6516C3.32141 2.44653 3.54925 2.28268 3.80324 2.1705C4.05722 2.05831 4.33179 2.00024 4.60945 1.99997H7.60945C8.09475 1.9952 8.56524 2.16705 8.93321 2.48351C9.30118 2.79996 9.54152 3.23942 9.60944 3.71997C9.73607 4.68004 9.97089 5.6227 10.3094 6.52997C10.444 6.8879 10.4731 7.27689 10.3934 7.65086C10.3136 8.02482 10.1283 8.36809 9.85944 8.63998L8.58945 9.90997C10.013 12.4135 12.0859 14.4864 14.5894 15.91L15.8594 14.64C16.1313 14.3711 16.4746 14.1858 16.8486 14.1061C17.2225 14.0263 17.6115 14.0554 17.9694 14.19C18.8767 14.5285 19.8194 14.7634 20.7794 14.89C21.2652 14.9585 21.7088 15.2032 22.026 15.5775C22.3431 15.9518 22.5116 16.4296 22.4994 16.92Z" stroke="#4984F6" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </span>
                        <div class="flex-col flex gap-4 w-full">
                            <p class="text-xl font-semibold text-[#201F36] dark:text-white">{{ __('general.Phone')}}</p>
                            <p class="text-sm md:text-base text-[#464559] dark:text-white">{{ __('general.Mon-Fri from 8.30 am to 4.30 pm.')}}</p>
                            <p class="text-sm md:text-base text-primary font-semibold">Industrial Liaison Division: 0117608040</p>
                        </div>
                    </div>
                </div>
                <div class="w-full md:w-9/12 cursor-pointer" onclick="window.location.href = 'https://maps.app.goo.gl/MkGzwZgYXSY5jsK17'">
                    <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d61570.33105436858!2d79.87936324570275!3d6.901970985950395!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a2abbb44707%3A0x683aeb0bd3e0c78e!2sTertiary%20%26%20Vocational%20Education%20Commission!5e0!3m2!1sen!2sus!4v1738634197225!5m2!1sen!2sus" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" class="w-full"></iframe>
{{--                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d65098722.89088757!2d-4.920168400000019!3d5.213781800000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae25a2abbb44707%3A0x683aeb0bd3e0c78e!2sTertiary%20%26%20Vocational%20Education%20Commission!5e0!3m2!1sen!2s!4v1719819110613!5m2!1sen!2s&z=150" class="w-full" height="550" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>--}}
                </div>
            </div>


{{--            <div class="relative overflow-x-auto flex flex-col gap-4">--}}
{{--                <p class="text-lg text-primary font-semibold">{{trans('system.contact_details')}}</p>--}}

{{--                <div class="relative overflow-x-auto border dark:border-white rounded-xl">--}}
{{--                    <table class="w-full text-base text-left rtl:text-right dark:text-white  overflow-hidden">--}}
{{--                        <tbody>--}}
{{--                        <tr>--}}
{{--                            <th scope="col" class="px-4 py-2 bg-blue-100 text-primary border border-gray-300" colspan="4">--}}
{{--                                Tertiary and Vocational Education Commission--}}
{{--                            </th>--}}
{{--                        </tr>--}}
{{--                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-300">--}}
{{--                            <th class="px-4 py-2 border border-gray-300">Designation</th>--}}
{{--                            <th class="px-4 py-2 border border-gray-300">Officer Name</th>--}}
{{--                            <th class="px-4 py-2 border border-gray-300">Mobile Contact</th>--}}
{{--                            <th class="px-4 py-2 border border-gray-300">E-mail</th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Chairman</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Dr. G.L. Dharmasiri Wickramasinghe</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300"></td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">chairman@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Director General</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Dr. K. A. Lalithadheera</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0714494018</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">dg@tvec.gov.lk</td>--}}
{{--                        </tr>--}}


{{--                        <tr>--}}
{{--                            <th scope="col" class="px-4 py-2 bg-blue-100 text-primary border border-gray-300" colspan="4">--}}
{{--                                Industrial Liaison Division--}}
{{--                            </th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. Manjula Vidanapatirana</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0714817629</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">manjula@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Assistant Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. Vajira Bandara</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0763270423</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">wijesinghe@tvec.gov.lk</td>--}}
{{--                        </tr>--}}

{{--                        <tr>--}}
{{--                            <th scope="col" class="px-4 py-2 bg-blue-100 text-primary border border-gray-300" colspan="4">--}}
{{--                                Information Systems Division--}}
{{--                            </th>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. G.A.M.U.Ganepola</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0777313719</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">manoj@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Deputy Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. Chammika Gunathilake</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0773630471</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">chammika@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Assistant Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. Lasantha Karunadasa</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0715378752</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">lasantha@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Assistant Director</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">Mr. H.B. Indika Sampath</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">0714433705</td>--}}
{{--                            <td class="px-4 py-2 border border-gray-300">indika@tvec.gov.lk</td>--}}
{{--                        </tr>--}}
{{--                        </tbody>--}}
{{--                    </table>--}}


{{--                </div>--}}

{{--            </div>--}}

        </div>
    </div>
@endsection
