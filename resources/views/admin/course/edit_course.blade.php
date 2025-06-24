@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <h2 class="page_title">Edit Course</h2>
    <span>Id : {{$course['id']}}</span>
    <div class="panel">
        <form action="{{ route('admin.course.edit.submit') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')
            <div class="field">
                <input type="hidden" name="course_id" value="{{$course['id']}}">

                <label for="course_category">Course Category</label>
                <select name="course_category" id="course_category" required>
                    <option value="" disabled>Select Category</option>
                    <option value="UG" {{ ($course['course_category'] ?? $course['course_type']) == 'UG' ? 'selected' : '' }}>Undergraduate (UG)</option>
                    <option value="PG" {{ ($course['course_category'] ?? $course['course_type']) == 'PG' ? 'selected' : '' }}>Postgraduate (PG)</option>
                    <option value="DIPLOMA" {{ ($course['course_category'] ?? $course['course_type']) == 'DIPLOMA' ? 'selected' : '' }}>Diploma</option>
                    <option value="CERTIFICATION" {{ ($course['course_category'] ?? $course['course_type']) == 'CERTIFICATION' ? 'selected' : '' }}>Certification</option>
                </select>
            </div>

            <div class="field">
                <label for="course_subcategory">Course Subcategory</label>
                <select name="course_subcategory" id="course_subcategory" required>
                    <option value="" disabled>Select Subcategory</option>
                    <option value="TECHNICAL" {{ ($course['course_subcategory'] ?? '') == 'TECHNICAL' ? 'selected' : '' }}>Technical</option>
                    <option value="MANAGEMENT" {{ ($course['course_subcategory'] ?? '') == 'MANAGEMENT' ? 'selected' : '' }}>Management</option>
                    <option value="MEDICAL" {{ ($course['course_subcategory'] ?? '') == 'MEDICAL' ? 'selected' : '' }}>Medical</option>
                    <option value="TRADITIONAL" {{ ($course['course_subcategory'] ?? '') == 'TRADITIONAL' ? 'selected' : '' }}>Traditional</option>
                </select>
            </div>
            <div class="field">
                <label for="course_online">Course Type</label>
                <select name="course_online" id="course_online" class="form-control" required>
                    <option value="1" {{ (isset($course['course_online']) && $course['course_online'] == 1) ? 'selected' : '' }}>Online</option>
                    <option value="0" {{ (isset($course['course_online']) && $course['course_online'] == 0) ? 'selected' : '' }}>Offline</option>
                </select>
            </div>

            <div class="field">
                <label for="course_name">Course Name</label>
                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter course name" required value="{{ $course['course_name'] ?? '' }}">
            </div>
            <div class="field">
                <label for="">Course Short Name </label>
                <input type="text" name="course_short_name" placeholder="Course Short Name" required value="{{$course['course_short_name']}}">
            </div>

            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary btn-lg">Edit Course</button>
            </div>
        </form>
    </div>
</main>

@push('script')
<script>
// Image validation removed
</script>
@endpush
@endsection