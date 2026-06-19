<div>
    <script src="https://cdn.jsdelivr.net/npm/flowbite@2.5.2/dist/flowbite.min.js"></script>
    {{-- <script src="https://cdn.tailwindcss.com"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <div class="w-full p-6 space-y-6 bg-white mt-4 rounded-xl flex flex-col">
        <x-breadcrumb :items="[
                    ['label' => 'Admin', 'url' => '/admin/overview'],
                    ['label' => 'Job support', 'url' => '#'],
                    ['label' => \Str::limit($this->jobData->title, 40), 'url' => '/admin/jobs'],
                    ['label' => 'Candidate list', 'url' => '#'],
                ]" />
{{--        <a href="/admin/jobs"--}}
{{--            class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">--}}
{{--            <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"--}}
{{--                width="24" height="24" fill="none" viewBox="0 0 24 24">--}}
{{--                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"--}}
{{--                    d="m15 19-7-7 7-7" />--}}
{{--            </svg>--}}
{{--            <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{ $this->jobData->title }}</h3>--}}
{{--        </a>--}}
        <form method="get" action="{{ url()->current() }}">
            <div class="flex gap-4 flex-row">
                <div class="w-full flex gap-4">
                    <div class="flex items-center gap-4 w-full">
                        <input type="text" name="search"
                            class="flex-grow px-4 py-2 border border-gray-300 rounded-lg text-[#91919A] font-medium"
                            value="{{ request()->query('search') }}" placeholder="{{ __('general.Trainee name') }}">
                    </div>
                </div>
                <div class="w-fit"><button type="submit"
                        class="flex-1 px-4 py-2 bg-blue-500 text-white rounded-full">{{ __('company.search') }}</button></div>

            </div>
        </form>
        @if (count($this->jobData->appliesTypeApply) <= 0)
            <p>{{ trans('cgo.job_support.company_list.no_record') }}</p>
        @else
            @foreach ($this->jobData->appliesTypeApply as $apply)
                <div
                    class="flex gap-5 lg:flex-row justify-between w-full lg:px-5 py-2 md:py-3 trainee-apply border-b border-[#bdbaba] ">
                    <div class="flex gap-6 items-center w-full">

                        <svg xmlns="http://www.w3.org/2000/svg" width="62" height="63" viewBox="0 0 62 63"
                            fill="none">
                            <rect y="0.5" width="62" height="62" rx="31" fill="#EDEDED" />
                            <path
                                d="M23.125 21.875C23.125 26.2167 26.6582 29.75 31 29.75C35.3417 29.75 38.875 26.2167 38.875 21.875C38.875 17.5332 35.3417 14 31 14C26.6582 14 23.125 17.5332 23.125 21.875ZM45 47.25H46.75V45.5C46.75 38.7467 41.2533 33.25 34.5 33.25H27.5C20.745 33.25 15.25 38.7467 15.25 45.5V47.25H45Z"
                                fill="#C9CCD4" />
                        </svg>
                        <div class="flex flex-col gap-1 w-full">
                            <p class="flex gap-3 items-center w-full flex-wrap flex-row">
                                <button type="button"
                                    class="ajax-call text-[#1e429f] font-semibold hover:text-blue-700 dark:hover:text-white"
                                    data-modal-target="default-modal" data-modal-toggle="default-modal"
                                    data-url="{{ route('cgo.job-support.trainee-list.information', $apply->user->id) }}"
                                    data-trainee-id="{{ $apply->user->id }}">
                                    {{ $apply->user->fullName }}
                                </button>

                                <span class="text-[#464559] dark:text-white">|</span>
                                {{-- <span class="text-[#464559] dark:text-white">2 years </span> --}}
                                @foreach ($apply->apply_types as $apply_type)
                                    <span style="background-color: #1e429f"
                                        class="text-sm px-2.5 py-1 rounded shadow-xs text-white {{ $apply_type == 'apply' ? 'bg-[#1e429f]' : 'bg-[#1e429f]' }}">
                                        {{ \App\Enums\TypeTraineeApply::getNameByKey($apply_type) }}
                                    </span>
                                @endforeach

                            </p>
                            <p class="text-[#706F81]  gap-3 dark:text-white flex flex-wrap">
                                {!! getNewestTrainingInformationOfTrainee($apply->user->id) !!}
                            </p>

                        </div>
                        <div class="flex flex-col gap-6 items-end">
                        <span class="text-sm text-primary flex gap-1 items-center font-semibold read-cv {{ empty($apply->read) ? 'hidden' : '' }}">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="17" viewBox="0 0 16 17" fill="none">
                                <path d="M4.66665 8.50008L7.99998 11.8334L14.6666 5.16675M1.33331 8.50008L4.66665 11.8334M7.99998 8.50008L11.3333 5.16675" stroke="#4984F6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            Read
                        </span>
                            <div class="flex gap-2">
                                <span class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold  {{ empty($apply->selected) || !empty($apply->employeed) ? 'hidden' : '' }} selected-cv">Selected</span>
                                <span class="text-sm text-primary px-2 py-1 bg-[#E9F5FF] rounded-xl font-semibold  {{ empty($apply->employeed) ? 'hidden' : '' }} employeed-trainee">Employed</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
        <div id="default-modal" tabindex="-1" aria-hidden="true"
            class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
            <div class="relative w-full max-w-4xl max-h-full p-4" style="padding: 16px;">
                <div class="relative bg-white rounded-lg shadow dark:bg-[#1E1E1E] dark:border-white">
                    <div
                        class="loading hidden h-full w-full opacity-90 z-50 absolute flex items-center justify-center w-56 h-56 border border-gray-200 bg-gray-50 dark:bg-gray-800 dark:border-gray-700">
                        <div role="status">
                            <svg aria-hidden="true"
                                class="w-8 h-8 text-gray-200 animate-spin dark:text-gray-600 fill-blue-600"
                                viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z"
                                    fill="currentColor" />
                                <path
                                    d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z"
                                    fill="currentFill" />
                            </svg>
                            <span class="sr-only text-black">Loading...</span>
                        </div>
                    </div>
                    <!-- Modal header -->
                    <div
                        class="flex items-center justify-between p-4 md:p-5 rounded-t-lg bg-[#5736ec] dark:bg-[#383838] px-6 py-4" style="background-color: #4984F6">
                        <h3 class="text-xl md:text-2xl lg:text-3xl font-semibold text-white">
                            Resume
                        </h3>
                        <button type="button"
                            class="text-white bg-transparent hover:text-gray-900 rounded-lg text-sm w-12 h-12 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="default-modal">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32"
                                fill="none">
                                <path d="M22.6654 9.33301L9.33203 22.6663M9.33203 9.33301L22.6654 22.6663"
                                    stroke="white" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="px-12 py-4 flex flex-col gap-6" style="padding: 16px 48px;">
                        <div class="flex flex-col lg:flex-row gap-6 items-center border-b pb-4">
                            <img class="w-32 h-32 rounded-full" id="avatar"
                                src="{{ asset('/images/user-default.svg') }}" alt="user photo">
                            <div class="flex flex-col gap-2 text-center lg:text-left">
                                <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold"
                                    id="trainee-name-heading"></p>
                            </div>
                        </div>
                        <div class="py-6 flex flex-col gap-9">
                            <div class="flex flex-col gap-4">
                                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                    {{ trans('company.job_support.trainee_list.modal_content.basic_information') }}</p>
                                <div class="flex gap-6 flex-col lg:flex-row">
                                    <div class="flex flex-col gap-4">
                                        <div class="flex gap-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M16.6654 17.5C16.6654 16.337 16.6654 15.7555 16.5218 15.2824C16.1987 14.217 15.365 13.3834 14.2996 13.0602C13.8265 12.9167 13.245 12.9167 12.082 12.9167H7.91537C6.7524 12.9167 6.17091 12.9167 5.69775 13.0602C4.63241 13.3834 3.79873 14.217 3.47556 15.2824C3.33203 15.7555 3.33203 16.337 3.33203 17.5M13.7487 6.25C13.7487 8.32107 12.0698 10 9.9987 10C7.92763 10 6.2487 8.32107 6.2487 6.25C6.2487 4.17893 7.92763 2.5 9.9987 2.5C12.0698 2.5 13.7487 4.17893 13.7487 6.25Z"
                                                    stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-sm text-[#464559] dark:text-white" style="color: black"
                                                id="trainee-name">Amila
                                                Lanka</span>
                                        </div>
                                        <div class="flex gap-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z"
                                                    stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-sm text-[#464559] dark:text-white"
                                                id="trainee-phone"></span>
                                        </div>
                                    </div>
                                    <div class="flex flex-col gap-4">
                                        <div class="flex gap-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M17.9179 14.9997L12.3823 9.99967M7.62035 9.99967L2.08466 14.9997M1.66797 5.83301L8.47207 10.5959C9.02304 10.9816 9.29853 11.1744 9.59819 11.2491C9.86288 11.3151 10.1397 11.3151 10.4044 11.2491C10.7041 11.1744 10.9796 10.9816 11.5305 10.5959L18.3346 5.83301M5.66797 16.6663H14.3346C15.7348 16.6663 16.4348 16.6663 16.9696 16.3939C17.44 16.1542 17.8225 15.7717 18.0622 15.3013C18.3346 14.7665 18.3346 14.0665 18.3346 12.6663V7.33301C18.3346 5.93288 18.3346 5.23281 18.0622 4.69803C17.8225 4.22763 17.44 3.84517 16.9696 3.60549C16.4348 3.33301 15.7348 3.33301 14.3346 3.33301H5.66797C4.26784 3.33301 3.56777 3.33301 3.03299 3.60549C2.56259 3.84517 2.18014 4.22763 1.94045 4.69803C1.66797 5.23281 1.66797 5.93288 1.66797 7.33301V12.6663C1.66797 14.0665 1.66797 14.7665 1.94045 15.3013C2.18014 15.7717 2.56259 16.1542 3.03299 16.3939C3.56777 16.6663 4.26784 16.6663 5.66797 16.6663Z"
                                                    stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-sm text-[#464559] dark:text-white"
                                                id="trainee-email">r</span>
                                        </div>
                                        <div class="flex gap-4">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                                viewBox="0 0 20 20" fill="none">
                                                <path
                                                    d="M9.9987 10.417C11.3794 10.417 12.4987 9.2977 12.4987 7.91699C12.4987 6.53628 11.3794 5.41699 9.9987 5.41699C8.61799 5.41699 7.4987 6.53628 7.4987 7.91699C7.4987 9.2977 8.61799 10.417 9.9987 10.417Z"
                                                    stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path
                                                    d="M9.9987 18.3337C11.6654 15.0003 16.6654 12.8489 16.6654 8.33366C16.6654 4.65176 13.6806 1.66699 9.9987 1.66699C6.3168 1.66699 3.33203 4.65176 3.33203 8.33366C3.33203 12.8489 8.33203 15.0003 9.9987 18.3337Z"
                                                    stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                            </svg>
                                            <span class="text-sm text-[#464559] dark:text-white" style="color: black"
                                                id="trainee-address">123
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-6 flex-col">
                                <div class="flex flex-col gap-4 w-full">
                                    <div class="flex flex-col gap-4">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                            {{ trans('company.job_support.trainee_list.modal_content.education') }}</p>
                                        <div id="education_block"></div>


                                    </div>
                                    <div class="flex flex-col gap-4">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                            {{ trans('company.job_support.trainee_list.modal_content.certificate') }}
                                        </p>
                                        <div id="certificate_block">

                                        </div>

                                    </div>
{{--                                    <div class="flex flex-col gap-4">--}}
{{--                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">--}}
{{--                                            {{ trans('company.job_support.trainee_list.modal_content.attachment') }}--}}
{{--                                        </p>--}}
{{--                                        <div id="attachment_block">--}}

{{--                                        </div>--}}

{{--                                    </div>--}}
                                    <div class="flex flex-col gap-4">
                                        <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">
                                            {{ trans('company.job_support.trainee_list.modal_content.portfolio') }}</p>
                                        <div id="portfolio_block">
                                            <p class="dark:text-white">No information</p>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
<script type="module">
    $(document).ready(function() {

        $('.ajax-call').on('click', function() {
            $(".loading").removeClass('hidden');
            let url = $(this).data('url');
            let trainee_id = $(this).data('trainee-id');

            $('#trainee-id').val(trainee_id);
            $.ajax({
                url: url,
                type: 'GET',
                success: function(response) {
                    $('#trainee-email').text(response.trainee_user.email);
                    $('#trainee-name').text(response.trainee_user.full_name);
                    $('#trainee-phone').text((response.trainee_user.telephone != null && response.trainee_user.telephone != '') ? response.trainee_user.telephone : response.trainee_user.mobile);
                    $('#summary_training_block').html(response.trainee_user
                        .sumary_training);
                    $('#trainee-name-heading').text(response.trainee_user.full_name);
                    let src = '';
                    if (response.trainee_user.profile_image) {
                        src = '/' + response.trainee_user.profile_image;
                    } else {
                        src = '/images/user-default.svg';
                    }
                    $('#avatar').attr('src', src);
                    $('#trainee-address').text(response.trainee_user.contact_address);
                    let certificateBlock = $('#certificate_block');
                    let educationBlock = $('#education_block');
                    let attachmentBlock = $('#attachment_block');
                    certificateBlock.empty();
                    educationBlock.empty();
                    attachmentBlock.empty();
                    let certificateDiv = ``;
                    let educationDiv = ``;
                    if (response.trainee_certificates != null && response.trainee_certificates.length > 0) {
                        response.trainee_certificates.forEach(function(certificate) {
                            certificateDiv += `
                        <div class="flex flex-col gap-4">
                            <div class="flex gap-4 items-baseline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                                </svg>
                                <div class="flex flex-col gap-2">
                                    <p>
                                        <span class="text-[#464559] text-xl font-semibold dark:text-white">${certificate.QUALIFICATION_NAME} - ${certificate.QUALIFICATION_LEVEL}</span>
                                        <span class="text-[#706F81] dark:text-white">(${certificate.EFFECTIVE_DATE})</span>
                                    </p>
                                </div>
                            </div>
                        </div>`;

                        });
                    } else {
                        certificateDiv += `<span class="dark:text-white">No information<span>`;
                    }
                    if (response.trainee_information != null && response.trainee_information.length > 0) {
                        response.trainee_information.forEach(function(information) {
                            educationDiv += `
                        <div class="flex  flex-col gap-4">
                            <div class="flex gap-4 items-baseline">
                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                    <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                                </svg>
                                <div class="flex flex-col gap-2">
                                    <p>
                                        <span class="text-[#464559] text-xl font-semibold dark:text-white">${information.institute.INSTITUTE_NAME}</span>
                                        <span class="text-[#706F81]  dark:text-white">(Industry sector: ${information.education.INDUSTRY_SECTOR})</span>
                                    </p>
                                    <p>
                                        <span class="text-[#91919A] dark:text-white">Course name: ${information.education.COURSE_NAME} (${information.education.START_DATE} - ${information.education.END_DATE})</span>
                                    </p>
                                </div>
                            </div>
                        </div>`;

                        });
                    } else {
                        educationDiv += `<span class="dark:text-white">No information<span>`;
                    }
//                     let attachmentDiv = ``;
//                     if (response.trainee_resume.length > 0) {
//                         response.trainee_resume.forEach(function(attachment) {
//                             attachmentDiv += `
//                         <div class="flex flex-col gap-4">
//                             <div class="flex gap-4 items-baseline items-center">
//                                 <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
//                                     <circle cx="5" cy="5" r="5" fill="#4984F6"/>
//                                 </svg>
//                                 <div class="flex flex-col gap-2">
//                                     <p>
//                                         <a href="/trainee/preview-cv?cid=` + btoa(attachment.id) + `" target="_blank" class="text-[#464559] text-xl font-semibold dark:text-white dark:text-white hover:text-primary dark:hover:text-primary flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
// <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
// </svg>
// Resume</a>
//                                     </p>
//                                 </div>
//                             </div>
//                         </div>`;
//                         });
//                     } else {
//                         attachmentDiv += `<span class="dark:text-white">No CV attachment</span>`;
//                     }
                    if(response.trainee_portfolio != '') {
                        $("#portfolio_block").html('<a class="dark:text-white underline text-primary" href="'+response.trainee_portfolio+'" target="_blank">View</a>');
                    }
                    certificateBlock.append(certificateDiv);
                    educationBlock.append(educationDiv);
                    // attachmentBlock.append(attachmentDiv);

                    $(".loading").addClass('hidden');

                },
                error: function(xhr, status, error) {
                    $(".loading").addClass('hidden');
                    alert('Error: ' + error);
                }
            });
        });
    });
</script>
