<?php
require_once 'admin/includes/db.php';

$stmt = $conn->query("SELECT content, link_url, file_path FROM ticker_news WHERE status = 1 ORDER BY created_at DESC");
$news = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($news);