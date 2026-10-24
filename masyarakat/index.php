
<?php
session_start();

require_once __DIR__ . '/../inc/function.php';

// Pastikan pengguna sudah login sebagai masyarakat
if (
    !isset($_SESSION['id_masyarakat']) ||
    ($_SESSION['role'] ?? '') !== 'masyarakat'
) {
    header("Location: ../inc/login.php");
    exit;
}

$id_masyarakat = (int) $_SESSION['id_masyarakat'];
$nama = $_SESSION['nama_masyarakat'] ?? 'Masyarakat';
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>APK Pengaduan</title>

    <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="../asset/css/style.css">
    <link rel="shortcut icon" href="../asset/img/guwa2.jpeg">
</head>

<body>
    <div class="container-scroller d-flex">

        <!-- SIDEBAR -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">

                <li class="nav-item sidebar-category">
    <p>Menu Masyarakat</p>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?pages=dashboard_masyarakat">
        <i class="mdi mdi-view-dashboard menu-icon"></i>
        <span class="menu-title">Dashboard</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?pages=buat_pengaduan">
        <i class="mdi mdi-file-plus menu-icon"></i>
        <span class="menu-title">Buat Pengaduan</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?pages=riwayat_pengaduan">
        <i class="mdi mdi-history menu-icon"></i>
        <span class="menu-title">Riwayat Pengaduan</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="index.php?pages=profil">
        <i class="mdi mdi-account-outline menu-icon"></i>
        <span class="menu-title">Profil Saya</span>
    </a>
</li>

<li class="nav-item">
    <a class="nav-link" href="../inc/logout.php">
        <i class="mdi mdi-logout menu-icon"></i>
        <span class="menu-title">Keluar</span>
    </a>
</li>

            </ul>
        </nav>
        <!-- SIDEBAR END -->

        <!-- PAGE BODY -->
        <div class="container-fluid page-body-wrapper">

            <!-- NAVBAR -->
            <nav class="col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
                <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end w-100">

                    <button class="navbar-toggler align-self-center"
                            type="button"
                            data-toggle="minimize">
                        <span class="mdi mdi-menu"></span>
                    </button>
<h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">
    Welcome <?= htmlspecialchars($_SESSION['nama_masyarakat'] ?? 'Masyarakat') ?>
</h4>

                    <ul class="navbar-nav d-flex flex-row align-items-center ms-auto">

                        <li class="nav-item dropdown me-1">
                            <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center"
                               id="messageDropdown"
                               href="#"
                               data-bs-toggle="dropdown"
                               style="color: black;">
                                <i class="mdi mdi-account-outline me-2"
                                   style="font-size: 24px; color: black;"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right preview-list">
                                <a class="dropdown-item preview-item" href="#">
                                    <i class="mdi mdi-account-outline me-2"></i>
                                    Profil
                                </a>

                                <a class="dropdown-item preview-item" href="#">
                                    <i class="mdi mdi-settings-outline me-2"></i>
                                    Pengaturan
                                </a>

                                <a class="dropdown-item preview-item" href="#">
                                    <i class="mdi mdi-account-multiple-outline me-2"></i>
                                    Pengguna
                                </a>

                                <a href="../inc/logout.php" class="dropdown-item preview-item">
                                    <i class="mdi mdi-logout me-2"></i>
                                    Keluar
                                </a>
                            </div>
                        </li>

                        <li class="nav-item dropdown me-2">
                            <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center"
                               id="notificationDropdown"
                               href="#"
                               data-bs-toggle="dropdown"
                               style="color: black;">
                                <i class="mdi mdi-email-open mx-0"
                                   style="font-size: 24px; color: black;"></i>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
                                 aria-labelledby="notificationDropdown">
                                <p class="mb-0 font-weight-normal float-left dropdown-header">
                                    Notifications
                                </p>
                            </div>
                        </li>

                    </ul>

                    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center"
                            type="button"
                            data-toggle="offcanvas">
                        <span class="mdi mdi-menu"></span>
                    </button>

                </div>
            </nav>
            <!-- NAVBAR END -->

            <!-- MAIN PANEL -->
            <div class="main-panel">
                <div class="content-wrapper">

                    <?php
                    // Memanggil router menu
                    require __DIR__ . '/../inc/menu.php';
                    ?>

                </div>
                <!-- CONTENT WRAPPER END -->
            </div>
            <!-- MAIN PANEL END -->

        </div>
        <!-- PAGE BODY END -->

    </div>
    <!-- CONTAINER SCROLLER END -->

    <!-- JAVASCRIPT -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/chart.js/Chart.min.js"></script>
    <script src="../asset/js/jquery.cookie.js"></script>
    <script src="../asset/js/off-canvas.js"></script>
    <script src="../asset/js/hoverable-collapse.js"></script>
    <script src="../asset/js/template.js"></script>
    <script src="../asset/js/dashboard.js"></script>
</body>

</html>
