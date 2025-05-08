<?php
session_start();

// Membatasi akses halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        document.location.href = 'login.php';
    </script>";
    exit;
}

// Membatasi akses berdasarkan level user
if ($_SESSION["level"] != 1 ) {
    echo "<script>
        alert('Anda tidak memiliki hak akses.');
        document.location.href = 'akun.php';
    </script>";
    exit;
}

$title = 'Data Siswa';
// Include header
include 'layout/header.php';

// Default values
$jumlahHalaman = 1;
$halamanAktif = 1;
$jumlahDataPerhalaman = 10; // Default number of records per page
$searchQuery = "";

// If there's a search query
if (isset($_GET['search'])) {
    $searchQuery = $_GET['search'];
}

// If the user filters data by date
if (isset($_POST['filter'])) {
    $tgl_awal = strip_tags($_POST['tgl_awal'] . "00:00:00");
    $tgl_akhir = strip_tags($_POST['tgl_akhir'] . "23:59:59");

    // Query data
    $data_siswa = select("SELECT * FROM siswa WHERE tanggal BETWEEN '$tgl_awal' AND '$tgl_akhir' ORDER BY id_siswa DESC");
} else {
    // query tampil data dengan pagination
    $jumlahDataPerhalaman = 1;
    $jumlahData = count(select("SELECT * FROM siswa"));
    $jumlahHalaman = ceil($jumlahData / $jumlahDataPerhalaman);
    $halamanAktif = (isset($_GET['halaman']) ? $_GET['halaman'] : 1);
    $awalData = ($jumlahDataPerhalaman * $halamanAktif) - $jumlahDataPerhalaman;

    $data_siswa = select("SELECT * FROM siswa ORDER BY id_siswa DESC LIMIT $awalData, $jumlahDataPerhalaman");
}

// Database query to fetch siswa data
$siswa = select("SELECT * FROM siswa ORDER BY id_siswa ASC");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-users"></i> Data Siswa</h1>
                </div>
                <hr><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-8">
                                    <a href="tambah-siswa.php" class="btn btn-primary mb-1">
                                        <i class="fas fa-plus-circle"></i> Tambah
                                    </a>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                <div class="table-responsive">
                                    <table id="serverside" class="table table-bordered table-hover mt-3" >
                                        <thead class="text-center">
                                            <tr>
                                                <th>No</th>
                                                <th>NIS</th>
                                                <th>Nama</th>
                                                <th>Jenis Kelamin</th>
                                                <th>Asal Sekolah</th>
                                                <th>Tanggal Mulai</th>
                                                <th>Tanggal Selesai</th>
                                                <th>No HP</th>
                                                <th>Alamat</th>
                                                <th style="width: 10%;">Aksi</th> 
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
 

                                    </div>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                    </div>
                </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>