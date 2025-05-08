<?php  

session_start();
/// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert ('login dulu');
        document.location.href = 'login.php';
        </script>";
    exit;
}

include 'config/app.php';

//menerima id mahasiswa yang dipilih pengguna
$id_presensi = (int)$_GET['id_presensi'];

if (delete_presensi($id_presensi) > 0) {
    echo "<script>
    alert('Presensi Berhasil Dihapus');
    document.location.href = 'presensi.php'; 
    </script>";
} else {
echo "<script>
    alert('Presensi Gagal Dihapus');
    document.location.href = 'presensi.php';
    </script>";
}