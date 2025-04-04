<!DOCTYPE html>
<html>
<head>
    <title>Tutor Unassignment Notification</title>
</head>
<body>
    <h2>Tutor Unassignment Notification</h2>
    
    <p>Dear {{ $student->first_name . ' ' . $student->last_name }},</p>
    
    <p>You have been unassigned from your tutor:</p>
    
    <div style="margin: 20px 0; padding: 15px; border: 1px solid #ddd;">
        <p><strong>Previous Tutor:</strong></p>
        <p>Name: {{ $tutor->first_name . ' ' . $tutor->last_name }} &nbsp;({{ $tutor->email }})</p>
    </div>
    
    <p>Please check your tutoring session status.</p>
    
    <p>Best regards,<br>ETuto Team</p>
</body>
</html>