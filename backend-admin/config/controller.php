<?php 
function select($query)
{
    global $db;

    $result = mysqli_query($db, $query);
    $rows = [];
 
    while ($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows; // Mengembalikan array hasil
}



function create_laporan_pkl($post, $files)
{
    global $db;

    // Ambil data dari form dan sanitasi input
    $nis = strip_tags($post['nis']);
    $nilai_akhir_pkl = isset($post['nilai_akhir_pkl']) && !empty($post['nilai_akhir_pkl']) ? strip_tags($post['nilai_akhir_pkl']) : 'Belum ada nilai';  // Jika kosong, set default

    // Ambil file dari form
    $file_laporan = $files['file_laporan'];
    $file_project = $files['file_project'];

    // Tentukan direktori tujuan upload
    $uploadDir = 'assets/files/';

    // Cek apakah folder tujuan ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
    }

    // Proses upload file laporan jika ada
    if ($file_laporan['error'] === 0) {
        $fileLaporanName = $file_laporan['name'];
        $fileLaporanTmpName = $file_laporan['tmp_name'];
        $fileLaporanDestination = $uploadDir . basename($fileLaporanName);

        // Pindahkan file laporan ke folder tujuan
        if (!move_uploaded_file($fileLaporanTmpName, $fileLaporanDestination)) {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file laporan!');</script>";
            return false;
        }
    } else {
        $fileLaporanName = null; // Jika file laporan tidak ada
    }

    // Proses upload file project jika ada
    if ($file_project['error'] === 0) {
        $fileProjectName = $file_project['name'];
        $fileProjectTmpName = $file_project['tmp_name'];
        $fileProjectDestination = $uploadDir . basename($fileProjectName);

        // Pindahkan file project ke folder tujuan
        if (!move_uploaded_file($fileProjectTmpName, $fileProjectDestination)) {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file project!');</script>";
            return false;
        }
    } else {
        $fileProjectName = null; // Jika file project tidak ada
    }

    // Query untuk tambah data ke tabel laporan_pkl
    $query = "INSERT INTO laporan_pkl (nis, file_laporan, file_project, nilai_akhir_pkl) 
              VALUES ('$nis', '$fileLaporanName', '$fileProjectName', '$nilai_akhir_pkl')";

    // Eksekusi query
    mysqli_query($db, $query);

    // Mengembalikan hasil apakah ada perubahan data
    return mysqli_affected_rows($db);
}

