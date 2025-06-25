@php
    $pageTitle = $page_title ?? 'Course Details';
    $university = $university ?? [];
    $course = $course ?? [];
    $univSlug = $university['univ_slug'] ?? '';
    $courseSlug = $course['course_slug'] ?? '';
@endphp

<div class="container hero-content mt-3">
    <div class="row">
        <div class="col">
            <p class="display-4" style="font-size: 1.6rem; font-weight: 400;">{{ $pageTitle }}</p>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('/') }}">
                            <i class="fa-solid fa-home blue pe-2"></i>
                            Home
                        </a>
                    </li>
                    @if(!empty($university) && !empty($univSlug))
                        <li class="breadcrumb-item">
                            <a href="{{ url('university/' . $univSlug) }}">
                                {{ $university['univ_name'] ?? 'University' }}
                            </a>
                        </li>
                    @endif
                    @if(!empty($course) && !empty($courseSlug))
                        <li class="breadcrumb-item">
                            <a href="{{ url('course/' . $courseSlug) }}">
                                {{ $course['course_name'] ?? 'Course' }}
                            </a>
                        </li>
                    @endif
                    <li class="breadcrumb-item active" aria-current="page">{{ $pageTitle }}</li>
                </ol>
            </nav>
        </div>
    </div>
</div>
