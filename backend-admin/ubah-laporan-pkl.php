<?php
session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('login dulu');
        document.location.href = 'login.php';
        </script>";
    exit;
}

$title = 'Ubah Laporan PKL';

include 'layout/header.php';

// Mengecek jika tombol ubah ditekan
if (isset($_POST['ubah'])) {
    if (update_laporan_pkl($_POST, $_FILES) > 0) {
        echo "<script>
        alert('Data Laporan PKL Berhasil Diubah');
        document.location.href = 'laporan-pkl.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Laporan PKL Gagal Diubah');
            document.location.href = 'laporan-pkl.php';
            </script>";
    }
}

// ambil id_laporan_pkl dari url
$id_laporan_pkl = (int)$_GET['id_laporan_pkl'];

// query ambil data laporan pkl
$laporan_pkl = select("SELECT * FROM laporan_pkl WHERE id_laporan_pkl = $id_laporan_pkl")[0];

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
                    <h4 class="text-center">Ubah Laporan PKL</h4>
                    <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
         <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_laporan_pkl" value="<?= $laporan_pkl['id_laporan_pkl']; ?>">
            <input type="hidden" name="file_laporan_lama" value="<?= $laporan_pkl['file_laporan']; ?>">
            <input type="hidden" name="file_project_lama" value="<?= $laporan_pkl['file_project']; ?>">

            <!-- NIS -->
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <input type="text" class="form-control" id="nis" name="nis" value="<?= $laporan_pkl['nis']; ?>" readonly>
            </div>

            <!-- File Laporan -->
            <div class="mb-3">
                <label for="file_laporan" class="form-label">File Laporan</label>
                <input type="file" class="form-control" id="file_laporan" name="file_laporan" accept=".pdf,.docx">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file laporan</small>
                <?php if ($laporan_pkl['file_laporan']) : ?>
                    <p>File Laporan Saat Ini: <a href="assets/files/<?= $laporan_pkl['file_laporan']; ?>" target="_blank">Lihat Laporan</a></p>
                <?php endif; ?>
            </div>

            <!-- File Project -->
            <div class="mb-3">
                <label for="file_project" class="form-label">File Project</label>
                <input type="file" class="form-control" id="file_project" name="file_project" accept=".zip,.rar">
                <small class="form-text text-muted">Kosongkan jika tidak ingin mengubah file project</small>
                <?php if ($laporan_pkl['file_project']) : ?>
                    <p>File Project Saat Ini: <a href="assets/files/<?= $laporan_pkl['file_project']; ?>" target="_blank">Lihat Project</a></p>
                <?php endif; ?>
            </div>

            <!-- Nilai Akhir PKL -->
            <div class="mb-3">
                <label for="nilai_akhir_pkl" class="form-label">Nilai Akhir PKL</label>
                <input type="number" class="form-control" id="nilai_akhir_pkl" name="nilai_akhir_pkl" value="<?= $laporan_pkl['nilai_akhir_pkl']; ?>" required>
            </div>

            <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <!-- Tombol Kembali di sebelah kiri -->
                        <a href="laporan-pkl.php" class="btn btn-secondary">Kembali</a>

                        <!-- Tombol Tambah di sebelah kanan -->
                        <button type="submit" name="ubah" class="btn btn-success">Ubah</button>
                    </div>
                </div>
        </form>
    </div>
</div>

<?php include 'layout/footer.php'; ?>
