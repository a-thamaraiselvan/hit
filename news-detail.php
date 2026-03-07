<?php
require_once 'admin/includes/db.php';

// Get news ID from URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Fetch news details
$stmt = $conn->prepare("SELECT * FROM news_events WHERE id = ?");
$stmt->execute([$id]);
$news = $stmt->fetch();

// If news not found, redirect to news page
if (!$news) {
    header("Location: news.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($news['title']); ?> - Hindusthan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
        .news-detail {
            padding: 60px 0;
            background: #f9f9f9;
        }
        
        .news-header {
            margin-bottom: 30px;
        }
        
        .news-title {
            font-size: 1.5rem;
            color: #1a1a1a;
            margin-bottom: 20px;
        }
        
        .news-meta {
            display: flex;
            gap: 20px;
            color: #666;
            margin-bottom: 20px;
        }
        
        .news-meta i {
            color: #ff6b00;
            margin-right: 5px;
        }
        
        .news-poster {
            width: 100%;
            max-height: 500px;
            object-fit: contain !important;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .news-content {
            background: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.05);
        }
        
        .news-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #444;
            margin-bottom: 30px;
        }
        
        .news-info {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        
        .news-info h4 {
            color: #1a1a1a;
            margin-bottom: 15px;
        }
        
        .news-info p {
            margin-bottom: 10px;
        }
        
        .news-info i {
            color: #ff6b00;
            width: 25px;
        }
        
        .share-buttons {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }
        
        .share-buttons h4 {
            margin-bottom: 15px;
        }
        
        .social-links {
            display: flex;
            gap: 10px;
        }
        
        .social-links a {
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f8f9fa;
            color: #666;
            border-radius: 50%;
            transition: all 0.3s ease;
        }
        
        .social-links a:hover {
            background: #ff6b00;
            color: #fff;
        }

        @media (max-width: 768px) {
            .news-title {
                font-size: 1rem;
            }
            
            .news-content {
                padding: 20px;
            }
            
            .news-meta {
                flex-direction: column;
                gap: 10px;
            }
        }
    </style>
</head>
<body>
    <div class="news-detail">
        <div class="container">
        <div class="section-title">
                <span>News and Event</span>
                <h2>View Full Details</h2>
                <!-- <p>Updated</p> -->
            </div>

            <div class="news-header">
                <h1 class="news-title"><?php echo htmlspecialchars($news['title']); ?></h1>
                <P class="news-title">Event Name : <?php echo htmlspecialchars($news['event_name']); ?></P>

                <div class="news-meta">
                    <span><i class="far fa-calendar-alt"></i> <?php echo date('F d, Y', strtotime($news['event_date'])); ?></span>
                    <span><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($news['venue']); ?></span>
                    <?php if($news['chief_guest']): ?>
                        <span><i class="fas fa-user"></i> <?php echo htmlspecialchars($news['chief_guest']); ?></span>
                    <?php endif; ?>
                </div>
            </div>

            <?php if($news['poster']): ?>
                <img src="<?php echo htmlspecialchars($news['poster']); ?>" 
                     alt="<?php echo htmlspecialchars($news['title']); ?>" 
                     class="news-poster">
            <?php endif; ?>

            <div class="row">
                <div class="col-lg-8">
                    <div class="news-content">
                        <div class="news-description">
                            <?php echo nl2br(htmlspecialchars($news['description'])); ?>
                        </div>

                        <div class="share-buttons">
                            <h4>Share This Story</h4>
                            <div class="social-links">
                                <a href="https://facebook.com/sharer/sharer.php?u=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" title="Share on Facebook">
                                    <i class="fab fa-facebook-f"></i>
                                </a>
                                <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" title="Share on Twitter">
                                    <i class="fab fa-twitter"></i>
                                </a>
                                <a href="https://www.linkedin.com/company/hindusthanedu/shareArticle?url=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" title="Share on LinkedIn">
                                    <i class="fab fa-linkedin-in"></i>
                                </a>
                                <a href="https://wa.me/?text=<?php echo urlencode($_SERVER['REQUEST_URI']); ?>" 
                                   target="_blank" title="Share on WhatsApp">
                                    <i class="fab fa-whatsapp"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="news-info">
                        <h4>Event Information</h4>
                        <p><i class="fas fa-calendar-alt"></i> <?php echo date('F d, Y', strtotime($news['event_date'])); ?></p>
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($news['venue']); ?></p>
                        <?php if($news['event_name']): ?>
                            <p><i class="fas fa-bookmark"></i> <?php echo htmlspecialchars($news['event_name']); ?></p>
                        <?php endif; ?>
                        <?php if($news['chief_guest']): ?>
                            <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($news['chief_guest']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>