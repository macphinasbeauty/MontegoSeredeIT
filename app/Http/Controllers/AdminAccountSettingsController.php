<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\UserTwoFactor;
use App\Models\UserLinkedAccount;
use App\Models\UserSocialProfile;
use App\Mail\TwoFactorCode;

class AdminAccountSettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get 2FA settings
        $emailTwoFactor = $user->getTwoFactorFor('email');
        $smsTwoFactor = $user->getTwoFactorFor('sms');

        // Get linked accounts
        $linkedAccounts = $user->linkedAccounts()->get()->keyBy('provider');

        // Get social profiles
        $socialProfiles = $user->socialProfiles()->get()->keyBy('platform');

        return view('admin-account-settings', compact(
            'user',
            'emailTwoFactor',
            'smsTwoFactor',
            'linkedAccounts',
            'socialProfiles'
        ));
    }

    // Two-Factor Authentication Methods
    public function sendTwoFactorCode(Request $request, $type)
    {
        $request->validate([
            'identifier' => 'required|email',
        ]);

        $user = Auth::user();
        $identifier = $request->identifier;

        // Generate 6-digit code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session temporarily (in production, use cache/database)
        session(['2fa_code_' . $type => [
            'code' => Hash::make($code),
            'identifier' => $identifier,
            'expires' => now()->addMinutes(10)
        ]]);

        if ($type === 'email') {
            // Send email
            try {
                Mail::to($identifier)->send(new TwoFactorCode($code));
                return response()->json(['success' => true, 'message' => 'Code sent to your email']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
            }
        } elseif ($type === 'sms') {
            // For SMS, you'd integrate with an SMS service like Twilio
            // For now, just return the code in response (remove in production)
            return response()->json(['success' => true, 'message' => 'Code sent to your phone', 'debug_code' => $code]);
        }

        return response()->json(['success' => false, 'message' => 'Invalid type'], 400);
    }

    public function verifyTwoFactorCode(Request $request, $type)
    {
        $request->validate([
            'code' => 'required|string|size:6',
        ]);

        $user = Auth::user();
        $sessionKey = '2fa_code_' . $type;
        $sessionData = session($sessionKey);

        if (!$sessionData || now()->greaterThan($sessionData['expires'])) {
            return response()->json(['success' => false, 'message' => 'Code expired'], 400);
        }

        if (!Hash::check($request->code, $sessionData['code'])) {
            return response()->json(['success' => false, 'message' => 'Invalid code'], 400);
        }

        // Enable 2FA
        UserTwoFactor::updateOrCreate(
            ['user_id' => $user->id, 'type' => $type],
            [
                'identifier' => $sessionData['identifier'],
                'enabled' => true,
                'verified_at' => now(),
                'backup_codes' => $this->generateBackupCodes(),
            ]
        );

        // Clear session
        session()->forget($sessionKey);

        return response()->json(['success' => true, 'message' => 'Two-factor authentication enabled']);
    }

    public function disableTwoFactor($type)
    {
        $user = Auth::user();

        UserTwoFactor::where('user_id', $user->id)
            ->where('type', $type)
            ->update(['enabled' => false, 'verified_at' => null]);

        return response()->json(['success' => true, 'message' => 'Two-factor authentication disabled']);
    }

    // Linked Accounts Methods
    public function connectLinkedAccount($provider)
    {
        $user = Auth::user();

        // This is a simplified version. In production, you'd implement OAuth flow
        // For now, we'll just mark as connected for demo purposes

        UserLinkedAccount::updateOrCreate(
            ['user_id' => $user->id, 'provider' => $provider],
            [
                'connected' => true,
                'name' => 'Demo User',
                'email' => 'demo@example.com',
            ]
        );

        return response()->json(['success' => true, 'message' => ucfirst($provider) . ' connected']);
    }

    public function disconnectLinkedAccount($provider)
    {
        $user = Auth::user();

        UserLinkedAccount::where('user_id', $user->id)
            ->where('provider', $provider)
            ->update([
                'connected' => false,
                'access_token' => null,
                'refresh_token' => null,
                'token_expires_at' => null,
            ]);

        return response()->json(['success' => true, 'message' => ucfirst($provider) . ' disconnected']);
    }

    // Social Media Profiles Methods
    public function updateSocialProfiles(Request $request)
    {
        $user = Auth::user();

        $platforms = ['facebook', 'twitter', 'instagram', 'youtube'];

        foreach ($platforms as $platform) {
            $profileUrl = $request->input($platform);

            if ($profileUrl) {
                UserSocialProfile::updateOrCreate(
                    ['user_id' => $user->id, 'platform' => $platform],
                    [
                        'profile_url' => $profileUrl,
                        'profile_id' => $this->extractProfileId($platform, $profileUrl),
                        'verified' => false, // In production, you'd verify these
                    ]
                );
            } else {
                // Remove if empty
                UserSocialProfile::where('user_id', $user->id)
                    ->where('platform', $platform)
                    ->delete();
            }
        }

        return redirect()->back()->with('success', 'Social media profiles updated successfully');
    }

    // Helper Methods
    private function generateBackupCodes()
    {
        $codes = [];
        for ($i = 0; $i < 10; $i++) {
            $codes[] = strtoupper(Str::random(8));
        }
        return $codes;
    }

    private function extractProfileId($platform, $url)
    {
        // Simple extraction - in production, you'd want more robust parsing
        $patterns = [
            'facebook' => '/facebook\.com\/([^\/\?]+)/',
            'twitter' => '/twitter\.com\/([^\/\?]+)/',
            'instagram' => '/instagram\.com\/([^\/\?]+)/',
            'youtube' => '/youtube\.com\/(?:@|channel\/|user\/)([^\/\?]+)/',
        ];

        if (isset($patterns[$platform]) && preg_match($patterns[$platform], $url, $matches)) {
            return $matches[1];
        }

        return null;
    }
}
