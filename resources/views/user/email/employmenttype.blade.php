@php
    $page_title = 'Job Employment';
@endphp

@push('css')
<style>
    .emp-container {
        display: flex;
        flex-direction: row;
        margin: 20px auto;
        max-width: 90%;
        padding: 20px;
    }

    .filter-section {
        width: 30%;
        padding: 15px;
        margin-top: 15px;
        background: rgba(176, 224, 230, 0.8);
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        color: black;
        position: sticky;
        top: 80px;
        height: auto;
    }

    .listing-section {
        width: 70%;
        padding: 15px;
        margin-left: 0;
    }

    .card {
        display: flex;
        flex-direction: column;
        border-radius: 5px;
        padding: 10px;
        box-shadow: 0px 0px 5px rgba(0, 0, 0, 0.2);
        width: 100%;
        background: #ffffff;
        margin-bottom: 20px;
    }

    .card-body {
        display: flex;
        flex-direction: column;
        padding: 10px;
        gap: 16px;
        padding: 1rem 2rem;
    }

    .details {
        display: flex;
        align-items: center;
    }

    .details img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        margin-right: 20px;
    }

    .info {
        display: flex;
        flex-direction: column;
        flex: 1;
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 10px;
    }

    .info p {
        margin: 0;
        font-size: 14px;
        color: #666;
        display: flex;
    }

    .info p i {
        margin-right: 6px;
        color: #1e90ff;
        font-size: 1.6rem;
        width: 20px;
    }

    .info .dynamic-data {
        color: #1e90ff;
    }

    .dynamic-data {
        color: #1e90ff;
    }

    .apply-now {
        text-align: right;
        margin-left: auto;
    }

    .apply-now a {
        text-decoration: none;
    }

    .apply-now button {
        background-color: #1e90ff;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
    }

    .apply-now button:hover {
        background-color: #1c86ee;
    }

    .card h4,
    .card h5 {
        margin: 0;
        font-size: 16px;
        margin-bottom: 10px;
    }
</style>
@endpush

@extends('user.info.layout')
@section('main_section')
<main>
    <h2 style="text-align: center;">Employees for {{ $type }}</h2>
    <div class="emp-container">
        <div class="filter-section">
            <h2>Popular Filters</h2>
            <form action="{{ route('employees.index') }}" method="GET">
                <input type="hidden" name="id" value="{{ request()->query('id') }}">
                <div class="form-group">
                    <label for="job_role">Job Role</label>
                    <input type="text" class="form-control" id="job_role" name="job_role" placeholder="Enter job role">
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="text" class="form-control" id="city" name="city" placeholder="Enter city">
                </div>
                <div class="form-group">
                    <label for="experience">Experience</label>
                    <div class="experience-group">
                        <select id="work-experience-years" name="work_experience_years" class="form-control">
                            <option value="">Select year</option>
                            @for ($i = 0; $i <= 50; $i++)
                                <option value="{{ $i }}">{{ $i }} year{{ $i != 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                        <select id="work-experience-months" name="work_experience_months" class="form-control">
                            <option value="">Select month</option>
                            @for ($i = 0; $i < 12; $i++)
                                <option value="{{ $i }}">{{ $i }} month{{ $i != 1 ? 's' : '' }}</option>
                            @endfor
                        </select>
                    </div>
                </div>

                <!-- New Employment Type Section -->
                <div class="form-group">
                    <label for="employment-type">Employment Type</label>
                    <select id="employment-type" name="employment_type" class="form-control">
                        <option value="">Select employment type</option>
                        <option value="Full Time">Full Time</option>
                        <option value="Part Time">Part Time</option>
                        <option value="WFH">WFH</option>
                        <option value="Intern">Intern</option>
                    </select>
                </div>
                <!-- End of Employment Type Section -->

                <button type="submit" class="btn btn-primary">Apply Filters</button>
            </form>
        </div>
        <div class="listing-section">
            @if(Session::has('success'))
                <div class="alert alert-success">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if(Session::has('error'))
                <div class="alert alert-danger">
                    {{ Session::get('error') }}
                </div>
            @endif

            @if($employees->isEmpty())
                <p>No employees found based on the selected filters.</p>
            @else
                @foreach($employees as $employee)
                    <div class="card">
                        <h4>Name: <span class="dynamic-data">{{ ucfirst($employee->full_name) }}</span></h4>
                        <h5>Job Type: <span class="dynamic-data">{{ ucfirst($employee->job_title) }}</span></h5>
                        <div class="card-body">
                            <div class="details">
                                <img src="{{ $employee->employee_photo ? asset($employee->employee_photo) : asset('images/default/img2.png') }}" alt="Employee Image">
                                <div class="info">
                                    <div class="info-grid">
                                        <p><i class="fas fa-user"></i> Gender: <span class="dynamic-data">{{ ucfirst($employee->gender) }}</span></p>
                                        <p><i class="fas fa-graduation-cap"></i> Education: <span class="dynamic-data">{{ ucfirst($employee->education) }}</span></p>
                                        <p><i class="fas fa-map-marker-alt"></i> Current City: <span class="dynamic-data">{{ ucfirst($employee->current_city) }}</span></p>
                                        <p><i class="fas fa-building"></i> Company: <span class="dynamic-data">{{ ucfirst($employee->company_name) }}</span></p>
                                        <p><i class="fas fa-briefcase"></i> Employment Type: <span class="dynamic-data">{{ ucfirst($employee->employment_type) }}</span></p>
                                        <p><i class="fas fa-clock"></i> Experience: <span class="dynamic-data">{{ ucfirst($employee->work_experience_years) }} years {{ ucfirst($employee->work_experience_months) }} months</span></p>
                                        <p><i class="fas fa-money-bill-wave"></i> Annual Salary: <span class="dynamic-data">{{ ucfirst($employee->annual_salary) }}</span></p>
                                        <p><i class="fas fa-cogs"></i> Skills: <span class="dynamic-data">{{ ucfirst($employee->key_skills) }}</span></p>
                                        <p><i class="fas fa-phone"></i> Phone: <span class="dynamic-data">{{ ucfirst($employee->phone_number) }}</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="apply-now">
                                <a href="downresume/{{ basename($employee->resume_path) . '?id=' . $recruiterId }}">
                                    <button><i class="fa-solid fa-download fa-xs"></i> Download Resume</button>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</main>
@endsection
