<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
require __DIR__ . '/api/login/auth.php';
$claims = require_auth([
    'admin', 
    'doctor', 
    'nurse', 
    'accountant', 
    'support',
    'laboratory',
    'pharmacy',
    'radiology',
    'patient_coordinator',
    'ot_coordinator',
    'ambulance_coordinator',
    'inventory_manager',
    'patient'
]);
$role = $claims['role'];
$name = $claims['name'];
$username = $claims['username'] ?? '';
$permissions = $claims['permissions'] ?? [];

include 'includes/header.php';
include 'includes/sidebar.php';
include 'includes/top-header.php';
include 'cards.php';
?>
<section>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="top-body d-flex justify-content-between align-items-center">
                    <span>
                        <i class="bi bi-grid-fill me-1"></i> Dashboard
                        <i class="bi bi-angle-right mx-1"></i>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <a href="index">Home</a>
                    </span>
                    <div class="digital-watch">
                        <?php include('watch.php'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container-fluid">
        <div class="row">
            <?php
            foreach ($cards as $index => $card) {
            ?>
                <div class="col-lg-3 col-md-6 col-sm-12" id="cards">
                    <a href="javascript:void(0)">
                        <div class="cards patient-card">
                            <div class="card-left">
                                <h6><?= $card['title']; ?></h6>
                                <h3 class="count" style="color: <?= $card['color']; ?>;"><?= $card['num']; ?></h3>
                            </div>
                            <div class="card-icon" style="background-color: <?= $card['icon-bg']; ?>;">
                                <i class="<?= $card['icon']; ?>"></i>
                            </div>
                        </div>
                    </a>
                </div>
            <?php
            }
            ?>
        </div>
        <div class="row" style="margin-top: 20px;">
            <div class="col-lg-9 col-md-9 col-sm-12">
                <div class="row">
                    <div class="col-lg-5 col-md-6 col-sm-12">
                        <div class="stats-card p-3">
                            <div class="card-title d-flex justify-content-between align-items-center mb-3">
                                <h6 class="mb-0">Recent Appointment</h6>
                                <i class="bi bi-three-dots-vertical"></i>
                            </div>

                            <!-- Scrollable container -->
                            <div class="stats-list">
                                <div class="stats-item">
                                    <div class="icon" style="background: #ff00c8;">
                                        <i class="bi bi-calendar-fill"></i>
                                    </div>
                                    <span class="label">Asharf Ali</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                                <div class="stats-item">
                                    <div class="icon" style="background: #28c745;">
                                        <i class="bi bi-envelope-fill"></i>
                                    </div>
                                    <span class="label">Vivek Pandey</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                <div class="stats-item">
                                    <div class="icon" style="background: #00e5ff;">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </div>
                                    <span class="label">Himanshu Yadav</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                <div class="stats-item">
                                    <div class="icon" style="background: #ffbf00;">
                                        <i class="bi bi-cursor-fill"></i>
                                    </div>
                                    <span class="label">Clicked</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                <div class="stats-item">
                                    <div class="icon" style="background: #007bff;">
                                        <i class="bi bi-file-earmark-plus-fill"></i>
                                    </div>
                                    <span class="label">Subscribed</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                <div class="stats-item">
                                    <div class="icon" style="background: #ff3b3b;">
                                        <i class="bi bi-envelope-exclamation-fill"></i>
                                    </div>
                                    <span class="label">Spam Message</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>

                                <div class="stats-item">
                                    <div class="icon" style="background: #6f42c1;">
                                        <i class="bi bi-eye-fill"></i>
                                    </div>
                                    <span class="label">Views Mails</span>
                                    <button class="btn btn-sm btn-success ms-2">
                                        <i class="bi bi-check"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger ms-1" onclick="removePatient(this)">
                                        <i class="bi bi-x"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-6 col-sm-12">
                        <div class="stats-card p-3">
                            <canvas id="visitorsChart" height="120"></canvas>

                            <div class="stats-info mt-3">
                                <h3>36.7% <small class="text-success">↑ 34.5%</small></h3>
                                <p>Visitors Growth</p>

                                <div class="progress-item">
                                    <span>Clicks</span>
                                    <span>2589</span>
                                    <div class="progress">
                                        <div class="progress-bar clicks-bar" style="width: 60%;"></div>
                                    </div>
                                </div>

                                <div class="progress-item">
                                    <span>Likes</span>
                                    <span>6748</span>
                                    <div class="progress">
                                        <div class="progress-bar likes-bar" style="width: 80%;"></div>
                                    </div>
                                </div>

                                <div class="progress-item">
                                    <span>Upvotes</span>
                                    <span>9842</span>
                                    <div class="progress">
                                        <div class="progress-bar upvotes-bar" style="width: 90%;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-12">
                <div class="d-flex flex-column gap-1">
                    <a href="#" class="dashboard-btn btn1">➕ Add New Patient</a>
                    <a href="#" class="dashboard-btn btn2">📅 Book Appointment</a>
                    <a href="#" class="dashboard-btn btn3">🧑‍⚕️ Assign Nurse</a>
                    <a href="#" class="dashboard-btn btn4">💊 Add Prescription</a>
                    <a href="#" class="dashboard-btn btn5">🧾 Generate Bill</a>
                </div>
                <div class="attendance-section text-center p-3 bg-white">
                    <span class="attendance-label mb-2">Attendance</span>
                    <div class="attendance-times mb-2" style="display:none;">
                        <div class="small-text"><strong>Login Time:</strong> <span id="login-time">--:--</span></div>
                        <div class="small-text"><strong>Logout Time:</strong> <span id="logout-time">--:--</span></div>
                    </div>
                    <button id="attendance-btn" class="attendance-btn">In-time</button>
                </div>
            </div>
        </div>
    </div>
</section>

<section>
    <div class="container-fluid mb-5">
        <div class="row">
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="onduty-card">
                    <div class="user-card-header">
                        <h5 style="color: #347433; font-size: 15px; border-radius: 20px; border-bottom: 2px solid #347433; padding: 0px 20px 5px 20px;">On Duty Doctors</h5>
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                    <div class="onduty-body">
                        <div class="user-list">
                            <!-- user item -->
                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=32" alt="">
                                    <div>
                                        <div class="name">Elon Jonado</div>
                                        <div class="username">elon_deo</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=12">
                                    <div>
                                        <div class="name">Alexzender Clito</div>
                                        <div class="username">zli_alexzender</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=45">
                                    <div>
                                        <div class="name">Michle Tinko</div>
                                        <div class="username">tinko_michle</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=25">
                                    <div>
                                        <div class="name">KailWemba</div>
                                        <div class="username">wemba_kl</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="onduty-card">
                    <div class="user-card-header">
                        <h5 style="color: #4300FF; font-size: 15px; border-radius: 20px; border-bottom: 2px solid #4300FF; padding: 0px 20px 5px 20px;">On Duty Nurse & Staff</h5>
                        <i class="bi bi-three-dots-vertical"></i>
                    </div>
                    <div class="onduty-body">
                        <div class="user-list">
                            <!-- user item -->
                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=32" alt="">
                                    <div>
                                        <div class="name">Elon Jonado</div>
                                        <div class="username">elon_deo</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=12">
                                    <div>
                                        <div class="name">Alexzender Clito</div>
                                        <div class="username">zli_alexzender</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=45">
                                    <div>
                                        <div class="name">Michle Tinko</div>
                                        <div class="username">tinko_michle</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=25">
                                    <div>
                                        <div class="name">KailWemba</div>
                                        <div class="username">wemba_kl</div>
                                    </div>
                                </div>
                                <input type="checkbox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="onduty-card leave-card">
                    <!-- Header -->
                    <div class="user-card-header leave-header">
                        <h5 style="color: #FF3F33; font-size: 15px; border-radius: 20px; border-bottom: 2px solid #FF3F33; padding: 0px 20px 5px 20px;">On Leave</h5>
                        <input type="text" class="leave-search" placeholder="Search staff...">
                    </div>

                    <!-- Scrollable Body -->
                    <div class="onduty-body">
                        <div class="user-list">

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=11">
                                    <div>
                                        <div class="name">Rohit Kumar</div>
                                        <div class="username">Sick Leave</div>
                                    </div>
                                </div>
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=18">
                                    <div>
                                        <div class="name">Anjali Singh</div>
                                        <div class="username">Casual Leave</div>
                                    </div>
                                </div>
                            </div>

                            <div class="user-item">
                                <div class="user-left">
                                    <img src="https://i.pravatar.cc/100?img=22">
                                    <div>
                                        <div class="name">Vikas Verma</div>
                                        <div class="username">Emergency Leave</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!--======= Attendance here ======-->
<script>
    const attendanceBtn = document.getElementById("attendance-btn");
    const attendanceTimes = document.querySelector(".attendance-times");
    const loginTime = document.getElementById("login-time");
    const logoutTime = document.getElementById("logout-time");

    function getCurrentTime() {
        const now = new Date();
        return now.toLocaleTimeString('en-GB', {
            hour12: true
        });
    }

    let state = "in"; // "in" -> "out" -> "done"

    attendanceBtn.addEventListener("click", () => {

        // Show the times container if hidden
        if (attendanceTimes.style.display === "none") {
            attendanceTimes.style.display = "block";
        }

        if (state === "in") {
            loginTime.textContent = getCurrentTime();
            attendanceBtn.textContent = "Out-time";
            attendanceBtn.classList.add("out");
            state = "out";
        } else if (state === "out") {
            logoutTime.textContent = getCurrentTime();
            attendanceBtn.textContent = "Done";
            attendanceBtn.classList.remove("out");
            attendanceBtn.classList.add("done");
            attendanceBtn.disabled = true;
            state = "done";
        }
    });
</script>

<!--===== Chart ===== --->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('visitorsChart').getContext('2d');
    const visitorsChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Visitors',
                data: [10, 20, 15, 25, 22, 30, 12],
                backgroundColor: 'rgba(0, 255, 0, 0.1)',
                borderColor: '#84ff33',
                borderWidth: 2,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#84ff33',
                pointRadius: 5
            }]
        },
        options: {
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                x: {
                    display: false
                },
                y: {
                    display: false
                }
            }
        }
    });
</script>
<script>
    document.querySelector('.leave-search').addEventListener('keyup', function() {
        const value = this.value.toLowerCase();
        document.querySelectorAll('.leave-card .user-item').forEach(item => {
            item.style.display = item.innerText.toLowerCase().includes(value) ?
                'flex' :
                'none';
        });
    });
</script>
<?php include('includes/footer.php'); ?>
<?php ob_end_flush(); ?>