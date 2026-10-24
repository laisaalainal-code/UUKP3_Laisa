
<?php
require_once __DIR__ . '/../../inc/function.php';

$id_masyarakat = (int) ($_SESSION['id_masyarakat'] ?? 0);

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT nama_masyarakat, nik, username,
            telepon_masyarakat, alamat_masyarakat
     FROM tbl_masyarakat
     WHERE id_masyarakat = ?
     LIMIT 1"
);

mysqli_stmt_bind_param($stmt, 'i', $id_masyarakat);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
$profil = mysqli_fetch_assoc($hasil);
?>

<div class="container-fluid">
    <h3 class="mb-4">Profil Saya</h3>

    <?php if ($profil): ?>
        <div class="card">
            <div class="card-body">
                <div class="form-group">
                    <label>Nama Lengkap</label>
                    <input class="form-control"
                           value="<?= htmlspecialchars($profil['nama_masyarakat']) ?>"
                           readonly>
                </div>

                <div class="form-group">
                    <label>NIK</label>
                    <input class="form-control"
                           value="<?= htmlspecialchars($profil['nik']) ?>"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Username</label>
                    <input class="form-control"
                           value="<?= htmlspecialchars($profil['username']) ?>"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Nomor Telepon</label>
                    <input class="form-control"
                           value="<?= htmlspecialchars($profil['telepon_masyarakat']) ?>"
                           readonly>
                </div>

                <div class="form-group">
                    <label>Alamat</label>
                    <textarea class="form-control" rows="3"
                              readonly><?= htmlspecialchars($profil['alamat_masyarakat'] ?? '') ?></textarea>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-warning">
            Data profil tidak ditemukan.
        </div>
    <?php endif; ?>
</div>
