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
$user_id = $claims['sub'];
$permissions = $claims['permissions'] ?? [];

if ($role !== 'admin' && !in_array('staff_list', $permissions)) {
    http_response_code(403);
    echo "❌ Unauthorized Access";
    exit;
}
if ($role == 'admin') {
    $staff = $conn->prepare("SELECT * FROM tbl_staff");
} else {
    $staff = $conn->prepare("SELECT * FROM tbl_staff WHERE id = ?");
    $staff->bind_param('i', $user_id);
}
$staff->execute();
$result = $staff->get_result();
$data = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
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
                        <span>Staff List</span>
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
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="appointment-list d-flex justify-content-between align-items-center flex-wrap mb-3">
                    <!-- Left side: Export Buttons -->
                    <div class="d-flex gap-2 flex-wrap">
                        <button class="btn btn-danger btn-sm export-btn" id="downloadPDF">
                            <i class="bi bi-file-earmark-pdf"></i> PDF
                        </button>
                        <button class="btn btn-dark btn-sm export-btn" onclick="printStaffSection()">
                            <i class="bi bi-printer"></i> Print
                        </button>
                    </div>
                    <!-- Right side: Search -->
                    <div class="search-box">
                        <i class="bi bi-search"></i>
                        <input type="text" id="staffSearch" placeholder="Search Staff...">
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="staff-list">
                    <p class="staff-details-list">
                        <i class="bi bi-people-fill me-2"></i>
                        Staff Details
                    </p>
                    <div class="row">
                        <?php foreach ($data as $row) :  ?>
                            <div class="col-12 col-lg-6 col-md-6">
                                <div class="staff-card d-flex mt-2">
                                    <div class="staff-img">
                                        <?php if (!empty($row['image']) && file_exists(__DIR__ . '/images/' . $row['image'])): ?>
                                            <img src="images/<?= $row['image']; ?>" alt="John Doe">
                                        <?php else: ?>
                                            <img src="img/profile.png" alt="John Doe">
                                        <?php endif; ?>
                                    </div>
                                    <div class="staff-details d-flex flex-column justify-content-between">
                                        <div class="staff-info-top">
                                            <h5 class="staff-name" style="display: flex; justify-content: space-between; align-items: center;">
                                                <span><?= $row['name']; ?></span>
                                                <span style="font-size: 13px;">EMP ID: <?= $row['emp_id']; ?></span>
                                            </h5>
                                            <p class="staff-role"><?= ucfirst(strtolower($row['role'])); ?></p>
                                            <p class="staff-email">Email: <?= $row['email']; ?></p>
                                            <p class="staff-phone">Phone: +91 <span style="margin-left: 3px;"><?= $row['mobile']; ?></span></p>
                                            <p>Status:
                                                <?php if ($row['status'] == 1) : ?>
                                                    <span class="staff-status active">Active</span>
                                                <?php else : ?>
                                                    <span class="staff-status inactive">Inactive</span>
                                                <?php endif; ?>
                                            </p>
                                        </div>
                                        <div class="staff-actions">
                                            <button class="btn btn-sm btn-primary">View Details</button>
                                            <button class="btn btn-sm btn-warning">Edit Details</button>
                                            <?php if ($role == 'admin'): ?>
                                                <button class="btn btn-sm btn-danger">Delete</button>
                                                <button class="btn btn-sm btn-secondary">Toggle Status</button>
                                                <label class="switch" style="margin-left:10px;">
                                                    <input type="checkbox" class="status-toggle"
                                                        data-id="<?= $row['id']; ?>"
                                                        <?= $row['status'] == 1 ? 'checked' : ''; ?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const staffListContainer = document.querySelector('.staff-list .row'); // container holding all staff cards
    const searchInput = document.getElementById('staffSearch');

    // Create a "No Data Found" message element
    let noDataMessage = document.createElement('p');
    noDataMessage.innerText = 'No staff found.';
    noDataMessage.style.textAlign = 'center';
    noDataMessage.style.fontWeight = 'bold';
    noDataMessage.style.color = 'red';
    noDataMessage.style.display = 'none';
    staffListContainer.appendChild(noDataMessage);

    searchInput.addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let staffCards = document.querySelectorAll('.staff-list .staff-card');
        let visibleCount = 0;

        staffCards.forEach(card => {
            let name = card.querySelector('.staff-name span').innerText.toLowerCase();
            let role = card.querySelector('.staff-role').innerText.toLowerCase();
            let email = card.querySelector('.staff-email').innerText.toLowerCase();
            let phone = card.querySelector('.staff-phone').innerText.toLowerCase();

            if (name.includes(filter) || role.includes(filter) || email.includes(filter) || phone.includes(filter)) {
                card.parentElement.style.display = ''; // show card
                visibleCount++;
            } else {
                card.parentElement.style.display = 'none'; // hide card
            }
        });

        // Show or hide "No Data Found" message
        if (visibleCount === 0) {
            noDataMessage.style.display = 'block';
        } else {
            noDataMessage.style.display = 'none';
        }
    });
