@extends('user.components.layout')
@php
$page_title = $course['university']['univ_name'] . ' - '.$course['course']['course_name'];
@endphp
@push('css')
<link rel="stylesheet" href="{{ url('/css/course_page.css') }}">
@endpush
@section('main')
<main>
    @include('user.components.breadcrumbs.course-breadcrumb')
    <section class="text-center p-2">
        <div class="container card py-4 bg-blue">
            <div class="row">
                {{-- <div class="col-4">
                    <article>
                        <h4>Duration</h4>
                        <h5>{{ $course['course']['course_duration'] }}</h5>
                    </article>
                </div> --}}
                <div class="col-4">
                    <article>
                        <h4>Duration</h4>
                        @foreach (json_decode($course['uc_details'], true) as $detail)
                            @if (strtolower($detail['title']) == 'duration')
                                <h5>{{ $detail['desc'] }}</h5>
                            @endif
                        @endforeach
                    </article>
                </div>
                <div class="col-4">
                    <article class="border-start border-end">
                        <h4>Fees</h4>
                        <h5>{{ $course['univ_course_fee'] }}</h5>
                    </article>
                </div>
                {{-- <div class="col-4">
                    <article>
                        <h4>Eligibility</h4>
                        <h5>{{ $course['course']['course_eligibility_short'] }}</h5>
                    </article>
                </div> --}}

                <div class="col-4">
                    <article>
                        <h4>Eligibility</h4>
                        @foreach (json_decode($course['uc_details'], true) as $detail)
                            @if (strtolower($detail['title']) == 'eligibilty')
                                <h5>{{ $detail['desc'] }}</h5>
                            @endif
                        @endforeach
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="text-transform: none;">
        <h4>{{ $page_title }}</h4>
        @foreach (json_decode($course['uc_about']) as $intro)
        <p>{{ $intro }}</p>
        @endforeach
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Overview</h4>
        <ul>
            @foreach (json_decode($course['uc_overview']) as $li)
            <li>{{ $li }}</li>
            @endforeach
        </ul>
    </section>
    <section class="container highlights " style="text-transform: none;">
        <h4>Course Highlights</h4>
        <p class="p-2">The course's primary highlights cover a variety of academic and professional
            advantages, ensuring that aspiring students have a well-rounded and enriching educational experience.</p>
        <div class="row">
            @php
            $img = ['cv.png', 'accreditation.png', 'network.png', 'career-path.png', 'directions.png', 'data-analytics.png', 'training.png', 'development.png'];
            @endphp
            @foreach (json_decode($course['uc_highlight']) as $i => $highlight)
            <div class="col-lg-3 col-md-4 col-6 p-2">
                <figure class="card text-center h-100">
                    <img src="/univ_course_img/{{ $img[$i%count($img)] }}" alt="course_highlight" class="img-fluid m-auto" width="100">
                    <h6 class="blue">{{ $highlight }}</h6>
                </figure>
            </div>
            @endforeach
        </div>
    </section>
    <section class="container" style="text-transform: none;">
        <article>
            <h4>Simplified Approach to Complete Admission Process</h4>
            <p>There is an online admissions process available at Online {{ $course['course_name'] }}, therefore there is
                no need to physically visit the campus to apply for admission. There is no entrance exam required to apply for
                admission to {{ $course['course_name'] }} Online because admissions are made directly. The following
                describes the {{ $course['course_name'] }}'s admissions process for online courses:</p>
            <a class="btn btn-primary my-2" title="get recommendation" href="#queryModal" data-bs-toggle="modal" data-bs-target="#queryModal">
                Ask Admission Query
            </a>
        </article>
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Details</h4>
        <p>This concise course overview includes key features and essential details, offering a comprehensive understanding of the program's offerings.</p>
        <table class="table table-striped text-capitalize bordered">
            <thead class="table-primary">
                <tr class="blue">
                    <th scope="col">Parameters</th>
                    <th scope="col">Details</th>
                </tr>
            </thead>
            <tbody>
                @foreach (json_decode($course['uc_details'], true) as $detail)
                <tr>
                    <td>{{ $detail['title'] }}</td>
                    <td>{{ $detail['desc'] }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th scope="col">course Fee</th>
                    <td>{{ number_format($course['univ_course_fee']) }}</td>
                </tr>
            </tfoot>
        </table>
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Syllabus</h4>
        <p>A comprehensive breakdown of the course-related syllabus, encompassing subjects
            organized by year or semester, is available for your detailed perusal.</p>
        <div class="row subject_groups">
            @foreach (json_decode($course['uc_subjects'], true) as $subject_group)
            <div class="col-lg-4 col-sm-6">
                <article class="">
                    <h5 class="blue">{{ $subject_group['title'] }}</h5>
                    <h6>Total {{ count($subject_group['subjects']) }} Subjects to study</h6>
                    <ul>
                        @foreach ($subject_group['subjects'] as $li)
                        <li>{{$li}}</li>
                        @endforeach
                    </ul>
                </article>
            </div>
            @endforeach
        </div>
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Assignments</h4>
        <p>The course entails a series of assignments designed to foster skill development,
            critical thinking, and practical application of the subject matter.</p>
        <div class="row">
            @php
            $img = ['operations & supply chain.png', 'geopolitics.png', 'organizational behavior.png', 'supply chain management.png', 'inventory management.png'];
            @endphp
            @foreach (json_decode($course['uc_assign']) as $i => $assign)
            <div class="col-lg-3 col-md-4 col-6 p-2">
                <figure class="card text-center h-100">
                    <img src="/univ_course_img/{{ $img[$i%count($img)] }}" alt="course_assign" class="img-fluid m-auto" width="100">
                    <h6 class="blue">{{ $assign }}</h6>
                </figure>
            </div>
            @endforeach
        </div>
    </section>

    <section class="container" >
        <h4>How Collegevihar helps you ?</h4>
        @foreach (json_decode($course['uc_cv_help']) as $intro)
        <p style="text-transform: none;">{{ $intro }}</p>
        @endforeach
    </section>
    <section class="container" >
        <h4>Collaboration to succeed</h4>
        @foreach (json_decode($course['uc_collab']) as $intro)
        <p style="text-transform: none;">{{ $intro }}</p>
        @endforeach
    </section>
    <section class="container">
        <h4>Grouping with experts</h4>
        @foreach (json_decode($course['uc_expert']) as $intro)
        <p style="text-transform: none;">{{ $intro }}</p>
        @endforeach
    </section>
    <section class="container" style="text-transform: none;">
        <div class="content">
            <article>
                <h6>START LEARNING</h6>
                <p>Obtain new, employable skills. Get individualized mentoring from our experts. Obtain a Certificate of
                    Completion with Collegevihar eLearning.</p>
            </article>
            <article>
                <h6>Career Impact</h6>
                <p>Our specialized courses in engineering and project management, which were especially designed to hasten
                    your professional career advancement, are one of Collegevihar's distinctive qualities.</p>
            </article>
            <article>
                <h6>High-performance coaching</h6>
                <p>Our objectives are to ensure student achievement and sustain the highest standards of instruction.
                    Through cooperative teamwork and reciprocal assistance, we hope to align our efforts with the goals and careers of the students.</p>
            </article>
            <article>
                <h6>Career Mentorship Sessions</h6>
                <p>We collaborate with professionals at the top of their fields, sharing their incredible knowledge with our
                    students. Our interest is in collaborating with specialists.</p>
            </article>
            <article>
                <h6>Interview Preparation</h6>
                <p>Working together, we impart to our students the invaluable knowledge of industry specialists. Our
                    steadfast goal is to collaborate with experts.</p>
            </article>
            <article>

            </article>
    </section>


    <section class="container" style="text-transform: none;">
        <h4>{{ $course['university']['univ_name'] }} <span>Admission Process</span></h4>
        <p>There is an online admissions process available at {{ $course['university']['univ_name'] }}, therefore there
            is no need to physically visit the campus to apply for admission. There is no entrance exam required to apply
            for admission to {{ $course['university']['univ_name'] }} Online because admissions are made directly. The
            following describes the {{ $course['university']['univ_name'] }}'s admissions process for online courses:</p>

        <div class="row">
            <div class="col-lg-4 p-2">
                <article class="card p-2 h-100">
                    <h6>Application Submission</h6>
                    <p>Prospective candidates should begin by completing the online application form. Once filled out,
                        the form should be submitted for approval.</p>
                </article>
            </div>
            <div class="col-lg-4 p-2">
                <article class="card p-2 h-100">
                    <h6>Document Submission</h6>
                    <p>After being selected by our faculty team, candidates will be asked to submit the following
                        documents:
                    </p>
                    <ul>
                        <li>Photocopies of attested mark sheets Two recent passport-sized photographs.</li>
                        <li>Please refer to the course details list for specific document requirements.</li>
                    </ul>
                </article>
            </div>
            <div class="col-lg-4 p-2">
                <article class="card p-2 h-100">
                    <h6>Seat Reservation through Fee Payment</h6>
                    <p>Upon successful submission and approval of your application form and required documents, you will
                        receive detailed instructions via email regarding the fee payment process. You can then proceed
                        to secure your seat by paying the fees using one of the following methods:</p>
                </article>
            </div>
        </div>
    </section>
</main>
@endsection