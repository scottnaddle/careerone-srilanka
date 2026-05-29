@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Employment - Newsletter')

@section('content')
    <div class="mb-6 flex flex-col">
        <div class="py-6">
            @if (activeGuard() == 'company')
                <x-breadcrumb :items="[
                    ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                    ['label' => trans('company.menu.job_support.root'), 'url' => '#'],
                    ['label' => trans('company.menu.job_support.employment.root'), 'url' => '#'],
                    ['label' => trans('company.menu.job_support.employment.news_letter'), 'url' => '#'],
                ]" />
            @else
                <x-breadcrumb :items="[
                    ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                    ['label' => trans('system.menu.career_guidance.root'), 'url' => '#'],
                    ['label' => trans('system.menu.career_guidance.employment.root'), 'url' => '#'],
                    ['label' => trans('system.menu.career_guidance.employment.news_letter'), 'url' => '#'],
                ]" />
            @endif
        </div>
        <div class="relative overflow-x-auto bg-white dark:bg-[#1E1E1E] rounded-xl">
            <div id="accordion-collapse" data-accordion="collapse"
                data-active-classes="bg-primary dark:bg-[#383838] text-white dark:text-white">
                @forelse($categories as $key => $category)
                    <h2 id="accordion-collapse-heading-category-{{ $category->id }}">
                        <button type="button"
                            class="flex categorys-center justify-between w-full p-5 font-semibold rtl:text-right text-white {{ $loop->first ? 'rounded-t-xl' : '' }} {{ $loop->last ? 'rounded-b-xl' : '' }}  dark:border-gray-700 dark:text-gray-400 hover:bg-primary hover:text-white dark:hover:bg-gray-800 gap-3"
                            data-accordion-target="#accordion-collapse-body-category-{{ $category->id }}"
                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" aria-controls="accordion-collapse-body-1">
                            <span>{{ $category->getName() }}</span>
                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5 5 1 1 5" />
                            </svg>
                        </button>
                    </h2>
                    <div id="accordion-collapse-body-category-{{ $category->id }}" class="hidden"
                        aria-labelledby="accordion-collapse-heading-category-{{ $category->id }}">
                        <div class="pl-12 dark:border-gray-700 dark:bg-[#1E1E1E] pr-4">
                            @if (count($category->newsLetters) > 0)
                                <div class=" dark:border-gray-700 dark:bg-[#1E1E1E] flex flex-col gap-4 py-4">
                                    @forelse($category->newsLetters as $data)
                                        <div
                                            class="flex flex-col rounded-xl border border-gray-300 dark:border-white p-4 gap-4">
                                            <a href="{{route('career-guidance.employment.newsletter.preview', ['id'=>$data->id])}}"
                                                class="text-[#706F81] text-base dark:text-white hover:text-primary underline font-semibold">{{ $data->getName() }}</a>
                                            <div class="flex flex-col gap-2 px-4 ">
                                                <span
                                                    class="text-base text-primary dark:text-white flex justify-start categorys-center font-semibold">Attachment</span>
                                                <div class="grid grid-cols-1 md:grid-cols-3 gap-2 break-all">
                                                    @if ($data->getAttachment() != '')
                                                            <a target="_blank"
                                                                href="{{ asset($data->getAttachment()) }}"
                                                                class="flex categorys-center gap-2 underline text-primary text-sm">
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                                    viewBox="0 0 24 24" stroke-width="1.5"
                                                                    stroke="currentColor" class="size-6">
                                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                                        d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                                                </svg>
                                                                {{ basename($data->getAttachment()) }}</a>
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
                @empty
                @endforelse
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
