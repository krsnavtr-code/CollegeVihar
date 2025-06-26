<?php

use App\Http\Controllers\backend\employeeController;
use App\Http\Controllers\backend\UniversityController;
use App\Http\Controllers\backend\UtilsController;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\backend\courseController;
use App\Http\Controllers\backend\FranchiseController;
use App\Http\Controllers\backend\LeadController;
use App\Http\Controllers\backend\TeamController;
use App\Http\Controllers\backend\BlogController;
use App\Http\Controllers\backend\ExamController;
use App\Http\Controllers\backend\EdTechController;
use App\Http\Controllers\MockTestController;
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
use Illuminate\Support\Facades\DB;
use App\Models\Blog;
use App\Models\UrlLinksLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\EmailController;
use App\Http\Middleware\ensurePermission;
use App\Http\Controllers\backend\MetadataConroller;




// Slug update route
Route::post('/update-slug', [\App\Http\Controllers\backend\MetadataConroller::class, 'updateSlug'])->name('admin.update-slug');

// Course status toggle route (temporarily outside middleware for testing)
Route::post('admin/course/toggle-status/{id}', function ($id) {
    return response()->json(\App\Http\Controllers\backend\courseController::toggleCourseStatus($id));
})->name('admin.course.toggle-status');

Route::prefix('/admin/email')->group(function () {  
    Route::get('/send-email', [EmailController::class, 'showEmailForm'])->name('admin.email');
    Route::post('/send-email', [EmailController::class, 'sendEmail'])->name('admin.send-email');
});



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

