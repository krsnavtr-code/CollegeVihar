<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Jobopening;
use App\Models\CompetitiveExam;
use App\Models\Scholarship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ExamController extends Controller
{
    protected const IMG_PATH = parent::IMG_PATH . "logos/";
    public function ui_view_jobs()
    {
       $jobopenings = Jobopening::all();
       return view('admin.exams.viewjob',compact('jobopenings'));
    }

    public function ui_add_jobs()
    {
        return view("admin.exams.Job");
    }

    public function web_add_jobs(Request $request){
             $validated = $request->validate([
                'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'job_profile' => 'required|string',
                'company_name' => 'required|string',
                'company_email' => 'required|string|email',
                'company_phone' => 'required|string',
                'job_experience' => 'required|string',
                'job_detail' => 'required|string',
             ]);

            //  $validated = $this->editor($validated);
             $validated = $this->handleFileUpload($validated);

             Jobopening::create($validated);

             return redirect()->back()->with('success','Job added successfully');
    }

    // private function editor($validated)
    // {
    //     if ($validated['logo']) {
    //         $moved = $this->move_file($validated['logo']);
    //         if ($moved) {
    //             $validated['logo'] = $moved['filename'];
    //         } else {
    //             $validated['logo'] = null;
    //         }
    //     }

    //     return $validated;
    // }
    // Show the form for editing the specified job
    public function edit($id)
    {
        $job = Jobopening::findOrFail($id);
        return view('admin.exams.editjob', compact('job'));
    }
        // Update the specified job in storage
    public function web_update_job(Request $request, $id)
    {
        $validated = $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'job_profile' => 'required|string',
            'company_name' => 'required|string',
            'company_email' => 'required|string|email',
            'company_phone' => 'required|string',
            'job_experience' => 'required|string',
            'job_detail' => 'required|string',
        ]);

        $job = Jobopening::findOrFail($id);

        if ($request->hasFile('logo')) {
            $validated = $this->handleFileUpload($validated);
        } else {
            $validated['logo'] = $job->logo; // Retain the old logo if not replaced
        }

        $job->update($validated);

        return redirect()->route('jobopenings.edit', $job->id)->with('success', 'Job updated successfully');
    }

    // // Handle the file upload and update the logo field
    // private function editor($validated)
    // {
    //     if (isset($validated['logo'])) {
    //         $moved = $this->move_file($validated['logo']);
    //         if ($moved) {
    //             $validated['logo'] = $moved['filename'];
    //         } else {
    //             $validated['logo'] = null;
    //         }
    //     }

    //     return $validated;
    // }
    public function destroyjob($id)
    {
        $exam = Jobopening::findOrFail($id);
        $exam->delete();

        return redirect()->back()->with('success', 'Exam deleted successfully.');
    }
     /**
     * Handle file upload and return the modified data array.
     */
    private function handleFileUpload($validated)
    {
        if (isset($validated['logo'])) {
            $fileName = time() . '.' . $validated['logo']->getClientOriginalExtension();
            $filePath = $validated['logo']->storeAs('logos', $fileName, 'public');
            $validated['logo'] = $filePath;
        }

        return $validated;
    }
    
    public function ui_view_competitive()
    {
          $exams = CompetitiveExam::all();
          return view('admin.exams.viewcompetitiveexam',compact('exams'));
    }

    public function ui_add_competitive()
    {
        return view("admin.exams.CompetitiveExam");
    }

    public function web_add_competitive(Request $request){
            // dd($request->all());

        //     $validatedData = $request->validate([
        //         'exam_type' => 'required|string',
        //         'exam_urls' => 'required|string',
        //         'exam_opening_date' => 'required|date',
        //         'exam_closing_date' => 'required|date',
        //         'exam_info' => 'required|string',
        //         'questions_answers' => 'array|required',
        //         'questions_answers.*' => 'string',
        //         'videos' => 'array|required',
        //         'videos.*' => 'url',
        //         'mock_tests' => 'array|required',
        //         'mock_tests.*' => 'string',
        //         'exam_syllabus' => 'required|string',
        //     ]);

        // // Check if validation passed
        // dd($validatedData);
    // Debugging line to check if data is received
    // Log::info('Request Data:', $request->all());

    // Prepare the data and encode arrays to JSON

    $examUrls = $request->input('exam_urls', []);
    $examUrls = is_array($examUrls) ? $examUrls : explode("\n", $examUrls);

    $fullUrls = [];
    foreach ($examUrls as $additionalDetail) {
        $fullUrls[] = 'https://collegevihar.com/competitive-exam/' . strtolower($request->input('exam_type')) . '/' . trim($additionalDetail);
    }

    $videos = $request->input('videos', []);
    $thumbnails = $request->input('thumbnails', []);
    
    $videoData = [];
    foreach ($videos as $index => $video) {
        $videoData[] = [
            'video_url' => $video,
            'thumbnail_url' => $thumbnails[$index] ?? null,
        ];
    }
    
    
    $data = [
        'exam_type' => $request->input('exam_type'),
        'exam_urls' => json_encode($fullUrls),
        'exam_opening_date' => $request->input('exam_opening_date'),
        'exam_closing_date' => $request->input('exam_closing_date'),
        'exam_info' => $request->input('exam_info'),
        // 'questions_answers' => $request->input('questions_answers'),
        'questions' => json_encode($request->input('questions')),
        'answers' => json_encode($request->input('answers')),
        'videos' => json_encode($videoData),
        // 'mock_tests' => $request->input('mock_tests'),
        'mock_test_questions' => json_encode($request->input('mock_test_questions')),
        'mock_test_answers' => json_encode($request->input('mock_test_answers')),
        'exam_syllabus' => $request->input('exam_syllabus'),
    ];

    // dd($data);
    // Log the data to be saved
    // Log::info('Data to be saved:', $data);

    // Create new exam instance and save the data
    $exam = new CompetitiveExam($data);
    $exam->save();

    return redirect()->back()->with('success', 'Exam added successfully');
}

