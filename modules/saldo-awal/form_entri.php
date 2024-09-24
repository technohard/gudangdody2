<?php
// mencegah direct access file PHP agar file PHP tidak bisa diakses secara langsung dari browser dan hanya dapat dijalankan ketika di include oleh file lain
// jika file diakses secara langsung
if (basename($_SERVER['PHP_SELF']) === basename(__FILE__)) {
  // alihkan ke halaman error 404
  header('location: 404.html');
}
// jika file di include oleh file lain, tampilkan isi file
else { ?>
  <!-- menampilkan pesan kesalahan -->
  <div id="pesan"></div>

  <div class="panel-header bg-secondary-gradient">
    <div class="page-inner py-4">
      <div class="page-header text-white">
        <!-- judul halaman -->
        <h4 class="page-title text-white"><i class="fas fa-sign-in-alt mr-2"></i> Saldo Awal</h4>
        <!-- breadcrumbs -->
        <ul class="breadcrumbs">
          <li class="nav-home"><a href="?module=dashboard"><i class="flaticon-home text-white"></i></a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a href="?module=saldo_awal" class="text-white">Saldo Awal</a></li>
          <li class="separator"><i class="flaticon-right-arrow"></i></li>
          <li class="nav-item"><a>Entri</a></li>
        </ul>
      </div>
    </div>
  </div>

  <div class="page-inner mt--5">
    <div class="card">
      <div class="card-header">
        <!-- judul form -->
        <div class="card-title">Entri Data Saldo Awal</div>
      </div>
      <!-- form entri data -->
      <form action="modules/saldo-awal/proses_entri.php" method="post" class="needs-validation" novalidate>
        <div class="card-body">
          <div class="row">
            

            <div class="col-md-5">
              <div class="form-group">
                <label>Periode <span class="text-danger">*</span></label>
                <input type="text" name="periode" class="form-control" autocomplete="off" value="<?php echo date('Ym'); ?>" required>
                <div class="invalid-feedback">Periode tidak boleh kosong.</div>
              </div>
            </div>

          </div>

          <hr class="mt-3 mb-4">

          <div class="row">
            <div class="col-md-7">
              <div class="form-group">
                <label>Barang <span class="text-danger">*</span></label>
                <select id="data_barang" name="barang" class="form-control chosen-select" autocomplete="off" required>
                  <option selected disabled value="">-- Pilih --</option>
                  <?php
                  // sql statement untuk menampilkan data dari tabel "tbl_barang"
                  ($query_barang = mysqli_query($mysqli, 'SELECT id_barang, nama_barang FROM tbl_barang ORDER BY id_barang ASC')) or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
                  // ambil data hasil query
                  while ($data_barang = mysqli_fetch_assoc($query_barang)) {
                    // tampilkan data
                    echo "<option value='$data_barang[id_barang]'>$data_barang[id_barang] - $data_barang[nama_barang]</option>";
                  }
                  ?>
                </select>
                <div class="invalid-feedback">Barang tidak boleh kosong.</div>
              </div>

              <div class="form-group">
                <label>Stok <span class="text-danger">*</span></label>
                <div class="input-group">
                  <input type="text" id="data_stok" name="stok" class="form-control" readonly>
                  <div id="data_satuan" class="input-group-append"></div>
                </div>
              </div>


              
            </div>





            <div class="col-md-5 ml-auto">
              <div class="form-group">
                <label>Saldo Awal <span class="text-danger">*</span></label>
                <input type="number" id="saldo_awal" name="saldo_awal" class="form-control" value="0" autocomplete="off" >
                <div class="invalid-feedback">Saldo Awal tidak boleh kosong.</div>
              </div>

              
            </div>
          </div>
          <div class="card-action">
            <!-- tombol simpan data -->
            <!-- <input type="submit" name="simpan" value="Simpan" class="btn btn-secondary btn-round pl-4 pr-4 mr-2"> -->
            <button class="btn btn-secondary btn-round pl-4 pr-4 mr-2" type="submit" name="simpan" value="Simpan">
             <?php echo transWord($_SESSION['Lang'],'simpan','Simpan') ?>
           </button>

            <!-- tombol kembali ke halaman data barang masuk -->
            <a href="?module=barang_masuk" class="btn btn-default btn-round pl-4 pr-4"><?php echo transWord($_SESSION['Lang'],'batal','Batal') ?></a>
          </div>

        </div>

      </form>

    </div>

    <script type="text/javascript">
      $(document).ready(function() {
        // Menampilkan data barang dari select box ke textfield
        $('#data_barang').change(function() {
          // mengambil value dari "id_barang"
          var id_barang = $('#data_barang').val();

          $.ajax({
            type: "GET", // mengirim data dengan method GET 
            url: "modules/barang-masuk/get_barang.php", // proses get data berdasarkan "id_barang"
            data: {
              id_barang: id_barang
            }, // data yang dikirim
            dataType: "JSON", // tipe data JSON
            success: function(result) { // ketika proses get data selesai
              // tampilkan data
              $('#data_stok').val(result.stok);
              $('#data_satuan').html('<span class="input-group-text">' + result
                .nama_satuan + '</span>');
              // set focus
              $('#saldo_awal').focus();
            }
          });
        });

        

        
      });
    </script>
  <?php } ?>