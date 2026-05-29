@extends('portfolio.layouts.master')
@section('content')
    <style>
        { !! $css !!}
    </style>
    {!! stripslashes($html) !!}
@endsection
