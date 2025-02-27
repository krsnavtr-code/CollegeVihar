@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/employee/edit" method="post" enctype="multipart/form-data">
        <h2 class="page_title">Edit Employee</h2>
        <section class="panel">
            @csrf
            <div class="field_group">
                <input type="hidden" name="empId" value="{{ $emp_data['id'] }}">
                <div class="field">
                    <label for="">Employee Name</label>
                    <input type="text" name="emp_name" placeholder="Employee Name"
                        value="{{ $emp_data['emp_name'] }}">
                </div>
                <div class="field">
                    <label for="">Employee Username</label>
                    <input type="text" readonly value="{{ $emp_data['emp_username'] }}">
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="field">
                <label for="">Employee Contact (Phone No.)</label>
                <input type="text" name="emp_contact" placeholder="Employee Contact"
                    value="{{ $emp_data['emp_contact'] }}">
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Employee Personal E-mail</label>
                    <input type="text" name="emp_email" placeholder="Employee E-mail"
                        value="{{ $emp_data['emp_email'] }}">
                </div>
                <div class="field">
                    <label for="">E-mail Provided by Company</label>
                    <input type="text" name="emp_company_email" placeholder="Employee Company E-mail"
                        value="{{ $emp_data['emp_company_email'] }}">
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="field">
                <label for="">Employee Salary</label>
                <input type="number" name="emp_salary" value="{{ $emp_data['emp_salary'] }}" placeholder="Salary">
            </div>
            <div class="field">
                <label for="">Employee Job Role (Contact Developer for more)</label>
                <select name="emp_job_role" id="">
                    <option value="" disabled selected>Please Select</option>
                    @foreach ($job_roles as $job_role)
                    @if (!$job_role['role_sensitive'] || $emp_data['emp_job_role'] == $job_role['id'])
                    <option value="{{ $job_role['id'] }}" @if ($emp_data['emp_job_role']==$job_role['id']) selected @endif>
                        {{ $job_role['job_role_title'] }}
                    </option>
                    @endif
                    @endforeach
                </select>
            </div>
        </section>
        <div class="field">
            <h6>* More changes can only be done by Developer</h6>
        </div>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Update Employee</button>
        </div>
    </form>
</main>
@endsection