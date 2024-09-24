<?php
session_start();      // mengaktifkan session



function InswInsertPengeluaranApi($mysqli,$id_transaksi, $tanggal_keluar, $barang, $jumlah, $jns_dok, $tgl_dok, $no_dok, $nama_pengirim)
{

  //string(10) "TK-0000001" string(10) "2024-06-05" string(6) "100006" string(1) "1" string(7) "0407631" string(10) "2024-06-05" string(14) "103/LDP-Keluar" string(5) "Sodik"
  //var_dump($id_transaksi, $tanggal_keluar, $barang, $jumlah, $jns_dok, $tgl_dok, $no_dok, $nama_pengirim);
  //exit;

  $status = true;

  //search barang
  $qry  = mysqli_query($mysqli, "SELECT a.*,b.nama_satuan 
  FROM 	tbl_barang a
  INNER JOIN tbl_satuan b ON a.satuan = b.id_satuan 
  WHERE id_barang='$barang'  
  ");
  $rows = mysqli_num_rows($qry);
  if($rows<=0){
    $status = false;
    return $status;
  }
  $rowBrg  = mysqli_fetch_assoc($qry);
  $kdKategoriBarang  = $rowBrg['jenis'];
  $kdBarang = $barang;
  $uraianBarang = $rowBrg['nama_barang'];
  $satuan = $rowBrg['nama_satuan'];
  $nilai = $rowBrg['nilai'];

  $tanggalKegiatan = substr($tanggal_keluar,8,2).'-'.substr($tanggal_keluar,5,2).'-'.substr($tanggal_keluar,0,4);
  $tanggalDokumen = substr($tgl_dok,8,2).'-'.substr($tgl_dok,5,2).'-'.substr($tgl_dok,0,4);

  $qryprofil = mysqli_query($mysqli, "SELECT * FROM tbl_profil WHERE npwp<>'' LIMIT 1")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  // ambil data hasil query
  $profil = mysqli_fetch_assoc($qryprofil);
  $npwp = $profil['npwp'];
  $nib = $profil['nib'];


  $postData = '{
    "data": [
      {
        "kdKegiatan": "31",
        "npwp": "'.$npwp.'",
        "nib": "'.$nib.'",
        "dokumenKegiatan": [
          {
            "nomorDokKegiatan": "'.$id_transaksi.'",
            "tanggalKegiatan": "'.$tanggalKegiatan.'",
            "namaEntitas": "'.$nama_pengirim.'",
            "barangTransaksi": [
              {
                "kdKategoriBarang": "'.$kdKategoriBarang.'",
                "kdBarang": "'.$kdBarang.'",
                "uraianBarang": "'.$uraianBarang.'",
                "jumlah": '.$jumlah.',
                "kdSatuan": "'.$satuan.'",
                "nilai": '.$nilai.',
                "dokumen": [
                  {
                    "kodeDokumen": "'.$jns_dok.'",
                    "nomorDokumen": "'.$no_dok.'",
                    "tanggalDokumen": "'.$tanggalDokumen.'"
                  }
                ]
              }
            ]
          }
        ]
      }
    ]
  }';


  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.insw.go.id/api-prod/inventory/pemasukan/tempInsert',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => $postData,
    CURLOPT_HTTPHEADER => array(
          'x-insw-key: RqT40lH7Hy202uUybBLkFhtNnfAvxrlp',
          'Content-Type: application/json',
          'Cookie: cookiesession1=678B2903FA2DC1A102FB47B2A486A316'
    ),
  ));

  $response = curl_exec($curl);
  curl_close($curl);
  //echo $response;
  $responseString = (string) $response; 
  $tglLog = date('Y-m-d H:i:s');
  $uraianLog = mysqli_real_escape_string($mysqli, $responseString);
  $modulLog = 'PENGELUARAN';
  $insert = mysqli_query($mysqli, "INSERT INTO tbl_log (tanggal, uraian, modul,ref) VALUES ('$tglLog','$uraianLog','$modulLog','$id_transaksi')");

  return $status;
}

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
    
    $nama_pengirim   = mysqli_real_escape_string($mysqli, $_POST['nama_pengirim']);
    $nama_penerima   = mysqli_real_escape_string($mysqli, $_POST['nama_penerima']);

    // ubah format tanggal menjadi Tahun-Bulan-Hari (Y-m-d) sebelum disimpan ke database  
    $tanggal_keluar = date('Y-m-d', strtotime($tanggal));

    $sqlInsert = "INSERT INTO tbl_barang_keluar(id_transaksi, tanggal, barang, jumlah, jns_dok, tgl_dok, no_dok, nama_pengirim, nama_penerima) 
    VALUES('$id_transaksi', '$tanggal_keluar', '$barang', '$jumlah' , '$jns_dok', ";
    if ($tgl_dok === NULL) {
        $sqlInsert .= "NULL";
    } else {
        $sqlInsert .= "'$tgl_dok'";
    }
    $sqlInsert .= ", '$no_dok', '$nama_pengirim', '$nama_penerima')";

    // sql statement untuk insert data ke tabel "tbl_barang_keluar"
    $insert = mysqli_query($mysqli, $sqlInsert)
                                     or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));
    // cek query
    // jika proses insert berhasil
    if ($insert) {

      $status = InswInsertPengeluaranApi($mysqli,$id_transaksi, $tanggal_keluar, $barang, $jumlah, $jns_dok, $tgl_dok, $no_dok, $nama_pengirim);

      // alihkan ke halaman barang keluar dan tampilkan pesan berhasil simpan data
      header('location: ../../main.php?module=barang_keluar&pesan=1');
    }
  }
}
