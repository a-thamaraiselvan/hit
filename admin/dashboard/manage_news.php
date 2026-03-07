<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

checkLogin();

// Handle delete action
if(isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $id = $_GET['delete'];
    try {
        // Get image path before deletion
        $stmt = $conn->prepare("SELECT poster FROM news_events WHERE id = ?");
        $stmt->execute([$id]);
        $news = $stmt->fetch();
        
        if($news && $news['poster']) {
            $file_path = "../../" . $news['poster'];
            if(file_exists($file_path)) {
                unlink($file_path);
            }
        }
        
        // Delete the record
        $stmt = $conn->prepare("DELETE FROM news_events WHERE id = ?");
        $stmt->execute([$id]);
        $success = "News/Event deleted successfully!";
    } catch(PDOException $e) {
        $error = "Error: " . $e->getMessage();
    }
}

ob_start();
?>

<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-md-6">
            <h2>Manage News & Events</h2>
        </div>
        <div class="col-md-6 text-end">
            <a href="news.php" class="btn btn-primary">
                <i class="fas fa-plus"></i> Add New
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
            <div class="table-responsive" style="font-size:15px;">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Event Name</th>
                            <th>Date</th>
                            <th>Venue</th>
                            <th>Chief Guest</th>
                            <th>Poster</th>
                            <th>Special Event</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $stmt = $conn->query("SELECT * FROM news_events ORDER BY created_at DESC");
                        while($row = $stmt->fetch()) {
                        ?>
                        <tr>
                            <td><?php echo htmlspecialchars($row['id']); ?></td>
                            <td><?php echo htmlspecialchars($row['title']); ?></td>
                            <td><?php echo htmlspecialchars($row['event_name']); ?></td>
                            <td><?php echo date('d M Y', strtotime($row['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($row['venue']); ?></td>
                            <td><?php echo htmlspecialchars($row['chief_guest']); ?></td>
                            <td>
                                <?php if($row['poster']): ?>
                                    <img src="../../<?php echo htmlspecialchars($row['poster']); ?>" 
                                         alt="Event Poster" 
                                         style="width: 50px; height: 50px; object-fit: cover;"
                                         onclick="window.open(this.src)"
                                         class="cursor-pointer">
                                <?php else: ?>
                                    <span class="text-muted">No poster</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="form-check form-switch">
                                    <input type="checkbox" class="form-check-input special-event-toggle" 
                                           data-id="<?php echo $row['id']; ?>"
                                           <?php echo $row['is_special'] ? 'checked' : ''; ?>>
                                </div>
                            </td>
                            <td><?php echo date('d M Y H:i', strtotime($row['created_at'])); ?></td>
                            <td>
                                <div class="btn-group">
                                    <button type="button" 
                                            class="btn btn-sm btn-primary"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editModal<?php echo $row['id']; ?>">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-sm btn-danger"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal<?php echo $row['id']; ?>">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </div>

                                <!-- Edit Modal -->
                                <div class="modal fade" id="editModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit News/Event</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <form action="update_news.php" method="POST" enctype="multipart/form-data">
                                                <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Title</label>
                                                        <input type="text" class="form-control" name="title" 
                                                               value="<?php echo htmlspecialchars($row['title']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Name</label>
                                                        <input type="text" class="form-control" name="event_name" 
                                                               value="<?php echo htmlspecialchars($row['event_name']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Date</label>
                                                        <input type="date" class="form-control" name="event_date" 
                                                               value="<?php echo date('Y-m-d', strtotime($row['event_date'])); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Venue</label>
                                                        <input type="text" class="form-control" name="venue" 
                                                               value="<?php echo htmlspecialchars($row['venue']); ?>" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Chief Guest</label>
                                                        <input type="text" class="form-control" name="chief_guest" 
                                                               value="<?php echo htmlspecialchars($row['chief_guest']); ?>">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Event Poster</label>
                                                        <?php if($row['poster']): ?>
                                                            <div class="mb-2">
                                                                <img src="../../<?php echo htmlspecialchars($row['poster']); ?>" 
                                                                     alt="Current Poster" style="max-width: 200px;">
                                                            </div>
                                                        <?php endif; ?>
                                                        <input type="file" class="form-control" name="event_poster" accept="image/*">
                                                        <small class="text-muted">Leave empty to keep current poster</small>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Description</label>
                                                        <textarea class="form-control" name="description" rows="5" required><?php echo htmlspecialchars($row['description']); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal<?php echo $row['id']; ?>" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Delete</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p>Are you sure you want to delete this news/event?</p>
                                                <p><strong>Title:</strong> <?php echo htmlspecialchars($row['title']); ?></p>
                                                <?php if($row['poster']): ?>
                                                    <p class="text-warning">
                                                        <i class="fas fa-exclamation-triangle"></i> 
                                                        The associated poster image will also be deleted.
                                                    </p>
                                                <?php endif; ?>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
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

<style>
    .cursor-pointer {
        cursor: pointer;
    }
    .cursor-pointer:hover {
        opacity: 0.8;
    }
    .btn-group {
        gap: 5px;
    }
    .modal-body .text-warning {
        margin-top: 10px;
    }
    .modal-lg {
        max-width: 800px;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle special event toggles
    const specialEventToggles = document.querySelectorAll('.special-event-toggle');
    specialEventToggles.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const newsId = this.dataset.id;
            const isSpecial = this.checked;
            
            // First, uncheck all other toggles
            if(isSpecial) {
                specialEventToggles.forEach(otherToggle => {
                    if(otherToggle !== this) {
                        otherToggle.checked = false;
                    }
                });
            }
            
            // Send AJAX request to update special status
            fetch('update_special_status.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `id=${newsId}&is_special=${isSpecial ? 1 : 0}`
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // Show success message
                    alert(data.message);
                } else {
                    // Show error message and revert the toggle
                    alert(data.message);
                    this.checked = !this.checked;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred while updating the special status');
                this.checked = !this.checked;
            });
        });
    });

    // Add form submission handling
    const editForms = document.querySelectorAll('form[action="update_news.php"]');
    editForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            fetch('update_news.php', {
                method: 'POST',
                body: formData
            })
            .then(response => {
                if(response.ok) {
                    alert('News/Event updated successfully!');
                    window.location.reload();
                } else {
                    throw new Error('Update failed');
                }
            })
            .catch(error => {
                alert('Error updating news/event. Please try again.');
                console.error('Error:', error);
            });
        });
    });
});
</script>

<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>