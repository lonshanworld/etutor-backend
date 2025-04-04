<!DOCTYPE html>
<html>
<head>
    <title>Tutor Allocation Success</title>
</head>
<body>
    <h2>Tutor Allocation Notification</h2>
    
    <p>Dear {{ $student->first_name . ' ' . $student->last_name }},</p>
    
    <p>You have been successfully allocated to a tutor:</p>
    
    <div style="margin: 20px 0; padding: 15px; border: 1px solid #ddd;">
        <p><strong>Tutor Information:</strong></p>
        <p>Name: {{ $tutor->first_name . ' ' . $tutor->last_name }}</p>
        <p>Email: {{ $tutor->email }}</p>
    </div>
    
    <p>Please check your tutoring session.</p>
    
    <p>Best regards,<br>ETuto Team</p>
</body>
</html>