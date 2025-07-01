@extends('user.components.layout')
@php
    $page_title = $university['univ_name'];
    $univ_img = $university['univ_image'];

    // Helper function to safely decode JSON
    function safeJsonDecode($json, $default = []) {
        if (empty($json)) {
            return $default;
        }
        
        if (is_array($json)) {
            return $json;
        }
        
        $decoded = json_decode($json, true);
        return (json_last_error() === JSON_ERROR_NONE) ? $decoded : $default;
    }

    // Decode all JSON fields with proper error handling
    $desc = safeJsonDecode($university['univ_description'] ?? '', ['']);
    $facts = safeJsonDecode($university['univ_facts'] ?? '');
    $advantages = safeJsonDecode($university['univ_advantage'] ?? '');
    $industry = safeJsonDecode($university['univ_industry'] ?? '');
    $popularCourses = safeJsonDecode($university['univ_popular_courses'] ?? '', [
        'undergraduate' => [],
        'postgraduate' => [],
        'diploma' => [],
        'others' => []
    ]);
    
    $admission = $university['univ_admission'] ?? '';
    $eligibility = safeJsonDecode($university['univ_eligibility'] ?? '');
    $importantDates = safeJsonDecode($university['important_dates'] ?? '');
    $placement = safeJsonDecode($university['univ_placement'] ?? '', ['highlights' => [], 'top_recruiters' => [], 'statistics' => []]);
    $careerGuidance = safeJsonDecode($university['univ_career_guidance'] ?? '', ['services' => [], 'testimonials' => []]);
    $scholarships = safeJsonDecode($university['univ_scholarship'] ?? '');
    $facilities = safeJsonDecode($university['univ_facilities'] ?? '');
    $gallery = safeJsonDecode($university['univ_gallery'] ?? '');
    
    // Ensure description is always an array
    if (!is_array($desc)) {
        $desc = [$desc];
    }
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
        <div class="container py-4">
            <div class="row">
                <!-- Main Content -->
                <div class="col-12 col-lg-8">
                    <!-- University Header -->
                    <section class="card shadow-sm mb-4">
                        <div class="card-body">
                            <div class="d-flex flex-column flex-md-row align-items-center">
                                <div class="col-md-3 text-center mb-3 mb-md-0">
                                    <div class="university-logo-container">
                                        <img src="{{ asset($university['univ_logo'] ?? 'images/default-university.png') }}" 
                                             alt="{{ $university['univ_name'] }} Logo" 
                                             class="img-fluid university-logo">
                                    </div>
                                </div>
                                <div class="col-md-9 ps-md-4">
                                    <h1 class="mb-3">{{ $university['univ_name'] }}</h1>
                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                        @if(!empty($university['univ_establishment_year']))
                                            <span class="badge bg-primary">Est. {{ $university['univ_establishment_year'] }}</span>
                                        @endif
                                        @if(!empty($university['univ_type']))
                                            <span class="badge bg-secondary">{{ $university['univ_type'] }}</span>
                                        @endif
                                        @if(!empty($university['univ_ownership']))
                                            <span class="badge bg-info">{{ $university['univ_ownership'] }}</span>
                                        @endif
                                        @if(!empty($university['univ_approval']))
                                            <span class="badge bg-success">{{ $university['univ_approval'] }} Approved</span>
                                        @endif
                                    </div>
                                    
                                    @if(!empty($university['univ_address']) || !empty($university['univ_website']) || !empty($university['univ_phone']))
                                        <div class="university-meta mt-3">
                                            @if(!empty($university['univ_address']))
                                                <p class="mb-1">
                                                    <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                    {{ $university['univ_address'] }}
                                                </p>
                                            @endif
                                            
                                            @if(!empty($university['univ_website']))
                                                <p class="mb-1">
                                                    <i class="fas fa-globe text-primary me-2"></i>
                                                    <a href="{{ $university['univ_website'] }}" target="_blank" class="text-decoration-none">
                                                        {{ parse_url($university['univ_website'], PHP_URL_HOST) }}
                                                    </a>
                                                </p>
                                            @endif
                                            
                                            @if(!empty($university['univ_phone']))
                                                <p class="mb-0">
                                                    <i class="fas fa-phone text-primary me-2"></i>
                                                    <a href="tel:{{ $university['univ_phone'] }}" class="text-decoration-none">
                                                        {{ $university['univ_phone'] }}
                                                    </a>
                                                </p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Quick Facts -->
                    @if(!empty($facts) && count($facts) > 0)
                        <section id="quick-facts" class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Quick Facts</h2>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    @foreach($facts as $fact)
                                        @if(!empty($fact['title']) || !empty($fact['value']))
                                            <div class="col-md-6 mb-3">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 text-primary me-3">
                                                        <i class="fas {{ $fact['icon'] ?? 'fa-check-circle' }}"></i>
                                                    </div>
                                                    <div>
                                                        @if(!empty($fact['title']))
                                                            <h6 class="mb-1">{{ $fact['title'] }}</h6>
                                                        @endif
                                                        @if(!empty($fact['value']))
                                                            <p class="mb-0 text-muted">{{ $fact['value'] }}</p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- About University -->
                    @if(!empty($desc))
                        <section id="about" class="card shadow-sm mb-4">
                            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                <h2 class="h5 mb-0">About {{ $university['univ_name'] }}</h2>
                            </div>
                            <div class="card-body">
                                @foreach($desc as $paragraph)
                                    @if(!empty($paragraph))
                                        <p>{!! nl2br(e($paragraph)) !!}</p>
                                    @endif
                                @endforeach
                                
                                @if(!empty($university['univ_campus_area']) || !empty($university['univ_student_strength']) || !empty($university['univ_faculty_strength']))
                                    <div class="row mt-4">
                                        @if(!empty($university['univ_campus_area']))
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-card">
                                                    <div class="stat-number">{{ $university['univ_campus_area'] }}</div>
                                                    <div class="stat-label">Campus Area (acres)</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(!empty($university['univ_student_strength']))
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-card">
                                                    <div class="stat-number">{{ number_format($university['univ_student_strength']) }}+</div>
                                                    <div class="stat-label">Students</div>
                                                </div>
                                            </div>
                                        @endif
                                        
                                        @if(!empty($university['univ_faculty_strength']))
                                            <div class="col-md-4 mb-3">
                                                <div class="stat-card">
                                                    <div class="stat-number">{{ number_format($university['univ_faculty_strength']) }}+</div>
                                                    <div class="stat-label">Faculty Members</div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    <!-- Popular Courses -->
                    @if(!empty($undergraduateCourses) || !empty($postgraduateCourses) || !empty($diplomaCourses) || !empty($otherCourses))
                        <section id="courses" class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Popular Courses at {{ $university['univ_name'] }}</h2>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="coursesAccordion">
                                    @if(!empty($undergraduateCourses))
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="undergradHeading">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                                        data-bs-target="#undergradCollapse" aria-expanded="true" 
                                                        aria-controls="undergradCollapse">
                                                    <i class="fas fa-graduation-cap me-2"></i> Undergraduate Programs
                                                </button>
                                            </h3>
                                            <div id="undergradCollapse" class="accordion-collapse collapse show" 
                                                 aria-labelledby="undergradHeading" data-bs-parent="#coursesAccordion">
                                                <div class="accordion-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Program</th>
                                                                    <th>Duration</th>
                                                                    <th>Eligibility</th>
                                                                    <th>Fees (Annual)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($undergraduateCourses as $course)
                                                                    @if(is_array($course) && !empty($course['program']))
                                                                        <tr>
                                                                            <td>
                                                                                <strong>{{ $course['program'] }}</strong>
                                                                                @if(!empty($course['specializations']))
                                                                                    <div class="text-muted small">
                                                                                        {{ is_array($course['specializations']) ? implode(', ', $course['specializations']) : $course['specializations'] }}
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $course['duration'] ?? 'N/A' }}</td>
                                                                            <td>{{ $course['eligibility'] ?? '10+2 or equivalent' }}</td>
                                                                            <td>
                                                                                @if(!empty($course['fees']))
                                                                                    ₹{{ number_format($course['fees']) }}
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Postgraduate Programs -->
                                    @if(!empty($postgraduateCourses))
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="postgradHeading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                        data-bs-target="#postgradCollapse" aria-expanded="false" 
                                                        aria-controls="postgradCollapse">
                                                    <i class="fas fa-user-graduate me-2"></i> Postgraduate Programs
                                                </button>
                                            </h3>
                                            <div id="postgradCollapse" class="accordion-collapse collapse" 
                                                 aria-labelledby="postgradHeading" data-bs-parent="#coursesAccordion">
                                                <div class="accordion-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Program</th>
                                                                    <th>Duration</th>
                                                                    <th>Eligibility</th>
                                                                    <th>Fees (Annual)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($postgraduateCourses as $course)
                                                                    @if(is_array($course) && !empty($course['program']))
                                                                        <tr>
                                                                            <td>
                                                                                <strong>{{ $course['program'] }}</strong>
                                                                                @if(!empty($course['specializations']))
                                                                                    <div class="text-muted small">
                                                                                        {{ is_array($course['specializations']) ? implode(', ', $course['specializations']) : $course['specializations'] }}
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $course['duration'] ?? 'N/A' }}</td>
                                                                            <td>{{ $course['eligibility'] ?? 'Graduation' }}</td>
                                                                            <td>
                                                                                @if(!empty($course['fees']))
                                                                                    ₹{{ number_format($course['fees']) }}
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Diploma Programs -->
                                    @if(!empty($diplomaCourses))
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="diplomaHeading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                        data-bs-target="#diplomaCollapse" aria-expanded="false" 
                                                        aria-controls="diplomaCollapse">
                                                    <i class="fas fa-certificate me-2"></i> Diploma Programs
                                                </button>
                                            </h3>
                                            <div id="diplomaCollapse" class="accordion-collapse collapse" 
                                                 aria-labelledby="diplomaHeading" data-bs-parent="#coursesAccordion">
                                                <div class="accordion-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Program</th>
                                                                    <th>Duration</th>
                                                                    <th>Eligibility</th>
                                                                    <th>Fees (Total)</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($diplomaCourses as $course)
                                                                    @if(is_array($course) && !empty($course['program']))
                                                                        <tr>
                                                                            <td>
                                                                                <strong>{{ $course['program'] }}</strong>
                                                                                @if(!empty($course['specializations']))
                                                                                    <div class="text-muted small">
                                                                                        {{ is_array($course['specializations']) ? implode(', ', $course['specializations']) : $course['specializations'] }}
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $course['duration'] ?? 'N/A' }}</td>
                                                                            <td>{{ $course['eligibility'] ?? '10th/12th Pass' }}</td>
                                                                            <td>
                                                                                @if(!empty($course['fees']))
                                                                                    ₹{{ number_format($course['fees']) }}
                                                                                @else
                                                                                    N/A
                                                                                @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Other Programs -->
                                    @if(!empty($otherCourses))
                                        <div class="accordion-item">
                                            <h3 class="accordion-header" id="otherCoursesHeading">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                        data-bs-target="#otherCoursesCollapse" aria-expanded="false" 
                                                        aria-controls="otherCoursesCollapse">
                                                    <i class="fas fa-book me-2"></i> Other Programs
                                                </button>
                                            </h3>
                                            <div id="otherCoursesCollapse" class="accordion-collapse collapse" 
                                                 aria-labelledby="otherCoursesHeading" data-bs-parent="#coursesAccordion">
                                                <div class="accordion-body p-0">
                                                    <div class="table-responsive">
                                                        <table class="table table-hover mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Program</th>
                                                                    <th>Type</th>
                                                                    <th>Duration</th>
                                                                    <th>Eligibility</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @foreach($otherCourses as $course)
                                                                    @if(is_array($course) && !empty($course['program']))
                                                                        <tr>
                                                                            <td>
                                                                                <strong>{{ $course['program'] }}</strong>
                                                                                @if(!empty($course['description']))
                                                                                    <div class="text-muted small">
                                                                                        {{ $course['description'] }}
                                                                                    </div>
                                                                                @endif
                                                                            </td>
                                                                            <td>{{ $course['type'] ?? 'Certificate' }}</td>
                                                                            <td>{{ $course['duration'] ?? 'N/A' }}</td>
                                                                            <td>{{ $course['eligibility'] ?? 'Varies' }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @endforeach
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Prospectus Download -->
                                    @if(!empty($university['univ_prospectus']))
                                        <div class="mt-4 text-center">
                                            <a href="{{ asset($university['univ_prospectus']) }}" 
                                               class="btn btn-outline-primary" target="_blank" download>
                                                <i class="fas fa-download me-2"></i> Download Full Prospectus
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </section>
                    @else
                        <div class="alert alert-info mb-4">
                            <i class="fas fa-info-circle me-2"></i>
                            No course information is currently available. Please check back later or contact the university directly for more information.
                        </div>
                    @endif

                    <!-- Admission Process -->
                    @if(!empty($admission))
                        <section class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Admission Process</h2>
                            </div>
                            <div class="card-body">
                                <div class="admission-content">
                                    {!! $admission !!}
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- Eligibility Criteria -->
                    @if(!empty($eligibility) && is_array($eligibility) && count($eligibility) > 0)
                        <section class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Eligibility Criteria</h2>
                            </div>
                            <div class="card-body">
                                <div class="accordion" id="eligibilityAccordion">
                                    @foreach($eligibility as $index => $criteria)
                                        @if(!empty($criteria['title']) && !empty($criteria['description']))
                                            <div class="accordion-item">
                                                <h3 class="accordion-header" id="eligibilityHeading{{ $index }}">
                                                    <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                                            type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#eligibilityCollapse{{ $index }}" 
                                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                                            aria-controls="eligibilityCollapse{{ $index }}">
                                                        {{ $criteria['title'] }}
                                                    </button>
                                                </h3>
                                                <div id="eligibilityCollapse{{ $index }}" 
                                                     class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                                     aria-labelledby="eligibilityHeading{{ $index }}" 
                                                     data-bs-parent="#eligibilityAccordion">
                                                    <div class="accordion-body">
                                                        {!! $criteria['description'] !!}
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </section>
                    @endif

                    <!-- Placement & Internships -->
                    @if(!empty($placement) && is_array($placement) && !empty($placement['highlights']))
                        <section id="placement" class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Placement & Internships</h2>
                            </div>
                            <div class="card-body">
                                @if(!empty($placement['highlights']))
                                    <div class="mb-4">
                                        <h4 class="h6 text-primary mb-3">Placement Highlights</h4>
                                        <div class="row">
                                            @foreach($placement['highlights'] as $highlight)
                                                <div class="col-md-6 mb-3">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 text-success me-2">
                                                            <i class="fas fa-check-circle"></i>
                                                        </div>
                                                        <div>
                                                            {{ $highlight }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($placement['top_recruiters']) && is_array($placement['top_recruiters']))
                                    <div class="mb-4">
                                        <h4 class="h6 text-primary mb-3">Top Recruiters</h4>
                                        <div class="row g-3">
                                            @foreach($placement['top_recruiters'] as $recruiter)
                                                @if(!empty($recruiter['logo']))
                                                    <div class="col-4 col-md-3">
                                                        <div class="bg-white p-2 border rounded text-center" style="height: 80px;">
                                                            <img src="{{ asset('storage/' . $recruiter['logo']) }}" 
                                                                 alt="{{ $recruiter['name'] ?? 'Recruiter Logo' }}" 
                                                                 class="img-fluid h-100" 
                                                                 style="object-fit: contain;">
                                                        </div>
                                                        @if(!empty($recruiter['name']))
                                                            <div class="small text-center mt-1">{{ $recruiter['name'] }}</div>
                                                        @endif
                                                    </div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if(!empty($placement['statistics']) && is_array($placement['statistics']))
                                    <div class="mt-4">
                                        <h4 class="h6 text-primary mb-3">Placement Statistics</h4>
                                        <div class="row">
                                            @foreach($placement['statistics'] as $stat)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card h-100 border-0 shadow-sm">
                                                        <div class="card-body text-center">
                                                            <div class="display-6 text-primary fw-bold mb-1">{{ $stat['value'] ?? 'N/A' }}</div>
                                                            <div class="text-muted small">{{ $stat['label'] ?? '' }}</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    <!-- Career Guidance -->
                    @if(!empty($careerGuidance) && is_array($careerGuidance) && !empty($careerGuidance['services']))
                        <section id="career-guidance" class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Career Guidance & Support</h2>
                            </div>
                            <div class="card-body">
                                @if(!empty($careerGuidance['services']))
                                    <div class="row">
                                        @foreach($careerGuidance['services'] as $service)
                                            <div class="col-md-6 mb-4">
                                                <div class="d-flex h-100">
                                                    <div class="flex-shrink-0 text-primary me-3 mt-1">
                                                        <i class="fas {{ $service['icon'] ?? 'fa-check-circle' }} fa-lg"></i>
                                                    </div>
                                                    <div>
                                                        <h5 class="h6 mb-2">{{ $service['title'] ?? '' }}</h5>
                                                        <p class="small text-muted mb-0">{{ $service['description'] ?? '' }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif

                                @if(!empty($careerGuidance['testimonials']) && is_array($careerGuidance['testimonials']))
                                    <div class="mt-4">
                                        <h4 class="h6 text-primary mb-3">Student Testimonials</h4>
                                        <div class="row">
                                            @foreach($careerGuidance['testimonials'] as $testimonial)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card h-100">
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center mb-3">
                                                                @if(!empty($testimonial['image']))
                                                                    <img src="{{ asset('storage/' . $testimonial['image']) }}" 
                                                                         alt="{{ $testimonial['name'] ?? 'Student' }}" 
                                                                         class="rounded-circle me-3" 
                                                                         width="50" 
                                                                         height="50">
                                                                @endif
                                                                <div>
                                                                    <div class="fw-bold">{{ $testimonial['name'] ?? 'Anonymous' }}</div>
                                                                    <div class="text-muted small">{{ $testimonial['position'] ?? 'Student' }}</div>
                                                                </div>
                                                            </div>
                                                            <p class="mb-0">"{{ $testimonial['testimonial'] ?? '' }}"</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </section>
                    @endif

                    <!-- Scholarships & Financial Aid -->
                    @if(!empty($university['univ_scholarship']))
                        <?php $scholarships = json_decode($university['univ_scholarship'], true); ?>
                        @if(is_array($scholarships) && count($scholarships) > 0)
                            <section id="scholarships" class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h2 class="h5 mb-0">Scholarships & Financial Aid</h2>
                                </div>
                                <div class="card-body">
                                    <div class="accordion" id="scholarshipAccordion">
                                        @foreach($scholarships as $index => $scholarship)
                                            @if(!empty($scholarship['name']) && !empty($scholarship['description']))
                                                <div class="accordion-item">
                                                    <h3 class="accordion-header" id="scholarshipHeading{{ $index }}">
                                                        <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }}" 
                                                                type="button" 
                                                                data-bs-toggle="collapse" 
                                                                data-bs-target="#scholarshipCollapse{{ $index }}" 
                                                                aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                                                aria-controls="scholarshipCollapse{{ $index }}">
                                                            {{ $scholarship['name'] }}
                                                            @if(!empty($scholarship['amount']))
                                                                <span class="badge bg-success ms-2">Up to {{ $scholarship['amount'] }}</span>
                                                            @endif
                                                        </button>
                                                    </h3>
                                                    <div id="scholarshipCollapse{{ $index }}" 
                                                         class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}" 
                                                         aria-labelledby="scholarshipHeading{{ $index }}" 
                                                         data-bs-parent="#scholarshipAccordion">
                                                        <div class="accordion-body">
                                                            <div class="mb-3">
                                                                {!! $scholarship['description'] !!}
                                                            </div>
                                                            @if(!empty($scholarship['eligibility']))
                                                                <h6 class="text-primary">Eligibility Criteria:</h6>
                                                                <ul class="mb-3">
                                                                    @foreach(explode('\n', $scholarship['eligibility']) as $criteria)
                                                                        <li>{{ trim($criteria) }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            @endif
                                                            @if(!empty($scholarship['application_deadline']))
                                                                <p class="mb-0">
                                                                    <strong>Application Deadline:</strong> 
                                                                    {{ $scholarship['application_deadline'] }}
                                                                </p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endif

                    <!-- Campus Facilities -->
                    @if(!empty($university['univ_facilities']))
                        <?php $facilities = json_decode($university['univ_facilities'], true); ?>
                        @if(is_array($facilities) && count($facilities) > 0)
                            <section id="facilities" class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h2 class="h5 mb-0">Campus Facilities</h2>
                                </div>
                                <div class="card-body">
                                    <div class="row g-4">
                                        @foreach($facilities as $facility)
                                            @if(!empty($facility['name']))
                                                <div class="col-md-6">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 text-primary me-3">
                                                            <i class="fas {{ $facility['icon'] ?? 'fa-check-circle' }} fa-2x"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="h6 mb-1">{{ $facility['name'] }}</h5>
                                                            @if(!empty($facility['description']))
                                                                <p class="small text-muted mb-0">{{ $facility['description'] }}</p>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                            </section>
                        @endif
                    @endif

                    <!-- FAQ Section -->
                    <section id="faq" class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h2 class="h5 mb-0">Frequently Asked Questions</h2>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="faqAccordion">
                                <!-- Admission FAQs -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="admissionFaqHeading">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#admissionFaqCollapse" aria-expanded="true" 
                                                aria-controls="admissionFaqCollapse">
                                            Admission Related Queries
                                        </button>
                                    </h3>
                                    <div id="admissionFaqCollapse" class="accordion-collapse collapse show" 
                                         aria-labelledby="admissionFaqHeading" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <h6>What are the admission requirements for international students?</h6>
                                                <p class="mb-0">
                                                    International students need to submit their academic transcripts, proof of English 
                                                    proficiency (TOEFL/IELTS), passport copy, and other relevant documents. Please check 
                                                    our international admissions page for detailed requirements.
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>When does the application process begin?</h6>
                                                <p class="mb-0">
                                                    The application process typically begins in January for the fall semester and in 
                                                    September for the spring semester. Please check our academic calendar for specific dates.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Course FAQs -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="courseFaqHeading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#courseFaqCollapse" aria-expanded="false" 
                                                aria-controls="courseFaqCollapse">
                                            Course & Program Queries
                                        </button>
                                    </h3>
                                    <div id="courseFaqCollapse" class="accordion-collapse collapse" 
                                         aria-labelledby="courseFaqHeading" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <h6>Can I change my major after being admitted?</h6>
                                                <p class="mb-0">
                                                    Yes, you can change your major after completing at least one semester at the university. 
                                                    You'll need to meet with an academic advisor and submit a change of major request form.
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>Are there online course options available?</h6>
                                                <p class="mb-0">
                                                    Yes, we offer a variety of online courses and degree programs. Please check our online 
                                                    learning section for available programs and courses.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Scholarship FAQs -->
                                <div class="accordion-item">
                                    <h3 class="accordion-header" id="scholarshipFaqHeading">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" 
                                                data-bs-target="#scholarshipFaqCollapse" aria-expanded="false" 
                                                aria-controls="scholarshipFaqCollapse">
                                            Scholarship & Financial Aid
                                        </button>
                                    </h3>
                                    <div id="scholarshipFaqCollapse" class="accordion-collapse collapse" 
                                         aria-labelledby="scholarshipFaqHeading" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <div class="mb-3">
                                                <h6>How do I apply for scholarships?</h6>
                                                <p class="mb-0">
                                                    You can apply for scholarships through our online portal. Make sure to submit all required 
                                                    documents before the deadline. Some scholarships may require separate applications.
                                                </p>
                                            </div>
                                            <div class="mb-3">
                                                <h6>When will I know if I've been awarded a scholarship?</h6>
                                                <p class="mb-0">
                                                    Scholarship decisions are typically made within 4-6 weeks after the application deadline. 
                                                    You will be notified via email if you are selected for a scholarship.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <!-- Important Dates -->
                    @if(!empty($importantDates) && is_array($importantDates) && count($importantDates) > 0)
                        <section id="dates" class="card shadow-sm mb-4">
                            <div class="card-header bg-light">
                                <h2 class="h5 mb-0">Important Dates</h2>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Event</th>
                                                <th>Start Date</th>
                                                <th>End Date</th>
                                                <th>Description</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($importantDates as $date)
                                                @if(isset($date['event']) && (isset($date['start_date']) || isset($date['end_date'])))
                                                    <tr>
                                                        <td>{{ $date['event'] ?? 'N/A' }}</td>
                                                        <td>{{ $date['start_date'] ?? 'N/A' }}</td>
                                                        <td>{{ $date['end_date'] ?? 'N/A' }}</td>
                                                        <td>{{ $date['description'] ?? '' }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
                <!-- End of main content column -->

                <!-- Sidebar -->
                <div class="col-12 col-lg-4">
                    <!-- Quick Links -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h3 class="h6 mb-0">Quick Links</h3>
                        </div>
                        <div class="list-group list-group-flush">
                            <a href="#about" class="list-group-item list-group-item-action">About University</a>
                            @if(!empty($popularCourses))<a href="#courses" class="list-group-item list-group-item-action">Popular Courses</a>@endif
                            @if(!empty($admission))<a href="#admission" class="list-group-item list-group-item-action">Admission Process</a>@endif
                            @if(!empty($eligibility))<a href="#eligibility" class="list-group-item list-group-item-action">Eligibility Criteria</a>@endif
                            @if(!empty($importantDates))<a href="#dates" class="list-group-item list-group-item-action">Important Dates</a>@endif
                            @if(!empty($placement))<a href="#placement" class="list-group-item list-group-item-action">Placement</a>@endif
                        </div>
                    </div>

                    <!-- Contact Information -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-light">
                            <h3 class="h6 mb-0">Contact Information</h3>
                        </div>
                        <div class="card-body">
                            @if(!empty($university['univ_address']))
                                <p class="mb-3">
                                    <i class="fas fa-map-marker-alt me-2 text-primary"></i>
                                    {{ $university['univ_address'] }}
                                </p>
                            @endif
                            
                            @if(!empty($university['univ_phone']))
                                <p class="mb-3">
                                    <i class="fas fa-phone me-2 text-primary"></i>
                                    <a href="tel:{{ $university['univ_phone'] }}" class="text-decoration-none">
                                        {{ $university['univ_phone'] }}
                                    </a>
                                </p>
                            @endif
                            
                            @if(!empty($university['univ_email']))
                                <p class="mb-3">
                                    <i class="fas fa-envelope me-2 text-primary"></i>
                                    <a href="mailto:{{ $university['univ_email'] }}" class="text-decoration-none">
                                        {{ $university['univ_email'] }}
                                    </a>
                                </p>
                            @endif
                            
                            @if(!empty($university['univ_website']))
                                <p class="mb-0">
                                    <i class="fas fa-globe me-2 text-primary"></i>
                                    <a href="{{ $university['univ_website'] }}" target="_blank" class="text-decoration-none">
                                        Visit Website
                                    </a>
                                </p>
                            @endif
                        </div>
                    </div>

                    <!-- University Gallery -->
                    @if(!empty($university['univ_gallery']))
                        <?php $gallery = json_decode($university['univ_gallery'], true); ?>
                        @if(is_array($gallery) && count($gallery) > 0)
                            <div class="card shadow-sm mb-4">
                                <div class="card-header bg-light">
                                    <h3 class="h6 mb-0">Campus Gallery</h3>
                                </div>
                                <div class="card-body">
                                    <div class="row g-2">
                                        @foreach(array_slice($gallery, 0, 6) as $image)
                                            <div class="col-4">
                                                <a href="{{ asset('storage/' . $image) }}" data-lightbox="university-gallery" class="d-block">
                                                    <img src="{{ asset('storage/' . $image) }}" 
                                                         alt="Campus Image {{ $loop->iteration }}" 
                                                         class="img-fluid rounded shadow-sm">
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                    @if(count($gallery) > 6)
                                        <div class="text-center mt-2">
                                            <a href="#" class="btn btn-sm btn-outline-primary">View All Photos</a>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
                <!-- End of sidebar column -->
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