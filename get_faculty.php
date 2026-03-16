<?php
header('Content-Type: application/json');
require_once 'admin/includes/db.php';

$dept = isset($_GET['dept']) ? $_GET['dept'] : '';

if (empty($dept)) {
    echo json_encode(['success' => false, 'message' => 'Department parameter is required.']);
    exit();
}

try {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE department = :dept ORDER BY priority ASC, name ASC");
    $stmt->bindParam(':dept', $dept);
    $stmt->execute();
    $faculty = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $faculty]);
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
