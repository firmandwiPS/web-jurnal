use PHPMailer\PHPMailer\PHPMailer;
//load composer's autoloader
require 'vendor/autoload.php';
$mail = new PHPMailer(true);
//server settings
$mail->SMTPDebug = 2; //Enable verbosedebug output
$mail->isSTMTP(); //Send using SMTP
$mail->Host = 'smtp.gmail.com'; //Set the SMTP server to send through
$mail->SMTPAuth = //Set the SMTP authentication
$mail->Username = 'user@example.com'; //SMTP username
$mail->Password = 'secret'; //SMTP password
$mail->SMTPsecure = PHPMailer::ENCRYPTION_SMTPS; //Enable implicit TLS encryption
$mail->pORT = 465;

if(isset($_POST['Kirim'])) {
//Recipients
$mail->setFrom('tutormubatekno@gmail.com', 'Tutorial Muba Teknologi');
$mail->addaddress($_POST['email_penerima']); //penerima
$mail->addReplyTo('tutormubatekno@gmail.com', 'Tutorial Muba Teknologi');

$mail->Subject =$_POST['subject'];
$mail->Body =$_POST['pesan'];

if ($mail->send()) {
echo "<script>
alert('Email Berhasil Dikirim');
document.location.href = 'email.php';
</script>";
} else{
echo "<script>
alert('email gagal dikirimkan');
document.location.href = 'email.com';
</script>";
}
exit();
}