@php
$page_title = 'Competitive Test';
@endphp

@extends('user.info.layout')
@section('main_section')

<div class="container mt-4">
        <h2>{{ $exam->exam_type }} Quiz</h2>
        
        <!-- Progress Bar -->
        <div id="progress-bar" class="progress mb-3">
            <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                1 / {{ count(session('mcq_ids', [])) }}
            </div>
        </div>

        <!-- Question and Answers -->
        <div id="quiz-content">
            <p><strong>Question:</strong> <span id="question">{{ $nextmcq->question }}</span></p>
            <form id="quiz-form">
                @csrf
                <ul class="list-unstyled">
                    @for($i = 1; $i <= 4; $i++)
                        <li>
                            <input type="radio" name="answer" value="{{ $i }}" required>
                            <label>{{ $nextmcq['answer' . $i] }}</label>
                        </li>
                    @endfor
                </ul>
                <button type="button" id="next-btn" class="btn btn-primary">Next</button>
            </form>
        </div>

        <!-- Feedback -->
        <div id="feedback" class="mt-3"></div>
    </div>

@push('script')
    <script>
        let examId = {{ $exam->id }};
        let currentIndex = {{ session('current_mcq_index', 0) }};
        let totalMcqs = {{ count(session('mcq_ids', [])) }};

        // Use event delegation on a parent element (e.g., #quiz-content)
        document.getElementById('quiz-content').addEventListener('click', function(e) {
            if (e.target && e.target.id === 'next-btn') {
                let formData = new FormData(document.getElementById('quiz-form'));
                axios.post(`/exam/${examId}/next`, formData)
                    .then(response => {
                        if (response.data.redirect) {
                            // Redirect to result page if quiz is complete
                            window.location.href = response.data.redirect;
                        } else {
                            // Update quiz content with next question
                            let mcq = response.data.mcq;
                            let questionHtml = `<p><strong>Question:</strong> ${mcq.question}</p>`;
                            let answersHtml = '';
                            mcq.answers.forEach((answer, index) => {
                                answersHtml += `<li><input type="radio" name="answer" value="${index + 1}" required><label>${answer}</label></li>`;
                            });
                            document.getElementById('question').innerHTML = mcq.question;
                            document.getElementById('quiz-form').innerHTML = `
                                <ul class="list-unstyled">${answersHtml}</ul>
                                <button type="button" id="next-btn" class="btn btn-primary">Next</button>
                            `;
                            document.getElementById('feedback').innerHTML = response.data.feedback 
                                ? `<p class="alert alert-${response.data.feedback.type}">${response.data.feedback.message}</p>` 
                                : '';

                            // Update progress bar
                            currentIndex++;
                            let progress = (currentIndex / totalMcqs) * 100;
                            document.querySelector('.progress-bar').style.width = `${progress}%`;
                            document.querySelector('.progress-bar').setAttribute('aria-valuenow', progress);
                            document.querySelector('.progress-bar').innerHTML = `${currentIndex + 1} / ${totalMcqs}`;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred. Please try again.');
                    });
            }
        });

        // Ensure CSRF token for Axios
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    </script>

    <!-- Bootstrap JS and Axios -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
@endpush
@endsection