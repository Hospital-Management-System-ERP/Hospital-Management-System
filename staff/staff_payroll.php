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

if ($role !== 'admin' && !in_array('staff_payroll', $permissions)) {
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
                        <span>Staff Payroll</span>
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
                        <i class="bi bi-cash-coin me-2"></i> Staff Payroll Management
                        <a href="#" class="btn-apply-leave">
                            <i class="bi bi-plus-circle me-2"></i>Generate Payroll
                        </a>
                    </p>

                    <div class="row g-3 mb-4">
                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="payroll-card p-3">
                                <div class="payroll-header"><i class="bi bi-people-fill me-1"></i> Total Staff</div>
                                <h4 class="fw-bold mt-2"><span class="counter" data-target="42">0</span></h4>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="payroll-card p-3">
                                <div class="payroll-header"><i class="bi bi-cash-stack me-1"></i> Total Payroll</div>
                                <h4 class="fw-bold mt-2">₹ <span class="counter" data-target="425000">0</span></h4>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="payroll-card p-3">
                                <div class="payroll-header"><i class="bi bi-check-circle-fill me-1"></i> Paid</div>
                                <h4 class="fw-bold mt-2">₹ <span class="counter" data-target="380000">0</span></h4>
                            </div>
                        </div>

                        <div class="col-12 col-lg-3 col-md-6">
                            <div class="card payroll-card p-3">
                                <div class="payroll-header"><i class="bi bi-hourglass-split me-1"></i> Pending</div>
                                <h4 class="fw-bold mt-2">₹ <span class="counter" data-target="45000">0</span></h4>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm mb-4 p-3 payroll-filter">
                        <div class="row g-3">
                            <div class="col-lg-3 col-md-3 col-12">
                                <select class="form-select">
                                    <option value="January" selected>January</option>
                                    <option value="February">February</option>
                                    <option value="March">March</option>
                                    <option value="April">April</option>
                                    <option value="May">May</option>
                                    <option value="June">June</option>
                                    <option value="July">July</option>
                                    <option value="August">August</option>
                                    <option value="September">September</option>
                                    <option value="October">October</option>
                                    <option value="November">November</option>
                                    <option value="December">December</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <select class="form-select">
                                    <?php
                                    $startYear = 2026;
                                    $currentYears = date('Y');
                                    for ($year = $startYear; $year <= $currentYears; $year++) {
                                        $selected = ($year == $currentYear) ? 'selected' : '';
                                        echo "<option value='{$year}' $selected>{$year}</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <select class="form-select">
                                    <option selected>All Departments</option>
                                    <option value="admin">Admin</option>
                                    <option value="accountant">Accountant</option>
                                    <option value="doctor">Doctor</option>
                                    <option value="nurse">Nurse</option>
                                    <option value="laboratory">Laboratory</option>
                                    <option value="pharmacy">Pharmacy</option>
                                    <option value="radiology">Radiology</option>
                                    <option value="patient_coordinator">Patient Coordinator</option>
                                    <option value="ot_coordinator">OT Coordinator</option>
                                    <option value="ambulance_coordinator">Ambulance Coordinator</option>
                                    <option value="inventory_manager">Inventory Manager</option>
                                    <option value="support">Support</option>
                                </select>
                            </div>
                            <div class="col-lg-3 col-md-3 col-12">
                                <button class="btn payroll-filter-btn w-100">
                                    <i class="bi bi-funnel me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm p-3 payroll-card-desktop">
                        <div class="table-responsive">
                            <table class="table align-middle">
                                <thead>
                                    <tr>
                                        <th>Staff</th>
                                        <th>Basic</th>
                                        <th>HRA</th>
                                        <th>TA</th>
                                        <th>PF</th>
                                        <th>Net Salary</th>
                                        <th>Status</th>
                                        <th style="width: 150px;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <img src="img/profile.png" class="rounded-circle me-2" height="40px" width="40px">
                                                Ashraf Ali
                                            </div>
                                        </td>
                                        <td>₹ 25,000</td>
                                        <td>₹ 3,000</td>
                                        <td>₹ 500</td>
                                        <td>₹ 1,500</td>
                                        <td class="fw-bold text-success">₹ 26,500</td>
                                        <td><span class="status-badge status-paid">Paid</span></td>
                                        <td>
                                            <a href="#" class="btn btn-sm btn-success d-flex align-items-center gap-1" download>
                                                <i class="bi bi-download me-1"></i> Download Slip
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- Mobile Card -->
                    <div class="mobile-card-payroll mt-3">
                        <div class="card shadow-lg p-3 mb-3 rounded-4" style="border-left: 3px solid #1e7e34;">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h6 class="fw-bold mb-0"><i class="bi bi-person-circle me-1"></i> Ashraf Ali</h6>
                                <span class="badge bg-success text-white">Net Paid</span>
                            </div>
                            <div class="d-flex justify-content-between mt-2">
                                <small>Basic:</small>
                                <small>₹25,000</small>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Allowance:</small>
                                <small>₹3,000</small>
                            </div>
                            <div class="d-flex justify-content-between mt-1">
                                <small>Deduction:</small>
                                <small>₹1,500</small>
                            </div>
                            <div class="d-flex justify-content-between mt-2 fw-bold text-primary">
                                <span>Net:</span>
                                <span>₹26,500</span>
                            </div>
                            <div class="mt-3 d-flex justify-content-between gap-2">
                                <a href="receipt.pdf" class="btn btn-sm btn-success flex-grow-1 d-flex align-items-center justify-content-center gap-1" download>
                                    <i class="bi bi-download"></i> Download
                                </a>
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