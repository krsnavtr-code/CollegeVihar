<!DOCTYPE html>
<html>
<head>
    <title>New Query Submission</title>
</head>
<body>
    <div style="max-width: 600px; margin: 0 auto; padding: 20px; font-family: Arial, sans-serif;">
        <div style="background-color: #001f60; color: white; padding: 20px; text-align: center; border-radius: 5px;">
            <h2 style="margin: 0;">{{ $details['title'] }}</h2>
        </div>
        
        <div style="background-color: #f8f9fa; padding: 20px; margin-top: 20px; border-radius: 5px;">
            <pre style="white-space: pre-wrap; font-family: Arial, sans-serif;">{{ $details['body'] }}</pre>
        </div>
        
        <div style="margin-top: 20px; text-align: center; color: #666;">
            <p>This is an automated email from College Vihar</p>
        </div>
    </div>
</body>
</html>
