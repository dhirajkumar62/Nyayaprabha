<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Complaint Status Update</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f9fafb; margin: 0; padding: 0; }
        .email-container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; margin-top: 40px; box-shadow: 0 4px 6px rgba(0,0,0,0.05); border: 1px solid #e5e7eb; }
        .email-header { background: linear-gradient(135deg, #EC4899 0%, #8B5CF6 100%); padding: 30px; text-align: center; color: #ffffff; }
        .email-header h1 { margin: 0; font-size: 24px; font-weight: 700; }
        .email-body { padding: 40px 30px; color: #374151; line-height: 1.6; }
        .status-box { background: #f8fafc; border-left: 4px solid #8B5CF6; padding: 20px; border-radius: 0 8px 8px 0; margin: 24px 0; }
        .status-badge { display: inline-block; padding: 6px 12px; border-radius: 50px; font-size: 12px; font-weight: 600; text-transform: uppercase; background: #eff6ff; color: #2563eb; margin-bottom: 12px; }
        .btn { display: inline-block; padding: 12px 24px; background: #8B5CF6; color: #ffffff; text-decoration: none; border-radius: 50px; font-weight: 600; margin-top: 20px; }
        .email-footer { background: #f3f4f6; padding: 20px; text-align: center; color: #6b7280; font-size: 13px; }
        .safety-tip { margin-top: 30px; padding-top: 20px; border-top: 1px dashed #d1d5db; font-size: 14px; color: #4b5563; }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h1>Update on Your Complaint</h1>
        </div>
        <div class="email-body">
            <p>Dear <strong>{{ $complaint['name'] }}</strong>,</p>
            <p>We are writing to inform you that there has been an update regarding your registered complaint (<strong>#{{ $complaint['complaintNumber'] }}</strong>).</p>
            
            <div class="status-box">
                <span class="status-badge">Status: {{ $status }}</span>
                <p style="margin: 0; font-size: 15px;"><strong>Admin Remark:</strong><br/>
                {{ $remark ?? 'Your complaint status has been updated by the administration.' }}</p>
            </div>
            
            <p>Our team is closely monitoring your request to ensure your safety and quick resolution. You can view the complete tracking history and timeline directly on your secure dashboard.</p>
            
            <center>
                <a href="{{ url('/users/complaint-details/'.$complaint['complaintNumber']) }}" class="btn">View Timeline in Dashboard</a>
            </center>
            
            <div class="safety-tip">
                <strong>Safety Reminder:</strong> If you feel you are in immediate danger, please do not wait for a status update. Immediately use the Emergency SOS button in your dashboard or contact local authorities. Your safety is our highest priority.
            </div>
        </div>
        <div class="email-footer">
            &copy; {{ date('Y') }} Nyayaprabha Women Safety Platform. All rights reserved.<br>
            This is an automated notification. Please do not reply to this email.
        </div>
    </div>
</body>
</html>
