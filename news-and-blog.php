<?php
require_once 'admin/includes/db.php';
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="robots" content="index, follow">

    <!-- Links of CSS files -->
    <link rel="stylesheet" href="assets/css/aos.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/boxicons.min.css">
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="assets/css/flaticon.css">
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/header.css">
    <link rel="stylesheet" href="assets/css/responsive.css">

    <title>News and Blog</title>
    <link rel="icon" type="image/png" href="assets/hindusthan_images/hindusthan.png">

    <style>
        .news-section {
            padding: 60px 0;
            background-image: url("assets/home/comman/bg-design1.png");

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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        .news-image {
            width: 300px;
            /* height: 220px; */
            object-fit: scale-down;
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
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
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
            background: #ff6b00 !important;
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
                            <!-- <li><i class='bx bxs-time'></i> Mon - Sat : 9:00 AM - 06:00 PM</li> -->
                            <li><i class='bx bxs-envelope'></i> <a href="mailto: hit.office@hindusthan.net">contact :
                                    hit.office@hindusthan.net</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-7 col-12 col-xm-12">
                    <div class="top-right-items">
                        <ul>
                            <!-- <li><a href='#'>Exam Result Even Sem</a></li> -->
                            <!-- <li><a href='student-activities.html'>Students</a></li> -->
                            <!-- <li><a href='alumni.php'>Alumni</a></li> -->
                            <li><a href='https://www.instagram.com/hindusthancolleges'>Media</a></li>
                            <li><a href='contact-us.php'>contact-us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Navbar Area -->

    <!-- Start Navbar Area Start -->
    <!-- Start Navbar Area Start -->
    <div class="navbar-area style-2" id="navbar">
        <div class="container-fluid">
            <nav class="navbar navbar-expand-lg">
                <a class='navbar-brand' href='index.html'>

                    <img class="logo-light logo-responsive" src="assets/hindusthan_images/hit_logo.jpg"
                        style="height:auto !important; width:auto !important; max-height:50px;">


                    <!-- <img class="logo-light" src="assets/hindusthan_images/hindusthan_logo.png" style="height: 50%; width: 50%;"
                        alt="logo"> -->

                    <img class="logo-dark" src="assets/hindusthan_images/hindusthan_logo.png" alt="logo">


                    <!-- <img class="logo-light" src="assets/hindusthan_images/hect.png"  alt="logo">
                    <img class="logo-dark" src="assets/hindusthan_images/hect.png"  alt="logo"> -->

                </a>

                <a class="navbar-toggler" data-bs-toggle="offcanvas" href="#navbarOffcanvas" role="button"
                    aria-controls="navbarOffcanvas">
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
                                <li class="nav-item"><a class='nav-link active' href='news-and-blog.php'>News and
                                        Blog</a></li>
                                <li class="nav-item"><a class='nav-link' href='blog-details.php'>Blog Details</a></li>

                                <li class="nav-item"><a class='nav-link' href='facilities.html'>Facilities</a></li>
                                <li class="nav-item"><a class='nav-link' href='gallery.html'>Gallery</a></li>
                            </ul>
                        </li>
                        <!-- <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Academics
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='academics.html'>Academics</a></li>
                                <li class="nav-item"><a class='nav-link' href='undergraduate.html'>Undergraduate</a>
                                </li>
                                <li class="nav-item"><a class='nav-link' href='graduate.html'>Postgraduate</a></li>
                                <li class="nav-item"><a class='nav-link' href='education.html'>Education</a></li>
                            </ul>
                        </li> -->
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
                                            <a href="m-e-vlsi-design.html" class="mega-link">
                                                <h6 class="mega-title">M.E. VLSI Design</h6>
                                                <p class="mega-desc">Microchip architecture and system-on-chip design.
                                                </p>
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
                                <li class="nav-item"><a class='nav-link' href='https://admission.hindusthan.net/'
                                        target="_blank">Admissions</a></li>
                                <li class="nav-item"><a class='nav-link' href='admission_policy.html'>Admission
                                        Policy</a></li>
                                <li class="nav-item"><a class='nav-link' href='financial-aid.html'>Financial Aid</a>
                                </li>
                            </ul>
                        </li>

                        <!-- <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                College Life
                            </a>
                            <ul class="dropdown-menu">
                                <li class="nav-item"><a class='nav-link' href='college-life.html'>College Life</a></li>
                                <li class="nav-item"><a class='nav-link' href='the-campus-experience.html'>The Campus
                                        Experience</a></li>
                                <li class="nav-item"><a class='nav-link' href='fitness-athletics.html'>Fitness &
                                        Athletics</a></li>
                                <li class="nav-item"><a class='nav-link' href='support-guidance.html'>Support &
                                        Guidance</a></li>
                                <li class="nav-item"><a class='nav-link' href='student-activities.html'>Student
                                        Activities</a></li>
                            </ul>
                        </li> -->
                        <li class="nav-item mega-nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Placement
                            </a>
                            <div class="dropdown-menu mega-menu-boxPlacement">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="about_placement.html" class="mega-link ">
                                                <h6 class="mega-title">About Placement</h6>
                                                <p class="mega-desc">Overview of our training and placement cell.</p>
                                            </a>
                                            <a href="assets/hit/pdf_folder/placement_pdf/HiTECH Placement Details.pdf"
                                                target="_blank" class="mega-link">
                                                <h6 class="mega-title">Placement Details</h6>
                                                <p class="mega-desc">Detailed statistics and recruitment information.
                                                </p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="assets/hit/pdf_folder/placement_pdf/PLACEMENT 2024-2025.pdf"
                                                target="_blank" class="mega-link">
                                                <h6 class="mega-title">Placement 2025</h6>
                                                <p class="mega-desc">Record of placements for the year 2025.</p>
                                            </a>
                                            <a href="assets/hit/pdf_folder/placement_pdf/PLACEMENT 2023-2024.pdf"
                                                target="_blank" class="mega-link">
                                                <h6 class="mega-title">Placement 2024</h6>
                                                <p class="mega-desc">Record of placements for the year 2024.</p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="assets/hit/pdf_folder/placement_pdf/PLACEMENT 2022-2023.pdf"
                                                target="_blank" class="mega-link">
                                                <h6 class="mega-title">Placement 2023</h6>
                                                <p class="mega-desc">Record of placements for the year 2023.</p>
                                            </a>
                                            <a href="assets/hit/pdf_folder/placement_pdf/PLACEMENT 2021-2022.pdf"
                                                target="_blank" class="mega-link">
                                                <h6 class="mega-title">Placement 2022</h6>
                                                <p class="mega-desc">Record of placements for the year 2022.</p>
                                            </a>
                                        </div>

                                    </div>
                                </div>
                            </div>

                        </li>

                        <li class="nav-item mega-nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Academic Menu
                            </a>

                            <div class="dropdown-menu mega-menu-boxmenu">
                                <div class="container">
                                    <div class="row">

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="coe.html" class="mega-link">
                                                <h6 class="mega-title">COE</h6>
                                                <p class="mega-desc">Controller of Examinations portal and academic
                                                    examination updates.</p>
                                            </a>

                                            <a href="http://ecampus.hicet.ac.in/ecampus/" class="mega-link">
                                                <h6 class="mega-title">E Campus Login</h6>
                                                <p class="mega-desc">Access the student E-Campus portal for academic
                                                    information.</p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="http://ecampus.hicet.ac.in/ecampus/online_payments"
                                                class="mega-link">
                                                <h6 class="mega-title">Online Fee Payment</h6>
                                                <p class="mega-desc">Pay tuition and other institutional fees securely
                                                    online.</p>
                                            </a>

                                            <a href="exam-fee.html" class="mega-link">
                                                <h6 class="mega-title">Exam Fee</h6>
                                                <p class="mega-desc">Pay examination fees and check related
                                                    notifications.</p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="nirf.html" class="mega-link">
                                                <h6 class="mega-title">NIRF</h6>
                                                <p class="mega-desc">National Institutional Ranking Framework details
                                                    and reports.</p>
                                            </a>

                                            <a href="e-content.html" class="mega-link">
                                                <h6 class="mega-title">E-Content</h6>
                                                <p class="mega-desc">Digital learning materials and academic resources.
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">

                                            <a href="nba_dcp.html" class="mega-link">
                                                <h6 class="mega-title">NBA / DCP</h6>
                                                <p class="mega-desc">
                                                    NBA / DCP accreditation related official documents and reports.
                                                </p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">

                                            <div class="mega-link">
                                                <h6 class="mega-title">Audit Report (NBA / NAAC)</h6>

                                                <div class="audit-buttons">

                                                    <a href="assets/hit/pdf_folder/Audit_pdf/Audit 2024-25.pdf"
                                                        class="audit-btn" target="_blank">
                                                        Audit Report 2024 – 2025
                                                    </a>

                                                    <a href="assets/hit/pdf_folder/Audit_pdf/Audit 2023-24.pdf"
                                                        class="audit-btn" target="_blank">
                                                        Audit Report 2023 – 2024
                                                    </a>
                                                    <a href="assets/hit/pdf_folder/Audit_pdf/Audit 2022-23.pdf"
                                                        class="audit-btn" target="_blank">
                                                        Audit Report 2022 – 2023
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">

                                            <div class="mega-link">
                                                <h6 class="mega-title">Audit Report (NBA / NAAC)</h6>

                                                <div class="audit-buttons">

                                                    <a href="assets/hit/pdf_folder/Audit_pdf/NBA EXT 2025.pdf"
                                                        class="audit-btn" target="_blank">
                                                        NBA
                                                    </a>

                                                    <a href="assets/hit/pdf_folder/Audit_pdf/accreditation2022.pdf"
                                                        class="audit-btn" target="_blank">
                                                        NAAC
                                                    </a>
                                                </div>
                                            </div>
                                        </div>



                                    </div>
                                </div>
                        </li>


                        <li class="nav-item">
                            <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                Committees
                            </a>

                            <ul class="dropdown-menu">



                                <li class="nav-item">
                                    <a class="nav-link" href="statutory.html">Statutory</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="non-statutory.html">Non-Statutory</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="iqac.html">IQAC</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="research-cell.html">Research Cell</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link"
                                        href="assets\hit\pdf_folder\HiTech Campus Security Audit Checklist.pdf"
                                        target="_blank">
                                        Campus Security Audit (PDF)
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="alumni.php">Alumni</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" href="posh-cell.html">
                                        POSH Cell
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="reports.html">
                                        Reports
                                    </a>
                                </li>


                            </ul>
                        </li>

                        <!-- <li class="nav-item">
                            <a class='nav-link' href='contact-us.php'>
                                Contact
                            </a>
                        </li> -->
                    </ul>
                    <div class="others-option d-flex align-items-center">
                        <div class="option-item">
                            <div class="nav-btn">
                                <a class='default-btn' href='https://admission.hindusthan.net/'
                                    target="_blank">Admission</a>
                            </div>
                        </div>
                        <div class="option-item">
                            <!-- <div class="nav-search">
                                <a href="#" data-bs-toggle="offcanvas" data-bs-target="#staticBackdrop" aria-controls="staticBackdrop" class="search-button"><i class='bx bx-search'></i></a>
                            </div> -->
                        </div>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- End Navbar Area Start -->
    <!-- End Navbar Area Start -->

    <!-- Start Responsive Navbar Area -->
    <div class="responsive-navbar offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="navbarOffcanvas">
        <div class="offcanvas-header">
            <a class='logo d-inline-block' href='index.html'>
                <img class="logo-light" src="assets/hindusthan_images/hindusthan_logo.png" alt="logo">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="accordion" id="navbarAccordion">


                <div class="accordion-item">
                    <a class='accordion-link without-icon' href='index.html'>
                        Home
                    </a>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button collapsed active" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                        About
                    </button>
                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionAbout">
                                <div class="accordion-item">
                                    <a class='accordion-link ' href='about-us.html'>
                                        About Us
                                    </a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link active' href='news-and-blog.php'>
                                        News and Blog
                                    </a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='blog-details.php'>
                                        Blog Details
                                    </a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='facilities.html'>
                                        Facilities
                                    </a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='gallery.html'>
                                        Gallery
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
                                    <a class='accordion-link' href='aeronautical-engineering.html'>Aeronautical
                                        Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='artificial-intelligence-and-data-science.html'>Artificial Intelligence &
                                        Data Science</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='electronics-and-communication-engineering.html'>Electronics and
                                        Communication Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='computer-science-and-engineering.html'>Computer
                                        Science and Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='information-technology.html'>Information
                                        Technology</a>
                                </div>



                                <div class="accordion-item">
                                    <a class='accordion-link' href='mechanical-engineering.html'>Mechanical
                                        Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='master-of-business-administration.html'>Master of
                                        Business Administration</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='m-e-computer-science-and-engineering.html'>M.E.
                                        Computer Science and Engineering</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='m-e-vlsi-design.html'>M.E. VLSI Design</a>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                        Admissions
                    </button>
                    <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionAdmissions">
                                <div class="accordion-item">
                                    <a class='accordion-link' href='https://admission.hindusthan.net/' target="_blank">
                                        Admissions
                                    </a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='admission_policy.html'>
                                        Admission Policy
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
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapsePlacement" aria-expanded="false" aria-controls="collapsePlacement">
                        Placement
                    </button>
                    <div id="collapsePlacement" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionPlacement">
                                <div class="accordion-item">
                                    <a class='accordion-link' href='about_placement.html'>About Placement</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='assets/hit/pdf_folder/placement_pdf/HiTECH Placement Details.pdf'
                                        target="_blank">Placement Details</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='assets/hit/pdf_folder/placement_pdf/PLACEMENT 2024-2025.pdf'
                                        target="_blank">Placement 2025</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='assets/hit/pdf_folder/placement_pdf/PLACEMENT 2023-2024.pdf'
                                        target="_blank">Placement 2024</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='assets/hit/pdf_folder/placement_pdf/PLACEMENT 2022-2023.pdf'
                                        target="_blank">Placement 2023</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='assets/hit/pdf_folder/placement_pdf/PLACEMENT 2021-2022.pdf'
                                        target="_blank">Placement 2022</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseMenu" aria-expanded="false" aria-controls="collapseMenu">
                        Academic Menu
                    </button>
                    <div id="collapseMenu" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionMenu">
                                <div class="accordion-item">
                                    <a class='accordion-link' href='coe.html'>COE</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='http://ecampus.hicet.ac.in/ecampus/'>E Campus
                                        Login</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='http://ecampus.hicet.ac.in/ecampus/online_payments'>Online Fee Payment</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='exam-fee.html'>Exam Fee</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='nirf.html'>NIRF</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='e-content.html'>E-Content</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='nba_dcp.html'>NBA / DCP</a>
                                </div>
                                <div class="accordion-item">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#collapseAudit" aria-expanded="false"
                                        aria-controls="collapseAudit">
                                        Audit Report (NBA / NAAC)
                                    </button>
                                    <div id="collapseAudit" class="accordion-collapse collapse">
                                        <div class="accordion-body">
                                            <div class="accordion">
                                                <div class="accordion-item"><a class='accordion-link'
                                                        href='assets/hit/pdf_folder/Audit_pdf/Audit 2024-25.pdf'
                                                        target="_blank">Audit Report
                                                        2024 – 2025</a></div>
                                                <div class="accordion-item"><a class='accordion-link'
                                                        href='assets/hit/pdf_folder/Audit_pdf/Audit 2023-24.pdf'
                                                        target="_blank">Audit Report
                                                        2023 – 2024</a></div>
                                                <div class="accordion-item"><a class='accordion-link'
                                                        href='assets/hit/pdf_folder/Audit_pdf/Audit 2022-23.pdf'
                                                        target="_blank">Audit Report
                                                        2022 – 2023</a></div>
                                                <div class="accordion-item"><a class='accordion-link'
                                                        href='assets/hit/pdf_folder/Audit_pdf/NBA EXT 2025.pdf'
                                                        target="_blank">NBA</a></div>
                                                <div class="accordion-item"><a class='accordion-link'
                                                        href='assets/hit/pdf_folder/Audit_pdf/accreditation2022.pdf'
                                                        target="_blank">NAAC</a></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseCommittees" aria-expanded="false" aria-controls="collapseCommittees">
                        Committees
                    </button>
                    <div id="collapseCommittees" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionCommittees">
                                <div class="accordion-item"><a class='accordion-link'
                                        href='statutory.html'>Statutory</a></div>
                                <div class="accordion-item"><a class='accordion-link'
                                        href='non-statutory.html'>Non-Statutory</a></div>
                                <div class="accordion-item"><a class='accordion-link' href='iqac.html'>IQAC</a></div>
                                <div class="accordion-item"><a class='accordion-link' href='research-cell.html'>Research
                                        Cell</a></div>
                                <div class="accordion-item"><a class='accordion-link'
                                        href='assets\hit\pdf_folder\HiTech Campus Security Audit Checklist.pdf'
                                        target="_blank">Campus Security Audit (PDF)</a></div>
                                <div class="accordion-item"><a class='accordion-link' href='alumni.php'>Alumni</a>
                                </div>
                                <div class="accordion-item"><a class='accordion-link' href='posh-cell.html'>POSH
                                        Cell</a></div>
                                <div class="accordion-item"><a class='accordion-link' href='reports.html'>Reports</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <a class='accordion-link without-icon' href='contact-us.php'>
                        Contact Us
                    </a>
                </div>
            </div>
            <div class="offcanvas-contact-info">
                <h4>Contact Info</h4>
                <ul class="contact-info list-style">
                    <li>
                        <i class="bx bxs-envelope"></i>
                        <a href="mailto:hit.office@hindusthan.net">contact : hit.office@hindusthan.net</a>
                    </li>
                    <li>
                        <i class="bx bxs-time"></i>
                        <p>Mon - Sat : 9:00 AM - 06:00 PM</p>
                    </li>
                </ul>
                <ul class="social-profile list-style">
                    <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i
                                class='bx bxl-facebook'></i></a></li>
                    <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i
                                class='bx bxl-instagram'></i></a></li>
                    <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i
                                class='bx bxl-linkedin'></i></a></li>
                </ul>
            </div>
            <div class="offcanvas-other-options">
                <div class="option-item">
                    <a class='default-btn' href='https://admission.hindusthan.net/' target="_blank">Admission</a>
                </div>
            </div>

        </div>
    </div>
    <!-- End Responsive Navbar Area -->
    <!-- End Responsive Navbar Area -->

    <!-- Start hindusthan.net Searchbar Area -->
    <div class="hindusthan.net offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1" id="staticBackdrop">
        <div class="offcanvas-header">
            <a class='logo' href='index.html'>
                <img src="assets/hindusthan_images/hindusthan_logo.png" alt="image">
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <div class="search-box">
                <div class="searchwrapper">
                    <div class="searchbox">
                        <div class="row align-items-center">
                            <div class="col-md-9"><input type="text" class="form-control"
                                    placeholder="Fiend Your Course Here!"></div>
                            <div class="col-lg-3">
                                <a class="btn" href="#">Search</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="offcanvas-contact-info">
                <h4>Contact Info</h4>
                <ul class="contact-info list-style">
                    <li>
                        <i class="bx bxs-time"></i>
                        <p>Mon - Sat : 9:00 AM - 06:00 PM</p>
                    </li>
                    <li><i class="bx bxs-phone-call"></i> General Inquiries - <a href="tel:+8495160885">(849)
                            516-0885</a></li>
                    <li>
                        <i class="bx bxs-envelope"></i>
                        <a href="mailto:hit.office@hindusthan.net">hit.office@hindusthan.net</a>
                    </li>
                    <li>
                        <i class="bx bxs-map"></i>
                        <p>404 Camino Del Rio S, Suite 102San Diego, CA 92108</p>
                    </li>
                </ul>
                <ul class="social-profile list-style">
                    <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i
                                class='bx bxl-facebook'></i></a></li>
                    <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i
                                class='bx bxl-instagram'></i></a></li>
                    <li><a href="https://x.com/Hindusthanhce?t=cH1BisxThpHw8G_iyNXYDA&s=09" target="_blank"><i
                                class='bx bxl-twitter'></i></a></li>
                    <li><a href="https://www.dribbble.com/" target="_blank"><i class='bx bxl-dribbble'></i></a></li>
                    <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i
                                class='bx bxl-linkedin'></i></a></li>
                </ul>
            </div>

        </div>
    </div>
    <!-- End hindusthan.net Searchbar Area -->

    <!-- Start Section Banner Area -->
    <div class="section-banner bg-2">
        <div class="container">
            <div class="banner-spacing">
                <div class="section-info">
                    <h2 data-aos="fade-up" data-aos-delay="100">News and Blog</h2>
                    <p data-aos="fade-up" data-aos-delay="200">Catch up on the latest happenings, achievements, and
                        important updates from Hindusthan Educational Institutions.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section Banner Area -->

    <!-- End Blog Area -->
    <!-- Blog Area -->
    <div class="blog-area pb-100" style="margin-top: 20px;">
        <div class="container">
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
                    if ($special_event): ?>
                        <div class="special-event mb-5">
                            <div class="news-item" style="border: 2px solid #ff6b00;">
                                <img src="<?php echo $special_event['poster'] ? htmlspecialchars($special_event['poster']) : 'assets/images/default-event.jpg'; ?>"
                                    class="news-image" alt="<?php echo htmlspecialchars($special_event['event_name']); ?>">
                                <div class="news-content">
                                    <span class="news-tag" style="background: #ff6b00;">Special Event</span>
                                    <a href="blog-details.php?id=<?php echo $special_event['id']; ?>" class="news-title">
                                        <?php echo htmlspecialchars($special_event['event_name']); ?>
                                    </a>
                                    <div class="news-date">
                                        <i class="far fa-calendar-alt"></i>
                                        <?php echo date('F d, Y', strtotime($special_event['event_date'])); ?>
                                    </div>
                                    <p class="news-description">
                                        <?php echo nl2br(htmlspecialchars(substr($special_event['description'], 0, 150))); ?>...
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <a href="blog-details.php?id=<?php echo $special_event['id']; ?>"
                                            class="btn btn btn-sm" style="color: #ff6b00; border-color: #ff6b00;">
                                            View More <i class="fas fa-arrow-right ms-1"></i>
                                        </a>
                                        <i class="fas fa-share-alt share-icon"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                    endif; ?>


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
                            <?php
                            // INITIAL LOAD: LATEST (UPCOMING) NEWS (same logic as get_news.php)
                            $page = isset($_GET['page']) ? max(1, (int) $_GET['page']) : 1;
                            $items_per_page = 3;
                            $offset = ($page - 1) * $items_per_page;

                            $total_stmt = $conn->query("
                                SELECT COUNT(*) FROM news_events 
                                WHERE event_date >= CURDATE()
                            ");
                            $total_items = (int) $total_stmt->fetchColumn();
                            $total_pages = (int) ceil($total_items / $items_per_page);

                            $stmt = $conn->prepare("
                                SELECT * FROM news_events 
                                WHERE event_date >= CURDATE()
                                ORDER BY event_date ASC
                                LIMIT :limit OFFSET :offset
                            ");
                            $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
                            $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
                            $stmt->execute();
                            ?>

                            <!-- Latest News Container -->
                            <div class="news-container" id="latest-news">
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)):
                                    $event_date = strtotime($row['event_date']);
                                    ?>
                                    <div class="news-item">
                                        <img src="<?php echo $row['poster'] ? htmlspecialchars($row['poster']) : 'assets/images/default-event.jpg'; ?>"
                                            class="news-image" alt="<?php echo htmlspecialchars($row['event_name']); ?>">
                                        <div class="news-content">
                                            <span class="news-tag">Featured News</span>
                                            <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="news-title">
                                                <?php echo htmlspecialchars($row['event_name']); ?>
                                            </a>
                                            <div class="news-date">
                                                <i class="far fa-calendar-alt"></i>
                                                <?php echo date('d', $event_date) . ' ' . date('M', $event_date); ?>
                                            </div>
                                            <p class="news-description">
                                                <?php echo nl2br(htmlspecialchars(substr($row['description'], 0, 150))); ?>...
                                            </p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <a href="blog-details.php?id=<?php echo $row['id']; ?>"
                                                    class="btn btn btn-sm" style="color: #ff6b00; border-color: #ff6b00;">
                                                    View More <i class="fas fa-arrow-right ms-1"></i>
                                                </a>
                                                <i class="fas fa-share-alt share-icon"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                endwhile; ?>

                                <!-- Pagination for Latest News -->
                                <?php if ($total_pages > 1): ?>
                                    <nav aria-label="Page navigation" class="mt-4" id="latest-pagination">
                                        <ul class="pagination justify-content-center">
                                            <?php if ($page > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" data-page="<?php echo $page - 1; ?>"
                                                        data-container="latest" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php
                                            endif; ?>

                                            <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                                                <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                                                    <a class="page-link" href="#" data-page="<?php echo $i; ?>"
                                                        data-container="latest"><?php echo $i; ?></a>
                                                </li>
                                                <?php
                                            endfor; ?>

                                            <?php if ($page < $total_pages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" data-page="<?php echo $page + 1; ?>"
                                                        data-container="latest" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                                <?php
                                            endif; ?>
                                        </ul>
                                    </nav>
                                    <?php
                                endif; ?>
                            </div>

                            <!-- Past News Container -->
                            <?php
                            $past_page = isset($_GET['past_page']) ? max(1, (int) $_GET['past_page']) : 1;
                            $past_offset = ($past_page - 1) * $items_per_page;

                            $past_total_stmt = $conn->query("
                                SELECT COUNT(*) FROM news_events 
                                WHERE event_date < CURDATE()
                            ");
                            $past_total_items = (int) $past_total_stmt->fetchColumn();
                            $past_total_pages = (int) ceil($past_total_items / $items_per_page);

                            $stmt = $conn->prepare("
                                SELECT * FROM news_events 
                                WHERE event_date < CURDATE()
                                ORDER BY event_date DESC
                                LIMIT :limit OFFSET :offset
                            ");
                            $stmt->bindValue(':limit', $items_per_page, PDO::PARAM_INT);
                            $stmt->bindValue(':offset', $past_offset, PDO::PARAM_INT);
                            $stmt->execute();
                            ?>

                            <div class="news-container hidden" id="past-news">
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                    <div class="news-item">
                                        <img src="<?php echo $row['poster'] ? htmlspecialchars($row['poster']) : 'assets/images/default-event.jpg'; ?>"
                                            class="news-image" alt="<?php echo htmlspecialchars($row['event_name']); ?>">
                                        <div class="news-content">
                                            <span class="news-tag">Past Event</span>
                                            <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="news-title">
                                                <?php echo htmlspecialchars($row['event_name']); ?>
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
                                    <?php
                                endwhile; ?>

                                <!-- Pagination for Past News -->
                                <?php if ($past_total_pages > 1): ?>
                                    <nav aria-label="Page navigation" class="mt-4" id="past-pagination">
                                        <ul class="pagination justify-content-center">
                                            <?php if ($past_page > 1): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" data-page="<?php echo $past_page - 1; ?>"
                                                        data-container="past" aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php
                                            endif; ?>

                                            <?php for ($i = 1; $i <= $past_total_pages; $i++): ?>
                                                <li class="page-item <?php echo $i === $past_page ? 'active' : ''; ?>">
                                                    <a class="page-link" href="#" data-page="<?php echo $i; ?>"
                                                        data-container="past"><?php echo $i; ?></a>
                                                </li>
                                                <?php
                                            endfor; ?>

                                            <?php if ($past_page < $past_total_pages): ?>
                                                <li class="page-item">
                                                    <a class="page-link" href="#" data-page="<?php echo $past_page + 1; ?>"
                                                        data-container="past" aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                                <?php
                                            endif; ?>
                                        </ul>
                                    </nav>
                                    <?php
                                endif; ?>
                            </div>
                        </div>

                        <!-- Upcoming Events Sidebar -->
                        <div class="col-lg-4">
                            <div class="upcoming-events">
                                <h3>Upcoming Events</h3>
                                <?php
                                $current_date = date('Y-m-d');
                                $stmt = $conn->query("
                                    SELECT * FROM news_events 
                                    WHERE event_date >= '$current_date'
                                    ORDER BY event_date ASC
                                    LIMIT 10
                                ");
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $event_date = strtotime($row['event_date']);
                                    ?>
                                    <div class="event-item">
                                        <div class="event-date">
                                            <div class="month"><?php echo date('M', $event_date); ?></div>
                                            <div class="day"><?php echo date('d', $event_date); ?></div>
                                        </div>
                                        <div class="event-info">
                                            <h4><?php echo htmlspecialchars($row['event_name']); ?></h4>
                                            <p><i class="fas fa-map-marker-alt"></i>
                                                <?php echo htmlspecialchars($row['venue']); ?></p>
                                        </div>
                                        <a href="blog-details.php?id=<?php echo $row['id']; ?>" class="event-link">
                                            <i class="fas fa-arrow-right"></i>
                                        </a>
                                    </div>
                                    <?php
                                } ?>
                                <!-- <div class="text-center mt-4">
                                    <a href="all-events.php" class="btn btn" style="color: #ff6b00; border-color: #ff6b00;">View More Events →</a>
                                </div> -->
                            </div>
                        </div>
                    </div> <!-- row -->
                </div>
            </div>
        </div>
    </div>
    <!-- End Blog Area -->

    <!-- Start Footer Area -->
    <div class="footer-area">
        <div class="footer-top-info ptb-100">
            <div class="content">
                <!-- <div class="image">
                    <img src="assets/hindusthan_images/hindusthan_logo.png" style="height: 80px;width: 80px;"
                        alt="image">
                </div> -->

                <p>Hindusthan offers an inclusive, welcoming campus where students learn with purpose, explore with
                    confidence, and embrace opportunities that shape their future.</p>
                <ul>
                    <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i
                                class='bx bxl-facebook'></i></a></li>
                    <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i
                                class='bx bxl-instagram'></i></a></li>
                    <li><a href="https://x.com/Hindusthanhce?t=cH1BisxThpHw8G_iyNXYDA&s=09"><i
                                class='bx bxl-twitter'></i></a></li>
                    <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i
                                class='bx bxl-linkedin-square'></i></a></li>
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
                                    <img class="logo-light logo-responsive-footer"
                                        src="assets/college_logos/hindusthan_logo_white.png"
                                        style="height:auto !important; width:auto !important; max-height:50px; margin-bottom: 20px; align-items: center;">
                                </div>
                                <p>Hindusthan Institute of Technology, Valley Campus, Pollachi Highway, Coimbatore - 641
                                    032. TamilNadu, INDIA</p>
                                <div style="color: white;">
                                    <i class="bx bxs-phone-call"></i> <a href="tel:+91 9715260118"
                                        style="color: white;"> +91 9715260118</a>
                                </div>
                                <div style="color: white;">
                                    <i class="bx bxs-phone-call"></i> <a href="tel:+91 9047010006"
                                        style="color: white;"> +91 9047010006</a>
                                </div>
                                <div style="color: white;">
                                    <i class="bx bxs-envelope"></i> <a href="mailto:hit.office@hindusthan.net"
                                        style="color: white;"> hit.office@hindusthan.net</a>
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
                                <li><a href='https://hice.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        College of Engineering</a></li>
                            </ul>

                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="footer-widget">
                            <h4>Quick Links</h4>
                            <ul>
                                <li><a href='admission_policy.html'><i class='bx bx-chevron-right'></i> Admission
                                        Policy</a></li>
                                <li><a href='about-us.html'><i class='bx bx-chevron-right'></i> About us</a></li>
                                <li><a href='facilities.html'><i class='bx bx-chevron-right'></i> Facilities</a></li>
                                <li><a href='about_placement.html'><i class='bx bx-chevron-right'></i> Placements</a>
                                </li>
                                <li><a href='news-and-blog.php'><i class='bx bx-chevron-right'></i> News & Blogs</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6">
                        <div class="footer-widget">
                            <h4>Location</h4>
                            <ul>
                                <div id="map" class="map-pd">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d28364.026242912434!2d76.997067!3d10.894546!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba85abaa31dcfa9%3A0x72d5daed0d228046!2sHindusthan%20Institute%20of%20Technology!5e1!3m2!1sen!2sus!4v1772600967447!5m2!1sen!2sus"
                                        width="600" height="450" style="border-radius:20px 20px 20px 20px;"
                                        allowfullscreen="" loading="lazy"
                                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                                </div>
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
                            <p style="font-size: 12.5px;">Design & Developed by<a href="https://novacodex.in/"
                                    style="color: black;"> NovaCodex </a> ( HICAS - IT Alumni )</p>
                        </div>
                    </div>
                    <div class="col-lg-8">
                        <div class="cpr-right">
                            <ul>
                                <div class="cpr-left">
                                    <p style="font-size: 15px;">Copyright© <a href="#">Hindusthan.net</a>, All rights
                                        reserved.</p>
                                </div>

                                <!-- <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Cookie Policy</a></li> -->
                            </ul>
                            <ul class="social-list">
                                <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore" target="_blank"><i
                                            class='bx bxl-facebook'></i></a></li>
                                <li><a href="https://www.instagram.com/hindusthancolleges" target="_blank"><i
                                            class='bx bxl-instagram-alt'></i></a></li>
                                <li><a href="https://x.com/Hindusthanhce?t=cH1BisxThpHw8G_iyNXYDA&s=09"><i
                                            class='bx bxl-twitter'></i></a></li>
                                <li><a href="https://www.linkedin.com/company/hindusthanedu/" target="_blank"><i
                                            class='bx bxl-linkedin-square'></i></a></li>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const toggleBtns = document.querySelectorAll('.toggle-btn');
            const newsContainers = document.querySelectorAll('.news-container');

            async function loadNews(page = 1, container = 'latest') {
                const targetId = container + '-news';
                const el = document.getElementById(targetId);
                if (!el) return;

                el.classList.add('loading');

                try {
                    const resp = await fetch(`get_news.php?page=${encodeURIComponent(page)}&container=${encodeURIComponent(container)}`);
                    if (!resp.ok) throw new Error('Network response not ok');
                    const html = await resp.text();
                    el.innerHTML = html;

                    const urlParams = new URLSearchParams(window.location.search);
                    if (container === 'latest') {
                        urlParams.set('page', page);
                        urlParams.delete('past_page');
                    } else {
                        urlParams.set('past_page', page);
                        urlParams.delete('page');
                    }
                    history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);

                    scrollToNewsContainer(el);
                } catch (err) {
                    console.error('Failed to load news:', err);
                } finally {
                    el.classList.remove('loading');
                }
            }

            function scrollToNewsContainer(containerEl) {
                const offset = window.innerWidth <= 576 ? 60 : 80;
                const topPosition = containerEl.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: topPosition, behavior: 'smooth' });
            }

            // Pagination click (AJAX)
            document.addEventListener('click', function (e) {
                const link = e.target.closest('.pagination .page-link');
                if (!link) return;
                e.preventDefault();

                const page = link.dataset.page;
                const container = link.dataset.container ||
                    (link.closest('.news-container') ? link.closest('.news-container').id.replace('-news', '') : 'latest');

                if (!page) return;

                loadNews(page, container);
            });

            // Toggle buttons
            toggleBtns.forEach(btn => {
                btn.addEventListener('click', function () {
                    toggleBtns.forEach(b => b.classList.remove('active'));
                    this.classList.add('active');

                    const target = this.dataset.target;
                    newsContainers.forEach(c => c.classList.add('hidden'));

                    const targetContainer = document.getElementById(target + '-news');
                    if (targetContainer) {
                        targetContainer.classList.remove('hidden');
                        scrollToNewsContainer(targetContainer);
                    }

                    const urlParams = new URLSearchParams(window.location.search);
                    if (target === 'latest') {
                        urlParams.delete('past_page');
                        if (!urlParams.has('page')) urlParams.set('page', '1');
                    } else {
                        urlParams.delete('page');
                        if (!urlParams.has('past_page')) urlParams.set('past_page', '1');
                    }
                    history.pushState({}, '', `${window.location.pathname}?${urlParams.toString()}`);
                });
            });

            // Handle back/forward
            window.addEventListener('popstate', function () {
                const params = new URLSearchParams(window.location.search);
                const page = params.get('page') || '1';
                const pastPage = params.get('past_page') || null;

                if (pastPage) {
                    document.querySelectorAll('.toggle-btn').forEach(b => {
                        b.classList.toggle('active', b.dataset.target === 'past');
                    });
                    document.querySelectorAll('.news-container').forEach(c => c.classList.toggle('hidden', c.id !== 'past-news'));
                    loadNews(pastPage, 'past');
                } else {
                    document.querySelectorAll('.toggle-btn').forEach(b => {
                        b.classList.toggle('active', b.dataset.target === 'latest');
                    });
                    document.querySelectorAll('.news-container').forEach(c => c.classList.toggle('hidden', c.id !== 'latest-news'));
                    loadNews(page, 'latest');
                }
            });
        });
    </script>


    <!-- Links of JS files -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/aos.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/magnific-popup.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/main.js"></script>
</body>

</html>