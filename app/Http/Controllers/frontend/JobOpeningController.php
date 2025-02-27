<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobRequirement;

class JobOpeningController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'jobTitle' => 'required|string|max:255',
            'jobLocation' => 'required|string|max:255',
            'openings' => 'required|integer',
            'experience' => 'required|string|max:255',
            'education' => 'required|string|max:255',
            'salary' => 'required|string|max:255',
            'bonus' => 'required|string|max:255',
            'jobInfo' => 'required|string',
            'skills' => 'required|string|max:255',
            'jobTimings' => 'required|string|max:255',
            'interviewDetails' => 'required|string',
            'companyName' => 'required|string|max:255',
            'contactPersonName' => 'required|string|max:255',
            'phoneNumber' => 'required|string|max:10',
            'email' => 'required|email|max:255',
            'contactPersonProfile' => 'required|string|max:255',
            'organizationSize' => 'required|string|max:255',
            'jobAddress' => 'required|string',
        ]);

        JobRequirement::create([
            'job_title' => $request->jobTitle,
            'job_location' => $request->jobLocation,
            'openings' => $request->openings,
            'experience' => $request->experience,
            'education' => $request->education,
            'salary' => $request->salary,
            'bonus' => $request->bonus,
            'job_info' => $request->jobInfo,
            'skills' => $request->skills,
            'job_timings' => $request->jobTimings,
            'interview_details' => $request->interviewDetails,
            'company_name' => $request->companyName,
            'contact_person_name' => $request->contactPersonName,
            'phone_number' => $request->phoneNumber,
            'email' => $request->email,
            'contact_person_profile' => $request->contactPersonProfile,
            'organization_size' => $request->organizationSize,
            'job_address' => $request->jobAddress,
        ]);

        return redirect()->back()->with('success', 'Job requirement has been added successfully.');
    }
}
