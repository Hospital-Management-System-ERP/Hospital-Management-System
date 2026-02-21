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

if ($role !== 'admin' && !in_array('doctor_add', $permissions)) {
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
                        <span><i class="bi-person-badge me-1"></i> Doctor</span>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <span>Add Doctor</span>
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
                    <h6 class="text-white mt-2">Please Fill in the Details to Add Doctor</h6>
                </div>
            </div>

            <div class="col-12">
                <div class="doctor-form">
                    <span class="corner tr"></span>
                    <span class="corner bl"></span>
                    <form>
                        <div class="row">
                            <div class="col-12">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Personal Details</p>
                                    <div class="row mt-2">
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="name" class="form-label">
                                                    Name <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="name" class="form-control" id="name" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" placeholder="Enter Name" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="fname" class="form-label">
                                                    Father's Name <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="fname" class="form-control" id="fname" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" placeholder="Enter Father's Name" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="mobile" class="form-label">
                                                    Mobile Number <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="mobile" class="form-control" id="mobile" pattern="[0-9]{10}" maxlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Mobile No" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="email" class="form-label">
                                                    Email Id
                                                </label>
                                                <input type="email" name="email" class="form-control" id="email" placeholder="Enter Email Id">
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="dob" class="form-label">
                                                    Date of Birth <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="date" name="dob" class="form-control" id="email" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Gender <sup><span class="required">*</span></sup>
                                                </label>

                                                <div class="radio-group">
                                                    <label class="radio-box">
                                                        <input type="radio" name="gender" value="male" required>
                                                        <span class="custom-square"></span>
                                                        Male
                                                    </label>

                                                    <label class="radio-box">
                                                        <input type="radio" name="gender" value="female">
                                                        <span class="custom-square"></span>
                                                        Female
                                                    </label>

                                                    <label class="radio-box">
                                                        <input type="radio" name="gender" value="other">
                                                        <span class="custom-square"></span>
                                                        Other
                                                    </label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="religion" class="form-label">
                                                    Religion <sup><span class="required">*</span></sup>
                                                </label>
                                                <select name="religion" id="religion" class="form-control" required>
                                                    <option value="">-- Select Religion --</option>
                                                    <option value="Hinduism">Hinduism</option>
                                                    <option value="Islam">Islam</option>
                                                    <option value="Christianity">Christianity</option>
                                                    <option value="Sikhism">Sikhism</option>
                                                    <option value="Buddhism">Buddhism</option>
                                                    <option value="Jainism">Jainism</option>
                                                    <option value="Zoroastrianism">Zoroastrianism</option>
                                                    <option value="Judaism">Judaism</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="adhar" class="form-label">
                                                    Adhar Number <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="adhar" class="form-control" id="adhar" placeholder="1111 2222 3333" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="bloodgroup" class="form-label">
                                                    Blood Group
                                                </label>
                                                <input type="text" name="bgroup" class="form-control" id="bgroup" placeholder="A+,A-">
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="nationality" class="form-label">
                                                    Nationality <sup><span class="required">*</span></sup>
                                                </label>
                                                <select name="nationality" id="nationality" class="form-control" required>
                                                    <option value="India" selected>India</option>
                                                    <option value="Afghanistan">Afghanistan</option>
                                                    <option value="Australia">Australia</option>
                                                    <option value="Bangladesh">Bangladesh</option>
                                                    <option value="Canada">Canada</option>
                                                    <option value="China">China</option>
                                                    <option value="Germany">Germany</option>
                                                    <option value="Japan">Japan</option>
                                                    <option value="Nepal">Nepal</option>
                                                    <option value="Pakistan">Pakistan</option>
                                                    <option value="Sri Lanka">Sri Lanka</option>
                                                    <option value="United Kingdom">United Kingdom</option>
                                                    <option value="United States">United States</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="marital_status" class="form-label">
                                                    Marital Status <sup><span class="required">*</span></sup>
                                                </label>

                                                <select name="marital_status" id="marital_status" class="form-control" required>
                                                    <option value="">-- Select Marital Status --</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Unmarried">Unmarried</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Separated">Separated</option>
                                                    <option value="Widowed">Widowed</option>
                                                    <option value="Widower">Widower</option>
                                                    <option value="Engaged">Engaged</option>
                                                    <option value="Other">Other</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Professional Details</p>
                                    <div class="row mt-2">
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="qualification" class="form-label">
                                                    Qualification <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="qualification" class="form-control" id="qualification" placeholder="Enter Higher Qualification" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="medical_council" class="form-label">
                                                    Medical Council No.
                                                </label>
                                                <input type="text" name="council" class="form-control" id="council" placeholder="Enter Medical Council No.">
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="experience" class="form-label">
                                                    Experience <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="experience" class="form-control" id="experience" placeholder="Enter Experience" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="department" class="form-label">
                                                    Department <sup><span class="required">*</span></sup>
                                                </label>
                                                <select name="department" id="department" class="form-control" required>
                                                    <option value="">-- Select Department --</option>
                                                    <option value="General Medicine">General Medicine</option>
                                                    <option value="General Surgery">General Surgery</option>
                                                    <option value="Cardiology">Cardiology</option>
                                                    <option value="Neurology">Neurology</option>
                                                    <option value="Neurosurgery">Neurosurgery</option>
                                                    <option value="Orthopedics">Orthopedics</option>
                                                    <option value="Pediatrics">Pediatrics</option>
                                                    <option value="Gynecology & Obstetrics">Gynecology & Obstetrics</option>
                                                    <option value="Dermatology">Dermatology</option>
                                                    <option value="ENT (Otolaryngology)">ENT (Otolaryngology)</option>
                                                    <option value="Ophthalmology">Ophthalmology</option>
                                                    <option value="Psychiatry">Psychiatry</option>
                                                    <option value="Pulmonology">Pulmonology</option>
                                                    <option value="Gastroenterology">Gastroenterology</option>
                                                    <option value="Urology">Urology</option>
                                                    <option value="Nephrology">Nephrology</option>
                                                    <option value="Oncology">Oncology</option>
                                                    <option value="Endocrinology">Endocrinology</option>
                                                    <option value="Radiology">Radiology</option>
                                                    <option value="Anesthesiology">Anesthesiology</option>
                                                    <option value="Pathology">Pathology</option>
                                                    <option value="Emergency Medicine">Emergency Medicine</option>
                                                    <option value="Plastic Surgery">Plastic Surgery</option>
                                                    <option value="Dentistry">Dentistry</option>
                                                    <option value="Physiotherapy">Physiotherapy</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="consult_fee" class="form-label">
                                                    Consultancy Fees <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="consult_fee" class="form-control" id="consult_fee" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Consultancy Fees" required>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="available_day" class="form-label">
                                                    Available Day <sup><span class="required">*</span></sup>
                                                </label>
                                                <select name="available_day" id="available_day" class="form-control" required>
                                                    <option value="">-- Select Day --</option>
                                                    <option value="All">All Days</option>
                                                    <option value="Monday">Monday</option>
                                                    <option value="Tuesday">Tuesday</option>
                                                    <option value="Wednesday">Wednesday</option>
                                                    <option value="Thursday">Thursday</option>
                                                    <option value="Friday">Friday</option>
                                                    <option value="Saturday">Saturday</option>
                                                    <option value="Sunday">Sunday</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="from_time" class="form-label">
                                                    From Time <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="time" name="from_time" id="from_time" class="form-control" required>
                                            </div>
                                        </div>
                                        <!-- To Time -->
                                        <div class="col-12 col-lg-3 col-md-6">
                                            <div class="mb-3">
                                                <label for="to_time" class="form-label">
                                                    To Time <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="time" name="to_time" id="to_time" class="form-control" required>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label class="form-label">
                                                    Specialization <sup><span class="required">*</span></sup>
                                                </label>
                                                <div class="row">
                                                    <?php
                                                    $specialization = $conn->prepare("SELECT * FROM tbl_doctor_specializations WHERE status = 1");
                                                    $specialization->execute();
                                                    $result = $specialization->get_result();
                                                    if ($result->num_rows > 0) {
                                                        while ($row = $result->fetch_assoc()) {
                                                    ?>
                                                            <div class="col-12 col-lg-3 col-md-6 mb-3">
                                                                <label class="specialization-box d-flex align-items-center">
                                                                    <input type="checkbox"
                                                                        name="specialization[]"
                                                                        value="<?= $row['id']; ?>">
                                                                    <?= $row['specialization']; ?>
                                                                </label>
                                                            </div>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Parmanent Address</p>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="parmanent_address" class="form-label">
                                                    Full Address <sup><span class="required">*</span></sup>
                                                </label>
                                                <textarea name="permanent_address"
                                                    id="permanent_address"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Enter full address"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Present Address</p>
                                    <div class="row mt-2">
                                        <div class="col-12">
                                            <div class="mb-3">
                                                <label for="parmanent_address" class="form-label">
                                                    Full Address <sup><span class="required">*</span></sup>
                                                    <input class="form-check-input" type="checkbox" id="same_address" style="margin-left: 10px;">
                                                    <span>Same as Permanent Address</span>
                                                </label>
                                                <textarea name="permanent_address"
                                                    id="permanent_address"
                                                    class="form-control"
                                                    rows="3"
                                                    placeholder="Enter full address"
                                                    required></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Employee Details -->
                            <div class="col-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Employment Details</p>
                                    <div class="row mt-2">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="role" class="form-label">
                                                    Role <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="role" id="role" class="form-control" value="doctor" required readonly>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="emp_type" class="form-label">
                                                    Employee Type <sup><span class="required">*</span></sup>
                                                </label>
                                                <select name="emp_type" id="emp_type" class="form-control" required>
                                                    <option value="" disabled selected>--Select Employee Type--</option>
                                                    <option value="permanent">Permanent</option>
                                                    <option value="contract">Contract</option>
                                                    <option value="probation">Probation</option>
                                                    <option value="intern">Intern</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="date_of_joining" class="form-label">
                                                    Date of Joining <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="date" name="date_of_joining" id="date_of_joining" class="form-control" required>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="paycycle" class="form-label">
                                                    Paycycle
                                                </label>
                                                <select name="pay_cycle" id="pay_cycle" class="form-control">
                                                    <option value="" disabled selected>--Select Paycycle--</option>
                                                    <option value="monthly">Monthly</option>
                                                    <option value="fortnightly">Fortnightly</option>
                                                    <option value="weekly">Weekly</option>
                                                    <option value="biweekly">Bi-Weekly</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="bank_name" class="form-label">
                                                    Bank
                                                </label>
                                                <select name="bank" id="bank" class="form-control">
                                                    <option value="" disabled selected>--Select Bank--</option>
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
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="account_no" class="form-label">
                                                    Account Number
                                                </label>
                                                <input type="text" name="account" id="account" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Account Number" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="ifsc_code" class="form-label">
                                                    IFSC Code
                                                </label>
                                                <input type="text" name="ifsc_code" id="ifsc_code" placeholder="Enter IFSC Code" oninput="this.value = this.value.toUpperCase();" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="basic_salary" class="form-label">
                                                    Basic Salary <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="salary" id="salary" placeholder="Enter Basic Salary" class="form-control" required>
                                            </div>
                                            <div id="salaryBreakdownContainer">
                                                <!-- Additional rows will appear here -->
                                            </div>
                                            <button type="button" id="addSalaryRow" class="add-more-btn mt-3">
                                                <i class="bi bi-plus-circle"></i> Add More
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Documents Uploads -->
                            <div class="col-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Document Upload
                                        <small class="text-muted" style="color: red!important;">
                                            ( Photo: JPG, JPEG, PNG | Aadhar Card, Experience Letter, Certificates – PDF / JPG / JPEG / PNG )
                                        </small>
                                    </p>
                                    <div class="row mt-2">
                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="adharcard" class="form-label">
                                                    Aadhar Card
                                                </label>
                                                <input type="file" name="adharcard" id="adharcard" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="certificate" class="form-label">
                                                    Certificate
                                                </label>
                                                <input type="file" name="certificate" id="certificate" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="experience_letter" class="form-label">
                                                    Experience Letter
                                                </label>
                                                <input type="file" name="experience_letter" id="experience_letter" class="form-control">
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-sm-12">
                                            <div class="mb-3">
                                                <label for="photo" class="form-label">
                                                    Photo
                                                </label>
                                                <input type="file" name="photo" id="photo" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--Autherised -->
                            <div class="col-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Login Creadentials</p>
                                    <div class="row mt-2">
                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="username" class="form-label">
                                                    Username <sup><span class="required">*</span></sup>
                                                </label>
                                                <input type="text" name="username" id="username" class="form-control" placeholder="Enter Username" required>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="password" class="form-label">
                                                    Password <small class="text-muted" style="color: red!important;">( Minimum 6 Characters )</small> <sup><span class="required">*</span></sup>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        name="password"
                                                        id="password"
                                                        class="form-control pe-5"
                                                        required>

                                                    <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                                        style="cursor:pointer;"
                                                        data-target="password">
                                                        <i class="bi bi-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-lg-4 col-md-6">
                                            <div class="mb-3">
                                                <label for="cnf_password" class="form-label">
                                                    Confirm Password <sup><span class="required">*</span></sup>
                                                </label>
                                                <div class="position-relative">
                                                    <input type="password"
                                                        name="cnf_password"
                                                        id="cnf_password"
                                                        class="form-control pe-5"
                                                        required>

                                                    <span class="toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                                                        style="cursor:pointer;"
                                                        data-target="cnf_password">
                                                        <i class="bi bi-eye"></i>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Access & Controls-->
                            <div class="col-12 mt-4">
                                <div class="doctor-personal-details">
                                    <p class="doctor-title">Access & Controls <small class="text-muted" style="color: red!important;">( Check Atleast One )</small></p>
                                    <div class="row">
                                        <div class="col-12 col-lg-12">
                                            <div class="row g-3 mt-2">
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
                                </div>
                            </div>

                            <!--Submit -->
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-12 text-end">
                                        <button type="reset" class="btn-reset-custom me-2" onclick="confirmReset()">
                                            <i class="bi bi-arrow-counterclockwise me-2"></i>
                                            Reset
                                        </button>
                                        <button type="submit" class="btn-submit-custom">
                                            <i class="bi bi-check-circle me-2"></i>
                                            Submit
                                        </button>
                                    </div>
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
    document.querySelectorAll('.specialization-box input').forEach((checkbox) => {
        checkbox.addEventListener('change', function() {
            this.closest('.specialization-box')
                .classList.toggle('checked', this.checked);
        });
    });

    // Add salary 
    document.getElementById("addSalaryRow").addEventListener("click", function() {
        let container = document.getElementById("salaryBreakdownContainer");

        let row = document.createElement("div");
        row.classList.add("salary-row", "p-1", "rounded", "mt-1");

        row.innerHTML = `
            <div class="mb-2">
                <input type="text" name="salary_name[]" 
                    class="form-control" 
                    placeholder="Salary Name" required>
            </div>
            <div class="d-flex align-items-center gap-1 mb-2">
                <input type="number" name="salary_amount[]" 
                    class="form-control" 
                    placeholder="Amount" required>
                <button type="button" 
                        class="btn btn-danger btn-sm p-1 removeRow">
                    <i class="bi bi-trash"></i>
                </button>
            </div>
        `;
        container.appendChild(row);
    });
    // Remove row
    document.addEventListener("click", function(e) {
        if (e.target.closest(".removeRow")) {
            e.target.closest(".salary-row").remove();
        }
    });

    // show and hide password
    document.querySelectorAll(".toggle-password").forEach(function(toggle) {
        toggle.addEventListener("click", function() {
            const input = document.getElementById(this.getAttribute("data-target"));
            const icon = this.querySelector("i");
            if (input.type === "password") {
                input.type = "text";
                icon.classList.remove("bi-eye");
                icon.classList.add("bi-eye-slash");
            } else {
                input.type = "password";
                icon.classList.remove("bi-eye-slash");
                icon.classList.add("bi-eye");
            }
        });
    });

    // reset --function confirmReset() {
    function confirmReset() {
        if (confirm("Are you sure you want to reset the form?")) {
            document.querySelector("form").reset();
        }
    }
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>