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

if ($role !== 'admin' && !in_array('appointment_list', $permissions)) {
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
                        <span>Appointment List</span>
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
                                    <th>#</th>
                                    <th>Patient Name</th>
                                    <th>Doctor</th>
                                    <th>Date</th>
                                    <th>Time</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Rahul Kumar</td>
                                    <td>Dr. Sharma</td>
                                    <td>15 Jan 2026</td>
                                    <td>10:30 AM</td>
                                    <td><span class="badge bg-success">Confirmed</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Neha Singh</td>
                                    <td>Dr. Verma</td>
                                    <td>16 Jan 2026</td>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Neha Singh</td>
                                    <td>Dr. Verma</td>
                                    <td>16 Jan 2026</td>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Neha Singh</td>
                                    <td>Dr. Verma</td>
                                    <td>16 Jan 2026</td>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Neha Singh</td>
                                    <td>Dr. Verma</td>
                                    <td>16 Jan 2026</td>
                                    <td>12:00 PM</td>
                                    <td><span class="badge bg-warning">Pending</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mobile-only">
                    <div class="appointment-card">
                        <div class="card-header">
                            <h6>Rahul Kumar</h6>
                            <span class="status-badge status-confirmed">Confirmed</span>
                        </div>

                        <div class="card-body">
                            <p><i class="bi bi-calendar-event"></i> 08 Feb 2026</p>
                            <p><i class="bi bi-clock"></i> 11:30 AM</p>
                            <p><i class="bi bi-person"></i> Dr. Sharma</p>
                        </div>

                        <div class="divider"></div>

                        <div class="card-actions">
                            <button class="btn-view">View</button>
                            <button class="btn-edit">Edit</button>
                            <button class="btn-delete">Cancel</button>
                        </div>
                    </div>

                    <div class="appointment-card">
                        <div class="card-header">
                            <h6>Rahul Kumar</h6>
                            <span class="status-badge status-confirmed">Confirmed</span>
                        </div>

                        <div class="card-body">
                            <p><i class="bi bi-calendar-event"></i> 08 Feb 2026</p>
                            <p><i class="bi bi-clock"></i> 11:30 AM</p>
                            <p><i class="bi bi-person"></i> Dr. Sharma</p>
                        </div>

                        <div class="divider"></div>

                        <div class="card-actions">
                            <button class="btn-view">View</button>
                            <button class="btn-edit">Edit</button>
                            <button class="btn-delete">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>



<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>