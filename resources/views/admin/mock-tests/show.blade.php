@extends('admin.components.layout')

@section('main')
<div class="container py-4">
    <div class="card shadow-lg p-4 border-0">
        <h1 class="text-primary mb-3">Mock Test Details</h1>
        <div class="mb-3">
            <p class="fw-bold text-secondary"><strong>Duration:</strong> <span class="text-dark">{{ $mockTest->test_duration }} minutes</span></p>
            <p class="fw-bold text-secondary"><strong>Exam:</strong> <span class="text-dark">{{ $mockTest->competitiveExam->exam_type }}</span></p>
        </div>
        <h3 class="text-success mb-3">Questions</h3>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Question</th>
                        <th>Option 1</th>
                        <th>Option 2</th>
                        <th>Option 3</th>
                        <th>Option 4</th>
                        <th>Correct Answer</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mockTest->questions as $index => $question)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $question->question }}</td>
                            <td>{{ $question->answer1 }}</td>
                            <td>{{ $question->answer2 }}</td>
                            <td>{{ $question->answer3 }}</td>
                            <td>{{ $question->answer4 }}</td>
                            <td>Answer {{ $question->correct_answer }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3">
            <a href="{{ route('admin.mock-test.index') }}" class="btn btn-outline-primary btn-sm">Back</a>
        </div>
    </div>
</div>
@endsection
