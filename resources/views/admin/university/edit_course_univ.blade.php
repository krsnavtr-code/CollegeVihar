@php
$permissions = Request::get('admin_permissions');
@endphp

@extends('admin.components.layout')

@section('main')
<main>
    @include('admin.components.response')
    <h2 class="page_title">Edit Course - {{ $university->univ_name }}</h2>
    <div class="panel">
        <form action="{{ route('university.course.update', $universityCourse->id) }}" method="post">
            @csrf
            @method('PUT')
            
            <div class="field">
                <label for="univ_course_fee">Course Fee</label>
                <input type="number" 
                       name="univ_course_fee" 
                       id="univ_course_fee" 
                       class="form-control"
                       value="{{ old('univ_course_fee', $universityCourse->univ_course_fee) }}" 
                       required>
            </div>

            @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
            <div class="field">
                <label for="univ_course_commision">Course Commission</label>
                <input type="number" 
                       name="univ_course_commision" 
                       id="univ_course_commision" 
                       class="form-control"
                       value="{{ old('univ_course_commision', $universityCourse->univ_course_commision) }}" 
                       required>
            </div>
            @endif

            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-1"></i> Update Details
                </button>
                <a href="{{ route('university.list', ['course' => $course->id]) }}" 
                   class="btn btn-secondary">
                    <i class="fas fa-times me-1"></i> Cancel
                </a>
            </div>
        </form>
    </div>
</main>
@endsection

@push('style')
<style>
    .field {
        margin-bottom: 1.5rem;
    }
    .field label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
    }
    .form-control {
        width: 100%;
        padding: 0.5rem;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 4px;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn i {
        margin-right: 0.5rem;
    }
</style>
@endpush
