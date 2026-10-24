<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="./images/favicon.png">
    <link href="../" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                   <form action="../uts/config/proses_login.php" method="POST">
    <div class="form-group">
        <label><strong>Email</strong></label>
        <input type="email" name="email" class="form-control" placeholder="Email" required>
    </div>
    <div class="form-group">
        <label><strong>Password</strong></label>
        <input type="password" name="password" class="form-control" placeholder="Password" required>
    </div>
    <div class="form-group">
        <label><strong>Role</strong></label>
        <select name="role" class="form-control" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin">Admin</option>
            <option value="petugas">Petugas</option>
            <option value="penyewa">Penyewa</option>
            <option value="pemilik">Pemilik</option>
        </select>
    </div>

    <div class="text-center">
        <button type="submit" class="btn btn-primary btn-block">Sign me in</button>
    </div>
</form>

<div class="new-account mt-3">
                                        <p>Don't have an account? <a class="text-primary" href="./page-register.html">Sign up</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--************
        Scripts
    *************-->
    <!-- Required vendors -->
    <script src="../vendors/global/global.min.js"></script>
    <script src="../js/quixnav-init.js"></script>
    <script src="../js/custom.min.js"></script>

</body>
<script>
function togglePassword() {
    const passwordInput = document.getElementById("password");
    const icon = event.target;
    if (passwordInput.type === "password") {
        passwordInput.type = "text";
    } else {
        passwordInput.type = "password";
    }
}
</script>
</html>