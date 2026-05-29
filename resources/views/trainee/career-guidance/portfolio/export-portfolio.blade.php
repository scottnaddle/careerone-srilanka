@extends('portfolio.layouts.master')
@section('content')
    <style>
        {!! stripslashes($css) !!}
    </style>
    {!! stripslashes(trim($html, '"')) !!}
@endsection
