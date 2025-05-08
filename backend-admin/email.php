<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silahkan untuk login terlebih dahulu');
            document.location.href = 'login.php'; 
          </script>";
    exit;
}

$title = 'Kirim Email';

include 'layout/header.php';

use PHPMailer\PHPMailer\PHPMailer;

require 'vendor/autoload.php';
$mail = new PHPMailer(true);
//Server settings
$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'pplgbmtibmti@gmail.com';                     //SMTP username
$mail->Password   = 'vnusdmgkmjminpxz';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;

if (isset($_POST['kirim'])) {

    $mail->setFrom('pplgbmtibmti@gmail.com', 'pplg bmti');
    $mail->addAddress($_POST['email_penerima']); // penerima
    $mail->addReplyTo('pplgbmtibmti@gmail.com', 'pplg bmti');

    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['pesan'];


    if ($mail->send()) {

        if (create_barang($_POST) > 0) {
            echo "<script>
                    alert('Email Berhasil Dikirimkan');
                    document.location.href = 'email.php';
                </script>";
        } else {
            echo "<script>
                    alert('Email Gagal Dikirimkan');
                    document.location.href = 'email.php';
                </script>";
        }
        exit();
    }
}

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="fas fa-envelope"></i> Kirim Email</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item active">Kirim Email</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="email_penerima" class="form-label">Email Penerima</label>
                    <input type="email" class="form-control" id="email_penerima" name="email_penerima"
                        placeholder="email penerima... " required>
                </div>

                <div class="mb-3">
                    <label for="subject" class="form-label">Subject</label>
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="subject..."
                        required>
                </div>

                <div class="mb-3">
                    <label for="pesan" class="form-label">Pesan</label>
                    <textarea name="pesan" id="pesan" cols="30" rows="10" class="form-control"></textarea>
                </div>

                <button type="submit" name="kirim" class="btn btn-primary" style="float: right;">Kirim</button>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php

include 'layout/footer.php';

?>