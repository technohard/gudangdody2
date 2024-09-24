<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {


  $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
  $host = $_SERVER['HTTP_HOST'];

  $uri = $_SERVER['REQUEST_URI'];

  $current_url = $protocol . $host . $uri;

  if(isset($_POST['saveAkses'])){

      $id_akses_fk = $_POST['hakAkses'];
      $query = mysqli_query($mysqli, "UPDATE tbl_akses_menu SET 
      is_view = 0 
      WHERE id_akses_fk = '$id_akses_fk'
       ")
      or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));


      $id_akses_array = $_POST['chkakses'];
      $length = count($id_akses_array);
      for ($i = 0; $i < $length; $i++) {
        $id_akses = $id_akses_array[$i];  
        
        $query = mysqli_query($mysqli, "UPDATE tbl_akses_menu SET 
        is_view = 1 
        WHERE id_akses_menu = '$id_akses' 
        ")
        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

      }

      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">' . transWord($_SESSION['Lang'], 'Sukses', 'Sukses') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'Data hak akses berhasil disimpan', 'Data hak akses berhasil disimpan') . '.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';


  }

  // menampilkan pesan sesuai dengan proses yang dijalankan
  // jika pesan tersedia
  if (isset($_GET['pesan'])) {
    // jika pesan = 1
    if ($_GET['pesan'] == 1) {
      // tampilkan pesan sukses simpan data
      echo '<div class="alert alert-notify alert-success alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-check"></span> 
              <span data-notify="title" class="text-success">' . transWord($_SESSION['Lang'], 'Sukses', 'Sukses') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'Data hak akses berhasil disimpan', 'Data hak akses berhasil disimpan') . '.</span>
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
              <span data-notify="title" class="text-success">' . transWord($_SESSION['Lang'], 'Sukses', 'Sukses') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'Data hak akses berhasil diubah', 'Data hak akses berhasil diubah') . '.</span>
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
              <span data-notify="title" class="text-success">' . transWord($_SESSION['Lang'], 'Sukses', 'Sukses') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'Data hak akses berhasil dihapus', 'Data hak akses berhasil dihapus') . '.</span>
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>';
    }
    // jika pesan = 4
    elseif ($_GET['pesan'] == 4) {
      // ambil data GET dari proses simpan/ubah
      $jenis = $_GET['jenis'];
      // tampilkan pesan gagal simpan data
      echo '<div class="alert alert-notify alert-danger alert-dismissible fade show" role="alert">
              <span data-notify="icon" class="fas fa-times"></span> 
              <span data-notify="title" class="text-danger">' . transWord($_SESSION['Lang'], 'Gagal', 'Gagal') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'hakAkses', 'Hak Akses') . ' <strong>' . $jenis . '</strong> ' . transWord($_SESSION['Lang'], 'sudah ada. Silahkan ganti nama hak akses yang Anda masukan', 'sudah ada. Silahkan ganti nama hak akses yang Anda masukan') . ' .</span>
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
              <span data-notify="title" class="text-danger">' . transWord($_SESSION['Lang'], 'Gagal', 'Gagal') . '!</span> 
              <span data-notify="message">' . transWord($_SESSION['Lang'], 'Data hak akses tidak bisa dihapus karena sudah tercatat pada Data User', 'Data hak akses tidak bisa dihapus karena sudah tercatat pada Data User') . '.</span>
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
          <h4 class="page-title text-white"><i class="fas fa-clone mr-2"></i> <?php echo transWord($_SESSION['Lang'], 'hakAkses', 'Hak Akses') ?>
          </h4>
          <!-- breadcrumbs -->
          <ul class="breadcrumbs">
            <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a href="?module=jenis" class="text-white"><?php echo transWord($_SESSION['Lang'], 'hakAkses', 'Hak Akses') ?> </a></li>
            <li class="separator"><i class="flaticon-right-arrow"></i></li>
            <li class="nav-item"><a><?php echo transWord($_SESSION['Lang'], 'data', 'Data') ?> </a></li>
          </ul>
        </div>
        <div class="ml-md-auto py-2 py-md-0">


        </div>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul tabel -->
        <div class="card-title"><?php echo transWord($_SESSION['Lang'], 'dataHakAkses', 'Data Hak Akses') ?> </div>
      </div>
      <form method="POST" action="<?php echo $current_url ?>">
      <div class="card-body">



        <div class="table-responsive">

          
            <div class="d-flex align-items-center">
              <div class="d-flex flex-column">
                <label class="mb-2" for=""><?php echo transWord($_SESSION['Lang'], 'Role Akses', 'Role Akses') ?> </label>
                <div class="d-flex align-items-center">
                  <select class="form-control" name="hakAkses">
                    <option value="AKS-66D4AD1D7158C" <?php echo (isset($_POST['loadAkses']) && $_POST['hakAkses'] == 'AKS-66D4AD1D7158C') ? 'selected' : '';  ?>> <?php echo transWord($_SESSION['Lang'], 'Administrator', 'Administrator') ?> </option>
                    <option value="AKS-66D4AD1D9E13E" <?php echo (isset($_POST['loadAkses']) && $_POST['hakAkses'] == 'AKS-66D4AD1D9E13E') ? 'selected' : '';  ?>><?php echo transWord($_SESSION['Lang'], 'Admin Gudang', 'Admin Gudang') ?> </option>
                    <option value="AKS-66D4AD1DAF852" <?php echo (isset($_POST['loadAkses']) && $_POST['hakAkses'] == 'AKS-66D4AD1DAF852') ? 'selected' : '';  ?>><?php echo transWord($_SESSION['Lang'], 'Kepala Gudang', 'Kepala Gudang') ?> </option>
                  </select>
                  <button type="submit" class="btn btn-primary py-2 px-3" name="loadAkses" value="LOADMENU" style="margin-left:10px;"><?php echo transWord($_SESSION['Lang'], 'Load Akses', 'Load Akses') ?> </button>
                </div>
              </div>
            </div>

          <?php
          $isHakAkses = 'AKS-66D4AD1D7158C';
          if (isset($_POST['loadAkses'])) {
            $isHakAkses = $_POST['hakAkses'];
          }
          ?>

          <!-- tabel untuk menampilkan data dari database -->
            <table id="" class="display table table-bordered table-striped table-hover">
              <thead>
                <tr>
                  <th class="text-center"><?php echo transWord($_SESSION['Lang'], 'no', 'No') ?> .</th>
                  <th class="text-center"><?php echo transWord($_SESSION['Lang'], 'menuAplikasi', 'Menu Aplikasi') ?></th>
                  <th class="text-center"><?php echo transWord($_SESSION['Lang'], 'akses', 'Akses') ?> </th>
                </tr>
              </thead>
              <tbody>
                <?php
                // variabel untuk nomor urut tabel
                $no = 1;
                // sql statement untuk menampilkan data dari tabel "tbl_jenis"
                $query = mysqli_query($mysqli, "SELECT b.*,a.id_akses_menu,a.is_view FROM tbl_akses_menu a
                INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
                WHERE a.id_akses_fk = '$isHakAkses' 
                ORDER BY b.id_menu ASC
                ")
                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                // ambil data hasil query
                while ($data = mysqli_fetch_assoc($query)) { ?>
                  <!-- tampilkan data -->
                  <tr>
                    <td width="20" class="text-left"><?php echo $data['id_menu']; ?></td>
                    <td width="300">
                      <div class="fw-bold"><?php echo ($_SESSION['Lang'] == 'Bahasa') ? $data['menu_nama_display'] : $data['menu_nama_display_mdr']; ?></div>
                    </td>
                    <td width="70" class="text-center">

                      <div class="">
                        <input class="" type="checkbox" value="<?php echo $data['id_akses_menu'] ?>" name="chkakses[]" id="" style="width:20px;height:20px;" <?php echo ($data['is_view']>0)?'checked':'' ?> >
                        <label class="form-check-label" for="defaultCheck1">
                          
                        </label>
                      </div>

                    </td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="container">
              <div class="row">
                <div class="col">
                  <div><button class="btn btn-lg btn-primary" type="submit" name="saveAkses" value="saveAkses"><?php echo transWord($_SESSION['Lang'], 'Save', 'Save') ?> </button></div>
                </div>
              </div>
            </div>





        </div>
      </div>
      </form>
    </div>
  </div>
<?php } ?>