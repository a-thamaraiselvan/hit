<?php
// Set header to return JSON
header('Content-Type: application/json');

// Database connection
$conn = new mysqli("localhost", "root", "", "net");

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Connection failed: ' . $conn->connect_error]);
    exit;
}

// Get form data
$name = $_POST['name'];
$email = $_POST['email'];
$phone = $_POST['phone'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$date = date('Y-m-d H:i:s');

// Prepare and execute SQL statement
$sql = "INSERT INTO enquiries (name, email, phone, subject, message, created_at) 
        VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $date);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Enquiry submitted successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Error submitting enquiry: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>