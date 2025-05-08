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
if ($_SESSION["level"] != 1) {
    echo "<script>
        alert('Anda tidak memiliki hak akses.');
        document.location.href = 'akun.php';
        </script>";
    exit;
}

$title = 'Laporan PKL - Admin';
include 'layout/header.php';

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
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <!-- /.card-header -->
                        <div class="card-body">
                            <!-- Tabel Laporan PKL -->
                            <div class="table-responsive">
                                <table id="serverside5" class="table table-bordered table-hover mt-3">
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
        </div>
    </section>
</div>

<?php include 'layout/footer.php'; ?>
