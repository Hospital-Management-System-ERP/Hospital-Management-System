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
                    <form>
                        <div class="row">
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Full Name <sup><span style="color: red;">*</span></sup></label>
                                    <input type="text" name="name" id="name" class="form-control traditional-input" oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')" placeholder="Enter your name">
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Mobile Number <sup><span style="color: red;">*</span></sup></label>
                                    <input type="text" name="mobile" id="mobile" class="form-control traditional-input" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="Enter your mobile no.">
                                </div>
                            </div>

                            <div class="col-lg-4 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Email ID</label>
                                    <input type="email" name="email" id="email" class="form-control traditional-input" placeholder="Enter your email">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12">
                                <div class="mb-3">
                                    <label for="fullName" class="form-label">Address <sup><span style="color:red;">*</span></sup></label>
                                    <textarea rows="1" name="address" class="form-control traditional-input" placeholder="Full Address..." id="address"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-12">
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="Specialization">
                                                        <select id="specialization" name="specialization" class="form-select traditional-input">
                                                            <option value="" disabled selected>Select a Specialization</option>
                                                            <option value="physiotherapy">Physiotherapy Specialist</option>
                                                            <option value="gastro">Gastro Laproscopic Surgeon</option>
                                                            <option value="neurosurgery">Neurosurgery — Gold Medalist</option>
                                                            <option value="Consultant Physician (MBBS, MD Medicine)">Consultant Physician (MBBS, MD Medicine)</option>
                                                            <option value="none">Not Preferred</option>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td data-label="services">
                                                        <div class="service-checkbox-group">
                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Injection At Home">
                                                                Injection At Home
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Home Care Nurse">
                                                                Home Care Nurse
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Old Age Care">
                                                                Old Age Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="ICU Setup">
                                                                ICU Setup
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Medical Attendant">
                                                                Medical Attendant
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Paralysis Patient Care">
                                                                Paralysis Patient Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Dressing At Home">
                                                                Dressing At Home
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Tracheotomy Care">
                                                                Tracheotomy Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Colostomy Care">
                                                                Colostomy Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Cardiac Patient Care">
                                                                Cardiac Patient Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Trauma Care">
                                                                Trauma Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Neuro Care">
                                                                Neuro Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Cancer Patient Care">
                                                                Cancer Patient Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Baby Care">
                                                                Baby Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Coma Patient Care">
                                                                Coma Patient Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Critical Care">
                                                                Critical Care
                                                            </label>

                                                            <label class="service-item">
                                                                <input type="checkbox" name="services[]" value="Medical Equipment on Rent">
                                                                Medical Equipment on Rent
                                                            </label>
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
                                                        <input type="time" name="appointment_time" id="appointment_time" class="form-control traditional-input">
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
    const specializationDr = {
        physiotherapy: ["Dr. Azra"],
        gastro: ["Dr. Manish Kumar"],
        neurosurgery: ["Dr. Ankur Anand"],
        "Consultant Physician (MBBS, MD Medicine)": ["Dr. Aviral"],
        none: ['Not Preferred']
    };
    const specializationSelect = document.getElementById('specialization');
    const doctorSelect = document.getElementById('doctor');

    specializationSelect.addEventListener('change', function() {
        const selectedSpec = this.value;
        doctorSelect.innerHTML = '<option value="" disabled selected>Select a Doctor</option>';

        if (specializationDr[selectedSpec]) {
            specializationDr[selectedSpec].forEach(doctor => {
                const option = document.createElement('option');
                option.value = doctor;
                option.text = doctor;
                doctorSelect.appendChild(option);
            });
        }
    });
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
</script>
<script>
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
</script>


<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>