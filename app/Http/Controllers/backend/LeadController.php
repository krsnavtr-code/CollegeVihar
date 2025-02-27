<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Leadupdate;
use App\Models\UrlLinksLead;
use Illuminate\Http\Request;

define("MAIL_WELCOME", ["subject" => "Welcome Mail", "message" => "<h1>Cool Dude</h1>", "headers" => "MIME-Version: 1.0\r\nContent-type:text/html;charset=UTF-8\r\nCc: anand24h@gmail.com\r\nBcc: anand24h@gmail.com\r\n"]);

class LeadController extends Controller
{
    static function create(Request $request)
    {
         // Validate the inputs
         $validatedData = $request->validate([
            'agent_name' => 'required|string|max:255',
            'lead_name' => 'required|string|max:255',
            'lead_dob' => 'nullable|date',
            'lead_contact' => 'required|string|max:10',
            'lead_email' => 'nullable|email|max:255',
            'lead_old_qualification' => 'nullable|string|max:255',
            'state' => 'required|integer',
            'mode_of_admission' => 'required|string|in:Online,Offline,Single-Seating,Back-Date,Distance,International'
        ]);
  
        // Check for existing entry or create a new one
        $lead = Lead::firstOrNew(
            [                
                'lead_contact' => $request->lead_contact,
                'lead_email' => $request->lead_email,
            ],
            [
                'lead_name' => $request->lead_name,
                'agent_name' => $request->agent_name,
                'lead_dob' => $request->lead_dob,
                'lead_old_qualification' => $request->lead_old_qualification,
                'lead_university' => $request->lead_university,
                'lead_course' => $request->lead_course,
                'state_id' => $request->state,
                'mode_of_admission' => $request->mode_of_admission,
            ]
        );
       

        $headers = "From:noreply@firstvite.com\r\nContent-type:text/html;charset=UTF-8\r\nMIME-Version: 1.0\r\n";
        if ($request->lead_email) {
            mail($request->lead_email, "Welcome To College Vihar", "<h1 style='color:red'></h1><img src='http://collegevihar.com/images/web%20assets/logo_full.png'/>", $headers);
        }
        return ["success" => $lead->save()];
    }

    static function create_url_links($request){
        $request->validate([
            'agent_name' => 'required|string|max:255',
            'social_media_1' => 'required|url|max:255',
            'social_media_2' => 'required|url|max:255',
            'social_media_3' => 'required|url|max:255',
            'social_media_4' => 'required|url|max:255',
            'job_opening' => 'required|url|max:255',
            'linkedin_profile_1' => 'required|url|max:255',
            'linkedin_profile_2' => 'required|url|max:255',
            'linkedin_profile_3' => 'required|url|max:255',
            'linkedin_profile_4' => 'required|url|max:255',
            'linkedin_profile_5' => 'required|url|max:255',
            'linkedin_profile_6' => 'required|url|max:255',
            'linkedin_profile_7' => 'required|url|max:255',
            'linkedin_profile_8' => 'required|url|max:255',
            'linkedin_profile_9' => 'required|url|max:255',
            'linkedin_profile_10' => 'required|url|max:255',
        ]);
    
        $existingLead = UrlLinksLead::where('agent_name', $request->agent_name)
            ->where('social_media_link_1', $request->social_media_1)
            ->where('social_media_link_2', $request->social_media_2)
            ->where('social_media_link_3', $request->social_media_3)
            ->where('social_media_link_4', $request->social_media_4)
            ->where('job_opening_link', $request->job_opening)
            ->where('linkedin_profile_link_1', $request->linkedin_profile_1)
            ->where('linkedin_profile_link_2', $request->linkedin_profile_2)
            ->where('linkedin_profile_link_3', $request->linkedin_profile_3)
            ->where('linkedin_profile_link_4', $request->linkedin_profile_4)
            ->where('linkedin_profile_link_5', $request->linkedin_profile_5)
            ->where('linkedin_profile_link_6', $request->linkedin_profile_6)
            ->where('linkedin_profile_link_7', $request->linkedin_profile_7)
            ->where('linkedin_profile_link_8', $request->linkedin_profile_8)
            ->where('linkedin_profile_link_9', $request->linkedin_profile_9)
            ->where('linkedin_profile_link_10', $request->linkedin_profile_10)
            ->first();
    
        if ($existingLead) {
            return [
                'success' => false,
                'message' => 'A lead with the same details already exists.'
            ];
        }
    
        $lead_urls = new UrlLinksLead;
        $lead_urls->agent_name = $request->agent_name;
        $lead_urls->social_media_link_1 = $request->social_media_1;
        $lead_urls->social_media_link_2 = $request->social_media_2;
        $lead_urls->social_media_link_3 = $request->social_media_3;
        $lead_urls->social_media_link_4 = $request->social_media_4;
        $lead_urls->job_opening_link = $request->job_opening;
        $lead_urls->linkedin_profile_link_1 = $request->linkedin_profile_1;
        $lead_urls->linkedin_profile_link_2 = $request->linkedin_profile_2;
        $lead_urls->linkedin_profile_link_3 = $request->linkedin_profile_3;
        $lead_urls->linkedin_profile_link_4 = $request->linkedin_profile_4;
        $lead_urls->linkedin_profile_link_5 = $request->linkedin_profile_5;
        $lead_urls->linkedin_profile_link_6 = $request->linkedin_profile_6;
        $lead_urls->linkedin_profile_link_7 = $request->linkedin_profile_7;
        $lead_urls->linkedin_profile_link_8 = $request->linkedin_profile_8;
        $lead_urls->linkedin_profile_link_9 = $request->linkedin_profile_9;
        $lead_urls->linkedin_profile_link_10 = $request->linkedin_profile_10;
        
        $saveSuccess = $lead_urls->save();
    
        return [
            'success' => $saveSuccess,
            'message' => $saveSuccess ? 'URL links lead created successfully!' : 'Failed to create URL links lead.'
        ];

   }
    static function addUpdate($request)
    {
        $update = new Leadupdate;

        $update->lead_id = $request->lead_id;
        $update->update_text = $request->update_from . ": " . $request->update_text;

        return ["success" => $update->save()];
    }
}
