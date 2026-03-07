<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $is_special = isset($_POST['is_special']) ? (int)$_POST['is_special'] : 0;
    
    try {
        if ($is_special) {
            // First, remove special status from all other events
            $stmt = $conn->prepare("UPDATE news_events SET is_special = 0 WHERE id != ?");
            $stmt->execute([$id]);
        }
        
        // Update the selected event's special status
        $stmt = $conn->prepare("UPDATE news_events SET is_special = ? WHERE id = ?");
        $stmt->execute([$is_special, $id]);
        
        echo json_encode([
            'success' => true,
            'message' => $is_special ? 'Event marked as special' : 'Special status removed'
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error updating special status: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Invalid request method'
    ]);
}