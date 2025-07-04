@extends('admin.components.layout')

@push('css')
<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgb(0, 0, 0);
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
        box-sizing: border-box;
    }

    .modal-content {
        background-color: #fefefe;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 50%;
        max-width: 500px;
        position: relative;
        box-sizing: border-box;
        overflow-y: auto;
    }

    .close {
        color: #aaa;
        position: absolute;
        top: 10px;
        right: 25px;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
    }

    .close:hover,
    .close:focus {
        color: black;
        text-decoration: none;
        cursor: pointer;
    }
</style>
@endpush

@section('main')
<main>
    <div>
        <h1>View Scholarship Exam</h1>
        <p class="mb-4">All Scholarship Exams Written by our team</p>
    </div>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.no</th>
                    <th>Scholarship Type</th>
                    <th>Videos</th>
                    <th>Scholarship Info</th>
                    <th>Questions & Answers</th>
                    <th>Syllabus</th>
                    <th>Mock Test</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $index => $exam)
                <tr>
                    <td>{{ $index + 1 }}.</td>
                    <td>{{ $exam->scholarship_type }}</td>
                    <!-- videos -->
                    <td>
                        @php
                        $videos = json_decode($exam->videos, true);
                        @endphp
                        @if(is_array($videos) && !empty($videos))
                        @foreach($videos as $video)
                        <div>
                            @if(isset($video['video_url']) && !empty($video['video_url']))
                            <a href="{{ $video['video_url'] }}" target="_blank">
                                @if(isset($video['thumbnail_url']) && !empty($video['thumbnail_url']))
                                <img src="{{ $video['thumbnail_url'] }}" alt="Thumbnail" class="img-fluid">
                                @else
                                {{ $video['video_url'] }}
                                @endif
                            </a>
                            @else
                            <small class="text-danger">Invalid video entry</small>
                            @endif
                        </div>
                        @endforeach
                        @else
                        <small class="text-danger">
                            No videos available
                        </small>
                        @endif
                    </td>


                    <!-- question -->
                    <td>
                        @php
                        $questions = json_decode($exam->questions, true);
                        $answers = json_decode($exam->answers, true);
                        @endphp
                        @if(is_array($questions) && is_array($answers))
                        @foreach($questions as $i => $question)
                        <h6 class="text-primary">
                            <strong>Q{{ $i + 1 }}:</strong>
                            {{ $question }}
                        </h6>
                        <p class="text-wrap text-secondary text-sm">
                            <strong class="text-danger">A:</strong>
                            {{ $mockTestAnswers[$i] ?? '' }}
                        </p>
                        @endforeach
                        @else
                        <small class="text-danger">
                            No questions available
                        </small>
                        @endif
                    </td>
                    <td>
                        @php
                        $mockTestQuestions = json_decode($exam->mock_test_questions, true);
                        $mockTestAnswers = json_decode($exam->mock_test_answers, true);
                        @endphp
                        @if(is_array($mockTestQuestions) && is_array($mockTestAnswers))
                        @foreach($mockTestQuestions as $i => $question)
                        <h6 class="text-primary">
                            <strong>Q{{ $i + 1 }}:</strong>
                            {{ $question }}
                        </h6>
                        <p class="text-wrap text-secondary text-sm">
                            <strong class="text-danger">A:</strong>
                            {{ $mockTestAnswers[$i] ?? '' }}
                        </p>
                        @endforeach
                        @else
                        <small class="text-danger">
                            No questions available
                        </small>
                        @endif
                    </td>
                    <!-- buttons -->
                    <td>
                        <button type="button" class="open-modal btn btn-primary" data-detail="{{ $exam->scholarship_info }}">View Details</button>
                    </td>
                    <td>
                        <button type="button" class="open-modal btn btn-light" data-detail="{{ $exam->scholarship_syllabus }}">View Syllabus</button>
                    </td>
                    <td>
                        <!-- link -->
                        @php
                        $examUrls = is_string($exam->exam_urls) ? json_decode($exam->exam_urls, true) : [];
                        @endphp
                        @if(is_array($examUrls))
                        @foreach($examUrls as $url)
                        <a href="{{ $url }}" target="_blank" class="btn btn-primary rounded-circle">
                            <i class="fa-solid fa-arrow-up-right-from-square"></i>
                        </a>
                        @endforeach
                        @else
                        <small class="text-danger">
                            No URLs available
                        </small>
                        @endif
                        <!-- edit -->
                        <a href="{{ route('scholarship-exam.edit', $exam->id) }}" class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pencil"></i></a>
                        <!-- delete -->
                        <form action="{{ route('scholarship-exam.destroyscholarship', $exam->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Are you sure you want to delete this scholarship?');" class="btn btn-danger rounded-circle">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <p id="modal-detail"></p>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var modal = document.getElementById("myModal");
        var btns = document.getElementsByClassName("open-modal");
        var span = document.getElementsByClassName("close")[0];
        var modalDetail = document.getElementById("modal-detail");

        Array.from(btns).forEach(function(btn) {
            btn.onclick = function() {
                modal.style.display = "block";
                var detail = this.getAttribute("data-detail");
                var tempDiv = document.createElement("div");
                tempDiv.innerHTML = detail;
                modalDetail.textContent = tempDiv.textContent || tempDiv.innerText || "";
            }
        });

        span.onclick = function() {
            modal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    });
</script>
@endpush