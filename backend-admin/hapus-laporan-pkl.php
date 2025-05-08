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
$id_laporan_pkl = (int)$_GET['id_laporan_pkl'];

if (delete_laporan_pkl($id_laporan_pkl) > 0) {
    echo "<script>
    alert('Data Laporan PKL Berhasil Dihapus');
    document.location.href = 'laporan-pkl.php'; 
    </script>";
} else {
echo "<script>
    alert('Data Laporan PKL Gagal Dihapus');
    document.location.href = 'laporan-pkl.php';
    </script>";
}