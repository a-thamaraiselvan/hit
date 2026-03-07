<?php
require_once 'admin/includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>News & Events - Hindusthan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="stylesheet" href="assets/css/aos.css">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/boxicons.min.css">
        <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
        <link rel="stylesheet" href="assets/css/flaticon.css">
        <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="assets/css/header.css">
        <link rel="stylesheet" href="assets/css/responsive.css">

    <style>
        .news-section {
            padding: 60px 0;
            background: #f9f9f9;
        }
        
        .section-title {
            text-align: center;
            margin-bottom: 40px;
        }
        
        .section-title span {
            color: #ff6b00;
            font-size: 14px;
            display: block;
            margin-bottom: 10px;
        }
        
        .section-title h2 {
            font-size: 32px;
            margin-bottom: 10px;
            color: #1a1a1a;
        }
        
        .news-item {
            display: flex;
            margin-bottom: 30px;
            background: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .news-image {
            width: 300px;
            height: 220px;
            object-fit: cover;
        }
        
        .news-content {
            padding: 25px;
            flex: 1;
        }
        
        .news-tag {
            display: inline-block;
            padding: 5px 15px;
            background: #ff6b00;
            color: #fff;
            border-radius: 4px;
            font-size: 13px;
            margin-bottom: 15px;
        }
        
        .news-title {
            font-size: 22px;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 600;
            text-decoration: none;
        }
        
        .news-title:hover {
            color: #ff6b00;
        }
        
        .news-date {
            color: #666;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        .news-description {
            color: #666;
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 20px;
        }
        
        .share-icon {
            color: #666;
            font-size: 18px;
            float: right;
            cursor: pointer;
            transition: color 0.3s;
        }
        
        .share-icon:hover {
            color: #ff6b00;
        }
        
        .upcoming-events {
            background: #fff;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .event-item {
            display: flex;
            align-items: center;
            padding: 15px 0;
            border-bottom: 1px solid #eee;
        }
        
        .event-date {
            text-align: center;
            margin-right: 20px;
        }
        
        .event-date .month {
            color: #ff6b00;
            font-size: 14px;
            font-weight: 600;
        }
        
        .event-date .day {
            font-size: 24px;
            font-weight: 700;
            color: #1a1a1a;
        }
        
        .event-info h4 {
            font-size: 16px;
            margin-bottom: 5px;
            color: #1a1a1a;
        }
        
        .event-info p {
            font-size: 14px;
            color: #666;
            margin: 0;
        }
        
        .event-link {
            margin-left: auto;
            color: #666;
            font-size: 18px;
        }
        
        .event-link:hover {
            color: #ff6b00;
        }

        /* Toggle Styles */
        .toggle-container {
            text-align: center;
            margin-bottom: 40px;
        }

        .toggle-buttons {
            display: inline-flex;
            background: #fff;
            padding: 5px;
            border-radius: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        .toggle-btn {
            padding: 10px 25px;
            border: none;
            background: none;
            color: #666;
            font-weight: 500;
            cursor: pointer;
            border-radius: 25px;
            transition: all 0.3s ease;
        }

        .toggle-btn.active {
            background: #ff6b00;
            color: #fff;
        }

        .toggle-btn i {
            margin-right: 8px;
        }

        .news-container {
            transition: opacity 0.3s ease;
        }

        .news-container.hidden {
            display: none;
        }

        /* Add these responsive styles */
        @media (max-width: 991px) {
            .col-lg-8 {
                margin-bottom: 30px;
            }
        }
    
        @media (max-width: 768px) {
            .news-item {
                flex-direction: column;
            }
            
            .news-image {
                width: 100%;
                height: 200px;
            }
            
            .news-content {
                padding: 20px;
            }
            
            .section-title h2 {
                font-size: 28px;
            }
        }
    
        @media (max-width: 576px) {
            .news-section {
                padding: 40px 0;
            }
            
            .section-title {
                margin-bottom: 30px;
            }
            
            .news-title {
                font-size: 18px;
            }
            
            .news-description {
                font-size: 14px;
            }
            
            .event-item {
                flex-wrap: wrap;
            }
            
            .event-date {
                margin-bottom: 10px;
                width: 100%;
                display: flex;
                align-items: center;
                justify-content: flex-start;
                margin-right: 0;
            }
            
            .event-date .month {
                margin-right: 5px;
            }
            
            .event-info {
                width: calc(100% - 30px);
            }
            
            .event-link {
                width: 30px;
                text-align: right;
            }
            
            .upcoming-events {
                padding: 20px;
            }
        }

            /* Add these styles for mobile optimization */
    @media (max-width: 576px) {
        .news-section {
            padding: 40px 0;
        }
        
        .toggle-buttons {
            width: 100%;
            justify-content: center;
        }
        
        .toggle-btn {
            padding: 8px 15px;
            font-size: 14px;
        }
        
        .news-item {
            margin-bottom: 20px;
        }
        
        .news-image {
            height: 180px;
        }
        
        .news-content {
            padding: 15px;
        }
        
        .news-title {
            font-size: 16px;
            margin-bottom: 10px;
        }
        
        .news-description {
            font-size: 13px;
            margin-bottom: 15px;
        }
        
        .pagination {
            flex-wrap: wrap;
            gap: 5px;
        }
        
        .page-link {
            padding: 0.4rem 0.75rem;
            font-size: 14px;
        }
    }
    
    /* Add smooth scrolling */
    html {
        scroll-behavior: smooth;
    }
    
    .news-container {
        scroll-margin-top: 80px;
    }
    
    /* Add loading state */
    .news-container.loading {
        opacity: 0.6;
        pointer-events: none;
    }

    </style>
</head>
<body>
    <div class="news-section">
        <div class="container">
            <div class="section-title">
                <span>News and Events</span>
                <h2>Recent Important Stories</h2>
                <p>Updated</p>
            </div>

            <?php
            // Display special event if exists
            $stmt = $conn->query("SELECT * FROM news_events WHERE is_special = 1 LIMIT 1");
            $special_event = $stmt->fetch();
            if($special_event): ?>
            <div class="special-event mb-5">
                <div class="news-item" style="border: 2px solid #ff6b00;">
                    <img src="<?php echo $special_event['poster'] ? htmlspecialchars($special_event['poster']) : 'assets/images/default-event.jpg'; ?>" 
                         class="news-image" alt="<?php echo htmlspecialchars($special_event['title']); ?>">
                    <div class="news-content">
                        <span class="news-tag" style="background: #ff6b00;">Special Event</span>
                        <a href="news-detail.php?id=<?php echo $special_event['id']; ?>" class="news-title">
                            <?php echo htmlspecialchars($special_event['title']); ?>
                        </a>
                        <div class="news-date">
                            <i class="far fa-calendar-alt"></i> 
                            <?php echo date('F d, Y', strtotime($special_event['event_date'])); ?>
                        </div>
                        <p class="news-description">
                            <?php echo nl2br(htmlspecialchars(substr($special_event['description'], 0, 150))); ?>...
                        </p>
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="news-detail.php?id=<?php echo $special_event['id']; ?>" class="btn btn-outline-primary btn-sm">
                                View More <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                            <i class="fas fa-share-alt share-icon"></i>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <div class="toggle-container">
                <div class="toggle-buttons">
                    <button class="toggle-btn active" data-target="latest">
                        <i class="fas fa-newspaper"></i> Latest News
                    </button>
                    <button class="toggle-btn" data-target="past">
                        <i class="fas fa-history"></i> Past News
                    </button>
                </div>
            </div>
            
            <div class="row">
                <div class="col-lg-8">
                    <!-- Latest News Container -->
                    <div class="news-container" id="latest-news">
                        <?php
                        // Get current page number
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $items_per_page = 3;
                        $offset = ($page - 1) * $items_per_page;

                        // Get total number of items
                        $total_stmt = $conn->query("SELECT COUNT(*) FROM news_events WHERE event_date >= CURDATE()");
                        $total_items = $total_stmt->fetchColumn();
                        $total_pages = ceil($total_items / $items_per_page);

                        // Get items for current page (Latest News)
                        $stmt = $conn->prepare("SELECT * FROM news_events WHERE event_date >= CURDATE() 
                                             ORDER BY event_date ASC LIMIT ? OFFSET ?");
                        $stmt->bindValue(1, $items_per_page, PDO::PARAM_INT);
                        $stmt->bindValue(2, $offset, PDO::PARAM_INT);
                        $stmt->execute();

                        while($row = $stmt->fetch()) {
                        ?>
                        <div class="news-item">
                            <img src="<?php echo $row['poster'] ? htmlspecialchars($row['poster']) : 'assets/images/default-event.jpg'; ?>" 
                                 class="news-image" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <div class="news-content">
                                <span class="news-tag">Featured News</span>
                                <a href="news-detail.php?id=<?php echo $row['id']; ?>" class="news-title">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                                <div class="news-date">
                                    <i class="far fa-calendar-alt"></i> 
                                    <?php 
                                        $event_date = strtotime($row['event_date']);
                                        echo date('d', $event_date) . ' ' . date('M', $event_date); 
                                    ?>
                                </div>
                                <p class="news-description">
                                    <?php echo nl2br(htmlspecialchars(substr($row['description'], 0, 150))); ?>...
                                </p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="news-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-outline-primary btn-sm">
                                        View More <i class="fas fa-arrow-right ms-1"></i>
                                    </a>
                                    <i class="fas fa-share-alt share-icon"></i>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Pagination -->
                        <?php if($total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4" id="latest-pagination">
                            <ul class="pagination justify-content-center">
                                <?php if($page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="<?php echo ($page - 1); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                    <a class="page-link" href="#" data-page="<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>

                                <?php if($page < $total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="#" data-page="<?php echo ($page + 1); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>

                    <!-- Past News Container -->
                    <div class="news-container hidden" id="past-news">
                        <?php
                        // Get current page for past news
                        $past_page = isset($_GET['past_page']) ? (int)$_GET['past_page'] : 1;
                        $past_offset = ($past_page - 1) * $items_per_page;

                        // Get total number of past items
                        $past_total_stmt = $conn->query("SELECT COUNT(*) FROM news_events WHERE event_date < CURDATE()");
                        $past_total_items = $past_total_stmt->fetchColumn();
                        $past_total_pages = ceil($past_total_items / $items_per_page);

                        // Get past items for current page
                        // For latest news
                        $stmt = $conn->prepare("SELECT * FROM news_events WHERE event_date >= CURDATE() 
                                             ORDER BY event_date ASC LIMIT ? OFFSET ?");
                        
                        // For past news
                        $stmt = $conn->prepare("SELECT * FROM news_events WHERE event_date < CURDATE() 
                                             ORDER BY event_date DESC LIMIT ? OFFSET ?");
                        $stmt->bindValue(1, $items_per_page, PDO::PARAM_INT);
                        $stmt->bindValue(2, $past_offset, PDO::PARAM_INT);
                        $stmt->execute();

                        while($row = $stmt->fetch()) {
                        ?>
                        <div class="news-item">
                            <img src="<?php echo $row['poster'] ? htmlspecialchars($row['poster']) : 'assets/images/default-event.jpg'; ?>" 
                                 class="news-image" alt="<?php echo htmlspecialchars($row['title']); ?>">
                            <div class="news-content">
                                <span class="news-tag">Featured News</span>
                                <a href="news-detail.php?id=<?php echo $row['id']; ?>" class="news-title">
                                    <?php echo htmlspecialchars($row['title']); ?>
                                </a>
                                <div class="news-date">
                                    <i class="far fa-calendar-alt"></i> 
                                    <?php echo date('F d, Y', strtotime($row['event_date'])); ?>
                                </div>
                                <p class="news-description">
                                    <?php echo nl2br(htmlspecialchars(substr($row['description'], 0, 150))); ?>...
                                </p>
                                <i class="fas fa-share-alt share-icon"></i>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- Pagination for Past News -->
                        <?php if($past_total_pages > 1): ?>
                        <nav aria-label="Page navigation" class="mt-4">
                            <ul class="pagination justify-content-center">
                                <?php if($past_page > 1): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?past_page=<?php echo ($past_page - 1); ?>" aria-label="Previous">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>

                                <?php for($i = 1; $i <= $past_total_pages; $i++): ?>
                                <li class="page-item <?php echo $i === $past_page ? 'active' : ''; ?>">
                                    <a class="page-link" href="?past_page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                </li>
                                <?php endfor; ?>

                                <?php if($past_page < $past_total_pages): ?>
                                <li class="page-item">
                                    <a class="page-link" href="?past_page=<?php echo ($past_page + 1); ?>" aria-label="Next">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                                <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="upcoming-events">
                        <h3>Upcoming Events</h3>
                        <?php
                        $current_date = date('Y-m-d');
                        $stmt = $conn->query("SELECT * FROM news_events WHERE event_date >= '$current_date' ORDER BY event_date ASC LIMIT 10");
                        while($row = $stmt->fetch()) {
                            $event_date = strtotime($row['event_date']);
                        ?>
                        <div class="event-item">
                            <div class="event-date">
                                <div class="month"><?php echo date('M', $event_date); ?></div>
                                <div class="day"><?php echo date('d', $event_date); ?></div>
                            </div>
                            <div class="event-info">
                                <h4><?php echo htmlspecialchars($row['title']); ?></h4>
                                <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($row['venue']); ?></p>
                            </div>
                            <a href="news-detail.php?id=<?php echo $row['id']; ?>" class="event-link">
                                <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                        <?php } ?>
                        <div class="text-center mt-4">
                            <a href="all-events.php" class="btn btn-outline-primary">View More Events →</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            const newsContainers = document.querySelectorAll('.news-container');

            function loadNews(page, container) {
                fetch(`get_news.php?page=${page}&container=${container}`)
                    .then(response => response.text())
                    .then(html => {
                        document.getElementById(`${container}-news`).innerHTML = html;
                        // Update URL without page reload
                        const urlParams = new URLSearchParams(window.location.search);
                        urlParams.set(container === 'latest' ? 'page' : 'past_page', page);
                        history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                        
                        // Reattach event listeners to new pagination
                        attachPaginationListeners();
                    });
            }

            function attachPaginationListeners() {
                document.querySelectorAll('.pagination .page-link').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const page = this.dataset.page;
                        const container = this.closest('.news-container').id.replace('-news', '');
                        loadNews(page, container);
                    });
                });
            }

            // Initial attachment of pagination listeners
            attachPaginationListeners();

            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    // Remove active class from all buttons
                    toggleBtns.forEach(b => b.classList.remove('active'));
                    // Add active class to clicked button
                    this.classList.add('active');

                    // Hide all news containers
                    newsContainers.forEach(container => {
                        container.classList.add('hidden');
                    });

                    // Show the selected news container
                    const targetContainer = document.getElementById(this.dataset.target + '-news');
                    if (targetContainer) {
                        targetContainer.classList.remove('hidden');
                    }
                    
                    // Update URL without page reload
                    const urlParams = new URLSearchParams(window.location.search);
                    if (this.dataset.target === 'latest') {
                        urlParams.delete('past_page');
                        if (!urlParams.has('page')) urlParams.set('page', '1');
                    } else {
                        urlParams.delete('page');
                        if (!urlParams.has('past_page')) urlParams.set('past_page', '1');
                    }
                    history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                });
            });
        });
 
   
    document.addEventListener('DOMContentLoaded', function() {
        const toggleBtns = document.querySelectorAll('.toggle-btn');
        const newsContainers = document.querySelectorAll('.news-container');
    
        function scrollToNews() {
            const newsSection = document.querySelector('.news-container');
            const offset = window.innerWidth <= 576 ? 60 : 80;
            const topPosition = newsSection.getBoundingClientRect().top + window.pageYOffset - offset;
            window.scrollTo({
                top: topPosition,
                behavior: 'smooth'
            });
        }
    
        // Handle pagination clicks
        document.querySelectorAll('.pagination .page-link').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const page = this.dataset.page;
                const container = this.closest('.news-container');
                container.classList.add('loading');
                
                // Add loading state
                setTimeout(() => {
                    // Your existing pagination logic here
                    scrollToNews();
                    container.classList.remove('loading');
                }, 300);
            });
        });
    
        // Toggle functionality
        toggleBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                toggleBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
    
                const targetId = this.dataset.target + '-news';
                newsContainers.forEach(container => {
                    container.classList.add('hidden');
                });
    
                const targetContainer = document.getElementById(targetId);
                if (targetContainer) {
                    targetContainer.classList.remove('hidden');
                    scrollToNews();
                }
            });
        });
    });
    </script>
</body>
</html>
