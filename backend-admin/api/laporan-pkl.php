<?php
// Set header untuk JSON
header('Content-Type: application/json');

// Koneksi langsung ke database menggunakan PDO
$host = 'localhost'; // Sesuaikan dengan host database Anda
$user = 'root'; // Sesuaikan dengan username database Anda
$password = ''; // Sesuaikan dengan password database Anda
$dbname = 'jurnal_pkl'; // Sesuaikan dengan nama database Anda

// Membuat koneksi menggunakan PDO
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    // Set error mode untuk menangkap exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(array('error' => 'Koneksi database gagal: ' . $e->getMessage()));
    exit(); // Hentikan eksekusi jika koneksi gagal
}

// Query untuk menampilkan data laporan_pkl dengan join ke tabel siswa
$query = "SELECT laporan_pkl.*, siswa.nama_siswa, siswa.asal_sekolah
          FROM laporan_pkl
          INNER JOIN siswa ON laporan_pkl.nis = siswa.nis
          ORDER BY laporan_pkl.id_laporan_pkl DESC";

// Eksekusi query
$stmt = $conn->prepare($query);
$stmt->execute();

// Ambil hasil query
$laporan = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Cek apakah data ditemukan
if ($laporan) {
    // Proses untuk menambahkan URL untuk file_laporan dan file_project
    foreach ($laporan as $key => $laporanItem) {
        // Pastikan file berada di folder 'assets/file' dan mengaksesnya dengan URL yang sesuai
        $laporan[$key]['file_laporan'] = 'http://localhost/jurnal/backend-admin/assets/files/' . $laporanItem['file_laporan'];
        $laporan[$key]['file_project'] = 'http://localhost/jurnal/backend-admin/assets/files/' . $laporanItem['file_project'];
    }
    // Kirim data dalam format JSON
    echo json_encode($laporan);
} else {
    // Tidak ada data ditemukan
    echo json_encode(array('message' => 'Tidak ada laporan PKL ditemukan.'));
}

// Tutup koneksi PDO (otomatis dilakukan saat skrip selesai)
?>
