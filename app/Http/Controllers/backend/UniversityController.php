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
        ], [
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
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
        $uni->save();

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
        ], [
            'country_id.required' => 'The country field is required.',
            'state_id.required' => 'The state field is required.',
            'city_id.required' => 'The city field is required.',
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
        
        $uni->save();

        // Update University Courses
        if (isset($request->course) && is_array($request->course)) {
            foreach ($request->course as $cor) {
                try {
                    isset($cor['old_id']) 
                        ? courseController::editUnivCourse($cor) 
                        : courseController::addUnivCourse($uni->id, $cor);
                } catch (\Exception $e) {
                    // Log error if needed
                    Log::error("Error updating course: " . $e->getMessage());
                }
            }
        }
        
        return ["success" => true, "message" => "University updated successfully"];
    }

    /* Add University Detail */
    static function addUniversityDetail(Request $request)
    {
        $uni_adv = [];

        $uni = University::find($request->univ_id);

        $uni->univ_state = $request->univ_state;
        $uni->univ_address = $request->univ_address;
        $uni->univ_detail_added = $request->univ_detail_added ?? 0;
        $uni->univ_slug = $request->univ_slug;

        $uni->univ_description = json_encode($request->univ_desc);
        $uni->univ_facts = json_encode($request->univ_facts);
        $uni->univ_industry = json_encode($request->industry);
        $uni->univ_carrier = json_encode($request->carrier);

        if ($request->univ_logo) {
            $uni->univ_logo = Str::random(10) . now()->timestamp . '.' . $request->univ_logo->getClientOriginalExtension();
            $request->univ_logo->move(LOGO_PATH, $uni->univ_logo);
        }
        if ($request->univ_image) {
            $uni->univ_image = Str::random(10) . now()->timestamp . '.' . $request->univ_image->getClientOriginalExtension();
            $request->univ_image->move(IMG_PATH, $uni->univ_image);
        }

        $uni_adv['about'] = $request->univ_adv['about'];
        foreach ($request->univ_adv['data'] as $adv) {
            if ($adv['logo']) {
                $logo = Str::random(10) . now()->timestamp . '.' . $adv['logo']->getClientOriginalExtension();
                $adv['logo']->move(PNG_LOGO_PATH, $logo);
            }
            $uni_adv['data'][] = [
                "logo" => $logo,
                "title" => $adv['title'],
                "description" => $adv['description']
            ];
        }
        $uni->univ_advantage = json_encode($uni_adv);

        $request->merge(['univ_slug' => "university/" . $request->univ_slug]);
        $result = UtilsController::add_metadata($request);

        if ($result['success']) {
            $uni->univ_slug = $result['id'];
        }

        return ["success" => $uni->save()];
    }

    /* Add University Detail */
    static function editUniversityDetail(Request $request)
    {
        // dd($request->all());
        $uni = University::find($request->univ_id);

        $uni->univ_state = $request->univ_state;
        $uni->univ_address = $request->univ_address;
        $uni->univ_payout = $request->univ_payout;

        $uni->univ_description = json_encode($request->univ_desc);
        $uni->univ_facts = json_encode($request->univ_facts);
        $uni->univ_industry = json_encode($request->industry);
        $uni->univ_carrier = json_encode($request->carrier);

        if ($request->univ_logo) {
            if ($request->file('univ_logo')->getSize() > 1024 * 1024) {
                return response()->json(['error' => 'University Logo must be smaller than 1 MB'], 422);
            }
            $uni->univ_logo = Str::random(10) . now()->timestamp . '.' . $request->univ_logo->getClientOriginalExtension();
            $request->univ_logo->move(LOGO_PATH, $uni->univ_logo);
        }
        if ($request->univ_image) {
            if ($request->file('univ_image')->getSize() > 1024 * 1024) {
                return response()->json(['error' => 'University Image must be smaller than 1 MB'], 422);
            }
            $uni->univ_image = Str::random(10) . now()->timestamp . '.' . $request->univ_image->getClientOriginalExtension();
            $request->univ_image->move(IMG_PATH, $uni->univ_image);
        }

        $uni_adv['about'] = $request->univ_adv['about'];
        $uni_adv['data'] = [];

        foreach ($request->univ_adv['data'] as $i => $adv) {
            if (isset($adv['logo']) && $request->hasFile("univ_adv.data.$i.logo")) {
                if ($adv['logo']->getSize() > 1024 * 1024) {
                    return response()->json(['error' => 'University Advantage Logo must be smaller than 1 MB'], 422);
                }
                $logo = Str::random(10) . now()->timestamp . '.' . $adv['logo']->getClientOriginalExtension();
                $adv['logo']->move(PNG_LOGO_PATH, $logo);
            }else if (isset($adv['old'])) {
                $logo = $adv['old'];
            }else {
                $logo = null;
            }

            $uni_adv['data'][] = [
                "logo" => $logo,
                "title" => $adv['title'],
                "description" => $adv['description']
            ];
        }
        $uni->univ_advantage = json_encode($uni_adv);

        return ["success" => $uni->save()];
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
                ->where('name', $state)
                ->orWhere('id', $state)
                ->firstOrFail();
            
            // Get universities in this state with their location relationships
            $universities = University::with([
                    'country', 
                    'state', 
                    'city', 
                    'courses' => function($query) {
                        $query->select('id', 'course_name', 'course_type', 'course_duration', 'course_fee');
                    }
                ])
                ->where('state_id', $stateModel->id)
                ->where('univ_status', 1) // Only active universities
                ->withCount('courses')
                ->orderBy('univ_name')
                ->get(['id', 'univ_name', 'univ_slug', 'univ_logo', 'state_id', 'univ_image', 'univ_type']);
                
            // Get all countries, states, and cities for filters
            $countries = \App\Models\Country::orderBy('name')->get(['id', 'name']);
            $states = \App\Models\State::orderBy('name')->get(['id', 'name', 'country_id']);
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
                $query->whereHas('courses', function($q) use ($request) {
                    $q->where('course_type', $request->course_type);
                });
            }
            
            if ($request->has('course_name') && $request->course_name) {
                $query->whereHas('courses', function($q) use ($request) {
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
            $transformed = $universities->map(function($university) {
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
                    'courses' => $university->courses->map(function($course) {
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
            'courses' => function($q) {
                $q->select('id', 'course_name', 'course_type', 'course_duration', 'course_fee');
            }, 
            'metadata'
        ]);

        // Filter by state (URL parameter)
        if ($state) {
            $query->whereHas('state', function($q) use ($state) {
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



