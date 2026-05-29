@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job Information - Job details')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => 'Home', 'url' => route('homepage')],
                ['label' => 'Career Guidance', 'url' => '#'],
                ['label' => 'Job/Career Information', 'url' => ''],
                ['label' => 'Job outlook', 'url' => '#'],
                ['label' => 'Job outlook detail ', 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-6">
                <a class="text-xl text-[#464559] dark:text-white  dark:text-white flex gap-4 items-center font-semibold" href="{{route('career-guidance.career-information.job-information')}}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="9" height="14" viewBox="0 0 9 14" fill="none">
                        <path d="M7.5 1L1.5 7L7.5 13" stroke="#354052" class="dark:stroke-white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    {{$job->title}}
                </a>
                <div class="flex flex-col gap-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="flex flex-col gap-2">
                            <p class="font-semibold text-[#201F36] dark:text-white">Expected Income per month</p>
                            <p class="text-[#464559] dark:text-white  px-4 py-3 border border-[#EDEDED] rounded-lg">{{$job->expected_income_per_month}}</p>
                        </div>
                        <div class="flex flex-col gap-2">
                            <p class="font-semibold text-[#201F36]">Job catagory</p>
                            <p class="text-[#464559] dark:text-white  px-4 py-3 border border-[#EDEDED] rounded-lg">{{$job->sector()->name}}</p>
                        </div>
{{--                        <div class="flex flex-col gap-2">--}}
{{--                            <p class="font-semibold text-[#201F36]">Sub sector</p>--}}
{{--                            <p class="text-[#464559] dark:text-white  px-4 py-3 border border-[#EDEDED] rounded-lg">{{$job->sector()->sub_sector_name}}</p>--}}
{{--                        </div>--}}
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-4 px-4">
                            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Job Description</span>
                            <p class="text-[#706F81] dark:text-white text-sm md:text-base">{{$job->description}}</p>
                        </div>
                        <div class="flex flex-col gap-4 px-4">
                            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Knowledge</span>
                            <div class="flex flex-col gap-4 text-sm md:text-base">
                                @forelse(json_decode($job->knowledge) as $knowledge)
                                <div class="flex gap-4 items-center">
                                    <div class="bg-gray-200 rounded-full h-2.5 dark:bg-white w-1/3">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{$knowledge->value}}%"></div>
                                    </div>
                                    <p class="text-sm text-[#464559] dark:text-white  dark:text-white w-2/3">{{$knowledge->text}}</p>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                        <div class="flex flex-col gap-4 px-4">
                            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Skills</span>
                            <div class="flex flex-col gap-4 text-sm md:text-base">
                                @forelse(json_decode($job->skills) as $skill)
                                <div class="flex gap-4 items-center">
                                    <div class="bg-gray-200 rounded-full h-2.5 dark:bg-white w-1/3">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{$skill->value}}%"></div>
                                    </div>
                                    <p class="text-sm text-[#464559] dark:text-white  dark:text-white w-2/3">{{$skill->text}}</p>
                                </div>
                                @empty
                                @endforelse
                            </div>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 px-4">
                        <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Duties of the Job</span>
{{--                        <p class="text-sm md:text-base text-[#706F81] dark:text-white">{{$job->duties_of_the_job}}</p>--}}
                        <div class="dark:text-white  w-full ">
                            {!! nl2br(e($job->duties_of_the_job)) !!}
                        </div>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="flex flex-col gap-4 px-4">
                            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Related Occupations</span>
                            <ul class=" space-y-1 list-disc list-inside text-[#706F81] dark:text-white px-2 text-sm md:text-base">
                                @forelse(json_decode($job->related_occupations) as $occupation)
                                <li class="text-[#706F81] dark:text-white text-sm md:text-base">
                                    {{ $occupation->occupation}}
                                </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                        <div class="flex flex-col gap-4 px-4">
                            <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Benefits</span>
                            <ul class=" space-y-1 list-disc list-inside text-[#706F81] dark:text-white px-2 text-sm md:text-base">
                                @forelse(json_decode($job->benefits) as $benefit)
                                    <li class="text-[#706F81] dark:text-white text-sm md:text-base">
                                        {{ $benefit->benefits }}
                                    </li>
                                @empty
                                @endforelse
                            </ul>
                        </div>
                    </div>
                    <div class="flex flex-col gap-4 px-4">
                        <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Attachment</span>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            @if($job->attachment_details != '' && count(json_decode($job->attachment_details)) > 0)
                                @forelse(json_decode($job->attachment_details) as $attachment)
                                    <a target="_blank" href="{{asset('storage/'.$attachment->path)}}" class="flex items-center gap-2 underline text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                        </svg>
                                        {{$attachment->file_name}}</a>
                                @empty

                                @endif
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
