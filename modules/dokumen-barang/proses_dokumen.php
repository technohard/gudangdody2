<?php
session_start();      // mengaktifkan session


function InswDokumenBarangApi($mysqli, $npwp, $tipe_dokumen, $idtrans, $kodeDokumen, $nomorDokumen, $tanggalDokumen)
{

  //string(15) "027681030529000" string(11) "idTransaksi" string(36) "357b9319-d64f-4342-86ed-fdf8b3cf838d" string(7) "0407611" string(6) "000004" string(10) "02-02-2024"
  //var_dump($npwp, $tipe_dokumen, $idtrans, $kodeDokumen, $nomorDokumen, $tanggalDokumen);
  //exit;

  $status = true;
  $qryprofil = mysqli_query($mysqli, "SELECT * FROM tbl_profil WHERE npwp<>'' LIMIT 1")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  $profil = mysqli_fetch_assoc($qryprofil);
  $npwp = $profil['npwp'];
  $id_transaksi = strtoupper(uniqid('DOB'));
  $tanggalDokumenx = substr($tanggalDokumen, 8, 2) . '-' . substr($tanggalDokumen, 5, 2) . '-' . substr($tanggalDokumen, 0, 4);

  $curl = curl_init();

  if ($tipe_dokumen == 'idTransaksi') {
    $apiurl = 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempDokumen?idTransaksi=' . $idtrans;
  }

  if ($tipe_dokumen == 'idBarangTransaksi') {
    $apiurl = 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempDokumen?idBarangTransaksi=' . $idtrans;
  }

  if ($tipe_dokumen == '') {
    $apiurl = 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempDokumen?idTransaksi=xyz';
  }


  curl_setopt_array($curl, array(
      CURLOPT_URL => $apiurl,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'PUT',
      CURLOPT_POSTFIELDS => '{
        "npwp":  "' . $npwp . '",
        "kodeDokumen": "' . $kodeDokumen . '",
        "nomorDokumen": "' . $nomorDokumen . '",
        "tanggalDokumen": "' . $tanggalDokumenx . '"
      }',
      CURLOPT_HTTPHEADER => array(
        'x-insw-key: RqT40lH7Hy202uUybBLkFhtNnfAvxrlp',
        'Content-Type: application/json',
        'Cookie: cookiesession1=678B2903FA2DC1A102FB47B2A486A316'
    ),
  ));


  $response = curl_exec($curl);

  $data = [];
  // Check for errors
  if (curl_errno($curl)) {
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
  $modulLog = 'DOKUMEN BARANG';
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
    $tipe_dokumen = mysqli_real_escape_string($mysqli, trim($_POST['tipe_dokumen']));
    $idtrans = mysqli_real_escape_string($mysqli, trim($_POST['idtrans']));
    $kodeDokumen = mysqli_real_escape_string($mysqli, trim($_POST['kodeDokumen']));
    $nomorDokumen = mysqli_real_escape_string($mysqli, trim($_POST['nomorDokumen']));
    $tanggalDokumen = mysqli_real_escape_string($mysqli, trim($_POST['tanggalDokumen']));

    $astatus = InswDokumenBarangApi($mysqli, $npwp, $tipe_dokumen, $idtrans, $kodeDokumen, $nomorDokumen, $tanggalDokumen);
    $message = (isset($astatus['data']['message'])) ? $astatus['data']['message'] : '';

    // cek query
    // jika proses update berhasil
    if ($astatus['status']) {
      // alihkan ke halaman user dan tampilkan pesan berhasil ubah data
      header('location: ../../main.php?module=dokumen_barang&pesan=1&message=' . $message);
    } else {
      header('location: ../../main.php?module=dokumen_barang&pesan=4&message=' . $message);
    }
  }
}
