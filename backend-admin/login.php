<?php
session_start();
include 'config/app.php';

// check apakah tombol login ditekan
if (isset($_POST['login'])) {
    // ambil input username dan password
    $username = mysqli_real_escape_string($db, $_POST['username']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    // secret key recaptcha
    $secret_key = "6Lc7xrUqAAAAALBVLyTmnMcnbTUfwkqEGq9mm6Xo";
    $verifikasi = file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $secret_key . '&response=' . $_POST['g-recaptcha-response']);
    $response = json_decode($verifikasi);

    if ($response->success) {
        // check username
        $result = mysqli_query($db, "SELECT * FROM akun WHERE username = '$username'");

        // jika username ditemukan
        if (mysqli_num_rows($result) == 1) {
            // ambil data user
            $hasil = mysqli_fetch_assoc($result);

            // check password
            if (password_verify($password, $hasil['password'])) {
                // set session
                $_SESSION['login']      = true;
                $_SESSION['id_akun']    = $hasil['id_akun'];
                $_SESSION['nama']       = $hasil['nama'];
                $_SESSION['username']   = $hasil['username'];
                $_SESSION['email']      = $hasil['email'];
                $_SESSION['level']      = $hasil['level'];

                // Redirect based on user level
                if ($_SESSION['level'] == 1) {
                    // level 1, redirect to siswa.php
                    header("Location: siswa.php");
                } elseif ($_SESSION['level'] == 2) {
                    // level 2, redirect to siswa-user.php
                    header("Location: siswa-user.php");
                } else {
                    // Default redirect if the level is unknown (you can handle other levels as needed)
                    header("Location: index.php");
                }
                exit;
            } else {
                // jika password salah
                $error = 'Password salah';
            }
        } else {
            // jika username tidak ditemukan
            $error = 'Username tidak ditemukan';
        }
    } else {
        // jika recaptcha tidak valid
        $errorRecaptcha = 'Recaptcha tidak valid';
    }
}
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>
    <link href="../assets/img/logobmti.png" rel="icon">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="assets-template/plugins/fontawesome-free/css/all.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="assets-template/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/signin.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <script src="main.js" async></script>

</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <div class="login-logo">
            <div class="text-center">
                <img src="../assets/img/logobmti.png" alt="" width="50" height="50">
                <H6 class="mt-2">Jurnal Kegiatan</H6>
            </div>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Silakan login terlebih dahulu untuk mengakses halaman ini!</p>

                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger text-center">
                        <b><?php echo $error; ?></b>
                    </div>
                <?php endif; ?>

                <?php if (isset($errorRecaptcha)) : ?>
                    <div class="alert alert-danger text-center">
                        <b><?php echo $errorRecaptcha; ?></b>
                    </div>
                <?php endif; ?>

                <form action="" method="post">
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="floatingInput" name="username" placeholder="Username..." autocomplete="off" required>
                        <label for="floatingInput">Username</label>
                    </div>

                    <div class="form-floating mb-3">
                        <input type="password" class="form-control" id="floatingPassword" name="password" placeholder="Password..." autocomplete="off" required>
                        <label for="floatingPassword">Password</label>

                    </div>

                    <div class="form-floating mb-3 recaptcha-container">
                        <div class="g-recaptcha" data-sitekey="6Lc7xrUqAAAAAKUU8c7D5KpQSD3U2xxQZOEvwyMA"></div>
                    </div>

                    <div class="col d-flex flex-column justify-content-center align-items-center">
                        <!-- Grup Tombol Login dan Kembali -->
                        <div class="button-group">
                            <!-- Tombol Kembali -->
                            <button type="button" class="btn btn-secondary btn-block" onclick="window.location.href='../index.html'">Kembali</button>
                            <!-- Tombol Login -->
                            <button type="submit" name="login" class="btn btn-primary btn-block">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- jQuery -->
    <script src="assets-template/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 5 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="assets-template/dist/js/adminlte.min.js"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
</body>

</html>

<style>
    .login-box-msg {
        font-size: 15px;
        /* Ubah ukuran font sesuai kebutuhan */
        color: grey;
        /* Anda juga bisa mengubah warna teks jika diperlukan */
    }
</style>