function update_laporan_pkl($post, $files)
{
    global $db;

    // Ambil data dari form dan sanitasi input
    $id_laporan_pkl = strip_tags($post['id_laporan_pkl']);  // ID laporan PKL yang akan diupdate
    $nis = strip_tags($post['nis']);
    $nilai_akhir_pkl = strip_tags($post['nilai_akhir_pkl']);
    
    // Ambil file laporan dan file project jika ada file yang diupload
    $file_laporan_lama = htmlspecialchars($post['file_laporan_lama']);  // Nama file laporan lama
    $file_project_lama = htmlspecialchars($post['file_project_lama']);  // Nama file project lama

    // Tentukan direktori tujuan upload
    $uploadDir = 'assets/files/';
    
    // Cek apakah folder tujuan ada
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true); // Membuat folder jika belum ada
    }

    // Proses upload file laporan jika ada file baru yang diupload
    if ($files['file_laporan']['error'] === 0) {
        $fileLaporanName = $files['file_laporan']['name'];
        $fileLaporanTmpName = $files['file_laporan']['tmp_name'];
        $fileLaporanDestination = $uploadDir . basename($fileLaporanName);

        // Pindahkan file laporan ke folder tujuan
        if (move_uploaded_file($fileLaporanTmpName, $fileLaporanDestination)) {
            // Jika file berhasil diupload, gunakan file yang baru
            $file_laporan = $fileLaporanName;
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file laporan!');</script>";
            return false;
        }
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file_laporan = $file_laporan_lama;
    }

    // Proses upload file project jika ada file baru yang diupload
    if ($files['file_project']['error'] === 0) {
        $fileProjectName = $files['file_project']['name'];
        $fileProjectTmpName = $files['file_project']['tmp_name'];
        $fileProjectDestination = $uploadDir . basename($fileProjectName);

        // Pindahkan file project ke folder tujuan
        if (move_uploaded_file($fileProjectTmpName, $fileProjectDestination)) {
            // Jika file berhasil diupload, gunakan file yang baru
            $file_project = $fileProjectName;
        } else {
            echo "<script>alert('Terjadi kesalahan saat mengunggah file project!');</script>";
            return false;
        }
    } else {
        // Jika tidak ada file baru, gunakan file lama
        $file_project = $file_project_lama;
    }

    // Query untuk update data ke tabel laporan_pkl
    $query = "UPDATE laporan_pkl 
              SET nis = '$nis', 
                  file_laporan = '$file_laporan', 
                  file_project = '$file_project', 
                  nilai_akhir_pkl = '$nilai_akhir_pkl' 
              WHERE id_laporan_pkl = '$id_laporan_pkl'";

    // Eksekusi query
    mysqli_query($db, $query);

    // Mengembalikan hasil apakah ada perubahan data
    return mysqli_affected_rows($db);
}
// Fungsi untuk menambahkan data siswa
function create_siswa($post)
{
    global $db;

    // Ambil data dari form dan sanitasi input
    $nis           = strip_tags($post['nis']);
    $nama_siswa    = strip_tags($post['nama_siswa']);
    $jenis_kelamin = strip_tags($post['jk']);
    $asal_sekolah  = strip_tags($post['asal_sekolah']);
    $tanggal_mulai = strip_tags($post['tanggal_mulai']);
    $tanggal_selesai = strip_tags($post['tanggal_selesai']);
    $no_hp         = strip_tags($post['no_hp']);
    $alamat        = $post['alamat'];

    // Query untuk update data siswa
    $query = "INSERT INTO siswa VALUES(null, '$nis','$nama_siswa','$jenis_kelamin','$asal_sekolah', '$tanggal_mulai','$tanggal_selesai','$no_hp','$alamat')";
    // Eksekusi query
    mysqli_query($db, $query);

    // Mengembalikan hasil apakah ada perubahan data
    return mysqli_affected_rows($db);
}

function delete_siswa($id_siswa)
{
    global $db;

    // Ambil NIS dari siswa yang akan dihapus
    $nis_query = "SELECT nis FROM siswa WHERE id_siswa = $id_siswa";
    $result = mysqli_query($db, $nis_query);
    $row = mysqli_fetch_assoc($result);
    $nis = $row['nis'];

    // Hapus data terkait di tabel laporan_pkl
    $deleteLaporanQuery = "DELETE FROM laporan_pkl WHERE nis = '$nis'";
    mysqli_query($db, $deleteLaporanQuery);

    // Hapus data siswa setelah data laporan_pkl dihapus
    $deleteSiswaQuery = "DELETE FROM siswa WHERE id_siswa = $id_siswa";
    mysqli_query($db, $deleteSiswaQuery);

    // Mengembalikan jumlah baris yang terpengaruh oleh query
    return mysqli_affected_rows($db);
}

function update_siswa($post)
{
    global $db;

    // Ambil data dari form dan sanitasi input
    $id_siswa      = (int)$post['id_siswa'];  // Casting id_siswa to integer to ensure it's a number
    $nis           = mysqli_real_escape_string($db, strip_tags($post['nis'])); // Sanitize input
    $nama_siswa    = mysqli_real_escape_string($db, strip_tags($post['nama_siswa']));
    $jenis_kelamin = mysqli_real_escape_string($db, strip_tags($post['jk']));
    $asal_sekolah  = mysqli_real_escape_string($db, strip_tags($post['asal_sekolah']));
    $tanggal_mulai = mysqli_real_escape_string($db, strip_tags($post['tanggal_mulai']));
    $tanggal_selesai = mysqli_real_escape_string($db, strip_tags($post['tanggal_selesai']));
    $no_hp         = mysqli_real_escape_string($db, strip_tags($post['no_hp']));
    $alamat        = mysqli_real_escape_string($db, $post['alamat']);  // No stripping for text input

    // Query untuk update data siswa
    $query = "UPDATE siswa 
              SET nis = '$nis', nama_siswa = '$nama_siswa', jenis_kelamin = '$jenis_kelamin', 
                  asal_sekolah = '$asal_sekolah', tanggal_mulai = '$tanggal_mulai', tanggal_selesai = '$tanggal_selesai', 
                  no_hp = '$no_hp', alamat = '$alamat' 
              WHERE id_siswa = $id_siswa";

    // Eksekusi query
    if (mysqli_query($db, $query)) {
        // Mengembalikan hasil apakah ada perubahan data
        return mysqli_affected_rows($db);
    } else {
        // Jika query gagal, tampilkan error
        echo "Error: " . mysqli_error($db);
        return 0;
    }
}


