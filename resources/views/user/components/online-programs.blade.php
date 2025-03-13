@extends('user.components.layout')
@php
$page_title = "online programs";
@endphp
@push('css')
<link rel="stylesheet" href="{{ url('/css/index.css') }}">
<link rel="stylesheet" href="{{ url('/css/info.css') }}">
<link rel="stylesheet" href="{{ url('/css/filter.css') }}">
@endpush
<style>
    @media screen and (max-width: 768px) {
        
        /* .b-between {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
            padding: 0;
            margin: 0;
        } */
        
    }
</style>
@section('main')
            @include('user.components.breadcrumbs.breadcrumb')
            <main>
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="filter-box">
                                <h5 class="p-2 bg-blue" style="cursor: default;">Filter</h5>                                                                                                                  {{-- <div class="between text-light p-2"> --}}
                                <ul class="filter">
                                    {{-- <h6 class="p-2 bg-blue " style="cursor: default;" data-filter="all">Filter By Graduation</h6> --}}
                                    <li>
                                        <a type="button" class="filter-btn active" style="cursor: default; background: var(--blue); color: #fff;" data-filter="all"> Filter By Graduation (All)</a>
                                    </li>  
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="PG">Post Graduation</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="UG">Under Graduation</a>
                                    </li>                                                                                                                  {{-- <h6>--}}
                                     <li>
                                        <a type="button" class="filter-btn" data-filter="Diploma">Diploma</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn active" style="cursor: default; background: var(--blue); color: #fff;" data-filter="all">Filter By Specialization (All)</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="Management">Management</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="Computer">Computer</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="Business">Business</a>
                                    </li>
                                    <li>
                                        <a type="button" class="filter-btn" data-filter="Commerce">Commerce</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            @php
    $onlineCourses = collect(Request::get('courses'))->filter(function ($course) {
        return $course['course_online'] == 1;
    });
    // dd($onlineCourses);
                            @endphp


                            @if($onlineCourses->isEmpty())
                                <p>No online courses available.</p>
                            @else
                                @foreach ($onlineCourses as $course)
                                    <article class="card on-card mb-2 filter-card" data-graduation="{{ $course['course_type'] }}" 
                                    data-specialization="{{ Str::slug($course['course_name']) }}">
                                        <div class="row">
                                            <a class="col-md-4" href="/{{ $course['metadata']['url_slug'] }}">
                                                <img class="img-fluid rounded-1" src="{{ asset('images/courses/course_images/' . $course['course_img']) }}" alt="{{ $course['course_name'] }}">
                                            </a>
                                            <div class="col-md-8">
                                                <div class="text-box">
                                                    <div class="between">
                                                        <div class="w-50">
                                                            <h6>
                                                                <a class="text-capitalize" href="/{{ $course['metadata']['url_slug'] }}">
                                                                    {{ $course['course_short_name'] }}
                                                                </a>
                                                            </h6>
                                                            {{ $course['course_name'] }}
                                                            {{-- <p>
                                                                <i class="fa-solid fa-location-dot"></i>
                                                                <span>{{ $course['university_location'] }}</span>,
                                                                <span class="country">{{ $course['university_country'] }}</span>
                                                            </p> --}}
                                                        </div>
                                                        <div class="flex">
                                                            <button class="btn btn-outline-secondary rounded-pill com-btn">
                                                                <small>Compare</small>
                                                                <i class="fa-regular fa-window-restore"></i>
                                                            </button>
                                                            <button class="btn btn-outline-secondary rounded-pill me-2">
                                                                <i class="fa-solid fa-bookmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="between b-between">
                                                        <div>
                                                            <div>
                                                                <p>Compare</p>
                                                                <h6>{{ count($course['universities']) }} universities</h6>
                                                            </div>
                                                        </div>
                                                        <div class="row p-2 pb-4 flex flex-column w-[170px]">
                                                            <div class="col-sm-12 col-6 mb-2 w-100">
                                                                <!-- <a href="#" class="btn btn-outline-danger rounded-pill w-100">
                                                                    <i class="fa-solid fa-download"></i>
                                                                    <small>Brochure</small>
                                                                </a> -->
                                                                <a class="btn btn-outline-danger rounded-pill w-100" style="border-bottom-left-radius: 20px;border-bottom-right-radius: 10px;" href="{{ route('download-pdf', ['filename' => 'prospectus_collegevihar.pdf']) }}">
                                                                    <span>Download</span>
                                                                    <i class="fa-solid fa-download fa-xs"></i>
                                                                </a>
                                                            </div>
                                                            <div class="col-sm-12 col-6 w-100">
                                                                <button class="btn btn-primary rounded-pill w-100">
                                                                    <small>Rate my chance</small>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </article>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </section>
        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>

        @push('script')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                const filterButtons = document.querySelectorAll('.filter-btn');
                const courses = document.querySelectorAll('.filter-card');

                filterButtons.forEach(button => {
                    button.addEventListener('click', () => {
                        const filterValue = button.dataset.filter;

                        // Remove active class from all buttons and add to current button
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        button.classList.add('active');

                        // Filter courses
                        courses.forEach(course => {
                            const graduationType = course.dataset.graduation.toLowerCase();
                            const specialization = course.dataset.specialization.toLowerCase();

                            if (
                                filterValue === 'all' || 
                                graduationType === filterValue.toLowerCase() || 
                                specialization.includes(filterValue.toLowerCase())
                            ) {
                                course.style.display = 'block';
                            } else {
                                course.style.display = 'none';
                            }
                        });
                    });
                });
            });
        </script>
        @endpush
@endsection