@php
    $page_title = 'Employee Details Page';
@endphp

@push('css')
 <style>
     .container2 {
    max-width: 800px;
    margin: 0 auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 8px;
    margin-top: -74px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
}

header {
    display: flex;
    justify-content: flex-end;
    padding: 10px;
}

.welcome {
    font-size: 16px;
    font-weight: bold;
}

main {
    padding: 20px;
}

h2 {
    font-size: 30px;
    margin-bottom: 10px;
    text-align: center;
}

p {
    font-size: 18px;
    color: #666;
    margin-bottom: 20px;
    text-align: center;
}

.form-group {
    margin-bottom: 15px;
}

        .form-group label {
            display: block;
            font-weight: bold;
        }

input[type="text"], select {
    width: calc(100% - 20px);
    padding: 8px 10px;
    margin-bottom: 5px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 14px;
}

.radio-group, .experience-group, .checkbox-group {
    display: flex;
    gap: 10px;
}

.radio-group label, .checkbox-group label {
    display: flex;
    align-items: center;
}

input[type="radio"], input[type="checkbox"] {
    margin-right: 5px;
}
.form-group input[type="text"], .form-group select, .form-group textarea, .form-group input[type="file"] {
            width: 70%;
            padding: 8px;
            box-sizing: border-box;
            border-radius: 5px;
            border: 1px solid #ccc;
            font-size: 16px;
        }
        .form-group textarea {
            height: 100px; 
            resize: vertical; /
        }
        .form-group input[type="file"] {
            padding: 5px; 
        }
        button[type="submit"] {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            color: #fff;
            background-color: #007bff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
        }
        button[type="submit"]:hover {
            background-color: #0056b3;
        }

</style>
@endpush
@extends('user.info.layout')
@section('main_section')

<main>

    <div class="container2">
        <header>
            <div class="welcome">
                <span id="username"></span>
            </div>
        </header>
        <main>
            @if(Session::has('success'))
            <div class="alert alert-success">
                {{ Session::get('success') }}
            </div>
            @endif
            <form method="POST" action="/employment-details-submit" enctype="multipart/form-data">
                @csrf
                <h2 style="text-align: center;">Employment Details</h2>
                <p>These details help recruiters identify your professional experience</p>
                <input type="hidden" name="id" value="{{ $id }}">

                <div class="form-group">
                    <label for="full-name">Full Name*</label>
                    <input type="text" id="full-name" name="full_name" required>
                </div>


                 <div class="form-group">
                <label for="gender">Gender*</label>
                <div class="radio-group">
                    <input type="radio" id="male" name="gender" value="male">
                    <label for="male">Male</label>
                    <input type="radio" id="female" name="gender" value="female">
                    <label for="female">Female</label>
                    <input type="radio" id="other" name="gender" value="other">
                    <label for="other">Other</label>
                </div>
              </div>

              <div class="form-group">
                <label for="education">Highest Qualification*</label>
                <div class="qualification-group">
                    <input type="radio" id="phd" name="education" value="Doctorate/PhD">
                    <label for="phd">Doctorate/PhD</label>
                    <input type="radio" id="masters" name="education" value="Masters/Post-Graduation">
                    <label for="masters">Masters/Post-Graduation</label>
                    <input type="radio" id="graduation" name="education" value="Graduation/Diploma">
                    <label for="graduation">Graduation/Diploma</label>
                    <input type="radio" id="12th" name="education" value="12th">
                    <label for="12th">12th</label>
                    <input type="radio" id="10th" name="education" value="10th">
                    <label for="10th">10th</label>
                    <input type="radio" id="below-10th" name="education" value="Below 10th">
                    <label for="below-10th">Below 10th</label>
                </div>
            </div>

                <div class="form-group">
                    <label>Are you currently employed?</label>
                    <div class="radio-group">
                        <input type="radio" id="yes" name="employed" value="yes">
                        <label for="yes">Yes</label>
                        <input type="radio" id="no" name="employed" value="no">
                        <label for="no">No</label>
                    </div>
                </div>

                 <!-- New Employment Type Section -->
                 <div class="form-group">
                    <label for="employment-type">Select Employment Type*</label>
                    <select id="employment-type" name="employment_type" required>
                        <option value="">Select employment type</option>
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                        <option value="WFH">WFH</option>
                        <option value="Intern">Intern</option>
                    </select>
                </div>
                <!-- End of Employment Type Section -->

                <div class="form-group">
                    <label for="work-experience">Total work experience*</label>
                    <div class="experience-group">
                        <select id="work-experience-years" name="work_experience_years">
                            <option value="">Select year</option>
                            @for ($i = 0; $i <= 50; $i++)
                                <option value="{{ $i }}">{{ $i }} year{{ $i != 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        <select id="work-experience-months" name="work_experience_months">
                            <option value="">Select month</option>
                            @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i }}">{{ $i }} month{{ $i != 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="company-name">Company name</label>
                    <input type="text" id="company-name" name="company_name">
                </div>
                <div class="form-group">
                    <label for="job-title">Current job title</label>
                    <input type="text" id="job-title" name="job_title">
                </div>
                <div class="form-group">
                    <label for="current-city">Current city</label>
                    <input type="text" id="current-city" name="current_city">
                </div>
                <div class="form-group">
                    <label for="phone-number">Phone Number*</label>
                    <input type="text" id="phone-number" name="phone_number" maxlength="10" pattern="\d{10}" required>
                </div>
                <div class="form-group">
                    <label for="key-skills">Key skills*</label>
                    <textarea id="key-skills" name="key_skills" placeholder="Key skills are crucial for recruiters to hire you"></textarea>
                </div>
                <div class="form-group">
                    <label for="annual-salary">Annual Salary*</label>
                    <input type="text" id="annual-salary" name="annual_salary" placeholder="Eg. 5,64,000" required>
                </div>

                <div class="form-group">
                    <label for="employee-photo">Photo*</label>
                    <input type="file" id="employee-photo" name="employee_photo">
                </div>
                <div class="form-group">
                    <label for="resume">Resume*</label>
                    <input type="file" id="resume" name="resume">
                </div>
                <button type="submit">Save and Submit</button>
            </form>
        </main>
    </div>
</main>
@endsection

@push('script')
<script>
        document.addEventListener('DOMContentLoaded', function () {
        const yearsDropdown = document.getElementById('work-experience-years');
        const monthsDropdown = document.getElementById('work-experience-months');

        // Function to update the displayed value
        function updateExperienceDisplay() {
            const selectedYear = yearsDropdown.options[yearsDropdown.selectedIndex].text;
            const selectedMonth = monthsDropdown.options[monthsDropdown.selectedIndex].text;
            console.log(`Selected Experience: ${selectedYear}, ${selectedMonth}`);
        }

        // Add event listeners to update display on change
        yearsDropdown.addEventListener('change', updateExperienceDisplay);
        monthsDropdown.addEventListener('change', updateExperienceDisplay);
    });
</script>
@endpush
