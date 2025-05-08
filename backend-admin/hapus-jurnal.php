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
$id_jurnal = (int)$_GET['id_jurnal'];

if (delete_jurnal($id_jurnal) > 0) {
    echo "<script>
    alert('Data jurnal Berhasil Dihapus');
    document.location.href = 'jurnal.php'; 
    </script>";
} else {
echo "<script>
    alert('Data jurnal Gagal Dihapus');
    document.location.href = 'jurnal.php';
    </script>";
}