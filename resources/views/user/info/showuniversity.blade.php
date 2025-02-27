@php
    $page_title = 'University List';
    $current_state = Request::segment(2); // Assuming the state name is in the second segment of the URL
@endphp

@extends('user.info.layout')

@push('css')
    <link rel="stylesheet" href="{{ url('/css/index.css') }}">
    <link rel="stylesheet" href="{{ url('/css/online-programs.css') }}">
    <link rel="stylesheet" href="{{ url('/css/show-uni-list.css') }}">
@endpush

@section('main_section')
    <main>
        <section>
            <div class="container">
                <div class="row">
                    @php
                        $state_univ = Request::get('state_univ', []);
                        $matched_state = collect($state_univ)->firstWhere('state_name', $current_state);
                        $courses = $matched_state ? collect($matched_state['universities'])->pluck('courses.*.course_name')->flatten()->unique() : [];
                        $university_count = $matched_state ? count($matched_state['universities']) : 0;
                    @endphp

                    @if ($matched_state && $university_count > 0)
                            <aside class="col-md-3">
                                <div class="filter-box">
                                    <h5 class="p-2 bg-blue">Filter by Course</h5>
                                    <ul class="filter">
                                        <li>
                                            <a type="button" class="filter-btn active" data-filter="all">All Courses</a>
                                        </li>

                                        @foreach ($courses as $course)
                                            <li>
                                                <a type="button" class="filter-btn" data-filter="{{ $course }}">{{ $course }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </aside>

                            <div class="col-md-9">
                                <h3 class="blue">We have found {{ $university_count }} universities for you in
                                    {{ ucfirst($current_state) }} State
                                </h3>
                                {{-- @php dd($matched_state['universities']) ; @endphp --}}
                                @foreach ($matched_state['universities'] as $univ)
                                    <article class="card on-card mb-2 filter-card"
                                        data-courses="{{ implode(',', collect($univ['courses'])->pluck('course_name')->toArray()) }}">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <img class="img-fluid rounded-1"
                                                    src="{{ asset('images/university/campus/' . $univ['univ_image']) }}"
                                                    alt="{{ $univ['univ_name'] }}">
                                            </div>
                                            <div class="col-md-8">
                                                <div class="text-box">
                                                    <div class="between">
                                                        <div>
                                                            <h6>
                                                                <a class="blue" href="/{{ $univ['metadata']['url_slug'] }}">
                                                                    {{ $univ['univ_name'] }}
                                                                </a>
                                                            </h6>
                                                            <p>
                                                                <i class="fa-solid fa-location-dot"></i>
                                                                {{$univ['univ_address']}}
                                                            </p>
                                                        </div>
                                                        <div class="flex">
                                                            <button class="btn btn-outline-secondary rounded-pill com-btn">
                                                                <small>Compare</small>
                                                                <i class="fa-regular fa-window-restore"></i>
                                                            </button>
                                                            <button class="btn btn-outline-secondary rounded-pill">
                                                                <i class="fa-solid fa-bookmark"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="between">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <p>Courses Offered</p>
                                                                <h6>
                                                                    {{ count($univ['courses']) }} Courses
                                                                </h6>
                                                            </div>
                                                            <div class="col-6">
                                                                <p> Tuition Fees</p>
                                                                <h6>
                                                                    <i class="fa-solid fa-indian-rupee-sign"></i>
                                                                    Starts From
                                                                    {{  collect($univ['courses'])->pluck('pivot.univ_course_fee')->filter()->first() ?? 'N/A' }}
                                                                </h6>
                                                            </div>
                                                            <div class="col-6">
                                                                <p>Exams Accepted</p>
                                                                <h6>JEE, NEET, +2</h6>
                                                            </div>
                                                            <div class="col-6">
                                                                <p>Mode</p>
                                                                <h6>
                                                                    @if ($univ['univ_type'] === 'online')
                                                                        <i class="fa-solid fa-desktop fa-xs"></i> Online Class
                                                                    @else
                                                                        <i class="fa-solid fa-school fa-xs"></i> Offline Class
                                                                    @endif
                                                                </h6>
                                                            </div>
                                                        </div>
                                                        <div class="row p-2">
                                                            <div class="col-sm-12 col-6">
                                                                <a href="{{ route('download-pdf', ['filename' => 'prospectus_collegevihar.pdf']) }}"
                                                                    class="btn btn-outline-danger rounded-pill w-100">
                                                                    <i class="fa-solid fa-download"></i>
                                                                    <small>Brochure</small>
                                                                </a>
                                                            </div>
                                                            <div class="col-sm-12 col-6">
                                                                <a class="btn btn-primary rounded-pill w-100" href="#"
                                                                    data-bs-toggle="modal" data-bs-target="#applyModal">
                                                                    <small>Apply Now</small>
                                                                    <i class="fa-solid fa-up-right-from-square fa-xs"></i>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </article>
                                @endforeach
                            </div>
                        </div>
                    @else
                        <div class="col-md-12">
                            <p class="text-center">No universities found for this region/state.</p>
                        </div>
                    @endif

            </div>
            </div>
        </section>

    </main>

    @push('script')

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Get all filter buttons and university cards
                const filterButtons = document.querySelectorAll('.filter-btn');
                const universityCards = document.querySelectorAll('.filter-card');

                // Add event listener to all filter buttons
                filterButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        // Remove active class from all buttons
                        filterButtons.forEach(btn => btn.classList.remove('active'));

                        // Add active class to the clicked button
                        this.classList.add('active');

                        // Get the selected filter value
                        const filter = this.getAttribute('data-filter');

                        // Show/hide university cards based on the filter
                        universityCards.forEach(card => {
                            const courses = card.getAttribute('data-courses').split(',');

                            // Show all cards if "all" is selected
                            if (filter === 'all' || courses.includes(filter)) {
                                card.style.display = 'block';
                            } else {
                                card.style.display = 'none';
                            }
                        });
                    });
                });
            });
        </script>
    @endpush
@endsection