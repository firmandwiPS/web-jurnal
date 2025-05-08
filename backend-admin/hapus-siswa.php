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
$id_siswa = (int)$_GET['id_siswa'];

if (delete_siswa($id_siswa) > 0) {
    echo "<script>
    alert('Data Siswa Berhasil Dihapus');
    document.location.href = 'siswa.php'; 
    </script>";
} else {
echo "<script>
    alert('Data Siswa Gagal Dihapus');
    document.location.href = 'siswa.php';
    </script>";
}