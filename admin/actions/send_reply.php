<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
require_once '../includes/mail_config.php';

// Check login status
checkLogin();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $enquiry_id = $_POST['enquiry_id'];
    $recipient_email = $_POST['recipient_email'];
    $recipient_name = $_POST['recipient_name'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];
    
    // Get PHPMailer instance
    $mail = configureMailer();
    
    if ($mail) {
        try {
            // Recipients
$mail->addAddress($recipient_email, $recipient_name);

// Content
$mail->isHTML(true);
$mail->Subject = $subject;

// Email body
$email_body = '
<html>
<head>
    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f4f7fc;
            font-family: Arial, sans-serif;
        }

        .wrapper {
            width: 100%;
            padding: 40px 0;
            background: #f4f7fc;
        }

        .container {
            max-width: 650px;
            margin: auto;
            background: #ffffff;
            border-radius: 10px;
            padding: 30px 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        }

        .header {
            text-align: center;
            padding-bottom: 15px;
            border-bottom: 2px solid #e6e6e6;
        }

        .header h1 {
            color: #003778;
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .sub-title {
            color: #666;
            font-size: 14px;
            margin-top: 5px;
        }

        .content {
            font-size: 15px;
            color: #333;
            line-height: 1.7;
            padding-top: 20px;
        }

        .hei-info-box {
            margin-top: 20px;
            background: #f0f6ff;
            padding: 15px 18px;
            border-left: 4px solid #0072ff;
            border-radius: 6px;
        }

        .hei-info-box p {
            margin: 5px 0;
            color: #1a1a1a;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 13px;
            color: #555;
            padding-top: 15px;
            border-top: 1px solid #ddd;
        }

        .footer p {
            margin: 3px 0;
        }

        a {
            color: #004aad;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        <div class="container">

            <!-- HEADER -->
            <div class="header">
                <h1>Hindusthan Educational Institutions</h1>
                <p class="sub-title">Coimbatore • Tamil Nadu • India</p>
            </div>

            <!-- MAIN CONTENT -->
            <div class="content">
                <p>Dear ' . htmlspecialchars($recipient_name) . ',</p>

                <p>' . nl2br(htmlspecialchars($message)) . '</p>

                <p>Warm regards,<br>
                <strong>Hindusthan Educational Institutions</strong></p>
            </div>

            <!-- INSTITUTION INFO BLOCK -->
            <div class="hei-info-box">
                <p><strong>About Hindusthan Educational Institutions:</strong></p>
                <p>Hindusthan Educational Institutions is one of South India\'s leading groups of educational institutions offering excellence in Engineering, Technology, Arts, Science, Management, and Research.</p>

                <p><strong>Why Hindusthan?</strong></p>
                <p>✔ State-of-the-art laboratories & research facilities<br>
                   ✔ Highly experienced faculty members<br>
                   ✔ Strong industry collaborations & placement support<br>
                   ✔ Innovation, entrepreneurship & startup ecosystem<br>
                   ✔ A vibrant campus with world-class infrastructure</p>

                <p><strong>Our Mission:</strong> To provide quality education and empower students with the skills, values, and knowledge needed for global excellence.</p>

                <p><strong>Our Vision:</strong> To be a world-class institution fostering innovation, leadership, and societal development.</p>
            </div>

            <!-- FOOTER -->
            <div class="footer">
                <p>© ' . date("Y") . ' Hindusthan Educational Institutions.</p>
                <p>All rights reserved.</p>
                <p>Visit us: <a href="https://hindusthan.net">hindusthan.net</a></p>
            </div>

        </div>
    </div>
</body>
</html>
';

$mail->Body = $email_body;

            
            // Send email
            $mail->send();
            
            // Log the reply in database
            $stmt = $conn->prepare("INSERT INTO enquiry_replies (enquiry_id, reply_subject, reply_message, sent_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$enquiry_id, $subject, $message]);
            
            // After successful email sending and before redirect
            $stmt = $conn->prepare("UPDATE enquiries SET replied = 1, replied_at = NOW() WHERE id = ?");
            $stmt->execute([$enquiry_id]);
            
            // Redirect with success message
            header('Location: ../dashboard/view_enquiry.php?success=1&message=Reply+sent+successfully');
            exit;
            
        } catch (Exception $e) {
            // Redirect with error message
            header('Location: ../dashboard/view_enquiry.php?error=1&message=Failed+to+send+reply:+' . $e->getMessage());
            exit;
        }
    } else {
        // Redirect with error message
        header('Location: ../dashboard/view_enquiry.php?error=1&message=Mail+configuration+error');
        exit;
    }
}
?>