// Fungsi untuk menambah data jurnal
function create_jurnal($post, $files)
{
    global $db;

    $nis = strip_tags($post['nis']);
    $tanggal_kegiatan = strip_tags($post['tanggal_kegiatan']);
    $uraian_kegiatan = strip_tags($post['uraian_kegiatan']);
    $catatan_pembimbing = strip_tags($post['catatan_pembimbing']);

    // Cek apakah ada file untuk paraf_pembimbing
    $paraf_pembimbing = null;
    if (isset($files['paraf_pembimbing']) && $files['paraf_pembimbing']['error'] == 0) {
        // Lakukan upload jika file ada
        $paraf_pembimbing = upload_file($files['paraf_pembimbing']);
    }

    // Query untuk memasukkan data jurnal
    $query = "INSERT INTO jurnal (nis, tanggal_kegiatan, uraian_kegiatan, catatan_pembimbing, paraf_pembimbing) 
              VALUES ('$nis', '$tanggal_kegiatan', '$uraian_kegiatan', '$catatan_pembimbing', '$paraf_pembimbing')";

    mysqli_query($db, $query);
    return mysqli_affected_rows($db);
}

function upload_file($file)
{
    $namaFile = $file['name'];
    $ukuranFile = $file['size'];
    $error = $file['error'];
    $tmpName = $file['tmp_name'];

    // Cek apakah ada error dalam upload
    if ($error === 0) {
        // Ekstrak ekstensi file
        $extensifileValid = ['jpg', 'jpeg', 'png'];  // ekstensi yang valid
        $extensifile = explode('.', $namaFile);
        $extensifile = strtolower(end($extensifile));

        // Cek apakah ekstensi file valid
        if (!in_array($extensifile, $extensifileValid)) {
            echo "<script>
                    alert('Format File Tidak Valid. Ekstensi file yang diterima hanya JPG, JPEG, PNG.');
                    document.location.href = 'tambah-jurnal.php';
                  </script>";
            die();
        }

        // Cek apakah ukuran file lebih dari 2MB
        if ($ukuranFile > 2048000) {
            echo "<script>
                    alert('Ukuran File Terlalu Besar. Maksimal 2MB.');
                    document.location.href = 'tambah-jurnal.php';
                  </script>";
            die();
        }

        // Generate nama file baru agar unik
        $namaFileBaru = uniqid() . '.' . $extensifile;

        // Tentukan lokasi penyimpanan file
        $fileDestination = 'assets/img/' . $namaFileBaru;

        // Pindahkan file ke direktori tujuan
        move_uploaded_file($tmpName, $fileDestination);

        return $namaFileBaru; // Mengembalikan nama file yang sudah diproses
    } else {
        return null;
    }
}

function update_jurnal($post, $files)
{
    global $db;

    // Ambil data dari POST
    $id_jurnal = strip_tags($post['id_jurnal']);
    $nis = strip_tags($post['nis']);
    $tanggal_kegiatan = strip_tags($post['tanggal_kegiatan']);
    $uraian_kegiatan = strip_tags($post['uraian_kegiatan']);
    $catatan_pembimbing = strip_tags($post['catatan_pembimbing']);
    
    // Cek apakah ada file baru untuk paraf_pembimbing
    if ($files['paraf_pembimbing']['error'] == 4) {
        // Jika tidak ada file baru, gunakan file lama dari database
        $paraf_pembimbing = $post['fotolama'];
    } else {
        // Jika ada file baru, upload file
        $paraf_pembimbing = upload_file($files['paraf_pembimbing']);
    }

    // Query untuk update data jurnal
    $query = "UPDATE jurnal 
              SET nis = '$nis', 
                  tanggal_kegiatan = '$tanggal_kegiatan', 
                  uraian_kegiatan = '$uraian_kegiatan', 
                  catatan_pembimbing = '$catatan_pembimbing', 
                  paraf_pembimbing = '$paraf_pembimbing' 
              WHERE id_jurnal = '$id_jurnal'";

    // Eksekusi query
    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}


