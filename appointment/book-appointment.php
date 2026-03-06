<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
require __DIR__ . '/../api/login/auth.php';
$claims = require_auth();
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$role = $claims['role'];
$name = $claims['name'];
$username = $claims['username'] ?? '';
$permissions = $claims['permissions'] ?? [];

if ($role !== 'admin' && !in_array('appointment_book', $permissions)) {
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
                        <span>Book Appointment</span>
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
                    <h6 class="text-white mt-2">Please Fill in the Details to Book an Appointment</h6>
                </div>
            </div>
            <div class="col-12">
                <div class="appointment-form">
                    <span class="corner tr"></span>
                    <span class="corner bl"></span>
                    <form id="appointment" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token']; ?>">
                        <div class="row">
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name <sup><span style="color: red;">*</span></sup></label>
                                    <input type="text" name="name" id="name" class="form-control traditional-input" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Mobile Number <sup><span style="color: red;">*</span></sup></label>
                                    <input type="text" name="mobile" id="mobile" maxlength="10" class="form-control traditional-input" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter your mobile no.">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Email ID </label>
                                    <input type="email" name="email" id="email" class="form-control traditional-input" placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="col-lg-3 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Age <sup><span style="color: red;">*</span></sup></label>
                                    <input type="number" name="age" id="age" class="form-control traditional-input" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter Patient Age">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Gender <sup><span style="color: red;">*</span></sup></label>
                                    <select id="gender" name="gender" class="form-select traditional-input">
                                        <option value="" disabled selected>Select Gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Address <sup><span style="color:red;">*</span></sup></label>
                                    <textarea rows="1" name="address" class="form-control traditional-input" placeholder="Full Address..." id="address"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="userRole" class="form-label">Select Service Type <sup><span style="color:red;">*</span></sup></label>
                                    <select id="service" name="service" class="form-select traditional-input">
                                        <option value="" disabled selected>Select a Service</option>
                                        <option value="clinic">Clinic Visit (At Our Clinic)</option>
                                        <option value="video">Video Conference (Online Consultation)</option>
                                        <option value="home">Home Visit (At Your Location)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12" id="clinicTable">
                                <div class="clinic-service">
                                    <div class="table-wrapper overflow-hidden rounded" style="border:1px solid #dee2e6;">
                                        <table class="table table-bordered mb-0 responsive-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Specialization <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Doctor <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Date <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Time <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Purpose</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Specialization">
                                                        <select id="specialization" name="specialization" class="form-select traditional-input">
                                                            <option value="" disabled selected>Select a Specialization</option>
                                                            <?php
                                                            $query = $conn->prepare("SELECT * FROM tbl_doctor_specializations WHERE status = 1");
                                                            $query->execute();
                                                            $result = $query->get_result();
                                                            if ($result->num_rows > 0) {
                                                                while ($rowDr = $result->fetch_assoc()) {
                                                            ?>
                                                                    <option value="<?= $rowDr['id']; ?>"><?= $rowDr['specialization']; ?></option>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                            <option value="not_preferred">Not Preferred</option>
                                                        </select>
                                                    </td>
                                                    <td data-label="Doctor">
                                                        <select id="doctor" name="doctor" class="form-select traditional-input">
                                                            <option value="" disabled selected>Select a Doctor</option>
                                                        </select>
                                                    </td>
                                                    <td data-label="Date">
                                                        <input type="date" name="doa" id="doa" class="form-control traditional-input">
                                                    </td>
                                                    <td data-label="Time">
                                                        <input type="time" name="appointment_time" id="appointment_time" class="form-control traditional-input">
                                                    </td>
                                                    <td data-label="purpose">
                                                        <textarea name="purpose" id="purpose" class="form-control traditional-input"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--At Home-->
                            <div class="col-12" id="homeTable">
                                <div class="clinic-service">
                                    <div class="table-wrapper overflow-hidden rounded" style="border:1px solid #dee2e6;">
                                        <table class="table table-bordered mb-0 responsive-table">
                                            <thead class="table-light">
                                                <tr>
                                                    <th>Service <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Service Cycle <sup><span style="color:red;">*</span></sup></th>
                                                    <th>From <sup><span style="color:red;">*</span></sup></th>
                                                    <th>To <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Time <sup><span style="color:red;">*</span></sup></th>
                                                    <th>Purpose</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="services">
                                                        <div class="service-checkbox-group">
                                                            <?php
                                                            $service = $conn->prepare("SELECT * FROM services WHERE is_custom = 0");
                                                            $service->execute();
                                                            $service_fetch = $service->get_result();
                                                            if ($service_fetch->num_rows > 0) {
                                                                while ($rowService = $service_fetch->fetch_assoc()) {
                                                            ?>
                                                                    <label class="service-item">
                                                                        <input type="checkbox" name="services[]" value="<?= $rowService['service_name']; ?>">
                                                                        <?= $rowService['service_name']; ?>
                                                                    </label>
                                                            <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <div class="add-more-wrapper">
                                                            <button type="button" class="add-more-btn-appointment" onclick="addServiceInput()">
                                                                + Add more
                                                            </button>

                                                            <div id="customServiceContainer"></div>
                                                        </div>
                                                    </td>
                                                    <td data-label="cycle">
                                                        <select name="service_cycle" id="service_cycle" class="form-control traditional-input">
                                                            <option disabled selected value="">--Select One--</option>
                                                            <option value="Daily">Daily</option>
                                                            <option value="Weekly">Weekly</option>
                                                            <option value="Monthly">Monthly</option>
                                                        </select>
                                                    </td>
                                                    <td data-label="Date">
                                                        <input type="date" name="from" id="from" class="form-control traditional-input">
                                                        <small class="text-danger d-none" id="dateError">
                                                            From date cannot be greater than To date
                                                        </small>
                                                    </td>
                                                    <td data-label="Date">
                                                        <input type="date" name="to" id="to" class="form-control traditional-input">
                                                    </td>
                                                    <td data-label="Time">
                                                        <input type="time" name="appointment_time" id="home_time" class="form-control traditional-input">
                                                    </td>
                                                    <td data-label="purpose">
                                                        <textarea name="purpose" id="purpose" class="form-control traditional-input"></textarea>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="appintment-btn">
                                    <button type="submit">Book Appoinment</button>
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
    document.getElementById('specialization').addEventListener('change', async function() {
        let specialization_id = this.value;
        let doctorSelect = document.getElementById("doctor");
        if (!specialization_id) {
            doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
            return;
        }
        if (specialization_id === "not_preferred") {
            doctorSelect.innerHTML = `
            <option value="not_preferred">Not Preferred</option>
        `;
            return;
        }
        doctorSelect.innerHTML = '<option value="">Loading...</option>';
        try {
            const response = await fetch('<?= BASE_URL ?>/api/doctor/get-doctor.php?specialization_id=' + specialization_id);
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            const data = await response.json();
            doctorSelect.innerHTML = '<option value="">Select Doctor</option>';
            data.forEach(function(doctor) {
                let option = document.createElement("option");
                option.value = doctor.emp_id;
                option.text = doctor.name;
                doctorSelect.appendChild(option);
            });
        } catch (error) {
            console.error("Error fetching doctors:", error);
            doctorSelect.innerHTML = '<option value="">Failed to load doctors</option>';
        }
    })
    // clinic specialization
    const serviceSelect = document.getElementById('service');
    const clinicTable = document.getElementById('clinicTable');
    const homeTable = document.getElementById('homeTable');

    serviceSelect.addEventListener('change', function() {
        if (this.value === 'clinic' || this.value === 'video') {
            clinicTable.style.display = 'block'; // show table
            homeTable.style.display = 'none';
            clinicTable.querySelectorAll('input, select').forEach(el => el.disabled = false);
            homeTable.querySelectorAll('input, select').forEach(el => el.disabled = true);
        } else if (this.value === 'home') {
            homeTable.style.display = 'block';
            clinicTable.style.display = 'none';
            homeTable.querySelectorAll('input, select').forEach(el => el.disabled = false);
            clinicTable.querySelectorAll('input, select').forEach(el => el.disabled = true);
        } else {
            clinicTable.style.display = 'none'; // hide table
            homeTable.style.display = 'none';
            clinicTable.querySelectorAll('input, select').forEach(el => el.disabled = true);
            homeTable.querySelectorAll('input, select').forEach(el => el.disabled = true);
        }
    });

    function addServiceInput() {
        const container = document.getElementById('customServiceContainer');

        const div = document.createElement('div');
        div.className = 'custom-service-row-appointment';

        div.innerHTML = `
        <input type="text" name="services[]" 
               class="custom-service-input-appointment" 
               placeholder="Enter service Name">
        <button type="button" class="remove-btn-appointment" onclick="this.parentElement.remove()">×</button>
    `;
        container.appendChild(div);
    }
    // date
    const fromInput = document.getElementById('from');
    const toInput = document.getElementById('to');
    const errorMsg = document.getElementById('dateError');

    function validateDates() {
        if (fromInput.value && toInput.value) {
            const fromDate = new Date(fromInput.value);
            const toDate = new Date(toInput.value);

            if (fromDate > toDate) {
                errorMsg.classList.remove('d-none');
                toInput.value = '';
            } else {
                errorMsg.classList.add('d-none');
            }
        }
    }
    fromInput.addEventListener('change', validateDates);
    toInput.addEventListener('change', validateDates);

    // data inserted
    const appointment = document.getElementById('appointment');
    appointment.addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(appointment);
        try {
            const response = await fetch('<?= BASE_URL ?>/api/appointment/create.php', {
                method: "POST",
                body: formData
            });
            const result = await response.json();
            if (result.success) {
                alert(result.message);
                appointment.reset();
            } else {
                alert(result.message || "Something Went Wrong");
            }
        } catch (error) {
            console.error(error);
            alert("Server Error");
        }
    })
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>