<?php include "template/header.php";
$tanggal_masuk = isset($_POST['now']) ? $_POST['now'] : '';
$biaya = isset($_POST['biaya']) ? floatval($_POST['biaya']) : 0;
$monthly_amount = isset($_POST['monthly_amount']) ? floatval($_POST['monthly_amount']) : 0;
$metode = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : 'bulanan';
$bulan_dibayar = isset($_POST['bulan_dibayar']) ? intval($_POST['bulan_dibayar']) : 1;
$id_kost = $_GET['id_kost'];
$query = "SELECT * FROM user JOIN kost on kost.id_pemilik=user.id";
$data = mysqli_query($koneksi, $query);
 $d = mysqli_fetch_array($data);

// ambil bank jika dikirim dari form
$bank = isset($_POST['bank']) ? $_POST['bank'] : '';

// Jika form dikirim dari booking-2 (POST), buat booking dan tagihan di sini
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ambil data detail yang dikirim dari booking-2
    $idkamar = isset($_POST['idkamar_post']) ? $_POST['idkamar_post'] : (isset($_POST['idkamar']) ? $_POST['idkamar'] : '');
    $hitungan_sewa = isset($_POST['hitungan_sewa_post']) ? $_POST['hitungan_sewa_post'] : (isset($_POST['hitungan_sewa']) ? $_POST['hitungan_sewa'] : '');
    $durasi_sewa = isset($_POST['durasi_sewa_post']) ? intval($_POST['durasi_sewa_post']) : (isset($_POST['durasi_sewa']) ? intval($_POST['durasi_sewa']) : 1);
    $tanggal_keluar = isset($_POST['tanggal_keluar_post']) ? $_POST['tanggal_keluar_post'] : '';
    $jumlah_kamar = isset($_POST['jumlah_kamar_post']) ? $_POST['jumlah_kamar_post'] : 1;
    $nama_lengkap = isset($_POST['nama_lengkap_post']) ? $_POST['nama_lengkap_post'] : '';
    $jenis_kelamin = isset($_POST['jenis_kelamin_post']) ? $_POST['jenis_kelamin_post'] : '';
    $no_hp = isset($_POST['no_hp_post']) ? $_POST['no_hp_post'] : '';
    $pekerjaan = isset($_POST['pekerjaan_post']) ? $_POST['pekerjaan_post'] : '';
    $foto_ktp = isset($_POST['foto_ktp_post']) ? $_POST['foto_ktp_post'] : '';
    $monthly_amount = isset($_POST['monthly_amount_post']) ? floatval($_POST['monthly_amount_post']) : (isset($_POST['monthly_amount']) ? floatval($_POST['monthly_amount']) : 0);
    $total_biaya = isset($_POST['total_biaya_post']) ? floatval($_POST['total_biaya_post']) : (isset($_POST['biaya']) ? floatval($_POST['biaya']) : 0);
    $metode = isset($_POST['metode_pembayaran']) ? $_POST['metode_pembayaran'] : 'bulanan';
    $bulan_dibayar = isset($_POST['bulan_dibayar']) ? intval($_POST['bulan_dibayar']) : 1;

    // ambil id_user dari session
    $username = $_SESSION['username'];
    $q_user = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    $u = mysqli_fetch_array($q_user);
    $id_user = $u['id'];

    // debug log (append)
    $debug_path = __DIR__ . DIRECTORY_SEPARATOR . 'pembayaran_debug.log';
    $dbg = [];
    $dbg['received_at'] = date('c');
    $dbg['post_keys'] = array_keys($_POST);
    $dbg['post_sample'] = array_intersect_key($_POST, array_flip(['idkamar_post','durasi_sewa_post','monthly_amount_post','total_biaya_post','metode_pembayaran','tanggal_masuk','now']));
    file_put_contents($debug_path, json_encode($dbg) . PHP_EOL, FILE_APPEND | LOCK_EX);

    // update profil user
    mysqli_query($koneksi, "UPDATE user SET nama_lengkap='$nama_lengkap', jenis_kelamin='$jenis_kelamin', no_hp='$no_hp', pekerjaan='$pekerjaan', foto_ktp='$foto_ktp' WHERE id='$id_user'");

    // insert booking (avoid duplicates) and ensure tagihan rows exist for all months
    mysqli_begin_transaction($koneksi);
    try {
        // check existing booking to avoid duplicate when user resubmits
        $check = mysqli_query($koneksi, "SELECT id_booking FROM booking WHERE id_user='$id_user' AND id_kamar='$idkamar' AND tanggal_masuk='$tanggal_masuk' LIMIT 1");
        if ($check && mysqli_num_rows($check) > 0) {
            $row = mysqli_fetch_array($check);
            $new_id_booking = $row['id_booking'];
        } else {
            // create booking
            $ins = mysqli_query($koneksi, "INSERT INTO booking (id_booking, id_user, id_kamar, tanggal_masuk, hitungan_sewa, durasi_sewa, tanggal_keluar, jumlah_kamar, metode_pembayaran, bulan_dibayar) VALUES ('','$id_user','$idkamar','$tanggal_masuk','$hitungan_sewa','$durasi_sewa','$tanggal_keluar','$jumlah_kamar','$metode','$bulan_dibayar')");
            if (!$ins) throw new Exception('Gagal insert booking: ' . mysqli_error($koneksi));
            $new_id_booking = mysqli_insert_id($koneksi);
        }

        // Ensure we have a monthly_amount; if not provided, compute from kamar/kost
        if (empty($monthly_amount) || $monthly_amount == 0) {
            $qinfo = mysqli_query($koneksi, "SELECT kamar.biaya_fasilitas, kost.harga_sewa, booking.hitungan_sewa FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost WHERE booking.id_booking='$new_id_booking' LIMIT 1");
            if ($qinfo && mysqli_num_rows($qinfo) > 0) {
                $inf = mysqli_fetch_assoc($qinfo);
                $hf = $inf['biaya_fasilitas'] ?? 0;
                $hs = $inf['harga_sewa'] ?? 0;
                $hitung = $inf['hitungan_sewa'] ?? 3;
                if ($hitung == 4) {
                    $monthly_amount = ($hs / 12) + $hf;
                } else {
                    $monthly_amount = $hs + $hf;
                }
            }
        }

        // create missing tagihan rows (1..durasi_sewa)
        $start_date = date('Y-m-d', strtotime($tanggal_masuk));
        $dur = max(1, intval($durasi_sewa));
        // fetch existing bulan_ke for this booking
        $q_exist_tag = mysqli_query($koneksi, "SELECT bulan_ke FROM tagihan WHERE no_booking='$new_id_booking'");
        $exists = [];
        while ($er = mysqli_fetch_assoc($q_exist_tag)) { $exists[intval($er['bulan_ke'])] = true; }

        for ($i = 1; $i <= $dur; $i++) {
            if (isset($exists[$i])) continue; // skip existing
            $due_date = date('Y-m-d', strtotime('+' . ($i - 1) . ' month', strtotime($start_date)));
            $ins2 = mysqli_query($koneksi, "INSERT INTO tagihan (no_tagihan, no_booking, total_tagihan, stats, tanggal_tagihan, bulan_ke) VALUES ('','$new_id_booking','$monthly_amount','3','$due_date','$i')");
            if (!$ins2) throw new Exception('Gagal insert tagihan: ' . mysqli_error($koneksi));
        }

        mysqli_commit($koneksi);
    } catch (Exception $e) {
        mysqli_rollback($koneksi);
        echo '<div class="alert alert-danger">Gagal membuat booking/tagihan: ' . $e->getMessage() . '</div>';
    }

}

