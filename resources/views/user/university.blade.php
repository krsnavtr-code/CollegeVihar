@extends('user.components.layout')
@php
$page_title = $university['univ_name'];
$univ_img = $university['univ_image'];

$desc = json_decode($university['univ_description']);
$facts = json_decode($university['univ_facts']);
$advantage = json_decode($university['univ_advantage'], true);
$industry = json_decode($university['univ_industry'], true);
@endphp
@push('css')
<link rel="stylesheet" href="/css/university-page.css">
<style>
    h2 {
        color: var(--blue);
        font-size: 1.7rem;
    }

    img {
        max-height: 200px;
    }
</style>
@endpush
@section('main')
<main>
@include('user.components.breadcrumbs.uni-breadcrumb')
    <section id="university">
        <div class="container">
            <div class="row">
                <article class="p-2">
                    <h2>About {{ $university['univ_name'] }}</h2>
                    @foreach ($desc as $p)
                    <p class="p-2">{{ $p }}</p>
                    @endforeach
                </article>
                <article class="p-2">
                    <h2>{{ $university['univ_name'] }} Facts</h2>
                    <ul>
                        @foreach ($facts as $li)
                        <li>{{$li}}</li>
                        @endforeach
                    </ul>
                </article>
                <article>
                    <h2>{{ $university['univ_name'] }} Advantages</h2>
                    <div class="row">
                        @foreach ($advantage['data'] as $d)
                        <div class="col-md-4 col-6 p-2">
                            <article class="card p-2 h-100">
                                <img class="img-fluid" src="/images/icon_png/{{ $d['logo'] }}" alt="{{$d['title']}}" height="200">
                                <h5 class="blue">{{ $d['title'] }}</h5>
                                <p>{{ $d['description'] }}</p>
                            </article>
                        </div>
                        @endforeach
                    </div>
                </article>
                <article class="p-2">
                    <h2>Available Courses</h2>
                    @foreach ($university['courses'] as $course)
                    @php
                    $metadata = DB::table('universitycourses')
                    ->where('course_id', $course['id'])
                    ->where('university_id', $university['id'])
                    ->first();

                    $url = $metadata->univ_course_slug ?? ''; // Use null coalescing operator to handle null value
                    $metadata2 = DB::table('metadata')->where('id', $url)->first();
                    $url2 = $metadata2->url_slug ?? '';
                    @endphp
                    <a class="btn btn-outline-primary m-1" title="{{ $course['course_name'] }}" href="/{{ $url2 }}" target="blank">{{ $course['course_short_name'] }}</a>
                    @endforeach
                </article>
                <article class="p-2">
                    <h2 class="blue">Boost Your Future</h2>
                    <p>Embark on Your Path to Success: Seize the Golden Opportunity Awaiting You! Take a Moment to Fill Out
                        Our Thorough Query Form, and You'll Be Initiating the First Thrilling Steps Towards a Brilliant
                        Future Filled with Remarkable Achievements and Lifelong Growth.</p>

                </article>
            </div>
        </div>
    </section>
    <section class="py-2">
        <div class="container">
            <div class="row">
                <div class="col-md-6 p-2">
                    <article>
                        <h2>Admission Process</h2>
                        <p>There is an online admissions process available at Online {{ $university['univ_name'] }}, therefore there is
                            no need to physically visit the campus to apply for admission. There is no entrance exam required to apply for
                            admission to {{ $university['univ_name'] }} Online because admissions are made directly. The following
                            describes the {{ $university['univ_name'] }}'s admissions process for online courses:</p>
                        <a class="btn btn-primary my-2" title="get recommendation" href="#queryModal" data-bs-toggle="modal" data-bs-target="#queryModal">
                            Ask Admission Query
                        </a>
                    </article>
                </div>
                <div class="col-md-6 p-2">
                    <div class="accordion">
                        @php
                        $steps = [['step_title' => 'Explore Programs', 'step_desc' => 'Browse our diverse range of programs like MBA, BBA, MA, B.COM, Machine Learning, Python and many more...'], ['step_title' => 'Fill Application', 'step_desc' => 'Fill online application form with accurate.'], ['step_title' => 'Get Expert Help', 'step_desc' => "You get your own education mentor who helps with all your questions about courses, university, colleges and fees. They're there to make things clear and easy for you."], ['step_title' => 'Upload Documents', 'step_desc' => 'Make your college application faster by sending your documents and paying the registeration fees.'], ['step_title' => 'Confirm Admission', 'step_desc' => 'Upon acceptance, pay fees to secure your seat and finalize enrollment'], ['step_title' => 'Start Class & Claim Gift', 'step_desc' => 'Confirm your class date, seat, enrollment number and get your gift as reward points']];
                        @endphp
                        @for ($i = 0; $i < count($steps); $i++)
                            <article class="accordion-item">
                            <h2 class="accordion-header">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panel{{ $i + 1 }}" aria-expanded="true" aria-controls="panel{{ $i + 1 }}">
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
    <section class="examination p-2">
        <div class="container">
            <div class="row">
                <h2 class="section_title"><span>{{ $university['univ_name'] }} Examination Pattern</span></h2>
                <p>With simply a laptop or desktop computer and a strong internet connection, you can take tests whenever and
                    wherever it suits you.</p>
                @php
                $patterns = [['title' => 'Exam Schedule', 'desc' => 'Exam schedule alerts will be sent to students through email or SMS in advance.', 'color' => '#6e5cbc'], ['title' => 'Slot Booking', 'desc' => 'Through the LMS, learners can reserve their preferred exam time slots.', 'color' => '#02233a'], ['title' => 'E-Hall Tickets', 'desc' => 'One week prior to the exam, hall tickets will be accessible for download through the LMS.', 'color' => '#f58e16'], ['title' => 'Exam', 'desc' => 'Using a secure browser from the comfort of your home, take examinations that are proctored online.', 'color' => '#1a697e'], ['title' => 'Evaluation & Results', 'desc' => 'Results will be announced and shared with students shortly following evaluation.', 'color' => '#2fb3b7']];
                @endphp
                @foreach ($patterns as $i => $pattern)
                <div class="col-md-4 col-6 p-2">
                    <div class="card bg-light text-center h-100 p-2 rounded-1 bordered border-2 border-primary m-2">
                        <h5 class="count rounded-circle bg-blue position-absolute start-0 top-0 center" style="width: 40px; height: 40px; transform: translate(-50%, 50%);">{{ $i + 1 }}</h5>
                        <h6 class="blue">{{ $pattern['title'] }}</h6>
                        <p class="text-secondary">{{ $pattern['desc'] }}</p>
                        <span class="bottom-line"></span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    <section class="Programs p-2">
        <div class="container">
            <div class="row">
                <h2>Industry-Ready Programs for Enhanced Career Readiness</h2>
                <ul class="list-unstyled row">
                    @foreach (['Communication', 'Self-development & Confidence building', 'Critical thinking & Problem solving', 'Leadership', 'Professionalism', 'Teamwork & Collaboration', 'Cultural fluency', 'Technology'] as $i => $li)
                    <li class="p-2 col-6">
                        <span class="blue">#</span>{{ $li }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section class="Programs p-2">
        <div class="container">
            <div class="row">
                <h2>Expert Career Guidance and Placement Services</h2>
                <p>Our goal is to increase the employability quotient of students who are eager to pursue careers after
                    completing their programs. We maintain a wide network with the top businesses in India, including both
                    well-established and start-up businesses, to assist our students. Our goal is to match alumni of our
                    programs with employers seeking the right talent and the right set of employment possibilities that
                    coincide with their career goals.</p>
                <ul class="list-unstyled row">
                    @foreach (['Career Counseling', 'Resume Building', 'Interview Preparation', 'Skill Development', 'Networking Opportunities', 'Industry Insights', 'Job Placement Services', 'Soft Skills Training'] as $li)
                    <li class="p-2 col-6">
                        <span class="blue">#</span>{{ $li }}
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </section>
    <section class="Placement p-2">
        <div class="container">
            <div class="row">
                <h2>{{ $university['univ_name'] }} Placement Partners</h2>
                @php
                $cards = [['/images/uni-page/placement.png', '1000 + Hiring partners'], ['/images/uni-page/experience.png', 'Enhanced Hands-on Experience'], ['/images/uni-page/hiring.png', 'E-Hire Portal for Exclusive Job Opportunities']];
                @endphp
                @foreach ($cards as $i => $card)
                <div class="col-md-4 p-2">
                    <div class="card p-4 bordered border-primary bg-light blue">
                        <div class="flex">
                            <img class="img-fluid" src="{{ $card[0] }}" alt="{{$card[1]}}" width="100">
                            <p>{{ $card[1] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
</main>
@endsection