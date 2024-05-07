<?php
session_start();      // mengaktifkan session

// panggil file "autoload.inc.php" untuk load dompdf, libraries, dan helper functions
require_once("../../assets/js/plugin/dompdf/autoload.inc.php");
// mereferensikan Dompdf namespace
use Dompdf\Dompdf;

function akumulasiSaldoAwal($tgl1,$tgl2,$id_barang,$mysqli){
  $saldo = 0;
  //2024-04-01
  //0123456789
  $day = substr($tgl1,8,2);
  $month = substr($tgl1,5,2);
  $year = substr($tgl1,0,4);
  $tgl_awalx=$year.'-'.$month.'-'.'01';
  


    //total saldo masuk sebelum tgl akhir
    //hitung data masuk
    $qrymasukx = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal < '$tgl1' AND a.barang = '$id_barang' ; ") 
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $res = ($qrymasukx) ? mysqli_fetch_assoc($qrymasukx) : 0;
    $saldo_masukx = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

    //hitung data keluar
    $qrykeluarx = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE  a.tanggal < '$tgl1' AND a.barang = '$id_barang' ; ") 
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $res = ($qrykeluarx) ? mysqli_fetch_assoc($qrykeluarx) : 0;
    $saldo_keluarx = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

    //hitung data penyesuaian
    $qryadjx = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE  a.tanggal < '$tgl1' AND a.barang = '$id_barang' ; ") 
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $res = ($qryadjx) ? mysqli_fetch_assoc($qryadjx) : 0;
    $saldo_adjustmentx = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 

    $saldo = ( $saldo_masukx - $saldo_keluarx ) + $saldo_adjustmentx;

  

  return $saldo;
}

