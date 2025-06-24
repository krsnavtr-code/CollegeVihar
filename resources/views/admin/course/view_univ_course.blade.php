@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('main')
<main>
    <!-- http://127.0.0.1:8000/admin/university/courses/34 -->

    <h2 class="page_title">{{ $university['univ_name'] }}</h2>
    <p class="mb-4">{{ $university['univ_address'] }}</p>
    
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Course Name</th>
                    <th>Course Fee</th>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*')) <th>Course Commision</th>  @endif
                    @if ( $permissions[0] == '*') <th>Status</th> @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($courses as $id => $course)
                <tr @class(['disable'=> !$course['univ_course_status']])>
                    <td>
                        {{  $id + 1 }}
                        @if (!$course['univ_course_detail_added'])
                        <i class="fa-solid fa-triangle-exclamation text-warning"
                            title="Course details are not uploaded"></i>
                        @endif
                        @if (!$course['univ_course_status'])
                        <i class="fa-solid fa-circle-xmark text-danger"
                            title="Employee is not activated"></i>
                        @endif
                    </td>
                    <td title="{{ $course['course']['course_name'] }}">
                        {{ $course['course']['course_short_name'] . ' (' . $course['course']['course_type'] . ')' }}
                    </td>
                    <td>{{ $course['univ_course_fee'] }}</td>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <td>{{ $course['univ_course_commision'] }}
                    </td>
                    @endif
                    @if ( in_array(41, $permissions) || $permissions[0] == '*')
                    <td onclick="switch_status(this, $course['id'] )">                       
                        <button class="disable_btn btn btn-secondary" title="Employee is disabled">Disable</button>
                        <button class="active_btn btn btn-success" title="Employee is active">Active</button>
                    </td>
                    @endif
                    <td>
                        @if (in_array(40, $permissions) || $permissions[0] == '*')
                        <a href="/admin/university/courses/edit/{{ $course['id'] }}" class="btn btn-light rounded-circle">
                            <i class="fa-solid fa-pencil" title="Edit Details"></i>
                        </a>
                        @endif
                        @if ( in_array(41, $permissions) || $permissions[0] == '*')
                        <button title="Delete Course" class="btn btn-danger rounded-circle" onclick="delete_course(this, $course['id'])">
                            <i class="fa-solid fa-trash-can"></i>
                        </button>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    {{-- pagination --}}
    @if(count($courses) >30 )
    <x-pagination :paginator="$courses" />
    @endif
</main>
@push('script')
<script>
    function switch_status(node, courseId) {
        ajax({
            url: "/api/course/status/" + courseId,
            success: (res) => {
                res = JSON.parse(res);
                if (res.success) {
                    node.closest("tr").toggleClass("disable");
                }
            }
        });
    }

    function delete_course(node, course_id) {
        if (!confirm("Are You sure to delete?")) return;
        ajax({
            url: "/api/univCourse/delete/" + course_id,
            success: (res) => {
                res = JSON.parse(res);
                if (res['success']) {
                    node.closest("tr").remove();
                    alert("!!! Deleted !!!");
                } else {
                    alert("Server Error");
                }
            },
            error: () => {
                alert("Item cannot be deleted");
            }
        })
    }
</script>
@endpush
@endsection