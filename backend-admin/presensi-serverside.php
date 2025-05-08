<?php
session_start();

// Include database connection
include 'config/database.php';

// Ensure the user is logged in and has appropriate access
if (!isset($_SESSION["login"])) {
    echo "<script>
            alert('Silakan login terlebih dahulu.');
            document.location.href = 'login.php';
          </script>";
    exit;
}

// If the request is for DataTables (table data request)
if ($_GET['action'] == "table_data") {
    // Columns that we need to handle
    $columns = array(
        0 => 'presensi.id_presensi', 
        1 => 'presensi.nis', 
        2 => 'siswa.nama_siswa',
        3 => 'presensi.tanggal',
        4 => 'presensi.keterangan'
    );

    // Count total records
    $queryCount = $db->query("SELECT COUNT(id_presensi) as jumlah FROM presensi");
    $dataCount = $queryCount->fetch_array();
    $totalData = $dataCount['jumlah'];
    $totalFiltered = $totalData;

    // Handle pagination
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $orderColumn = $columns[$_POST['order'][0]['column']];
    $orderDir = $_POST['order'][0]['dir'];

    // Handle search
    $searchQuery = "";
    if (!empty($_POST['search']['value'])) {
        $search = $_POST['search']['value'];
        $searchQuery = "WHERE presensi.nis LIKE '%$search%' OR presensi.tanggal LIKE '%$search%' OR presensi.keterangan LIKE '%$search%' OR siswa.nama_siswa LIKE '%$search%'";
    }

    // Query to fetch data with the joined table
    $query = "SELECT presensi.*, siswa.nama_siswa
              FROM presensi
              INNER JOIN siswa ON presensi.nis = siswa.nis
              $searchQuery
              ORDER BY $orderColumn $orderDir
              LIMIT $limit OFFSET $start";
    
    $dataPresensi = $db->query($query);

    // Get the filtered record count
    if (!empty($_POST['search']['value'])) {
        $queryCount = $db->query("SELECT COUNT(id_presensi) as jumlah FROM presensi
                                  INNER JOIN siswa ON presensi.nis = siswa.nis $searchQuery");
        $dataCount = $queryCount->fetch_array();
        $totalFiltered = $dataCount['jumlah'];
    }

  // Prepare data to return to DataTables
$data = array();
if ($dataPresensi->num_rows > 0) {
    $no = $start + 1;
    while ($row = $dataPresensi->fetch_array()) {
        $nestedData = array();
        $nestedData['no'] = $no;
        $nestedData['nis'] = $row['nis'];
        $nestedData['nama_siswa'] = $row['nama_siswa'];
        $nestedData['tanggal'] = $row['tanggal'];
        $nestedData['keterangan'] = $row['keterangan'];

        // Adding the HTML for the action buttons
        $nestedData['aksi'] = '
            <td class="text-center" width="18%">
                <!-- Tombol Ubah (Modal) -->
                <button type="button" class="btn btn-success mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;"
                    data-bs-toggle="modal" data-bs-target="#modalUbah' . $row['id_presensi'] . '">
                    <i class="fas fa-edit"></i> 
                </button>

                <!-- Tombol Hapus (Modal) -->
                <button type="button" class="btn btn-danger mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;"
                    data-bs-toggle="modal" data-bs-target="#modalHapus' . $row['id_presensi'] . '">
                    <i class="fas fa-trash"></i> 
                </button>
            </td>
        ';

        // Add the row to the data array
        $data[] = $nestedData;
        $no++;
    }
}

    // Return data in the format DataTables expects
    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}
?>
