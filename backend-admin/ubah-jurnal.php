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

$title = 'Ubah jurnal';

include 'layout/header.php';

if (isset($_POST['ubah'])) {
    // Perbaiki pemanggilan $_FILES yang salah ketik menjadi $_FILES
    if (update_jurnal($_POST, $_FILES) > 0) {
        echo "<script>
            alert('Data jurnal Berhasil Diubah');
            document.location.href = 'jurnal.php';
        </script>";
    } else {
        echo "<script>
            alert('Data jurnal gagal Diubah');
            document.location.href = 'jurnal.php';
        </script>";
    }
}

// ambil id jurnal dari url
$id_jurnal = (int)$_GET['id_jurnal'];

// query ambil data jurnal
$jurnal = select("SELECT * FROM jurnal WHERE id_jurnal = $id_jurnal")[0];
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <h4 class="text-center">Ubah Jurnal</h4>
                <br>
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <form action="" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_jurnal" value="<?= $jurnal['id_jurnal']; ?>">
                <input type="hidden" name="fotolama" value="<?= $jurnal['paraf_pembimbing']; ?>">

                <!-- NIS (Dari Data Siswa) -->
                <div class="row">
                    <div class="mb-3 col-lg-6">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" class="form-control" id="nis" name="nis" required
                            value="<?= $jurnal['nis']; ?>" readonly>
                        <input type="hidden" name="nis" value="<?= $jurnal['nis']; ?>"> <!-- Menyertakan NIS sebagai hidden input -->
                    </div>

                    <!-- Tanggal Kegiatan -->
                    <div class="mb-3 col-lg-6">
                        <label for="tanggal_kegiatan" class="form-label">Tanggal Kegiatan</label>
                        <input type="date" class="form-control" id="tanggal_kegiatan" name="tanggal_kegiatan" readonly
                            value="<?= $jurnal['tanggal_kegiatan']; ?>">
                    </div>
                </div>

                <!-- Uraian Kegiatan dengan CKEditor -->
                <div class="mb-3">
                    <label for="uraian_kegiatan" class="form-label">Uraian Kegiatan</label>
                    <textarea class="form-control" id="uraian_kegiatan" name="uraian_kegiatan" rows="5"><?= $jurnal['uraian_kegiatan']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="catatan_pembimbing" class="form-label">Catatan Pembimbing</label>
                    <textarea name="catatan_pembimbing" id="catatan_pembimbing" class="form-control" placeholder="Catatan dari pembimbing (opsional)"><?= $jurnal['catatan_pembimbing']; ?></textarea>
                </div>

                <div class="mb-3">
                    <label for="paraf_pembimbing" class="form-label">Paraf Pembimbing</label>
                    <input type="file" class="form-control" id="paraf_pembimbing" name="paraf_pembimbing" accept="image/*">
                    <small class="form-text text-muted">Pilih gambar tanda tangan pembimbing (format: JPG, PNG)</small>
                    <br>
                    <!-- Tampilkan paraf jika sudah ada -->
                    <?php if (!empty($jurnal['paraf_pembimbing'])) : ?>
                        <img src="assets/img/<?= $jurnal['paraf_pembimbing']; ?>" width="100" alt="Paraf Pembimbing">
                        <br>
                        <small>Paraf pembimbing yang sudah ada.</small>
                    <?php else : ?>
                        <p>Belum ada paraf pembimbing.</p>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <div class="d-flex justify-content-between">
                        <!-- Tombol Kembali di sebelah kiri -->
                        <a href="siswa.php" class="btn btn-secondary">Kembali</a>

                        <!-- Tombol Tambah di sebelah kanan -->
                        <button type="submit" name="ubah" class="btn btn-success">Ubah</button>
                    </div>
                </div>
            </form>
        </div>
    </section>
    <!-- /.content -->
</div>

<?php include 'layout/footer.php'; ?>


