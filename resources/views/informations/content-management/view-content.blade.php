@extends('homepage.layouts.master')
@section('title', 'Information - Content management - Document')

@section('content')
    <div class="pt-6">
        <div class="mx-auto px-6 py-8 bg-white">
            <!-- Breadcrumb -->
            <div class="text-sm text-gray-500 mb-2">
                <a href="#" class="hover:underline">{{ $content->title }}</a>
            </div>

            <!-- Title -->
            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 mb-1">
                {{ $content->title }}
            </h1>

            <!-- Author -->
            <p class="text-sm text-right text-gray-500 mb-4">By
                {{ $content->getAuthor($content->system, $content->created_by)->fullName }}</p>
            {{--       
        <!-- Badge -->
        <span class="inline-block bg-[#4984F6] text-white text-sm font-semibold px-3 py-1 rounded-lg mb-4">
          Rectangle 212
        </span> --}}

            <!-- Image -->
            @if ($content->content_type === 'video')
                <div class="rounded-xl border border-[#4984F6] overflow-hidden mb-6 h-[300px]">
                    <iframe src="{{ getYoutubeEmbedUrl($content->video_url) }}" class="w-full h-full" frameborder="0"
                        allowfullscreen>
                    </iframe>
                </div>
            @else
                <div class="rounded-xl border border-[#4984F6] overflow-hidden mb-6 max-h-[300px]">
                    <img src="{{ asset($content->attachment_details['path']) }}" alt="Cover Image"
                        class="w-full object-cover">
                </div>
            @endif


            <!-- Content -->
            <div class="text-sm md:text-base text-gray-700 leading-relaxed space-y-4">
                {!! $content->intro !!}
            </div>
            <!-- Button -->
            <div class="mt-8 text-end">
                <a href="{{ route('cgo.informations.content-management.show-review', $content) }}"><button
                        class="bg-[#4984F6] hover:bg-[#3a6cd9] text-white font-medium px-6 py-2 rounded-full transition">
                        Form Response
                    </button></a>

            </div>
        </div>
    </div>



@endsection
@push('js')
@endpush
