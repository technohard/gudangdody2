<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-user mr-2"></i> <?php echo transWord($_SESSION['Lang'],'manajemenUser','Manajemen User') ?> </h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=user" class="text-white"><?php echo transWord($_SESSION['Lang'],'user','User') ?> </a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'],'entri','Entri') ?> </a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'],'entriDataUser','Entri Data User') ?> </div>
      </div>
      <!-- form entri data -->
      <form action="modules/user/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="form-group col-lg-5">
            <label><?php echo transWord($_SESSION['Lang'],'namaUser','Nama User') ?>  <span class="text-danger">*</span></label>
            <input type="text" name="nama_user" class="form-control" autocomplete="off" required>
            <div class="invalid-feedback">Nama user tidak boleh kosong.</div>
          </div>

          <div class="form-group col-lg-5">
            <label><?php echo transWord($_SESSION['Lang'],'username','Username') ?>  <span class="text-danger">*</span></label>
            <input type="text" name="username" class="form-control" autocomplete="off" required>
            <div class="invalid-feedback">Username tidak boleh kosong.</div>
          </div>

          <div class="form-group col-lg-5">
            <label><?php echo transWord($_SESSION['Lang'],'password','Password') ?>  <span class="text-danger">*</span></label>
            <input type="password" name="password" class="form-control" autocomplete="off" required>
            <div class="invalid-feedback">Password tidak boleh kosong.</div>
          </div>

          <div class="form-group col-lg-5">
            <label><?php echo transWord($_SESSION['Lang'],'hakAkses','Hak Akses') ?> <span class="text-danger">*</span></label>
            <select name="hak_akses" class="form-control chosen-select" autocomplete="off" required>
              <option selected disabled value="">-- <?php echo transWord($_SESSION['Lang'],'pilih','Pilih') ?>  --</option>
              <option value="Administrator"><?php echo transWord($_SESSION['Lang'], 'Administrator', 'Administrator') ?> </option>
              <option value="Admin Gudang"><?php echo transWord($_SESSION['Lang'], 'Admin Gudang', 'Admin Gudang') ?> </option>
              <option value="Kepala Gudang"><?php echo transWord($_SESSION['Lang'], 'Kepala Gudang', 'Kepala Gudang') ?> </option>
            </select>
            <div class="invalid-feedback"><?php echo transWord($_SESSION['Lang'], 'Hak akses tidak boleh kosong', 'Hak akses tidak boleh kosong') ?></div>
          </div>
        </div>
        <div class="card-action">
          <!-- tombol simpan data -->
          <!-- <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2"> -->
          <button class="btn btn-secondary btn-round pl-4 pr-4 mr-2" type="submit" name="simpan" value="<?php echo transWord($_SESSION['Lang'],'simpan','Simpan') ?> ">
             <?php echo transWord($_SESSION['Lang'],'simpan','Simpan') ?>
           </button>

          <!-- tombol kembali ke halaman data user -->
          <a href="?module=user" class="btn btn-default btn-round pl-4 pr-4"><?php echo transWord($_SESSION['Lang'],'batal','Batal') ?> </a>
        </div>
      </form>
    </div>
  </div>
<?php } ?>