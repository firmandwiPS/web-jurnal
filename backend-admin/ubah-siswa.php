<?php

session_start();

// Membatasi akses halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silahkan untuk login terlebih dahulu');
            document.location.href = 'login.php'; 
          </script>";
    exit;
}

$title = 'Ubah Siswa';

include 'layout/header.php';

// Cek apakah id_siswa ada di URL
if (isset($_GET['id_siswa'])) {
    $id_siswa = $_GET['id_siswa'];

    // Ambil data siswa berdasarkan id_siswa
    $siswa = select("SELECT * FROM siswa WHERE id_siswa = $id_siswa")[0];
}

// Cek apakah tombol ubah ditekan
if (isset($_POST['ubah'])) {
    if (update_siswa($_POST) > 0) {
        // Cek level pengguna dan arahkan ke halaman yang sesuai
        if ($_SESSION['level'] == 1) {
            echo "<script>
                    alert('Data siswa Berhasil Diubah');
                    document.location.href = 'siswa.php'; // Menuju ke siswa.php untuk level 1
                  </script>";
        } else if ($_SESSION['level'] == 2) {
            echo "<script>
                    alert('Data siswa Berhasil Diubah');
                    document.location.href = 'siswa-user.php'; // Menuju ke siswa-user.php untuk level 2
                  </script>";
        }
    } else {
        if ($_SESSION['level'] == 1) {
            echo "<script>
                    alert('Data Siswa Gagal Diubah');
                    document.location.href = 'siswa.php'; // Menuju ke siswa.php untuk level 1
                  </script>";
        } else if ($_SESSION['level'] == 2) {
            echo "<script>
                    alert('Data Siswa Gagal Diubah');
                    document.location.href = 'siswa-user.php'; // Menuju ke siswa-user.php untuk level 2
                  </script>";
        }
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h4 class="text-center">Ubah Siswa</h4>
                <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- Input hidden untuk id_siswa -->
                <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa']; ?>">

                <!-- NIS -->
                <div class="row">
                    <!-- NIS -->
                    <div class="mb-3 col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="number" class="form-control" id="nis" name="nis" value="<?= $siswa['nis']; ?>" required>
                    </div>

                    <!-- Nama Siswa -->
                    <div class="mb-3 col-md-6">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" value="<?= $siswa['nama_siswa']; ?>" required>
                    </div>
                </div>
                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select name="jk" id="jk" class="form-control" required>
                        <option value="Laki-laki" <?= $siswa['jenis_kelamin'] == 'Laki-laki' ? 'selected' : ''; ?>>Laki-laki</option>
                        <option value="Perempuan" <?= $siswa['jenis_kelamin'] == 'Perempuan' ? 'selected' : ''; ?>>Perempuan</option>
                    </select>
                </div>

                <!-- Asal Sekolah -->
                <div class="mb-3">
                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" value="<?= $siswa['asal_sekolah']; ?>" required>
                </div>
                <div class="row">
                    <!-- Tanggal Mulai PKL -->
                    <div class="mb-3 col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai PKL</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= $siswa['tanggal_mulai']; ?>" required>
                    </div>

                    <!-- Tanggal Selesai PKL -->
                    <div class="mb-3 col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai PKL</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= $siswa['tanggal_selesai']; ?>" required>
                    </div>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp" value="<?= $siswa['no_hp']; ?>" required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat"><?= $siswa['alamat']; ?></textarea>
                </div>
                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <!-- Tombol Kembali di sebelah kiri -->
                        <a href="<?php echo ($_SESSION['level'] == 1) ? 'siswa.php' : 'siswa-user.php'; ?>" class="btn btn-secondary">Kembali</a>

                        <!-- Tombol Ubah di sebelah kanan -->
                        <button type="submit" name="ubah" class="btn btn-success">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php include 'layout/footer.php'; ?>