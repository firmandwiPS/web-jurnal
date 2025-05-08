<?php

session_start();

if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Login dulu');
            document.location.href = 'login.php';
        </script>";
    exit;
}

if ($_SESSION["level"] != 1 && $_SESSION['level'] != 3) {
    echo "<script>
            alert('Anda tidak punya hak akses');
            document.location.href = 'akun.php';
        </script>";
    exit;
}

include 'layout/header.php';

$title = 'download-pdf';

$data_mahasiswa = select("SELECT * FROM mahasiswa ORDER BY id_mahasiswa DESC");
?>
<div class="content-wrapper">
    <div class="mt-5">
        <table id="serverside" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Jenis Kelamin</th>
                    <th>Telepon</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php foreach ($data_mahasiswa as $mahasiswa) : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $mahasiswa['nama']; ?></td>
                    <td><?= $mahasiswa['prodi']; ?></td>
                    <td><?= $mahasiswa['jk']; ?></td>
                    <td><?= $mahasiswa['telepon']; ?></td>
                    <td><img src="assets/img/'.$barang['foto']. '" class="gambar" /></td>
                </tr>;
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
<script>
window.print();
</script>