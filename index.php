<?php
// index.php adalah file yang dipanggil pertama kali saat user mengakses sebuah alamat website
// disini file index.php hanya digunakan untuk pengalihan halaman 
// alihkan ke halaman login
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");
header('location: login.php');
?>