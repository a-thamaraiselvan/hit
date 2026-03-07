<?php
require_once 'admin/includes/db.php';

$container = $_GET['container'] ?? 'latest';
// sanitize container
$container = $container === 'past' ? 'past' : 'latest';

$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page);
$items_per_page = 3;
$offset = ($page - 1) * $items_per_page;

if ($container === 'latest') {
    // Upcoming news - upcoming day order wise
    $where_clause = "event_date >= CURDATE()";
    $order_by = "event_date ASC";
} else {
    // Past news - most recent past first
    $where_clause = "event_date < CURDATE()";
    $order_by = "event_date DESC";
}

$total_stmt = $conn->query("SELECT COUNT(*) FROM news_events WHERE $where_clause");
$total_items = (int)$total_stmt->fetchColumn();
$total_pages = (int)ceil($total_items / $items_per_page);

// Safety
$items_per_page = max(0, (int)$items_per_page);
$offset = max(0, (int)$offset);

$stmt = $conn->prepare("
    SELECT * FROM news_events 
    WHERE $where_clause 
    ORDER BY $order_by
    LIMIT :limit OFFSET :offset
");
$stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $event_ts = strtotime($row['event_date']);
    ?>
    <div class="news-item">
        <img src="<?php echo $row['poster'] ? htmlspecialchars($row['poster']) : 'assets/images/default-event.jpg'; ?>" 
             class="news-image" alt="<?php echo htmlspecialchars($row['event_name']); ?>">
        <div class="news-content">
            <span class="news-tag">
                <?php echo $container === 'latest' ? 'Featured News' : 'Past Event'; ?>
            </span>
            <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="news-title">
                <?php echo htmlspecialchars($row['event_name']); ?>
            </a>
            <div class="news-date">
                <i class="far fa-calendar-alt"></i>
                <?php
                if ($container === 'latest') {
                    // e.g. 05 Dec
                    echo date('d', $event_ts) . ' ' . date('M', $event_ts);
                } else {
                    // e.g. December 05, 2025
                    echo date('F d, Y', $event_ts);
                }
                ?>
            </div>
            <p class="news-description">
                <?php echo nl2br(htmlspecialchars(substr($row['description'], 0, 150))); ?>...
            </p>
            <div class="d-flex justify-content-between align-items-center">
                <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">
                    View More <i class="fas fa-arrow-right ms-1"></i>
                </a>
                <i class="fas fa-share-alt share-icon"></i>
            </div>
        </div>
    </div>
    <?php
}

// Pagination
if ($total_pages > 1): ?>
<nav aria-label="Page navigation" class="mt-4">
    <ul class="pagination justify-content-center">
        <?php if ($page > 1): ?>
        <li class="page-item">
            <a class="page-link"
               href="#"
               data-page="<?php echo $page - 1; ?>"
               data-container="<?php echo $container; ?>"
               aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
            </a>
        </li>
        <?php endif; ?>

        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
            <a class="page-link"
               href="#"
               data-page="<?php echo $i; ?>"
               data-container="<?php echo $container; ?>">
                <?php echo $i; ?>
            </a>
        </li>
        <?php endfor; ?>

        <?php if ($page < $total_pages): ?>
        <li class="page-item">
            <a class="page-link"
               href="#"
               data-page="<?php echo $page + 1; ?>"
               data-container="<?php echo $container; ?>"
               aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
            </a>
        </li>
        <?php endif; ?>
    </ul>
</nav>
<?php endif; ?>
