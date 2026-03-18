<?php
// Start clean output buffer (IMPORTANT)
ob_start();

// Allow only POST request
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    header("Location: contact-us.html");
    exit();
}

// Database connection
$conn = new mysqli("localhost", "root", "", "hit");

if ($conn->connect_error) {
    header("Location: contact-us.html?status=error");
    exit();
}

// Sanitize + validate
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message)) {
    header("Location: contact-us.html?status=error");
    exit();
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: contact-us.html?status=error");
    exit();
}

$date = date('Y-m-d H:i:s');

// Insert query
$sql = "INSERT INTO enquiries (name, email, phone, subject, message, created_at) 
        VALUES (?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $date);

// Execute
if ($stmt->execute()) {
    header("Location: contact-us.html?status=success");
} else {
    header("Location: contact-us.html?status=error");
}

$stmt->close();
$conn->close();

// Flush buffer
ob_end_flush();
exit();
?>