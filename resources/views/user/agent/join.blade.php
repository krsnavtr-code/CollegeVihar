
@extends('user.info.layout')
@php
    $page_title = '';
@endphp

@push('css')
<style>

    .breadcrumb{
        display: none;
    }

    main {
        margin: 20px;
        font-family: Arial, sans-serif;
    }

    h2 {
        text-align: center;
        color: #333;
        margin-bottom: 20px;

    }


    form {
        max-width: 900px;
        margin: auto;
        background: #f9f9f9;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
        margin-bottom: 15px;
    }

    .form-row .form-group {
        width: calc(50% - 10px); /* Two fields in one row */
        margin-bottom: 15px;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        font-size: 14px;
        color: #333;
    }

    .form-group input, 
    .form-group select {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        box-sizing: border-box;
    }


    .form-group input[type="file"] {
        padding: 5px;
    }

    .joinbtn {
        width: calc(33% - 10px);
        padding: 10px;
        background-color: #ff5722;
        color: white;
        border: none;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        margin: 10px 5px 0 0;
    }

    .joinbtn:hover {
        background-color: #e64a19;
    }

    .image-preview {
        display: flex;
        flex-direction: column;
        align-items: center;
        margin-bottom: 15px;
    }

    .image-preview img {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ccc;
        margin-bottom: 10px;
    }


    .note {
        font-size: 12px;
        color: red;
        text-align: center;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .form-row .form-group {
            width: 100%;
        }

        .joinbtn {
            width: 100%;
        }
    }


</style>
@endpush


@section('main_section')
<main>
<h2>Business Partner Application Form</h2>

<form  action="/agent/join" method="POST" enctype="multipart/form-data">
    @csrf

    <!-- Image Preview -->
    <div class="image-preview">
        <img id="preview-image" src="https://via.placeholder.com/120" alt="Employee Photo">
        <button type="button" id="camera-button">
            <i class="fa-solid fa-camera"></i>
        </button>
        {{-- <span class="note">Only JPEG and PNG image type is allowed. Max size: 2 MB</span> --}}
    </div>

    <!-- Image Upload -->
    <div class="form-row">
        <div class="form-group">
            <label for="emp_pic">Image:</label>
            <input type="file" id="emp_pic" name="emp_pic" accept="image/jpeg, image/png" required onchange="previewImage(event)">
        </div>
    </div>

    <!-- Name and Job Role -->
    <div class="form-row">
        <div class="form-group">
            <label for="emp_name">Name:</label>
            <input type="text" id="emp_name" name="emp_name" required>
        </div>
        <div class="form-group">
            <label for="emp_job_role">Job Role:</label>
            <select id="emp_job_role" name="emp_job_role" required>
                <option value="Agent">Agent</option>
            </select>
        </div>
    </div>

    <!-- Email and Branch -->
    <div class="form-row">
        <div class="form-group">
            <label for="emp_email">Email:</label>
            <input type="email" id="emp_email" name="emp_email" value="{{ $email ?? '' }}" required>
        </div>
        <div class="form-group">
            <label for="emp_phone">Phone:</label>
            <input type="text" id="emp_phone" name="emp_phone" value="{{ $phone ??  '' }}" required>
        </div>
    </div>

    <!-- State and District Selection -->
    <div class="form-row">
        <div class="form-group">
            <label for="state-select">State:</label>
            <select id="state-select" required>
                <option value="">Select State</option>
            </select>
        </div>
        <div class="form-group">
            <label for="district-select">District:</label>
            <select id="district-select" required>
                <option value="">Select District</option>
            </select>
        </div>
        <div class="form-group">
            <label for="emp_location">Location:</label>
            <input type="text" id="emp_location" name="emp_location" readonly required>
        </div>
    </div>

    <!-- Salary and Referral Code -->
    <div class="form-row">
        <div class="form-group">
            <label for="referral_code">Referral Code:</label>
            <input type="text" id="referral_code" name="referral_code" value="{{ $savedReferralCode ?? '' }}" readonly >
        </div>
    </div>

    <button type="submit" class="joinbtn">Join</button>
    {{-- <button type="reset">Reset</button>
    <button type="button" onclick="window.history.back()">Back</button> --}}

</form>
</main>

@push('script')
<script>
    
    // Preview selected image
    function previewImage(event) {
        const file = event.target.files[0];
        const preview = document.getElementById('preview-image');
        const maxSize = 8 * 1024 * 1024; // 8 MB

        if (file) {
            if (file.size > maxSize) {
                alert("File size exceeds 8 MB!");
                event.target.value = '';
                preview.src = "https://via.placeholder.com/120";
                return;
            }

            const validTypes = ['image/jpeg', 'image/png'];
            if (!validTypes.includes(file.type)) {
                alert("Only JPEG and PNG formats are allowed!");
                event.target.value = '';
                preview.src = "https://via.placeholder.com/120";
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    }

    // Open camera for image capture
    document.getElementById('camera-button').addEventListener('click', () => {
        const input = document.createElement('input');
        input.type = 'file';
        input.accept = 'image/*';
        input.capture = 'camera'; // Enables the camera for mobile devices
        input.onchange = previewImage;
        input.click();
    });
</script>

<script>
    const stateSelect = document.getElementById('state-select');
    const districtSelect = document.getElementById('district-select');

    // Fetch states
    fetch('/api/getstates')
        .then(response => response.json())
        .then(data => {
            if (data && data.states) {
                data.states.forEach(state => {
                    const option = document.createElement('option');
                    option.value = state.state_id; // Use state_id as the value
                    option.textContent = state.state_name; // Display state name
                    stateSelect.appendChild(option);
                });
            }
        })
        .catch(error => {
            console.error('Error fetching states:', error);
        });

    // Fetch districts based on selected state
    stateSelect.addEventListener('change', () => {
        const selectedStateId = stateSelect.value; // Get state_id
        districtSelect.innerHTML = '<option value="">Select District</option>'; // Reset districts

        if (selectedStateId) {
            fetch(`/api/getdistricts/${selectedStateId}`)
                .then(response => response.json())
                .then(data => {
                    if (data && data.districts) {
                        data.districts.forEach(district => {
                            const option = document.createElement('option');
                            option.value = district.district_name; // Use district name as value
                            option.textContent = district.district_name; // Display district name
                            districtSelect.appendChild(option);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error fetching districts:', error);
                });
        }
    });

    // Update emp_location value when district is selected
    districtSelect.addEventListener('change', function () {
        const state = stateSelect.options[stateSelect.selectedIndex].text; // Get state name
        const district = districtSelect.options[districtSelect.selectedIndex].text; // Get district name

        if (state && district && state !== 'Select State' && district !== 'Select District') {
            // Dynamically set the emp_location value
            document.getElementById('emp_location').value = `${district}, ${state}`;
        }
    });
</script>
@endpush
@endsection
