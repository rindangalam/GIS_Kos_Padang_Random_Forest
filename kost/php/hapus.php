<?php
include "../../php/koneksi.php";

$id_kost = $_GET['id_kost'];
echo $id_kost;

// Hapus semua kamar yang terkait dengan kost ini terlebih dahulu
mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kost='$id_kost'");

// Baru hapus data kost
$query = "DELETE FROM kost WHERE id_kost='$id_kost'";
$data = mysqli_query($koneksi, $query);

if ($data) {
    header("location:../properti.php");
} else {
    header("location:../index.php");
}
?>
<!-- hapus  -->