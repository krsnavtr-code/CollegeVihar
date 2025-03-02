
<?php


use App\Http\Controllers\backend\UtilsController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CityController;
use App\Http\Controllers\frontend\BlogController;
use App\Http\Controllers\frontend\UserController;
use App\Http\Controllers\frontend\JobOpeningController;
use App\Http\Controllers\frontend\UserOtpController;
use App\Http\Controllers\backend\courseController;
use App\Http\Controllers\frontend\SearchjobController;
use App\Http\Controllers\backend\UniversityController;
use App\Http\Controllers\QuizController;
use App\Models\Course;
use App\Models\Otp;
use App\Models\EdtechRegistration;
use App\Models\AddUnivRegistration;
use App\Models\Candidate;
use App\Models\EmailVerification;
use App\Models\JobUser;
use App\Models\JobRequirement;
use App\Models\Recruiter;
use App\Models\CompetitiveRegister;
use App\Models\ScholarshipRegister;
use App\Models\Employeedetail;
use App\Models\University;
use App\Models\UniversityCourse;
use App\Models\mainLead;
use App\Models\univ_course;
use App\Models\TestingPageUniv;
use App\Http\Middleware\CheckUserActive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;


// For Mock test



Route::post('/logout', function () {
    Session::flush(); // remove session data
    return redirect('/'); // redirect to homepage
});

# HomePage of website
Route::get("/", function (Request $request) {

    
    $universities = University::with('univCourses:id,university_id,univ_course_slug,univ_course_detail_added,course_id,uc_details')->get(['id','univ_name','univ_image','univ_logo','univ_type','univ_status']);
    // dd($universities->first()->univCourses->first()->toArray());
    // dd($universities->toArray());
    
    $courseData = Course::get(['id','course_name'])->toArray();
    // $topCourseData = University::all()->toArray();
    // // dd($topCourseData);
     return view("user.index", ["courseData" => $courseData, "universities" => $universities]);
})->name("homepage");


# Info Pages
Route::get("/about", function () {
    return view("user.info.about");
})->name('about');
Route::get("/privacy-policy", function () {
    return view("user.info.privacy");
})->name('privacy');
Route::get("/refund-policy", function () {
    return view("user.info.refund");
})->name('refund');
Route::get("/terms-of-use", function () {
    return view("user.info.terms");
})->name('terms');
Route::get("/disclaimer", function () {
    return view("user.info.disclaimer");
})->name("disclaimer");
Route::get("/faqs", function () {
    return view("user.info.faqs");
})->name("faqs");
Route::get("/career", function () {
    return view("user.info.career");
})->name("career");
Route::get("/contact", function () {
    return view("user.info.contact");
})->name("contact");
Route::get("/job-openings",function(){
     return view("user.info.job_opening");
})->name("job-openings");
Route::get("/post-job",function(){
    return view("user.info.postjob");
});
Route::get("/competitive-exam",function(){
    return view("user.info.competitive");
})->name("competitive-exam");
Route::get("/scholarship",function(){
    return view("user.info.scholarship");
})->name("scholarship");

Route::get('/post-admission-support', function () {
      return view('user.info.postadmission');
});
Route::get('/resume-help', function () {
    return view('user.info.Resume');
});
Route::get('/community', function () {
    return view('user.info.community');
});

// Route::get('/universal-login',function(){
//       return view('user.info.universallogin');
// });

// Route::get('/scholarship-details/{type}', [UserController::class, 'showScholarshipDetails']);
Route::get('/scholarship-exam/{id}', [UserController::class, 'showscholarshipExamDetails']);

// Route::get('/competitive-details/{type}', [UserController::class, 'showCompetitiveDetails']);
Route::get('/competitive-exam/{id}', [UserController::class, 'showExamDetails']);

Route::get('/competitive-exams/{examId}/mocks', [QuizController::class, 'showMocks'])->name('quizzes.mocks');

// Route::post('/quiz/verify-otp/{mockTestId}', [QuizController::class, 'VerifyQuizOtp'])->name('quizzes.verify-otp');


Route::middleware([CheckUserActive::class])->group(function () {
    Route::get('competitive-exams/mock-tests/{mockTestId}/start', [QuizController::class, 'startQuiz'])->name('quizzes.start');

    Route::post('/quiz/submit', [QuizController::class, 'submitAnswer'])->name('quizzes.submit');
    Route::get('competitive-exams/mock-test/result/{mockTestId}', [QuizController::class, 'showResult'])->name('quizzes.result');
});
Route::get("/drive",function(){
    return view("user.info.drive");
});

// Download prospectus Routes

Route::get('/download-pdf/{filename}', function ($filename) {
    $filePath = public_path('prospectus/' . $filename);
    if (file_exists($filePath)) {
        return Response::download($filePath);
    } else {
        abort(404, 'File not found.');
    }
})->name('download-pdf');
 
// Download Resume Routes

Route::get('downresume/{filename}', [UserController::class, 'downloadResume']);

  
//   JOB OPENING OTP Routes 


Route::get('/login',function(){
    return redirect('/');
});
// Route::post('/jobregister',[UserController::class,'jobRegister']);
// Route::post('/send-otp', [UserController::class,'sendOtp'])->name('sendOtp');
// Route::get('/verification/{id}',[UserController::class,'verification']);
// Route::post('/verified',[UserController::class,'verifiedOtp'])->name('verifiedOtp');
// Route::get('/resend-otp',[UserController::class,'resendOtp'])->name('resendOtp');
Route::get('/employment-details/{id}', [UserController::class, 'showEmploymentForm'])->name('employment.details');
Route::post('/employment-details-submit', [UserController::class, 'submitEmploymentDetails']);


// Route::middleware(['check_user_active'])->group(function () {
 
   
    
