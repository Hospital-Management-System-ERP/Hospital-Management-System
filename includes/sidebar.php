<?php
function renderSidebar($sidebarItems, $permissions, $role)
{
    $grouped = [];

    foreach ($sidebarItems as $item) {
        if ($role !== 'admin' && $item['permission'] !== null && !in_array($item['permission'], $permissions)) {
            continue;
        }

        if (isset($item['parent']) && trim($item['parent']) !== '') {
            $parentKey = trim($item['parent']);
        } else {
            $parentKey = '__root__';
        }
        $grouped[$parentKey][] = $item;
    }
    foreach ($grouped as $parent => $items) {
        if ($parent === '__root__') {
            foreach ($items as $item) {
                echo '<a href="' . $item['url'] . '" class="list-group-item">';
                echo '<i class="bi ' . $item['icon'] . ' me-2"></i>';
                echo $item['title'];
                echo '</a>';
            }
            continue;
        }
        $menuId = strtolower(preg_replace('/[^a-zA-Z0-9]/', '', $parent)) . 'Menu';
        $parentIcon = $items[0]['icon'] ?? 'bi-folder';
        echo '
            <a href="#' . $menuId . '" 
            data-bs-toggle="collapse"
            data-bs-parent="#sidebar-accordion"
            class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span>
                    <i class="bi ' . $parentIcon . ' me-2"></i>' . $parent . '
                </span>
                <i class="bi bi-chevron-down small"></i>
            </a>';
        echo '<div class="collapse ms-2" id="' . $menuId . '">';

        foreach ($items as $item) {
            echo '<a href="' . $item['url'] . '" class="list-group-item">';
            echo $item['title'];
            echo '</a>';
        }

        echo '</div>';
    }
}
?>
<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading text-white fw-bold d-flex align-items-center justify-content-center p-3 mb-4 rounded-4 shadow-sm gradient-bg">
            <i class="bi bi-heart-pulse me-2 fs-4"></i>
            <span class="fs-5 text-uppercase">Health Care</span>
        </div>

        <div class="list-group list-group-flush" id="sidebar-accordion">
            <?php
            include __DIR__ . '/menuItem.php';
            renderSidebar($sidebarItems, $permissions, $role);
            ?>
        </div>
    </div>
</div>

