<?php
session_start();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // CSRF check
    if (!isset($_POST['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $_POST['csrf_token'])) {
        header("Location: contact-us.php?status=error");
        exit();
    }

    // Google reCAPTCHA Verification (Production Keys)
    $recaptcha_secret = '6LejcI0sAAAAAEiPnJqr-iudKWDQOLK_jON7PwUo';
    $recaptcha_response = $_POST['g-recaptcha-response'] ?? '';
    
    if (empty($recaptcha_response)) {
        header("Location: contact-us.php?status=recaptcha_error");
        exit();
    }
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret' => $recaptcha_secret,
        'response' => $recaptcha_response
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $recaptcha_result = json_decode($response);
    if (!$recaptcha_result || !$recaptcha_result->success) {
        header("Location: contact-us.php?status=recaptcha_error");
        exit();
    }

    $conn = new mysqli("localhost", "root", "", "hit");
    if ($conn->connect_error) {
        header("Location: contact-us.php?status=error");
        exit();
    }

    $form_type = $_POST['form_type'] ?? 'contact';
    $date = date('Y-m-d H:i:s');

    if ($form_type === 'contact') {
        // Handle Contact Form
        $name = trim(strip_tags($_POST['name'] ?? ''));
        $email = trim(filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL));
        $phone = trim(strip_tags($_POST['phone'] ?? ''));
        $subject = trim(strip_tags($_POST['subject'] ?? ''));
        $message = trim(strip_tags($_POST['message'] ?? ''));

        if (empty($name) || empty($email) || empty($phone) || empty($subject) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: contact-us.php?status=error");
            exit();
        }

        $sql = "INSERT INTO enquiries (name, email, phone, subject, message, created_at) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssss", $name, $email, $phone, $subject, $message, $date);
            if ($stmt->execute()) {
                header("Location: contact-us.php?status=success");
            } else {
                header("Location: contact-us.php?status=error");
            }
            $stmt->close();
        } else {
            header("Location: contact-us.php?status=error");
        }
    } elseif ($form_type === 'grievance') {
        // Handle Grievance Form
        $name = trim(strip_tags($_POST['g_name'] ?? ''));
        $roll_number = trim(strip_tags($_POST['g_roll_number'] ?? ''));
        $department = trim(strip_tags($_POST['g_department'] ?? ''));
        $mobile_number = trim(strip_tags($_POST['g_mobile_number'] ?? ''));
        $email = trim(filter_var($_POST['g_email'] ?? '', FILTER_SANITIZE_EMAIL));
        $grievance_type = trim(strip_tags($_POST['g_grievance_type'] ?? ''));
        $query = trim(strip_tags($_POST['g_query'] ?? ''));

        if (empty($name) || empty($roll_number) || empty($department) || empty($mobile_number) || empty($email) || empty($grievance_type) || empty($query) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            header("Location: contact-us.php?status=error");
            exit();
        }

        $sql = "INSERT INTO student_grievances (name, roll_number, department, mobile_number, email, grievance_type, query, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        if ($stmt) {
            $stmt->bind_param("ssssssss", $name, $roll_number, $department, $mobile_number, $email, $grievance_type, $query, $date);
            if ($stmt->execute()) {
                header("Location: contact-us.php?status=success");
            } else {
                header("Location: contact-us.php?status=error");
            }
            $stmt->close();
        } else {
            header("Location: contact-us.php?status=error");
        }
    } else {
        header("Location: contact-us.php?status=error");
    }

    $conn->close();
    exit();
}
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

    <!-- Google reCAPTCHA API -->
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
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
                            <li><a href='contact-us.php'>Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Top Navbar Area -->

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
                                <li class="nav-item"><a class='nav-link' href='about-us.html'>About
                                        Us</a></li>
                                <li class="nav-item"><a class='nav-link' href='news-and-blog.php'>News
                                        and Blog</a></li>
                                <li class="nav-item"><a class='nav-link' href='blog-details.php'>Blog
                                        Details</a></li>

                                <li class="nav-item"><a class='nav-link' href='facilities.html'>Facilities</a></li>
                                <li class="nav-item"><a class='nav-link' href='gallery.html'>Gallery</a>
                                </li>
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
                                                <p class="mega-desc">Design, manufacturing, and
                                                    mechanics of flight.</p>
                                            </a>
                                            <a href="computer-science-and-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Computer Science and Engineering
                                                </h6>
                                                <p class="mega-desc">Software dev, algorithms, and logic
                                                    systems.</p>
                                            </a>
                                            <a href="mechanical-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Mechanical Engineering</h6>
                                                <p class="mega-desc">Design and manufacturing of
                                                    mechanical systems.</p>
                                            </a>
                                            
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="artificial-intelligence-and-data-science.html" class="mega-link">
                                                <h6 class="mega-title">Artificial Intelligence & Data
                                                    Science</h6>
                                                <p class="mega-desc">Machine learning, analytics, and
                                                    big data.</p>
                                            </a>
                                            <a href="information-technology.html" class="mega-link">
                                                <h6 class="mega-title">Information Technology</h6>
                                                <p class="mega-desc">Network systems, security, and IT
                                                    management.</p>
                                            </a>
                                            <a href="master-of-business-administration.html" class="mega-link">
                                                <h6 class="mega-title">Master of Business Administration
                                                </h6>
                                                <p class="mega-desc">Business leadership and corporate
                                                    strategies.</p>
                                            </a>
                                            
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="electronics-and-communication-engineering.html" class="mega-link">
                                                <h6 class="mega-title">Electronics and Communication
                                                    Engineering</h6>
                                                <p class="mega-desc">Circuit design and electronic
                                                    devices.</p>
                                            </a>
                                            
                                            <a href="m-e-computer-science-and-engineering.html" class="mega-link">
                                                <h6 class="mega-title">M.E. Computer Science and
                                                    Engineering</h6>
                                                <p class="mega-desc">Advanced postgraduate computing
                                                    logic.</p>
                                            </a>
                                            <a href="m-e-vlsi-design.html" class="mega-link">
                                                <h6 class="mega-title">M.E. VLSI Design</h6>
                                                <p class="mega-desc">Microchip architecture and
                                                    system-on-chip design.
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
                                            <a href="about_placement.html" class="mega-link">
                                                <h6 class="mega-title">About Placement</h6>
                                                <p class="mega-desc">Overview of our training and
                                                    placement cell.</p>
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
                                                <p class="mega-desc">Record of placements for the year
                                                    2025.</p>
                                            </a>
                                            <a href="placement .pdf" class="mega-link">
                                                <h6 class="mega-title">Placement 2024</h6>
                                                <p class="mega-desc">Record of placements for the year
                                                    2024.</p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="placement .pdf" class="mega-link">
                                                <h6 class="mega-title">Placement 2023</h6>
                                                <p class="mega-desc">Record of placements for the year
                                                    2023.</p>
                                            </a>
                                            <a href="placement .pdf" class="mega-link">
                                                <h6 class="mega-title">Placement 2022</h6>
                                                <p class="mega-desc">Record of placements for the year
                                                    2022.</p>
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
                                                <p class="mega-desc">Controller of Examinations portal
                                                    and academic
                                                    examination updates.</p>
                                            </a>

                                            <a href="http://ecampus.hicet.ac.in/ecampus/" class="mega-link">
                                                <h6 class="mega-title">E Campus Login</h6>
                                                <p class="mega-desc">Access the student E-Campus portal
                                                    for academic
                                                    information.</p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="online-fee-payment.html" class="mega-link">
                                                <h6 class="mega-title">Online Fee Payment</h6>
                                                <p class="mega-desc">Pay tuition and other institutional
                                                    fees securely
                                                    online.</p>
                                            </a>

                                            <a href="exam-fee.html" class="mega-link">
                                                <h6 class="mega-title">Exam Fee</h6>
                                                <p class="mega-desc">Pay examination fees and check
                                                    related
                                                    notifications.</p>
                                            </a>
                                        </div>

                                        <div class="col-lg-4 col-md-6 mega-col">
                                            <a href="nirf.html" class="mega-link">
                                                <h6 class="mega-title">NIRF</h6>
                                                <p class="mega-desc">National Institutional Ranking
                                                    Framework details
                                                    and reports.</p>
                                            </a>

                                            <a href="e-content.html" class="mega-link">
                                                <h6 class="mega-title">E-Content</h6>
                                                <p class="mega-desc">Digital learning materials and
                                                    academic resources.
                                                </p>
                                            </a>
                                        </div>
                                        <div class="col-lg-4 col-md-6 mega-col">

                                            <a href="nba_dcp.html" class="mega-link">
                                                <h6 class="mega-title">NBA / DCP</h6>
                                                <p class="mega-desc">
                                                    NBA / DCP accreditation related official documents
                                                    and reports.
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
                            <a class='nav-link active' href='contact-us.php'>
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
                                        href='artificial-intelligence-and-data-science.html'>Artificial
                                        Intelligence &
                                        Data Science</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link'
                                        href='electronics-and-communication-engineering.html'>Electronics
                                        and
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
                                    <a class='accordion-link' href='m-e-vlsi-design.html'>M.E. VLSI
                                        Design</a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                </div>


                <div class="accordion-item">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                        data-bs-target="#collapseAdmissions" aria-expanded="false" aria-controls="collapseAdmissions">
                        Admissions
                    </button>
                    <div id="collapseAdmissions" class="accordion-collapse collapse" data-bs-parent="#navbarAccordion">
                        <div class="accordion-body">
                            <div class="accordion" id="navbarAccordionAdmissions">
                                <div class="accordion-item">
                                    <a class='accordion-link' href='https://admission.hindusthan.net/'
                                        target="_blank">Admissions</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='admission_policy.html'>Admission
                                        Policy</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='financial-aid.html'>Financial
                                        Aid</a>
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
                                    <a class='accordion-link' href='about_placement.html'>About
                                        Placement</a>
                                </div>
                                <div class="accordion-item">
                                    <a class='accordion-link' href='placement-details.html'>Placement
                                        Details</a>
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
                                    <a class='accordion-link' href='online-fee-payment.html'>Online Fee
                                        Payment</a>
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
                                        target="_blank">Campus Security
                                        Audit (PDF)</a></div>
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
                    <a class='accordion-link without-icon active' href='contact-us.php'>
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
    <div class="section-banner bg-4">
        <div class="container">
            <div class="banner-spacing">
                <div class="section-info">
                    <h2 data-aos="fade-zoom-in" data-aos-delay="100">Contact Us</h2>
                    <p data-aos="fade-zoom-in" data-aos-delay="200">Whether you have questions about
                        courses, admissions, or campus life — we're here to help.
                        Connect with us today and take the first step toward your future.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- End Section Banner Area -->

    <!-- Start Contact  Area-->
    <div class="contact-area ptb-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="contact-content">
                        <div class="header-content">
                            <h2>Get in Touch / Submit a Grievance</h2>
                            <p>Please select the type of form you want to submit. Based on your selection, the form fields will update accordingly.</p>
                            <p>For verifications, please email <a href="mailto:hit.office@hindusthan.net">hit.office@hindusthan.net</a></p>
                        </div>

                        <div id="formMessage"></div>
                        <div class="contact-form">
                            <form id="contactForm" action="contact-us.php" method="POST" onsubmit="return validateForm()">
                                <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($_SESSION['csrf_token']); ?>">
                                
                                <div class="row">
                                    <div class="col-lg-12 col-md-12 mb-4">
                                        <!-- <div class="form-group">
                                            <label style="font-weight:bold; color:black;">Select Form Type <span style="color:red;">*</span></label>
                                            <select name="form_type" id="form_type" class="form-control" onchange="toggleFormFields()" style="height: 50px;">
                                                <option value="contact" selected>Contact Form</option>
                                                <option value="grievance">Student Grievance</option>
                                            </select>
                                            <small style="color:red; display:block; margin-top:5px; font-weight:600;">
                                                * If you are a student and want to raise a complaint, please select "Student Grievance." The form will automatically change to collect the required details.
                                            </small>
                                        </div> -->
                                        <div style="margin-bottom:20px;">
                                        <label style="font-weight:600; color:#000; display:block; margin-bottom:8px;">
                                            Select Form Type <span style="color:red;">*</span>
                                        </label>

                                        <div style="position:relative;">
                                            <select name="form_type" id="form_type" onchange="toggleFormFields()"
                                                style="width:100%; height:50px; padding:0 45px 0 15px; border:1px solid #ccc; border-radius:8px; font-size:16px; appearance:none; -webkit-appearance:none; -moz-appearance:none; background:#fff; cursor:pointer;">
                                                
                                                <option value="contact" selected>Contact Form</option>
                                                <option value="grievance">Student Grievance</option>
                                            </select>

                                            <!-- Arrow -->
                                            <span style="position:absolute; right:15px; top:50%; transform:translateY(-50%); pointer-events:none; font-size:14px; color:#555;">
                                                ▼
                                            </span>
                                        </div>

                                        <small style="color:red; display:block; margin-top:6px; font-weight:500; font-size:13px;">
                                            * If you are a student and want to raise a complaint, please select "Student Grievance."
                                        </small>
                                    </div>
                                    </div>
                                </div>

                                <!-- Contact Form Fields -->
                                <div class="row" id="contact-fields">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="nameError" style="color: red; display: none;">Please enter your name</span>
                                            <input type="text" name="name" id="name" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="emailError" style="color: red; display: none;">Please enter a valid email address</span>
                                            <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="phoneError" style="color: red; display: none;">Please enter a valid 10-digit phone number</span>
                                            <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="subjectError" style="color: red; display: none;">Please enter the subject</span>
                                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject">
                                        </div>
                                    </div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <span class="error-message" id="messageError" style="color: red; display: none;">Please enter your message</span>
                                            <textarea name="message" id="message" class="form-control" placeholder="Your Message"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Student Grievance Form Fields -->
                                <div class="row" id="grievance-fields" style="display: none;">
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="gNameError" style="color: red; display: none;">Please enter your name</span>
                                            <input type="text" name="g_name" id="g_name" class="form-control" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="gRollError" style="color: red; display: none;">Please enter your roll number</span>
                                            <input type="text" name="g_roll_number" id="g_roll_number" class="form-control" placeholder="Roll Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="gDeptError" style="color: red; display: none;">Please enter your department</span>
                                            <input type="text" name="g_department" id="g_department" class="form-control" placeholder="Department">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="gMobileError" style="color: red; display: none;">Please enter a valid mobile number</span>
                                            <input type="text" name="g_mobile_number" id="g_mobile_number" class="form-control" placeholder="Mobile Number">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
                                        <div class="form-group">
                                            <span class="error-message" id="gEmailError" style="color: red; display: none;">Please enter a valid email</span>
                                            <input type="email" name="g_email" id="g_email" class="form-control" placeholder="Email">
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6">
    <div style="margin-bottom:20px;">

        <!-- Error Message -->
        <span id="gTypeError"
            style="color:red; display:none; font-size:13px; margin-bottom:6px; font-weight:500;">
            Please select grievance type
        </span>

        <!-- Custom Dropdown -->
        <div style="position:relative;">
            <select name="g_grievance_type" id="g_grievance_type"
                style="width:100%; height:50px; padding:0 45px 0 15px; border:1px solid #ccc; border-radius:8px; font-size:15px; appearance:none; -webkit-appearance:none; -moz-appearance:none; background:#fff; cursor:pointer;">
                
                <option value="" disabled selected>Select Type of Grievance</option>
                <option value="Admission">Grievance related to Admission</option>
                <option value="Discrimination SC/ST">Complaints on discrimination by students from SC/ST Categories</option>
                <option value="Women Redressal">Complaints on Women redressal</option>
                <option value="Victimization">Grievance related to Victimization</option>
                <option value="Attendance">Grievance related to Attendance</option>
                <option value="Fee Charging">Grievance related to charging of fees</option>
                <option value="Evaluation Process">Grievance regarding non-transparent or unfair evaluation process</option>
                <option value="AICTE Norms">Non-observation of AICTE norms and standards</option>
                <option value="Document Return">Refusal to return documents such as certificates</option>
                <option value="Harassment">Harassment by fellow students or teachers</option>
                <option value="Scholarships">Non-payment or Delay in payment of scholarships</option>
                <option value="Timetable">Grievance related to timetable scheduling</option>
                <option value="Lab/Library Rules">Violation of lab/library rules</option>
                <option value="Hostel and Mess">Institute hostel and mess related issues</option>
                <option value="Administration Maintenance">General administration and maintenance related issues</option>
            </select>

            <!-- Arrow -->
            <span style="position:absolute; right:15px; top:50%; transform:translateY(-50%); pointer-events:none; font-size:14px; color:#555;">
                ▼
            </span>
        </div>

    </div>
