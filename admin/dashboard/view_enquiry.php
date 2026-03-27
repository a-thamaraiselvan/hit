<?php
require_once '../includes/db.php';
require_once '../includes/functions.php';

// Check login status
checkLogin();

// Add search and filter functionality
$search = isset($_GET['search']) ? sanitize($_GET['search']) : '';
$filter = isset($_GET['filter']) ? sanitize($_GET['filter']) : '';

// Get the view type from URL
$status = isset($_GET['status']) ? sanitize($_GET['status']) : 'pending';

        // Prepare the SQL query with search and filter
        $sql = "SELECT e.*, 
               er.reply_subject, 
               er.reply_message, 
               er.sent_at as reply_sent_at,
               CASE WHEN er.id IS NOT NULL THEN 1 ELSE 0 END as is_replied 
        FROM enquiries e 
        LEFT JOIN (
            SELECT r1.* FROM enquiry_replies r1
            INNER JOIN (
                SELECT MAX(id) as max_id FROM enquiry_replies GROUP BY enquiry_id
            ) r2 ON r1.id = r2.max_id
        ) er ON e.id = er.enquiry_id 
        WHERE 1=1";

// Add status filter
if ($status === 'replied') {
    $sql .= " AND er.id IS NOT NULL";
}
else {
    $sql .= " AND er.id IS NULL";
}

if ($search) {
    $sql .= " AND (e.name LIKE :search OR e.email LIKE :search OR e.subject LIKE :search)";
}
if ($filter) {
    $sql .= " AND DATE(e.created_at) = :filter";
}
$sql .= " ORDER BY e.created_at DESC";

$stmt = $conn->prepare($sql);
if ($search) {
    $searchParam = "%$search%";
    $stmt->bindParam(':search', $searchParam);
}
if ($filter) {
    $stmt->bindParam(':filter', $filter);
}
$stmt->execute();

// Start output buffering
ob_start();
?>

