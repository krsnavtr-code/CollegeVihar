@extends('user.components.layout')
@push('css')
    <!-- <link rel="stylesheet" href="/css/slider.css"> -->
    <link rel="stylesheet" href="/css/university.css">
    <link rel="stylesheet" href="/css/index.css">
    <link rel="stylesheet" href="/css/card.css">
@endpush

<style>
    .feature-images {
        width: 50%;
        height: 300px;
        object-fit: cover;
        object-position: center;
    }

    .owl-carousel-font-size {
        font-size: 1.2rem !important;
    }

    /* .owl-carousel-font-size-h{
        font-size: 1.3rem !important;
    } */
</style>

@section('main')
        <main>
            <section id="gradient-color">
                <!-- banner -->
                <section id="banner">
                    <div class="container">
                        <div class="owl-carousel owl-theme">
                            <div class="item">
                                <div class="row align-items-center text-sm-start text-center">
                                    <div class="col-sm-8">
                                        <div class="text-box mt-4">
                                            <h5 class="display-7"> Start Your Preparation</h5> {{-- Let’s find the --}}
                                            <p class="display-6 owl-carousel-font-size">With Our Award Winning Guru's</p>
                                            {{-- <h2 class="display-5"></h2> --}}
                                            <a class="btn btn-light mt-3" title="Get Started Now" href="#callbackModal"
                                                data-bs-toggle="modal" data-bs-target="#callbackModal">
                                                Get Started Now
                                            </a>
                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center">
                                        <img src="https://collegevihar.com/images/slider/slide_1.webp" alt="" class="img-fluid"
                                            style="height: 11rem; width:9rem" />
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row align-items-center text-sm-start text-center">
                                    <div class="col-sm-8">
                                        <div class="text-box mt-4">
                                            <h5>World Top Most Universities</h5>
                                            <p class="display-5 owl-carousel-font-size">Your path to reputable degrees anytime
                                                from anywhere
                                                <a href="tel:+919266585858" class="btn btn-light mt-2"> call us:
                                                    +91 9266585858</a>
                                            </p>

                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center">
                                        <img src="https://collegevihar.com/images/slider/slide_2.webp" alt="" class="img-fluid"
                                            style="height: 11rem; width:9rem" />
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row align-items-center text-sm-start text-center">
                                    <div class="col-sm-8 mt-1">
                                        <h5 class="owl-carousel-font-size-h"> Get The Best Jobs Now Today Fast Quick</h5>
                                        </h5> {{-- Explore a world of knowledge --}}
                                        <p class="display-5 owl-carousel-font-size">From Leading MNCs Offering Exciting
                                            Opportunities</p>
                                        {{--you are one click away --}}
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center">
                                        <img src="https://collegevihar.com/images/slider/slide_3.webp" alt="" class="img-fluid"
                                            style="height: 11rem; width:9rem" />
                                    </div>
                                </div>
                            </div>
                            <div class="item">
                                <div class="row align-items-center text-sm-start text-center">
                                    <div class="col-sm-8 mt-4">
                                        <div class="text-box mt-1">
                                            <h5>Scholarship For</h5> {{--Allow our admission --}}
                                            <h2 class="display-5 owl-carousel-font-size"> Deserving Student</h2> {{--services to
                                            simplify--}}
                                            <p class="owl-carousel-font-size"> Get All Information Regarding Scholarship
                                                Programs At
                                                One Place</p> {{--your path
                                            to success--}}
                                        </div>
                                    </div>
                                    <div class="col-sm-4 d-flex justify-content-center mb-2">
                                        <img src="https://collegevihar.com/images/slider/slide_4.webp" alt=""
                                            style="height: 11rem; width:9rem;" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- banner end -->
                <!-- home cards -->
                {{-- <section class="mt-1 mb-2" id="home-cards">
                    <div class="container">
                        <div class="row justify-content-center g-3">
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="max-width: 70vw;">
                                <div class="card shadow-lg border-3 border-primary rounded-4 home-program-card"
                                    style="max-width: 300px;">
                                    <a href="{{ session('user_active') ? url('/job-openings') : url('/universal-login') }}">
                                        <img src="/images/home/job.png" alt="job" class="img-fluid w-100 shadow-lg"
                                            style="height: 17vh">
                                        <button class="btn btn-danger w-100"
                                            style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                                            Job Openings
                                        </button>
                                    </a>
                                </div>
                            </div>

                            <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="max-width: 70vw;">
                                <div class="card shadow-lg border-3 border-primary rounded-4 home-program-card"
                                    style="max-width: 300px;">
                                    <a href="/competitive-exam">
                                        <img src="/images/home/exam.png" alt="exam" class="img-fluid w-100 shadow-lg"
                                            style="height: 17vh">
                                        <button class="btn btn-danger w-100"
                                            style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                                            Competitive Exams
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3" style="max-width: 70vw;">
                                <div class="card shadow-lg border-3 border-primary rounded-4 home-program-card"
                                    style="max-width: 300px;">
                                    <a href="/scholarship">
                                        <img src="/images/home/scholarship.png" alt="scholarship"
                                            class="img-fluid w-100 shadow-lg" style="height: 17vh">
                                        <button class="btn btn-danger w-100"
                                            style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                                            Scholarship Exams
                                        </button>
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-4 col-lg-3 " style="max-width: 70vw;">
                                <div class="card shadow-lg border-3 border-primary rounded-4 home-program-card"
                                    style="max-width: 300px;">
                                    <a data-bs-toggle="modal" data-bs-target="#callbackModal">
                                        <img src="/images/home/call.png" alt="call" class="img-fluid w-100 shadow-lg"
                                            style="height: 17vh">
                                        <button class="btn btn-danger w-100" data-bs-toggle="modal"
                                            data-bs-target="#callbackModal"
                                            style="border-bottom-left-radius: 12px; border-bottom-right-radius: 12px;">
                                            Request a Callback
                                        </button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </section> --}}

                <!-- home cards Ner -->
                <section>
                    <div class="container py-1">
                        <div class="row g-4">
                            <div class="col-6 col-sm-6 col-lg-3">
                                <div class="card text-center p-1 shadow" id="card-gradient-color">
                                    <img src="/images/home/job.png" class="card-img-top mx-auto" alt="job">
                                    <div class="card-body p-0">
                                        <div class="card-body-content">
                                            Browse through various job openings and take the next step in your career.
                                        </div>
                                        <a href="{{ session('user_active') ? url('/job-openings') : url('/universal-login') }}">
                                            <button class="btn btn-light p-0 w-100" style="border-radius: 9px;">
                                                Job Openings
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-lg-3">
                                <div class="card text-center p-1 shadow" id="card-gradient-color">
                                    <img src="/images/home/exam.png" class="card-img-top mx-auto" alt="exam">
                                    <div class="card-body p-0">
                                        <div class="card-body-content">
                                            Prepare for top competitive exams with resources to boost your success.
                                        </div>
                                        <a href="/competitive-exam">
                                            <button class="btn btn-light p-0 w-100" style="border-radius: 9px;">
                                                Competitive Exams
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-lg-3">
                                <div class="card text-center p-1 shadow" id="card-gradient-color">
                                    <img src="/images/home/scholarship.png" class="card-img-top mx-auto" alt="scholarship">
                                    <div class="card-body p-0">
                                        <div class="card-body-content">
                                            Unlock scholarship opportunities and get financial aid for your education.
                                        </div>
                                        <a href="/scholarship">
                                            <button class="btn btn-light p-0 w-100" style="border-radius: 9px;">
                                                Scholarship Exams
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-sm-6 col-lg-3">
                                <div class="card text-center p-1 shadow" id="card-gradient-color">
                                    <img src="/images/home/call.png" class="card-img-top mx-auto" alt="Call">
                                    <div class="card-body p-0">
                                        <div class="card-body-content">
                                            Have questions? Request a callback and our team will connect with you soon!
                                        </div>
                                        <a data-bs-toggle="modal" data-bs-target="#callbackModal">
                                            <button class="btn btn-light p-0 w-100" data-bs-toggle="modal"
                                                data-bs-target="#callbackModal" style="border-radius: 9px;">
                                                Request a Callback
                                            </button>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>

                <!-- home cards end -->

                <!-- recommend -->
                <section class=" py-4">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-sm-8 p-2">
                                <h5>Let’s find the</h5>
                                <h2 class="display-5">best university/course</h2>
                                <h5>for your career</h5>

                            </div>
                            <div class="col-sm-4 p-2">
                                <a class="btn btn-light" title="get recommendation" href="#queryModal" data-bs-toggle="modal"
                                    data-bs-target="#queryModal">
                                    Get Recommendation
                                </a>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- recommend end-->
                {{-- <section class=" p-2" id="counter">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-4 p-2">
                                <article class="text-center">
                                    <h2 class="center">
                                        <strong class="count display-4" initial-count="35"></strong>
                                        <strong class="display-4"> ,000 </strong>
                                        <i class="fa-solid fa-plus"></i>
                                    </h2>
                                    <h5>Trusted Students</h5>
                                </article>
                            </div>
                            <div class="col-sm-4 p-2">
                                <article class="text-center">
                                    <h2 class="center">
                                        <strong class="count display-4" initial-count="90"></strong>
                                        <i class="fa-solid fa-percentage"></i>
                                    </h2>
                                    <h5>Career Hike</h5>
                                </article>
                            </div>
                            <div class="col-sm-4 p-2">
                                <article class="text-center">
                                    <h2 class="center">
                                        <strong class="count display-4" initial-count="80+"></strong>
                                        <i class="fa-solid fa-plus"></i>
                                    </h2>
                                    <h5>Expert Guidance</h5>
                                </article>
                            </div>
                        </div>
                    </div>
                </section> --}}
            </section>
            <!-- recommend end-->


            <!-- Universities -->
            <section class="py-2" id="universities">
                <p class="university-text">Our best 100 University and 500 Courses</p>
                <div class="container mt-3">
                    @php
    $tabs = ['PG', 'UG', 'Diploma', 'Certification', 'online', 'offline', 'International Online', 'International Offline'];
    $courses = Request::get('courses');
    $universitiesfil = Request::get('universities');

    $courseCounts = [];
    $universityCounts = [];
    foreach ($tabs as $tab) {
        if (in_array($tab, ['online', 'offline'])) {
            // For 'online' and 'offline', filter universities
            $filteredUniversities = array_filter($universitiesfil, function ($university) use ($tab) {
                return strtolower($university['univ_type']) === strtolower($tab);
            });
            $universityCounts[$tab] = count($filteredUniversities);
            $courseCounts[$tab] = count($filteredUniversities) > 0 ? 1 : 0; // Just to indicate that there are courses
        } else {
            // For other tabs, filter courses based on 'course_type'
            $filteredCourses = array_filter($courses, function ($course) use ($tab) {
                return strtolower($course['course_type']) === strtolower($tab);
            });

            $courseCounts[$tab] = count($filteredCourses);

            // Calculate the total number of universities
            $totalUniversities = 0;
            foreach ($filteredCourses as $course) {
                $totalUniversities += count($course['universities']);
            }
            $universityCounts[$tab] = $totalUniversities;
        }

        // // Only include tabs with non-zero data

    }
                    @endphp
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="filter-box mx-auto" style="max-width: 300px;">
                                <h5 class="p-2 bg-blue">Filter by Course</h5>
                                <ul class="nav flex-column nav-tabs filter" id="nav-tab" role="tablist"
                                    aria-orientation="vertical">
                                    <li>
                                        <a class="filter-btn active" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Top 50+ courses</a>
                                    </li>
                                    @foreach ($tabs as $tab)
                                        <li>
                                            <a class="filter-btn" id="nav-{{ $tab }}-tab" data-bs-toggle="tab"
                                                data-bs-target="#nav-{{ $tab }}" type="button" role="tab"
                                                aria-controls="nav-{{ $tab }}" aria-selected="false"
                                                style="color: #0056d2">{{ ucfirst($tab) }} Courses
                                                <div>
                                                    @if ($courseCounts[$tab] > 0 || $universityCounts[$tab] > 0)
                                                        <div class="ms-3">
                                                            @if (in_array($tab, ['online', 'offline']))
                                                                {{ $universityCounts[$tab] }} Universities
                                                            @else
                                                                {{ $courseCounts[$tab] }} Courses, {{ $universityCounts[$tab] }}
                                                                Universities
                                                            @endif
                                                        </div>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-9 p-2">
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                    aria-labelledby="nav-home-tab" tabindex="0">
                                    <div class="row">
                                        @php
    // dd(Request::get('courses')); 
    // dd($universities);
                                        @endphp

                                        @foreach ($universities as $university)
                                                                        @php
        $course = $university->univCourses->first();
        // dd($course);
                                                                        @endphp
                                                                        @if ($course && $course->univ_course_detail_added == 1)
                                                                                                    <div class="col-lg-4 col-sm-6 p-2">
                                                                                                        <article class="card filter-card h-100 mx-auto"
                                                                                                            style="max-width: 300px; border-radius: 26px; border: 5px solid #4166ab; box-shadow: 9px 9px 0px #3b64b1;">
                                                                                                            <div class="img-box" style="z-index: 1">
                                                                                                                <a href="{{ $course->metadata->url_slug }}">
                                                                                                                    <img class="img-fluid uni-img"
                                                                                                                        style="border-top-left-radius: 20px; border-top-right-radius: 18px;"
                                                                                                                        src="/images/university/campus/{{ $university->univ_image }}"
                                                                                                                        alt="{{ $university->univ_name }}"
                                                                                                                        onerror="this.src='/images/web assets/university.png'"
                                                                                                                        loading="lazy">
                                                                                                                    <img class="uni-badge rounded-1"
                                                                                                                        src="/images/university/logo/{{ $university->univ_logo}}"
                                                                                                                        height="30" />
                                                                                                                </a>
                                                                                                            </div>
                                                                                                            <div class="text-box"
                                                                                                                style="background-color: #edefef1c;border-bottom-left-radius: 16px;border-bottom-right-radius: 16px; z-index: 1">
                                                                                                                <h5 class="name blue" style="font-weight: 600;">
                                                                                                                    <a href="{{ $course->metadata->url_slug }}" style="color: black;">
                                                                                                                        {{ $university->univ_name }}

                                                                                                                    </a>
                                                                                                                </h5>
                                                                                                                <h6 class="course">
                                                                                                                    <i class="fa-solid fa-graduation-cap"></i>
                                                                                                                    <span
                                                                                                                        style="font-size:medium; font-weight: 500;">{{ $course['course']['course_name'] }}</span>
                                                                                                                </h6>
                                                                                                                <p class="p-1">
                                                                                                                    <i class="fa-regular fa-calendar-days fa-xs"></i>
                                                                                                                    <span style=" font-weight: 500; font-size: small;"> Duration:
                                                                                                                        @php 
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                            // dd($course->uc_details);
            $ucdetails = json_decode($course->uc_details);
            // dd($ucdetails);
            if (strtolower($ucdetails[4]->title) == 'duration') {
                echo $ucdetails[4]->desc;
            } 

                                                                                                                        @endphp
                                                                                                                    </span>
                                                                                                                    {{-- @php dd($course);@endphp --}}

                                                                                                                </p>
                                                                                                                <p class="p-1" style="font-weight: 500; font-size: small;">
                                                                                                                    {!! $course['course']['course_online']
                ? " <i class='fa-solid fa-desktop fa-xs'></i> Online Class"
                : " <i class='fa-solid fa-school fa-xs'></i> Offline Class" !!}
                                                                                                                </p>
                                                                                                                <div class="between flex-md-row flex-column gap-2">
                                                                                                                    <a class="btn btn-danger bg-red"
                                                                                                                        style="border-bottom-left-radius: 20px;border-bottom-right-radius: 10px;"
                                                                                                                        href="{{ route('download-pdf', ['filename' => 'prospectus_collegevihar.pdf']) }}">
                                                                                                                        <span>Download</span>
                                                                                                                        <i class="fa-solid fa-download fa-xs"></i>
                                                                                                                    </a>
                                                                                                                    <a class="btn btn-primary"
                                                                                                                        style="border-bottom-left-radius: 10px;border-bottom-right-radius: 20px;"
                                                                                                                        href="#" data-bs-toggle="modal" data-bs-target="#applyModal"
                                                                                                                        style="border-bottom-left-radius: 10px;border-bottom-right-radius: 20px;">
                                                                                                                        <span>Apply Now</span>
                                                                                                                        <i class="fa-solid fa-up-right-from-square fa-xs"></i>
                                                                                                                    </a>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </article>
                                                                                                    </div>
                                                                        @endif
                                        @endforeach
                                    </div>
                                </div>
                                @foreach ($tabs as $tab)
                                    <div class="tab-pane fade courses" id="nav-{{ $tab }}" role="tabpanel"
                                        aria-labelledby="nav-{{ $tab }}-tab" tabindex="0">
                                        <div class="row">
                                            @foreach (Request::get('courses') as $course)
                                                @if ($course['course_type'] == $tab)
                                                    <div class="col-lg-3 p-2 text-center">
                                                        <a class="card h-100 p-2" href="/{{ $course['metadata']['url_slug'] }}">
                                                            {{-- <img src="{{ $course['course_img'] }}" alt="" class="m-auto" width="80"
                                                                height="60"> --}}
                                                            <img src="{{ File::exists(public_path('images/courses/course_images/' . $course['course_img'])) ? asset('images/courses/course_images/' . $course['course_img']) : $course['course_img'] }}"
                                                                alt="{{ $course['course_name'] }}" class="m-auto"
                                                                style="height:100px ; width: 215px;">
                                                            <p class="blue">{{ $course['course_name'] }}</p>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                        <div class="row">
                                            @foreach (Request::get('universities') as $university)
                                                @if ($university['univ_type'] == $tab)
                                                    <div class="col-lg-3 p-2 text-center">
                                                        <a class="card h-100 p-1" href="/{{ $university['metadata']['url_slug'] }}">
                                                            <img src="/images/university/logo/{{ $university['univ_logo'] }}" alt=""
                                                                class="m-auto" onerror="this.src='/images/web assets/university.png'"
                                                                width="80%" height="60">
                                                            <p class="blue">{{ $university['univ_name'] }}</p>
                                                        </a>
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- counter -->
            <div class="container mt-5 mb-5">
                <div class="row">
                    <div class="col-12">
                        <div class="card-diff">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-4 mb-3">
                                        <article class="text-center">
                                            <h2 class="center card-title">
                                                <strong class="count display-4" initial-count="35"></strong>
                                                <strong class="display-4"> ,000 </strong>
                                                <i class="fa-solid fa-plus"></i>
                                            </h2>
                                            <h5 class="mt-3">Trusted Students</h5>
                                        </article>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <article class="text-center">
                                            <h2 class="center card-title">
                                                <strong class="count display-4" initial-count="90"></strong>
                                                <i class="fa-solid fa-percentage"></i>
                                            </h2>
                                            <h5 class="mt-3">Career Hike</h5>
                                        </article>
                                    </div>
                                    <div class="col-md-4 mb-3">
                                        <article class="text-center">
                                            <h2 class="center card-title">
                                                <strong class="count display-4" initial-count="80+"></strong>
                                                <i class="fa-solid fa-plus"></i>
                                            </h2>
                                            <h5 class="mt-3">Expert Guidance</h5>
                                        </article>
                                    </div>
                                </div>
                            </div>
                            <div class="line1"></div>
                            <div class="line2"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- counter end -->

            <!-- why us -->
            <section class="py-4">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-8 p-2">
                            <h5 class="display-6">
                                <span>Why</span>
                                <span class="blue">College</span>
                                <span class="red">Vihar</span>
                                <span>?</span>
                            </h5>
                            <p>Collegevihar is an online learning platform that makes it simple for students to get enrolled
                                in
                                top
                                colleges, based on their location or financial situation. Collegevihar assists students in
                                achieving
                                their academic objectives and creating a better future by providing flexible learning
                                options,
                                personalized support, and low tuition.</p>
                        </div>
                        <div class="col-sm-4 p-2">
                            <img class="img-fluid" src="/images/web assets/why-us.png" alt="why">
                        </div>
                    </div>
                </div>
            </section>
            <!-- why us end-->
            <!-- Our Approach -->
            <section class="bg-blue py-4">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-6 p-2">
                            <h5 class="display-6">
                                Our Approach to a Comprehensive Admission Process.
                            </h5>
                            <p>Receive assistance for finding what you need, making a list of options,
                                applying, getting ready, securing admission and meeting placement needs.</p>
                            <a class="btn btn-light mt-3" title="Get Started Now" href="#callbackModal" data-bs-toggle="modal"
                                data-bs-target="#callbackModal">
                                Get Started Now
                            </a>
                        </div>
                        <div class="col-sm-6 p-2">
                            <div class="accordion">
                                @php
    $steps = [['step_title' => 'Explore Programs', 'step_desc' => 'Browse our diverse range of programs like MBA, BBA, MA, B.COM, Machine Learning, Python and many more...'], ['step_title' => 'Fill Application', 'step_desc' => 'Fill online application form with accurate.'], ['step_title' => 'Get Expert Help', 'step_desc' => "You get your own education mentor who helps with all your questions about courses, university, colleges and fees. They're there to make things clear and easy for you."], ['step_title' => 'Upload Documents', 'step_desc' => 'Make your college application faster by sending your documents and paying the registeration fees.'], ['step_title' => 'Confirm Admission', 'step_desc' => 'Upon acceptance, pay fees to secure your seat and finalize enrollment'], ['step_title' => 'Start Class & Claim Gift', 'step_desc' => 'Confirm your class date, seat, enrollment number and get your gift as reward points']];
                                @endphp
                                @for ($i = 0; $i < count($steps); $i++)
                                    <article class="accordion-item">
                                        <h2 class="accordion-header">
                                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                data-bs-target="#panel{{ $i + 1 }}" aria-expanded="true"
                                                aria-controls="panel{{ $i + 1 }}">
                                                <span>Step {{ $i + 1 }} : </span>
                                                <span class="ms-1">{{ $steps[$i]['step_title'] }}</span>
                                            </button>
                                        </h2>
                                        <div id="panel{{ $i + 1 }}" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <p class="step_desc">{{ $steps[$i]['step_desc'] }}</p>
                                            </div>
                                        </div>
                                    </article>
                                @endfor
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Our Approach end-->
            <!-- Contact Us -->
            <section class="bg-light py-4">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-sm-6 p-2">
                            <h5 class="display-6">
                                Contact us now!
                            </h5>
                            <p class="mb-2">Explore our programs, partner universities, and tuition rates with ease. Let us
                                help
                                you reach your academic goals!</p>
                            <div class="">
                                <a href="tel:+919266585858">
                                    <i class="fa-solid fa-phone"></i>
                                    <span>+91 9266585858</span>
                                </a>
                                <span>or</span>
                                <a href="mailto:info@collegevihar.com">
                                    <i class="fa-solid fa-envelope"></i>
                                    <span>info@collegevihar.com</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-sm-6 p-2">
                            <form action="" class="card row gap-2 py-3 m-sm-0 m-1">
                                <div class="flex">
                                    <i class="fa-solid fa-user"></i>
                                    <input type="text" name="name" class="form-control validate" value="{{ old('name') }}"
                                        placeholder="Enter Your Full Name " required>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-envelope"></i>
                                    <input type="text" name="email" class="form-control validate" value="{{ old('email') }}"
                                        placeholder="Enter Your email Address" required>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-phone"></i>
                                    <input type="text" name="phone" class="form-control validate" value="{{ old('phone') }}"
                                        placeholder="Enter Your Phone number " required>
                                </div>
                                <div class="flex">
                                    <i class="fa-solid fa-pencil-alt"></i>
                                    <textarea name="message" class="form-control validate"
                                        placeholder="Enter Your Message"></textarea>
                                </div>
                                <div class="flex justify-content-end">
                                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Submit <i
                                            class="fa fa-paper-plane"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Contact end-->
        </main>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
        <script src="{{ asset('js/main.js') }}"></script>
@endsection