<!DOCTYPE html>
<html>
<head>
    <title>Password Reset OTP</title>
</head>
<body style="font-family: Arial, sans-serif; color: #333; line-height: 1.6; max-width: 600px; margin: 0 auto; padding: 20px;">
    <div style="background: #f8f9fa; padding: 20px; border-radius: 8px; text-align: center;">
        <h2 style="color: #4F46E5;">Password Reset</h2>
        <p>You have requested to reset your password. Use the following OTP to proceed:</p>
        
        <div style="background: #fff; padding: 15px; border-radius: 6px; font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #1e293b; margin: 20px 0; border: 1px solid #e2e8f0;">
            {{ $otp }}
        </div>
        
        <p style="font-size: 14px; color: #64748b;">This OTP is valid for 10 minutes. If you did not request a password reset, please ignore this email.</p>
        
        <div style="margin-top: 30px; border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #94a3b8;">
            &copy; {{ date('Y') }} Nyayaprabha. All rights reserved.
        </div>
    </div>
</body>
</html>
