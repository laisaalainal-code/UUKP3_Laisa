
<?php
//+=+=========================================+=+
// APLIKASI PENGADUAN MASYARAKAT
//+=+=========================================+=+

// 1. PENGATURAN WAKTU
date_default_timezone_set('Asia/Jakarta');
$waktu_sekarang = date('Y-m-d H:i:s');


// 2. KONEKSI DATABASE
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "db_pengaduan";

$koneksi = mysqli_connect(
    $servername,
    $username,
    $password,
    $dbname
);

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


// 3. FUNGSI TAMPIL DATA
function tampil($query_string)
{
    global $koneksi;

    $query = mysqli_query($koneksi, $query_string);

    if (!$query) {
        die("Error: " . mysqli_error($koneksi));
    }

    $hasil_data = [];

    while ($row = mysqli_fetch_assoc($query)) {
        $hasil_data[] = $row;
    }

    return $hasil_data;
}

// =====================================================
// 4. FUNGSI REGISTRASI MASYARAKAT
// Fungsi untuk mendaftarkan akun masyarakat baru
// =====================================================
function registrasi($data)
{
    // Mengakses variabel koneksi database yang dibuat di luar fungsi
    global $koneksi;

    // Mengambil NIK dari form, menghapus spasi di awal/akhir,
    // lalu mengamankan karakter khusus untuk query SQL
    $nik = mysqli_real_escape_string(
        $koneksi,
        trim($data['nik'] ?? '')
    );

    // Mengambil nama masyarakat dari form
    $nama_masyarakat = mysqli_real_escape_string(
        $koneksi,
        trim($data['nama'] ?? '')
    );

    // Mengambil username yang akan digunakan untuk login
    $username = mysqli_real_escape_string(
        $koneksi,
        trim($data['username'] ?? '')
    );

    // Mengambil nomor telepon masyarakat dari form
    $telepon_masyarakat = mysqli_real_escape_string(
        $koneksi,
        trim($data['telp'] ?? '')
    );

    // Mengambil password yang dimasukkan pengguna
    $password = $data['password'] ?? '';

    // Mengambil password konfirmasi untuk dibandingkan
    $confirm_password = $data['confirm_password'] ?? '';

    // =====================================================
    // 1. VALIDASI DATA KOSONG
    // =====================================================

    // Memeriksa apakah ada data wajib yang belum diisi
    if (
        $nik === '' ||
        $nama_masyarakat === '' ||
        $username === '' ||
        $telepon_masyarakat === '' ||
        $password === ''
    ) {
        // Menampilkan peringatan jika ada data wajib yang kosong
        echo "<script>alert('Semua data wajib diisi!');</script>";

        // Menghentikan fungsi dan menandakan registrasi gagal
        return false;
    }

    // =====================================================
    // 2. CEK NIK DAN USERNAME
    // =====================================================

    // Mencari apakah NIK atau username sudah terdaftar
    // di tabel tbl_masyarakat
    $cek = mysqli_query(
        $koneksi,
        "SELECT id_masyarakat
         FROM tbl_masyarakat
         WHERE nik = '$nik' OR username = '$username'"
    );

    // Memeriksa apakah query berhasil dijalankan
    if (!$cek) {
        // Menghentikan program dan menampilkan pesan error database
        die("Error: " . mysqli_error($koneksi));
    }

    // Mengambil satu baris hasil pencarian
    // Jika data ditemukan, berarti NIK atau username sudah digunakan
    if (mysqli_fetch_assoc($cek)) {

        // Menampilkan peringatan bahwa data sudah terdaftar
        echo "<script>alert('NIK atau username sudah terdaftar!');</script>";

        // Menghentikan fungsi karena data tidak boleh didaftarkan lagi
        return false;
    }

    // =====================================================
    // 3. VALIDASI PASSWORD
    // =====================================================

    // Membandingkan password dengan password konfirmasi
    if ($password !== $confirm_password) {

        // Menampilkan peringatan jika kedua password berbeda
        echo "<script>alert('Password tidak sama!');</script>";

        // Menghentikan fungsi karena password tidak cocok
        return false;
    }

    // =====================================================
    // 4. MENGAMANKAN PASSWORD
    // =====================================================

    // Mengubah password asli menjadi hash sebelum disimpan
    // agar password tidak disimpan dalam bentuk teks biasa
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // =====================================================
    // 5. MENYIMPAN DATA MASYARAKAT
    // =====================================================

    // Membuat query INSERT untuk memasukkan data baru
    // ke kolom-kolom tabel tbl_masyarakat
    $query = "INSERT INTO tbl_masyarakat
        (nama_masyarakat, username, password, nik, telepon_masyarakat)
        VALUES (
            '$nama_masyarakat',
            '$username',
            '$password_hash',
            '$nik',
            '$telepon_masyarakat'
        )";

    // Menjalankan query INSERT untuk menyimpan data ke database
    if (!mysqli_query($koneksi, $query)) {

        // Menghentikan program jika proses penyimpanan gagal
        // dan menampilkan pesan error dari database
        die("Gagal registrasi: " . mysqli_error($koneksi));
    }

    // Mengembalikan jumlah baris yang berhasil ditambahkan
    // Biasanya bernilai 1 jika satu akun berhasil didaftarkan
    return mysqli_affected_rows($koneksi);
}


