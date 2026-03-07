<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check login status
checkLogin();

// Get pending count
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM enquiries e LEFT JOIN enquiry_replies er ON e.id = er.enquiry_id WHERE er.id IS NULL");
$stmt->execute();
$pending = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Get replied count
$stmt = $conn->prepare("SELECT COUNT(*) as count FROM enquiries e LEFT JOIN enquiry_replies er ON e.id = er.enquiry_id WHERE er.id IS NOT NULL");
$stmt->execute();
$replied = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

// Return JSON response
header('Content-Type: application/json');
echo json_encode([
    'pending' => (int)$pending,
    'replied' => (int)$replied
]);