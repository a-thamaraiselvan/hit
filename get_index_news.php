<?php
header('Content-Type: application/json');
require_once 'admin/includes/db.php';

try {
    $response = [
        'featured' => null,
        'recent' => [],
        'upcoming' => []
    ];

    // 1. Fetch Featured News (soonest upcoming marked as is_special)
    $stmt = $conn->query("SELECT * FROM news_events WHERE is_special = 1 AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1");
    $featured = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Fallback if no special upcoming event exists
    if (!$featured) {
        $stmt = $conn->query("SELECT * FROM news_events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 1");
        $featured = $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    if ($featured) {
        $response['featured'] = $featured;
    }

    // 2. Fetch Next News (chronological order)
    $featuredId = $featured ? $featured['id'] : 0;
    $stmt = $conn->prepare("SELECT * FROM news_events WHERE id != :id AND event_date >= CURDATE() ORDER BY event_date ASC LIMIT 2");
    $stmt->bindValue(':id', $featuredId, PDO::PARAM_INT);
    $stmt->execute();
    $response['recent'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 3. Fetch Upcoming Events (same logic, soonest first)
    $stmt = $conn->query("SELECT * FROM news_events WHERE event_date >= CURDATE() ORDER BY event_date ASC LIMIT 3");
    $response['upcoming'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['success' => true, 'data' => $response]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?>
