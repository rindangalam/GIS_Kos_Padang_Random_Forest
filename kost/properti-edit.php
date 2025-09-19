<?php
include 'template/header.php';

$id_kost = $_GET['id_kost'];
$query = "SELECT * FROM kost WHERE id_kost='$id_kost'";
$data_2 = mysqli_query($koneksi, $query);
$d = mysqli_fetch_array($data_2);
$o = explode(', ', $d['fasilitas_kost']);
?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-8 col-md-10">
      <form class="shadow-lg rounded-4 p-4 bg-white" action="php/properti-edit_proses.php?id_kost=<?php echo $d['id_kost']; ?>" method="post" enctype="multipart/form-data" style="border:1.5px solid #b2ebeb;">
        <div class="text-center mb-4">
          <div style="font-size:2.2rem;color:#19a9a9;font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-home" style="margin-right:8px;color:#00b894;"></i>Edit Kost
          </div>
          <div style="color:#1565c0;font-size:1.1rem;">Perbarui data kost Anda dengan detail dan foto terbaik!</div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Info Kost</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="nama_kost" class="form-label">Nama Kost</label>
            <input type="text" name="nama_kost" id="nama_kost" class="form-control" value="<?php echo $d['nama_kost'] ?>" required>
          </div>
          <div class="col-md-6">
            <label for="kontak" class="form-label">Nomer Telepon/HP</label>
            <input type="text" name="kontak" id="kontak" class="form-control" value="<?php echo $d['kontak'] ?>">
          </div>
        </div>
        <div class="mb-3">
          <label for="alamat" class="form-label">Alamat Kost</label>
          <textarea class="form-control" name="alamat" id="alamat" rows="2" required><?php echo $d['alamat'] ?></textarea>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="kecamatan" class="form-label">Kecamatan</label>
            <input type="text" name="kecamatan" id="kecamatan" class="form-control" value="<?php echo $d['kecamatan'] ?>">
          </div>
          <div class="col-md-6">
            <label for="kelurahan" class="form-label">Kelurahan</label>
            <input type="text" name="kelurahan" id="kelurahan" class="form-control" value="<?php echo $d['kelurahan'] ?>">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-12">
            <label for="kampus" class="form-label">Pilih Kampus Terdekat</label>
            <input list="daftar-kampus" name="kampus" id="kampus" class="form-control" value="<?php echo isset($d['kampus']) ? $d['kampus'] : '' ?>" placeholder="Ketik atau pilih kampus...">
            <datalist id="daftar-kampus">
              <option value="Universitas Adzkia">
              <option value="Universitas Andalas">
              <option value="Universitas Negeri Padang">
              <option value="Politeknik Negeri Padang">
              <option value="UPI YPTK Padang">
              <option value="Universitas Bung Hatta">
              <option value="Universitas Ekasakti">
              <option value="Universitas Putra Indonesia">
              <option value="Universitas Baiturrahmah">
              <option value="Universitas Dharma Andalas">
              <option value="Universitas Muhammadiyah Sumatera Barat">
            </datalist>
          </div>
        </div>
        <div class="mb-3">
          <label for="deskripsi" class="form-label">Deskripsi Kost (opsional)</label>
          <textarea class="form-control" name="deskripsi" id="deskripsi" rows="2"><?php echo $d['deskripsi'] ?></textarea>
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
                  $checked = in_array($f['label'], $o) ? 'checked' : '';
                  echo '<div class="form-check me-3 mb-2" style="min-width: 160px;">
                          <input class="form-check-input" type="checkbox" name="fasilitas[]" value="'.$f['label'].'" id="f'.$i.'" '.$checked.'>
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
                <option value="<?= $i ?>" <?= ($d['tanggal_tagih']==$i)?'selected':''; ?>><?= $i ?></option>
              <?php endfor; ?>
            </select>
          </div>
          <div class="col-md-6">
            <label for="nama_pemilik" class="form-label">Nama Pemilik Kost</label>
            <input class="form-control" type="text" name="nama_pemilik" id="nama_pemilik" value="<?php echo $d['nama_pemilik'] ?>">
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="nama_bank" class="form-label">Nama Bank</label>
            <input type="text" name="nama_bank" id="nama_bank" class="form-control" value="<?php echo $d['nama_bank'] ?>">
          </div>
          <div class="col-md-6">
            <label for="no_rekening" class="form-label">Nomor Rekening</label>
            <input type="number" name="no_rekening" id="no_rekening" class="form-control" value="<?php echo $d['no_rekening'] ?>">
          </div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Foto Bangunan</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="bangunan_utama" class="form-label">Foto bangunan Utama</label>
            <input type="file" name="foto_bangunan_utama" id="bangunan_utama" class="form-control">
            <small class="text-muted">Foto saat ini: <?php echo $d['foto_bangunan_utama'] ?></small>
          </div>
          <div class="col-md-6">
            <label for="foto_kamar" class="form-label">Foto Kamar</label>
            <input type="file" name="foto_kamar" id="foto_kamar" class="form-control">
            <small class="text-muted">Foto saat ini: <?php echo $d['foto_kamar'] ?></small>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="foto_kamar_mandi" class="form-label">Foto Kamar Mandi</label>
            <input type="file" name="foto_kamar_mandi" id="foto_kamar_mandi" class="form-control">
            <small class="text-muted">Foto saat ini: <?php echo $d['foto_kamar_mandi'] ?></small>
          </div>
          <div class="col-md-6">
            <label for="foto_interior" class="form-label">Foto Interior Kamar</label>
            <input type="file" name="foto_interior" id="foto_interior" class="form-control">
            <small class="text-muted">Foto saat ini: <?php echo $d['foto_interior'] ?></small>
          </div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Detail Kost</h6>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="jenis_kost" class="form-label">Jenis Kost</label>
            <select name="jenis_kost" id="jenis_kost" class="form-select">
              <option value="Putra" <?= ($d['jenis_kost']=='Putra')?'selected':''; ?>>Kost Putra</option>
              <option value="Putri" <?= ($d['jenis_kost']=='Putri')?'selected':''; ?>>Kost Putri</option>
              <option value="Campuran" <?= ($d['jenis_kost']=='Campuran')?'selected':''; ?>>Kost Campuran</option>
            </select>
          </div>
          <div class="col-md-6">
            <label for="tipe_kost" class="form-label">Tipe Kost</label>
            <select name="tipe_kost" id="tipe_kost" class="form-select">
              <option value="Bulan" <?= ($d['tipe_kost']=='Bulan')?'selected':''; ?>>Perbulan</option>
              <option value="Tahun" <?= ($d['tipe_kost']=='Tahun')?'selected':''; ?>>Pertahun</option>
            </select>
          </div>
        </div>
        <div class="row g-3 mb-4">
          <div class="col-md-6">
            <label for="harga_sewa" class="form-label">Harga Sewa</label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input type="text" name="harga_sewa" id="harga_sewa" class="form-control" value="<?php echo $d['harga_sewa'] ?>">
            </div>
          </div>
        </div>
        <div class="text-center">
          <button type="submit" class="btn btn-primary px-5 py-2 rounded-pill" name="ubah" style="font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-save me-2"></i> Simpan Perubahan
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<?php include 'template/footer.php'; ?>

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