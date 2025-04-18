@extends('admin.components.layout')

@section('main')
<div class="container">
    <h1>Mock Tests</h1>
    <a href="{{ route('admin.mock-test.add') }}" class="btn btn-primary">Add New Mock Test</a>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Duration</th>
                    <th>Exam</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mockTests as $test)
                    <tr>
                        <td>{{ $test->id }}</td>
                        <td>{{ $test->test_duration }} minutes</td>
                        <td>{{ optional($test->competitiveExam)->exam_type }}</td>
                        <td>
                            <a href="{{ route('admin.mock-test.show', $test->id) }}">
                                <i class="icon fa-solid fa-eye" title="View Mock Test"></i>
                            </a>
                            <a href="{{ route('admin.mock-test.edit', $test->id) }}">
                                <i class="icon fa-solid fa-pen" title="Edit Mock Test"></i>
                            </a>
                            <form action="{{ route('admin.mock-test.delete', $test->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="icon btn btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fa-solid fa-trash" title="Delete Mock Test"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
