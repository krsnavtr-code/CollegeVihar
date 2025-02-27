<?php

use App\Http\Controllers\backend\employeeController;
use App\Http\Controllers\backend\UniversityController;
use App\Http\Controllers\backend\UtilsController;
use App\Http\Controllers\backend\courseController;
use App\Http\Controllers\backend\FranchiseController;
use App\Http\Controllers\backend\LeadController;
use App\Http\Controllers\backend\TeamController;
use App\Http\Controllers\backend\BlogController;
use App\Http\Controllers\backend\ExamController;
use App\Http\Controllers\backend\EdTechController;
use App\Models\AdminPage;
use App\Models\EdtechRegistration;
use App\Models\Jobopening;
use App\Models\CompetitiveExam;
use App\Models\Scholarship;
use App\Models\Course;
use App\Models\Employee;
use App\Models\JobRole;
use App\Models\Lead;
use App\Models\MainLead;
use App\Models\Leadupdate;
use App\Models\Metadata;
use App\Models\University;
use App\Models\UniversityCourse;
use App\Models\State;
use App\Models\Blog;
use App\Models\UrlLinksLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// Admin Dashboard Page
Route::get("", function () {
    return view("admin.index");
})->name("admin_home");
Route::get("/index", function () {
    return redirect()->route("admin_home");
});

// Admin Login Page
Route::withoutMiddleware('admin')->group(function () {
    Route::get("/login", function () {
        return session()->has("admin_username") ?
            redirect()->route("admin_home") : view("admin.login");
    })->name('admin_login');
    Route::post("/login", function (Request $request) {
        $result = employeeController::login($request);
        if ($result['success']) {
            return redirect()->route('admin_home');
        } else {
            session()->flash('error', $result['msg']);
            return redirect()->route('admin_login');
        }
    });
    Route::any("/logout", function () {
        $result = employeeController::logout();
        if (!$result['success']) session()->forget('admin_username');
        return redirect()->route('admin_login');
    })->name('admin_logout');
});

