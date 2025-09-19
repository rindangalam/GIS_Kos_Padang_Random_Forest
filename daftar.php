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
        background: rgba(255, 255, 255, 0.13); 
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
    height: 350px; /* 1.5x dari sebelumnya (300px) */
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
          <
      </div>

  </div>
    </div>
  </div>

     <!-- endhero --> 
  <div class="container">
    <div class="row">
      <div class="login-form">
        <form action="php/daftar_proses.php" method="post" enctype="multipart/form-data">
          <div style="text-align:center; margin-bottom: 25px;">
            <img src="img/logo.png" alt="Logo" style="width:70px; height:70px; border-radius:50%; box-shadow:0 2px 8px rgba(25,169,169,0.15); margin-bottom:10px;">
            <h2 style="font-weight:bold; color:#19a9a9; margin:0;">Daftar</h2>
            <p style="color:#555; font-size:15px; margin-top:8px;">Silakan isi data di bawah untuk membuat akun baru</p>
          </div>

          <div class="form-group">
            <input required="required" class="form-control text-center" type="text" name="username" id="username" placeholder="Masukan username">
          </div>
          <div class="form-group">
            <input required="required" type="password" name="password" id="password" class="form-control text-center" placeholder="Masukan Password">
          </div>
          <div class="form-group">
            <input required="required" type="email" name="email" id="email" class="form-control text-center" placeholder="Masukan Email">
          </div>
          <div class="form-group">
            <input required="required" type="text" name="nama_lengkap" id="nama_lengkap" class="form-control text-center" placeholder="Masukan Nama Lengkap">
          </div>
          <div class="form-group">
            <input required="required" type="number" name="no_hp" id="no_hp" class="form-control text-center" placeholder="Masukan Nomer Telepon/HP">
          </div>
          <div class="form-group">
            <input required="required" type="text" name="pekerjaan" id="pekerjaan" class="form-control text-center" placeholder="Masukan Pekerjaan">
          </div>
          <div class="form-group">

            <label for="">Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="custom-select">
              <option value="laki-laki">Laki-laki</option>
              <option value="perempuan">Perempuan</option>
            </select>
            <br>
          </div>
          <div class="form-group">
            <!-- <label for="foto_ktp" class="form-group">Foto KTP</label>
            <input type="file" name="foto_ktp" id="foto_ktp" class="form-group">
          </div> -->
          <div class="form-group">
            <label for="foto_profil" class="form-group">Foto Profil</label>
            <input type="file" name="foto_profil" id="foto_profil" class="form-group">
          </div>


          <div class="form-group">
            <label for="">Mendaftar sebagai ?</label>
            <br>
            <select name="roles" id="roles" class="custom-select">
              <option value="1">Penghuni kost</option>
              <option value="2">Pemilik kost</option>
            </select>
          </div>


          <div class="form-group text-center">
            <input type="submit" value="Daftar" class="btn btn-primary"
    style="
      border-radius: 25px;
      font-size: 1.15rem;
      font-weight: bold;
      padding: 5px 22px;
      min-width: unset;
      min-height: 38px;
      box-shadow: 0 4px 16px rgba(25, 169, 169, 0.13);
      background: linear-gradient(90deg, #19a9a9 0%, #00cec9 100%);
      color: #fff;
      border: none;
      display: inline-block;
      transition: background 0.3s, transform 0.2s;
    "
    onmouseover="this.style.background='linear-gradient(90deg,#00cec9 0%,#19a9a9 100%)';this.style.transform='scale(1.04)'"
    onmouseout="this.style.background='linear-gradient(90deg,#19a9a9 0%,#00cec9 100%)';this.style.transform='scale(1)'"
  >
          </div>
        </form>
        <p class="text-center"><a href="login.php">Sudah punya akun ? Login</a></p>
      </div>

    </div>
  

    </div>
  </div>




  <?php
  include "template/footer.php";
  ?>

</body>
   
















