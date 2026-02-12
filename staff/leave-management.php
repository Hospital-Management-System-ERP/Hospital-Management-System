<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
require __DIR__ . '/../api/login/auth.php';
$claims = require_auth();
$role = $claims['role'];
$name = $claims['name'];
$username = $claims['username'] ?? '';
$permissions = $claims['permissions'] ?? [];

if ($role !== 'admin' && !in_array('staff_leave', $permissions)) {
    http_response_code(403);
    echo "❌ Unauthorized Access";
    exit;
}
include('../includes/header.php');
include('../includes/sidebar.php');
include('../includes/top-header.php');
?>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="top-body d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-grid-fill me-1"></i> <a href="<?= BASE_URL ?>">Dashboard</a>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <span><i class="bi bi-people-fill me-1"></i> Staff</span>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <span> Leave Management </span>
                    </span>
                    <div class="digital-watch">
                        <?php include __DIR__ . '/../watch.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="appointment-list d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Left side: Export Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-danger btn-sm export-btn">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </button>
                        <button class="btn btn-dark btn-sm export-btn" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                    <!-- Right side: Search -->
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="staffSearch" placeholder="Search Staff...">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="staff-list">
                    <p class="staff-details-list">
                        <i class="bi bi-people-fill me-2"></i>
                        Staff Details
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="staff-info d-flex flex-wrap gap-3">
                                <div class="staff-card d-flex">
                                    <div class="staff-img">
                                        <img src="img/profile.png" alt="John Doe">
                                    </div>
                                    <div class="staff-details d-flex flex-column justify-content-between">
                                        <div class="staff-info-top">
                                            <h5 class="staff-name">John Doe</h5>
                                            <p class="staff-role">Admin</p>
                                            <p class="staff-email">Email: john@example.com</p>
                                            <p class="staff-phone">Phone: +91 9934104210</p>
                                            <p>Status: <span class="staff-status active">Active</span></p>
                                        </div>
                                        <div class="staff-actions">
                                            <button class="btn btn-sm btn-primary">View Details</button>
                                            <button class="btn btn-sm btn-warning">Edit Details</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                            <button class="btn btn-sm btn-secondary">Toggle Status</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="staff-card d-flex">
                                    <div class="staff-img">
                                        <img src="img/profile.png" alt="Jane Smith">
                                    </div>
                                    <div class="staff-details d-flex flex-column justify-content-between">
                                        <div class="staff-info-top">
                                            <h5 class="staff-name">Asraf Ali</h5>
                                            <p class="staff-role">Accountant</p>
                                            <p class="staff-email">Email: john@example.com</p>
                                            <p class="staff-phone">Phone: +91 9934104210</p>
                                            <p>Status: <span class="staff-status inactive">Inactive</span></p>
                                        </div>
                                        <div class="staff-actions">
                                            <button class="btn btn-sm btn-primary">View Details</button>
                                            <button class="btn btn-sm btn-warning">Edit Details</button>
                                            <button class="btn btn-sm btn-danger">Delete</button>
                                            <button class="btn btn-sm btn-secondary">Toggle Status</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>