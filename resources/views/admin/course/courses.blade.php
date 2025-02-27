@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('main')
<main>
    <h2 class="page_title">View Course</h2>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead class="text-center">
                <tr>
                    <th>Sr.No.</th>
                    <th>Course Name</th>
                    <th>Course Type</th>
                    <th>Universities</th>
                    @if ( $permissions[0] == '*') <th>Course Status</th> @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $i => $course)
                <tr @class(['disable'=> !$course['course_status']])>
                    <td>
                        {{ $i + 1 }}
                        @if (!$course['course_detail_added'] && $course['course_status'])
                        <i class="fa-solid fa-triangle-exclamation text-warning"
                            title="course details are not uploaded"></i>
                        @endif
                        <i class="fa-solid fa-circle-xmark text-danger"
                            title="course is not activated"></i>
                    </td>
                    <td title="{{ $course['course_name'] }}">{{ $course['course_short_name'] }}</td>
                    <td>{{ $course['course_type'] }}</td>
                    <td><a href="/admin/course/university/{{ $course['id'] }}"
                            class="btn btn-light">{{ count($course['universities']) }}
                            Uni.</a>
                    </td>
                    @if ( $permissions[0] == '*')
                    <td onclick="switch_status(this,{{ $course['id'] }})">
                        <button class="disable_btn btn btn-secondary" title="course is disabled">Disabled</button>
                        <button class="active_btn btn btn-success" title="course is active">Active</button>
                    </td>
                    @endif
                    <td>
                        <a href="/admin/course/edit/{{ $course['id'] }}" title="Edit Course"
                            class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        {{-- Add course Details --}}
                        @if ((in_array(16, $permissions) || $permissions[0] == '*') && !$course['course_detail_added'])
                        <a href="/admin/course/add/details/{{ $course['id'] }}"
                            title="Add course Details">
                            <i class="fa-solid fa-plus"></i>
                        </a>
                        @endif
                        @if ($permissions && (in_array(19, $permissions) || $permissions[0] == '*') && $course['course_detail_added'])
                        <a href="/admin/course/edit/details/{{ $course['id'] }}" title="Edit course Details"
                            class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pen-fancy"></i>
                        </a>
                        @endif
                        @if ((in_array(18, $permissions) || $permissions[0] == '*') && $course['course_detail_added'])
                        <a href="/admin/web_pages/edit/{{ $course['course_slug'] }}"
                            class="btn btn-primary">
                            SEO
                        </a>
                        @endif
                        @if ( $permissions[0] == '*')
                        <button type="submit" title="Delete University"
                            onclick="if (confirm('Are you sure you want to delete this university?')) deleteCourse(this)"
                            data-course="{{ $course['id'] }}"
                            class="btn btn-danger rounded-circle">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- pagination --}}
    <x-pagination :paginator="$courses" />
</main>
@push('script')
<script>
    function switch_status(node, univId) {
        ajax({
            url: "/api/course/status/" + univId,
            success: (res) => {
                res = JSON.parse(res);
                if (res.success) {
                    node.closest("tr").toggleClass("disable");
                }
            }
        });
    }

    function deleteCourse(node) {
        if (!confirm("Are You sure to delete?")) return;
        ajax({
            url: "/api/course/delete/" + node.get("data-course"),
            success: (res) => {
                res = JSON.parse(res);
                if (res['success']) {
                    node.closest("tr").remove();
                } else {
                    alert("Server Error");
                }
            }
        });
    }
</script>
@endpush
@endsection