<?php
require_once 'admin/includes/db.php';

// Get all alumni
$stmt = $conn->query("SELECT * FROM alumni ORDER BY graduation_year DESC");
$alumni = $stmt->fetchAll();
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

    <title>Hindusthan Institute of Technology | Top Engineering College in Coimbatore</title>
    <link rel="icon" type="image/png" href="assets/hindusthan_images/hindusthan.png">

    <!-- Add Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Add Swiper CSS -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">


    <style>
        .team-hero {
            padding: 56px 18px;
            background: #f7f8fa;
            position: relative;
        }

        /* optional subtle background image (replace url or remove) */
        .team-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background-image: url('assets/img/bg-blur.jpg');
            background-size: cover;
            background-position: center;
            opacity: 0.04;
            pointer-events: none;
            z-index: 0;
        }

        .team-hero .container {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .team-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .team-header h2 {
            margin: 0;
            font-size: 28px;
        }

        .team-header p {
            margin: 8px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        /* Swiper slide center */
        .team-swiper .swiper-slide {
            display: flex;
            justify-content: center;
            padding: 6px;
        }

        /* Card */
        .member-card {
            width: 100%;
            max-width: 320px;
            background: var(--card-bg);
            border-radius: 6px;
            overflow: visible;
            box-shadow: 0 10px 30px var(--shadow);
            text-align: center;
            padding: 0 18px 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: transform .28s, box-shadow .28s;
        }

        .member-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 22px 50px rgba(16, 24, 40, 0.12);
        }

        /* Photo container */
        .member-photo {
            width: 100%;
            height: 240px;
            overflow: hidden;
            position: relative;
            display: block;
            border-top-left-radius: 6px;
            border-top-right-radius: 6px;
            background: #fff;
        }

        .member-photo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
            filter: grayscale(100%) contrast(1.02);
            transform: scale(1.03);
            transition: transform .7s ease, filter .5s ease;

        }

        .member-card:hover .member-photo img {
            transform: scale(1.0);
            filter: grayscale(0.0) contrast(1.02) saturate(.95);
        }

        /* orange bar under image */
        .photo-accent {
            height: 12px;
            width: 70%;
            max-width: 220px;
            background: var(--accent);
            margin: -6px auto 14px;
            border-radius: 4px;
            box-shadow: 0 6px 18px rgba(255, 111, 31, 0.12);
        }

        .member-name {
            font-size: 18px;
            font-weight: 700;
            margin: 6px 0 4px;
            color: #111827;
        }

        .member-role {
            color: var(--accent);
            font-weight: 700;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .member-desc {
            color: var(--muted);
            font-size: 13px;
            line-height: 1.6;
            max-height: 92px;
            overflow: hidden;
            padding: 0 6px;
        }

        .member-meta {
            margin-top: 12px;
            display: flex;
            gap: 10px;
            justify-content: center;
            font-size: 13px;
            color: var(--muted);
            flex-wrap: wrap;
        }

        /* Social icons row */
        .member-social {
            margin-top: auto;
            display: flex;
            gap: 10px;
            justify-content: center;
            padding-top: 12px;
            width: 100%;
            border-top: 1px solid rgba(15, 23, 42, 0.04);
        }

        .social-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: transparent;
            border: 1px solid rgba(15, 23, 42, 0.06);
            color: var(--muted);
            text-decoration: none;
            transition: all .18s;
        }

        .social-btn svg {
            width: 16px;
            height: 16px;
            display: block;
        }

        .social-btn:hover {
            background: var(--accent);
            color: #ed6f26;
            border-color: var(--accent);
            transform: translateY(-4px);
        }

        /* controls */
        .swiper-button-next,
        .swiper-button-prev {
            color: #ed6f26 !important;
            background: #fff;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            box-shadow: 0 8px 18px rgba(16, 24, 40, 0.06);
            display: flex;
            align-items: center;
            justify-content: center;
            display: none;
        }

        .swiper-pagination-bullet {
            background: rgba(11, 27, 58, 0.12);
            opacity: 1;
        }

        .swiper-pagination-bullet-active {
            background: var(--accent);
            transform: scale(1.08);
        }

        /* responsive */
        @media (max-width:1100px) {
            .member-card {
                max-width: 280px;
            }
        }

        @media (max-width:820px) {
            .member-card {
                max-width: 260px;
            }

            .member-photo {
                height: 200px;
            }
        }

        @media (max-width:560px) {
            .member-photo {
                height: 180px;
            }

            .photo-accent {
                width: 60%;
            }
        }

        /* Truncation helper used by the read-more toggle */
        .member-desc {
            transition: max-height .36s ease, opacity .28s ease;
            overflow: hidden;
            max-height: 92px;
            /* default collapsed max height (matches earlier) */
            opacity: 1;
        }

        /* When expanded we remove the height limit */
        .member-desc.expanded {
            max-height: 2000px;
            /* large enough to show full text */
            overflow: visible;
        }

        /* Optional subtle fade at bottom when collapsed */
        .member-desc.collapsed-fade {
            position: relative;
        }

        .member-desc.collapsed-fade::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            height: 34px;
            pointer-events: none;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0), #fff);
        }


        /* Read-more button */
        .read-more {
            background: none;
            border: 0;
            color: var(--accent);
            cursor: pointer;
            font-weight: 700;
            padding-top: 8px;
            font-size: 13px;
            display: inline-block;
        }
    </style>
