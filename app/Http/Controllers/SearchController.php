<?php

// app/Http/Controllers/SearchController.php

namespace App\Http\Controllers;

use App\Models\University;

use App\Models\Course;
use App\Models\Lead;
use App\Models\MainLead;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Dompdf\Dompdf;

class SearchController extends Controller
{
    // public function index()
    // {
    //     return view('search.index');
    // }


    public function search(Request $request)
    {
        $query = $request->input('query');

        $universities = University::where('univ_name', 'like', "%$query%")
            ->take(10)
            ->get(['univ_name', 'univ_url']) // Include univ_url only for universities
            ->toArray();

        $courses = Course::where('course_name', 'like', "%$query%")
            ->take(10)
            ->get(['course_name'])
            ->toArray();

        $results = array_merge($universities, $courses);

        return response()->json($results);
    }

    public function submitForm(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:50',
            'email' => 'required|email',
            'phone' => 'required|max:10',
            'course' => 'required',
        ]);

        // Check for existing entry or create a new one
        $mainsiteLead = MainLead::firstOrCreate(
            [
                'lead_name' => $request->name,
                'getNumber' => $request->phone,
                'getEmail' => $request->email,
                'getCourse' => $request->course,
            ],
            [
                'lead_types' => "Mainsite"
            ]
        );

        // Ensure that course data is loaded
        if (!$mainsiteLead->wasRecentlyCreated && $mainsiteLead->relationLoaded('course') === false) {
            $mainsiteLead->load('course');
        }

        // Compose the email with course name
        $courseName = $mainsiteLead->course ? $mainsiteLead->course->course_name : 'Unknown Course';

        
        // Send email using PHP mail function
        $to = 'anand24h@gmail.com';
        $subject = 'College Vihar Lead';
        $message = "Name: {$request->name}\n" .
                "Email: {$request->email}\n" .
                "Phone: {$request->phone}\n" .
                "Course: {$courseName}\n";

        $headers = 'From: info@collegevihar.com' . "\r\n" .
                'Reply-To: info@collegevihar.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

        mail($to, $subject, $message, $headers);

        // Redirect back with a success message flashed to the session
        return back()->with('success', 'Enquiry Form has been submitted successfully!');
    }

    public function handleQueryForm(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'yourName' => 'required|string|max:50',
                'contact' => 'required|string|max:10',
                'emailId' => 'required|email',
                'queryData' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $mainsiteLead = MainLead::firstOrCreate(
                [
                    'lead_name' => $request->yourName,
                    'lead_contact' => $request->contact,
                    'lead_email' => $request->emailId,
                    'lead_query' => $request->queryData,
                ],
                [
                    'lead_types' => "Mainsite"
                ]
            );
    
            return response()->json(['message' => 'Query submitted successfully','status' => 'Success']);
        } catch (\Exception $e) {
            Log::error($e);
    
            return response()->json(['error' => 'An error occurred while submitting the query. Please try again.'], 500);
        }
    }

    public function getStartedNow(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'getName' => 'required|string|max:50',
                'getNumber' => 'required|string|max:11',
                'getEmail' => 'required|email',
                'getAddress' => 'required|string|max:50',
                'getCourse' => 'required|string|max:255',
                'getDescription' => 'required',
            ]);
    
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $mainsiteLead = mainLead::firstOrCreate(
                [
                    'lead_name' => $request->getName,
                    'getNumber' => $request->getNumber,
                    'getEmail' => $request->getEmail,
                    'getAddress' => $request->getAddress,
                    'getCourse' => $request->getCourse,
                    'getDescription' => $request->getDescription,
                ],
                [
                    'lead_types' => "Mainsite"
                ]
            );

    
            return response()->json(['message' => 'Query submitted successfully','status' => 'Success']);
        } catch (\Exception $e) {
            Log::error($e);
    
            return response()->json(['error' => 'An error occurred while submitting the query. Please try again.'], 500);
        }
    }

    public function downloadPDF(Request $request)
    {
        $slug = $request->input('slug');
        
        // Retrieve webpage content
        $url = 'https://collegevihar.com/' . $slug;
        // $url = 'https://collegevihar.com/course/manipal-university-master-of-business-administration--in-human-resource-management';
        $html = file_get_contents($url);

        // Create a new instance of Dompdf
        // It is working
        $dompdf = new Dompdf();

        // Load HTML content
        $dompdf->loadHtml($html);

        // Set paper size (optional)
        $dompdf->setPaper('A4', 'portrait');

        // Render PDF (optional)
        $dompdf->render();

        // Output PDF as a download
        return $dompdf->stream('course.pdf');
    }
}

