<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\Controller;
use App\Mail\CustomEmail;

class EmailController extends Controller
{
    public function showEmailForm()
    {
        return view('admin.email_form');
    }

    public function sendEmail(Request $request)
    {
        $request->validate([
            'emails' => 'required|string',
            'subject' => 'required|string',
            'message' => 'nullable|string',
            'attachments.*' => 'file|max:2048' // Max 2MB file size
        ]);

        $emails = explode(',', $request->emails);
        $emails = array_map('trim', $emails);

        foreach ($emails as $email) {
            $details = [
                'subject' => $request->subject,
                'message' => $request->message,
                // 'attachments' => $request->attachments, // Attachments
            ];
            // Handle Attachments
            $attachments = [];
            if ($request->hasFile('attachments')) {
                foreach ($request->file('attachments') as $file) {
                    $attachments[] = $file->getPathname(); // Get file path
                }
            }
            $details['attachments'] = $attachments;
            Mail::to($email)->send(new CustomEmail($details));
        }

        return redirect()->back()->with('success', 'Emails sent successfully!');
    }
}