</head>

<body>

    </head>

    <body>
        <!-- Start Top Navbar Area -->
        <div class="top-area">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-5 col-12 col-xm-12">
                        <div class="top-left-items">
                            <ul>
                                <!-- <li><i class='bx bxs-time'></i> Mon - Sat : 9:00 AM - 06:00 PM</li> -->
                                <li><i class='bx bxs-envelope'></i> <a href="mailto: hit.office@hindusthan.net">contact
                                        :
                                        hit.office@hindusthan.net</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-7 col-12 col-xm-12">
                        <div class="top-right-items">
                            <ul>
                                <li><a href='#'>Exam Result Even Sem</a></li>
                                <!-- <li><a href='student-activities.html'>Students</a></li> -->
                                <!-- <li><a href='alumni.php'>Alumni</a></li> -->
                                <li><a href='https://www.instagram.com/hindusthancolleges'>Media</a></li>
                                <li><a href='contact-us.html'>contact-us</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Top Navbar Area -->

        <!-- preloader -->
        <div class="preloader-container" id="preloader">
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
            <div class="preloader-dot"></div>
        </div>
        <!-- preloader -->

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
                                <a href="javascript:void(0)" class="dropdown-toggle nav-link">
                                    About
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="nav-item"><a class='nav-link' href='about-us.html'>About Us</a></li>
                                    <li class="nav-item"><a class='nav-link' href='news-and-blog.php'>News and Blog</a>
                                    </li>
                                    <li class="nav-item"><a class='nav-link' href='blog-details.php'>Blog Details</a>
                                    </li>

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
                                                    <p class="mega-desc">Design, manufacturing, and mechanics of flight.
                                                    </p>
                                                </a>
                                                <a href="computer-science-and-engineering.html" class="mega-link">
                                                    <h6 class="mega-title">Computer Science and Engineering</h6>
                                                    <p class="mega-desc">Software dev, algorithms, and logic systems.
                                                    </p>
                                                </a>
                                                <a href="mechanical-engineering.html" class="mega-link">
                                                    <h6 class="mega-title">Mechanical Engineering</h6>
                                                    <p class="mega-desc">Design and manufacturing of mechanical systems.
                                                    </p>
                                                </a>
                                                <a href="m-e-vlsi-design.html" class="mega-link">
                                                    <h6 class="mega-title">M.E. VLSI Design</h6>
                                                    <p class="mega-desc">Microchip architecture and system-on-chip
                                                        design.
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mega-col">
                                                <a href="artificial-intelligence-and-data-science.html"
                                                    class="mega-link">
                                                    <h6 class="mega-title">Artificial Intelligence & Data Science</h6>
                                                    <p class="mega-desc">Machine learning, analytics, and big data.</p>
                                                </a>
                                                <a href="information-technology.html" class="mega-link">
                                                    <h6 class="mega-title">Information Technology</h6>
                                                    <p class="mega-desc">Network systems, security, and IT management.
                                                    </p>
                                                </a>
                                                <a href="master-of-business-administration.html" class="mega-link">
                                                    <h6 class="mega-title">Master of Business Administration</h6>
                                                    <p class="mega-desc">Business leadership and corporate strategies.
                                                    </p>
                                                </a>
                                                <a href="science-and-humanities.html" class="mega-link">
                                                    <h6 class="mega-title">Science & Humanities</h6>
                                                    <p class="mega-desc">Foundational sciences and general studies.</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mega-col">
                                                <a href="electronics-and-communication-engineering.html"
                                                    class="mega-link">
                                                    <h6 class="mega-title">Electronics and Communication Engineering
                                                    </h6>
                                                    <p class="mega-desc">Circuit design and electronic devices.</p>
                                                </a>
                                                <a href="pharmaceutical-technology.html" class="mega-link">
                                                    <h6 class="mega-title">Pharmaceutical Technology</h6>
                                                    <p class="mega-desc">Drug formulation, analysis, and healthcare.</p>
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
                                    <li class="nav-item"><a class='nav-link' href='https://apply.hindusthan.net/'
                                            target="_blank">Admissions</a></li>
                                    <li class="nav-item"><a class='nav-link' href='admission_policy.html'>Admission
                                            Policy</a>
                                    </li>
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
                                                <a href="about_placement.html" class="mega-link">
                                                    <h6 class="mega-title">About Placement</h6>
                                                    <p class="mega-desc">Overview of our training and placement cell.
                                                    </p>
                                                </a>
                                                <a href="placement-details.html" class="mega-link">
                                                    <h6 class="mega-title">Placement Details</h6>
                                                    <p class="mega-desc">Detailed statistics and recruitment
                                                        information.
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mega-col">
                                                <a href="placement .pdf" class="mega-link">
                                                    <h6 class="mega-title">Placement 2025</h6>
                                                    <p class="mega-desc">Record of placements for the year 2025.</p>
                                                </a>
                                                <a href="placement .pdf" class="mega-link">
                                                    <h6 class="mega-title">Placement 2024</h6>
                                                    <p class="mega-desc">Record of placements for the year 2024.</p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mega-col">
                                                <a href="placement .pdf" class="mega-link">
                                                    <h6 class="mega-title">Placement 2023</h6>
                                                    <p class="mega-desc">Record of placements for the year 2023.</p>
                                                </a>
                                                <a href="placement .pdf" class="mega-link">
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
                                                <a href="online-fee-payment.html" class="mega-link">
                                                    <h6 class="mega-title">Online Fee Payment</h6>
                                                    <p class="mega-desc">Pay tuition and other institutional fees
                                                        securely
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
                                                    <p class="mega-desc">National Institutional Ranking Framework
                                                        details
                                                        and reports.</p>
                                                </a>

                                                <a href="e-content.html" class="mega-link">
                                                    <h6 class="mega-title">E-Content</h6>
                                                    <p class="mega-desc">Digital learning materials and academic
                                                        resources.
                                                    </p>
                                                </a>
                                            </div>
                                            <div class="col-lg-4 col-md-6 mega-col">

                                                <a href="nba-dcp.pdf" class="mega-link">
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
                                        <a class="nav-link" href="assets\hit\pdf_folder\HiTech Campus Security Audit Checklist.pdf" target="_blank">
                                            Campus Security Audit (PDF)
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link active" href="alumni.php">Alumni</a>
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
                            <a class='nav-link' href='contact-us.html'>
                                Contact
                            </a>
                        </li> -->
                        </ul>
                        <div class="others-option d-flex align-items-center">
                            <div class="option-item">
                                <div class="nav-btn">
                                    <a class='default-btn' href='https://apply.hindusthan.net/'
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

        <!-- Start Responsive Navbar Area -->
        <div class="responsive-navbar offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1"
            id="navbarOffcanvas">
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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            About
                        </button>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordionAbout">
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
                                            href='artificial-intelligence-and-data-science.html'>Artificial Intelligence
                                            &
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
                                        <a class='accordion-link' href='pharmaceutical-technology.html'>Pharmaceutical
                                            Technology</a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='mechanical-engineering.html'>Mechanical
                                            Engineering</a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='master-of-business-administration.html'>Master
                                            of
                                            Business Administration</a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='m-e-computer-science-and-engineering.html'>M.E.
                                            Computer Science and Engineering</a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='m-e-vlsi-design.html'>M.E. VLSI Design</a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='science-and-humanities.html'>Science &
                                            Humanities</a>
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
                                        <a class='accordion-link' href='https://apply.hindusthan.net/' target="_blank">
                                            Admissions
                                        </a>
                                    </div>
                                    <div class="accordion-item">
                                        <a class='accordion-link' href='how-to-apply.html'>
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
                        <div id="collapsePlacement" class="accordion-collapse collapse"
                            data-bs-parent="#navbarAccordion">
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
                                        <a class='accordion-link' href='online-fee-payment.html'>Online Fee Payment</a>
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
                                        <a class='accordion-link' href='nba-dcp.pdf'>NBA / DCP</a>
                                    </div>
                                    <div class="accordion-item">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseAudit"
                                            aria-expanded="false" aria-controls="collapseAudit">
                                            Audit Report (NBA / NAAC)
                                        </button>
                                        <div id="collapseAudit" class="accordion-collapse collapse">
                                            <div class="accordion-body">
                                                <div class="accordion">
                                                    <div class="accordion-item"><a class='accordion-link'
                                                            href='assets/hit/pdf_folder/Audit_pdf/Audit 2024-25.pdf'
                                                            target="_blank">Audit
                                                            Report
                                                            2024 – 2025</a></div>
                                                    <div class="accordion-item"><a class='accordion-link'
                                                            href='assets/hit/pdf_folder/Audit_pdf/Audit 2023-24.pdf'
                                                            target="_blank">Audit
                                                            Report
                                                            2023 – 2024</a></div>
                                                    <div class="accordion-item"><a class='accordion-link'
                                                            href='assets/hit/pdf_folder/Audit_pdf/Audit 2022-23.pdf'
                                                            target="_blank">Audit
                                                            Report
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
                        <button class="accordion-button collapsed active" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseCommittees" aria-expanded="false"
                            aria-controls="collapseCommittees">
                            Committees
                        </button>
                        <div id="collapseCommittees" class="accordion-collapse collapse"
                            data-bs-parent="#navbarAccordion">
                            <div class="accordion-body">
                                <div class="accordion" id="navbarAccordionCommittees">
                                    <div class="accordion-item"><a class='accordion-link'
                                            href='statutory.html'>Statutory</a></div>
                                    <div class="accordion-item"><a class='accordion-link'
                                            href='non-statutory.html'>Non-Statutory</a></div>
                                    <div class="accordion-item"><a class='accordion-link' href='iqac.html'>IQAC</a>
                                    </div>
                                    <div class="accordion-item"><a class='accordion-link'
                                            href='research-cell.html'>Research
                                            Cell</a></div>
                                    <div class="accordion-item"><a class='accordion-link'
                                            href='assets\hit\pdf_folder\HiTech Campus Security Audit Checklist.pdf' target="_blank">Campus Security Audit
                                            (PDF)</a></div>
                                    <div class="accordion-item"><a class='accordion-link active'
                                            href='alumni.php'>Alumni</a>
                                    </div>
                                    <div class="accordion-item"><a class='accordion-link' href='posh-cell.html'>POSH
                                            Cell</a></div>
                                    <div class="accordion-item"><a class='accordion-link'
                                            href='reports.html'>Reports</a>
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
                        <a class='default-btn' href='https://apply.hindusthan.net/' target="_blank">Admission</a>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Responsive Navbar Area -->

        <!-- Start hindusthan.net Searchbar Area -->
        <div class="hindusthan.net offcanvas offcanvas-start" data-bs-backdrop="static" tabindex="-1"
            id="staticBackdrop">
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
                            <a href="mailto:info@hindusthan.net">contact : info@hindusthan.net</a>
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
        <div class="section-banner bg-5">
            <div class="container">
                <div class="banner-spacing">
                    <div class="section-info">
                        <h2 data-aos="fade-zoom-in" data-aos-delay="100">Alumni</h2>
                        <p data-aos="fade-zoom-in" data-aos-delay="200">A strong network of successful graduates
                            contributing to society and supporting the growth of future Hindusthanians.</p>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Section Banner Area -->

        <!-- Start About Area -->
        <div class="about-alumni ptb-100">
            <div class="container-fluid p-0">
                <div class="row g-0 align-items-center">
                    <div class="col-lg-7">
                        <div class="content" data-aos="fade-up" data-aos-delay="100">
                            <div class="sub-title">
                                <i class='bx bxs-graduation'></i>
                                <p>Hindusthanian's</p>
                            </div>
                            <h2>Hindusthan Alumni Stories</h2>
                            <p>At Hindusthan Educational Institutions, our alumni don’t just graduate—they go on to
                                lead, innovate, and inspire. Each story is a reflection of hard work, ambition, and the
                                strong academic foundation they built here.</p>
                            <p> From startup founders and industry leaders to researchers, educators, and change-makers,
                                their journeys highlight the global impact of a Hindusthan education.</p>
                            <a class='default-btn' href='alumni_form.php'>Register For Hindusthan Alumni</a>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="image" data-aos="fade-zoom-in" data-aos-delay="100">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End About Area -->

        <!-- Start Alumni Area -->




        <div class="team-hero" data-aos="fade-up" data-aos-delay="100">
            <div class="container">
                <div class="team-header">
                    <h2>Our Alumni Stories</h2>
                    <p>Celebrating the achievements and journeys of our distinguished alumni</p>
                </div>

                <!-- Swiper -->
                <div class="swiper team-swiper">
                    <div class="swiper-wrapper">
                        <?php foreach ($alumni as $alum):
                            $id = htmlspecialchars($alum['id'] ?? spl_object_hash((object) $alum));
                            $name = htmlspecialchars($alum['name'] ?? '—');
                            $role = htmlspecialchars($alum['current_position'] ?? '');
                            $company = htmlspecialchars($alum['company'] ?? '');
                            $course = htmlspecialchars($alum['course'] ?? '');
                            $year = htmlspecialchars($alum['graduation_year'] ?? '');
                            $desc = trim($alum['message'] ?? '');
                            $linkedin = htmlspecialchars($alum['linkedin_url'] ?? '');
                            $email = htmlspecialchars($alum['email'] ?? '');
                            $phone = htmlspecialchars($alum['phone'] ?? '');
                            $photo = !empty($alum['photo']) ? htmlspecialchars($alum['photo']) : 'assets/img/default-avatar.jpg';
                            ?>
                            <div class="swiper-slide" role="group" aria-label="<?php echo $name; ?>">
                                <article class="member-card" aria-labelledby="member-<?php echo $id; ?>">
                                    <div class="member-photo" aria-hidden="false">
                                        <img loading="lazy" decoding="async" src="<?php echo $photo; ?>"
                                            alt="<?php echo $name; ?> photo">
                                    </div>


                                    <div class="photo-accent" aria-hidden="true"></div>

                                    <div style="padding-top:4px;">
                                        <div id="member-<?php echo $id; ?>" class="member-name" style="color: #ed6f26;">
                                            <?php echo $name; ?>
                                        </div>
                                        <?php if ($role): ?>
                                            <div class="member-role"><?php echo $role; ?></div><?php endif; ?>

                                        <div class="member-desc" id="desc-<?php echo $id; ?>">
                                            <?php
                                            if (!empty($desc)) {
                                                echo nl2br(htmlspecialchars($desc));
                                            } else {
                                                $parts = [];
                                                if ($company)
                                                    $parts[] = $company;
                                                if ($course)
                                                    $parts[] = $course;
                                                if ($year)
                                                    $parts[] = ($year ? "Class of $year" : '');
                                                echo htmlspecialchars(implode(' • ', array_filter($parts)));
                                            }
                                            ?>
                                        </div>
                                        <div class="member-meta" aria-hidden="false">
                                            <span style=" font-weight: 700 !important;">Company :</span>
                                            <?php if ($company): ?>
                                                <div><?php echo htmlspecialchars($company); ?></div><?php endif; ?>
                                        </div>


                                        <div class="member-meta" aria-hidden="false"><span
                                                style=" font-weight: 700 !important;">Studied Department:</span>
                                            <?php if ($course): ?>
                                                <div><?php echo htmlspecialchars($course); ?></div><?php endif; ?>
                                            <?php if ($year): ?>
                                                <div><span style="color: #ed6f26;"><?php echo htmlspecialchars($year); ?></span>
                                                </div><?php endif; ?>
                                        </div>
                                    </div>

                                    <div class="member-social" aria-label="social links">
                                        <?php if ($linkedin): ?>
                                            <a class="social-btn" href="<?php echo $linkedin; ?>" target="_blank"
                                                rel="noopener noreferrer" aria-label="LinkedIn of <?php echo $name; ?>">
                                                <!-- LinkedIn icon -->
                                                <svg viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M4.98 3.5C4.98 4.8807 3.8807 6 2.5 6C1.1193 6 0 4.8807 0 3.5C0 2.1193 1.1193 1 2.5 1C3.8807 1 4.98 2.1193 4.98 3.5Z" />
                                                    <path d="M0 24V7.5H5V24H0Z" />
                                                    <path
                                                        d="M7.5 7.5H12V10.2C12.7 9.15 14.2 7.5 17.1 7.5C21.4 7.5 24 10.1 24 15.3V24H19V16.2C19 14.1 18.5 12.3 16 12.3C13.5 12.3 12.9 13.9 12.9 16V24H7.5V7.5Z" />
                                                </svg>
                                            </a>
                                        <?php endif; ?>


                                    </div>
                                </article>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- pagination + nav -->
                    <div class="swiper-pagination" aria-hidden="true"></div>
                    <div class="swiper-button-next" aria-label="Next"></div>
                    <div class="swiper-button-prev" aria-label="Previous"></div>
                </div>
            </div>
        </div>




        <!-- End Alumni Area -->

        <!-- Start Footer Area -->
        <div class="footer-area">
            <div class="footer-top-info pb-100">
                <div class="content">
                    <div class="image">
                        <img src="assets/hindusthan_images/hindusthan_logo.png" style="height: 80px;width: 80px;"
                            alt="image">
                    </div>

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
                                    <p>City Campus, Nava India, Avinashi Road, Coimbatore - 641028 & Valley Campus,
                                        Pollachi Highway, Coimbatore - 641032, Tamilnadu, India.</p>
                                    <div>
                                        <a href="tel:+91 422 - 4440555" style="color: #868786;">+91 422 - 4440555</a>
                                    </div>
                                    <div>
                                        <a href="tel:+91 80983 33333" style="color: white;">+91 80983 33333</a>
                                    </div>
                                    <div>
                                        <a href="mailto:info@hindusthan.net"
                                            style="color: white;">info@hindusthan.net</a>
                                    </div>

                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4>Our Campus</h4>
                                <ul>
                                    <li><a href='https://hicas.ac.in/' target="_blank"><i
                                                class='bx bx-chevron-right'></i>
                                            Arts & Science</a></li>
                                    <li><a href='https://hicet.ac.in/' target="_blank"><i
                                                class='bx bx-chevron-right'></i>
                                            Engineering & Technology</a></li>
                                    <li><a href='http://hit.edu.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                            Institute of Technology</a></li>
                                    <li><a href='https://hindusthan.net/hce/' target="_blank"><i
                                                class='bx bx-chevron-right'></i> College of Education</a></li>
                                    <li><a href='https://hsoa.ac.in/' target="_blank"><i
                                                class='bx bx-chevron-right'></i>
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
                                    <li><a href='https://hisac.ac.in/' target="_blank"><i
                                                class='bx bx-chevron-right'></i>
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
                                    <li><a href='how-to-apply.html'><i class='bx bx-chevron-right'></i> Apply For
                                            Admissions</a></li>
                                    <li><a href='about-us.html'><i class='bx bx-chevron-right'></i> About us</a></li>
                                    <li><a href='undergraduate.html'><i class='bx bx-chevron-right'></i> UG Course</a>
                                    </li>
                                    <li><a href='graduate.html'><i class='bx bx-chevron-right'></i> PG Course</a></li>
                                    <li><a href='the-campus-experience.html'><i class='bx bx-chevron-right'></i> Campus
                                            Experience</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6 col-md-6">
                            <div class="footer-widget">
                                <h4>Location</h4>
                                <ul>
                                    <div id="map" class="map-pd">
                                        <iframe
                                            src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d62661.52189754748!2d76.99315200000001!3d11.012712!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5265d0f0e202dd%3A0x6c1cb249318c77f!2shicas!5e0!3m2!1sen!2sin!4v1746593040542!5m2!1sen!2sin"
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
                                        <p style="font-size: 15px;">Copyright© <a href="#">Hindusthan.net</a>, All
                                            rights reserved.</p>
                                    </div>

                                    <!-- <li><a href="#">Privacy Policy</a></li>
                                    <li><a href="#">Cookie Policy</a></li> -->
                                </ul>
                                <ul class="social-list">
                                    <li><a href="https://www.facebook.com/Hindusthan.College.Coimbatore"
                                            target="_blank"><i class='bx bxl-facebook'></i></a></li>
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

        <!-- existing code  -->

        <!-- start  Floating Contact Button -->
        <div class="floating-contact">
            <div class="main-button" onclick="toggleContactOptions()">
                <i class='bx bx-message-dots'></i>
            </div>
            <div class="contact-options" id="contactOptions">
                <a href="https://wa.me/918300604896?text=Hello%21%0AI%E2%80%99m%20interested%20in%20knowing%20more%20about%20your%20admissions.%0ACould%20you%20please%20share%20the%20details%20about%20courses%2C%20fees%2C%20eligibility%2C%20and%20the%20admission%20process%3F%0A%0AExcited%20to%20explore%20the%20opportunities%20at%20your%20institution.%20Thank%20you%21"
                    class="contact-option" target="_blank">
                    <i class='bx bxl-whatsapp'></i>
                    <span>WhatsApp Message</span>
                </a>
                <a href="https://apply.hindusthan.net/" class="contact-option">
                    <i class='bx bx-book-content'></i>
                    <span>Admission Enquiry</span>
                </a>
                <a href="contact-us.html" class="contact-option">
                    <i class='bx bx-envelope'></i>
                    <span>Quick Contact</span>
                </a>
            </div>
        </div>

        <!--end Floating Contact Button -->



        <!-- Links of JS files -->
        <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/aos.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/main.js"></script>
        <script src="assets/js/messagefloating.js"></script>


        <script src="https://unpkg.com/swiper@9/swiper-bundle.min.js"></script>
        <script>
            (function () {
                // Ensure DOM ready
                function ready(fn) {
                    if (document.readyState !== 'loading') fn();
                    else document.addEventListener('DOMContentLoaded', fn);
                }

                ready(function () {
                    // --- Safe Swiper init: destroy previous instance if exists ---
                    // make var global-safe to allow inspect in console if needed
                    if (window._teamSwiperInstance && typeof window._teamSwiperInstance.destroy === 'function') {
                        try {
                            window._teamSwiperInstance.destroy(true, true);
                        } catch (e) {
                            /* ignore */
                        }
                        window._teamSwiperInstance = null;
                    }

                    // Query container selector (update if you changed class)
                    const selector = '.team-swiper';
                    const elm = document.querySelector(selector);
                    if (!elm) {
                        console.warn('Swiper: container not found for selector', selector);
                        return;
                    }

                    // Initialize Swiper with observer options to adapt to DOM/CSS changes
                    window._teamSwiperInstance = new Swiper(selector, {
                        slidesPerView: 3,
                        spaceBetween: 24,
                        loop: true,
                        speed: 700,
                        autoplay: {
                            delay: 3600,
                            disableOnInteraction: false
                        },
                        navigation: {
                            nextEl: '.swiper-button-next',
                            prevEl: '.swiper-button-prev'
                        },
                        pagination: {
                            el: '.swiper-pagination',
                            clickable: true
                        },
                        observer: true, // watch for changes in swiper container
                        observeParents: true, // watch for changes in parents (useful when hidden then shown)
                        watchOverflow: true, // if not enough slides, disable navigation
                        breakpoints: {
                            320: {
                                slidesPerView: 1,
                                spaceBetween: 12
                            },
                            640: {
                                slidesPerView: 2,
                                spaceBetween: 16
                            },
                            980: {
                                slidesPerView: 3,
                                spaceBetween: 20
                            }
                        }
                    });

                    // Pause/resume autoplay on hover (desktop)
                    elm.addEventListener('mouseenter', () => {
                        if (window._teamSwiperInstance && window._teamSwiperInstance.autoplay) window._teamSwiperInstance.autoplay.stop();
                    });
                    elm.addEventListener('mouseleave', () => {
                        if (window._teamSwiperInstance && window._teamSwiperInstance.autoplay) window._teamSwiperInstance.autoplay.start();
                    });

                    // Read-more setup: adds button only if overflow
                    function setupDesc(descEl, uid) {
                        if (!descEl) return;
                        const collapsedH = 92;
                        // ensure initial collapsed state
                        descEl.classList.add('collapsed-fade');
                        descEl.style.maxHeight = collapsedH + 'px';

                        // measure full height (temporarily remove limit)
                        const prevMax = descEl.style.maxHeight;
                        descEl.style.maxHeight = 'none';
                        const fullH = descEl.scrollHeight;
                        descEl.style.maxHeight = prevMax;

                        const parent = descEl.parentElement;
                        if (!parent) return;
                        // remove any existing button with same uid to avoid duplicates
                        const existing = parent.querySelector('.read-more[data-target="' + uid + '"]');
                        if (fullH <= collapsedH) {
                            if (existing) existing.remove();
                            // keep collapsed-fade off if no overflow so text shows fully on narrow content
                            descEl.classList.remove('collapsed-fade');
                            descEl.style.maxHeight = 'none';
                            return;
                        }

                        // ensure collapsed initially
                        descEl.classList.add('collapsed-fade');
                        descEl.style.maxHeight = collapsedH + 'px';

                        if (!existing) {
                            const btn = document.createElement('button');
                            btn.type = 'button';
                            btn.className = 'read-more';
                            btn.setAttribute('data-target', uid);
                            btn.textContent = 'Read more';
                            btn.addEventListener('click', function () {
                                if (descEl.classList.contains('expanded')) {
                                    descEl.classList.remove('expanded');
                                    descEl.classList.add('collapsed-fade');
                                    descEl.style.maxHeight = collapsedH + 'px';
                                    this.textContent = 'Read more';
                                    if (window._teamSwiperUnique && typeof window._teamSwiperUnique.update === 'function') window._teamSwiperUnique.update();
                                } else {
                                    descEl.classList.add('expanded');
                                    descEl.classList.remove('collapsed-fade');
                                    descEl.style.maxHeight = descEl.scrollHeight + 'px';
                                    this.textContent = 'Show less';
                                    if (window._teamSwiperUnique && typeof window._teamSwiperUnique.update === 'function') window._teamSwiperUnique.update();
                                }
                            });
                            parent.appendChild(btn);
                        } else {
                            existing.textContent = 'Read more';
                        }
                    }

                    function initAllDescriptions() {
                        document.querySelectorAll('.member-desc').forEach((descEl, idx) => {
                            let uid = 'auto-' + idx;
                            if (descEl.id && descEl.id.indexOf('desc-') === 0) uid = descEl.id.replace('desc-', '');
                            const parent = descEl.closest('.member-card');
                            const label = parent && parent.getAttribute('aria-labelledby');
                            if (label && label.indexOf('member-') === 0) uid = label.replace('member-', '');
                            setupDesc(descEl, uid);
                        });
                    }

                    // initial
                    initAllDescriptions();

                    // re-run on swiper events that may change layout
                    if (window._teamSwiperUnique) {
                        window._teamSwiperUnique.on('transitionEnd resize slideChange', initAllDescriptions);
                    }

                    // re-run on resize (debounced)
                    let timer = null;
                    window.addEventListener('resize', () => {
                        clearTimeout(timer);
                        timer = setTimeout(initAllDescriptions, 180);
                    });

                    // setup all descriptions on first load
                    function initAllDescriptions() {
                        // select all desc elements inside slides
                        document.querySelectorAll('.member-card .member-desc').forEach((descEl, idx) => {
                            // attempt to identify a uid from nearby ID or data attribute
                            // preferred: desc id like "desc-<uid>"
                            let uid = 'auto-' + idx;
                            if (descEl.id && descEl.id.indexOf('desc-') === 0) uid = descEl.id.replace('desc-', '');
                            else {
                                // fallback: use parent's aria-labelledby or generate
                                const parent = descEl.closest('.member-card');
                                const label = parent && parent.getAttribute('aria-labelledby');
                                if (label && label.indexOf('member-') === 0) uid = label.replace('member-', '');
                            }
                            setupDesc(descEl, uid);
                        });
                    }





                }); // ready
            })();
        </script>

    </body>

</html>