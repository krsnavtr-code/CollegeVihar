@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <h2 class="page_title">Add Course</h2>
    <div class="panel">
        <form action="/admin/course/add" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="">Course Type</label>
                <select name="course_type" required>
                    <option selected disabled value="">
                        ----- Course Type -----
                    </option>
                    <option value="UG">UG</option>
                    <option value="PG">PG</option>
                    <option value="DIPLOMA">Diploma</option>
                    <option value="CERTIFICATION">Certification</option>
                    <option value="TECHNICAL COURSES">Technical Courses</option>
                    <option value="MANAGEMENT COURSES">Management Courses</option>
                    <option value="MEDICAL COURSES">Medical Courses</option>
                    <option value="TRADITIONAL COURSES">Traditional Courses</option>
                </select>
            </div>
            <div class="field">
                <label for="">Course Online</label>
                <select name="course_online" required>
                    <option selected disabled value="">
                        ----- Is Course Online -----
                    </option>
                    <option value="1">Online</option>
                    <option value="0">Offline</option>
                </select>
            </div>
            <div class="field">
                <label for="">Course Name <i class="text">( It can be already there )</i></label>
                <input type="text" name="course_name" placeholder="Course Name" required>
            </div>
            <div class="field">
                <label for="">Course Short Name <i class="text">( Re-check Once )</i></label>
                <input type="text" name="course_short_name" placeholder="Course Short Name" required>
            </div>
            <div class="field">
                <label for="">Course Image:</label>
                <input type="file" name="course_img" accept="image/jpeg,image/jpg,image/png" required>
            </div>
            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary btn-lg">Add Course</button>
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