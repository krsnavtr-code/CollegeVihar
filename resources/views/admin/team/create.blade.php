@extends('admin.components.layout')
@section('main')
    <main>
        @include('admin.components.response')
        <form action="/admin/team/create" method="post">
            @csrf
            <h2 class="page_title">Add University</h2>
            <section class="panel">
                <div class="field_group">
                    <div class="field">
                        <label for="team_name">Team Name</label>
                        <input type="text" name="team_name" id="team_name" placeholder="Team Name">
                    </div>
                    <div class="field">
                        <label for="team_leader">Team Leader</label>
                        <select name="team_leader" id="team_leader">
                            <option value="" selected disabled>--- Please Select ---</option>
                            @foreach ($employees as $employee)
                                <option value="{{ $employee['id'] }}">
                                {{ $employee['emp_name'] }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </section>
            <section class="panel">
                <div class="row">
                    @foreach ($employees as $i => $employee)
                        <div class="col-12 col-s-6 col-m-4 col-l-3">
                            <div @class(['field', 'disable' => $employee['emp_team']])>
                                <input type="checkbox" name="team_members[]" value="{{ $employee['id'] }}"
                                    id="f{{ $i }}" @if ($employee['emp_team']) disabled @endif
                                    @if ($employee['emp_team'] == '1') checked @endif>
                                <label for="f{{ $i }}">{{ $employee['emp_name'] }}</label>
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
            <button type="submit">Create Team</button>
        </form>
    </main>
@endsection
