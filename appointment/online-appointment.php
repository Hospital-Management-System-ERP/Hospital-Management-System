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

if ($role !== 'admin' && !in_array('appointment_online', $permissions)) {
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
                        <span><i class="bi bi-calendar-check me-1"></i> Appointment</span>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <span>Online Appointment</span>
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
                        <button class="btn btn-success btn-sm export-btn">
                            <i class="bi bi-file-earmark-excel"></i> Excel
                        </button>

                        <button class="btn btn-danger btn-sm export-btn">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </button>

                        <button class="btn btn-primary btn-sm export-btn">
                            <i class="bi bi-filetype-csv"></i> CSV
                        </button>

                        <button class="btn btn-dark btn-sm export-btn" onclick="window.print()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                    <!-- Right side: Search -->
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" placeholder="Search appointment...">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="appointment-list-table desktop-only">
                    <div class="table-responsive w-100">
                        <table id="appointmentTable" class="table table-hover align-middle responsive-table">
                            <thead class="table-light">
                                <tr>
                                    <th>Sno.</th>
                                    <th>Name</th>
                                    <th>Mobile</th>
                                    <th>Service Type</th>
                                    <th>Cycle</th>
                                    <th>Mode</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Asraf</td>
                                    <td>9934102010</td>
                                    <td>Home</td>
                                    <td>Daily</td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success border border-success px-3">
                                            <i class="bi bi-wifi me-1"></i> Online
                                        </span>
                                    </td>
                                    <td>10-10-2025</td>
                                    <td>10:20 A.M</td>
                                    <td>
                                        <span class="status-badge active">Active</span>
                                    </td>
                                    <td class="action-btns">
                                        <button class="btn-action edit" title="Edit">
                                            <i class="bi bi-pencil-square"></i>
                                        </button>

                                        <button class="btn-action view" title="View">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        <button class="btn-action assign" title="Assign Nurse">
                                            <i class="bi bi-person-plus"></i>
                                        </button>

                                        <button class="btn-action delete" title="Delete">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mobile-only">
                    <div class="appointment-card">
                        <!-- Header -->
                        <div class="card-header">
                            <h6>Asraf</h6>
                            <span class="status-badge active">Active</span>
                        </div>
                        <!-- Body -->
                        <div class="card-body">
                            <p><i class="bi bi-telephone"></i> 9934102010</p>
                            <p><i class="bi bi-envelope"></i> test@gmail.com</p>
                            <p><i class="bi bi-heart-pulse"></i> Home</p>
                            <p><i class="bi bi-wifi me-1"></i> Online</p>
                            <p><i class="bi bi-arrow-repeat"></i> Daily</p>
                            <p><i class="bi bi-calendar-event"></i> 10-10-2025</p>
                            <p><i class="bi bi-clock"></i> 10:20 AM</p>
                        </div>
                        <div class="divider"></div>
                        <!-- Actions -->
                        <div class="card-actions">
                            <button class="btn-action edit" title="Edit">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                            <button class="btn-action view" title="View">
                                <i class="bi bi-eye"></i>
                            </button>
                            <button class="btn-action assign" title="Assign Nurse">
                                <i class="bi bi-person-plus"></i>
                            </button>
                            <button class="btn-action delete" title="Delete">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>