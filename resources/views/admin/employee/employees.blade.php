@extends('admin.components.layout')
@section('main')
<main>
    <h2 class="page_title">View Employees</h2>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $i => $employee)
                <tr @class(['disable'=> !$employee['emp_status']])>
                    <td>{{ $i + 1 }}
                        <i class="icon error fa-solid fa-circle-xmark" title="Employee is not activated"></i>
                    </td>
                    <td>{{ $employee['emp_name'] }}</td>
                    <td>{{ $employee['emp_username'] }}</td>
                    <td>{{ $employee['jobrole']['job_role_title'] }}</td>
                    <td onclick="switch_status(this,{{ $employee['id'] }})">
                        <button class="disable_btn" title="Employee is disabled">Disabled</button>
                        <button class="active_btn" title="Employee is active">Active</button>
                    </td>
                    <td style="text-overflow: nowrap;">
                        <a href="tel:+{{ $employee['emp_contact'] }}">
                            <i class="icon fa-solid fa-phone"></i>
                        </a>
                        <a href="mailto:{{ $employee['emp_email'] }}">
                            <i class="icon fa-solid fa-envelope"></i>
                        </a>
                        <a href="https://wa.me/91{{ $employee['emp_contact'] }}" target="_blank">
                            <i class="icon fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="/admin/employee/edit/{{ $employee['id'] }}" title="Edit Details">
                            <i class="icon fa-solid fa-pencil"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@push('script')
<script>
    function switch_status(node, empId) {
        ajax({
            url: "/api/employee/status/" + empId,
            success: (res) => {
                res = JSON.parse(res);
                if (res.success) {
                    node.closest("tr").toggleClass("disable");
                }
            }
        });
    }
</script>
@endpush
@endsection