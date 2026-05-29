@extends('homepage.layouts.master')
@section('title', 'Company - Job support - Job Vacancy - Register Job')

@section('content')
    <link href="{{ asset('css/select2/select2.css') }}" rel="stylesheet" />
    <div class="mb-6 flex flex-col">
        {{--        <p class="text-2xl text-[#464559] dark:text-white font-semibold">{{ __('company.job_vacancy') }}</p> --}}
        <div class="py-6">
            @if (auth('company')->check())
                <x-breadcrumb :items="[
                    ['label' => trans('system.menu.home'), 'url' => route('homepage')],
                    ['label' => trans('company.menu.job_support.root'), 'url' => '#'],
                    ['label' => __('company.job_vacancy'), 'url' => route('company.job-support.job-vacancy.list')],
                    ['label' => __('company.job_details'), 'url' => '#'],
                ]" />
            @else
                <x-breadcrumb :items="[
                    ['label' => 'Home', 'url' => route('homepage')],
                    ['label' => 'Job list', 'url' => route('homepage.job-list')],
                    ['label' => $job->title, 'url' => '#'],
                ]" />
            @endif

        </div>
        {{-- job details section --}}
        <x-job-details :job="$job" />
        {{-- end new --}}
    </div>
@endsection
@push('js')
@endpush
