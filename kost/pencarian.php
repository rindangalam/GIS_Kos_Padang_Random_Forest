<?php
include "../php/koneksi.php";
include "template/navbar.php";
$scrollNavbar = true;

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

<?php
$keyword = $_GET['keyword'] ?? '';
$kecamatan = $_GET['kecamatan'] ?? '';
$kampus = $_GET['kampus'] ?? '';
$wisata = $_GET['wisata'] ?? '';
$kategori = $_GET['kategori'] ?? '';
$tipe_kamar = $_GET['tipe_kamar'] ?? '';
$harga_min = $_GET['harga_min'] ?? 0;
$harga_max = $_GET['harga_max'] ?? 99999999;
$fasilitas = $_GET['fasilitas'] ?? [];


// Bangun query dasar dengan subquery agar bisa filter pakai min_fasilitas
$baseQuery = "SELECT kost.*, user.*, (
    SELECT MIN(biaya_fasilitas) FROM kamar WHERE kamar.id_kost = kost.id_kost
) AS min_fasilitas
FROM kost
JOIN user ON kost.id_pemilik = user.id
WHERE 1=1";

// Tambahkan filter pencarian ke $baseQuery (kecuali filter harga)
if (!empty($keyword)) {
    $baseQuery .= " AND (nama_kost LIKE '%$keyword%' OR deskripsi LIKE '%$keyword%')";
}
if (!empty($kecamatan)) {
    $baseQuery .= " AND kecamatan = '$kecamatan'";
}
if (!empty($kategori)) {
    $baseQuery .= " AND jenis_kost = '$kategori'";
}
if (!empty($kampus)) {
    $baseQuery .= " AND kampus = '$kampus'";
}
if (!empty($tipe_kamar)) {
    $baseQuery .= " AND tipe_kost = '$tipe_kamar'";
}
if (!empty($fasilitas)) {
    foreach ($fasilitas as $f) {
        $baseQuery .= " AND fasilitas_kost LIKE '%$f%'";
    }
}

// Bungkus sebagai subquery agar bisa filter harga pakai alias
$query = "SELECT * FROM ( $baseQuery ) AS hasil WHERE 1=1";
if (is_numeric($harga_min) && $harga_min > 0) {
    $query .= " AND (harga_sewa + IFNULL(min_fasilitas,0)) >= $harga_min";
}
if (is_numeric($harga_max) && $harga_max > 0 && $harga_max < 99999999) {
    $query .= " AND (harga_sewa + IFNULL(min_fasilitas,0)) <= $harga_max";
}

// PAGINATION SETUP
$jumlah_data_perhalaman = 20;
$countQuery = "SELECT COUNT(*) as total FROM ( $baseQuery ) AS hasil WHERE 1=1";
if (is_numeric($harga_min) && $harga_min > 0) {
    $countQuery .= " AND (harga_sewa + IFNULL(min_fasilitas,0)) >= $harga_min";
}
if (is_numeric($harga_max) && $harga_max > 0 && $harga_max < 99999999) {
    $countQuery .= " AND (harga_sewa + IFNULL(min_fasilitas,0)) <= $harga_max";
}
$countResult = mysqli_query($koneksi, $countQuery);
$totalData = mysqli_fetch_assoc($countResult)['total'] ?? 0;
$jumlah_halaman = ceil($totalData / $jumlah_data_perhalaman);
$halaman_aktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$awalData = ($jumlah_data_perhalaman * $halaman_aktif) - $jumlah_data_perhalaman;
// Tambahkan LIMIT ke query utama
$query .= " LIMIT $awalData, $jumlah_data_perhalaman";
$result = mysqli_query($koneksi, $query);

?>


<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Hasil Pencarian Kos</title>
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/fontawesome.min.css">
  <script src="../js/jquery.min.js"></script>
  <script src="../js/bootstrap.bundle.min.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
