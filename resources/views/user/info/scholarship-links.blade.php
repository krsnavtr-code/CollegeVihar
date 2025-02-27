@php
    $page_title = 'View Scholarship Exams';
@endphp

@push('css')
<style>
    .exam-list {
        position: relative;
        overflow: hidden;
        height: 300px;
        padding-top: 50px; /* Adjust this height to match the header height */
    }

    .exam-list .header {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        box-sizing: border-box;
        background-color: #f2f2f2;
        font-weight: bold;
        position: absolute;
        top: 0;
        width: 100%;
        border-bottom: 1px solid #ccc;
        z-index: 2; /* Ensure the header is above the scrolling content */
    }

    .exam-list .row {
        display: flex;
        justify-content: space-between;
        padding: 10px;
        box-sizing: border-box;
        border-bottom: 1px solid #ccc;
        z-index: 1; /* Ensure rows are below the header */
    }

    .exam-list .row:nth-child(even) {
        background-color: #f9f9f9;
    }

    .exam-list .column {
        flex: 1;
        padding: 10px;
    }

    .exam-list .rows {
        position: absolute;
        top: 50px; /* Adjust this height to match the header height */
        width: 100%;
        animation: scrollUp 20s linear infinite;
    }

    @keyframes scrollUp {
        0% {
            top: 100%;
        }
        100% {
            top: -100%;
        }
    }
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <div class="container">
        <h2 style="text-align:center; margin-bottom: 25px;">Latest Scholarship Exams</h2>
        <div class="exam-list" id="exam-list">
            <div class="header">
                <div class="column">Scholarship Exam Link</div>
                <div class="column">Exam Opening Date</div>
                <div class="column">Exam Closing Date</div>
            </div>
            <div class="rows">
                @foreach($exams as $exam)
                    @php
                        $examUrls = json_decode($exam->exam_urls, true);
                    @endphp
                    @foreach($examUrls as $url)
                        <div class="row">
                            <div class="column"><a href="/scholarship-exam/{{ $exam->id }}"><strong>{{ $url }}</strong></a></div>
                            <div class="column">{{ \Carbon\Carbon::parse($exam->exam_opening_date)->format('d-M-Y h:i A') }}</div>
                            <div class="column">{{ \Carbon\Carbon::parse($exam->exam_closing_date)->format('d-M-Y h:i A') }}</div>
                        </div>
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
</main>
@endsection

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const examList = document.querySelector('.exam-list .rows');
        
        const startScroll = () => {
            examList.style.animationPlayState = 'running';
        };

        const stopScroll = () => {
            examList.style.animationPlayState = 'paused';
        };

        startScroll();

        examList.addEventListener('mouseover', stopScroll);
        examList.addEventListener('mouseout', startScroll);
    });
</script>
@endpush
