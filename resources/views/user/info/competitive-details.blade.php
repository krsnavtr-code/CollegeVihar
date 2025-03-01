@php
$page_title = 'Competitive Exam Details';
@endphp

@extends('user.info.layout')

@push('css')
    <style>
        .competitive-header {
            /* margin: 20px 0; */
            border-bottom: 1px solid #ddd;
            display: flex;
            justify-content: center;
            align-items: center;
            background: #f5f5f5;
            /* padding: 15px 10px; */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        .competitive-header .competitive-nav {
            display: flex;
            justify-content: center;
            align-items: center;
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .competitive-header .competitive-nav-item {
            margin-right: 10px;
        }

        .competitive-header .competitive-nav-link {
            font-size: 1.1rem;
            color: #007bff;
            cursor: pointer;
            display: inline-block;
            padding: 10px;
            text-decoration: none;
            transition: color 0.3s, border-bottom 0.3s;
            border-radius: 5px;
        }

        .competitive-header .competitive-nav-link:hover {
            color: #0056b3;
        }

        .competitive-header .competitive-nav-link.active {
            color: #0056b3;
            font-weight: bold;
            border-bottom: 2px solid #0056b3;
        }

        .competitive-details-container {
            margin: 20px auto;
            max-width: 80%;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            color: #333;
            border: 1px solid #ddd;
        }

        .competitive-details-container .section-title {
            text-align: center;
            margin-top: -36px;
            color: #F26522;
            font-size: 1.3rem;
            font-weight: bold;
            font-family: 'Georgia', serif;
        }

        .competitive-details-container p {
            font-size: 0.8rem;
            /* line-height: 1.6; */
            margin-bottom: 5px;
            text-align: justify;
            font-family: 'Georgia', serif;
        }

        .competitive-details-container .highlight {
            color: #303f9f;
            font-weight: bold;
        }

        .title-dates {
            font-size: 1.2rem;
        }

        .exam-info-title {
            text-align: center;
            font-weight: bold;
            margin: auto;
            color: #F26522;
            font-size: 1.3rem;
            font-weight: bold;
            font-family: 'Georgia', serif;
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

        .competitive-syllabus ul {
            padding-left: 20px;
            list-style-type: disc;
        }

        .competitive-syllabus li {
            margin-bottom: 5px;
            font-size: 1.2rem;
        }

        .competitive-section {
            display: block;
            /* Display all sections initially */
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

        /* Syllabus */
        .pagination-controls {
            margin-top: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .pagination-controls button {
            padding: 8px 15px;
            background: #007bff;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }

        .pagination-controls button:disabled {
            background: #ccc;
            cursor: not-allowed;
        }

        /* Syllabus List Styling */
        .syllabus-item {
            background: #f9f9f9;
            padding: 9px 20px;
            margin: 8px 0;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 500;
            color: #333;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.1s ease-in-out;
        }

        /* Hover Effect */
        .syllabus-item:hover {
            background: #007bff;
            color: white;
            transform: scale(1.01);
        }

        #syllabus-content p:nth-child(1) {
            text-align: center;
            margin-top: -36px;
            color: #F26522;
            font-size: 1.3rem;
            font-weight: bold;
            font-family: 'Georgia', serif;
            background-color: white;
            box-shadow: none;
            transition: none;
        }

        /* First Line Special Styling */
        .syllabus-first-line {
            text-align: center;
            margin-top: -36px;
            color: #F26522;
            font-size: 1.3rem;
            font-weight: bold;
            font-family: 'Georgia', serif;
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
        @media screen and (max-width: 768px) {
            .competitive-header .competitive-nav {
                flex-direction: column;
            }

        }
    </style>
@endpush

@section('main_section')
                <main>
                    {{--
                    <link rel="stylesheet" href="venobox/venobox.min.css" type="text/css" media="screen" /> --}}

                    <div class="competitive-header">
                        <ul class="competitive-nav" id="competitiveTab" role="tablist">
                            <li class="competitive-nav-item">
                                <a class="competitive-nav-link" href="#exam-info" id="info"
                                    onclick="showSection('exam-info')">Examination
                                    Info</a>
                            </li>
                            <li class="competitive-nav-item">
                                <a class="competitive-nav-link" href="#videos" onclick="showSection('videos')">Videos</a>
                            </li>
                            <li class="competitive-nav-item">
                                <a class="competitive-nav-link" href="#questions-answers"
                                    onclick="showSection('questions-answers')">Questions & Answers</a>
                            </li>
                            <li class="competitive-nav-item">
                                <a class="competitive-nav-link" href="#syllabus" onclick="showSection('syllabus')">Syllabus</a>
                            </li>
                            <li class="competitive-nav-item">
                                <a class="competitive-nav-link" href="#mock-test" onclick="showSection('mock-test')">Mock Test</a>
                            </li>
                        </ul>
                    </div>

                    <div class="competitive-details-container">
                        <!-- Examination Info -->
                        <div id="exam-info" class="competitive-section">
                            <!-- <h6 class="section-title">Examination Info</h6> -->
                            <p>{!! $competitive->exam_info !!}</p>
                            <p class="exam-info-title">Eligibility Criteria</p>
                            <!-- <p>{!! $competitive->eligibility_criteria !!}</p> -->
                            <p>Demo text - Lorem ipsum dolor sit, amet consectetur adipisicing elit. Adipisci, totam?</p>
                            <p class="exam-info-title">Salary: <span style="color: #333333"><span>&#8377;</span> 25000</span></p>
                            <p class="exam-info-title">Important Date</p>
                            <p class="title-dates">Starting Date: <span
                                    class="highlight">{{ \Carbon\Carbon::parse($competitive->exam_opening_date)->format('d-M-Y h:i A') }}</span>
                            </p>
                            <!-- <p class="title-dates">Closing Date: <span
                                                                                            class="highlight">{{ \Carbon\Carbon::parse($competitive->exam_closing_date)->format('d-M-Y h:i A') }}</span>
                                                                                    </p> -->
                            <p class="title-dates">
                                Closing Date:
                                <span class="highlight">
                                    @php
$closingDate = \Carbon\Carbon::parse($competitive->exam_closing_date);
                                    @endphp

                                    @if ($closingDate->isPast())
                                        Job Expired
                                    @else


                                        {{ $closingDate->format('d-M-Y h:i A') }}
                                    @endif


                                </span>
                            </p>
                            <!-- <h6 class="section-title">Exam Info</h6> -->
                        </div>

                        <!-- Video -->
                        <div id="videos" class="competitive-section">
                            <!-- <h6 class="section-title">Videos</h6> -->
                            <div id="animated-thumbnails">
                                <ul class="videos-list" uk-lightbox="animation: slide">
                                    @php
$videos = json_decode($competitive->videos);
// dd($videos);
                                    @endphp
                                    {{-- @foreach($videos as $video)
                                    <li>
                                        <a class="uk-inline" href="https://youtu.be/yDahPvYYxbU?si=D0hIxZlWJ8ZNshTg">
                                            <img
                                                src="https://images.pexels.com/photos/16310530/pexels-photo-16310530/free-photo-of-yard-in-traditional-stone-and-wooden-house.jpeg">
                                        </a>
                                        <a data-type="iframe" class="uk-inline" data-caption="Caption 1"
                                            href="https://www.youtube.com/embed/{{  preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video, $matches) ? $matches[2] : '' }}">
                                            <iframe
                                                src="https://www.youtube.com/embed/{{ preg_match('/(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+)/', $video, $matches) ? $matches[2] : '' }}"></iframe>
                                        </a>
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
                                                                            <a target="_blank" data-type="iframe" class="uk-inline" data-caption="Video"
                                                                                href="https://www.youtube.com/embed/{{ preg_replace('/.*(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+).*/', '$2', $videoUrl) }}">
                                                                                <iframe
                                                                                    src="https://www.youtube.com/embed/{{ preg_replace('/.*(youtube\.com\/watch\?v=|youtu\.be\/)([^&]+).*/', '$2', $videoUrl) }}"
                                                                                    allowfullscreen></iframe>
                                                                            </a>
                                                                        </li>
                                                                    @endif


                                                    @endforeach
                                    @else


                                        <li>No videos available.</li>
                                    @endif


                                </ul>
                                <!-- ye chal raha -->
                                {{-- <div class="uk-child-width-1-3@m" uk-grid uk-lightbox="animation: slide">
                                    <div>
                                        <a class="uk-inline"
                                            href="https://images.pexels.com/photos/16310530/pexels-photo-16310530/free-photo-of-yard-in-traditional-stone-and-wooden-house.jpeg">
                                            <img
                                                src="https://images.pexels.com/photos/16310530/pexels-photo-16310530/free-photo-of-yard-in-traditional-stone-and-wooden-house.jpeg">
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline"
                                            href="https://images.pexels.com/photos/22027141/pexels-photo-22027141/free-photo-of-farmer-in-hat-sitting-on-field.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                                            <img
                                                src="https://images.pexels.com/photos/22027141/pexels-photo-22027141/free-photo-of-farmer-in-hat-sitting-on-field.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1">
                                        </a>
                                    </div>
                                    <div>
                                        <a class="uk-inline"
                                            href="https://images.pexels.com/photos/12646557/pexels-photo-12646557.jpeg">
                                            <img src="https://images.pexels.com/photos/12646557/pexels-photo-12646557.jpeg">
                                        </a>
                                    </div>

                                </div> --}}


                            </div>
                        </div>

                        <!-- Questions & Answers -->
                        <div id="questions-answers" class="competitive-section">
                            <!-- <h6 class="section-title">Questions & Answers</h6> -->
                            @php
$questions = json_decode($competitive->questions);
$answers = json_decode($competitive->answers);
                            @endphp
                            @if($questions && $answers)
                                @foreach($questions as $index => $question)
                                                                                                            <div class="qa-item">
                                        <div class="question" onclick="toggleAnswer(this)">Q{{ $index + 1 }}: {!!
            nl2br(e($question)) !!}</div>
                                        <div class="answer">A{{ $index + 1 }}: {!! nl2br(e($answers[$index])) !!}</div>
                                    </div>
                                @endforeach
                            @endif


                        </div>

                        <!-- Syllabus Section in One page -->
                        <!-- <div id="syllabus" class="competitive-section competitive-syllabus">
                                                                                    <h6 class="section-title">Syllabus</h6>
                                                                                    {!! $competitive->exam_syllabus !!}
                                                                                </div> -->
                        <!-- Syllabus Section in multiple pages-->
                        <div id="syllabus" class="competitive-section competitive-syllabus">
                            <!-- Page Navigation -->
                            @php
// $syllabus_lines = explode("\n", strip_tags($competitive->exam_syllabus)); // Content into array line-wise
$syllabus_text = html_entity_decode(strip_tags($competitive->exam_syllabus));
$syllabus_text = str_replace(["•", "&bull;", "&nbsp;"], "", $syllabus_text);
$syllabus_lines = explode("\n", $syllabus_text);
$total_lines = count($syllabus_lines);
$lines_per_page = 15; // Ek page par 15 lines
$total_pages = ceil($total_lines / $lines_per_page);
                            @endphp
                            <!-- Syllabus Pagination Script -->
                            <script>
                                let currentPage = 1;
                                const totalPages = {{ $total_pages }};
                                const linesPerPage = {{ $lines_per_page }};
                                const syllabusLines = @json($syllabus_lines);
                                const totalLines = {{ $total_lines }};

                                function changePage(change) {
                                    currentPage += change;
                                    let syllabusContent = document.getElementById('syllabus-content');
                                    syllabusContent.innerHTML = ''; // Purana content clear karo

                                    for (let i = (currentPage - 1) * linesPerPage; i < Math.min(currentPage * linesPerPage, totalLines); i++) {
                                        let p = document.createElement("p");
                                        p.textContent = syllabusLines[i];

                                        // **Agar yeh first line hai, toh alag CSS do**
                                        if (i === (currentPage - 1) * linesPerPage) {
                                            p.classList.add("syllabus-first-line");
                                        } else {
                                            p.classList.add("syllabus-item");
                                        }

                                        syllabusContent.appendChild(p);
                                    }

                                    // Page Number Update Karo
                                    document.getElementById('page-info').innerText = `Page ${currentPage} of ${totalPages}`;

                                    // Previous/Next Button Enable/Disable
                                    document.getElementById('prev-btn').disabled = currentPage === 1;
                                    document.getElementById('next-btn').disabled = currentPage === totalPages;
                                }
                            </script>

                            <!-- Syllabus Content -->
                            <div id="syllabus-content">
                                @for ($i = 0; $i < min($lines_per_page, $total_lines); $i++)
                                    <p class="syllabus-item">{{ $syllabus_lines[$i] }}</p>
                                @endfor
                            </div>
                            <!-- Syllabus Pagination Buttons -->
                            <div class="pagination-controls">
                                <button id="prev-btn" onclick="changePage(-1)" disabled>Previous</button>
                                <span id="page-info">Page 1 of {{ $total_pages }}</span>
                                <button id="next-btn" onclick="changePage(1)">Next</button>
                            </div>
                        </div>


                        <!-- Mock Test -->
                        <div id="mock-test" class="competitive-section">
                            <!-- <h6 class="section-title">Mock Test</h6> -->
                            <!-- @php
                                                                                        $mockTestQuestions = json_decode($competitive->mock_test_questions);
                                                                                        $mockTestAnswers = json_decode($competitive->mock_test_answers);
                                                                                    @endphp -->
                            <!-- @if($mockTestQuestions && $mockTestAnswers)
                                                                                        @foreach($mockTestQuestions as $index => $question)
                                                                                            <div class="mocktest-item">
                                                                                                <div class="question">Q{{ $index + 1 }}: {!! nl2br(e($question)) !!}</div>
                                                                                                <div class="answer">A{{ $index + 1 }}: {!! nl2br(e($mockTestAnswers[$index])) !!}</div>
                                                                                            </div>
                                                                                            <div style="margin-bottom: 20px;"></div>
                                                                                        @endforeach
                                                                                    @else
                                                                                        <p>No mock test questions available.</p>
                                                                                    @endif  -->
                            <!-- Mock Test Section in One page -->

                            <div class="guidelines-container text-center">
                                <h2 class="mb-3">Guidelines</h2>
                                @foreach($mockTests as $mockTest)
                                <ul class="list-group text-start">
                                    <li class="list-group-item">All questions are mandatory and there is no negative marking.</li>
                                    <li class="list-group-item">Duration: {{ $mockTest->test_duration }} minutes</li>
                                    <li class="list-group-item">Total Questions: <?php echo "27"; ?></li>
                                    <li class="list-group-item">Question Type: MCQ</li>
                                </ul>
                                @endforeach
                                <h4 class="mt-4">Disclaimer</h4>
                                <ul class="list-group text-start">
                                    <li class="list-group-item">Read the question carefully.</li>
                                    <li class="list-group-item">Select the best answer from the provided options.</li>
                                    <li class="list-group-item">Ensure you have a stable Internet connection.</li>
                                    <li class="list-group-item">After selecting your answer, click on the "Submit" button.</li>
                                </ul>
                                @foreach($mockTests as $mockTest)
                                    <a href="{{ route('quizzes.start', $mockTest->id) }}" class="btn btn-primary mt-3">
                                      Start Your Test
                                    </a>
                                    @endforeach
                            </div>
                        </div>
                    </div>
                </main>
@endsection

@push('script')

    {{--
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.21.8/dist/css/uikit.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.8/dist/js/uikit.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/uikit@3.21.8/dist/js/uikit-icons.min.js"></script> --}}

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
            const sections = document.querySelectorAll('.competitive-section');
            sections.forEach(section => section.style.display = 'none');
            const targetSection = document.getElementById(sectionId);
            if (targetSection) {
                targetSection.style.display = 'block';
            }
            const navLinks = document.querySelectorAll('.competitive-nav-link');
            navLinks.forEach(navLink => navLink.classList.remove('active'));
            const clickedNavLink = document.querySelector(`a[href="#${sectionId}"]`);
            if (clickedNavLink) {
                clickedNavLink.classList.add('active');
            }
        }

        document.addEventListener('DOMContentLoaded', () => {
            document.getElementById('info').click();
        });

    </script>

    <!-- <script>
            function showSection(sectionId) {
                var section = document.getElementById(sectionId);
                if (section) {
                    section.style.display = "block";
                }
            }
        </script> -->
@endpush