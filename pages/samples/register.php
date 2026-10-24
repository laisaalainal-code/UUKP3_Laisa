

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register Account</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../../images/favicon.png">
    <link href="../../css/style.css" rel="stylesheet">
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

                                    <h4 class="text-center mb-4">Create an Account</h4>

                                    <!-- PESAN ERROR / SUKSES -->
                                    <?php if(isset($error)): ?>
                                        <div class="alert alert-danger"><?= $error ?></div>
                                    <?php endif; ?>

                                    <?php if(isset($success)): ?>
                                        <div class="alert alert-success"><?= $success ?></div>
                                    <?php endif; ?>

                                    <!-- FORM REGISTER -->
                                    <form method="POST" action="">
                                        <div class="form-group">
                                            <label><strong>Nama</strong></label>
                                            <input type="text" name="nama" class="form-control" required placeholder="Nama lengkap">
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" required placeholder="Email">
                                        </div>

                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control" required placeholder="Password">
                                        </div>

                                        <div class="text-center mt-4">
                                            <button class="btn btn-primary btn-block" href="../../index.php"type="submit">Register</button>
                                        </div>
                                    </form>

                                    <div class="new-account mt-3">
                                        <p>Already have an account? 
                                            <a class="text-primary" href="login.php">Sign in</a>
                                        </p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPT -->
    <script src="../../vendor/global/global.min.js"></script>
    <script src="../../js/quixnav-init.js"></script>
    <script src="../../js/custom.min.js"></script>

</body>
</html>
