<?php
include 'config/database.php';

if ($_GET['action'] == "table_data") {
    $columns = array(
        0 => 'id_jurnal',
        1 => 'nis',
        2 => 'nama_siswa',
        3 => 'tanggal_kegiatan',
        4 => 'uraian_kegiatan',
        5 => 'catatan_pembimbing',
        6 => 'paraf_pembimbing',
        7 => 'id_jurnal' // Kolom untuk aksi
    );

    // Hitung jumlah total data jurnal
    $queryCount = $db->query("SELECT count(id_jurnal) as jumlah FROM jurnal");
    $dataCount = $queryCount->fetch_array();
    $totalData = $dataCount['jumlah'];
    $totalFiltered = $totalData;

    // Ambil parameter length dan start dari DataTables
    $limit = $_POST['length'];
    $start = $_POST['start'];
    $orderColumn = $columns[$_POST['order'][0]['column']];
    $orderDir = $_POST['order'][0]['dir'];

    // Pencarian
    $searchQuery = "";
    if (!empty($_POST['search']['value'])) {
        $search = $_POST['search']['value'];
        $searchQuery = "WHERE jurnal.nis LIKE '%$search%' 
          OR siswa.nama_siswa LIKE '%$search%'
                        OR jurnal.tanggal_kegiatan LIKE '%$search%' 
                        OR jurnal.uraian_kegiatan LIKE '%$search%'"; 
                      
    }

    // Query untuk ambil data jurnal
    $query = "SELECT jurnal.*, siswa.nama_siswa
              FROM jurnal
              INNER JOIN siswa ON jurnal.nis = siswa.nis
              $searchQuery
              ORDER BY $orderColumn $orderDir
              LIMIT $limit OFFSET $start";

    $dataJurnal = $db->query($query);

    // Hitung jumlah data setelah filter (jika ada pencarian)
    if (!empty($_POST['search']['value'])) {
        $queryCount = $db->query("SELECT count(id_jurnal) as jumlah FROM jurnal
                                  INNER JOIN siswa ON jurnal.nis = siswa.nis
                                  $searchQuery");
        $dataCount = $queryCount->fetch_array();
        $totalFiltered = $dataCount['jumlah'];
    }

    // Menyusun data untuk dikembalikan ke DataTables
    $data = array();
    if ($dataJurnal->num_rows > 0) {
        $no = $start + 1;
        while ($row = $dataJurnal->fetch_array()) {
            $nestedData = array();
            $nestedData['no'] = $no;
            $nestedData['nis'] = $row['nis'];
            $nestedData['nama_siswa'] = $row['nama_siswa'];

            // Format tanggal kegiatan
            $nestedData['tanggal_kegiatan'] = date('d-m-Y', strtotime($row['tanggal_kegiatan']));

            $nestedData['uraian_kegiatan'] = $row['uraian_kegiatan'];
            $nestedData['catatan_pembimbing'] = $row['catatan_pembimbing'];

            // Menampilkan paraf pembimbing (Jika ada)
            if ($row['paraf_pembimbing']) {
                $nestedData['paraf_pembimbing'] = '<img src="assets/img/' . $row['paraf_pembimbing'] . '" alt="Paraf Pembimbing" width="50" height="50">';
            } else {
                $nestedData['paraf_pembimbing'] = '-';
            }

            // Kolom aksi untuk edit dan hapus
            $nestedData['aksi'] = '<div class="text-center" width="20%">
                                    <a href="ubah-jurnal.php?id_jurnal=' . $row['id_jurnal'] . '"class="btn btn-success mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;"><i class="fas fa-edit"></i> </a>
                                    <a href="hapus-jurnal.php?id_jurnal=' . $row['id_jurnal'] . '"class="btn btn-danger mb-1 btn-sm" style="font-size: 12px; padding: 3px 8px;"" onclick="return confirm(\'Yakin Data Jurnal Akan Dihapus?\');"><i class="fas fa-trash"></i> </a>
                                    </div>';
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
