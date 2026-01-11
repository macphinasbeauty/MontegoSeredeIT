<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Two-Factor Authentication Code</title>
</head>
<body style="font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 5px; margin-bottom: 20px;">
        <h2 style="color: #007bff; margin: 0 0 10px 0;">Two-Factor Authentication Code</h2>
        <p style="margin: 0;">You requested to enable two-factor authentication for your account.</p>
    </div>

    <div style="text-align: center; margin: 30px 0;">
        <div style="background: #007bff; color: white; padding: 20px; border-radius: 5px; font-size: 24px; font-weight: bold; letter-spacing: 5px; display: inline-block;">
            {{ $code }}
        </div>
    </div>

    <div style="background: #fff3cd; border: 1px solid #ffeaa7; padding: 15px; border-radius: 5px; margin: 20px 0;">
        <p style="margin: 0; color: #856404;">
            <strong>Important:</strong> This code will expire in 10 minutes. Do not share this code with anyone.
        </p>
    </div>

    <p>If you didn't request this code, please ignore this email. Your account security is important to us.</p>

    <hr style="border: none; border-top: 1px solid #eee; margin: 30px 0;">

    <p style="color: #666; font-size: 12px;">
        This email was sent by Milestour. If you have any questions, please contact our support team.
    </p>
</body>
</html>