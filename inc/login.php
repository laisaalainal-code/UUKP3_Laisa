<?php
// Memulai session agar data login bisa disimpan dan digunakan di halaman lain
session_start();

// Memanggil file function.php yang berisi fungsi dan koneksi database
require_once __DIR__ . '/function.php';

// Menyiapkan variabel untuk menyimpan pesan error login
$error = '';

// Mengecek apakah tombol login sudah ditekan
if (isset($_POST['login'])) {

    // Mengambil username atau email yang diketik dari form login
    // Jika input username tidak tersedia, maka mengambil input email
    // trim() digunakan untuk menghapus spasi di awal dan akhir teks
    $login = trim($_POST['username'] ?? $_POST['email'] ?? '');

    // Mengambil password yang diketik dari form login
    // Jika input password tidak tersedia, nilainya menjadi string kosong
    $password = $_POST['password'] ?? '';

    // =====================================================
    // 1. CEK LOGIN MASYARAKAT
    // =====================================================

    // Menyiapkan query untuk mencari akun masyarakat berdasarkan username
    // Tanda ? akan diisi dengan username yang dimasukkan pengguna
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT * FROM tbl_masyarakat WHERE username = ? LIMIT 1"
    );

    // Memasukkan nilai $login ke tanda ? pada query
    // Huruf "s" berarti data yang dikirim bertipe string atau teks
    mysqli_stmt_bind_param($stmt, "s", $login);

    // Menjalankan query untuk mencari data masyarakat di database
    mysqli_stmt_execute($stmt);

    // Mengambil hasil pencarian dari database
    $result = mysqli_stmt_get_result($stmt);

    // Mengambil satu baris data masyarakat dalam bentuk array asosiatif
    // Nama kolom database menjadi key untuk mengakses datanya
    $masyarakat = mysqli_fetch_assoc($result);

    // Mengecek apakah akun masyarakat ditemukan dan password cocok
    // password_verify() membandingkan password input dengan password hash di database
    if ($masyarakat && password_verify($password, $masyarakat['password'])) {

        // Membuat ID session baru setelah login berhasil
        // untuk membantu mencegah session fixation
        session_regenerate_id(true);

        // Menyimpan ID masyarakat ke dalam session
        $_SESSION['id_masyarakat'] = $masyarakat['id_masyarakat'];

        // Menyimpan NIK masyarakat ke dalam session
        $_SESSION['nik'] = $masyarakat['nik'];

        // Menyimpan nama masyarakat ke dalam session
        $_SESSION['nama_masyarakat'] = $masyarakat['nama_masyarakat'];

        // Menandai bahwa pengguna yang login adalah masyarakat
        $_SESSION['role'] = 'masyarakat';

        // Mengarahkan masyarakat ke halaman utama masyarakat
        header('Location: ../masyarakat/index.php');

        // Menghentikan proses PHP setelah melakukan redirect
        exit;
    }

    // =====================================================
    // 2. CEK LOGIN ADMIN ATAU PETUGAS
    // =====================================================

    // Jika login masyarakat gagal, cari akun admin/petugas
    // berdasarkan email di tabel tbl_petugas
    $stmt = mysqli_prepare(
        $koneksi,
        "SELECT * FROM tbl_petugas WHERE email = ? LIMIT 1"
    );

    // Memasukkan nilai $login ke tanda ? pada query
    // Huruf "s" berarti parameter berupa string
    mysqli_stmt_bind_param($stmt, "s", $login);

    // Menjalankan query untuk mencari akun admin/petugas
    mysqli_stmt_execute($stmt);

    // Mengambil hasil pencarian dari database
    $result = mysqli_stmt_get_result($stmt);

    // Mengambil data akun yang ditemukan dalam bentuk array asosiatif
    $petugas = mysqli_fetch_assoc($result);

    // Mengecek apakah akun ditemukan dan password yang dimasukkan cocok
    if ($petugas && password_verify($password, $petugas['password'])) {

        // Membuat ID session baru setelah login berhasil
        session_regenerate_id(true);

        // Menyimpan ID petugas ke dalam session
        $_SESSION['id_petugas'] = $petugas['id_petugas'];

        // Menyimpan email petugas ke dalam session
        $_SESSION['email'] = $petugas['email'];

        // Menyimpan level pengguna ke dalam session sebagai integer
        $_SESSION['level'] = (int) $petugas['level'];

        // Jika level pengguna adalah 1, berarti admin
        if ((int) $petugas['level'] === 1) {

            // Mengarahkan admin ke halaman utama admin
            header('Location: ../admin/index.php');
            exit;

        // Jika level pengguna adalah 2, berarti petugas
        } elseif ((int) $petugas['level'] === 2) {

            // Mengarahkan petugas ke halaman utama petugas
            header('Location: ../petugas/index.php');
            exit;
        }
    }

    // =====================================================
    // 3. LOGIN GAGAL
    // =====================================================

    // Jika akun tidak ditemukan atau password salah,
    // simpan pesan error agar bisa ditampilkan di halaman login
    $error = 'Username/email atau password salah!';
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Spica Admin</title>
  <!-- base:css -->
  <link rel="stylesheet" href="../vendors/mdi/css/materialdesignicons.min.css">
  <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
  <!-- endinject -->
  <!-- plugin css for this page -->
  <!-- End plugin css for this page -->
  <!-- inject:css -->
  <link rel="stylesheet" href="../asset/css/style.css">
  <!-- endinject -->
  <link rel="shortcut icon" href="../asset/images/favicon.png" />
</head>


  <body class="bg-galaxy">
<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow-lg p-5 login-card" style="width: 550px;">
              <h4 class="text-center">LOGIN</h4>
              <form class="pt-3" method="POST">
                <div class="form-group">
                  <label>Email</label>
                  <div class="input-group" style="border:1px solid #0e0101;">
                    <div class="input-group-prepend bg-transparent">
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-account-outline text-primary"></i>
                      </span>
                    </div>
                    <input type="email" class="form-control form-control-lg border-left-0" required placeholder="email" name="email">
                  </div>
                </div>
                <div class="form-group" >
                  <label>Password</label>
                  <div class="input-group" style="border:1px solid #0e0101;">
                    <div class="input-group-prepend bg-transparent" >
                      <span class="input-group-text bg-transparent border-right-0">
                        <i class="mdi mdi-lock-outline text-primary" ></i>
                      </span>
                    </div>
                    <input type="password" name="password" class="form-control form-control-lg border-left-0" placeholder="password">                        
                  </div>
                </div>
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  <a href="#" class="auth-link text-black">Forgot password?</a>
                </div>
                <div class="my-3 text-center" >
                <button type="submit"
                        name="login"
                        class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                        >
                    LOGIN
                </button>
              </div>
               
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="../inc/register.php" class="text-primary">Create</a>
                </div>
              </form>
            </div>
          <?php if ($error !== ''): ?>
    <div class="alert alert-danger">
        <?= htmlspecialchars($error) ?>
    </div>
<?php endif; ?>
         
        
      <!-- content-wrapper ends -->
    
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- base:js -->
  <script src="../../vendors/js/vendor.bundle.base.js"></script>
  <!-- endinject -->
  <script src="../../js/jquery.cookie.js" type="text/javascript"></script>
  <!-- inject:js -->
  <script src="../../js/off-canvas.js"></script>
  <script src="../../js/hoverable-collapse.js"></script>
  <script src="../../js/template.js"></script>
  <!-- endinject -->
</body>

</html>