</head>
<style>
  .container2 {
    max-width: 1100px;
    width: 98%;
    margin: 0 auto 40px auto;
    padding-left: 24px;
    padding-right: 24px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px 0 rgba(25,169,169,0.08);
    position: relative;
    z-index: 2;
  }
  .hasil-title {
    font-size: 2.1rem;
    font-weight: bold;
    color: #19a9a9;
    margin: 32px 0 18px 0;
    text-align: center;
    letter-spacing: 1px;
    text-shadow: 0 2px 8px rgba(25,169,169,0.08);
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
    border-radius: 18px;
    box-shadow: 0 8px 36px 0 rgba(25,169,169,0.13), 0 2px 8px 0 rgba(0,0,0,0.04);
    width: 260px;
    min-width: 180px;
    max-width: 95vw;
    display: flex;
    flex-direction: column;
    padding: 0;
    margin-bottom: 18px;
    transition: box-shadow 0.25s, transform 0.22s;
    overflow: hidden;
    border: 1.5px solid #e0f7fa;
  }
  .kost-vertical-card:hover {
    box-shadow: 0 20px 60px 0 rgba(25,169,169,0.18);
    transform: translateY(-8px) scale(1.035);
    border-color: #19a9a9;
  }
  .kost-vertical-img-wrap {
    position: relative;
    width: 100%;
    height: 140px;
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
    transition: transform 0.3s;
  }
  .kost-vertical-card:hover .kost-vertical-img {
    transform: scale(1.07);
  }
  .kost-vertical-avatar {
    position: absolute;
    left: 12px;
    bottom: 12px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    border: 2px solid #fff;
    box-shadow: 0 2px 8px rgba(25,169,169,0.18);
    object-fit: cover;
    z-index: 2;
    background: #fff;
  }
  .kost-vertical-type {
    position: absolute;
    right: 0;
    top: 18px;
    background: linear-gradient(90deg, #19a9a9 60%, #1565c0 100%);
    color: #fff;
    font-size: 1em;
    font-weight: bold;
    padding: 8px 22px 8px 14px;
    border-radius: 16px 0 0 16px;
    z-index: 2;
    box-shadow: 0 2px 8px rgba(25,169,169,0.10);
    letter-spacing: 0.5px;
    text-transform: uppercase;
  }
  .kost-type-putri { background: linear-gradient(90deg, #e573b7 60%, #ad1457 100%) !important; }
  .kost-type-putra { background: linear-gradient(90deg, #222 60%, #1565c0 100%) !important; }
  .kost-type-campuran { background: linear-gradient(90deg, #7c4dff 60%, #19a9a9 100%) !important; }
  .kost-vertical-body {
    padding: 14px 10px 10px 10px;
    display: flex;
    flex-direction: column;
    flex: 1;
    min-width: 0;
    justify-content: space-between;
  }
  .kost-vertical-title {
    font-weight: bold;
    margin-bottom: 10px;
    font-size: 1.05rem;
    color: #222;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
  .kost-vertical-location {
    font-size: 0.95em;
    color: #555;
    margin-bottom: 8px;
    text-overflow: ellipsis;
    overflow: hidden;
    white-space: nowrap;
  }
  .kost-vertical-owner {
    font-size: 0.95em;
    color: #888;
    margin-bottom: 12px;
  }
  .kost-vertical-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 10px;
  }
  .kost-vertical-price {
    color: #19a9a9;
    font-weight: bold;
    font-size: 1.08em;
  }
  .kost-vertical-room {
    color: #1565c0;
    font-size: 1em;
  }
  @media (max-width: 1200px) {
    .kost-vertical-card { width: 44%; }
    .kost-vertical-img-wrap { height: 110px; }
  }
  @media (max-width: 768px) {
    .container2 { padding-left: 4px; padding-right: 4px; }
    .kost-vertical-card { width: 98%; min-width: 0; max-width: 100%; }
    .kost-vertical-img-wrap { height: 80px; }
    .kost-vertical-body { padding: 8px 4px 6px 4px; }
    .hasil-title { font-size: 1.3rem; }
  }

   #hero-section {
position: relative;
    overflow: hidden;
    z-index: 0 !important;
    height: 300px; 
    width: 103.66%;
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    background: #e0f7fa;
    margin-top: 0px !important;
    
    left: 50%;
    right: 50%;
    transform: translateX(-50%);
    border: none;
  }
  #hero-section .hero-overlay-text {
    background: rgba(0, 0, 0, 0.45);
    border-radius: 0 0 32px 32px;
  }
  .container2 {
    
    width: 98%;
    margin: 0 auto 40px auto;
    padding-left: 24px;
    padding-right: 24px;
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px 0 rgba(25,169,169,0.08);
    position: relative;
    z-index: 2;
  }
  
  #hero-section {
    z-index: 0 !important;
    position: relative;
  }
      .container {
      max-width: 100% !important;
      width: 100% !important;
   
    }
  
  .container2 {
    max-width: 1300px;
    width: 100%;
    margin: 0 auto 40px auto;
    padding-left: 24px;

    background: #fff;
    border-radius: 18px;
    box-shadow: 0 4px 32px 0 rgba(25,169,169,0.08);
    position: relative;
    z-index: 2;
    align-items: center;
  }
</style>


<body>
 <div class="container">
   
<!-- Hero Section -->
<div id="hero-section" class="mb-4" style="position: relative; overflow: hidden; ">
  <?php
    $hero_images = [
      "img/hero/hero1.jpg",
      "img/hero/hero2.jpg",
      "img/hero/hero3.jpg",
      "img/hero/hero4.jpg"
    ];
    shuffle($hero_images);
  ?>
  <div id="hero-slider" style="height:100%; width:100%; position:relative;">
    <?php foreach ($hero_images as $idx => $img): ?>
      <img src="<?php echo $img; ?>"
           class="hero-slide-img"
           style="
             position:absolute;
             top:0; left:0; width:100%; height:100%; object-fit:cover;
             opacity:<?php echo $idx === 0 ? '1' : '0'; ?>;
             transition: opacity 1s ease;
           "
           data-index="<?= $idx ?>"
           alt="Hero Image <?= $idx+1; ?>">
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
            <h2 style="font-size: 50px; font-weight: bold; letter-spacing: 1px; animation: fadeIn 0.5s ease-in-out; margin-top: -70px;">
                Temukan Kost Idamanmu di <span style="color: rgb(150, 205, 170);">KosIn</span> aja
            </h2>
            <p style="font-size: 20px; animation: fadeIn 0.5s ease-in-out;">Pilih, cari, dan booking kost dengan mudah dan cepat!</p>
        </div>
        
    </div>
       
</div>
  </div>

<script>
  const slides = document.querySelectorAll('.hero-slide-img');
  let currentSlide = 0;
  const totalSlides = slides.length;

  function showSlide(index) {
    slides.forEach((slide, i) => {
      slide.style.opacity = i === index ? '1' : '0';
    });
    currentSlide = index;
  }

  function nextSlide() {
    let next = (currentSlide + 1) % totalSlides;
    showSlide(next);
  }

  function prevSlide() {
    let prev = (currentSlide - 1 + totalSlides) % totalSlides;
    showSlide(prev);
  }

  document.getElementById('next-slide').addEventListener('click', nextSlide);
  document.getElementById('prev-slide').addEventListener('click', prevSlide);

  // Optional: auto-slide every 5 seconds
  setInterval(nextSlide, 5000);
</script>


<!-- End Hero Section -->
 </div>

<div class="container2">
  <div class="hasil-title">Hasil Pencarian Kos</div>
  <div class="row justify-content-center" style="margin-top:18px;" id="hasil-list">
    <!-- Data hasil pencarian akan dimuat di sini oleh JavaScript -->
  </div>
  <div class="row justify-content-center mt-4 mb-5" id="pagination">
    <!-- Pagination akan dimuat di sini oleh JavaScript -->
  </div>
</div>

<script>
const API_URL = 'http://localhost:5000/api/pencarian'; // Ganti sesuai endpoint Flask Anda
const KOST_PER_PAGE = 20;
let kostData = [];
let currentPage = 1;
let totalPages = 1;

function getQueryParams() {
  const params = new URLSearchParams(window.location.search);
  return params.toString();
}

function formatRupiah(angka) {
  return angka.toLocaleString('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).replace(/,00$/, '');
}

function renderKostList(page = 1) {
  const start = (page - 1) * KOST_PER_PAGE;
  const end = start + KOST_PER_PAGE;
  const list = kostData.slice(start, end);
  const container = document.getElementById('hasil-list');
  container.innerHTML = '';
  if (list.length === 0) {
    container.innerHTML = '<p style="text-align:center;width:100%;font-size:1.1rem;color:#888;">Tidak ada kos yang ditemukan.</p>';
    return;
  }
  list.forEach(d => {
    container.innerHTML += `
      <div class="kost-vertical-card mb-4">
        <a href="tampilan-kost.php?id_kost=${d.id_kost}" style="text-decoration:none;color:inherit;display:block;">
          <div class="kost-vertical-img-wrap">
            <img src="https://picsum.photos/seed/${d.id_kost}-rumah/400/240" alt="Kamar Kost" class="kost-vertical-img" style="border-radius:12px 12px 0 0;">
            <img src="../img/profil/${d.foto_profil}" class="kost-vertical-avatar" alt="avatar">
            <div class="kost-vertical-type kost-type-${d.jenis_kost.toLowerCase()}">
              ${d.jenis_kost}
            </div>
          </div>
          <div class="kost-vertical-body">
            <h5 class="kost-vertical-title">${d.nama_kost}</h5>
            <div class="kost-vertical-location">
              <i class="fas fa-map-marker-alt"></i> ${d.kecamatan}, ${d.kelurahan}
            </div>
            <div class="kost-vertical-owner">
              <i class="fas fa-user"></i> ${d.nama_lengkap}
            </div>
            <div class="kost-vertical-footer">
              <span class="kost-vertical-price">
                Rp ${Number(d.harga_sewa + (d.min_fasilitas || 0)).toLocaleString('id-ID')} / ${d.tipe_kost}
              </span>
              <span class="kost-vertical-room">
                <i class="fas fa-door-open"></i> ${d.jumlah_kamar} Kamar
              </span>
            </div>
          </div>
        </a>
      </div>
    `;
  });
}

function renderPagination() {
  const container = document.getElementById('pagination');
  let html = '<nav aria-label="Page navigation"><ul class="pagination pagination-lg">';
  for (let i = 1; i <= totalPages; i++) {
    html += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#" onclick="goToPage(${i});return false;">${i}</a></li>`;
  }
  html += '</ul></nav>';
  container.innerHTML = html;
}

function goToPage(page) {
  currentPage = page;
  renderKostList(page);
  renderPagination();
  window.scrollTo({top: 0, behavior: 'smooth'});
}

function fetchKostData() {
  const params = getQueryParams();
  fetch(`${API_URL}?${params}`)
    .then(res => res.json())
    .then(data => {
      kostData = data.data || [];
      totalPages = Math.ceil((data.total || kostData.length) / KOST_PER_PAGE);
      renderKostList(1);
      renderPagination();
    })
    .catch(err => {
      document.getElementById('hasil-list').innerHTML = '<div class="alert alert-danger">Gagal memuat data dari server Flask.</div>';
    });
}

fetchKostData();
</script>

<?php
// ...existing code...
?>
