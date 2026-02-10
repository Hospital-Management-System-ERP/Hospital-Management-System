<div id="page-content-wrapper">
    <nav class="navbar navbar-expand-lg navbar-light bg-white px-4 border-bottom sticky-top">
        <div class="container-fluid p-0">
            <button class="btn btn-light d-md-none me-3" id="menu-toggle">
                <i class="bi bi-list fs-4"></i>
            </button>
            <div class="header-title">
                <h4 class="service-title">City Home Care Nursing Service</h4>
            </div>
            <div class="ms-auto d-flex align-items-center gap-3">
                <div class="search-box d-none d-md-flex">
                    <span class="search-icon">
                        <i class="bi bi-search"></i>
                    </span>
                    <input type="text" placeholder="Search patient..." />
                </div>
                <i class="bi bi-bell fs-5"></i>
                <i class="bi bi-envelope-open fs-5"></i>
                <div class="dropdown-topbar" style="position: relative;">
                    <img src="<?= BASE_URL ?>images/user.png"
                        class="rounded-circle dropdown-toggle"
                        alt="user"
                        height="50"
                        width="50"
                        id="userDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="cursor: pointer;">
                        
                    <ul class="dropdown-menu dropdown-menu-end shadow animated-dropdown" aria-labelledby="userDropdown">
                        <li>
                            <h6 class="dropdown-header">Welcome, <strong><?= htmlspecialchars($name) ?></h6>
                            <small class="dropdown-item-text"><?= htmlspecialchars($username) ?></small>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>/users/profile">Profile</a></li>
                        <li><a class="dropdown-item" href="<?= BASE_URL ?>settings.php">Settings</a></li>
                        <li><a class="dropdown-item text-danger" href="<?= BASE_URL ?>api/login/logout"><b>Logout</b> <i class="bi bi-lock"></i></a></li>
                    </ul>
                </div>

            </div>
        </div>
    </nav>