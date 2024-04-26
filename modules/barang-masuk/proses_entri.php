<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk insert
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_transaksi  = mysqli_real_escape_string($mysqli, $_POST['id_transaksi']);
    $tanggal       = mysqli_real_escape_string($mysqli, trim($_POST['tanggal']));
    $barang        = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $jumlah        = mysqli_real_escape_string($mysqli, $_POST['jumlah']);
    $no_dok         = mysqli_real_escape_string($mysqli, $_POST['no_dok']);
    $jns_dok         = mysqli_real_escape_string($mysqli, $_POST['jns_dok']);
    $tgl_dok         = mysqli_real_escape_string($mysqli, $_POST['tgl_dok']);

    if(!empty($tgl_dok) || $tgl_dok!==""){

      $day = substr($tgl_dok, 0, 2);
      $month = substr($tgl_dok, 3, 2);
      $year = substr($tgl_dok, 6, 4);
      // Format the date as "Y-m-d"
      $tgl_dok = $year . "-" . $month . "-" . $day;
    }else{
      $tgl_dok = null;
    }
    
    $nama_pengirim  = mysqli_real_escape_string($mysqli, $_POST['nama_pengirim']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database
    $tanggal_masuk = date('Y-m-d', strtotime($tanggal));

    $sqlInsert = "INSERT INTO tbl_barang_masuk(id_transaksi, tanggal, barang, jumlah, jns_dok, tgl_dok, no_dok, nama_pengirim) 
    VALUES('$id_transaksi', '$tanggal_masuk', '$barang', '$jumlah', '$jns_dok', ";
    if ($tgl_dok === NULL) {
        $sqlInsert .= "NULL";
    } else {
        $sqlInsert .= "'$tgl_dok'";
    }
    $sqlInsert .= ", '$no_dok', '$nama_pengirim')";

    // sql statement untuk insert data ke tabel "tbl_barang_masuk"
    $insert = mysqli_query($mysqli, $sqlInsert)
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang masuk dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_masuk&pesan=1');
    }
  }
}
