
<?php
$cari = trim($_GET['cari'] ?? '');

$sql = "SELECT p.*, m.nama_masyarakat
        FROM tbl_pengaduan p
        LEFT JOIN tbl_masyarakat m
        ON p.id_masyarakat = m.id_masyarakat";

if ($cari !== '') {
    $sql .= " WHERE m.nama_masyarakat LIKE ?
              OR p.isi_laporan LIKE ?
              OR p.status LIKE ?";
}

$sql .= " ORDER BY p.tgl_pengaduan DESC";

$stmt = mysqli_prepare($koneksi, $sql);

if ($stmt) {
    if ($cari !== '') {
        $keyword = "%{$cari}%";
        mysqli_stmt_bind_param(
            $stmt,
            "sss",
            $keyword,
            $keyword,
            $keyword
        );
    }

    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
} else {
    die("Query gagal: " . mysqli_error($koneksi));
}
?>

<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h4>Data Laporan Masuk</h4>
            <p class="text-muted mb-0">
                Daftar pengaduan masyarakat
            </p>
        </div>

        <div class="card-body">

            <form method="GET" class="mb-3">
              <input type="hidden" name="pages" value="pengaduan">

                <div class="input-group">
                    <input
                        type="text"
                        name="cari"
                        class="form-control"
                        placeholder="Cari nama atau isi laporan..."
                        value="<?= htmlspecialchars($cari) ?>"
                    >

                    <button type="submit" class="btn btn-primary">
                        Cari
                    </button>
<a href="?pages=pengaduan" class="btn btn-secondary">Reset</a>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>ID Pengaduan</th>
                            <th>Tanggal</th>
                            <th>Nama Pelapor</th>
                            <th>Isi Laporan</th>
                            <th>Foto</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        $no = 1;

                        if (mysqli_num_rows($result) > 0):
                            while ($data = mysqli_fetch_assoc($result)):
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>

                                <td>
                                    <?= htmlspecialchars(
                                        (string) $data['id_pengaduan']
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        (string) $data['tgl_pengaduan']
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        (string) ($data['nama'] ?? '-')
                                    ) ?>
                                </td>

                                <td>
                                    <?= htmlspecialchars(
                                        (string) $data['isi_laporan']
                                    ) ?>
                                </td>

                                <td>
                                    <?php if (!empty($data['foto'])): ?>
                                        <a
                                            href="../pages/pengaduan/foto/<?= rawurlencode(basename($data['foto'])) ?>"
                                            target="_blank"
                                            rel="noopener"
                                        >
                                            Lihat Foto
                                        </a>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>

                                <td>
                                    <?php
                                    $status = strtolower(
                                        (string) $data['status']
                                    );

                                    if ($status === '0' ||
                                        $status === 'menunggu') {
                                        echo '<span class="badge bg-warning text-dark">Menunggu</span>';
                                    } elseif ($status === 'proses' ||
                                              $status === 'diproses') {
                                        echo '<span class="badge bg-info text-dark">Diproses</span>';
                                    } elseif ($status === 'selesai') {
                                        echo '<span class="badge bg-success">Selesai</span>';
                                    } else {
                                        echo '<span class="badge bg-secondary">'
                                            . htmlspecialchars(
                                                (string) $data['status']
                                            )
                                            . '</span>';
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
                            endwhile;
                        else:
                        ?>
                            <tr>
                                <td colspan="7" class="text-center">
                                    Belum ada data laporan.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<?php
mysqli_stmt_close($stmt);
?>
