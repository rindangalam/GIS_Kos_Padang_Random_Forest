<?php
include "template/navbar.php";
$scrollNavbar = true;
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


  .checked {
    color: #19a9a9;
  }
  .card-header, .card-footer {
    background: #b2ebeb;
    border-bottom: 1px solid #19a9a9;
    border-top: 1px solid #19a9a9;
  }
  body {
    background-color: rgb(255, 255, 255);
  }
  #hero-section {
    position: relative;
    overflow: hidden;
    z-index: 0 !important;
    height: 650px; 
    border-radius: 0;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    background: #e0f7fa;
    margin-top: 0px !important;
    width: 101.99%;
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
  .container {
    max-width: 100% !important;
    width: 100% !important;

  }
  .container2 {
    max-width: 98% !important;
    width: 98% !important;
    padding-left: 200px !important;
    padding-right: 100px !important;
  }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

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
</div>

    <!-- Tombol panah -->
    <button id="prev-slide" style="position:absolute; top:50%; left:10px; transform:translateY(-50%);
      background:rgba(0, 0, 0, 0.15); color:white; border:none; padding:10px; cursor:pointer; z-index:2;">
      &#10094;
    </button>
    <button id="next-slide" style="position:absolute; top:50%; right:10px; transform:translateY(-50%);
      background:rgba(0,0,0,0.15); color:white; border:none; padding:10px; cursor:pointer; z-index:2;">
      &#10095;
    </button>
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
<!-- Search -->
  <style>
   .filter-compact {
  display: flex;
  justify-content: center;
  gap: 10px;
  margin: 20px;
}

.filter-compact input {
  padding: 10px;
  width: 300px;
  border: 1px solid #ccc;
  border-radius: 8px;
}

.search-button {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  border-radius: 8px;
  cursor: pointer;
}



.form-group {
  margin: 10px;
  flex: 1;
}



/* Animation */
@keyframes fadeIn {
  from {opacity: 0;}
  to {opacity: 1;}
}
 .tags button {
    background: #f0f0f0;
    border: none;
    margin: 3px;
    padding: 8px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.9rem;
  }

  .form-group {
    flex: 1;
    margin: 0 8px 16px 0;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 12px;
    width: 90%;
    max-width: 800px;
    animation: fadeIn 0.3s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .close {
    float: right;
    font-size: 1.5rem;
    cursor: pointer;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 1rem;
    gap: 10px;
  }

  #searchModal .modal-content {
  background: #fff;
  margin: 4% auto;
  padding: 32px 28px 24px 28px;
  border-radius: 14px;
  width: 96%;
  max-width: 600px;
  box-shadow: 0 8px 32px 0 rgba(25,169,169,0.10), 0 2px 8px 0 rgba(0,0,0,0.04);
  border: 1px solid #e0f7fa;
}
#searchModal .close {
  float: right;
  font-size: 1.7rem;
  cursor: pointer;
  color: #19a9a9;
  font-weight: bold;
  margin-top: -8px;
  margin-right: -8px;
  background: none;
  border: none;
  transition: color 0.2s;
}
#searchModal h3 {
  color: #1565c0;
  font-size: 1.25rem;
  font-weight: bold;
  margin-bottom: 1.2rem;
  text-align: center;
  letter-spacing: 0.5px;
}
#searchModal h4 {
  color: #19a9a9;
  font-size: 0.85rem; /* lebih kecil lagi */
  font-weight: 600;
  margin-bottom: 0.2rem;
}
#searchModal .tags {
  display: flex;
  flex-wrap: wrap;
  gap: 8px;
  margin-bottom: 12px;
}
#searchModal .tags button {
  background: #f7fafd;
  border: 1px solid #e0f7fa;
  margin: 0;
  padding: 3px 9px; /* lebih kecil lagi */
  border-radius: 12px;
  cursor: pointer;
  font-size: 0.78rem; /* lebih kecil lagi */
  color: #1565c0;
  font-weight: 500;
  box-shadow: none;
  transition: background 0.2s, color 0.2s, border 0.2s;
}
#searchModal .tags button:hover {
  background: #19a9a9;
  color: #fff;
  border: 1px solid #19a9a9;
}
#searchModal .form-group {
  flex: 1;
  margin: 0 8px 16px 0;
  min-width: 160px;
}
#searchModal .form-control {
  width: 100%;
  padding: 8px; /* lebih kecil */
  border-radius: 7px;
  border: 1px solid #e0f7fa;
  font-size: 0.92rem; /* lebih kecil */
  background: #f7fafd;
  color: #222;
  margin-bottom: 0;
  transition: border 0.2s;
}
#searchModal label {
  font-size: 0.89rem; /* lebih kecil */
  color: #1565c0;
  font-weight: 500;
  margin-bottom: 4px;
}
#searchModal .search-row {
  text-align: right;
  margin-top: 20px;
}
#searchModal .search-button {
  padding: 10px 28px;
  background: #19a9a9;
  color: #fff;
  border: none;
  border-radius: 14px;
  cursor: pointer;
  font-size: 1.05rem;
  font-weight: bold;
  box-shadow: 0 2px 8px rgba(25,169,169,0.10);
  transition: background 0.2s, box-shadow 0.2s;
}
#searchModal .search-button:hover {
  background: #1565c0;
}
@media (max-width: 700px) {
  #searchModal .modal-content {
    padding: 14px 2vw 10px 2vw;
    border-radius: 8px;
  }
  #searchModal h3 { font-size: 1.05rem; }
}
  </style>