</script>
<script>
    const staffList = document.querySelector('.staff-list .row');
    document.getElementById('downloadPDF').addEventListener('click', () => {
        // Clone container to preserve styles
        let clone = staffList.cloneNode(true);

        // Ensure profile images stay circular
        clone.querySelectorAll('.staff-img img').forEach(img => {
            img.style.borderRadius = '50%';
            img.style.width = '80px'; // optional: keep size consistent
            img.style.height = '80px';
            img.style.objectFit = 'cover';
        });

        let opt = {
            margin: 0.5,
            filename: 'staff-list.pdf',
            image: {
                type: 'jpeg',
                quality: 0.98
            },
            html2canvas: {
                scale: 2
            },
            jsPDF: {
                unit: 'in',
                format: 'a4',
                orientation: 'portrait'
            }
        };
        html2pdf().set(opt).from(clone).save();
    });

    // Print Staff
    document.getElementById('printStaff').addEventListener('click', () => {
        let clone = staffList.cloneNode(true);
        clone.querySelectorAll('.staff-img img').forEach(img => {
            img.style.borderRadius = '50%';
            img.style.width = '80px';
            img.style.height = '80px';
            img.style.objectFit = 'cover';
        });

        let printWindow = window.open('', '', 'height=600,width=800');
        printWindow.document.write('<html><head><title>Staff List</title>');
        printWindow.document.write('<link rel="stylesheet" href="css/bootstrap.min.css">'); // your CSS
        printWindow.document.write('<style>');
        printWindow.document.write(`
        .staff-card { display:flex; border:1px solid #ccc; padding:10px; margin-bottom:10px; border-radius:10px; }
        .staff-img img { border-radius:50%; width:80px; height:80px; object-fit:cover; }
        .staff-details { margin-left:10px; }
        .staff-status.active { color: green; font-weight: bold; }
        .staff-status.inactive { color: red; font-weight: bold; }
    `);
        printWindow.document.write('</style></head><body>');
        printWindow.document.write(clone.outerHTML);
        printWindow.document.write('</body></html>');
        printWindow.document.close();
        printWindow.focus();
        printWindow.print();
    });

    // print staff detaisl after click print button
    function printStaffSection() {
        // Get the staff section element
        const staffSection = document.querySelector('.staff-list');
        const printWindow = window.open('', '', 'width=900,height=600');
        const styles = `
        <style>
            body { font-family: Arial, sans-serif; padding: 20px; }
            .staff-card { display: flex; margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; border-radius: 10px; }
            .staff-img { width: 80px; height: 80px; border-radius: 50%; overflow: hidden; margin-right: 15px; }
            .staff-img img { width: 100%; height: 100%; object-fit: cover; display: block; }
            .staff-details { display: flex; flex-direction: column; justify-content: space-between; }
            .staff-actions { display: flex; gap: 5px; margin-top: 10px; }
            .staff-status.active { color: green; font-weight: bold; }
            .staff-status.inactive { color: red; font-weight: bold; }
        </style>
    `;
        printWindow.document.write('<html><head><title>Staff List</title>' + styles + '</head><body>');
        printWindow.document.write(staffSection.outerHTML);
        printWindow.document.write('</body></html>');

        printWindow.document.close();
        printWindow.focus();

        // Print the window
        printWindow.print();
        printWindow.close();
    }
</script>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>