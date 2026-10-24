<?php
session_start();
include 'function_login.php';

if (empty($_POST['email']) || empty($_POST['password'])) {
    die("Form tidak lengkap!");
}

$email = $_POST['email'];
$password = $_POST['password'];

// Ambil user berdasarkan email
$query = "SELECT * FROM tbl_users WHERE email = '$email'";
$result = mysqli_query($koneksi, $query);

if ($data = mysqli_fetch_assoc($result)) {

    // Cek password hash
    if (password_verify($password, $data['password'])) {

        $_SESSION['id_user'] = $data['id_user'];
        $_SESSION['email'] = $data['email'];
        $_SESSION['role'] = $data['role'];

        // Redirect berdasarkan role
        switch($data['role']) {
            case 2: // admin/mitra
                header("Location: ../index.php");
                exit;
            case 1: // customer/user
                header("Location: ../index1.php");
                exit;
            default:
                die("Peran tidak dikenali!");
        }

    } else {
        die("Login gagal! Password salah");
    }

} else {
    die("Login gagal! Email tidak ditemukan");
}
?>