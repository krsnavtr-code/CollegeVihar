@php
$page_title = 'Job Requirement Details';
@endphp

@push('css')
<style>
    body {
        scroll-behavior: smooth;
    }

    main {
        background: #f4f5f9;
    }

    .job-container {
        padding: 4rem 0;
        width: 90%;
        margin: auto;
        display: flex;
        flex: 1;
        gap: 1rem;
    }

    /* interducing */
    .interducing {
        margin: 4rem 0;
        position: sticky;
        top: 26%;
        text-transform: capitalize;
    }

    .interducing .meter-box {
        display: flex;
    }

    .meter-box small {
        white-space: nowrap;
    }


    .interducing h5 {
        font-weight: 600;
        color: #0056b3;
    }

    .interducing h2 {
        margin: 1rem 0 2rem;
        color: #0056b3;
        font-weight: 600;
    }

    .flex {
        display: flex;
        gap: 1rem;
    }

    .between {
        display: flex;
        justify-content: space-between;
    }

    .interducing h6 {
        font-weight: 600;
        font-size: 14px;
    }

    .interducing .blue {
        border-radius: 10px;
        margin: 1rem 0;
        padding: 1rem;
        background-color: #f4f5f9;
    }

    .interducing p {
        color: gray;
    }

    .job-container aside {
        padding: 1rem;
        position: relative;
    }

    .job-container .panel {
        padding: 2rem;
        margin-bottom: 3rem;
        border-radius: 1rem;
        box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
        background: #fff !important;
    }

    .job-container h2 {
        font-size: 16px;
        color: #3f51b5;
        font-weight: 600;
    }

    .job-container h3 {
        font-size: 16px;
        font-weight: 400;
    }

    .form-group {
        margin: 0 !important;
        position: relative;
    }

    .form-group label {
        margin: 2rem 0 1rem;
        font-size: 16px;
        font-weight: 500;
        line-height: 20px;
        display: flex;
        align-items: center;
        white-space: nowrap;
        gap: 3px;
        cursor: pointer;
    }

    .form-group label span {
        color: red;
    }

    .form-group label small {
        color: gray;
    }

    .form-group textarea {
        width: 70%;
    }

    .form-group input,
    .form-group select {
        padding-left: 1rem;
        text-transform: capitalize;
        width: 50%;
        height: 35px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .about-company select,
    .about-company input {
        width: 100%;
    }

    .radio-group {
        display: flex;
        gap: 1rem;
        align-items: center;
    }

    .experience .radio-group label {
        border: 1px solid grey;
        border-radius: 6px;
        padding: 1rem 2rem;
        cursor: pointer;
        color: gray;
        margin: 0;
    }

    .experience .radio-group input {
        display: none;
    }

    .experience .radio-group input[type="radio"]:checked+label {
        color: blue;
        border: 1px solid #0056b3;
        /* Change to match the color you want */
    }


    .range {
        display: flex;
        overflow: hidden;
    }

    .range input {
        width: auto;
        outline: none;
        color: gray;
        text-transform: uppercase;
    }

    .range span {
        padding: 6px;
        display: flex;
        text-transform: capitalize;
        background-color: #f4f5f9;
    }

    .note {
        color: red;
        display: block;
    }

    .bonus input {
        width: 20px;
        height: 20px;
    }

    .radio-group label {
        margin: 0;
    }

    small {
        color: gray;
    }

    .timings {
        display: flex;
        gap: 1rem;
    }

    #interviewDetails {
        width: 300px;
    }

    .form-control {
        display: block;
        width: 100%;
        padding: 10px;
        font-size: 16px;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        background-clip: padding-box;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-check-input {
        width: 20px;
        height: 20px;
        margin-right: 10px;
    }

    .form-check-label {
        margin-bottom: 0;
        font-size: 1rem;
        cursor: pointer;
    }

    .about-company .form-group {
        flex: 1;
        min-width: 250px;
        margin-right: 20px;
    }

    .about-company .form-group:last-child {
        margin-right: 0;
    }

    .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }


    .form-footer .checkbox-group label {
        margin: 0;
        margin-left: 1rem;
    }

    .form-footer .btn-submit {
        width: 200px;
        background-color: #007bff;
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        margin-top: 1rem;
        transition: background-color 0.3s;
    }

    .form-footer .btn-submit:hover {
        background-color: #0056b3;
    }

    .autocomplete-list {
        border: 1px solid #ccc;
        border-radius: 4px;
        max-height: 150px;
        overflow-y: auto;
        background-color: #fff;
        position: absolute;
        z-index: 1000;
        width: 70%;
        top: 100%;
        left: 15%;
    }

    .autocomplete-item {
        padding: 10px;
        cursor: pointer;
    }

    .autocomplete-item:hover {
        background-color: #f1f1f1;
    }

    /* Styling for Find Jobs section */
    .find-jobs-section {
        text-align: center;
        margin-top: 40px;
    }

    .find-jobs-section h3 {
        color: #333;
        font-size: 1.2em;
    }

    .find-jobs-button {
        width: 200px;
        background-color: #007bff;
        /* Blue color for the button */
        color: white;
        border: none;
        padding: 1rem;
        border-radius: 4px;
        cursor: pointer;
        font-size: 12px;
        transition: background-color 0.3s;
    }

    .find-jobs-button:hover {
        background-color: #0056b3;
    }

    @media only screen and (max-width:1024px) {

        .timings,
        .job-container {
            flex-direction: column;
        }
        select,input{
            width: 100%;
        }

    }
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <div class="job-container">

        <form method="POST" action="{{ route('job.requirements.store') }}">
            @csrf
            <h2>Basic Job Details</h2>
            <div class="panel">
                <div class="form-group">
                    <label for="jobTitle">Job Title<span>*</span></label>
                    <input type="text" id="jobTitle" name="jobTitle" class="form-control" placeholder="Enter the Job Title" required>
                </div>
                <div class="form-group">
                    <label for="jobLocation">Job Location<span>*</span></label>
                    <input type="text" id="jobLocation" name="jobLocation" class="form-control" placeholder="Pick Your City" list="city-list" required>
                    <datalist id="city-list"></datalist>
                </div>
                <div class="form-group">
                    <label for="openings">No Of Openings<span>*</span></label>
                    <input type="number" id="openings" name="openings" class="form-control short-input" placeholder="Eg. 2" required>
                </div>
            </div>

            <h3>Candidate Requirement</h3>
            <div class="panel">
                <div class="form-group experience">
                    <label>Total Experience of Candidate <span>*</span></label>
                    <div class="radio-group">
                        <input id="any" type="radio" name="experience" value="any" required>
                        <label for="any">Any</label>
                        <input id="freshers" type="radio" name="experience" value="freshers" required>
                        <label for="freshers">Freshers Only</label>
                        <input id="experienced" type="radio" name="experience" value="experienced" required>
                        <label for="experienced">Experienced Only</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="education">Education Required<span>*</span></label>
                    <select id="education" name="education" class="form-control" required>
                        <option value="">Select Education Level</option>
                        <option value="high_school">High School</option>
                        <option value="bachelors">Bachelor's Degree</option>
                        <option value="masters">Master's Degree</option>
                        <option value="phd">PhD</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="salary">Monthly In-hand Salary<span>*</span> <small>(Only Put Actual Salary)</small></label>
                    <div class="range">
                        <input type="number" id="min-salary" min="10000" placeholder="eg: 10,000/-">
                        <span>to</span>
                        <input type="number" id="max-salary" min="15000" placeholder="eg: 15,000/-">
                    </div>
                    <small class="note">Please Enter Minimum Salary</small>
                    <!-- <select id="salary" name="salary" class="form-control" required>
                        <option value="5000-10000">5000-10000</option>
                        <option value="10000-20000">10000-20000</option>
                        <option value="20000-50000">20000-50000</option>
                        <option value=">50000">More than 50000</option>
                    </select> -->
                </div>
                <div class="form-group bonus">
                    <label>Do you offer bonus in addition to monthly salary?</label>
                    <div class="radio-group">
                        <input type="radio" name="bonus" value="yes" id="yes" required>
                        <label for="yes">Yes</label>
                        <input type="radio" name="bonus" value="no" id="no" required>
                        <label for="no">No</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jobInfo">Job Info / Job Description<span>*</span></label>
                    <textarea id="jobInfo" name="jobInfo" class="form-control" rows="3" cols="6" required></textarea>
                    <small>Remaining characters: 350</small>
                </div>
                <div class="form-group">
                    <label for="skills">Skills</label>
                    <input type="text" id="skills" name="skills" class="form-control" placeholder="type to serch skills" style="width: 100%;">
                </div>
            </div>

            <h2>Timings</h2>
            <div class="panel timings">
                <div class="form-group">
                    <label for="jobTimings">Job Timings<span>*</span></label>
                    <div class="range">
                        <input type="datetime-local" name="jobTimings" id="jobTimings-start">
                        <span>to</span>
                        <input type="datetime-local" name="jobTimings" id="jobTimings-end">
                    </div>
                    <small>Please mention job timings correctly otherwise candidates may not join</small>
                </div>
                <div class="form-group">
                    <label for="interviewDetails">Interview Details<span>*</span></label>
                    <textarea id="interviewDetails" name="interviewDetails" class="form-control" rows="4" required></textarea>
                </div>
            </div>

            <h3>About Your Company</h3>
            <div class="panel about-company">
                <div class="form-row">
                    <div class="form-group">
                        <label for="companyName">Company Name<span>*</span></label>
                        <input type="text" id="companyName" name="companyName" class="form-control" placeholder="Eg. Eloquent info Solutions" required>
                    </div>
                    <div class="form-group">
                        <label for="contactPersonName">Contact Person Name<span>*</span></label>
                        <input type="text" id="contactPersonName" name="contactPersonName" class="form-control" placeholder="Eg. Nilesh" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="phoneNumber">Phone Number<span>*</span></label>
                        <input type="tel" id="phoneNumber" name="phoneNumber" class="form-control" pattern="[0-9]{10}" required>
                        <small>Phone number should be 10 digits.</small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email Id<span>*</span></label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Eg. eloquent@gmail.com" required>
                        <small>Candidates will send resumes on this email-id.</small>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="contactPersonProfile">Contact Person Profile <span>*</span></label>
                        <select name="contactPersonProfile" id="contactPersonProfile">
                            <option selected disabled>HR/Owner....</option>
                            <option value="hr_recruiter">HR/Recruiter</option>
                            <option value="owner_partner">Owner/Partner</option>
                            <option value="manager">Manager</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="organizationSize">Size of Organization <span>*</span></label>
                        <select name="organizationSize" id="organizationSize">
                            <option selected disabled>Choose hiring frequency</option>
                            <option value="1-10">1-10</option>
                            <option value="1-10">11-50</option>
                            <option value="1-10">51-100</option>
                            <option value="1-10">more then 100</option>
                        </select>
                    </div>
                </div>
                <div class="form-group">
                    <label for="jobAddress">Job Address<span>*</span></label>
                    <textarea id="jobAddress" name="jobAddress" class="form-control" rows="3" placeholder="Please fill complete address, mention Landmark near your office" required></textarea>
                    <small>Please fill complete address, mention Landmark near your office</small>
                </div>
            </div>

            <div class="form-footer">
                <div class="checkbox-group">
                    <input type="checkbox" id="terms" name="terms" class="form-check-input" required>
                    <label for="terms">I Accept <a href="#">Terms And Conditions</a> and <a href="#">Privacy Policy</a><span>*</span></label>
                    <small class="note">Asking job seeker for any kind of payment is strictly prohibited.</small>
                </div>
                <button type="submit" class="btn-submit">Submit</button>
            </div>

            <!-- New Find Jobs Section -->
            <div class="find-jobs-section">
                <h3>ARE YOU LOOKING FOR A JOB?</h3>
                <button class="find-jobs-button">FIND JOBS</button>
            </div>
        </form>

        <aside>
            <article class="panel interducing">
                <h6>interducing</h6>
                <h2>Performance Insights Hub</h2>
                <h5>Job Reach Meter</h5>
                <figure>
                    <div class="meter-box">
                        <div>
                            <img src="https://resources.workindia.in/employer/assets/icon/ic_default_meter_92_47.svg" alt="">
                            <small>not enough data</small>
                        </div>
                        <p>Based on your requirement parameters</p>
                    </div>
                    <div class="blue">
                        <p>Salary trends for your requirements are shown here</p>
                        <div class="between">
                            <div>
                                <h6>Minimum Salary</h6>
                                <span>___</span>
                            </div>
                            <div>
                                <h6>Maximum Salary</h6>
                                <span>___</span>
                            </div>
                        </div>
                    </div>
                </figure>
            </article>
        </aside>

    </div>

</main>

@push('script')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    function fetchCities() {
        $.ajax({
            url: '/fetch-cities',
            method: 'GET',
            success: function(response) {
                let cities = response.geonames;
                let options = cities.map(city => `<option value="${city.name}">${city.name}</option>`);
                $('#city-list').html(options);
            },
            error: function(error) {
                console.error('Error fetching cities:', error);
            }
        });
    }

    $(document).ready(function() {
        fetchCities();
    });
</script>
@endpush
@endsection