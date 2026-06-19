@extends('homepage.layouts.master')
@section('title', 'Career Guidance - Job/Career Information - Content details')
@push('css')


@endpush
@section('content')
    <div class="mb-6 flex flex-col gap-6">
        <div class="py-6">
            <x-breadcrumb :items="[
               ['label' => trans('cgo.menu.home'), 'url' => route('homepage')],
                ['label' => trans('system.menu.information.root'), 'url' => '#'],
                ['label' => trans('system.information.content_management.title'), 'url' => route(activeGuard().'.informations.content-management.videos.list')],
                ['label' => trans('cgo.menu.information.content_management.peer_content_list'), 'url' => route('cgo.informations.content-management.peer-review.list')],
                ['label' => $content->category->name, 'url' => '#'],
            ]" />
        </div>
        <div class="flex flex-col gap-6 p-4 bg-white dark:bg-[#1E1E1E] rounded-xl">
            <a href="{{ url()->previous() }}"
               class="text-gray-900 dark:bg-gray-950  dark:text-white border-gray-200 font-medium rounded-xl text-center inline-flex items-center">
                <svg class="w-5 h-5 text-gray-800 dark:text-white mr-2" aria-hidden="true"
                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="m15 19-7-7 7-7" />
                </svg>
                <h3 class="text-lg font-semibold text-[#464559] dark:text-white">{{$content->title}}</h3>
            </a>

            <x-content-details :content="$content" />

        </div>

        <x-peer-review-content-response-form :content="$content" :questionList="$questionList" :peerItem="$peerItem" />

        </div>

    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            $('input[type=radio]').on('change', function () {
                const name = $(this).attr('name'); // e.g. "1-2"
                const value = parseFloat($(this).val());

                const $textarea = $(`textarea[name="reason-${name}"]`);
                if ($textarea.length) {
                    if (value === 0 || value === 2.5) {
                        $textarea.show().attr('required', true);
                    } else {
                        $textarea.hide().removeAttr('required');
                    }
                }
            });
        });
    </script>
@endpush
