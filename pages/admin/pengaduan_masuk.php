<?php
// Mengambil data pengaduan beserta nama masyarakat yang melapor
$query = mysqli_query($koneksi, "
    SELECT p.*, m.nama_masyarakat
    FROM tbl_pengaduan p
    JOIN tbl_masyarakat m
        ON p.id_masyarakat = m.id_masyarakat
    ORDER BY p.id_pengaduan DESC
");
?>

<div class="container-fluid">

    <!-- Judul halaman -->
    <h3 class="mb-3">Data Pengaduan Masuk</h3>

    <!-- Tabel daftar pengaduan -->
    <div class="card">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-bordered table-striped">

                    <!-- Header tabel -->
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <!-- Isi tabel -->
                    <tbody>
                        <?php
                        $no = 1;

                        // Memeriksa apakah ada data pengaduan
                        if ($query && mysqli_num_rows($query) > 0) {

                            // Mengambil data satu per satu
                            while ($data = mysqli_fetch_assoc($query)) {
                        ?>
                                <tr>
                                    <td><?= $no++; ?></td>

                                    <td>
                                        <?= htmlspecialchars($data['tgl_pengaduan']); ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['nama_masyarakat']); ?>
                                    </td>

                                    <td>
                                        <?= nl2br(htmlspecialchars($data['isi_laporan'])); ?>
                                    </td>

                                    <td>
                                        <?php if (!empty($data['foto_masyarakat'])) { ?>
                                            <img
                                                src="../pages/images/pengaduan/<?= htmlspecialchars($data['foto_masyarakat']); ?>"
                                                width="100"
                                                alt="Foto pengaduan">
                                        <?php } else { ?>
                                            Tidak ada foto
                                        <?php } ?>
                                    </td>

                                    <td>
                                        <?= htmlspecialchars($data['status']); ?>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6" class="text-center">
                                    Belum ada pengaduan masuk.
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>

                </table>
            </div>

        </div>
    </div>
</div>