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
    header("Location: news-and-blog.php");
    exit;
}
?>


<?php
// Force the domain + https for ALL share URLs
$baseDomain = "https://hindusthan.net";

// Get current page path (e.g. /news.php?id=5)
$currentPath = $_SERVER['REQUEST_URI'];

// Build full page URL
$fullUrl = $baseDomain . $currentPath;

// Encode for share links
$encodedUrl = rawurlencode($fullUrl);

// Optional share text
$shareText = rawurlencode("Check this out");
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
            background-image:url("assets/home/comman/bg_newspage.png");
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
            object-fit: contain;
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


<title>Hindusthan Institute of Technology | Top Engineering College in Coimbatore</title>
        <link rel="icon" type="image/png" href="assets/hindusthan_images/hindusthan.png">


</head>
<body>


        <!-- preloader -->
        <div class="preloader-container" id="preloader">
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
        </div>
        <!-- preloader -->

        <!-- Start Top Navbar Area -->
        <div class="top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-12 col-xm-12">
                        <div class="top-left-items">
                            <ul>
                                <li><i class='bx bxs-time'></i> Mon - Sat : 9:00 AM - 06:00 PM</li>
                                <li><i class='bx bxs-envelope'></i> <a href="mailto:info@hindusthan.net">contact : info@hindusthan.net</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12 col-xm-12">
                        <div class="top-right-items">
                            <ul>
                                <li><i class='bx bxs-map'></i> <a href='contact-us.html'>Visit Us</a></li>
                                <li><a href='student-activities.html'>Students</a></li>
                                 <li><a href='alumni.php'>Alumni</a></li>
                                <li><a href='the-campus-experience.html'>Visitors</a></li>
                                <li><a href='https://www.instagram.com/hindusthancolleges'>Media</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Navbar Area -->

        <!-- Start Navbar Area Start -->
       <div class="navbar-area" id="navbar">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">
                <a class='navbar-brand' href='index.html'>
                    <img class="logo-light" src="assets/hindusthan_images/hindusthan_logo.png"  alt="logo">
                </a>
                  <a class="navbar-toggler" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button" aria-controls="navbarOffcanvas">
                    <i class='bx bx-menu'></i>
                </a>
                <div class="collapse navbar-collapse justify-content-between">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class='nav-link' href='index.html'>
                                Home
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link active">
                                About
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='about-us.html'>About Us</a></li>
                                <li class="nav-item"><a class='nav-link' href='news-and-blog.php'>News and Blog</a></li>
                                <li class="nav-item"><a class='nav-link active' href='blog-details.php'>Blog Details</a></li>
                                <li class="nav-item"><a class='nav-link' href='alumni.php'>Alumni</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Academics
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='academics.html'>Academics</a></li>
                                <li class="nav-item"><a class='nav-link' href='undergraduate.html'>Undergraduate</a></li>
                                <li class="nav-item"><a class='nav-link' href='graduate.html'>Postgraduate</a></li>
                                <li class="nav-item"><a class='nav-link' href='education.html
