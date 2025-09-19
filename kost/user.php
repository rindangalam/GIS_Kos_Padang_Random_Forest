<?php
include "template/header.php";

$data = mysqli_query($koneksi, "SELECT * FROM user JOIN roles_user on user.roles=roles_user.id_roles");
?>

<div class="container py-4">
    <div class="properti-card">
        <div class="mb-3">
            <h4 style="font-weight:bold;color:#19a9a9;letter-spacing:1px;">Daftar Seluruh Pengguna</h4>
            <hr style="width:60px;border-top:3px solid #b2ebeb;margin-left:0;">
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle text-center">
                <thead style:"background:#19a9a9;">
                    <tr>
                        <th>No</th>
                        <th>Nama Lengkap</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>Roles</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $n = 0;
                    while ($d = mysqli_fetch_array($data)) {
                        $n++;
                    ?>
                        <tr>
                            <td><?php echo $n ?></td>
                            <td><?php echo $d['nama_lengkap'] ?></td>
                            <td><?php echo $d['username'] ?></td>
                            <td><?php echo $d['password'] ?></td>
                            <td>
                                <span class="badge" style="background:#e0f7fa;color:#19a9a9;font-weight:500;">
                                    <?php echo $d['nama'] ?>
                                </span>
                            </td>
                            <td>
                                <a href="php/hapus-user.php?id=<?php echo $d['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin membanned user ini?')">
                                    <i class="fa fa-ban"></i> Banned
                                </a>
                                <!-- <a href="<?php // echo "edit-profil.php?id=" . $d['id'] ?>"><button class="btn-dark">Ubah</button></a> -->
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
    background-color: rgb(255, 255, 255);
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
    background: #e0f7fa;
    color: #19a9a9;
    font-weight: 500;
}
.btn-danger.btn-sm {
    font-size: 0.95em;
    padding: 0.35em 1em;
    border-radius: 1em;
}
</style>

<?php
include "template/footer.php"
?>