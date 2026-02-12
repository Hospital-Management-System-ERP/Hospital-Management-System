<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Staff Attendance</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <style>
    body {
      background: #f4f6f9;
    }

    .attendance-card {
      border-radius: 20px;
    }

    .staff-img {
      width: 90px;
      height: 90px;
      object-fit: cover;
    }

    .summary-box {
      border-radius: 15px;
      transition: 0.3s;
    }

    .summary-box:hover {
      transform: translateY(-3px);
    }

    .table thead {
      background: #f8f9fa;
    }

    .status-badge {
      padding: 6px 12px;
      border-radius: 20px;
      font-size: 13px;
    }
  </style>
</head>

<body>

  <div class="container py-5">

    <div class="card attendance-card shadow-lg border-0">
      <div class="card-body p-4">

        <!-- ================= Staff Personal Details ================= -->

        <div class="d-flex flex-wrap align-items-center justify-content-between mb-4">

          <div class="d-flex align-items-center">
            <img src="https://via.placeholder.com/100" class="rounded-circle staff-img me-3 shadow-sm">
            <div>
              <h4 class="fw-bold mb-1">Ashraf Ali</h4>
              <div class="text-muted small">
                <i class="bi bi-person-badge"></i> Staff ID: ST-101 |
                <i class="bi bi-building"></i> Nursing |
                <i class="bi bi-briefcase"></i> Supervisor
              </div>
              <div class="text-muted small">
                <i class="bi bi-telephone"></i> 9876543210 |
                <i class="bi bi-calendar"></i> Joining: 01 Jan 2024
              </div>
            </div>
          </div>

          <!-- Filter -->
          <div class="mt-3 mt-md-0">
            <div class="d-flex gap-2">
              <select class="form-select">
                <option>January</option>
                <option>February</option>
                <option selected>March</option>
                <option>April</option>
              </select>

              <select class="form-select">
                <option>2026</option>
                <option selected>2025</option>
                <option>2024</option>
              </select>

              <button class="btn btn-primary">
                <i class="bi bi-funnel"></i>
              </button>
            </div>
          </div>

        </div>

        <!-- ================= Summary Section ================= -->

        <div class="row g-3 text-center mb-4">

          <div class="col-md-3">
            <div class="summary-box bg-success bg-opacity-10 p-3 shadow-sm">
              <div class="text-success fw-semibold">Present</div>
              <h4 class="fw-bold text-success">22</h4>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-box bg-danger bg-opacity-10 p-3 shadow-sm">
              <div class="text-danger fw-semibold">Absent</div>
              <h4 class="fw-bold text-danger">2</h4>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-box bg-warning bg-opacity-10 p-3 shadow-sm">
              <div class="text-warning fw-semibold">Late</div>
              <h4 class="fw-bold text-warning">3</h4>
            </div>
          </div>

          <div class="col-md-3">
            <div class="summary-box bg-info bg-opacity-10 p-3 shadow-sm">
              <div class="text-info fw-semibold">Leave</div>
              <h4 class="fw-bold text-info">1</h4>
            </div>
          </div>

        </div>

        <!-- ================= Attendance Table ================= -->

        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Check In</th>
                <th>Check Out</th>
                <th>Working Hours</th>
                <th>Status</th>
              </tr>
            </thead>

            <tbody>

              <tr>
                <td>01-03-2025</td>
                <td>Monday</td>
                <td>09:05 AM</td>
                <td>06:00 PM</td>
                <td>8h 55m</td>
                <td><span class="status-badge bg-success text-white">Present</span></td>
              </tr>

              <tr>
                <td>02-03-2025</td>
                <td>Tuesday</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td><span class="status-badge bg-danger text-white">Absent</span></td>
              </tr>

              <tr>
                <td>03-03-2025</td>
                <td>Wednesday</td>
                <td>09:40 AM</td>
                <td>06:00 PM</td>
                <td>8h 20m</td>
                <td><span class="status-badge bg-warning text-dark">Late</span></td>
              </tr>

              <tr>
                <td>04-03-2025</td>
                <td>Thursday</td>
                <td>-</td>
                <td>-</td>
                <td>-</td>
                <td><span class="status-badge bg-info text-white">Leave</span></td>
              </tr>

            </tbody>
          </table>
        </div>

      </div>
    </div>

  </div>

</body>

</html>