<!-- Basic Search Bar -->
<!-- Basic Search Bar -->
<form class="filter-compact" onsubmit="openSearchModal(); return false;">
  <input type="text" name="keyword" placeholder="Cari kos di Kota Padang..." readonly />
  <button type="button" class="search-button" onclick="openSearchModal()">SEARCH</button>

</form>

<!-- Full Filter Modal -->
<div id="searchModal" class="modal">
  <div class="modal-content">
    <span class="close" onclick="closeSearchModal()">&times;</span>
    <h3 style="margin-bottom: 1rem">🔍Pencarian dengan Random Forest</h3>

    <!-- Top Popular Rows -->
    <div class="row">
      <div style="flex: 1">
        <h4>📍 Daerah Populer</h4>
        <div class="tags">
          <button type="button" onclick="setFilterValue('kecamatan', 'Padang Barat')">Padang Barat</button>
          <button type="button" onclick="setFilterValue('kecamatan', 'Padang Utara')">Padang Utara</button>
          <button type="button" onclick="setFilterValue('kecamatan', 'Kuranji')">Kuranji</button>
          <button type="button" onclick="setFilterValue('kecamatan', 'Pauh')">Pauh</button>
        </div>
      </div>
      <div style="flex: 1">
        <h4>🎓 Kampus Populer</h4>
        <div class="tags">
          <button type="button" onclick="setFilterValue('kampus', 'Universitas Andalas')">UNAND</button>
          <button type="button" onclick="setFilterValue('kampus', 'Politeknik Negeri Padang')">Politeknik Negeri Padang</button>
          <button type="button" onclick="setFilterValue('kampus', 'UPI YPTK')">UPI YPTK</button>
          <button type="button" onclick="setFilterValue('kampus', 'Universitas Bung Hatta')">Universitas Bung Hatta</button>
        </div>
      </div>
    </div>

    <!-- Filter Fields -->
    <form id="searchForm" >
      <div class="row">
        <div class="form-group">
          <input type="text" name="keyword" placeholder="🔎 Kata kunci..." class="form-control" />
        </div>
        <div class="form-group">
          <select name="kecamatan" id="kecamatan" class="form-control">
            <option value="">Kecamatan</option>
            <option>Padang Barat</option>
            <option>Padang Timur</option>
            <option>Padang Utara</option>
            <option>Kuranji</option>
            <option>Pauh</option>
            <option>Lubuk Begalung</option>
            <option>Lubuk Kilangan</option>
            <option>Nanggalo</option>
            <option>Koto Tangah</option>
          </select>
        </div>
        <div class="form-group">
          <select name="kampus" id="kampus" class="form-control">
            <option value="">Kampus</option>
            <option>Universitas Andalas</option>
            <option>Politeknik Negeri Padang</option>
            <option>UPI YPTK</option>
            <option>Universitas Bung Hatta</option>
            <option>Universitas Ekasakti</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <select name="kategori" class="form-control">
            <option value="">Kategori Kos</option>
            <option>Putra</option>
            <option>Putri</option>
          </select>
        </div>
        <div class="form-group">
          <select name="tipe_kost" class="form-control">
            <option value=""> Tipe Kost</option>
            <option>Tahun</option>
            <option>Bulan</option>
          </select>
        </div>
      </div>

      <div class="row">
        <div class="form-group">
          <label>Harga Min</label>
          <input type="number" name="harga_min" placeholder="Rp 500000" class="form-control" />
        </div>
        <div class="form-group">
          <label>Harga Max</label>
          <input type="number" name="harga_max" placeholder="Rp 1500000" class="form-control" />
        </div>
      </div>

      <div class="row">
        <div class="form-group" style="flex: 1">
          <label>Fasilitas</label>
          <select name="fasilitas[]" multiple class="form-control" style="height: 100px;">
            <option>Parkir</option>
            <option>Wifi</option>
            <option>Security</option>
            <option>Ruang tamu</option>
            <option>Ruang fitnes</option>
            <option>Ruang makan</option>
            <option>Dapur</option>
            <option>Laundry</option>
            <option>Musholla</option>
          </select>
        </div>
      </div>

      <div class="search-row" style="text-align: right; margin-top: 20px;">
        <button type="submit" class="search-button" href="pencarian.php">🔍 CARI KOS</button>
      </div>
    </form>
  </div>
