@extends('portfolio.layouts.master')
@section('content')
<div id="gjs" style="height:0px; overflow:hidden;">
{{--<div class="panel">--}}
{{--        <div class="px-4 md:px-12 py-4 flex flex-col gap-6">--}}
{{--            <div class="flex flex-col lg:flex-row gap-6 items-center border-b pb-4">--}}
{{--                <img class="w-32 h-32 rounded-full" src="{{ asset('images/avatar.png') }}" alt="user photo">--}}
{{--                <div class="flex flex-col gap-2 text-center lg:text-left">--}}
{{--                    <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold"--}}
{{--                       id="trainee-name-heading">{{$user->fullName}}</p>--}}
{{--                    <p class="text-[#706F81] dark:text-white text-lg" id="trainee-short-bio">"{{$user->traineeInformation->short_bio}}"</p>--}}
{{--                    <p class="text-[#91919A] dark:text-white" id="expertise_heading_block">--}}
{{--                        Web Designer | NVQ5 | Tourism--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="py-6 flex flex-col gap-9">--}}
{{--                <div class="flex flex-col gap-4">--}}
{{--                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Basic Information</p>--}}
{{--                    <div class="flex gap-6 flex-col lg:flex-row">--}}
{{--                        <div class="flex flex-col gap-4">--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
{{--                                     viewBox="0 0 20 20" fill="none">--}}
{{--                                    <path--}}
{{--                                        d="M16.6654 17.5C16.6654 16.337 16.6654 15.7555 16.5218 15.2824C16.1987 14.217 15.365 13.3834 14.2996 13.0602C13.8265 12.9167 13.245 12.9167 12.082 12.9167H7.91537C6.7524 12.9167 6.17091 12.9167 5.69775 13.0602C4.63241 13.3834 3.79873 14.217 3.47556 15.2824C3.33203 15.7555 3.33203 16.337 3.33203 17.5M13.7487 6.25C13.7487 8.32107 12.0698 10 9.9987 10C7.92763 10 6.2487 8.32107 6.2487 6.25C6.2487 4.17893 7.92763 2.5 9.9987 2.5C12.0698 2.5 13.7487 4.17893 13.7487 6.25Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                </svg>--}}
{{--                                <span class="text-sm text-[#464559] dark:text-white" id="trainee-name">{{$user->fullName}}</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
{{--                                     viewBox="0 0 20 20" fill="none">--}}
{{--                                    <path--}}
{{--                                        d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                </svg>--}}
{{--                                <span class="text-sm text-[#464559] dark:text-white"--}}
{{--                                      id="trainee-phone">{{formatPhoneNumber($user->telephone)}}</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
{{--                                     viewBox="0 0 20 20" fill="none">--}}
{{--                                    <path--}}
{{--                                        d="M14.168 12.0833V9.57866C14.168 9.4291 14.168 9.35431 14.1452 9.28829C14.1251 9.22991 14.0922 9.17673 14.049 9.1326C14.0001 9.08271 13.9332 9.04927 13.7994 8.98238L10.0013 7.08331M3.33464 7.91664V13.5888C3.33464 13.8987 3.33464 14.0537 3.38298 14.1894C3.42573 14.3093 3.49539 14.4179 3.58662 14.5067C3.68981 14.6072 3.8307 14.6718 4.11243 14.8009L9.44576 17.2454C9.65013 17.339 9.75231 17.3859 9.85875 17.4043C9.95308 17.4207 10.0495 17.4207 10.1439 17.4043C10.2503 17.3859 10.3525 17.339 10.5568 17.2454L15.8902 14.8009C16.1719 14.6718 16.3128 14.6072 16.416 14.5067C16.5072 14.4179 16.5769 14.3093 16.6196 14.1894C16.668 14.0537 16.668 13.8987 16.668 13.5888V7.91664M1.66797 7.08331L9.70316 3.06571C9.81248 3.01105 9.86714 2.98372 9.92447 2.97297C9.97525 2.96344 10.0274 2.96344 10.0781 2.97297C10.1355 2.98372 10.1901 3.01105 10.2994 3.06571L18.3346 7.08331L10.2994 11.1009C10.1901 11.1556 10.1355 11.1829 10.0781 11.1936C10.0274 11.2032 9.97525 11.2032 9.92447 11.1936C9.86714 11.1829 9.81248 11.1556 9.70316 11.1009L1.66797 7.08331Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                </svg>--}}
{{--                                <span class="text-sm text-[#464559] dark:text-white"--}}
{{--                                      id="trainee-school">{{$user->institute->name}}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="flex flex-col gap-4">--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
{{--                                     viewBox="0 0 20 20" fill="none">--}}
{{--                                    <path--}}
{{--                                        d="M17.9179 14.9997L12.3823 9.99967M7.62035 9.99967L2.08466 14.9997M1.66797 5.83301L8.47207 10.5959C9.02304 10.9816 9.29853 11.1744 9.59819 11.2491C9.86288 11.3151 10.1397 11.3151 10.4044 11.2491C10.7041 11.1744 10.9796 10.9816 11.5305 10.5959L18.3346 5.83301M5.66797 16.6663H14.3346C15.7348 16.6663 16.4348 16.6663 16.9696 16.3939C17.44 16.1542 17.8225 15.7717 18.0622 15.3013C18.3346 14.7665 18.3346 14.0665 18.3346 12.6663V7.33301C18.3346 5.93288 18.3346 5.23281 18.0622 4.69803C17.8225 4.22763 17.44 3.84517 16.9696 3.60549C16.4348 3.33301 15.7348 3.33301 14.3346 3.33301H5.66797C4.26784 3.33301 3.56777 3.33301 3.03299 3.60549C2.56259 3.84517 2.18014 4.22763 1.94045 4.69803C1.66797 5.23281 1.66797 5.93288 1.66797 7.33301V12.6663C1.66797 14.0665 1.66797 14.7665 1.94045 15.3013C2.18014 15.7717 2.56259 16.1542 3.03299 16.3939C3.56777 16.6663 4.26784 16.6663 5.66797 16.6663Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                </svg>--}}
{{--                                <span class="text-sm text-[#464559] dark:text-white"--}}
{{--                                      id="trainee-email">{{$user->email}}</span>--}}
{{--                            </div>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"--}}
{{--                                     viewBox="0 0 20 20" fill="none">--}}
{{--                                    <path--}}
{{--                                        d="M9.9987 10.417C11.3794 10.417 12.4987 9.2977 12.4987 7.91699C12.4987 6.53628 11.3794 5.41699 9.9987 5.41699C8.61799 5.41699 7.4987 6.53628 7.4987 7.91699C7.4987 9.2977 8.61799 10.417 9.9987 10.417Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                    <path--}}
{{--                                        d="M9.9987 18.3337C11.6654 15.0003 16.6654 12.8489 16.6654 8.33366C16.6654 4.65176 13.6806 1.66699 9.9987 1.66699C6.3168 1.66699 3.33203 4.65176 3.33203 8.33366C3.33203 12.8489 8.33203 15.0003 9.9987 18.3337Z"--}}
{{--                                        stroke="#91919A" stroke-width="1.2" stroke-linecap="round"--}}
{{--                                        stroke-linejoin="round" />--}}
{{--                                </svg>--}}
{{--                                <span class="text-sm text-[#464559] dark:text-white" id="trainee-address">{!! $user->traineeInformation->address !!}</span>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <div class="flex flex-col gap-4">--}}
{{--                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">About me</p>--}}
{{--                    <p class="text-lg text-[#706F81] dark:text-white" id="trainee-basic-information">{{$user->traineeInformation->basic_information}}</p>--}}
{{--                </div>--}}
{{--                <div class="flex gap-6 flex-col lg:flex-row">--}}
{{--                    <div class="flex flex-col gap-4 w-full lg:w-1/2">--}}
{{--                        <div class="flex flex-col gap-4">--}}
{{--                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Education</p>--}}
{{--                            <div id="education_block">--}}
{{--                                @forelse(json_decode($user->traineeInformation->education) as $education)--}}
{{--                                    <div class="flex  flex-col gap-4">--}}
{{--                                        <div class="flex gap-4 items-baseline">--}}
{{--                                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">--}}
{{--                                                <circle cx="5" cy="5" r="5" fill="#4984F6"/>--}}
{{--                                            </svg>--}}
{{--                                            <div class="flex flex-col gap-2">--}}
{{--                                                <p>--}}
{{--                                                    <span class="text-[#464559] text-xl font-semibold dark:text-white">{{$education->degree}} </span>--}}
{{--                                                    <span class="text-[#706F81]  dark:text-white"> ({{$education->institution}})</span>--}}
{{--                                                </p>--}}
{{--                                                <p>--}}
{{--                                                    <span class="text-[#91919A] dark:text-white">{{$education->start_year}} - {{$education->end_year}}</span>--}}
{{--                                                </p>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                @empty--}}
{{--                                @endforelse--}}
{{--                            </div>--}}


{{--                        </div>--}}
{{--                        <div class="flex flex-col gap-4">--}}
{{--                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Certificate</p>--}}
{{--                            <div id="certificate_block">--}}
{{--                                @forelse(json_decode($user->traineeInformation->certificate) as $certificate)--}}
{{--                                <div class="flex flex-col gap-4">--}}
{{--                                    <div class="flex gap-4 items-baseline">--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">--}}
{{--                                            <circle cx="5" cy="5" r="5" fill="#4984F6"/>--}}
{{--                                        </svg>--}}
{{--                                        <div class="flex flex-col gap-2">--}}
{{--                                            <p>--}}
{{--                                                <span class="text-[#464559] text-xl font-semibold dark:text-white">{{$certificate->name}}</span>--}}
{{--                                                <span class="text-[#706F81] dark:text-white">({{$certificate->nvq}})</span>--}}
{{--                                            </p>--}}
{{--                                            <p>--}}
{{--                                                <span class="text-[#91919A] dark:text-white">{{$certificate->start_year}} - {{$certificate->end_year}}</span>--}}
{{--                                            </p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                @empty--}}
{{--                                @endforelse--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col gap-4 w-full lg:w-1/2">--}}
{{--                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Experience</p>--}}
{{--                        <div id="experience_block">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <div class="flex gap-6 flex-col lg:flex-row">--}}
{{--                    <div class="flex flex-col gap-4 w-full lg:w-1/2">--}}
{{--                        <div class="flex flex-col gap-4">--}}
{{--                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Expertise</p>--}}
{{--                            <div class="flex  flex-wrap gap-4" id="expertise_block">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col gap-4 w-full lg:w-1/2">--}}
{{--                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">Language</p>--}}
{{--                        <div class="flex  flex-wrap gap-4" id="language_block">--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--</div>--}}
    <style>
        .panel {
            width: 90%;
            max-width: 900px;
            border-radius: 3px;
            padding: 30px 20px;
            margin: 150px auto 0px;
            box-shadow: 0px 3px 10px 0px rgba(0,0,0,0.25);
            color:rgba(255,255,255,0.75);
            font-family: Poppins !important;
            margin-bottom: 100px;
        }
        .gjs-pn-panel {
            font-family: Poppins !important;
        }
    </style>
</div>
@endsection

@push('js')
<script>
    $(document).ready(function (){
        const projectID = Math.floor(Math.random() * 100);
        const projectSaveEndpoint = `/trainee/career-guidance/portfolio/save-portfolio/${projectID}`;
        const projectLoadEndpoint = `/trainee/career-guidance/portfolio/load-portfolio`;
        let editor = grapesjs.init({
            showOffsets: 1,
            noticeOnUnload: 0,
            container: '#gjs',
            height: '100%',
            fromElement: true,
            storageManager: {
                type: 'remote',
                autosave: false,
                autoload: true,
                stepsBeforeSave: 1,
                options: {
                    remote: {
                        headers: {}, // Custom headers for the remote storage request
                        urlStore: projectSaveEndpoint, // Endpoint for saving
                        urlLoad: projectLoadEndpoint,  // Endpoint for loading
                        onStore: data => ({ id: projectID, data }),
                        onLoad: result => JSON.parse(result.data),
                    }
                },
            },
            contentTypeJson: true,
            plugins: [gTailwindcss, preset_newsletter],
            styleManager: {
                sectors: [{
                    name: 'General',
                    open: false,
                    buildProps: ['float', 'display', 'position', 'top', 'right', 'left', 'bottom']
                }, {
                    name: 'Flex',
                    open: false,
                    buildProps: ['flex-direction', 'flex-wrap', 'justify-content', 'align-items', 'align-content', 'order', 'flex-basis', 'flex-grow', 'flex-shrink', 'align-self']
                }, {
                    name: 'Dimension',
                    open: false,
                    buildProps: ['width', 'height', 'max-width', 'min-height', 'margin', 'padding'],
                }, {
                    name: 'Typography',
                    open: false,
                    buildProps: ['font-family', 'font-size', 'font-weight', 'letter-spacing', 'color', 'line-height', 'text-shadow'],
                }, {
                    name: 'Decorations',
                    open: false,
                    buildProps: ['border-radius-c', 'background-color', 'border-radius', 'border', 'box-shadow', 'background'],
                }, {
                    name: 'Extra',
                    open: false,
                    buildProps: ['transition', 'perspective', 'transform'],
                }
                ],
            },
            pluginsOpts: {}
        });

        editor.Panels.addButton('options', { // Add a new button to the 'options' panel
            id: 'save-db',
            className: 'fa fa-floppy-o',
            label: ' Save',
            command(editor) {
                // Get HTML and CSS content from the editor
                const htmlContent = editor.getHtml();
                const cssContent = editor.getCss();
                const data = editor.getProjectData();

                // Send a POST request to save the content to the database
                fetch('/trainee/career-guidance/portfolio/save-portfolio', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') // Add CSRF token
                    },
                    body: JSON.stringify({
                        'gjs-html': htmlContent,
                        'gjs-css': cssContent,
                        'data' : data
                    })
                }).then(response => {
                    if (response.ok) {
                        alert('Template saved successfully!');
                    } else {
                        alert('Failed to save template.');
                    }
                }).catch(error => {
                    console.error('Error:', error);
                });
            },
            attributes: {
                title: 'Save to Database'
            }
        });

        editor.on('load', () => {
            // var iframe = $('.gjs-frame')[0];
            // if(iframe != undefined) {
            //     var iframeDoc = iframe.contentDocument || iframe.contentWindow.document;
            //
            //     // Get all link tags with rel="stylesheet" from the parent document
            //     $('link[rel="stylesheet"]').each(function() {
            //         var linkHref = $(this).attr('href');  // Get the href of the stylesheet
            //
            //         // Create a new link element in the iframe
            //         var $iframeLink = $('<link>', {
            //             rel: 'stylesheet',
            //             href: linkHref
            //         });
            //
            //         // Append the new link tag to the iframe's head
            //         $($iframeLink).appendTo($(iframeDoc.head));
            //     });
            // }

            // fetch('/portfolio/templates/template2.html')
            //     .then(response => response.text())
            //     .then(html => {
            //         // Load the fetched HTML into the GrapesJS editor
            //         editor.setComponents(html);
            //     })
            //     .catch(err => console.error('Error loading HTML file:', err));
        });
    });

</script>
@endpush
