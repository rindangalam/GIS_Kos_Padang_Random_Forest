<head>
    <style>

    </style>
    <?php
    include '../php/koneksi.php';

    // mengaktifkan session
    session_start();

    $username = $_SESSION['username'];
    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    $d = mysqli_fetch_array($data);

    // cek apakah user telah login, jika belum login maka di alihkan ke halaman login
    if ($_SESSION['status'] != "login") {
        header("location:../index.php");
    }
    ?>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- tampilan depan -->
    <link rel="stylesheet" type="text/css" href="css/sb-admin-2.css">
    <link rel="stylesheet" type="text/css" href="css/sb-admin-2.min.css">
    <script type="text/javascript" src="js/sb-admin-2.js"></script>
    <script type="text/javascript" src="js/sb-admin-2.min.js"></script>
    <style>
        body, html {
            height: 100%;
        }
        #wrapper {
            position: relative;
            min-height: 100vh;
        }
        .navbar {
            z-index: 1030 !important;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            width: 100%;
        }
        .sidebar {
            z-index: 1020 !important;
            position: fixed;
            top: 56px; /* tinggi topbar */
            left: 0;
            height: calc(100vh - 56px);
            width: 220px;
            overflow-y: auto;
        }
        #content-wrapper {
            z-index: 2;
            position: relative;
            margin-left: 220px;
            margin-top: 56px;
            min-height: calc(100vh - 56px);
            background: transparent;
        }
        @media (max-width: 991.98px) {
            .sidebar {
                top: 56px !important;
                width: 100%;
                left: 0;
            }
            #content-wrapper {
                margin-left: 0;
            }
        }
        .sidebar .sidebar-brand {
            margin-top: 0.5rem;
        }
        .brand-text-kosin {
            font-size: 1.3rem;
            font-weight: 700;
            color: #19a9a9;
            margin-left: 10px;
            letter-spacing: 1px;
            display: inline-block;
            vertical-align: middle;
        }
        @media (max-width: 575.98px) {
            .brand-text-kosin {
                font-size: 1rem;
                margin-left: 6px;
            }
        }
        /* Tombol minimize tanpa bulat dan hijau */
        #sidebarToggleTop {
            background: none !important;
            color: #19a9a9 !important;
            border: none !important;
            box-shadow: none !important;
            padding: 0.5rem 0.7rem;
        }
        #sidebarToggleTop:focus {
            outline: none;
            box-shadow: none;
        }
    </style>
</head>

<body id="page-top">
    <!-- Topbar -->
    <nav class="navbar navbar-expand navbar-light bg-white topbar mb-0 static-top shadow">
        <!-- Sidebar Toggle (Topbar) -->
        <button id="sidebarToggleTop" class="btn d-md-inline-block d-lg-inline-block mr-2" aria-label="Minimize sidebar">
            <i class="fa fa-bars"></i>
        </button>
        <!-- Logo dan Nama KosIn di Topbar -->
        <span class="d-flex align-items-center ml-2">
            <span class="sidebar-brand-icon " style="font-size:1.5rem;">
                <img src="../img/logo.png" width="35" height="35" class="d-inline-block align-top mr-2" alt="Logo" style="border-radius:50%;background:#fff;">
            </span>
            <span class="brand-text-kosin">KosIn</span>
        </span>
        <!-- Topbar Navbar -->
        <ul class="navbar-nav ml-auto align-items-center">
            <!-- Informasi user -->
            <li class="nav-item dropdown no-arrow">
                <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <span class="mr-2 d-none d-lg-inline text-gray-800 small"><?php echo $_SESSION['username']; ?></span>
                </a>
            </li>
        </ul>
    </nav>
    <!-- End of Topbar -->

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul style="background: linear-gradient(180deg, #19a9a9 0%, #00b894 100%) !important;" class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php" style="color:#fff;">
            </a>

            <!-- Divider -->
            <!-- <hr class="sidebar-divider my-0" style="border-top:2px solid #b2ebeb;"> -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-fw fa-home"></i>
                    <span>Home</span></a>
            </li>

            <li class="nav-item active">
                <a class="nav-link" href="dashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>

                <!-- Divider -->
                <a class="nav-link collapsed"  href="profil.php" ><i class="fa fa-user"></i> Profil</a>
                <hr class="sidebar-divider">
                

                <!-- Heading -->
                <div class="sidebar-heading" style="color:#e0f7fa;">
                    Interface
                </div>

                <?php
                if ($d['roles'] == 1) {
                ?>
                    <!-- Nav Item - Penghuni kost -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Menu</span>
                </a>
                
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Daftar Menu:</h6>
                   
                        <a class="collapse-item" href="tagihan.php">Tagihan</a>
                        <a class="collapse-item" href="kostku.php">Kostku</a>
                        <a class="collapse-item" href="wishlist.php">My Wishlist</a>
                    </div>
                </div>
            </li>
        <?php } else if ($d['roles'] == 2) { ?>
            <!-- Nav Item - OWNER MENU-->
            <li class="nav-item">
   
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Owner Menu</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Daftar Menu:</h6>
                        <a class="collapse-item" href="tambah_kos.php">Tambah Kost</a>
                        <a class="collapse-item" href="properti.php">Kost Saya</a>
                    </div>
                </div>
            </li>
        <?php } else if ($d['roles'] == 3) { ?>
            <li class="nav-item">
                <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                    <i class="fas fa-fw fa-cog"></i>
                    <span>Admin Menu</span>
                </a>
                <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header">Daftar Menu:</h6>
                        <a class="collapse-item" href="user.php">User</a>
                        <a class="collapse-item" href="kost_management.php">Kost</a>
                        <a class="collapse-item" href="semua_transaksi.php">Management Transaksi</a>
                    </div>
                </div>
            </li>
        <?php } ?>

        <!-- Divider -->
        <hr class="sidebar-divider">
        <li class="nav-item active">
            <a class="nav-link" href="logout.php">
                <i class="fas fa-fw fa-sign-out-alt"></i>
                <span>Logout</span>
            </a>
        </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <!-- <h1 class="h3 mb-0 text-gray-800">Dashboard</h1> -->
                    </div>
                </div>
                <!-- End of Main Content -->