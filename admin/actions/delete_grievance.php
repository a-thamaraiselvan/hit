<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check login status
checkLogin();

if (isset($_GET['id'])) {

    $id = sanitize($_GET['id']);

    try {
        // Begin transaction
        $conn->beginTransaction();

        // Delete associated replies first
        $stmt = $conn->prepare("DELETE FROM grievance_replies WHERE grievance_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Delete the grievance
        $stmt = $conn->prepare("DELETE FROM student_grievances WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Redirect with success message
        header('Location: ../dashboard/view_grievance.php?success=1&message=Grievance+deleted+successfully');
        exit;

    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();

        // Redirect with error message
        header('Location: ../dashboard/view_grievance.php?error=1&message=' . urlencode('Deletion failed: ' . $e->getMessage()));
        exit;
    }

} else {
    // Redirect if direct access without ID
    header('Location: ../dashboard/view_grievance.php');
    exit;
}
?>
