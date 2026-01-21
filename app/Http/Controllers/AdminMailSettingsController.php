<?php

namespace App\Http\Controllers;

use App\Models\MailSetting;
use Illuminate\Http\Request;

class AdminMailSettingsController extends Controller
{
    /**
     * Display the mail settings.
     */
    public function index()
    {
        $mailSetting = MailSetting::first();

        // If no settings exist, create default
        if (!$mailSetting) {
            $mailSetting = MailSetting::create([
                'mail_driver' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => 587,
                'mail_encryption' => 'tls',
                'mail_from_name' => 'Miles Montego',
                'is_active' => false,
            ]);
        }

        return view('admin-mail-settings', compact('mailSetting'));
    }

    /**
     * Update the mail settings.
     */
    public function update(Request $request)
    {
        try {
            $mailSetting = MailSetting::first();

            if (!$mailSetting) {
                $mailSetting = MailSetting::create([
                    'mail_driver' => 'smtp',
                    'mail_host' => 'smtp.gmail.com',
                    'mail_port' => 587,
                    'mail_encryption' => 'tls',
                    'mail_from_name' => 'DreamsTour',
                    'is_active' => false,
                ]);
            }

            $data = [
                'mail_driver' => $request->mail_driver ?? 'smtp',
                'mail_host' => $request->mail_host ?? 'smtp.gmail.com',
                'mail_port' => $request->mail_port ?? 587,
                'mail_username' => $request->mail_username ?? null,
                'mail_password' => $request->mail_password ?? null,
                'mail_encryption' => $request->mail_encryption ?? 'tls',
                'mail_from_address' => $request->mail_from_address ?? 'test@example.com',
                'mail_from_name' => $request->mail_from_name ?? 'DreamsTour',
                'mailgun_domain' => $request->mailgun_domain ?? null,
                'mailgun_secret' => $request->mailgun_secret ?? null,
                'mailgun_endpoint' => $request->mailgun_endpoint ?? 'api.mailgun.net',
                'ses_key' => $request->ses_key ?? null,
                'ses_secret' => $request->ses_secret ?? null,
                'ses_region' => $request->ses_region ?? 'us-east-1',
                'is_active' => $request->is_active ? 1 : 0,
            ];

            $mailSetting->update($data);

            // Update .env file with mail settings
            $this->updateEnvFile($data);

            return redirect()->back()->with('success', 'Mail settings updated successfully!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }

    /**
     * Update .env file with mail settings
     */
    private function updateEnvFile(array $data)
    {
        $envFile = base_path('.env');

        if (!file_exists($envFile)) {
            return; // .env file doesn't exist
        }

        $envContent = file_get_contents($envFile);
        $lines = explode("\n", $envContent);
        $updated = false;

        // Map database fields to .env variables
        $envMappings = [
            'mail_driver' => 'MAIL_MAILER',
            'mail_host' => 'MAIL_HOST',
            'mail_port' => 'MAIL_PORT',
            'mail_username' => 'MAIL_USERNAME',
            'mail_password' => 'MAIL_PASSWORD',
            'mail_encryption' => 'MAIL_ENCRYPTION',
            'mail_from_address' => 'MAIL_FROM_ADDRESS',
            'mail_from_name' => 'MAIL_FROM_NAME',
        ];

        foreach ($lines as $index => $line) {
            // Skip comments and empty lines
            if (empty(trim($line)) || strpos(trim($line), '#') === 0) {
                continue;
            }

            foreach ($envMappings as $dbField => $envVar) {
                if (strpos($line, "{$envVar}=") === 0) {
                    $value = $data[$dbField] ?? '';
                    // Quote values that contain spaces
                    if (strpos($value, ' ') !== false) {
                        $value = '"' . $value . '"';
                    }
                    $lines[$index] = "{$envVar}={$value}";
                    $updated = true;
                    break;
                }
            }
        }

        // If no updates were made, add missing variables
        $existingVars = [];
        foreach ($lines as $line) {
            if (preg_match('/^([A-Z_]+)=/', $line, $matches)) {
                $existingVars[] = $matches[1];
            }
        }

        foreach ($envMappings as $dbField => $envVar) {
            if (!in_array($envVar, $existingVars)) {
                $value = $data[$dbField] ?? '';
                // Quote values that contain spaces
                if (strpos($value, ' ') !== false) {
                    $value = '"' . $value . '"';
                }
                $lines[] = "{$envVar}={$value}";
                $updated = true;
            }
        }

        if ($updated) {
            // Write back to .env file
            $newContent = implode("\n", $lines);
            file_put_contents($envFile, $newContent);
        }
    }

    /**
     * Test the mail configuration.
     */
    public function test(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        try {
            $mailSetting = MailSetting::first();

            if (!$mailSetting) {
                return redirect()->back()->with('error', 'No mail settings configured. Please save mail settings first.');
            }

            if (!$mailSetting->is_active) {
                return redirect()->back()->with('error', 'Mail settings are not active. Please check "Active Configuration" and save settings.');
            }

            // Ensure we have required values
            $fromAddress = $mailSetting->mail_from_address ?: 'test@example.com';
            $fromName = $mailSetting->mail_from_name ?: 'DreamsTour';

            // Configure mail dynamically
            config([
                'mail.default' => $mailSetting->mail_driver ?? 'smtp',
                'mail.mailers.smtp.host' => $mailSetting->mail_host ?? 'smtp.gmail.com',
                'mail.mailers.smtp.port' => $mailSetting->mail_port ?? 587,
                'mail.mailers.smtp.username' => $mailSetting->mail_username,
                'mail.mailers.smtp.password' => $mailSetting->mail_password,
                'mail.mailers.smtp.encryption' => $mailSetting->mail_encryption ?? 'tls',
                'mail.from.address' => $fromAddress,
                'mail.from.name' => $fromName,
            ]);

            // Send test email
            \Illuminate\Support\Facades\Mail::raw(
                'This is a test email from Miles Montego mail configuration.',
                function ($message) use ($request, $fromAddress, $fromName) {
                    $message->to($request->test_email)
                            ->subject('Miles Montego Mail Test')
                            ->from($fromAddress, $fromName);
                }
            );

            return redirect()->back()->with('success', 'Test email sent successfully to ' . $request->test_email);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
