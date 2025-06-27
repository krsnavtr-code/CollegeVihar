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

        .image-container {
            width: 100%;
            height: 120px;
            /* Reduced height for smaller card */
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .image-container img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
            /* Ensures full visibility without cropping */
        }

        .card {
            border-radius: 10px;
            transition: transform 0.2s ease-in-out;
            padding: 10px;
            /* Reduced padding */
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .univ_titles {
            font-size: 1.2rem;
            font-weight: 600;
            /* margin-bottom: 1rem; */
            color: var(--blue);
        }

        /*  */
        /* Overview Table Styling */
        .overview-table {
            width: 100%;
            /* border-collapse: collapse; */
            font-size: 15px;
            background-color: #fff;
            /* border: 1px solid #e2e8f0; */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        .overview-table th,
        .overview-table td {
            vertical-align: top;
        }

        .overview-table th {
            background-color: #f8fafc;
            font-weight: 600;
            color: #334155;
            width: 30%;
        }

        .overview-table td {
            background-color: #ffffff;
            color: #1e293b;
        }

        .overview-table a {
            color: #0d6efd;
            text-decoration: none;
        }

        .overview-table a:hover {
            text-decoration: underline;
        }

        .overview-table tr:hover td {
            background-color: #f1f5f9;
        }

        @media (max-width: 576px) {
            .overview-table {
                font-size: 14px;
            }
        }

        /*  */
        .recruiter-marquee-container {
    overflow: hidden;
    white-space: nowrap;
    position: relative;
    background-color: #f8fafc;
    /* border: 1px solid #e2e8f0; */
    border-radius: 8px;
    padding: 10px 0;
}

.recruiter-marquee-track {
    display: inline-block;
    white-space: nowrap;
    animation: scroll-left 25s linear infinite;
}

.recruiter-badge {
    display: inline-block;
    background-color: #e0f2fe;
    color: #0369a1;
    padding: 8px 16px;
    margin: 0 10px;
    border-radius: 20px;
    font-weight: 500;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    white-space: nowrap;
}

@keyframes scroll-left {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

/* Optional: Hover pause */
.recruiter-marquee-container:hover .recruiter-marquee-track {
    animation-play-state: paused;
}

    </style>
@endpush

@section('main')
    <main>
        @include('user.components.breadcrumbs.uni-breadcrumb')
        <div class="container">
            <div class="row">
                <div class=" col-9 col-s-12 col-m-12 col-l-12">
                    <!-- University Header -->
                    <section class="univ-header mb-4">
                        <div class=" d-flex flex-column flex-md-row">
                            <div class="col-md-2">
                                <img src="{{ !empty($university['univ_image']) ? '/images/university/campus/' . $university['univ_image'] : '/images/logomini.png' }}"
                                    alt="{{ $university['univ_name'] }}"
                                    class="img-fluid rounded shadow h-100 w-100 object-fit-cover object-position-center">
                            </div>
                            <div class="col-md-10 ms-3">
                                <h2>{{ $university['univ_name'] }}</h2>
                                <p><span
                                        class="blue fw-bold me-1 ">{{ !empty($university['courses']) ? count($university['courses']) : 0 }}</span>
                                    Course{{ !empty($university['courses']) && count($university['courses']) !== 1 ? 's' : '' }}
                                    Available
                                </p>
                                <p><span><i class="fa-solid fa-industry blue"></i>
                                        {{ !empty($university['univ_category']) ? $university['univ_category'] : 'Not specified' }}</span>
                                    | <span><i class="fa-solid fa-award blue"></i> UGC, AICTE, NAAC, BCI, COA</span> |
                                    <span><i class="fa-solid fa-university blue"></i>
                                        {{ !empty($university['univ_type']) ? $university['univ_type'] : 'Not specified' }}
                                        University</span>
                                </p>
                                <p><span
                                        class="blue fw-bold me-1 ">{{ !empty($university['univ_address']) ? $university['univ_address'] : 'Location not specified' }}</span>
                                </p>
                            </div>
                        </div>
                    </section>

                    <!-- University Content -->
                    <section id="university">
                        <div class="">
                            <div class="row">
                                <article class="p-2">
                                    <p class="univ_titles">About {{ $university['univ_name'] }}</p>
                                    @if(!empty($desc) && is_array($desc))
                                        @foreach ($desc as $p)
                                            <p class="ps-2 mb-3">{{ $p }}</p>
                                        @endforeach
                                    @else
                                        <p class="p-2">No description available.</p>
                                    @endif
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles mb-2">Highlights of {{ $university['univ_name'] }}</p>
                                    @if (!empty($industry) && is_array($industry))
                                        @foreach ($industry as $index => $p)
                                            <div class=" ps-2 mb-3">
                                                <!-- Button group -->
                                                <div class="d-flex justify-content-start gap-2 mb-2">
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                                        data-bs-target="#details-{{ $index }}" aria-expanded="true"
                                                        aria-controls="details-{{ $index }}">
                                                        Overview
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                                        data-bs-target="#rankings-{{ $index }}" aria-expanded="false"
                                                        aria-controls="rankings-{{ $index }}">
                                                        Rankings
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                                        data-bs-target="#popular-courses-{{ $index }}" aria-expanded="false"
                                                        aria-controls="popular-courses-{{ $index }}">
                                                        Popular Courses
                                                    </button>
                                                    <button class="btn btn-sm btn-outline-primary" data-bs-toggle="collapse"
                                                        data-bs-target="#ranking-{{ $index }}" aria-expanded="false"
                                                        aria-controls="ranking-{{ $index }}">
                                                        Ranking Info
                                                    </button>
                                                </div>

                                                <!-- Accordion for this row -->
                                                <div class="accordion" id="accordion-{{ $index }}">
                                                    <div id="details-{{ $index }}" class="accordion-collapse collapse show"
                                                        data-bs-parent="#accordion-{{ $index }}">
                                                        <div class="accordion-body">
                                                            <!-- <strong>Details:</strong> {{ $p['details'] ?? 'N/A' }} -->
                                                            <article class="">
                                                                <p class="univ_titles">Overview</p>

                                                                <div class="table-responsive">
                                                                    <table class="table overview-table">
                                                                        <tbody>
                                                                            <tr>
                                                                                <th>University Name</th>
                                                                                <td>Manipal University Jaipur (MUJ)</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Year of Establishment</th>
                                                                                <td>2011</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>University Type</th>
                                                                                <td>Private</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Recognitions</th>
                                                                                <td>UGC, AICTE, COA, BCI, DSIR</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Accreditation</th>
                                                                                <td>NAAC 'A+' Grade</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Campus Area</th>
                                                                                <td>122 Acres</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Location</th>
                                                                                <td>Dehmi Kalan, Jaipur-Ajmer Expressway, Jaipur
                                                                                </td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Admission Mode</th>
                                                                                <td>Entrance-Based & Merit-Based</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Entrance Exams Accepted</th>
                                                                                <td>MU-OET, JEE, CAT, MAT, CLAT, LSAT, NATA</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Courses Offered</th>
                                                                                <td>UG, PG, Ph.D. (Engineering, Management, Design,
                                                                                    Law, Arts, etc.)</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Student Strength</th>
                                                                                <td>~8000+ Students (approx.)</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Faculty Strength</th>
                                                                                <td>300+ Qualified Faculty</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Placement Assistance</th>
                                                                                <td>Yes, with top recruiters & dedicated placement
                                                                                    cell</td>
                                                                            </tr>
                                                                            <tr>
                                                                                <th>Official Website</th>
                                                                                <td><a href="https://jaipur.manipal.edu"
                                                                                        target="_blank">jaipur.manipal.edu</a></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </article>
                                                        </div>
                                                    </div>
                                                    <div id="rankings-{{ $index }}" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordion-{{ $index }}">
                                                        <article class="p-2">
                                                            <p class="univ_titles">Rankings of {{ $university['univ_name'] }}</p>
                                                            <p>{{ $university['univ_name'] }} has consistently ranked among the top
                                                                private universities in India by various reputed agencies. Here's a
                                                                look at its recent rankings:</p>

                                                            <div class="table-responsive">
                                                                <table class="table rankings-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Ranking Body</th>
                                                                            <th>Category</th>
                                                                            <th>Rank / Band</th>
                                                                            <th>Year</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>NIRF (Ministry of Education)</td>
                                                                            <td>Engineering (India)</td>
                                                                            <td>101-150 Band</td>
                                                                            <td>2023</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>India Today</td>
                                                                            <td>Private Universities</td>
                                                                            <td>17th</td>
                                                                            <td>2022</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>IIRF Ranking</td>
                                                                            <td>Overall Private Universities</td>
                                                                            <td>35th</td>
                                                                            <td>2023</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Outlook-ICARE</td>
                                                                            <td>Engineering (Private)</td>
                                                                            <td>16th</td>
                                                                            <td>2022</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>Times Engineering</td>
                                                                            <td>Top Private Engineering Colleges</td>
                                                                            <td>10th</td>
                                                                            <td>2021</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </article>
                                                    </div>
                                                    <div id="popular-courses-{{ $index }}" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordion-{{ $index }}">
                                                        <article class="p-2">
                                                            <p class="univ_titles">Popular Courses at Manipal University Jaipur</p>

                                                            <!-- Undergraduate Programs -->
                                                            <h5 class="mt-3 text-primary">Undergraduate Programs</h5>
                                                            <div class="table-responsive">
                                                                <table class="table course-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Program</th>
                                                                            <th>Duration</th>
                                                                            <th>Specializations</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>B.Tech</td>
                                                                            <td>4 Years</td>
                                                                            <td>CSE, ECE, Mechanical, AI & ML, Civil, IT, Data
                                                                                Science</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>BBA</td>
                                                                            <td>3 Years</td>
                                                                            <td>General, Finance, HR, Marketing</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>BCA</td>
                                                                            <td>3 Years</td>
                                                                            <td>Data Analytics, Cyber Security</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B.Des</td>
                                                                            <td>4 Years</td>
                                                                            <td>Interior, Fashion, Communication Design</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>BA (Hons)</td>
                                                                            <td>3 Years</td>
                                                                            <td>English, Psychology, Economics</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B.Com (Hons)</td>
                                                                            <td>3 Years</td>
                                                                            <td>Finance, International Business, Taxation</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>BA LLB / BBA LLB</td>
                                                                            <td>5 Years (Integrated)</td>
                                                                            <td>Law Degree Program</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>B.Arch</td>
                                                                            <td>5 Years</td>
                                                                            <td>Architecture</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Postgraduate Programs -->
                                                            <h5 class="mt-4 text-primary">Postgraduate Programs</h5>
                                                            <div class="table-responsive">
                                                                <table class="table course-table">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>Program</th>
                                                                            <th>Duration</th>
                                                                            <th>Specializations</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>MBA</td>
                                                                            <td>2 Years</td>
                                                                            <td>Marketing, Finance, HR, Operations, Analytics</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>M.Tech</td>
                                                                            <td>2 Years</td>
                                                                            <td>Power Systems, VLSI Design, Structural, Data Science
                                                                            </td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>M.Sc</td>
                                                                            <td>2 Years</td>
                                                                            <td>Mathematics, Biotechnology, Data Science</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>MA</td>
                                                                            <td>2 Years</td>
                                                                            <td>Journalism, English</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>LLM</td>
                                                                            <td>1 Year</td>
                                                                            <td>Corporate Law, Constitutional Law</td>
                                                                        </tr>
                                                                        <tr>
                                                                            <td>MCA</td>
                                                                            <td>2 Years</td>
                                                                            <td>Software Development, AI</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>

                                                            <!-- Doctoral Programs -->
                                                            <h5 class="mt-4 text-primary">Doctoral Programs (Ph.D.)</h5>
                                                            <p>Offered across multiple streams such as <strong>Engineering, Law,
                                                                    Management, Arts, and Sciences</strong> with both
                                                                <strong>full-time and part-time</strong> options.
                                                            </p>
                                                        </article>
                                                    </div>
                                                    <div id="ranking-{{ $index }}" class="accordion-collapse collapse"
                                                        data-bs-parent="#accordion-{{ $index }}">
                                                        <div class="accordion-body">
                                                            <strong>Ranking Info:</strong> {{ $p['ranking_body'] ?? 'N/A' }}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <p class="p-2">No industry available.</p>
                                    @endif
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Admission Process</p>
                                    <ul class="ps-2 ms-3 mb-3">
                                        <li>Online Registration: Visit jaipur.manipal.edu to apply online.</li>
                                        <li>Check Eligibility: Based on 10+2 or UG scores and entrance exam results.
                                        </li>
                                        <li>Entrance Exam: MUJ conducts MU-OET for specific programs; national-level
                                            scores like JEE/CAT/CLAT are also accepted.</li>
                                        <li>Counselling/Interview: Shortlisted candidates are invited.</li>
                                        <li>Document Verification & Fee Payment to confirm admission.</li>
                                    </ul>
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Important Dates (Tentative)</p>
                                    <ul class="ps-2 ms-3 mb-3">
                                        <li>Online Application Starts January 2025</li>
                                        <li>Application Deadline May 2025</li>
                                        <li>MU-OET Exam Dates June 2025</li>
                                        <li>Counselling Begins July 2025</li>
                                        <li>Session Commencement August 2025</li>
                                        <li>Cut-Off Details (Program-wise)</li>
                                        <li>Program Accepted Exam Cut-Off (Expected)</li>
                                        <li>B.Tech (CSE) JEE Main / MU-OET 85+ Percentile / 140+ Marks</li>
                                        <li>B.Tech (IT, ECE, AI) JEE / MU-OET 70–80 Percentile</li>
                                        <li>B.Des MUJ DAT + Portfolio 60%+ Score</li>
                                        <li>MBA CAT/MAT/XAT/CMAT 60+ Percentile</li>
                                        <li>BA LLB / BBA LLB CLAT / LSAT CLAT Rank < 10000</li>
                                        <li>BBA / BCA Merit-Based 70–75% in Class 12th</li>
                                        <li>B.Arch NATA 90+ Score</li>
                                    </ul>
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Placement Details at {{ $university['univ_name'] }}</p>
                                    <p class="ps-2 mb-3">
                                        MUJ has a strong placement cell and maintains robust industry connections. Every year, more than 90% of eligible students land great job offers.
                                    </p>
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Key Placement Stats (2023)</p>
                                    <ul class="ps-2 ms-3 mb-3">
                                        <li>Highest CTC: ₹45 LPA (offered by Microsoft to a CSE graduate)</li>
                                        <li>Average CTC: ₹6.5 LPA (Engineering), ₹5.2 LPA (MBA)</li>
                                        <li>Placement Percentage: 90%+</li>
                                    </ul>
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Top Recruiters</p>
                                    <div class="recruiter-marquee-container ps-2 mb-3">
                                        <div class="recruiter-marquee-track">
                                            @foreach ([
                                                'Microsoft', 'Amazon', 'Deloitte', 'Accenture', 'Infosys', 'TCS',
                                                'Bosch', 'IBM', 'Wipro', 'L&T', 'Capgemini', 'HDFC Bank',
                                                'ZS Associates', 'Cognizant', 'Byju\'s'
                                            ] as $recruiter)
                                                <span class="recruiter-badge">{{ $recruiter }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                </article>

                                <article class="p-2">
                                    <p class="univ_titles">Facts</p>
                                    @if(!empty($facts) && is_array($facts))
                                        <ul class="ps-2 ms-3 mb-3">
                                            @foreach ($facts as $li)
                                                <li>{{$li}}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p>No facts available.</p>
                                    @endif
                                </article>
                                <article>
                                    <p class="univ_titles">Advantages</p>
                                    @if(!empty($advantage) && is_array($advantage) && isset($advantage['data']) && is_array($advantage['data']))
                                        <div class="row ps-2">
                                            @foreach ($advantage['data'] as $d)
                                                <div class="col-md-3 col-6 p-2"> <!-- Reduced column size -->
                                                    <article class="card p-2 h-100 shadow-sm border-0 text-center">
                                                        <div class="image-container">
                                                            <img class="img-fluid" src="/images/icon_png/{{ $d['logo'] }}"
                                                                alt="{{$d['title']}}">
                                                        </div>
                                                        <p class="blue mt-2">{{ $d['title'] }}</p>
                                                        <!-- <p class="text-muted small">{{ $d['description'] }}</p> -->
                                                    </article>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <p>No advantages available.</p>
                                    @endif
                                </article>
                                <article class="p-2">
                                    <p class="univ_titles">Available Courses</p>
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
                                        <a class="btn btn-outline-primary m-1" title="{{ $course['course_name'] }}"
                                            href="/{{ $url2 }}" target="blank">{{ $course['course_short_name'] }}</a>
                                    @endforeach
                                </article>
                                <article class="p-2">
                                    <p class="univ_titles">Boost Your Future</p>
                                    <p>Embark on Your Path to Success: Seize the Golden Opportunity Awaiting You! Take a
                                        Moment
                                        to Fill Out
                                        Our Thorough Query Form, and You'll Be Initiating the First Thrilling Steps Towards
                                        a
                                        Brilliant
                                        Future Filled with Remarkable Achievements and Lifelong Growth.</p>

                                </article>
                            </div>
                        </div>
                    </section>
                    <section class="py-2">
                        <div class="">
                            <div class="row">
                                <div class="col-md-6 p-2">
                                    <article>
                                        <p class="univ_titles">Admission Process</p>
                                        <p>There is an online admissions process available at Online
                                            {{ $university['univ_name'] }}, therefore there is
                                            no need to physically visit the campus to apply for admission. There is no
                                            entrance
                                            exam required to apply for
                                            admission to {{ $university['univ_name'] }} Online because admissions are made
                                            directly. The following
                                            describes the {{ $university['univ_name'] }}'s admissions process for online
                                            courses:
                                        </p>
                                        <a class="btn btn-primary my-2" title="get recommendation" href="#queryModal"
                                            data-bs-toggle="modal" data-bs-target="#queryModal">
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
                                                <p class="accordion-header">
                                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                                        data-bs-target="#panel{{ $i + 1 }}" aria-expanded="true"
                                                        aria-controls="panel{{ $i + 1 }}">
                                                        <span>Step {{ $i + 1 }} : </span>
                                                        <span class="ms-1">{{ $steps[$i]['step_title'] }}</span>
                                                    </button>
                                                </p>
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
                        <div class="">
                            <div class="row">
                                <p class="section_title"><span>{{ $university['univ_name'] }} Examination Pattern</span></p>
                                <p>With simply a laptop or desktop computer and a strong internet connection, you can take
                                    tests
                                    whenever and
                                    wherever it suits you.</p>
                                @php
                                    $patterns = [['title' => 'Exam Schedule', 'desc' => 'Exam schedule alerts will be sent to students through email or SMS in advance.', 'color' => '#6e5cbc'], ['title' => 'Slot Booking', 'desc' => 'Through the LMS, learners can reserve their preferred exam time slots.', 'color' => '#02233a'], ['title' => 'E-Hall Tickets', 'desc' => 'One week prior to the exam, hall tickets will be accessible for download through the LMS.', 'color' => '#f58e16'], ['title' => 'Exam', 'desc' => 'Using a secure browser from the comfort of your home, take examinations that are proctored online.', 'color' => '#1a697e'], ['title' => 'Evaluation & Results', 'desc' => 'Results will be announced and shared with students shortly following evaluation.', 'color' => '#2fb3b7']];
                                @endphp
                                @foreach ($patterns as $i => $pattern)
                                    <div class="col-md-4 col-6 p-2">
                                        <div
                                            class="card bg-light text-center h-100 p-2 rounded-1 bordered border-2 border-primary m-2">
                                            <p class="count rounded-circle bg-blue position-absolute start-0 top-0 center"
                                                style="width: 40px; height: 40px; transform: translate(-50%, 50%);">{{ $i + 1 }}
                                            </p>
                                            <p class="blue">{{ $pattern['title'] }}</p>
                                            <p class="text-secondary">{{ $pattern['desc'] }}</p>
                                            <span class="bottom-line"></span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </section>
                    <section class="Programs p-2">
                        <div class="">
                            <div class="row">
                                <p class="univ_titles">Industry-Ready Programs for Enhanced Career Readiness</p>
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
                        <div class="">
                            <div class="row">
                                <p class="univ_titles">Expert Career Guidance and Placement Services</p>
                                <p>Our goal is to increase the employability quotient of students who are eager to pursue
                                    careers after
                                    completing their programs. We maintain a wide network with the top businesses in India,
                                    including both
                                    well-established and start-up businesses, to assist our students. Our goal is to match
                                    alumni of our
                                    programs with employers seeking the right talent and the right set of employment
                                    possibilities that
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
                    <!-- Placement Section -->
                    <section class="Placement p-2">
                        <div class="">
                            <div class="row">
                                <p class="univ_titles">Placement Partners</p>
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
                    <!-- Gallery Section -->
                    <section class="Gallery p-2">
                        <p class="univ_titles">Gallery</p>
                        <div class="row row-cols-md-3 row-cols-2 g-2 mb-2 ms-2">
                            <div class="col-md-4 col-6 p-2">
                                <img class="img-fluid rounded hover-zoom" src="/images/university/gallery/user (2).jpg" alt="">
                            </div>
                            <div class="col-md-4 col-6 p-2">
                                <img class="img-fluid rounded hover-zoom" src="/images/university/gallery/user (4).jpg" alt="">
                            </div>
                            <div class="col-md-4 col-6 p-2">
                                <img class="img-fluid rounded hover-zoom" src="/images/university/gallery/user_bg.jpg" alt="">
                            </div>
                        </div>
                    </section>
                    <!-- FAQ's -->
                     <section class="FAQ p-2">
                        <div class="">
                            <div class="row">
                                <p class="univ_titles">FAQ's</p>
                                <p>Here is the list of frequently asked questions by the students</p>
                                <ul class="list-unstyled row ms-2 ">
                                    @foreach (['Communication', 'Self-development & Confidence building', 'Critical thinking & Problem solving', 'Leadership', 'Professionalism', 'Teamwork & Collaboration', 'Cultural fluency', 'Technology'] as $i => $li)
                                        <li class="p-2 col-6">
                                            <span class="blue">#</span>{{ $li }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </section>
                    <!-- College MAP Location Section -->
                    <section class="p-2">
                        <p class="univ_titles">College Location</p>
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3559.877133408761!2d75.56265937414662!3d26.84385996304845!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x396c4850e05bee9b%3A0x1b8d67402d4eb863!2sManipal%20University%20Jaipur!5e0!3m2!1sen!2sin!4v1750999981023!5m2!1sen!2sin" width="100%" height="200" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downdowngrade"
                        class="rounded shadow ms-2 mb-2"></iframe>
                    </section>
                </div>
                <!-- Make sure parent is position: relative if needed -->
                <div class="col-3 col-s-12 col-m-12 col-l-12 mt-5">
                    <div class="card border-0 bg-light rounded-2 shadow"
                        style="position: sticky; top: 20%; max-height: calc(100vh - 100px); overflow-y: auto;">
                        <div>
                            <p class="text-primary fw-bold mb-3">Admission</p>
                            <p>Eligibility Criteria</p>
                            <p>Important Dates</p>
                            <p>Application Process</p>
                            <p>Fee Structure</p>
                            <p>Scholarships</p>
                            <p>More Details</p>
                            <p>More Details</p>
                            <p>More Details</p>
                            <p>More Details</p>
                            <!-- Add more to test scroll -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('script')
        <script>
            function toggleContent(index, type) {
                const types = ['details', 'rankings', 'ranking'];
                types.forEach(t => {
                    const element = document.getElementById(`${t}-${index}`);
                    if (t === type) {
                        element.style.display = element.style.display === 'none' ? 'block' : 'none';
                    } else {
                        if (element) element.style.display = 'none';
                    }
                });
            }
        </script>
    @endpush
@endsection