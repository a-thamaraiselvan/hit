<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Handle delete action
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Get photo path before deletion
        $stmt = $conn->prepare("SELECT photo FROM alumni WHERE id = ?");
        $stmt->execute([$id]);
        $alumni = $stmt->fetch();
        
        if($alumni && $alumni['photo']) {
            $file_path = "../../" . $alumni['photo'];
            if(file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Delete the record
        $stmt = $conn->prepare("DELETE FROM alumni WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Alumni deleted successfully!";
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

ob_start();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Manage Alumni</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="add_alumni.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New Alumni
            </a>
        </div>
    </div>

    <?php if(isset($success)): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Graduation Year</th>
                            <th>Course</th>
                            <th>Current Position</th>
                            <th>Company</th>
                            <th>Email</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM alumni ORDER BY created_at DESC");
                        while($row = $stmt->fetch()) {
                        ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td>
                                <?php if($row['photo']): ?>
                                    <img src="../../<?php echo htmlspecialchars($row['photo']); ?>" 
                                         alt="Alumni Photo" 
                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 50%;">
                                <?php else: ?>
                                    <span class="text-muted">No photo</span>
                                <?php endif; ?>
                            </td>
                            <td><?php echo htmlspecialchars($row['name']); ?></td>
                            <td><?php echo htmlspecialchars($row['graduation_year']); ?></td>
                            <td><?php echo htmlspecialchars($row['course']); ?></td>
                            <td><?php echo htmlspecialchars($row['current_position']); ?></td>
                            <td><?php echo htmlspecialchars($row['company']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td>
                                <div class="btn-group">
                                    <a href="edit_alumni.php?id=<?php echo $row['id']; ?>" 
                                       class="btn btn-sm btn-primary me-1">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger"
                                            onclick="deleteAlumni(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
function deleteAlumni(id) {
    if(confirm('Are you sure you want to delete this alumni?')) {
        window.location.href = `?delete=${id}`;
    }
}
</script>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>