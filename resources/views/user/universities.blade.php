@extends('user.components.layout')
@push('css')
    <link rel="stylesheet" href="/css/university.css">
    <style></style>
@endpush
@section('main')
    <main>
        <div class="universities">
            <div class="row">
                @php
                    $universities = Request::get('universities');
                    shuffle($universities);
                @endphp
                @foreach ($universities as $university)
                    <x-university :univ="$university" />
                @endforeach
            </div>
        </div>
    </main>
@endsection
