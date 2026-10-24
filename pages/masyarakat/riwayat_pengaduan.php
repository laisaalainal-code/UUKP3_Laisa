
<?php
require_once __DIR__ . '/../../inc/function.php';

$id_masyarakat = (int) ($_SESSION['id_masyarakat'] ?? 0);

$stmt = mysqli_prepare(
    $koneksi,
    "SELECT id_pengaduan, tgl_pengaduan, isi_laporan,
            foto_masyarakat, status
     FROM tbl_pengaduan
     WHERE id_masyarakat = ?
     ORDER BY tgl_pengaduan DESC, id_pengaduan DESC"
);

mysqli_stmt_bind_param($stmt, 'i', $id_masyarakat);
mysqli_stmt_execute($stmt);
$hasil = mysqli_stmt_get_result($stmt);
?>

<div class="container-fluid">
    <h3 class="mb-4">Riwayat Pengaduan</h3>

    <div class="card">
        <div class="card-body table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Tanggal</th>
                        <th>Isi Laporan</th>
                        <th>Foto</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (mysqli_num_rows($hasil) > 0): ?>
                    <?php $no = 1; ?>
                    <?php while ($row = mysqli_fetch_assoc($hasil)): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($row['tgl_pengaduan']) ?></td>
                            <td><?= nl2br(htmlspecialchars($row['isi_laporan'])) ?></td>
                            <td>
                                <?php if ($row['foto_masyarakat'] !== ''): ?>
                                    <img
                                        src="../pages/images/pengaduan/<?= rawurlencode(basename($row['foto_masyarakat'])) ?>"
                                        width="80"
                                        alt="Foto pengaduan">
                                <?php else: ?>
                                    Tidak ada foto
                                <?php endif; ?>
                            </td>
                            <td>
                                <?= htmlspecialchars(ucfirst($row['status'])) ?>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">
                            Belum ada pengaduan.
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
