@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <h2 class="page_title">Edit Course</h2>
    <div class="panel">
        <form action="/admin/course/edit" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                
                <input type="hidden" name="course_id" value="{{$course['id']}}">

                <label for="">Course Type</label>
                <select name="course_type" required>
                    <option selected disabled value="">
                        ----- Course Type -----
                    </option>
                    <option {{ $course['course_type'] == 'UG' ? 'selected' : '' }} value="UG">UG</option>
                    <option {{ $course['course_type'] == 'PG' ? 'selected' : '' }} value="PG">PG</option>
                    <option {{ $course['course_type'] == 'DIPLOMA' ? 'selected' : '' }} value="DIPLOMA">Diploma</option>
                    <option {{ $course['course_type'] == 'CERTIFICATION' ? 'selected' : '' }} value="CERTIFICATION">Certification</option>
                    <option {{ $course['course_type'] == 'TECHNICAL COURSES' ? 'selected' : '' }} value="TECHNICAL COURSES">Technical Courses</option>
                    <option {{ $course['course_type'] == 'MANAGEMENT COURSES' ? 'selected' : '' }} value="MANAGEMENT COURSES">Management Courses</option>
                    <option {{ $course['course_type'] == 'MEDICAL COURSES' ? 'selected' : '' }} value="MEDICAL COURSES">Medical Courses</option>
                    <option {{ $course['course_type'] == 'TRADITIONAL COURSES' ? 'selected' : '' }} value="TRADITIONAL COURSES">Traditional Courses</option>
                </select>
            </div>
            <div class="field">
                <label for="">Course Name </label>
                <input type="text" name="course_name" placeholder="Course Name" required value="{{$course['course_name']}}">
            </div>
            <div class="field">
                <label for="">Course Short Name </label>
                <input type="text" name="course_short_name" placeholder="Course Short Name" required value="{{$course['course_short_name']}}">
            </div>
            <div class="field">
                <label for="">Course Image:</label>
                <input type="file" name="course_img" value="{{$course['course_img']}}" accept="image/jpeg,image/jpg,image/png" required>
            </div>
            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary btn-lg">Edit Course</button>
            </div>
        </form>
    </div>
</main>

@push('script')
<script>
document.querySelector('input[name="course_img"]').addEventListener('change', function (e) {
    const file = e.target.files[0];
    const validExtensions = ['image/jpeg', 'image/jpg', 'image/png'];

    if (file) {
        if (!validExtensions.includes(file.type)) {
            alert('Invalid file type. Only JPEG, JPG, and PNG are allowed.');
            e.target.value = '';
        } else if (file.size > 2 * 1024 * 1024) { // 2MB
            alert('File size exceeds 2MB.');
            e.target.value = '';
        }
    }
});
</script>
@endpush
@endsection