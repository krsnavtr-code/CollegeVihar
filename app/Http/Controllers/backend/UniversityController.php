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
    // Update University Details
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

    /* Edit University Detail */
    static function editUniversityDetail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'univ_id' => 'required|exists:universities,id',
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
            'univ_established_year.required' => 'The established year is required.',
            'univ_established_year.min' => 'The established year must be at least 1800.',
            'univ_established_year.max' => 'The established year cannot be in the future.',
            'univ_approved_by.required' => 'The approval body is required.',
            'univ_accreditation.required' => 'The accreditation is required.',
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

        $uni = University::with('gallery')->findOrFail($request->univ_id);

        // Basic details
        $uni->univ_state = $request->univ_state ?? $uni->state_id;
        $uni->univ_address = $request->univ_address;
        $uni->univ_detail_added = $request->univ_detail_added ?? 0;
        $uni->univ_slug = $request->univ_slug ?? Str::slug($uni->univ_name);

        // University other info
        $uni->univ_established_year = $request->univ_established_year;
        $uni->univ_approved_by = $request->univ_approved_by;
        $uni->univ_accreditation = $request->univ_accreditation;
        $uni->univ_programs_offered = $request->univ_programs_offered;

        // JSON encoded fields
        $uni->univ_description = json_encode($request->univ_desc ?? []);
        $uni->univ_facts = json_encode($request->univ_facts ?? []);
        $uni->univ_industry = json_encode($request->industry ?? []);
        $uni->univ_carrier = json_encode($request->carrier ?? []);

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
            $uni->univ_logo = LOGO_PATH . '/' . $logoName;
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
            $uni->univ_image = IMG_PATH . '/' . $bannerName;
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

        // Handle university advantages
        $uni_adv = [
            'about' => $request->univ_adv['about'] ?? '',
            'data' => []
        ];

        if (isset($request->univ_adv['data'])) {
            foreach ($request->univ_adv['data'] as $adv) {
                $logo = $adv['existing_logo'] ?? null;

                // Handle logo upload if a new one is provided
                if (isset($adv['logo']) && $adv['logo'] instanceof \Illuminate\Http\UploadedFile) {
                    $logo = Str::random(10) . now()->timestamp . '.' . $adv['logo']->getClientOriginalExtension();
                    $adv['logo']->move(public_path(PNG_LOGO_PATH), $logo);
                }

                if (!empty($adv['title']) || !empty($adv['description'])) {
                    $uni_adv['data'][] = [
                        'logo' => $logo,
                        'title' => $adv['title'] ?? '',
                        'description' => $adv['description'] ?? ''
                    ];
                }
            }
        }

        $uni->univ_advantage = json_encode($uni_adv);

        // Update slug and metadata
        if (!empty($request->univ_slug)) {
            $request->merge(['univ_slug' => "university/" . $request->univ_slug]);
            $result = UtilsController::add_metadata($request);

            if ($result['success']) {
                $uni->univ_slug = $result['id'];
            }
        }

        // Save all changes to the university
        $uni->save();

        // Handle redirect with success message
        return redirect()->route('admin.university.edit.details', $uni->id)
            ->with('success', 'University details updated successfully!');
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



