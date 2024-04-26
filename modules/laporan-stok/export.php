<?php
session_start();      // mengaktifkan session

// pengecekan session login user 
// jika user belum login
if (empty($_SESSION['username']) && empty($_SESSION['password'])) {
  // alihkan ke halaman login dan tampilkan pesan peringatan login
  header('location: ../../login.php?pesan=2');
}
// jika user sudah login, maka jalankan perintah untuk export
else {
  // panggil file "database.php" untuk koneksi ke database
  require_once "../../config/database.php";
  // panggil file "fungsi_tanggal_indo.php" untuk membuat format tanggal indonesia
  require_once "../../helper/fungsi_tanggal_indo.php";

  // ambil data GET dari tombol export
  $stok = $_GET['stok'];

  // variabel untuk nomor urut tabel 
  $no = 1;

  // mengecek filter data stok
  // jika filter data stok "Seluruh" dipilih, tampilkan laporan stok seluruh barang
  if ($stok == 'Seluruh') {
    // fungsi header untuk mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
    // mendefinisikan nama file hasil ekspor "Laporan Stok Seluruh Barang.xls"
    header("Content-Disposition: attachment; filename=Laporan Stok Seluruh Barang.xls");
?>
    <!-- halaman HTML yang akan diexport ke excel -->
    <!-- judul tabel -->
    <center>
      <h4>LAPORAN STOK SELURUH BARANG</h4>
    </center>
    <!-- tabel untuk menampilkan data dari database -->
    <table border="1">
      <thead>
        <tr style="background-color:#6861ce;color:#fff">

          <th height="30" align="center" vertical="center" class="text-center">No.</th>
          <th height="30" align="center" vertical="center" class="text-center">Kode Barang</th>
          <th height="30" align="center" vertical="center" class="text-center">Ketegori Barang</th>
          <th height="30" align="center" vertical="center" class="text-center">Nama Barang</th>
          <th height="30" align="center" vertical="center" class="text-center">Satuan</th>
          <th height="30" align="center" vertical="center" class="text-center">Saldo Awal</th>
          <th height="30" align="center" vertical="center" class="text-center">Pemasukan</th>
          <th height="30" align="center" vertical="center" class="text-center">Pengeluaran</th>
          <th height="30" align="center" vertical="center" class="text-center">Penyesuaian</th>
          <th height="30" align="center" vertical="center" class="text-center">Saldo Barang</th>
          <th height="30" align="center" vertical="center" class="text-center">Stock Opname</th>
          <th height="30" align="center" vertical="center" class="text-center">Selisih</th>

        </tr>
      </thead>
      <tbody>
        <?php
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

          ?>
          <!-- tampilkan data -->
          <tr>
            <td width="50" class="text-center"><?php echo $no++; ?></td>
            <td width="80"><?php echo $data['id_barang']; ?></td>
            <td width="150"><?php echo $data['nama_jenis']; ?></td>
            <td width="150"><?php echo $data['nama_barang']; ?></td>
            <td width="150"><?php echo $data['nama_satuan']; ?></td>
            <td width="150" class="text-center"><?php echo $saldo_awal; ?></td>
            <td width="150" class="text-center"><?php echo $saldo_masuk; ?></td>
            <td width="150" class="text-center"><span class="badge badge-warning"><?php echo $saldo_keluar; ?></span></td>
            <td width="150" class="text-center"><?php echo $saldo_adjustment; ?></td>
            <td width="150" class="text-center"><?php echo $saldo_barang; ?></td>
            <td width="150" class="text-center"><?php echo $stock_opname; ?></td>
            <td width="150" class="text-center">
                <?php echo $selisih; ?>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php
  }
  // jika filter data stok "Minimum" dipilih, tampilkan laporan stok barang yang mencapai batas minimum
  else {
    // fungsi header untuk mengirimkan raw data excel
    header("Content-type: application/vnd-ms-excel");
    // mendefinisikan nama file hasil ekspor "Laporan Stok Barang Minimum.xls"
    header("Content-Disposition: attachment; filename=Laporan Stok Barang Minimum.xls");
  ?>
    <!-- halaman HTML yang akan diexport ke excel -->
    <!-- judul tabel -->
    <center>
      <h4>LAPORAN STOK BARANG YANG MENCAPAI BATAS MINIMUM</h4>
    </center>
    <!-- tabel untuk menampilkan data dari database -->
    <table border="1">
      <thead>
        <tr style="background-color:#6861ce;color:#fff">
          <th height="30" align="center" vertical="center">No.</th>
          <th height="30" align="center" vertical="center">ID Barang</th>
          <th height="30" align="center" vertical="center">Nama Barang</th>
          <th height="30" align="center" vertical="center">Jenis Barang</th>
          <th height="30" align="center" vertical="center">Stok</th>
          <th height="30" align="center" vertical="center">Satuan</th>
        </tr>
      </thead>
      <tbody>
        <?php
        // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan" berdasarkan "stok"
        $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan
                                        FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
                                        ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
                                        WHERE a.stok<=a.stok_minimum ORDER BY a.id_barang ASC")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
        // ambil data hasil query
        while ($data = mysqli_fetch_assoc($query)) { ?>
          <!-- tampilkan data -->
          <tr>
            <td width="70" align="center"><?php echo $no++; ?></td>
            <td width="120" align="center"><?php echo $data['id_barang']; ?></td>
            <td width="300"><?php echo $data['nama_barang']; ?></td>
            <td width="200"><?php echo $data['nama_jenis']; ?></td>
            <td width="100" align="right"><?php echo $data['stok']; ?></td>
            <td width="150"><?php echo $data['nama_satuan']; ?></td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  <?php } ?>
  <br>
  <div style="text-align:right">............, <?php echo tanggal_indo(date('Y-m-d')); ?></div>
<?php } ?>