public function editexam($id)
{
    $exam = CompetitiveExam::findOrFail($id);
    $exam->exam_urls = is_string($exam->exam_urls) ? json_decode($exam->exam_urls, true) : $exam->exam_urls;
    $exam->videos = is_string($exam->videos) ? json_decode($exam->videos, true) : $exam->videos;

    return view('admin.exams.editcompetitive', compact('exam'));
}

public function update(Request $request, $id)
{
    $exam = CompetitiveExam::findOrFail($id);

    // Process exam URLs
    $examUrls = $request->input('exam_urls');
    if (is_string($examUrls)) {
        $examUrls = explode("\n", $examUrls);
    }

    $fullUrls = [];
    foreach ($examUrls as $additionalDetail) {
        $fullUrls[] = 'https://collegevihar.com/competitive-exam/' . strtolower($request->input('exam_type')) . '/' . trim($additionalDetail);
    }

    // Process video URLs and thumbnails
    $videos = $request->input('videos', []);
    $thumbnails = $request->input('thumbnails', []);
    
    $videoData = [];
    foreach ($videos as $index => $video) {
        $videoData[] = [
            'video_url' => $video,
            'thumbnail_url' => $thumbnails[$index] ?? null,
        ];
    }

    // Directly assign request data to the model attributes
    $exam->exam_type = $request->input('exam_type');
    $exam->exam_urls = json_encode($fullUrls);
    $exam->exam_opening_date = $request->input('exam_opening_date');
    $exam->exam_closing_date = $request->input('exam_closing_date');
    $exam->exam_info = $request->input('exam_info');
    $exam->questions = json_encode($request->input('questions'));
    $exam->answers = json_encode($request->input('answers'));
    $exam->videos = json_encode($videoData);
    $exam->mock_test_questions = json_encode($request->input('mock_test_questions'));
    $exam->mock_test_answers = json_encode($request->input('mock_test_answers'));
    $exam->exam_syllabus = $request->input('exam_syllabus');

    // Save the updated model
    $exam->save();

    return redirect()->route('competitive-exam.edit', $exam->id)->with('success', 'Exam updated successfully');
}
                                         

    public function destroy($id)
    {
        $exam = CompetitiveExam::findorFail($id);
        $exam->delete();

        return redirect()->back()->with('success','Exam Deleted Successfully');
    }

    public function ui_view_scholarship()
    {
          $exams = Scholarship::all();
          return view('admin.exams.viewscholarshipexam',compact('exams'));
    }

    public function ui_add_scholarship()
    {
        return view("admin.exams.ScholarshipExam");
    }

    public function web_add_scholarship(Request $request){

        $examUrls = $request->input('exam_urls', []);
        $examUrls = is_array($examUrls) ? $examUrls : explode("\n", $examUrls);

        $fullUrls = [];
        foreach ($examUrls as $additionalDetail) {
            $fullUrls[] = 'https://collegevihar.scholarship-exam/' . strtolower($request->input('scholarship_type')) . '/' . trim($additionalDetail);
        }

        // Process video URLs and thumbnails
        $videos = $request->input('videos', []);
        $thumbnails = $request->input('thumbnails', []);
        
        $videoData = [];
        foreach ($videos as $index => $video) {
            $videoData[] = [
                'video_url' => $video,
                'thumbnail_url' => $thumbnails[$index] ?? null,
            ];
        }

        $data = [
            'scholarship_type' => $request->input('scholarship_type'),
            'exam_urls' => json_encode($fullUrls),
            'scholarship_info' => $request->input('scholarship_info'),
            'questions' => json_encode($request->input('questions')),
            'answers' => json_encode($request->input('answers')),
            'videos' => json_encode($videoData),
            'mock_test_questions' => json_encode($request->input('mock_test_questions')),
            'mock_test_answers' => json_encode($request->input('mock_test_answers')),
            'scholarship_syllabus' => $request->input('scholarship_syllabus'),
        ];

        $exam = new Scholarship($data);

        $exam->save();

        return redirect()->back()->with('success', 'Scholarship added successfully');
    }
    

    public function edit_scholarship($id)
    {
        $exam = Scholarship::findOrFail($id);
        $exam->exam_urls = is_string($exam->exam_urls) ? json_decode($exam->exam_urls, true) : $exam->exam_urls;
        $exam->videos = is_string($exam->videos) ? json_decode($exam->videos, true) : $exam->videos;
        return view('admin.exams.editscholarship', compact('exam'));
    }

    public function update_scholarship(Request $request, $id)
    {
        $exam = Scholarship::findOrFail($id);

         // Process exam URLs
        $examUrls = $request->input('exam_urls');
             if (is_string($examUrls)) {
               $examUrls = explode("\n", $examUrls);
             }
    
        $fullUrls = [];
        foreach ($examUrls as $additionalDetail) {
            $fullUrls[] = 'https://collegevihar.scholarship-exam/' . strtolower($request->input('scholarship_type')) . '/' . trim($additionalDetail);
        }

        // Process video URLs and thumbnails
        $videos = $request->input('videos', []);
        $thumbnails = $request->input('thumbnails', []);
        
        $videoData = [];
        foreach ($videos as $index => $video) {
            $videoData[] = [
                'video_url' => $video,
                'thumbnail_url' => $thumbnails[$index] ?? null,
            ];
        }

        // Update the exam
        $exam->scholarship_type = $request->input('scholarship_type');
        $exam->exam_urls = json_encode($fullUrls);
        $exam->scholarship_info = $request->input('scholarship_info');
        $exam->questions = json_encode($request->input('questions'));
        $exam->answers = json_encode($request->input('answers'));
        $exam->videos = json_encode($videoData);
        $exam->mock_test_questions = json_encode($request->input('mock_test_questions'));
        $exam->mock_test_answers = json_encode($request->input('mock_test_answers'));
        $exam->scholarship_syllabus = $request->input('scholarship_syllabus');

        $exam->save();

        return redirect()->route('scholarship-exam.edit', $exam->id)->with('success', 'Scholarship updated successfully');
    }

    public function destroyscholarship($id)
    {
        $exam = Scholarship::findorFail($id);
        $exam->delete();

        return redirect()->back()->with('success','Exam Deleted Successfully');
    }
}
