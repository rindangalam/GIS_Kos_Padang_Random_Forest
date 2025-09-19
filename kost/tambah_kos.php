<?php
include('template/header.php');
?>


<!--Main Content -->
<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <form class="shadow-lg rounded-4 p-4 bg-white" action="php/tambah-kos_proses.php" method="post" enctype="multipart/form-data" style="border:1.5px solid #b2ebeb;">
        <div class="text-center mb-4">
          <div style="font-size:2.2rem;color:#19a9a9;font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-home" style="margin-right:8px;color:#00b894;"></i>Tambah Kost
          </div>
          <div style="color:#1565c0;font-size:1.1rem;">Lengkapi data kost Anda dengan detail dan foto terbaik!</div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Info Kost</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="nama_kost" class="form-label">Nama Kost</label>
            <input type="text" name="nama_kost" id="nama_kost" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="kontak" class="form-label">Nomer Telepon/HP</label>
            <input type="text" name="kontak" id="kontak" class="form-control">
          </div>
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat Kost</label>
          <textarea class="form-control" name="alamat" id="alamat" rows="2" placeholder="Masukan alamat kost anda" required></textarea>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="latitude" class="form-label">Latitude</label>
            <input type="text" name="latitude" id="latitude" class="form-control" required>
          </div>
          <div class="col-md-6">
            <label for="longitude" class="form-label">Longitude</label>
            <input type="text" name="longitude" id="longitude" class="form-control" required>
          </div>
          <div class="col-12 mt-2 d-flex flex-column flex-md-row align-items-stretch" style="gap: 0.5rem 0.5rem;">
            <button type="button" class="btn btn-outline-primary w-100 w-md-auto mb-2 mb-md-0 me-md-2" style="min-width:0;" onclick="getLocation()">
              <i class="fa fa-map-marker-alt me-1"></i> Ambil Lokasi Saya
            </button>
            <button type="button" class="btn btn-outline-success w-100 w-md-auto" style="min-width:0;" onclick="openMapModal()">
              <i class="fa fa-map me-1"></i> Pilih dari Peta
            </button>
            <div id="lokasi-alert" style="font-size:0.98rem;color:#1565c0;margin-top:6px;display:none;"></div>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <input list="daftar-kecamatan" name="kecamatan" id="kecamatan" class="form-control" placeholder="Ketik atau pilih kecamatan...">
            <datalist id="daftar-kecamatan">
              <option value="Padang Barat">
              <option value="Padang Timur">
              <option value="Padang Utara">
              <option value="Kuranji">
              <option value="Pauh">
              <option value="Lubuk Begalung">
              <option value="Lubuk Kilangan">
              <option value="Nanggalo">
              <option value="Koto Tangah">
              <option value="Bungus Teluk Kabung">
            </datalist>
          </div>
          <div class="col-md-6">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <input list="daftar-kelurahan" type="text" name="kelurahan" id="kelurahan" class="form-control" placeholder="Ketik atau pilih kelurahan...">
            <datalist id="daftar-kelurahan">
              <option value="Bungus Barat">
              <option value="Bungus Selatan">
              <option value="Bungus Timur">
              <option value="Teluk Kabung Selatan">
              <option value="Teluk Kabung Tengah">
              <option value="Teluk Kabung Utara">
              <option value="Aie Pacah">
              <option value="Balai Gadang">
              <option value="Batang Kabung Ganting">
              <option value="Batipuh Panjang">
              <option value="Bungo Pasang">
              <option value="Dadok Tunggul Hitam">
              <option value="Koto Panjang Ikua Koto">
              <option value="Koto Pulai">
              <option value="Sungai Bangek">  
              <option value="Lubuk Buaya">
              <option value="Lubuk Minturun">
              <option value="Padang Sarai">
              <option value="Parupuk Tabing">
              <option value="Pasie Nan Tigo">
              <option value="Anduring">
              <option value="Pasar Ambacang">
              <option value="Lubuk Lintah">
              <option value="Ampang">
              <option value="Kalumbuk">
              <option value="Korong Gadang">
              <option value="Kuranji">
              <option value="Gunung Sarik">
              <option value="Sungai Sapih">
              <option value="Gurun Laweh">
              <option value="Lubuk Begalung">
              <option value="Banuaran">
              <option value="Tanjung Aur">
              <option value="Batang Taba">
              <option value="Parak Laweh Pulau Air">
              <option value="Bandar Buat">
              <option value="Koto Lalang">
              <option value="Padang Besi">
              <option value="Tarantang">
              <option value="Beringin">
              <option value="Batu Gadang">
              <option value="Indarung">
              <option value="Kampung Lapai">
              <option value="Kampung Olo">
              <option value="Tabing Banda Gadang">
              <option value="Gurun Lawas">
              <option value="Surau Gadang">
              <option value="Kurao Pagang">
              <option value="Rimbo Kaluang">
              <option value="Kampung Jao">
              <option value="Padang Pasir">
              <option value="Flamboyan">
              <option value="Ujung Gurun">
              <option value="Purus">
              <option value="Olo">
              <option value="Belakang Tangsi">
              <option value="Kampung Pondok">
              <option value="Berok Nipah">
              <option value="Air Manis">
              <option value="Alang Laweh">
              <option value="Batang Arau">
              <option value="Belakang Pondok">
              <option value="Bukit Gado-gado">
              <option value="Mata Air">
              <option value="Pasa Gadang">
              <option value="Ranah Parak Rumbio">
              <option value="Rawang">
              <option value="Seberang Padang">
              <option value="Seberang Palinggam">
              <option value="Teluk Bayur">
              <option value="Padang Timur">
              <option value="Andalas">
              <option value="Ganting Parak Gadang">
              <option value="Jati">
              <option value="Jati Baru">
              <option value="Kubu Dalam Parak Karakah">
              <option value="Kubu Marapalam">
              <option value="Parak Gadang Timur">
              <option value="Sawahan">
              <option value="Sawahan Timur">
              <option value="Simpang Haru">
              <option value="Air Tawar Barat">
              <option value="Air Tawar Timur">
              <option value="Alai Parak Kopi">
              <option value="Gunung Pangilun">
              <option value="Lolong Belanti">
              <option value="Ulak Karang Selatan">
              <option value="Ulak Karang Utara">
              <option value="Binuang Kampung Dalam">
              <option value="Cupak Tengah">
              <option value="Kapalo Koto">
              <option value="Koto Lua">
              <option value="Lambung Bukik">
              <option value="Limau Manis">
              <option value="Limau Manis Selatan">
              <option value="Piai Tengah">
              <option value="Pisang">
            </datalist>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-12">
            <label for="kampus" class="form-label">Pilih Kampus Terdekat</label>
            <input list="daftar-kampus" name="kampus" id="kampus" class="form-control" placeholder="Ketik atau pilih kampus...">
            <datalist id="daftar-kampus">
              <option value="Universitas Andalas (Unand)">
              <option value="Universitas Negeri Padang (UNP)">
              <option value="Politeknik Negeri Padang">
              <option value="Poltekkes Kemenkes Padang">
              <option value="UIN Imam Bonjol Padang Kampus 1">
              <option value="UIN Imam Bonjol Padang Kampus 2">
              <option value="UIN Imam Bonjol Padang Kampus 3">
              <option value="Universitas Bung Hatta">
              <option value="Universitas Muhammadiyah Sumatera Barat">
              <option value="Universitas Ekasakti">
              <option value="Universitas Tamansiswa Padang">
              <option value="Universitas Dharma Andalas">
              <option value="Universitas Baiturrahmah">
              <option value="Universitas Putra Indonesia YPTK">
              <option value="Universitas Alifah">
              <option value="Universitas Adzkia">
              <option value="Institut Teknologi Padang (ITP)">
              <option value="STMIK Indonesia Padang">
              <option value="STKIP PGRI Sumatera Barat">
              <option value="STIE KBP">
              <option value="STIE Dharma Andalas">
              <option value="STIH Prayoga">
              <option value="STIKes Alifah">
              <option value="STIFI Padang">
              <option value="STISIP Imam Bonjol">
              <option value="STTIND Padang">
            </datalist>
          </div>
        </div>
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi Kost (opsional)</label>
          <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2" placeholder="Deskripsi singkat"></textarea>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Fasilitas Kost</h6>
        <div class="row mb-3">
          <div class="col">
            <div class="d-flex flex-wrap gap-3">
              <?php
                $fasilitas = [
                  ["icon" => "fa-car", "label" => "Parkir Mobil"],
                  ["icon" => "fa-wifi", "label" => "WIFI/Internet"],
                  ["icon" => "fa-shield-alt", "label" => "Security"],
                  ["icon" => "fa-couch", "label" => "Ruang Tamu"],
                  ["icon" => "fa-dumbbell", "label" => "Ruang Fitness"],
                  ["icon" => "fa-utensils", "label" => "Ruang Makan"],
                  ["icon" => "fa-fire", "label" => "Dapur"],
                  ["icon" => "fa-tshirt", "label" => "Laundry"],
                  ["icon" => "fa-mosque", "label" => "Musholla"],
                ];
                foreach ($fasilitas as $i => $f) {
                  echo '<div class="form-check me-3 mb-2" style="min-width: 160px;">
                          <input class="form-check-input" type="checkbox" name="fasilitas[]" value="'.$f['label'].'" id="f'.$i.'">
                          <label class="form-check-label" for="f'.$i.'" style="font-weight:500;">
                            <i class="fa '.$f['icon'].' me-1" style="color:#19a9a9;"></i> '.$f['label'].'
                          </label>
                        </div>';
                }
              ?>
            </div>
          </div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Info Pembayaran</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="tanggal_tagih" class="form-label">Ditagih setiap tanggal</label>
            <select class="form-control" name="tanggal_tagih" id="tanggal_tagih" required>
              <option value="">Pilih tanggal...</option>
              <?php for($i=1;$i<=31;$i++): ?>
                <option value="<?= $i ?>"><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="nama_pemilik" class="form-label">Nama Pemilik Kost</label>
            <input class="form-control" type="text" name="nama_pemilik" id="nama_pemilik">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="nama_bank" class="form-label">Nama Bank</label>
            <input list="daftar-bank" class="form-control" type="text" name="nama_bank" id="nama_bank" placeholder="Ketik atau pilih bank...">
            <datalist id="daftar-bank">
              <option value="Bank Mandiri">
              <option value="Bank BRI">
              <option value="Bank BNI">
              <option value="Bank Syariah Indonesia">
              <option value="Bank Nagari">
              <option value="Bank CIMB Niaga">
              <option value="Bank Danamon">
              <option value="Bank Permata">
              <option value="Bank BTN">
              <option value="Bank Mega">
              <option value="Bank Panin">
              <option value="Bank OCBC NISP">
              <option value="Bank Maybank">
              <option value="Bank Sinarmas">
              <option value="Bank Bukopin">
            </datalist>
          </div>
          <div class="col-md-6">
            <label for="no_rekening" class="form-label">Nomor Rekening</label>
            <input type="number" name="no_rekening" id="no_rekening" class="form-control">
          </div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Foto Bangunan</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="bangunan_utama" class="form-label">Foto bangunan Utama</label>
            <input type="file" name="foto_bangunan_utama" id="bangunan_utama" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="foto_kamar" class="form-label">Foto Kamar</label>
            <input type="file" name="foto_kamar" id="foto_kamar" class="form-control">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="foto_kamar_mandi" class="form-label">Foto Kamar Mandi</label>
            <input type="file" name="foto_kamar_mandi" id="foto_kamar_mandi" class="form-control">
          </div>
          <div class="col-md-6">
            <label for="foto_interior" class="form-label">Foto Interior Kamar</label>
            <input type="file" name="foto_interior" id="foto_interior" class="form-control">
          </div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Detail Kost</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="jenis_kost" class="form-label">Jenis Kost</label>
            <select name="jenis_kost" id="jenis_kost" class="form-select">
              <option value="Putra">Kost Putra</option>
              <option value="Putri">Kost Putri</option>
              <option value="Campuran">Kost Campuran</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="tipe_kost" class="form-label">Tipe Kost</label>
            <select name="tipe_kost" id="tipe_kost" class="form-select">
              <option value="Bulan">Perbulan</option>
              <option value="Tahun">Pertahun</option>
            </select>
          </div>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="harga_sewa" class="form-label">Harga Sewa</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input type="text" name="harga_sewa" id="harga_sewa" class="form-control">
            </div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill" name="tambah" style="font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-save me-2"></i> Simpan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Akhir Content -->

