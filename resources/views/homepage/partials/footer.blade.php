<footer class="bg-white dark:bg-[#1E1E1E]  w-full mt-6">
    <div class="max-w-[1440px] xl:px-[54px] mx-auto">
        <div class="border-y border-gray-300 flex divide-x relative">
            <!-- Family Site Button -->
            <button id="family-site-button" type="button" class="w-48 md:w-64 text-primary bg-gray-50 hover:bg-gray-100 font-medium px-5 py-2.5 text-center dark:bg-blue-100 ">
                {{__('system.links')}}
            </button>

            <!-- Family Site Tooltip -->
            <div id="tooltip-click1" class="w-48 md:w-64 absolute top-full left-0 z-10 hidden flex flex-col gap-1 p-4 bg-white rounded-b-lg shadow-lg dark:bg-gray-700 h-auto overflow-y-auto">
                <a href="https://skillsmin.gov.lk/" class="dark:text-white hover:text-primary " target="_blank">NIE</a>
                <a href="https://nvq.gov.lk/Home/index2.htm" class="dark:text-white hover:text-primary " target="_blank">NVQ</a>
                <a href="https://nsp.gov.lk/" class="dark:text-white hover:text-primary " target="_blank">SKILLS PASSPORT</a>
                <a href="https://www.tvec.gov.lk/" class="dark:text-white hover:text-primary " target="_blank">TVEC</a>
                <a href="https://www.nvq.gov.lk/TVET_GUIDE/" class="dark:text-white hover:text-primary " target="_blank">TVET Guide</a>
            </div>

            <!-- Related Organizations Button -->
            <button id="related-orgs-button" type="button" class="w-48 md:w-64 text-primary bg-gray-50 hover:bg-gray-100 font-medium px-5 py-2.5 text-center  ">
                {{__('system.related_institutes')}}
            </button>

            <!-- Related Organizations Tooltip -->
            <div id="tooltip-click2" class="w-48 md:w-64 absolute top-full left-48 md:left-64 z-10 hidden flex flex-col gap-1 p-4 bg-white rounded-b-lg shadow-lg dark:bg-gray-700 h-auto overflow-y-auto">
                <a href="https://uovt.ac.lk/" class="dark:text-white hover:text-primary " target="_blank">UNIVOTEC</a>
                <a href="https://naita.gov.lk/naitahome/naita-trade-list-2/" class="dark:text-white hover:text-primary " target="_blank">NAITA</a>
                <a href="https://dtet.gov.lk/en/" class="dark:text-white hover:text-primary " target="_blank">DTET</a>
                <a href="https://course.vta.lk/" class="dark:text-white hover:text-primary " target="_blank">VTA</a>
                <a href="https://ocu.ac.lk/" class="dark:text-white hover:text-primary " target="_blank">Ocean University</a>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('family-site-button').addEventListener('click', function () {
            const tooltip = document.getElementById('tooltip-click1');
            tooltip.classList.toggle('hidden');
            document.getElementById('tooltip-click2').classList.add('hidden'); // Hide other tooltip
        });

        document.getElementById('related-orgs-button').addEventListener('click', function () {
            const tooltip = document.getElementById('tooltip-click2');
            tooltip.classList.toggle('hidden');
            document.getElementById('tooltip-click1').classList.add('hidden'); // Hide other tooltip
        });

        // Optional: Close tooltips when clicking outside
        document.addEventListener('click', function (event) {
            if (!event.target.closest('#family-site-button') && !event.target.closest('#tooltip-click1')) {
                document.getElementById('tooltip-click1').classList.add('hidden');
            }
            if (!event.target.closest('#related-orgs-button') && !event.target.closest('#tooltip-click2')) {
                document.getElementById('tooltip-click2').classList.add('hidden');
            }
        });
    </script>
    <div class="mx-auto w-full max-w-[1440px] xl:px-[54px] p-6 md:p-8 xl:px-14 xl:pt-12 xl:pb-6">
        <div class="grid md:grid-cols-3 sm:grid-cols-1 xl:gap-44  gap-4 md:gap-10 lg:gap-20">
            <div class="flex gap-4 flex-col ">
                <a href="/" class="flex items-center">
                    <img loading="lazy" src="{{asset('images/careerone-logo.webp')}}" class="me-3 h-12 md:h-16 block dark:hidden" width="" height="" alt="TVET Logo" />
                    <img loading="lazy" src="{{asset('/images/careerone-logo-dark.webp')}}" class="me-3 h-12 md:h-16 hidden dark:block" alt="TVET Logo" />
                </a>
                <h1 class="text-xs text-[#706F81] dark:text-white">{{ __('general."Career one" aims to provide high-quality career guidance for trainees with high-level vocational skills in Sri Lanka') }}</h1>
{{--                <a href="{{route('homepage.contact-us')}}" class="font-semibold text-primary dark:text-white  md:text-lg">Contact us</a>--}}
            </div>
            <div class="flex flex-col gap-6 justify-center">
                <p class="font-semibold text-primary dark:text-white md:text-xl md:text-center">{{ __('general.Get the app') }}</p>
                <div class="flex gap-5">
                    <a href="https://apps.apple.com/vn/app/careerone-lankas-career-hub/id6743777719" target="_blank">
                        <img src="{{asset('images/appstore.webp')}}" loading="lazy" alt="Appstore">
                    </a>
                    <a href="https://play.google.com/store/apps/details?id=com.tvec.careerone" target="_blank">
                        <img loading="lazy" src="{{asset('images/chplay.webp')}}" alt="Google play"></a>

                </div>
            </div>
            <div class="flex flex-col gap-6 justify-center">
                <p class="font-semibold text-primary dark:text-white md:text-xl text-center">{{ __('general.Follow us') }}</p>
                <div class="flex gap-4 justify-center">
                    <a href="https://www.facebook.com/profile.php?id=61560884938489" target="_blank" class="text-[#91919A] dark:text-white hover:text-primary dark:text-white">
                        <svg class="w-6 h-6" viewBox="0 0 48 48" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">

                            <title>Facebook-color</title>
                            <desc>Created with Sketch.</desc>
                            <defs>

                            </defs>
                            <g id="Icons" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <g id="Color-" transform="translate(-200.000000, -160.000000)" fill="#4460A0">
                                    <path d="M225.638355,208 L202.649232,208 C201.185673,208 200,206.813592 200,205.350603 L200,162.649211 C200,161.18585 201.185859,160 202.649232,160 L245.350955,160 C246.813955,160 248,161.18585 248,162.649211 L248,205.350603 C248,206.813778 246.813769,208 245.350955,208 L233.119305,208 L233.119305,189.411755 L239.358521,189.411755 L240.292755,182.167586 L233.119305,182.167586 L233.119305,177.542641 C233.119305,175.445287 233.701712,174.01601 236.70929,174.01601 L240.545311,174.014333 L240.545311,167.535091 C239.881886,167.446808 237.604784,167.24957 234.955552,167.24957 C229.424834,167.24957 225.638355,170.625526 225.638355,176.825209 L225.638355,182.167586 L219.383122,182.167586 L219.383122,189.411755 L225.638355,189.411755 L225.638355,208 L225.638355,208 Z" id="Facebook">

                                    </path>
                                </g>
                            </g>
                        </svg>
                        <span class="sr-only">Facebook page</span>
                    </a>
                    <a href="https://www.instagram.com/career_onelk/" target="_blank" class="text-[#91919A] dark:text-white hover:text-primary dark:text-white">
                        <svg class="w-6 h-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 0 551.034 551.034" xml:space="preserve">
                            <g id="XMLID_13_">

                                <linearGradient id="XMLID_2_" gradientUnits="userSpaceOnUse" x1="275.517" y1="4.5714" x2="275.517" y2="549.7202" gradientTransform="matrix(1 0 0 -1 0 554)">
                                    <stop  offset="0" style="stop-color:#E09B3D"/>
                                    <stop  offset="0.3" style="stop-color:#C74C4D"/>
                                    <stop  offset="0.6" style="stop-color:#C21975"/>
                                    <stop  offset="1" style="stop-color:#7024C4"/>
                                </linearGradient>
                                <path id="XMLID_17_" style="fill:url(#XMLID_2_);" d="M386.878,0H164.156C73.64,0,0,73.64,0,164.156v222.722
                                    c0,90.516,73.64,164.156,164.156,164.156h222.722c90.516,0,164.156-73.64,164.156-164.156V164.156
                                    C551.033,73.64,477.393,0,386.878,0z M495.6,386.878c0,60.045-48.677,108.722-108.722,108.722H164.156
                                    c-60.045,0-108.722-48.677-108.722-108.722V164.156c0-60.046,48.677-108.722,108.722-108.722h222.722
                                    c60.045,0,108.722,48.676,108.722,108.722L495.6,386.878L495.6,386.878z"/>

                                <linearGradient id="XMLID_3_" gradientUnits="userSpaceOnUse" x1="275.517" y1="4.5714" x2="275.517" y2="549.7202" gradientTransform="matrix(1 0 0 -1 0 554)">
                                    <stop  offset="0" style="stop-color:#E09B3D"/>
                                    <stop  offset="0.3" style="stop-color:#C74C4D"/>
                                    <stop  offset="0.6" style="stop-color:#C21975"/>
                                    <stop  offset="1" style="stop-color:#7024C4"/>
                                </linearGradient>
                                <path id="XMLID_81_" style="fill:url(#XMLID_3_);" d="M275.517,133C196.933,133,133,196.933,133,275.516
                                    s63.933,142.517,142.517,142.517S418.034,354.1,418.034,275.516S354.101,133,275.517,133z M275.517,362.6
                                    c-48.095,0-87.083-38.988-87.083-87.083s38.989-87.083,87.083-87.083c48.095,0,87.083,38.988,87.083,87.083
                                    C362.6,323.611,323.611,362.6,275.517,362.6z"/>

                                <linearGradient id="XMLID_4_" gradientUnits="userSpaceOnUse" x1="418.306" y1="4.5714" x2="418.306" y2="549.7202" gradientTransform="matrix(1 0 0 -1 0 554)">
                                    <stop  offset="0" style="stop-color:#E09B3D"/>
                                    <stop  offset="0.3" style="stop-color:#C74C4D"/>
                                    <stop  offset="0.6" style="stop-color:#C21975"/>
                                    <stop  offset="1" style="stop-color:#7024C4"/>
                                </linearGradient>
                                <circle id="XMLID_83_" style="fill:url(#XMLID_4_);" cx="418.306" cy="134.072" r="34.149"/>
                            </g>
                            </svg>
                        <span class="sr-only">Instagram</span>
                    </a>
                    <a href="https://www.linkedin.com/company/career-one-sri-lanka/posts/?feedView=all" target="_blank" class="text-[#91919A] dark:text-white hover:text-primary dark:text-white">
                        <svg class="w-6 h-6" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="none"><path fill="#0A66C2" d="M12.225 12.225h-1.778V9.44c0-.664-.012-1.519-.925-1.519-.926 0-1.068.724-1.068 1.47v2.834H6.676V6.498h1.707v.783h.024c.348-.594.996-.95 1.684-.925 1.802 0 2.135 1.185 2.135 2.728l-.001 3.14zM4.67 5.715a1.037 1.037 0 01-1.032-1.031c0-.566.466-1.032 1.032-1.032.566 0 1.031.466 1.032 1.032 0 .566-.466 1.032-1.032 1.032zm.889 6.51h-1.78V6.498h1.78v5.727zM13.11 2H2.885A.88.88 0 002 2.866v10.268a.88.88 0 00.885.866h10.226a.882.882 0 00.889-.866V2.865a.88.88 0 00-.889-.864z"/></svg>
                        <span class="sr-only">LinkedIn</span>
                    </a>
                    <a href="https://www.tiktok.com/@careeronesrilanka?_t=8oj33E5ivyi&_r=1" target="_blank" class="text-[#91919A] dark:text-white hover:text-primary dark:text-white">
                        <svg class="w-6 h-6" viewBox="0 0 250 250" xmlns="http://www.w3.org/2000/svg">

                            <g clip-rule="evenodd" fill-rule="evenodd">

                                <path d="M25 0h200c13.808 0 25 11.192 25 25v200c0 13.808-11.192 25-25 25H25c-13.808 0-25-11.192-25-25V25C0 11.192 11.192 0 25 0z" fill="#010101"/>

                                <path d="M156.98 230c7.607 0 13.774-6.117 13.774-13.662s-6.167-13.663-13.774-13.663h-2.075c7.607 0 13.774 6.118 13.774 13.663S162.512 230 154.905 230z" fill="#ee1d51"/>

                                <path d="M154.717 202.675h-2.075c-7.607 0-13.775 6.118-13.775 13.663S145.035 230 152.642 230h2.075c-7.608 0-13.775-6.117-13.775-13.662s6.167-13.663 13.775-13.663z" fill="#66c8cf"/>

                                <ellipse cx="154.811" cy="216.338" fill="#010101" rx="6.699" ry="6.643"/>

                                <path d="M50 196.5v6.925h8.112v26.388h8.115v-26.201h6.603l2.264-7.112zm66.415 0v6.925h8.112v26.388h8.115v-26.201h6.603l2.264-7.112zm-39.81 3.93c0-2.17 1.771-3.93 3.959-3.93 2.19 0 3.963 1.76 3.963 3.93s-1.772 3.93-3.963 3.93c-2.188-.001-3.959-1.76-3.959-3.93zm0 6.738h7.922v22.645h-7.922zM87.924 196.5v33.313h7.925v-8.608l2.453-2.248L106.037 230h8.49l-11.133-16.095 10-9.733h-9.622l-7.923 7.86V196.5zm85.47 0v33.313h7.926v-8.608l2.452-2.248L191.509 230H200l-11.133-16.095 10-9.733h-9.622l-7.925 7.86V196.5z" fill="#ffffff"/>

                                <path d="M161.167 81.186c10.944 7.819 24.352 12.42 38.832 12.42V65.755a39.26 39.26 0 0 1-8.155-.853v21.923c-14.479 0-27.885-4.601-38.832-12.42v56.835c0 28.432-23.06 51.479-51.505 51.479-10.613 0-20.478-3.207-28.673-8.707C82.187 183.57 95.23 189.5 109.66 189.5c28.447 0 51.508-23.047 51.508-51.48V81.186zm10.06-28.098c-5.593-6.107-9.265-14-10.06-22.726V26.78h-7.728c1.945 11.09 8.58 20.565 17.788 26.308zm-80.402 99.107a23.445 23.445 0 0 1-4.806-14.256c0-13.004 10.548-23.547 23.561-23.547a23.6 23.6 0 0 1 7.147 1.103V87.022a51.97 51.97 0 0 0-8.152-.469v22.162a23.619 23.619 0 0 0-7.15-1.103c-13.013 0-23.56 10.543-23.56 23.548 0 9.195 5.272 17.157 12.96 21.035z" fill="#ee1d52"/>

                                <path d="M153.012 74.405c10.947 7.819 24.353 12.42 38.832 12.42V64.902c-8.082-1.72-15.237-5.942-20.617-11.814-9.208-5.743-15.843-15.218-17.788-26.308H133.14v111.239c-.046 12.968-10.576 23.468-23.561 23.468-7.652 0-14.45-3.645-18.755-9.292-7.688-3.878-12.96-11.84-12.96-21.035 0-13.005 10.547-23.548 23.56-23.548 2.493 0 4.896.388 7.15 1.103V86.553c-27.945.577-50.42 23.399-50.42 51.467 0 14.011 5.597 26.713 14.68 35.993 8.195 5.5 18.06 8.707 28.673 8.707 28.445 0 51.505-23.048 51.505-51.479z" fill="#ffffff"/>

                                <path d="M191.844 64.902v-5.928a38.84 38.84 0 0 1-20.617-5.887 38.948 38.948 0 0 0 20.617 11.815zM153.439 26.78a39.524 39.524 0 0 1-.427-3.198V20h-28.028v111.24c-.045 12.967-10.574 23.467-23.56 23.467-3.813 0-7.412-.904-10.6-2.512 4.305 5.647 11.103 9.292 18.755 9.292 12.984 0 23.515-10.5 23.561-23.468V26.78zm-44.864 59.773v-6.311a51.97 51.97 0 0 0-7.067-.479C73.06 79.763 50 102.811 50 131.24c0 17.824 9.063 33.532 22.835 42.772-9.083-9.28-14.68-21.982-14.68-35.993 0-28.067 22.474-50.889 50.42-51.466z" fill="#69c9d0"/>

                                <path d="M154.904 230c7.607 0 13.775-6.117 13.775-13.662s-6.168-13.663-13.775-13.663h-.188c-7.607 0-13.774 6.118-13.774 13.663S147.109 230 154.716 230zm-6.792-13.662c0-3.67 3-6.643 6.7-6.643 3.697 0 6.697 2.973 6.697 6.643s-3 6.645-6.697 6.645c-3.7-.001-6.7-2.975-6.7-6.645z" fill="#ffffff"/>

                            </g>

                        </svg>
                        <span class="sr-only">Tiktok</span>
                    </a>
                    <a href="https://www.youtube.com/@CareeerOneSriLanka" target="_blank" class="text-[#91919A] dark:text-white hover:text-primary dark:text-white">
{{--                        <svg class="w-6 h-6" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">--}}
{{--                            <path fill-rule="evenodd" d="M10 0a10 10 0 1 0 10 10A10.009 10.009 0 0 0 10 0Zm6.613 4.614a8.523 8.523 0 0 1 1.93 5.32 20.094 20.094 0 0 0-5.949-.274c-.059-.149-.122-.292-.184-.441a23.879 23.879 0 0 0-.566-1.239 11.41 11.41 0 0 0 4.769-3.366ZM8 1.707a8.821 8.821 0 0 1 2-.238 8.5 8.5 0 0 1 5.664 2.152 9.608 9.608 0 0 1-4.476 3.087A45.758 45.758 0 0 0 8 1.707ZM1.642 8.262a8.57 8.57 0 0 1 4.73-5.981A53.998 53.998 0 0 1 9.54 7.222a32.078 32.078 0 0 1-7.9 1.04h.002Zm2.01 7.46a8.51 8.51 0 0 1-2.2-5.707v-.262a31.64 31.64 0 0 0 8.777-1.219c.243.477.477.964.692 1.449-.114.032-.227.067-.336.1a13.569 13.569 0 0 0-6.942 5.636l.009.003ZM10 18.556a8.508 8.508 0 0 1-5.243-1.8 11.717 11.717 0 0 1 6.7-5.332.509.509 0 0 1 .055-.02 35.65 35.65 0 0 1 1.819 6.476 8.476 8.476 0 0 1-3.331.676Zm4.772-1.462A37.232 37.232 0 0 0 13.113 11a12.513 12.513 0 0 1 5.321.364 8.56 8.56 0 0 1-3.66 5.73h-.002Z" clip-rule="evenodd"/>--}}
{{--                        </svg>--}}
                        <svg  class="w-6 h-6" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                             viewBox="0 0 461.001 461.001" xml:space="preserve">
                                <g>
                                    <path style="fill:#F61C0D;" d="M365.257,67.393H95.744C42.866,67.393,0,110.259,0,163.137v134.728
                                        c0,52.878,42.866,95.744,95.744,95.744h269.513c52.878,0,95.744-42.866,95.744-95.744V163.137
                                        C461.001,110.259,418.135,67.393,365.257,67.393z M300.506,237.056l-126.06,60.123c-3.359,1.602-7.239-0.847-7.239-4.568V168.607
                                        c0-3.774,3.982-6.22,7.348-4.514l126.06,63.881C304.363,229.873,304.298,235.248,300.506,237.056z"/>
                                </g>
                                </svg>
                        <span class="sr-only">Youtube</span>
                    </a>
                </div>
            </div>
        </div>
        <hr class="mt-8 " />
        <div class="flex justify-center mt-4">
          <p class=" text-[#91919A] dark:text-white text-center text-sm md:text-base"> © {{ __('general.Tertiary and Vocational Education Commission - Ministry of Education, Higher Education & Vocational Education. All rights reserved.') }}
          </p>
        </div>
    </div>
</footer>

