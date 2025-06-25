@php
$permissions = Request::get('admin_permissions');
@endphp

@extends('admin.components.layout')
@section('title', 'View University Courses - CV Admin')

@section('main')
<main>
    <h5 class="page_title mb-3">View University Courses</h5>
    <h6 class="text-center mb-4">Here are all courses of <b class="text-primary">{{ $university['univ_name'] }}</b></h6>

    <div class="table-responsive shadow-sm rounded">
        <table class="table table-sm table-bordered table-striped table-hover align-middle text-nowrap">
            <thead class="table-light">
                <tr>
                    <th width="60" class="text-center">Sr.No.</th>
                    <th>Course Name</th>
                    <th>Fee (₹)</th>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                        <th>Commission (₹)</th>
                    @endif
                    @if (in_array(16, $permissions) || $permissions[0] == '*')
                        <th>Status</th>
                    @endif
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $id => $course)
                <tr @class(['table-danger' => !$course['univ_course_status'], 'table-success' => $course['univ_course_detail_added']])>
                    <td class="text-center">
                        {{ $id + 1 }}
                        @if (!$course['univ_course_detail_added'])
                            <span class="badge bg-warning" title="Details not uploaded">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                            </span>
                        @endif
                        @if (!$course['univ_course_status'])
                            <span class="badge bg-danger" title="Course is inactive">
                                <i class="fa-solid fa-circle-xmark"></i>
                            </span>
                        @endif
                    </td>
                    <td title="{{ $course['course']['course_name'] ?? 'N/A' }}">
                        @if(isset($course['course']))
                            {{ $course['course']['course_short_name'] ?? 'N/A' }} ({{ $course['course']['course_type'] ?? 'N/A' }})
                        @else
                            <span class="text-danger">Course not found</span>
                        @endif
                    </td>
                    <td>₹{{ number_format($course['univ_course_fee']) }}</td>
                    
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <td>₹{{ number_format($course['univ_course_commision']) }}</td>
                    @endif

                    @if (in_array(16, $permissions) || $permissions[0] == '*')
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                onclick="switch_status(this, $course['id'])"
                                {{ $course['univ_course_status'] ? 'checked' : '' }}>
                            <label class="form-check-label rounded px-2 ms-2">{{ $course['univ_course_status'] ? 'Active' : 'Inactive' }}</label>
                        </div>
                    </td>
                    @endif

                    <td>
                        <div class="d-flex gap-2 flex-wrap">
                            @if (in_array(40, $permissions) || $permissions[0] == '*')
                            <a href="/admin/university/courses/edit/{{ $course['id'] }}" class="btn btn-light btn-sm" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
                            </a>
                            @endif

                            @if (in_array(41, $permissions) || $permissions[0] == '*')
                            <button title="Delete Course" class="btn btn-danger btn-sm"
                                onclick="delete_course(this, $course['id'])">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if(count($courses) > 30)
    <x-pagination :paginator="$courses" />
    @endif
</main>

@push('script')
<script>
    function switch_status(node, courseId) {
        fetch(`/api/course/status/${courseId}`)
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    node.closest("tr").classList.toggle("table-danger");
                }
            });
    }

    function delete_course(node, course_id) {
        if (!confirm("Are you sure you want to delete this course?")) return;
        fetch(`/api/univCourse/delete/${course_id}`)
            .then(response => response.json())
            .then(res => {
                if (res.success) {
                    node.closest("tr").remove();
                    alert("Deleted successfully!");
                } else {
                    alert("Server Error");
                }
            })
            .catch(() => {
                alert("Item cannot be deleted");
            });
    }
</script>
@endpush
@endsection
