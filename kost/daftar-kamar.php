<?php
include "template/header.php";
$id_kost = $_GET['id_kost'];

$query = mysqli_query($koneksi, "SELECT * from kamar WHERE id_kost=$id_kost");
?>

<style>
    :root {
        --main-bg: #343a40;
        --main-header: #19a9a9;
        --main-btn: #19a9a9;
        --main-btn-hover: #138d8d;
        --table-border: #19a9a9;
        --table-hover: #e6f7f7;
    }
    .table {
        border-radius: 14px;
        overflow: hidden;
        border-collapse: separate;
        border-spacing: 0;
        background: #fff;
        box-shadow: none;
    }
    .table thead th {
        vertical-align: middle;
        background: var(--main-header); /* Tanpa gradient */
        color: #fff;
        border: none;
        font-weight: 700;
        font-size: 1.08rem;
        letter-spacing: 0.5px;
        text-transform: uppercase;
    }
    .table tbody td {
        vertical-align: middle;
        border-top: 1.5px solid var(--table-border);
        background: #fff;
        font-size: 1rem;
        color: var(--main-btn);
        font-weight: 500;
    }
    .table tbody td:first-child {
        color: var(--main-bg);
        font-weight: 700;
    }
    .table tbody tr {
        transition: background 0.2s;
    }
    .table tbody tr:hover {
        background: var(--table-hover);
    }
    .table th, .table td {
        padding: 0.75rem 0.75rem;
    }
    .table-responsive {
        border-radius: 14px;
        overflow: hidden;
    }
    .btn-custom {
        border-radius: 50px;
        font-weight: 500;
        letter-spacing: 0.5px;
        box-shadow: none;
        transition: background 0.2s, color 0.2s;
    }
    .btn-custom-primary {
        background: var(--main-btn);
        color: #fff;
        border: none;
    }
    .btn-custom-primary:hover {
        background: var(--main-btn-hover);
        color: #fff;
    }
    .btn-custom-warning,
    .btn-custom-danger {
        background: transparent;
        color: var(--main-btn);
        border: none;
        box-shadow: none;
        padding: 0.35rem 0.7rem;
        font-size: 1.1rem;
        border-radius: 50px;
        transition: background 0.2s, color 0.2s;
    }
    .btn-custom-warning:hover,
    .btn-custom-danger:hover {
        background: var(--main-btn);
        color: #fff;
    }
    .card-modern {
        border-radius: 18px;
        border: none;
        box-shadow: 0 4px 24px rgba(25,169,169,0.10);
    }
</style>

<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0 fw-bold" style="color:var(--main-btn)">
            <i class="fa fa-bed me-2"></i>Daftar Kamar
        </h3>
        <a href="kamar.php?id_kost=<?php echo $id_kost ?>" class="btn btn-custom btn-custom-primary px-4 py-2">
            <i class="fa fa-plus"></i> Tambah Kamar
        </a>
    </div>
    <div class="card card-modern shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0 text-center align-middle">
                    <thead>
                        <tr>
                            <th style="width:5%;">No</th>
                            <th style="width:18%;">Tipe Kamar</th>
                            <th style="width:12%;">Jumlah</th>
                            <th>Fasilitas</th>
                            <th style="width:18%;">Biaya Fasilitas</th>
                            <th style="width:15%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 0;
                        while ($d = mysqli_fetch_array($query)) {
                            $no++;
                        ?>
                            <tr>
                                <td><?php echo $no ?></td>
                                <td class="fw-semibold"><?php echo $d['tipe_kamar'] ?></td>
                                <td><?php echo $d['jumlah_kamar'] ?></td>
                                <td class="text-start"><?php echo $d['fasilitas_kamar'] ?></td>
                                <td>
                                    <span class="fs-6" style="color:var(--main-btn); font-weight:bold;">
                                        <?php echo "Rp. " . number_format($d['biaya_fasilitas'], 0, ',', '.')  ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="edit-kamar.php?id_kamar=<?php echo $d['id_kamar'] ?>"
                                           class="btn btn-custom btn-custom-warning"
                                           title="Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <form action="php/kamar_proses.php?id_kamar=<?php echo $d['id_kamar'] ?>"
                                              method="post"
                                              onsubmit="return confirm('Yakin ingin menghapus kamar ini?')"
                                              style="display:inline;">
                                            <button class="btn btn-custom btn-custom-danger"
                                                    name="hapus_kamar"
                                                    title="Hapus">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php
                        }
                        if ($no == 0) {
                            echo '<tr><td colspan="6" class="text-muted">Belum ada kamar.</td></tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
include "template/footer.php";
?>