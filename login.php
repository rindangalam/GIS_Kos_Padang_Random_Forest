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
    .login-form {
        width: 400px;
        margin: 0 auto;
        padding: 20px;
        
        
        position: relative;
        
    } 

   .login-form form {
        margin-bottom: 15px;
        box-shadow: 0 4px 24px rgba(25, 169, 169, 0.13);  
        padding: 40px 32px 32px 32px; 
        border-radius: 10px; 
        background: rgba(25, 169, 169, 0.13); 
        border: none;
    }


   .login-form h2 {
        margin: 0 0 25px;
        font-weight: bold;
        color: #19a9a9;
        letter-spacing: 1px;
    }

    .login-form label {
        color: #19a9a9;
        font-weight: 500;
        margin-right: 8px;
    }
    .login-form a {
        color: #19a9a9;
        font-weight: bold;
        margin-left: 10px;
        transition: color 0.2s;
    }
    .login-form a:hover {
        color: #1565c0;
        text-decoration: underline;
    }
    .login-form .text-center a {
        color: #1565c0;
        font-weight: bold;
     
    }

    
    .form-control
    {
      border: 2px solid #19a9a9;
      border-radius: 25px;
      padding: 10px 20px;
      font-size: 15px;
      color: #333;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .btn {
      min-height: 38px;
      border-radius: 2px;
    }

    .btn {
      font-size: 15px;
      font-weight: bold;
      background-color: #19a9a9;
      color: #fff;
      border: none;
      border-radius: 25px;
      padding: 10px 32px;
      min-width: unset;
      min-height: 38px;
      transition: background 0.2s, box-shadow 0.2s;
      /* Efek shadow dan bevel */
      box-shadow:
        0 4px 16px 0 rgba(25,169,169,0.18), /* shadow luar */
        inset 0 2px 8px 0 rgba(255,255,255,0.25), /* bevel atas dalam */
        inset 0 -2px 8px 0 rgba(0,0,0,0.10);     /* bevel bawah dalam */
    }

    .btn:hover,
    .btn:focus {
      background-color: #138d8d;
      color: #fff;
      box-shadow:
        0 6px 24px 0 rgba(25,169,169,0.22),
        inset 0 3px 12px 0 rgba(255,255,255,0.28),
        inset 0 -3px 12px 0 rgba(0,0,0,0.13);
    }


  /* hero */
 #hero-section {
    position: relative;
    overflow: hidden;
    z-index: 0 !important;
    height: 300px; 
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    background: #e0f7fa;
    margin-top: -71.7px !important;
    
    width: 120.5%;
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
      max-width: 98% !important;
      width: 98% !important;
      padding-left: 50px !important;
      padding-right: 50px !important;
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
      gap: 32px;
      flex-wrap: wrap;
  ">
          <div class="left-column" style="flex: 1; pointer-events: auto;">
              <h2 style="font-size: 50px; font-weight: bold; letter-spacing: 1px; animation: fadeIn 0.5s ease-in-out;">
                  Temukan Kost Idamanmu di <span style="color: rgb(150, 205, 170);">KosIn</span> aja
              </h2>
              <p style="font-size: 20px; animation: fadeIn 0.5s ease-in-out;">Pilih, cari, dan booking kost dengan mudah dan cepat!</p>
          </div>
          
      </div>

  </div>
    </div>
  </div>

     <!-- endhero --> 
  <div class="container">
    <div class="row">
      <div class="login-form">
        <form action="php/login_proses.php" method="post" class="bg-white">
          <h2 class=" text-center">Login</h2>
          <div class="form-group">
            <input autocomplete="off" autofocus required="required" class="form-control text-center" type="text" name="username" id="username" placeholder="Masukan username">
          </div>
          <div class="form-group">
            <input autocomplete="off" autofocus required="required" type="password" name="password" id="password" class="form-control text-center" placeholder="Masukan Password">
          </div>
          <div class="form-group text-center">
            <button class="btn" type="submit" value="login"
        style="
            background-color: #19a9a9;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-size: 15px;
            font-weight: bold;
            padding: 10px 32px;
            min-width: unset;
            min-height: 38px;
            transition: background 0.2s;
            display: inline-block;
        "
        onmouseover="this.style.backgroundColor='#138d8d'"
        onmouseout="this.style.backgroundColor='#19a9a9'"
    >
        Masuk
    </button>
            <div class="clearfix">
              <input type="checkbox" name="remember" id="">
              <label for="" class="pull-left checkbox-inline">
                Remember Me
              </label>
              <a href="#">Lupa Password?</a>
            </div>
            <p class="text-center" ><a href="daftar.php">Daftar / Buat Akun ?</a></p>
          </div>
        </form>
      </div>

    </div>
  </div>




  <?php
  include "template/footer.php";
  ?>

</body>
   


