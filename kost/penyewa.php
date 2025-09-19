<?php
// ensure session is started (template/header.php usually starts session, but we need it for action handling)
if (session_status() == PHP_SESSION_NONE) session_start();

// include database connection so $koneksi is available for action handling
include_once __DIR__ . '/../php/koneksi.php';

$id_kost = isset($_GET['id_kost']) ? intval($_GET['id_kost']) : 0;
$current_username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

// handle deletion request (owner action) - process before output/header include
if (isset($_GET['delete_user']) && $id_kost) {
    $del_user = intval($_GET['delete_user']);
    // verify current user is owner of the kost
    $owner_check = mysqli_query($koneksi, "SELECT id_pemilik FROM kost WHERE id_kost='$id_kost'");
    $ok = false;
    if ($owner_check && mysqli_num_rows($owner_check) > 0) {
        $oc = mysqli_fetch_assoc($owner_check);
        // lookup current user id
        $cur = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT id FROM user WHERE username='".mysqli_real_escape_string($koneksi,$current_username)."'"));
        if ($cur && intval($oc['id_pemilik']) === intval($cur['id'])) {
            $ok = true;
        }
    }
    if ($ok) {
        // find bookings for this user on this kost
        $qbook = mysqli_query($koneksi, "SELECT booking.id_booking FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE booking.id_user='$del_user' AND kamar.id_kost='$id_kost'");
        $ids = [];
        while ($b = mysqli_fetch_assoc($qbook)) { $ids[] = intval($b['id_booking']); }
        if (count($ids) > 0) {
            $idlist = implode(',', $ids);
            // delete tagihan rows
            mysqli_query($koneksi, "DELETE FROM tagihan WHERE no_booking IN ($idlist)");
            // delete booking rows
            mysqli_query($koneksi, "DELETE FROM booking WHERE id_booking IN ($idlist)");
        }
        // redirect to avoid resubmission
        header("Location: penyewa.php?id_kost=$id_kost&deleted=1");
        exit;
    } else {
        $error_msg = 'Anda tidak punya izin untuk menghapus penyewa ini.';
    }
}

// init variables to avoid undefined variable notices
$error_msg = '';
$deleted = isset($_GET['deleted']) ? 1 : 0;
$open_user = isset($_GET['open_user']) ? intval($_GET['open_user']) : 0;

// now include header and continue rendering
include "template/header.php";

// get distinct tenants (users) who have bookings in this kost
$q = mysqli_query($koneksi, "SELECT DISTINCT user.id AS user_id, user.nama_lengkap FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN user ON booking.id_user=user.id WHERE kamar.id_kost='$id_kost'");

?>

