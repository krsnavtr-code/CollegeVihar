@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <h2 class="page_title">Add Course</h2>
    <div class="panel">
        <form action="{{ route('admin.course.add.submit') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="field">
                <label for="course_category">Course Category</label>
                <select name="course_category" id="course_category" required>
                    <option value="" selected disabled>Select Category</option>
                    <option value="UG">Undergraduate (UG)</option>
                    <option value="PG">Postgraduate (PG)</option>
                    <option value="DIPLOMA">Diploma</option>
                    <option value="CERTIFICATION">Certification</option>
                </select>
            </div>

            <div class="field">
                <label for="course_subcategory">Course Subcategory</label>
                <select name="course_subcategory" id="course_subcategory" required>
                    <option value="" selected disabled>Select Subcategory</option>
                    <option value="TECHNICAL">Technical</option>
                    <option value="MANAGEMENT">Management</option>
                    <option value="MEDICAL">Medical</option>
                    <option value="TRADITIONAL">Traditional</option>
                </select>
            </div>
            <div class="field">
                <label for="course_online">Course Type</label>
                <select name="course_online" id="course_online" class="form-control" required>
                    <option value="1" selected>Online</option>
                    <option value="0">Offline</option>
                </select>
            </div>

            <div class="field">
                <label for="course_name">Course Name <i class="text">(It can be already there)</i></label>
                <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter course name" required>
            </div>
            <div class="field">
                <label for="">Course Short Name <i class="text">( Re-check Once )</i></label>
                <input type="text" name="course_short_name" placeholder="Course Short Name" required>
            </div>

            <div class="text-end p-4">
                <button type="submit" class="btn btn-primary btn-lg">Add Course</button>
            </div>
        </form>
    </div>
</main>


@endsection