<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to DreamsTour - Your Agent Account</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <h1 style="color: #007bff; text-align: center;">Welcome to Miles Montego!</h1>

        <p>Dear {{ $user->name }},</p>

        <p>Congratulations! Your application to become a Miles Montego expert has been approved. We're excited to have you join our team of travel professionals.</p>

        <p>Your agent account has been created and you can now access the agent dashboard to manage your services and bookings.</p>

        @if($password)
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #007bff;">Your Login Credentials</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Password:</strong> {{ $password }}</p>
            <p style="color: #dc3545; font-weight: bold;">⚠️ Please save these credentials securely and change your password after first login.</p>
        </div>
        @else
        <div style="background-color: #f8f9fa; padding: 20px; border-radius: 5px; margin: 20px 0;">
            <h3 style="margin-top: 0; color: #007bff;">Your Account Details</h3>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p style="color: #28a745; font-weight: bold;">✅ Use your existing password to log in to your agent account.</p>
        </div>
        @endif

        <p><strong>How to get started:</strong></p>
        <ol>
            <li>Visit our website and click "Sign In"</li>
            <li>Use the credentials above to log in</li>
            <li>Complete your profile and add your services</li>
            <li>Start managing bookings and earning</li>
        </ol>

        <p>As an agent, you'll have access to:</p>
        <ul>
            <li>🏨 Add and manage hotel listings</li>
            <li>🚗 Add and manage car rental services</li>
            <li>✈️ Add and manage tour packages</li>
            <li>📊 Track your bookings and earnings</li>
            <li>💬 Customer support and assistance</li>
        </ul>

        <p>If you have any questions or need assistance, please don't hesitate to contact our support team.</p>

        <p>Welcome aboard!</p>

        <p>Best regards,<br>
        <strong>The Miles Montego Team</strong></p>

        <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

        <p style="font-size: 12px; color: #666; text-align: center;">
            This email was sent to {{ $user->email }} because you applied to become a Miles Montego agent.<br>
            If you did not apply for this account, please ignore this email.
        </p>
    </div>
</body>
</html>
