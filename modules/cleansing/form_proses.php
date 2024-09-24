<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {

  


    // sql statement untuk menampilkan data dari tabel "tbl_user" berdasarkan "id_user"
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_profil WHERE npwp<>''")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $numrow = mysqli_num_rows($query);
    if($numrow<=0){
      //insert 
      $npwp='027681030529000';
      $nib='9120100781919';
      $nama='PT.DATA SAMPLE';
      $insert = mysqli_query($mysqli, "INSERT INTO tbl_profil(npwp, nib, nama) 
                                       VALUES('$npwp', '$nib', '$nama')")
                                       or die('Ada kesalahan pada query insert : ' . mysqli_error($mysqli));

    }

    $query = mysqli_query($mysqli, "SELECT * FROM tbl_profil WHERE npwp<>'' LIMIT 1")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);

  
?>

<?php
  // menampilkan pesan sesuai dengan proses yang dijalankan
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      $message = isset($_GET['message'])?$_GET['message']:'';
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">Sukses!</span> 
              <span data-notify="message">Cleansing Data Percobaan berhasil diproses. '.$message.'</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    
    elseif ($_GET['pesan'] == 4) {
      $message = isset($_GET['message'])?$_GET['message']:'';
      // tampilkan pesan gagal hapus data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">Gagal!</span> 
              <span data-notify="message">Cleansing Data Percobaan gagal diproses. '.$message.'</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
  }
  ?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-user mr-2"></i> <?php echo transWord($_SESSION['Lang'],'cleansingDataPercobaan','Cleansing Data Percobaan') ?> </h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=form_ubah_profil" class="text-white"><?php echo transWord($_SESSION['Lang'],'cleansingDataPercobaan','Cleansing Data Percobaan') ?> </a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'],'proses','Proses') ?> </a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'],'prosesData','Proses Data') ?> </div>
      </div>
      <!-- form ubah data -->
      <form action="modules/cleansing/proses_cleansing.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <input type="hidden" name="id_profil" value="<?php echo $data['id_profil']; ?>">


          <div class="form-group col-lg-5">
            <label><?php echo transWord($_SESSION['Lang'],'nPWP','NPWP') ?>  <span class="text-danger">*</span></label>
            <input type="text" name="npwp" class="form-control" autocomplete="off" value="<?php echo $data['npwp']; ?>" readonly>
            <!-- <div class="invalid-feedback">Npwp tidak boleh kosong.</div> -->
          </div>

          
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <input type="submit" name="simpan" value="<?php echo transWord($_SESSION['Lang'],'proses','Proses') ?> " class="btn btn-secondary btn-round pl-4 pr-4 mr-2">
          <!-- tombol kembali ke halaman data user -->
          <!-- <a href="?module=saldo_awal_final" class="btn btn-default btn-round pl-4 pr-4"><?php echo transWord($_SESSION['Lang'],'batal','Batal') ?></a> -->
        </div>
      </form>
    </div>
  </div>
<?php } ?>