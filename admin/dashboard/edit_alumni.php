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
    $max_size = 2 * 1024 * 1024; // 2MB in bytes
    if(isset($_FILES["photo"]) && $_FILES["photo"]["error"] == 0) {
        $target_dir = "../../uploads/alumni/";
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        
        $file_extension = strtolower(pathinfo($_FILES["photo"]["name"], PATHINFO_EXTENSION));
        // Check if image file is a actual image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if($check !== false) {
            // Valid image file
            $file_name = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $file_name;
            
            // Create image from uploaded file
            $source = null;
            switch($file_extension) {
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg($_FILES["photo"]["tmp_name"]);
                    break;
                case 'png':
                    $source = imagecreatefrompng($_FILES["photo"]["tmp_name"]);
                    break;
            }
            
            if($source) {
                // Delete old photo if exists
                if($alumni['photo']) {
                    $old_file = "../../" . $alumni['photo'];
                    if(file_exists($old_file)) {
                        unlink($old_file);
                    }
                }

                // Get original dimensions
                $width = imagesx($source);
                $height = imagesy($source);
                
                // Determine compression settings
                $needs_compression = $_FILES["photo"]["size"] > $max_size;
                
                if($needs_compression) {
                    // Calculate new dimensions while maintaining aspect ratio
                    $max_dimension = 800; // Max width or height
                    if($width > $height) {
                        $new_width = $max_dimension;
                        $new_height = floor($height * ($max_dimension / $width));
                    } else {
                        $new_height = $max_dimension;
                        $new_width = floor($width * ($max_dimension / $height));
                    }
                    
                    // Create new image
                    $new_image = imagecreatetruecolor($new_width, $new_height);
                    
                    // Handle transparency for PNG
                    if($file_extension == 'png') {
                        imagealphablending($new_image, false);
                        imagesavealpha($new_image, true);
                    }
                    
                    // Resize image
                    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
                    
                    // Save compressed image
                    if($file_extension == 'jpg' || $file_extension == 'jpeg') {
                        imagejpeg($new_image, $target_file, 60); // Compression quality 60
                    } else {
                        imagepng($new_image, $target_file, 8); // PNG compression 8
                    }
                    
                    imagedestroy($new_image);
                } else {
                    // For files under 2MB, just move the uploaded file
                    move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
                }
                
                imagedestroy($source);
                $photo_update = ", photo = ?";
                $photo_value = "uploads/alumni/" . $file_name;
            }
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