'>Education
</a></li>
                             </ul>
                        </li>
                                                                        <li class="nav-item mega-nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Courses
                            </a>
                            <div class="dropdown-menu mega-menu-box">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="aeronautical-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Aeronautical Engineering</h6>
                                                <p class="mega-desc">Design, manufacturing, and mechanics of flight.</p>
                                            </a>
                                            <a href="computer-science-and-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Computer Science and Engineering</h6>
                                                <p class="mega-desc">Software dev, algorithms, and logic systems.</p>
                                            </a>
                                            <a href="mechanical-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Mechanical Engineering</h6>
                                                <p class="mega-desc">Design and manufacturing of mechanical systems.</p>
                                            </a>
                                            <a href="m-e-vlsi-design.html" class="mega-link">
                                                <h6 class="mega-title">M.E. VLSI Design</h6>
                                                <p class="mega-desc">Microchip architecture and system-on-chip design.</p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="artificial-intelligence-and-data-science.html" class="mega-link">
                                                <h6 class="mega-title">Artificial Intelligence & Data Science</h6>
                                                <p class="mega-desc">Machine learning, analytics, and big data.</p>
                                            </a>
                                            <a href="information-technology.html" class="mega-link">
                                                <h6 class="mega-title">Information Technology</h6>
                                                <p class="mega-desc">Network systems, security, and IT management.</p>
                                            </a>
                                            <a href="master-of-business-administration.html" class="mega-link">
                                                <h6 class="mega-title">Master of Business Administration</h6>
                                                <p class="mega-desc">Business leadership and corporate strategies.</p>
                                            </a>
                                            <a href="science-and-humanities.html" class="mega-link">
                                                <h6 class="mega-title">Science & Humanities</h6>
                                                <p class="mega-desc">Foundational sciences and general studies.</p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="electronics-and-communication-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Electronics and Communication Engineering</h6>
                                                <p class="mega-desc">Circuit design and electronic devices.</p>
                                            </a>
                                             

                                            <a href="m-e-computer-science-and-engineering.html" class="mega-link">
                                                <h6 class="mega-title">M.E. Computer Science and Engineering</h6>
                                                <p class="mega-desc">Advanced postgraduate computing logic.</p>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Admissions
                            </a>
                             <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='how-to-apply.html'>How to Apply</a></li>
                                <li class="nav-item"><a class='nav-link' href='https://apply.hindusthan.net/' target="_blank">Admissions</a></li>
                                <li class="nav-item"><a class='nav-link' href='https://apply.hindusthan.net/arts-and-science' target="_blank">Arts & Science-Form</a></li>
                                <li class="nav-item"><a class='nav-link' href='https://apply.hindusthan.net/engineering-form' target="_blank">Engineering-Form</a></li>
                                <li class="nav-item"><a class='nav-link' href='financial-aid.html'>Financial Aid</a></li>
                            </ul>
                        </li>
                         
                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                College Life
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='college-life.html'>College Life</a></li>
                                <li class="nav-item"><a class='nav-link' href='the-campus-experience.html'>The Campus Experience</a></li>
                                <li class="nav-item"><a class='nav-link' href='fitness-athletics.html'>Fitness & Athletics</a></li>
                                <li class="nav-item"><a class='nav-link' href='support-guidance.html'>Support & Guidance</a></li>
                                <li class="nav-item"><a class='nav-link' href='student-activities.html'>Student Activities</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class='nav-link' href='contact-us.html'>
                                Contact
                            </a>
                        </li>
                    </ul>
                    <div class="others-option d-flex align-items-center">
                        <div class="option-item">
                                                        <div class="nav-btn">
                                <a class='default-btn' href='https://apply.hindusthan.net/' target="_blank">Admission</a>
                            </div>

                        </div>
                     </div>
                </div>
            </nav>
        </div>
       </div>
       <!-- End Navbar Area Start -->

        <!-- Start Responsive Navbar Area -->
        <div class="responsive-navbar offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
            <div class="offcanvas-header">
                <a class='logo d-inline-block' href='index.html'>
                    <img class="logo-light" src="assets/hindusthan_images/hindusthan_logo.png"  alt="logo">
                </a>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="accordion" id="navbarAccordion">
                    <div class="accordion-item">
                        <a class='accordion-link without-icon' href='index.html'>
                            Home
                        </a>
                    </div>                    <div class="accordion-item">
                        <button class="accordion-button collapsed active" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            About
                        </button>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion8">
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='about-us.html'>
                                            About Us
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='news-and-blog.php'>
                                            News and Blog
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link active' href='blog-details.php'>
                                            Blog Details
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='alumni.php'>
                                            Alumni
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Academics
                        </button>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion30">
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='academics.html'>
                                            Academics
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='undergraduate.html'>
                                            Undergraduate
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link ' href='graduate.html'>
                                            Postgraduate
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='education.html
'>
                                            Education

                                        </a>
                                    </div>
  
                                </div>
                            </div>
                        </div>
                    </div>
                                    <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCourses" aria-expanded="false" aria-controls="collapseCourses">
                        Courses
                    </button>
                    <div id="collapseCourses" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionCourses">
                                <div class="accordion-item">
                                    <a class='accordion-link' href='aeronautical-engineering.html'>Aeronautical Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='artificial-intelligence-and-data-science.html'>Artificial Intelligence & Data Science</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='electronics-and-communication-engineering.html'>Electronics and Communication Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='computer-science-and-engineering.html'>Computer Science and Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='information-technology.html'>Information Technology</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='pharmaceutical-technology.html'>Pharmaceutical Technology</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='mechanical-engineering.html'>Mechanical Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='master-of-business-administration.html'>Master of Business Administration</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='m-e-computer-science-and-engineering.html'>M.E. Computer Science and Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='m-e-vlsi-design.html'>M.E. VLSI Design</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='science-and-humanities.html'>Science & Humanities</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                            Admissions
                        </button>
                        <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion31">
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='how-to-apply.html'>
                                            How to Apply
                                        </a>
                                    </div>

                                    <div class="accordion-item">
                                        <a class='accordion-link' href='https://apply.hindusthan.net/' target="_blank">
                                            Admissions
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='https://apply.hindusthan.net/arts-and-science' target="_blank">
                                            Arts & Science-Form
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='https://apply.hindusthan.net/engineering-form' target="_blank">
                                            Engineering-Form
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='financial-aid.html'>
                                            Financial Aid
                                        </a>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                      
                    <div class="accordion-item">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSix" aria-expanded="false" aria-controls="collapseSix">
                            College Life
                        </button>
                        <div id="collapseSix" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordion40">
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='college-life.html'>
                                            College Life
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='the-campus-experience.html'>
                                            The Campus Experience
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='fitness-athletics.html'>
                                            Fitness &amp; Athletics
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='support-guidance.html'>
                                            Support &amp; Guidance
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='student-activities.html'>
                                            Student Activities
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <a class='accordion-link without-icon' href='contact-us.html'>
                            Contact Us
                        </a>
                    </div>
                </div>
                <div class="offcanvas-contact-info">
                    <h4>Contact Info</h4>
                    <ul class="contact-info list-style">
                        <li>
                            <i class="bx bxs-envelope"></i>
                            <a href="mailto:info@hindusthan.net">contact : info@hindusthan.net</a>
                        </li>
                        <li>
                            <i class="bx bxs-time"></i>
                            <p>Mon - Sat : 9:00 AM - 06:00 PM</p>
                        </li>
                    </ul>
                    <ul class="social-profile list-style">
                        <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                        <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                        <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i class='bx bxl-linkedin' ></i></a></li>
                    </ul>
                </div>
                <div class="offcanvas-other-options">
                    <div class="option-item">
                        <a class='default-btn' href='https://apply.hindusthan.net/' target="_blank">Admission</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Responsive Navbar Area -->

 
        <!-- Start Section Banner Area -->
        <div class="section-banner bg-3">
            <div class="container">
                <div class="banner-spacing">
                    <div class="section-info">
                        <h2 data-aos="fade-up" data-aos-delay="100">Blog Details</h2>
                        <p data-aos="fade-up" data-aos-delay="200">Explore the full story and insights behind this blog post in a simple and engaging way.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Banner Area -->
    <div class="news-detail">
        <div class="container">
        <div class="section-title">
                <span style="color: #ff6b00;">News and Event</span>
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

        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $encodedUrl; ?>"
           target="_blank" rel="noopener noreferrer">
            <i class="fab fa-facebook-f"></i>
        </a>

        <a href="https://twitter.com/intent/tweet?url=<?php echo $encodedUrl; ?>&text=<?php echo $shareText; ?>"
           target="_blank" rel="noopener noreferrer">
            <i class="fab fa-twitter"></i>
        </a>

        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo $encodedUrl; ?>"
           target="_blank" rel="noopener noreferrer">
            <i class="fab fa-linkedin-in"></i>
        </a>

        <a href="https://wa.me/?text=<?php echo $shareText; ?>%20<?php echo $encodedUrl; ?>"
           target="_blank" rel="noopener noreferrer">
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

    
        <!-- Start Footer Area -->
        <div class="footer-area">
            <div class="footer-top-info pb-100">
                <div class="content">
                                          <div class="image">
                        <img src="assets/hindusthan_images/hindusthan_logo.png" style="height: 80px;width: 80px;" alt="image">
                    </div>

                    <p>Hindusthan offers an inclusive, welcoming campus where students learn with purpose, explore with confidence, and embrace opportunities that shape their future.</p>
                    <ul>
                        <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                        <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i class='bx bxl-instagram'></i></a></li>
                        <li><a href="https://x.com/Hindusthanhce?t=cH1BisxThpHw8G_iyNXYDA&s=09"><i class='bx bxl-twitter'></i></a></li>
                        <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i class='bx bxl-linkedin-square'></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-widget-info pt-100">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <ul>
                                <div>
                                    <img class="logo-light logo-responsive-footer" src="assets/college_logos/hindusthan_logo_white.png"
                                        style="height:auto !important; width:auto !important; max-height:50px; margin-bottom: 20px; align-items: center;">
                                </div>
                                <p>City Campus, Nava India, Avinashi Road, Coimbatore - 641028 & Valley Campus, Pollachi
                                    Highway, Coimbatore - 641032, Tamilnadu, India.</p>
                                <div style="color: white;">
                                  <i class="bx bxs-phone-call"></i>  <a href="tel:+91 422 - 4440555" style="color: white;">  +91 422 - 4440555</a>
                                </div>
                                <div style="color: white;">
                                   <i class="bx bxs-phone-call"></i> <a href="tel:+91 80983 33333" style="color: white;">  +91 80983 33333</a>
                                </div>
                                <div style="color: white;">
                                   <i class="bx bxs-envelope"></i> <a href="mailto:info@hindusthan.net" style="color: white;">  info@hindusthan.net</a>
                                </div>

                            </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4>Our Campus</h4>
                            <ul>
                                <li><a href='https://hicas.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        Arts & Science</a></li>
                                <li><a href='https://hicet.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        Engineering & Technology</a></li>
                                <li><a href='http://hit.edu.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        Institute of Technology</a></li>
                                <li><a href='https://hindusthan.net/hce/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> College of Education</a></li>
                                <li><a href='https://hsoa.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        School of Architecture</a></li>
                                <li><a href='https://hpc.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        Polytechnic College</a></li>
                                <li><a href='https://hindusthan.net/hschool/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> Hindusthan School</a></li>
                                <li><a href='https://his.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        International School</a></li>
                                <li><a href='https://hindusthan.net/hichs/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> College of Health Science</a></li>
                                <li><a href='https://www.hindusthan.net/hicon/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> College of Nursing</a></li>
                                <li><a href='https://hisac.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        College of Science & Commerce</a></li>
                                <li><a href='https://hindusthan.net/hice/' target="_blank"><i
                                            class='bx bx-chevron-right'></i>
                                        College of Engineering</a></li>
                             </ul>

                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4>Quick Links</h4>
                                <ul>
                                    <li><a href='how-to-apply.html'><i class='bx bx-chevron-right'></i> Apply For Admissions</a></li>
                                    <li><a href='about-us.html'><i class='bx bx-chevron-right'></i> About us</a></li>
                                    <li><a href='undergraduate.html'><i class='bx bx-chevron-right'></i> UG Course</a></li>
                                    <li><a href='graduate.html'><i class='bx bx-chevron-right'></i> PG Course</a></li>
                                    <li><a href='the-campus-experience.html'><i class='bx bx-chevron-right'></i> Campus Experience</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4>Location</h4>
                                <ul>
                                    <div id="map" class="map-pd">
                                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d62661.52189754748!2d76.99315200000001!3d11.012712!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5265d0f0e202dd%3A0x6c1cb249318c77f!2shicas!5e0!3m2!1sen!2sin!4v1746593040542!5m2!1sen!2sin" width="600" height="450" style="border-radius:20px 20px 20px 20px;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>                                    </div>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-right-area style-2">
                <div class="container">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="cpr-left">
                                <p style="font-size: 12.5px;">Design & Developed by<a href="https://novacodex.in/" style="color: black;"> NovaCodex </a> ( HICAS - IT Alumni )</p>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="cpr-right">
                                <ul>
                                 <div class="cpr-left">
                                    <p style="font-size: 15px;">Copyright© <a href="#">Hindusthan.net</a>, All rights reserved.</p>
                                 </div>

                                    <!-- <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Cookie Policy</a></li> -->
                                </ul>
                                <ul class="social-list">
                                    <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i class='bx bxl-facebook'></i></a></li>
                                    <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i class='bx bxl-instagram-alt'></i></a></li>
                                    <li><a href="https://x.com/Hindusthanhce?t=cH1BisxThpHw8G_iyNXYDA&s=09"><i class='bx bxl-twitter'></i></a></li>
                                    <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i class='bx bxl-linkedin-square'></i></a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Footer Area -->

        <div class="go-top active">
            <i class="bx bx-up-arrow-alt"></i>
        </div>

        <!-- Links of JS files -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/aos.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    </body>

</html>

