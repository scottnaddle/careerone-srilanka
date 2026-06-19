@extends('homepage.layouts.master')
@section('title', 'Portfolio Builder')

@push('css')
    @vite(['resources/js/vue/main.js'])
@endpush

@section('content')
    <div id="app" data-portfolio='@json($portfolioData)' data-districts='@json($districts ?? [])' data-genders='@json($genders ?? [])' data-lang="{{ app()->getLocale() }}"></div>
@endsection
