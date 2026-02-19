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

if ($role !== 'admin' && !in_array('staff_roles_permissions', $permissions)) {
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
                        <span>Staff Roles & Permissions</span>
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
                        Staff Roles & Permissions Details
                    </p>
                    <div class="row">
                        <div class="col-12">
                            <div class="staff-permission-card mb-3">
                                <!-- Left: Image -->
                                <div class="staff-image">
                                    <img src="img/profile.png" alt="Ashraf Ali">
                                </div>
                                <!-- Center: Info -->
                                <div class="staff-info">
                                    <h5>Ashraf Ali</h5>
                                    <p><strong>Username:</strong> ashraf123</p>
                                    <p><strong>Email:</strong> ashraf@example.com</p>
                                    <!-- Roles -->
                                    <div class="roles">
                                        <span class="badge bg-success role-badge">Admin</span>
                                    </div>
                                    <!-- Permissions -->
                                    <div class="permissions-box">
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Manage Users</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> View Reports</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Edit Roles</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> View Schedule</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Edit Nursing Notes</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Update Patient Vitals</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Edit Articles</div>
                                        <div class="permission-tag"><i class="bi bi-unlock"></i> Publish Articles</div>
                                    </div>
                                </div>
                                <!-- Right: Actions -->
                                <div class="actions">
                                    <button class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit Roles / Permissions
                                    </button>
                                    <button class="btn btn-sm btn-danger">
                                        <i class="bi bi-trash"></i> Delete
                                    </button>
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