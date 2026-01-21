<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use App\Models\UserTwoFactor;
use App\Mail\TwoFactorCode;

class AdminSecuritySettingsController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get 2FA settings
        $emailTwoFactor = $user->getTwoFactorFor('email');
        $smsTwoFactor = $user->getTwoFactorFor('sms');

        // Get password last changed info
        $passwordLastChanged = $user->updated_at->format('d M Y, H:i A');

        return view('admin-security-settings', compact(
            'user',
            'emailTwoFactor',
            'smsTwoFactor',
            'passwordLastChanged'
        ));
    }

    // Password Change Methods
    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()->symbols()],
        ]);

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Current password is incorrect'], 400);
        }

        // Update password
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['success' => true, 'message' => 'Password changed successfully']);
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

        // Store in session temporarily
        session(['2fa_code_' . $type => [
            'code' => Hash::make($code),
            'identifier' => $identifier,
            'expires' => now()->addMinutes(10)
        ]]);

        if ($type === 'email') {
            try {
                Mail::to($identifier)->send(new TwoFactorCode($code));
                return response()->json(['success' => true, 'message' => 'Code sent to your email']);
            } catch (\Exception $e) {
                return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
            }
        } elseif ($type === 'sms') {
            // For SMS, integrate with SMS service like Twilio
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

    public function toggleTwoFactor($type)
    {
        $user = Auth::user();
        $twoFactor = $user->getTwoFactorFor($type);

        if ($twoFactor && $twoFactor->isEnabled()) {
            // Disable 2FA
            $twoFactor->update(['enabled' => false, 'verified_at' => null]);
            $message = 'Two-factor authentication disabled';
        } else {
            // For enabling, we need to go through verification process
            return response()->json(['success' => false, 'message' => 'Please verify your email/phone first'], 400);
        }

        return response()->json(['success' => true, 'message' => $message]);
    }

    public function disableTwoFactor($type)
    {
        $user = Auth::user();

        UserTwoFactor::where('user_id', $user->id)
            ->where('type', $type)
            ->update(['enabled' => false, 'verified_at' => null]);

        return response()->json(['success' => true, 'message' => 'Two-factor authentication disabled']);
    }

    // Password Reset Methods (for admin to reset other users' passwords)
    public function resetUserPassword(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        // Only allow admins to reset other users' passwords
        if (!Auth::user()->is_admin) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $user = User::find($request->user_id);

        // Generate temporary password
        $tempPassword = Str::random(12);

        $user->password = Hash::make($tempPassword);
        $user->save();

        // TODO: Send password reset email to user

        return response()->json([
            'success' => true,
            'message' => 'Password reset successfully',
            'temp_password' => $tempPassword // Remove in production
        ]);
    }

    // Phone Number Verification Methods
    public function sendPhoneVerificationCode(Request $request)
    {
        $request->validate([
            'phone' => 'required|string|regex:/^\+?[1-9]\d{1,14}$/',
        ]);

        $user = Auth::user();

        // Generate 6-digit code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session temporarily
        session(['phone_verification_code' => [
            'code' => Hash::make($code),
            'phone' => $request->phone,
            'expires' => now()->addMinutes(10)
        ]]);

        // TODO: Send SMS code (integrate with SMS service like Twilio)
        // For now, return code in response for testing
        return response()->json([
            'success' => true,
            'message' => 'Verification code sent to your phone',
            'debug_code' => $code // Remove in production
        ]);
    }

    public function verifyPhoneNumber(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
            'phone' => 'required|string',
        ]);

        $sessionData = session('phone_verification_code');

        if (!$sessionData || now()->greaterThan($sessionData['expires'])) {
            return response()->json(['success' => false, 'message' => 'Code expired'], 400);
        }

        if ($request->phone !== $sessionData['phone']) {
            return response()->json(['success' => false, 'message' => 'Phone number mismatch'], 400);
        }

        if (!Hash::check($request->code, $sessionData['code'])) {
            return response()->json(['success' => false, 'message' => 'Invalid code'], 400);
        }

        // Update user's phone number
        $user = Auth::user();
        $user->phone = $request->phone;
        $user->phone_verified_at = now();
        $user->save();

        // Clear session
        session()->forget('phone_verification_code');

        return response()->json(['success' => true, 'message' => 'Phone number verified successfully']);
    }

    public function removePhoneNumber(Request $request)
    {
        $user = Auth::user();
        $user->phone = null;
        $user->phone_verified_at = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Phone number removed']);
    }

    // Email Verification Methods
    public function sendEmailVerificationCode(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users,email,' . Auth::id(),
        ]);

        $user = Auth::user();

        // Generate 6-digit code
        $code = str_pad(rand(0, 999999), 6, '0', STR_PAD_LEFT);

        // Store in session temporarily
        session(['email_change_code' => [
            'code' => Hash::make($code),
            'email' => $request->email,
            'expires' => now()->addMinutes(10)
        ]]);

        // Send email with code
        try {
            Mail::to($request->email)->send(new TwoFactorCode($code));
            return response()->json(['success' => true, 'message' => 'Verification code sent to your email']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send email'], 500);
        }
    }

    public function verifyEmailChange(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:6',
            'email' => 'required|email',
        ]);

        $sessionData = session('email_change_code');

        if (!$sessionData || now()->greaterThan($sessionData['expires'])) {
            return response()->json(['success' => false, 'message' => 'Code expired'], 400);
        }

        if ($request->email !== $sessionData['email']) {
            return response()->json(['success' => false, 'message' => 'Email mismatch'], 400);
        }

        if (!Hash::check($request->code, $sessionData['code'])) {
            return response()->json(['success' => false, 'message' => 'Invalid code'], 400);
        }

        // Update user's email
        $user = Auth::user();
        $user->email = $request->email;
        $user->email_verified_at = now();
        $user->save();

        // Clear session
        session()->forget('email_change_code');

        return response()->json(['success' => true, 'message' => 'Email updated successfully']);
    }

    public function removeEmailVerification(Request $request)
    {
        $user = Auth::user();

        // Cannot remove the only email if it's the last verification method
        if (!$user->phone_verified_at) {
            return response()->json(['success' => false, 'message' => 'Cannot remove email verification without alternative verification method'], 400);
        }

        $user->email_verified_at = null;
        $user->save();

        return response()->json(['success' => true, 'message' => 'Email verification removed']);
    }

    // Account Activity Methods
    public function getAccountActivity(Request $request)
    {
        // Get recent login activity (you might want to create a separate table for this)
        // For now, return mock data
        $activities = [
            [
                'id' => 1,
                'action' => 'Login',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Chrome on Windows',
                'location' => 'Nairobi, Kenya',
                'created_at' => now()->subHours(2)->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'action' => 'Password Changed',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Chrome on Windows',
                'location' => 'Nairobi, Kenya',
                'created_at' => now()->subDays(15)->format('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'action' => '2FA Enabled',
                'ip_address' => '192.168.1.100',
                'user_agent' => 'Chrome on Windows',
                'location' => 'Nairobi, Kenya',
                'created_at' => now()->subDays(10)->format('Y-m-d H:i:s'),
            ],
        ];

        return response()->json(['activities' => $activities]);
    }

    // Device Management Methods
    public function getDevices(Request $request)
    {
        // Get user's active sessions/devices
        // This is a simplified version - in production you'd track sessions in database
        $devices = [
            [
                'id' => 1,
                'device_name' => 'Chrome on Windows',
                'ip_address' => '192.168.1.100',
                'location' => 'Nairobi, Kenya',
                'last_active' => now()->subMinutes(5)->format('Y-m-d H:i:s'),
                'current_device' => true,
            ],
            [
                'id' => 2,
                'device_name' => 'Safari on iPhone',
                'ip_address' => '192.168.1.101',
                'location' => 'Nairobi, Kenya',
                'last_active' => now()->subHours(2)->format('Y-m-d H:i:s'),
                'current_device' => false,
            ],
        ];

        return response()->json(['devices' => $devices]);
    }

    public function revokeDevice(Request $request, $deviceId)
    {
        // In production, you'd invalidate the specific session
        // For now, just return success
        return response()->json(['success' => true, 'message' => 'Device access revoked']);
    }

    // Account Deletion
    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required',
            'confirmation' => 'required|string|in:DELETE',
        ]);

        $user = Auth::user();

        // Verify password
        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'message' => 'Incorrect password'], 400);
        }

        // Soft delete or schedule for deletion
        // In production, you might want to anonymize data instead of hard delete
        $user->delete();

        Auth::logout();

        return response()->json(['success' => true, 'message' => 'Account deleted successfully']);
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
}
