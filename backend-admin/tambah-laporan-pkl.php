<?php
session_start();

// Membatasi akses halaman sebelum login
if (!isset($_SESSION['login'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu.');
        document.location.href = 'login.php';
        </script>";
    exit;
}

$title = 'Tambah Laporan PKL';

include 'layout/header.php';

// Proses tambah data laporan PKL
if (isset($_POST['tambah'])) {
    if (create_laporan_pkl($_POST, $_FILES) > 0) {
        echo "<script>
        alert('Data Laporan PKL berhasil ditambahkan.');
        document.location.href = 'laporan-pkl.php';
        </script>";
    } else {
        echo "<script>
            alert('Data Laporan PKL gagal ditambahkan.');
            document.location.href = 'laporan-pkl.php';
            </script>";
    }
}

// Ambil data siswa untuk dropdown (gunakan fungsi select untuk ambil data siswa dari database)
$data_siswa = select("SELECT * FROM siswa ORDER BY nis ASC");
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                
                    <h4 class="text-center">Tambah Laporan PKL</h4>
                    <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
        <form action="" method="post" enctype="multipart/form-data">
            <!-- NIS -->
            <div class="mb-3">
                <label for="nis" class="form-label">NIS</label>
                <select name="nis" id="nis" class="form-control" required>
                    <option value="">-- Pilih NIS --</option>
                    <?php foreach ($data_siswa as $siswa) : ?>
                        <option value="<?= $siswa['nis']; ?>"><?= $siswa['nis']; ?> - <?= $siswa['nama_siswa']; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- File Laporan (Opsional) -->
            <div class="mb-3">
                <label for="file_laporan" class="form-label">File Laporan (Opsional)</label>
                <input type="file" class="form-control" id="file_laporan" name="file_laporan" accept=".pdf,.docx">
            </div>

            <!-- File Project (Opsional) -->
            <div class="mb-3">
                <label for="file_project" class="form-label">File Project (Opsional)</label>
                <input type="file" class="form-control" id="file_project" name="file_project" accept=".zip,.rar">
            </div>

            <!-- Nilai Akhir PKL (Opsional) -->
            <div class="mb-3">
                <label for="nilai_akhir_pkl" class="form-label">Nilai Akhir PKL (Opsional)</label>
                <input type="number" class="form-control" id="nilai_akhir_pkl" name="nilai_akhir_pkl" placeholder="Nilai Akhir PKL">
            </div>

            <div class="mb-3">
                <div class="d-flex justify-content-between">
                    <!-- Tombol Kembali di sebelah kiri -->
                    <a href="laporan-pkl.php" class="btn btn-secondary">Kembali</a>

                    <!-- Tombol Tambah di sebelah kanan -->
                    <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>


<?php include 'layout/footer.php'; ?>
