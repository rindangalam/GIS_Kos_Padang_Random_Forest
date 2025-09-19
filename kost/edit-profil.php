<?php
include 'template/header.php';

$username = $_SESSION['username'];
$data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
$d = mysqli_fetch_array($data);
?>

<style>
  body {
    background-color: rgb(222, 251, 232);

  }
  .edit-profil-modern-card {
    border-radius: 1.5rem;
    box-shadow: 0 8px 32px rgba(25,169,169,0.10);
    background: linear-gradient(135deg, #f1f5f9 60%, #e0e7ef 100%);
    padding: 2.5rem 2.5rem 2rem 2.5rem;
    border: 1px solid #e2e8f0;
    margin: 2rem auto;
    max-width: 600px;
  }
  .edit-profil-modern-title {
    font-size: 2rem;
    font-weight: 700;
    color: #1e293b;
    letter-spacing: 1px;
    margin-bottom: 1.5rem;
    text-align: center;
  }
  .form-label {
    font-weight: 600;
    color: #1e293b;
    margin-bottom: 0.3rem;
  }
  .form-control, .form-select {
    border-radius: 0.9rem !important;
    font-size: 1.08rem;
    border: 1px solid #e2e8f0;
    background: #f8fafc;
    transition: border-color 0.2s, box-shadow 0.2s;
  }
  .form-control:focus, .form-select:focus {
    border-color: #00b894;
    box-shadow: 0 0 0 0.15rem rgba(0,184,148,0.13);
    background: #fff;
  }
  .btn-ubah-modern {
    background: #00b894;
    color: #fff;
    border-radius: 25px;
    font-weight: bold;
    font-size: 1.1rem;
    padding: 12px 48px;
    border: none;
    box-shadow: 0 4px 16px 0 rgba(25,169,169,0.18);
    transition: background 0.3s, transform 0.2s;
    margin-top: 1.5rem;
  }
  .btn-ubah-modern:hover, .btn-ubah-modern:focus {
    background: #00997a;
    color: #fff;
    transform: scale(1.04);
  }
  .edit-profil-foto-preview {
    border-radius: 1rem;
    box-shadow: 0 2px 12px rgba(25,169,169,0.10);
    margin-bottom: 1rem;
    background: #e0e7ef;
    object-fit: cover;
    width: 90px;
    height: 90px;
    display: block;
  }
</style>

<div class="container my-5">
  <div class="edit-profil-modern-card">
    <div class="edit-profil-modern-title">
      <i class="bi bi-person-circle" style="color:#00b894"></i> Ubah Data Profil
    </div>
    <form action="php/edit-profil_proses.php" method="post" enctype="multipart/form-data">
      <div class="mb-3">
        <label class="form-label" for="username">Username</label>
        <input class="form-control" type="text" name="username" id="username" value="<?php echo $username ?>" readonly>
      </div>
      <div class="mb-3">
        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" value="<?php echo $d['nama_lengkap']; ?>">
      </div>
      <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo $d['email']; ?>">
      </div>
      <div class="mb-3">
        <label for="pekerjaan" class="form-label">Pekerjaan</label>
        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" value="<?php echo $d['pekerjaan']; ?>">
      </div>
      <div class="mb-3">
        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
        <select required name="jenis_kelamin" id="jenis_kelamin" class="form-select">
          <option selected hidden value="<?php echo $d['jenis_kelamin']; ?>"><?php echo $d['jenis_kelamin']; ?></option>
          <option value="laki-laki">Laki-laki</option>
          <option value="perempuan">Perempuan</option>
        </select>
      </div>
      <div class="mb-3">
        <label for="no_hp" class="form-label">Nomer Handphone/Telepon</label>
        <input type="number" name="no_hp" id="no_hp" class="form-control" value="<?php echo $d['no_hp']; ?>">
      </div>
      <div class="mb-3">
        <label for="foto_profil" class="form-label">Ubah Foto Profil</label>
        <?php if ($d['foto_profil']) { ?>
          <img src="../img/profil/<?php echo $d['foto_profil']; ?>" alt="Foto Profil" class="edit-profil-foto-preview mb-2">
        <?php } ?>
        <input type="file" name="foto_profil" id="foto_profil" class="form-control">
      </div>
      <div class="text-center">
        <button type="submit" value="submit" class="btn btn-ubah-modern" name="submit">
          <i class="bi bi-save"></i> Ubah Data
        </button>
      </div>
    </form>
  </div>
</div>

<?php
include 'template/footer.php';
?>