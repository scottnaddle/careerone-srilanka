@extends('homepage.layouts.master')
@section('title', 'CGO - Job support - Job List - Trainee Information')

@section('content')
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.root') }}</p>--}}
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('cgo.menu.job_support.root'), 'url' => '#'],
                ['label' => trans('cgo.menu.job_support.job_list'), 'url' => route('cgo.job-support.job-list.list')],
                ['label' => trans('cgo.job_support.ojt_list.trainee_match.trainee_apply'), 'url' => route('cgo.job-support.job-list.list-applied', ['job_id' => $job->id, 'slug' => $job->slug])],
                ['label' => trans('cgo.job_support.ojt_list.trainee_match.trainee_information.root'), 'url' => '#']
            ]" />
        </div>
        <form id="form-submit" action="{{ route('cgo.job-support.job-list.match-trainee') }}" method="POST" id="match">
            @csrf
            <input value="{{ $trainee->id }}" name="trainee_id" hidden />
            <input value="{{ $job->id }}" name="job_id" hidden />
            <input value="{{ Auth::guard(activeGuard())->user()->id }}" name="matched_by" hidden />
            <input value="{{ activeGuard() }}" name="system" hidden />
            <input value="true" name="redirect" hidden />


            <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
                <a class="text-xl text-[#464559] dark:text-white flex gap-4 items-center font-semibold"
                   href="{{ url()->previous() }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                        <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2"
                              stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    {{ $trainee->fullName }}
                </a>
                <div class="flex flex-col gap-5 divide-y divide-inherit dark:divide-white lg:divide-y-0 p-5">
                    <div class="flex flex-col lg:flex-row gap-6 items-center border-b pb-4">
                        @if($trainee->profile_image != '')
                            <img class="w-32 h-32 rounded-full" src="{{ asset($trainee->profile_image) }}" alt="user photo">
                        @else
                            <img class="w-32 h-32 rounded-full" src="{{ asset('images/user-default.svg') }}" alt="user photo">
                        @endif
                        <div class="flex flex-col gap-2 text-center lg:text-left">
                            <p class="text-[#464559] dark:text-white text-2xl lg:text-3xl font-semibold">
                                {{ $trainee->fullName }}</p>
                            <p class="text-[#706F81] dark:text-white text-lg">{!! getNewestTrainingInformationOfTrainee($trainee->id) !!}
                            </p>

                        </div>
                    </div>
                    <div class="py-6 flex flex-col gap-9">
                        <div class="flex flex-col gap-4">
                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.basic_information') }}</p>
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
                                        <span
                                            class="text-sm text-[#464559] dark:text-white">{{ $trainee->fullName }}</span>
                                    </div>
                                    <div class="flex gap-4">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                             viewBox="0 0 20 20" fill="none">
                                            <path
                                                d="M6.98356 7.37779C7.56356 8.58581 8.35422 9.71801 9.35553 10.7193C10.3568 11.7206 11.4891 12.5113 12.6971 13.0913C12.801 13.1412 12.8529 13.1661 12.9187 13.1853C13.1523 13.2534 13.4392 13.2045 13.637 13.0628C13.6927 13.0229 13.7403 12.9753 13.8356 12.88C14.1269 12.5887 14.2726 12.443 14.4191 12.3478C14.9715 11.9886 15.6837 11.9886 16.2361 12.3478C16.3825 12.443 16.5282 12.5887 16.8196 12.88L16.9819 13.0424C17.4248 13.4853 17.6462 13.7067 17.7665 13.9446C18.0058 14.4175 18.0058 14.9761 17.7665 15.449C17.6462 15.6869 17.4248 15.9083 16.9819 16.3512L16.8506 16.4825C16.4092 16.9239 16.1886 17.1446 15.8885 17.3131C15.5556 17.5001 15.0385 17.6346 14.6567 17.6334C14.3126 17.6324 14.0774 17.5657 13.607 17.4322C11.0792 16.7147 8.69387 15.361 6.70388 13.371C4.7139 11.381 3.36017 8.99569 2.6427 6.46786C2.50919 5.99749 2.44244 5.7623 2.44141 5.41818C2.44028 5.03633 2.57475 4.51925 2.76176 4.18633C2.9303 3.88631 3.15098 3.66563 3.59233 3.22428L3.72369 3.09292C4.16656 2.65005 4.388 2.42861 4.62581 2.30833C5.09878 2.0691 5.65734 2.0691 6.1303 2.30832C6.36812 2.42861 6.58955 2.65005 7.03242 3.09291L7.19481 3.25531C7.48615 3.54665 7.63182 3.69231 7.72706 3.8388C8.08622 4.3912 8.08622 5.10336 7.72706 5.65576C7.63182 5.80225 7.48615 5.94791 7.19481 6.23925C7.09955 6.33451 7.05192 6.38214 7.01206 6.43782C6.87038 6.63568 6.82146 6.92256 6.88957 7.15619C6.90873 7.22193 6.93367 7.27389 6.98356 7.37779Z"
                                                stroke="#91919A" stroke-width="1.2" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                        </svg>
                                        <span
                                            class="text-sm text-[#464559] dark:text-white">{{ !empty($trainee->telephone) ? $trainee->telephone : $trainee->mobile }}</span>
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
                                        <span class="text-sm text-[#464559] dark:text-white">{{ $trainee->email }}</span>
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
                                        <span
                                            class="text-sm text-[#464559] dark:text-white">{{ $trainee->contact_address }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{--                        <div class="flex flex-col gap-4">--}}
                        {{--                            <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.about_me') }}</p>--}}
                        {{--                            <p class="text-lg text-[#706F81] dark:text-white">--}}
                        {{--                                {{ $trainee->traineeInformation->basic_information }}</p>--}}
                        {{--                        </div>--}}
                        <div class="flex gap-6 flex-col">
                            <div class="flex flex-col gap-4 w-full lg:w-1/2">
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.education') }}</p>
                                    @if(isset($trainee->traineeInformation) && $trainee->traineeInformation->content != null)
                                        @foreach(json_decode($trainee->traineeInformation->content) as $item)
                                            <div class="flex  flex-col gap-4">
                                                <div class="flex gap-4 items-baseline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                         viewBox="0 0 10 10" fill="none">
                                                        <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                                    </svg>
                                                    <div class="flex flex-col gap-2">
                                                        <p>
                                                            <span
                                                                class="text-[#464559] text-xl font-semibold dark:text-white">{{ $item->COURSE->COURSE_NAME }}</span>
                                                            <span
                                                                class="text-[#706F81]  dark:text-white">({{ $item->INSTITUTE->INSTITUTE_NAME }})</span>
                                                        </p>
                                                        <p>
                                                            <span
                                                                class="text-[#91919A] dark:text-white">{{ $item->COURSE->START_DATE }}
                                                                - {{ $item->COURSE->END_DATE }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="dark:text-white">No information</p>
                                    @endif

                                </div>
                                <div class="flex flex-col gap-4">
                                    <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.certificate') }}</p>
                                    @if(isset($trainee->traineeInformation) && $trainee->traineeInformation->nvq_content!= null)
                                        @foreach (json_decode($trainee->traineeInformation->nvq_content) as $item)
                                            <div class="flex  flex-col gap-4">
                                                <div class="flex gap-4 items-baseline">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10"
                                                         viewBox="0 0 10 10" fill="none">
                                                        <circle cx="5" cy="5" r="5" fill="#4984F6" />
                                                    </svg>
                                                    <div class="flex flex-col gap-2">
                                                        <p>
                                                        <span
                                                            class="text-[#464559] text-xl font-semibold dark:text-white">{{ $item->QUALIFICATION_NAME }} </span>
                                                            <span class="text-[#706F81] dark:text-white">({{ $item->QUALIFICATION_LEVEL }})</span>
                                                        </p>
                                                        <p>
                                                        <span
                                                            class="text-[#91919A] dark:text-white">{{ $item->EFFECTIVE_DATE }}</span>
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="dark:text-white">No information</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-6 flex-col">
                            <div class="flex flex-col gap-4 w-full lg:w-1/2">
                                <p class="text-2xl text-[#4984F6] dark:text-white font-semibold">{{ trans('company.job_support.trainee_list.modal_content.portfolio') }}</p>
                                <div class="flex  flex-wrap gap-4">
                                    @if($trainee->portfolio && $trainee->public_portfolio)
                                        <div class="flex flex-col gap-4">
                                            <div class="flex gap-4 items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                                    <circle cx="5" cy="5" r="5" fill="#4984F6"/>
                                                </svg>
                                                <div class="flex flex-col gap-2">
                                                    <p>
                                                        <a href="{{route('trainee.career-guidance.portfolio.preview-portfolio', ['pid'=>$trainee->portfolio->id])}}" target="_blank" class="text-[#464559] text-xl font-semibold dark:text-white dark:text-white hover:text-primary dark:hover:text-primary flex items-center gap-1"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                                                <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                                            </svg>
                                                            View</a>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="dark:text-white">No information</span>
                                    @endif


                                </div>

                            </div>
                        </div>
{{--                        <div class="flex justify-end">--}}
{{--                            @if ($trainee->isMatchJob($job->id))--}}
{{--                                @if(getCGOIdMatchedTraineeToJob($trainee->id, $job->id) != Auth::guard(activeGuard())->user()->id)--}}
{{--                                    <button type="button" disabled--}}
{{--                                            class="cursor-not-allowed py-2.5 px-4 text-white bg-[#F34550] hover:bg-red-800 text-sm font-medium rounded-full">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.unmatch_button') }}</button>--}}
{{--                                @else--}}
{{--                                    <button type="button" data-modal-target="delete-modal" data-modal-toggle="delete-modal"--}}
{{--                                            class="py-2.5 px-4 text-white bg-[#F34550] hover:bg-red-800 text-sm font-medium rounded-full">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.unmatch_button') }}</button>--}}
{{--                                @endif--}}
{{--                            @else--}}
{{--                                <button type="submit"--}}
{{--                                        class="py-2.5 px-4 text-white bg-primary hover:bg-blue-800 text-sm font-medium rounded-full block">{{ trans('cgo.job_support.ojt_list.trainee_match.trainee_information.match_button') }}</button>--}}
{{--                            @endif--}}
{{--                        </div>--}}
                    </div>
                </div>
            </div>
        </form>

    </div>

@endsection
@push('js')
    <script>
        $('#confirm_unmatch').click(function(e) {
            e.preventDefault();
            $('#form-submit').submit();
        })
    </script>
@endpush
