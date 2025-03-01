@extends('admin.components.layout')

@section('main')
<div class="container">
    <h1 class="mb-4">Edit Mock Test</h1>
    <form action="{{ route('admin.mock-test.update', $mockTest->id) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="test_duration">Test Duration (Minutes)</label>
                    <input type="number" name="test_duration" id="test_duration" class="form-control" value="{{ $mockTest->test_duration }}" required>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="competitive_exam_id">Competitive Exam</label>
                    <select name="competitive_exam_id" id="competitive_exam_id" class="form-control" required>
                        <option value="">Select Exam</option>
                        @foreach($exams as $exam)
                            <option value="{{ $exam->id }}" {{ $mockTest->competitive_exam_id == $exam->id ? 'selected' : '' }}>{{ $exam->exam_type }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        <div id="questions-container" class="mt-4">
            <h3>Questions</h3>
            @foreach($mockTest->questions as $index => $question)
                <div class="question-row border p-3 mb-3 position-relative">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question position-absolute top-0 end-0 m-2">❌</button>
                    <div class="form-group">
                        <label for="question">Question</label>
                        <textarea name="questions[{{ $index }}][question]" class="form-control" required>{{ $question->question }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Answers</label>
                        <input type="text" name="questions[{{ $index }}][answer1]" class="form-control mb-2" value="{{ $question->answer1 }}" placeholder="Enter Answer 1" required>
                        <input type="text" name="questions[{{ $index }}][answer2]" class="form-control mb-2" value="{{ $question->answer2 }}" placeholder="Enter Answer 2" required>
                        <input type="text" name="questions[{{ $index }}][answer3]" class="form-control mb-2" value="{{ $question->answer3 }}" placeholder="Enter Answer 3" required>
                        <input type="text" name="questions[{{ $index }}][answer4]" class="form-control mb-2" value="{{ $question->answer4 }}" placeholder="Enter Answer 4" required>
                    </div>
                    <div class="form-group">
                        <label for="correct_answer">Correct Answer</label>
                        <select name="questions[{{ $index }}][correct_answer]" class="form-control" required>
                            <option value="1" {{ $question->correct_answer == '1' ? 'selected' : '' }}>Answer 1</option>
                            <option value="2" {{ $question->correct_answer == '2' ? 'selected' : '' }}>Answer 2</option>
                            <option value="3" {{ $question->correct_answer == '3' ? 'selected' : '' }}>Answer 3</option>
                            <option value="4" {{ $question->correct_answer == '4' ? 'selected' : '' }}>Answer 4</option>
                        </select>
                    </div>
                    <input type="hidden" name="questions[{{ $index }}][id]" value="{{ $question->id }}">
                </div>
            @endforeach
        </div>
        
        <button type="button" id="add-question" class="btn btn-primary mt-3">Add New Question</button>
        <button type="submit" class="btn btn-success mt-3">Update Mock Test</button>
    </form>
</div>

@push('script')
<script>
    let questionCount = {{ count($mockTest->questions) }};
    document.getElementById('add-question').addEventListener('click', function() {
        const container = document.getElementById('questions-container');
        const newQuestion = `
            <div class="question-row border p-3 mb-3 position-relative">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question position-absolute top-0 end-0 m-2">❌</button>
                <div class="form-group">
                    <label for="question">Question</label>
                    <textarea name="questions[${questionCount}][question]" class="form-control" required></textarea>
                </div>
                <div class="form-group">
                    <label>Answers</label>
                    <input type="text" name="questions[${questionCount}][answer1]" class="form-control mb-2" placeholder="Enter Answer 1" required>
                    <input type="text" name="questions[${questionCount}][answer2]" class="form-control mb-2" placeholder="Enter Answer 2" required>
                    <input type="text" name="questions[${questionCount}][answer3]" class="form-control mb-2" placeholder="Enter Answer 3" required>
                    <input type="text" name="questions[${questionCount}][answer4]" class="form-control mb-2" placeholder="Enter Answer 4" required>
                </div>
                <div class="form-group">
                    <label for="correct_answer">Correct Answer</label>
                    <select name="questions[${questionCount}][correct_answer]" class="form-control" required>
                        <option value="1">Answer 1</option>
                        <option value="2">Answer 2</option>
                        <option value="3">Answer 3</option>
                        <option value="4">Answer 4</option>
                    </select>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', newQuestion);
        questionCount++;
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-question')) {
            e.target.parentElement.remove();
        }
    });
</script>
@endpush
@endsection