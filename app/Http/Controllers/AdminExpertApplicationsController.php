<?php

namespace App\Http\Controllers;

use App\Models\ExpertApplication;
use App\Models\User;
use App\Models\Agent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use App\Mail\AgentWelcome;

class AdminExpertApplicationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $applications = ExpertApplication::with('approvedBy')->latest()->paginate(20);
        return view('admin-expert-applications', compact('applications'));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $application = ExpertApplication::with('approvedBy')->findOrFail($id);
        return view('admin-expert-application-detail', compact('application'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $application = ExpertApplication::findOrFail($id);

        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'admin_notes' => 'nullable|string|max:1000',
        ]);

        $data = [
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
        ];

        if ($request->status === 'approved') {
            $data['approved_at'] = now();
            $data['approved_by'] = auth()->id();

            // Create user account and agent record
            $this->createAgentFromApplication($application);
        } elseif ($request->status === 'rejected') {
            $data['approved_by'] = auth()->id();
            // No agent creation for rejected applications
        } elseif ($request->status === 'pending') {
            // Clear approval data when reverting to pending
            $data['approved_at'] = null;
            $data['approved_by'] = null;
        }

        $application->update($data);

        return redirect()->back()->with('success', 'Application status updated successfully.');
    }

    /**
     * Create agent account from approved application
     */
    private function createAgentFromApplication(ExpertApplication $application)
    {
        try {
            // Check if user already exists
            $user = User::where('email', $application->email)->first();
            $userJustCreated = false;
            $password = null;

            if (!$user) {
                // Generate a random password
                $password = Str::random(12);
                $userJustCreated = true;

                // Create new user
                $user = User::create([
                    'name' => $application->first_name . ' ' . $application->last_name,
                    'email' => $application->email,
                    'password' => Hash::make($password),
                    'phone' => $application->mobile_number,
                    'is_admin' => false,
                ]);
            }

            // Check if agent already exists for this user
            $existingAgent = Agent::where('user_id', $user->id)->first();

            if (!$existingAgent) {
                // Create agent record
                Agent::create([
                    'user_id' => $user->id,
                    'name' => $user->name,
                    'first_name' => $application->first_name,
                    'last_name' => $application->last_name,
                    'email' => $application->email,
                    'phone' => $application->mobile_number,
                    'company' => 'DreamsTour Agent',
                    // Set default permissions - can be modified later by admin
                    'can_manage_hotels' => true,
                    'can_manage_cars' => true,
                    'can_manage_tours' => true,
                    'can_manage_cruises' => true,
                    'can_manage_buses' => true,
                    'can_manage_flights' => true,
                ]);
            }

            // Send welcome email with credentials using configured mail settings
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

                    if ($userJustCreated) {
                        // New user - send welcome email with generated password
                        Mail::to($user->email)->send(new AgentWelcome($user, $password));
                    } else {
                        // Existing user - send password reset email so they can access their account
                        Password::sendResetLink(['email' => $user->email]);

                        // Also send welcome notification
                        Mail::to($user->email)->send(new AgentWelcome($user, null));
                    }
                } else {
                    // No active mail settings configured - log warning and skip email
                    \Log::warning('Agent welcome email not sent - no active mail settings configured. Please configure mail settings in admin panel.');
                }
            } catch (\Exception $e) {
                \Log::error('Failed to send agent welcome email: ' . $e->getMessage());
                // Don't fail the entire process if email fails
            }

        } catch (\Exception $e) {
            \Log::error('Failed to create agent account: ' . $e->getMessage());
            throw $e; // Re-throw to let the admin know something went wrong
        }
    }
}