</div>

<script>
const PENCARIAN_API_URL = 'http://localhost:5000/api/pencarian';

document.getElementById("searchForm").addEventListener("submit", function(e) {
    e.preventDefault(); // mencegah reload

    const formData = new FormData(this);
    const params = new URLSearchParams();

    for (const [key, value] of formData.entries()) {
        if (value.trim() !== "") {
            if (key.endsWith('[]')) {
                params.append(key, value);
            } else {
                params.append(key, value.trim());
            }
        }
    }

    // Opsi: tambahkan limit & start
    params.append("start", 0);
    params.append("limit", 50);

    fetch(`${PENCARIAN_API_URL}?${params.toString()}`)
        .then(res => res.json())
        .then(res => {
            closeSearchModal(); // menutup modal otomatis
            if (res.status && res.jumlah > 0) {
                renderKostList(res.data);
                document.getElementById('pagination').innerHTML = ""; // hilangkan pagination karena hasil RF
            } else {
                document.getElementById('kost-list').innerHTML = '<p style="text-align:center;width:100%;font-size:1.1rem;color:#888;">Tidak ada kos rekomendasi sesuai pencarian.</p>';
            }
        })
        .catch(err => {
            console.error(err);
            document.getElementById('kost-list').innerHTML = '<div class="alert alert-danger">Gagal memuat data rekomendasi dari server Flask.</div>';
        });
});
</script>


