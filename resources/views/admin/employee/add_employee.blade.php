@extends('admin.components.layout')
@section('main')
<main>
    @include('admin.components.response')
    <form action="/admin/employee/add" method="post" enctype="multipart/form-data">
        <h2 class="page_title">Add Employee</h2>
        <section class="jcc">
            <div class="profile_pic field">
                <label for="pp">
                    <img src="/images/profile/profile 1.jpg" alt="profile">
                </label>
                <input type="file" name="" id="pp" onchange="display_pic(this)">
            </div>
        </section>
        <section class="panel">
            @csrf
            <div class="field_group">
                <div class="field">
                    <label for="">Employee Name</label>
                    <input type="text" name="emp_name" placeholder="Employee Name">
                </div>
                <div class="field">
                    <label for="">Employee Username <i class="text">( Anything you want )</i></label>
                    <input type="text" name="emp_username" placeholder="Employee Username">
                </div>
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Employee D.O.B.</label>
                    <input type="date" name="emp_dob" placeholder="Employee DOB">
                </div>
                <div class="field">
                    <label for="">Employee Gender</label>
                    <select name="emp_gender" id="">
                        <option value="" disabled selected>Please Select</option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="transgender">Transgender</option>
                    </select>
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="field">
                <label for="">Employee Contact <i class="text">( Phone Number Personal )</i></label>
                <input type="text" name="emp_contact" placeholder="Employee Contact">
            </div>
            <div class="field_group">
                <div class="field">
                    <label for="">Employee E-mail<i class="text">( Personal )</i></label>
                    <input type="text" name="emp_email" placeholder="Employee E-mail">
                </div>
                <div class="field">
                    <label for="">E-mail<i class="text">( Provided by Company )</i></label>
                    <input type="text" name="emp_company_email" placeholder="Employee Company E-mail">
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="field">
                <label for="">Employee Address <i class="text">(Currently living)</i></label>
                <input type="text" name="emp_address" placeholder="Employee Address">
            </div>
            <div class="field">
                <div class="field">
                    <label for="">Employee State <i class="text">(Currently living)</i></label>
                    <select name="emp_state" id="">
                        <option value="" disabled selected>Please Select State</option>
                        @foreach ($states as $state)
                        <option value="{{ $state['id'] }}">
                            {{ $state['state_name'] }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>
        <section class="panel">
            <div class="field_group">
                <div class="field">
                    <label for="">Employee Joing Date</label>
                    <input type="date" name="emp_joining_date" id="">
                </div>
                <div class="field">
                    <label for="">Employee Salary</label>
                    <input type="number" name="emp_salary" placeholder="Salary">
                </div>
            </div>
            <div class="field">
                <label for="">Employee Job Role <i class="text">( Contact Developer for more )</i></label>
                <select name="emp_job_role" id="">
                    <option value="" disabled selected>Please Select</option>
                    @foreach ($job_roles as $job_role)
                    @if (!$job_role['role_sensitive'])
                    <option value="{{ $job_role['id'] }}">{{ $job_role['job_role_title'] }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </section>
        <section class="panel">
            <div class="field">
                <label for="">Employee Password <i class="text">( Can only be changed by developer )</i></label>
                <input type="password" name="emp_password" placeholder="Password">
            </div>
        </section>
        <div class="text-end p-4">
            <button type="submit" class="btn btn-primary btn-lg">Add Employee</button>
        </div>
    </form>
</main>
@push('script')
<script>
    function display_pic(node) {
        $(`label[for='${node.id}'] img`)[0].src = URL.createObjectURL(node.files[0]);
    }
</script>
@endpush
@endsection