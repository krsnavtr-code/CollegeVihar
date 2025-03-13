@php
    $page_title = 'Scholarship Exam';
@endphp
@push('css')
    <style>
        .text-primary {
            color: #007bff !important;
        }

        .search-form .form-group {
            margin-right: 10px;
        }

        .badge {
            font-size: 14px;
            margin: 0 5px;
        }
 

        label {
            display: block;
            margin-bottom: 5px;
        }

        .form-control {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #00A2E8;
            ;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #00796b;
        }

        .search-btn {
            cursor: pointer;
            border: none;
            font-size: 1rem;
            font-weight: 600;
            color: #fff;
            height: 44px;
            border-radius: 2px;
            background: #f37921;
            outline: none;
            width: 110px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
            transition: background-color 0.3s;
        }

        .search-btn:hover {
            background-color: #0056b3;
        }

        .search-form {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 20px;
        }

        .form-group {
            margin-right: 15px;
        }

        .row {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
        }

        .col-md-3 {
            flex: 0 0 33.3333%;
            max-width: 33.3333%;
            padding: 10px;
            box-sizing: border-box;
        }

        .category-card {
            background-color: #f8f9fa;
            border-radius: 10px;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            max-width: 24rem;
            margin: auto;
        }

        .category-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .category-card .icon {
            color: #007bff;
        }

        .category-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 15px;
        }

        .category-card .btn {
            padding: 10px 20px;
            font-size: 0.9rem;
            font-weight: 500;
            text-transform: uppercase;
        }


        @media (max-width: 767px) {
            .category-card {
                padding: 20px;
            }

            .category-card h3 {
                font-size: 1.1rem;
            }

            .category-card .btn {
                width: 100%;
            }
        }
    </style>
@endpush

@extends('user.info.layout')
@section('main_section')
    <main>
        <div class="container my-5">
            <h2 class="text-center my-5">Choose Your Desired Category</h2>
            <div class="row text-center">
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-graduation-cap fa-3x"></i>
                        </div>
                        <h3>Indian Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'indian') }}" class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-globe fa-3x"></i>
                        </div>
                        <h3>International Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'international') }}"
                            class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-search fa-3x"></i>
                        </div>
                        <h3>Research Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'research') }}" class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-graduation-cap fa-3x"></i>
                        </div>
                        <h3>Minority Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'minority') }}" class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-graduation-cap fa-3x"></i>
                        </div>
                        <h3>BPL Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'bpl') }}" class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
                <div class="col-md-4 col-sm-6 col-12 mb-4">
                    <div class="category-card p-4 shadow-sm rounded">
                        <div class="icon mb-3">
                            <i class="fa fa-graduation-cap fa-3x"></i>
                        </div>
                        <h3>All Scholarships</h3>
                        <a href="{{ url('/scholarship-details', 'all') }}" class="btn btn-primary mt-3">Scholarship
                            Details</a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')

    @endpush
@endsection