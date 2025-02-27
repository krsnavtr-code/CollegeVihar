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
    static function getUniversities()
    {
        return University::orderBy('univ_name', 'asc')->with('courses')->paginate(30);
    }

    /* Get university data */
    static function getUniversity(University $univId)
    {
        return $univId;
    }

    /* Add New University */
    static function addUniversity(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'univ_name' => 'required|unique:universities,univ_name',
            'univ_url' => 'required|unique:universities,univ_url',
            'univ_type' => 'nullable',
            'univ_person' => 'nullable',
            'univ_person_email' => 'nullable',
            'univ_person_phone' => 'nullable',
            'univ_payout' => 'nullable|numeric',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $uni = new University;

        // University Basic Details
        $uni->univ_name = $request->univ_name;
        $uni->univ_url = $request->univ_url;
        $uni->univ_type = $request->univ_type;

        // University person to contact
        $uni->univ_person = $request->univ_person;
        $uni->univ_person_email = $request->univ_person_email;
        $uni->univ_person_phone = $request->univ_person_phone;
        $uni->univ_payout = $request->univ_payout;
        $uni->save();

        // Adding University Courses
        foreach ($request->course as $cor) {
            courseController::addUnivCourse($uni->id, $cor);
        }

        return redirect('/admin/university/add')->with([
            'success' => true,
            'message' => 'University added successfully.'
        ]);   
       
    }

    /* Update University Details */
    static function editUniversity(Request $request)
    {
        $uni = University::find($request->univ_id);
        // University Basic Details
        $uni->univ_name = $request->univ_name;
        $uni->univ_url = $request->univ_url;
        $uni->univ_type = $request->univ_type;

        // University person to contact
        $uni->univ_person = $request->univ_person;
        $uni->univ_person_email = $request->univ_person_email;
        $uni->univ_person_phone = $request->univ_person_phone;
        $uni->save();

        // Adding University Courses
        foreach ($request->course as $cor) {
            isset($cor['old_id']) ? courseController::editUnivCourse($cor) : courseController::addUnivCourse($uni->id, $cor);
        }
        return ["success" => true];
      
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
        $uni->univ_payout = $request->univ_payout;

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
        return view ('user.info.showuniversity');
    }

    
}


  
