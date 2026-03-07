<?php
// Mail Server Configuration
ini_set('SMTP', 'smtp.gmail.com');
ini_set('smtp_port', '587');

// Email Configuration
define('MAIL_FROM', 'hindusthaneducation@gmail.com'); // Replace with your email
define('MAIL_FROM_NAME', 'Hindusthan College'); // Replace with your name
define('MAIL_USERNAME', 'hindusthaneducation@gmail.com'); // Replace with your email
define('MAIL_PASSWORD', 'zgaq vprv ugac lmsy'); // Replace with your app password

// Configure PHPMailer settings
function configureMailer() {
    require_once __DIR__ . '/../../vendor/autoload.php';
    
    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = MAIL_USERNAME;
        $mail->Password = MAIL_PASSWORD;
        $mail->SMTPSecure = \PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        
        // Default sender
        $mail->setFrom(MAIL_FROM, MAIL_FROM_NAME);
        
        return $mail;
    } catch (Exception $e) {
        error_log('Mailer Error: ' . $e->getMessage());
        return false;
    }
}
?>