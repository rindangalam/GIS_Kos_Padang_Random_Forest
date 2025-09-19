<?php

include "../../php/koneksi.php";

function ubahKamar()
{
    $id_kamar = $_GET['id_kamar'];
    global $koneksi;
    echo $id_kamar . "<br>";
    echo "<br>" . $jumlah_kamar = $_POST['jumlah_kamar'];
    echo "<br>" . $panjang_kamar = $_POST['panjang_kamar'];
    echo "<br>" . $lebar_kamar = $_POST['lebar_kamar'];
    echo "<br>" . $tipe_kamar = $_POST['tipe_kamar'];
    echo "<br>" . $biaya_fasilitas = $_POST['biaya_fasilitas'];
    $fasilitas_kamar = $_POST['fasilitas_kamar'];
    echo "<br>" . $fasilitas = implode(', ', $fasilitas_kamar);
    $id_kost = idkost($id_kamar);
    $ubah = mysqli_query($koneksi, "UPDATE kamar SET jumlah_kamar='$jumlah_kamar',panjang_kamar='$panjang_kamar',lebar_kamar='$lebar_kamar',tipe_kamar='$tipe_kamar',biaya_fasilitas='$biaya_fasilitas',fasilitas_kamar='$fasilitas' WHERE id_kamar='$id_kamar'");
    if ($ubah) {
        echo "berhasil";
        header("location:../$id_kost");
    } else {
        echo "gagal<br>";
        header("location:../$id_kost"); //kesini
    }
}

function tambahKamar()
{
    $id_kost = $_GET['id_kost'];
    global $koneksi;
    echo "<br>Jumlah Kamar:" . $jumlah_kamar = $_POST['jumlah_kamar'];
    echo "<br>Panjang Kamar:" . $panjang_kamar = $_POST['panjang_kamar'];
    echo "<br>Lebar Kamar:" . $lebar_kamar = $_POST['lebar_kamar'];
    echo "<br>Tipe Kamar:" . $tipe_kamar = $_POST['tipe_kamar'];
    echo "<br>Biaya Kamar: " . $biaya_fasilitas = $_POST['biaya_fasilitas'];
    $fasilitas_kamar = $_POST['fasilitas_kamar'];
    echo "<br>Fasilitas: " . $fasilitas = implode(', ', $fasilitas_kamar);

    $kirim = mysqli_query($koneksi, "INSERT INTO kamar VALUES ('','$id_kost','$jumlah_kamar','$panjang_kamar','$lebar_kamar','$tipe_kamar','$biaya_fasilitas','$fasilitas')");
    if ($kirim) {
        header("location:../daftar-kamar.php?id_kost=$id_kost");
    } else {
        header("location:../index.php");
        echo "<script>alert('gagal')</script>";
    }
}



function idkost($id_kamar)
{
    global $koneksi;
    $query = mysqli_query($koneksi, "SELECT * FROM kamar");
    $d = mysqli_fetch_array($query);
    if ($d['id_kost']) {
        return "daftar-kamar.php?id_kost=" . $d['id_kost']; //pindahkan ini
    } else {
        return "properti.php";
    }
}

function hapusKamar()
{
    global  $koneksi;
    $id_kamar = $_GET['id_kamar'];
    $query = mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kamar=$id_kamar");
    $id_kost = idkost($id_kamar);
    if ($query) {
        echo "berhasil";
        header("location:../$id_kost");
    } else {
        echo "gagal<br>";
        header("location:../$id_kost"); //kesini
    }
}

if (isset($_POST['submit'])) {
    tambahKamar();
} else if (isset($_POST['hapus_kamar'])) {
    $id_kamar = $_GET['id_kamar'];
    // Ambil id_kost dari kamar yang akan dihapus
    $q = mysqli_query($koneksi, "SELECT id_kost FROM kamar WHERE id_kamar='$id_kamar'");
    $row = mysqli_fetch_assoc($q);
    $id_kost = $row['id_kost'];
    // Hapus kamar
    mysqli_query($koneksi, "DELETE FROM kamar WHERE id_kamar='$id_kamar'");
    // Redirect ke daftar kamar dengan id_kost yang benar
    header("Location: ../daftar-kamar.php?id_kost=$id_kost");
    exit;
} else if (isset($_POST['ubah_kamar'])) {
    $id_kamar = $_GET['id_kamar'];
    // ... proses update kamar ...
    // Ambil id_kost dari kamar yang diedit
    $q = mysqli_query($koneksi, "SELECT id_kost FROM kamar WHERE id_kamar='$id_kamar'");
    $row = mysqli_fetch_assoc($q);
    $id_kost = $row['id_kost'];
    // Redirect ke halaman kamar dengan id_kost yang benar
    header("Location: ../daftar-kamar.php?id_kost=$id_kost");
    exit;
} else {
    echo "failed";
}
