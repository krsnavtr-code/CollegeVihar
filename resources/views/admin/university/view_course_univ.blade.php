@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('title', 'View Course Universityes - CV Admin')

@push('styles')
<style>
    .table-sm-custom td,
    .table-sm-custom th {
        padding: 0.3rem 0.5rem; /* chhoti padding for compact look */
        font-size: 0.50rem; /* optional: chhoti font size */
    }
</style>
@endpush

@section('main')
<main>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h5 class="page_title">View Course Universityes</h5>
        <h6>Course Name: <b>{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</b></h6>
    </div>
    <div class="panel">
        <table class="table table-sm-custom table-bordered table-responsive table-hover table-striped align-middle">
            <thead>
                <tr style="font-size: 0.7rem;">
                    <th width="60" class="text-center">#</th>
                    <th>University Name</th>
                    <th>Course Fee</th>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <th>Course Commision</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody style="font-size: 0.7rem;">
                @foreach ($universities as $id => $university)
                <tr @class([ 'disable'=> !(
                    $university['univ_course_status'] &&
                    $university['university']['univ_status']
                    ),
                    ])>
                    <td>{{ $universities->firstItem() + $loop->index }}</td>
                    <td title="{{ $university['university']['univ_name'] }}">
                        {{ $university['university']['univ_name'] }}
                    </td>
                    <td>{{ $university['univ_course_fee'] }}</td>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <td>{{ $university['univ_course_commision'] }}</td>
                    @endif
                    <td>
                        <a href="{{ route('university.course.edit', $university['id']) }}" class="btn btn-light rounded-circle" title="Edit Details">
                            <i class="fa-solid fa-pencil"></i>
                        </a>
                        @if (in_array(3, $permissions) || in_array(15, $permissions) || $permissions[0] == '*')
                        <button class="btn btn-danger rounded-circle" title="Delete Course" onclick="delete_course(this, $university['id'] )">
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
    <x-pagination :paginator="$universities" />
   
</main>
@push('script')
<script>
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