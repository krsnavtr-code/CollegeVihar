<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Metadata;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class UtilsController extends Controller
{
    static function getStates()
    {
        return State::all(['id', 'state_name'])->toArray();
    }


    public static function apigetStates()
    {
        // Fetch states from the CoWIN API
        $response = Http::get('https://cdn-api.co-vin.in/api/v2/admin/location/states');
        if ($response->successful()) {
            return $response->json(); // Return JSON response
        }
        return response()->json(['error' => 'Unable to fetch states'], 500);
    }

    // Function to fetch districts based on state ID
    public static function apigetDistricts($stateId)
    {
        // Fetch districts for the selected state
        $response = Http::get("https://cdn-api.co-vin.in/api/v2/admin/location/districts/{$stateId}");
        if ($response->successful()) {
            return $response->json(); // Return JSON response
        }
        return response()->json(['error' => 'Unable to fetch districts'], 500);
    }
    static function add_metadata(Request $request)
    {
        $metadata = new Metadata();

        $metadata->meta_title = $request->meta_title;
        $metadata->meta_h1 = $request->meta_h1;
        $metadata->meta_description = $request->meta_description;
        $metadata->meta_keywords = $request->meta_keywords;
        $metadata->other_meta_tags = $request->other_meta_tags;

        $metadata->url_slug = $request->univ_slug;
        $metadata->meta_canonical = "https://firstvite.com/" . $request->univ_slug;

        $result = $metadata->save();
        if ($result) {
            return ["success" => $result, "id" => $metadata->id];
        } else {
            return ["success" => $result];
        }
    }
    static function edit_metadata(Request $request)
    {
        $metadata = Metadata::find($request->meta_id);

        $metadata->meta_title = $request->meta_title;
        $metadata->meta_h1 = $request->meta_h1;
        $metadata->meta_description = $request->meta_description;
        $metadata->meta_keywords = $request->meta_keywords;
        $metadata->other_meta_tags = $request->other_meta_tags;

        return ["success" => $metadata->save()];
    }
    
    static function send_mail()
    {
        mail("anand24h@gmail.com", "Connect", "connected successfully");
        return ["success" => true];
    }
    static function query_form(Request $request)
    {
        if(Lead::where("lead_contact", $request->ucontact)->get()->toArray()){
            return ["success" => true,"msg"=>"Already Exists"];
        }
        $lead = new Lead;

        $lead->lead_name = $request->uname;
        $lead->lead_contact = $request->ucontact;
        $lead->lead_email = $request->umail;
        $lead->lead_university = $request->uuniversity;
        $lead->lead_course = $request->ucourse;
        $lead->lead_source = "web";
        $lead->lead_query = $request->uquery;

        return ["success"=>$lead->save()];
    }
}
