<?php
include "../../php/koneksi.php";
$id = $_GET['id'];
// Ambil semua id_booking milik user
$result = mysqli_query($koneksi, "SELECT id_booking FROM booking WHERE id_user='$id'");
while ($row = mysqli_fetch_array($result)) {
    $id_booking = $row['id_booking'];
    mysqli_query($koneksi, "DELETE FROM tagihan WHERE no_booking='$id_booking'");
}
mysqli_query($koneksi, "DELETE FROM booking WHERE id_user='$id'");
$query = "DELETE FROM user WHERE id='$id'";
$data = mysqli_query($koneksi, $query);

var_dump($data);
if ($data) {
    header("location:../user.php");
} else {
    header("location:../index.php");
}
