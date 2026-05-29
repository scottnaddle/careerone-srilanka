@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Employment - Newsletter')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('homepage')],
            ['label' => 'Career Guidance', 'url' => '#'],
            ['label' => 'Newsletter', 'url' => route('career-guidance.employment.newsletter')],
            ['label' => \Str::limit($newsLetter->title,40), 'url' => '#'],
        ]" />
        </div>
        <div class="bg-white dark:bg-[#1E1E1E] rounded-xl px-4 py-5 flex flex-col gap-4 md:gap-6 pb-10">
            <div class="flex flex-col gap-4 md:gap-6">
{{--                <span class="text-xl text-primary dark:text-white flex justify-start items-center font-semibold">--}}
{{--                    <div class="mr-2 w-1 h-4 bg-primary dark:bg-white rounded"></div>{{ trans('company.job_support.employments.news_letter.root')}}--}}
{{--                </span>--}}
                <div class="flex flex-col gap-4">
                    <p class="font-semibold dark:text-white">Category: {{ $newsLetter->newsletterCategory->name ?? 'No category' }}</p>
                    <p class="dark:text-white">{{$newsLetter->title}}</p>
                    @if ($newsLetter->thumbnail)
                        <img src="{{ asset('storage/' . $newsLetter->thumbnail) }}" alt="Thumbnail" class="rounded-xl  click-zoom" style="max-width: 300px;">
                    @endif
                    @if ($newsLetter->attachment)
                        <p class="dark:text-white"><a href="{{ asset($newsLetter->attachment) }}" target="_blank">Attachment: <span class="underline text-primary">{{basename($newsLetter->attachment)}}</span></a></p>
                    @endif

                </div>

            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        let url = new URL(window.location.href);
        $('#year').on('change', function() {
            if (url.searchParams.has('year')) {
                url.searchParams.set('year', this.value);
                url.searchParams.delete('page');
            } else {
                url.searchParams.append('year', this.value);
                url.searchParams.delete('page');
            }
            window.location.href = url.href;
        });
    </script>
@endpush
