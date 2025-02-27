<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Metadata;
use App\Models\UniversityCourse;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

class courseController extends Controller
{
    static function getUnivCourses($univId)
    {
        return UniversityCourse::where('university_id', $univId)->with('course:id,course_name,course_short_name')->get(['id', 'course_id', 'university_id'])->toArray();
    }
    static function addCourse(Request $request)
    {
        $course = new Course();
        $type = $request->course_type;
        $count = Course::where('course_type', $type)->orderBy('id', 'desc')->first()->toArray();
        // dd($count);
        $id = $count['id'];
        // Feeding new Data
        $course->id = $id + 1;

        // Save the new image
        if ($request->hasFile('course_img')) {
            $image = $request->file('course_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/courses/course_images'), $imageName);
            $course->course_img = $imageName;
        }
        
        $course->course_name = $request->course_name;
        $course->course_short_name = $request->course_short_name;
        $course->course_online = $request->course_online;
        $course->course_type = $type;
        return ["success" => $course->save()];
    }
    static function editCourse(Request $request)
    {
        $course = Course::find($request->course_id);

        // Delete the old image if it exists
        if ($course->course_img && File::exists(public_path('images/courses/course_images/' . $course->course_img))) {
            File::delete(public_path('images/courses/course_images/' . $course->course_img));
        }

        // Save the new image
        if ($request->hasFile('course_img')) {
            $image = $request->file('course_img');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images/courses/course_images'), $imageName);
            $course->course_img = $imageName;
        }
        $course->course_name = $request->course_name;
        $course->course_short_name = $request->course_short_name;
        $course->course_type = $request->course_type;
        return ["success" => $course->save()];
    }
    /* Permanent Delete Course */
    static function deleteCourse($courseId)
    {
        $course = Course::find($courseId);
        return ["success" => $course->delete()];
    }
    static function addCourseDetails(Request $request)
    {
        $highlights = [];
        $course_type = [];
        $faqs = [];

        $course = Course::find($request->course_id);
        $course->course_duration = $request->course_duration;
        $course->course_eligibility_short = $request->course_eligibility_short;
        $course->course_freights = $request->course_freights;
        $course->course_slug = $request->course_slug;
        $course->course_detail_added = $request->course_detail_added ?? 0;

        foreach ($request->course_highlights as $highlight) $highlights[] = $highlight;
        foreach ($request->course_type as $type) $course_type[] = $type;
        foreach ($request->faq as $faq) $faqs[] = $faq;

        $course->course_highlights = json_encode($highlights);
        $course->course_types = json_encode($course_type);
        $course->course_faqs = json_encode($faqs);

        $course->course_intro = json_encode($request->course_intro);
        $course->course_overview = json_encode($request->course_overview);
        $course->course_subjects = json_encode($request->course_subjects);
        $course->course_eligibility = json_encode($request->course_eligibility);
        $course->course_specialization = json_encode($request->course_specialization);
        $course->course_job = json_encode($request->course_job);
        $course->why_this_course = json_encode($request->why_this_course);

        $request->merge(['univ_slug' => "course/" . $request->course_slug]);
        $result = UtilsController::add_metadata($request);

        if ($result['success']) {
            $course->course_slug = $result['id'];
        }
        return  ["success" => $course->save()];
    }
    static function editCourseDetails(Request $request)
    {
        $highlights = [];
        $course_type = [];
        $faqs = [];

        $course = Course::find($request->course_id);
        $course->course_duration = $request->course_duration;
        $course->course_eligibility_short = $request->course_eligibility_short;
        $course->course_freights = $request->course_freights;

        foreach ($request->course_highlights as $highlight) $highlights[] = $highlight;
        foreach ($request->course_type as $type) $course_type[] = $type;
        foreach ($request->faq as $faq) $faqs[] = $faq;

        $course->course_highlights = json_encode($highlights);
        $course->course_types = json_encode($course_type);
        $course->course_faqs = json_encode($faqs);

        $course->course_intro = json_encode($request->course_intro);
        $course->course_overview = json_encode($request->course_overview);
        $course->course_subjects = json_encode($request->course_subjects);
        $course->course_eligibility = json_encode($request->course_eligibility);
        $course->course_specialization = json_encode($request->course_specialization);
        $course->course_job = json_encode($request->course_job);
        $course->why_this_course = json_encode($request->why_this_course);

        return  ["success" => $course->save()];
    }
    static function toggleCourseStatus($courseId)
    {
        $course = Course::find($courseId);
        $course->course_status = !$course->course_status;
        return  ["success" => $course->save()];
    }
    static function addUnivCourse($uni, $cor)
    {
        $course = new UniversityCourse;
        $course->course_id = $cor['id'];
        $course->university_id = $uni;
        $course->univ_course_commision = $cor['commision'];
        $course->univ_course_fee = $cor['fee'];
        $course->save();
    }
    static function editUnivCourse($cor)
    {
        $course = UniversityCourse::find($cor['old_id']);
        $course->univ_course_commision = $cor['commision'];
        $course->univ_course_fee = $cor['fee'];
        $course->save();
    }
    static function editUnivCourseDetails(Request $request)
    {
        // dd($request->all());
        $course = UniversityCourse::find($request->course_id);

        $course->uc_about = json_encode($request->uc_about);
        $course->uc_overview = json_encode($request->uc_overview);
        $course->uc_cv_help = json_encode($request->uc_cv_help);
        // $course->uc_speci = json_encode($request->uc_speci);
        $course->uc_collab = json_encode($request->uc_collab);
        $course->uc_expert = json_encode($request->uc_expert);
        $course->uc_highlight = json_encode($request->uc_highlights);

        foreach ($request->uc_subjects as $value) $subject[] = $value;
        foreach ($request->uc_details as $value) $details[] = $value;
        $course->uc_subjects = json_encode($subject);
        $course->uc_details = json_encode($details);

        $course->uc_assign = json_encode($request->uc_assign);
        $course->uc_job = json_encode($request->uc_job);
        $course->univ_course_detail_added = 1;
        
        $request->merge(['univ_slug' => "course/" . $request->course_slug]);
        $result = UtilsController::add_metadata($request);
        
        if ($result['success']) {
            $course->univ_course_slug = $result['id'];
        }
        return  ["success" => $course->save()];
    }
    /* Permanent Delete Course */
    static function deleteUnivCourse($courseId)
    {
        $course = UniversityCourse::find($courseId);
        return ["success" => $course->delete()];
    }
    static function toggleUnivCourseStatus($courseId)
    {
        $course = UniversityCourse::find($courseId);
        $course->univ_course_status = !$course->course_status;
        return  ["success" => $course->save()];
    }
}
