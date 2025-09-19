<?php
include('template/header.php');
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
<style>
    .profile-modern-card {
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.10);
        background: linear-gradient(135deg, #f1f5f9 60%, #e0e7ef 100%);
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        position: relative;
        overflow: hidden;
        border: 1px solid #e2e8f0;
    }
    .profile-modern-img {
        width: 180px;         /* Ukuran diperbesar */
        height: 180px;        /* Ukuran diperbesar */
        object-fit: cover;
        border-radius: 50%;
        border: 5px solid #fff;
        box-shadow: 0 2px 12px rgba(0,0,0,0.08);
        margin-bottom: 1rem;
        background: #e0e7ef;
    }
    .profile-modern-header {
        margin-bottom: 1.5rem;
    }
    .profile-modern-name {
        font-size: 1.5rem;
        font-weight: 700;
        color: #1e293b;
    }
    .profile-modern-badge {
        font-size: 0.95rem;
        background: rgba(25, 169, 169, 0.85); /* Warna utama */
        color: #fff;
        border-radius: 0.5rem;
        padding: 0.3rem 1rem;
        margin-top: 0.5rem;
        display: inline-block;
        letter-spacing: 1px;
        box-shadow: 0 2px 8px rgba(25,169,169,0.10);
    }
    .profile-modern-info {
        background: #fff;
        border-radius: 1rem;
        padding: 1.5rem 1rem;
        margin-bottom: 1.5rem;
        box-shadow: 0 2px 8px rgba(25,169,169,0.06);
        border: 1px solid #e2e8f0;
    }
    .profile-modern-row {
        display: flex;
        align-items: center;
        margin-bottom: 1.1rem;
    }
    .profile-modern-icon {
        font-size: 1.3rem;
        color: rgba(25, 169, 169, 0.85); /* Warna utama */
        width: 2.2rem;
        text-align: center;
    }
    .profile-modern-label {
        color: #64748b;
        font-weight: 500;
        width: 7rem;
    }
    .profile-modern-value {
        color: #1e293b;
        font-weight: 600;
        flex: 1;
    }
    .profile-modern-edit {
        position: absolute;
        top: 1.5rem;
        right: 2rem;
        background: #fff;
        color: rgba(25, 169, 169, 0.85) !important;
        border: 2px solid rgba(25, 169, 169, 0.85);
        border-radius: 50px;
        transition: 0.2s;
    }
    .profile-modern-edit:hover, .profile-modern-edit:focus {
        background: rgba(25, 169, 169, 0.85);
        color: #fff !important;
        border-color: rgba(25, 169, 169, 0.85);
        transform: scale(1.08);
    }
    .profile-modern-edit i {
        color: inherit !important;
        transition: 0.2s;
    }
    .btn-ubah-data {
        background: rgba(25, 169, 169, 0.85);
        color: #fff;
        border-radius: 25px;
        font-weight: bold;
        border: none;
        padding: 10px 36px;
        font-size: 1.1rem;
        box-shadow: 0 4px 16px 0 rgba(25,169,169,0.18);
        transition: background 0.3s, color 0.3s, transform 0.2s;
    }
    .btn-ubah-data:hover, .btn-ubah-data:focus {
        background: #159090;
        color: #fff;
        transform: scale(1.04);
    }
    @media (max-width: 576px) {
        .profile-modern-card { padding: 1.2rem 0.5rem 1rem 0.5rem; }
        .profile-modern-img { width: 110px; height: 110px; }
    }
</style>
<style>
body {
    background-color: rgb(222, 251, 232); /* abu abu terang */
  
}
</style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<?php
$username = $_SESSION['username'];
$data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
$d = mysqli_fetch_array($data);
?>
<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="profile-modern-card position-relative">
                <!-- Hapus tombol edit di kanan atas -->
                <div class="text-center profile-modern-header">
                    <img class="profile-modern-img" src="../img/profil/<?php echo $d['foto_profil'] ?>" alt="Foto Profil">
                    <div class="profile-modern-name"><?php echo $d['nama_lengkap']; ?></div>
                    <span class="profile-modern-badge">
                        <i class="bi bi-person-fill"></i> <?php echo ucfirst($d['jenis_kelamin']); ?>
                    </span>
                </div>
                <div class="profile-modern-info">
                    <div class="profile-modern-row">
                        <span class="profile-modern-icon"><i class="bi bi-person-badge"></i></span>
                        <span class="profile-modern-label">Username</span>
                        <span class="profile-modern-value"><?php echo $_SESSION['username']; ?></span>
                    </div>
                    <div class="profile-modern-row">
                        <span class="profile-modern-icon"><i class="bi bi-envelope-at"></i></span>
                        <span class="profile-modern-label">Email</span>
                        <span class="profile-modern-value"><?php echo $d['email']; ?></span>
                    </div>
                    <div class="profile-modern-row">
                        <span class="profile-modern-icon"><i class="bi bi-briefcase"></i></span>
                        <span class="profile-modern-label">Pekerjaan</span>
                        <span class="profile-modern-value"><?php echo $d['pekerjaan']; ?></span>
                    </div>
                    <div class="profile-modern-row">
                        <span class="profile-modern-icon"><i class="bi bi-telephone"></i></span>
                        <span class="profile-modern-label">No. HP</span>
                        <span class="profile-modern-value"><?php echo $d['no_hp']; ?></span>
                    </div>
                </div>
                <div class="text-center mt-3">
                    <a href="edit-profil.php" class="btn btn-ubah-data">
                        <i class="bi bi-pencil"></i> Ubah Data
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include('template/footer.php');
?>