</div>
                                    <div class="col-lg-12 col-md-12">
                                        <div class="form-group">
                                            <span class="error-message" id="gQueryError" style="color: red; display: none;">Please enter your query</span>
                                            <textarea name="g_query" id="g_query" class="form-control" placeholder="Your Query"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12 col-md-12">
                                        <!-- Google reCAPTCHA Widget -->
                                        <div class="g-recaptcha mb-3" data-sitekey="6LejcI0sAAAAANBbwHXGRa3dpOirsLj9BaZo6iPZ"></div>
                                        <button type="submit" class="default-btn">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info">

                        <!-- Start Map Area -->
                        <div id="map" class="map-pd">
                            <iframe
                                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d62661.52189754748!2d76.99315200000001!3d11.012712!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5265d0f0e202dd%3A0x6c1cb249318c77f!2shicas!5e0!3m2!1sen!2sin!4v1746613455232!5m2!1sen!2sin"
                                width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                        <!-- End Map Area -->

                        <div class="info-details">
                            <ul>
                                <li><i class='bx bxs-phone-call'></i> General tel - <a href="tel:+91 422 - 4440555">91
                                        422 - 4440555</a></li>
                                <li><i class='bx bxs-phone-call'></i> Mobile - <a href="tel:+91 98431 33333">91 98431
                                        33333</a></li>
                                <li><i class='bx bxs-phone-call'></i> Mobile - <a href="tel:+91 80983 33333"> 91 80983
                                        33333</a></li>
                                <!-- <li><i class='bx bxs-phone-call'></i> Student Account Inquiries - <a href="tel:+18554750885"> (849) 516-0885</a>(Option 5)</li> -->
                                <li><i class='bx bxs-map'></i>Hindusthan Institute of Technology, Valley Campus, Pollachi Highway, Coimbatore - 641 032. TamilNadu, INDIA</li>
                                <li><i class='bx bxs-envelope'></i><a
                                        href="mailto:hit.office@hindusthan.net">hit.office@hindusthan.net</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- End Contact Area-->

    <!-- Start Footer Area -->
    <div class="footer-area">
        <div class="footer-top-info ptb-100">
            <div class="content">
                <!--   <!-- <div class="image">
                    <img src="assets/hindusthan_images/hindusthan_logo.png" style="height: 80px;width: 80px;"
                        alt="image">
                </div> --> -->
                <p>Hindusthan offers an inclusive, welcoming campus where students learn with purpose,
                    explore with confidence, and embrace opportunities that shape their future.</p>
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
                                <p>Hindusthan Institute of Technology, Valley Campus, Pollachi Highway, Coimbatore - 641 032. TamilNadu, INDIA</p>
                                <div style="color: white;">
                                    <i class="bx bxs-phone-call"></i> <a href="tel:+91 422 - 4440555"
                                        style="color: white;"> +91 422 - 4440555</a>
                                </div>
                                <div style="color: white;">
                                    <i class="bx bxs-phone-call"></i> <a href="tel:+91 80983 33333"
                                        style="color: white;"> +91 80983 33333</a>
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
                                            class='bx bx-chevron-right'></i> College of Education</a>
                                </li>
                                <li><a href='https://hsoa.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        School of Architecture</a></li>
                                <li><a href='https://hpc.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        Polytechnic College</a></li>
                                <li><a href='https://hindusthan.net/hschool/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> Hindusthan School</a></li>
                                <li><a href='https://his.ac.in/' target="_blank"><i class='bx bx-chevron-right'></i>
                                        International School</a></li>
                                <li><a href='https://hindusthan.net/hichs/' target="_blank"><i
                                            class='bx bx-chevron-right'></i> College of Health
                                        Science</a></li>
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
                                <li><a href='how-to-apply.html'><i class='bx bx-chevron-right'></i>
                                        Apply For Admissions</a></li>
                                <li><a href='about-us.html'><i class='bx bx-chevron-right'></i> About
                                        us</a></li>
                                <li><a href='undergraduate.html'><i class='bx bx-chevron-right'></i> UG
                                        Course</a></li>
                                <li><a href='graduate.html'><i class='bx bx-chevron-right'></i> PG
                                        Course</a></li>
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
                                    style="color: black;"> NovaCodex </a> (
                                HICAS - IT Alumni )</p>
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

    <!-- Response Modal -->
    <!-- <div class="modal fade" id="responseModal" tabindex="-1" aria-labelledby="responseModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="responseModalLabel">Enquiry Message</h5>
                   
                </div>
                <div class="modal-body" id="responseModalBody">
                  
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div> -->

    <div class="go-top active">
        <i class="bx bx-up-arrow-alt"></i>
    </div>


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
            <a href="https://admission.hindusthan.net/" class="contact-option">
                <i class='bx bx-book-content'></i>
                <span>Admission Enquiry</span>
            </a>
            <a href="contact-us.php" class="contact-option">
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
    <script src="assets/js/custom.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        function toggleFormFields() {
            const formType = document.getElementById('form_type').value;
            if (formType === 'contact') {
                document.getElementById('contact-fields').style.display = 'flex';
                document.getElementById('grievance-fields').style.display = 'none';
            } else {
                document.getElementById('contact-fields').style.display = 'none';
                document.getElementById('grievance-fields').style.display = 'flex';
            }
        }

        function validateForm() {
            let isValid = true;
            const formType = document.getElementById('form_type').value;

            if (formType === 'contact') {
                // Name validation
                const name = document.getElementById('name');
                if (!name.value.trim()) {
                    document.getElementById('nameError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('nameError').style.display = 'none';
                }

                // Email validation
                const email = document.getElementById('email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!email.value.trim() || !emailPattern.test(email.value)) {
                    document.getElementById('emailError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('emailError').style.display = 'none';
                }

                // Phone validation
                const phone = document.getElementById('phone');
                const phonePattern = /^[0-9]{10}$/;
                if (!phone.value.trim() || !phonePattern.test(phone.value)) {
                    document.getElementById('phoneError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('phoneError').style.display = 'none';
                }

                // Subject validation
                const subject = document.getElementById('subject');
                if (!subject.value.trim()) {
                    document.getElementById('subjectError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('subjectError').style.display = 'none';
                }

                // Message validation
                const message = document.getElementById('message');
                if (!message.value.trim()) {
                    document.getElementById('messageError').style.display = 'block';
                    isValid = false;
                } else {
                    document.getElementById('messageError').style.display = 'none';
                }
            } else {
                // Grievance validation
                const gName = document.getElementById('g_name');
                if (!gName.value.trim()) {
                    document.getElementById('gNameError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gNameError').style.display = 'none'; }
                
                const gRoll = document.getElementById('g_roll_number');
                if (!gRoll.value.trim()) {
                    document.getElementById('gRollError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gRollError').style.display = 'none'; }
                
                const gDept = document.getElementById('g_department');
                if (!gDept.value.trim()) {
                    document.getElementById('gDeptError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gDeptError').style.display = 'none'; }
                
                const gMobile = document.getElementById('g_mobile_number');
                const mobilePattern = /^[0-9]{10}$/;
                if (!gMobile.value.trim() || !mobilePattern.test(gMobile.value)) {
                    document.getElementById('gMobileError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gMobileError').style.display = 'none'; }
                
                const gEmail = document.getElementById('g_email');
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!gEmail.value.trim() || !emailPattern.test(gEmail.value)) {
                    document.getElementById('gEmailError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gEmailError').style.display = 'none'; }
                
                const gType = document.getElementById('g_grievance_type');
                if (!gType.value) {
                    document.getElementById('gTypeError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gTypeError').style.display = 'none'; }
                
                const gQuery = document.getElementById('g_query');
                if (!gQuery.value.trim()) {
                    document.getElementById('gQueryError').style.display = 'block'; isValid = false;
                } else { document.getElementById('gQueryError').style.display = 'none'; }
            }

            // reCAPTCHA validation
            const recaptchaResponse = grecaptcha.getResponse();
            if (recaptchaResponse.length === 0) {
                // Not checked
                Swal.fire({
                    icon: 'warning',
                    title: 'Verification Required',
                    text: 'Please check the reCAPTCHA box to proceed.',
                    confirmButtonColor: '#3085d6'
                });
                isValid = false;
            }

            return isValid;
        }


    </script>

    <script>
        const params = new URLSearchParams(window.location.search);
        const status = params.get("status");

        if (status === "success") {
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Enquiry submitted successfully!',
                confirmButtonColor: '#3085d6'
            });
        } else if (status === "recaptcha_error") {
            Swal.fire({
                icon: 'error',
                title: 'Verification Failed',
                text: 'Please complete the reCAPTCHA to verify you are human.',
                confirmButtonColor: '#d33'
            });
        } else if (status === "error") {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'Something went wrong. Please try again.',
                confirmButtonColor: '#d33'
            });
        }

        // Remove ?status from URL
        if (window.history.replaceState) {
            const url = window.location.origin + window.location.pathname;
            window.history.replaceState({}, document.title, url);
        }
    </script>



</body>

</html>