<style>
  .tags button {
    background: #f0f0f0;
    border: none;
    margin: 3px;
    padding: 8px 12px;
    border-radius: 20px;
    cursor: pointer;
    font-size: 0.9rem;
  }

  .form-group {
    flex: 1;
    margin: 0 8px 16px 0;
  }

  .form-control {
    width: 100%;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 0.95rem;
  }

  .modal {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0, 0, 0, 0.5);
  }

  .modal-content {
    background-color: #fff;
    margin: 5% auto;
    padding: 20px;
    border-radius: 12px;
    width: 90%;
    max-width: 800px;
    animation: fadeIn 0.3s ease-in-out;
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .close {
    float: right;
    font-size: 1.5rem;
    cursor: pointer;
  }

  .row {
    display: flex;
    flex-wrap: wrap;
    margin-bottom: 1rem;
    gap: 10px;
  }

</style>
  
<script>
  function openSearchModal() {
    document.getElementById("searchModal").style.display = "block";
  }

  function closeSearchModal() {
    document.getElementById("searchModal").style.display = "none";
  }

  function setFilterValue(id, value) {
    const el = document.getElementById(id);
    if (el) el.value = value;
  }

  window.onclick = function(event) {
    const modal = document.getElementById("searchModal");
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }
</script>

<!-- end search -->



<?php
include "../php/koneksi.php";

//ambil harga fasilitas kamar terendah
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


  <!-- Konten lain tanpa card di sini -->
  <div class="row justify-content-start" style="margin-top:32px;">
  <?php
  // Query data kost (ganti sesuai kebutuhan)
  $data = mysqli_query($koneksi, "SELECT kost.*, user.foto_profil, user.nama_lengkap FROM kost JOIN user ON kost.id_pemilik=user.id ORDER BY RAND()");
  while ($d = mysqli_fetch_array($data)) :
  ?>
   
  <?php endwhile; ?>
  </div>

</div>
<?php
// PAGINATION SETUP
$jumlah_data_perhalaman = 20;
$jumlah_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kost JOIN user ON kost.id_pemilik=user.id"));
$jumlah_halaman = ceil($jumlah_data / $jumlah_data_perhalaman);
$halaman_aktif = isset($_GET['halaman']) ? (int)$_GET['halaman'] : 1;
$awalData = ($jumlah_data_perhalaman * $halaman_aktif) - $jumlah_data_perhalaman;
// Query data kost untuk halaman aktif
$data = mysqli_query($koneksi, "SELECT kost.*, user.foto_profil, user.nama_lengkap FROM kost JOIN user ON kost.id_pemilik=user.id ORDER BY kost.id_kost ASC LIMIT $awalData, $jumlah_data_perhalaman");
?>
<div class="container2">
  <div class="row justify-content-start" style="margin-top:32px;" id="kost-list">
    <!-- Data kost akan dimuat di sini oleh JavaScript -->
  </div>
  <div class="row justify-content-center mt-4 mb-5" id="pagination">
    <!-- Pagination akan dimuat di sini oleh JavaScript -->
  </div>
</div>

<script>
const API_URL = 'http://localhost:5000/api/kost';
const KOST_PER_PAGE = 20;
let kostData = [];
let currentPage = 1;
let totalData = 0;

function renderKostList(list) {
  const container = document.getElementById('kost-list');
  container.innerHTML = '';
  if (list.length === 0) {
    container.innerHTML = '<p style="text-align:center;width:100%;font-size:1.1rem;color:#888;">Tidak ada kos yang ditemukan.</p>';
    return;
  }
  list.forEach(d => {
    container.innerHTML += `
      <div class=\"kost-vertical-card mb-4\">
        <a href=\"tampilan-kost.php?id_kost=${d.id_kost}\" style=\"text-decoration:none;color:inherit;display:block;\">
          <div class=\"kost-vertical-img-wrap\" style=\"position:relative;\">
            <img src=\"https://picsum.photos/seed/${d.id_kost}-kamar/400/240\" alt=\"Kamar Kost\" class=\"kost-vertical-img\" style=\"border-radius:12px 12px 0 0;\">
            <img src=\"../img/profil/${d.foto_profil}\" class=\"kost-vertical-avatar\" alt=\"avatar\">

            <div class=\"kost-vertical-type kost-type-${d.jenis_kost.toLowerCase()}\">
              ${d.jenis_kost}
            </div>
          </div>
          <div class=\"kost-vertical-body\">
            <h5 class=\"kost-vertical-title\">${d.nama_kost}</h5>
            <div class=\"kost-vertical-location\">
              <i class=\"fas fa-map-marker-alt\"></i> ${d.kecamatan}, ${d.kelurahan}
            </div>
            <div class=\"kost-vertical-owner\">
              <i class=\"fas fa-user\"></i> ${d.nama_lengkap}
            </div>
            <div class=\"kost-vertical-footer\">
              <span class=\"kost-vertical-price\">
                Rp ${Number(d.harga_sewa).toLocaleString('id-ID')} / ${d.tipe_kost}
              </span>
              <span class=\"kost-vertical-room\">
                <i class=\"fas fa-door-open\"></i> ${d.jumlah_kamar} Kamar
              </span>
            </div>
          </div>
        </a>
      </div>
    `;
  });
}

function renderPagination() {
  const totalPages = Math.ceil(totalData / KOST_PER_PAGE);
  const container = document.getElementById('pagination');
  if (totalPages <= 1) { container.innerHTML = ''; return; }
  let html = '<nav aria-label="Page navigation"><ul class="pagination pagination-lg justify-content-center">';
  // Previous button
  html += `<li class="page-item${currentPage === 1 ? ' disabled' : ''}"><a class="page-link" href="#" onclick="goToPage(${currentPage-1});return false;">&laquo;</a></li>`;
  // Page numbers (max 7, with ellipsis)
  let startPage = Math.max(1, currentPage - 2);
  let endPage = Math.min(totalPages, currentPage + 2);
  if (currentPage <= 3) endPage = Math.min(5, totalPages);
  if (currentPage >= totalPages - 2) startPage = Math.max(1, totalPages - 4);
  if (startPage > 1) html += `<li class="page-item"><a class="page-link" href="#" onclick="goToPage(1);return false;">1</a></li>`;
  if (startPage > 2) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
  for (let i = startPage; i <= endPage; i++) {
    html += `<li class="page-item${i === currentPage ? ' active' : ''}"><a class="page-link" href="#" onclick="goToPage(${i});return false;">${i}</a></li>`;
  }
  if (endPage < totalPages - 1) html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
  if (endPage < totalPages) html += `<li class="page-item"><a class="page-link" href="#" onclick="goToPage(${totalPages});return false;">${totalPages}</a></li>`;
  // Next button
  html += `<li class="page-item${currentPage === totalPages ? ' disabled' : ''}"><a class="page-link" href="#" onclick="goToPage(${currentPage+1});return false;">&raquo;</a></li>`;
  html += '</ul></nav>';
  container.innerHTML = html;
}

// Tambahkan CSS agar pagination lebih rapi dan responsif
document.head.insertAdjacentHTML('beforeend', `
<style>
.pagination-lg .page-link { min-width: 44px; text-align: center; font-size: 1.15rem; border-radius: 8px; margin: 0 2px; }
.pagination-lg .page-item.active .page-link { background: #19a9a9; color: #fff; border-color: #19a9a9; font-weight: bold; }
.pagination-lg .page-item.disabled .page-link { color: #bbb; background: #f7fafd; border-color: #e0f7fa; }
.pagination-lg .page-link:hover { background: #e0f7fa; color: #19a9a9; }
@media (max-width: 700px) {
  .pagination-lg .page-link { font-size: 1rem; min-width: 32px; padding: 6px 8px; }
}
</style>
`);

function goToPage(page) {
  currentPage = page;
  fetchKostData();
  window.scrollTo({top: 0, behavior: 'smooth'});
}

function fetchKostData() {
  const start = (currentPage - 1) * KOST_PER_PAGE;
  fetch(`${API_URL}?start=${start}&limit=${KOST_PER_PAGE}`)
    .then(res => res.json())
    .then(data => {
      kostData = data;
      totalData = data.length < KOST_PER_PAGE && currentPage === 1 ? data.length : 1000; // fallback jika backend belum support total
      renderKostList(kostData);
      renderPagination();
    })
    .catch(err => {
      document.getElementById('kost-list').innerHTML = '<div class="alert alert-danger">Gagal memuat data dari server Flask.</div>';
    });
}

fetchKostData();
</script>


<style>
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
    .kost-vertical-card { width: 98%; min-width: 0; max-width: 100%; }
    .kost-vertical-img-wrap { height: 80px; }
    .kost-vertical-body { padding: 8px 4px 6px 4px; }
  }
  </style>

<?php
include "template/footer2.php";
?>