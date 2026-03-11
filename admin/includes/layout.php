<?php
// Check if session is not already started before starting it
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Hindusthan </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <link rel="icon" href="../../assets/hindusthan_images/hindusthan_logo.png" type="image/png">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../assets/css/font-awesome.min.css">
    <link rel="stylesheet" href="../../assets/css/aos.css">
    <link rel="stylesheet" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/boxicons.min.css">
    <link rel="stylesheet" href="../../assets/css/owl.carousel.min.css">
    <link rel="stylesheet" href="../../assets/css/flaticon.css">
    <link rel="stylesheet" href="../../assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="../../assets/css/style.css">
    <link rel="stylesheet" href="../../assets/css/header.css">
    <link rel="stylesheet" href="../../assets/css/responsive.css">
    <link rel="stylesheet" href="../../assets/css/skeleton.css">

    <style>
        :root {
            --sidebar-width: 250px;
            --header-height: 60px;
            --primary-color: rgb(0, 0, 0);
            --hover-color: #34495e;
            --active-color: #ed6f26;
        }

        body {
            min-height: 100vh;
            background: #f8f9fa;
        }

        /* Sidebar Styles */
        .sidebar {
            width: var(--sidebar-width);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 0;
            background: var(--primary-color);
            color: white;
            transition: all 0.3s;
            z-index: 1000;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 15px;
            background: rgba(0, 0, 0, 0.1);
        }

        .sidebar .nav-link {
            color: #ecf0f1;
            padding: 12px 20px;
            margin: 4px 8px;
            border-radius: 5px;
            transition: all 0.3s;
            display: flex;
            align-items: center;
        }

        .sidebar .nav-link:hover {
            background: #fbbb83;
            transform: translateX(5px);
            color: #000;
        }

        .sidebar .nav-link.active {
            background: var(--active-color);
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        }

        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styles */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 10px;
            min-height: 100vh;
            transition: all 0.3s;
        }

        /* Top Bar Styles */
        .top-bar {
            background: white;
            padding: 10px 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        /* User Profile Styles */
        .user-profile {
            display: flex;
            align-items: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .user-profile img {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            margin-right: 15px;
            border: 2px solid rgba(255, 255, 255, 0.2);
        }

        .user-profile .user-info {
            flex-grow: 1;
        }

        .user-profile h6 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
        }

        .user-profile small {
            opacity: 0.7;
        }

        /* Dropdown Styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: #f8f9fa;
            transform: translateX(5px);
        }

        /* Card Styles */
        .card {
            border: none;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border-radius: 10px;
            transition: all 0.3s;
        }

        /* .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        } */

        /* Responsive Styles */
        @media (max-width: 991.98px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .main-content.shifted {
                /* margin-left: var(--sidebar-width); */
            }
        }

        /* Mobile Menu Toggle */
        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: var(--primary-color);
            font-size: 1.5rem;
            padding: 0.5rem;
            cursor: pointer;
        }

        @media (max-width: 991.98px) {
            .menu-toggle {
                display: block;
            }
        }

        /* Navigation Categories */
        .nav-category {
            font-size: 0.75rem;
            text-transform: uppercase;
            padding: 1rem 1.5rem 0.5rem;
            color: rgba(255, 255, 255, 0.5);
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        /* Overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 991.98px) {
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>

<body>
    <!-- Mobile Menu Toggle -->
    <!-- <button class="menu-toggle" id="menuToggle">
        <i class="fas fa-bars"></i>
    </button> -->

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">


        <div class="sidebar-header">
            <div class="user-profile">
                <img src="../../assets/hindusthan_images/hindusthan_logo.png" alt="HECT Profile">


                <div class="user-info">
                    <h6><?php echo $_SESSION['admin_username'] ?? 'Admin'; ?></h6>
                    <small>Administrator</small>
                </div>
            </div>
        </div>

        <nav class="nav flex-column mt-3">
            <div class="nav-category">Main Navigation</div>
            <a class="nav-link" href="index.php">
                <i class="fas fa-tachometer-alt"></i>
                <span>Dashboard</span>
            </a>
            <a class="nav-link" href="chat_support.php">
                <i class="fas fa-comments"></i> Chat Support
            </a>

            <div class="nav-category">News Management</div>
            <a class="nav-link" href="news.php">
                <i class="fas fa-edit"></i>
                <span>Create News</span>
            </a>
            <a class="nav-link" href="manage_news.php">
                <i class="fas fa-newspaper"></i>
                <span>Manage News</span>
            </a>
            <a class="nav-link" href="manage_ticker.php">
                <i class="fas fa-bullhorn"></i>
                <span>Manage Latest News</span>
            </a>


            <div class="nav-category">Communication</div>
            <a class="nav-link" href="view_enquiry.php">
                <i class="fas fa-envelope"></i>
                <span>View Enquiries</span>
            </a>

            <div class="nav-category">Alumni Maintanance</div>
            <a class="nav-link" href="add_alumni.php">
                <i class="fas fa-edit"></i>
                <span>Create Alumni</span>
            </a>
            <a class="nav-link" href="manage_alumni.php">
                <i class="fas fa-graduation-cap"></i>
                <span>Manage Alumni</span>
            </a>
            <a class="nav-link" href="alumni_details_by_alumni.php">
                <i class="fas fa-list"></i>
                <span>Alumni Form Details</span>
            </a>


            <div class="nav-category">Media & Settings</div>
            <a class="nav-link" href="media.php">
                <i class="fas fa-images"></i>
                <span>Media Library</span>
            </a>
            <a class="nav-link" href="profile.php">
                <i class="fas fa-profile"></i>
                <span>Profile</span>
            </a>
        </nav>
    </div>

    <!-- Top Bar -->
    <div class="top-bar">
        <div class="row align-items-center">
        <script src="../../assets/js/skeleton.js"></script>
            <div class="col">

                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0">
                        <button class="menu-toggle" id="menuToggle">
                            <i class="fas fa-bars"></i>
                    </ol>
                </nav>
            </div>
            <div class="col-auto">
                <div class="dropdown">
                    <button class="btn btn-link dropdown toggle text-dark" type="button" id="userDropdown"
                        data-bs-toggle="dropdown">
                        <i class="fas fa-user-gear fa-lg"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php">
                                <i class="fas fa-user me-2"></i> Profile
                            </a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item text-danger" href="../auth/logout.php">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">

        <!-- Page Content -->
        <div class="content">
            <?php
            if (isset($content)) {
                echo $content;
            }
            ?>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Menu Toggle Functionality
            const menuToggle = document.getElementById('menuToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleMenu() {
                sidebar.classList.toggle('show');
                overlay.classList.toggle('show');
                mainContent.classList.toggle('shifted');
            }

            menuToggle.addEventListener('click', toggleMenu);
            overlay.addEventListener('click', toggleMenu);

            // Active Menu Item
            const currentPage = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPage) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // Handle Window Resize
            window.addEventListener('resize', function () {
                if (window.innerWidth > 991.98) {
                    sidebar.classList.remove('show');
                    overlay.classList.remove('show');
                    mainContent.classList.remove('shifted');
                }
            });
        });



        // Prevent form resubmission when page is refreshed
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
    </script>

</body>

</html>