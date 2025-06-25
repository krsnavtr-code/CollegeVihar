@extends('admin.components.layout')

@section('title', 'Dashboard - CV Admin')

@section('main')
<main>
    <section class="admin">
        <img src="/images/user_bg.jpg" alt="profile" class="mt-4 rounded-2 w-100" height="300">
        <div class="text-center translate-middle-y">
            <img src="/images/web assets/logo_mini.jpeg" alt="profile" class="rounded-circle" height="200" width="200">
            <button class="btn btn-primary rounded-circle cam-btn">
                <i class="fa-solid fa-camera"></i>
            </button>
            <h4 class="mt-1 text-primary"><i class="fa-regular fa-at"></i>{{Session::get('admin_username')}}</h4>
            <h5>{{Request::get('admin_data')['emp_name']}}</h5>
        </div>
    </section>
</main>
@endsection