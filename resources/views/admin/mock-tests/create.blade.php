@extends('admin.components.layout')

@section('main')
<div class="container py-4">
    <div class="card shadow-lg p-4">
        <h2 class="mb-4 text-primary">Add New Mock Test</h2>
        <form action="{{ route('admin.mock-test.store') }}" method="POST">
            @csrf
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="test_duration" class="font-weight-bold">Test Duration (Minutes)</label>
                        <input type="number" name="test_duration" id="test_duration" class="form-control border-primary" required>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="competitive_exam_id" class="font-weight-bold">Competitive Exam</label>
                        <select name="competitive_exam_id" id="competitive_exam_id" class="form-control border-primary" required>
                            <option value="">Select Exam</option>
                            @foreach($exams as $exam)
                                <option value="{{ $exam->id }}">{{ $exam->exam_type }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div id="questions-container" class="mt-4">
                <h4 class="text-success">Questions</h4>
                <div class="question-row border p-3 mb-3 bg-light rounded position-relative">
                    <button type="button" class="btn btn-sm btn-outline-danger remove-question position-absolute top-0 end-0 m-2">❌</button>
                    <div class="form-group">
                        <label class="font-weight-bold">Question</label>
                        <textarea name="questions[0][question]" class="form-control border-success" required></textarea>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Answers</label>
                        <input type="text" name="questions[0][answer1]" class="form-control mb-2 border-success" placeholder="Answer 1" required>
                        <input type="text" name="questions[0][answer2]" class="form-control mb-2 border-success" placeholder="Answer 2" required>
                        <input type="text" name="questions[0][answer3]" class="form-control mb-2 border-success" placeholder="Answer 3" required>
                        <input type="text" name="questions[0][answer4]" class="form-control mb-2 border-success" placeholder="Answer 4" required>
                    </div>
                    <div class="form-group">
                        <label class="font-weight-bold">Correct Answer</label>
                        <select name="questions[0][correct_answer]" class="form-control border-success" required>
                            <option value="1">Answer 1</option>
                            <option value="2">Answer 2</option>
                            <option value="3">Answer 3</option>
                            <option value="4">Answer 4</option>
                        </select>
                    </div>
                </div>
            </div>

            <button type="button" id="add-question" class="btn btn-outline-primary mt-3"> Add New Question</button>
            <button type="submit" class="btn btn-success mt-3">Save Mock Test</button>
        </form>
    </div>
</div>

@push('script')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let questionCount = 1;
        
        document.getElementById('add-question').addEventListener('click', function () {
            const container = document.getElementById('questions-container');
            const newQuestion = document.createElement('div');
            newQuestion.classList.add('question-row', 'border', 'p-3', 'mb-3', 'bg-light', 'rounded', 'position-relative');
            newQuestion.innerHTML = `
                <button type="button" class="btn btn-sm btn-outline-danger remove-question position-absolute top-0 end-0 m-2">❌</button>
                <div class="form-group">
                    <label class="font-weight-bold">Question</label>
                    <textarea name="questions[\${questionCount}][question]" class="form-control border-success" required></textarea>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Answers</label>
                    <input type="text" name="questions[\${questionCount}][answer1]" class="form-control mb-2 border-success" placeholder="Answer 1" required>
                    <input type="text" name="questions[\${questionCount}][answer2]" class="form-control mb-2 border-success" placeholder="Answer 2" required>
                    <input type="text" name="questions[\${questionCount}][answer3]" class="form-control mb-2 border-success" placeholder="Answer 3" required>
                    <input type="text" name="questions[\${questionCount}][answer4]" class="form-control mb-2 border-success" placeholder="Answer 4" required>
                </div>
                <div class="form-group">
                    <label class="font-weight-bold"> Correct Answer</label>
                    <select name="questions[\${questionCount}][correct_answer]" class="form-control border-success" required>
                        <option value="1">Answer 1</option>
                        <option value="2">Answer 2</option>
                        <option value="3">Answer 3</option>
                        <option value="4">Answer 4</option>
                    </select>
                </div>
            `;
            container.appendChild(newQuestion);
            questionCount++;
        });
        
        document.getElementById('questions-container').addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-question')) {
                e.target.closest('.question-row').remove();
            }
        });
    });
</script>
@endpush
@endsection
