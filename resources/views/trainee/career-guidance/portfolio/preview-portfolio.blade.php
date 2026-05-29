@extends('portfolio.layouts.master')
@section('content')
    <style>
        {!! stripslashes($portfolio->css) !!}
    </style>
    {!! stripslashes(trim($portfolio->html, '"')) !!}
@endsection
