<?php
ob_start();
?>
<?php
session_start();
include 'config.php';

$error = $_GET['error'] ?? '';
$msg = '';
$type = 'error';

if ($error === 'required') {
    $msg = "Username, password, and role are required.";
} else if ($error === 'method') {
    $msg = "Only POST method is allowed.";
} else if ($error === 'invalid_role') {
    $msg = "Invalid role. Please select your correct role.";
} else if ($error === 'invalid') {
    $msg = "Invalid username, password, or role. Please check and try again.";
} else if ($error === 'logout') {
    $msg = "You have successfully logged out.";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Hospital ERP Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
    <link rel="stylesheet" href="<?= BASE_URL ?>css/login.css">
</head>

<body>
    <div class="login-bg">
        <!-- LEFT SIDE CONTENT -->
        <div class="login-left-content">
            <h1 class="erp-title">Hospital Management ERP</h1>
            <p style="text-align: justify;">
                A secure and intelligent hospital ERP solution designed to streamline
                patient care, staff management, pharmacy, laboratory, billing,
                and administrative operations — all from one centralized platform.
            </p>
            <ul class="erp-features">
                <li><span>Patient & Appointment Management</span></li>
                <li><span>Doctor, Nurse & Staff Role-Based Access</span></li>
                <li><span>Integrated Pharmacy & Laboratory System</span></li>
                <li><span>Accounts, Billing & Financial Reports</span></li>
                <li><span>Enterprise-Grade Secure Login System</span></li>
            </ul>
        </div>
        <!-- RIGHT SIDE LOGIN FORM -->
        <div class="login-card">
            <h2>Welcome Back</h2>
            <p>Login to access your dashboard</p>
            <form action="api/login/login.php" method="POST">
                <div class="form-group">
                    <label>Select Role</label>
                    <select name="role" id="role">
                        <option value="">Choose Role</option>
                        <optgroup label="Management">
                            <option value="admin">Admin</option>
                            <option value="accountant">Accountant</option>
                        </optgroup>
                        <optgroup label="Medical Staff">
                            <option value="doctor">Doctor</option>
                            <option value="nurse">Nurse</option>
                            <option value="laboratory">Laboratory</option>
                            <option value="pharmacy">Pharmacy</option>
                            <option value="radiology">Radiology</option>
                        </optgroup>
                        <optgroup label="Operations & Coordination">
                            <option value="patient_coordinator">Patient Coordinator</option>
                            <option value="ot_coordinator">OT Coordinator</option>
                            <option value="ambulance_coordinator">Ambulance Coordinator</option>
                        </optgroup>
                        <optgroup label="Inventory & Stores">
                            <option value="inventory_manager">Inventory Manager</option>
                        </optgroup>
                        <optgroup label="Support">
                            <option value="support">Support</option>
                        </optgroup>
                        <optgroup label="Patient">
                            <option value="patient">Patient</option>
                        </optgroup>
                    </select>
                </div>
                <div class="form-group">
                    <label>Username / Email</label>
                    <input type="text" name="username" id="username" placeholder="Enter username">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" id="password" placeholder="Enter password">
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>
        </div>
    </div>
    <script>
        const errorMsg = <?= json_encode($msg) ?>;

        if (errorMsg) {
            const bgColor = <?= json_encode($error === 'logout' ? '#2ecc71' : '#e74c3c') ?>;
            Toastify({
                text: errorMsg,
                duration: 3000,
                gravity: "top",
                position: "right",
                backgroundColor: bgColor,
                close: true,
            }).showToast();
        }
    </script>
    <script>
        if (window.history && window.history.pushState) {
            window.history.pushState(null, null, window.location.href);
            window.onpopstate = function() {
                window.location.replace('login?error=logout');
            };
        }
    </script>
</body>

</html>
<?php
ob_end_flush();
?>