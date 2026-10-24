<?php
// inc/menu.php
$PAGE = $_GET['pages'] ?? 'dashboard';

switch ($PAGE) {
    // ==========================================
    // 1. MODUL MASYARAKAT
    // ==========================================
    case 'dashboard_masyarakat':
        $path = __DIR__ . '/../pages/masyarakat/dashboard_masyarakat.php';

        if (file_exists($path)) {
            include $path;
        } else {
            echo "File tidak ditemukan: " . $path;
        }
        break;

    case 'pengaduan':
        $path = __DIR__ . '/../pages/pengaduan/tampil.php';

        if (file_exists($path)) {
            include $path;
        } else {
            echo "File tidak ditemukan: " . $path;
        }
        break;


    case 'riwayat_pengaduan':
        require __DIR__ . '/../pages/masyarakat/riwayat_pengaduan.php';
        break;

    case 'profil':
        require __DIR__ . '/../pages/masyarakat/profil.php';
        break;

    // ==========================================
    // 2. MODUL PETUGAS & ADMIN
    // ==========================================
    case 'data_pengaduan':
        $PATH = __DIR__ . '/../pages/admin/data_pengaduan.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'pengaduan_masuk':
        $PATH = __DIR__ . '/../pages/admin/pengaduan_masuk.php';
        if (file_exists($PATH)) include $PATH;
        break;
    case 'tanggapan':
        $PATH = __DIR__ . '/../pages/petugas/tanggapan.php';
        if (file_exists($PATH)) include $PATH;
        break;

    // ==========================================
    // 3. DASHBOARD DEFAULT ADMIN/PETUGAS
    // ==========================================
    case 'dashboard':
    default:
        $PATH = __DIR__ . '/../pages/dashboard.php';
        if (file_exists($PATH)) include $PATH;
        break;


    // ==========================================
    // 3. DASHBOARD DEFAULT ADMIN/PETUGAS
    // ==========================================
    case 'buat_pengaduan':
        $path = __DIR__ . '/../pages/masyarakat/tambah_pengaduan.php';

        if (file_exists($path)) {
            include $path;
        } else {
            echo "File tidak ditemukan: " . $path;
        }
        break;
}
