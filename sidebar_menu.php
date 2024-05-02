<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else {
  require_once "./lang.php";
  // pengecekan hak akses untuk menampilkan menu sesuai dengan hak akses
  // jika hak akses = Administrator, tampilkan menu
  if ($_SESSION['hak_akses'] == 'Administrator') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif
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

    // jika menu data barang (tampil data / tampil detail / form entri / form ubah) dipilih, menu data barang aktif
    if ($_GET['module'] == 'barang' || $_GET['module'] == 'tampil_detail_barang' || $_GET['module'] == 'form_entri_barang' || $_GET['module'] == 'form_ubah_barang') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li class="active">
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?> </span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?> </span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?> </span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika menu jenis barang (tampil data / form entri / form ubah) dipilih, menu jenis barang aktif
    elseif ($_GET['module'] == 'jenis' || $_GET['module'] == 'form_entri_jenis' || $_GET['module'] == 'form_ubah_jenis') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?> </span>
              </a>
            </li>
            <li class="active">
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'satuan' || $_GET['module'] == 'form_entri_satuan' || $_GET['module'] == 'form_ubah_satuan') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li class="active">
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }

    // jika menu barang masuk (tampil data / form entri) dipilih, menu barang masuk aktif
    if ($_GET['module'] == 'barang_masuk' || $_GET['module'] == 'form_entri_barang_masuk') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang masuk tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu barang keluar (tampil data / form entri) dipilih, menu barang keluar aktif
    if ($_GET['module'] == 'barang_keluar' || $_GET['module'] == 'form_entri_barang_keluar') { ?>
      <li class="nav-item active">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }

    if ($_GET['module'] == 'laporan_adjustmen' ) { ?>

      <li class="nav-item active">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
    
      <?php
    }

    if ($_GET['module'] == 'stok_opname' ) { ?>

      <li class="nav-item active">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <li class="nav-item">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

    <?php
    }

    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?></p>
        </a>
      </li>

          
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?></p>
        </a>
      </li>
      
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu manajemen user (tampil data / form entri / form ubah) dipilih, menu manajemen user aktif
    if ($_GET['module'] == 'user' || $_GET['module'] == 'form_entri_user' || $_GET['module'] == 'form_ubah_user') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'pengaturan','Pengaturan') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=user">
          <i class="fas fa-user"></i>
          <p><?php echo transWord($_SESSION['Lang'],'manajemenUser','Manajemen User') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu manajemen user tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'pengaturan','Pengaturan') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=user">
          <i class="fas fa-user"></i>
          <p><?php echo transWord($_SESSION['Lang'],'manajemenUser','Manajemen User') ?></p>
        </a>
      </li>
    <?php
    }
  }



  // jika hak akses = Admin Gudang, tampilkan menu
  elseif ($_SESSION['hak_akses'] == 'Admin Gudang') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif
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

    // jika menu data barang (tampil data / tampil detail / form entri / form ubah) dipilih, menu data barang aktif
    if ($_GET['module'] == 'barang' || $_GET['module'] == 'tampil_detail_barang' || $_GET['module'] == 'form_entri_barang' || $_GET['module'] == 'form_ubah_barang') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li class="active">
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika menu jenis barang (tampil data / form entri / form ubah) dipilih, menu jenis barang aktif
    elseif ($_GET['module'] == 'jenis' || $_GET['module'] == 'form_entri_jenis' || $_GET['module'] == 'form_ubah_jenis') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li class="active">
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika menu satuan (tampil data / form entri / form ubah) dipilih, menu satuan aktif
    elseif ($_GET['module'] == 'satuan' || $_GET['module'] == 'form_entri_satuan' || $_GET['module'] == 'form_ubah_satuan') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item active submenu">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse show" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li class="active">
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'master','Master') ?></h4>
      </li>

      <li class="nav-item">
        <a data-toggle="collapse" href="#barang">
          <i class="fas fa-clone"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barang','Barang') ?></p>
          <span class="caret"></span>
        </a>

        <div class="collapse" id="barang">
          <ul class="nav nav-collapse">
            <li>
              <a href="?module=barang">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'dataBarang','Data Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=jenis">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'jenisBarang','Jenis Barang') ?></span>
              </a>
            </li>
            <li>
              <a href="?module=satuan">
                <span class="sub-item"><?php echo transWord($_SESSION['Lang'],'satuan','Satuan') ?></span>
              </a>
            </li>
          </ul>
        </div>
      </li>
    <?php
    }

    // jika menu barang masuk (tampil data / form entri) dipilih, menu barang masuk aktif
    if ($_GET['module'] == 'barang_masuk' || $_GET['module'] == 'form_entri_barang_masuk') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang masuk tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'transaksi','Transaksi') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=barang_masuk">
          <i class="fas fa-sign-in-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangMasuk','Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu barang keluar (tampil data / form entri) dipilih, menu barang keluar aktif
    if ($_GET['module'] == 'barang_keluar' || $_GET['module'] == 'form_entri_barang_keluar') { ?>
      <li class="nav-item active">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=barang_keluar">
          <i class="fas fa-sign-out-alt"></i>
          <p><?php echo transWord($_SESSION['Lang'],'barangKeluar','Barang Keluar') ?></p>
        </a>
      </li>
      <?php
    }

    if ($_GET['module'] == 'laporan_adjustmen' ) { ?>

      <li class="nav-item active">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'adjustment','Adjustment') ?></p>
        </a>
      </li>
    
      <?php
    }

    if ($_GET['module'] == 'stok_opname' ) { ?>

      <li class="nav-item active">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

      <?php
    }
    // jika tidak dipilih, menu barang keluar tidak aktif
    else { ?>

      <li class="nav-item">
        <a href="?module=stok_opname">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'stokOpname','Stok Opname') ?></p>
        </a>
      </li>

    <?php
    }

    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
  }



  
  // jika hak akses = Kepala Gudang, tampilkan menu
  elseif ($_SESSION['hak_akses'] == 'Kepala Gudang') {
    // pengecekan menu aktif
    // jika menu dashboard dipilih, menu dashboard aktif
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

    // jika menu laporan stok dipilih, menu laporan stok aktif
    if ($_GET['module'] == 'laporan_stok') { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item active">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanAdjustment','Laporan Adjustment') ?></p>
        </a>
      </li>
      
    <?php
    }
    // jika tidak dipilih, menu laporan stok tidak aktif
    else { ?>
      <li class="nav-section">
        <span class="sidebar-mini-icon">
          <i class="fa fa-ellipsis-h"></i>
        </span>
        <h4 class="text-section"><?php echo transWord($_SESSION['Lang'],'laporan','Laporan') ?></h4>
      </li>

      <li class="nav-item">
        <a href="?module=laporan_stok">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanStok','Laporan Stok') ?> </p>
        </a>
      </li>
      <li class="nav-item ">
        <a href="?module=laporan_adjustmen">
          <i class="fas fa-file-signature"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanAdjustment','Laporan Adjustment') ?></p>
        </a>
      </li>
      
    <?php
    }

    // jika menu laporan barang masuk dipilih, menu laporan barang masuk aktif
    if ($_GET['module'] == 'laporan_barang_masuk') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang masuk tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_masuk">
          <i class="fas fa-file-import"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangMasuk','Laporan Barang Masuk') ?></p>
        </a>
      </li>
    <?php
    }

    // jika menu laporan barang keluar dipilih, menu laporan barang keluar aktif
    if ($_GET['module'] == 'laporan_barang_keluar') { ?>
      <li class="nav-item active">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
    <?php
    }
    // jika tidak dipilih, menu laporan barang keluar tidak aktif
    else { ?>
      <li class="nav-item">
        <a href="?module=laporan_barang_keluar">
          <i class="fas fa-file-export"></i>
          <p><?php echo transWord($_SESSION['Lang'],'laporanBarangKeluar','Laporan Barang Keluar') ?></p>
        </a>
      </li>
<?php
    }
  }
}
?>