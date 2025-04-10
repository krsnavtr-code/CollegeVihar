<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Query;

class QueryController extends Controller
{
    public function submitQuery(Request $request)
    {
        try {
            // Validate input
            $validatedData = $request->validate([
                'uname' => 'required|string|min:2',
                'email' => 'required|email',
                'ucontact' => 'required|digits:10',
                'course' => 'required',
                'location' => 'required|string',
                'message' => 'nullable|string'
            ]);

            // Prepare email content
            $details = [
                'title' => 'New Query Received',
                'body' => "A new query has been received:\n\n" .
                        "Name: {$validatedData['uname']}\n" .
                        "Email: {$validatedData['email']}\n" .
                        "Phone: {$validatedData['ucontact']}\n" .
                        "Course: {$validatedData['course']}\n" .
                        "Location: {$validatedData['location']}\n" .
                        "Message: {$validatedData['message']}"
            ];

            // Send email to admin
            Mail::send('emails.query_form_email', ['details' => $details], function($message) use ($validatedData) {
                $message->to('anand24h@gmail.com')
                        ->subject('New Query from ' . $validatedData['uname']);
            });

            // Send confirmation email to user
            Mail::send('emails.query_form_email', ['details' => [
                'title' => 'Thank you for your query',
                'body' => "Dear {$validatedData['uname']},\n\nThank you for submitting your query. We have received your message and will get back to you shortly.\n\nBest regards,\nCollege Vihar Team"
            ]], function($message) use ($validatedData) {
                $message->to($validatedData['email'])
                        ->subject('Query Confirmation - College Vihar');
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Your query has been submitted successfully. We will contact you shortly.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Please check your inputs: ' . implode(', ', $e->errors())
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred. Please try again later.'
            ], 500);
        }
    }
}
