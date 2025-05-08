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
if ($_SESSION["level"] != 1 && $_SESSION["level"] != 2) {
    echo "<script>
        alert('Anda tidak memiliki hak akses.');
        document.location.href = 'akun.php';
        </script>";
    exit;
}

$title = 'Jurnal';
include 'layout/header.php';

// Menangani pencarian
$search_query = '';
if (isset($_GET['search']) && !empty($_GET['search'])) {
    $search = $_GET['search']; // Ambil input pencarian
    $search_query = "WHERE jurnal.nis LIKE '%$search%' OR jurnal.tanggal_kegiatan LIKE '%$search%' OR jurnal.uraian_kegiatan LIKE '%$search%'";
}

// Query untuk menampilkan data jurnal dengan join ke tabel siswa
$query = "SELECT jurnal.*, siswa.nama_siswa 
          FROM jurnal 
          INNER JOIN siswa ON jurnal.nis = siswa.nis
          $search_query
          ORDER BY jurnal.id_jurnal DESC";

// Pastikan kamu memanggil fungsi select untuk mengeksekusi query
$data_jurnal = select($query);  // Menjalankan query pencarian atau query semua data jurnal

?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-pen"></i>
                    </i>
                    Data Jurnal
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
                                    <a href="tambah-jurnal.php" class="btn btn-primary mb-1">
                                        <i class="fas fa-plus-circle"></i> Tambah
                                    </a>
                                </div>
                                <div class="table-responsive">
                            <table  class="table table-bordered table-hover mt-3" id="serverside2">
                            
                        <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Tanggal Kegiatan</th>
                                        <th>Uraian Kegiatan</th>
                                        <th>Catatan Pembimbing</th>
                                        <th>Paraf Pembimbing</th>
                                        <th style="width: 10%;">Aksi</th> 
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                            </table>
                            
                                <!-- /. tools -->
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body pt-0">
                            <!--The calendar -->
                            <div id="calendar" style="width: 100%"></div>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
    </section>
    <!-- right col -->
</div>
<!-- /.row (main row) -->
</div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>


<?php include 'layout/footer.php'; ?>