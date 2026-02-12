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
                        <span>Leave Management</span>
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
                <div class="staff-list mb-5">
                    <p class="staff-details-list">
                        <i class="bi bi-people-fill me-2"></i>
                        Staff Leave Management
                        <a href="#" class="btn-apply-leave">
                            <i class="bi bi-plus-circle-fill me-2"></i> Apply Leave
                        </a>
                    </p>

                    <div class="row">
                        <div class="col-12">
                            <div class="card attendance-card shadow-lg border-0">
                                <div class="card-body p-4">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">
                                        <div class="d-flex align-items-center">
                                            <img src="img/profile.png" class="rounded-circle staff-img me-3 shadow-sm">
                                            <div>
                                                <h4 class="fw-bold mb-1">Ashraf Ali</h4>
                                                <div class="text-muted small">
                                                    <i class="bi bi-person-badge"></i> Staff ID: ST-101 |
                                                    <i class="bi bi-building"></i> Nursing |
                                                    <i class="bi bi-briefcase"></i> Supervisor
                                                </div>
                                                <div class="text-muted small">
                                                    <i class="bi bi-telephone"></i> 9876543210 |
                                                    <i class="bi bi-calendar"></i> Joining: 01 Jan 2024
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Filter -->
                                        <!-- Filter -->
                                        <div class="mt-3 mt-md-0">
                                            <div class="d-flex gap-2">
                                                <select class="form-select">
                                                    <option>January</option>
                                                    <option>February</option>
                                                    <option selected>March</option>
                                                    <option>April</option>
                                                </select>
                                                <select class="form-select">
                                                    <option>2026</option>
                                                    <option selected>2025</option>
                                                    <option>2024</option>
                                                </select>
                                                <button class="btn btn-primary">
                                                    <i class="bi bi-funnel"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row g-3 text-center mb-4">
                                        <div class="col-md-4">
                                            <div class="summary-box bg-success bg-opacity-10 p-3 shadow-sm">
                                                <div class="text-success fw-semibold">Approved</div>
                                                <h4 class="fw-bold text-success">22</h4>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-4">
                                            <div class="summary-box bg-danger bg-opacity-10 p-3 shadow-sm">
                                                <div class="text-danger fw-semibold">Pending</div>
                                                <h4 class="fw-bold text-danger">2</h4>
                                            </div>
                                        </div> -->
                                        <div class="col-md-4">
                                            <div class="summary-box bg-warning bg-opacity-10 p-3 shadow-sm">
                                                <div class="text-warning fw-semibold">Pending</div>
                                                <h4 class="fw-bold text-warning">3</h4>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="summary-box bg-danger bg-opacity-10 p-3 shadow-sm">
                                                <div class="text-danger fw-semibold">Rejected</div>
                                                <h4 class="fw-bold text-danger">2</h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-hover align-middle">
                                            <thead>
                                                <tr>
                                                    <th>Date From</th>
                                                    <th>Date To</th>
                                                    <th>Leave Type</th>
                                                    <th>Reason</th>
                                                    <th>Status</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>01-03-2025</td>
                                                    <td>03-03-2025</td>
                                                    <td>Casual Leave</td>
                                                    <td>Personal Work</td>
                                                    <td>
                                                        <span class="status-badge badge-present">
                                                            <span class="status-dot" style="background:#1b7a4b;"></span>
                                                            Approved
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>02-03-2025</td>
                                                    <td>Tuesday</td>
                                                    <td>-</td>
                                                    <td>-</td>

                                                    <td>
                                                        <span class="status-badge badge-late ">
                                                            <span class="status-dot"
                                                                style="background:#b54708 ;"></span>
                                                            Pending
                                                        </span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>03-03-2025</td>
                                                    <td>Wednesday</td>
                                                    <td>09:40 AM</td>
                                                    <td>06:00 PM</td>

                                                    <td>
                                                        <span class="status-badge badge-absent">
                                                            <span class="status-dot" style="background:#b42318;"></span>
                                                            Rejected
                                                        </span>
                                                    </td>
                                                </tr>

                                            </tbody>
                                        </table>
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