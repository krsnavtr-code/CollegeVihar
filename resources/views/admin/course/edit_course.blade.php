@extends('admin.components.layout')
@section('title', 'Edit Course - CV Admin')

@section('main')
<main>
    @include('admin.components.response')

    <div class="container my-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h5 class="card-title mb-1">Edit Course</h5>
                <p class="text-muted mb-3 text-center">
                    Now editing <b class="text-primary">{{ $course['course_name'] }}</b> course
                </p>
                <div class="mb-3"><strong>Course ID:</strong> {{ $course['id'] }}</div>

                <form action="{{ route('admin.course.edit.submit') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <input type="hidden" name="course_id" value="{{ $course['id'] }}">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="course_category" class="form-label">Course Category <span class="text-danger">*</span></label>
                            <select name="course_category" id="course_category" class="form-select" required>
                                <option value="" disabled>Select Category</option>
                                <option value="UG" {{ ($course['course_category'] ?? $course['course_type']) == 'UG' ? 'selected' : '' }}>Undergraduate (UG)</option>
                                <option value="PG" {{ ($course['course_category'] ?? $course['course_type']) == 'PG' ? 'selected' : '' }}>Postgraduate (PG)</option>
                                <option value="DIPLOMA" {{ ($course['course_category'] ?? $course['course_type']) == 'DIPLOMA' ? 'selected' : '' }}>Diploma</option>
                                <option value="CERTIFICATION" {{ ($course['course_category'] ?? $course['course_type']) == 'CERTIFICATION' ? 'selected' : '' }}>Certification</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="course_subcategory" class="form-label">Course Subcategory <span class="text-danger">*</span></label>
                            <select name="course_subcategory" id="course_subcategory" class="form-select" required>
                                <option value="" disabled>Select Subcategory</option>
                                <option value="TECHNICAL" {{ ($course['course_subcategory'] ?? '') == 'TECHNICAL' ? 'selected' : '' }}>Technical</option>
                                <option value="MANAGEMENT" {{ ($course['course_subcategory'] ?? '') == 'MANAGEMENT' ? 'selected' : '' }}>Management</option>
                                <option value="MEDICAL" {{ ($course['course_subcategory'] ?? '') == 'MEDICAL' ? 'selected' : '' }}>Medical</option>
                                <option value="TRADITIONAL" {{ ($course['course_subcategory'] ?? '') == 'TRADITIONAL' ? 'selected' : '' }}>Traditional</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="course_online" class="form-label">Course Mode <span class="text-danger">*</span></label>
                            <select name="course_online" id="course_online" class="form-select" required>
                                <option value="1" {{ (isset($course['course_online']) && $course['course_online'] == 1) ? 'selected' : '' }}>Online</option>
                                <option value="0" {{ (isset($course['course_online']) && $course['course_online'] == 0) ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="university_id" class="form-label">University <span class="text-danger">*</span></label>
                            <select name="university_id" id="university_id" class="form-select">
                                <option value="">Select University</option>
                                @php
                                    $universityCourse = \App\Models\UniversityCourse::where('course_id', $course['id'])->first();
                                    $currentUniversityId = $universityCourse ? $universityCourse->university_id : null;
                                @endphp
                                @foreach(\App\Models\University::where('univ_status', 1)->orderBy('univ_name')->get() as $university)
                                    <option value="{{ $university->id }}" {{ $currentUniversityId == $university->id ? 'selected' : '' }}>
                                        {{ $loop->iteration }}. {{ $university->univ_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="course_name" class="form-label">Course Full Name <span class="text-danger">*</span></label>
                        <input type="text" name="course_name" id="course_name" class="form-control" required placeholder="Enter full course name" value="{{ $course['course_name'] ?? '' }}">
                    </div>

                    <div class="mb-4">
                        <label for="course_short_name" class="form-label">Course Short Name <span class="text-danger">*</span></label>
                        <input type="text" name="course_short_name" id="course_short_name" class="form-control" required placeholder="Enter short course name" value="{{ $course['course_short_name'] ?? '' }}">
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fa-solid fa-pen-to-square me-1"></i> Update Course
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('script')
<script>
// JS scripts can be added here if needed later
</script>
@endpush
@endsection