function akumulasiStokOpname($tgl1,$tgl2,$id_barang,$mysqli){

  $saldo = 0;
  //2024-04-01
  //0123456789
  $day = substr($tgl1,8,2);
  $month = substr($tgl1,5,2);
  $year = substr($tgl1,0,4);
  $tgl_awalx=$year.'-'.$month.'-'.'01';
  
  

    //hitung data stok opname
    $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE  a.tanggal < '$tgl1' AND a.barang = '$id_barang' ; ") 
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
    $stock_opnamex = (isset($res['stock_opname']))? $res['stock_opname'] : 0; 

    $saldo = $stock_opnamex;

  

  return $saldo;

}

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk cetak
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  // panggil file "fungsi_tanggal_indo.php" untuk membuat format tanggal indonesia
  require_once "../../helper/fungsi_tanggal_indo.php";

  // ambil data GET dari tombol cetak
  $stok = $_GET['stok'];
  $tanggal_awal  = isset($_GET['tanggal_awal'])?$_GET['tanggal_awal']:'';
  $tanggal_akhir  = isset($_GET['tanggal_akhir'])?$_GET['tanggal_akhir']:'';
  $jenis  = isset($_GET['jenis'])?$_GET['jenis']:'';

  $tanggal_awalx  = date('d-m-Y', strtotime($tanggal_awal));
  $tanggal_akhirx = date('d-m-Y', strtotime($tanggal_akhir));

  // variabel untuk nomor urut tabel 
  $no = 1;

  // gunakan dompdf class
  $dompdf = new Dompdf();
  // setting options
  $options = $dompdf->getOptions();
  $options->setIsRemoteEnabled(true); // aktifkan akses file untuk bisa mengakses file gambar dan CSS
  //$options->setChroot('C:\xampp\htdocs\gudang'); // tentukan path direktori aplikasi
  $dompdf->setOptions($options);

  // mengecek filter data stok
  // jika filter data stok "Seluruh" dipilih, tampilkan laporan stok seluruh barang
  if ($stok == 'Seluruh') {
    // halaman HTML yang akan diubah ke PDF
    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Seluruh Barang</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h4 style="margin-bottom:2px;padding-bottom:2px;">LAPORAN STOK SELURUH BARANG</h4>
                <h4 style="margin-top:2px;padding-top:2px;">Periode : '.$tanggal_awalx.' s/d '.$tanggal_akhirx.'</h4>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Saldo Awal</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Penyesuaian</th>
                      <th>Saldo Akhir</th>
                      <th>Stok Opname</th>
                      <th>Selisih</th>
                      <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';

                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
    ORDER BY a.id_barang ASC")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {

      $saldo_awal = 0;
      $stock_opname = 0;
      $id_barang = $data['id_barang'];

      

      //hitung saldo awal
      $periode = substr($tanggal_awal,0,4).substr($tanggal_awal,5,2);
      $qrysawal = mysqli_query($mysqli,"SELECT a.saldo_awal FROM tbl_saldo a WHERE a.periode='$periode' AND a.id_barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrysawal) ? mysqli_fetch_assoc($qrysawal) : 0;
      $saldo_awal = (isset($res['saldo_awal']))? $res['saldo_awal'] : 0; 

      $saldo_akumulasi=akumulasiSaldoAwal($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $saldo_awal = $saldo_awal + $saldo_akumulasi;
      
      //hitung data masuk
      $qrymasuk = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrymasuk) ? mysqli_fetch_assoc($qrymasuk) : 0;
      $saldo_masuk = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

      //hitung data keluar
      $qrykeluar = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrykeluar) ? mysqli_fetch_assoc($qrykeluar) : 0;
      $saldo_keluar = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

      //hitung data penyesuaian
      $qryadj = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryadj) ? mysqli_fetch_assoc($qryadj) : 0;
      $saldo_adjustment = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 
      
      //hitung data stok opname
      $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
      $stock_opname = (isset($res['stock_opname']))? $res['stock_opname'] : 0;
      
      $saldo_akumulasi=akumulasiStokOpname($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $stock_opname = $stock_opname + $saldo_akumulasi;

      $saldo_barang = $saldo_awal + ($saldo_masuk - $saldo_keluar) + $saldo_adjustment ; 
      $selisih = 0;
      if($stock_opname<>0 && $stock_opname <= $saldo_barang){
        //hasil minus
        $selisih = $saldo_barang - $stock_opname;
      }
      if($stock_opname<>0 && $stock_opname >= $saldo_barang){
        //hasil positif
        $selisih = $stock_opname - $saldo_barang ;
      }


      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td width="80" class="text-center">' . $data['id_barang'] . '</td>
                      <td width="200">' . $data['nama_jenis'] . '</td>
                      <td width="200">' . $data['nama_barang'] . '</td>
                      <td width="50">' . $data['nama_satuan'] . '</td>
                      <td width="150">' . $saldo_awal . '</td>
                      <td width="150">' . $saldo_masuk . '</td>
                      <td width="150">' . $saldo_keluar . '</td>
                      <td width="150">' . $saldo_adjustment . '</td>
                      <td width="150">' . $saldo_barang . '</td>
                      <td width="150">' . $stock_opname . '</td>
                      <td width="150">' . $selisih . '</td>
                      <td width="150">' . ' ' . '</td>
                    </tr>';      
    
    
    }


    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';

    echo $html;
    exit;
        

    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Seluruh Barang.pdf', array('Attachment' => 0));

  }elseif ($jenis == 'Seluruh') {

    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Seluruh Barang</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h1>LAPORAN STOK SELURUH JENIS BARANG</h1>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Saldo Awal</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Penyesuaian</th>
                      <th>Saldo Akhir</th>
                      <th>Stok Opname</th>
                      <th>Selisih</th>
                      <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';

                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
    ORDER BY a.id_barang ASC")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {

      $saldo_awal = 0;
      $stock_opname = 0;
      $id_barang = $data['id_barang'];

      //hitung saldo awal
      $periode = substr($tanggal_awal,0,4).substr($tanggal_awal,5,2);
      $qrysawal = mysqli_query($mysqli,"SELECT a.saldo_awal FROM tbl_saldo a WHERE a.periode='$periode' AND a.id_barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrysawal) ? mysqli_fetch_assoc($qrysawal) : 0;
      $saldo_awal = (isset($res['saldo_awal']))? $res['saldo_awal'] : 0;
      
      $saldo_akumulasi=akumulasiSaldoAwal($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $saldo_awal = $saldo_awal + $saldo_akumulasi;
      
      //hitung data masuk
      $qrymasuk = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrymasuk) ? mysqli_fetch_assoc($qrymasuk) : 0;
      $saldo_masuk = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

      //hitung data keluar
      $qrykeluar = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrykeluar) ? mysqli_fetch_assoc($qrykeluar) : 0;
      $saldo_keluar = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

      //hitung data penyesuaian
      $qryadj = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryadj) ? mysqli_fetch_assoc($qryadj) : 0;
      $saldo_adjustment = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 
      
      //hitung data stok opname
      $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
      $stock_opname = (isset($res['stock_opname']))? $res['stock_opname'] : 0;
      
      $saldo_akumulasi=akumulasiStokOpname($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $stock_opname = $stock_opname + $saldo_akumulasi;

      $saldo_barang = $saldo_awal + ($saldo_masuk - $saldo_keluar) + $saldo_adjustment ; 
      $selisih = 0;
      if($stock_opname<>0 && $stock_opname <= $saldo_barang){
        //hasil minus
        $selisih = $saldo_barang - $stock_opname;
      }
      if($stock_opname<>0 && $stock_opname >= $saldo_barang){
        //hasil positif
        $selisih = $stock_opname - $saldo_barang ;
      }


      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td width="80" class="text-center">' . $data['id_barang'] . '</td>
                      <td width="200">' . $data['nama_jenis'] . '</td>
                      <td width="200">' . $data['nama_barang'] . '</td>
                      <td width="50">' . $data['nama_satuan'] . '</td>
                      <td width="150">' . $saldo_awal . '</td>
                      <td width="150">' . $saldo_masuk . '</td>
                      <td width="150">' . $saldo_keluar . '</td>
                      <td width="150">' . $saldo_adjustment . '</td>
                      <td width="150">' . $saldo_barang . '</td>
                      <td width="150">' . $stock_opname . '</td>
                      <td width="150">' . $selisih . '</td>
                      <td width="150">' . ' ' . '</td>
                    </tr>';      
    
    
    }


    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';

    echo $html;
    exit;


    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Seluruh Barang.pdf', array('Attachment' => 0));



  }elseif ($stok != 'Seluruh' && $jenis=='') {

    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Seluruh Barang</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h1>LAPORAN STOK BARANG '.strtoupper($stok).' </h1>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Saldo Awal</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Penyesuaian</th>
                      <th>Saldo Akhir</th>
                      <th>Stok Opname</th>
                      <th>Selisih</th>
                      <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';

                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
    WHERE a.nama_barang = '$stok'
    ORDER BY a.id_barang ASC")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {

      $saldo_awal = 0;
      $stock_opname = 0;
      $id_barang = $data['id_barang'];

      //hitung saldo awal
      $periode = substr($tanggal_awal,0,4).substr($tanggal_awal,5,2);
      $qrysawal = mysqli_query($mysqli,"SELECT a.saldo_awal FROM tbl_saldo a WHERE a.periode='$periode' AND a.id_barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrysawal) ? mysqli_fetch_assoc($qrysawal) : 0;
      $saldo_awal = (isset($res['saldo_awal']))? $res['saldo_awal'] : 0;
      
      $saldo_akumulasi=akumulasiSaldoAwal($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $saldo_awal = $saldo_awal + $saldo_akumulasi;
      
      //hitung data masuk
      $qrymasuk = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrymasuk) ? mysqli_fetch_assoc($qrymasuk) : 0;
      $saldo_masuk = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

      //hitung data keluar
      $qrykeluar = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrykeluar) ? mysqli_fetch_assoc($qrykeluar) : 0;
      $saldo_keluar = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

      //hitung data penyesuaian
      $qryadj = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryadj) ? mysqli_fetch_assoc($qryadj) : 0;
      $saldo_adjustment = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 
      
      //hitung data stok opname
      $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
      $stock_opname = (isset($res['stock_opname']))? $res['stock_opname'] : 0;
      
      $saldo_akumulasi=akumulasiStokOpname($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $stock_opname = $stock_opname + $saldo_akumulasi;

      $saldo_barang = $saldo_awal + ($saldo_masuk - $saldo_keluar) + $saldo_adjustment ; 
      $selisih = 0;
      if($stock_opname<>0 && $stock_opname <= $saldo_barang){
        //hasil minus
        $selisih = $saldo_barang - $stock_opname;
      }
      if($stock_opname<>0 && $stock_opname >= $saldo_barang){
        //hasil positif
        $selisih = $stock_opname - $saldo_barang ;
      }


      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td width="80" class="text-center">' . $data['id_barang'] . '</td>
                      <td width="200">' . $data['nama_jenis'] . '</td>
                      <td width="200">' . $data['nama_barang'] . '</td>
                      <td width="50">' . $data['nama_satuan'] . '</td>
                      <td width="150">' . $saldo_awal . '</td>
                      <td width="150">' . $saldo_masuk . '</td>
                      <td width="150">' . $saldo_keluar . '</td>
                      <td width="150">' . $saldo_adjustment . '</td>
                      <td width="150">' . $saldo_barang . '</td>
                      <td width="150">' . $stock_opname . '</td>
                      <td width="150">' . $selisih . '</td>
                      <td width="150">' . ' ' . '</td>
                    </tr>';      
    
    
    }


    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';

    echo $html;
    exit;

    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Seluruh Barang.pdf', array('Attachment' => 0));



  }elseif ($jenis != 'Seluruh' && $stok == '') {

    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Seluruh Barang</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h1>LAPORAN STOK JENIS BARANG '.strtoupper($jenis).'</h1>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Saldo Awal</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Penyesuaian</th>
                      <th>Saldo Akhir</th>
                      <th>Stok Opname</th>
                      <th>Selisih</th>
                      <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';

                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
    WHERE b.nama_jenis = '$jenis'
    ORDER BY a.id_barang ASC")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {

      $saldo_awal = 0;
      $stock_opname = 0;
      $id_barang = $data['id_barang'];

      //hitung saldo awal
      $periode = substr($tanggal_awal,0,4).substr($tanggal_awal,5,2);
      $qrysawal = mysqli_query($mysqli,"SELECT a.saldo_awal FROM tbl_saldo a WHERE a.periode='$periode' AND a.id_barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrysawal) ? mysqli_fetch_assoc($qrysawal) : 0;
      $saldo_awal = (isset($res['saldo_awal']))? $res['saldo_awal'] : 0; 

      $saldo_akumulasi=akumulasiSaldoAwal($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $saldo_awal = $saldo_awal + $saldo_akumulasi;
      
      //hitung data masuk
      $qrymasuk = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrymasuk) ? mysqli_fetch_assoc($qrymasuk) : 0;
      $saldo_masuk = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

      //hitung data keluar
      $qrykeluar = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrykeluar) ? mysqli_fetch_assoc($qrykeluar) : 0;
      $saldo_keluar = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

      //hitung data penyesuaian
      $qryadj = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryadj) ? mysqli_fetch_assoc($qryadj) : 0;
      $saldo_adjustment = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 
      
      //hitung data stok opname
      $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
      $stock_opname = (isset($res['stock_opname']))? $res['stock_opname'] : 0;
      
      $saldo_akumulasi=akumulasiStokOpname($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $stock_opname = $stock_opname + $saldo_akumulasi;

      $saldo_barang = $saldo_awal + ($saldo_masuk - $saldo_keluar) + $saldo_adjustment ; 
      $selisih = 0;
      if($stock_opname<>0 && $stock_opname <= $saldo_barang){
        //hasil minus
        $selisih = $saldo_barang - $stock_opname;
      }
      if($stock_opname<>0 && $stock_opname >= $saldo_barang){
        //hasil positif
        $selisih = $stock_opname - $saldo_barang ;
      }


      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td width="80" class="text-center">' . $data['id_barang'] . '</td>
                      <td width="200">' . $data['nama_jenis'] . '</td>
                      <td width="200">' . $data['nama_barang'] . '</td>
                      <td width="50">' . $data['nama_satuan'] . '</td>
                      <td width="150">' . $saldo_awal . '</td>
                      <td width="150">' . $saldo_masuk . '</td>
                      <td width="150">' . $saldo_keluar . '</td>
                      <td width="150">' . $saldo_adjustment . '</td>
                      <td width="150">' . $saldo_barang . '</td>
                      <td width="150">' . $stock_opname . '</td>
                      <td width="150">' . $selisih . '</td>
                      <td width="150">' . ' ' . '</td>
                    </tr>';      
    
    
    }


    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';
    
    echo $html;
    exit;

    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Seluruh Barang.pdf', array('Attachment' => 0));
  // jika filter data stok "Minimum" dipilih, tampilkan laporan stok barang yang mencapai batas minimum
   } else {
    // halaman HTML yang akan diubah ke PDF
    $html = '<!DOCTYPE html>
            <html>
            <head>
              <title>Laporan Stok Seluruh Barang</title>
              <link rel="stylesheet" href="../../assets/css/laporan.css">
            </head>
            <body class="text-dark">
              <div class="text-center mb-4">
                <h1>LAPORAN STOK SELURUH BARANG</h1>
              </div>
              <hr>
              <div class="mt-4">
                <table class="table table-bordered" width="100%" cellspacing="0">
                  <thead class="bg-secondary text-white text-center">
                    <tr>
                      <th>No.</th>
                      <th>Kode Barang</th>
                      <th>Kategori</th>
                      <th>Nama Barang</th>
                      <th>Satuan</th>
                      <th>Saldo Awal</th>
                      <th>Pemasukan</th>
                      <th>Pengeluaran</th>
                      <th>Penyesuaian</th>
                      <th>Saldo Akhir</th>
                      <th>Stok Opname</th>
                      <th>Selisih</th>
                      <th>Ket</th>
                    </tr>
                  </thead>
                  <tbody class="text-dark">';

                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"
    $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
    FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
    ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
    ORDER BY a.id_barang ASC")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    // ambil data hasil query
    while ($data = mysqli_fetch_assoc($query)) {

      $saldo_awal = 0;
      $stock_opname = 0;
      $id_barang = $data['id_barang'];

      //hitung saldo awal
      $periode = substr($tanggal_awal,0,4).substr($tanggal_awal,5,2);
      $qrysawal = mysqli_query($mysqli,"SELECT a.saldo_awal FROM tbl_saldo a WHERE a.periode='$periode' AND a.id_barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrysawal) ? mysqli_fetch_assoc($qrysawal) : 0;
      $saldo_awal = (isset($res['saldo_awal']))? $res['saldo_awal'] : 0;
      
      $saldo_akumulasi=akumulasiSaldoAwal($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $saldo_awal = $saldo_awal + $saldo_akumulasi;
      
      //hitung data masuk
      $qrymasuk = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_masuk FROM tbl_barang_masuk a WHERE  a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrymasuk) ? mysqli_fetch_assoc($qrymasuk) : 0;
      $saldo_masuk = (isset($res['saldo_masuk']))? $res['saldo_masuk'] : 0; 

      //hitung data keluar
      $qrykeluar = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_keluar FROM tbl_barang_keluar a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qrykeluar) ? mysqli_fetch_assoc($qrykeluar) : 0;
      $saldo_keluar = (isset($res['saldo_keluar']))? $res['saldo_keluar'] : 0; 

      //hitung data penyesuaian
      $qryadj = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as saldo_adjustment FROM tbl_adjustment a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryadj) ? mysqli_fetch_assoc($qryadj) : 0;
      $saldo_adjustment = (isset($res['saldo_adjustment']))? $res['saldo_adjustment'] : 0; 
      
      //hitung data stok opname
      $qryso = mysqli_query($mysqli,"SELECT SUM(a.jumlah) as stock_opname FROM tbl_stok_opname a WHERE a.tanggal BETWEEN '$tanggal_awal' AND '$tanggal_akhir' AND a.barang = '$id_barang' ; ") 
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
      $res = ($qryso) ? mysqli_fetch_assoc($qryso) : 0;
      $stock_opname = (isset($res['stock_opname']))? $res['stock_opname'] : 0;
      
      $saldo_akumulasi=akumulasiStokOpname($tanggal_awal,$tanggal_akhir,$id_barang,$mysqli);
      $stock_opname = $stock_opname + $saldo_akumulasi;

      $saldo_barang = $saldo_awal + ($saldo_masuk - $saldo_keluar) + $saldo_adjustment ; 
      $selisih = 0;
      if($stock_opname<>0 && $stock_opname <= $saldo_barang){
        //hasil minus
        $selisih = $saldo_barang - $stock_opname;
      }
      if($stock_opname<>0 && $stock_opname >= $saldo_barang){
        //hasil positif
        $selisih = $stock_opname - $saldo_barang ;
      }


      // tampilkan data
      $html .= '		<tr>
                      <td width="50" class="text-center">' . $no++ . '</td>
                      <td width="80" class="text-center">' . $data['id_barang'] . '</td>
                      <td width="200">' . $data['nama_jenis'] . '</td>
                      <td width="200">' . $data['nama_barang'] . '</td>
                      <td width="50">' . $data['nama_satuan'] . '</td>
                      <td width="150">' . $saldo_awal . '</td>
                      <td width="150">' . $saldo_masuk . '</td>
                      <td width="150">' . $saldo_keluar . '</td>
                      <td width="150">' . $saldo_adjustment . '</td>
                      <td width="150">' . $saldo_barang . '</td>
                      <td width="150">' . $stock_opname . '</td>
                      <td width="150">' . $selisih . '</td>
                      <td width="150">' . ' ' . '</td>
                    </tr>';      
    
    
    }


    $html .= '		</tbody>
                </table>
              </div>
              <div class="text-right mt-5">............, ' . tanggal_indo(date('Y-m-d')) . '</div>
            </body>
            </html>';

    echo $html;
    exit;

    // load html
    $dompdf->loadHtml($html);
    // mengatur ukuran dan orientasi kertas
    $dompdf->setPaper('A4', 'landscape');
    // mengubah dari HTML menjadi PDF
    $dompdf->render();
    // menampilkan file PDF yang dihasilkan ke browser dan berikan nama file "Laporan Stok Seluruh Barang.pdf"
    $dompdf->stream('Laporan Stok Seluruh Barang.pdf', array('Attachment' => 0));
  }
}
