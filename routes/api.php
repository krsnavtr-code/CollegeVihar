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
Route::get("search/{query}", function ($query) {
    // $results = Metadata::where('meta_description', 'LIKE', '%' . $query . '%')->orWhere('meta_keywords', 'LIKE', '%' . $query . '%')->get()->toArray();
    $results = [];
    $results+=University::where('univ_name', 'LIKE', '%' . $query . '%')->with('courses')->get()->toArray();
    $results+=Course::where('course_name', 'LIKE', '%' . $query . '%')->with('universities')->get()->toArray();
    echo "<pre>";
    print_r($results);
    echo "</pre>";
});



Route::get('/universities/search', [UniversityController::class, 'filterUniversities']);
