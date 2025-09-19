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
<?php
$scrollNavbar = $scrollNavbar ?? false; 
$navbarClass = $scrollNavbar ? 'transparent-navbar' : '';
?>


<head>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.js"></script>

    <!-- online java scrip  -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>


<body>
    <div class="container">
        <!-- navigasi -->

        <!-- HEADER NAVBAR -->
        <nav id="mainNavbar"class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm <?= $navbarClass ?>">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="../img/logo.png" width="35" height="35" class="d-inline-block align-top mr-2" alt="Logo" style="border-radius:50%;background:#fff;">
                <span style="font-weight:bold; color:#fff; font-size:1.3rem; margin-left:10px; letter-spacing:1px;">KosIn</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto align-items-lg-center">
                    <li class="nav-item mt-2 mt-lg-0 ml-lg-2">
                        <a href="dashboard.php"
                           class="btn btn-outline-light my-2 my-sm-0"
                           style="
                              border-radius: 25px;
                              font-size: 1rem;
                              font-weight: bold;
                              padding: 6px 20px;
                              border: none;
                              background: #fff;
                              color: #00b894;
                              box-shadow:
                                0 4px 16px 0 rgba(25,169,169,0.18),
                                inset 0 2px 8px 0 rgba(255,255,255,0.25),
                                inset 0 -2px 8px 0 rgba(0,0,0,0.10);
                              transition: background 0.3s, color 0.3s, transform 0.2s;
                           "
                           onmouseover="this.style.background='rgba(25, 169, 169, 0.85)';this.style.color='#fff';this.style.transform='scale(1.05)'"
                           onmouseout="this.style.background='#fff';this.style.color='#00b894';this.style.transform='scale(1)'"
                        >
                           <i class="fa fa-user"></i> <?php echo htmlspecialchars($_SESSION['username']); ?>
                        </a>
                    </li>
                    <li>
                        
                    </li>
                </ul>
            </div>
        </nav>
            


        <style>
            
            nav.navbar {
              border: none;
              background-color:rgba(0, 184, 147, 0.7);
            }
            .navbar-nav .nav-link:hover {
                color: #ffd700 !important;
                transition: 0.2s;
            }
            .navbar-brand span {
                letter-spacing: 1px;
            }
            @media (min-width: 992px) {
                .navbar-collapse {
                    display: flex !important;
                    align-items: center;
                    justify-content: center;
                }
                .navbar-nav {
                    flex-direction: row;
                }
                .navbar-nav .nav-item {
                    margin-right: 15px;
                }
                .form-inline {
                    margin-bottom: 0;
                }
            }
            @media (max-width: 991.98px) {
                .navbar-nav {
                    flex-direction: column !important;
                    width: 100%;
                }
                .navbar-nav .nav-item {
                    margin-right: 0;
                    width: 100%;
                    text-align: left;
                }
                .navbar-nav .form-inline {
                    width: 100%;
                    flex-direction: column;
                    align-items: stretch;
                }
                .navbar-nav .form-inline .form-control,
                .navbar-nav .form-inline .btn {
                    width: 100%;
                    margin-bottom: 8px;
                }
                .navbar-nav .btn {
                    width: 100%;
                }
                .ml-auto, .mx-2 {
                    margin-left: 0 !important;
                }
            }
        </style>