?>
<style>
    .container {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>
<div class="container">
            <div class="col">
                    <h6>Jumlah Total :</h6>
                    <h2>Rp.<?php echo number_format($biaya, 0, ',', '.') ?></h2>
                </div>
    <hr>
    <div class="row">
        <?php
        $hari = ['', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu', 'Minggu'];
        ?>
        <div class="col">
            <h5>Mohon Selesaikan Pembayaran sebelum <?php echo $hari[date('N', strtotime('+' . 2 . 'day'))] . date(', d-m-y h:i.a ', strtotime('+' . 2 . 'day')) ?></h5>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="container">
            <div class="row">
                <div class="col">
                    <h6>Kode Bank</h6>
                    <h4><?php
                        if ($bank == "Bank BNI") {
                            echo "009";
                        } else if ($bank == "Bank Rakyat Indonesia tbk") {
                            echo "002";
                        } else if ($bank == "Bank Mandiri") {
                            echo "008";
                        } elseif ($bank == "Bank BCA") {
                            echo "014";
                        } else if ($bank == "Bank Muamalat") {
                            echo "147";
                        } else {
                            echo "error bank tidak ditemukan";
                        }
                        ?></h4>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h6> No Rekening :</h6>
                    <h2><?php echo $d['no_rekening']; ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h6>Nama Pemilik Rekening :</h6>
                    <h2> <?php echo $d['nama_pemilik'] ?></h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h6>Jumlah Total :</h6>
                    <h2>Rp.<?php echo number_format($biaya, 0, ',', '.') ?></h2>
                </div>
            </div>

        </div>
    </div>
        <div class="row">
                <div class="col-md-3">
                        <label for="total_pembayaran">Total Pembayaran yang harus dibayar saat ini:</label>
                </div>
                <div class="col">
                        <span id="total_pembayaran"></span>
                </div>
        </div>
</div>
<script>
    // Tampilkan jumlah yang harus dibayar saat ini:
    // Jika metode bulanan -> tampilkan hanya bulan pertama (monthly_amount)
    // Jika metode lunas -> tampilkan total biaya (biaya)
    var metode = '<?php echo $metode; ?>';
    var biaya = <?php echo $biaya; ?>;
    var monthly = <?php echo $monthly_amount; ?>;
    var toShow = (metode === 'lunas') ? biaya : monthly;
    // Format angka ke Rp.xxx
    function formatRp(n) {
        return 'Rp ' + n.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }
    document.getElementById('total_pembayaran').innerText = formatRp(toShow);
</script>
<?php include "template/footer.php"; ?>