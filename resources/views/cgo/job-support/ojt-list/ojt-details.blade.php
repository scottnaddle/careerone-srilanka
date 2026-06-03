@extends('homepage.layouts.master')
@section('title', 'Job support - Trainee List - Job Match - Job details')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
            ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
            ['label' => trans('cgo.menu.job_support.ojt_list'), 'url' => route('cgo.job-support.ojt-list.list')],
            ['label' => \Str::limit($ojt->title,30), 'url' => '#'],
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <div class="flex items-center mb-4">
                    <p class="text-xl text-[#464559] dark:text-white font-semibold">{{trans('company.job_support.ojt_list.ojt_details')}}</p>
                </div>
{{--                <form class="flex flex-col gap-6">--}}
{{--                    <div>--}}
{{--                        <label for="" class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">Title</label>--}}
{{--                        <input type="text" id=""--}}
{{--                               class="border border-[#EDEDED] bg-[#F5F7FA] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                               value="{{ $ojt->title }}" readonly required disabled />--}}
{{--                    </div>--}}
{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.ojt_detail.application_requirements') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.gender.root') }}</label>--}}
{{--                            <div class="flex gap-4">--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="male" type="radio" value="" name="gender"--}}
{{--                                           {{ $ojt->gender == 1 ? 'checked' : '' }}--}}
{{--                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="male" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.gender.male') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="female" type="radio" value="" name="gender"--}}
{{--                                           {{ $ojt->gender == 0 ? 'checked' : '' }}--}}
{{--                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="female"--}}
{{--                                           class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.gender.female') }}</label>--}}
{{--                                </div>--}}
{{--                                <div class="flex items-center">--}}
{{--                                    <input disabled id="na" type="radio" value="" name="gender"--}}
{{--                                           {{ $ojt->gender == 2 ? 'checked' : '' }}--}}
{{--                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                    <label for="na" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.gender.na') }}</label>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.age_limitation') }}</label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                       class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                       value="{{ $ojt->min_age }}" disabled />--}}
{{--                                <input type="text" id=""--}}
{{--                                       class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                       placeholder="" value="{{ $ojt->max_age }}" disabled readonly />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="notage" type="radio" value="" name="age"--}}
{{--                                       {{ $ojt->age_limitation ? 'checked' : '' }}--}}
{{--                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-white">--}}
{{--                                <label for="notage" class="ms-2 text-xs text-[#464559] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}

{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.require_work_experience') }} <span class="text-red-700">*</span></label>--}}
{{--                            <div class="flex gap-6 mb-2">--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                       class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                       value="{{ $ojt->min_work_experience }}" disabled />--}}
{{--                                <input readonly type="text" id=""--}}
{{--                                       class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                       placeholder="" value="{{ $ojt->max_work_experience }}" disabled />--}}
{{--                            </div>--}}
{{--                            <div class="flex items-center">--}}
{{--                                <input disabled id="default-radio-1" type="radio" value="" name="default-radio"--}}
{{--                                       {{ $ojt->work_experience_limitation ? 'checked' : '' }}--}}
{{--                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-[#EDEDED] focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-white dark:border-white">--}}
{{--                                <label for="default-radio-1"--}}
{{--                                       class="ms-2 text-xs font-medium text-[#464559] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.not_limitation') }}</label>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.required_skills') }}</label>--}}
{{--                            <input name="required_skills" id="required_skills" value="{{$ojt->required_skills}}" class=" bg-[#F5F7FA] border border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Require skills" readonly disabled>--}}

{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.application_deadline') }}</label>--}}
{{--                            <div class="flex gap-6">--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                                 fill="none" viewBox="0 0 24 24">--}}
{{--                                                <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                      stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <input disabled value="{{ $ojt->application_endtime != '' ? date("Y-m-d", strtotime($ojt->application_starttime)) : '' }}"--}}
{{--                                               type="text" name="application_starttime" id="application_starttime"--}}
{{--                                               class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="w-1/2">--}}
{{--                                    <div class="relative">--}}
{{--                                        <div--}}
{{--                                            class="absolute inset-y-0 end-0 top-0 flex items-center pe-3.5 pointer-events-none">--}}
{{--                                            <svg class="w-5 h-5 text-gray-300 dark:text-white" aria-hidden="true"--}}
{{--                                                 xmlns="http://www.w3.org/2000/svg" width="24" height="24"--}}
{{--                                                 fill="none" viewBox="0 0 24 24">--}}
{{--                                                <path stroke="currentColor" stroke-linecap="round"--}}
{{--                                                      stroke-linejoin="round" stroke-width="2"--}}
{{--                                                      d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z" />--}}
{{--                                            </svg>--}}
{{--                                        </div>--}}
{{--                                        <input disabled value="{{ $ojt->application_endtime != '' ? date("Y-m-d", strtotime($ojt->application_endtime)) : '' }}"--}}
{{--                                               type="text" name="application_endtime" id="application_endtime"--}}
{{--                                               class="bg-[#F5F7FA] border border-[#EDEDED] text-gray-900 p-2.5 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full  dark:bg-[#1E1E1E] dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">--}}

{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                    <div class="flex flex-col gap-6">--}}
{{--                        <p class="text-xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.ojt_detail.inquires.root') }}</p>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.inquires.hr_name') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   placeholder="" disabled value="{{ $ojt->hr_name }}" />--}}
{{--                        </div>--}}
{{--                        <div class="">--}}
{{--                            <label for="email"--}}
{{--                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.inquires.hr_email') }}</label>--}}
{{--                            <input readonly type="email" id="email"--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   value="{{ $ojt->hr_email }}" disabled />--}}
{{--                        </div>--}}
{{--                        <div>--}}
{{--                            <label for=""--}}
{{--                                   class="block mb-2 text-sm font-medium text-[#706F81] dark:text-white">{{ trans('cgo.job_support.ojt_list.ojt_detail.inquires.hr_contact_info') }}</label>--}}
{{--                            <input readonly type="text" id=""--}}
{{--                                   class="border bg-[#F5F7FA] border-[#EDEDED] text-[#201F36] text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-[#1E1E1E] dark:border-white dark:placeholder-text-white dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 placeholder:font-medium placeholder:text-[#201F36] font-medium"--}}
{{--                                   value="{{ $ojt->hr_contact_info }}" disabled />--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </form>--}}
                <x-o-j-t-details :ojt="$ojt" />
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.3.0/datepicker.min.js"></script> --}}
    <script>
        if ('{{ Session::get('success') }}') {
            Toastify({
                text: '{{ Session::get('success') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #00b09b, #96c93d)",
                },
                onClick: function() {}
            }).showToast();
        } else if ('{{ Session::get('error') }}') {
            Toastify({
                text: '{{ Session::get('error') }}',
                duration: 3000,

                newWindow: true,
                close: true,
                gravity: "top",
                position: "right",
                stopOnFocus: true,
                style: {
                    background: "linear-gradient(to right, #db4a4a, #bb7f7f)",
                },
                onClick: function() {}
            }).showToast();
        }
    </script>
    <script>
        $(".btn-readmore").click(function () {
            let answer = $(this).data('answer');
            $("#article-answer").html(answer);
            $(this).addClass('hidden');
            // $("form input[name='id']")
            $('.btn-showless').removeClass('hidden');
        });
        $(".btn-showless").click(function () {
            let summary = $(this).data('summary');
            $("#article-answer").html(summary);
            $(this).addClass('hidden');
            $('.btn-readmore').removeClass('hidden');
        });
    </script>
    <script>
        function handleBookmarkOJT(button) {
            toggleLoadingOverlay();
            const traineeId = button.getAttribute('data-trainee-id');
            const ojtId = button.getAttribute('data-ojt-id');
            $.ajax({
                url: '{{ route('trainee.job-support.ojt.mark-ojt') }}',
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    trainee_id: traineeId,
                    ojt_id: ojtId,
                },
                success: function (response) {
                    let status = false;
                    if (response.action == 'mark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                        status = true;
                    } else if (response.action == 'unmark') {
                        var svgElement = button.querySelector('svg');
                        svgElement.classList.toggle('fill-primary');
                        status = true;
                    }
                    if (status) {
                        showToast(response.message, 3000, response.status);
                    } else {
                        showToast(response.message, 3000, response.status);
                    }
                    toggleLoadingOverlay();
                },
                error: function (xhr, status, error) {
                    toggleLoadingOverlay();
                    console.error('Error:', error);
                }
            });
        }

        function showToast(message, dru, status) {
            let bg_color = '#9e9d9d';
            switch (status) {
                case 'success':
                    bg_color = 'linear-gradient(to right, #00b09b, #96c93d)';
                    break;
                case 'error':
                    bg_color = 'linear-gradient(to right, #db4a4a, #bb7f7f)';
                    break;

            }
            Toastify({
                text: message,
                duration: dru,

                newWindow: true,
                close: true,
                gravity: "top", // `top` or `bottom`
                position: "right", // `left`, `center` or `right`
                stopOnFocus: true, // Prevents dismissing of toast on hover
                style: {
                    background: bg_color,
                },
                onClick: function () {
                } // Callback after click
            }).showToast();
        }
    </script>
@endpush
