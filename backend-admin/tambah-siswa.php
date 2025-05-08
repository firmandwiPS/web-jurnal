<?php

session_start();

// membatasi halaman sebelum login
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silahkan untuk login terlebih dahulu');
            document.location.href = 'login.php'; 
          </script>";
    exit;
}

$title = 'Tambah Siswa';

include 'layout/header.php';

//cek apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (create_siswa($_POST) > 0) {
        echo "<script>
                alert('Data Siswa Berhasil Ditambahkan');
                document.location.href = 'siswa.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Siswa Gagal Ditambahkan');
                document.location.href = 'siswa.php';
              </script>";
    }
}
?>

<!-- Content Wrapper. Contains page content -->

<div class="content-wrapper">
    
    <!-- Content Header (Page header) -->
    <div class="content-header"  data-widget="pushmenu">
        <div class="container-fluid">
            <div class="row mb-2">

                    <h4 class="text-center">Tambah Siswa</h4>
                    <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- NIS and Nama Siswa -->
                <div class="row">
                    <!-- NIS -->
                    <div class="mb-3 col-md-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="number" class="form-control" id="nis" name="nis"  required>
                    </div>

                    <!-- Nama Siswa -->
                    <div class="mb-3 col-md-6">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa"  required>
                    </div>
                </div>

                <!-- Jenis Kelamin -->
                <div class="mb-3">
                    <label for="jk" class="form-label">Jenis Kelamin</label>
                    <select name="jk" id="jk" class="form-control" required>
                        <option value="">-- Pilih Jenis Kelamin --</option>
                        <option value="Laki-laki">Laki-laki</option>
                        <option value="Perempuan">Perempuan</option>
                    </select>
                </div>

                <!-- Asal Sekolah -->
                <div class="mb-3">
                    <label for="asal_sekolah" class="form-label">Asal Sekolah</label>
                    <input type="text" class="form-control" id="asal_sekolah" name="asal_sekolah" required>
                </div>

                <!-- Tanggal Mulai & Tanggal Selesai PKL -->
                <div class="row">
                    <!-- Tanggal Mulai PKL -->
                    <div class="mb-3 col-md-6">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai PKL</label>
                        <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" required>
                    </div>

                    <!-- Tanggal Selesai PKL -->
                    <div class="mb-3 col-md-6">
                        <label for="tanggal_selesai" class="form-label">Tanggal Selesai PKL</label>
                        <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" required>
                    </div>
                </div>

                <!-- No HP -->
                <div class="mb-3">
                    <label for="no_hp" class="form-label">No HP</label>
                    <input type="text" class="form-control" id="no_hp" name="no_hp"  required>
                </div>

                <!-- Alamat -->
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea name="alamat" id="alamat" class="form-control"  required></textarea>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <!-- Tombol Kembali di sebelah kiri -->
                        <a href="siswa.php" class="btn btn-secondary">Kembali</a>

                        <!-- Tombol Tambah di sebelah kanan -->
                        <button type="submit" name="tambah" class="btn btn-success">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php include 'layout/footer.php'; ?>
