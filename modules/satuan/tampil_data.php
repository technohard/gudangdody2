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
              <span data-notify="title" class="text-success">'.transWord($_SESSION['Lang'],'Sukses','Sukses').'!</span> 
              <span data-notify="message">'.transWord($_SESSION['Lang'],'Data berhasil disimpan','Data berhasil disimpan').'.</span>
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
              <span data-notify="title" class="text-success">'.transWord($_SESSION['Lang'],'Sukses','Sukses').'!</span> 
              <span data-notify="message">'.transWord($_SESSION['Lang'],'Data berhasil diubah','Data berhasil diubah').' .</span>
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
              <span data-notify="title" class="text-success">'.transWord($_SESSION['Lang'],'Sukses','Sukses').'!</span> 
              <span data-notify="message">'.transWord($_SESSION['Lang'],'Data satuan berhasil dihapus','Data satuan berhasil dihapus').' .</span>
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
              <span data-notify="title" class="text-danger">'.transWord($_SESSION['Lang'],'Gagal','Gagal').'!</span> 
              <span data-notify="message">'.transWord($_SESSION['Lang'],'Data tersebut sudah ada','Data tersebut sudah ada').' .</span>
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
              <span data-notify="message">'.transWord($_SESSION['Lang'],'Data tidak bisa dihapus karena sudah tercatat','Data tidak bisa dihapus karena sudah tercatat').'  .</span>
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
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> <?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=satuan" class="text-white"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'],'data','Data') ?> </a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">
          <!-- tombol entri data -->
          <a href="?module=form_entri_satuan" class="btn btn-secondary btn-round mr-2">
            <span class="btn-label"><i class="fa fa-plus mr-2"></i></span> <?php echo transWord($_SESSION['Lang'],'entriData','Entri Data') ?> 
          </a>
          <!-- tombol export data -->
          <a href="modules/satuan/export.php" class="btn btn-success btn-round">
            <span class="btn-label"><i class="fa fa-file-excel mr-2"></i></span> <?php echo transWord($_SESSION['Lang'],'export','Export') ?>  
          </a>
        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'],'dataSatuan','Data Satuan') ?> </div>
      </div>
      <div class="card-body">
        <div class="table-responsive">
          <!-- tabel untuk menampilkan data dari database -->
          <table id="basic-datatables" class="display table table-bordered table-striped table-hover">
            <thead>
              <tr>
                <th class="text-center"><?php echo transWord($_SESSION['Lang'],'no','No') ?> .</th>
                <th class="text-center"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></th>
                <th class="text-center"><?php echo transWord($_SESSION['Lang'],'aksi','Aksi') ?> </th>
              </tr>
            </thead>
            <tbody>
              <?php
              // variabel untuk nomor urut tabel
              $no = 1;
              // sql statement untuk menampilkan data dari tabel "tbl_satuan"
              $query = mysqli_query($mysqli, "SELECT * FROM tbl_satuan ORDER BY id_satuan DESC")
                                              or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
              // ambil data hasil query
              while ($data = mysqli_fetch_assoc($query)) { ?>
                <!-- tampilkan data -->
                <tr>
                  <td width="30" class="text-center"><?php echo $no++; ?></td>
                  <td width="300"><?php echo $data['nama_satuan']; ?></td>
                  <td width="70" class="text-center">
                    <div>
                      <!-- tombol ubah data -->
                      <a href="?module=form_ubah_satuan&id=<?php echo $data['id_satuan']; ?>" class="btn btn-icon btn-round btn-secondary btn-sm mr-md-1" data-toggle="tooltip" data-placement="top" title="Ubah">
                        <i class="fas fa-pencil-alt fa-sm"></i>
                      </a>
                      <!-- tombol hapus data -->
                      <a href="modules/satuan/proses_hapus.php?id=<?php echo $data['id_satuan']; ?>" onclick="return confirm(' <?php echo transWord($_SESSION['Lang'],'Anda yakin ingin menghapus data','Anda yakin ingin menghapus data') ?>  <?php echo $data['nama_satuan']; ?>?')" class="btn btn-icon btn-round btn-danger btn-sm" data-toggle="tooltip" data-placement="top" title="Hapus">
                        <i class="fas fa-trash fa-sm"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
<?php } ?>