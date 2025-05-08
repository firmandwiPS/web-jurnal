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
        document.location.href = 'presensi.php';
        </script>";
    exit;
}

$title = 'Presensi';
include 'layout/header.php';

// Menangani pencarian
$search_query = '';
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $search_query = "WHERE nis LIKE '%$search%' OR tanggal LIKE '%$search%' OR keterangan LIKE '%$search%'";
}

// Menampilkan data presensi berdasarkan pencarian
$data_presensi = select("SELECT * FROM presensi $search_query ORDER BY id_presensi DESC");
$data_siswa = select("SELECT * FROM siswa ORDER BY nis ASC");

// Menambah data presensi
if (isset($_POST['tambah'])) {
    if (create_presensi($_POST) > 0) {
        echo "<script>
                alert('Data Presensi Berhasil Ditambahkan');
                document.location.href = 'presensi.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Presensi Gagal Ditambahkan');
                document.location.href = 'presensi.php';
              </script>";
    }
}
// Cek apakah tombol ubah ditekan
if (isset($_POST['ubah'])) {
    if (update_presensi($_POST) > 0) {
        echo "<script>
                alert('Data Presensi Berhasil Diubah');
                document.location.href = 'presensi.php';
              </script>";
    } else {
        echo "<script>
                alert('Data Presensi Gagal Diubah');
                document.location.href = 'presensi.php';
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
                <div class="col-sm-6">
                    <h1 class="m-0"><i class="nav-icon fas fa-calendar-check"></i> Data Presensi
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
                       <!-- Tombol Tambah -->
                       <div class="row">
                                <div class="mb-3 col-md-6">
                                    <button type="button" class="btn btn-primary mb-1" data-bs-toggle="modal" data-bs-target="#modalTambah">
                                        <i class="fas fa-plus-circle"></i> Tambah
                                    </button>
                                </div>

                            
                             <!-- Tabel Presensi -->
                             <div class="table-responsive">
                             <table  class="table table-bordered table-hover mt-3" id="serverside3" >
                                <thead class="text-center">
                                    <tr>
                                        <th>No</th>
                                        <th>NIS</th>
                                        <th>Nama</th>
                                        <th>Tanggal</th>
                                        <th>Keterangan</th>
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


<!-- Modal Tambah -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Presensi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="presensi.php" method="post">
                    <!-- NIS Column -->
                    <div class="mb-3 col-12">
                        <label for="nis" class="form-label">NIS</label>
                        <select name="nis" id="nis" class="form-control" required>
                            <option value="">-- Pilih NIS --</option>
                            <?php foreach ($data_siswa as $siswa) : ?>
                                <option value="<?= $siswa['nis']; ?>"><?= $siswa['nis']; ?> - <?= $siswa['nama_siswa']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>


                    <!-- Tanggal Column -->
                    <div class="mb-3 col-12">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control w-100" required>
                    </div>

                    <!-- Keterangan Column -->
                    <div class="mb-3 col-12">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <select name="keterangan" id="keterangan" class="form-control w-100" required>
                            <option value="">-- Pilih Keterangan --</option>
                            <option value="Masuk">Masuk</option>
                            <option value="Izin">Izin</option>
                            <option value="Alpa">Alpa</option>
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                        <button type="submit" name="tambah" class="btn btn-primary">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Ubah -->
<?php foreach ($data_presensi as $presensi) : ?>
    <div class="modal fade" id="modalUbah<?= $presensi['id_presensi']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Ubah Presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="presensi.php" method="post">
                        <input type="hidden" name="id_presensi" value="<?= $presensi['id_presensi']; ?>">

                        <div class="mb-3">
                            <label for="nis" class="form-label">NIS</label>
                            <input type="number" class="form-control" id="nis" name="nis" value="<?= $presensi['nis']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" name="tanggal" id="tanggal" class="form-control" value="<?= $presensi['tanggal']; ?>" readonly>
                        </div>

                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <select name="keterangan" id="keterangan" class="form-control" required>
                                <option value="Masuk" <?= $presensi['keterangan'] == 'Masuk' ? 'selected' : ''; ?>>Masuk</option>
                                <option value="Izin" <?= $presensi['keterangan'] == 'Izin' ? 'selected' : ''; ?>>Izin</option>
                                <option value="Alpa" <?= $presensi['keterangan'] == 'Alpa' ? 'selected' : ''; ?>>Alpa</option>
                            </select>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Kembali</button>
                            <button type="submit" name="ubah" class="btn btn-primary">Ubah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>


<!-- Modal Hapus -->
<?php foreach ($data_presensi as $presensi) : ?>

    <div class="modal fade" id="modalHapus<?= $presensi['id_presensi']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Hapus presensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus data presensi dengan NIS <?= htmlspecialchars($presensi['nis']); ?> pada tanggal <?= htmlspecialchars($presensi['tanggal']); ?>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <a href="hapus-presensi.php?id_presensi=<?= $presensi['id_presensi']; ?>" class="btn btn-danger">Hapus</a>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>
<?php include 'layout/footer.php'; ?>