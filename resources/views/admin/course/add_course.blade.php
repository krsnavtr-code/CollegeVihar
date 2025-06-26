@extends('admin.components.layout')
@section('title', 'Add Course - CV Admin')

@section('main')
<main>
    @include('admin.components.response')

    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-1">Add New Course</h5>
                <p class="text-muted mb-4 text-center">Fill the form below to add a new course.</p>

                <form action="{{ route('admin.course.add.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="course_category" class="form-label">Course Category <span class="text-danger">*</span></label>
                            <select name="course_category" id="course_category" class="form-select" required>
                                <option value="" selected disabled>Select Category</option>
                                <option value="UG">Undergraduate (UG)</option>
                                <option value="PG">Postgraduate (PG)</option>
                                <option value="DIPLOMA">Diploma</option>
                                <option value="CERTIFICATION">Certification</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="course_subcategory" class="form-label">Course Subcategory <span class="text-danger">*</span></label>
                            <select name="course_subcategory" id="course_subcategory" class="form-select" required>
                                <option value="" selected disabled>Select Subcategory</option>
                                <option value="TECHNICAL">Technical</option>
                                <option value="MANAGEMENT">Management</option>
                                <option value="MEDICAL">Medical</option>
                                <option value="TRADITIONAL">Traditional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="course_online" class="form-label">Course Mode <span class="text-danger">*</span></label>
                            <select name="course_online" id="course_online" class="form-select" required>
                                <option value="1" selected>Online</option>
                                <option value="0">Offline</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="university_id" class="form-label">Offered By University <span class="text-danger">*</span></label>
                            <select name="university_id" id="university_id" class="form-select" required>
                                <option value="" selected disabled>Select University</option>
                                @foreach(\App\Models\University::where('univ_status', 1)->orderBy('univ_name')->get() as $university)
                                    <option value="{{ $university->id }}">{{ $loop->iteration }}. {{ $university->univ_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="course_name" id="course_name" class="form-control" placeholder="Enter full course name" required>
                    </div>

                    <div class="mb-4">
                        <label for="course_short_name" class="form-label">Course Short Name <span class="text-danger">*</span></label>
                        <input type="text" name="course_short_name" id="course_short_name" class="form-control" placeholder="Enter short course name" required>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-plus me-1"></i> Add Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
@endsection
