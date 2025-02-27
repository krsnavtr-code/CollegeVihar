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

        .category-card {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin: 10px;
            transition: transform 0.3s;
            width: 100%;
            max-width: 250px;
        }

        .category-card:hover {
            transform: scale(1.05);
        }

        .category-card .icon {
            font-size: 40px;
            color: #007bff;
            margin-bottom: 10px;
        }

        .category-card h3 {
            font-size: 18px;
            font-weight: bold;
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
    background-color: #00A2E8;;
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
            align-items:center;
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

</style>
@endpush

@extends('user.info.layout')
@section('main_section')
    <main>
        <div class="container my-5">
        
            <h2 class="text-center my-5">Choose Your Desired Category</h2>
            <div class="row text-center">
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                        <h3>Indian Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','indian') }}"class="btn">Scholarship Details</a>
                      
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-globe"></i></div>
                        <h3>International Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','international') }}"class="btn">Scholarship Details</a>
                      
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-search"></i></div>
                        <h3>Research Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','research') }}"class="btn">Scholarship Details</a>
                      
                    </div>
                </div>
                <div class="row justify-content-center text-center mt-4">
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                        <h3>Minority Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','minority') }}"class="btn">Scholarship Details</a>
                     
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                        <h3>BPL Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','bpl') }}"class="btn">Scholarship Details</a>
                    
                    </div>
                </div>
                <div class="col-md-3 col-sm-6">
                    <div class="category-card">
                        <div class="icon"><i class="fa fa-graduation-cap"></i></div>
                        <h3>All Scholarships</h3>
                        <a href=  "{{ url('/scholarship-details','all') }}"class="btn">Scholarship Details</a>
                    
                    </div>
                </div>
            </div>
        </div> 
    </main>
   
    @push('script')
    
    @endpush
 @endsection