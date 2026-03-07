<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = sanitize($_POST['title']);
    $event_name = sanitize($_POST['event_name']);
    $event_date = sanitize($_POST['event_date']);
    $venue = sanitize($_POST['venue']);
    $chief_guest = sanitize($_POST['chief_guest']);
    $description = sanitize($_POST['description']);
    
    // Handle file upload
    $target_dir = "../../uploads/events/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $poster = "";
    $max_size = 2 * 1024 * 1024; // 2MB in bytes
    if(isset($_FILES["event_poster"]) && $_FILES["event_poster"]["error"] == 0) {
        $file_extension = strtolower(pathinfo($_FILES["event_poster"]["name"], PATHINFO_EXTENSION));
        // Check if image file is a actual image
        $check = getimagesize($_FILES["event_poster"]["tmp_name"]);
        if($check !== false) {
            // Valid image file
            $file_name = uniqid() . "." . $file_extension;
            $target_file = $target_dir . $file_name;
            
            // Create image from uploaded file
            switch($file_extension) {
                case 'jpg':
                case 'jpeg':
                    $source = imagecreatefromjpeg($_FILES["event_poster"]["tmp_name"]);
                    break;
                case 'png':
                    $source = imagecreatefrompng($_FILES["event_poster"]["tmp_name"]);
                    break;
                default:
                    $error = "Error: Only JPG, JPEG & PNG files are allowed.";
                    break;
            }
            
            if(!isset($error)) {
                // Get original dimensions
                $width = imagesx($source);
                $height = imagesy($source);
                
                // Calculate new dimensions while maintaining aspect ratio
                $max_dimension = 800; // Max width or height for larger files
                if ($_FILES["event_poster"]["size"] > $max_size) {
                    $max_dimension = 600; // Smaller dimensions for files over 2MB
                }
                
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
                switch($file_extension) {
                    case 'jpg':
                    case 'jpeg':
                        // Higher compression for larger files
                        $quality = $_FILES["event_poster"]["size"] > $max_size ? 40 : 60;
                        imagejpeg($new_image, $target_file, $quality);
                        break;
                    case 'png':
                        // Maximum PNG compression
                        imagepng($new_image, $target_file, 9);
                        break;
                }
                
                // Free up memory
                imagedestroy($new_image);
                imagedestroy($source);
                $poster = "uploads/events/" . $file_name;
            }
        } else {
            $error = "Error: File is not an image.";
        }
    }
    
    if(!isset($error)) {
        try {
            $stmt = $conn->prepare("INSERT INTO news_events (title, event_name, event_date, venue, chief_guest, description, poster, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $stmt->execute([$title, $event_name, $event_date, $venue, $chief_guest, $description, $poster]);
            $success = "News/Event added successfully!";
        } catch(PDOException $e) {
            $error = "Error: " . $e->getMessage();
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
                    <h3 class="card-title">Add News/Event</h3>
                </div>
                <div class="card-body">
                    <?php if(isset($success)): ?>
                        <div class="alert alert-success"><?php echo $success; ?></div>
                    <?php endif; ?>
                    <?php if(isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Name</label>
                            <input type="text" class="form-control" name="event_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Date</label>
                            <input type="date" class="form-control" name="event_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Venue</label>
                            <input type="text" class="form-control" name="venue" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Chief Guest</label>
                            <input type="text" class="form-control" name="chief_guest">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Event Poster</label>
                            <input type="file" class="form-control" name="event_poster" accept="image/*">
                            <div class="form-text text-muted">
                                Maximum file size: 2MB. Files larger than 2MB will be automatically compressed to ~100KB. Allowed formats: JPG, JPEG, PNG
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <textarea class="form-control" name="description" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add News/Event</button>
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