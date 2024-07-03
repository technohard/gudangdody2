<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // menampilkan pesan sesuai dengan proses yang dijalankan
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil disimpan.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 2
    elseif ($_GET['pesan'] == 2) {
      // tampilkan pesan sukses ubah data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil diubah.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 3
    elseif ($_GET['pesan'] == 3) {
      // tampilkan pesan sukses hapus data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Data barang berhasil dihapus.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 4
    elseif ($_GET['pesan'] == 4) {
      // tampilkan pesan gagal hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Data barang tidak bisa dihapus karena sudah tercatat pada Data Transaksi.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-45">
      <div class="d-flex align-items-left align-items-md-top flex-column flex-md-row">
        <div class="page-header text-white">
          <!-- judul halaman -->
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> <?php echo transWord($_SESSION['Lang'],'barangAdjustment','Barang Adjustment') ?> </h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=barang" class="text-white"><?php echo transWord($_SESSION['Lang'],'barangAdjustment','Barang Adjustment') ?> </a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'],'barangAdjustment','Barang Adjustment') ?></a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_adjustment" class="btn btn-secondary btn-round">
            <span class="btn-label"><i class="fa fa-plus mr-2"></i></span> <?php echo transWord($_SESSION['Lang'],'entriData','Entri Data') ?> 
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'],'laporanAdjustment','Laporan Adjustment') ?></div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
         
         
         
           <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
                <thead>
                  <tr>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'no','No') ?>.</th>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'tanggal','Tanggal') ?></th>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'kodeBarang','Kode Barang') ?></th>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'kategoriBarang','Ketegori Barang') ?></th>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'namaBarang','Nama Barang') ?></th>
                    <th class="text-center"><?php echo transWord($_SESSION['Lang'],'satuanBarang','Satuan Barang') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'jumlahBarang','Jumlah Barang') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'saldoAwal','Saldo Awal') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'jumlahPemasukanBarang','Jumlah Pemasukan Barang') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'jumlahPengeluaranBarang','Jumlah Pengeluaran Barang') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'penyesuaian','Penyesuaian') ?></th>
                     <th class="text-center"><?php echo transWord($_SESSION['Lang'],'saldoAkhir','Saldo Akhir') ?></th>
                      <th class="text-center"><?php echo transWord($_SESSION['Lang'],'keterangan','Keterangan') ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  // variabel untuk nomor urut tabel
                  $no = 1;
                  // sql statement untuk menampilkan data dari tabel "tbl_barang", tabel "tbl_jenis", dan tabel "tbl_satuan"


                  $query = mysqli_query($mysqli, "SELECT a.id_transaksi, a.tanggal, a.barang, a.jumlah, b.nama_barang, c.nama_satuan, a.keterangan, d.nama_jenis, b.stok_minimum, b.stok
                                              FROM tbl_adjustment as a 
                                              INNER JOIN tbl_barang as b ON a.barang = b.id_barang 
                                              INNER JOIN tbl_jenis as d ON b.jenis = d.id_jenis 
                                              INNER JOIN tbl_satuan as c ON b.satuan = c.id_satuan
                                              ORDER BY a.barang,a.id_transaksi ASC")
                                              or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

                  // $query = mysqli_query($mysqli, "SELECT a.id_barang, a.nama_barang, a.jenis, a.stok_minimum, a.stok, a.satuan, b.nama_jenis, c.nama_satuan, a.tanggale, a.jenis, a.id_barang, a.keterangan, a.Saldo_akhir, a.Saldo_awal, a.Pemasukan, a.Pengeluaran, a.Penyesuaian, a.Keterangan
                  //                                 FROM tbl_adjusment as a INNER JOIN tbl_jenis as b INNER JOIN tbl_satuan as c 
                  //                                 ON a.jenis=b.id_jenis AND a.satuan=c.id_satuan 
                  //                                 ORDER BY a.id_barang ASC")
                  //                                 or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));


                  // ambil data hasil query
                  $saldo_awal = 0;
                  $saldo_akhir = 0;
                  $masuk = 0;
                  $keluar = 0;
                  while ($data = mysqli_fetch_assoc($query)) { 
                    $periode = substr($data['tanggal'],0,4).substr($data['tanggal'],5,2);
                    $bulan = substr($data['tanggal'],5,2);
                    $tahun = substr($data['tanggal'],0,4);
                    $id_barang = $data['barang'];
                    $adjustment = $data['jumlah'];

                    $query2 = mysqli_query($mysqli,"select saldo_awal from tbl_saldo where periode='$periode' and id_barang='$id_barang' ");
                    $res = mysqli_fetch_assoc($query2);
                    $saldo_awal = ($res) ? $res['saldo_awal'] : 0;
                    
                    $query2 = mysqli_query($mysqli,"select SUM(jumlah) as total_masuk from tbl_barang_masuk where LPAD(MONTH(tanggal), 2, '0')='$bulan' and YEAR(tanggal)='$tahun' and  barang = '$id_barang' ");
                    $res = mysqli_fetch_assoc($query2);
                    $masuk = ($res) ? $res['total_masuk'] : 0;

                    $query2 = mysqli_query($mysqli,"select SUM(jumlah) as total_keluar from tbl_barang_keluar where LPAD(MONTH(tanggal), 2, '0')='$bulan' and YEAR(tanggal)='$tahun' and  barang = '$id_barang' ");
                    $res = mysqli_fetch_assoc($query2);
                    $keluar = ($res) ? $res['total_keluar'] : 0;
                    
                    $saldo_akhir = ( $masuk - $keluar ) + $adjustment;

                    ?>
                    <!-- tampilkan data -->
                    <tr>
                      <td width="50" class="text-center"><?php echo $no++; ?></td>
                      <td width="80" class="text-center"><?php echo $data['tanggal']; ?></td>
                      <td width="200"><?php echo $data['barang']; ?></td>
                      <td width="150"><?php echo $data['nama_jenis']; ?></td>
                       <td width="150"><?php echo $data['nama_barang']; ?></td>
                       <td width="150"><?php echo $data['nama_satuan']; ?></td>
                      <?php
                      // mengecek data "stok"
                      // jika data stok minim
                      if ($data['stok'] <= $data['stok_minimum']) { ?>
                        <!-- tampilkan data dengan warna background -->
                        <td width="70" class="text-right"><span class="badge badge-warning"><?php echo $data['stok']; ?></span></td>
                      <?php }
                      // jika data stok tidak minim
                      else { ?>
                        <!-- tampilkan data tanpa warna background -->
                        <td width="70" class="text-right"><?php echo $data['stok']; ?></td>
                      <?php } ?>
                         <td width="70"><?php echo $saldo_awal; ?></td>
                          <td width="70"><?php echo $masuk; ?></td>
                           <td width="70"><?php echo $keluar; ?></td>
                             <td width="70"><?php echo $data['jumlah']; ?></td>
                              <td width="70"><?php echo $saldo_akhir; ?></td>
                               <td width="70"><?php echo $data['keterangan']; ?></td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table> 
         
         
         
         
         
         
         
         
         
         
         
        </div>
      </div>
    </div>
  </div>
<?php } ?>