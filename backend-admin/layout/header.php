<?php
include 'config/app.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <title><?= $title; ?></title>

  <!-- Favicon -->
  <link rel="icon" href="../assets/img/logobmti.png" type="image/png">

  <!-- DataTables CSS -->
  <link rel="stylesheet" href="assets-template/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="assets-template/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="assets-template/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Bootstrap CSS (CDN) -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="assets-template/plugins/fontawesome-free/css/all.min.css">

  <!-- AdminLTE CSS -->
  <link rel="stylesheet" href="assets-template/dist/css/adminlte.min.css">
  <link rel="stylesheet" href="assets-template/dist/css/adminlte.css">

  <!-- OverlayScrollbars -->
  <link rel="stylesheet" href="assets-template/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">

  <!-- jQuery -->
  <script src="assets-template/plugins/jquery/jquery.min.js"></script>


</head>


<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">


    <!-- Preloader -->
    <div class="preloader flex-column justify-content-center align-items-center">
      <img class="animation__shake" src="../assets/img/logobmti.png" alt="AdminLTELogo" height="60" width="60">
    </div>

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
       
      </ul>

      <!-- Right navbar links -->
      <ul class="navbar-nav ml-auto">
        <!-- Navbar Search -->
        <li class="nav-item">
          <a class="nav-link" data-widget="navbar-search" href="#" role="button">
            <i class="fas fa-search"></i>
          </a>
          <div class="navbar-search-block">
            <form class="form-inline">
              <div class="input-group input-group-sm">
                <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
                <div class="input-group-append">
                  <button class="btn btn-navbar" type="submit">
                    <i class="fas fa-search"></i>
                  </button>
                  <button class="btn btn-navbar" type="button" data-widget="navbar-search">
                    <i class="fas fa-times"></i>
                  </button>
                </div>
              </div>
            </form>
          </div>
        </li>

      
        <!-- Fullscreen Button -->
        <li class="nav-item">
          <a class="nav-link" data-widget="fullscreen" href="#" role="button">
            <i class="fas fa-expand-arrows-alt"></i>
          </a>
        </li>

        
      </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4" style="background:#091842;">
      <!-- Sidebar -->
      <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-5 pb-3 mb-3 d-flex">
          <div class="info">
            <a href="#" class="d-block"><?= $_SESSION['nama']; ?></a>
          </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-header">Daftar Menu</li>


            <?php if ($_SESSION['level'] == 1): ?>
              <li class="nav-item">
                <a href="siswa.php" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Data Siswa</p>
                </a>
              </li>
            <?php endif; ?>
            <?php if ($_SESSION['level'] == 2): ?>
              <li class="nav-item">
                <a href="siswa-user.php" class="nav-link">
                  <i class="nav-icon fas fa-users"></i>
                  <p>Data Siswa</p>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($_SESSION['level'] == 1 || $_SESSION['level'] == 2): ?>
              <li class="nav-item">
                <a href="jurnal.php" class="nav-link">
                  <i class="nav-icon fas fa-pen"></i>
                  <p>Jurnal</p>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($_SESSION['level'] == 1 || $_SESSION['level'] == 2): ?>
              <li class="nav-item">
                <a href="presensi.php" class="nav-link">
                  <i class="nav-icon fas fa-calendar-check"></i>
                  <p>Presensi</p>
                </a>
              </li>
            <?php endif; ?>

            <?php if ($_SESSION['level'] == 1): ?>
              <li class="nav-item">
                <a href="laporan-pkl-admin.php" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>Laporan PKL</p>
                </a>
              </li>
            <?php endif; ?>
            <?php if ($_SESSION['level'] == 2):?>
              <li class="nav-item">
                <a href="laporan-pkl.php" class="nav-link">
                  <i class="nav-icon fas fa-book"></i>
                  <p>Laporan PKL</p>
                </a>
              </li>
            <?php endif; ?>

            <li class="nav-item">
              <a href="akun.php" class="nav-link">
                <i class="nav-icon fas fa-user-cog"></i>
                <p>Data Akun</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="logout.php" onclick="return confirm('Yakin Ingin Keluar ?')" class="nav-link">
                <i class="nav-icon fas fa-sign-out-alt"></i>
                <p>Logout</p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>
    <!-- /.main-sidebar -->

  </div>

  <!-- JavaScript and Bootstrap Bundle -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JS -->
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

</body>

</html>