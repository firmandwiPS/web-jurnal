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

$title = 'Tambah Jurnal';
include 'layout/header.php';

// Ambil data siswa untuk dropdown
$data_siswa = select("SELECT * FROM siswa ORDER BY nis ASC");

// Cek apakah tombol tambah ditekan
if (isset($_POST['tambah'])) {
    if (create_jurnal($_POST, $_FILES) > 0) {
        echo "<script>
                alert('Data Jurnal Berhasil Ditambahkan');
                document.location.href = 'jurnal.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Jurnal Gagal Ditambahkan');
                document.location.href = 'jurnal.php';
              </script>";
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">

                <h4 class="text-center">Tambah Jurnal</h4>
                <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
                <!-- NIS (Dari Data Siswa) -->
                <div class="row">
                    <div class="mt-2 col-lg-6">
                        <label for="nis" class="form-label">NIS</label>
                        <select name="nis" id="nis" class="form-control " required>
                            <option value="">-- Pilih NIS --</option>
                            <?php foreach ($data_siswa as $siswa) : ?>
                                <option value="<?= $siswa['nis']; ?>"><?= $siswa['nis']; ?> - <?= $siswa['nama_siswa']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Tanggal Kegiatan -->
                    <div class="mb-3 col-lg-6">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" required>
                    </div>
                </div>

                <!-- Uraian Kegiatan -->
                <div class="mb-3">
                    <label for="uraian_kegiatan" class="form-label">Uraian Kegiatan</label>
                    <textarea class="form-control" id="uraian_kegiatan" name="uraian_kegiatan" rows="3" required></textarea>
                </div>

                <!-- Catatan Pembimbing -->
                <div class="mb-3">
                    <label for="catatan_pembimbing" class="form-label">Catatan Pembimbing</label>
                    <textarea class="form-control" id="catatan_pembimbing" name="catatan_pembimbing" rows="3" required></textarea>
                </div>

                <!-- Paraf Pembimbing -->
                <div class="mb-3">
                    <label for="paraf_pembimbing" class="form-label">Paraf Pembimbing</label>
                    <input type="file" class="form-control" id="paraf_pembimbing" name="paraf_pembimbing"
                        onchange="previewImg()">
                    <small class="form-text text-muted">Upload gambar untuk paraf pembimbing (jpg, jpeg, png). Bisa dikosongkan.</small>
                </div>


                <button type="submit" name="tambah" class="btn btn-success" style="float: right;">Tambah Jurnal</button>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<!-- Preview image -->
<script>
    function previewImg() {
        const foto = document.querySelector('#foto');
        const imgPreview = document.querySelector('.img-preview');

        const fileFoto = new FileReader();
        fileFoto.readAsDataURL(foto.files[0]);

        fileFoto.onload = function(e) {
            imgPreview.src = e.target.result;
        }
    }
</script>

<?php include 'layout/footer.php'; ?>
