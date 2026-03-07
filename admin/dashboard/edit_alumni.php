<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// Get current alumni data
$stmt = $conn->prepare("SELECT * FROM alumni WHERE id = ?");
$stmt->execute([$id]);
$alumni = $stmt->fetch();

if (!$alumni) {
    header("Location: manage_alumni.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $graduation_year = (int)$_POST['graduation_year'];
    $course = sanitize($_POST['course']);
    $current_position = sanitize($_POST['current_position']);
    $company = sanitize($_POST['company']);
    $email = sanitize($_POST['email']);
    $phone = sanitize($_POST['phone']);
    $message = sanitize($_POST['message']);
    $linkedin_url = sanitize($_POST['linkedin_url']);
    
    // Handle photo upload
    $photo_update = "";
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        // Delete old photo if exists
        if($alumni['photo']) {
            $old_file = "../../" . $alumni['photo'];
            if(file_exists($old_file)) {
                unlink($old_file);
            }
        }
        
        $target_dir = "../../uploads/alumni/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION);
        $file_name = uniqid() . "." . $file_extension;
        $target_file = $target_dir . $file_name;
        
        if(move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
            $photo_update = ", photo = ?";
            $photo_value = "uploads/alumni/" . $file_name;
        }
    }
    
    try {
        $sql = "UPDATE alumni SET 
                name = ?, 
                graduation_year = ?, 
                course = ?, 
                current_position = ?, 
                company = ?, 
                email = ?, 
                phone = ?, 
                message = ?, 
                linkedin_url = ?" . $photo_update . " 
                WHERE id = ?";
                
        $params = [$name, $graduation_year, $course, $current_position, $company, $email, $phone, $message, $linkedin_url];
        if($photo_update) {
            $params[] = $photo_value;
        }
        $params[] = $id;
        
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $success = "Alumni updated successfully!";
        
        // Refresh alumni data
        $stmt = $conn->prepare("SELECT * FROM alumni WHERE id = ?");
        $stmt->execute([$id]);
        $alumni = $stmt->fetch();
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

ob_start();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Alumni</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" 
                                           value="<?php echo htmlspecialchars($alumni['name']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Graduation Year</label>
                                    <input type="number" class="form-control" name="graduation_year" 
                                           value="<?php echo htmlspecialchars($alumni['graduation_year']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Course</label>
                                    <input type="text" class="form-control" name="course" 
                                           value="<?php echo htmlspecialchars($alumni['course']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Current Position</label>
                                    <input type="text" class="form-control" name="current_position" 
                                           value="<?php echo htmlspecialchars($alumni['current_position']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Company</label>
                                    <input type="text" class="form-control" name="company" 
                                           value="<?php echo htmlspecialchars($alumni['company']); ?>">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" 
                                           value="<?php echo htmlspecialchars($alumni['email']); ?>" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input type="text" class="form-control" name="phone" 
                                           value="<?php echo htmlspecialchars($alumni['phone']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">LinkedIn URL</label>
                                    <input type="url" class="form-control" name="linkedin_url" 
                                           value="<?php echo htmlspecialchars($alumni['linkedin_url']); ?>">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Photo</label>
                                    <?php if($alumni['photo']): ?>
                                        <div class="mb-2">
                                            <img src="../../<?php echo htmlspecialchars($alumni['photo']); ?>" 
                                                 alt="Current Photo" style="max-width: 200px;">
                                        </div>
                                    <?php endif; ?>
                                    <input type="file" class="form-control" name="photo" accept="image/*">
                                    <small class="text-muted">Leave empty to keep current photo</small>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label class="form-label">Message/Bio</label>
                                    <textarea class="form-control" name="message" rows="4"><?php echo htmlspecialchars($alumni['message']); ?></textarea>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Alumni</button>
                        <a href="manage_alumni.php" class="btn btn-secondary">Cancel</a>
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