// 5. FUNGSI UPLOAD FOTO PENGADUAN
function upload_files(
    $file_input,
    $identifier,
    $target_folder = '../images/pengaduan',
    $option = []
) {
    $default = [
        'max_size' => 2 * 1024 * 1024,
        'allowed_types' => ['jpg', 'jpeg', 'png'],
        'create_folder' => true,
        'prefix' => 'BUKTI'
    ];

    $options = array_merge($default, $option);

    if (
        !isset($file_input['error']) ||
        !isset($file_input['tmp_name'])
    ) {
        return [
            'success' => false,
            'message' => 'File tidak valid.'
        ];
    }

    if ($file_input['error'] === UPLOAD_ERR_NO_FILE) {
        return [
            'success' => false,
            'message' => 'Tidak ada file yang diupload.'
        ];
    }

    if ($file_input['error'] !== UPLOAD_ERR_OK) {
        return [
            'success' => false,
            'message' => 'Terjadi kesalahan upload.'
        ];
    }

    $ekstensi = strtolower(
        pathinfo($file_input['name'], PATHINFO_EXTENSION)
    );

    if (!in_array($ekstensi, $options['allowed_types'])) {
        return [
            'success' => false,
            'message' => 'Ekstensi file tidak diizinkan.'
        ];
    }

    if ($file_input['size'] > $options['max_size']) {
        return [
            'success' => false,
            'message' => 'Ukuran file terlalu besar.'
        ];
    }

    if (
        !is_dir($target_folder) &&
        $options['create_folder']
    ) {
        if (!mkdir($target_folder, 0755, true)) {
            return [
                'success' => false,
                'message' => 'Gagal membuat folder.'
            ];
        }
    }

    if (!is_dir($target_folder)) {
        return [
            'success' => false,
            'message' => 'Folder upload tidak ditemukan.'
        ];
    }

    $prefix = $options['prefix']
        ? $options['prefix'] . '_'
        : '';

    $nama_file = $prefix
        . $identifier . '_'
        . date('Ymd_His') . '_'
        . uniqid() . '.'
        . $ekstensi;

    $path_file = rtrim($target_folder, '/\\')
        . DIRECTORY_SEPARATOR
        . $nama_file;

    if (move_uploaded_file($file_input['tmp_name'], $path_file)) {
        return [
            'success' => true,
            'Filename_tersimpan' => $nama_file
        ];
    }

    return [
        'success' => false,
        'message' => 'Gagal memindahkan file.'
    ];
}


// 6. FUNGSI TAMBAH PETUGAS
function tambah_petugas($data)
{
    global $koneksi;

    $nama_petugas = mysqli_real_escape_string(
        $koneksi,
        trim($data['nama_petugas'] ?? '')
    );

    $username = mysqli_real_escape_string(
        $koneksi,
        trim($data['username'] ?? '')
    );

    $telepon_petugas = mysqli_real_escape_string(
        $koneksi,
        trim($data['telp'] ?? '')
    );

    $password = $data['password'] ?? '';
    $confirm_password = $data['confirm_password'] ?? '';
    $level = (int) ($data['level'] ?? 2);

    if ($password !== $confirm_password) {
        $_SESSION['Sess_FormErrors'] = [
            'Password dan konfirmasi password tidak sama.'
        ];
        return false;
    }

    $cek = mysqli_query(
        $koneksi,
        "SELECT id_petugas FROM tbl_petugas
         WHERE email = '$username'"
    );

    if (!$cek) {
        $_SESSION['Sess_FormErrors'] = [
            'Gagal memeriksa akun: ' . mysqli_error($koneksi)
        ];
        return false;
    }

    if (mysqli_fetch_assoc($cek)) {
        $_SESSION['Sess_FormErrors'] = [
            'Email sudah terdaftar.'
        ];
        return false;
    }

    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    $query = "INSERT INTO tbl_petugas
        (nama_petugas, email, password, telepon_petugas, level)
        VALUES (
            '$nama_petugas',
            '$username',
            '$password_hash',
            '$telepon_petugas',
            $level
        )";

    if (mysqli_query($koneksi, $query)) {
        $_SESSION['Sess_SuccessMessage'] =
            'Data petugas berhasil ditambahkan!';
        return true;
    }

    $_SESSION['Sess_FormErrors'] = [
        'Gagal menambahkan petugas: ' . mysqli_error($koneksi)
    ];

    return false;
}


// 7. FUNGSI MEMBERIKAN TANGGAPAN
function berikan_tanggapan($data)
{
    global $koneksi;

    $id_pengaduan = (int) ($data['id_pengaduan'] ?? 0);

    $tanggapan = mysqli_real_escape_string(
        $koneksi,
        trim($data['tanggapan'] ?? '')
    );

    $status = $data['status'] ?? '';

    if (!in_array($status, ['menunggu', 'proses', 'selesai'])) {
        return false;
    }

    $status = mysqli_real_escape_string($koneksi, $status);

    $id_petugas = (int) ($_SESSION['id_petugas'] ?? 0);
    $tgl_tanggapan = date('Y-m-d');

    if ($id_petugas <= 0 || $id_pengaduan <= 0) {
        return false;
    }

    $query_tanggapan = "INSERT INTO tbl_tanggapan
        (id_pengaduan, tgl_tanggapan, tanggapan, id_petugas)
        VALUES (
            $id_pengaduan,
            '$tgl_tanggapan',
            '$tanggapan',
            $id_petugas
        )";

    if (!mysqli_query($koneksi, $query_tanggapan)) {
        die("Gagal menyimpan tanggapan: " . mysqli_error($koneksi));
    }

    $query_update = "UPDATE tbl_pengaduan
        SET status = '$status'
        WHERE id_pengaduan = $id_pengaduan";

    if (!mysqli_query($koneksi, $query_update)) {
        die("Gagal mengubah status: " . mysqli_error($koneksi));
    }

    return mysqli_affected_rows($koneksi);
}
?>
