
<?php
session_start();

require_once '../inc/function.php';

$error = '';

if (isset($_POST['registrasi'])) {
    if (registrasi($_POST)) {
        echo "<script>
            alert('Registrasi masyarakat berhasil! Silakan login.');
            window.location.href = '../inc/login.php';
        </script>";
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="id" class="h-100">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register Masyarakat</title>
    <link rel="icon" type="image/png" sizes="16x16"
          href="../asset/img/toothless.jpeg">
    <link href="../asset/css/style.css" rel="stylesheet">
</head>

<body class="h-100">
<div class="authincation h-100">
    <div class="container-fluid h-100">
        <div class="row justify-content-center h-100 align-items-center">
            <div class="col-md-6">
                <div class="authincation-content">
                    <div class="auth-form">
                        <div style="border:1px solid #0e0101; border-radius:10px; padding:20px;">

                            <form method="POST">
                                <h4 class="text-center mb-4">
                                    Buat Akun Masyarakat
                                </h4>

                                <?php if (!empty($error)): ?>
                                    <div class="alert alert-danger">
                                        <?= htmlspecialchars($error) ?>
                                    </div>
                                <?php endif; ?>

                                <div class="form-group">
                                    <label><strong>NIK</strong></label>
                                    <input type="text" name="nik"
                                           class="form-control" required
                                           placeholder="Masukkan NIK"
                                           value="<?= htmlspecialchars($_POST['nik'] ?? '') ?>">
                                </div>

                                <div class="form-group">
                                    <label><strong>Nama Lengkap</strong></label>
                                    <input type="text" name="nama"
                                           class="form-control" required
                                           placeholder="Masukkan nama lengkap"
                                           value="<?= htmlspecialchars($_POST['nama'] ?? '') ?>">
                                </div>

                                <div class="form-group">
                                    <label><strong>Username</strong></label>
                                    <input type="text" name="username"
                                           class="form-control" required
                                           placeholder="Buat username"
                                           value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                                </div>

                                <div class="form-group">
                                    <label><strong>Nomor Telepon</strong></label>
                                    <input type="text" name="telp"
                                           class="form-control" required
                                           placeholder="Masukkan nomor telepon"
                                           value="<?= htmlspecialchars($_POST['telp'] ?? '') ?>">
                                </div>

                                <div class="form-group">
                                    <label><strong>Password</strong></label>
                                    <input type="password" name="password"
                                           class="form-control" required
                                           placeholder="Buat password"
                                           autocomplete="new-password">
                                </div>

                                <div class="form-group">
                                    <label><strong>Konfirmasi Password</strong></label>
                                    <input type="password" name="confirm_password"
                                           class="form-control" required
                                           placeholder="Ulangi password"
                                           autocomplete="new-password">
                                </div>

                                <div class="text-center mt-4">
                                    <button type="submit" name="registrasi"
                                            class="btn btn-primary btn-block">
                                        Register
                                    </button>
                                </div>
                            </form>

                            <div class="new-account mt-3">
                                <p>Sudah punya akun?
                                    <a class="text-primary"
                                       href="../inc/login.php">Login</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