<div class="container-fluid py-4">
    <div class="row">
        <main class="col-md-12 px-md-4">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-4 border-bottom">
                <h2><i class="fas fa-envelope-open-text me-2"></i>Enquiries Management</h2>
                <div class="btn-toolbar mb-2 mb-md-0">
                    <div class="btn-group me-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="exportBtn">
                            <i class="fas fa-download me-1"></i> Export to Excel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <form class="row g-3" method="GET">
                        <div class="col-md-4">
                            <input type="text" class="form-control" name="search" placeholder="Search by name, email or subject" value="<?php echo htmlspecialchars($search); ?>">
                        </div>
                        <div class="col-md-4">
                            <input type="date" class="form-control" name="filter" value="<?php echo $filter; ?>">
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary me-2">Search</button>
                            <a href="view_enquiry.php" class="btn btn-secondary">Reset</a>
                        </div>
                        <input type="hidden" name="status" value="<?php echo htmlspecialchars($status); ?>">
                    </form>
                </div>
            </div>

            <!-- Toggle Buttons -->
          <div class="d-flex justify-content-end">
            <div class="btn-group me-2 mb-4" role="group" aria-label="Toggle view">
                <input type="radio" class="btn-check" name="viewType" id="pendingView" value="pending" <?php echo(!isset($_GET['status']) || $_GET['status'] === 'pending') ? 'checked' : ''; ?>>
                <label class="btn btn-outline-warning" for="pendingView">
                    <i class="fas fa-clock me-1"></i> Pending
                    <span class="badge bg-warning ms-1" id="pendingCount">0</span>
                </label>

                <input type="radio" class="btn-check" name="viewType" id="repliedView" value="replied" <?php echo(isset($_GET['status']) && $_GET['status'] === 'replied') ? 'checked' : ''; ?>>
                <label class="btn btn-outline-success" for="repliedView">
                    <i class="fas fa-check-circle me-1"></i> Replied
                    <span class="badge bg-success ms-1" id="repliedCount">0</span>
                </label>
            </div>
        </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3"><i class="fas fa-hashtag me-1"></i>ID</th>
                                    <th class="py-3"><i class="fas fa-user me-1"></i>Name</th>
                                    <th class="py-3"><i class="fas fa-envelope me-1"></i>Email</th>
                                    <th class="py-3"><i class="fas fa-phone me-1"></i>Phone</th>
                                    <th class="py-3"><i class="fas fa-tag me-1"></i>Subject</th>
                                    <th class="py-3"><i class="fas fa-comment-alt me-1"></i>Message</th>
                                    <th class="py-3"><i class="fas fa-calendar me-1"></i>Date</th>
                                    <th class="py-3"><i class="fas fa-check-circle me-1"></i>Status</th>
                                    <th class="py-3"><i class="fas fa-cog me-1"></i>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>
                                <tr>
                                    <td class="py-3"><?php echo $row['id']; ?></td>
                                    <td class="py-3"><?php echo htmlspecialchars($row['name']); ?></td>
                                    <td class="py-3" >
                                        <a href="mailto:<?php echo htmlspecialchars($row['email']); ?>" class="text-decoration-none" style="color:#ed6f26">
                                            <?php echo htmlspecialchars($row['email']); ?>
                                        </a>
                                    </td>
                                    <td class="py-3">
                                        <a href="tel:<?php echo htmlspecialchars($row['phone']); ?>" class="text-decoration-none" style="color:#ed6f26">
                                            <?php echo htmlspecialchars($row['phone']); ?>
                                        </a>
                                    </td>
                                    <td class="py-3"><?php echo htmlspecialchars($row['subject']); ?></td>
                                    <td class="py-3">
                                        <span class="text-truncate d-inline-block" style="max-width: 200px;" 
                                              data-bs-toggle="tooltip" title="<?php echo htmlspecialchars($row['message']); ?>">
                                            <?php echo htmlspecialchars($row['message']); ?>
                                        </span>
                                    </td>
                                    <td class="py-3">
                                        <span data-bs-toggle="tooltip" title="<?php echo $row['created_at']; ?>">
                                            <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                                        </span>
                                    </td>


                                    <td class="py-3">
                                        <?php if ($row['is_replied']): ?>
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Replied</span>
                                        <?php
    else: ?>
                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>Not Replied</span>
                                        <?php
    endif; ?>
                                    </td>



  

                                    <td class="py-3">
                                        <div class="btn-group">
                                            <button type="button" class="btn btn-sm btn-info me-1" 
                                                    data-bs-toggle="modal" data-bs-target="#viewModal<?php echo $row['id']; ?>">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-primary me-1"
                                                    data-bs-toggle="modal" data-bs-target="#replyModal<?php echo $row['id']; ?>">
                                                <i class="fas fa-paper-plane"></i>
                                            </button>
                                            <a href="../actions/delete_enquiry.php?id=<?php echo $row['id']; ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Are you sure you want to delete this enquiry?')">
                                                <i class="fas fa-trash"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>

                                <!-- View Modal -->
                                <div class="modal fade" id="viewModal<?php echo $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Enquiry Details</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="fw-bold"><i class="fas fa-user me-2"></i>Name:</label>
                                                    <p><?php echo htmlspecialchars($row['name']); ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold"><i class="fas fa-envelope me-2"></i>Email:</label>
                                                    <p><?php echo htmlspecialchars($row['email']); ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold"><i class="fas fa-phone me-2"></i>Phone:</label>
                                                    <p><?php echo htmlspecialchars($row['phone']); ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold"><i class="fas fa-tag me-2"></i>Subject:</label>
                                                    <p><?php echo htmlspecialchars($row['subject']); ?></p>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="fw-bold"><i class="fas fa-comment-alt me-2"></i>Message:</label>
                                                    <p><?php echo nl2br(htmlspecialchars($row['message'])); ?></p>
                                                </div>
                                                
                                                <?php if ($row['is_replied']): 
                                                    $replyStmt = $conn->prepare("SELECT * FROM enquiry_replies WHERE enquiry_id = ? ORDER BY sent_at DESC");
                                                    $replyStmt->execute([$row['id']]);
                                                    $all_replies = $replyStmt->fetchAll(PDO::FETCH_ASSOC);
                                                ?>
                                                <hr>
                                                <h6 class="text-primary mt-3"><i class="fas fa-reply-all me-2"></i>Reply History</h6>
                                                
                                                <div class="reply-history" style="max-height: 400px; overflow-y: auto; padding-right: 5px;">
                                                    <?php foreach ($all_replies as $index => $reply): ?>
                                                        <div class="card mb-3 border-<?php echo $index === 0 ? 'primary' : 'secondary'; ?> shadow-sm">
                                                            <div class="card-header bg-<?php echo $index === 0 ? 'primary text-white' : 'light'; ?> py-2 d-flex justify-content-between align-items-center">
                                                                <span>
                                                                    <i class="fas fa-envelope-open-text me-2"></i> 
                                                                    <?php echo $index === 0 ? 'Latest Reply' : 'Previous Reply'; ?>
                                                                </span>
                                                                <small><i class="fas fa-calendar-check me-1"></i> <?php echo date('M d, Y h:i A', strtotime($reply['sent_at'])); ?></small>
                                                            </div>
                                                            <div class="card-body py-2">
                                                                <div class="mb-2">
                                                                    <label class="fw-bold text-muted small">Subject:</label>
                                                                    <p class="mb-1 fw-bold"><?php echo htmlspecialchars($reply['reply_subject']); ?></p>
                                                                </div>
                                                                <div>
                                                                    <label class="fw-bold text-muted small">Message:</label>
                                                                    <div class="p-2 bg-light rounded border border-secondary border-opacity-25" style="font-size: 0.95rem;">
                                                                        <?php echo nl2br(htmlspecialchars($reply['reply_message'])); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- Reply Modal -->
                                <div class="modal fade" id="replyModal<?php echo $row['id']; ?>" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Reply to Enquiry</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="../actions/send_reply.php" method="POST">
                                                <div class="modal-body">
                                                    <input type="hidden" name="enquiry_id" value="<?php echo $row['id']; ?>">
                                                    <input type="hidden" name="recipient_email" value="<?php echo htmlspecialchars($row['email']); ?>">
                                                    <input type="hidden" name="recipient_name" value="<?php echo htmlspecialchars($row['name']); ?>">
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">To:</label>
                                                        <p class="form-control-static"><?php echo htmlspecialchars($row['name']); ?> (<?php echo htmlspecialchars($row['email']); ?>)</p>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Subject:</label>
                                                        <input type="text" class="form-control" name="subject" value="Reply for : <?php echo htmlspecialchars($row['subject']); ?>" required>
                                                    </div>
                                                    
                                                    <div class="mb-3">
                                                        <label class="form-label">Message:</label>
                                                        <textarea class="form-control" name="message" rows="6" required></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary">Send Reply</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Success Modal -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Success</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i id="successIcon" class="fas fa-check-circle fa-3x text-success mb-3"></i>
                <h5 id="successTitle">Success!</h5>
                <p class="mb-0" id="successMessage">Operation completed successfully.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Error Modal -->
