<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
</aside>
<!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery UI 1.11.4 -->
<script src="assets-template/plugins/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>

<!-- Bootstrap 4 -->
<script src="assets-template/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- ChartJS -->
<script src="assets-template/plugins/chart.js/Chart.min.js"></script>

<!-- Sparkline -->
<script src="assets-template/plugins/sparklines/sparkline.js"></script>

<!-- JQVMap -->
<script src="assets-template/plugins/jqvmap/jquery.vmap.min.js"></script>
<script src="assets-template/plugins/jqvmap/maps/jquery.vmap.usa.js"></script>

<!-- jQuery Knob Chart -->
<script src="assets-template/plugins/jquery-knob/jquery.knob.min.js"></script>

<!-- daterangepicker -->
<script src="assets-template/plugins/moment/moment.min.js"></script>
<script src="assets-template/plugins/daterangepicker/daterangepicker.js"></script>

<!-- Tempusdominus Bootstrap 4 -->
<script src="assets-template/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Summernote -->
<script src="assets-template/plugins/summernote/summernote-bs4.min.js"></script>

<!-- overlayScrollbars -->
<script src="assets-template/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>

<!-- AdminLTE App -->
<script src="assets-template/dist/js/adminlte.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="assets-template/dist/js/demo.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="assets-template/dist/js/pages/dashboard.js"></script>

<!-- Optional JavaScript; choose one of the two! -->

<!-- Option 1: Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

<!-- Asset plugin datatables -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>

<script defer src="https://use.fontawesome.com/releases/v5.15.4/js/all.js" integrity="sha384-rOA1PnstxnOBLzCLMcre8ybwbTmemjzdNlILg8O7z1lUkLXozs4DHonlDtnE7fpc" crossorigin="anonymous"></script>

<!-- Include CKEditor -->
<!--loadckeditor cdn -->
<script src="https://cdn.ckeditor.com/4.22.1/full/ckeditor.js"></script>

<!-- Initialize CKEditor for 'alamat' -->
<script>
    CKEDITOR.replace('alamat', {
        filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=files',
        height: '100px' // Adjust the height as needed
    });
</script>

<!-- Initialize CKEditor for 'uraian_kegiatan' -->
<script>
    CKEDITOR.replace('uraian_kegiatan', {
        filebrowserBrowseUrl: 'assets/ckfinder/ckfinder.html',
        filebrowserUploadUrl: 'assets/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=files',
        height: '100px' // Adjust the height as needed
    });
</script>

<script>
$(document).ready(function() {
    $('#table').DataTable();
});
</script>

<!-- Script untuk mengaktifkan Select2 pada NIS -->
<script>
    $(document).ready(function() {
        // Menginisialisasi Select2 pada elemen dengan id 'nis'
        $('#nis').select2({
            placeholder: "-- Pilih NIS --", // Tampilkan placeholder
            allowClear: true, // Memungkinkan penghapusan pilihan
        });
    });
</script>

