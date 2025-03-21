<?php

use App\Http\Controllers\backend\courseController;
use App\Http\Controllers\backend\employeeController;
use App\Http\Controllers\backend\UniversityController;
use App\Http\Controllers\backend\UtilsController;
use App\Models\Course;
use App\Models\Metadata;
use App\Models\University;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


// use Illuminate\Http\Request;
use App\Models\Employee;
// use Illuminate\Support\Facades\Hash;

Route::post('/employee/change-password/{id}', function (Request $request, $id) {
    $employee = Employee::find($id);
    if (!$employee) {
        return response()->json(['success' => false, 'message' => 'Employee not found'], 404);
    }

    // $employee->emp_password = Hash::make($request->password); // Password hashing
    $employee->emp_password = $request->password; // Plain text password
    $employee->save();

    return response()->json(['success' => true, 'message' => 'Password updated successfully']);
});


Route::post("/admin/login", function (Request $request) {
    $result = employeeController::login($request);
    return $result;
});
Route::get("/states", function () {
    return UtilsController::getStates();
});

Route::get('/getstates', [UtilsController::class, 'apigetStates']);

// Route to fetch districts based on state ID
Route::get('/getdistricts/{stateId}', [UtilsController::class, 'apigetDistricts']);

Route::get("/university/status/{univId}", function ($univId) {
    $result = UniversityController::toggleUniversityStatus($univId);
    return $result;
});
Route::get("/employee/status/{empId}", function ($empId) {
    $result = employeeController::toggleEmployeeStatus($empId);
    return $result;
});
Route::get("/course/status/{courseId}", function ($courseId) {
    $result = courseController::toggleCourseStatus($courseId);
    return $result;
});
Route::get("/course/delete/{courseId}", function ($courseId) {
    $result = courseController::deleteCourse($courseId);
    return $result;
});
Route::get("/univCourse/{univId}", function ($univId) {
    $result = courseController::getUnivCourses($univId);
    return $result;
});
Route::get("/univCourse/delete/{courseId}", function ($courseId) {
    $result = courseController::deleteUnivCourse($courseId);
    return $result;
});

Route::get("/mail", function () {
    UtilsController::send_mail();
});

// Route::get("search/{query}", function ($query) {
//     // $results = Metadata::where('meta_description', 'LIKE', '%' . $query . '%')->orWhere('meta_keywords', 'LIKE', '%' . $query . '%')->get()->toArray();
//     $results = [];
//     $results+=University::where('univ_name', 'LIKE', '%' . $query . '%')->with('courses')->get()->toArray();
//     $results+=Course::where('course_name', 'LIKE', '%' . $query . '%')->with('universities')->get()->toArray();
//     echo "<pre>";
//     print_r($results);
//     echo "</pre>";
// });

// Search API Routes 
Route::get("search", function (Request $request) {
    $query = $request->input('query');
    
    $universities = University::where('univ_name', 'LIKE', '%' . $query . '%')
        ->take(10)
        ->get(['id', 'univ_name', 'univ_url'])
        ->toArray();

    $courses = Course::where('course_name', 'LIKE', '%' . $query . '%')
        ->take(10)
        ->get(['id', 'course_name'])
        ->toArray();

    // Add type field to distinguish between universities and courses
    $universities = array_map(function($item) {
        $item['type'] = 'university';
        return $item;
    }, $universities);

    $courses = array_map(function($item) {
        $item['type'] = 'course';
        return $item;
    }, $courses);

    $results = array_merge($universities, $courses);
    
    return response()->json($results);
});

Route::get('/course/{id}/universities', function ($id) {
    $course = Course::findOrFail($id);
    $universities = $course->universities()
        ->select('universities.id', 'univ_name', 'univ_url')
        ->get();
    return response()->json($universities);
});
// End Search API Routes

Route::get('/universities/{state?}', [UniversityController::class, 'filterUniversities'])->where('state', '[A-Za-z]+');