<?php
session_start();
include "../../UKK/function.php"; // Pastikan path benar

// Jika user sudah login → langsung lempar ke index
if (isset($_SESSION['email'])) {
    header("Location: ../../index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Cek email
    $query = mysqli_query($conn, "SELECT * FROM user WHERE email='$email'");
    $data = mysqli_fetch_assoc($query);

    if ($data) {
        // Verifikasi password
        if (password_verify($password, $data['password'])) {

            // Simpan session
            $_SESSION['email'] = $data['email'];
            $_SESSION['role']  = $data['role'];

            // Redirect sesuai role
            if ($data['role'] == 'admin') {
                header("Location: ../../index.php"); 
            } else if ($data['role'] == 'user') {
                header("Location: ../../pages/user_dashboard.php"); 
            } else {
                header("Location: ../../index.php"); // default
            }
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>