// Report Routes
Route::prefix('reports')->name('admin.reports.')->group(function () {
    Route::get('/students', function() {
        return response()->streamDownload(function() {
            // Generate and stream CSV
            $handle = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($handle, ['ID', 'Name', 'Email', 'Phone', 'Course', 'Status', 'Created At']);
            
            // Add sample data - replace with actual database query
            $students = []; // Add your student data query here
            
            foreach ($students as $student) {
                fputcsv($handle, [
                    $student->id,
                    $student->name,
                    $student->email,
                    $student->phone,
                    $student->course->name ?? 'N/A',
                    ucfirst($student->status),
                    $student->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($handle);
        }, 'students_report_' . date('Y-m-d') . '.csv');
    })->name('students');
    
    Route::get('/courses', function() {
        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Course Name', 'University', 'Duration', 'Fee', 'Status', 'Created At']);
            
            $courses = []; // Add your course data query here
            
            foreach ($courses as $course) {
                fputcsv($handle, [
                    $course->id,
                    $course->name,
                    $course->university->name ?? 'N/A',
                    $course->duration,
                    $course->fee,
                    $course->is_active ? 'Active' : 'Inactive',
                    $course->created_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($handle);
        }, 'courses_report_' . date('Y-m-d') . '.csv');
    })->name('courses');
    
    Route::get('/admissions', function() {
        return response()->streamDownload(function() {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['ID', 'Student', 'Course', 'University', 'Status', 'Applied At', 'Status Updated At']);
            
            $admissions = []; // Add your admission data query here
            
            foreach ($admissions as $admission) {
                fputcsv($handle, [
                    $admission->id,
                    $admission->student->name ?? 'N/A',
                    $admission->course->name ?? 'N/A',
                    $admission->university->name ?? 'N/A',
                    ucfirst($admission->status),
                    $admission->created_at->format('Y-m-d H:i:s'),
                    $admission->updated_at->format('Y-m-d H:i:s')
                ]);
            }
            
            fclose($handle);
        }, 'admissions_report_' . date('Y-m-d') . '.csv');
    })->name('admissions');
    
    Route::post('/custom', function(Request $request) {
        $request->validate([
            'type' => 'required|in:students,courses,admissions,leads',
            'format' => 'required|in:csv,pdf,excel',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date'
        ]);
        
        // Add your custom report generation logic here
        return response()->download(storage_path('app/reports/custom_report.' . $request->format));
    })->name('custom');
});

Route::middleware('ensurePermission')->group(function () {
    // University Routes
    Route::prefix("/university")->group(function () {
        Route::get("", function (Request $request) {
            $universities = UniversityController::getUniversities($request);
            return view("admin.university.view_univ", [
                'universities' => $universities,
                'search' => $request->search ?? ''
            ]);
        });
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $allCourses = Course::all()->toArray();
                $states = DB::table('states')->get()->map(function($state) {
                    return (array)$state;
                })->toArray();
                
                // Group courses by their type
                $groupedCourses = [
                    'UG' => ['UG'],
                    'PG' => ['PG'],
                    'DIPLOMA' => ['Diploma'],
                    'CERTIFICATION' => ['Certification'],
                    'TECHNICAL' => ['TECHNICAL COURSES'],
                    'MANAGEMENT' => ['MANAGEMENT COURSES'],
                    'MEDICAL' => ['MEDICAL COURSES'],
                    'TRADITIONAL' => ['TRADITIONAL COURSES']
                ];
                
                $coursesByType = [];
                foreach ($allCourses as $course) {
                    foreach ($groupedCourses as $type => $matches) {
                        if (in_array($course['course_type'], $matches)) {
                            $coursesByType[$type][] = $course;
                            break;
                        }
                    }
                }
                
                return view("admin.university.add_univ", [
                    'courseCategories' => [
                        'UG' => ['label' => 'Undergraduate (UG) Courses', 'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']],
                        'PG' => ['label' => 'Postgraduate (PG) Courses', 'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']],
                        'DIPLOMA' => ['label' => 'Diploma Courses', 'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']],
                        'CERTIFICATION' => ['label' => 'Certification Courses', 'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']]
                    ],
                    'coursesByType' => $coursesByType,
                    'states' => $states
                ]);
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
                $allCourses = Course::all()->toArray();
                $university = University::with('courses')->find($univ_id)->toArray();
                
                // Group courses by their type
                $groupedCourses = [
                    'UG' => ['UG'],
                    'PG' => ['PG'],
                    'DIPLOMA' => ['Diploma'],
                    'CERTIFICATION' => ['Certification'],
                    'TECHNICAL' => ['TECHNICAL COURSES'],
                    'MANAGEMENT' => ['MANAGEMENT COURSES'],
                    'MEDICAL' => ['MEDICAL COURSES'],
                    'TRADITIONAL' => ['TRADITIONAL COURSES']
                ];
                
                $coursesByType = [];
                foreach ($allCourses as $course) {
                    foreach ($groupedCourses as $type => $matches) {
                        if (in_array($course['course_type'], $matches)) {
                            $coursesByType[$type][] = $course;
                            break;
                        }
                    }
                }
                
                $states = DB::table('states')->get()->map(function($state) {
                    return (array)$state;
                })->toArray();
                
                $data = [
                    'courses' => $allCourses,
                    'coursesByType' => $coursesByType,
                    'university' => $university,
                    'states' => $states
                ];
                
                return view("admin.university.edit_univ", $data);
            });
            Route::post("", function (Request $request) {
                $result = UniversityController::editUniversity($request);
                session()->flash('success', $result['success']);
                return redirect()->back();
            });
            Route::prefix("details")->group(function () {
                Route::get("{id}", function ($id) {
                    $university = University::with('metadata')->find($id);
                    
                    if (!$university) {
                        return redirect('/admin/university')->with('error', 'University not found');
                    }
                    
                    $universityData = $university->toArray();
                    
                    // Ensure metadata is always an array
                    if (!isset($universityData['metadata']) || !is_array($universityData['metadata'])) {
                        $universityData['metadata'] = [];
                    }
                    
                    // Ensure url_slug exists in metadata
                    if (!isset($universityData['metadata']['url_slug'])) {
                        $universityData['metadata']['url_slug'] = '';
                    }
                    
                    // Get states with the correct field name
                    $states = State::select(['id', 'state_name'])->get()->toArray();
                    
                    // Ensure univ_state is set in university data
                    if (!isset($universityData['univ_state'])) {
                        $universityData['univ_state'] = '';
                    }
                    
                    $data = [
                        "university" => $universityData,
                        "states" => $states,
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
                $university = University::findOrFail($univId, ['id', 'univ_name', 'univ_address']);
                $courses = UniversityCourse::where('university_id', $univId)
                    ->with(['course' => function($query) {
                        $query->select('id', 'course_name', 'course_short_name', 'course_type');
                    }])
                    ->get()
                    ->toArray();
                
                $data = [
                    'university' => $university->toArray(),
                    'courses' => $courses
                ];
                
                return view('admin.course.view_univ_course', $data);
            });
            Route::prefix("edit")->group(function () {
                Route::get("/{courseId}", function ($courseId) {
                    try {
                        // Eager load the relationships
                        $univCourse = UniversityCourse::with(['university', 'course'])->findOrFail($courseId);
                        
                        // Convert to array and ensure all necessary fields are present
                        $courseData = $univCourse->toArray();
                        
                        // Debug: Uncomment to see the data structure
                        // dd($courseData);
                        
                        // Ensure nested relationships are properly set
                        if (isset($courseData['university'])) {
                            $courseData['university_name'] = $courseData['university']['univ_name'] ?? '';
                        }
                        
                        if (isset($courseData['course'])) {
                            $courseData['course_name'] = $courseData['course']['course_name'] ?? '';
                        }
                        
                        // List of all JSON fields that need to be decoded
                        $jsonFields = [
                            'uc_about', 'uc_overview', 'uc_cv_help', 'uc_highlight',
                            'uc_collab', 'uc_expert', 'uc_subjects', 'uc_details', 'uc_job'
                        ];
                        
                        foreach ($jsonFields as $field) {
                            if (!isset($courseData[$field])) {
                                $courseData[$field] = [];
                                continue;
                            }
                            
                            // Skip if already an array
                            if (is_array($courseData[$field])) {
                                continue;
                            }
                            
                            // Handle JSON string
                            if (is_string($courseData[$field]) && !empty($courseData[$field])) {
                                $decoded = json_decode($courseData[$field], true);
                                $courseData[$field] = (json_last_error() === JSON_ERROR_NONE) ? $decoded : [];
                            } else {
                                $courseData[$field] = [];
                            }
                        }
                        
                        return view('admin.course.edit_univ_course', ['course' => $courseData]);
                    } catch (\Exception $e) {
                        // Log the error for debugging
                        Log::error('Error loading course data: ' . $e->getMessage());
                        
                        // Return to previous page with error message
                        return back()->with('error', 'Error loading course data: ' . $e->getMessage());
                    }
                });
                
                Route::post("", function(Request $request) {
                    $result = courseController::editUnivCourseDetails($request);
                    session()->flash('success', $result['success']);
                    return redirect()->back();
                });
            });
        });
    });
    // Courses routes
    Route::prefix("course")->group(function () {
        // Toggle course status
        Route::post('toggle-status/{id}', function ($id) {
            return response()->json(\App\Http\Controllers\backend\courseController::toggleCourseStatus($id));
        })->name('admin.course.toggle-status');
        
        // List all courses
        Route::get("", function () {
            $courses = Course::with('universities')
                ->select(['id', 'course_name', 'course_short_name', 'course_type', 'course_slug', 
                         'course_status', 'course_detail_added', 'course_category', 'course_subcategory',
                         'course_online', 'course_img', 'created_at'])
                ->orderBy('created_at', 'desc')
                ->paginate(100);
            
            return view("admin.course.courses", [
                'courses' => $courses
            ]);
        })->name('admin.course.index');

        // Add course routes
        Route::prefix("add")->group(function () {
            // Show add course form
            Route::get("", function () {
                return view("admin.course.add_course");
            })->name('admin.course.add.form');

            // Handle course creation
            Route::post("", function (Request $request) {
                try {
                    $result = courseController::addCourse($request);
                    
                    if ($result['success']) {
                        session()->flash('success', $result['message']);
                        return redirect()->route('admin.course.edit.form', ['course' => $result['course_id']]);
                    } else {
                        // If there are validation errors, redirect back with errors and input
                        if (isset($result['errors'])) {
                            return redirect()->back()
                                ->withErrors($result['errors'])
                                ->withInput($request->except('_token'));
                        }
                        
                        // For other types of errors
                        session()->flash('error', $result['message']);
                        return redirect()->back()->withInput($request->except('_token'));
                    }
                } catch (\Exception $e) {
                    Log::error('Error in course creation route: ' . $e->getMessage());
                    session()->flash('error', 'An unexpected error occurred. Please try again.');
                    return redirect()->back()->withInput($request->except('_token'));
                }
            })->name('admin.course.add.submit');

            // Course details
            Route::prefix("details")->name('details.')->group(function () {
                // Show add course details form
                Route::get("/{id}", function ($id) {
                    $course = Course::findOrFail($id);
                    return view("admin.course.add_course_details", [
                        'course' => $course->toArray()
                    ]);
                })->name('form');

                // Handle course details submission
                Route::post("", function (Request $request) {
                    $result = courseController::addCourseDetails($request);
                    session()->flash('success', $result['success'] ? 'Course details added successfully' : 'Failed to add course details');
                    return redirect()->route('admin.course.index');
                })->name('submit');
            });
        });

        // Delete course route
        Route::delete('/{course}', function (Course $course) {
            try {
                $result = courseController::deleteCourse($course->id);
                
                if ($result['success']) {
                    return response()->json([
                        'success' => true,
                        'message' => $result['message'] ?? 'Course deleted successfully'
                    ]);
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => $result['message'] ?? 'Failed to delete course'
                    ], 500);
                }
            } catch (\Exception $e) {
                Log::error('Error deleting course: ' . $e->getMessage());
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while deleting the course: ' . $e->getMessage()
                ], 500);
            }
        })->name('admin.course.delete');

        // Edit course routes
        Route::prefix("edit")->name('admin.course.edit.')->group(function () {
            // Show edit course form
            Route::get("/{course}", function (Course $course) {
                return view("admin.course.edit_course", [
                    'course' => $course->toArray()
                ]);
            })->name('form');

            // Handle course update
            Route::post("", function (Request $request) {
                $result = courseController::editCourse($request);
                session()->flash('success', $result['success'] ? 'Course updated successfully' : 'Failed to update course');
                return redirect()->route('admin.course.edit.form', ['course' => $request->course_id]);
            })->name('submit');

            // Course details
            Route::prefix("details")->name('details.')->group(function () {
                // Show edit course details form
                Route::get("/{id}", function ($id) {
                    $course = Course::with('metadata')->findOrFail($id);
                    return view('admin.course.edit_course_details', [
                        'course' => $course->toArray()
                    ]);
                })->name('form');

                // Handle course details update
                Route::post("", function (Request $request) {
                    $result = courseController::editCourseDetails($request);
                    session()->flash('success', $result['success'] ? 'Course details updated successfully' : 'Failed to update course details');
                    return redirect()->route('admin.course.edit.details.form', $request->course_id);
                })->name('submit');
            });
        });

        // Course universities
        Route::prefix("university")->group(function () {
            // View universities for a course
            Route::get("/{course}", function (Course $course) {
                $universities = UniversityCourse::where("course_id", $course->id)
                    ->where('univ_course_status', '1')
                    ->with('university')
                    ->paginate(10);
                    
                return view('admin.university.view_course_univ', [
                    'course' => $course->only(['id', 'course_name', 'course_short_name']),
                    'universities' => $universities
                ]);
            })->name('university.list');

            // Edit university course relationship
            Route::get("/edit/{universityCourse}", function (UniversityCourse $universityCourse) {
                $universityCourse->load('university', 'course');
                return view('admin.university.edit_course_univ', [
                    'universityCourse' => $universityCourse,
                    'course' => $universityCourse->course,
                    'university' => $universityCourse->university
                ]);
            })->name('university.course.edit');

            // Update university course relationship
            Route::post("/update/{universityCourse}", function (Request $request, UniversityCourse $universityCourse) {
                $validated = $request->validate([
                    'univ_course_fee' => 'required|numeric',
                    'univ_course_commision' => 'required|numeric',
                ]);

                $universityCourse->update($validated);

                return redirect()->route('university.list', ['course' => $universityCourse->course_id])
                    ->with('success', 'Course details updated successfully');
            })->name('university.course.update');
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
            $data = ['employees' => Employee::where('emp_type', 'office')
                ->orWhere('emp_type', 'field')
                ->with('jobrole')
                ->get()
                ->toArray()];
            return view("admin.employee.employees", $data);
        });
        
        Route::prefix("/add")->group(function () {
            Route::get("", function () {
                $statesResponse = UtilsController::getStates();
                $states = [];
                
                // Check if the response is a JSON response and get the data
                if ($statesResponse instanceof \Illuminate\Http\JsonResponse) {
                    $states = $statesResponse->getData(true);
                } elseif (is_array($statesResponse)) {
                    $states = $statesResponse;
                } elseif (is_object($statesResponse) && method_exists($statesResponse, 'toArray')) {
                    $states = $statesResponse->toArray();
                }
                
                $data = [
                    'job_roles' => employeeController::job_roles(),
                    'states' => $states
                ];
                return view("admin.employee.add_employee", $data);
            });
            
            Route::post("", function (Request $request) {
                $result = employeeController::add($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/employee");
            });
        });
        
        Route::prefix("/edit")->group(function () {
            Route::get("/{empId}", function (Employee $empId) {
                $statesResponse = UtilsController::getStates();
                $states = [];
                
                // Check if the response is a JSON response and get the data
                if ($statesResponse instanceof \Illuminate\Http\JsonResponse) {
                    $states = $statesResponse->getData(true);
                } elseif (is_array($statesResponse)) {
                    $states = $statesResponse;
                } elseif (is_object($statesResponse) && method_exists($statesResponse, 'toArray')) {
                    $states = $statesResponse->toArray();
                }
                
                $data = [
                    'job_roles' => employeeController::job_roles(),
                    'states' => $states,
                    'emp_data' => $empId->toArray()
                ];
                return view("admin.employee.edit_employee", $data);
            });
            
            Route::post("", function (Request $request) {
                $result = employeeController::edit($request);
                session()->flash('success', $result['success']);
                return redirect("/admin/employee/edit/" . $request->empId);
            });
        });
        
        // Toggle employee status
        Route::post("/toggle-status/{empId}", function ($empId) {
            $result = employeeController::toggleEmployeeStatus($empId);
            return response()->json($result);
        });
    });
    // Seo Routes
    Route::prefix("/web_pages")->group(function () {
        Route::get("", function (Request $request) {
            $query = Metadata::query();
            
            // Apply search filter if search parameter exists
            if ($request->has('search') && !empty($request->search)) {
                $query->where('url_slug', 'like', '%' . $request->search . '%');
            }
            
            $pages = $query->paginate(30);
            $pages->appends(request()->query());
            
            // Prepare pagination data for the view
            $pagesArray = [
                'current_page' => $pages->currentPage(),
                'first_page_url' => $pages->url(1),
                'from' => $pages->firstItem(),
                'last_page' => $pages->lastPage(),
                'last_page_url' => $pages->url($pages->lastPage()),
                'next_page_url' => $pages->nextPageUrl(),
                'path' => $pages->path(),
                'per_page' => $pages->perPage(),
                'prev_page_url' => $pages->previousPageUrl(),
                'to' => $pages->lastItem(),
                'total' => $pages->total(),
            ];
            $data = ["pages" => $pages->items(), 'com' => $pagesArray];
            return view('admin.seo.pages', $data);
        });
        
        // Delete page route
        Route::match(['delete'], '/delete/{id}', function ($id) {
            try {
                $metadata = \App\Models\Metadata::findOrFail($id);
                $metadata->delete();
                
                return response()->json([
                    'success' => true,
                    'message' => 'Page deleted successfully'
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete page: ' . $e->getMessage()
                ], 500);
            }
        })->name('admin.web_pages.delete');
        
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
                $statesResponse = UtilsController::getStates();
                $states = [];
                
                // Check if the response is a JSON response and get the data
                if ($statesResponse instanceof \Illuminate\Http\JsonResponse) {
                    $states = $statesResponse->getData(true);
                } elseif (is_array($statesResponse)) {
                    $states = $statesResponse;
                } elseif (is_object($statesResponse) && method_exists($statesResponse, 'toArray')) {
                    $states = $statesResponse->toArray();
                }
                
                $data = ["states" => $states];
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
            return view("admin.working");
        });
        Route::get("/create", function () {
            return view("admin.working");
        });
        Route::prefix("/group")->group(function () {
            Route::get("", function () {
                return view("admin.working");
            });
            Route::get("/create", function () {
                return view("admin.working");
            });
        });
    });



    

    // Route::prefix("/adminpage")->group(function () {
    //     Route::get("", function () {
    //     });
    // });
    Route::prefix('mock-test')->group(function () {
        Route::get('/', [MockTestController::class, 'index'])->name('admin.mock-test.index');
        Route::get('/view/{id}', [MockTestController::class, 'show'])->name('admin.mock-test.show');
        Route::get('/add', [MockTestController::class, 'create'])->name('admin.mock-test.add');
        Route::post('/add', [MockTestController::class, 'store'])->name('admin.mock-test.store');
        Route::get('/edit/{id}', [MockTestController::class, 'edit'])->name('admin.mock-test.edit');
        Route::put('/edit/{id}', [MockTestController::class, 'update'])->name('admin.mock-test.update');
        Route::delete('/delete/{id}', [MockTestController::class, 'destroy'])->name('admin.mock-test.delete');
    });
});