<?php
include('template/footer.php');
?>

<style>
body {
  background: #f8fafc;
}
form.bg-white {
  border: 1.5px solid #b2ebeb;
  box-shadow: 0 8px 32px 0 rgba(25,169,169,0.10);
  background: #fff;
}
.section-title {
  color: #1565c0;
  font-weight: bold;
  letter-spacing: 0.5px;
  font-size: 1.08rem;
}
input[type="text"], input[type="number"], input[type="date"], textarea, select, .form-select {
  border-radius: 12px !important;
  border: 1.5px solid #b2ebeb !important;
  background: #f8fafc;
  font-size: 1rem;
}
input[list], input[list]:focus {
  border-radius: 12px !important;
  border: 1.5px solid #b2ebeb !important;
  background: #f8fafc;
  font-size: 1rem;
  transition: border 0.2s, box-shadow 0.2s;
}
input[list]:focus {
  border-color: #19a9a9 !important;
  box-shadow: 0 0 0 2px #b2ebeb33;
  background: #fff;
}
input[type="file"], .form-control-file {
  border-radius: 8px !important;
  background: #f1f5f9;
  border: none;
  padding: 7px 0 7px 7px;
}
input[type="checkbox"] {
  accent-color: #19a9a9;
}
input:focus, textarea:focus, select:focus {
  border-color: #19a9a9 !important;
  box-shadow: 0 0 0 2px #b2ebeb33;
  background: #fff;
}
.btn-primary {
  background: linear-gradient(90deg,#19a9a9 0%,#00b894 100%);
  border: none;
  font-weight: bold;
  transition: background 0.3s, transform 0.2s;
}
.btn-primary:hover {
  background: linear-gradient(90deg,#00b894 0%,#19a9a9 100%);
  transform: scale(1.04);
}
input[type="file"]::-webkit-file-upload-button {
  background: #e0f7fa;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  color: #19a9a9;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}
input[type="file"]:hover::-webkit-file-upload-button {
  background: #b2ebeb;
}
input[type="file"]::file-selector-button {
  background: #e0f7fa;
  border: none;
  border-radius: 8px;
  padding: 6px 16px;
  color: #19a9a9;
  font-weight: bold;
  cursor: pointer;
  transition: background 0.2s;
}
input[type="file"]:hover::file-selector-button {
  background: #b2ebeb;
}
/* Tambahan agar fasilitas lebih jelas dan rapi */
.form-check-input[type="checkbox"] {
  accent-color: #19a9a9;
  width: 1.2em;
  height: 1.2em;
  margin-top: 0.15em;
}
.form-check-label {
  font-size: 1.05em;
  margin-left: 0.35em;
  vertical-align: middle;
}
.d-flex.flex-wrap.gap-3 {
  gap: 0.8rem 2.2rem !important;
}
</style>

<script>
function getLocation() {
  var latInput = document.getElementById('latitude');
  var lonInput = document.getElementById('longitude');
  var alertBox = document.getElementById('lokasi-alert');
  if (navigator.geolocation) {
    alertBox.style.display = 'block';
    alertBox.innerText = 'Mengambil lokasi...';
    navigator.geolocation.getCurrentPosition(function(position) {
      latInput.value = position.coords.latitude;
      lonInput.value = position.coords.longitude;
      alertBox.innerText = 'Lokasi berhasil diambil!';
      setTimeout(()=>{alertBox.style.display='none';}, 2000);
    }, function(error) {
      alertBox.innerText = 'Gagal mengambil lokasi: ' + error.message;
    });
  } else {
    alertBox.style.display = 'block';
    alertBox.innerText = 'Geolocation tidak didukung browser ini.';
  }
}
</script>

<!-- Modal Peta -->
<div class="modal" id="mapModal" tabindex="-1" style="display:none;position:fixed;z-index:9999;top:0;left:0;width:100vw;height:100vh;background:rgba(0,0,0,0.4);align-items:center;justify-content:center;">
  <div style="background:#fff;border-radius:12px;max-width:95vw;width:400px;max-height:90vh;padding:0;overflow:hidden;box-shadow:0 8px 32px 0 rgba(25,169,169,0.18);position:relative;">
    <div style="padding:12px 16px;border-bottom:1px solid #eee;display:flex;align-items:center;justify-content:space-between;">
      <span style="font-weight:bold;color:#19a9a9;">Pilih Lokasi di Peta</span>
      <button type="button" onclick="closeMapModal()" style="background:none;border:none;font-size:1.3rem;color:#888;">&times;</button>
    </div>
    <div id="leafletMap" style="width:100%;height:350px;"></div>
    <div style="padding:10px 16px;text-align:right;display:flex;gap:8px;justify-content:flex-end;">
      <button type="button" class="btn btn-sm btn-secondary" onclick="closeMapModal()">Tutup</button>
      <button type="button" class="btn btn-sm btn-primary" id="btnOkeMap" onclick="okeMapModal()" disabled>Oke</button>
    </div>
  </div>
</div>
<!-- End Modal Peta -->

<!-- Leaflet CSS & JS CDN -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
<script>
function openMapModal() {
  document.getElementById('mapModal').style.display = 'flex';
  setTimeout(() => {
    if (navigator.geolocation) {
      navigator.geolocation.getCurrentPosition(function(position) {
        initLeafletMap(position.coords.latitude, position.coords.longitude);
      }, function() {
        // Jika gagal, fallback ke Padang
        initLeafletMap(-0.9471, 100.4172);
      });
    } else {
      initLeafletMap(-0.9471, 100.4172);
    }
  }, 100);
}
let leafletMap, marker, lastLatLng;
function initLeafletMap(lat, lng) {
  if (!leafletMap) {
    leafletMap = L.map('leafletMap').setView([lat, lng], 15);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      attribution: '© OpenStreetMap'
    }).addTo(leafletMap);
    leafletMap.on('click', function(e) {
      if (marker) leafletMap.removeLayer(marker);
      marker = L.marker(e.latlng).addTo(leafletMap);
      lastLatLng = e.latlng;
      document.getElementById('btnOkeMap').disabled = false;
    });
  } else {
    leafletMap.setView([lat, lng], 15);
    leafletMap.invalidateSize();
    if (marker) {
      leafletMap.removeLayer(marker);
      marker = null;
    }
    lastLatLng = null;
    document.getElementById('btnOkeMap').disabled = true;
  }
}
function okeMapModal() {
  if (lastLatLng) {
    document.getElementById('latitude').value = lastLatLng.lat;
    document.getElementById('longitude').value = lastLatLng.lng;
    document.getElementById('lokasi-alert').style.display = 'block';
    document.getElementById('lokasi-alert').innerText = 'Lokasi diambil dari peta!';
    setTimeout(()=>{document.getElementById('lokasi-alert').style.display='none';}, 2000);
    closeMapModal();
  }
}
function closeMapModal() {
  document.getElementById('mapModal').style.display = 'none';
  // Hapus marker jika ada
  if (marker && leafletMap) {
    leafletMap.removeLayer(marker);
    marker = null;
  }
}
</script>