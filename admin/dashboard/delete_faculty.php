<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $dept = isset($_GET['dept']) ? $_GET['dept'] : '';

    try {
        // Get image path before deleting
        $stmt = $conn->prepare("SELECT image_path FROM faculty WHERE id = ?");
        $stmt->execute([$id]);
        $faculty = $stmt->fetch();
        
        if ($faculty) {
            // Delete image file if it exists
            if ($faculty['image_path'] && file_exists("../../" . $faculty['image_path'])) {
                if (strpos($faculty['image_path'], 'uploads/department/') === 0) {
                    unlink("../../" . $faculty['image_path']);
                }
            }
            
            // Delete from database
            $stmt = $conn->prepare("DELETE FROM faculty WHERE id = ?");
            $stmt->execute([$id]);
            
            header("Location: manage_faculty.php?dept=" . $dept . "&msg=Faculty deleted successfully");
            exit();
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}

header("Location: manage_faculty.php");
exit();
?>
