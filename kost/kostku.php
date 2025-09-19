<?php
include "template/header.php";

// select distinct kosts that this user has bookings for (avoid joining tagihan to prevent duplicate rows)
$today = date('Y-m-d');
// upcoming tagihan within next 5 days (show starting 5 days before tanggal_tagihan)
$notif_q = mysqli_query($koneksi, "SELECT t.*, k.nama_kost, b.id_user FROM tagihan t JOIN booking b ON t.no_booking=b.id_booking JOIN kamar cm ON b.id_kamar=cm.id_kamar JOIN kost k ON cm.id_kost=k.id_kost JOIN user u ON b.id_user=u.id WHERE u.username='".$username."' AND t.stats<>1 AND t.tanggal_tagihan BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 5 DAY) ORDER BY t.tanggal_tagihan ASC");
$notif_count = ($notif_q) ? mysqli_num_rows($notif_q) : 0;
?>
<?php if ($notif_count > 0) { ?>
    <div class="container mt-3">
        <div class="alert alert-warning" role="alert">
            <strong>Ada <?php echo $notif_count; ?> tagihan mendekat:</strong>
            <ul class="mb-0">
                <?php while ($n = mysqli_fetch_assoc($notif_q)) { ?>
                    <li>
                        <?php echo htmlspecialchars($n['nama_kost']); ?> — Tanggal: <?php echo htmlspecialchars($n['tanggal_tagihan']); ?> — Jumlah: Rp. <?php echo number_format($n['total_tagihan'],0,',','.'); ?>
                        &nbsp; <a href="tagihan.php?no_booking=<?php echo intval($n['no_booking']); ?>" class="alert-link">Lihat</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php } ?>

<?php
// overdue tagihan: tanggal_tagihan < today and not paid
$overdue_q = mysqli_query($koneksi, "SELECT t.*, k.nama_kost, cm.id_kost, b.id_booking, DATEDIFF(CURDATE(), t.tanggal_tagihan) AS days_overdue FROM tagihan t JOIN booking b ON t.no_booking=b.id_booking JOIN kamar cm ON b.id_kamar=cm.id_kamar JOIN kost k ON cm.id_kost=k.id_kost JOIN user u ON b.id_user=u.id WHERE u.username='".$username."' AND t.stats<>1 AND t.tanggal_tagihan < CURDATE() ORDER BY t.tanggal_tagihan ASC");
$grace_list = [];
$blocked_kosts = []; // kost ids that passed grace period
if ($overdue_q && mysqli_num_rows($overdue_q) > 0) {
    while ($ov = mysqli_fetch_assoc($overdue_q)) {
        $days = intval($ov['days_overdue']);
        if ($days <= 5) {
            $ov['days_left'] = 5 - $days;
            $grace_list[] = $ov;
        } else {
            $blocked_kosts[intval($ov['id_kost'])] = $ov; // store last ov info per kost
        }
    }
}

if (count($grace_list) > 0) { ?>
    <div class="container mt-2">
        <div class="alert alert-warning" role="alert">
            <strong>Tagihan melewati tanggal jatuh tempo — keringanan 5 hari:</strong>
            <ul class="mb-0">
                <?php foreach ($grace_list as $g) { ?>
                    <li><?php echo htmlspecialchars($g['nama_kost']); ?> — Tanggal: <?php echo htmlspecialchars($g['tanggal_tagihan']); ?> — Jumlah: Rp. <?php echo number_format($g['total_tagihan'],0,',','.'); ?> — sisa keringanan: <?php echo intval($g['days_left']); ?> hari
                        &nbsp; <a href="tagihan.php?no_booking=<?php echo intval($g['no_booking']); ?>" class="alert-link">Lihat</a>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
<?php }

if (count($blocked_kosts) > 0) { ?>
    <div class="container mt-2">
        <div class="alert alert-danger" role="alert">
            <strong>Ada kost yang akan diblokir karena melewati masa keringanan:</strong>
            <ul class="mb-0">
                <?php foreach ($blocked_kosts as $bk) { ?>
                    <li><?php echo htmlspecialchars($bk['nama_kost']); ?> — Tagihan jatuh tempo: <?php echo htmlspecialchars($bk['tanggal_tagihan']); ?> — Jumlah: Rp. <?php echo number_format($bk['total_tagihan'],0,',','.'); ?>
                        &nbsp; <a href="tagihan.php?no_booking=<?php echo intval($bk['no_booking']); ?>" class="alert-link">Lihat</a>
                    </li>
                <?php } ?>
            </ul>
            <p class="mb-0"><small>Jika tidak dibayar dalam masa keringanan, penyewaan kos akan dihentikan oleh owner.</small></p>
        </div>
    </div>

<?php } ?>

<?php
$query = "SELECT DISTINCT kost.id_kost, kost.nama_kost FROM booking JOIN kamar ON kamar.id_kamar=booking.id_kamar JOIN kost ON kost.id_kost=kamar.id_kost JOIN user ON user.id=booking.id_user WHERE user.username='$username'";
$data = mysqli_query($koneksi, $query);

// track which kost details we've rendered (will render once per kost)
$rendered_kost = [];
?>
<div class="container  bg-gray">
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>kost</th>
                <th>tanggal masuk</th>
                <th>tanggal keluar</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        while ($d = mysqli_fetch_assoc($data)) {
            $id_kost = intval($d['id_kost']);
            $nama_kost = $d['nama_kost'];

            // fetch latest booking for this user on this kost to show dates and status
            $qlatest = mysqli_query($koneksi, "SELECT booking.* FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN user ON booking.id_user=user.id WHERE user.username='$username' AND kamar.id_kost='$id_kost' ORDER BY booking.tanggal_masuk DESC LIMIT 1");
            $latest = mysqli_fetch_assoc($qlatest);

            $tanggal_masuk = $latest ? $latest['tanggal_masuk'] : '-';
            $tanggal_keluar = $latest ? $latest['tanggal_keluar'] : '-';

            // determine status from latest booking's tagihan rows
            $status_label = 'Belum dibuat';
            if ($latest) {
                $id_booking = intval($latest['id_booking']);
                $qtag = mysqli_query($koneksi, "SELECT stats FROM tagihan WHERE no_booking='$id_booking'");
                if (mysqli_num_rows($qtag) == 0) {
                    $status_label = 'Belum dibuat';
                } else {
                    $has_pending = false; $has_unpaid = false; $all_paid = true;
                    while ($tg = mysqli_fetch_assoc($qtag)) {
                        $st = intval($tg['stats']);
                        if ($st != 1) { $all_paid = false; }
                        if ($st == 2) { $has_pending = true; }
                        if ($st == 3) { $has_unpaid = true; }
                    }
                    if ($all_paid) $status_label = 'Lunas';
                    else if ($has_pending) $status_label = 'Pending';
                    else if ($has_unpaid) $status_label = 'Belum Lunas';
                }
            }

        ?>
            <tr>
                <td><?php echo htmlspecialchars($nama_kost); ?></td>
                <td><?php echo htmlspecialchars($tanggal_masuk); ?></td>
                <td><?php echo htmlspecialchars($tanggal_keluar); ?></td>
                
                <td>
                    <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#detail-kost-<?php echo $id_kost; ?>" aria-expanded="false" aria-controls="detail-kost-<?php echo $id_kost; ?>">Lihat Detail</button>
                </td>
            </tr>

            <?php
            // render the detail collapse row once per kost
            if (!in_array($id_kost, $rendered_kost)) {
                $rendered_kost[] = $id_kost;
                // fetch bookings for this kost (for this user)
                $q = mysqli_query($koneksi, "SELECT booking.*, user.nama_lengkap, kamar.id_kost FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN user ON booking.id_user=user.id WHERE user.username='$username' AND kamar.id_kost='$id_kost' ORDER BY booking.tanggal_masuk DESC");
            ?>
                <tr class="collapse" id="detail-kost-<?php echo $id_kost; ?>">
                    <td colspan="5">
                        
                        <?php if (mysqli_num_rows($q) == 0) { ?>
                            <p>Tidak ada penyewaan untuk kost ini.</p>
                        <?php } else { ?>
                            <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        
                                        <th>Tanggal Masuk</th>
                                        <th>Tanggal Keluar</th>
                                        <th>Durasi</th>
                                        <th>Rincian Bulan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($b = mysqli_fetch_assoc($q)) {
                                        // ambil tagihan per bulan untuk booking ini
                                        $id_booking = $b['id_booking'];
                                        $qtag = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE no_booking='$id_booking' ORDER BY bulan_ke ASC");
                                        // build array months
                                        $months = [];
                                        while ($tg = mysqli_fetch_assoc($qtag)) { $months[intval($tg['bulan_ke'])] = $tg; }
                                        $dur = intval($b['durasi_sewa']);
                                    ?>
                                        <tr>
                                           
                                            <td><?php echo htmlspecialchars($b['tanggal_masuk']); ?></td>
                                            <td><?php echo htmlspecialchars($b['tanggal_keluar']); ?></td>
                                            <td><?php echo $dur; ?></td>
                                            <td>
                                                <table class="table table-sm mb-0">
                                                    <thead>
                                                        <tr>
                                                            <th>Bulan Ke</th>
                                                            <th>Tanggal Tagihan</th>
                                                            <th>Jumlah</th>
                                                            <th>Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php for ($m = 1; $m <= max(1,$dur); $m++) {
                                                            if (isset($months[$m])) {
                                                                $r = $months[$m];
                                                                $st = intval($r['stats']);
                                                                $label = ($st==1)?'Lunas':(($st==2)?'Pending':'Belum Lunas');
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $m; ?></td>
                                                                <td><?php echo $r['tanggal_tagihan']; ?></td>
                                                                <td>Rp. <?php echo number_format($r['total_tagihan'],0,',','.'); ?></td>
                                                                <td><?php echo $label; ?></td>
                                                            </tr>
                                                        <?php } else {
                                                            // jika tidak ada tagihan untuk bulan ini, tampilkan placeholder
                                                            // hitung due date dari tanggal_masuk
                                                            $due = date('Y-m-d', strtotime('+' . ($m-1) . ' month', strtotime($b['tanggal_masuk'])));
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $m; ?></td>
                                                                <td><?php echo $due; ?></td>
                                                                <td>-</td>
                                                                <td>Belum dibuat</td>
                                                            </tr>
                                                        <?php } } ?>
                                                    </tbody>
                                                </table>
                                            </td>
                                        </tr>
                                    <?php } // end while bookings ?>
                                </tbody>
                            </table>
                            </div>
                        <?php } // end if bookings exist ?>
                    </td>
                </tr>
            <?php } // end render check ?>

    <?php
    } // end while
    ?>
        </tbody>
    </table>
</div>
<?php
include "template/footer.php";
?>