    <?php include "template/header.php"; ?>

    <?php
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';

    // ambil user id
    $q_user = mysqli_query($koneksi, "SELECT id FROM user WHERE username='$username'");
    $u = mysqli_fetch_array($q_user);
    $user_id = $u['id'] ?? 0;
    ?>

    <style>
        /* Visual polish for tagihan page */
        .tagihan-container { background-color: #f8fbfd; padding: 18px; border-radius: 6px; }
        .card-header { background: #ffffff; border-bottom: 1px solid #e9eef2; }
        .card { box-shadow: 0 1px 0 rgba(0,0,0,0.03); }
        .badge-status { font-size: 0.75rem; padding: 0.45em 0.6em; }
        .month-table td, .month-table th { vertical-align: middle; }
        .booking-meta { font-size: 0.9rem; color:#586069; }
        .card-footer { background: transparent; border-top: 1px dashed #e9eef2; }
        .small-muted { font-size:0.85rem; color:#6c757d; }
    </style>

    <div class="container" style="background-color: azure">
        <h4 class="text-center">Tagihan</h4>
        <hr>

        <div class="accordion" id="bookingAccordion">
            <?php
            $q_bookings = mysqli_query($koneksi, "SELECT booking.*, kamar.tipe_kamar, kost.nama_kost FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost WHERE booking.id_user='$user_id' ORDER BY booking.tanggal_masuk DESC");
            $bno = 0;
            while ($booking = mysqli_fetch_assoc($q_bookings)) {
                $bno++;
                $booking_id = $booking['id_booking'];
                $q_sum = mysqli_query($koneksi, "SELECT IFNULL(SUM(total_tagihan),0) as outstanding FROM tagihan WHERE no_booking='$booking_id' AND stats=3");
                $sum_row = mysqli_fetch_array($q_sum);
                $outstanding = $sum_row['outstanding'];
                // ambil tagihan yang sudah ada untuk booking ini
                $q_tag = mysqli_query($koneksi, "SELECT * FROM tagihan WHERE no_booking='$booking_id'");
                $existing = [];
                while ($r = mysqli_fetch_assoc($q_tag)) {
                    $existing[intval($r['bulan_ke'])] = $r;
                }

                // ambil info harga dari kamar/kost untuk membentuk nilai per-bulan jika belum ada tagihan
                $q_kamar_info = mysqli_query($koneksi, "SELECT kamar.biaya_fasilitas, kost.harga_sewa, kost.tipe_kost FROM booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kamar.id_kost=kost.id_kost WHERE booking.id_booking='$booking_id' LIMIT 1");
                $info = mysqli_fetch_assoc($q_kamar_info);
                $harga_sewa_info = $info['harga_sewa'] ?? 0;
                $biaya_fasilitas_info = $info['biaya_fasilitas'] ?? 0;
                $hitungan = $booking['hitungan_sewa'];
                $durasi = intval($booking['durasi_sewa']);
                // monthly amount: if hitungan bulanan (3) or tahunan (4) we normalize to per-month
                if ($hitungan == 3) {
                    $monthly_amount_info = $harga_sewa_info + $biaya_fasilitas_info;
                } elseif ($hitungan == 4) {
                    // harga_sewa probably yearly in kost.harga_sewa; convert to monthly
                    $monthly_amount_info = ($harga_sewa_info / 12) + $biaya_fasilitas_info;
                } else {
                    $monthly_amount_info = $harga_sewa_info + $biaya_fasilitas_info;
                }
            ?>
                <div class="card mb-3">
                    <div class="card-header" id="heading<?php echo $bno; ?>">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <h5 class="mb-0"><?php echo htmlspecialchars($booking['nama_kost']); ?> <small class="booking-meta">&bull; Booking #<?php echo $booking_id; ?></small></h5>
                                <div class="booking-meta">Tanggal Masuk: <?php echo $booking['tanggal_masuk']; ?> &nbsp;&nbsp;|&nbsp;&nbsp; Tanggal Keluar: <?php echo $booking['tanggal_keluar']; ?></div>
                            </div>
                            <div class="text-right">
                                <div class="font-weight-bold" style="color:#218838">Total Outstanding: Rp. <?php echo number_format($outstanding,0,',','.'); ?></div>
                                <button class="btn btn-sm btn-outline-primary mt-2" type="button" data-toggle="collapse" data-target="#collapse<?php echo $bno; ?>" aria-expanded="false" aria-controls="collapse<?php echo $bno; ?>">Lihat Detail</button>
                            </div>
                        </div>
                    </div>

                    <div id="collapse<?php echo $bno; ?>" class="collapse" aria-labelledby="heading<?php echo $bno; ?>" data-parent="#bookingAccordion">
                        <div class="card-body px-3 py-2">
                            <div class="table-responsive">
                            <table class="table table-sm table-striped month-table mb-0">
                                <thead class="thead-light">
                                    <tr>
                                        <th style="width:8%">Bulan</th>
                                        <th style="width:22%">Tanggal Tagihan</th>
                                        <th style="width:18%">Jumlah</th>
                                        <th style="width:22%">Batas Waktu</th>
                                        <th style="width:15%">Status</th>
                                        <th style="width:15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // tampilkan semua bulan berdasarkan durasi booking
                                    for ($i = 1; $i <= max(1, $durasi); $i++) {
                                        // hitung tanggal jatuh tempo untuk bulan ke-i
                                        $due_date = date('Y-m-d', strtotime('+' . ($i - 1) . ' month', strtotime($booking['tanggal_masuk'])));
                                        if (isset($existing[$i])) {
                                            $t = $existing[$i];
                                            $status = intval($t['stats']);
                                            $display_date = $t['tanggal_tagihan'];
                                            $display_amount = $t['total_tagihan'];
                                            $display_jatuh = date('Y-m-d', strtotime($t['tanggal_tagihan'] . ' +90 days'));
                                        } else {
                                            // buat tampilan sementara untuk bulan yang belum dibuat tagihannya
                                            $status = 0; // belum dibuat
                                            $display_date = $due_date;
                                            $display_amount = $monthly_amount_info;
                                            $display_jatuh = date('Y-m-d', strtotime($due_date . ' +90 days'));
                                        }
                                    ?>
                                        <tr>
                                            <td class="align-middle text-center font-weight-bold"><?php echo $i; ?></td>
                                            <td class="align-middle"><?php echo $display_date; ?></td>
                                            <td class="align-middle">Rp. <?php echo number_format($display_amount, 0, ',', '.'); ?></td>
                                            <td class="align-middle small-muted"><?php echo $display_jatuh; ?></td>
                                            <td class="align-middle">
                                                <?php
                                                if ($status == 1) { echo '<span class="badge badge-success badge-status">Lunas</span>'; }
                                                else if ($status == 2) { echo '<span class="badge badge-warning badge-status">Pending</span>'; }
                                                else if ($status == 3) { echo '<span class="badge badge-danger badge-status">Belum Lunas</span>'; }
                                                else { echo '<span class="badge badge-secondary badge-status">Belum dibuat</span>'; }
                                                ?>
                                            </td>
                                            <td class="align-middle">
                                                <?php if ($status == 3) { ?>
                                                    <a class="btn btn-sm btn-primary" href="validasi.php?no_tagihan=<?php echo $t['no_tagihan']; ?>">Bayar / Bukti</a>
                                                <?php } else if ($status == 2) { ?>
                                                    <span class="small-muted">Menunggu Verif.</span>
                                                <?php } else if ($status == 1) { ?>
                                                    <span class="text-success">Selesai</span>
                                                <?php } else { ?>
                                                    <span class="small-muted">-</span>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php } // end generated months loop ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php } // end bookings loop ?>
        </div>

        <p><b>Status</b></p>
        <p>
            Belum Bayar = Segera Lunasi Pembayaran Anda <br>
            Pending = Pembayaran anda sedang diproses<br>
            Lunas = Transaksi Selesai dan telah terverifikasi
        </p>

    </div>

    <?php include "template/footer.php" ?>