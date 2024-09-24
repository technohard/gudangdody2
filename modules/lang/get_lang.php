<?php
header("Access-Control-Allow-Origin: *");
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
  header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
  header("Access-Control-Max-Age: 86400");
  exit(0);
}
session_start();
// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
// jika ada ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../lang.php";

  // mengecek data GET dari ajax
  if (isset($_GET['lang'])) {
    // ambil data GET dari ajax
    $lang = $_GET['lang'];
    saveLang($lang);

    // kirimkan data
    echo json_encode($lang);
  }
}
// jika tidak ada ajax request
else {
  // alihkan ke halaman error 404
  header('location: ../../404.html');
}
