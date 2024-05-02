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
              <span data-notify="message">Data Saldo Awal berhasil disimpan.</span>
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
              <span data-notify="message">Data Saldo Awal berhasil diubah.</span>
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
              <span data-notify="message">Data Saldo Awal berhasil dihapus.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 4
    elseif ($_GET['pesan'] == 4) {
      // ambil data GET dari proses simpan/ubah
      $satuan = $_GET['satuan'];
      // tampilkan pesan gagal simpan data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Satuan <strong>' . $satuan . '</strong> sudah ada. Silahkan ganti nama satuan yang Anda masukan.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 5
    elseif ($_GET['pesan'] == 5) {
      // tampilkan pesan gagal hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Data Saldo Awal tidak bisa dihapus karena sudah tercatat pada Data Barang.</span>
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
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> Saldo Awal</h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=saldo_awal" class="text-white">Saldo Awal</a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a>Data</a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_saldo_awal" class="btn btn-secondary btn-round mr-2">
            <span class="btn-label"><i class="fa fa-plus mr-2"></i></span> Entri Data
          </a>
          <!-- tombol export data -->
          <!-- <a href="modules/satuan/export.php" class="btn btn-success btn-round">
            <span class="btn-label"><i class="fa fa-file-excel mr-2"></i></span> Export
          </a> -->

        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title">Data Saldo Awal</div>
        <form action="" method="POST">
          <div class="d-flex align-items-center mt-2">
            <div class="">Filter : </div>
            <div class="" style="margin-left:5px;">
              <input type="text" class="form-control" name="periode" id="periode" value="<?php echo (isset($_POST['periode']) ? $_POST['periode'] : date('Ym')) ?>">
            </div>
            <div class="">
              <button type="submit" name="filter" class="btn btn-secondary ">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                  <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                </svg>
              </button>
            </div>
          </div>
        </form>
      </div>
      <div class="card-body">
        <?php if (!isset($_POST['periode'])) { ?>

          <?php 
            
            $periode = date('Ym');

            $qry1 = mysqli_query($mysqli, "SELECT count(*) as jml1 FROM tbl_barang ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
            $res1 = mysqli_fetch_assoc($qry1);
            $jml1 = $res1['jml1'];

            $qry2 = mysqli_query($mysqli, "SELECT count(*) as jml2 FROM tbl_saldo WHERE periode='$periode' ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
            $res2 = mysqli_fetch_assoc($qry2);
            $jml2 = $res2['jml2'];

            if($jml1<>$jml2){
              $qry3 = mysqli_query($mysqli, "SELECT id_barang FROM tbl_barang ORDER BY id_barang ASC ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              if($qry3){
                while ($data3 = mysqli_fetch_assoc($qry3)) {

                  $id_barang = $data3['id_barang'];
                  $id_transaksi = strtoupper(uniqid('TS-'));

                  $qry4 = mysqli_query($mysqli, "SELECT id_barang FROM tbl_saldo WHERE id_barang = '$id_barang' AND periode = '$periode' ")or die('Ada kesalahan pada query cari data : ' . mysqli_error($mysqli));
                  $found = mysqli_num_rows($qry4);
                  if($found<=0){

                    $sqlInsert = "INSERT INTO tbl_saldo (id_transaksi,periode, id_barang, saldo_awal) VALUES ('$id_transaksi', '$periode', '$id_barang' , '0')";
                    $qry5 = mysqli_query($mysqli, $sqlInsert) or die('Ada kesalahan pada query insert data : ' . mysqli_error($mysqli));

                  }else{


                  }

                  
                }  
              }
            }
            
          ?>

          <div class="table-responsive">
            <!-- tabel untuk menampilkan data dari database -->
            <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Kategori</th>
                  <th class="text-center">Barang</th>
                  <th class="text-center">Satuan</th>
                  <th class="text-center">Saldo Awal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // variabel untuk nomor urut tabel

                

                $no = 1;
                // sql statement untuk menampilkan data dari tabel "tbl_satuan"
                $query = mysqli_query($mysqli, "SELECT a.*,b.nama_barang,d.nama_satuan,c.nama_jenis
              FROM tbl_saldo a
              INNER JOIN tbl_barang b ON b.id_barang = a.id_barang 
              INNER JOIN tbl_jenis c ON c.id_jenis = b.jenis 
              INNER JOIN tbl_satuan d ON d.id_satuan = b.satuan
              WHERE a.periode = '$periode' 
              ORDER BY b.nama_barang,d.id_satuan ASC")
                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                  <!-- tampilkan data -->
                  <tr>
                    <td width="30" class="text-center"><?php echo $no++; ?></td>
                    <td width="100"><?php echo $data['periode']; ?></td>
                    <td width="100"><?php echo $data['nama_jenis']; ?></td>
                    <td width="100"><?php echo $data['nama_barang']; ?></td>
                    <td width="100"><?php echo $data['nama_satuan']; ?></td>
                    <td width="100" class="text-center"><?php echo $data['saldo_awal']; ?></td>
                    <td width="70" class="text-center">
                      <div>
                        <!-- tombol ubah data -->
                        <a href="?module=form_ubah_saldo_awal&id=<?php echo $data['id_transaksi']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                          <i class="fas fa-pencil-alt fa-sm"></i>
                        </a>
                        <!-- tombol hapus data -->
                        <!-- <a href="modules/satuan/proses_hapus.php?id=<?php //echo $data['id_satuan']; ?>" onclick="return confirm('Anda yakin ingin menghapus data satuan <?php //echo $data['nama_satuan']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash fa-sm"></i>
                        </a> -->
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        <?php } elseif (isset($_POST['periode'])) { ?>

          <?php 
          
          $periode = isset($_POST['periode']) ? $_POST['periode'] : date('Ym');          
          
          ?>

          <div class="table-responsive">
            <!-- tabel untuk menampilkan data dari database -->
            <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center">No.</th>
                  <th class="text-center">Periode</th>
                  <th class="text-center">Kategori</th>
                  <th class="text-center">Barang</th>
                  <th class="text-center">Satuan</th>
                  <th class="text-center">Saldo Awal</th>
                  <th class="text-center">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <?php
                // variabel untuk nomor urut tabel

                $qry1 = mysqli_query($mysqli, "SELECT count(*) as jml1 FROM tbl_barang ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                $res1 = mysqli_fetch_assoc($qry1);
                $jml1 = $res1['jml1'];

                $qry2 = mysqli_query($mysqli, "SELECT count(*) as jml2 FROM tbl_saldo WHERE periode='$periode' ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                $res2 = mysqli_fetch_assoc($qry2);
                $jml2 = $res2['jml2'];

                if($jml1<>$jml2){
                  $qry3 = mysqli_query($mysqli, "SELECT id_barang FROM tbl_barang ORDER BY id_barang ASC ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                  if($qry3){
                    while ($data3 = mysqli_fetch_assoc($qry3)) {

                      $id_barang = $data3['id_barang'];
                      $id_transaksi = strtoupper(uniqid('TS-'));

                      $qry4 = mysqli_query($mysqli, "SELECT id_barang FROM tbl_saldo WHERE id_barang = '$id_barang' AND periode = '$periode' ")or die('Ada kesalahan pada query cari data : ' . mysqli_error($mysqli));
                      $found = mysqli_num_rows($qry4);
                      if($found<=0){

                        $sqlInsert = "INSERT INTO tbl_saldo (id_transaksi,periode, id_barang, saldo_awal) VALUES ('$id_transaksi', '$periode', '$id_barang' , '0')";
                        $qry5 = mysqli_query($mysqli, $sqlInsert) or die('Ada kesalahan pada query insert data : ' . mysqli_error($mysqli));

                      }
                      
                    }  
                  }
                }

                $no = 1;
                // sql statement untuk menampilkan data dari tabel "tbl_satuan"
                $query = mysqli_query($mysqli, "SELECT a.*,b.nama_barang,d.nama_satuan,c.nama_jenis
                FROM tbl_saldo a
                INNER JOIN tbl_barang b ON b.id_barang = a.id_barang 
                INNER JOIN tbl_jenis c ON c.id_jenis = b.jenis 
                INNER JOIN tbl_satuan d ON d.id_satuan = b.satuan
                WHERE a.periode = '$periode' 
                ORDER BY b.nama_barang,d.id_satuan ASC")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                  <!-- tampilkan data -->
                  <tr>
                    <td width="30" class="text-center"><?php echo $no++; ?></td>
                    <td width="100"><?php echo $data['periode']; ?></td>
                    <td width="100"><?php echo $data['nama_jenis']; ?></td>
                    <td width="100"><?php echo $data['nama_barang']; ?></td>
                    <td width="100"><?php echo $data['nama_satuan']; ?></td>
                    <td width="100" class="text-center"><?php echo $data['saldo_awal']; ?></td>
                    <td width="70" class="text-center">
                      <div>
                        <!-- tombol ubah data -->
                        <a href="?module=form_ubah_saldo_awal&id=<?php echo $data['id_transaksi']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                          <i class="fas fa-pencil-alt fa-sm"></i>
                        </a>
                        <!-- tombol hapus data -->
                        <!-- <a href="modules/satuan/proses_hapus.php?id=<?php //echo $data['id_satuan']; ?>" onclick="return confirm('Anda yakin ingin menghapus data satuan <?php //echo $data['nama_satuan']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                          <i class="fas fa-trash fa-sm"></i>
                        </a> -->
                      </div>
                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>

        <?php } ?>
      </div>

    </div>
  </div>
<?php } ?>