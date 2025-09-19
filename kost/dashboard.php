<?php
include "template/header.php";

// Ambil data user dari session
$username = $_SESSION['username'];
$user = mysqli_fetch_array(mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'"));
$role = $user['roles']; // 1 = penyewa, 2 = pemilik, 3 = admin

// Data statistik (contoh, sesuaikan query sesuai kebutuhan)
if ($role == 1) { // Penyewa
    $tagihan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan JOIN booking ON tagihan.no_booking=booking.id_booking WHERE booking.id_user='{$user['id']}'"));
    $kostku = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM booking WHERE id_user='{$user['id']}'"));
    $wishlist = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM wishlist WHERE id_user='{$user['id']}'"));
    // Tenant notifications: upcoming due (next 5 days) and overdue
    $tenant_id = $user['id'];
    $tenant_upcoming_q = mysqli_query($koneksi, "SELECT t.*, booking.id_user, user.nama_lengkap, kost.nama_kost, kost.id_kost FROM tagihan t JOIN booking ON t.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost JOIN user ON booking.id_user=user.id WHERE booking.id_user='$tenant_id' AND t.stats<>1 AND t.tanggal_tagihan BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY) ORDER BY t.tanggal_tagihan ASC");
    $tenant_upcoming_count = ($tenant_upcoming_q) ? mysqli_num_rows($tenant_upcoming_q) : 0;
    $tenant_overdue_q = mysqli_query($koneksi, "SELECT t.*, booking.id_user, user.nama_lengkap, kost.nama_kost, kost.id_kost, DATEDIFF(CURDATE(), t.tanggal_tagihan) AS days_overdue FROM tagihan t JOIN booking ON t.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost JOIN user ON booking.id_user=user.id WHERE booking.id_user='$tenant_id' AND t.stats<>1 AND t.tanggal_tagihan < CURDATE() ORDER BY t.tanggal_tagihan ASC");
    $tenant_overdue_count = ($tenant_overdue_q) ? mysqli_num_rows($tenant_overdue_q) : 0;
} elseif ($role == 2) { // Pemilik
    $kost = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kost WHERE id_pemilik='{$user['id']}'"));
    $penyewa = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE kamar.id_kost IN (SELECT id_kost FROM kost WHERE id_pemilik='{$user['id']}')"));
    $tagihan = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan JOIN booking ON tagihan.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE kamar.id_kost IN (SELECT id_kost FROM kost WHERE id_pemilik='{$user['id']}')"));
    // Tambahan statistik tagihan belum bayar dan pending
    $tagihan_belum_bayar = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan JOIN booking ON tagihan.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE kamar.id_kost IN (SELECT id_kost FROM kost WHERE id_pemilik='{$user['id']}') AND tagihan.stats=3"));
    $tagihan_pending = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan JOIN booking ON tagihan.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE kamar.id_kost IN (SELECT id_kost FROM kost WHERE id_pemilik='{$user['id']}') AND tagihan.stats=2"));
    // Owner notifications: upcoming due (next 5 days) and overdue
    $owner_id = $user['id'];
    $upcoming_q = mysqli_query($koneksi, "SELECT t.*, booking.id_user, user.nama_lengkap, kost.nama_kost, kost.id_kost FROM tagihan t JOIN booking ON t.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost JOIN user ON booking.id_user=user.id WHERE kost.id_pemilik='$owner_id' AND t.stats<>1 AND t.tanggal_tagihan BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY) ORDER BY t.tanggal_tagihan ASC");
    $upcoming_count = ($upcoming_q) ? mysqli_num_rows($upcoming_q) : 0;
    $overdue_q = mysqli_query($koneksi, "SELECT t.*, booking.id_user, user.nama_lengkap, kost.nama_kost, kost.id_kost, DATEDIFF(CURDATE(), t.tanggal_tagihan) AS days_overdue FROM tagihan t JOIN booking ON t.no_booking=booking.id_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost JOIN user ON booking.id_user=user.id WHERE kost.id_pemilik='$owner_id' AND t.stats<>1 AND t.tanggal_tagihan < CURDATE() ORDER BY t.tanggal_tagihan ASC");
    $overdue_count = ($overdue_q) ? mysqli_num_rows($overdue_q) : 0;
} elseif ($role == 3) { // Admin
    $kost = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM kost"));
    $user_count = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM user"));
    $transaksi = mysqli_num_rows(mysqli_query($koneksi, "SELECT * FROM tagihan"));
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
 <style>
  
    .dashboard-card {
        border-radius: 1.5rem;
        box-shadow: 0 8px 32px rgba(25,169,169,0.10);
        background: linear-gradient(135deg, #f1f5f9 60%, #e0e7ef 100%);
        padding: 2.5rem 2.5rem 2rem 2.5rem;
        border: 1px solid #e2e8f0;
        margin: 2rem auto;
        max-width: 1100px;
    }
    .dashboard-title {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        letter-spacing: 1px;
        margin-bottom: 1.5rem;
        text-align: center;
    }
    .dashboard-welcome {
        font-size: 1.2rem;
        color: #00b894;
        font-weight: 600;
        text-align: center;
        margin-bottom: 2rem;
    }
    .dashboard-stat {
        border-radius: 1.2rem;
        background: #f8fafc;
        box-shadow: 0 2px 8px rgba(25,169,169,0.06);
        border: 1px solid #e2e8f0;
        padding: 1.5rem 1rem;
        text-align: center;
        margin-bottom: 1.5rem;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .dashboard-stat:hover {
        box-shadow: 0 8px 32px rgba(25,169,169,0.13);
        transform: translateY(-4px) scale(1.03);
    }
    .dashboard-stat .icon {
        font-size: 2.2rem;
        margin-bottom: 0.7rem;
        color: #00b894;
    }
    .dashboard-stat .stat-value {
        font-size: 2rem;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 0.2rem;
    }
    .dashboard-stat .stat-label {
        font-size: 1.05rem;
        color: #64748b;
        font-weight: 500;
    }
    @media (max-width: 767px) {
        .dashboard-card { padding: 1.2rem 0.5rem; }
        .dashboard-title { font-size: 1.3rem; }
        .dashboard-stat .stat-value { font-size: 1.3rem; }
    }
</style>

<div class="container my-5">
    <div class="dashboard-card">
        <div class="dashboard-title">
            <i class="bi bi-speedometer2" style="color:#00b894"></i> Dashboard
        </div>
        <div class="dashboard-welcome" id="dashboard-greeting">
            <!-- Greeting will be set by JS -->
            Selamat datang, <b><?php echo $user['nama_lengkap']; ?></b>!<br>
            <?php
            if ($role == 1) echo "Anda login sebagai <span style='color:#00997a'>Penyewa</span>";
            elseif ($role == 2) echo "Anda login sebagai <span style='color:#00997a'>Pemilik Kost</span>";
            elseif ($role == 3) echo "Anda login sebagai <span style='color:#00997a'>Admin</span>";
            ?>
        </div>
        <div class="row g-4 justify-content-center">
            <?php if ($role == 1) { ?>
                <div class="col-md-4 col-12 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#e0f7fa 60%,#b2ebf2 100%);">
                        <div class="icon"><i class="bi bi-receipt" style="color:#00b894"></i></div>
                        <div class="stat-value"><?php echo $tagihan; ?></div>
                        <div class="stat-label">Tagihan</div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#f1f8e9 60%,#dcedc8 100%);">
                        <div class="icon"><i class="bi bi-house-heart" style="color:#388e3c"></i></div>
                        <div class="stat-value"><?php echo $kostku; ?></div>
                        <div class="stat-label">Kost Saya</div>
                    </div>
                </div>
                <div class="col-md-4 col-12 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#fffde7 60%,#fff9c4 100%);">
                        <div class="icon"><i class="bi bi-heart" style="color:#fbc02d"></i></div>
                        <div class="stat-value"><?php echo $wishlist; ?></div>
                        <div class="stat-label">Wishlist</div>
                    </div>
                </div>
                <?php if (!empty($tenant_upcoming_count) && $tenant_upcoming_count > 0) { ?>
                    <div class="col-12 mt-3">
                        <div class="alert alert-warning">
                            <strong>Ada <?php echo $tenant_upcoming_count; ?> tagihan Anda yang akan jatuh tempo dalam 5 hari:</strong>
                            <ul class="mb-0 mt-2">
                                <?php while ($t = mysqli_fetch_assoc($tenant_upcoming_q)) { ?>
                                    <li><?php echo htmlspecialchars($t['nama_kost']); ?> — <?php echo $t['tanggal_tagihan']; ?> — Rp. <?php echo number_format($t['total_tagihan'],0,',','.'); ?> <a href="tagihan.php">Lihat Tagihan</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>

                <?php if (!empty($tenant_overdue_count) && $tenant_overdue_count > 0) { ?>
                    <div class="col-12 mt-2">
                        <div class="alert alert-danger">
                            <strong>Ada <?php echo $tenant_overdue_count; ?> tagihan Anda yang sudah lewat jatuh tempo:</strong>
                            <ul class="mb-0 mt-2">
                                <?php while ($to = mysqli_fetch_assoc($tenant_overdue_q)) { ?>
                                    <li><?php echo htmlspecialchars($to['nama_kost']); ?> — <?php echo $to['tanggal_tagihan']; ?> — Rp. <?php echo number_format($to['total_tagihan'],0,',','.'); ?> — Terlambat: <?php echo intval($to['days_overdue']); ?> hari <a href="tagihan.php">Lihat Tagihan</a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                <?php } ?>
            <?php } elseif ($role == 2) { ?>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#e0f7fa 60%,#b2ebf2 100%);">
                        <div class="icon"><i class="bi bi-building" style="color:#00b894"></i></div>
                        <div class="stat-value"><?php echo $kost; ?></div>
                        <div class="stat-label">Properti Kost</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#f1f8e9 60%,#dcedc8 100%);">
                        <div class="icon"><i class="bi bi-people" style="color:#388e3c"></i></div>
                        <div class="stat-value"><?php echo $penyewa; ?></div>
                        <div class="stat-label">Jumlah Penyewa</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#fffde7 60%,#fff9c4 100%);">
                        <div class="icon"><i class="bi bi-receipt" style="color:#fbc02d"></i></div>
                        <div class="stat-value"><?php echo $tagihan; ?></div>
                        <div class="stat-label">Tagihan Masuk</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#ffebee 60%,#ffcdd2 100%);">
                        <div class="icon"><i class="bi bi-exclamation-circle" style="color:#e17055"></i></div>
                        <div class="stat-value"><?php echo $tagihan_belum_bayar; ?></div>
                        <div class="stat-label">Tagihan Belum Bayar</div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-12 mb-3">
                    <div class="dashboard-stat h-100" style="background:linear-gradient(135deg,#fff8e1 60%,#ffe0b2 100%);">
                        <div class="icon"><i class="bi bi-hourglass-split" style="color:#fdcb6e"></i></div>
                        <div class="stat-value"><?php echo $tagihan_pending; ?></div>
                        <div class="stat-label">Tagihan Pending</div>
                    </div>
                </div>
                <!-- Tabel Tagihan Belum Bayar & Pending untuk Pemilik -->
                <div class="col-12 mt-4">
                    <h5 class="mb-3" style="font-weight:600;color:#1e293b"><i class="bi bi-exclamation-diamond" style="color:#e17055"></i> Daftar Tagihan Belum Bayar & Pending</h5>
                    <div class="table-responsive rounded shadow-sm" style="background:#f8fafc;padding:1.5rem 1rem;">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:linear-gradient(90deg,#e0e7ef 60%,#f1f5f9 100%);">
                                <tr style="color:#1e293b;font-weight:600;">
                                    <th>No</th>
                                    <th><i class="bi bi-receipt"></i> No Tagihan</th>
                                    <th><i class="bi bi-person"></i> Nama Penyewa</th>
                                    <th><i class="bi bi-house"></i> Nama Kost</th>
                                    <th><i class="bi bi-calendar"></i> Tanggal Tagihan</th>
                                    <th><i class="bi bi-cash"></i> Total Tagihan</th>
                                    <th><i class="bi bi-info-circle"></i> Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q_tagihan = mysqli_query($koneksi, "SELECT tagihan.*, booking.id_user, user.nama_lengkap, kamar.id_kost, kost.nama_kost FROM tagihan JOIN booking ON tagihan.no_booking=booking.id_booking JOIN user ON booking.id_user=user.id JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost WHERE kamar.id_kost IN (SELECT id_kost FROM kost WHERE id_pemilik='{$user['id']}') AND (tagihan.stats=2 OR tagihan.stats=3) ORDER BY tagihan.tanggal_tagihan DESC");
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($q_tagihan)) {
                                    $status = $row['stats'] == 2 ? 'Pending' : ($row['stats'] == 3 ? 'Belum Bayar' : 'Lunas');
                                    $badge = $row['stats'] == 2 ? '<span class=\'badge\' style=\'background:#ffe082;color:#795548;font-weight:600\'><i class=\'bi bi-hourglass-split\'></i> Pending</span>' : ($row['stats'] == 3 ? '<span class=\'badge\' style=\'background:#e17055;color:white;font-weight:600\'><i class=\'bi bi-exclamation-circle\'></i> Belum Bayar</span>' : '<span class=\'badge\' style=\'background:#00b894;color:white;font-weight:600\'><i class=\'bi bi-check-circle\'></i> Lunas</span>');
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo $row['no_tagihan']; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kost']); ?></td>
                                    <td><?php echo $row['tanggal_tagihan']; ?></td>
                                    <td><span style="color:#00b894;font-weight:600">Rp. <?php echo number_format($row['total_tagihan'], 0, ',', '.'); ?></span></td>
                                    <td><?php echo $badge; ?></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <?php if (mysqli_num_rows($q_tagihan) == 0) echo '<div class="text-center text-muted mt-3">Tidak ada tagihan belum bayar atau pending.</div>'; ?>
                    </div>
                </div>
                    <?php if ($upcoming_count > 0) { ?>
                        <div class="col-12 mt-3">
                            <div class="alert alert-warning">
                                <strong>Ada <?php echo $upcoming_count; ?> tagihan yang akan jatuh tempo dalam 5 hari:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php while ($r = mysqli_fetch_assoc($upcoming_q)) { ?>
                                        <li><?php echo htmlspecialchars($r['nama_kost']); ?> — <?php echo htmlspecialchars($r['nama_lengkap']); ?> — <?php echo $r['tanggal_tagihan']; ?> — Rp. <?php echo number_format($r['total_tagihan'],0,',','.'); ?> <a href="penyewa.php?id_kost=<?php echo intval($r['id_kost']); ?>&open_user=<?php echo intval($r['id_user']); ?>">Lihat</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ($overdue_count > 0) { ?>
                        <div class="col-12 mt-2">
                            <div class="alert alert-danger">
                                <strong>Ada <?php echo $overdue_count; ?> tagihan yang sudah lewat jatuh tempo:</strong>
                                <ul class="mb-0 mt-2">
                                    <?php while ($r2 = mysqli_fetch_assoc($overdue_q)) { ?>
                                        <li><?php echo htmlspecialchars($r2['nama_kost']); ?> — <?php echo htmlspecialchars($r2['nama_lengkap']); ?> — <?php echo $r2['tanggal_tagihan']; ?> — Rp. <?php echo number_format($r2['total_tagihan'],0,',','.'); ?> — Terlambat: <?php echo intval($r2['days_overdue']); ?> hari <a href="penyewa.php?id_kost=<?php echo intval($r2['id_kost']); ?>&open_user=<?php echo intval($r2['id_user']); ?>">Lihat</a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    <?php } ?>
                <!-- Tabel Seluruh Penyewa pada Semua Kost Pemilik -->
                <div class="col-12 mt-4">
                    <h5 class="mb-3" style="font-weight:600;color:#1e293b">
                        <i class="bi bi-people" style="color:#388e3c"></i> Daftar Seluruh Penyewa di Kost Anda
                    </h5>
                    <div class="table-responsive rounded shadow-sm" style="background:#f8fafc;padding:1.5rem 1rem;">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background:linear-gradient(90deg,#e0e7ef 60%,#f1f5f9 100%);">
                                <tr style="color:#1e293b;font-weight:600;">
                                    <th>No</th>
                                    <th>Nama Penyewa</th>
                                    <th>Username</th>
                                    <th>Kost</th>
                                    <th>Kamar</th>
                                    <th>Tanggal Masuk</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $q_penyewa = mysqli_query($koneksi, "
                                    SELECT 
                                        user.nama_lengkap, user.username, 
                                        kost.nama_kost, kamar.tipe_kamar, 
                                        booking.tanggal_masuk, booking.id_booking
                                    FROM booking
                                    JOIN user ON booking.id_user = user.id
                                    JOIN kamar ON booking.id_kamar = kamar.id_kamar
                                    JOIN kost ON kamar.id_kost = kost.id_kost
                                    WHERE kost.id_pemilik = '{$user['id']}'
                                    ORDER BY booking.tanggal_masuk DESC
                                ");
                                $no = 1;
                                while ($row = mysqli_fetch_assoc($q_penyewa)) {
                                ?>
                                <tr>
                                    <td><?php echo $no++; ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_lengkap']); ?></td>
                                    <td><?php echo htmlspecialchars($row['username']); ?></td>
                                    <td><?php echo htmlspecialchars($row['nama_kost']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tipe_kamar']); ?></td>
                                    <td><?php echo htmlspecialchars($row['tanggal_masuk']); ?></td>
                                    <!-- Tombol laporan pemilik dihapus sesuai permintaan -->
                                </tr>
                                <?php } ?>
                                <?php if (mysqli_num_rows($q_penyewa) == 0) { ?>
                                    <tr>
                                        <td colspan="6" class="text-center text-muted">Belum ada penyewa di seluruh kost Anda.</td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php } elseif ($role == 3) { ?>
                <div class="col-md-4 col-12">
                    <div class="dashboard-stat">
                        <div class="icon"><i class="bi bi-building"></i></div>
                        <div class="stat-value"><?php echo $kost; ?></div>
                        <div class="stat-label">Total Kost</div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-stat">
                        <div class="icon"><i class="bi bi-people"></i></div>
                        <div class="stat-value"><?php echo $user_count; ?></div>
                        <div class="stat-label">Total User</div>
                    </div>
                </div>
                <div class="col-md-4 col-12">
                    <div class="dashboard-stat">
                        <div class="icon"><i class="bi bi-list-check"></i></div>
                        <div class="stat-value"><?php echo $transaksi; ?></div>
                        <div class="stat-label">Total Transaksi</div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>

<script>
    // Ucapan waktu otomatis
    function getGreeting() {
        const now = new Date();
        const hour = now.getHours();
        let greet = "Selamat pagi";
        if (hour >= 12 && hour < 15) {
            greet = "Selamat siang";
        } else if (hour >= 15 && hour < 18) {
            greet = "Selamat sore";
        } else if (hour >= 18 || hour < 5) {
            greet = "Selamat malam";
        }
        return greet;
    }
    window.addEventListener('DOMContentLoaded', function() {
        const greeting = getGreeting();
        const nama = "<?php echo $user['nama_lengkap']; ?>";
        let role = "<?php echo $role; ?>";
        let roleText = "";
        if (role == "1") roleText = "Anda login sebagai <span style='color:#00997a'>Penyewa</span>";
        else if (role == "2") roleText = "Anda login sebagai <span style='color:#00997a'>Pemilik Kost</span>";
        else if (role == "3") roleText = "Anda login sebagai <span style='color:#00997a'>Admin</span>";
        document.getElementById('dashboard-greeting').innerHTML =
            greeting + ', <b>' + nama + '</b>!<br>' + roleText;
    });
</script>
<!-- Footer Selalu di Bawah -->
<style>
    .footer-fixed-bottom {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        z-index: 999;
    }
    @media (max-width: 767px) {
        .footer-fixed-bottom {
            position: static;
        }
    }
</style>
<div class="footer-fixed-bottom">
    <?php include "template/footer.php"; ?>
</div>
</body>
</html>
