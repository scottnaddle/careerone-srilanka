@extends('homepage.layouts.master')
@section('title', 'Career Information - Job Information')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('system.menu.career_guidance.job_information.root'), 'url' => '#'],
                ['label' => trans('system.menu.career_guidance.job_information.job_outlook'), 'url' => '#'],
            ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-5">
            <div class="flex flex-col gap-4">
                <form method="get">
                    <div class="flex flex-col">
                        <div class="flex gap-6 items-center">
                            <label for="simple-search" class="sr-only">Search</label>
                            <div class="relative w-full">
                                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                    <svg class="w-4 h-4 text-[#706F81] dark:text-gray-400" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                    </svg>
                                </div>
                                <input type="text" id="simple-search"
                                       class="bg-gray-50 border border-[#EDEDED] text-[#706F81] text-sm rounded-lg focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-[#1E1E1E] dark:border-white dark:placeholder-white dark:text-white"
                                       placeholder="{{ __('general.Job title') }}" name="keyword" value="{{ $keyword }}" required />
                            </div>
                            <button type="submit"
                                    class="px-6 lg:px-12 py-2.5 font-medium text-white bg-primary rounded-full hover:bg-blue-800  shadow-xs">
                                {{__('system.form.button.search')}}
                            </button>
                        </div>
                    </div>
                </form>
                <div class="flex gap-4 flex-col items-start">
                    @if ($keyword != '')
                        <div>
                            <p class="text-[#706F81] text-lg dark:text-white relative flex items-center">Result for <span
                                    class="font-semibold px-2 py-1 bg-gray-100 rounded-xl">{{ $keyword }}</span> <a
                                    href="{{ route('career-guidance.career-information.job-information') }}"
                                    class="absolute -right-1 -top-1 pl-3"><svg xmlns="http://www.w3.org/2000/svg"
                                                                               fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                                               class="size-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" class="stroke-red-500"
                                              d="M15 12H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                    </svg>
                                </a>:</p>
                        </div>

                        {{--                        <p class="text-[#706F81] text-lg font-semibold dark:text-white">{{$count}} Results</p> --}}
                    @endif

                </div>
                <div class="relative overflow-x-auto">
                    <div id="accordion-collapse" data-accordion="collapse"
                         data-active-classes="bg-primary dark:bg-[#383838] text-white dark:text-white">
                        @forelse($sectors as $key => $sector)
                            @if (count($sector->jobs) > 0)
                            <h2 id="accordion-collapse-heading-sector-{{ $sector->id }}">
                                <button type="button"
                                        class="flex items-center justify-between w-full p-5 font-semibold rtl:text-right text-gray-500 {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}  dark:border-gray-700 dark:text-gray-400 hover:bg-primary hover:text-white dark:hover:bg-gray-800 gap-3"
                                        data-accordion-target="#accordion-collapse-body-sector-{{ $sector->id }}"
                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                        aria-controls="accordion-collapse-body-1">
                                    <span>{{ $sector->name }}</span>
                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M9 5 5 1 1 5" />
                                    </svg>
                                </button>
                            </h2>
                            <div id="accordion-collapse-body-sector-{{ $sector->id }}" class="hidden"
                                 aria-labelledby="accordion-collapse-heading-sector-{{ $sector->id }}">
                                <div class="pl-12 dark:border-gray-700 dark:bg-[#1E1E1E]  pr-4">
                                    @forelse($sector->getSubSectors() as $key => $subSector)
                                        <div id="accordion-collapse-subsector-{{ $subSector->id }}"
                                             data-accordion="collapse" data-active-classes="bg-white dark:bg-[#1E1E1E]">
                                            <h2 id="accordion-collapse-heading-subsector-{{ $subSector->id }}">
                                                <button type="button"
                                                        class="flex items-center justify-between w-full p-5 font-semibold rtl:text-right text-primary  dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-900 gap-3"
                                                        data-accordion-target="#accordion-collapse-body-subsector-{{ $subSector->id }}"
                                                        aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                        aria-controls="accordion-collapse-body-subsector-{{ $subSector->id }}">
                                                    <span>{{ $subSector->name }}</span>
                                                    <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0"
                                                         aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 10 6">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                              stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                                    </svg>
                                                </button>
                                            </h2>
                                            <div id="accordion-collapse-body-subsector-{{ $subSector->id }}" class="hidden"
                                                 aria-labelledby="accordion-collapse-heading-subsector-{{ $subSector->id }}">
                                                <div
                                                    class="px-14 dark:border-gray-700 dark:bg-[#1E1E1E] flex flex-col gap-4 py-4">
                                                    @forelse($subSector->jobs as $job)
                                                        <a href="{{ route('career-guidance.career-information.job-information.job-details', ['slug' => $job->slug]) }}"
                                                           class="text-[#706F81] text-sm dark:text-white hover:text-primary">{{ $job->title }}</a>
                                                    @empty
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                    @endforelse
                                    @if (count($sector->jobs) > 0)
                                        <div class=" dark:border-gray-700 dark:bg-[#1E1E1E] flex flex-col gap-4 py-4">
                                            @forelse($sector->jobs as $job)
                                                <div
                                                    class="flex flex-col rounded-xl border border-gray-300 dark:border-white p-4 gap-4">
                                                    <a href="{{ route('career-guidance.career-information.job-information.job-details', ['slug' => $job->slug]) }}"
                                                       class="text-[#706F81] text-base dark:text-white hover:text-primary font-semibold underline">{{ $job->title }}</a>
                                                    <div class="flex flex-col gap-2 px-4 ">
                                                        <span
                                                            class="text-base text-primary dark:text-white flex justify-start items-center font-semibold">Attachment</span>
                                                        <div class="grid grid-cols-1 md:grid-cols-3 gap-2 break-all">
                                                            @if ($job->attachment_details != '' && count(json_decode($job->attachment_details)) > 0)
                                                                @forelse(json_decode($job->attachment_details) as $attachment)
                                                                    <a target="_blank"
                                                                       href="{{ asset('storage/' . $attachment->path) }}"
                                                                       class="flex items-center gap-2 underline text-primary text-sm">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                             fill="none" viewBox="0 0 24 24"
                                                                             stroke-width="1.5" stroke="currentColor"
                                                                             class="size-6">
                                                                            <path stroke-linecap="round"
                                                                                  stroke-linejoin="round"
                                                                                  d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                                                        </svg>
                                                                        {{ $attachment->file_name }}</a>
                                                                @empty

                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>

                                            @empty
                                            @endforelse
                                        </div>
                                    @endif
                                </div>
                            </div>
                            @endif
                        @empty
                        @endforelse
                    </div>

                </div>

            </div>
        </div>
    </div>
@endsection
