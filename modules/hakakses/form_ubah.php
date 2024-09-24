<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  // mengecek data GET "id_jenis"
  if (isset($_GET['id'])) {
    // ambil data GET dari tombol ubah
    $id_jenis = $_GET['id'];

    // sql statement untuk menampilkan data dari tabel "tbl_jenis" berdasarkan "id_jenis"
    $query = mysqli_query($mysqli, "SELECT * FROM tbl_jenis WHERE id_jenis='$id_jenis'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
  }
?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> <?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?> </h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=jenis" class="text-white"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?> </a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'],'ubah','Ubah') ?> </a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'],'Ubah Data Jenis Barang','Ubah Data Jenis Barang') ?> </div>
      </div>
      <!-- form ubah data -->
      <form action="modules/hakakses/proses_ubah.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <input type="hidden" name="id_jenis" value="<?php echo $data['id_jenis']; ?>">

          <div class="form-group">
            <label><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?>  <span class="text-danger">*</span></label>
            <input type="text" name="nama_jenis" class="form-control col-lg-5" autocomplete="off" value="<?php echo $data['nama_jenis']; ?>" required>
            <div class="invalid-feedback"><?php echo transWord($_SESSION['Lang'],'Jenis barang tidak boleh kosong','Jenis barang tidak boleh kosong') ?> .</div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <!-- <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2"> -->

          <button class="btn btn-secondary btn-round pl-4 pr-4 mr-2" type="submit" name="simpan" value="Simpan">
             <?php echo transWord($_SESSION['Lang'],'simpan','Simpan') ?>
           </button>

          <!-- tombol kembali ke halaman data jenis barang -->
          <a href="?module=jenis" class="btn btn-default btn-round pl-4 pr-4"><?php echo transWord($_SESSION['Lang'],'batal','Batal') ?> </a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>