Route::middleware('ensurePermission')->group(function () {
    // University Routes
    Route::prefix("/university")->group(function () {
        Route::get("", function () {
            // $data = ["universities" => UniversityController::getUniversities()];
            // return view("admin.university.view_univ", ['data'=> $data]);
            $universities = UniversityController::getUniversities();
            return view("admin.university.view_univ", ['universities' => $universities]);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $data = ["courses" => Course::all()->toArray()];
                return view("admin.university.add_univ", $data);
            });
            Route::post("" , [UniversityController::class, 'addUniversity'] ) ;
            Route::prefix("/details")->group(function () {
                Route::get("/{id}", function (University $id) {
                    $data = [
                        "university" => $id->toArray(),
                        "states" => UtilsController::getStates(),
                    ];
                    return view("admin.university.add_univ_details", $data);
                });
                Route::post("", function (Request $request) {
                    $result = UniversityController::addUniversityDetail($request);
                    session()->flash('success', $result['success']);
                    return redirect("/admin/university");
                });
            });
        });
        Route::prefix("edit")->group(function () {
            Route::get("{univ_id}", function ($univ_id) {
                $data = ["courses" => Course::all()->toArray(), 'university' => University::with('courses')->find($univ_id)->toArray()];
                return view("admin.university.edit_univ", $data);
            });
            Route::post("", function (Request $request) {
                $result = UniversityController::editUniversity($request);
                session()->flash('success', $result['success']);
                return redirect()->back();
            });
            Route::prefix("details")->group(function () {
                Route::get("{id}", function ($id) {
                    $data = [
                        "university" => University::with('metadata')->find($id)->toArray(),
                        "states" => UtilsController::getStates(),
                    ];
                    return view("admin.university.edit_univ_details", $data);
                });
                Route::post("", function (Request $request) {
                    $result = UniversityController::editUniversityDetail($request);
                    session()->flash('success', $result['success']);
                    return redirect()->back();
                });
            });
        });
        
        Route::get('delete/{univ_id}', function ($univ_id) {
            $result = UniversityController::deleteUniversity($univ_id);
            if ($result['success']) {
                session()->flash('success', $result['message']);
            } else {
                session()->flash('error', $result['message']);
            }
            return redirect('/admin/university');
        });
        

        Route::prefix("/courses")->group(function () {
            Route::get("/{univ_id}", function (Request $request, $univId) {
                $data = ["university" => University::find($univId, ['id', 'univ_name', 'univ_address'])->toArray(), "courses" => UniversityCourse::where('university_id', $univId)->with('course')->get()->toArray()];
                return view('admin.course.view_univ_course', $data);
            });
            Route::prefix("edit")->group(function () {
                Route::get("/{courseId}", function ($courseId) {
                    $data = ['course' => UniversityCourse::with(['university', 'course'])->find($courseId)->toArray()];
                    // dd($data);
                    return view('admin.course.edit_univ_course', $data);
                });
                Route::post("",function(Request $request){
                    $result = courseController::editUnivCourseDetails($request);
                    session()->flash('success', $result['success']);
                    return redirect()->back();
                });
            });
        });
    });
    // Courses routes
    Route::prefix("course")->group(function () {
        Route::get("", function () {
            $data = ['courses' => Course::with('universities')->get(['id', 'course_name', 'course_short_name', 'course_type', 'course_slug', 'course_status', 'course_detail_added'])->toArray()];
            $courses = Course::with('universities')->paginate(30);
            // dd($courses);
            $data = ['courses' => $courses, 'com' => $courses];
            // dd($data);
            return view("admin.course.courses", $data);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                return view("admin.course.add_course");
            });
            Route::post("", function (Request $request) {
                $result = courseController::addCourse($request);
                session()->flash('success', $result['success']);
                return redirect()->back();
            });
            Route::prefix("/details")->group(function () {
                Route::get("/{id}", function ($id) {
                    $data = [
                        "course" => Course::where('id', $id)->get()->first()->toArray(),
                    ];
                    return view("admin.course.add_course_details", $data);
                });
                Route::post("", function (Request $request) {
                    $result = courseController::addCourseDetails($request);
                    session()->flash('success', $result['success']);
                    return redirect("/admin/course");
                });
            });
        });
        Route::prefix("/edit")->group(function () {
            Route::get("/{id}", function (Course $id) {
                $data = ["course" => $id->toArray()];
                return view("admin.course.edit_course", $data);
            });
            Route::post("", function (Request $request) {
                $result = courseController::editCourse($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/course/edit/" . $request->course_id);
            });
            Route::prefix("/details")->group(function () {
                Route::get("/{id}", function ($id) {
                    $data = ["course" => Course::with('metadata')->find($id)->toArray()];
                    return view('admin.course.edit_course_details', $data);
                });
                Route::post("", function (Request $request) {
                    $result = courseController::editCourseDetails($request);
                    session()->flash('success', $result['success']);
                    return redirect("/admin/course/edit/details/" . $request->course_id);
                });
            });
        });
        Route::get("/university/{course_id}", function ($course_id) {
            $data = ["course" => Course::find($course_id, ['id', 'course_name', 'course_short_name'])->toArray(), "universities" => UniversityCourse::where("course_id", $course_id)->where('univ_course_status', '1')->with('university')->get()->toArray()];
            // dd($data);
            return view('admin.university.view_course_univ', $data);
        });
    });
    // Job role routes
    Route::prefix("/job_role")->group(function () {
        Route::get("", function () {
            $data = ['job_roles' => employeeController::job_roles()];
            return view("admin.employee.job_roles", $data);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $pages = AdminPage::all()->toArray();
                return view("admin.employee.add_job_role", ['pages' => $pages]);
            });
            Route::post("", function (Request $request) {
                $result = employeeController::create_job_role($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/job_role/add");
            });
        });
        Route::prefix("/edit")->group(function () {
            Route::get("/{id}", function (JobRole $id) {
                $pages = AdminPage::all()->toArray();
                $id = $id->toArray();
                $data = ['pages' => $pages, 'job_role' => $id];
                return view("admin.employee.edit_job_role", $data);
            });
            Route::post("", function (Request $request) {
                $id = $request->job_id;
                $result = employeeController::edit_job_role($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/job_role/edit/$id");
            });
        });
    });
    // Employee routes
    Route::prefix("/employee")->group(function () {
        Route::get("", function () {
            $data = ['employees' => Employee::where('emp_type', 'office')->orWhere('emp_type', 'field')->with('jobrole')->get()->toArray()];
            return view("admin.employee.employees", $data);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $data = ['job_roles' => employeeController::job_roles(), "states" => UtilsController::getStates()];
                return view("admin.employee.add_employee", $data);
            });
            Route::post("", function (Request $request) {
                $result = employeeController::add($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/employee/add");
            });
        });
        Route::prefix("/edit")->group(function () {
            Route::get("/{empId}", function (Employee $empId) {
                $data = ['job_roles' => employeeController::job_roles(), "states" => UtilsController::getStates(), 'emp_data' => $empId->toArray()];
                return view("admin.employee.edit_employee", $data);
            });
            Route::post("", function (Request $request) {
                $result = employeeController::edit($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/employee/edit/" . $request->empId);
            });
        });
    });
    // Seo Routes
    Route::prefix("/web_pages")->group(function () {
        Route::get("", function () {
            $pages = Metadata::paginate(30)->toArray();
            $data = ["pages" => $pages['data'], 'com' => $pages];
            return view('admin.seo.pages', $data);
        });
        Route::prefix("/edit")->group(function () {
            Route::get("/{id}", function (Metadata $id) {
                $data = ["metadata" => $id->toArray()];
                return view('admin.seo.edit', $data);
            });
            Route::post("", function (Request $request) {
                $result = UtilsController::edit_metadata($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/web_pages/edit/" . $request->meta_id);
            });
        });
    });
    // Blogs Routes
    
    Route::controller(BlogController::class)->prefix("/blogs")->group(function () {
        Route::get('', 'ui_view_blogs');

        Route::prefix("add")->group(function () {
            Route::get('', 'ui_editor');
            Route::post('', 'web_editor');
        });
        
    });

    // Exams Routes

    Route::controller(ExamController::class)->group(function () {
        // Job-Opening Section Routes
        Route::get('/job-openings', 'ui_view_jobs');
        Route::get('/job-openings/add', 'ui_add_jobs');
        Route::post('/job-openings/add', 'web_add_jobs')->name('web_add_jobs');
        Route::delete('/job-openings/{id}',  'destroyjob')->name('jobopenings.destroyjob');
        Route::get('/job-openings/edit/{id}','edit')->name('jobopenings.edit');
        Route::post('/job-openings/update/{id}','web_update_job')->name('web_update_job');

          
        // Competitive-Exam Section Routes
        Route::get('/competitive-exam', 'ui_view_competitive');
        Route::post('/competitive-exam/add', 'web_add_competitive');
        Route::get('/competitive-exam/add', 'ui_add_competitive');
        Route::delete('/competitive-exam/{id}', 'destroy')->name('competitive-exam.destroy');
        Route::get('/competitive-exam/edit/{id}', 'editexam')->name('competitive-exam.edit');
        Route::post('/competitive-exam/update/{id}', 'update')->name('competitive-exam.update');

         // Scholarship-Exam Section Routes
         Route::get('/scholarship-exam', 'ui_view_scholarship');
         Route::get('/scholarship-exam/add', 'ui_add_scholarship');
         Route::post('/scholarship-exam/add', 'web_add_scholarship')->name('web_add_scholarship');
         Route::delete('/scholarship-exam/{id}', 'destroyscholarship')->name('scholarship-exam.destroyscholarship');
         Route::get('/scholarship-exam/edit/{id}', 'edit_scholarship')->name('scholarship-exam.edit');
         Route::post('/scholarship-exam/update/{id}', 'update_scholarship')->name('scholarship-exam.update');

        
    });

    // Edtech Routes

    Route::get('/ed-tech-franchise', [EdTechController::class, 'index'])->name('ed-tech-franchise');
    Route::delete('/ed-tech-franchise/{id}', [EdTechController::class, 'destroy'])->name('ed-tech-franchise.destroy');
    

    // Franchise Routes
    Route::prefix("/franchise")->group(function () {
        Route::get("", function () {
            $data = ["franchises" => Employee::where('emp_type', 'franchise')->get()->toArray()];
            return view("admin.franchise.view", $data);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $data = ["states" => UtilsController::getStates()];
                return view("admin.franchise.add", $data);
            });
            Route::post("", function (Request $request) {
                $result = FranchiseController::addFranchiese($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/franchise/add");
            });
        });
    });
    // Team Routes
    Route::prefix("/team")->group(function () {
        Route::get("", function () {
            $data = ["teams" => []];
            return view("admin.team.view", $data);
        });
        Route::prefix("/create")->group(function () {
            Route::get("", function () {
                $data = ["employees" => Employee::where("emp_type", "office")->where('emp_status', '1')->get(['id', 'emp_name', 'emp_username', 'emp_pic', 'emp_team'])->toArray()];
                return view("admin.team.create", $data);
            });
            Route::post("", function (Request $request) {
                $result = TeamController::createTeam($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/team/create");
            });
        });
    });
    // Leads Routes

    Route::prefix("/lead")->group(function () {
        
        Route::get("/agent", function () {
            
            $leads = Lead::with(['course', 'university', 'state'])->paginate(30);
            // dd($leads);
            
            $data = ["leads" => $leads];
            
            return view("admin.leads.agent_view", $data);
        });
        Route::get("/social-media", function () {
            
            $leads = MainLead::with(['course'])->paginate(30);
            // dd($leads);
            
            $data = ["leads" => $leads];
            
            return view("admin.leads.social_media_view", $data);
        });
        Route::get("/view-url-links", function(){
            $urlleads = UrlLinksLead::paginate(30);
            
            $data = ["leads" => $urlleads];
            
            return view("admin.leads.url_links_view", $data);

        });
        Route::get("/update/{leadId}", function ($leadId) {
            $data = ["updates" => Leadupdate::where("lead_id", $leadId)->get()->toArray()];
            return view("admin.leads.updates", $data);
        });
        Route::post("/update", function (Request $request) {
            $result = LeadController::addUpdate($request);
            return $result;
        });
        Route::prefix("/create")->group(function () {
            Route::get("", function () {
                $data = [
                    "universities" => University::all(['id', 'univ_name'])->toArray(),
                    "courses" => Course::all(['id', 'course_name', 'course_short_name'])->toArray(),
                    "states" => State::all(['id', 'state_name', 'state_short'])->toArray()
                ];
                return view("admin.leads.create", $data);
            });
            Route::post("", function (Request $request) {
                $result = LeadController::create($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/lead/create");
            });
        });
        Route::prefix("/create-add-url-links")->group(function () {
            Route::get("", function () {
                return view("admin.leads.add_url_links_leads");
            });
            Route::post("", function (Request $request) {
                $result = LeadController::create_url_links($request);
                if ($result['success']) {
                    session()->flash('success', $result['message']);
                } else {
                    session()->flash('error', $result['message']);
                }
                return redirect("/admin/lead/create-add-url-links");
            });
        });
    });
    
    Route::prefix("/adminpage")->group(function () {
        Route::get("", function () {
            return "Working on this";
        });
        Route::get("/create", function () {
            return "Working on this";
        });
        Route::prefix("/group")->group(function () {
            Route::get("", function () {
                return "Working on this";
            });
            Route::get("/create", function () {
                return "Working on this";
            });
        });
    });
    // Route::prefix("/adminpage")->group(function () {
    //     Route::get("", function () {
    //     });
    // });
});
