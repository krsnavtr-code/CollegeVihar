@php
$page_title = 'MCQs Test';
@endphp

@extends('user.info.layout')

@section('main_section')

<style>
    /* Quiz Container */
    .quiz-card {
        max-width: 700px;
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Question Styling */
    .question-title {
        font-size: 22px;
        font-weight: bold;
        color: #333;
    }

    /* Answer List */
    .answer-item {
        cursor: pointer;
        padding: 12px;
        border-radius: 6px;
        transition: 0.3s;
        display: flex;
        align-items: center;
    }

    /* Hover effect */
    .answer-item:hover {
        background: #f1f1f1;
    }

    /* Selected Answer */
    .answer-item.selected {
        background: #007bff;
        color: white;
        font-weight: bold;
    }

    /* Button Styling */
    .next-btn {
        width: 200px;
        font-size: 16px;
        padding: 10px;
        border-radius: 6px;
    }
</style>

<div class="container mt-5 d-flex justify-content-center mb-4">
    <div class="card quiz-card p-4">
        <h3 class="text-center text-primary">{{ $mockTest->competitiveExam->exam_type }} - Mock Test</h3>

        <div id="quiz-container">
            @if($questions->isNotEmpty())
                @php $firstQuestion = $questions->first(); @endphp
                <div class="question mt-3" data-question-id="{{ $firstQuestion->id }}">
                    <h5 class="text-secondary">Question <span id="current-question" class="text-danger">{{ session('current_question', 1) }}</span> of {{ $questions->count() }}</h5>

                    <p id="question-text" class="question-title">{{ $firstQuestion->question }}</p>
                    
                    <ul id="answers-list" class="list-group mt-3">
                        @foreach(range(1, 4) as $index)
                            <li class="list-group-item answer-item" data-value="{{ $index }}">
                                <input type="radio" name="answer" value="{{ $index }}" id="answer{{ $index }}" class="d-none">
                                <label for="answer{{ $index }}" class="w-100 m-0">{{ $firstQuestion->{'answer' . $index} }}</label>
                            </li>
                        @endforeach
                    </ul>
                    
                    <div class="text-center mt-4">
                        <button id="submit-answer" class="btn btn-primary next-btn">Next</button>
                    </div>
                </div>
            @else
                <p class="text-muted text-center">No questions available for this mock test.</p>
            @endif
        </div>
    </div>
</div>

@endsection

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    console.log("Quiz Page Loaded");

    // Make the whole answer item clickable
    $(document).on("click", ".answer-item", function() {
        $(".answer-item").removeClass("selected");
        $(this).addClass("selected");
        $(this).find("input[type='radio']").prop("checked", true);
    });

    // Handle Next Button Click
    $(document).on('click', '#submit-answer', function() {
        let selectedAnswer = $('input[name="answer"]:checked').val();
        if (!selectedAnswer) {
            alert('Please select an answer.');
            return;
        }

        $('#submit-answer').prop('disabled', true).text('Please wait...');

        $.ajax({
            url: '{{ route('quizzes.submit') }}',
            method: 'POST',
            data: { 
                answer: selectedAnswer, 
                _token: '{{ csrf_token() }}' 
            },
            success: function(response) {
                console.log("Response:", response);

                if (response.status === 'success') {
                    $('#current-question').text(response.current);
                    $('#question-text').text(response.question.question);
                    
                    let answersHtml = '';
                    for (let i = 1; i <= 4; i++) {
                        answersHtml += `<li class='list-group-item answer-item' data-value='${i}'>
                            <input type='radio' name='answer' value='${i}' id='answer${i}' class='d-none'>
                            <label for='answer${i}' class='w-100 m-0'>${response.question['answer' + i]}</label>
                        </li>`;
                    }
                    $('#answers-list').html(answersHtml);

                    $('#submit-answer').prop('disabled', false).text('Next');
                } else if (response.status === 'completed') {
                    console.log('Redirecting to:', response.redirect);
                    window.location.href = response.redirect;
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred. Please try again.');
                $('#submit-answer').prop('disabled', false).text('Next');
            }
        });
    });
});
</script>
@endpush
