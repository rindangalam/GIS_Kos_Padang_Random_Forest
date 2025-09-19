<?php 
include 'template/navbar2.php' ;
$scrollNavbar = true;
?>



<style>
  /* div {
    border: 1px solid red;
  }

  .card {
    background-color: aquamarine;
  } */
  .checked {
    color: gold;
  }

  h3 {
    color: black;
  }



  h6 {
    color: red;
    font-weight: bold;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 150%;
  }

  .tampilan-foto {
    max-height: 500px;

  }

  label {
    color: black;
    font-weight: bold;
  }

  #map {
            height: 500px;
            width: 100%;
        }

  /* .tampilan-foto img {} */
  .card {
    border-radius: 18px;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.10);
    border: 1.5px solid #b2ebeb;
    background: #fff;
    margin-top: 100px;
    margin-bottom: 32px;
    overflow: hidden;
  }
  .card-header {
    background: #fff;
    border-bottom: 1.5px solid #19a9a9;
    padding: 1.2rem 1.5rem 1rem 1.5rem;
    border-radius: 18px 18px 0 0;
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 0.7rem;
  }
  .card-header .row {
    width: 100%;
    margin: 0;
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 0.7rem;
  }
  .card-header img.rounded-circle {
    width: 56px;
    height: 56px;
    object-fit: cover;
    border: none;
    margin-right: 12px;
    background: #fff;
  }
  .card-header .nama-pemilik {
    font-weight: bold;
    color: #1565c0;
    font-size: 1.1rem;
    margin-right: 12px;
  }
  .card-header .btn-primary {
    font-size: 0.95rem;
    padding: 6px 18px;
    border-radius: 16px;
    margin-left: 0;
    margin-top: 0.2rem;
  }
  .carousel-inner.tampilan-foto, .carousel-inner img, .carousel-item img {
    width: 100% !important;
    height: 320px !important;
    max-height: 320px !important;
    min-height: 320px !important;
    object-fit: cover !important;
    border-radius: 16px;
    background: #e0f7fa;
    margin-left: 0;
    margin-right: 0;
    border: none;
    box-shadow: none;
    display: block;
  }
  .carousel-inner.tampilan-foto {
    padding-left: 0;
    padding-right: 0;
  }
  .carousel-item img {
    width: 100%;
    height: 320px !important;
    object-fit: cover !important;
    border-radius: 16px;
    background: #e0f7fa;
  }
  @media (max-width: 768px) {
    .card-header {
      padding: 0.7rem 0.7rem 0.7rem 0.7rem;
    }
    .carousel-inner.tampilan-foto, .carousel-inner img, .carousel-item img {
      height: 180px !important;
      max-height: 180px !important;
      min-height: 180px !important;
    }
    .card-header img.rounded-circle {
      width: 40px;
      height: 40px;
    }
  }
  .checked {
    color: #FFD700;
    font-size: 1.2rem;
  }
  .stars-active {
    display: inline-block;
    vertical-align: middle;
  }
  .card-body label {
    color: #1565c0;
    font-weight: bold;
    font-size: 1.08rem;
    margin-bottom: 0.2rem;
  }
  .card-body p {
    color: #333;
    font-size: 1.01rem;
    margin-bottom: 0.7rem;
  }
  .table {
    border-radius: 12px;
    overflow: hidden;
    background: #f8fafc;
    margin-top: 10px;
  }
  .table th {
    background: #19a9a9;
    color: #fff;
    font-weight: 600;
    border: none;
  }
  .table td {
    background: #f7fafd;
    color: #222;
    border: none;
  }
  .bg-light {
    background: #f8fafc !important;
    border-radius: 16px;
    box-shadow: 0 2px 8px rgba(25,169,169,0.07);
    margin-left: 12px;
    margin-top: 12px;
    padding: 24px 12px;
  }
  .row {
    margin-bottom: 0.5rem;
  }
  .carousel-control-prev-icon, .carousel-control-next-icon {
    background-color: #19a9a9;
    border-radius: 50%;
    padding: 8px;
  }
  .card-header .row, .card-body .row {
    margin-left: 0;
    margin-right: 0;
  }
  .card-header, .card-body, .card-footer {
    padding-left: 1.5rem;
    padding-right: 1.5rem;
  }
  .card-body .container, .card-body .container-fluid {
    padding-left: 0;
    padding-right: 0;
  }
  .card-body .row > .col, .card-body .row > .col-md-8, .card-body .row > .col-md-6 {
    padding-left: 0.5rem;
    padding-right: 0.5rem;
  }
  .card-body .row {
    margin-bottom: 0.7rem;
  }
  .table {
    margin-bottom: 0;
  }
  .bg-light {
    margin-left: 0;
    margin-top: 0;
    padding: 24px 12px;
    min-width: 260px;
  }
  .card {
    margin-bottom: 40px;
  }
  .carousel-inner {
    min-height: 220px;
  }
  @media (max-width: 991.98px) {
    .card-header, .card-body, .card-footer {
      padding-left: 0.7rem;
      padding-right: 0.7rem;
    }
    .bg-light {
      padding: 12px 2px;
    }
  }

  .img-popup-bg {
    display: none;
    position: fixed;
    z-index: 9999;
    left: 0; top: 0; width: 100vw; height: 100vh;
    background: rgba(0,0,0,0.7);
    align-items: center;
    justify-content: center;
  }
  .img-popup-bg.active {
    display: flex;
  }
  .img-popup-content {
    max-width: 90vw;
    max-height: 90vh;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 8px 32px 0 rgba(25,169,169,0.18);
    padding: 0;
    position: relative;
    display: flex;
    align-items: center;
    justify-content: center;
  }
  .img-popup-content img {
    max-width: 90vw;
    max-height: 80vh;
    border-radius: 12px;
    object-fit: contain;
    background: #fff;
  }
  .img-popup-close {
    position: absolute;
    top: 10px;
    right: 18px;
    font-size: 2rem;
    color: #19a9a9;
    background: none;
    border: none;
    cursor: pointer;
    z-index: 2;
    font-weight: bold;
  }
