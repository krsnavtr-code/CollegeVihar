@extends('admin.components.layout')

@section('main')
<main>
    @include('admin.components.response')

    <div class="container">
        <h2 class="page_title mb-2">Create New Team</h2>
        <p class="page_sub_title mb-4">Define the team name, select a leader, and assign members.</p>

        <form action="/admin/team/create" method="POST" class="shadow-sm p-4 bg-white rounded border">
            @csrf

            {{-- Team Info --}}
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="team_name" class="form-label fw-semibold">Team Name</label>
                        <input type="text" name="team_name" id="team_name" class="form-control" placeholder="e.g. Marketing Squad" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="team_leader" class="form-label fw-semibold">Team Leader</label>
                        <select name="team_leader" id="team_leader" class="form-select" required>
                            <option value="" disabled selected>-- Select Leader --</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee['id'] }}">
                                    {{ $employee['emp_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Member Selection --}}
            <div class="card">
                <div class="card-header bg-light fw-bold">Select Team Members</div>
                <div class="card-body">
                    <div class="row">
                        @foreach ($employees as $i => $employee)
                            <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                                <div class="form-check {{ $employee['emp_team'] ? 'text-muted' : '' }}">
                                    <input class="form-check-input"
                                        type="checkbox"
                                        id="emp_{{ $i }}"
                                        name="team_members[]"
                                        value="{{ $employee['id'] }}"
                                        @if ($employee['emp_team']) disabled @endif
                                        @if ($employee['emp_team'] == '1') checked @endif
                                    >
                                    <label class="form-check-label rounded p-2 " for="emp_{{ $i }}">
                                        {{ $employee['emp_name'] }}
                                        @if ($employee['emp_team'])
                                            <span class="badge bg-secondary ms-1">Already in Team</span>
                                        @endif
                                    </label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Submit --}}
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-primary px-4">Create Team</button>
            </div>
        </form>
    </div>
</main>
@endsection
