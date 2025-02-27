@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/job_role/add" method="post">
        <h2 class="page_title">Create Job Role</h2>
        @csrf
        <div class="panel">
            <div class="field">
                <label for="a">Job role title</label>
                <input type="text" id="a" name="job_role_title" placeholder="Job Role">
            </div>
        </div>
        <div class="panel row">
            @foreach ($pages as $i=>$page)
            <div class="col-12 col-s-6 col-m-4 col-l-3">
                <div class="field">
                    <input type="checkbox" name="job_role_permissions[]" value="{{$page['id']}}" id="f{{$i}}">
                    <label for="f{{$i}}">{{$page['admin_page_title']}}</label>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Create Role</button>
        </div>
    </form>
</main>
@endsection