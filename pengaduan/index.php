<?php
@session_start();
require_once '../inc/function.php';

if (@$_SESSION['email']) {
  if (!@$_SESSION['level'] == "admin") {
    header("Location:../admin/index.php");
} else {
  if (@$_SESSION['level'] == "petugas") {
    header("Location: ../petugas/index.php");
} elseif (@$_SESSION['level'] == "pengawas") {
    header("Location: ../pengawas/index.php");
}
}
}else{
  header("location:../inc/login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Laisa Native</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../asset/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../asset/img/guwa2.jpeg" />
</head>
<body>
  <div class="container-scroller d-flex">
    <div class="row p-0 m-0 proBanner" id="proBanner">
      <div class="col-md-12 p-0 m-0">
        <div class="card-body card-body-padding d-flex align-items-center justify-content-between">
          <div class="ps-lg-1">
          </div>
        </div>
      </div>
    </div>

    <!-- partial:./partials/_sidebar.html -->
    <nav class="sidebar sidebar-offcanvas" id="sidebar">
      <ul class="nav">
        <li class="nav-item sidebar-category">
          <p>Navigation</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="?page=dashboard">
            <i class="mdi mdi-view-quilt menu-icon"></i>
            <span class="menu-title">Dashboard</span>
            <div class="badge badge-info badge-pill">2</div>
          </a>
        </li>
        <!--<li class="nav-item sidebar-category">
          <p>Components</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
            <i class="mdi mdi-palette menu-icon"></i>
            <span class="menu-title">UI Elements</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="ui-basic">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="pages/ui-features/buttons.html">Buttons</a></li>
              <li class="nav-item"> <a class="nav-link" href="pages/ui-features/typography.html">Typography</a></li>
            </ul>
          </div>-->
        </li>
        <li class="nav-item">
         <a class="nav-link" href="#">
        <i class="mdi mdi-cash-multiple menu-icon"></i>
        <span class="menu-title">Table</span>
         </a>
      </li>
        <li class="nav-item sidebar-category">
          <p>TRANSAKSI</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-cash-multiple menu-icon"></i>
            <span class="menu-title">Tabungan Nasabah</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-basket menu-icon"></i>
            <span class="menu-title">Transaksi Bank Mini</span>
          </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>NASABAH</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-account-group menu-icon"></i>
            <span class="menu-title">Data Nasabah</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-help-circle-outline menu-icon"></i>
            <span class="menu-title">Tidak Menabung</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-bank menu-icon"></i>
            <span class="menu-title">LIhat Saldo Nasabah</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>REKAP TRANSAKSI</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-database menu-icon"></i>
            <span class="menu-title">Rekap Tabungan</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-file-document-outline menu-icon"></i>
            <span class="menu-title">Rekap Pembayaran</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-account-multiple menu-icon"></i>
            <span class="menu-title">Laporan Peringkat</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>PENGATURAN</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-settings menu-icon"></i>
            <span class="menu-title">Pengaturan Sistem</span>
            </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">
            <i class="mdi mdi-account-settings menu-icon"></i>
            <span class="menu-title">Pengaturan Nasabah</span>
            </a>
        </li>
        <li class="nav-item sidebar-category">
          <p>AKUN</p>
          <span></span>
        </li>
       
         <li class="nav-item">

    <!-- PROFIL -->
    <a class="nav-link"
       data-bs-toggle="collapse"
       href="#profilDropdown"
       aria-expanded="false"
       aria-controls="profilDropdown">

        <i class="mdi mdi-account-multiple-outline menu-icon"></i>
        <span class="menu-title">User Pages</span>
        <i class="menu-arrow"></i>

    </a>

    <!-- ISI DROPDOWN PROFIL -->
    <div class="collapse" id="profilDropdown">

        <ul class="nav flex-column sub-menu">

            <li class="nav-item">
                <a class="nav-link" href="?page=admin">
                    Admin
                </a>
            </li>

        </ul>

    </div>

</li>
 <li class="nav-item">
          <a class="nav-link" data-bs-toggle="collapse" href="#auth" aria-expanded="false" aria-controls="auth">
            <i class="mdi mdi-account-outline menu-icon"></i>
            <span class="menu-title">Profile</span>
            <i class="menu-arrow"></i>
          </a>
          <div class="collapse" id="auth">
            <ul class="nav flex-column sub-menu">
              <li class="nav-item"> <a class="nav-link" href="?pages=login"> Login </a></li>
              <li class="nav-item"> <a class="nav-link" href="?pages=login2"> Login 2 </a></li>
              <li class="nav-item"> <a class="nav-link" href="?pages=register"> Register </a></li>
              <li class="nav-item"> <a class="nav-link" href="?pages=register2"> Register 2 </a></li>
              <li class="nav-item"> <a class="nav-link" href="?pages=lockscreen"> Lockscreen </a></li>
            </ul>
          </div>
</li>
        <li class="nav-item">
          <a class="nav-link" href="../inc/logout.php">
            <i class="mdi mdi-logout menu-icon"></i>
            <span class="menu-title">Keluar</span>
            </a>
        </li>
        
        <!--<li class="nav-item sidebar-category">
          <p>Apps</p>
          <span></span>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="docs/documentation.html">
            <i class="mdi mdi-file-document-box-outline menu-icon"></i>
            <span class="menu-title">Documentation</span>
          </a>
        </li>-->
       
      </ul>
    </nav>
    <!-- partial -->
    <div class="container-fluid page-body-wrapper">
      <!-- partial:./partials/_navbar.html -->
      <nav class=" col-lg-12 col-12 px-0 py-0 py-lg-4 d-flex flex-row">
    <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end w-100">
        <button class="navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
        </button>
          <h4 class="font-weight-bold mb-0 d-none d-md-block mt-1">Welcome </h4>
           <ul class="navbar-nav d-flex flex-row align-items-center ms-auto">
            <li class="nav-item dropdown me-1">
              <a class="nav-link count-indicator dropdown-toggle d-flex justify-content-center align-items-center" id="messageDropdown" href="#" data-bs-toggle="dropdown" style="color: black;">
                <i class="mdi mdi-account-outline me-2" style="font-size: 24px; color: black;"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right  preview-list">
              <a class="dropdown-item preview-item">
                  <i class="mdi mdi-account-outline me-2"></i>
                  Profil
              </a>
              <a class="dropdown-item preview-item">
                  <i class="mdi mdi-settings-outline me-2"></i>
                  Pengaturan
              </a>
              <a class="dropdown-item preview-item">
                  <i class="mdi mdi-account-multiple-outline me-2"></i>
                  Pengguna
              </a>
              <a href="../inc/logout.php" class="dropdown-item preview-item">
                  <i class="mdi mdi-logout me-2"></i>
                  Keluar
              </a>
              </div>
                  
            <li class="nav-item dropdown me-2">
              <a class="nav-link count-indicator dropdown-toggle d-flex align-items-center justify-content-center" id="notificationDropdown" href="#" data-bs-toggle="dropdown" style="color: black;">
               <i class="mdi mdi-email-open mx-0" style="font-size: 24px; color: black;"></i>
              </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"  aria-labelledby="notificationDropdown">
                <p class="mb-0 font-weight-normal float-left dropdown-header">Notifications</p>
                <a class="dropdown-item preview-item" >
                 
                </a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu"></span>
          </button>
        </div>
      </nav>
     
      <!-- partial -->
     <div class="main-panel">

    <div class="content-wrapper">

        <?php

        $page = $_GET['page'] ?? 'dashboard';

        if ($page == "dashboard") {

            include "../pages/master/dashboard.php";

        } elseif ($page == "admin") {

            include "../pages/user_admin/tampil.php";

        } elseif ($page == "tambah") {

            include "../pages/user_admin/tambah.php";

        }elseif ($page == "edit") {

            include "../pages/user_admin/edit.php";

        }elseif ($page == "delete") {

            include "../pages/user_admin/delete.php";

        }

        ?>

    </div>
    <!-- content-wrapper ends -->

</div>
<!-- main-panel ends -->

</div>
<!-- page-body-wrapper ends -->

</div>
<!-- container-scroller -->
          
          </div>
          <!-- row end -->
          <div class="row">
            <div class="col-md-4 grid-margin stretch-card">
         
          </div>
          <!-- row end -->
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:./partials/_footer.html -->
       
        <!-- partial -->
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  <!-- base:js -->
  <script src="../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <!-- Plugin js for this page-->
  <script src="../vendors/chart.js/Chart.min.js"></script>
  <script src="../asset/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page-->
  <!-- inject:js -->
  <script src="../asset/js/off-canvas.js"></script>
  <script src="../asset/js/hoverable-collapse.js"></script>
  <script src="../asset/js/template.js"></script>
  <!-- endinject -->
  <!-- plugin js for this page -->
    <script src="../asset/js/jquery.cookie.js" type="text/javascript"></script>
  <!-- End plugin js for this page -->
  <!-- Custom js for this page-->
  <script src="../asset/js/dashboard.js"></script>
  <!-- End custom js for this page-->
</body>

</html>