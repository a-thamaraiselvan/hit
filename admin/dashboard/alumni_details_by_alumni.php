<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Handle delete action
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Delete the record
        $stmt = $conn->prepare("DELETE FROM alumni_form WHERE id = ?");
        $stmt->execute([$id]);
        $success = "Entry deleted successfully!";
    } catch (PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

// Handle Export to Excel
if (isset($_GET['export']) && $_GET['export'] == 'excel') {
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment; filename="alumni_submissions.xls"');

    echo "S.No\tName\tEmail\tDepartment\tYear of Passing\tMobile\tCurrent Position\tMessage\tDate\n";

    $search = isset($_GET['search']) ? $_GET['search'] : '';
    $query = "SELECT * FROM alumni_form";
    $params = [];

    if ($search) {
        $query .= " WHERE name LIKE ? OR email LIKE ? OR department LIKE ?";
        $params = ["%$search%", "%$search%", "%$search%"];
    }

    $query .= " ORDER BY created_at ASC";

    $stmt = $conn->prepare($query);
    $stmt->execute($params);

    $i = 1;
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo $i . "\t" .
            $row['name'] . "\t" .
            $row['email'] . "\t" .
            $row['department'] . "\t" .
            $row['year_of_passing'] . "\t" .
            $row['mobile'] . "\t" .
            $row['current_position'] . "\t" .
            str_replace(["\r", "\n", "\t"], " ", $row['message']) . "\t" .
            $row['created_at'] . "\n";
        $i++;
    }
    exit;
}

ob_start();
?>

<div class="container-fluid">
    <div class="row mb-4 align-items-center">
        <div class="col-md-4">
            <h2>Alumni Form Submissions</h2>
        </div>
        <div class="col-md-8">
            <form method="GET" class="d-flex justify-content-end gap-2">
                <input type="text" name="search" class="form-control w-auto" style="height: 35px;" placeholder="Search..."
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i></button>
                <?php if (isset($_GET['search']) && $_GET['search']): ?>
                    <a href="alumni_details_by_alumni.php" class="btn btn-secondary"><i class="fas fa-times"></i></a>
                <?php endif; ?>
                <a href="?export=excel<?php echo isset($_GET['search']) ? '&search=' . urlencode($_GET['search']) : ''; ?>"
                    class="btn btn-success">
                    <i class="fas fa-file-excel"></i> Export
                </a>
            </form>
        </div>
    </div>

    <?php if (isset($success)): ?>
        <div class="alert alert-success alert-dismissible fade show">
            <?php echo $success; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show">
            <?php echo $error; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>S.No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                            <th>Year of Passing</th>
                            <th>Mobile</th>
                            <th>Current Position</th>
                            <th>Message</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $query = "SELECT * FROM alumni_form";
                        $params = [];

                        if ($search) {
                            $query .= " WHERE name LIKE ? OR email LIKE ? OR department LIKE ?";
                            $params = ["%$search%", "%$search%", "%$search%"];
                        }

                        $query .= " ORDER BY created_at ASC";

                        $stmt = $conn->prepare($query);
                        $stmt->execute($params);

                        $i = 1;
                        while ($row = $stmt->fetch()) {
                            ?>
                            <tr>
                                <td><?php echo $i++; ?></td>
                                <td><?php echo htmlspecialchars($row['name']); ?></td>
                                <td><a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none" style="color:#ed6f26">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                </td>
                                <td><?php echo htmlspecialchars($row['department']); ?></td>
                                <td><?php echo htmlspecialchars($row['year_of_passing']); ?></td>
                                <td><a href="tel:<?php echo htmlspecialchars($row['mobile']); ?>" class="text-decoration-none" style="color:#ed6f26">
                                            <?php echo htmlspecialchars($row['mobile']); ?>
                                        </a>
                                </td>
                                
                                <td><?php echo htmlspecialchars($row['current_position']); ?></td>
                                <td><?php echo htmlspecialchars(substr($row['message'], 0, 50)) . (strlen($row['message']) > 50 ? '...' : ''); ?>
                                </td>
                                <td> <?php echo date('M d, Y', strtotime($row['created_at'])); ?></td>
                                
                                <td>
                                    <button type="button" class="btn btn-sm btn-danger"
                                        onclick="deleteEntry(<?php echo $row['id']; ?>)">
                                        <i class="fas fa-trash"></i>
                                    </button>
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
    function deleteEntry(id) {
        if (confirm('Are you sure you want to delete this entry?')) {
            window.location.href = `?delete=${id}`;
        }
    }
</script>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>