<div class="modal fade" id="errorModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title"><i class="fas fa-exclamation-circle me-2"></i>Error</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body text-center py-4">
                <i class="fas fa-times-circle fa-3x text-danger mb-3"></i>
                <h5 id="errorTitle">Operation Failed!</h5>
                <p class="mb-0" id="errorMessage">Something went wrong.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Check for success/error parameter in URL
        const urlParams = new URLSearchParams(window.location.search);
        
        if (urlParams.get('success') === '1') {
            const message = urlParams.get('message') ? decodeURIComponent(urlParams.get('message').replace(/\+/g, ' ')) : 'Operation successful';
            const successModalEl = document.getElementById('successModal');
            const successTitle = document.getElementById('successTitle');
            const successMessage = document.getElementById('successMessage');
            const successIcon = document.getElementById('successIcon');

            // Customize based on message content
            if (message.toLowerCase().includes('deleted')) {
                successTitle.textContent = 'Enquiry Deleted!';
                successMessage.textContent = 'The enquiry has been deleted successfully.';
                successIcon.className = 'fas fa-trash-alt fa-3x text-success mb-3';
            } else if (message.toLowerCase().includes('reply sent')) {
                successTitle.textContent = 'Email Sent Successfully!';
                successMessage.textContent = 'Your reply has been sent and the enquiry has been marked as responded.';
                successIcon.className = 'fas fa-envelope-open-text fa-3x text-success mb-3';
            } else {
                successTitle.textContent = 'Success!';
                successMessage.textContent = message;
                successIcon.className = 'fas fa-check-circle fa-3x text-success mb-3';
            }

            // Show success modal
            const successModal = new bootstrap.Modal(successModalEl);
            successModal.show();
            
            // Remove parameters from URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
        
        if (urlParams.get('error') === '1') {
            // Show error modal
            const message = urlParams.get('message') || 'An error occurred during the operation.';
            document.getElementById('errorMessage').textContent = decodeURIComponent(message.replace(/\+/g, ' '));
            
            const errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
            
            // Remove parameters from URL
            window.history.replaceState({}, document.title, window.location.pathname);
        }
    });

document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Export to Excel functionality
    document.getElementById('exportBtn').addEventListener('click', function() {
        let table = document.querySelector('table');
        let html = table.outerHTML;
        
        // Add BOM for proper Excel encoding
        let data = '\ufeff' + html;
        
        // Create blob and download
        let blob = new Blob([data], { type: 'application/vnd.ms-excel' });
        let url = window.URL.createObjectURL(blob);
        let a = document.createElement('a');
        a.href = url;
        a.download = 'enquiries_' + new Date().toISOString().slice(0,10) + '.xls';
        document.body.appendChild(a);
        a.click();
        document.body.removeChild(a);
        window.URL.revokeObjectURL(url);
    });
});


document.addEventListener('DOMContentLoaded', function() {
    // Handle toggle buttons
    document.querySelectorAll('.btn-check').forEach(function(radio) {
        radio.addEventListener('change', function() {
            // Get current URL parameters
            const urlParams = new URLSearchParams(window.location.search);
            
            // Update status parameter
            urlParams.set('status', this.value);
            
            // Redirect with all parameters
            window.location.href = 'view_enquiry.php?' + urlParams.toString();
        });
    });



    // Update counters
    function updateCounters() {
        fetch('get_enquiry_counts.php')
            .then(response => response.json())
            .then(data => {
                document.getElementById('pendingCount').textContent = data.pending;
                document.getElementById('repliedCount').textContent = data.replied;
            });
    }
    updateCounters();
});
</script>
<?php
$content = ob_get_clean();
require_once '../includes/layout.php';
?>



           