<!-- <div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading text-white fw-bold d-flex align-items-center justify-content-center p-3 mb-4 rounded-4 shadow-sm gradient-bg">
            <i class="bi bi-heart-pulse me-2 fs-4"></i>
            <span class="fs-5 text-uppercase">Health Care</span>
        </div>

        <div class="list-group list-group-flush" id="sidebar-accordion">

            <a href="<?= BASE_URL ?>" class="list-group-item dashboard-active" id="active">
                <i class="bi bi-grid-fill me-2"></i> Dashboard
            </a>

            <a href="#patientMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-people me-2"></i> Patients</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="patientMenu">
                <a href="#" class="list-group-item">Add New Patient</a>
                <a href="#" class="list-group-item">Patient List</a>
                <a href="#" class="list-group-item">OPD Patient</a>
                <a href="#" class="list-group-item">IPD Patients</a>
                <a href="#" class="list-group-item">Patient Documents</a>
                <a href="#" class="list-group-item">Patient History</a>
                <a href="#" class="list-group-item">Discharge Summary</a>
            </div>

            <a href="#appointMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-calendar-check me-2"></i> Appointment</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="appointMenu">
                <a href="<?= BASE_URL ?>appointment/book-appointment" class="list-group-item">Book Appointment</a>
                <a href="<?= BASE_URL ?>appointment/appointment-list" class="list-group-item">Appointment List</a>
                <a href="#" class="list-group-item">Doctor-wise Schedule</a>
                <a href="#" class="list-group-item">Reschedule / Cancel</a>
                <a href="#" class="list-group-item">Online Appointments</a>
            </div>

            <a href="#docMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-person-badge me-2"></i> Doctor Management</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="docMenu">
                <a href="#" class="list-group-item">Add Doctor</a>
                <a href="#" class="list-group-item">Doctor List</a>
                <a href="#" class="list-group-item">Doctor Schedule</a>
                <a href="#" class="list-group-item">Specialization</a>
                <a href="#" class="list-group-item">Consultation Charges</a>
            </div>
            <a href="#opdIpdMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-hospital me-2"></i> OPD / IPD</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="opdIpdMenu">
                <a href="#" class="list-group-item">OPD Registration</a>
                <a href="#" class="list-group-item">IPD Admission</a>
                <a href="#" class="list-group-item">Bed Allocation</a>
                <a href="#" class="list-group-item">Ward Management</a>
                <a href="#" class="list-group-item">Room Transfer</a>
                <a href="#" class="list-group-item">Discharge Process</a>
            </div>

            <a href="#billingMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-wallet2 me-2"></i> Billing & Payments</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="billingMenu">
                <a href="#" class="list-group-item">Generate Bill</a>
                <a href="#" class="list-group-item">OPD Billing</a>
                <a href="#" class="list-group-item">Insurance Billing</a>
                <a href="#" class="list-group-item">Payment History</a>
                <a href="#" class="list-group-item">Tax Reports</a>
            </div>

            <a href="#labMenu1" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-droplet-half me-2"></i> Laboratory</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="labMenu1">
                <a href="#" class="list-group-item">Lab Test Categories</a>
                <a href="#" class="list-group-item">Add Test</a>
                <a href="#" class="list-group-item">Test Request</a>
                <a href="#" class="list-group-item">Sample Collection</a>
                <a href="#" class="list-group-item">Test Reports</a>
                <a href="#" class="list-group-item">Report Printing</a>
            </div>

            <a href="#labMenu2" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-radioactive me-2"></i> Radiology</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="labMenu2">
                <a href="#" class="list-group-item">X-Ray</a>
                <a href="#" class="list-group-item">MRI</a>
                <a href="#" class="list-group-item">CT Scan</a>
                <a href="#" class="list-group-item">Ultrasound</a>
                <a href="#" class="list-group-item">Radiology Reports</a>
            </div>

            <a href="#labMenu3" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-capsule me-2"></i> Pharmacy</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="labMenu3">
                <a href="#" class="list-group-item">Add Medicine</a>
                <a href="#" class="list-group-item">Stock Management</a>
                <a href="#" class="list-group-item">Purchase Entry</a>
                <a href="#" class="list-group-item">Sale / Issue Medicine</a>
                <a href="#" class="list-group-item">Expiry Tracking</a>
                <a href="#" class="list-group-item">Supplier Management</a>
            </div>

            <a href="#labMenu4" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion" class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-scissors me-2"></i> Operation Theatre</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="labMenu4">
                <a href="#" class="list-group-item">OT Schedule</a>
                <a href="#" class="list-group-item">Surgery List</a>
                <a href="#" class="list-group-item">Surgeon Assignment</a>
                <a href="#" class="list-group-item">Pre / Post Operation Notes</a>
            </div>

            <a href="#ambulanceMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-truck-front me-2"></i> Ambulance</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="ambulanceMenu">
                <a href="#" class="list-group-item">Add Ambulance</a>
                <a href="#" class="list-group-item">Ambulance List</a>
                <a href="#" class="list-group-item">Driver Management</a>
                <a href="#" class="list-group-item">Ambulance Requests</a>
                <a href="#" class="list-group-item">Trip History</a>
            </div>

            <a href="#nurseMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-heart-pulse me-2"></i> Nurse Station</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="nurseMenu">
                <a href="#" class="list-group-item">Patient Vitals</a>
                <a href="#" class="list-group-item">Medication Schedule</a>
                <a href="#" class="list-group-item">Nursing Notes</a>
                <a href="#" class="list-group-item">Shift Management</a>
            </div>

            <a href="#hrMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-people-fill me-2"></i> Staff</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="hrMenu">
                <a href="#" class="list-group-item">Add Staff</a>
                <a href="#" class="list-group-item">Staff List</a>
                <a href="#" class="list-group-item">Attendance</a>
                <a href="#" class="list-group-item">Leave Management</a>
                <a href="#" class="list-group-item">Payroll</a>
                <a href="#" class="list-group-item">Roles & Permissions</a>
            </div>

            <a href="#inventoryMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-box-seam me-2"></i> Inventory</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="inventoryMenu">
                <a href="#" class="list-group-item">Medical Equipment</a>
                <a href="#" class="list-group-item">Consumables</a>
                <a href="#" class="list-group-item">Stock In / Out</a>
                <a href="#" class="list-group-item">Low Stock Alert</a>
            </div>

            <a href="#reportMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-bar-chart-line me-2"></i> Reports</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="reportMenu">
                <a href="#" class="list-group-item">Daily / Monthly Reports</a>
                <a href="#" class="list-group-item">Patient Reports</a>
                <a href="#" class="list-group-item">Revenue Reports</a>
                <a href="#" class="list-group-item">Doctor Reports</a>
                <a href="#" class="list-group-item">Pharmacy Reports</a>
                <a href="#" class="list-group-item">Lab Reports</a>
            </div>

            <a href="#accountsMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-currency-rupee me-2"></i> Accounts</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="accountsMenu">
                <a href="#" class="list-group-item">Income</a>
                <a href="#" class="list-group-item">Expenses</a>
                <a href="#" class="list-group-item">Profit & Loss</a>
                <a href="#" class="list-group-item">Cash / Bank Report</a>
            </div>

            <a href="#communicationMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-chat-dots me-2"></i> Communication</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="communicationMenu">
                <a href="#" class="list-group-item">SMS Alerts</a>
                <a href="#" class="list-group-item">Email Notifications</a>
                <a href="#" class="list-group-item">WhatsApp Integration</a>
            </div>
            <a href="#settingsMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-gear-fill me-2"></i> Settings</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="settingsMenu">
                <a href="#" class="list-group-item">Hospital Profile</a>
                <a href="#" class="list-group-item">Department Setup</a>
                <a href="#" class="list-group-item">Bed Types</a>
                <a href="#" class="list-group-item">Charges Configuration</a>
                <a href="#" class="list-group-item">User Management</a>
                <a href="#" class="list-group-item">Backup & Restore</a>
            </div>
            <a href="#helpMenu" data-bs-toggle="collapse" data-bs-parent="#sidebar-accordion"
                class="list-group-item d-flex justify-content-between align-items-center collapsed">
                <span><i class="bi bi-question-circle me-2"></i> Help / Support</span>
                <i class="bi bi-chevron-down small"></i>
            </a>
            <div class="collapse ms-2" id="helpMenu">
                <a href="#" class="list-group-item">Help Center</a>
                <a href="#" class="list-group-item">User Guide</a>
                <a href="#" class="list-group-item">Support Tickets</a>
            </div>
        </div>
    </div>
</div> -->