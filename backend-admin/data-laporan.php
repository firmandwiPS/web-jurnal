<?php

$title = 'Laporan PKL';
include 'layout/header3.php';

// Menangani pencarian berdasarkan NIS dan Nama
$search_query = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_query = "WHERE (laporan_pkl.nis LIKE '%$search%' OR siswa.nama_siswa LIKE '%$search%')";
}

// Query untuk menampilkan data laporan pkl berdasarkan pencarian atau semua data
$query = "
    SELECT laporan_pkl.*, siswa.nama_siswa 
    FROM laporan_pkl
    LEFT JOIN siswa ON siswa.nis = laporan_pkl.nis
    $search_query
    ORDER BY laporan_pkl.id_laporan_pkl DESC
";
$data_laporan_pkl = select($query);  // Menjalankan query pencarian atau query semua data laporan_pkl
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <!-- Header for Laporan PKL -->
                    <div class="container mt-3">
                        <h4 class="m-0">
                            <i class="fas fa-file-alt"></i> Data Laporan PKL
                        </h4>
                        <hr>

                        <div class="container-5">
                            <!-- Form untuk Pencarian -->
                            <div class="row">
                                 <!-- Form untuk Pencarian -->
                                <div class="mb-3 col-md-6">
                                    <form method="get" class="d-flex mb-3">
                                        <input type="text" name="search" class="form-control" placeholder="Cari berdasarkan NIS, Nama" value="<?= isset($search) ? htmlspecialchars($search) : ''; ?>" />
                                        <button type="submit" class="btn btn-info ml-2">Cari</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table table-bordered table-hover mt-3" id="example2">
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama Siswa</th> <!-- Kolom untuk Nama Siswa -->
                                        <th>File Laporan</th>
                                        <th>File Project</th>
                                        <th>Nilai Akhir PKL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1; ?>
                                    <?php foreach ($data_laporan_pkl as $laporan_pkl) : ?>
                                        <tr>
                                            <td><?= $no++; ?></td>
                                            <td><?= $laporan_pkl['nis']; ?></td>
                                            <td><?= $laporan_pkl['nama_siswa']; ?></td> <!-- Menampilkan nama siswa -->
                                            <td class="text-red">
                                                <?php if ($laporan_pkl['file_laporan']) : ?>
                                                    <a href="assets/files/<?= $laporan_pkl['file_laporan']; ?>" target="_blank">Lihat Laporan</a>
                                                <?php else : ?>
                                                    Belum ada laporan
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-red">
                                                <?php if ($laporan_pkl['file_project']) : ?>
                                                    <a href="assets/files/<?= $laporan_pkl['file_project']; ?>" target="_blank">Lihat Project</a>
                                                <?php else : ?>
                                                    Belum ada project
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php
                                                // Menangani tampilan "Belum ada nilai" jika nilai kosong
                                                echo ($laporan_pkl['nilai_akhir_pkl'] != null && $laporan_pkl['nilai_akhir_pkl'] != '') ? $laporan_pkl['nilai_akhir_pkl'] : 'Belum ada nilai';
                                                ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
    </section><!-- /.content -->
</div><!-- /.content-wrapper -->

<?php include 'layout/footer2.php'; ?>
