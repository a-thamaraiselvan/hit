<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

header('Content-Type: application/json');
$response = ['success' => false, 'message' => ''];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $title = sanitize($_POST['title']);
    $event_name = sanitize($_POST['event_name']);
    $event_date = sanitize($_POST['event_date']);
    $venue = sanitize($_POST['venue']);
    $chief_guest = sanitize($_POST['chief_guest']);
    $description = sanitize($_POST['description']);
    
    try {
        // Handle file upload if new poster is provided
        $poster_update = "";
        if(isset($_FILES["event_poster"]) && $_FILES["event_poster"]["error"] == 0) {
            // Get current poster to delete if exists
            $stmt = $conn->prepare("SELECT poster FROM news_events WHERE id = ?");
            $stmt->execute([$id]);
            $current = $stmt->fetch();
            
            if($current && $current['poster']) {
                $old_file = "../../" . $current['poster'];
                if(file_exists($old_file)) {
                    unlink($old_file);
                }
            }
            
            // Upload new poster
            $target_dir = "../../uploads/events/";
            if (!file_exists($target_dir)) {
                mkdir($target_dir, 0777, true);
            }
            
            $file_extension = pathinfo($_FILES["event_poster"]["name"], PATHINFO_EXTENSION);
            $file_name = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $file_name;
            
            if(move_uploaded_file($_FILES["event_poster"]["tmp_name"], $target_file)) {
                $poster_update = ", poster = ?";
                $poster_value = "uploads/events/" . $file_name;
            }
        }
        
        // Update the database
        $sql = "UPDATE news_events SET 
                title = ?, 
                event_name = ?, 
                event_date = ?, 
                venue = ?, 
                chief_guest = ?, 
                description = ?" . $poster_update . " 
                WHERE id = ?";
                
        $params = [$title, $event_name, $event_date, $venue, $chief_guest, $description];
        if($poster_update) {
            $params[] = $poster_value;
        }
        $params[] = $id;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        
        $response['success'] = true;
        $response['message'] = 'News/Event updated successfully!';
        
    } catch(PDOException $e) {
        $response['message'] = "Error: " . $e->getMessage();
    }
} else {
    $response['message'] = "Invalid request method";
}

echo json_encode($response);
?>