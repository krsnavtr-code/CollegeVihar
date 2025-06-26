@extends('admin.components.layout')

@push('css')
<style>
    /* Modal styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto;
        background-color: rgba(0, 0, 0, 0.4);
        padding-top: 60px;
        box-sizing: border-box;
    }

    .modal-content {
        background-color: #fff;
        margin: auto;
        padding: 20px;
        border: 1px solid #888;
        width: 90%;
        max-width: 600px;
        position: relative;
        box-sizing: border-box;
        border-radius: 8px;
    }

    .close {
        position: absolute;
        top: 10px;
        right: 15px;
        font-size: 24px;
        font-weight: bold;
        color: #888;
        background: #fff;
        border: 1px solid #ccc;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
    }

    .close:hover {
        color: #000;
        border-color: #000;
    }

    #modal-detail {
        max-height: 70vh;
        overflow-y: auto;
        text-align: left;
    }

    .table th,
    .table td {
        vertical-align: top;
    }
</style>
@endpush

@section('main')
<main>
    <div>
        <h1>View Competitive Exams</h1>
        <p class="mb-4">All Competitive Exams Written by our team</p>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered align-middle">
            <thead class="table-light">
                <tr>
                    <th>S.No</th>
                    <th>Exam Type</th>
                    <th>Opening Date</th>
                    <th>Closing Date</th>
                    <th>Videos</th>
                    <th>Q&A</th>
                    <th>Mock Test</th>
                    <th>Syllabus</th>
                    <th>Info</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($exams as $index => $exam)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $exam->exam_type }}</td>
                    <td class="text-success">{{ \Carbon\Carbon::parse($exam->exam_opening_date)->format('d-M-Y h:i A') }}</td>
                    <td class="text-secondary">{{ \Carbon\Carbon::parse($exam->exam_closing_date)->format('d-M-Y h:i A') }}</td>

                    {{-- Videos --}}
                    <td>
                        @php $videos = json_decode($exam->videos, true); @endphp
                        @if(is_array($videos) && count($videos))
                            @foreach($videos as $video)
                                @if(!empty($video['video_url']))
                                    <a href="{{ $video['video_url'] }}" target="_blank" class="d-block mb-1">
                                        @if(!empty($video['thumbnail_url']))
                                            <img src="{{ $video['thumbnail_url'] }}" alt="Video" width="100">
                                        @else
                                            {{ $video['video_url'] }}
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        @else
                            <span class="text-danger">No videos</span>
                        @endif
                    </td>

                    {{-- Q&A --}}
                    <td>
                        @php
                            $questions = json_decode($exam->questions, true);
                            $answers = json_decode($exam->answers, true);
                        @endphp
                        @if(is_array($questions) && is_array($answers))
                            @foreach($questions as $i => $q)
                                <strong>Q{{ $i+1 }}:</strong> {{ $q }}<br>
                                <span class="text-danger">A:</span> {{ $answers[$i] ?? '' }}<br><br>
                            @endforeach
                        @else
                            <span class="text-danger">No Q&A</span>
                        @endif
                    </td>

                    {{-- Mock Test --}}
                    <td>
                        @php
                            $mockQ = json_decode($exam->mock_test_questions, true);
                            $mockA = json_decode($exam->mock_test_answers, true);
                        @endphp
                        @if(is_array($mockQ) && is_array($mockA))
                            @foreach($mockQ as $i => $q)
                                <strong>Q{{ $i+1 }}:</strong> {{ $q }}<br>
                                <span class="text-danger">A:</span> {{ $mockA[$i] ?? '' }}<br><br>
                            @endforeach
                        @else
                            <span class="text-danger">No Mock Test</span>
                        @endif
                    </td>

                    {{-- Syllabus --}}
                    <td><button class="btn btn-primary btn-sm open-modal" data-detail="{{ $exam->exam_syllabus }}">View</button></td>

                    {{-- Info --}}
                    <td><button class="btn btn-light btn-sm open-modal" data-detail="{{ $exam->exam_info }}">View</button></td>

                    {{-- Action --}}
                    <td>
                        @php
                            $examUrls = is_string($exam->exam_urls) ? json_decode($exam->exam_urls, true) : [];
                        @endphp
                        @if(is_array($examUrls))
                            @foreach($examUrls as $url)
                                <a href="{{ $url }}" target="_blank" class="btn btn-sm btn-outline-primary mb-1">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            @endforeach
                        @endif
                        <a href="{{ route('competitive-exam.edit', $exam->id) }}" class="btn btn-sm btn-warning">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        <form action="{{ route('competitive-exam.destroy', $exam->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <div id="modal-detail"></div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById("myModal");
        const modalDetail = document.getElementById("modal-detail");
        const closeBtn = document.querySelector(".close");

        document.querySelectorAll(".open-modal").forEach(button => {
            button.addEventListener('click', function () {
                const detailHTML = this.getAttribute("data-detail") || "No details available";
                modalDetail.innerHTML = detailHTML;
                modal.style.display = "block";
            });
        });

        closeBtn.addEventListener('click', () => modal.style.display = "none");
        window.addEventListener('click', (e) => {
            if (e.target === modal) modal.style.display = "none";
        });
    });
</script>
@endpush
