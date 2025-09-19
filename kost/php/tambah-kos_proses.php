<?php
include "../../php/koneksi.php";
session_start();
if (isset($_POST['tambah'])) {

    $nama_kost = $_POST['nama_kost'];
    $alamat = $_POST['alamat'];
    // $provinsi = $_POST['provinsi'];
    // $kota = $_POST['kota'];
    $kecamatan = $_POST['kecamatan'];
    $kelurahan = $_POST['kelurahan'];
    $kampus = $_POST['kampus'];
    $deskripsi = $_POST['deskripsi'];
    // info kamar 
    $jumlah_kamar = $_POST['jumlah_kamar'];
    // $panjang_kamar = $_POST['panjang_kamar'];
    //  $lebar_kamar = $_POST['lebar_kamar'];
    $kontak = $_POST['kontak'];
    // info pembayaran
    $tanggal_tagih = $_POST['tanggal_tagih'];
    $nama_pemilik = $_POST['nama_pemilik'];
    $nama_bank = $_POST['nama_bank'];
    $no_rekening = $_POST['no_rekening'];
    $fasilitas_kost = $_POST['fasilitas'];
    $fasilitas = implode(', ', $fasilitas_kost);
    // foto bangunan
    $foto_bangunan_utama = $_FILES['foto_bangunan_utama']['name'];
    $foto_kamar = $_FILES['foto_kamar']['name'];
    $foto_kamar_mandi = $_FILES['foto_kamar_mandi']['name'];
    $foto_interior = $_FILES['foto_interior']['name'];
    $foto_1 = $_FILES['foto_bangunan_utama']['tmp_name'];
    $foto_2 = $_FILES['foto_kamar']['tmp_name'];
    $foto_3 = $_FILES['foto_kamar_mandi']['tmp_name'];
    $foto_4 = $_FILES['foto_interior']['tmp_name'];
    // move uploaded untuk pindahkan data
    move_uploaded_file($foto_1, "../../img/foto_kost/bangunan_utama/" . $foto_bangunan_utama);
    move_uploaded_file($foto_2, "../../img/foto_kost/kamar/" . $foto_kamar);
    move_uploaded_file($foto_3, "../../img/foto_kost/kamar_mandi/" . $foto_kamar_mandi);
    move_uploaded_file($foto_4, "../../img/foto_kost/interior/" . $foto_interior);
    //end uploaded

    // detail kost 
    $jenis_kost = $_POST['jenis_kost'];
    $tipe_kost = $_POST['tipe_kost'];
    $harga_sewa = $_POST['harga_sewa'];
    //id pemilik


    $username = $_SESSION['username'];
    $data = mysqli_query($koneksi, "SELECT * FROM user WHERE username='$username'");
    $d = mysqli_fetch_array($data);
    $pemilik = $d['id'];

    //end insilaisasi
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    //query insert
    $query = "INSERT INTO kost (
        nama_kost, tipe_kost, jenis_kost, tanggal_tagih, nama_pemilik, nama_bank, no_rekening, foto_bangunan_utama, foto_kamar, foto_kamar_mandi, kecamatan, kelurahan, kampus, alamat, latitude, longitude, harga_sewa, kontak, deskripsi, id_pemilik, fasilitas_kost
    ) VALUES (
        '$nama_kost', '$tipe_kost', '$jenis_kost', '$tanggal_tagih', '$nama_pemilik', '$nama_bank', '$no_rekening', '$foto_bangunan_utama', '$foto_kamar', '$foto_kamar_mandi', '$kecamatan', '$kelurahan', '$kampus', '$alamat', '$latitude', '$longitude', '$harga_sewa', '$kontak', '$deskripsi', '$pemilik', '$fasilitas'
    )";
    $tambah = mysqli_query($koneksi, $query);
    $id_kost = mysqli_insert_id($koneksi);
    if ($tambah) {
        header("location:../kamar.php?id_kost=$id_kost");
    } else {
        header("location:../tambah_kos.php");
        echo "<script>alert('gagal')</script>";
    }
}

?>


<!-- a  -->