</style>

<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<?php
$id_kost = $_GET['id_kost'];
$locations = mysqli_query($koneksi, "SELECT * FROM kost");

$query = "SELECT * FROM kost JOIN user ON kost.id_pemilik=user.id WHERE id_kost=$id_kost";
$data = mysqli_query($koneksi, $query);
$d = mysqli_fetch_array($data);


$idkost = $d['id_kost'];
$queryx = "SELECT * FROM kamar WHERE id_kost=$idkost";
$kamar = mysqli_query($koneksi, $queryx);

//total harga sewa + fasilitas terendah
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

//fungsi untuk menentukan harga sewa di tabel
function fas($fas, $tipe_kost)
{
  if ($tipe_kost == "Bulan") {
    return $fas;
  } else if ($tipe_kost == "Tahun") {
    return $fas * 12;
  }
}

?>

<div class="container">
  <div class="container-fluid">
    <div class="card">
      <div class="card-header">
        <div class="row align-items-center mb-2">
          <div class="col-auto d-flex align-items-center">
            <img style="object-fit: cover;" src="../img/profil/<?php echo $d['foto_profil'] ?>" class="rounded-circle mr-3" alt="avatar">
            <span class="nama-pemilik"><?php echo $d['nama_lengkap'] ?></span>
          </div>
          <div class="col-auto">
            <button class="btn-primary"><?php echo $d['jenis_kost'] ?></button>
          </div>
        </div>
        <div class="row mb-2">
          <div class="col">
            <h2 style="color:#19a9a9;font-weight:bold;font-size:1.6rem;margin:0;line-height:1.2;letter-spacing:0.5px;">
              <?php echo $d['nama_kost'] ?>
            </h2>
            <?php if (!empty($d['kampus'])): ?>
            <div style="color:#1565c0;font-size:1.08rem;font-weight:500;margin-top:2px;">
              <i class="fa fa-university" style="margin-right:4px;color:#19a9a9;"></i> <?php echo $d['kampus']; ?>
            </div>
            <?php endif; ?>
          </div>
        </div>
        <div class="row mt-2">
          <div id="carouselExampleControls" class="carousel slide" data-ride="carousel" style="width:100%;margin:0 auto;">
            <div class="carousel-inner tampilan-foto" style="width:100%;margin:0;">
              <div class="carousel-item active">
                <img src="https://picsum.photos/seed/<?php echo $d['id_kost']; ?>-kamar/600/360" alt="Foto Kamar" class="img-clickable" onclick="showImgPopup(this)">
              </div>
              <div class="carousel-item">
                <img src="https://picsum.photos/seed/<?php echo $d['id_kost']; ?>-bangunan/600/360" alt="Bangunan Utama" class="img-clickable" onclick="showImgPopup(this)">
              </div>
              <div class="carousel-item">
                <img src="https://picsum.photos/seed/<?php echo $d['id_kost']; ?>-mandi/600/360" alt="Kamar Mandi" class="img-clickable" onclick="showImgPopup(this)">
              </div>
              <div class="carousel-item">
                <img src="https://picsum.photos/seed/<?php echo $d['id_kost']; ?>-interior/600/360" alt="Interior" class="img-clickable" onclick="showImgPopup(this)">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>
        </div>
      </div>
      <div class="card-body">
        <div class="row">
          <!-- sisi kiri  -->
          <div class="col-md-8">
            <div class="container-fluid">
              <div class="row">
                <div class="col"><i class="fas fa-map-marker-alt"></i>  <?php echo $d['kecamatan'] ?>,<?php echo $d['kelurahan'] ?></div>
              </div>
              <br>
              <div class="row">
                <div class="container">
                  <!-- <div class="row">
                    <div class="card-text"> -->
                  <!-- <p><i class="fas fa-fw fa-long-arrow-alt-right"></i> Lebar Kamar = <?php echo $d['lebar_kamar'] ?> m</p>
                      <p><i class="fas fa-fw fa-long-arrow-alt-up"></i> Panjang Kamar = <?php echo $d['panjang_kamar'] ?> m</p> -->
                  <!-- <p><i class="fas fa-fw fa-th-large"></i> Luas Kamar = <?php echo $d['panjang_kamar'] . "x" . $d['lebar_kamar'] ?> m</p> -->
                  <!-- </div>
                  </div -->


                  <div class="row">
                    <div class="card-title">
                      <label for="">Deskripsi Kost</label>
                      <p><?php echo $d['deskripsi'] ?></p>
                      <hr>
                    </div>
                  </div>
                  <div class="row">
                    <div class="card-title">
                      <label>Fasilitas Kost</label>
                      <p><?php echo $d['fasilitas_kost'] ?></p>
                    </div>
                  </div>
                  <div class="row">
                    <div class="card-title">
                      <label>Alamat
                        <i class="fas fa-map-marked-alt"></i></label>
                      <p>
                        <?php echo $d['alamat']; ?>
                      </p>
                    </div>

                   <div style="width:100%;height:350px;">
                      <?php if (!empty($d['latitude']) && !empty($d['longitude'])): ?>
                          <iframe
                              width="100%"
                              height="350"
                              style="border:0"
                              loading="lazy"
                              allowfullscreen
                              referrerpolicy="no-referrer-when-downgrade"
                              src="https://www.google.com/maps?q=<?php echo $d['latitude']; ?>,<?php echo $d['longitude']; ?>&hl=id&z=17&output=embed">
                          </iframe>
                      <?php else: ?>
                          <div class="alert alert-warning">Peta tidak tersedia karena data koordinat belum lengkap.</div>
                      <?php endif; ?>
                  </div>
                   
                    <!-- <div id="map">

                    </div> -->

                  </div>
                  <!-- kamar  -->

                  <?php
                  $cek = mysqli_num_rows($kamar);
                  if ($cek > 0) {


                    # code...

                  ?>
                    <div class="row">
                      <label>Info Kamar</label>
                    </div>
                    <div class="row">
                      <table class="table">
                        <thead class=" thead-dark">
                          <tr>
                            <!-- <th>Tipe</th> -->
                            <th>Tersedia</th>
                            <th>Tipe Kamar</th>
                            <th>Fasilitas Kamar</th>
                            <th>Harga Sewa</th>
                          </tr>
                        </thead>
                        <?php
                        // $fasilitas=implode(', ',$l['fasilitas_kamar']);
                        $i = 0;
                        while ($l = mysqli_fetch_array($kamar)) {
                          $i++;
                        ?>
                          <tbody>
                            <tr>
                              <!-- <td><?php
                                        // echo "A" . $i; 
                                        ?></td> -->
                              <td><?php if ($l['jumlah_kamar'] > 0) {
                                    echo $l['jumlah_kamar'];
                                  } else {
                                    echo "Penuh";
                                  }

                                  ?></td>
                              <td><?php echo $l['tipe_kamar'] ?></td>
                              <td><?php echo $l['fasilitas_kamar'] ?></td>
                              <td><?php echo number_format(fas($l['biaya_fasilitas'], $d['tipe_kost']) + $d['harga_sewa'], 0, ',', '.') . "/" . $d['tipe_kost'] ?></td>
                            </tr>
                          </tbody>
                        <?php }
                        ?>
                      </table>

                    </div>
                  <?php } ?>
                  <br>
                  <!-- tutup kamar  -->

                </div>
              </div>


            </div>

          </div>
          <!-- tutup sisi kiri -->

          <!-- sisi kanan  -->
          <div class="col bg-light py-lg-4 text-center">
            <div class="container">
              <div class="row">
                <h6>Rp. <?php echo number_format($d['harga_sewa'] + minfas($d['id_kost'], $d['tipe_kost']), 0, ',', '.'); ?> / <?php echo $d['tipe_kost'] ?></h6>
              </div>
              <hr>
              <div class="row">
                Pemillik Kost : <?php echo $d['nama_pemilik'] ?>
              </div>
              <div class="row">
                <?php
                if ($d['jumlah_kamar'] != 0) {
                  echo "Sisa Kamar : <b style='color:green'>" . $d['jumlah_kamar'] . "</b>";
                } else {
                  echo " <b style='color:red'>Kamar Tidak Tersedia</b>";
                }
                ?>
              </div>
              <div class="row">
                Kontak : <?php echo $d['kontak'] ?>
              </div>
              <div class="row">
                <div style="position:fixed;right:20px;bottom:20px;">
                  <a target="_blank" href="https://api.whatsapp.com/send?phone=<?php echo $d['kontak'] ?>&text=Assalamualaikum, apakah ini bapak/ibu yang mengiklan kost <?php echo $d['nama_kost'] ?> di website simkos ">
                    <button style="background:#f50251;vertical-align:center;height:36px;border-radius:5px">
                      <img src="https://web.whatsapp.com/img/favicon/1x/favicon.png"> Whatsapp Pemilik Kost</button></a>
                </div>
              </div>
            </div>
          </div>
          <!-- tutup sisi kiri -->

        </div>
        <div class="row">
          <?php
          $query3 = "SELECT * from user where username='$username'";
          $data3 = mysqli_query($koneksi, $query3);
          $n = mysqli_fetch_array($data3);
          if ($n['roles'] == 1 && $d['jumlah_kamar'] != 0) {
            # code...

          ?>
            <div class="col-md-2"><a href="booking.php?id_kost=<?php echo $d['id_kost'] ?>"><button class="btn-primary">Booking Kost</button></a></div>
            <div class="col-md-3"><a href="php/wishlist-proses.php?id_kost=<?php echo $d['id_kost'] ?>"><button class="btn-group">Masukan ke Wishlist</button></a></div>
          <?php
          }
          ?>
          <div class="col"></div>
        </div>
      </div>
      <div class="card-footer"></div>
    </div>
  </div>
