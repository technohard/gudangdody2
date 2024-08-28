<?php
session_start();      // mengaktifkan session


function InswSaldoAwalFinalApi($mysqli,$npwp)
{
  
  $status = true;
  $qryprofil = mysqli_query($mysqli, "SELECT * FROM tbl_profil WHERE npwp<>'' LIMIT 1")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  $profil = mysqli_fetch_assoc($qryprofil);
  $npwp = $profil['npwp'];
  $id_transaksi = strtoupper(uniqid('SAF'));

  $postData = '{ "npwp": "'.$npwp.'" }';

  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.insw.go.id/api-prod/inventory/tempFinalisasiRegistrasi',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => array(
          'x-insw-key: RqT40lH7Hy202uUybBLkFhtNnfAvxrlp',
          'Content-Type: application/json',
          'Cookie: cookiesession1=678B2903FA2DC1A102FB47B2A486A316'
    ),
  ));

  $response = curl_exec($curl);

  $data = [];
  // Check for errors
  if(curl_errno($curl)){
    //echo 'Curl error: ' . curl_error($curl);
    $status = false;
  } else {
    // Parse JSON response
    $data = json_decode($response, true); // true for associative array

    // Check if json_decode succeeded
    if (json_last_error() === JSON_ERROR_NONE) {
        // Use $data as needed
        //print_r($data);
        $status = true;

    } else {
      $status = false;
      //echo 'JSON decoding error: ' . json_last_error_msg();
    }
  }

  curl_close($curl);
  //echo $response;
  $responseString = (string) $response; 
  $tglLog = date('Y-m-d H:i:s');
  $uraianLog = mysqli_real_escape_string($mysqli, $responseString);
  $modulLog = 'SALDO AWAL FINAL';
  $insert = mysqli_query($mysqli, "INSERT INTO tbl_log (tanggal, uraian, modul,ref) VALUES ('$tglLog','$uraianLog','$modulLog','$id_transaksi')");

  return [
    'status' => $status,
    'data' => $data,
  ];
}


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
    $npwp = mysqli_real_escape_string($mysqli, trim($_POST['npwp']));

    $astatus = InswSaldoAwalFinalApi($mysqli,$npwp);
    $message = (isset($astatus['data']['message']))?$astatus['data']['message']:'';
    $message2 = (isset($astatus['data']['data']['message']))?$astatus['data']['data']['message']:'';

      // cek query
      // jika proses update berhasil
      if ($astatus['status']) {
        // alihkan ke halaman user dan tampilkan pesan berhasil ubah data
        header('location: ../../main.php?module=saldo_awal_final&pesan=1&message='.$message.' '.$message2);
      }else{
        header('location: ../../main.php?module=saldo_awal_final&pesan=4&message='.$message.' '.$message2);
      }
  }
}
