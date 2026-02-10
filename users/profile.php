<?php
ob_start();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
header("Expires: 0");
require __DIR__ . '/../api/login/auth.php';
$claims = require_auth([
    'admin',
    'doctor',
    'nurse',
    'accountant',
    'support',
    'laboratory',
    'pharmacy'
]);
$role = $claims['role'];
$name = $claims['name'];
$username = $claims['username'] ?? '';
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
                        <span><i class="bi bi-person-circle me-1"></i> Users</span>
                        <i class="bi bi-arrow-right mx-1"></i>
                        <span>Profile</span>
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
                    <?php if ($role === 'admin') :  ?>
                        <h6 class="text-white mt-2">Welcome to Users Panel</h6>
                    <?php else : ?>
                        <h6 class="text-white mt-2">Welcome <?= htmlspecialchars($name) ?> to your Profile</h6>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
<?php ob_end_flush(); ?>