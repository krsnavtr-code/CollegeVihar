<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\JobRole;
use Illuminate\Http\Request;

class employeeController extends Controller
{
    static function login(Request $request)
    {
        $username = $request->username;
        $passcode = $request->passcode;

        $ed = Employee::where('emp_username', $username)->with('jobrole')->first();
        if ($ed) {
            $employee_data = $ed->getOriginal();
            if (!$employee_data['emp_status']) {
                return ["success" => false, "msg" => "Contact HR for more"];
            } else if ($employee_data['emp_password'] == $passcode) {
                $employee_data = $ed->toArray();
                session()->put("admin_username", "$username");
                $employee_data['job_role']['permissions'] = json_decode($employee_data['jobrole']['permissions']);
                session()->put("admin_data", $employee_data);
                return ["success" => true];
            } else {
                return ["success" => false, "msg" => "Invalid Credentials"];
            }
        } else {
            return ["success" => false, "msg" => "User not Exists"];
        }
    }
    static function logout()
    {
        if (session()->flush()) {
            return ['success' => true];
        };
        return ['success' => false];
    }
    // Job Roles
    static function job_roles()
    {
        return JobRole::all()->toArray();
    }
    static function create_job_role(Request $request)
    {
        $job_role = new JobRole();
        $job_role->job_role_title = $request->job_role_title;
        $job_role->permissions = json_encode($request->job_role_permissions ?? []);
        if ($job_role->save()) {
            return ['success' => true];
        }
        return ['success' => false];
    }
    static function edit_job_role(Request $request)
    {
        $job_role = JobRole::where('id', $request->job_id)->update(['permissions' => json_encode($request->job_role_permissions)]);
        if ($job_role) {
            return ['success' => true];
        }
        return ['success' => false];
    }
    // Employee Add and Delete
    static function add(Request $request)
    {
        $emp = new Employee;

        // Employee Basic Details
        $emp->emp_name = $request->emp_name;
        $emp->emp_username = strtolower($request->emp_username);
        $emp->emp_gender = $request->emp_gender;
        $emp->emp_dob = $request->emp_dob;

        // Employee Contact Details
        $emp->emp_contact = $request->emp_contact;
        $emp->emp_email = $request->emp_email;
        $emp->emp_company_email = $request->emp_company_email;

        // Employee Address Details
        $emp->emp_address = $request->emp_address;
        $emp->emp_state = $request->emp_state;

        // Employee Job_role, Joining and salary
        $emp->emp_joining_date = $request->emp_joining_date;
        $emp->emp_job_role = $request->emp_job_role;
        $emp->emp_salary = $request->emp_salary;

        // Employee Password 
        $emp->emp_password = $request->emp_password;

        return ["success" => $emp->save()];
    }
    static function edit(Request $request)
    {
        $emp = Employee::find($request->empId);

        // Employee Basic Details
        $emp->emp_name = $request->emp_name;

        // Employee Contact Details
        $emp->emp_contact = $request->emp_contact;
        $emp->emp_email = $request->emp_email;
        $emp->emp_company_email = $request->emp_company_email;

        // Employee Job_role, Joining and salary
        $emp->emp_job_role = $request->emp_job_role;
        $emp->emp_salary = $request->emp_salary;

        return ["success" => $emp->save()];
    }
    static function toggleEmployeeStatus($empId)
    {
        $emp = Employee::find($empId);
        $emp->emp_status = !$emp->emp_status;
        return  ["success" => $emp->save()];
    }
}
