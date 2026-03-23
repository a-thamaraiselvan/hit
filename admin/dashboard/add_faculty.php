<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

$departments = [
    'aeronautical' => 'Aeronautical Engineering',
    'ai-ds' => 'Artificial Intelligence and Data Science',
    // 'agricultural' => 'Agricultural Engineering',
    // 'biomedical' => 'Biomedical Engineering',
    'cse' => 'Computer Science and Engineering',
    'ece' => 'Electronics and Communication Engineering',
    // 'eee' => 'Electrical and Electronics Engineering',
    'it' => 'Information Technology',
    'me-cse' => 'M.E. Computer Science and Engineering',
    'me-vlsi' => 'M.E. VLSI Design',
    'mba' => 'Master of Business Administration',
    'mechanical' => 'Mechanical Engineering',
    // 'mechatronics' => 'Mechatronics Engineering',
    // 'pharmaceutical' => 'Pharmaceutical Technology',
    // 'food-tech' => 'Food Technology',
    's-h' => 'Science and Humanities'
];

$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : 'aeronautical';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = sanitize($_POST['name']);
    $designation = sanitize($_POST['designation']);
    $experience = sanitize($_POST['experience']);
    $qualification = sanitize($_POST['qualification']);
    $specialization = sanitize($_POST['specialization']);
    $joined_date = sanitize($_POST['joined_date']);
    $association = sanitize($_POST['association']);
    $email = sanitize($_POST['email']);
    $department = sanitize($_POST['department']);
    $about = sanitize($_POST['about']);
    $priority = (int) $_POST['priority'];

    // Handle file upload
    $dept_folder = "../../uploads/department/" . $department . "/faculty_image_folder/";
    if (!file_exists($dept_folder)) {
        mkdir($dept_folder, 0777, true);
    }

    $image_path = "";
    $max_size = 2 * 1024 * 1024; // 2MB

    if (isset($_FILES["faculty_image"]) && $_FILES["faculty_image"]["error"] == 0) {
        $file_extension = strtolower(pathinfo($_FILES["faculty_image"]["name"], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'webp', 'gif'];

        if (!in_array($file_extension, $allowed_extensions)) {
            $error = "Only JPG, JPEG, PNG, WEBP, and GIF images are allowed.";
        } else {
            $check = getimagesize($_FILES["faculty_image"]["tmp_name"]);

            if ($check !== false) {
                $file_name = slugify($name) . "." . $file_extension;
                $target_file = $dept_folder . $file_name;

                // Compression logic
                $source = null;
                if ($file_extension == 'jpg' || $file_extension == 'jpeg') {
                    $source = imagecreatefromjpeg($_FILES["faculty_image"]["tmp_name"]);
                } elseif ($file_extension == 'png') {
                    $source = imagecreatefrompng($_FILES["faculty_image"]["tmp_name"]);
                } elseif ($file_extension == 'webp') {
                    $source = imagecreatefromwebp($_FILES["faculty_image"]["tmp_name"]);
                } elseif ($file_extension == 'gif') {
                    $source = imagecreatefromgif($_FILES["faculty_image"]["tmp_name"]);
                }

                if ($source) {
                    $width = imagesx($source);
                    $height = imagesy($source);

                    // Resize if needed or if over 2MB
                    $max_dim = 800;
                    if ($_FILES["faculty_image"]["size"] > $max_size) {
                        $max_dim = 600;
                    }

                    if ($width > $height) {
                        $new_width = $max_dim;
                        $new_height = floor($height * ($max_dim / $width));
                    } else {
                        $new_height = $max_dim;
                        $new_width = floor($width * ($max_dim / $height));
                    }

                    $new_image = imagecreatetruecolor($new_width, $new_height);
                    if ($file_extension == 'png' || $file_extension == 'webp') {
                        imagealphablending($new_image, false);
                        imagesavealpha($new_image, true);
                    } elseif ($file_extension == 'gif') {
                        $transparent = imagecolorallocatealpha($new_image, 255, 255, 255, 127);
                        imagefilledrectangle($new_image, 0, 0, $new_width, $new_height, $transparent);
                    }

                    imagecopyresampled($new_image, $source, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

                    if ($file_extension == 'jpg' || $file_extension == 'jpeg') {
                        $quality = $_FILES["faculty_image"]["size"] > $max_size ? 50 : 80;
                        imagejpeg($new_image, $target_file, $quality);
                    } elseif ($file_extension == 'png') {
                        imagepng($new_image, $target_file, 9);
                    } elseif ($file_extension == 'webp') {
                        $quality = $_FILES["faculty_image"]["size"] > $max_size ? 50 : 80;
                        imagewebp($new_image, $target_file, $quality);
                    } elseif ($file_extension == 'gif') {
                        imagegif($new_image, $target_file);
                    }

                    imagedestroy($new_image);
                    imagedestroy($source);
                    $image_path = "uploads/department/" . $department . "/faculty_image_folder/" . $file_name;
                }
            } else {
                $error = "File is not a valid image.";
            }
        }
    } else {
        $error = "Please upload a faculty image.";
    }

    if (!isset($error)) {
        try {
            $stmt = $conn->prepare("INSERT INTO faculty (name, designation, experience, qualification, specialization, joined_date, association, email, department, about, image_path, priority) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([$name, $designation, $experience, $qualification, $specialization, $joined_date, $association, $email, $department, $about, $image_path, $priority]);
            header("Location: manage_faculty.php?dept=" . $department . "&msg=Faculty added successfully");
            exit();
        } catch (PDOException $e) {
            $error = "Database Error: " . $e->getMessage();
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
                    <h3 class="card-title">Add New Faculty</h3>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Department</label>
                                <select name="department" class="form-select" required>
                                    <?php foreach ($departments as $code => $name): ?>
                                        <option value="<?php echo $code; ?>" <?php echo $selected_dept == $code ? 'selected' : ''; ?>>
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Designation</label>
                                <input type="text" name="designation" class="form-control" required
                                    placeholder="e.g. Assistant Professor">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Experience</label>
                                <input type="text" name="experience" class="form-control" placeholder="e.g. 10 Years">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Qualification</label>
                                <input type="text" name="qualification" class="form-control" required
                                    placeholder="e.g. M.E., Ph.D">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Specialization</label>
                                <input type="text" name="specialization" class="form-control"
                                    placeholder="e.g. Machine Learning">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Date of Joining</label>
                                <input type="date" name="joined_date" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Association</label>
                                <input type="text" name="association" class="form-control"
                                    placeholder="e.g. Professional Member of IEEE">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email ID</label>
                                <input type="email" name="email" class="form-control"
                                    placeholder="e.g. name@hindusthan.net">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Display Priority</label>
                                <input type="number" name="priority" class="form-control" value="10" required>
                                <div class="form-text">Lower numbers show up first.</div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Faculty Image</label>
                            <input type="file" name="faculty_image" class="form-control" accept="image/*" required>
                            <div class="form-text">Images over 2MB will be automatically compressed & Allowed formats:
                                JPG, JPEG, PNG.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">About / Bio</label>
                            <textarea name="about" class="form-control" rows="6" required></textarea>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="manage_faculty.php?dept=<?php echo $selected_dept; ?>"
                                class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">Add Faculty member</button>
                        </div>
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