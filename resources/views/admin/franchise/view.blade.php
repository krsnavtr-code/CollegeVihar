@extends('admin.components.layout')
@section('main')
<main>
    <!-- Franchise -->
    <h2 class="page_title">View Employees</h2>
    <div class="overflow-auto text-nowrap">
        <table class="table">
            <thead>
                <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($franchises as $i => $franchises)
                <tr @class(['disable'=> !$franchises['emp_status']])>
                    <td>{{ $i + 1 }}
                        <i class="icon error fa-solid fa-circle-xmark" title="Employee is not activated"></i>
                    </td>
                    <td>{{ $franchises['emp_name'] }}</td>
                    <td>{{ $franchises['emp_username'] }}</td>
                    <td onclick="switch_status(this,{{ $franchises['id'] }})">
                        <button class="disable_btn" title="Employee is disabled">Disabled</button>
                        <button class="active_btn" title="Employee is active">Active</button>
                    </td>
                    <td>
                        <a href="tel:+{{ $franchises['emp_contact'] }}">
                            <i class="icon fa-solid fa-phone"></i>
                        </a>
                        <a href="mailto:{{ $franchises['emp_email'] }}">
                            <i class="icon fa-solid fa-envelope"></i>
                        </a>
                        <a href="https://wa.me/91{{ $franchises['emp_contact'] }}" target="_blank">
                            <i class="icon fa-brands fa-whatsapp"></i>
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