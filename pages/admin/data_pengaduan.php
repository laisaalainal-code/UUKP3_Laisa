<?php
// Mengambil semua data pengaduan beserta nama masyarakat
$query = mysqli_query($koneksi, "
    SELECT p.*, m.nama_masyarakat
    FROM tbl_pengaduan p
    JOIN tbl_masyarakat m
        ON p.id_masyarakat = m.id_masyarakat
    ORDER BY p.id_pengaduan DESC
");
?>

<div class="container-fluid">
    <h3 class="mb-3">Data Pengaduan</h3>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Masyarakat</th>
                            <th>Isi Laporan</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($data['tgl_pengaduan']); ?></td>
                                    <td><?= htmlspecialchars($data['nama_masyarakat']); ?></td>
                                    <td><?= nl2br(htmlspecialchars($data['isi_laporan'])); ?></td>
                                    <td><?= htmlspecialchars($data['status']); ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                        ?>
                            <tr>
                                <td colspan="5" class="text-center">
                                    Belum ada data pengaduan.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>