<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  require_once "config/database.php";
  require_once "./lang.php";
  // pengecekan hak akses untuk menampilkan menu sesuai dengan hak akses
  // jika hak akses = Administrator, tampilkan menu

  


  if ($_SESSION['hak_akses'] == 'Administrator') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif

    $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
                INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
                INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
                WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Dashboard'
                LIMIT 1
                ");
    $data = mysqli_fetch_assoc($query);
    $isDashboard = $data['is_view'];
    if($isDashboard>0){

      if ($_GET['module'] == 'dashboard') { ?>
        <li class="nav-item active">
          <a href="?module=dashboard">
            <i class="fas fa-home"></i>
            <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?> </p>
          </a>
        </li>
      <?php
      }
      // jika tidak dipilih, menu dashboard tidak aktif
      else { ?>
        <li class="nav-item">
          <a href="?module=dashboard">
            <i class="fas fa-home"></i>
            <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?> </p>
          </a>
        </li>
      <?php
      }

    }


    

    // jika menu data barang (tampil data / tampil detail / form entri / form ubah) dipilih, menu data barang aktif
    if ($_GET['module'] == 'barang' || $_GET['module'] == 'tampil_detail_barang' || $_GET['module'] == 'form_entri_barang' || $_GET['module'] == 'form_ubah_barang') { ?>
      
      <?php 

        $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
        INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
        INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
        WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Master'
        LIMIT 1
        ");
        $data = mysqli_fetch_assoc($query);
        $isMaster = $data['is_view'];
        if($isMaster>0){
      
      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <?php
        }
      ?>


      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li class="active">
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?> </span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isjenisBarang = $data['is_view'];
            if($isjenisBarang>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?> </span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>


            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?> </span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?> </span>
              </a>
            </li>

            <?php } ?>

          </ul>
        </div>
      </li>


    <?php } ?>



    <?php
    }
    // jika menu jenis barang (tampil data / form entri / form ubah) dipilih, menu jenis barang aktif
    elseif ($_GET['module'] == 'jenis' || $_GET['module'] == 'form_entri_jenis' || $_GET['module'] == 'form_ubah_jenis') { ?>


      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>
            
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?> </span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isjenisBarang = $data['is_view'];
            if($isjenisBarang>0){

            ?>

            <li class="active">
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>

          </ul>
        </div>
      </li>


      <?php } ?>

    <?php
    }
    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'satuan' || $_GET['module'] == 'form_entri_satuan' || $_GET['module'] == 'form_ubah_satuan') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>


      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>


      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isjenisBarang = $data['is_view'];
            if($isjenisBarang>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li class="active">
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
              <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>

      <?php } ?>


    <?php
    }

    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'saldo_awal_final' ) { ?>

      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>


      <?php } ?>


      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>


            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isjenisBarang = $data['is_view'];
            if($isjenisBarang>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li >
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li class="active">
              <a href="?module=saldo_awal_final">
              <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>

      <?php } ?>

    <?php
    }
    
    // jika tidak dipilih, menu barang tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>


      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>


      <?php } ?>
     
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){
              
            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>


            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isjenisBarang = $data['is_view'];
            if($isjenisBarang>0){

            ?>
            
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>


            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>

          </ul>
        </div>
      </li>

      <?php } ?>

    <?php
    }

    // jika menu barang masuk (tampil data / form entri) dipilih, menu barang masuk aktif
    if ($_GET['module'] == 'barang_masuk' || $_GET['module'] == 'form_entri_barang_masuk') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Transaksi'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isTransaksi = $data['is_view'];
      if($isTransaksi>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgMasuk = $data['is_view'];
      if($isBrgMasuk>0){

      ?>

      <li class="nav-item active">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>

      <?php } ?>


    <?php
    }
    // jika tidak dipilih, menu barang masuk tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Transaksi'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isTransaksi = $data['is_view'];
      if($isTransaksi>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgMasuk = $data['is_view'];
      if($isBrgMasuk>0){

      ?>

      <li class="nav-item">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

    // jika menu barang keluar (tampil data / form entri) dipilih, menu barang keluar aktif
    if ($_GET['module'] == 'barang_keluar' || $_GET['module'] == 'form_entri_barang_keluar') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgKeluar = $data['is_view'];
      if($isBrgKeluar>0){

      ?>

      <li class="nav-item active">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgKeluar = $data['is_view'];
      if($isBrgKeluar>0){

      ?>
      <li class="nav-item">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

    if ($_GET['module'] == 'laporan_adjustmen'  || $_GET['module'] == 'form_entri_adjustment'  ) { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPenyesuaian = $data['is_view'];
      if($isPenyesuaian>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
      <?php } ?>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPenyesuaian = $data['is_view'];
      if($isPenyesuaian>0){

      ?>
      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
      <?php } ?>
    
      <?php
    }

    if ($_GET['module'] == 'stok_opname' || $_GET['module'] == 'form_entri_stok_opname' ) { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Stok Opname'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isStokOpname = $data['is_view'];
      if($isStokOpname>0){

      ?>

      <li class="nav-item active">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>
      <?php } ?>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Stok Opname'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isStokOpname = $data['is_view'];
      if($isStokOpname>0){

      ?>

      <li class="nav-item">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

      <?php } ?>

    <?php
    }

    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>


      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>
      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?></p>
        </a>
      </li>
      <?php } ?>
          
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?></p>
        </a>
      </li>

      <?php } ?>
      
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

     // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
     if ($_GET['module'] == 'laporan_status_api') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>
      
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan Status Api tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>

      <?php } ?>

      <?php
    }

     // jika menu manajemen user (tampil data / form entri / form ubah) dipilih, menu manajemen user aktif
     if ($_GET['module'] == 'profil' || $_GET['module'] == 'form_ubah_profil' ) { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Pengaturan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPengaturan = $data['is_view'];
      if($isPengaturan>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'pengaturan','Pengaturan') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Profil Usaha'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isProfilUsaha = $data['is_view'];
      if($isProfilUsaha>0){

      ?>

      <li class="nav-item active">
        <a href="?module=form_ubah_profil">
        <i class="fa fa-address-card"></i>
        <p><?php echo transWord($_SESSION['Lang'],'profilUsaha','Profil Usaha') ?></p>
        </a>
      </li>

      <?php } ?>

    <?php
    }

    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Pengaturan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPengaturan = $data['is_view'];
      if($isPengaturan>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'pengaturan','Pengaturan') ?></h4>
      </li>
      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Profil Usaha'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isProfilUsaha = $data['is_view'];
      if($isProfilUsaha>0){

      ?>

      <li class="nav-item">
        <a href="?module=form_ubah_profil">
          <i class="fa fa-address-card"></i>
          <p><?php echo transWord($_SESSION['Lang'],'profilUsaha','Profil Usaha') ?></p>
        </a>
      </li>
      <?php } ?>

      <?php
    }

    // jika menu manajemen user (tampil data / form entri / form ubah) dipilih, menu manajemen user aktif
    if ($_GET['module'] == 'user' || $_GET['module'] == 'form_entri_user' || $_GET['module'] == 'form_ubah_user') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Manajemen User'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isManajemenUser = $data['is_view'];
      if($isManajemenUser>0){

      ?>
      <li class="nav-item active">
        <a href="?module=user">
          <i class="fas fa-user"></i>
          <p><?php echo transWord($_SESSION['Lang'],'manajemenUser','Manajemen User') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }
    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Manajemen User'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isManajemenUser = $data['is_view'];
      if($isManajemenUser>0){

      ?>
      <li class="nav-item">
        <a href="?module=user">
          <i class="fas fa-user"></i>
          <p><?php echo transWord($_SESSION['Lang'],'manajemenUser','Manajemen User') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

    if ($_GET['module'] == 'hakakses') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Hak Akses'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isHakAkses = $data['is_view'];
      if($isHakAkses>0){

      ?>
      <li class="nav-item active">
        <a href="?module=hakakses">
          <i class="fa fa-user-shield"></i>
          <p><?php echo transWord($_SESSION['Lang'],'hakAkses','Hak Akses') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Hak Akses'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isHakAkses = $data['is_view'];
      if($isHakAkses>0){

      ?>
      <li class="nav-item">
        <a href="?module=hakakses">
        <i class="fa fa-user-shield"></i>
        <p><?php echo transWord($_SESSION['Lang'],'hakAkses','Hak Akses') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }


    if ($_GET['module'] == 'cleansing') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Cleansing Data Percobaan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isCleansing = $data['is_view'];
      if($isCleansing>0){

      ?>
      <li class="nav-item active">
        <a href="?module=cleansing">
          <i class="fa fa-trash"></i>
          <p><?php echo transWord($_SESSION['Lang'],'cleansingDataPercobaan','Cleansing Data Percobaan') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Cleansing Data Percobaan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isCleansing = $data['is_view'];
      if($isCleansing>0){

      ?>
      <li class="nav-item">
        <a href="?module=cleansing">
          <i class="fa fa-trash"></i>
          <p><?php echo transWord($_SESSION['Lang'],'cleansingDataPercobaan','Cleansing Data Percobaan') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

    if ($_GET['module'] == 'dokumen_barang') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Dokumen Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isDokBrg = $data['is_view'];
      if($isDokBrg>0){

      ?>
      <li class="nav-item active">
        <a href="?module=dokumen_barang">
          <i class="fa fa-file-invoice"></i>
          <p><?php echo transWord($_SESSION['Lang'],'dokumenBarang','Dokumen Barang') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Administrator' AND b.menu_nama = 'Dokumen Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isDokBrg = $data['is_view'];
      if($isDokBrg>0){

      ?>
      <li class="nav-item">
        <a href="?module=dokumen_barang">
          <i class="fa fa-file-invoice"></i>
          <p><?php echo transWord($_SESSION['Lang'],'dokumenBarang','Dokumen Barang') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }

  }





  // jika hak akses = Admin Gudang, tampilkan menu
  elseif ($_SESSION['hak_akses'] == 'Admin Gudang') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif
    if ($_GET['module'] == 'dashboard') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Dashboard'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isDashboard = $data['is_view'];
      if($isDashboard>0){

      ?>
      <li class="nav-item active">
        <a href="?module=dashboard">
          <i class="fas fa-home"></i>
          <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu dashboard tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Dashboard'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isDashboard = $data['is_view'];
      if($isDashboard>0){

      ?>
      <li class="nav-item">
        <a href="?module=dashboard">
          <i class="fas fa-home"></i>
          <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }

    // jika menu data barang (tampil data / tampil detail / form entri / form ubah) dipilih, menu data barang aktif
    if ($_GET['module'] == 'barang' || $_GET['module'] == 'tampil_detail_barang' || $_GET['module'] == 'form_entri_barang' || $_GET['module'] == 'form_ubah_barang') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isDashboard = $data['is_view'];
      if($isDashboard>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>
      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">

        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>
            
            <li class="active">
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isJenisBarang = $data['is_view'];
            if($isJenisBarang>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>
      
      <?php } ?>

    <?php
    }
    // jika menu jenis barang (tampil data / form entri / form ubah) dipilih, menu jenis barang aktif
    elseif ($_GET['module'] == 'jenis' || $_GET['module'] == 'form_entri_jenis' || $_GET['module'] == 'form_ubah_jenis') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>
      <?php } ?>

      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isJenisBarang = $data['is_view'];
            if($isJenisBarang>0){

            ?>

            <li class="active">
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isSaldoAwalFinal = $data['is_view'];
            if($isSaldoAwalFinal>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            
            <?php } ?>


          </ul>
        </div>
      </li>
      
      <?php } ?>

    <?php
    }
    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'satuan' || $_GET['module'] == 'form_entri_satuan' || $_GET['module'] == 'form_ubah_satuan') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrg = $data['is_view'];
      if($isBrg>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isJenisBrg = $data['is_view'];
            if($isJenisBrg>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li class="active">
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>


            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isSaldoAwalFinal = $data['is_view'];
            if($isSaldoAwalFinal>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>

      <?php } ?>

    <?php
    }

    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'saldo_awal_final') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBarang = $data['is_view'];
      if($isBarang>0){

      ?>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>

            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isJenisBrg = $data['is_view'];
            if($isJenisBrg>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isSaldoAwalFinal = $data['is_view'];
            if($isSaldoAwalFinal>0){

            ?>

            <li class="active">
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>

      <?php } ?>


      <?php
    }
      // jika tidak dipilih, menu barang tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Master'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isMaster = $data['is_view'];
      if($isMaster>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrg = $data['is_view'];
      if($isBrg>0){

      ?>

      <li class="nav-item">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse" id="barang">
          <ul class="nav nav-collapse">

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Data Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isdataBarang = $data['is_view'];
            if($isdataBarang>0){

            ?>
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Jenis Barang'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isJenisBarang = $data['is_view'];
            if($isJenisBarang>0){

            ?>

            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>

            <?php } ?>

            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Satuan'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $issatuan = $data['is_view'];
            if($issatuan>0){

            ?>

            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
            <?php } ?>
            
            <?php 

            $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
            INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
            INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
            WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Saldo Awal Final'
            LIMIT 1
            ");
            $data = mysqli_fetch_assoc($query);
            $isSaldoAwalFinal = $data['is_view'];
            if($isSaldoAwalFinal>0){

            ?>

            <li>
              <a href="?module=saldo_awal_final">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'saldoAwalFinal','Saldo Awal Final') ?></span>
              </a>
            </li>
            <?php } ?>


          </ul>
        </div>
      </li>

      <?php } ?>
      
    <?php
    }
   
    // jika menu barang masuk (tampil data / form entri) dipilih, menu barang masuk aktif
    if ($_GET['module'] == 'barang_masuk' || $_GET['module'] == 'form_entri_barang_masuk') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Transaksi'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isTransaksi = $data['is_view'];
      if($isTransaksi>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgMasuk = $data['is_view'];
      if($isBrgMasuk>0){

      ?>

      <li class="nav-item active">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu barang masuk tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Transaksi'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isTransaksi = $data['is_view'];
      if($isTransaksi>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgMasuk = $data['is_view'];
      if($isBrgMasuk>0){

      ?>

      <li class="nav-item">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }

    // jika menu barang keluar (tampil data / form entri) dipilih, menu barang keluar aktif
    if ($_GET['module'] == 'barang_keluar' || $_GET['module'] == 'form_entri_barang_keluar') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgKeluar = $data['is_view'];
      if($isBrgKeluar>0){

      ?>
      <li class="nav-item active">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isBrgKeluar = $data['is_view'];
      if($isBrgKeluar>0){

      ?>

      <li class="nav-item">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

      <?php
    }

    if ($_GET['module'] == 'laporan_adjustmen' || $_GET['module'] == 'form_entri_adjustment' ) { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPenyesuaian = $data['is_view'];
      if($isPenyesuaian>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
      <?php } ?>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isPenyesuaian = $data['is_view'];
      if($isPenyesuaian>0){

      ?>

      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
      <?php } ?>
    
      <?php
    }

    if ($_GET['module'] == 'stok_opname' || $_GET['module'] == 'form_entri_stok_opname' ) { ?>


      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Stok Opname'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isStokOpname = $data['is_view'];
      if($isStokOpname>0){

      ?>

      <li class="nav-item active">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

      <?php } ?>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Stok Opname'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isStokOpname = $data['is_view'];
      if($isStokOpname>0){

      ?>

      <li class="nav-item">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

      <?php } ?>

    <?php
    }

    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>
      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <?php } ?>
      
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>
      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>
      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <?php } ?>
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>
    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_status_api') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan Status Api tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>

      <?php } ?>

      <?php
    }

  }



  
  // jika hak akses = Kepala Gudang, tampilkan menu
  elseif ($_SESSION['hak_akses'] == 'Kepala Gudang') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif

    $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
                INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
                INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
                WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Dashboard'
                LIMIT 1
                ");
    $data = mysqli_fetch_assoc($query);
    $isDashboard = $data['is_view'];
    if($isDashboard>0){

      if ($_GET['module'] == 'dashboard') { ?>

        <li class="nav-item active">
          <a href="?module=dashboard">
            <i class="fas fa-home"></i>
            <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?></p>
          </a>
        </li>

      <?php
      }
      // jika tidak dipilih, menu dashboard tidak aktif
      else { ?>
        <li class="nav-item">
          <a href="?module=dashboard">
            <i class="fas fa-home"></i>
            <p><?php echo transWord($_SESSION['Lang'],'dashboard','Dashboard') ?></p>
          </a>
        </li>
      <?php
      }

    }



    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>

      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanAdjustment = $data['is_view'];
      if($isLaporanAdjustment>0){

      ?>

      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanAdjustment','Laporan Adjustment') ?></p>
        </a>
      </li>

      <?php } ?>
      
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporan = $data['is_view'];
      if($isLaporan>0){

      ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>
      <?php } ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Stok'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStok = $data['is_view'];
      if($isLaporanStok>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <?php } ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Adjustment'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanAdjustment = $data['is_view'];
      if($isLaporanAdjustment>0){

      ?>

      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanAdjustment','Laporan Adjustment') ?></p>
        </a>
      </li>

      <?php } ?>
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>

    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>

      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Kepala Gudang' AND b.menu_nama = 'Laporan Barang Masuk'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgMasuk = $data['is_view'];
      if($isLaporanBrgMasuk>0){

      ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      
      <?php } ?>


    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Barang Keluar'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanBrgKlr = $data['is_view'];
      if($isLaporanBrgKlr>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
      <?php } ?>

  <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_status_api') { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item active">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>
      <?php } ?>


    <?php
    }
    // jika tidak dipilih, menu laporan Status Api tidak aktif
    else { ?>
      
      <?php 

      $query = mysqli_query($mysqli, "SELECT a.is_view FROM tbl_akses_menu a
      INNER JOIN tbl_menu_app b ON a.id_menu_fk = b.id_menu
      INNER JOIN tbl_akses c ON a.id_akses_fk = c.id_akses
      WHERE c.akses_nama = 'Admin Gudang' AND b.menu_nama = 'Laporan Status Api'
      LIMIT 1
      ");
      $data = mysqli_fetch_assoc($query);
      $isLaporanStsApi = $data['is_view'];
      if($isLaporanStsApi>0){

      ?>

      <li class="nav-item">
        <a href="?module=laporan_status_api">
          <i class="fa fa-file-medical-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStatusApi','Laporan Status Api') ?></p>
        </a>
      </li>

      <?php } ?>

      <?php
    }

  }
}
?>