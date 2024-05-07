<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { 
  
  
  ?>

  <?php 
  
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

  ?>


  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-file-signature mr-2"></i> Laporan Stok</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Laporan</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Stok</a></li>
        </ul>
      </div>
    </div>
  </div>

  <?php
  // mengecek data hasil submit dari form filter
  // jika tidak ada data yang dikirim (tombol tampilkan belum diklik) 
  if (!isset($_POST['tampil'])) { ?>
    <div class="page-inner mt--5">
      <div class="card">
        <div class="card-header">
          <!-- judul form -->
          <div class="card-title">Filter Data Stok</div>
        </div>
        <!-- form filter data -->
        <div class="card-body">
          <form action="?module=laporan_stok" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-lg-5">
                <div class="form-group">
                  <label>Stok </label>
                  <select name="stok" class="form-control chosen-select" autocomplete="off">
                    <option selected disabled value="">-- Pilih --</option>
                    <option value="">-</option>
                    <?php  

                      $query1 = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
                      FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
                      ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
                      ORDER BY a.id_barang ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data1 = mysqli_fetch_assoc($query1)) { ?>
                        <option value="<?php echo $data1['nama_barang']; ?>"><?php echo $data1['nama_barang']; ?></option>
                      <?php } ?>

                    <option value="Seluruh">Seluruh</option>
                  
                  </select>
                  
                </div>
              </div>

              <div class="col-lg-5">
                <div class="form-group">
                  <label>Jenis Barang </label>
                  <select name="jenis" class="form-control chosen-select" autocomplete="off" >
                    <option disabled value="">-- Pilih --</option>
                    <option value="">-</option>
                    <?php  

                      $query2 = mysqli_query($mysqli, "SELECT a.id_jenis, a.nama_jenis
                      FROM tbl_jenis as a 
                      ORDER BY a.nama_jenis ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data2 = mysqli_fetch_assoc($query2)) { ?>
                        <option value="<?php echo $data2['nama_jenis']; ?>"><?php echo $data2['nama_jenis']; ?></option>
                      <?php } ?>
                    <option value="Seluruh">Seluruh</option>
                  </select>
                  <!-- <div class="invalid-feedback">Stok tidak boleh kosong.</div> -->
                </div>
              </div>
              
              
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Awal <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_awal" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal awal tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Akhir <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_akhir" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal akhir tidak boleh kosong.</div>
                </div>
              </div>
              

              <div class="col-lg-3">
                <div class="form-group pt-3">
                  <!-- tombol tampil data -->
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-secondary btn-round btn-block mt-4">
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  <?php
  }
  // jika ada data yang dikirim (tombol tampilkan diklik)
  else {
    // ambil data hasil submit dari form filter
    $stok = (isset($_POST['stok']))?$_POST['stok']:'';
    $jenis = (isset($_POST['jenis']))?$_POST['jenis']:'';
    $tanggal_awal  = date('Y-m-d', strtotime($_POST['tanggal_awal']));
    $tanggal_akhir = date('Y-m-d', strtotime($_POST['tanggal_akhir']));

    

  ?>
    <div class="page-inner mt--5">
      <div class="card">
        <div class="card-header">
          <!-- judul form -->
          <div class="card-title">Filter Data Stok</div>
        </div>
        <!-- form filter data -->
        <div class="card-body">
          
          <form action="?module=laporan_stok" method="post" class="needs-validation" novalidate>
            <div class="row">
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Stok <span class="text-danger">*</span></label>
                  <select name="stok" class="form-control chosen-select" autocomplete="off" >
                    <option disabled value="">-- Pilih --</option>
                    <option  value="">-</option>
                    <?php  

                      $query1 = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan
                      FROM tbl_barang as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
                      ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
                      ORDER BY a.id_barang ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data1 = mysqli_fetch_assoc($query1)) { ?>
                        <?php if($data1['nama_barang']==$stok) { ?>
                          <option value="<?php echo $data1['nama_barang']; ?>" selected><?php echo $data1['nama_barang']; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $data1['nama_barang']; ?>"><?php echo $data1['nama_barang']; ?></option>
                        <?php } ?>
                      <?php } ?>

                    <option value="Seluruh">Seluruh</option>
                  </select>
                  <div class="invalid-feedback">Stok tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label>Jenis Barang </label>
                  <select name="jenis" class="form-control chosen-select" autocomplete="off" >
                    <option disabled value="">-- Pilih --</option>
                    <option value="">-</option>
                    <?php  

                      $query2 = mysqli_query($mysqli, "SELECT a.id_jenis, a.nama_jenis
                      FROM tbl_jenis as a 
                      ORDER BY a.nama_jenis ASC")
                      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                      // ambil data hasil query
                      while ($data2 = mysqli_fetch_assoc($query2)) { ?>
                        <?php if($data2['nama_jenis']==$jenis) { ?>
                          <option value="<?php echo $data2['nama_jenis']; ?>" selected><?php echo $data2['nama_jenis']; ?></option>
                        <?php }else{ ?>
                          <option value="<?php echo $data2['nama_jenis']; ?>"><?php echo $data2['nama_jenis']; ?></option>
                        <?php } ?>
                        
                      <?php } ?>
                    <option value="Seluruh">Seluruh</option>
                  </select>
                  <!-- <div class="invalid-feedback">Stok tidak boleh kosong.</div> -->
                </div>
              </div>
              
              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Awal <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_awal" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal awal tidak boleh kosong.</div>
                </div>
              </div>

              <div class="col-lg-3">
                <div class="form-group">
                  <label>Tanggal Akhir <span class="text-danger">*</span></label>
                  <input type="text" name="tanggal_akhir" class="form-control date-picker" autocomplete="off" required>
                  <div class="invalid-feedback">Tanggal akhir tidak boleh kosong.</div>
                </div>
              </div>
              

              <div class="col-lg-3">
                <div class="form-group pt-3">
                  <!-- tombol tampil data -->
                  <input type="submit" name="tampil" value="Tampilkan" class="btn btn-secondary btn-round btn-block mt-4">
                </div>
              </div>

              <div class="col-lg-2 pr-0">
                <div class="form-group pt-3">
                  <!-- tombol cetak laporan -->
                  <a href="modules/laporan-stok/cetak.php?stok=<?php echo $stok; ?>&tanggal_awal=<?php echo $tanggal_awal ?>&tanggal_akhir=<?php echo $tanggal_akhir ?>&jenis=<?php echo $jenis ?>" target="_blank" class="btn btn-warning btn-round btn-block mt-4">
                    <span class="btn-label"><i class="fa fa-print mr-2"></i></span> Cetak
                  </a>
                </div>
              </div>

              <div class="col-lg-2 pl-0">
                <div class="form-group pt-3">
                  <!-- tombol export laporan -->
                  <a href="modules/laporan-stok/export.php?stok=<?php echo $stok; ?>" target="_blank" class="btn btn-success btn-round btn-block mt-4">
                    <span class="btn-label"><i class="fa fa-file-excel mr-2"></i></span> Export
                  </a>
                </div>
              </div>
            </div>
          </form>
        </div>
      </div>

      <div class="card">
        <?php
        // mengecek filter data stok
        // jika filter data stok "Seluruh" dipilih
        if ($stok == 'Seluruh') { ?>
          <!-- tampilkan laporan stok seluruh barang -->
          <div class="card-header">
            <!-- judul tabel -->
            <div class="card-title"><i class="fas fa-file-alt mr-2"></i> Laporan Stok Seluruh Barang</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- tabel untuk menampilkan data dari database -->
              <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Ketegori Barang</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Saldo Awal</th>
                    <th class="text-center">Pemasukan</th>
                    <th class="text-center">Pengeluaran</th>
                    <th class="text-center">Penyesuaian</th>
                    <th class="text-center">Saldo Barang</th>
                    <th class="text-center">Stock Opname</th>
                    <th class="text-center">Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // variabel untuk nomor urut tabel
                  $no = 1;
                  $tanggal_awal  = date('Y-m-d', strtotime($_POST['tanggal_awal']));
                  $tanggal_akhir = date('Y-m-d', strtotime($_POST['tanggal_akhir']));
                  

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
            </div>
          </div>
        <?php
        }
        // jika filter data jenis "Seluruh" dipilih
        elseif($jenis == 'Seluruh') { ?>
          <!-- tampilkan laporan stok seluruh barang -->
          <div class="card-header">
            <!-- judul tabel -->
            <div class="card-title"><i class="fas fa-file-alt mr-2"></i> Laporan Stok Seluruh Jenis Barang</div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- tabel untuk menampilkan data dari database -->
              <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Ketegori Barang</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Saldo Awal</th>
                    <th class="text-center">Pemasukan</th>
                    <th class="text-center">Pengeluaran</th>
                    <th class="text-center">Penyesuaian</th>
                    <th class="text-center">Saldo Barang</th>
                    <th class="text-center">Stock Opname</th>
                    <th class="text-center">Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // variabel untuk nomor urut tabel
                  $no = 1;
                  $tanggal_awal  = date('Y-m-d', strtotime($_POST['tanggal_awal']));
                  $tanggal_akhir = date('Y-m-d', strtotime($_POST['tanggal_akhir']));

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
                      <td width="150" class="text-center"><?php echo $selisih; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>
        <?php 
        } 
        //
        elseif($stok != 'Seluruh' && $jenis=='') { ?>

        <!-- tampilkan laporan stok seluruh barang -->
        <div class="card-header">
            <!-- judul tabel -->
            <div class="card-title"><i class="fas fa-file-alt mr-2"></i> Laporan Stok Barang <?php echo ucwords($stok)  ?> </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- tabel untuk menampilkan data dari database -->
              <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Ketegori Barang</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Saldo Awal</th>
                    <th class="text-center">Pemasukan</th>
                    <th class="text-center">Pengeluaran</th>
                    <th class="text-center">Penyesuaian</th>
                    <th class="text-center">Saldo Barang</th>
                    <th class="text-center">Stock Opname</th>
                    <th class="text-center">Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // variabel untuk nomor urut tabel
                  $no = 1;
                  $tanggal_awal  = date('Y-m-d', strtotime($_POST['tanggal_awal']));
                  $tanggal_akhir = date('Y-m-d', strtotime($_POST['tanggal_akhir']));

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
                      <td width="150" class="text-center"><?php echo $selisih; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>

        <?php
        } //
        elseif($jenis != 'Seluruh' && $stok == '') { ?>

          <!-- tampilkan laporan stok seluruh barang -->
        <div class="card-header">
            <!-- judul tabel -->
            <div class="card-title"><i class="fas fa-file-alt mr-2"></i> Laporan Stok Jenis Barang <?php echo ucwords($jenis)  ?> </div>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- tabel untuk menampilkan data dari database -->
              <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center">No.</th>
                    <th class="text-center">Kode Barang</th>
                    <th class="text-center">Ketegori Barang</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Saldo Awal</th>
                    <th class="text-center">Pemasukan</th>
                    <th class="text-center">Pengeluaran</th>
                    <th class="text-center">Penyesuaian</th>
                    <th class="text-center">Saldo Barang</th>
                    <th class="text-center">Stock Opname</th>
                    <th class="text-center">Selisih</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // variabel untuk nomor urut tabel
                  $no = 1;
                  $tanggal_awal  = date('Y-m-d', strtotime($_POST['tanggal_awal']));
                  $tanggal_akhir = date('Y-m-d', strtotime($_POST['tanggal_akhir']));

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
                      <td width="150" class="text-center"><?php echo $selisih; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
            </div>
          </div>


        <?php
        } //
        ?>
      </div>
    </div>
<?php
  }
}
?>