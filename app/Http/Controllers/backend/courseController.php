<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Metadata;
use App\Models\University;
use App\Models\UniversityCourse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log as Logger;

class courseController extends Controller
{
    static function getUnivCourses($univId)
    {
        return UniversityCourse::where('university_id', $univId)->with('course:id,course_name,course_short_name')->get(['id', 'course_id', 'university_id'])->toArray();
    }

    static function addCourse(Request $request)
    {
        Logger::info('Starting course creation', ['request' => $request->all()]);

        try {
            // Validate the request
            $validator = Validator::make(
                $request->all(),
                Course::rules(),
                Course::messages()
            );

            if ($validator->fails()) {
                $errors = $validator->errors();
                Logger::warning('Validation failed', ['errors' => $errors->toArray()]);
                return [
                    'success' => false,
                    'errors' => $errors,
                    'message' => 'Validation failed. Please check your input.'
                ];
            }

            // Start database transaction
            DB::beginTransaction();

            // Get the next available ID
            $lastCourse = Course::withTrashed()->orderBy('id', 'desc')->first();
            $newId = $lastCourse ? $lastCourse->id + 1 : 1;

            Logger::info('Creating course with ID: ' . $newId);

            // Create the course
            $course = new Course();
            $course->id = $newId;
            $course->course_name = ucwords(strtolower(trim($request->course_name)));
            $course->course_short_name = strtoupper(trim($request->course_short_name));
            $course->course_category = $request->course_category;
            $course->course_subcategory = $request->course_subcategory;
            $course->course_online = $request->boolean('course_online');
            $course->course_type = $request->course_category;  // For backward compatibility
            $course->course_status = 1;  // Active by default
            $course->course_detail_added = 0;  // No details added yet
            $course->created_at = now();
            $course->updated_at = now();

            if (!$course->save()) {
                throw new \Exception('Failed to save course');
            }

            // Create metadata for the course
            $metadata = new Metadata();
            $metadata->meta_title = $course->course_name . ' - College Vihar';
            $metadata->meta_description = 'Learn ' . $course->course_name . ' from top universities on College Vihar.';
            $metadata->meta_keywords = $course->course_name . ', online course, college vihar';
            $metadata->meta_h1 = $course->course_name; // Using meta_h1 instead of page_title
            $metadata->meta_canonical = strtolower(str_replace(' ', '-', $course->course_name)) . '-' . $newId;
            $metadata->url_slug = strtolower(str_replace(' ', '-', $course->course_name)) . '-' . $newId;
            $metadata->created_at = now();
            $metadata->updated_at = now();

            if (!$metadata->save()) {
                throw new \Exception('Failed to save metadata');
            }

            // Update course with metadata ID
            $course->course_slug = $metadata->id;
            $course->save();

            // Commit the transaction
            DB::commit();

            return [
                'success' => true,
                'message' => 'Course added successfully!',
                'course_id' => $course->id
            ];
        } catch (\Exception $e) {
            // Rollback transaction on error
            DB::rollBack();

            // Log the error
            Logger::error('Error adding course: ' . $e->getMessage(), [
                'exception' => $e,
                'request' => $request->all()
            ]);

            return [
                'success' => false,
                'message' => 'An error occurred while adding the course. Please try again.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ];
        }
    }

    static function editCourse(Request $request)
    {
        Logger::info('Starting course update', ['request_data' => $request->all()]);
        
        // Get validation rules from model and add course_id validation
        $rules = array_merge(
            ['course_id' => 'required|exists:courses,id'],
            Course::rules($request->course_id) // Pass the course ID to ignore in unique checks
        );

        // Make image optional for updates
        if (isset($rules['course_img'])) {
            $rules['course_img'] = str_replace('required|', '', $rules['course_img']);
        }

        $validator = Validator::make(
            $request->all(),
            $rules,
            Course::messages()
        );

        if ($validator->fails()) {
            $errors = $validator->errors()->toArray();
            Logger::warning('Validation failed', ['errors' => $errors]);
            return [
                'success' => false,
                'errors' => $errors,
                'message' => 'Validation failed. Please check your input.'
            ];
        }

        try {
            $course = Course::find($request->course_id);
            if (!$course) {
                $errorMsg = 'Course with ID ' . $request->course_id . ' not found';
                Logger::error($errorMsg);
                return [
                    'success' => false,
                    'message' => 'Course not found',
                    'error' => $errorMsg
                ];
            }


            // Log current course data before update
            Logger::info('Current course data', $course->toArray());
            
            // Update course details
            $course->course_name = ucwords(strtolower(trim($request->course_name)));
            $course->course_short_name = strtoupper(trim($request->course_short_name));
            $course->course_category = $request->course_category;
            $course->course_subcategory = $request->course_subcategory;
            $course->course_online = $request->boolean('course_online');
            $course->course_type = $request->course_category;  // For backward compatibility
            $course->updated_at = now();

            Logger::info('Attempting to save course with data', $course->toArray());
            
            $saved = $course->save();
            
            if (!$saved) {
                Logger::error('Failed to save course', ['course_id' => $course->id]);
            } else {
                Logger::info('Course updated successfully', ['course_id' => $course->id]);
            }

            return [
                'success' => $saved,
                'message' => $saved ? 'Course updated successfully' : 'Failed to update course',
                'course' => $saved ? $course : null
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error updating course: ' . $e->getMessage(),
                'error' => $e->getTraceAsString()
            ];
        }
    }

    /**
     * Permanently delete a course and its related data
     *
     * @param int $courseId
     * @return array
     */
    static function deleteCourse($courseId)
    {
        try {
            // Find the course with relationships to delete
            $course = Course::with(['universities', 'metadata'])->find($courseId);

            if (!$course) {
                return [
                    'success' => false,
                    'message' => 'Course not found'
                ];
            }

            // Store course name for success message
            $courseName = $course->course_name;

            // Check for dependent leads and get lead details
            $leads = DB::table('main_leads')
                ->where('getCourse', $courseId)
                ->select('id', 'lead_name as name', 'getEmail as email', 'getNumber as phone')
                ->get();

            if ($leads->isNotEmpty()) {
                $leadDetails = $leads->map(function ($lead) {
                    return sprintf(
                        'ID: %d - %s (Email: %s, Phone: %s)',
                        $lead->id,
                        $lead->name ?? 'No Name',
                        $lead->email ?? 'No Email',
                        $lead->phone ?? 'No Phone'
                    );
                })->implode("\n");

                return [
                    'success' => false,
                    'message' => 'Cannot delete course "' . $courseName . '" because it has ' . $leads->count() . ' associated leads.<br><br>Leads:<br>' . str_replace("\n", '<br>', $leadDetails) . '<br><br>Please update or delete these leads first.',
                    'leads' => $leads->map(function ($lead) {
                        return [
                            'id' => $lead->id,
                            'name' => $lead->name ?? 'No Name',
                            'email' => $lead->email ?? 'No Email',
                            'phone' => $lead->phone ?? 'No Phone'
                        ];
                    }),
                    'html' => true
                ];
            }

            // Start a database transaction
            DB::beginTransaction();

            try {
                // Delete related data first to maintain referential integrity
                if ($course->metadata) {
                    $course->metadata()->delete();
                }

                // Detach from universities (pivot table)
                if ($course->universities->isNotEmpty()) {
                    $course->universities()->detach();
                }

                // Delete course image if exists
                if ($course->course_img && file_exists(public_path('images/courses/course_images/' . $course->course_img))) {
                    unlink(public_path('images/courses/course_images/' . $course->course_img));
                }

                // Delete the course
                $deleted = $course->delete();

                // Commit the transaction
                DB::commit();

                return [
                    'success' => $deleted,
                    'message' => $deleted
                        ? 'Course "' . $courseName . '" has been deleted successfully'
                        : 'Failed to delete course',
                    'course_name' => $courseName
                ];
            } catch (\Exception $e) {
                // Rollback the transaction on error
                DB::rollBack();
                throw $e;
            }
        } catch (\Exception $e) {
            Logger::error('Error deleting course ID ' . $courseId . ': ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'An error occurred while deleting the course: ' . $e->getMessage()
            ];
        }
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

        foreach ($request->course_highlights as $highlight)
            $highlights[] = $highlight;
        foreach ($request->course_type as $type)
            $course_type[] = $type;
        foreach ($request->faq as $faq)
            $faqs[] = $faq;

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

        $request->merge(['univ_slug' => 'course/' . $request->course_slug]);
        $result = UtilsController::add_metadata($request);

        if ($result['success']) {
            $course->course_slug = $result['id'];
        }
        return ['success' => $course->save()];
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

        foreach ($request->course_highlights as $highlight)
            $highlights[] = $highlight;
        foreach ($request->course_type as $type)
            $course_type[] = $type;
        foreach ($request->faq as $faq)
            $faqs[] = $faq;

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

        return ['success' => $course->save()];
    }

    static function toggleCourseStatus($courseId)
    {
        try {
            DB::beginTransaction();

            $course = Course::findOrFail($courseId);
            $newStatus = !$course->course_status;

            // If we're deactivating the course, remove it from users
            if ($newStatus === false) {
                // Check if user_courses table exists before trying to delete
                if (\Illuminate\Support\Facades\Schema::hasTable('user_courses')) {
                    // Remove from user_courses table if it exists
                    DB::table('user_courses')
                        ->where('course_id', $courseId)
                        ->delete();
                }

                // You can add more logic here if needed, like sending notifications
            }

            $course->course_status = $newStatus;
            $course->save();

            DB::commit();

            return [
                'success' => true,
                'new_status' => $newStatus,
                'message' => $newStatus ? 'Course activated successfully' : 'Course deactivated successfully'
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'success' => false,
                'message' => 'Error toggling course status: ' . $e->getMessage()
            ];
        }
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

        foreach ($request->uc_subjects as $value)
            $subject[] = $value;
        foreach ($request->uc_details as $value)
            $details[] = $value;
        $course->uc_subjects = json_encode($subject);
        $course->uc_details = json_encode($details);

        $course->uc_assign = json_encode($request->uc_assign);
        $course->uc_job = json_encode($request->uc_job);
        $course->univ_course_detail_added = 1;

        $request->merge(['univ_slug' => 'course/' . $request->course_slug]);
        $result = UtilsController::add_metadata($request);

        if ($result['success']) {
            $course->univ_course_slug = $result['id'];
        }
        return ['success' => $course->save()];
    }

    /* Permanent Delete Course */
    static function deleteUnivCourse($courseId)
    {
        $course = UniversityCourse::find($courseId);
        return ['success' => $course->delete()];
    }

    static function toggleUnivCourseStatus($courseId)
    {
        $course = UniversityCourse::find($courseId);
        $course->univ_course_status = !$course->course_status;
        return ['success' => $course->save()];
    }
}
