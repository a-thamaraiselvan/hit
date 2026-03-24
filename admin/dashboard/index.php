<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Get some basic statistics using try-catch for error handling
try {
    // Get database statistics
    $stats = [
        'admin_users' => 0,
        'enquiries' => 0,
        'grievances' => 0,
        'news_events' => 0,
        'alumni' => 0,
        'faculty' => 0
    ];

    $stmt = $conn->query("SELECT COUNT(*) as count FROM admin_users");
    $stats['admin_users'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt = $conn->query("SELECT COUNT(*) as count FROM enquiries");
    $stats['enquiries'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt = $conn->query("SELECT COUNT(*) as count FROM student_grievances");
    $stats['grievances'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt = $conn->query("SELECT COUNT(*) as count FROM news_events");
    $stats['news_events'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

    $stmt = $conn->query("SELECT COUNT(*) as count FROM alumni");
    $stats['alumni'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

     $stmt = $conn->query("SELECT COUNT(*) as count FROM faculty");
     $stats['faculty'] = $stmt->fetch(PDO::FETCH_ASSOC)['count'];

  
} catch(PDOException $e) {
    error_log("Database error in dashboard: " . $e->getMessage());
}

ob_start();
?>
<style>
    .card {
        background-color: #ed6f26 !important;
    }
</style>
<div class="row">
    <div class="col-md-12">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
        <p>This is your admin dashboard. You can manage your website content from here.</p>
    </div>
</div>

<div class="row mt-4">
    <!-- Statistics Cards -->
    <!-- <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Admin Users</h5>
                <h2 class="card-text"><?php echo $stats['admin_users']; ?></h2>
                <a href="../users/manage_users.php" class="btn btn-light">Manage Users</a>
            </div>
        </div>
    </div> -->
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">News & Events</h5>
                <h2 class="card-text"><?php echo $stats['news_events']; ?></h2>
                <a href="manage_news.php" class="btn btn-light">Manage News</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Enquiries</h5>
                <h2 class="card-text"><?php echo $stats['enquiries']; ?></h2>
                <a href="view_enquiry.php" class="btn btn-light">View Enquiries</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <h5 class="card-title">Student Grievances</h5>
                <h2 class="card-text"><?php echo $stats['grievances']; ?></h2>
                <a href="view_grievance.php" class="btn btn-light">View Grievances</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">Alumni</h5>
                <h2 class="card-text"><?php echo $stats['alumni']; ?></h2>
                <a href="manage_alumni.php" class="btn btn-light">View Alumni</a>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-4">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <h5 class="card-title">faculty</h5>
                <h2 class="card-text"><?php echo $stats['faculty']; ?></h2>
                <a href="manage_faculty.php" class="btn btn-light">View faculties</a>
            </div>
        </div>
    </div>

</div>


<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>