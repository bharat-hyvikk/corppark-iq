<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Contact Message Notification</title>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Figtree", sans-serif;
            margin: 0;
            padding: 40px 20px;
            background-color: #f4f4f4;
            color: #333;
            position: relative;
        }
        .email-container {
            max-width: 600px;
            margin: auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }
        .email-header {
            background-color: #fff;
            text-align: center;
            padding: 30px 20px 20px;
            border-bottom: 2px solid #1E90FF    ;
        }
        .email-header img {
            max-width: 120px;
            margin-bottom: 15px;
        }
        .email-header h1 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
            color: #1E90FF;
        }
        .email-body {
            padding: 30px;
        }
        .info-row {
            display: flex;
            gap: 10px;
            margin-bottom: 18px;
        }
        .message-box {
            background-color: #e3f1fc;
            border-left: 4px solid #1E90FF;
            padding: 20px;
            margin-top: 20px;
            border-radius: 6px;
        }
        .email-footer {
            text-align: center;
            background-color: #f7f7f7;
            font-size: 12px;
            color: #777;
            padding: 20px;
            border-top: 1px solid #eaeaea;
        }
        a {
            color: #222;
            text-decoration: none;
        }
        .flex{
            display: flex;
        }
        .item-center{
            align-items: center;
        }
        .gap-3{
            gap: 12px;
        }
        .logo-name {
            font-size: 1.125rem; /* 18px */
            font-weight: 700;
        }
        
        @media (min-width: 768px) {
            .logo-name {
                font-size: 1.25rem; /* 20px */
            }
        }
        .logo-div{
            justify-content: center;
        }
        
    </style>
</head>
<body>
    <div class="email-container" role="main" aria-label="New contact message">
        <div class="email-header">
            <div class="flex items-center gap-3 logo-div">
            <img src="https://corpparkiq.hyvikk.solutions/assets/logoicon.svg" alt="Logo" class="w-10 h-10">
            <p class="logo-name">Corppakr IQ</p>
        </div>
            <h1>Get into Contact</h1>
        </div>
        <div class="email-body">
            <h2 style="margin-top: 0; font-size: 20px; font-weight: 700; color: #222; margin-bottom: 30px;">
                You've received a new contact message
            </h2>
            <div style="display: flex;flex-direction:column; flex-wrap: wrap; gap: 20px; margin-bottom: 20px;">
                <div>
                    <p style="margin: 0; font-weight: 600; color: #000;">Full Name</p>
                    <p style="margin: 5px 0 0; font-size: 16px; font-weight: 500; color: #222;">{{ $name }}</p>
                </div>
                <div>
                    <p style="margin: 0; font-weight: 600; color: #000;">Email Address</p>
                    <a href="" style="color: #222; text-decoration: none;">{{ $email }}</a>
                </div>
                <div>
                    <p style="margin: 0; font-weight: 600; color: #000;">Phone Number</p>
                    <a href=""  style="color: #222; text-decoration: none;">{{ $phone }}</a>
                </div>
            </div>
            <div class="message-box">
                <p style="margin: 0 0 10px; font-weight: 600; color: #444;">Message</p>
                <p style="margin: 0; color: #555; line-height: 1.6;">{{ $usermessage }}</p>
            </div>
        </div>
        <div class="email-footer">
            <p>This message was submitted through your website contact form.</p>
            <p>&copy; 2025 Corppark IQ. All rights reserved.</p>
        </div>
    </div>
</body>
</html>