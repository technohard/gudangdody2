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
    $periode       = mysqli_real_escape_string($mysqli, trim($_POST['periode']));
    $barang        = mysqli_real_escape_string($mysqli, $_POST['barang']);
    $saldo_awal        = mysqli_real_escape_string($mysqli, $_POST['saldo_awal']);

    $qry  = mysqli_query($mysqli, "SELECT id_barang FROM tbl_saldo WHERE id_barang='$barang' AND periode= '$periode' ");
    $rows = mysqli_num_rows($qry);
    $insert = false;
    if($rows<=0){
      //insert
      $id_transaksi = strtoupper(uniqid('TS-'));
      $insert = mysqli_query($mysqli, "INSERT INTO tbl_saldo (id_transaksi, periode, id_barang, saldo_awal) VALUES ('$id_transaksi','$periode', '$barang', '$saldo_awal')") or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
      
    }else{
      //update 
      $insert = mysqli_query($mysqli, "UPDATE tbl_saldo SET saldo_awal='$saldo_awal' WHERE periode = '$periode' AND id_barang='$barang' ") or die('Ada kesalahan pada query update : ' . mysqli_error($mysqli));
    }

    // jika proses insert berhasil
    if ($insert) {
      // alihkan ke halaman barang masuk dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=saldo_awal&pesan=1');
    }
  }
}