// });

Route::get('/universal-login', function() {
    return view('user.info.universal-login');
})->name('universal-login');

Route::post('/return-to-login', [UserController::class, 'returnToLogin']);

Route::post('/send-otp-email', [UserController::class, 'EmailSendOtp']);
Route::post('/verify-otp-email', [UserController::class, 'EmailVerifyOtp']);

Route::post('/send-otp-sms', [UserController::class, 'SmsSendOtp']);
Route::post('/verify-otp-sms', [UserController::class, 'SmsVerifyOtp']);

// routes/web.php
Route::get('/agent/join', [UserController::class, 'showJoinForm']);
Route::post('/agent/join', [UserController::class, 'submitJoinForm']);


// Route::get('/check-user-session', function() {
//     if (!Session::has('user_active') || !Session::get('user_active')) {
//         return redirect('/login')->withErrors(['error' => 'You must be logged in to access this page.']);
//     }
//     return redirect('/next-page');
// })->name('check.user.session');

// Post a Job Routes

Route::post('/register', [UserController::class, 'register']);

// Routes for each option
Route::get('/consultant', function () {
    return view('user.info.postjobdetail');
});

Route::get('/company', function () {
    return view('user.info.postjobdetail');
});

Route::get('/freelancer', function () {
    return view('user.info.postjobdetail');
});

Route::post('/job-requirements', [JobOpeningController::class, 'store'])->name('job.requirements.store');

// Search  Job Routes
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/fetch-cities', [CityController::class,'fetchCities']);

// Ed Tech Routes
Route::post('/edregister', [UserController::class, 'store']);


// middleware functionality 

Route::middleware([CheckUserActive::class])->group(function () {
    Route::match(['get', 'post'],'/recruiter/register', [UserController::class, 'recruiterRegister'])->name('recruiterRegister');
    Route::match(['get', 'post'],'/jobregister', [UserController::class, 'jobRegister'])->name('jobRegister');
});

Route::match(['get', 'post'],'/competitive-details/{type}', [UserController::class, 'showCompetitiveDetails']);
Route::match(['get', 'post'],'/scholarship-details/{type}', [UserController::class, 'showScholarshipDetails']);

// Recruiters/Hire Now Routes
Route::get('/employees', [UserController::class, 'employeesindex'])->name('employees.index');

Route::get('/job-employment/{type}', [UserController::class, 'filterByEmploymentType'])->name('job.employment.filter');


//  Add University Routes
Route::post('/univstore', [UserController::class, 'univstore'])->name('univstore');

Route::get('/user/info/univ_section', function () {
    $courses = Course::all()->toArray();
    return view('user.info.univ_section', compact('courses'));
})->name('user.info.univ_section');

Route::post('/add-university', [UserController::class, 'addUniversity'])->name('add.university');

// Partner University Routes

Route::get('/universities/{state}', [UniversityController::class, 'show'])->name('universities.show');

// Route::get("/universities/{state}",function(){
//     return view("user.info.showuniversity");
// });


Route::get('/online-programs', function () {
    return view('user.components.online-programs');
});



Route::controller(BlogController::class)->prefix("blogs")->group(function () {
    Route::get("", 'ui_view_blogs');
    Route::get("{slug}", 'ui_view_blog');
});

//searchable univ and course routes
Route::controller(SearchController::class)->group(function (){
    Route::get("/search", 'search');
    Route::post('/submit-form', 'submitForm')->name('submit.form');
    Route::post("/mainsite_raiseQueryForm", 'handleQueryForm')->name('mainsite.raiseQueryForm');
    Route::post("/mainsite_getStartedNow", 'getStartedNow')->name('mainsite.getStartedNow');
    Route::get("/download-pdf", 'downloadPDF')->name('download.pdf');
});

Route::post("/query-form", function (Request $request) {
    $result = UtilsController::query_form($request);
    return $result;
});

// University and universities
Route::get("/university", function () {
    return view("user.universities");
});

Route::get("/university/{university}", function (Request $request) {
    $data = University::where('univ_slug', $request->raw_meta['id'])->with('courses')->get()->toArray();
    return view("user.university", ["university" => $data[0]]);
});

Route::get("/university/raw/{univ_name}", function ($univ_name) {
    // Query the database to retrieve data based on the provided univ_name
    $university = TestingPageUniv::where('univ_name', $univ_name)->first();

    if ($university) {
        // If data is found, pass it to the view
        return view("user.testing-university", ['university' => $university]);
    } else {        
        abort(404); // For example, return a 404 Not Found response
    }
});

// University and universities
Route::get("/course", function () {
    return view("user.courses");
});

// Route::get("/course/{course}", function (Request $request) {
//     $data = Course::where('course_slug', $request->raw_meta['id'])->with('universities')->get()->toArray();
//     if ($data)
//         return view("user.course", ["course" => $data[0]]);
//     else {
//         $data = UniversityCourse::where('univ_course_slug', $request->raw_meta['id'])->with(['university:id,univ_name', 'course:id,course_name,course_short_name,course_duration,course_eligibility_short'])->get()->toArray();
//         return view("user.univ_course", ["course" => $data[0]]);
//     }
// });

Route::get("/course/{course}", function (Request $request) {
    $course = Course::where('course_slug', $request->raw_meta['id'])->with('universities')->first();
    if (!empty($course)) {
        // dd($course, 12);
        return view("user.course", ["course" => $course]);
    } else {
        $universityCourse = UniversityCourse::where('univ_course_slug', $request->raw_meta['id'])
                                            ->with(['university:id,univ_name', 'course:id,course_name,course_short_name,course_duration,course_eligibility_short'])
                                            ->first();
        // dd($universityCourse, 24);
        return view("user.univ_course", ["course" => $universityCourse]);
    }
});


