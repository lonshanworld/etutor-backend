<!DOCTYPE html>
<html>
<head>
    <title>Student Unassignment Notification</title>
</head>
<body>
    <h2>Student Unassignment Notification</h2>
    
    <p>Dear {{ $tutor->first_name . ' ' . $tutor->last_name }},</p>
    
    <p>The following students have been unassigned from you:</p>
    
    <div style="margin: 20px 0; padding: 15px; border: 1px solid #ddd;">
        <p><strong>Student Information:</strong></p>
        @foreach($students as $student)
            <p>Name: {{ $student->first_name . ' ' . $student->last_name }} &nbsp;({{ $student->email }})</p>
        @endforeach
    </div>
    
    <p>Please check your tutoring sessions.</p>
    
    <p>Best regards,<br>ETuto Team</p>
</body>
</html>