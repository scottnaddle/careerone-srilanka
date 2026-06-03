@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job/Career Information - Content details')

@section('content')
    <div class="mb-6 flex flex-col gap-6">
        <div class="pt-6">
            <x-breadcrumb :items="[
                ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                ['label' => trans('cgo.career_guidance.job_information.career_expert_interview.root'), 'url' => '#'],
                ['label' => $content->category->name, 'url' => '#'],
            ]" />
        </div>
        <div class="flex flex-col gap-6 p-4 bg-white dark:bg-[#1E1E1E] rounded-xl">
            <a href="{{ url()->previous() }}"
               class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center break-words">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{\Str::limit($content->title,100)}}</h3>
            </a>
            <x-content-details :content="$content" />
    </div>
        @php $type = 'content'; @endphp
        <x-content-comments :content="$content" :type="$type" />
@endsection
