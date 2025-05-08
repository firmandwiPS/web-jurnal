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

// Jika permintaan berasal dari DataTables
if ($_GET['action'] == "table_data") {
    // Kolom-kolom yang diambil
    $columns = array(
        0 => 'laporan_pkl.id_laporan_pkl',
        1 => 'laporan_pkl.nis',
        2 => 'siswa.nama_siswa',
        3 => 'siswa.asal_sekolah',
        4 => 'laporan_pkl.file_laporan',
        5 => 'laporan_pkl.file_project',
        6 => 'laporan_pkl.nilai_akhir_pkl'
    );

    // Hitung jumlah total data
    $queryCount = $db->query("SELECT COUNT(id_laporan_pkl) as jumlah FROM laporan_pkl");
    $dataCount = $queryCount->fetch_array();
    $totalData = $dataCount['jumlah'];
    $totalFiltered = $totalData;

    // Menangani parameter pagination
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $orderColumn = $columns[$_POST['order'][0]['column']];
    $orderDir = $_POST['order'][0]['dir'];

    // Pencarian
    $searchQuery = "";
    if (!empty($_POST['search']['value'])) {
        $search = $_POST['search']['value'];
        $searchQuery = "WHERE laporan_pkl.nis LIKE '%$search%' OR siswa.nama_siswa LIKE '%$search%' OR siswa.asal_sekolah LIKE '%$search%'";
    }

    // Query untuk ambil data laporan_pkl dengan join ke tabel siswa
    $query = "SELECT laporan_pkl.*, siswa.nama_siswa, siswa.asal_sekolah
              FROM laporan_pkl
              INNER JOIN siswa ON laporan_pkl.nis = siswa.nis
              $searchQuery
              ORDER BY $orderColumn $orderDir
              LIMIT $limit OFFSET $start";
    
    $dataLaporanPkl = $db->query($query);

    // Hitung jumlah data setelah filter
    if (!empty($_POST['search']['value'])) {
        $queryCount = $db->query("SELECT COUNT(id_laporan_pkl) as jumlah FROM laporan_pkl
                                  INNER JOIN siswa ON laporan_pkl.nis = siswa.nis $searchQuery");
        $dataCount = $queryCount->fetch_array();
        $totalFiltered = $dataCount['jumlah'];
    }

    // Menyusun data untuk dikembalikan ke DataTables
    $data = array();
    if ($dataLaporanPkl->num_rows > 0) {
        $no = $start + 1;
        while ($row = $dataLaporanPkl->fetch_array()) {
            $nestedData = array();
            $nestedData['no'] = $no;
            $nestedData['nis'] = $row['nis'];
            $nestedData['nama_siswa'] = $row['nama_siswa'];
            $nestedData['asal_sekolah'] = $row['asal_sekolah'];

            // Menampilkan link file laporan
            $nestedData['file_laporan'] = $row['file_laporan'] ? '<a href="assets/files/'.$row['file_laporan'].'" target="_blank">Lihat Laporan</a>' : 'Belum ada laporan';

            // Menampilkan link file project
            $nestedData['file_project'] = $row['file_project'] ? '<a href="assets/files/'.$row['file_project'].'" target="_blank">Lihat Project</a>' : 'Belum ada project';

            $nestedData['nilai_akhir_pkl'] = $row['nilai_akhir_pkl'];
            
            // Kolom aksi untuk edit dan hapus
            $nestedData['aksi'] = '
                <div class="text-center " >
                    <a href="ubah-laporan-pkl.php?id_laporan_pkl='.$row['id_laporan_pkl'].'" class="btn btn-success mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;">
                        <i class="fas fa-edit"></i> 
                    </a>
                    <a href="hapus-laporan-pkl.php?id_laporan_pkl='.$row['id_laporan_pkl'].'"" class="btn btn-danger mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;" onclick="return confirm(\'Yakin ingin menghapus laporan ini?\');">
                        <i class="fas fa-trash"></i> 
                    </a>
                </div>
            ';

            $data[] = $nestedData;
            $no++;
        }
    }

    // Menyusun data untuk dikembalikan ke DataTables
    $json_data = array(
        "draw" => intval($_POST['draw']),
        "recordsTotal" => intval($totalData),
        "recordsFiltered" => intval($totalFiltered),
        "data" => $data
    );

    echo json_encode($json_data);
}
?>
