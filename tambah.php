<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tentang</title>
</head>
<body>
    
<script>
    
 window.addEventListener('scroll', function () {
    const navbar = document.getElementById('mainNavbar');
    if (window.scrollY > 50) {
      navbar.classList.add('scrolled-navbar');
    } else {
      navbar.classList.remove('scrolled-navbar');
    }
  });
</script>
<?php

include 'template/header.php'
?>
<style>
    .transparent-navbar {
    background-color: rgba(25, 169, 169, 0.85);

  }
    body {
        background-color: rgb(222, 251, 232);
      
    }
    .about-kosin {
        max-width: 700px;
        margin: 64px auto 0 auto;
        background: rgba(255,255,255,0.92);
        border-radius: 36px;
        box-shadow: 0 8px 32px rgba(25, 169, 169, 0.13), 0 2px 8px rgba(0,0,0,0.04);
        padding: 48px 36px 40px 36px;
        text-align: center;
        position: relative;
        overflow: hidden;
    }
    .about-kosin::before {
        content: "";
        position: absolute;
        left: -60px; top: -60px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, #19a9a933 60%, transparent 100%);
        z-index: 0;
    }
    .about-kosin::after {
        content: "";
        position: absolute;
        right: -60px; bottom: -60px;
        width: 180px; height: 180px;
        background: radial-gradient(circle, #00b89433 60%, transparent 100%);
        z-index: 0;
    }
    .about-kosin-logo {
        width: 60px;
        height: 60px;
        border-radius: 18px;
        background: linear-gradient(135deg, #19a9a9 60%, #00b894 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px auto;
        box-shadow: 0 4px 16px rgba(25,169,169,0.10);
        z-index: 1;
        position: relative;
    }
    .about-kosin-logo i {
        font-size: 2.2rem;
        color: #fff;
    }
    .about-kosin h5 {
        color: #19a9a9;
        font-weight: 800;
        letter-spacing: 1.2px;
        margin-bottom: 12px;
        font-size: 1.5rem;
        z-index: 1;
        position: relative;
    }
    .about-kosin hr {
        width: 70px;
        border-top: 3px solid #00b894;
        margin: 0 auto 26px auto;
        z-index: 1;
        position: relative;
    }
    .about-kosin p {
        font-size: 1.18rem;
        color: #222;
        font-weight: 500;
        letter-spacing: 0.2px;
        line-height: 1.7;
        z-index: 1;
        position: relative;
    }
    .about-kosin-highlight {
        color: #00b894;
        font-weight: bold;
        letter-spacing: 1px;
    }
    @media (max-width: 600px) {
        .about-kosin {
            padding: 28px 10px 24px 10px;
        }
        .about-kosin h5 {
            font-size: 1.1rem;
        }
        .about-kosin-logo {
            width: 44px; height: 44px;
        }
    }
</style>
<div class="about-kosin">
    <div class="about-kosin-logo">
        <i class="fas fa-door-open"></i>
    </div>
    <h5>Tentang <span class="about-kosin-highlight">KosIn</span></h5>
    <hr>
    <p>
        <span class="about-kosin-highlight">KosIn</span> hadir sebagai solusi modern untuk kamu yang ingin mencari atau mempromosikan kost dengan cara yang lebih mudah, cepat, dan transparan.<br><br>
        Temukan berbagai pilihan kost dengan fasilitas lengkap, harga yang jelas, dan foto asli yang bisa kamu percaya. Mau cari kost idaman? Atau ingin kost kamu cepat terisi? Semua bisa lewat <span class="about-kosin-highlight">KosIn</span>!<br><br>
        Nikmati pengalaman mencari dan menawarkan kost yang lebih nyaman, aman, dan pastinya tanpa ribet. Yuk, mulai perjalanan barumu bersama <span class="about-kosin-highlight">KosIn</span>! #CariKostGakPakeRibet 🚀
    </p>
</div>

<?php
include "template/footer.php";
?>
</body>
</html>