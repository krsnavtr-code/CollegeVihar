@php
$page_title = 'Scholarship Exam Details';
@endphp

@extends('user.info.layout')

@push('css')
    <style>
        .scholarship-header {
            margin: 20px 0;
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
            padding: 15px 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .scholarship-header .scholarship-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .scholarship-header .scholarship-nav-item {
            margin-right: 20px;
        }

        .scholarship-header .scholarship-nav-link {
            font-size: 2rem;
            color: #007bff;
            cursor: pointer;
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            transition: color 0.3s, border-bottom 0.3s;
            border-radius: 5px;
        }

        .scholarship-header .scholarship-nav-link:hover {
            color: #0056b3;
        }

        .scholarship-header .scholarship-nav-link.active {
            color: #0056b3;
            font-weight: bold;
            border-bottom: 2px solid #0056b3;
        }

        .scholarship-details-container {
            margin: 20px auto;
            max-width: 80%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            color: #333;
            border: 1px solid #ddd;
        }

        .scholarship-details-container .section-title {
            text-align: center;
            font-weight: bold;
            margin-top: -36px;
            color: #F26522;
            font-size: 25px;
            font-family: 'Georgia', serif;
        }

        .scholarship-details-container p {
            font-size: 1.7rem;
            line-height: 1.6;
            margin-bottom: 15px;
            text-align: justify;
            font-family: 'Georgia', serif;
        }

        .scholarship-details-container .highlight {
            color: #303f9f;
            font-weight: bold;
        }

        .videos-list {
            list-style-type: none;
            padding: 0;
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 20px;
        }

        .videos-list li {
            margin-bottom: 20px;
            flex: 1;
            max-width: 300px;
            transition: transform 0.3s ease;
        }

        .videos-list iframe {
            width: 100%;
            height: 200px;
            border: 1px solid #0056d2;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .videos-list li.active iframe {
            width: 100%;
            height: 400px;
        }

        .scholarship-syllabus ul {
            padding-left: 20px;
            list-style-type: disc;
        }

        .scholarship-syllabus li {
            margin-bottom: 5px;
            font-size: 1.8rem;
        }

        .scholarship-section {
            display: block; /* Display all sections initially */
            background: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin-top: 20px;
            color: #333;
        }

        #videos {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        /* Questions & Answers Section */
        .qa-item {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .qa-item .question {
            font-weight: bold;
            padding: 15px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Georgia', serif;
        }

        .qa-item .answer {
            display: none;
            padding: 15px;
            border-top: 1px solid #ccc;
            font-family: 'Georgia', serif;
        }

        .qa-item .question:hover {
            background: #f5f5f5;
        }

        .qa-item .question:after {
            content: '+';
            font-size: 20px;
        }

        .qa-item .question.active:after {
            content: '-';
        }

        /* Mock Test Section */
        .mocktest-item {
            background: #fff;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            overflow: hidden;
        }

        .mocktest-item .question {
            font-weight: bold;
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-family: 'Georgia', serif;
        }

        .mocktest-item .answer {
            padding: 15px;
            border-top: 1px solid #ccc;
            font-family: 'Georgia', serif;
        }
    </style>
@endpush

@section('main_section')
<main>
    <div class="scholarship-header">
        <ul class="scholarship-nav" id="scholarshipTab" role="tablist">
            <li class="scholarship-nav-item">
                <a class="scholarship-nav-link" href="#exam-info" id="info" onclick="showSection('exam-info')">Examination Info</a>
            </li>
            <li class="scholarship-nav-item">
                <a class="scholarship-nav-link" href="#videos" onclick="showSection('videos')">Videos</a>
            </li>
            <li class="scholarship-nav-item">
                <a class="scholarship-nav-link" href="#questions-answers" onclick="showSection('questions-answers')">Questions & Answers</a>
            </li>
            <li class="scholarship-nav-item">
                <a class="scholarship-nav-link" href="#syllabus" onclick="showSection('syllabus')">Syllabus</a>
            </li>
            <li class="scholarship-nav-item">
                <a class="scholarship-nav-link" href="#mock-test" onclick="showSection('mock-test')">Mock Test</a>
            </li>
        </ul>
    </div>

    <div class="scholarship-details-container">
        <div id="exam-info" class="scholarship-section">
            <!-- <h6 class="section-title">Exam Info</h6> -->
            <p>{!! $scholarship->scholarship_info !!}</p>
            <tes class="section-title">Important Dates</h6>
            <p>Opening Date: <span class="highlight">{{ \Carbon\Carbon::parse($scholarship->exam_opening_date)->format('d-M-Y h:i A') }}</span></p>
            <p>Closing Date: <span class="highlight">{{ \Carbon\Carbon::parse($scholarship->exam_closing_date)->format('d-M-Y h:i A') }}</span></p>
        </div>
        
        <div id="videos" class="scholarship-section">
            <!-- <h6 class="section-title">Videos</h6> -->
            <ul class="videos-list">
                @php 
                    $videos = json_decode($scholarship->videos);
// dd($videos);
                @endphp
                {{-- @foreach($videos as $video)
                    <li onclick="expandVideo(this)">
                        <iframe src="https://www.youtube.com/embed/{{ preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video, $matches) ? $matches[2] : '' }}" allowfullscreen></iframe>
                    </li>
                @endforeach --}}
                @if ($videos)
                    @foreach($videos as $video)
                    @php
        // Determine if the item is an object or a plain URL
        $videoUrl = is_object($video) ? $video->video_url ?? '' : $video;
        $thumbnailUrl = is_object($video) ? $video->thumbnail_url ?? '' : "https://img.youtube.com/vi/" . preg_replace('/.*(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+).*/', '$2', $videoUrl) . "/maxresdefault.jpg";
                    @endphp

                    @if (!empty($videoUrl))
                        <li>
                            <!-- Thumbnail Link -->
                            <!-- <a class="uk-inline" href="{{ $videoUrl }}">
                                <img src="{{ $thumbnailUrl }}" style="width: 300px; height: 200px;">
                            </a> -->

                            <!-- Embedded YouTube Video -->
                            <a data-type="iframe" class="uk-inline" data-caption="Video"
                                href="https://www.youtube.com/embed/{{ preg_replace('/.*(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+).*/', '$2', $videoUrl) }}">
                                <iframe src="https://www.youtube.com/embed/{{ preg_replace('/.*(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+).*/', '$2', $videoUrl) }}" allowfullscreen></iframe>
                            </a>
                        </li>
                    @endif
                    @endforeach
                @else
                    <li>No videos available.</li>
                @endif
            </ul>
        </div>

        <div id="questions-answers" class="scholarship-section">
            <!-- <h6 class="section-title">Questions & Answers</h6> -->
            @php
$questions = json_decode($scholarship->questions);
$answers = json_decode($scholarship->answers);
            @endphp
            @if($questions && $answers)
                @foreach($questions as $index => $question)
                    <div class="qa-item">
                        <div class="question" onclick="toggleAnswer(this)">Q{{ $index + 1 }}: {!! nl2br(e($question)) !!}</div>
                        <div class="answer">A{{ $index + 1 }}: {!! nl2br(e($answers[$index])) !!}</div>
                    </div>
                @endforeach
            @endif
        </div>

        <div id="syllabus" class="scholarship-section scholarship-syllabus">
            <!-- <h6 class="section-title">Syllabus</h6> -->
            {!! $scholarship->scholarship_syllabus !!}
        </div>
        
        <div id="mock-test" class="scholarship-section">
            <!-- <h6 class="section-title">Mock Test</h6> -->
            @php
$mockTestQuestions = json_decode($scholarship->mock_test_questions);
$mockTestAnswers = json_decode($scholarship->mock_test_answers);
            @endphp
            @if($mockTestQuestions && $mockTestAnswers)
                @foreach($mockTestQuestions as $index => $question)
                    <div class="mocktest-item">
                        <div class="question">Q{{ $index + 1 }}: {!! nl2br(e($question)) !!}</div>
                        <div class="answer">A{{ $index + 1 }}: {!! nl2br(e($mockTestAnswers[$index])) !!}</div>
                    </div>
                    <div style="margin-bottom: 20px;"></div>
                @endforeach
            @else
                <p>No mock test questions available.</p>
            @endif
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    function toggleAnswer(element) {
        const answer = element.nextElementSibling;
        const isActive = element.classList.contains('active');

        document.querySelectorAll('.qa-item .answer').forEach(ans => {
            ans.style.display = 'none';
            ans.previousElementSibling.classList.remove('active');
        });

        if (!isActive) {
            element.classList.add('active');
            answer.style.display = 'block';
        }
    }

    function showSection(sectionId) {
        event.preventDefault();
        const sections = document.querySelectorAll('.scholarship-section');
        sections.forEach(section => section.style.display = 'none');
        const targetSection = document.getElementById(sectionId);
        if (targetSection) {
            targetSection.style.display = 'block';
        }
        const navLinks = document.querySelectorAll('.scholarship-nav-link');
        navLinks.forEach(navLink => navLink.classList.remove('active'));
        const clickedNavLink = document.querySelector(`a[href="#${sectionId}"]`);
        if (clickedNavLink) {
            clickedNavLink.classList.add('active');
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('info').click();
    });

    function expandVideo(element) {
        document.querySelectorAll('.videos-list li').forEach(item => {
            item.classList.remove('active');
            item.querySelector('iframe').style.height = '200px';
        });

        element.classList.add('active');
        element.querySelector('iframe').style.height = '400px';
    }
</script>
@endpush