// Fungsi untuk menghapus data jurnal
function delete_jurnal($id_jurnal)
{
    global $db;

    $query = "DELETE FROM jurnal WHERE id_jurnal = $id_jurnal";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}
// Fungsi untuk menyimpan data laporan PKL

// Fungsi untuk upload file
function uploadFile($inputName) {
    $fileName = $_FILES[$inputName]['name'];
    $fileTmpName = $_FILES[$inputName]['tmp_name'];
    $fileSize = $_FILES[$inputName]['size'];
    $fileError = $_FILES[$inputName]['error'];
    $fileType = $_FILES[$inputName]['type'];

    // Cek apakah ada error dalam upload
    if ($fileError === 0) {
        $fileDestination = 'assets/files/' . $fileName;
        move_uploaded_file($fileTmpName, $fileDestination);
        return $fileName;
    } else {
        echo "<script>alert('Terjadi kesalahan saat mengunggah file!');</script>";
        return false;
    }
}

function delete_laporan_pkl($id_laporan_pkl)
{
    global $db;

    $query = "DELETE FROM laporan_pkl WHERE id_laporan_pkl = $id_laporan_pkl";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function create_presensi($post)
{
    global $db;

    // Ambil data dari form
    $nis        = strip_tags($post['nis']);
    $tanggal    = strip_tags($post['tanggal']);
    $keterangan = strip_tags($post['keterangan']);

    // Query untuk tambah data ke tabel presensi
    $query = "INSERT INTO presensi VALUES(null, '$nis', '$tanggal', '$keterangan')";

    // Eksekusi query
    mysqli_query($db, $query);

    // Kembalikan jumlah baris yang terpengaruh
    return mysqli_affected_rows($db);
}
function update_presensi($post)
{
    global $db;

    // Ambil data dari form
    $id_presensi = strip_tags($post['id_presensi']);
    $nis         = strip_tags($post['nis']);
    $tanggal     = strip_tags($post['tanggal']);
    $keterangan  = strip_tags($post['keterangan']);

    // Query untuk update data di tabel presensi
    $query = "UPDATE presensi SET nis = '$nis', tanggal = '$tanggal', keterangan = '$keterangan' WHERE id_presensi = $id_presensi";

    // Eksekusi query
    mysqli_query($db, $query);

    // Kembalikan jumlah baris yang terpengaruh
    return mysqli_affected_rows($db);
}
function delete_presensi($id_presensi)
{
    global $db;

    $query = "DELETE FROM presensi WHERE id_presensi = $id_presensi";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function create_akun($post)
{
    global $db;

    $nama        = strip_tags($post['nama']);
    $username    = strip_tags($post['username']);
    $email       = strip_tags($post['email']);
    $password    = strip_tags($post['password']);
    $level       = strip_tags($post['level']);

    // enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

 // query tambah data
       $query = "INSERT INTO akun VALUES(null, '$nama','$username','$email', '$password', 
       '$level')";
   
       mysqli_query($db, $query);
   
       return mysqli_affected_rows($db);
}


function delete_akun($id_akun)
{

    global $db;

    $query = "DELETE FROM akun WHERE id_akun = $id_akun";

    mysqli_query($db, $query);

    return mysqli_affected_rows($db);
}

function update_akun($post)
{
    global $db;

    $id_akun  = strip_tags($post['id_akun']);
    $nama     = strip_tags($post['nama']);
    $username = strip_tags($post['username']);
    $email    = strip_tags($post['email']);
    $password = strip_tags($post['password']);
    $level    = strip_tags($post['level']);
   

    // Prepare the SQL statement
    if (empty($password)) {
        $query = "UPDATE akun SET nama = ?, username = ?, email = ?, level = ? WHERE id_akun = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'ssssi', $nama, $username, $email, $level, $id_akun);
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $query = "UPDATE akun SET nama = ?, username = ?, email = ?, password = ?, level = ? WHERE id_akun = ?";
        $stmt = mysqli_prepare($db, $query);
        mysqli_stmt_bind_param($stmt, 'sssssi', $nama, $username, $email, $hashed_password, $level, $id_akun);
    }

    mysqli_stmt_execute($stmt);
    return mysqli_stmt_affected_rows($stmt);
}