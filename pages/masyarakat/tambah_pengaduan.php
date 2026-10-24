
<?php
require_once __DIR__ . '/../../inc/function.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$id_masyarakat = (int) ($_SESSION['id_masyarakat'] ?? 0);
$pesan = '';

$tanggal = date('Y-m-d');
$isi = '';

if (isset($_POST['kirim_pengaduan'])) {
    $tanggal = trim($_POST['tgl_pengaduan'] ?? '');
    $isi = trim($_POST['isi_laporan'] ?? '');
    $foto = '';

    if ($id_masyarakat <= 0) {
        $pesan = 'Session masyarakat tidak ditemukan. Silakan login kembali.';
    } elseif ($tanggal === '' || $isi === '') {
        $pesan = 'Tanggal dan isi laporan wajib diisi.';
    } elseif ($tanggal > date('Y-m-d')) {
        $pesan = 'Tanggal pengaduan tidak boleh di masa depan.';
    } else {
        $folder = __DIR__ . '/../images/pengaduan/';

        if (!is_dir($folder)) {
            if (!mkdir($folder, 0775, true)) {
                $pesan = 'Folder penyimpanan foto gagal dibuat.';
            }
        }

        if (
            $pesan === '' &&
            !empty($_FILES['foto_masyarakat']['name'])
        ) {
            $tmp = $_FILES['foto_masyarakat']['tmp_name'];
            $ukuran = (int) $_FILES['foto_masyarakat']['size'];

            $ekstensi = strtolower(
                pathinfo(
                    $_FILES['foto_masyarakat']['name'],
                    PATHINFO_EXTENSION
                )
            );

            if (!in_array($ekstensi, ['jpg', 'jpeg', 'png'], true)) {
                $pesan = 'Foto harus berformat JPG, JPEG, atau PNG.';
            } elseif ($ukuran > 2 * 1024 * 1024) {
                $pesan = 'Ukuran foto maksimal 2 MB.';
            } elseif (
                !isset($_FILES['foto_masyarakat']['error']) ||
                $_FILES['foto_masyarakat']['error'] !== UPLOAD_ERR_OK ||
                !is_uploaded_file($tmp)
            ) {
                $pesan = 'Upload foto gagal.';
            } else {
                $info_foto = @getimagesize($tmp);

                if ($info_foto === false) {
                    $pesan = 'File yang diunggah bukan gambar yang valid.';
                } else {
                    $nama_file = bin2hex(random_bytes(16)) . '.' . $ekstensi;

                    if (move_uploaded_file($tmp, $folder . $nama_file)) {
                        $foto = $nama_file;
                    } else {
                        $pesan = 'Foto gagal disimpan.';
                    }
                }
            }
        }

        if ($pesan === '') {
            $stmt = mysqli_prepare(
                $koneksi,
                "INSERT INTO tbl_pengaduan
                (
                    tgl_pengaduan,
                    id_masyarakat,
                    isi_laporan,
                    foto_masyarakat,
                    status
                )
                VALUES (?, ?, ?, ?, 'menunggu')"
            );

            if ($stmt) {
                mysqli_stmt_bind_param(
                    $stmt,
                    'siss',
                    $tanggal,
                    $id_masyarakat,
                    $isi,
                    $foto
                );

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_close($stmt);

                    echo "<script>
                        alert('Pengaduan berhasil dikirim!');
                        window.location.href =
                            'index.php?pages=riwayat_pengaduan';
                    </script>";
                    exit;
                } else {
                    $pesan = 'Gagal menyimpan pengaduan: '
                        . mysqli_stmt_error($stmt);

                    mysqli_stmt_close($stmt);
                }
            } else {
                $pesan = 'Query pengaduan gagal disiapkan.';
            }
        }
    }
}
?>

<div class="container-fluid">
    <div class="card shadow-sm">
        <div class="card-header">
            <h5 class="mb-0">Buat Pengaduan</h5>
        </div>

        <div class="card-body">

            <?php if ($pesan !== '') : ?>
                <div class="alert alert-danger">
                    <?= htmlspecialchars($pesan) ?>
                </div>
            <?php endif; ?>

            <form method="POST" enctype="multipart/form-data">

                <div class="mb-3">
                    <label for="tgl_pengaduan" class="form-label">
                        Tanggal Pengaduan
                    </label>

                    <input
                        type="date"
                        name="tgl_pengaduan"
                        id="tgl_pengaduan"
                        class="form-control"
                        value="<?= htmlspecialchars($tanggal) ?>"
                        max="<?= date('Y-m-d') ?>"
                        required
                    >
                </div>

                <div class="mb-3">
                    <label for="isi_laporan" class="form-label">
                        Isi Laporan
                    </label>

                    <textarea
                        name="isi_laporan"
                        id="isi_laporan"
                        class="form-control"
                        rows="5"
                        placeholder="Tuliskan pengaduan kamu..."
                        required
                    ><?= htmlspecialchars($isi) ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="foto_masyarakat" class="form-label">
                        Foto Pendukung (Opsional)
                    </label>

                    <input
                        type="file"
                        name="foto_masyarakat"
                        id="foto_masyarakat"
                        class="form-control"
                        accept=".jpg,.jpeg,.png"
                    >

                    <small class="text-muted">
                        Format JPG, JPEG, atau PNG. Maksimal 2 MB.
                    </small>
                </div>

                <button
                    type="submit"
                    name="kirim_pengaduan"
                    class="btn btn-primary"
                >
                    <i class="fas fa-paper-plane"></i>
                    Kirim Pengaduan
                </button>

                <a
                    href="index.php?pages=riwayat_pengaduan"
                    class="btn btn-secondary"
                >
                    Batal
                </a>

            </form>
        </div>
    </div>
</div>