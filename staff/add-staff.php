<?php
ob_start();
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require __DIR__ . '/../api/login/auth.php';
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");

$claims = require_auth();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$role = $claims['role'];
$name = $claims['name'];
$username = $claims['username'] ?? '';
$permissions = $claims['permissions'] ?? [];

if ($role !== 'admin' && !in_array('staff_add', $permissions)) {
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
                        <span>Add Staff</span>
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
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-12">
                <div class="appointment-list d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <h6 class="text-white mt-2">Please Fill in the Details to add Staff</h6>
                </div>
            </div>

            <div class="col-12">
                <div class="appointment-form-top">
                    <span class="corner tr"></span>
                    <span class="corner bl"></span>
                    <div class="step-wizard">
                        <button type="button" class="step-btn active" data-step="1">
                            Personal Details
                        </button>
                        <span class="step-line"></span>

                        <button type="button" class="step-btn" data-step="2" disabled>
                            Address Details
                        </button>
                        <span class="step-line"></span>

                        <button type="button" class="step-btn" data-step="3" disabled>
                            Employment Details
                        </button>
                        <span class="step-line"></span>

                        <button type="button" class="step-btn" data-step="4" disabled>
                            Document Upload
                        </button>
                        <span class="step-line"></span>

                        <button type="button" class="step-btn" data-step="5" disabled>
                            Access & Authentication
                        </button>
                    </div>
                </div>
                <div class="appointment-form add-staff-form mt-3">
                    <span class="corner tr"></span>
                    <span class="corner bl"></span>
                    <form id="staffForm" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <div id="step-1" class="step-section active" data-step="1">
                            <div class="row">
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="first_name" id="first_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="form-input" required>
                                        <label for="first_name">First Name <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="last_name" id="last_name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="form-input">
                                        <label for="last_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="fname" id="fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="form-input" required>
                                        <label for="father_name">Father's Name <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="mname" id="mname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" class="form-input">
                                        <label for="father_name">Mother's Name</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="mobile" id="mobile" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-input" required>
                                        <label for="father_name">Mobile Number <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="email" id="email" class="form-input" required>
                                        <label for="father_name">Email Id <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group required">
                                        <input type="date" name="dob" id="dob" class="form-input" required>
                                        <label for="dob">Date of Birth <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="gender-group">
                                        <label class="gender-label">
                                            Gender <span>*</span>
                                        </label>

                                        <div class="gender-options">
                                            <label class="gender-card">
                                                <input type="radio" name="gender" value="male" required>
                                                <span class="custom-radio"></span>
                                                Male
                                            </label>

                                            <label class="gender-card">
                                                <input type="radio" name="gender" value="female">
                                                <span class="custom-radio"></span>
                                                Female
                                            </label>

                                            <label class="gender-card">
                                                <input type="radio" name="gender" value="other">
                                                <span class="custom-radio"></span>
                                                Other
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group required">
                                        <select name="religion" id="religion" class="form-input" required>
                                            <option value="" disabled selected hidden>--Select Religion--</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Islam">Islam</option>
                                            <option value="Christian">Christian</option>
                                            <option value="Sikh">Sikh</option>
                                            <option value="Buddhist">Buddhist</option>
                                            <option value="Jain">Jain</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <label for="religion">Religion <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group">
                                        <input type="text" name="bgroup" id="bgroup" class="form-input blood-uppercase">
                                        <label for="bgroup">Blood Group</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group required">
                                        <select name="marital_status" id="marital_status" class="form-input" required>
                                            <option value="" disabled selected hidden>--Select One--</option>
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Widowed">Widowed</option>
                                            <option value="Divorced">Divorced</option>
                                        </select>
                                        <label for="religion">Marital Status <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-3 col-md-6">
                                    <div class="form-group required">
                                        <select name="nationality" id="nationality" class="form-input" required>
                                            <option value="Indian" selected>Indian</option>
                                            <option value="Afghan">Afghan</option>
                                            <option value="Albanian">Albanian</option>
                                            <option value="American">American</option>
                                            <option value="Australian">Australian</option>
                                            <option value="Bangladeshi">Bangladeshi</option>
                                            <option value="British">British</option>
                                            <option value="Canadian">Canadian</option>
                                            <option value="Chinese">Chinese</option>
                                            <option value="French">French</option>
                                            <option value="German">German</option>
                                            <option value="Indonesian">Indonesian</option>
                                            <option value="Italian">Italian</option>
                                            <option value="Japanese">Japanese</option>
                                            <option value="Nepalese">Nepalese</option>
                                            <option value="Pakistani">Pakistani</option>
                                            <option value="Russian">Russian</option>
                                            <option value="Sri Lankan">Sri Lankan</option>
                                            <option value="South African">South African</option>
                                            <option value="Thai">Thai</option>
                                            <option value="Ukrainian">Ukrainian</option>
                                            <option value="Vietnamese">Vietnamese</option>
                                            <option value="Other">Other</option>
                                        </select>
                                        <label for="nationality">Nationality</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="appintment-btn">
                                        <button type="button" onclick="nextStep()">Save & Next ➡</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 Start-->
                        <div id="step-2" class="step-section" data-step="2">
                            <p class="present-address">Permanent Address</p>
                            <div class="row mt-4">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="full_address" id="full_address" class="form-input" required>
                                        <label>Address <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="post" id="post" class="form-input" required>
                                        <label>City <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="police" id="police" class="form-input" required>
                                        <label>Police Station <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="dist" id="dis" class="form-input" required>
                                        <label>District <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="state" id="state" class="form-input" required>
                                            <option disabled selected value="">--Select State--</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">
                                                Dadra and Nagar Haveli and Daman and Diu
                                            </option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                        <label>State <sup><span style="color:red">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="pincode" id="pincode" pattern="[0-9]{6}" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-input" required>
                                        <label>Pincode <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-check mb-4">
                                <input class="form-check-input" type="checkbox" id="sameAddress">
                                <label class="form-check-label-present" for="sameAddress">
                                    Present Address same as Permanent Address
                                </label>
                            </div>
                            <p class="present-address">Present Address</p>
                            <div class="row mt-4">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="p_full_address" id="p_full_address" class="form-input" required>
                                        <label>Address <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="p_post" id="p_post" class="form-input" required>
                                        <label>City <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="p_police" id="p_police" class="form-input" required>
                                        <label>Police Station <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="p_dist" id="p_dis" class="form-input" required>
                                        <label>District <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="p_state" id="p_state" class="form-input" required>
                                            <option disabled selected value="">--Select State--</option>
                                            <option value="Andaman and Nicobar Islands">Andaman and Nicobar Islands</option>
                                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                                            <option value="Assam">Assam</option>
                                            <option value="Bihar">Bihar</option>
                                            <option value="Chandigarh">Chandigarh</option>
                                            <option value="Chhattisgarh">Chhattisgarh</option>
                                            <option value="Dadra and Nagar Haveli and Daman and Diu">
                                                Dadra and Nagar Haveli and Daman and Diu
                                            </option>
                                            <option value="Delhi">Delhi</option>
                                            <option value="Goa">Goa</option>
                                            <option value="Gujarat">Gujarat</option>
                                            <option value="Haryana">Haryana</option>
                                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                                            <option value="Jharkhand">Jharkhand</option>
                                            <option value="Karnataka">Karnataka</option>
                                            <option value="Kerala">Kerala</option>
                                            <option value="Ladakh">Ladakh</option>
                                            <option value="Lakshadweep">Lakshadweep</option>
                                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                                            <option value="Maharashtra">Maharashtra</option>
                                            <option value="Manipur">Manipur</option>
                                            <option value="Meghalaya">Meghalaya</option>
                                            <option value="Mizoram">Mizoram</option>
                                            <option value="Nagaland">Nagaland</option>
                                            <option value="Odisha">Odisha</option>
                                            <option value="Puducherry">Puducherry</option>
                                            <option value="Punjab">Punjab</option>
                                            <option value="Rajasthan">Rajasthan</option>
                                            <option value="Sikkim">Sikkim</option>
                                            <option value="Tamil Nadu">Tamil Nadu</option>
                                            <option value="Telangana">Telangana</option>
                                            <option value="Tripura">Tripura</option>
                                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                                            <option value="Uttarakhand">Uttarakhand</option>
                                            <option value="West Bengal">West Bengal</option>
                                        </select>
                                        <label>State <sup><span style="color:red">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="p_pincode" id="p_pincode" pattern="[0-9]{6}" maxlength="6" oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-input" required>
                                        <label>Pincode <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" onclick="prevStep()" class="btn-prev">⬅ Previous</button>
                                    <button type="button" onclick="nextStep()" class="btn-next">Save & Next ➡</button>
                                </div>
                            </div>
                        </div>
                        <!-- Step 2 end here -->

                        <!-- step 3 here start-->
                        <div id="step-3" class="step-section" data-step="3">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="role" id="role" class="form-input" required>
                                            <option value="" disabled selected hidden>--Select Role--</option>
                                            <option value="admin">Admin</option>
                                            <option value="accountant">Accountant</option>
                                            <option value="nurse">Nurse</option>
                                            <option value="laboratory">Laboratory</option>
                                            <option value="pharmacy">Pharmacy</option>
                                            <option value="radiology">Radiology</option>
                                            <option value="patient_coordinator">Patient Coordinator</option>
                                            <option value="ot_coordinator">OT Coordinator</option>
                                            <option value="ambulance_coordinator">Ambulance Coordinator</option>
                                            <option value="inventory_manager">Inventory Manager</option>
                                            <option value="support">Support</option>
                                            <option value="patient">Patient</option>
                                        </select>
                                        <label>Role <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="emp_type" id="emp_type" class="form-input" required>
                                            <option value="" disabled selected>--Select Employee Type--</option>
                                            <option value="permanent">Permanent</option>
                                            <option value="contract">Contract</option>
                                            <option value="probation">Probation</option>
                                            <option value="intern">Intern</option>
                                        </select>
                                        <label>Employee Type <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="date" name="date_of_joining" id="date_of_joining" class="form-input" required>
                                        <label>Date of Joining <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="bank" id="bank" class="form-input">
                                            <option value="" disabled selected hidden>--Select Bank--</option>
                                            <option value="State Bank of India">State Bank of India</option>
                                            <option value="Bank of Baroda">Bank of Baroda</option>
                                            <option value="Bank of India">Bank of India</option>
                                            <option value="Canara Bank">Canara Bank</option>
                                            <option value="Central Bank of India">Central Bank of India</option>
                                            <option value="Punjab National Bank">Punjab National Bank</option>
                                            <option value="Union Bank of India">Union Bank of India</option>
                                            <option value="UCO Bank">UCO Bank</option>
                                            <option value="Indian Bank">Indian Bank</option>
                                            <option value="Indian Overseas Bank">Indian Overseas Bank</option>
                                            <option value="Bank of Maharashtra">Bank of Maharashtra</option>
                                            <option value="Punjab & Sind Bank">Punjab & Sind Bank</option>
                                            <option value="HDFC Bank">HDFC Bank</option>
                                            <option value="ICICI Bank">ICICI Bank</option>
                                            <option value="Axis Bank">Axis Bank</option>
                                            <option value="Kotak Mahindra Bank">Kotak Mahindra Bank</option>
                                            <option value="IndusInd Bank">IndusInd Bank</option>
                                            <option value="IDFC FIRST Bank">IDFC FIRST Bank</option>
                                            <option value="RBL Bank">RBL Bank</option>
                                            <option value="Bandhan Bank">Bandhan Bank</option>
                                            <option value="CSB Bank">CSB Bank</option>
                                            <option value="City Union Bank">City Union Bank</option>
                                            <option value="DCB Bank">DCB Bank</option>
                                            <option value="Dhanlaxmi Bank">Dhanlaxmi Bank</option>
                                            <option value="Federal Bank">Federal Bank</option>
                                            <option value="South Indian Bank">South Indian Bank</option>
                                            <option value="Tamilnad Mercantile Bank">Tamilnad Mercantile Bank</option>
                                            <option value="Jammu & Kashmir Bank">Jammu & Kashmir Bank</option>
                                            <option value="Karnataka Bank">Karnataka Bank</option>
                                            <option value="Karur Vysya Bank">Karur Vysya Bank</option>
                                            <option value="Yes Bank">Yes Bank</option>
                                        </select>
                                        <label for="bank">Bank Name <sup><span style="color:red">*</span></sup></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <select name="pay_cycle" id="pay_cycle" class="form-input" required>
                                            <option value="" disabled selected hidden>--Select Paycycle--</option>
                                            <option value="monthly">Monthly</option>
                                            <option value="fortnightly">Fortnightly</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="biweekly">Bi-Weekly</option>
                                        </select>
                                        <label>Paycycle</label>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-4">
                                    <div class="form-group">
                                        <input type="text" name="salary" id="salary" class="form-input" required>
                                        <label>Basic Salary <sup><span style="color: red;">*</span></sup></label>
                                    </div>

                                    <div id="salaryBreakdownContainer">
                                        <!-- Additional rows will appear here -->
                                    </div>
                                    <button type="button" id="addSalaryRow" class="add-more-btn">
                                        <i class="bi bi-plus-circle"></i> Add More
                                    </button>
                                </div>
                            </div>
                            <!-- Buttons -->
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" onclick="prevStep()" class="btn-prev">⬅ Previous</button>
                                    <button type="button" onclick="nextStep()" class="btn-next">Save & Next ➡</button>
                                </div>
                            </div>
                        </div>

                        <!-- Step 4 start here -->
                        <div id="step-4" class="step-section" data-step="4">
                            <div class="row">
                                <div class="col-12 col-lg-3">
                                    <div class="form-group custom-file-input">
                                        <input type="file" name="adhar" id="adhar" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="adhar">Upload Aadhar (PDF/JPG/PNG)</label>
                                    </div>
                                    <div class="preview-area"></div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-group custom-file-input">
                                        <input type="file" name="certificate" id="certificate" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="certificate">Upload Certificate</label>
                                    </div>
                                    <div class="preview-area"></div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-group custom-file-input">
                                        <input type="file" name="experience_letter" id="experience_letter" class="form-input" accept=".pdf,.jpg,.jpeg,.png">
                                        <label for="experience_letter">Upload Experience Letter</label>
                                    </div>
                                    <div class="preview-area"></div>
                                </div>

                                <div class="col-12 col-lg-3">
                                    <div class="form-group custom-file-input">
                                        <input type="file" name="image" id="image" class="form-input" accept=".jpg,.jpeg,.png">
                                        <label for="image">Upload Passport Size Image</label>
                                    </div>
                                    <div class="preview-area"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" onclick="prevStep()" class="btn-prev">⬅ Previous</button>
                                    <button type="button" onclick="nextStep()" class="btn-next">Save & Next ➡</button>
                                </div>
                            </div>
                        </div>
                        <div id="step-5" class="step-section" data-step="5">
                            <div class="row">
                                <div class="col-12 col-lg-4">
                                    <div class="form-group custom-file-input">
                                        <input type="text" name="username" id="username" class="form-input" required>
                                        <label for="adhar">Username <sup><span style="color: red;">*</span></sup></label>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-group custom-file-input">
                                        <input type="password" name="password" id="pass" minlength="6"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$" class="form-input" required>
                                        <label for="password">Password <sup><span style="color: red;">*</span></sup></label>
                                        <span class="toggle-pass" onclick="togglePassword('pass')">Show</span>
                                    </div>
                                </div>

                                <div class="col-12 col-lg-4">
                                    <div class="form-group custom-file-input">
                                        <input type="password" name="cnf_password" id="cnf_password" minlength="6"
                                            pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$" class="form-input" required>
                                        <label for="confirmpassword">confirm Password <sup><span style="color: red;">*</span></sup></label>
                                        <span class="toggle-pass" onclick="togglePassword('cnf_password')">Show</span>
                                    </div>
                                </div>
                                <div class="col-12 col-lg-12">
                                    <p class="mb-3 check-access">Check Access for User</p>
                                    <div class="row g-3">
                                        <?php
                                        $fetch = $conn->prepare("SELECT * FROM permissions");
                                        $fetch->execute();
                                        $result = $fetch->get_result();
                                        $data = [];
                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $data[] = $row;
                                            }
                                        }
                                        ?>
                                        <?php foreach ($data as $row): ?>
                                            <div class="col-lg-3 col-md-6 col-12">
                                                <label class="access-card">
                                                    <input type="checkbox" name="access[]" value="<?= $row['id']; ?>">
                                                    <?= $row['permission_name']; ?>
                                                </label>
                                            </div>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 d-flex justify-content-end gap-2">
                                    <button type="button" onclick="prevStep()" class="btn-prev">⬅ Previous</button>
                                    <button type="button" class="btn-next" onclick="finalSubmit()"><i class="bi bi-send-fill me-2"></i>Submit</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    const totalSteps = 5;
    let currentStep = localStorage.getItem("currentStep") ?
        parseInt(localStorage.getItem("currentStep")) :
        1;

    let completedStep = localStorage.getItem("completedStep") ?
        parseInt(localStorage.getItem("completedStep")) :
        1;
    const sections = document.querySelectorAll(".step-section");
    const stepBtns = document.querySelectorAll(".step-btn");
    const stepLines = document.querySelectorAll(".step-line");

    function showStep(step) {

        sections.forEach(sec => {
            sec.classList.toggle(
                "active",
                parseInt(sec.dataset.step) === step
            );
        });
        stepBtns.forEach(btn => {
            const btnStep = parseInt(btn.dataset.step);

            btn.classList.remove("active", "completed");
            btn.disabled = true;

            if (btnStep < completedStep) {
                btn.classList.add("completed");
                btn.disabled = false;
            }
            if (btnStep === step) {
                btn.classList.add("active");
                btn.disabled = false;
            }
        });
        stepLines.forEach((line, i) => {
            line.classList.toggle("filled", i < completedStep - 1);
        });

        localStorage.setItem("currentStep", step);
    }

    function prevStep() {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    }
    stepBtns.forEach(btn => {
        btn.addEventListener("click", () => {
            const step = parseInt(btn.dataset.step);

            if (step <= completedStep) {
                currentStep = step;
                showStep(step);
            }
        });
    });
    showStep(currentStep);
    const form = document.getElementById("staffForm");
    /* save on change */
    form.querySelectorAll("input, select, textarea").forEach(field => {
        field.addEventListener("change", () => {
            saveFormData();
        });
    });

    function saveFormData() {
        const data = {};

        form.querySelectorAll("input, select, textarea").forEach(field => {
            if (field.name === "csrf_token") return;
            if (field.type === "radio") {
                if (field.checked) {
                    data[field.name] = field.value;
                }
            } else if (field.type === "checkbox") {
                if (!data[field.name]) {
                    data[field.name] = [];
                }
                if (field.checked) {
                    data[field.name].push(field.value);
                }
            } else {
                data[field.name] = field.value;
            }
        });

        localStorage.setItem("staffFormData", JSON.stringify(data));
    }
    document.addEventListener("DOMContentLoaded", () => {
        const form = document.getElementById("staffForm");
        const sameAddress = document.getElementById("sameAddress");

        const addressMap = [
            ["full_address", "p_full_address"],
            ["post", "p_post"],
            ["police", "p_police"],
            ["dis", "p_dis"],
            ["state", "p_state"],
            ["pincode", "p_pincode"]
        ];

        const savedData = localStorage.getItem("staffFormData");

        if (savedData) {
            const data = JSON.parse(savedData);

            Object.keys(data).forEach(name => {
                if (name === "csrf_token") return;

                const fields = form.querySelectorAll(`[name="${name}"]`);
                if (!fields.length) return;

                fields.forEach(field => {
                    if (field.type === "radio") {
                        field.checked = field.value === data[name];
                    } else if (field.type === "checkbox") {
                        if (Array.isArray(data[name])) {
                            field.checked = data[name].includes(field.value);
                        } else {
                            field.checked = data[name];
                        }
                    } else {
                        field.value = data[name];
                    }
                });
            });
            // Restore sameAddress state
            if (data.sameAddress) {
                sameAddress.checked = true;
                copyAddress();
            }
        }
        function copyAddress() {
            addressMap.forEach(([from, to]) => {
                const fromEl = document.getElementById(from);
                const toEl = document.getElementById(to);
                if (!fromEl || !toEl) return;
                if (sameAddress.checked) {
                    toEl.value = fromEl.value;
                    if (toEl.tagName === "SELECT") {
                        toEl.style.pointerEvents = "none";
                    } else {
                        toEl.readOnly = true; 
                    }
                    toEl.style.background = "#f1f1f1";
                } else {
                    if (toEl.tagName === "SELECT") {
                        toEl.style.pointerEvents = "";
                    } else {
                        toEl.readOnly = false;
                    }
                    toEl.style.background = "";
                }
            });
        }
        sameAddress.addEventListener("change", function() {
            copyAddress();

            const formData = JSON.parse(localStorage.getItem("staffFormData") || "{}");
            formData.sameAddress = this.checked;
            localStorage.setItem("staffFormData", JSON.stringify(formData));
        });
    });
    const addBtn = document.getElementById("addSalaryRow");
    const container = document.getElementById("salaryBreakdownContainer");

    addBtn.addEventListener("click", () => {
        const row = document.createElement("div");
        row.classList.add("salary-row");

        row.innerHTML = `
            <div class="form-group">
                <input type="text" class="form-input small-input" name="salary_name[]">
                <label>Salary Name</label>
            </div>
            <div class="form-group">
                <input type="text" class="form-input small-input" name="salary_amount[]">
                <label>Amount</label>
            </div>
            <button type="button" class="btn-remove" title="Remove">
                <i class="bi bi-trash"></i>
            </button>
        `;
        container.appendChild(row);

        // Remove functionality
        row.querySelector(".btn-remove").addEventListener("click", () => {
            row.remove();
        });
    });

    function togglePassword(id) {
        const input = document.getElementById(id);
        const toggle = input.nextElementSibling; // span element
        if (input.type === "password") {
            input.type = "text";
        } else {
            input.type = "password";
        }
    }
    document.querySelectorAll('#step-4 input[type="file"]').forEach(input => {
        input.addEventListener('change', function() {
            const file = this.files[0];
            if (!file) return;
            const previewArea = this.closest('.col-lg-3').querySelector('.preview-area');
            previewArea.innerHTML = "";
            // 🔒 2MB Validation
            if (file.size > 2 * 1024 * 1024) {
                showToast("File must be less than 2MB");
                this.value = "";
                return;
            }
            const fileType = file.type;
            const fileURL = URL.createObjectURL(file);
            const isImageField = this.id === "image";
            let card = document.createElement("div");
            card.className = "preview-card";
            // Passport Image → Only Image
            if (isImageField && !fileType.startsWith('image/')) {
                showToast("Only JPG, JPEG, PNG allowed for Passport Image");
                this.value = "";
                return;
            }
            // IMAGE PREVIEW
            if (fileType.startsWith('image/')) {
                card.innerHTML = `
                <img src="${fileURL}" class="preview-img">
                <div class="status-check">✔</div>
                <button type="button" class="remove-btn-staff">✖</button>
            `;
            }
            // PDF PREVIEW
            else if (fileType === "application/pdf") {
                card.innerHTML = `
                <div class="pdf-icon">📄</div>
                <div>
                    <div style="font-weight:600;font-size:14px;">Pdf Uploaded</div>
                    <a href="${fileURL}" download="${file.name}" class="view-btn">Download</a>
                </div>
                <div class="status-check">✔</div>
                <button type="button" class="remove-btn-staff">✖</button>
            `;
            } else {
                alert("Invalid file type");
                this.value = "";
                return;
            }
            previewArea.appendChild(card);
            // Remove Button
            card.querySelector(".remove-btn-staff").addEventListener("click", () => {
                this.value = "";
                previewArea.innerHTML = "";
            });
        });
    });
    // Validation and submit process here 
    function validateCurrentStep() {
        const currentSection = document.querySelector(`#step-${currentStep}`);
        const requiredFields = currentSection.querySelectorAll("[required]");
        for (let field of requiredFields) {
            if (field.type === "radio") {
                const radios = currentSection.querySelectorAll(`input[name="${field.name}"]`);
                const isChecked = Array.from(radios).some(r => r.checked);

                if (!isChecked) {
                    showToast(`Please select ${field.name.replace("_", " ")}`);
                    radios[0].focus();
                    return false;
                }
                continue;
            }
            if (field.type === "checkbox") {
                if (!field.checked) {
                    showToast(`Please check ${field.name.replace("_", " ")}`);
                    field.focus();
                    return false;
                }
                continue;
            }
            if (!field.value || field.value.trim() === "") {
                let label = currentSection.querySelector(`label[for="${field.id}"]`);
                let fieldName = label ? label.innerText.replace("*", "").trim() : field.name;
                showToast(`Please enter ${fieldName}`);
                field.focus();
                return false;
            }
            if (field.name === "mobile" || field.id === "mobile") {
                const mobilePattern = /^[0-9]{10}$/;
                if (!mobilePattern.test(field.value.trim())) {
                    showToast("Please enter a valid 10-digit mobile number");
                    field.focus();
                    return false;
                }
            }
            if (field.name === "pincode" || field.id === "pincode") {
                const pincodePattern = /^[0-9]{6}$/;
                if (!pincodePattern.test(field.value.trim())) {
                    showToast("Please enter a valid 6-digit pincode");
                    field.focus();
                    return false;
                }
            }
        }
        return true;
    }

    function nextStep() {
        if (!validateCurrentStep()) return;
        if (currentStep < totalSteps) {
            completedStep = Math.max(completedStep, currentStep + 1);
            currentStep++;
            localStorage.setItem("completedStep", completedStep);
            showStep(currentStep);
        }
    }

    async function finalSubmit() {
        if (!validateCurrentStep()) return;
        // Password match validation
        const pass = document.getElementById("pass").value;
        const cnf = document.getElementById("cnf_password").value;

        const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&]).{6,}$/;

        if (!strongRegex.test(pass)) {
            showToast("Password must be at least 6 characters with uppercase, lowercase, number and special character");
            return;
        }
        if (!cnf) {
            showToast("Please confirm your password");
            document.getElementById("cnf_password").focus();
            return;
        }
        if (pass !== cnf) {
            showToast("Passwords do not match");
            document.getElementById("cnf_password").focus();
            return;
        }
        const accessCheckboxes = document.querySelectorAll('input[name="access[]"]');
        const isAnyChecked = Array.from(accessCheckboxes).some(cb => cb.checked);
        if (!isAnyChecked) {
            showToast("Please select at least one access permission");
            accessCheckboxes[0].focus();
            return;
        }

        // for send the data on server
        const form = document.getElementById('staffForm');
        if (!form) {
            console.error("Form not found");
            return;
        }
        const formData = new FormData(form);
        try {
            const response = await fetch("<?= BASE_URL ?>api/staff/create.php", {
                method: 'POST',
                body: formData,
                credentials: "same-origin"
            });
            const result = await response.json();
            console.log(result);
            if (result.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: result.message,
                    confirmButtonColor: '#28a745'
                }).then(() => {

                    localStorage.removeItem("currentStep");
                    localStorage.removeItem("completedStep");
                    localStorage.removeItem("staffFormData");
                    window.location.href = "<?= BASE_URL ?>/staff/add-staff";
                });
            } else {
                showToast(result.message || "Something went wrong");
            }
        } catch (error) {
            console.error(error);
            showToast("Server Error");
        }
    }

    function showToast(message) {
        Toastify({
            text: message,
            duration: 3000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#FF0000",
            stopOnFocus: true,
        }).showToast();
    }
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>