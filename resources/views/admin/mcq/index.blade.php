@extends('admin.components.layout')

@section('main')
<main>
    <h2 class="page_title">MCQ Tests</h2>
    <a href="{{ route('admin.mcq.add') }}" class="btn btn-primary">Add New MCQ</a>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Duration</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($mcqs as $mcq)
                <tr>
                    <td>{{ $mcq->id }}</td>
                    <td>{{ $mcq->question }}</td>
                    <td>{{ $mcq->test_duration }} min</td>
                    <td>
                        <a href="{{ route('admin.mcq.view', $mcq->id) }}">
                            <i class="icon fa-solid fa-eye" title="View MCQ"></i>
                        </a>
                        <a href="{{ route('admin.mcq.edit', $mcq->id) }}">
                            <i class="icon fa-solid fa-pen" title="Edit MCQ"></i>
                        </a>
                        <form action="{{ route('admin.mcq.delete', $mcq->id) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="icon btn btn-danger" onclick="return confirm('Are you sure?')">
                                <i class="fa-solid fa-trash" title="Delete MCQ"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection
