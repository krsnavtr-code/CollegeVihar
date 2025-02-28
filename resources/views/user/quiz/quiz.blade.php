@php
$page_title = 'MCQS Test';
@endphp

@extends('user.info.layout')
@section('main_section')

<div class="container mt-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center py-4">
            <h1 class="mb-0">{{ $exam->exam_type }} Quiz</h1>
            <p class="mb-0 text-white-50" id="progress-text">1 / {{ count(session('mcq_ids', [])) }}</p>
        </div>
        <div class="card-body p-5">
            <!-- Question and Answers -->
            <div id="quiz-content" class="mb-4">
                <div class="question-box p-4 bg-light rounded-3 shadow-sm mb-4">
                    <h4 class="mb-3"><strong>Question:</strong></h4>
                    <p class="lead" id="question">{{ $nextmcq->question }}</p>
                </div>
                <form id="quiz-form" class="mt-4">
                    @csrf
                    <div class="list-group">
                        @for($i = 1; $i <= 4; $i++)
                            <div class="list-group-item d-flex align-items-center p-3 border-bottom">
                                <input type="radio" name="answer" value="{{ $i }}" class="form-check-input me-3" required id="answer{{ $i }}">
                                <label class="form-check-label w-100 clickable-answer" for="answer{{ $i }}">{{ $nextmcq['answer' . $i] }}</label>
                            </div>
                        @endfor
                    </div>
                    <button type="button" id="next-btn" class="btn btn-primary mt-4 px-5 py-2">Next</button>
                </form>
            </div>

            <!-- Feedback -->
            <div id="feedback" class="mt-3"></div>
        </div>
        <div class="card-footer bg-light text-center py-3">
            
        </div>
    </div>
</div>

@push('script')
    <script>
        let examId = {{ $exam->id }};
        let currentIndex = {{ session('current_mcq_index', 0) }};
        let totalMcqs = {{ count(session('mcq_ids', [])) }};

        // Use event delegation on #quiz-content
        document.getElementById('quiz-content').addEventListener('click', function(e) {
            if (e.target && (e.target.id === 'next-btn' || e.target.classList.contains('clickable-answer'))) {
                if (e.target.classList.contains('clickable-answer')) {
                    // Simulate clicking the radio button when label is clicked
                    let radioId = e.target.getAttribute('for');
                    document.getElementById(radioId).checked = true;
                } else {
                    let nextBtn = e.target;
                    let formData = new FormData(document.getElementById('quiz-form'));

                    // Show loading state on button
                    nextBtn.disabled = true;
                    nextBtn.innerHTML = 'Please wait...';

                    axios.post(`/exam/${examId}/next`, formData)
                        .then(response => {
                            if (response.data.redirect) {
                                // Redirect to result page if quiz is complete
                                window.location.href = response.data.redirect;
                            } else {
                                // Update quiz content with next question
                                let mcq = response.data.mcq;
                                let questionHtml = `<h4 class="mb-3"><strong>Question:</strong></h4><p class="lead">${mcq.question}</p>`;
                                let answersHtml = '';
                                mcq.answers.forEach((answer, index) => {
                                    answersHtml += `<div class="list-group-item d-flex align-items-center p-3 border-bottom"><input type="radio" name="answer" value="${index + 1}" class="form-check-input me-3" required id="answer${index + 1}"><label class="form-check-label w-100 clickable-answer" for="answer${index + 1}">${answer}</label></div>`;
                                });
                                document.getElementById('question').innerHTML = mcq.question;
                                document.getElementById('quiz-form').innerHTML = `
                                    <div class="list-group">${answersHtml}</div>
                                    <button type="button" id="next-btn" class="btn btn-primary mt-4 px-5 py-2">Next</button>
                                `;
                                document.getElementById('feedback').innerHTML = response.data.feedback 
                                    ? `<div class="alert alert-${response.data.feedback.type} alert-dismissible fade show" role="alert">${response.data.feedback.message}<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>` 
                                    : '';

                                // Update progress text
                                currentIndex++;
                                document.getElementById('progress-text').innerHTML = `${currentIndex + 1} / ${totalMcqs}`;
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('An error occurred. Please try again.');
                        })
                        .finally(() => {
                            // Restore button state after request completes
                            if (nextBtn) {
                                nextBtn.disabled = false;
                                nextBtn.innerHTML = 'Next';
                            }
                        });
                }
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