</div>

<!-- <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
    // Ambil koordinat kost yang sedang dibuka
    var kostLat = <?php echo json_encode($d['latitude']); ?>;
    var kostLng = <?php echo json_encode($d['longitude']); ?>;
    var kostNama = <?php echo json_encode($d['nama_kost']); ?>;
    // Set view map ke lokasi kost
    var map = L.map('map').setView([kostLat, kostLng], 16);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    // Tampilkan marker hanya untuk kost ini
    L.marker([kostLat, kostLng])
        .bindPopup(kostNama)
        .addTo(map);
</script> -->

    <div id="imgPopup" class="img-popup-bg" onclick="closeImgPopup(event)">
      <div class="img-popup-content">
        <button class="img-popup-close" onclick="closeImgPopup(event)">&times;</button>
        <img id="imgPopupImg" src="" alt="Preview Gambar Kost" />
      </div>
    </div>
    <script>
      function showImgPopup(img) {
        var popup = document.getElementById('imgPopup');
        var popupImg = document.getElementById('imgPopupImg');
        popupImg.src = img.src;
        popup.classList.add('active');
      }
      function closeImgPopup(e) {
        if (e.target.classList.contains('img-popup-bg') || e.target.classList.contains('img-popup-close')) {
          document.getElementById('imgPopup').classList.remove('active');
        }
      }
    </script>

<?php
include 'template/footer.php' ?>