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

if ($role !== 'admin' && !in_array('appointment_schedule', $permissions)) {
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
                        <span>Reschedule or Cancel Appointment</span>
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
                        <i class="bi bi-person-fill"></i>
                        <input type="text" name="name" placeholder="Search ...">
                    </div>
                    <div class="search-box">
                        <input type="date" name="date" placeholder="Search appointment...">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="drwise-schedule mb-5">
                    <p class="drwise-schedule-top">All Reschedule or Cancel Appointment Details</p>
                    <div class="doctor-card">
                        <div class="doctor-info" style="background-color: #FF4646;">
                            <img src="<?= BASE_URL ?>staff/img/profile.png" alt="Doctor Photo">
                            <h3>Dr. Ashraf Ali</h3>
                            <p>Cardiologist</p>
                        </div>
                        <div class="schedule-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Patient Name</th>
                                        <th>Disease</th>
                                        <th>Status</th>
                                        <th style="width: 180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:00 - 10:30</td>
                                        <td>John Doe</td>
                                        <td>Fever</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:30 - 11:00</td>
                                        <td>Jane Smith</td>
                                        <td>Cold</td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger border border-danger">
                                                <i class="bi bi-x-circle"></i> Cancel
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>11:00 - 11:30</td>
                                        <td>Michael Ray</td>
                                        <td>Diabetes</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="doctor-card">
                        <div class="doctor-info" style="background-color: #FF4646;">
                            <img src="<?= BASE_URL ?>staff/img/profile.png" alt="Doctor Photo">
                            <h3>Dr. Ashraf Ali</h3>
                            <p>Cardiologist</p>
                        </div>
                        <div class="schedule-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Patient Name</th>
                                        <th>Disease</th>
                                        <th>Status</th>
                                        <th style="width: 180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:00 - 10:30</td>
                                        <td>John Doe</td>
                                        <td>Fever</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:30 - 11:00</td>
                                        <td>Jane Smith</td>
                                        <td>Cold</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>11:00 - 11:30</td>
                                        <td>Michael Ray</td>
                                        <td>Diabetes</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="doctor-card">
                        <div class="doctor-info" style="background-color: #FF4646;">
                            <img src="<?= BASE_URL ?>staff/img/profile.png" alt="Doctor Photo">
                            <h3>Dr. Ashraf Ali</h3>
                            <p>Cardiologist</p>
                        </div>
                        <div class="schedule-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Patient Name</th>
                                        <th>Disease</th>
                                        <th>Status</th>
                                        <th style="width: 180px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:00 - 10:30</td>
                                        <td>John Doe</td>
                                        <td>Fever</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>10:30 - 11:00</td>
                                        <td>Jane Smith</td>
                                        <td>Cold</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>10-10-2025</td>
                                        <td>11:00 - 11:30</td>
                                        <td>Michael Ray</td>
                                        <td>Diabetes</td>
                                        <td>
                                            <span class="badge bg-warning-subtle text-warning border border-warning ms-1">
                                                <i class="bi bi-arrow-repeat"></i> Reschedule
                                            </span>
                                        </td>
                                        <td>
                                            <button class="action-btn view" title="View"><i class="bi bi-eye"></i></button>
                                            <button class="action-btn cancel" title="Cancel"><i class="bi bi-x-circle"></i></button>
                                            <button class="action-btn reschedule" title="Reschedule"><i class="bi bi-calendar-event"></i></button>
                                            <button class="action-btn remove" title="Remove"><i class="bi bi-trash"></i></button>
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
</section>



<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>