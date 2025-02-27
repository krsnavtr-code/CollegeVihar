@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/job_role/edit" method="post">
        <h2 class="page_title">Edit Job Role</h2>
        @csrf
        <div class="panel">
            <div class="field">
                <input type="hidden" name="job_id" value="{{ $job_role['id'] }}">
                <label for="a">Job role title</label>
                <input type="text" id="a" readonly value="{{ $job_role['job_role_title'] }}">
            </div>
        </div>
        @php
        $permissions=json_decode($job_role['permissions']);
        @endphp
        <div class="panel row">
            @foreach ($pages as $i => $page)
            <div class="col-12 col-s-6 col-m-4 col-l-3">
                <div class="field">
                    <input type="checkbox" name="job_role_permissions[]" value="{{ $page['id'] }}" id="f{{ $i }}" @if (in_array($page['id'],$permissions)||($permissions && $permissions[0]=='*' )) checked @endif>
                    <label for="f{{ $i }}">{{ $page['admin_page_title'] }}</label>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update Role</button>
        </div>
    </form>
</main>
@endsection