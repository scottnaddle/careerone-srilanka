@extends('homepage.layouts.master')
@section('title', 'Career Information - Job Information')

@section('content')
    <div class="my-6 flex flex-col gap-5">
        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ trans('trainee.menu.career_guidance.job_career_information.root') }}</p>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <form method="get">
                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                                    </svg>
                                </div>
                                <input type="text" id="simple-search" class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white" placeholder="" name="keyword" value="{{ request('keyword') }}" required />
                            </div>
                            <button type="submit" class="px-6 lg:px-12 py-2 md:py-3 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                Search
                            </button>
                        </div>
                    </div>
                </form>

                <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold"><div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded" ></div>Job Information</span>
                <div class="flex gap-4 flex-col items-start">
                    @if(request('keyword') != '')
                        <div>
                            <p class="text-[#706F81] text-lg dark:text-white relative flex items-center">Result for <span class="font-semibold px-2 py-1 bg-gray-100 rounded-xl">{{request('keyword')}}</span> <a href="{{route('cgo.career-guidance.career-information.job-information')}}" class="absolute -right-1 -top-1 pl-3"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500" d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </a>:</p>
                        </div>

                        {{--                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{$count}} Results</p>--}}
                    @endif

                </div>
                <div class="relative overflow-x-auto">
                    <div id="accordion-collapse" data-accordion="collapse" data-active-classes="bg-primary dark:bg-[#383838] text-white dark:text-white">
                        @forelse($sectors as $key => $sector)
                            <h2 id="accordion-collapse-heading-sector-{{$sector->id}}">
                                <button type="button" class="flex items-center justify-between w-full p-5 font-semibold rtl:text-right text-white {{($loop->first) ? 'rounded-t-xl' : '' }} {{($loop->last) ? 'rounded-b-xl' : '' }}  dark:border-gray-700 dark:text-gray-400 hover:bg-primary hover:text-white dark:hover:bg-gray-800 gap-3" data-accordion-target="#accordion-collapse-body-sector-{{$sector->id}}" aria-expanded="{{($loop->first) ? 'true' : 'false'}}" aria-controls="accordion-collapse-body-1">
                                    <span>{{$sector->name}}</span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-sector-{{$sector->id}}" class="hidden" aria-labelledby="accordion-collapse-heading-sector-{{$sector->id}}">
                                <div class="pl-14 dark:border-gray-700 dark:bg-[#1E1E1E]">
                                    @forelse($sector->getSubSectors() as $key => $subSector)
                                        <div id="accordion-collapse-subsector-{{$subSector->id}}" data-accordion="collapse" data-active-classes="bg-white dark:bg-[#1E1E1E]">
                                            <h2 id="accordion-collapse-heading-subsector-{{$subSector->id}}">
                                                <button type="button" class="flex items-center justify-between w-full p-5 font-semibold rtl:text-right text-primary  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 gap-3" data-accordion-target="#accordion-collapse-body-subsector-{{$subSector->id}}" aria-expanded="{{($loop->first) ? 'true' : 'false'}}" aria-controls="accordion-collapse-body-subsector-{{$subSector->id}}">
                                                    <span>{{$subSector->name}}</span>
                                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5"/>
                                                    </svg>
                                                </button>
                                            </h2>
                                            <div id="accordion-collapse-body-subsector-{{$subSector->id}}" class="hidden" aria-labelledby="accordion-collapse-heading-subsector-{{$subSector->id}}">
                                                <div class="px-14 dark:border-gray-700 dark:bg-[#1E1E1E] flex flex-col gap-4 py-4">
                                                    @forelse($subSector->jobs as $job)
                                                        <a href="{{route('trainee.career-guidance.job-career-information.job-details', ['slug' => $job->slug])}}" class="w-fit text-[#706F81] text-sm dark:text-white hover:text-primary">{{$job->title}}</a>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                    @if(count($sector->jobs) > 0)
                                        <div class=" dark:border-gray-700 dark:bg-[#1E1E1E] flex flex-col gap-4 py-4">
                                            @forelse($sector->jobs as $job)
                                                <a href="{{route('trainee.career-guidance.job-career-information.job-details', ['slug' => $job->slug])}}" class="w-fit text-[#706F81] text-sm dark:text-white hover:text-primary">{{$job->title}}</a>
                                            @empty
                                            @endforelse
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                        @endforelse
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
