@php
$page_title = 'Job Requirement';
@endphp

@push('css')
<style>
    .option-container {
        display: grid;
        grid-template-columns: repeat(3,1fr);
        padding: 2rem;
        gap: 2rem;
        background-color: #5394f3;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        margin: 2rem auto;
        max-width: 800px;
        text-align: center;
    }

    .option {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        background-color: #f1f1f1;
        border-radius: 10px;
        cursor: pointer;
        transition: transform 0.3s;
    }

    .option:hover {
        transform: scale(1.05);
    }

    .option label {
        display: block;
        font-size: 1.2em;
    }

    .option input[type="radio"] {
        display: none;
    }

    .option input[type="radio"]+label::before {
        content: " ";
        display: inline-block;
        width: 20px;
        height: 20px;
        margin-right: 10px;
        border: 2px solid #007bff;
        border-radius: 50%;
        vertical-align: middle;
        background-color: #fff;
    }

    .option input[type="radio"]:checked label::before {
        background-color: #007bff;
    }

    .header {
        text-align: center;
        margin-bottom: 20px;
        font-size: 1.5em;
    }

    @media only screen and (max-width: 600px) {
        .option-container {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <div class="header">
        <h2>What do you want to do?</h2>
    </div>
    <div class="option-container">
        <form action="{{ url('/consultant') }}" method="get" class="option p-3">
            <img src="{{ asset('images/job/svg/consultant.svg') }}" alt="Hire Intern">
            <input type="radio" id="consultant" name="jobType" value="consultant" onclick="this.form.submit()">
            <label for="consultant mb-3">
                We are Consultant
            </label>
        </form>
        <form action="{{ url('/company') }}" method="get" class="option p-3">
            <img src="{{ asset('images/job/svg/company.svg') }}" alt="Hire Intern">
            <input type="radio" id="company" name="jobType" value="company" onclick="this.form.submit()">
            <label for="company mb-3">
                We are Company
            </label>
        </form>
        <form action="{{ url('/freelancer') }}" method="get" class="option p-3">
            <img src="{{ asset('images/job/svg/freelancer.svg') }}" alt="Hire Intern">
            <input type="radio" id="freelancer" name="jobType" value="freelancer" onclick="this.form.submit()">
            <label for="freelancer mb-3">
                We are Freelancer Recruiter
            </label>
        </form>
    </div>
</main>
@endsection

{{--
    <!-- The Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Registration</h2>
            <form action="{{ url('/register') }}" method="POST">
@csrf
<div class="form-group">
    <label for="fullName">Full Name</label>
    <input type="text" id="fullName" name="fullName" required>
</div>
<div class="form-group">
    <label for="email">Email Id</label>
    <input type="email" id="email" name="email" required>
</div>
<div class="form-group">
    <label for="phone">Phone No.</label>
    <input type="tel" id="phone" name="phone" pattern="\d{10}" maxlength="10" title="Phone number should be 10 digits only" required>
</div>
<button type="submit" class="btn">Register</button>
</form>
</div>
</div>
</main>
@endsection --}}
{{--
@push('script')
<script>
function openModal(type) {
    document.getElementById('myModal').style.display = "block";
    document.querySelector('input[name="jobType"][value="' + type + '"]').checked = true;
}

function closeModal() {
    document.getElementById('myModal').style.display = "none";
}

// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    if (event.target == document.getElementById('myModal')) {
        document.getElementById('myModal').style.display = "none";
    }
}
</script>
@endpush --}}