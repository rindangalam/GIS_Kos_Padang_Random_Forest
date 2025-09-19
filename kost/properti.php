<?php
include ('template/header.php');
?>
<?php
$jumlah_data_perhalaman = 10;
$jumlah_halaman = ceil($jumlah_data = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kost JOIN user ON kost.id_pemilik = user.id")) / $jumlah_data_perhalaman);
if (isset($_GET['halaman'])) {
  $halaman_aktif = $_GET['halaman'];
} else {
  $halaman_aktif = 1;
}
$awalData = ($jumlah_data_perhalaman * $halaman_aktif) - $jumlah_data_perhalaman;



$username = $_SESSION['username'];
$data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username' LIMIT $awalData,$jumlah_data_perhalaman");
$f = mysqli_fetch_array($data);
//mengambil id user
$id = $f['id'];
// tampilkan semua data kost milik user 
$query = "SELECT * FROM kost WHERE id_pemilik='$id'";
$data_2 = mysqli_query($koneksi, $query);

?>

<style>
  body {
    background-color: rgb(222, 251, 232);
  }
  .properti-card {
    background: #fff;
    border-radius: 1.2rem;
    box-shadow: 0 4px 24px rgba(25,169,169,0.10);
    padding: 2rem 1.5rem;
    margin-bottom: 2rem;
    border: 1px solid #e2e8f0;
  }
  .properti-table th {
    background: rgba(25, 169, 169, 0.85);
    color: #fff;
    font-weight: 600;
    border: none;
  }
  .properti-table td, .properti-table th {
    vertical-align: middle !important;
    font-size: 1.05rem;
  }
  .properti-table img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border-radius: 0.7rem;
    box-shadow: 0 2px 8px rgba(25,169,169,0.08);
  }
  .btn-primary, .btn-dark, .btn-danger, .btn-warning {
    border-radius: 20px !important;
    font-weight: 600;
    padding: 6px 18px;
    font-size: 1rem;
    border: none;
    transition: 0.2s;
    background: transparent !important; /* Hilangkan latar belakang */
    color: #19a9a9 !important;          /* Warna utama */
    box-shadow: none !important;
  }
  .btn-primary:hover, .btn-dark:hover, .btn-danger:hover, .btn-warning:hover,
  .btn-primary:focus, .btn-dark:focus, .btn-danger:focus, .btn-warning:focus {
    background: #19a9a9 !important;
    color: #fff !important;
    transform: scale(1.04);
  }
  .btn-tambah {
    background: rgba(25, 169, 169, 0.85);
    color: #fff;
    border-radius: 25px;
    font-weight: bold;
    font-size: 1rem;
    padding: 8px 28px;
    border: none;
    box-shadow: 0 4px 16px 0 rgba(25,169,169,0.12);
    transition: background 0.3s, transform 0.2s;
  }
  .btn-tambah:hover, .btn-tambah:focus {
    background: #159090;
    color: #fff;
    transform: scale(1.05);
  }
  .pagination-modern a {
    font-weight: bold;
    background: #fff;
    color: rgba(25, 169, 169, 0.85);
    border-radius: 10px;
    padding: 8px 18px;
    margin: 0 3px;
    border: 2px solid rgba(25, 169, 169, 0.15);
    text-decoration: none;
    transition: 0.2s;
    box-shadow: 0 2px 8px rgba(25,169,169,0.06);
    display: inline-block;
  }
  .pagination-modern a.active,
  .pagination-modern a:hover,
  .pagination-modern a:focus {
    background: rgba(25, 169, 169, 0.85);
    color: #fff;
    border-color: rgba(25, 169, 169, 0.85);
    transform: scale(1.08);
  }
</style>

<div class="container py-4">
  <div class="properti-card">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h3 class="mb-0" style="font-weight:700;color:#1e293b;">Daftar Kost Saya</h3>
      <a href="tambah_kos.php" class="btn btn-tambah">
        <i class="bi bi-plus-circle"></i> Tambah Kost
      </a>
    </div>
    <div class="table-responsive">
      <table class="table properti-table align-middle">
        <thead>
          <tr>
            <th>No</th>
            <th>Nama Kost</th>
            <th>Kapasitas</th>
            <th>Foto Kost</th>
            <th>Perintah</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $i = 0;
          while ($d = mysqli_fetch_array($data_2)) {
            $i++;
          ?>
            <tr>
              <td><?php echo $i  ?></td>
              <td>
                <a style="font-weight:bold;text-decoration: none;color:#1e293b" href="tampilan-kost.php?id_kost=<?php echo $d['id_kost']; ?>">
                  <?php echo $d['nama_kost'] ?>
                </a>
              </td>
              <td><?php echo $d['jumlah_kamar'] ?></td>
              <td>
                <img class="img-thumbnail" src="https://picsum.photos/seed/<?php echo $d['id_kost']; ?>-kamar/120/120" alt="Kamar Kost">
              </td>
              <td>
                <a href="penyewa.php?id_kost=<?php echo $d['id_kost']; ?>" class="btn btn-dark mb-1">Penyewa</a>
                <a href="properti-edit.php?id_kost=<?php echo $d['id_kost']; ?>" class="btn btn-primary mb-1">Edit</a>
                <a href="php/hapus.php?id_kost=<?php echo $d['id_kost']; ?>" class="btn btn-danger mb-1" onclick="return confirm('Yakin ingin menghapus kost ini?')">Hapus</a>
                <a href="daftar-kamar.php?id_kost=<?php echo $d['id_kost']; ?>" class="btn btn-warning mb-1">Kamar</a>
              </td>
            </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
    <div class="pagination-modern text-center mt-4">
      <?php for ($i = 1; $i <= $jumlah_halaman; $i++) : ?>
        <a href="?halaman=<?php echo $i ?>" class="<?php if ($i == $halaman_aktif) echo 'active'; ?>">
          <?php echo $i ?>
        </a>
      <?php endfor; ?>
    </div>
  </div>
</div>

<?php
include 'template/footer.php';
?>