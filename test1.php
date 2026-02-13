<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Staff Card with Lining Background</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
    body {
        background-color: #f0f2f5;
        font-family: 'Segoe UI', sans-serif;
    }

    .staff-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        background-color: #fff;
        border-radius: 15px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.08);
        padding: 15px;
        position: relative;
        overflow: hidden;
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .staff-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: repeating-linear-gradient(
            45deg,
            rgba(0,0,0,0.03) 0,
            rgba(0,0,0,0.03) 1px,
            transparent 1px,
            transparent 8px
        );
        border-radius: 15px;
        pointer-events: none;
    }

    .staff-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }

    .staff-image img {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #ddd;
        z-index: 1;
        position: relative;
    }

    .staff-info {
        flex: 1;
        margin-left: 15px;
        z-index: 1;
        position: relative;
    }

    .staff-info h5 {
        font-weight: 600;
        margin-bottom: 3px;
    }

    .staff-info p {
        margin-bottom: 3px;
        color: #6c757d;
        font-size: 0.95rem;
    }

    .roles {
        margin-top: 5px;
    }

    .role-badge {
        font-size: 0.8rem;
        margin-right: 5px;
        margin-top: 3px;
    }

    .permissions-box {
        display: flex;
        flex-wrap: wrap;
        gap: 5px;
        margin-top: 8px;
        z-index: 1;
        position: relative;
    }

    .permission-tag {
        background-color: #e0e7ff;
        color: #1e40af;
        padding: 4px 8px;
        border-radius: 6px;
        font-size: 0.8rem;
        white-space: nowrap;
    }

    .actions {
        display: flex;
        flex-direction: column;
        gap: 8px;
        z-index: 1;
        position: relative;
    }

    @media (max-width: 768px) {
        .staff-card {
            flex-direction: column;
            align-items: flex-start;
        }
        .staff-info {
            margin-left: 0;
            margin-top: 10px;
        }
        .actions {
            flex-direction: row;
            width: 100%;
            justify-content: flex-end;
            margin-top: 10px;
        }
        .actions .btn {
            flex: 1;
        }
    }
</style>
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4 text-center">Staff Cards with Lining Background</h2>

    <!-- Horizontal Card -->
    <div class="staff-card mb-3">
        <!-- Left: Image -->
        <div class="staff-image">
            <img src="https://randomuser.me/api/portraits/men/75.jpg" alt="Ashraf Ali">
        </div>

        <!-- Center: Info -->
        <div class="staff-info">
            <h5>Ashraf Ali</h5>
            <p><strong>Username:</strong> ashraf123</p>
            <p><strong>Email:</strong> ashraf@example.com</p>

            <!-- Roles -->
            <div class="roles">
                <span class="badge bg-success role-badge">Admin</span>
                <span class="badge bg-info text-dark role-badge">Nurse</span>
                <span class="badge bg-warning text-dark role-badge">Editor</span>
            </div>

            <!-- Permissions -->
            <div class="permissions-box">
                <div class="permission-tag">Manage Users</div>
                <div class="permission-tag">View Reports</div>
                <div class="permission-tag">Edit Roles</div>
                <div class="permission-tag">View Schedule</div>
                <div class="permission-tag">Edit Nursing Notes</div>
                <div class="permission-tag">Update Patient Vitals</div>
                <div class="permission-tag">Edit Articles</div>
                <div class="permission-tag">Publish Articles</div>
            </div>
        </div>

        <!-- Right: Actions -->
        <div class="actions">
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
        </div>
    </div>

    <!-- Another Horizontal Card -->
    <div class="staff-card mb-3">
        <div class="staff-image">
            <img src="https://randomuser.me/api/portraits/men/32.jpg" alt="Dr. Rahul Sharma">
        </div>
        <div class="staff-info">
            <h5>Dr. Rahul Sharma</h5>
            <p><strong>Username:</strong> drrahul</p>
            <p><strong>Email:</strong> rahul@example.com</p>

            <div class="roles">
                <span class="badge bg-primary role-badge">Doctor</span>
                <span class="badge bg-warning text-dark role-badge">Manager</span>
            </div>

            <div class="permissions-box">
                <div class="permission-tag">View Patient Records</div>
                <div class="permission-tag">Write Prescription</div>
                <div class="permission-tag">Order Lab Tests</div>
                <div class="permission-tag">Approve Requests</div>
                <div class="permission-tag">View Reports</div>
                <div class="permission-tag">Assign Tasks</div>
                <div class="permission-tag">Edit Schedule</div>
                <div class="permission-tag">Manage Department</div>
            </div>
        </div>

        <div class="actions">
            <button class="btn btn-sm btn-warning">Edit</button>
            <button class="btn btn-sm btn-danger">Delete</button>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
