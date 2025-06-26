@extends('admin.components.layout')

@section('title', 'All Teams')

@section('main')
<main class="container mt-4">
    @include('admin.components.response')

    <div class="mb-4">
        <h2 class="page_title">All Teams</h2>
        <p class="page_sub_title">View all the created teams, their leaders, and assigned members.</p>
    </div>

    @if(count($teams) > 0)
        <div class="row">
            @foreach($teams as $team)
                <div class="col-lg-6 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                            <span class="fw-bold">{{ $team->team_name }}</span>
                            <span class="badge bg-light text-dark">Leader: {{ $team->leader->emp_name ?? 'N/A' }}</span>
                        </div>
                        <div class="card-body">
                            <h6 class="fw-semibold mb-2">Team Members:</h6>
                            @if($team->members->count())
                                <ul class="list-group list-group-flush">
                                    @foreach($team->members as $member)
                                        <li class="list-group-item">{{ $member->emp_name }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-muted">No members in this team.</p>
                            @endif
                        </div>
                        <div class="card-footer text-end">
                            <a href="{{ route('team.edit', $team->id) }}" class="btn btn-sm btn-light">
                                <i class="fa fa-pencil"></i> Edit
                            </a>
                            <form action="{{ route('team.destroy', $team->id) }}" method="POST" style="display: inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete this team?')">
                                    <i class="fa fa-trash"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="alert alert-info">
            No teams have been created yet.
        </div>
    @endif
</main>
@endsection
