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
if ( $_SESSION["level"] != 2) {
    echo "<script>
        alert('Anda tidak memiliki hak akses.');
        document.location.href = 'akun.php';
        </script>";
    exit;
}

$title = 'Laporan PKL';
include 'layout/header.php';

// Menangani pencarian
$search_query = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search']; // Ambil input pencarian
    $search = mysqli_real_escape_string($conn, $search); // Mencegah SQL Injection
    $search_query = "WHERE laporan_pkl.nis LIKE '%$search%'";
}

// Query untuk menampilkan data laporan_pkl dengan join ke tabel siswa
$query = "SELECT laporan_pkl.*, siswa.nama_siswa, siswa.asal_sekolah
          FROM laporan_pkl
          INNER JOIN siswa ON laporan_pkl.nis = siswa.nis
          $search_query
          ORDER BY laporan_pkl.id_laporan_pkl DESC";

// Pastikan kamu memanggil fungsi select untuk mengeksekusi query
$data_laporan_pkl = select($query);


?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-book"></i> Data Laporan PKL
                </div>
                <hr><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->

    <!-- /.row -->
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <div class="mb-3 col-md-6">
                                <a href="tambah-laporan-pkl.php" class="btn btn-primary mb-1">
                                    <i class="fas fa-plus-circle"></i> Tambah
                                </a>    
                            </div>

                            <!-- Tabel Laporan PKL -->
                            <div class="table-responsive">
                            <table id="serverside4" class="table table-bordered table-hover mt-3">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Asal Sekolah</th>
                                        <th>File Laporan</th>
                                        <th>File Project</th>
                                        <th>Nilai Akhir PKL</th>
                                        <th style="width: 10%;">Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>




<?php include 'layout/footer.php'; ?>