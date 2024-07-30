@extends('frontend.layouts.app')

@section('title', 'Beranda')

@section('content')
    @include('frontend.components.navbar')
    @include('frontend.components.banner')
    @include('frontend.components.services')
    @include('frontend.components.mapbox')
@endsection
