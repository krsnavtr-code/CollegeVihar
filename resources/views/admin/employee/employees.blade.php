@extends('admin.components.layout')
@section('main')
    <!-- Job Employee -->
    <!-- <main class="container py-4">
        <h2 class="text-center mb-4">View Employees</h2>

        <div class="table-responsive shadow-lg p-3 bg-white rounded">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
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
                        <tr class="{{ !$employee['emp_status'] ? 'table-danger' : '' }}">
                            <td>
                                {{ $i + 1 }}
                                @if(!$employee['emp_status'])
                                    <i class="text-danger fa-solid fa-circle-xmark" title="Employee is not activated"></i>
                                @endif
                            </td>
                            <td class="fw-bold">{{ $employee['emp_name'] }}</td>
                            <td>{{ $employee['emp_username'] }}</td>
                            <td class="text-capitalize">{{ $employee['jobrole']['job_role_title'] }}</td>
                            <td>
                                <button class="btn btn-sm {{ $employee['emp_status'] ? 'btn-success' : 'btn-danger' }}"
                                    onclick="switch_status(this, {{ $employee['id'] }})">
                                    {{ $employee['emp_status'] ? 'Active' : 'Disabled' }}
                                </button>
                            </td>
                            <td class="text-nowrap">
                                <a href="tel:+{{ $employee['emp_contact'] }}" class="text-primary me-2" title="Call">
                                    <i class="fa-solid fa-phone"></i>
                                </a>
                                <a href="mailto:{{ $employee['emp_email'] }}" class="text-secondary me-2" title="Email">
                                    <i class="fa-solid fa-envelope"></i>
                                </a>
                                <a href="https://wa.me/91{{ $employee['emp_contact'] }}" target="_blank"
                                    class="text-success me-2" title="WhatsApp">
                                    <i class="fa-brands fa-whatsapp"></i>
                                </a>
                                <a href="/admin/employee/edit/{{ $employee['id'] }}" class="text-warning" title="Edit">
                                    <i class="fa-solid fa-pencil"></i>
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
    @endpush -->




    <!-- By krishna -->
     <main class="container py-4">
    <h2 class="text-center mb-4">View Employees</h2>

    <div class="table-responsive shadow-lg p-3 bg-white rounded">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Sr.No.</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Password</th> <!-- New Column -->
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
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
                        <td class="fw-bold">{{ $employee['emp_name'] }}</td>
                        <td>{{ $employee['emp_username'] }}</td>
                        <td>
                            <span class="password-field" data-password="{{ $employee['emp_password'] }}">••••••••</span>
                            <button class="btn btn-sm btn-outline-secondary" onclick="togglePassword(this)">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                            <button class="btn btn-sm btn-outline-primary" onclick="changePassword({{ $employee['id'] }})">
                                <i class="fa-solid fa-key"></i>
                            </button>
                        </td>
                        <td class="text-capitalize">{{ $employee['jobrole']['job_role_title'] }}</td>
                        <td>
                            <button class="btn btn-sm {{ $employee['emp_status'] ? 'btn-success' : 'btn-danger' }}"
                                onclick="switch_status(this, {{ $employee['id'] }})">
                                {{ $employee['emp_status'] ? 'Active' : 'Disabled' }}
                            </button>
                        </td>
                        <td class="text-nowrap">
                            <a href="tel:+{{ $employee['emp_contact'] }}" class="text-primary me-2" title="Call">
                                <i class="fa-solid fa-phone"></i>
                            </a>
                            <a href="mailto:{{ $employee['emp_email'] }}" class="text-secondary me-2" title="Email">
                                <i class="fa-solid fa-envelope"></i>
                            </a>
                            <a href="https://wa.me/91{{ $employee['emp_contact'] }}" target="_blank"
                                class="text-success me-2" title="WhatsApp">
                                <i class="fa-brands fa-whatsapp"></i>
                            </a>
                            <a href="/admin/employee/edit/{{ $employee['id'] }}" class="text-warning" title="Edit">
                                <i class="fa-solid fa-pencil"></i>
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


    function togglePassword(button) {
        let passwordSpan = button.previousElementSibling;
        if (passwordSpan.textContent === "••••••••") {
            passwordSpan.textContent = passwordSpan.getAttribute("data-password");
            button.innerHTML = '<i class="fa-solid fa-eye-slash"></i>';
        } else {
            passwordSpan.textContent = "••••••••";
            button.innerHTML = '<i class="fa-solid fa-eye"></i>';
        }
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
                console.log(data);
                if (data.success) {
                    alert("Password updated successfully!");
                } else {
                    alert("Error updating password.");
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Error updating password.");
            });
        }
    }
</script>
@endpush

@endsection