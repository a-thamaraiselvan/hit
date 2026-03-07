<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check if user is logged in
if (!isset($_SESSION['admin_id'])) {
    header('Location: ../auth/login.php');
    exit();
}

$success_message = '';
$error_message = '';

// Get current admin data
$admin_id = $_SESSION['admin_id'];
$stmt = $conn->prepare("SELECT * FROM admin_users WHERE id = ?");
$stmt->execute([$admin_id]);
$admin = $stmt->fetch();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate inputs
    if (empty($username) || empty($email)) {
        $error_message = "Name and email are required fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    } else {
        // Start transaction
        $conn->beginTransaction();
        try {
            // Update basic info
            $stmt = $conn->prepare("UPDATE admin_users SET username = ?, email = ? WHERE id = ?");
            $stmt->execute([$username, $email, $admin_id]);

            // Handle password change if requested
            if (!empty($current_password)) {
                // Verify current password
                if (!password_verify($current_password, $admin['password'])) {
                    throw new Exception("Current password is incorrect.");
                }

                // Validate new password
                if (empty($new_password)) {
                    throw new Exception("New password cannot be empty.");
                }
                if ($new_password !== $confirm_password) {
                    throw new Exception("New passwords do not match.");
                }

                // Update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE admin_users SET password = ? WHERE id = ?");
                $stmt->execute([$hashed_password, $admin_id]);
            }

            $conn->commit();
            $success_message = "Profile updated successfully!";
            
            // Refresh admin data
            $stmt = $conn->prepare("SELECT * FROM admin_users WHERE id = ?");
            $stmt->execute([$admin_id]);
            $admin = $stmt->fetch();

        } catch (Exception $e) {
            $conn->rollBack();
            $error_message = $e->getMessage();
        }
    }
}
ob_start();
?>


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Update Profile</h4>
                </div>
                <div class="card-body">
                    <?php if ($success_message): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($success_message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($error_message): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error_message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="username" name="username" 
                                   value="<?php echo htmlspecialchars($admin['username']); ?>">
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   value="<?php echo htmlspecialchars($admin['email']); ?>" >
                        </div>

                        <hr>
                        <h5>Change Password</h5>
                        <p class="text-muted" style="color:blue !important;">Leave blank if you don't want to change the password</p>

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password">
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password">
                        </div>

                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                        </div>

                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>