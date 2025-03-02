<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\backend\courseController;
use Illuminate\Http\Request;
use App\Models\JobUser;
use App\Models\EmailVerification;
use App\Models\AddUnivRegistration;
use App\Models\Employeedetail;
use App\Models\Scholarship;
use App\Models\CompetitiveExam;
use App\Models\CompetitiveRegister;
use App\Models\ScholarshipRegister;
use App\Models\EdtechRegistration;
use App\Models\University;
use App\Models\UniversityCourse;
use App\Models\Course;
use App\Models\Otp;
use App\Models\Recruiter;
use App\Models\MockTest;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;





class UserController extends Controller

{
    public function jobRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|max:100',
            'phone' => 'required|digits:10',
        ]);

        // Check for existing user by email
        $user = JobUser::updateOrCreate(
            ['email' => $request->email], // Match by email
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );

        Session::flash('success', 'Job application registered successfully.');


    // Store target route and user ID in session
    // Session::put('target_route', 'employment.details');
    // Session::put('target_id', $user->id);

    // Assume the user is not yet verified and set the user_active flag to false
    // Session::put('user_active', false);

    // Now, you can redirect to wherever you need, knowing the target is stored in session.
    return redirect()->route('employment.details', ['id' => $user->id]);

        // Redirect to universal login (OTP verification page) with target route
        // return redirect()->route('universal-login', ['target' => 'employment.details', 'id' => $user->id]);

        // // Store the intended route in session
        // Session::put('url.intended', route('employment.details', ['id' => $user->id]));

        //    // Redirect to universal login (OTP verification page)
        //    return redirect()->route('universal-login');
    }

    // public function competitiveExamRegister(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|min:2',
    //         'email' => 'required|string|email|max:100',
    //         'phone' => 'required|digits:10',
    //     ]);

    //     // Check for existing user by email
    //     $user = CompetitiveRegister::updateOrCreate(
    //         ['email' => $request->email], // Match by email
    //         [
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //         ]
    //     );

    //     Session::flash('success', 'Competitive exam registration successful.');

    //     // Store the intended route in session
    //     Session::put('url.intended', route('competitive-exam', ['id' => $user->id]));

    //     // Redirect to OTP verification
    //     return redirect()->route('verifyOtp');
    // }
   
    // public function scholarshipExamRegister(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required|string|min:2',
    //         'email' => 'required|string|email|max:100',
    //         'phone' => 'required|digits:10',
    //     ]);

    //     // Check for existing user by email
    //     $user = ScholarshipRegister::updateOrCreate(
    //         ['email' => $request->email], // Match by email
    //         [
    //             'name' => $request->name,
    //             'phone' => $request->phone,
    //         ]
    //     );

    //     Session::flash('success', 'Scholarship exam registration successful.');

    //     // Store the intended route in session
    //     Session::put('url.intended', route('scholarship', ['id' => $user->id]));

    //     // Redirect to OTP verification
    //     return redirect()->route('verifyOtp');
    // }



    // public function sendOtp($user)
    // {
    //     $otp = rand(100000,999999);
    //     $time = time();

    //     EmailVerification::updateOrCreate(
    //         ['email' => $user->email],
    //         [
    //         'email' => $user->email,
    //         'otp' => $otp,
    //         'created_at' => $time
    //         ]
    //     );

    //     $data['email'] = $user->email;
    //     $data['title'] = 'Mail Verification';

    //     $data['body'] = 'Your OTP is:- '.$otp;

    //     Mail::send('user.email.mailVerification',['data'=>$data],function($message) use ($data){
    //         $message->to($data['email'])->subject($data['title']);
    //     });
    //     // Prepare the email data
    // $to = $user->email;
    // $subject = 'Mail Verification By CollegeVihar';
    // $body = 'Your OTP is: ' . $otp . "\r\n\r\nThank You!";
    // $headers = "MIME-Version: 1.0" . "\r\n";
    // $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    // $headers .= 'From: no-reply@yourdomain.com' . "\r\n";

    // // Send the email using PHP's mail function
    // if (mail($to, $subject, nl2br($body), $headers)) {
    //     Log::info('Email sent successfully to ' . $to);
    // } else {
    //     Log::error('Failed to send email to ' . $to);
    // }
    // }
   
    // public function verification($id)
    // {
    //     $user = JobUser::where('id',$id)->first();
    //     if(!$user || $user->is_verified == 1){
    //         return redirect('/');
    //     }
    //     $email = $user->email;

    //     $this->sendOtp($user);//OTP SEND

    //     return view('user.email.verification',compact('email', 'id'));

    // }

    // public function verifiedOtp(Request $request)
    // {
    //     $user = JobUser::where('email',$request->email)->first();
    //     $otpData = EmailVerification::where('otp',$request->otp)->first();
    //     if(!$otpData){
    //         return response()->json(['success' => false,'msg'=> 'You entered wrong OTP']);
    //     }
    //     else{

    //         $currentTime = time();
    //         $time = $otpData->created_at;

    //         if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
    //             JobUser::where('id',$user->id)->update([
    //                 'is_verified' => 1
    //             ]);
    //             return response()->json(['success' => true,'msg'=> 'Mail has been verified']);
    //         }
    //         else{
    //             return response()->json(['success' => false,'msg'=> 'Your OTP has been Expired']);
    //         }

    //     }
    // }

    // public function resendOtp(Request $request)
    // {
    //     $user = JobUser::where('email',$request->email)->first();
    //     $otpData = EmailVerification::where('email',$request->email)->first();

    //     $currentTime = time();
    //     $time = $otpData->created_at;

    //     if($currentTime >= $time && $time >= $currentTime - (90+5)){//90 seconds
    //         return response()->json(['success' => false,'msg'=> 'Please try after some time']);
    //     }
    //     else{

    //         $this->sendOtp($user);//OTP SEND
    //         return response()->json(['success' => true,'msg'=> 'OTP has been sent']);
    //     }

    //  }

    public function showEmploymentForm($id)
    {
        return view('user.email.employmentdetail', ['id' => $id]);
    }

    public function submitEmploymentDetails(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'gender' => 'required|string',
            'education' => 'required|string',
            'employee_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'annual_salary' => 'required|string|max:255',
             'employed' => 'required',
            'company_name' => 'required|string|max:255',
            'job_title' => 'required|string|max:255',
            'current_city' => 'required|string|max:255',
            'key_skills' => 'required|string',
            'resume' => 'required|mimes:pdf,doc,docx|max:2048',
            'work_experience_years' => 'required|integer|min:0|max:50',
            'work_experience_months' => 'required|integer|min:0|max:11',
            'phone_number' => 'required|string|size:10',
            'employment_type' => 'required|string',
        ]);

        $employeePhotoPath = null;
        if ($request->hasFile('employee_photo')) {
            $employeePhoto = $request->file('employee_photo');
            $employeePhotoName = time() . '_' . $employeePhoto->getClientOriginalName();
            $employeePhotoPath = 'images/employeephotos/' . $employeePhotoName;
            $employeePhoto->move(public_path('images/employeephotos'), $employeePhotoName);
        }


        Employeedetail::create([
            'user_id' => $request->input('id'),
            'full_name' => $request->input('full_name'),
            'gender' => $request->input('gender'),
            'education' => $request->input('education'),
            'employee_photo' =>$employeePhotoPath,
            'annual_salary' => $request->input('annual_salary'),
            'employed' => $request->input('employed') == 'yes',
            'company_name' => $request->input('company_name'),
            'job_title' => $request->input('job_title'),
            'current_city' => $request->input('current_city'),
            'key_skills' => $request->input('key_skills'),
            'resume_path' =>  $request->file('resume')->store('resumes', 'public'),
            'work_experience_years' => $request->input('work_experience_years'),
            'work_experience_months' => $request->input('work_experience_months'),
            'phone_number' => $request->input('phone_number'),
            'employment_type' => $request->input('employment_type'),
        ]);

        Session::flash('success', 'Employment details submitted successfully.');
        return redirect()->route('homepage');
    
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'phone' => 'required|digits:10',
            'address' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:255',
            'experience' => 'required|string',
            'company_name' => 'required|string|max:255',
            'company_email' => 'required|string|email|max:255',
            'company_address' => 'required|string|max:255',
            'presently_working_as' => 'required|string',
            'admission_target' => 'required|string',
            'terms' => 'required|accepted',
        ]);

        $validatedData['terms'] = $request->has('terms');

        // Save the data to the database
        $registration = EdtechRegistration::create($validatedData);

        // Send an email to the admin
        $to = 'anand24h@gmail.com';
        $subject = 'Ed Tech Registration Successfully';
        $body = 'Hi ' . $registration->name . ' has been registered successfully';
        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
        $headers .= 'From: info@collegevihar.com' . "\r\n";

        if (mail($to, $subject, nl2br($body), $headers)) {
            Log::info('Email sent successfully to ' . $to);
        } else {
            Log::error('Failed to send email to ' . $to);
        }

        return redirect()->back()->with('success', 'Registration successful!');
    }
    
    public function univstore(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'phone' => 'required|digits:10',
        ]);

        // Save the data to the database
        $registration = AddUnivRegistration::create($validatedData);

        return redirect()->route('user.info.univ_section')->with('success', 'Registration successful!');


    }

    static function addUniversity(Request $request)
    {
        
    // Validation
    $request->validate([
        'univ_name' => 'required|string|max:255',
        'univ_url' => 'required|string|max:255',
        'univ_payout' => 'required|integer|min:0',
        'univ_type' => 'required|string',
        'univ_person' => 'required|string|max:255',
        'univ_person_email' => 'required|email|max:255',
        'univ_person_phone' => 'required|digits:10',
        'course' => 'required|array|min:1'
    ], [
        'course.required' => 'Please select at least one course.'
    ]);

    // Creating University Instance
        $uni = new University;

        // University Basic Details
        $uni->univ_name = $request->univ_name;
        $uni->univ_url = $request->univ_url;
        $uni->univ_type = $request->univ_type;

        // University person to contact
        $uni->univ_person = $request->univ_person;
        $uni->univ_person_email = $request->univ_person_email;
        $uni->univ_person_phone = $request->univ_person_phone;
        $uni->univ_status = 0;
        $uni->save();

    //    Adding University Courses
        if (isset($request->course) && is_array($request->course)) {
            foreach ($request->course as $cor) {
                CourseController::addUnivCourse($uni->id, $cor);
            }
        }
        Session::flash('success', 'University details submitted successfully.');
        return redirect()->route('homepage');
    }

    public function recruiterRegister(Request $request)
    {
        $request->validate([
            'name' => 'required|string|min:2',
            'email' => 'required|string|email|max:100',          
            'phone' => 'required|digits:10',
        ]);

        // Check for existing entry or create a new one
        $recruiter = Recruiter::updateOrCreate(
            ['email' => $request->email], // Match by email
            [
                'name' => $request->name,
                'phone' => $request->phone,
            ]
        );

        Session::flash('success', 'Registered successfully.');
        
        // // Store the intended route in session
        // Session::put('url.intended', route('employees.index', ['id' => $recruiter->id]));
        

        //     // Redirect to universal login (OTP verification page)
        //     return redirect()->route('universal-login');
        
    // Store target route and user ID in session
    // Session::put('target_route', 'employees.index');
    // Session::put('target_id', $recruiter->id);

    // Assume the user is not yet verified and set the user_active flag to false
    // Session::put('user_active', false);

    // Now, you can redirect to wherever you need, knowing the target is stored in session.
    return redirect()->route('employees.index', ['id' => $recruiter->id]);
    }

    public function employeesindex(Request $request)
    {
        $query = EmployeeDetail::query();

        if ($request->filled('job_role')) {
            $query->where('job_title', 'like', '%' . $request->input('job_role') . '%');
        }
    
        if ($request->filled('city')) {
            $query->where('current_city', 'like', '%' . $request->input('city') . '%');
        }
    
        if ($request->filled('work_experience_years')) {
            $query->where('work_experience_years', $request->input('work_experience_years'));
        }
    
        if ($request->filled('work_experience_months')) {
            $query->where('work_experience_months', $request->input('work_experience_months'));
        }
    
        if ($request->filled('employment_type')) {
            $query->where('employment_type', $request->input('employment_type'));
        }
    
        $employees = $query->get();
        $recruiterId = $request->query('id');
    
        return view('user.email.employees', compact('employees', 'recruiterId'));

    }

    public function filterByEmploymentType($type, Request $request)
   {
    $employees = EmployeeDetail::where('employment_type', $type)->get();
    $recruiterId = $request->query('id');
    return view('user.email.employmenttype', compact('employees', 'type', 'recruiterId'));
  }

    
    public function downloadResume($filename, Request $request)
    {
        $recruiterId = $request->query('id');

        if (!$recruiterId) {
            return response()->json([
                'error' => 'Recruiter ID not provided',
            ], 400);
        }

        $recruiter = DB::table('recruiters')->where('id', $recruiterId)->first();

        if (!$recruiter) {
            return response()->json([
                'error' => 'Recruiter not found',
            ], 404);
        }

        if ($recruiter->download_count >= 3) {
            return response()->json([
                'error' => 'Download limit reached',
            ], 403);
        }

        $filePath = storage_path('app/public/resumes/' . $filename);

        if (!file_exists($filePath)) {
            return response()->json([
                'error' => 'File not found',
                'path' => $filePath,
            ], 404);
        }

        DB::table('recruiters')
            ->where('id', $recruiterId)
            ->update(['download_count' => $recruiter->download_count + 1]);

        return response()->download($filePath);
    }

    
    public function showScholarshipDetails( Request $request,$type)
    {
        $exams = Scholarship::where('scholarship_type', $type)->get();

        return view('user.info.scholarship-links',compact('exams'));
    }

    public function showscholarshipExamDetails($id)
    {

            $scholarship = Scholarship::find($id);

            if (!$scholarship) {
                return redirect()->back()->with('error', 'Exam not found');
            }
                // dd($scholarship);
            return view('user.info.scholarship-details', compact('scholarship'));

    }

    public function showCompetitiveDetails(Request $request, $type)
    {
        // $competitive = CompetitiveExam::where('exam_type', $type)->first();

        // if ($competitive) {
        //     return view('user.info.competitive-links', ['competitive' => $competitive]);
        // } else {
        //     return redirect()->back()->with('error', 'Competitive Exam information not found');
        // }
        // $exams = CompetitiveExam::where('exam_type', $type)->get();
        // return view('user.info.competitive-links', compact('exams','type'));
        $examInfo = [
           'SSC' => 'Staff Selection Commission (SSC) exams are conducted to recruit staff to various posts in ministries, departments, and organizations of the Government of India. The SSC conducts exams such as CGL, CHSL, JE, and others. These exams provide a gateway to secure a government job in various sectors. SSC exams are known for their rigorous selection process and provide opportunities in diverse government departments. Candidates preparing for SSC exams often undergo extensive training and coaching to enhance their chances of success.',
           'Banking' => 'Banking exams are conducted to recruit candidates for various positions in banks, such as clerks, probationary officers, and specialist officers. Major banking exams include IBPS PO, IBPS Clerk, SBI PO, and SBI Clerk, offering prestigious job opportunities in the banking sector. These exams are highly competitive and require thorough preparation in areas such as quantitative aptitude, reasoning ability, and general awareness. Banking jobs are known for their job security, good salary, and career growth opportunities, making them highly sought after.',
           'Railway' => 'Railway Recruitment Board (RRB) exams are conducted to recruit staff for various positions in the Indian Railways. These exams include RRB NTPC, RRB JE, RRB ALP, and others. They provide a stable and rewarding career in one of the largest railway networks in the world. Indian Railways offers a wide range of job opportunities in technical and non-technical categories, making it a popular choice among job seekers. The selection process typically involves multiple stages, including computer-based tests, physical efficiency tests, and document verification.',
           'Police' => 'Police exams are conducted to recruit candidates for various positions in the police department, such as constables, sub-inspectors, and inspectors. These exams ensure the recruitment of capable individuals to maintain law and order in society and provide public safety. Police jobs are challenging and demanding, requiring candidates to possess physical fitness, mental toughness, and a sense of duty. The recruitment process often includes written exams, physical tests, medical examinations, and interviews to select the best candidates.',
           'Civil' => 'Civil Services exams, including the UPSC exam, are conducted to recruit candidates for various civil services positions, such as IAS, IPS, and IFS. These exams are highly competitive and offer prestigious positions that involve significant responsibility and authority in public administration. The Civil Services exam is one of the toughest exams in India, requiring extensive preparation and a deep understanding of a wide range of subjects. Successful candidates have the opportunity to serve the nation and contribute to policy-making and governance.',
           'Teaching' => 'Teaching exams are conducted to recruit teachers for various levels of education, including primary, secondary, and higher education positions. Major exams include CTET, TET, NET, and others, ensuring the recruitment of qualified educators to shape the future of students. Teaching is a noble profession that requires a passion for education and a commitment to student development. Teaching exams assess candidates on their subject knowledge, teaching aptitude, and pedagogical skills to ensure they are well-equipped to educate the next generation.',
        ];

        if (!array_key_exists($type, $examInfo)) {
            return redirect()->back()->with('error', 'Competitive Exam information not found');
        }

    //       // If the user is not authenticated or not active, redirect to the universal login
    // if (!Session::has('user_active') || !Session::get('user_active')) {
    //     return redirect()->route('universal-login', ['target' => 'competitive-details', 'id' => $type]);
    // }

        $exams = CompetitiveExam::where('exam_type', $type)->get();
        return view('user.info.competitive-links', compact('exams', 'type', 'examInfo'));
    }


   public function showExamDetails($id)
    {
        $competitive = CompetitiveExam::find($id);
        
        if (!$competitive) {
            return redirect()->back()->with('error', 'Exam not found');
        }

        // Fetch related mock tests for this competitive exam
        $mockTests = MockTest::where('competitive_exam_id', $id)->get();
        
        // Get the first mock test (or handle if no mock tests exist)
        $firstMockTest = $mockTests->first();

        return view('user.info.competitive-details', compact('competitive', 'mockTests', 'firstMockTest'));
    }


    

    public function returnToLogin(Request $request)
    {
        // Clear OTP session variables
        Session::forget(['otp_sent', 'otp_method', 'email', 'phone', 'test_otp']);

        // Redirect back to the login page
        return redirect('universal-login');
    }

    // Email OTP verification
    public function EmailSendOtp (Request $request)
    {

        $request->validate([
            'email' => 'required|string|email|max:100',
        ]);

        $email = $request->input('email');

        //  // Hardcoded email for testing purposes
        //  $email = 'test@example.com';
        //  $phone = '1234567890'; // Hardcoded phone number for testing

        // // Check if email already exists
        // $existingOtp = Otp::where('email', $email)->first();
        // if ($existingOtp) {
        //     return back()->withErrors(['email' => 'Email already exists. Please use a different email.']);
        // }

        // Generate OTP
        $otp = rand(100000, 999999);

        
        // Update existing OTP entry or create a new one
        $otpRecord = Otp::updateOrCreate(
            ['email' => $email], // Match by email
            [
                'otp' => $otp,
                'expires_at' => now()->addMinutes(10),
                'status' => 'pending',
                'user_type' => $request->user_type ?? 'job'
            ]
        );

        // Send OTP via email
        $subject = 'OTP Code - Collegevihar';
        $message = "Your OTP code is $otp. It is valid for 10 minutes.  From - Collegevihar";
        // $headers = "From: info@collegevihar.com";

        // if (mail($email, $subject, $message, $headers)) {
        try {
            // Use Laravel's Mail facade for SMTP
            Mail::raw($message, function ($mail) use ($email, $subject) {
                $mail->to($email)
                    ->subject($subject)
                    ->from('info@collegevihar.com', 'Collegevihar');
            });

            session([
                'otp_sent' => true,
                'otp_method' => 'email',
                'temp_email' => $email,
            ]);
            return back();
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send OTP. Please try again.']);
        }

        //   // Store OTP in session for testing purposes
        //   Session::put('test_otp', $otp);

        //    // Simulate OTP sending success
        //    return back()->with('otp_sent', true)->with('otp', $otp);
    }

    public function EmailVerifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email|max:100',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord =  Otp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->where('status', 'pending')
            ->first();

        // Check if OTP is valid and not expired
        if ($otpRecord) {
            // Update the OTP record
            $otpRecord->status = 'verified';
            $otpRecord->save();

            session([
                'user_active' => true,
                'user_active_until' => Carbon::now()->addHours(2),
                'email' => $request->email,
            ]);
            
            // Clear OTP session variables
            Session::forget(['otp_sent', 'otp_method', 'temp_email']);    
            
            if($otpRecord->user_type == 'mock'){
                return redirect('/competitive-exam');
            }
            return redirect('/job-openings');


            // Get the target route and ID from the session
            // $targetRoute = Session::get('target_route'); // Default to home if not set
            // $targetId = Session::get('target_id');

            // Redirect to the target route
            
            // return redirect()->route($targetRoute, ['id' => $targetId]);
            //  return redirect()->route('employees.index');
            // return redirect->back();

        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }
    }

    // Sms otp access for login 
    public function SmsSendOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
        ]);

        $phone = $request->phone;
        $otpCode = rand(100000, 999999);

        // Update existing OTP entry or create a new one
        $otpRecord = Otp::updateOrCreate(
            ['phone' => $phone], // Match by phone
            [
                'otp' => $otpCode,
                'expires_at' => now()->addMinutes(10),
                'status' => 'pending',
                'user_type' => $request->user_type ?? 'job'
            ]
        );

        $data = [
            "FORMAT" => "1",
            "USERNAME" => "Insystasim",
            "PASSWORD" => "New@5555",
            "GSMID" => "SMSSMS",
            "TEXT" => "Your OTP code is $otpCode for Login . From - Collegevihar ",
            "TEXTTYPE" => "TEXT",
            "MOBLIST" => $phone,
        ];

        // Http::post('http://sirfsms.com/sms/api/jsonapi.aspx', $data);
        Http::post('https://sirfsms.com/api/xml.aspx', $data);
        // Set session variables
        session([
            'otp_sent' => true,
            'otp_method' => 'sms',
            'temp_phone' => $phone,
        ]);

        return back();
        
    }

    public function SmsVerifyOtp(Request $request)
    {
        $request->validate([
            'phone' => 'required|digits:10',
            'otp' => 'required|digits:6',
        ]);

        $otpRecord = Otp::where('phone', $request->phone)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->where('status', 'pending')
            ->first();


        if ($otpRecord) {
            // Update the OTP record
            $otpRecord->status = 'verified';
            $otpRecord->save();
    
            session([
                'user_active' => true,
                'user_active_until' => Carbon::now()->addHours(2),
                'phone' => $request->phone,
            ]);
    
            // Clear OTP session variables
            Session::forget(['otp_sent', 'otp_method', 'temp_phone']);          
            // return redirect('/');
            return redirect('/job-openings');
        } else {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

    }

    public function showJoinForm(Request $request){
        
        $user = session('user_active');             

        // Save referral code in session with 10-minute validity
        if ($request->query('refid')) {
            // Get referral code from the URL parameter
            $referralCode = $request->query('refid');

            session(['referral_code' => $referralCode]);

            // Automatically expire the session referral_code after 10 minutes
            Session::put('referral_code_expiry', now()->addMinutes(10));
        }

        // Check for an expired referral code and remove it if necessary
        if (Session::has('referral_code_expiry') && now()->greaterThan(Session::get('referral_code_expiry'))) {
            Session::forget(['referral_code', 'referral_code_expiry']);
        }        

        if (!$user) {
            return redirect('/universal-login');
        } else{
        
            // Check for existing session referral code
            $savedReferralCode = session('referral_code', null);
            $phone = session('phone');
            $email = session('email');

            return view('user.agent.join', compact('savedReferralCode', 'phone', 'email'));
        }
        
    }

    public function submitJoinForm(Request $request)
    {
        $request->validate([
            'emp_name' => 'required|string',
            'emp_job_role' => 'required|string',
            'emp_email' => 'required|email',
            'emp_location' => 'required|string',
            'emp_phone' => 'required|numeric',
            'referral_code' => 'nullable|string',
            'emp_pic' => 'required|image|mimes:jpeg,png,jpg', 
        ]);

        $data = $request->only([
            'emp_name', 'emp_job_role', 'emp_email', 'emp_location', 'emp_phone', 'referral_code',
        ]);
        // dd($data, $request->file('emp_pic'));

        try {
            // $response = Http::post('https://www.genlead.in/api/agent/register', $data);

            $response = Http::attach(
                'emp_pic', 
                file_get_contents($request->file('emp_pic')->getRealPath()), 
                $request->file('emp_pic')->getClientOriginalName()
            )->post('https://www.genlead.in/api/agent/register', $data);
            // Debug the response
            if ($response->failed()) {
                // logger()->error('API Error: ', $response->json());
                return redirect()->back()->withErrors($response->status(), $response->json());
            }

            if ($response->successful()) {
                // echo "success";
                return redirect('/')->with('message', $response->json('message'));
            } else {
                return redirect()->back()->withErrors($response->json('message') ?? 'Registration failed. Please try again.');
            }
        } catch (\Exception $e) {
            // Handle exception
            return redirect()->back()->withErrors('An error occurred: ' . $e->getMessage());
        }
    }

}


