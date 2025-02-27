<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

define('doc_path', public_path("private_docs/docs"));

class FranchiseController extends Controller
{
    static function addFranchiese(Request $request)
    {
        $emp = new Employee;

        $emp->emp_name = $request->emp_name;
        $emp->emp_username = $request->emp_username;
        $emp->emp_dob = $request->emp_dob;
        $emp->emp_gender = $request->emp_gender;
        $emp->emp_contact = $request->emp_contact;
        $emp->emp_email = $request->emp_email;
        $emp->emp_company_email = $request->emp_company_email;
        $emp->emp_address = $request->emp_address;
        $emp->emp_state = $request->emp_state;
        $emp->emp_joining_date = $request->emp_joining_date;
        $emp->emp_password = $request->emp_password;
        $emp->emp_job_role = 12;
        $emp->emp_type = "franchise";

        if ($request->aadhar_front) {
            $aadhar_front = Str::random(10) . now()->timestamp . '.' . $request->aadhar_front->getClientOriginalExtension();
            $request->aadhar_front->move(doc_path, $aadhar_front);
        }
        if ($request->aadhar_back) {
            $aadhar_back = Str::random(10) . now()->timestamp . '.' . $request->aadhar_back->getClientOriginalExtension();
            $request->aadhar_back->move(doc_path, $aadhar_back);
        }
        if ($request->pan_pic) {
            $pan_pic = Str::random(10) . now()->timestamp . '.' . $request->pan_pic->getClientOriginalExtension();
            $request->pan_pic->move(doc_path, $pan_pic);
        }
        if ($request->bank_pic) {
            $bank_pic = Str::random(10) . now()->timestamp . '.' . $request->bank_pic->getClientOriginalExtension();
            $request->bank_pic->move(doc_path, $bank_pic);
        }

        $emp_docs = [
            "aadhar" => ["number" => $request->aadhar_number, "front_pic" => $aadhar_front, "back_pic" => $aadhar_back],
            "pan" => ["number" => $request->pan_number, "pic" => $pan_pic],
            "bank" => ["number" => $request->account_number, "ifsc" => $request->ifsc, "upi" => $request->upi, "pic" => $bank_pic]
        ];
        $emp->emp_docs = json_encode($emp_docs);
        $emp->emp_status = $request->fran_status ?? '0';
        // dd($emp->toArray());

        return ["success" => $emp->save()];
    }
}
