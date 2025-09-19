<?php
include("php/koneksi.php");
?>
<style>
    * {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<head>

    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <!-- Keep only one bootstrap CSS (minified) to avoid duplication -->

    <!-- Load JS in correct order for Bootstrap 4: jQuery -> Popper -> Bootstrap -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

</head>

<body>
    <div class="container">
        <!-- navigasi -->

        <!-- HEADER NAVBAR -->
    


        <nav id="mainNavbar"class="navbar navbar-expand-lg navbar-dark fixed-top shadow-sm <?= $navbarClass ?>" >
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="img/logo.png" width="35" height="35" class="d-inline-block align-top mr-2" alt="Logo" style="border-radius:50%;background:#fff;">
                <span style="font-weight:bold;">KosIn</span>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto align-items-lg-center">
                    <li class="nav-item active">
                        <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="tentang.php">Tentang</a>
                    </li>
                 
                    <li class="nav-item mt-2 mt-lg-0 ml-lg-2">
                        <a href="login.php"
                           class="btn btn-outline-light my-2 my-sm-0"
                           style="
                              border-radius: 25px;
                              font-size: 1rem;
                              font-weight: bold;
                              padding: 6px 20px;
                              border-width: 2px;
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
                           <i class="fa fa-sign-in-alt"></i> Masuk / Daftar
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <style>
            nav.navbar {
              border-radius: 0 !important;
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
                    /* flex-direction: column !important;
                    width: 100%; */
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

        <!-- tutup navigasi  -->
        <br>
        <br>
        <br>
        
        <!-- jumbotron header  -->
        <!-- JUMBOTRON -->
    
</body>

<!-- <style>
.jumbotron {
  max-width: 100vw !important;
  width: 100vw !important;
  margin-left: 49.3% !important;
  transform: translateX(-50%);
  margin-right: 0 !important;
  margin-top: -14px !important; /* geser ke atas agar menempel navbar */
  padding-left: 0 !important;
  padding-right: 0 !important;
  border-radius: 0 !important;
  border-left: none !important;
  border-right: none !important;
  box-shadow: none !important; /* hilangkan shadow belakang jumbotron */
}
.jumbotron .row.align-items-center > .col-md-6:first-child {
  padding-left: 7vw !important;
  padding-right: 2vw !important;
  
}
</style> -->