<!-- Script untuk mengaktifkan DataTables -->
<script>
    // Inisialisasi DataTable untuk tabel server-side
    $(document).ready(function() {
        var table = $('#serverside').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'siswa-serverside.php',
                type: 'POST',
                data: function(d) {
                    // Add additional data (e.g., date filter) if needed
                    d.tgl_awal = $('#tgl_awal').val();
                    d.tgl_akhir = $('#tgl_akhir').val();
                }
            },
            columns: [{
                    "data": "no"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "jenis_kelamin"
                },
                {
                    "data": "asal_sekolah"
                },
                {
                    "data": "tanggal_mulai"
                },
                {
                    "data": "tanggal_selesai"
                },
                {
                    "data": "no_hp"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "aksi",

                }
            ],
            // Optionally, you can add more options such as pagination, searching, etc.
        });
    });
    $(document).ready(function() {
        var table = $('#serverside6').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'siswa-user-serverside.php',
                type: 'POST',
                data: function(d) {
                    // Add additional data (e.g., date filter) if needed
                    d.tgl_awal = $('#tgl_awal').val();
                    d.tgl_akhir = $('#tgl_akhir').val();
                }
            },
            columns: [{
                    "data": "no"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "jenis_kelamin"
                },
                {
                    "data": "asal_sekolah"
                },
                {
                    "data": "tanggal_mulai"
                },
                {
                    "data": "tanggal_selesai"
                },
                {
                    "data": "no_hp"
                },
                {
                    "data": "alamat"
                },
                {
                    "data": "aksi",

                }
            ],
            // Optionally, you can add more options such as pagination, searching, etc.
        });
    });


    $(document).ready(function() {
        $('#serverside2').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'jurnal-serverside.php?action=table_data',
                type: 'POST'
            },
            columns: [{
                    "data": "no"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "tanggal_kegiatan"
                },
                {
                    "data": "uraian_kegiatan"
                },
                {
                    "data": "catatan_pembimbing"
                },
                {
                    "data": "paraf_pembimbing"
                },
                {
                    "data": "aksi",
                    "orderable": false
                }
            ]
        });
    });

    $(document).ready(function() {
        $('#serverside3').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'presensi-serverside.php?action=table_data',
                type: 'POST'
            },
            columns: [{
                    "data": "no"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "tanggal"
                },
                {
                    "data": "keterangan"
                },
                {
                    "data": "aksi",
                    "orderable": false
                }
            ]
        });
    });


    $(document).ready(function() {
        $('#serverside4').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: 'laporan-pkl-serverside.php?action=table_data',
                type: 'POST'
            },
            columns: [{
                    "data": "no"
                },
                {
                    "data": "nis"
                },
                {
                    "data": "nama_siswa"
                },
                {
                    "data": "asal_sekolah"
                },
                {
                    "data": "file_laporan"
                },
                {
                    "data": "file_project"
                },
                {
                    "data": "nilai_akhir_pkl"
                },
                {
                    "data": "aksi",
                    "orderable": false
                }
            ]
        });

    });
    $(document).ready(function() {
    // Menginisialisasi DataTable
    $('#serverside5').DataTable({
        processing: true,  // Menampilkan loading ketika data diproses
        serverSide: true,  // Menggunakan server-side processing
        ajax: {
            url: 'laporan-pkl-admin-serverside.php?action=table_data',  // URL untuk mengambil data
            type: 'POST',
            dataSrc: function(json) {
                return json.data; // Menangani respons JSON yang berisi data
            }
        },
        columns: [
            { "data": "no" },  // Kolom untuk nomor urut
            { "data": "nis" },  // Kolom untuk NIS
            { "data": "nama_siswa" },  // Kolom untuk nama siswa
            { "data": "asal_sekolah" },  // Kolom untuk asal sekolah
            { "data": "file_laporan" },  // Kolom untuk file laporan
            { "data": "file_project" },  // Kolom untuk file project
            { "data": "nilai_akhir_pkl" },  // Kolom untuk nilai akhir PKL
            { "data": "aksi", "orderable": false }  // Kolom aksi (edit, hapus)
        ],
        // Tambahan pengaturan jika diperlukan
        order: [[0, 'asc']]  // Urutkan berdasarkan kolom pertama
    });
});


</script>

<!-- DataTables & Plugins -->
<script src="assets-template/plugins/datatables/jquery.dataTables.min.js"></script>
<script src="assets-template/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
<script src="assets-template/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
<script src="assets-template/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
<script src="assets-template/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
<script src="assets-template/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
<script src="assets-template/plugins/jszip/jszip.min.js"></script>
<script src="assets-template/plugins/pdfmake/pdfmake.min.js"></script>
<script src="assets-template/plugins/pdfmake/vfs_fonts.js"></script>
<script src="assets-template/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
<script src="assets-template/plugins/datatables-buttons/js/buttons.print.min.js"></script>
<script src="assets-template/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>

<script>
    $(function() {
        // Inisialisasi DataTable dengan berbagai opsi untuk export dan fitur lainnya
        $("#example1").DataTable({
            "responsive": true,
            "lengthChange": false,
            "autoWidth": false,
            "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');

        // DataTable untuk tabel lainnya dengan pengaturan berbeda
        $('#example2').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": false,
            "ordering": true,
            "info": true,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    // DataTable lainnya jika diperlukan
    $(function() {
        $('#example2').DataTable();
    });
</script>