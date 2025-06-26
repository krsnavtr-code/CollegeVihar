@extends('admin.components.layout')

@section('main')
<main class="container py-4">
    <h5 class="mb-4">View Employees</h5>
    <p class="text-center text-muted mb-4">Now viewing <b class="text-primary">All Employees</b> here and manage them, add new employee or edit existing employee.</p>

    <div class="table-responsive shadow-sm p-3 bg-white rounded">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($employees as $i => $employee)
                <tr class="{{ !$employee['emp_status'] ? 'table-danger' : '' }}">
                    <td>
                        {{ $i + 1 }}
                        @if(!$employee['emp_status'])
                            <i class="text-danger fa-solid fa-circle-xmark" title="Employee is not activated"></i>
                        @endif
                    </td>
                    <td class="fw-semibold">{{ $employee['emp_name'] }}</td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-secondary" onclick="changeUser($employee['id'])" title="Change Username">
                                <i class="fa-solid fa-user-pen"></i>
                            </button>
                            <span class="user-field">{{ $employee['emp_username'] }}</span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-sm btn-outline-primary" onclick="changePassword($employee['id'])" title="Change Password">
                                <i class="fa-solid fa-key"></i>
                            </button>
                            <span class="password-field">{{ $employee['emp_password'] }}</span>
                        </div>
                    </td>
                    <td class="text-capitalize">{{ $employee['jobrole']['job_role_title'] }}</td>
                    <td>
                        <button 
                            class="btn btn-sm {{ $employee['emp_status'] ? 'btn-success' : 'btn-danger' }}" 
                            onclick="switch_status(this, $employee['id'])"
                        >
                            {{ $employee['emp_status'] ? 'Active' : 'Disabled' }}
                        </button>
                    </td>
                    <td class="text-nowrap text-center">
                        <a href="tel:+{{ $employee['emp_contact'] }}" class="text-primary me-2" title="Call">
                            <i class="fa-solid fa-phone"></i>
                        </a>
                        <a href="mailto:{{ $employee['emp_email'] }}" class="text-secondary me-2" title="Email">
                            <i class="fa-solid fa-envelope"></i>
                        </a>
                        <a href="https://wa.me/91{{ $employee['emp_contact'] }}" target="_blank" class="text-success me-2" title="WhatsApp">
                            <i class="fa-brands fa-whatsapp"></i>
                        </a>
                        <a href="/admin/employee/edit/{{ $employee['id'] }}" class="text-warning" title="Edit Employee">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</main>
@endsection

@push('script')
<script>
    function switch_status(node, empId) {
        ajax({
            url: "/api/employee/status/" + empId,
            success: (res) => {
                res = JSON.parse(res);
                if (res.success) {
                    const row = node.closest("tr");
                    row.classList.toggle("table-danger");
                    node.classList.toggle("btn-success");
                    node.classList.toggle("btn-danger");
                    node.textContent = node.textContent === 'Active' ? 'Disabled' : 'Active';
                }
            }
        });
    }

    function changePassword(empId) {
        let newPassword = prompt("Enter new password:");
        if (newPassword) {
            fetch(`/api/employee/change-password/${empId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ password: newPassword })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Password updated successfully!");
                    location.reload();
                } else {
                    alert("Error updating password.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Server Error");
            });
        }
    }

    function changeUser(empId) {
        let newUsername = prompt("Enter new username:");
        if (newUsername) {
            fetch(`/api/employee/change-username/${empId}`, {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                },
                body: JSON.stringify({ username: newUsername })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert("Username updated successfully!");
                    location.reload();
                } else {
                    alert("Error updating username.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Server Error");
            });
        }
    }
</script>
@endpush
