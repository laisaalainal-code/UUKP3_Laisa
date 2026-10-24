
<?php
// Mengambil session masyarakat
$nik = $_SESSION['nik'] ?? '';
$nama = $_SESSION['nama_masyarakat'] ?? $_SESSION['nama'] ?? 'Masyarakat';

// Menyiapkan data pengaduan
$riwayat_pengaduan = [];

if ($nik !== '') {
    // Mencari masyarakat berdasarkan NIK
    $nik_query = mysqli_real_escape_string($koneksi, $nik);

    $data_masyarakat = tampil("
        SELECT id_masyarakat, nama_masyarakat
        FROM tbl_masyarakat
        WHERE nik = '$nik_query'
    ");

    // Mengambil riwayat pengaduan masyarakat
    if (!empty($data_masyarakat)) {
        $id_masyarakat = (int) $data_masyarakat[0]['id_masyarakat'];
        $nama = $data_masyarakat[0]['nama_masyarakat'];

        $riwayat_pengaduan = tampil("
            SELECT *
            FROM tbl_pengaduan
            WHERE id_masyarakat = $id_masyarakat
            ORDER BY tgl_pengaduan DESC
        ");
    }
}
?>

<div class="page-heading">
    <h3>
        Selamat Datang, <?= htmlspecialchars($nama); ?>!
    </h3>

    <p class="text-subtitle text-muted">
        Pantau riwayat pengaduan Anda di sini.
    </p>
</div>

<div class="page-content">
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Riwayat Pengaduan</h5>

<a href="?page=buat_pengaduan" class="btn btn-primary">
    <i class="bi bi-plus"></i> Buat Laporan
</a>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tanggal</th>
                                <th>Isi Laporan</th>
                                <th>Foto Bukti</th>
                                <th>Status</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (!empty($riwayat_pengaduan)) : ?>
                                <?php $i = 1; ?>

                                <?php foreach ($riwayat_pengaduan as $row) : ?>
                                    <tr>
                                        <td><?= $i++; ?></td>

                                        <td>
                                            <?= !empty($row['tgl_pengaduan'])
                                                ? date(
                                                    'd-m-Y',
                                                    strtotime($row['tgl_pengaduan'])
                                                )
                                                : '-'; ?>
                                        </td>

                                        <td>
                                            <?= htmlspecialchars(
                                                substr($row['isi_laporan'] ?? '', 0, 50)
                                            ); ?>

                                            <?= strlen($row['isi_laporan'] ?? '') > 50
                                                ? '...'
                                                : ''; ?>
                                        </td>

                                        <td>
                                            <?php if (!empty($row['foto_masyarakat'])) : ?>
                                                <img
                                                    src="../images/pengaduan/<?= htmlspecialchars(
                                                        $row['foto_masyarakat']
                                                    ); ?>"
                                                    alt="Foto bukti pengaduan"
                                                    width="80"
                                                    class="rounded"
                                                >
                                            <?php else : ?>
                                                <span class="badge bg-secondary">
                                                    Tidak ada foto
                                                </span>
                                            <?php endif; ?>
                                        </td>

                                        <td>
                                            <?php
                                            $status = $row['status'] ?? '';

                                            if ($status === 'menunggu') {
                                                echo '<span class="badge bg-danger">Menunggu</span>';
                                            } elseif ($status === 'proses') {
                                                echo '<span class="badge bg-warning text-dark">Sedang Diproses</span>';
                                            } elseif ($status === 'selesai') {
                                                echo '<span class="badge bg-success">Selesai</span>';
                                            } else {
                                                echo '<span class="badge bg-secondary">Status tidak diketahui</span>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                            <?php else : ?>
                                <tr>
                                    <td colspan="5" class="text-center">
                                        Belum ada riwayat pengaduan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
</div>
