@php
$permissions = Request::get('admin_permissions');
@endphp
@extends('admin.components.layout')
@section('main')
<!-- http://localhost:8000/admin/course/university/5 -->
<main>
    <h2 class="page_title">{{ $course['course_name'] }} ({{ $course['course_short_name'] }})</h2>
    <div class="panel">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>University Name</th>
                    <th>Course Fee</th>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <th>Course Commision</th>
                    @endif
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($universities as $id => $university)
                <tr @class([ 'disable'=> !(
                    $university['univ_course_status'] &&
                    $university['university']['univ_status']
                    ),
                    ])>
                    <td>{{ $id + 1 }}</td>
                    <td title="{{ $university['university']['univ_name'] }}">
                        {{ $university['university']['univ_name'] }}
                    </td>
                    <td>{{ $university['univ_course_fee'] }}</td>
                    @if ($permissions && (in_array(1, $permissions) || $permissions[0] == '*'))
                    <td>{{ $university['univ_course_commision'] }}</td>
                    @endif
                    <td>
                        <button class="btn btn-light rounded-circle" title="Edit Details" onclick="edit({{ $university['id'] }})">
                            <i class="fa-solid fa-pencil"></i>
                        </button>
                        @if (in_array(3, $permissions) || in_array(15, $permissions) || $permissions[0] == '*')
                        <button class="btn btn-danger rounded-circle" title="Delete Course" onclick="delete_course(this,{{ $university['id'] }})">
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