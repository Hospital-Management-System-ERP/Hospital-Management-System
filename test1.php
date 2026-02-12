<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Staff Payroll Management</title>

<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

<style>
body{
    background:#f4f6f9;
}

.payroll-card{
    border:0;
    border-radius:18px;
    transition:0.3s ease;
}
.payroll-card:hover{
    transform:translateY(-5px);
}

.payroll-header{
    font-weight:600;
    color:#555;
}

.table thead{
    background:#f1f3f6;
}

.status-badge{
    padding:6px 12px;
    border-radius:20px;
    font-size:13px;
}

.status-paid{
    background:#e6f4ea;
    color:#1e7e34;
}

.status-pending{
    background:#fff4e5;
    color:#b54708;
}

@media(max-width:768px){
    .table{
        display:none;
    }
    .mobile-card{
        display:block;
    }
}

@media(min-width:769px){
    .mobile-card{
        display:none;
    }
}
</style>
</head>
<body>

<div class="container-fluid py-4">

    <!-- Page Title -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h4 class="fw-bold"><i class="bi bi-cash-coin me-2"></i>Staff Payroll Management</h4>
        <button class="btn btn-primary">
            <i class="bi bi-plus-circle me-2"></i>Generate Payroll
        </button>
    </div>

    <!-- Summary Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card payroll-card shadow-sm p-3 bg-primary bg-opacity-10">
                <div class="payroll-header">Total Staff</div>
                <h4 class="fw-bold mt-2">42</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card payroll-card shadow-sm p-3 bg-success bg-opacity-10">
                <div class="payroll-header">Total Payroll</div>
                <h4 class="fw-bold mt-2">₹ 4,25,000</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card payroll-card shadow-sm p-3 bg-info bg-opacity-10">
                <div class="payroll-header">Paid</div>
                <h4 class="fw-bold mt-2">₹ 3,80,000</h4>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card payroll-card shadow-sm p-3 bg-danger bg-opacity-10">
                <div class="payroll-header">Pending</div>
                <h4 class="fw-bold mt-2">₹ 45,000</h4>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card shadow-sm mb-4 p-3">
        <div class="row g-3">
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>March</option>
                    <option>April</option>
                    <option>May</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>2025</option>
                    <option>2024</option>
                </select>
            </div>
            <div class="col-md-3">
                <select class="form-select">
                    <option selected>All Departments</option>
                    <option>Nursing</option>
                    <option>Accounts</option>
                </select>
            </div>
            <div class="col-md-3">
                <button class="btn btn-dark w-100">
                    <i class="bi bi-funnel me-2"></i>Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Payroll Table -->
    <div class="card shadow-sm p-3">
        <div class="table-responsive">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Staff</th>
                        <th>Basic</th>
                        <th>Allowance</th>
                        <th>Deduction</th>
                        <th>Net Salary</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <img src="https://i.pravatar.cc/40" class="rounded-circle me-2">
                                Ashraf Ali
                            </div>
                        </td>
                        <td>₹ 25,000</td>
                        <td>₹ 3,000</td>
                        <td>₹ 1,500</td>
                        <td class="fw-bold text-success">₹ 26,500</td>
                        <td><span class="status-badge status-paid">Paid</span></td>
                        <td>
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#slipModal">
                                View Slip
                            </button>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Mobile Card -->
        <div class="mobile-card mt-3">
            <div class="card shadow-sm p-3 mb-3">
                <h6 class="fw-bold">Ashraf Ali</h6>
                <div>Basic: ₹25,000</div>
                <div>Allowance: ₹3,000</div>
                <div>Deduction: ₹1,500</div>
                <div class="fw-bold text-success">Net: ₹26,500</div>
                <button class="btn btn-sm btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#slipModal">
                    View Slip
                </button>
            </div>
        </div>
    </div>

</div>

<!-- Salary Slip Modal -->
<div class="modal fade" id="slipModal">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Salary Slip - March 2025</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <h6 class="fw-bold">Ashraf Ali</h6>
        <hr>
        <div class="row">
            <div class="col-md-6">
                <h6>Earnings</h6>
                <p>Basic: ₹25,000</p>
                <p>Allowance: ₹3,000</p>
            </div>
            <div class="col-md-6">
                <h6>Deductions</h6>
                <p>PF: ₹1,000</p>
                <p>Other: ₹500</p>
            </div>
        </div>
        <hr>
        <h5 class="text-end fw-bold text-success">Net Salary: ₹26,500</h5>
      </div>
      <div class="modal-footer">
        <button class="btn btn-success"><i class="bi bi-download me-2"></i>Download PDF</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
