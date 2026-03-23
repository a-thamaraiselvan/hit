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
    // 's-h' => 'Science and Humanities'
];

$selected_dept = isset($_GET['dept']) ? $_GET['dept'] : 'aeronautical';

// Fetch faculty for selected department
try {
    $stmt = $conn->prepare("SELECT * FROM faculty WHERE department = ? ORDER BY priority ASC, name ASC");
    $stmt->execute([$selected_dept]);
    $faculty_members = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $error = "Error: " . $e->getMessage();
}

// Handle priority update
if (isset($_POST['update_priority'])) {
    foreach ($_POST['priority'] as $id => $val) {
        $stmt = $conn->prepare("UPDATE faculty SET priority = ? WHERE id = ?");
        $stmt->execute([(int)$val, (int)$id]);
    }
    header("Location: manage_faculty.php?dept=" . $selected_dept . "&msg=Priority updated");
    exit();
}

ob_start();
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h3 class="card-title">Manage Faculty</h3>
                    <a href="add_faculty.php?dept=<?php echo $selected_dept; ?>" class="btn btn-primary btn-sm">Add New Faculty</a>
                </div>
                <div class="card-body">
                    <form method="GET" class="mb-4">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <label class="form-label">Select Department</label>
                                <select name="dept" class="form-select" onchange="this.form.submit()">
                                    <?php foreach ($departments as $code => $name): ?>
                                        <option value="<?php echo $code; ?>" <?php echo $selected_dept == $code ? 'selected' : ''; ?>>
                                            <?php echo $name; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </form>

                    <?php if (isset($_GET['msg'])): ?>
                        <div class="alert alert-success mt-3"><?php echo htmlspecialchars($_GET['msg']); ?></div>
                    <?php endif; ?>

                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger mt-3"><?php echo $error; ?></div>
                    <?php endif; ?>

                    <form method="POST">
                        <input type="hidden" name="update_priority" value="1">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th style="width: 80px;">Priority</th>
                                        <th style="width: 80px;">Image</th>
                                        <th>Name</th>
                                        <th>Designation</th>
                                        <th>Qualification</th>
                                        <th style="width: 150px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if (count($faculty_members) > 0): ?>
                                        <?php foreach ($faculty_members as $faculty): ?>
                                            <tr>
                                                <td>
                                                    <input type="number" name="priority[<?php echo $faculty['id']; ?>]" value="<?php echo $faculty['priority']; ?>" class="form-control form-control-sm">
                                                </td>
                                                <td>
                                                    <img src="../../<?php echo $faculty['image_path']; ?>" alt="" style="width: 50px; height: 50px; object-fit: cover; border-radius: 5px;">
                                                </td>
                                                <td><?php echo $faculty['name']; ?></td>
                                                <td><?php echo $faculty['designation']; ?></td>
                                                <td><?php echo $faculty['qualification']; ?></td>
                                                <td>
                                                    <a href="edit_faculty.php?id=<?php echo $faculty['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                                                    <button type="button" class="btn btn-danger btn-sm" onclick="confirmDelete(<?php echo $faculty['id']; ?>, '<?php echo $selected_dept; ?>')">Delete</button>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No faculty found for this department.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                        <?php if (count($faculty_members) > 0): ?>
                            <button type="submit" class="btn btn-success">Update All Priorities</button>
                        <?php endif; ?>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id, dept) {
    if (confirm('Are you sure you want to delete this faculty member?')) {
        window.location.href = 'delete_faculty.php?id=' + id + '&dept=' + dept;
    }
}
</script>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>
