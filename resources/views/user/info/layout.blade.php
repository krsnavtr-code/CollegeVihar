@extends('user.components.layout')
@push('css')
    <link rel="stylesheet" href="{{ url('/css/info.css') }}">
    <link rel="stylesheet" href="{{ url('/css/breadcrumb.css') }}">
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet" /> --}}
@endpush
@section('main')
    @include('user.components.breadcrumbs.breadcrumb')
    @yield('main_section')
@endsection
