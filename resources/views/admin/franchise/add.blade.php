@extends('admin.components.layout')

@section('main')
<main class="container py-4">
    @include('admin.components.response')

    <form action="/admin/franchise/add" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <h4 class="card-title mb-3">Add Franchise</h4>
                <p class="text-muted">Enter complete franchise information here.</p>

                <!-- Profile Picture -->
                <div class="text-center mb-4">
                    <label for="pp" class="d-inline-block cursor-pointer">
                        <img id="profilePreview" src="/images/profile/profile 1.jpg" class="rounded-circle shadow" style="width: 120px; height: 120px; object-fit: cover; border: 2px solid #ccc;">
                    </label>
                    <input type="file" id="pp" class="d-none" name="profile_pic" onchange="previewImage(this, 'profilePreview')">
                    <div class="form-text">Click to change profile picture</div>
                </div>

                <!-- Franchise Info -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Franchise Name</label>
                        <input type="text" class="form-control" name="emp_name" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="emp_username" placeholder="Unique Username" required>
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
                            <option disabled selected>Select Gender</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="transgender">Transgender</option>
                        </select>
                    </div>
                </div>

                <!-- Contact & Email -->
                <div class="mb-3">
                    <label class="form-label">Contact Number</label>
                    <input type="text" class="form-control" name="emp_contact" placeholder="10-digit mobile number" required>
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Personal Email</label>
                        <input type="email" class="form-control" name="emp_email" placeholder="user@example.com">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Company Email</label>
                        <input type="email" class="form-control" name="emp_company_email" placeholder="official@company.com">
                    </div>
                </div>

                <!-- Address -->
                <div class="mb-3">
                    <label class="form-label">Address (As per Aadhar)</label>
                    <input type="text" class="form-control" name="emp_address" placeholder="Full address" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <select class="form-select" name="emp_state" required>
                        <option disabled selected>Select State</option>
                        @foreach ($states as $state)
                            <option value="{{ $state['id'] }}">{{ $state['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Joining & Commission -->
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Joining Date</label>
                        <input type="date" class="form-control" name="emp_joining_date">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Commission</label>
                        <input type="text" class="form-control" name="emp_salary" placeholder="e.g. 10%">
                    </div>
                </div>

                <!-- Aadhar Details -->
                <h5 class="mt-4">Aadhar Details</h5>
                <div class="mb-3">
                    <label class="form-label">Aadhar Number</label>
                    <input type="number" class="form-control" name="aadhar_number" placeholder="12-digit Aadhar">
                </div>

                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label for="aadhar_front" class="form-label">Front Side</label>
                        <input type="file" class="form-control" name="aadhar_front" id="aadhar_front" onchange="previewImage(this, 'aadharFrontPreview')">
                        <img id="aadharFrontPreview" class="img-fluid mt-2 border" style="max-height: 150px;">
                    </div>
                    <div class="col-md-6">
                        <label for="aadhar_back" class="form-label">Back Side</label>
                        <input type="file" class="form-control" name="aadhar_back" id="aadhar_back" onchange="previewImage(this, 'aadharBackPreview')">
                        <img id="aadharBackPreview" class="img-fluid mt-2 border" style="max-height: 150px;">
                    </div>
                </div>

                <!-- PAN Details -->
                <h5 class="mt-4">PAN Details</h5>
                <div class="mb-3">
                    <label class="form-label">PAN Number</label>
                    <input type="text" class="form-control" name="pan_number" placeholder="ABCDE1234F">
                </div>

                <div class="mb-3">
                    <label for="pan_pic" class="form-label">PAN Card Image</label>
                    <input type="file" class="form-control" name="pan_pic" id="pan_pic" onchange="previewImage(this, 'panPreview')">
                    <img id="panPreview" class="img-fluid mt-2 border" style="max-height: 150px;">
                </div>

                <!-- Bank Details -->
                <h5 class="mt-4">Bank Details</h5>
                <div class="row g-3 mb-3">
                    <div class="col-md-6">
                        <label class="form-label">Account Number</label>
                        <input type="text" class="form-control" name="account_number" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">IFSC Code</label>
                        <input type="text" class="form-control" name="ifsc" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">UPI ID</label>
                    <input type="text" class="form-control" name="upi" placeholder="abc@upi">
                </div>

                <div class="mb-3">
                    <label class="form-label">Bank Passbook Photo</label>
                    <input type="file" class="form-control" name="bank_pic" id="bank_pic" onchange="previewImage(this, 'bankPreview')">
                    <img id="bankPreview" class="img-fluid mt-2 border" style="max-height: 150px;">
                </div>

                <!-- Password & Status -->
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" name="emp_password" placeholder="Set Password" required>
                </div>

                <div class="form-check mb-4">
                    <input class="form-check-input" type="checkbox" name="fran_status" id="fran_status" value="1">
                    <label class="form-check-label" for="fran_status">
                        Activate this Franchise
                    </label>
                </div>

                <!-- Submit -->
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="fa-solid fa-plus me-1"></i> Add Franchise
                    </button>
                </div>
            </div>
        </div>
    </form>
</main>
@endsection

@push('script')
<script>
    function previewImage(input, imgId) {
        const preview = document.getElementById(imgId);
        if (input.files && input.files[0]) {
            preview.src = URL.createObjectURL(input.files[0]);
        }
    }
</script>
@endpush
