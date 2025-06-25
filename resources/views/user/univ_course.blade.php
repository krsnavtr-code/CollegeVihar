@extends('user.components.layout')
@php
    // Debug: Log the incoming course data
    // Uncomment the next line to see the full course data in the error log
    // \Illuminate\Support\Facades\Log::info('Course Data:', is_array($course) ? $course : ['type' => gettype($course)]);
    
    // Initialize variables with default values
    $course = $course ?? [];
    $university = is_array($course) ? ($course['university'] ?? []) : [];
    $courseData = is_array($course) ? ($course['course'] ?? []) : [];
    
    // Set default values for required fields
    $univName = is_array($university) ? ($university['univ_name'] ?? 'University') : 'University';
    $courseName = is_array($courseData) ? ($courseData['course_name'] ?? 'Course') : 'Course';
    $page_title = "{$univName} - {$courseName}";
    $ucDetails = (is_array($course) && !empty($course['uc_details'])) ? (json_decode($course['uc_details'], true) ?? []) : [];
    
    // Ensure we have valid arrays for the breadcrumb
    $breadcrumbData = [
        'page_title' => $page_title,
        'university' => is_array($university) ? $university : [],
        'course' => is_array($courseData) ? $courseData : []
    ];
    
    // Debug: Check if we have the required data
    if (empty($university) || empty($courseData)) {
        // Log a warning if we're missing expected data
        \Illuminate\Support\Facades\Log::warning('Missing university or course data in univ_course.blade.php', [
            'has_university' => !empty($university),
            'has_course_data' => !empty($courseData),
            'course_keys' => is_array($course) ? array_keys($course) : 'not an array'
        ]);
    }
