<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ $subject }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            color: #333;
            margin: 0;
        }
        .content {
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>{{ $subject }}</h1>
    </div>

    <div class="content">
        <p>Dear Recipient,</p>

        <p>We are pleased to present our proposal for <a href="http://www.collegevihar.com"><span style="color: #0C73B8">College</span><span style="color: #EE4130">Vihar</span></a>. Please find attached the detailed proposal document.</p>

        @if($cover_letter)
            <p>{{ $cover_letter }}</p>
        @endif

        <p>If you have any questions or would like to discuss further, please feel free to contact us.</p>
        <span>+91 6395585858, info@collegevihar.com</span>

        <p>Thank you for considering our proposal.</p>

        <p>Best regards,</p>
        <p>College Vihar Team</p>
    </div>
</body>
</html>
