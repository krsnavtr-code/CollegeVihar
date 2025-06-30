<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Controllers\backend\courseController;
use App\Models\Metadata;
use App\Models\University;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

define("PNG_LOGO_PATH", public_path("icon_png"));
define("LOGO_PATH", public_path("images/university/logo"));
define("IMG_PATH", public_path("images/university/campus"));

class UniversityController extends Controller
{
    /* Get active universities data */
    function getActiveUniversities()
    {
        return University::where('univ_status', '1')->orderBy('univ_name', 'asc')->get()->toArray();
    }

    /**
     * Toggle university status (active/inactive)
     *
     * @param int $univId
     * @return \Illuminate\Http\JsonResponse
     */
    public static function toggleUniversityStatus($univId)
    {
        try {
            $university = University::findOrFail($univId);
            $university->univ_status = $university->univ_status == 1 ? 0 : 1;
            $university->save();

            return response()->json([
                'success' => true,
                'message' => 'University status updated successfully',
                'status' => $university->univ_status
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update university status',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /* Get universities data */
    static function getUniversities(Request $request = null)
    {
        $query = University::orderBy('univ_name', 'asc')->with('courses');

        // Define course categories
        $courseCategories = [
            'UG' => [
                'label' => 'Undergraduate (UG) Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'PG' => [
                'label' => 'Postgraduate (PG) Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'DIPLOMA' => [
                'label' => 'Diploma Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'CERTIFICATION' => [
                'label' => 'Certification Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ]
        ];

        // Add search functionality if search parameter exists
        if ($request && $request->has('search') && !empty($request->search)) {
            $search = $request->search;
            $query->where('univ_name', 'like', "%{$search}%")
                ->orWhere('univ_type', 'like', "%{$search}%")
                ->orWhere('univ_category', 'like', "%{$search}%");
        }

        return $query->paginate(30);
    }

    /* Get university data */
    static function getUniversity(University $univId)
    {
        return $univId;
    }

    /* Add New University */
    static function addUniversity(Request $request)
    {
        // Define course categories for the view
        $courseCategories = [
            'UG' => [
                'label' => 'Undergraduate (UG) Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'PG' => [
                'label' => 'Postgraduate (PG) Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'DIPLOMA' => [
                'label' => 'Diploma Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ],
            'CERTIFICATION' => [
                'label' => 'Certification Courses',
                'subcategories' => ['TECHNICAL', 'MANAGEMENT', 'MEDICAL', 'TRADITIONAL']
            ]
        ];

        $validator = Validator::make($request->all(), [
            'univ_name' => 'required|unique:universities,univ_name',
            'univ_url' => 'required|unique:universities,univ_url',
            'univ_type' => 'required',
            'univ_category' => 'required',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'univ_address' => 'required|string|max:255',
            'univ_established_year' => 'required|integer|min:1800|max:' . date('Y'),
            'univ_approved_by' => 'required|string|max:50',
            'univ_accreditation' => 'required|string|max:10',
            'univ_programs_offered' => 'nullable|string',
            'univ_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'univ_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'univ_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
            'univ_established_year.required' => 'The established year is required.',
            'univ_established_year.min' => 'The established year must be at least 1800.',
            'univ_established_year.max' => 'The established year cannot be in the future.',
            'univ_approved_by.required' => 'The approval body is required.',
            'univ_accreditation.required' => 'The accreditation is required.',
            'univ_logo.required' => 'The university logo is required.',
            'univ_image.required' => 'The university banner image is required.',
            'univ_logo.image' => 'The university logo must be an image.',
            'univ_image.image' => 'The university banner must be an image.',
            'univ_gallery.*.image' => 'Each gallery file must be an image.',
            'univ_logo.mimes' => 'The university logo must be a file of type: jpeg, png, jpg, gif.',
            'univ_image.mimes' => 'The university banner must be a file of type: jpeg, png, jpg, gif.',
            'univ_gallery.*.mimes' => 'Each gallery file must be of type: jpeg, png, jpg, gif.',
            'univ_logo.max' => 'The university logo may not be greater than 2MB.',
            'univ_image.max' => 'The university banner may not be greater than 5MB.',
            'univ_gallery.*.max' => 'Each gallery image may not be greater than 5MB.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify that the state belongs to the selected country
        $state = DB::table('states')
            ->where('id', $request->state_id)
            ->where('country_id', $request->country_id)
            ->first();

        if (!$state) {
            return redirect()->back()
                ->withErrors(['state_id' => 'The selected state does not belong to the selected country.'])
                ->withInput();
        }

        // Verify that the city belongs to the selected state
        $city = DB::table('cities')
            ->where('id', $request->city_id)
            ->where('state_id', $request->state_id)
            ->first();

        if (!$city) {
            return redirect()->back()
                ->withErrors(['city_id' => 'The selected city does not belong to the selected state.'])
                ->withInput();
        }

        $uni = new University;

        // University Basic Details
        $uni->univ_name = $request->univ_name;
        $uni->univ_url = $request->univ_url;
        $uni->univ_type = $request->univ_type;
        $uni->univ_category = $request->univ_category;
        $uni->country_id = $request->country_id;
        $uni->state_id = $request->state_id;
        $uni->city_id = $request->city_id;
        $uni->univ_address = $request->univ_address;

        // Handle logo upload
        if ($request->hasFile('univ_logo')) {
            try {
                $logo = $request->file('univ_logo');
                if ($logo->isValid()) {
                    $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
                    $logo->move(LOGO_PATH, $logoName);
                    $uni->univ_logo = $logoName;
                }
            } catch (\Exception $e) {
                Log::error('Error uploading logo: ' . $e->getMessage());
            }
        }

        // Handle banner upload
        if ($request->hasFile('univ_image')) {
            try {
                $banner = $request->file('univ_image');
                if ($banner->isValid()) {
                    $bannerName = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
                    $banner->move(IMG_PATH, $bannerName);
                    $uni->univ_image = $bannerName;
                }
            } catch (\Exception $e) {
                Log::error('Error uploading banner: ' . $e->getMessage());
            }
        }

        $uni->univ_established_year = $request->univ_established_year;
        $uni->univ_approved_by = $request->univ_approved_by;
        $uni->univ_accreditation = $request->univ_accreditation;
        $uni->univ_programs_offered = $request->univ_programs_offered;
        $uni->save();

        // Handle gallery images
        if ($request->hasFile('univ_gallery')) {
            $galleryPath = 'images/university/gallery/';
            // Ensure the directory exists
            if (!file_exists(public_path($galleryPath))) {
                mkdir(public_path($galleryPath), 0777, true);
            }

            foreach ($request->file('univ_gallery') as $galleryImage) {
                try {
                    // Skip if the file is not valid
                    if (!$galleryImage->isValid()) {
                        continue;
                    }

                    $galleryName = 'gallery_' . time() . '_' . uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                    $destinationPath = public_path($galleryPath);

                    // Move the file first
                    $galleryImage->move($destinationPath, $galleryName);

                    // Get the file size after moving
                    $filePath = $destinationPath . $galleryName;
                    $fileSize = file_exists($filePath) ? filesize($filePath) : 0;

                    $uni->gallery()->create([
                        'image_path' => $galleryPath . $galleryName,
                        'original_name' => $galleryImage->getClientOriginalName(),
                        'mime_type' => $galleryImage->getClientMimeType(),
                        'size' => $fileSize,
                    ]);
                } catch (\Exception $e) {
                    // Log the error but don't stop the process for other files
                    Log::error('Error uploading gallery image: ' . $e->getMessage());
                    continue;
                }
            }
        }

        // Adding University Courses
        if ($request->has('course') && is_array($request->course)) {
            foreach ($request->course as $cor) {
                courseController::addUnivCourse($uni->id, $cor);
            }
        }

        // Get states for the form
        $states = DB::table('states')->get();

        return redirect('/admin/university/add')
            ->with([
                'success' => true,
                'message' => 'University added successfully.'
            ])
            ->with('courseCategories', $courseCategories)
            ->with('states', $states);

    }

    /* Update University Details */
    static function editUniversity(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'univ_name' => 'required|unique:universities,univ_name,' . $request->univ_id,
            'univ_url' => 'required|unique:universities,univ_url,' . $request->univ_id,
            'univ_type' => 'required',
            'univ_category' => 'required',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'required|exists:states,id',
            'city_id' => 'required|exists:cities,id',
            'univ_address' => 'required|string|max:255',
            'univ_established_year' => 'required|integer|min:1800|max:' . date('Y'),
            'univ_approved_by' => 'required|string|max:50',
            'univ_accreditation' => 'required|string|max:10',
            'univ_programs_offered' => 'nullable|string',
            'univ_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'univ_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'univ_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'deleted_gallery' => 'nullable|array',
            'deleted_gallery.*' => 'exists:university_galleries,id',
        ], [
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
            'univ_established_year.required' => 'The established year is required.',
            'univ_established_year.min' => 'The established year must be at least 1800.',
            'univ_established_year.max' => 'The established year cannot be in the future.',
            'univ_approved_by.required' => 'The approval body is required.',
            'univ_accreditation.required' => 'The accreditation is required.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Verify that the state belongs to the selected country
        $state = DB::table('states')
            ->where('id', $request->state_id)
            ->where('country_id', $request->country_id)
            ->first();

        if (!$state) {
            return redirect()->back()
                ->withErrors(['state_id' => 'The selected state does not belong to the selected country.'])
                ->withInput();
        }

        // Verify that the city belongs to the selected state
        $city = DB::table('cities')
            ->where('id', $request->city_id)
            ->where('state_id', $request->state_id)
            ->first();

        if (!$city) {
            return redirect()->back()
                ->withErrors(['city_id' => 'The selected city does not belong to the selected state.'])
                ->withInput();
        }

        $uni = University::find($request->univ_id);
        $uni->univ_name = $request->univ_name;
        $uni->univ_url = $request->univ_url;
        $uni->univ_type = $request->univ_type;
        $uni->univ_category = $request->univ_category;
        $uni->country_id = $request->country_id;
        $uni->state_id = $request->state_id;
        $uni->city_id = $request->city_id;
        $uni->univ_address = $request->univ_address;
        $uni->univ_established_year = $request->univ_established_year;
        $uni->univ_approved_by = $request->univ_approved_by;
        $uni->univ_accreditation = $request->univ_accreditation;
        $uni->univ_programs_offered = $request->univ_programs_offered;

        // Handle logo update/removal
        if ($request->has('remove_logo') && $uni->univ_logo) {
            // Remove logo if checkbox is checked
            if (file_exists(public_path($uni->univ_logo))) {
                unlink(public_path($uni->univ_logo));
            }
            $uni->univ_logo = null;
        } elseif ($request->hasFile('univ_logo')) {
            // Update logo if a new one is uploaded
            if ($uni->univ_logo && file_exists(public_path($uni->univ_logo))) {
                unlink(public_path($uni->univ_logo));
            }
            $logo = $request->file('univ_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path(LOGO_PATH), $logoName);
            $uni->univ_logo = 'images/university/logo/' . $logoName;
        }

        // Handle banner update/removal
        if ($request->has('remove_banner') && $uni->univ_image) {
            // Remove banner if checkbox is checked
            if (file_exists(public_path($uni->univ_image))) {
                unlink(public_path($uni->univ_image));
            }
            $uni->univ_image = null;
        } elseif ($request->hasFile('univ_image')) {
            // Update banner if a new one is uploaded
            if ($uni->univ_image && file_exists(public_path($uni->univ_image))) {
                unlink(public_path($uni->univ_image));
            }
            $banner = $request->file('univ_image');
            $bannerName = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path(IMG_PATH), $bannerName);
            $uni->univ_image = 'images/university/campus/' . $bannerName;
        }

        // Handle gallery images deletion
        if (!empty($request->deleted_gallery)) {
            $galleryToDelete = $uni->gallery()->whereIn('id', $request->deleted_gallery)->get();
            foreach ($galleryToDelete as $image) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }
        }

        // Handle new gallery images upload
        if ($request->hasFile('univ_gallery')) {
            $galleryPath = 'images/university/gallery/';
            if (!file_exists(public_path($galleryPath))) {
                mkdir(public_path($galleryPath), 0777, true);
            }

            foreach ($request->file('univ_gallery') as $galleryImage) {
                try {
                    // Skip if the file is not valid
                    if (!$galleryImage->isValid()) {
                        continue;
                    }

                    $galleryName = 'gallery_' . time() . '_' . uniqid() . '.' . $galleryImage->getClientOriginalExtension();
                    $destinationPath = public_path($galleryPath);

                    // Move the file first
                    $galleryImage->move($destinationPath, $galleryName);

                    // Get the file size after moving
                    $filePath = $destinationPath . $galleryName;
                    $fileSize = file_exists($filePath) ? filesize($filePath) : 0;

                    $uni->gallery()->create([
                        'image_path' => $galleryPath . $galleryName,
                        'original_name' => $galleryImage->getClientOriginalName(),
                        'mime_type' => $galleryImage->getClientMimeType(),
                        'size' => $fileSize,
                    ]);
                } catch (\Exception $e) {
                    // Log the error but don't stop the process for other files
                    Log::error('Error uploading gallery image: ' . $e->getMessage());
                    continue;
                }
            }
        }

        // Save all changes to the university
        $uni->save();

        // Update University Courses
        if (isset($request->courses) && is_array($request->courses)) {
            $uni->courses()->sync($request->courses);
        }

        return redirect('/admin/university/edit/' . $uni->id)
            ->with('success', 'University updated successfully!');
    }


    // Update University all details one by one
    /**
     * Update university slug
     */
    public function updateSlug(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_slug' => 'required|string|max:255|unique:universities,univ_slug,' . $request->univ_id,
        ]);

        $university = University::findOrFail($request->univ_id);
        $university->univ_slug = $request->univ_slug;
        $university->save();

        return back()
            ->with('section', 'slug')
            ->with('message', 'University URL slug updated successfully!');
    }

    /**
     * Update university info/description
     */
    public function updateInfo(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_description' => 'required|array',
            'univ_description.*' => 'required|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        $university->univ_description = json_encode($request->univ_description);
        $university->save();

        return back()
            ->with('section', 'info')
            ->with('message', 'University information updated successfully!');
    }

    /**
     * Update university overview
     */
    public function updateOverview(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_campus_area' => 'nullable|numeric|min:0',
            'univ_courses_offered' => 'nullable|string|max:500',
            'univ_student_strength' => 'nullable|integer|min:0',
            'univ_faculty_strength' => 'nullable|integer|min:0',
        ]);

        $university = University::findOrFail($request->univ_id);
        
        // Update overview fields
        $university->univ_campus_area = $request->univ_campus_area;
        $university->univ_courses_offered = $request->univ_courses_offered;
        $university->univ_student_strength = $request->univ_student_strength;
        $university->univ_faculty_strength = $request->univ_faculty_strength;
        
        $university->save();

        return back()
            ->with('section', 'overview')
            ->with('message', 'University overview updated successfully!');
    }
    
    /**
     * Update university popular courses
     */
    public function updatePopularCourses(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'undergrad_programs' => 'nullable|array',
            'undergrad_programs.*.program' => 'required|string|max:255',
            'undergrad_programs.*.duration' => 'required|string|max:50',
            'undergrad_programs.*.specializations' => 'nullable|string|max:500',
            'postgrad_programs' => 'nullable|array',
            'postgrad_programs.*.program' => 'required|string|max:255',
            'postgrad_programs.*.duration' => 'required|string|max:50',
            'postgrad_programs.*.specializations' => 'nullable|string|max:500',
            'diploma_programs' => 'nullable|array',
            'diploma_programs.*.program' => 'required|string|max:255',
            'diploma_programs.*.duration' => 'required|string|max:50',
            'diploma_programs.*.specializations' => 'nullable|string|max:500',
            'other_programs' => 'nullable|array',
            'other_programs.*.program' => 'required|string|max:255',
            'other_programs.*.duration' => 'required|string|max:50',
            'other_programs.*.specializations' => 'nullable|string|max:500',
        ]);

        $university = University::findOrFail($request->univ_id);
        
        // Prepare popular courses data
        $popularCourses = [
            'undergraduate' => $request->undergrad_programs ?? [],
            'postgraduate' => $request->postgrad_programs ?? [],
            'diploma' => $request->diploma_programs ?? [],
            'others' => $request->other_programs ?? []
        ];
        
        // Remove any empty entries
        foreach ($popularCourses as $key => $programs) {
            $popularCourses[$key] = array_values(array_filter($programs, function($program) {
                return !empty($program['program']) || !empty($program['duration']);
            }));
        }
        
        // Update the university record
        $university->univ_popular_courses = $popularCourses;
        $university->save();

        return back()
            ->with('section', 'popular-courses')
            ->with('message', 'Popular courses updated successfully!');
    }
    
    /**
     * Update university admission process
     */
    public function updateAdmissionProcess(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_admission' => 'nullable|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        
        // Clean and prepare the admission content
        $admissionContent = $request->univ_admission ?? '';
        
        // Update the university record
        $university->univ_admission = $admissionContent;
        $university->save();

        return back()
            ->with('section', 'admission')
            ->with('message', 'Admission process updated successfully!');
    }
    
    /**
     * Update university eligibility criteria
     */
    public function updateEligibilityCriteria(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'eligibility' => 'required|array',
            'eligibility.*.course' => 'required|string|max:255',
            'eligibility.*.percentage' => 'required|numeric|min:0|max:100',
            'eligibility_notes' => 'nullable|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        
        // Prepare eligibility data
        $eligibilityData = [];
        foreach ($request->eligibility as $item) {
            if (!empty($item['course']) && isset($item['percentage'])) {
                $eligibilityData[] = [
                    'course' => $item['course'],
                    'percentage' => (float) $item['percentage']
                ];
            }
        }
        
        // Add notes if provided
        if ($request->filled('eligibility_notes')) {
            $eligibilityData['notes'] = $request->eligibility_notes;
        }
        
        // Update the university record
        $university->univ_eligibility = json_encode($eligibilityData, JSON_PRETTY_PRINT);
        $university->save();

        return back()
            ->with('section', 'eligibility')
            ->with('message', 'Eligibility criteria updated successfully!');
    }
    
    /**
     * Update university placement details
     */
    public function updatePlacement(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'highest_package' => 'nullable|numeric|min:0',
            'average_package' => 'nullable|numeric|min:0',
            'recruiters' => 'nullable|array',
            'recruiters.*' => 'string|max:255',
            'placement_year' => 'nullable|integer|min:2000|max:' . (date('Y') + 1),
            'students_placed' => 'nullable|integer|min:0',
            'placement_percentage' => 'nullable|numeric|min:0|max:100',
            'placement_highlights' => 'nullable|string',
        ]);