@endphp
@push('css')
<link rel="stylesheet" href="{{ url('/css/course_page.css') }}">
@endpush
@section('main')
<main>
    @include('user.components.breadcrumbs.course-breadcrumb', [
        'page_title' => $page_title,
        'university' => $university,
        'course' => $courseData
    ])
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
                        @if(!empty($ucDetails))
                            @foreach ($ucDetails as $detail)
                                @if (isset($detail['title']) && strtolower($detail['title']) == 'duration' && isset($detail['desc']))
                                    <h5>{{ $detail['desc'] }}</h5>
                                @endif
                            @endforeach
                        @else
                            <h5>N/A</h5>
                        @endif
                    </article>
                </div>
                <div class="col-4">
                    <article class="border-start border-end">
                        <h4>Fees</h4>
                        <h5>{{ $course['univ_course_fee'] ?? 'N/A' }}</h5>
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
                        @if(!empty($ucDetails))
                            @foreach ($ucDetails as $detail)
                                @if (isset($detail['title']) && strtolower($detail['title']) == 'eligibility' && isset($detail['desc']))
                                    <h5>{{ $detail['desc'] }}</h5>
                                @endif
                            @endforeach
                        @else
                            <h5>N/A</h5>
                        @endif
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="container" style="text-transform: none;">
        <h4>{{ $page_title }}</h4>
        @php
            $aboutContent = !empty($course['uc_about']) ? json_decode($course['uc_about']) : [];
        @endphp
        @if(!empty($aboutContent) && is_array($aboutContent))
            @foreach ($aboutContent as $intro)
                @if(!empty($intro))
                    <p>{{ $intro }}</p>
                @endif
            @endforeach
        @else
            <p>No course description available.</p>
        @endif
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Overview</h4>
        @php
            $overviewContent = !empty($course['uc_overview']) ? json_decode($course['uc_overview']) : [];
        @endphp
        @if(!empty($overviewContent) && is_array($overviewContent))
            <ul>
                @foreach ($overviewContent as $li)
                    @if(!empty($li))
                        <li>{{ $li }}</li>
                    @endif
                @endforeach
            </ul>
        @else
            <p>No course overview available.</p>
        @endif
    </section>
    <section class="container highlights" style="text-transform: none;">
        <h4>Course Highlights</h4>
        <p class="p-2">The course's primary highlights cover a variety of academic and professional
            advantages, ensuring that aspiring students have a well-rounded and enriching educational experience.</p>
        @php
            $img = ['cv.png', 'accreditation.png', 'network.png', 'career-path.png', 'directions.png', 'data-analytics.png', 'training.png', 'development.png'];
            $highlights = !empty($course['uc_highlight']) ? json_decode($course['uc_highlight'], true) : [];
        @endphp
        @if(!empty($highlights) && is_array($highlights))
            <div class="row">
                @foreach ($highlights as $i => $highlight)
                    @if(!empty($highlight))
                        <div class="col-lg-3 col-md-4 col-6 p-2">
                            <figure class="card text-center h-100">
                                <img src="{{ asset('univ_course_img/' . ($img[$i % count($img)] ?? 'default.png')) }}" 
                                     alt="course_highlight" class="img-fluid m-auto" width="100">
                                <h6 class="blue">{{ $highlight }}</h6>
                            </figure>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="alert alert-info">No highlights available for this course.</div>
        @endif
    </section>
    <section class="container" style="text-transform: none;">
        <article>
            <h4>Simplified Approach to Complete Admission Process</h4>
            @php
                $courseName = $course['course_name'] ?? 'this course';
                $courseNameDisplay = $courseName === 'this course' ? $courseName : "Online {$courseName}";
            @endphp
            <p>There is an online admissions process available at {{ $courseNameDisplay }}, therefore there is
                no need to physically visit the campus to apply for admission. There is no entrance exam required to apply for
                admission to {{ $courseNameDisplay }} because admissions are made directly. The following
                describes the {{ $courseNameDisplay }}'s admissions process for online courses:</p>
            <a class="btn btn-primary my-2" title="get recommendation" href="#queryModal" data-bs-toggle="modal" data-bs-target="#queryModal">
                Ask Admission Query
            </a>
        </article>
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Details</h4>
        <p>This concise course overview includes key features and essential details, offering a comprehensive understanding of the program's offerings.</p>
        @php
            $courseDetails = !empty($course['uc_details']) ? json_decode($course['uc_details'], true) : [];
            $courseFee = isset($course['univ_course_fee']) ? number_format($course['univ_course_fee']) : 'N/A';
        @endphp
        
        @if(!empty($courseDetails) && is_array($courseDetails))
            <table class="table table-striped text-capitalize bordered">
                <thead class="table-primary">
                    <tr class="blue">
                        <th scope="col">Parameters</th>
                        <th scope="col">Details</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($courseDetails as $detail)
                        @if(isset($detail['title']) || isset($detail['desc']))
                            <tr>
                                <td>{{ $detail['title'] ?? 'N/A' }}</td>
                                <td>{{ $detail['desc'] ?? 'N/A' }}</td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th scope="col">Course Fee</th>
                        <td>{{ $courseFee }}</td>
                    </tr>
                </tfoot>
            </table>
        @else
            <div class="alert alert-info">No course details available at the moment.</div>
            <div class="mt-3">
                <strong>Course Fee:</strong> {{ $courseFee }}
            </div>
        @endif
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Syllabus</h4>
        <p>A comprehensive breakdown of the course-related syllabus, encompassing subjects
            organized by year or semester, is available for your detailed perusal.</p>
        @php
            $subjectGroups = !empty($course['uc_subjects']) ? json_decode($course['uc_subjects'], true) : [];
        @endphp
        
        @if(!empty($subjectGroups) && is_array($subjectGroups))
            <div class="row subject_groups">
                @foreach ($subjectGroups as $subject_group)
                    @if(!empty($subject_group['title']) && !empty($subject_group['subjects']) && is_array($subject_group['subjects']))
                        <div class="col-lg-4 col-sm-6 mb-4">
                            <article class="h-100 p-3 border rounded">
                                <h5 class="blue">{{ $subject_group['title'] ?? 'Subjects' }}</h5>
                                @if(!empty($subject_group['subjects']))
                                    <h6>Total {{ count($subject_group['subjects']) }} Subjects to study</h6>
                                    <ul class="mb-0">
                                        @foreach ($subject_group['subjects'] as $subject)
                                            @if(!empty($subject))
                                                <li>{{ $subject }}</li>
                                            @endif
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-muted mb-0">No subjects listed for this group.</p>
                                @endif
                            </article>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                The course syllabus is currently being updated. Please check back later for detailed subject information.
            </div>
        @endif
    </section>
    <section class="container" style="text-transform: none;">
        <h4>Course Assignments</h4>
        <p>The course entails a series of assignments designed to foster skill development,
            critical thinking, and practical application of the subject matter.</p>
        @php
            $assignments = !empty($course['uc_assign']) ? json_decode($course['uc_assign'], true) : [];
            $assignmentImages = [
                'operations & supply chain.png', 
                'geopolitics.png', 
                'organizational behavior.png', 
                'supply chain management.png', 
                'inventory management.png'
            ];
        @endphp
        
        @if(!empty($assignments) && is_array($assignments))
            <div class="row">
                @foreach ($assignments as $i => $assignment)
                    @if(!empty($assignment))
                        <div class="col-lg-3 col-md-4 col-6 p-2">
                            <figure class="card text-center h-100">
                                @php
                                    $imgIndex = $i % count($assignmentImages);
                                    $imgSrc = asset('univ_course_img/' . ($assignmentImages[$imgIndex] ?? 'default-assignment.png'));
                                @endphp
                                @php
                                    $fallbackImage = asset('univ_course_img/default-assignment.png');
                                @endphp
                                <img src="{{ $imgSrc }}" 
                                     alt="Assignment {{ $i + 1 }}" 
                                     class="img-fluid m-auto" 
                                     width="100"
                                     onerror="this.onerror=null; this.src='{{ $fallbackImage }}'"
                                >
                                <h6 class="blue mt-2">{{ $assignment }}</h6>
                            </figure>
                        </div>
                    @endif
                @endforeach
            </div>
        @else
            <div class="alert alert-info">
                Assignment details will be provided at the start of the course.
            </div>
        @endif
    </section>

    @php
        // Helper function to safely decode and process JSON content
        function processContent($content, $defaultMessage = 'Information not available.') {
            if (empty($content)) {
                return [];
            }
            $decoded = json_decode($content, true);
            return is_array($decoded) ? array_filter($decoded) : [];
        }

        $cvHelp = processContent($course['uc_cv_help'] ?? null, 'How CollegeVihar can assist you will be shared during the course orientation.');
        $collaboration = processContent($course['uc_collab'] ?? null, 'Collaboration details will be provided by your course instructor.');
        $expertInfo = processContent($course['uc_expert'] ?? null, 'Expert guidance information will be available soon.');
    @endphp

    @if(!empty($cvHelp))
        <section class="container">
            <h4>How CollegeVihar Helps You</h4>
            @foreach($cvHelp as $item)
                @if(!empty($item))
                    <p style="text-transform: none;" class="mb-3">{{ $item }}</p>
                @endif
            @endforeach
        </section>
    @endif

    @if(!empty($collaboration))
        <section class="container mt-4">
            <h4>Collaboration to Succeed</h4>
            @foreach($collaboration as $item)
                @if(!empty($item))
                    <p style="text-transform: none;" class="mb-3">{{ $item }}</p>
                @endif
            @endforeach
        </section>
    @endif

    @if(!empty($expertInfo))
        <section class="container mt-4">
            <h4>Grouping with Experts</h4>
            @foreach($expertInfo as $item)
                @if(!empty($item))
                    <p style="text-transform: none;" class="mb-3">{{ $item }}</p>
                @endif
            @endforeach
        </section>
    @endif
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


    @php
        $universityName = $course['university']['univ_name'] ?? 'the University';
        $universityName = !empty($universityName) ? $universityName : 'the University';
    @endphp
    
    <section class="container" style="text-transform: none;">
        <h4>{{ $universityName }} <span>Admission Process</span></h4>
        <p>There is an online admissions process available at {{ $universityName }}, therefore there
            is no need to physically visit the campus to apply for admission. There is no entrance exam required to apply
            for admission to {{ $universityName }} Online because admissions are made directly. The
            following describes the {{ $universityName }}'s admissions process for online courses:</p>

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