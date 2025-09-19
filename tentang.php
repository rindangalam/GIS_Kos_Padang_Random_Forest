<?php
$scrollNavbar = true;
include 'template/header.php';

$jumlah_data_perhalaman = 8;
$jumlah_halaman = ceil($jumlah_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kost JOIN user ON kost.id_pemilik = user.id")) / $jumlah_data_perhalaman);
if (isset($_GET['halaman'])) {
  $halaman_aktif = $_GET['halaman'];
} else {
  $halaman_aktif = 1;
}

$awalData = ($jumlah_data_perhalaman * $halaman_aktif) - $jumlah_data_perhalaman;

$query = "SELECT * FROM kost  INNER JOIN user ON kost.id_pemilik = user.id LIMIT $awalData,$jumlah_data_perhalaman";

$data = mysqli_query($koneksi, $query);

function minfas($idkost, $tipe_kost)
{
  global $koneksi;
  $cost = mysqli_query($koneksi, "SELECT min(biaya_fasilitas) FROM kamar WHERE id_kost=$idkost");
  $p = mysqli_fetch_array($cost);
  if ($tipe_kost == "Bulan") {
    return $p['min(biaya_fasilitas)'];
  } else if ($tipe_kost == "Tahun") {
    return $p['min(biaya_fasilitas)'] * 12;
  }
}

?>


<?php if ($scrollNavbar): ?>
  <style>
    .transparent-navbar {
      background-color: rgba(0, 0, 0, 0);
      transition: background-color 0.4s ease;
      border-radius: 0 0 20px 20px;
    }

    .scrolled-navbar {
      background-color:rgba(25, 169, 169, 0.85);
    }
  </style>

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
<?php endif; ?>



<style>



  /* hero */
 #hero-section {
    position: relative;
    overflow: hidden;
    z-index: 0 !important;
    height: 650px; 
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    background: #e0f7fa;
    margin-top: -71.7px !important;
    
    width: 104%;
    left: 50%;
    right: 50%;
    transform: translateX(-50%);
    border: none;
  }
  #hero-section::before {
    content: "";
    position: absolute;
    inset: 0;
    background: rgba(224,247,250,0.3);
    z-index: 1;
    pointer-events: none;
    border-radius: 0;
  }
  @media (max-width: 991.98px) {
    #accordionSidebar {
      z-index: 1051 !important;
      position: relative;
    }
  }
  .sidebar,
  #accordionSidebar {
    z-index: 1051 !important;
    position: relative;
  }
  #hero-section {
    z-index: 0 !important;
    position: relative;
  }
  /* end hero */


  body {
    background-color:rgb(255, 255, 255); 
  }


    .container {
      max-width: 100% !important;
      width: 100% !important;
      
    }
</style>

<body>
  <div class="container">
   
     <!-- hero -->

    <div id="hero-section" class="mb-4">
      <?php
        // Array gambar hero (ganti sesuai gambar yang ada di folder)
        $hero_images = [
          "kost/img/hero/hero1.jpg",
          "kost/img/hero/hero2.jpg",
        "kost/img/hero/hero3.jpg",
        "kost/img/hero/hero4.jpg"
      ];
      shuffle($hero_images); // Acak urutan gambar
    ?>
    <div id="hero-slider" style="height:100%; width:100%; position:relative;">
      <?php foreach ($hero_images as $idx => $img): ?>
        <img src="<?php echo $img; ?>"
             class="hero-slide-img"
             style="
               position:absolute;
               top:0; left:0; width:100%; height:100%; object-fit:cover;
               opacity:<?php echo $idx === 0 ? '1' : '0'; ?>;
               z-index:1;
               transition: opacity 1s cubic-bezier(.4,0,.2,1);
             "
             alt="Hero Image <?php echo $idx+1; ?>">
      <?php endforeach; ?>
      <!-- Overlay tulisan di atas gambar tanpa background -->
      <div class="hero-smoke-bg"
           style="
              position:absolute;
              bottom:0;
              left:0;
              width:100%;
              height:100px;
              z-index:1;
              pointer-events:none;

           ">
      </div>
      <div class="hero-overlay-text" style="
      position: absolute;
      top: 50%;
      left: 0;
      width: 100%;
      color: #fff;
      padding: 325px 32px 325px 32px;
      z-index: 2;
      pointer-events: none;
      background: rgba(0, 0, 0, 0.5);
      display: flex;
      justify-content: space-between;
      align-items: center;
      transform: translateY(-50%);
      
  ">
          <div class="left-column" style="flex: 1; pointer-events: auto;">
              <h2 style="font-size: 50px; font-weight: bold; letter-spacing: 1px; animation: fadeIn 0.5s ease-in-out;">
                  Temukan Kost Idamanmu di <span style="color: rgb(150, 205, 170);">KosIn</span> aja
              </h2>
              <p style="font-size: 20px; animation: fadeIn 0.5s ease-in-out;">Pilih, cari, dan booking kost dengan mudah dan cepat!</p>
          </div>
          <
      </div>

  </div>
    </div>
  </div>

     <!-- endhero --> 
  <!-- Search -->
<style>
    .about-kosin {
        max-width: 700px;
        margin: 64px auto 50 auto;
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
   

