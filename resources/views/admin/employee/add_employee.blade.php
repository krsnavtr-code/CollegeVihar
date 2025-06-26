@extends('admin.components.layout')

@section('main')
<main class="container py-4">
    @include('admin.components.response')

    <form action="/admin/employee/add" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Add New Employee</h4>
                <p class="text-muted">Fill out the details to add a new employee to the system.</p>

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <label for="pp" class="d-inline-block cursor-pointer">
                        <img id="profilePreview" src="/images/profile/profile 1.jpg" alt="Profile" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ddd;">
                    </label>
                    <input type="file" id="pp" name="profile_image" class="d-none" accept="image/*" onchange="display_pic(this)">
                    <div class="form-text">Click on the image to change profile picture</div>
                </div>

                <!-- Basic Info -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Employee Name</label>
                        <input type="text" class="form-control" name="emp_name" required placeholder="John Doe">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Employee Username <small class="text-muted">(any unique name)</small></label>
                        <input type="text" class="form-control" name="emp_username" required placeholder="john_doe">
                    </div>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Date of Birth</label>
                        <input type="date" class="form-control" name="emp_dob" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Gender</label>
                        <select class="form-select" name="emp_gender" required>
                            <option value="" disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="transgender">Transgender</option>
                        </select>
                    </div>
                </div>

                <!-- Contact Info -->
                <div class="mb-3">
                    <label class="form-label">Phone Number <small class="text-muted">(Personal)</small></label>
                    <input type="text" class="form-control" name="emp_contact" required placeholder="9876543210">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Personal Email</label>
                        <input type="email" class="form-control" name="emp_email" placeholder="email@example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Email</label>
                        <input type="email" class="form-control" name="emp_company_email" placeholder="official@example.com">
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="emp_address" placeholder="Current Address">
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <select class="form-select" name="emp_state" required>
                        <option value="" disabled selected>Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Employment Info -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Joining Date</label>
                        <input type="date" class="form-control" name="emp_joining_date" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Salary</label>
                        <input type="number" class="form-control" name="emp_salary" placeholder="Salary">
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Job Role <small class="text-muted">(Contact Developer for new roles)</small></label>
                    <select class="form-select" name="emp_job_role" required>
                        <option value="" disabled selected>Select Job Role</option>
                        @foreach ($job_roles as $job_role)
                            @if (!$job_role['role_sensitive'])
                                <option value="{{ $job_role['id'] }}">{{ $job_role['job_role_title'] }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label">Password <small class="text-muted">(Only developers can change it later)</small></label>
                    <input type="password" class="form-control" name="emp_password" required placeholder="Enter Password">
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-lg btn-primary">
                        <i class="fa-solid fa-plus me-1"></i> Add Employee
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>
@endsection

@push('script')
<script>
    function display_pic(input) {
        const preview = document.getElementById('profilePreview');
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
        }
    }
</script>
@endpush
