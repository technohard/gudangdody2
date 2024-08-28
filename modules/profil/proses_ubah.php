<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk update
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";

  // mengecek data hasil submit dari form
  if (isset($_POST['simpan'])) {
    // ambil data hasil submit dari form
    $id_profil   = mysqli_real_escape_string($mysqli, $_POST['id_profil']);
    $nama = mysqli_real_escape_string($mysqli, trim($_POST['nama']));
    $npwp = mysqli_real_escape_string($mysqli, trim($_POST['npwp']));
    $nib = mysqli_real_escape_string($mysqli, trim($_POST['nib']));


    $update = mysqli_query($mysqli, "UPDATE tbl_profil
                                         SET nama='$nama', npwp='$npwp', nib='$nib'
                                         WHERE id_profil='$id_profil'")
                                         or die('Ada kesalahan pada query update : ' . mysqli_error($mysqli));

      // cek query
      // jika proses update berhasil
      if ($update) {
        // alihkan ke halaman user dan tampilkan pesan berhasil ubah data
        header('location: ../../main.php?module=form_ubah_profil&pesan=1');
      }
  }
}