<div class="container">
    <?php if (!empty($error_msg)) { ?><div class="alert alert-danger"><?php echo htmlspecialchars($error_msg); ?></div><?php } ?>
    <?php if ($deleted) { ?><div class="alert alert-success">Penyewa berhasil dihapus dari kost.</div><?php } ?>
    <table class="table">
        <thead class="thead-dark">
            <tr>
                <th>No</th>
                <th>Nama Penyewa</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Keluar</th>
                
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $i = 0;
            if ($q && mysqli_num_rows($q) > 0) {
                while ($u = mysqli_fetch_assoc($q)) {
                    $i++;
                    $user_id = intval($u['user_id']);
                // get the latest booking for this user in this kost
                $qbook = mysqli_query($koneksi, "SELECT booking.* FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE booking.id_user='$user_id' AND kamar.id_kost='$id_kost' ORDER BY booking.tanggal_masuk DESC LIMIT 1");
                $latest = mysqli_fetch_assoc($qbook);

                $tanggal_masuk = $latest ? $latest['tanggal_masuk'] : '-';
                $tanggal_keluar = $latest ? $latest['tanggal_keluar'] : '-';

                // determine a simple status based on latest booking's tagihan
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
                    <td><?php echo $i; ?></td>
                    <td><?php echo htmlspecialchars($u['nama_lengkap']); ?></td>
                    <td><?php echo htmlspecialchars($tanggal_masuk); ?></td>
                    <td><?php echo htmlspecialchars($tanggal_keluar); ?></td>
                    
                    <td>
                        <div class="btn-group" role="group">
                            <button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target="#detail-penyewa-<?php echo $user_id; ?>" aria-expanded="false" aria-controls="detail-penyewa-<?php echo $user_id; ?>">Lihat Detail</button>
                            <?php
                                // check if this tenant has any tagihan overdue > 5 days for this kost
                                $check_over = mysqli_query($koneksi, "SELECT COUNT(*) AS cnt FROM tagihan t JOIN booking b ON t.no_booking=b.id_booking JOIN kamar cm ON b.id_kamar=cm.id_kamar WHERE b.id_user='$user_id' AND cm.id_kost='$id_kost' AND t.stats<>1 AND DATEDIFF(CURDATE(), t.tanggal_tagihan) > 5");
                                $show_delete = false;
                                if ($check_over) {
                                    $co = mysqli_fetch_assoc($check_over);
                                    if (intval($co['cnt']) > 0) $show_delete = true;
                                }
                                if ($show_delete) {
                                    // delete button with confirmation
                            ?>
                                <a href="penyewa.php?id_kost=<?php echo $id_kost; ?>&delete_user=<?php echo $user_id; ?>" onclick="return confirm('Hapus penyewa ini dari kost? Data booking dan tagihan akan dihapus.');" class="btn btn-sm btn-danger">Hapus</a>
                            <?php } ?>
                        </div>
                    </td>
                </tr>

                <tr class="collapse" id="detail-penyewa-<?php echo $user_id; ?>">
                    <td colspan="6">
                        <h5>Detail Penyewa: <?php echo htmlspecialchars($u['nama_lengkap']); ?></h5>
                        <?php
                        // fetch all bookings for this tenant in this kost
                        $qb = mysqli_query($koneksi, "SELECT booking.*, kamar.id_kost FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar WHERE booking.id_user='$user_id' AND kamar.id_kost='$id_kost' ORDER BY booking.tanggal_masuk DESC");
                        if (mysqli_num_rows($qb) == 0) {
                            echo '<p>Tidak ada penyewaan.</p>';
                        } else {
                        ?>
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
                                    <?php while ($b = mysqli_fetch_assoc($qb)) {
                                        $id_booking = intval($b['id_booking']);
                                        $qtag = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE no_booking='$id_booking' ORDER BY bulan_ke ASC");
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
                                                        <th>Action</th>
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
                                                            <td>
                                                                <?php if ($st == 1) { ?>
                                                                    -
                                                                <?php } else if ($st == 2) { ?>
                                                                    <a href="cek-bayar.php?id_tagihan=<?php echo $r['no_tagihan']; ?>"><button class="btn btn-sm btn-primary">Cek</button></a>
                                                                <?php } else { ?>
                                                                    -
                                                                <?php } ?>
                                                            </td>
                                                        </tr>
                                                    <?php } else {
                                                        $due = date('Y-m-d', strtotime('+' . ($m-1) . ' month', strtotime($b['tanggal_masuk'])));
                                                    ?>
                                                        <tr>
                                                            <td><?php echo $m; ?></td>
                                                            <td><?php echo $due; ?></td>
                                                            <td>-</td>
                                                            <td>Belum dibuat</td>
                                                            <td>-</td>
                                                        </tr>
                                                    <?php } } ?>
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                    <?php } // end bookings loop ?>
                                </tbody>
                            </table>
                        </div>
                        <?php } // end if bookings exist ?>
                    </td>
                </tr>

                <?php } // end while tenants ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6" class="text-center text-muted">Belum ada penyewa untuk kost ini.</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<?php
include "template/footer.php";
?>
<?php
// flush output buffer
if (ob_get_level()) ob_end_flush();
?>
<?php if ($open_user > 0) { ?>
    <script>
        // wait DOM then open collapse and scroll into view
        document.addEventListener('DOMContentLoaded', function () {
            var id = <?php echo $open_user; ?>;
            var selector = '#detail-penyewa-' + id;
            var el = document.querySelector(selector);
            if (el) {
                // use jQuery/Bootstrap collapse if available
                if (window.jQuery && jQuery(selector).collapse) {
                    jQuery(selector).collapse('show');
                } else {
                    el.classList.add('show');
                }
                // scroll to the detail row
                el.scrollIntoView({behavior: 'smooth', block: 'center'});
            }
        });
    </script>
<?php } ?>