<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';
checkLogin();

// Create uploads directory if it doesn't exist
$upload_dir = '../../uploads/ticker_files/';
if (!file_exists($upload_dir)) {
    mkdir($upload_dir, 0777, true);
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add':
                $content = $_POST['content'];
                $link_url = $_POST['link_url'] ?? null;
                $status = isset($_POST['status']) ? 1 : 0;
                $file_path = null;

                // Handle file upload
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
                    $max_size = 64 * 1024 * 1024; // 64MB in bytes
                    if ($_FILES['pdf_file']['size'] > $max_size) {
                        die('File is too large. Maximum size allowed is 64MB.');
                    }
                    $file_type = $_FILES['pdf_file']['type'];
                    if ($file_type !== 'application/pdf') {
                        die('Only PDF files are allowed');
                    }
                    
                    $file_name = time() . '_' . $_FILES['pdf_file']['name'];
                    $target_path = $upload_dir . $file_name;
                    
                    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_path)) {
                        $file_path = 'uploads/ticker_files/' . $file_name;
                    }
                }

                $stmt = $conn->prepare("INSERT INTO ticker_news (content, link_url, file_path, status) VALUES (?, ?, ?, ?)");
                $stmt->execute([$content, $link_url, $file_path, $status]);
                break;

            case 'update':
                $content = $_POST['content'];
                $link_url = $_POST['link_url'] ?? null;
                $status = isset($_POST['status']) ? 1 : 0;
                $id = $_POST['id'];
                
                // Handle file upload for update
                $file_path = null;
                if (isset($_FILES['pdf_file']) && $_FILES['pdf_file']['error'] === 0) {
                    $file_type = $_FILES['pdf_file']['type'];
                    if ($file_type !== 'application/pdf') {
                        die('Only PDF files are allowed');
                    }
                    
                    $file_name = time() . '_' . $_FILES['pdf_file']['name'];
                    $target_path = $upload_dir . $file_name;
                    
                    if (move_uploaded_file($_FILES['pdf_file']['tmp_name'], $target_path)) {
                        $file_path = 'uploads/ticker_files/' . $file_name;
                        
                        // Delete old file if exists
                        $stmt = $conn->prepare("SELECT file_path FROM ticker_news WHERE id = ?");
                        $stmt->execute([$id]);
                        $old_file = $stmt->fetchColumn();
                        if ($old_file && file_exists('../../' . $old_file)) {
                            unlink('../../' . $old_file);
                        }
                    }
                }

                $sql = "UPDATE ticker_news SET content = ?, link_url = ?, status = ?";
                $params = [$content, $link_url, $status];

                if ($file_path) {
                    $sql .= ", file_path = ?";
                    $params[] = $file_path;
                }

                $sql .= " WHERE id = ?";
                $params[] = $id;

                $stmt = $conn->prepare($sql);
                $stmt->execute($params);
                break;

            case 'delete':
                $stmt = $conn->prepare("SELECT file_path FROM ticker_news WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                $file_path = $stmt->fetchColumn();
                
                if ($file_path && file_exists('../../' . $file_path)) {
                    unlink('../../' . $file_path);
                }

                $stmt = $conn->prepare("DELETE FROM ticker_news WHERE id = ?");
                $stmt->execute([$_POST['id']]);
                // Add this case in the switch statement after case 'delete':
               case 'update_status':

                    $id = $_POST['id'] ?? null;
                    $status = $_POST['status'] ?? null;

                    if ($id && $status) {
                        $stmt = $conn->prepare("UPDATE ticker_news SET status = ? WHERE id = ?");
                        $stmt->execute([$status, $id]);
                    }
                    break;

        }
    }
}

// Get all ticker news
$news = $conn->query("SELECT * FROM ticker_news ORDER BY created_at DESC")->fetchAll();

ob_start();
?>

<div class="container-fluid">

    <h2 class="mb-4">Manage Ticker News</h2>
    
    <!-- Add New Form -->
    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <input type="hidden" name="action" value="add">
                <div class="form-group mb-3">
                    <label>News Content</label>
                    <input type="text" name="content" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label>Link URL (Optional)</label>
                    <input type="url" name="link_url" class="form-control" placeholder="https://example.com">
                </div>
                <div class="form-group mb-3">
                    <label>PDF File (Optional)</label>
                    <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                </div>
                <button type="submit" class="btn btn-primary">Add News</button>
            </form>
        </div>
    </div>

    <!-- News List -->
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Content</th>
                            <th>Link/File</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($news as $item): ?>
                        <tr>
                            <td><?= htmlspecialchars($item['content']) ?></td>
                            <td>
                                <?php if ($item['link_url']): ?>
                                    <a href="<?= htmlspecialchars($item['link_url']) ?>" target="_blank" class="btn btn-sm btn-info">View <i class="fas fa-link"></i></a>
                                <?php endif; ?>
                                <?php if ($item['file_path']): ?>
                                    <a href="../../<?= htmlspecialchars($item['file_path']) ?>" target="_blank" class="btn btn-sm btn-success">View <i class="fas fa-file-pdf"></i></a>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="POST" style="display: inline;">
                                    <input type="hidden" name="action" value="update_status">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                        <option value="1" <?= $item['status'] == 1 ? 'selected' : '' ?>>Active</option>
                                        <option value="0" <?= $item['status'] == 0 ? 'selected' : '' ?>>Inactive</option>
                                    </select>
                                </form>
                            </td>
                            <td><?= $item['created_at'] ?></td>
                            <td>
                                <div class="btn-group">
                                <button type="button" class="btn btn-warning btn-sm me-1 text-white" data-bs-toggle="modal" data-bs-target="#editModal<?= $item['id'] ?>"><i class="fas fa-edit"></i></button>
                                <form method="POST" style="display: inline;" onsubmit="return confirm('Are you sure?');">
                                    <input type="hidden" name="action" value="delete">
                                    <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                    <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                </form>
                                </div>
                            </td>
                        </tr>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editModal<?= $item['id'] ?>" tabindex="-1">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit News</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form method="POST" enctype="multipart/form-data">
                                            <input type="hidden" name="action" value="update">
                                            <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                            <div class="form-group mb-3">
                                                <label>News Content</label>
                                                <input type="text" name="content" class="form-control" value="<?= htmlspecialchars($item['content']) ?>" required>
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>Link URL (Optional)</label>
                                                <input type="url" name="link_url" class="form-control" value="<?= htmlspecialchars($item['link_url']) ?>">
                                            </div>
                                            <div class="form-group mb-3">
                                                <label>PDF File (Optional)</label>
                                                <input type="file" name="pdf_file" class="form-control" accept=".pdf">
                                                <?php if ($item['file_path']): ?>
                                                    <small class="text-muted">Current file: <?= basename($item['file_path']) ?></small>
                                                <?php endif; ?>
                                            </div>
                                            <button type="submit" class="btn btn-primary">Update</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>