        try {
            $university = University::findOrFail($request->univ_id);
            
            // Prepare placement data
            $placementData = [
                'highest_package' => $request->filled('highest_package') ? (float) $request->highest_package : null,
                'average_package' => $request->filled('average_package') ? (float) $request->average_package : null,
                'recruiters' => $request->recruiters ? array_values(array_filter($request->recruiters)) : [],
                'placement_year' => $request->filled('placement_year') ? (int) $request->placement_year : null,
                'students_placed' => $request->filled('students_placed') ? (int) $request->students_placed : null,
                'placement_percentage' => $request->filled('placement_percentage') ? (float) $request->placement_percentage : null,
                'placement_highlights' => $request->placement_highlights,
                'updated_at' => now(),
            ];
            
            // Update the university record
            $university->univ_placement = $placementData;
            $university->save();

            return back()
                ->with('section', 'placement')
                ->with('message', 'Placement details updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Error updating placement details: ' . $e->getMessage());
            return back()
                ->with('section', 'placement')
                ->with('error', 'Failed to update placement details. Please try again.');
        }
    }
    
    /**
     * Update important dates for university
     */
    public function updateImportantDates(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'important_dates' => 'required|array',
            'important_dates.*.event' => 'required|string|max:255',
            'important_dates.*.date' => 'required|date',
            'important_dates.*.description' => 'nullable|string',
            'important_dates_notes' => 'nullable|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        
        // Prepare important dates data
        $importantDatesData = [];
        foreach ($request->important_dates as $item) {
            if (!empty($item['event']) && !empty($item['date'])) {
                $importantDatesData[] = [
                    'event' => $item['event'],
                    'date' => $item['date'],
                    'description' => $item['description'] ?? null,
                ];
            }
        }
        
        // Add notes if provided
        if ($request->filled('important_dates_notes')) {
            $importantDatesData['notes'] = $request->important_dates_notes;
        }
        
        // Update the university record
        $university->important_dates = $importantDatesData;
        $university->save();

        return back()
            ->with('section', 'important_dates')
            ->with('message', 'Important dates updated successfully!');
    }

    /**
     * Update university facts
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateFacts(Request $request)
    {
        try {
            // Log the incoming request data for debugging
            Log::info('Update Facts Request Data:', $request->all());
            
            $validated = $request->validate([
                'univ_id' => 'required|exists:universities,id',
                'univ_facts' => 'required|array|min:1',
                'univ_facts.*' => 'required|string|max:1000',
            ]);

            $university = University::findOrFail($validated['univ_id']);
            
            // Filter out empty facts and reindex the array
            $facts = array_values(array_filter($validated['univ_facts'], function($fact) {
                return !empty(trim($fact));
            }));
            
            if (empty($facts)) {
                return back()
                    ->with('section', 'facts')
                    ->with('error', 'At least one fact is required')
                    ->withInput();
            }
            
            // Log the facts before saving
            Log::info('Saving facts:', $facts);
            
            // Update the university record
            $university->univ_facts = $facts;
            $university->save();
            
            // Log the saved data for verification
            $savedUniversity = University::find($validated['univ_id']);
            Log::info('Saved university facts:', [
                'univ_id' => $validated['univ_id'],
                'saved_facts' => $savedUniversity->univ_facts
            ]);

            return back()
                ->with('section', 'facts')
                ->with('message', 'University facts updated successfully!');
                
        } catch (\Exception $e) {
            Log::error('Error updating university facts: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()
                ->with('section', 'facts')
                ->with('error', 'Failed to update university facts. Please try again.')
                ->withInput();
        }
    }

    /**
     * Update university SEO details
     */
    public function updateSeo(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:500',
            'meta_canonical' => 'nullable|url|max:255',
            'meta_h1' => 'nullable|string|max:255',
        ]);

        $university = University::findOrFail($request->univ_id);

        // Update or create SEO metadata
        $university->meta_title = $request->meta_title;
        $university->meta_description = $request->meta_description;
        $university->meta_keywords = $request->meta_keywords;
        $university->meta_canonical = $request->meta_canonical;
        $university->meta_h1 = $request->meta_h1;

        $university->save();

        return back()->with('success', 'SEO details updated successfully!');
    }

    /**
     * Update university basic information
     */
    public function updateBasicInfo(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_established_year' => 'required|integer|min:1800|max:' . date('Y'),
            'univ_approved_by' => 'required|string|max:50',
            'univ_accreditation' => 'required|string|max:10',
            'univ_programs_offered' => 'nullable|string',
            'univ_address' => 'required|string|max:500',
            'univ_state' => 'required|exists:states,id',
        ], [
            'univ_established_year.required' => 'The established year is required.',
            'univ_established_year.min' => 'The established year must be at least 1800.',
            'univ_established_year.max' => 'The established year cannot be in the future.',
            'univ_approved_by.required' => 'The approval body is required.',
            'univ_accreditation.required' => 'The accreditation is required.',
        ]);

        $university = University::findOrFail($request->univ_id);

        $university->update([
            'univ_established_year' => $request->univ_established_year,
            'univ_approved_by' => $request->univ_approved_by,
            'univ_accreditation' => $request->univ_accreditation,
            'univ_programs_offered' => $request->univ_programs_offered,
            'univ_address' => $request->univ_address,
            'univ_state' => $request->univ_state,
            'univ_detail_added' => 1
        ]);

        return back()->with('success', 'Basic information updated successfully!');
    }

    /**
     * Handle university logo upload
     */
    public function updateLogo(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'univ_logo.required' => 'Please select a logo to upload.',
            'univ_logo.image' => 'The logo must be an image file.',
            'univ_logo.mimes' => 'The logo must be a file of type: jpeg, png, jpg, gif.',
            'univ_logo.max' => 'The logo may not be greater than 2MB.',
        ]);

        $university = University::findOrFail($request->univ_id);

        // Handle logo upload
        if ($request->hasFile('univ_logo')) {
            // Delete old logo if exists
            if ($university->univ_logo && file_exists(public_path($university->univ_logo))) {
                unlink(public_path($university->univ_logo));
            }

            $logo = $request->file('univ_logo');
            $logoName = 'logo_' . time() . '.' . $logo->getClientOriginalExtension();
            $logo->move(public_path('images/university/logo'), $logoName);

            $university->update([
                'univ_logo' => 'images/university/logo/' . $logoName
            ]);
        }

        return back()->with('success', 'University logo updated successfully!');
    }

    /**
     * Handle university banner upload
     */
    public function updateBanner(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'univ_image.required' => 'Please select a banner image to upload.',
            'univ_image.image' => 'The banner must be an image file.',
            'univ_image.mimes' => 'The banner must be a file of type: jpeg, png, jpg, gif.',
            'univ_image.max' => 'The banner may not be greater than 5MB.',
        ]);

        $university = University::findOrFail($request->univ_id);

        // Handle banner upload
        if ($request->hasFile('univ_image')) {
            // Delete old banner if exists
            if ($university->univ_image && file_exists(public_path($university->univ_image))) {
                unlink(public_path($university->univ_image));
            }

            $banner = $request->file('univ_image');
            $bannerName = 'banner_' . time() . '.' . $banner->getClientOriginalExtension();
            $banner->move(public_path('images/university/banner'), $bannerName);

            $university->update([
                'univ_image' => 'images/university/banner/' . $bannerName
            ]);
        }

        return back()->with('success', 'University banner updated successfully!');
    }

    /**
     * Handle university gallery images
     */
    public function updateGallery(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'univ_gallery.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'deleted_gallery' => 'nullable|array',
            'deleted_gallery.*' => 'exists:university_galleries,id',
        ], [
            'univ_gallery.*.image' => 'Each file must be an image.',
            'univ_gallery.*.mimes' => 'Each file must be of type: jpeg, png, jpg, gif.',
            'univ_gallery.*.max' => 'Each image may not be greater than 5MB.',
        ]);

        $university = University::with('gallery')->findOrFail($request->univ_id);

        // Handle deleted gallery items
        if (!empty($request->deleted_gallery)) {
            $galleryToDelete = $university->gallery()->whereIn('id', $request->deleted_gallery)->get();
            foreach ($galleryToDelete as $image) {
                if (file_exists(public_path($image->image_path))) {
                    unlink(public_path($image->image_path));
                }
                $image->delete();
            }
        }

        // Handle new gallery uploads
        if ($request->hasFile('univ_gallery')) {
            $galleryPath = 'images/university/gallery/';
            if (!file_exists(public_path($galleryPath))) {
                mkdir(public_path($galleryPath), 0777, true);
            }

            foreach ($request->file('univ_gallery') as $image) {
                if ($image->isValid()) {
                    $imageName = 'gallery_' . time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                    $image->move(public_path($galleryPath), $imageName);

                    $university->gallery()->create([
                        'image_path' => $galleryPath . $imageName,
                        'original_name' => $image->getClientOriginalName(),
                        'mime_type' => $image->getClientMimeType(),
                        'size' => $image->getSize(),
                    ]);
                }
            }
        }

        return back()->with('success', 'University gallery updated successfully!');
    }

    /**
     * Update university industry connections
     */
    public function updateIndustry(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'industry' => 'required|array',
            'industry.*' => 'required|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        $university->update([
            'univ_industry' => json_encode($request->industry)
        ]);

        return back()->with('success', 'Industry connections updated successfully!');
    }

    /**
     * Update university career guidance
     */
    public function updateCareerGuidance(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'career' => 'required|array',
            'career.*' => 'required|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        $university->update([
            'univ_career_guidance' => json_encode($request->career)
        ]);

        return back()->with('success', 'Career guidance information updated successfully!');
    }

    /**
     * Update university facilities
     */
    public function updateFacilities(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'facilities' => 'required|array',
            'facilities.*.title' => 'required|string|max:255',
            'facilities.*.description' => 'nullable|string',
            'facilities.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $university = University::findOrFail($request->univ_id);
        $facilities = [];
        $facilityPath = 'images/university/facilities/';

        if (!file_exists(public_path($facilityPath))) {
            mkdir(public_path($facilityPath), 0777, true);
        }

        foreach ($request->facilities as $index => $facility) {
            $facilityData = [
                'id' => $facility['id'] ?? 'facility-' . $index . '-' . time(),
                'title' => $facility['title'],
                'description' => $facility['description'] ?? null,
            ];

            // Handle facility image upload if present
            if (isset($facility['image']) && $facility['image']->isValid()) {
                $image = $facility['image'];
                $imageName = 'facility_' . $index . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path($facilityPath), $imageName);
                $facilityData['image'] = $facilityPath . $imageName;
            } elseif (isset($facility['existing_image'])) {
                $facilityData['image'] = $facility['existing_image'];
            }

            $facilities[] = $facilityData;
        }

        $university->update([
            'univ_facilities' => json_encode($facilities)
        ]);

        return back()->with('success', 'University facilities updated successfully!');
    }

    /**
     * Update university scholarships
     */
    public function updateScholarships(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'scholarships' => 'required|array',
            'scholarships.*.name' => 'required|string|max:255',
            'scholarships.*.description' => 'nullable|string',
            'scholarships.*.eligibility' => 'nullable|string',
            'scholarships.*.amount' => 'nullable|string',
        ]);

        $university = University::findOrFail($request->univ_id);
        $university->update([
            'univ_scholarship' => json_encode($request->scholarships)
        ]);

        return back()->with('success', 'Scholarship information updated successfully!');
    }

    /**
     * Update university advantages
     */
    public function updateAdvantages(Request $request)
    {
        $request->validate([
            'univ_id' => 'required|exists:universities,id',
            'about' => 'required|string',
            'advantages' => 'required|array',
            'advantages.*.title' => 'required|string|max:255',
            'advantages.*.description' => 'required|string',
            'advantages.*.logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'advantages.*.existing_logo' => 'nullable|string',
        ]);

        $university = University::findOrFail($request->univ_id);

        $advantages = [
            'about' => $request->about,
            'data' => []
        ];

        foreach ($request->advantages as $index => $adv) {
            $logo = $adv['existing_logo'] ?? null;

            // Handle logo upload if a new one is provided
            if (isset($adv['logo']) && $adv['logo'] instanceof \Illuminate\Http\UploadedFile) {
                $logoName = 'advantage_' . $index . '_' . time() . '.' . $adv['logo']->getClientOriginalExtension();
                $logoPath = 'images/university/advantages/';

                if (!file_exists(public_path($logoPath))) {
                    mkdir(public_path($logoPath), 0777, true);
                }

                $adv['logo']->move(public_path($logoPath), $logoName);
                $logo = $logoPath . $logoName;
            }

            $advantages['data'][] = [
                'logo' => $logo,
                'title' => $adv['title'],
                'description' => $adv['description']
            ];
        }

        $university->update([
            'univ_advantage' => json_encode($advantages)
        ]);

        return back()->with('success', 'University advantages updated successfully!');
    }

    /**
     * Legacy method - kept for backward compatibility
     * Will be removed in future versions
     */
    public static function editUniversityDetail(Request $request)
    {
        // This method is now deprecated and will be removed in future versions
        // All functionality has been moved to individual update methods
        return redirect()->back()->with('warning', 'This action is no longer supported. Please use the individual update forms.');
    }

    /* Permanent Delete University */
    static function deleteUniversity($univId)
    {
        $uni = University::find($univId);

        if (!$uni) {
            return ['success' => false, 'message' => 'University not found.'];
        }

        // Delete related university courses
        $uni->univCourses()->delete();

        // Now delete the university
        $uni->delete();

        return ['success' => true, 'message' => 'University deleted successfully.'];
    }

    public function show($state)
    {
        try {
            // Find the state by name or ID
            $stateModel = \App\Models\State::with('country')
                ->where('state_name', $state)
                ->orWhere('id', $state)
                ->firstOrFail();

            // Get universities in this state with their location relationships
            $universities = University::with([
                'country',
                'state',
                'city',
                'metadata',
                'courses' => function ($query) {
                    $query->select('courses.id', 'courses.course_name', 'courses.course_type', 'courses.course_duration', 'courses.course_freights as course_fee');
                }
            ])
                ->where('state_id', $stateModel->id)
                ->where('univ_status', 1) // Only active universities
                ->withCount('courses')
                ->orderBy('univ_name')
                ->get(['universities.id', 'universities.univ_name', 'universities.univ_slug', 'universities.univ_logo', 'universities.state_id', 'universities.univ_image', 'universities.univ_type', 'universities.univ_address']);

            // Get all countries, states, and cities for filters
            $countries = \App\Models\Country::orderBy('name')->get(['id', 'name']);
            $states = \App\Models\State::orderBy('state_name')->get(['id', 'state_name as name', 'country_id']);
            $cities = \App\Models\City::where('state_id', $stateModel->id)
                ->orderBy('name')
                ->get(['id', 'name', 'state_id']);

            // Get unique course categories
            $categories = University::where('univ_status', 1)
                ->whereNotNull('univ_category')
                ->distinct()
                ->orderBy('univ_category')
                ->pluck('univ_category');

            // Get unique course types from courses
            $courseTypes = \App\Models\Course::select('course_type')
                ->distinct()
                ->whereNotNull('course_type')
                ->orderBy('course_type')
                ->pluck('course_type');

            return view('user.info.showuniversity', [
                'state' => $stateModel,
                'universities' => $universities,
                'countries' => $countries,
                'states' => $states,
                'cities' => $cities,
                'categories' => $categories,
                'courseTypes' => $courseTypes
            ]);

        } catch (\Exception $e) {
            Log::error('Error in UniversityController@show: ' . $e->getMessage());
            abort(404, 'State not found or an error occurred');
        }
    }

    /**
     * API endpoint for filtering universities
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function filterUniversitiesApi(Request $request)
    {
        try {
            $query = University::query()
                ->with(['country', 'state', 'city', 'courses'])
                ->where('univ_status', 1) // Only active universities
                ->withCount('courses');

            // Apply filters
            if ($request->has('country_id') && $request->country_id) {
                $query->where('country_id', $request->country_id);
            }

            if ($request->has('state_id') && $request->state_id) {
                $query->where('state_id', $request->state_id);
            }

            if ($request->has('city_id') && $request->city_id) {
                $query->where('city_id', $request->city_id);
            }

            if ($request->has('univ_category') && $request->univ_category) {
                $query->where('univ_category', $request->univ_category);
            }

            if ($request->has('course_type') && $request->course_type) {
                $query->whereHas('courses', function ($q) use ($request) {
                    $q->where('course_type', $request->course_type);
                });
            }

            if ($request->has('course_name') && $request->course_name) {
                $query->whereHas('courses', function ($q) use ($request) {
                    $q->where('course_name', 'like', '%' . $request->course_name . '%');
                });
            }

            // Search by university name
            if ($request->has('search') && $request->search) {
                $query->where('univ_name', 'like', '%' . $request->search . '%');
            }

            // Sort results
            $sortBy = $request->input('sort_by', 'univ_name');
            $sortOrder = $request->input('sort_order', 'asc');
            $query->orderBy($sortBy, $sortOrder);

            // Get all results (no pagination for now to match the frontend)
            $universities = $query->get();

            // Transform the data to match the frontend's expectations
            $transformed = $universities->map(function ($university) {
                return [
                    'id' => $university->id,
                    'univ_name' => $university->univ_name,
                    'univ_category' => $university->univ_category,
                    'univ_type' => $university->univ_type,
                    'univ_description' => $university->univ_description,
                    'univ_image' => $university->univ_image,
                    'courses_count' => $university->courses_count,
                    'country' => $university->country ? [
                        'id' => $university->country->id,
                        'name' => $university->country->name
                    ] : null,
                    'state' => $university->state ? [
                        'id' => $university->state->id,
                        'name' => $university->state->name
                    ] : null,
                    'city' => $university->city ? [
                        'id' => $university->city->id,
                        'name' => $university->city->name
                    ] : null,
                    'courses' => $university->courses->map(function ($course) {
                        return [
                            'id' => $course->id,
                            'course_name' => $course->course_name,
                            'course_type' => $course->course_type
                        ];
                    })
                ];
            });

            return response()->json([
                'success' => true,
                'universities' => $transformed,
                'message' => 'Universities retrieved successfully.'
            ]);

        } catch (\Exception $e) {
            // Log the error using the Log facade
            Log::error('Error filtering universities: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while filtering universities.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function filterUniversities(Request $request, $state = null)
    {
        $query = University::with([
            'country',
            'state',
            'city',
            'courses' => function ($q) {
                $q->select('id', 'course_name', 'course_type', 'course_duration', 'course_fee');
            },
            'metadata'
        ]);

        // Filter by state (URL parameter)
        if ($state) {
            $query->whereHas('state', function ($q) use ($state) {
                $q->where('name', 'like', '%' . $state . '%')
                    ->orWhere('id', $state);
            });
        }

        // Filter by country
        if ($request->has('country_id') && $request->country_id) {
            $query->where('country_id', $request->country_id);
        }

        // Filter by state (from request)
        if ($request->has('state_id') && $request->state_id) {
            $query->where('state_id', $request->state_id);
        }

        // Filter by city
        if ($request->has('city_id') && $request->city_id) {
            $query->where('city_id', $request->city_id);
        }

        // Filter by university category
        if ($request->has('univ_category') && $request->univ_category != '') {
            $query->where('univ_category', $request->univ_category);
        }

        // Filter by course type
        if ($request->has('course_type') && $request->course_type != '') {
            $query->whereHas('courses', function ($q) use ($request) {
                $q->where('course_type', $request->course_type);
            });
        }

        // Filter by specific course
        if ($request->has('courses') && $request->courses != '') {
            $query->whereHas('courses', function ($q) use ($request) {
                $q->where('course_name', 'like', '%' . $request->courses . '%');
            });
        }

        // Filter by university name
        if ($request->has('univ_name') && $request->univ_name != '') {
            $query->where('univ_name', 'like', '%' . $request->univ_name . '%');
        }

        // Add search parameter for university name (compatibility with frontend)
        if ($request->has('search') && $request->search != '') {
            $query->where('univ_name', 'like', '%' . $request->search . '%');
        }

        // Only get active universities
        $query->where('univ_status', 1);

        // Add course count
        $query->withCount('courses');

        // Execute the query with specific columns to avoid selecting non-existent columns
        $universities = $query->get([
            'id',
            'univ_name',
            'univ_slug',
            'univ_logo',
            'state_id',
            'city_id',
            'country_id',
            'univ_image',
            'univ_type',
            'univ_category',
            'univ_description'
        ]);

        // Get courses for the filter (if needed)
        $courses = [];
        if ($request->has('course_type') && $request->course_type != '') {
            $courses = \App\Models\Course::where('course_type', $request->course_type)
                ->select('id', 'course_name')
                ->orderBy('course_name')
                ->get()
                ->toArray();
        }

        return response()->json([
            'universities' => $universities,
            'courses' => $courses
        ]);
    }

}



