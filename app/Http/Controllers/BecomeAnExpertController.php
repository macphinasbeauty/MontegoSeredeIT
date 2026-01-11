<?php

namespace App\Http\Controllers;

use App\Models\ExpertApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BecomeAnExpertController extends Controller
{
    public function show()
    {
        return view('become-an-expert');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:expert_applications,email',
            'mobile_number' => 'required|string|max:20',
            'comments' => 'nullable|string',
        ]);

        // Save to database
        $application = ExpertApplication::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'mobile_number' => $request->mobile_number,
            'comments' => $request->comments,
        ]);

        // Send notification email to admin using configured mail settings
        try {
            $mailSetting = \App\Models\MailSetting::active()->first();

            if ($mailSetting) {
                // Configure mail dynamically
                config([
                    'mail.default' => $mailSetting->mail_driver,
                    'mail.mailers.smtp.host' => $mailSetting->mail_host,
                    'mail.mailers.smtp.port' => $mailSetting->mail_port,
                    'mail.mailers.smtp.username' => $mailSetting->mail_username,
                    'mail.mailers.smtp.password' => $mailSetting->mail_password,
                    'mail.mailers.smtp.encryption' => $mailSetting->mail_encryption,
                    'mail.from.address' => $mailSetting->mail_from_address,
                    'mail.from.name' => $mailSetting->mail_from_name,
                ]);
            }

            Mail::to(config('mail.admin_email', 'admin@example.com'))->send(new \App\Mail\ExpertApplicationSubmitted($application));
        } catch (\Exception $e) {
            // Log error but don't fail the application submission
            \Log::error('Failed to send expert application notification email: ' . $e->getMessage());
        }

        return back()->with('success', 'Your application has been submitted successfully! We will contact you soon.');
    }
}
