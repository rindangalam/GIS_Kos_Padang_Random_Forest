<?php
include "template/header.php";

$query2 = "SELECT * FROM booking JOIN tagihan ON booking.id_booking=tagihan.no_booking JOIN kamar ON booking.id_kamar=kamar.id_kamar JOIN kost ON kost.id_kost=kamar.id_kost JOIN user on booking.id_user=user.id";
$data2 = mysqli_query($koneksi, $query2);

if ($d['roles'] == 3) {
?>

<div class="container py-4">
    <div class="properti-card">
        <div class="mb-3">
            <h4 style="font-weight:bold;color:#19a9a9;letter-spacing:1px;">Daftar Semua Transaksi</h4>
            <hr style="width:60px;border-top:3px solid #b2ebeb;margin-left:0;">
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>ID Tagihan</th>
                        <th>ID Booking</th>
                        <th>Nama Penyewa</th>
                        <th>Nama Kost</th>
                        <th>Nama Pemilik Kost</th>
                        <th>Total Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 0;
                    while ($p = mysqli_fetch_array($data2)) {
                        $i++;
                    ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $p['no_tagihan'] ?></td>
                            <td><?php echo $p['id_booking'] ?></td>
                            <td><?php echo $p['nama_lengkap'] ?></td>
                            <td><?php echo $p['nama_kost'] ?></td>
                            <td><?php echo $p['nama_pemilik'] ?></td>
                            <td>
                                <span class="badge" style="background:#e0f7fa;color:#19a9a9;font-weight:500;">
                                    <?php echo "Rp. " . number_format($p['total_tagihan'], 0, ',', '.') ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                $stat = $p['stats'];
                                if ($stat == 1) {
                                    echo '<span class="badge" style="background:#b2ebeb;color:#00b894;font-weight:600;">Lunas</span>';
                                } elseif ($stat == 2) {
                                    echo '<span class="badge" style="background:#fff3cd;color:#f59e42;font-weight:600;">Pending</span>';
                                } else {
                                    echo '<span class="badge" style="background:#ffeaea;color:#e74c3c;font-weight:600;">Belum Lunas</span>';
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

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
.table thead th {
    background: #19a9a9;
    color: #fff;
    font-weight: 600;
    border: none;
    letter-spacing: 0.5px;
}
.table tbody tr {
    background: #f8fafc;
    transition: background 0.2s;
}
.table tbody tr:hover {
    background: #e0f7fa;
}
.table td, .table th {
    vertical-align: middle !important;
}
.badge {
    font-size: 1em;
    padding: 0.5em 1em;
    border-radius: 1em;
}
</style>

<?php
}
include "template/footer.php";
?>