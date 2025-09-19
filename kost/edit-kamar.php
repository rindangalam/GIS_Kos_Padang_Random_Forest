<?php
include "template/header.php";
$kamar = $_GET['id_kamar'];
$query = mysqli_query($koneksi, "SELECT * FROM kamar WHERE id_kamar=$kamar");
$d = mysqli_fetch_array($query);
$o = explode(', ', $d['fasilitas_kamar']);
?>

<div class="container py-4">
  <div class="row justify-content-center">
    <div class="col-lg-7 col-md-10">
      <form class="shadow-lg rounded-4 p-4 bg-white" action="php/kamar_proses.php?id_kamar=<?php echo $kamar ?>" method="post" style="border:1.5px solid #b2ebeb;">
        <div class="text-center mb-4">
          <div style="font-size:2rem;color:#19a9a9;font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-bed" style="margin-right:8px;color:#00b894;"></i>Ubah Data Kamar
          </div>
          <div style="color:#1565c0;font-size:1.05rem;">Edit detail kamar kost Anda dengan fasilitas terbaik!</div>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Info Kamar</h6>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="jumlah_kamar" class="form-label">Jumlah Kamar</label>
            <input min="0" type="number" name="jumlah_kamar" id="jumlah_kamar" class="form-control" value="<?php echo $d['jumlah_kamar'] ?>" required>
          </div>
          <div class="col-md-6">
            <label for="biaya_fasilitas" class="form-label">Biaya Fasilitas Kamar <span style="font-size:0.9em;color:#888;">(per bulan)</span></label>
            <div class="input-group">
              <span class="input-group-text">Rp.</span>
              <input type="number" name="biaya_fasilitas" id="biaya_fasilitas" class="form-control" value="<?php echo $d['biaya_fasilitas'] ?>" placeholder="0">
            </div>
            <div class="form-text">Biaya fasilitas akan ditambahkan ke harga sewa sebagai biaya tambahan.</div>
          </div>
        </div>
        <div class="row g-3 mb-3">
          <div class="col-md-6">
            <label for="panjang_kamar" class="form-label">Panjang Kamar (m)</label>
            <input type="number" name="panjang_kamar" id="panjang_kamar" class="form-control" step="0.01" value="<?php echo $d['panjang_kamar'] ?>" required>
          </div>
          <div class="col-md-6">
            <label for="lebar_kamar" class="form-label">Lebar Kamar (m)</label>
            <input type="number" name="lebar_kamar" id="lebar_kamar" class="form-control" step="0.01" value="<?php echo $d['lebar_kamar'] ?>" required>
          </div>
        </div>
        <div class="mb-3">
          <label for="tipe_kamar" class="form-label">Tipe Kamar</label>
          <select name="tipe_kamar" id="tipe_kamar" class="form-select" required>
            <option value="<?php echo $d['tipe_kamar'] ?>" selected><?php echo $d['tipe_kamar'] ?></option>
            <option value="kamar mandi dalam">Kamar Mandi Dalam</option>
            <option value="kamar mandi luar">Kamar Mandi Luar</option>
          </select>
        </div>
        <hr>
        <h6 class="mb-3 section-title">Fasilitas Kamar</h6>
        <div class="row mb-4">
          <div class="col">
            <div class="d-flex flex-wrap gap-3">
              <?php
                $fasilitas_kamar = [
                  ["icon" => "fa-snowflake", "label" => "AC"],
                  ["icon" => "fa-bed", "label" => "Tempat Tidur"],
                  ["icon" => "fa-archive", "label" => "Lemari"],
                  ["icon" => "fa-tv", "label" => "TV"],
                  ["icon" => "fa-ice-cream", "label" => "Kulkas"],
                  ["icon" => "fa-fan", "label" => "Kipas Angin"],
                ];
                foreach ($fasilitas_kamar as $i => $f) {
                  $checked = in_array($f['label'], $o) ? 'checked' : '';
                  echo '<div class="form-check me-3 mb-2" style="min-width: 140px;">
                          <input class="form-check-input" type="checkbox" name="fasilitas_kamar[]" value="'.$f['label'].'" id="fk'.$i.'" '.$checked.'>
                          <label class="form-check-label" for="fk'.$i.'" style="font-weight:500;">
                            <i class="fa '.$f['icon'].' me-1" style="color:#19a9a9;"></i> '.$f['label'].'
                          </label>
                        </div>';
                }
              ?>
            </div>
          </div>
        </div>
        <div class="text-center">
          <button name="ubah_kamar" type="submit" class="btn btn-primary px-5 py-2 rounded-pill" style="font-weight:bold;letter-spacing:1px;">
            <i class="fa fa-save me-2"></i> Simpan Kamar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<?php include "template/footer.php"; ?>

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
input[type="text"], input[type="number"], select, .form-select {
  border-radius: 12px !important;
  border: 1.5px solid #b2ebeb !important;
  background: #f8fafc;
  font-size: 1rem;
}
input:focus, select:focus {
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