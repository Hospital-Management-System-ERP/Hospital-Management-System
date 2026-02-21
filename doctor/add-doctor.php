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
                                                <label for="specialization" class="form-label">
                                                    Specialization <sup><span class="required">*</span></sup>
                                                </label>

                                                <select name="specialization" id="specialization" class="form-control" required>
                                                    <option value="">-- Select Marital Status --</option>
                                                    <?php
                                                        $specialization = $conn->prepare("SELECT * FROM  tbl_doctor_specializations WHERE status = 1");
                                                        $specialization->execute();
                                                        $result = $specialization->get_result();
                                                        if($result->num_rows > 0){
                                                            while($row = $result->fetch_assoc()){
                                                    ?>
                                                        <option value="<?= $row['id']; ?>"><?= $row['specialization']; ?></option>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
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


<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>