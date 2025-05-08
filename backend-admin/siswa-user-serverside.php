<?php
session_start();

// Include database connection
include 'config/database.php';

// Check if the user is logged in and has access
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silakan login terlebih dahulu.');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// Get DataTables parameters
$columns = array(
    0 => 'id_siswa',
    1 => 'nis',
    2 => 'nama_siswa',
    3 => 'jenis_kelamin',
    4 => 'asal_sekolah',
    5 => 'tanggal_mulai',
    6 => 'tanggal_selesai',
    7 => 'no_hp',
    8 => 'alamat'
);

// Count total records
$queryCount = $db->query("SELECT COUNT(id_siswa) as jumlah FROM siswa");
$dataCount = $queryCount->fetch_array();
$totalData = $dataCount['jumlah'];
$totalFiltered = $totalData;

// Pagination parameters
$limit = $_POST['length']; 
$start = $_POST['start']; 
$orderColumn = $columns[$_POST['order'][0]['column']]; 
$orderDir = $_POST['order'][0]['dir']; 

// Handle search filter
$searchQuery = "";
if (!empty($_POST['search']['value'])) {
    $search = $_POST['search']['value'];
    $searchQuery = "WHERE nis LIKE '%$search%' OR nama_siswa LIKE '%$search%' OR asal_sekolah LIKE '%$search%' OR alamat LIKE '%$search%'";
}

// Handle date filter (if posted)
$dateQuery = "";
if (isset($_POST['tgl_awal']) && isset($_POST['tgl_akhir']) && !empty($_POST['tgl_awal']) && !empty($_POST['tgl_akhir'])) {
    $tgl_awal = strip_tags($_POST['tgl_awal'] . " 00:00:00");
    $tgl_akhir = strip_tags($_POST['tgl_akhir'] . " 23:59:59");
    $dateQuery = "AND tanggal_mulai BETWEEN '$tgl_awal' AND '$tgl_akhir'";
}

// Query for data with pagination and filtering
$query = "SELECT * FROM siswa $searchQuery $dateQuery ORDER BY $orderColumn $orderDir LIMIT $limit OFFSET $start";

$dataSiswa = $db->query($query);

// Get the filtered record count
if (!empty($_POST['search']['value'])) {
    $queryCount = $db->query("SELECT COUNT(id_siswa) as jumlah FROM siswa $searchQuery $dateQuery");
    $dataCount = $queryCount->fetch_array();
    $totalFiltered = $dataCount['jumlah'];
}

// Prepare data for DataTables
$data = array();
if ($dataSiswa->num_rows > 0) {
    $no = $start + 1;
    while ($row = $dataSiswa->fetch_array()) {
        $nestedData = array();
        $nestedData['no'] = $no;
        $nestedData['nis'] = $row['nis'];
        $nestedData['nama_siswa'] = $row['nama_siswa'];
        $nestedData['jenis_kelamin'] = $row['jenis_kelamin'];
        $nestedData['asal_sekolah'] = $row['asal_sekolah'];
        $nestedData['tanggal_mulai'] = $row['tanggal_mulai'];
        $nestedData['tanggal_selesai'] = $row['tanggal_selesai'];
        $nestedData['no_hp'] = $row['no_hp'];
        $nestedData['alamat'] = $row['alamat'];

        $nestedData['aksi'] = '
        <div class="text-center">
            <a href="ubah-siswa.php?id_siswa='.$row['id_siswa'].'"class="btn btn-success mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;">
                <i class="fas fa-edit"></i>
            </a>

    ';

        $data[] = $nestedData;
        $no++;
    }
}

// Return JSON data to DataTables
$json_data = array(
    "draw" => intval($_POST['draw']),
    "recordsTotal" => intval($totalData),
    "recordsFiltered" => intval($totalFiltered),
    "data" => $data
);

echo json_encode($json_data);
?>
