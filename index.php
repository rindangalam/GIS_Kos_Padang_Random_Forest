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
    height: 800px; /* 1.5x dari sebelumnya (300px) */
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    background: #e0f7fa;
    margin-top: -71.7px !important;
    
    width: 103.7%;
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

  .card {
    margin: 2px;
  }

  a {
    text-decoration: none;
    color: black
  }

  body {
    background-color:rgb(255, 255, 255); 
  }



  .row {
    display: flex;
    flex-wrap: wrap;
    gap: 2.5rem 2rem;
    justify-content: flex-start;
    }
  .kost-vertical-card {
    background: #fff;
    border: none;
    border-radius: 12px;
    box-shadow: 0 8px 36px 0 rgba(25,169,169,0.13), 0 2px 8px 0 rgba(0,0,0,0.04);
    width: 420px;
    min-width: 320px;
    max-width: 99vw;
    display: flex;
    flex-direction: column;
    padding: 0;
    transition: box-shadow 0.2s, transform 0.2s;
    overflow: hidden;
  }
  .kost-vertical-card:hover {
    box-shadow: 0 20px 60px 0 rgba(25,169,169,0.18);
    transform: translateY(-6px) scale(1.025);
  }
  .kost-vertical-img-wrap {
    position: relative;
    width: 100%;
    height: 320px;
    background: #e0f7fa;
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .kost-vertical-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 0;
    display: block;
  }
  .kost-vertical-avatar {
    position: absolute;
    left: 24px;
    bottom: 24px;
    width: 60px;
    height: 60px;
    border-radius: 50%;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(25,169,169,0.18);
    object-fit: cover;
    z-index: 2;
    background: #fff;
  }
  .kost-vertical-type {
    position: absolute;
    right: 0;
    top: 22px;
    background: #19a9a9;
    color: #fff;
    font-size: 1.15em;
    font-weight: bold;
    padding: 12px 32px 12px 18px;
    border-radius: 0;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(25,169,169,0.10);
    letter-spacing: 0.5px;
  }
  .kost-type-putri { background: #e573b7 !important; }
  .kost-type-putra { background: #222 !important; }
  .kost-type-campuran { background: #7c4dff !important; }
  .kost-vertical-body {
    padding: 32px 32px 24px 32px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
    justify-content: space-between;
  }
  .kost-vertical-title {
    font-weight: bold;
    margin-bottom: 12px;
    font-size: 1.35rem;
    color: #222;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
  .kost-vertical-location {
    font-size: 1.12em;
    color: #555;
    margin-bottom: 10px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
  .kost-vertical-owner {
    font-size: 1.05em;
    color: #888;
    margin-bottom: 18px;
  }
  .kost-vertical-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 16px;
  }
  .kost-vertical-price {
    color: #19a9a9;
    font-weight: bold;
    font-size: 1.18em;
  }
  .kost-vertical-room {
    color: #1565c0;
    font-size: 1.08em;
  }
  @media (max-width: 1200px) {
    .kost-vertical-card { width: 48%; }
    .kost-vertical-img-wrap { height: 220px; }
  }
  @media (max-width: 768px) {
    .kost-vertical-card { width: 98%; min-width: 0; max-width: 100%; }
    .kost-vertical-img-wrap { height: 180px; }
    .kost-vertical-body { padding: 18px 12px 14px 12px; }
  }
    .container {
      max-width: 100% !important;
      width: 100% !important;
     
    }
  /* info section */
  .info-section {
    background: #fff;
    padding: 60px 0 40px 0;
    margin: 40px 0;
    box-shadow: none;
    border: none;
  }
  .info-section h2 {
    color: #19a9a9;
    font-size: 2.2rem;
    font-weight: bold;
    margin-bottom: 18px;
    text-align: center;
  }
  .info-section p {
    color: #444;
    font-size: 1.15rem;
    text-align: center;
    margin-bottom: 32px;
    max-width: 700px;
    margin-left: auto;
    margin-right: auto;
  }
  .info-features {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 32px;
    margin-top: 30px;
  }
  .feature-card {
    background: #fff;
    border-radius: 14px;
    box-shadow: 0 2px 12px 0 rgba(25,169,169,0.10);
    padding: 32px 28px;
    max-width: 340px;
    min-width: 260px;
    text-align: center;
    transition: box-shadow 0.2s, transform 0.2s;
  }
  .feature-card:hover {
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.16);
    transform: translateY(-6px) scale(1.03);
  }
  .feature-card img {
    width: 80px;
    height: 80px;
    object-fit: contain;
    margin-bottom: 18px;
  }
  .feature-card h4 {
    color: #1565c0;
    font-size: 1.18rem;
    font-weight: bold;
    margin-bottom: 10px;
  }
  .feature-card p {
    color: #555;
    font-size: 1rem;
    margin-bottom: 0;
  }
  /* end info section */

  /* about section */
  .about-section {
    background: #fff;
    box-shadow: none;
    padding: 60px 0 40px 0;
    margin: 40px 0;
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 40px;
    border: none;
  }
  .about-img {
    flex: 1 1 320px;
    min-width: 280px;
    max-width: 420px;
    text-align: center;
  }
  .about-img img {
    width: 90%;
    max-width: 350px;
    border-radius: 16px;
    box-shadow: none;
  }
  .about-content {
    flex: 2 1 400px;
    min-width: 280px;
    max-width: 700px;
  }
  .about-content h3 {
    color: #19a9a9;
    font-size: 2rem;
    font-weight: bold;
    margin-bottom: 18px;
  }
  .about-content p {
    color: #444;
    font-size: 1.13rem;
    margin-bottom: 18px;
  }
  @media (max-width: 900px) {
    .about-section {
      flex-direction: column;
      padding: 40px 0 20px 0;
    }
    .about-img, .about-content {
      max-width: 100%;
    }
  }
  /* end about section */
</style>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
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
            padding: 424px 32px 424px 32px;
            z-index: 2;
            pointer-events: none;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: flex-start;
            align-items: center;
            transform: translateY(-50%);">
            <div class="left-column" style="flex: 1; pointer-events: auto;">
                <h2 style="font-size: 50px; font-weight: bold; letter-spacing: 1px; animation: fadeIn 0.5s ease-in-out;">
                    Temukan Kost Idamanmu di <span style="color: rgb(150, 205, 170);">KosIn</span> aja
                </h2>
                <p style="font-size: 20px; animation: fadeIn 0.5s ease-in-out;">Pilih, cari, dan booking kost dengan mudah dan cepat!</p>
            </div>
          </div>
        </div>
        <!-- Bagian bawah kosong di dalam hero section -->
        <div id="hero-bottom-empty" style="position:absolute; left:0; right:0; bottom:0; z-index:2; width:100%; height:60px; background:transparent;"></div>
      </div>
      <!-- end hero -->

      <!-- Kost Card Mini di Hero Section Bawah -->
      <div id="kost-mini-slider-wrap" style="position:absolute; left:0; right:0; bottom:0; z-index:3; width:100%; padding:0 0 32px 0; pointer-events:auto; background:transparent;">
        <div style="max-width:1200px; margin:0 auto; padding:0 24px; background:transparent;">
          <div style="background:transparent; border-radius:0; box-shadow:none; padding:0; overflow-x:visible;">
            <div id="kost-mini-slider" style="display:flex; gap:18px; overflow-x:auto; scrollbar-width:none; align-items:flex-end; padding-bottom:8px;">
              <?php mysqli_data_seek($data, 0); while ($d = mysqli_fetch_array($data)) { ?>
                <div class="kost-vertical-card mini-kost-card" style="width:190px; min-width:170px; max-width:210px; border-radius:16px; margin-bottom:0; box-shadow:0 6px 22px 0 rgba(25,169,169,0.15); border:1.5px solid #e0f7fa; background:rgba(255,255,255,0.92); position:relative; transition:box-shadow 0.18s,transform 0.18s; display:flex; flex-direction:column; align-items:center; padding:0;">
                  <a href="kost/tampilan-kost.php?id_kost=<?php echo $d['id_kost'] ?>" style="text-decoration:none;color:inherit;display:block;width:100%;">
                    <div class="kost-vertical-img-wrap" style="height:110px; border-radius:16px 16px 0 0; overflow:hidden; width:100%;">
                      <img src="img/foto_kost/kamar/<?php echo $d['foto_kamar'] ?>" alt="Kamar Kost" class="kost-vertical-img" style="border-radius:16px 16px 0 0; width:100%; height:100%; object-fit:cover;">
                    </div>
                    <div style="padding:13px 10px 10px 10px; text-align:center; width:100%; background:transparent;">
                      <div class="kost-vertical-title" style="font-size:1.08rem; margin-bottom:4px; font-weight:600; color:#222; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                        <?php echo $d['nama_kost'] ?>
                      </div>
                      <div class="kost-vertical-type kost-type-<?php echo strtolower($d['jenis_kost']); ?>" style="display:inline-block; font-size:0.85em; padding:5px 16px 5px 16px; border-radius:10px; margin-top:4px; background:#19a9a9; color:#fff; font-weight:500; letter-spacing:0.2px;">
                        <?php echo $d['jenis_kost'] ?>
                      </div>
                    </div>
                  </a>
                </div>
              <?php } ?>
            </div>
          </div>
        </div>
      </div>
      <style>
      #kost-mini-slider::-webkit-scrollbar { display:none; }
      #kost-mini-slider { scrollbar-width:none; }
      .mini-kost-card { transition:box-shadow 0.18s,transform 0.18s; }
      .mini-kost-card:hover { box-shadow:0 8px 24px 0 rgba(25,169,169,0.18); transform:translateY(-3px) scale(1.04); z-index:2; }
      .mini-kost-card .kost-vertical-type { position:absolute; top:8px; left:8px; background:#19a9a9; color:#fff; font-size:0.7em; padding:3px 10px; border-radius:8px; min-width:unset; z-index:2; }
      @media (max-width:900px) {
        #kost-mini-slider { gap:8px; }
        .mini-kost-card { min-width:110px; max-width:130px; }
        .mini-kost-card .kost-vertical-img-wrap { height:70px !important; }
        .mini-kost-card .kost-vertical-title { font-size:0.82rem !important; }
        .mini-kost-card .kost-vertical-type { font-size:0.65em !important; padding:3px 8px !important; }
      }
      </style>
      <script>
      // Animasi auto geser slider
      (function(){
        const slider = document.getElementById('kost-mini-slider');
        let scrollAmount = 0;
        let maxScroll = 0;
        let direction = 1;
        function autoScroll() {
          if (!slider) return;
          maxScroll = slider.scrollWidth - slider.clientWidth;
          if (maxScroll <= 0) return;
          scrollAmount += direction * 1.2;
          if (scrollAmount >= maxScroll) { direction = -1; scrollAmount = maxScroll; }
          if (scrollAmount <= 0) { direction = 1; scrollAmount = 0; }
          slider.scrollTo({ left: scrollAmount, behavior: 'smooth' });
        }
        setInterval(autoScroll, 30);
      })();
      </script>

      <!-- Info Section -->
      <div class="info-section">
        <h2>Mengapa Memilih KosIn?</h2>
        <p>KosIn adalah platform pencarian kos terlengkap di Kota Padang. Kami membantu Anda menemukan kos idaman dengan mudah, cepat, dan aman. Temukan berbagai pilihan kos dengan fasilitas terbaik, lokasi strategis, dan harga terjangkau hanya di KosIn!</p>
        <div class="info-features">
          <div class="feature-card">
            <img src="img/jumbotron-sample.png" alt="Fitur Pencarian">
            <h4>Pencarian Mudah</h4>
            <p>Cari kos sesuai kebutuhan Anda dengan filter lokasi, harga, fasilitas, dan kategori.</p>
          </div>
          <div class="feature-card">
            <img src="img/logo.png" alt="Fitur Booking">
            <h4>Booking Online</h4>
            <p>Booking kamar kos secara online, tanpa harus survei langsung. Praktis dan efisien!</p>
          </div>
          <div class="feature-card">
            <img src="img/profil/jojon.jpg" alt="Fitur Aman">
            <h4>Transaksi Aman</h4>
            <p>Transaksi pembayaran terjamin aman dan transparan melalui sistem kami.</p>
          </div>
        </div>
      </div>

      <!-- About Section -->
      <div class="about-section">
        <div class="about-img">
          <img src="img/foto_kost/kamar/kamar1.jpeg" alt="Contoh Kamar Kos">
        </div>
        <div class="about-content">
          <h3>Tentang Kos-Kosan di Padang</h3>
          <p>Kos-kosan di Padang menawarkan berbagai pilihan tipe kamar, mulai dari kamar mandi dalam, kamar mandi luar, hingga fasilitas lengkap seperti WiFi, parkir, dapur, dan ruang tamu. Lokasi kos tersebar di dekat kampus ternama seperti UNAND, Politeknik Negeri Padang, dan UPI YPTK, serta dekat dengan pusat kota dan tempat wisata.</p>
          <p>Dengan KosIn, Anda dapat membandingkan harga, fasilitas, dan lokasi secara transparan. Setiap kos yang terdaftar telah diverifikasi untuk memastikan kenyamanan dan keamanan Anda selama tinggal di Padang.</p>
        </div>
      </div>

      <!-- Gallery Section -->
      <div class="info-section">
        <h2>Galeri Kos-Kosan</h2>
        <p>Lihat beberapa contoh kos-kosan yang tersedia di platform kami.</p>
        <div class="info-features">
          <div class="feature-card">
            <img src="img/foto_kost/kamar/kamar1.jpeg" alt="Kamar Nyaman">
            <h4>Kamar Nyaman</h4>
            <p>Kamar bersih, rapi, dan nyaman untuk istirahat setelah aktivitas seharian.</p>
          </div>
          <div class="feature-card">
            <img src="https://picsum.photos/350/220?random=1" alt="Bangunan Utama">
            <h4>Bangunan Modern</h4>
            <p>Bangunan kos modern dengan desain kekinian dan fasilitas lengkap.</p>
          </div>
          <div class="feature-card">
            <img src="https://picsum.photos/350/220?random=2" alt="Interior Kos">
            <h4>Interior Menarik</h4>
            <p>Interior kos yang didesain untuk kenyamanan dan produktivitas penghuni.</p>
          </div>
        </div>
      </div>

      <!-- New: Benefit Section -->
      <div class="info-section">
        <h2>Keuntungan Bergabung di KosIn</h2>
        <div class="info-features">
          <div class="feature-card">
            <img src="https://picsum.photos/80/80?random=3" alt="Komunitas Penghuni">
            <h4>Komunitas Penghuni</h4>
            <p>Bergabung dengan komunitas penghuni kos, dapatkan teman baru dan info seputar kehidupan kos.</p>
          </div>
          <div class="feature-card">
            <img src="https://picsum.photos/80/80?random=4" alt="Review & Rating">
            <h4>Review & Rating</h4>
            <p>Lihat ulasan dan rating dari penghuni sebelumnya untuk membantu Anda memilih kos terbaik.</p>
          </div>
          <div class="feature-card">
            <img src="https://picsum.photos/80/80?random=5" alt="Dukungan 24 Jam">
            <h4>Dukungan 24 Jam</h4>
            <p>Tim support kami siap membantu Anda kapan saja jika ada kendala dalam mencari atau booking kos.</p>
          </div>
        </div>
      </div>

      <!-- Call to Action Section (moved before footer) -->
      <div class="info-section" style="background: #fff; color: #19a9a9; text-align: center; margin-bottom: 40px; box-shadow: 0 4px 24px 0 rgba(25,169,169,0.10);">
        <div style="max-width: 700px; margin: 0 auto; padding: 48px 24px; border-radius: 18px; background: #fff; box-shadow: 0 2px 16px 0 rgba(25,169,169,0.10);">
          <span style="color: #19a9a9; font-size: 2rem; font-weight: bold; display: block; margin-bottom: 18px;">Gabung sekarang di KosIn!</span>
          <span style="color: #333; font-size: 1.15rem; display: block; margin-bottom: 28px;">Mulai petualanganmu mencari kos yang nyaman, aman, dan sesuai kebutuhanmu. Nikmati kemudahan pencarian, booking online, dan promo menarik khusus member baru!</span>
          <a href="daftar.php" style="display: inline-block; background: #19a9a9; color: #fff; font-weight: bold; font-size: 1.2rem; padding: 16px 38px; border-radius: 30px; text-decoration: none; box-shadow: 0 2px 12px 0 rgba(25,169,169,0.13); transition: background 0.2s, color 0.2s;">Daftar Sekarang &rarr;</a>
        </div>
      </div>

    </div>

<?php
include "template/footer.php";
?>

</body>
</html>
