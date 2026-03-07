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
        $stmt = $conn->prepare("DELETE FROM enquiry_replies WHERE enquiry_id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Delete the enquiry
        $stmt = $conn->prepare("DELETE FROM enquiries WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Commit transaction
        $conn->commit();

        // Redirect with success message
        header('Location: ../dashboard/view_enquiry.php?success=1&message=Enquiry+deleted+successfully');
        exit;

    } catch (PDOException $e) {
        // Rollback transaction on error
        $conn->rollBack();

        // Redirect with error message
        header('Location: ../dashboard/view_enquiry.php?error=1&message=' . urlencode('Deletion failed: ' . $e->getMessage()));
        exit;
    }

} else {
    // Redirect if direct access without ID
    header('Location: ../dashboard/view_enquiry.php');
    exit;
}
?>