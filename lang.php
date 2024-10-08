<?php 

// Check if sessions are enabled
if (session_status() == PHP_SESSION_DISABLED) {
} elseif (session_status() == PHP_SESSION_NONE) {
    session_start();
    $cookieLifetime = 365 * 24 * 60 * 60; // 1 year
    session_set_cookie_params($cookieLifetime);
} elseif (session_status() == PHP_SESSION_ACTIVE) {
}


function saveLang($langValue){
    $cookie_name = 'Lang';
    $cookie_value = $langValue;
    // setcookie($cookie_name, $cookie_value, time() + (86400 * 365 * 30), "/cookies"); // 86400 = 1 day
    $_SESSION[$cookie_name] = $cookie_value;
    return;
}
function getLang($langValue=''){
    if(isset($_SESSION["Lang"])) {
        return $_SESSION["Lang"];
    } else {
        if($langValue=='Bahasa'){
            saveLang('Bahasa');
            return 'Bahasa';
        }elseif($langValue=='Mandarin'){
            saveLang('Mandarin');
            return 'Mandarin';
        }else{
            saveLang('Bahasa');
            return 'Bahasa';
        }
    }
}

function transWord($code='Bahasa',$word='welcome',$original=''){
    $lang = array(
        'Bahasa' => [
            'welcome' => 'Selamat Datang',
            'dashboard' => 'Dashboard',
            'master' => 'Master',
            'barang' => 'Barang',
            'transaksi' => 'Transaksi',
            'barangMasuk' => 'Barang Masuk',
            'barangKeluar' => 'Barang Keluar',
            'penyesuaian' => 'Penyesuaian',
            'stokOpname' => 'Stok Opname',
            'laporan' => 'Laporan',
            'laporanStok' => 'Laporan Stok',
            'laporanBarangMasuk' => 'Laporan Barang Masuk',
            'laporanBarangKeluar' => 'Laporan Barang Keluar',
            'pengaturan' => 'Pengaturan',
            'manajemenUser' => 'Manajemen User',
            'dataBarang' => 'Data Barang',
            'dataBarangMasuk' => 'Data Barang Masuk',
            'dataBarangKeluar' => 'Data Barang Keluar',
            'dataJenisBarang' => 'Data Jenis Barang',
            'dataSatuan' => 'Data Satuan',
            'dataUser' => 'Data User',
            'stokBarangTelahMencapaiBatasMinimum' => 'Stok barang telah mencapai batas minimum',
            'tampilkan' => 'Tampilkan',
            'data' => 'Data',
            'cari' => 'Cari',
            'no' => 'No',
            'idBarang' => 'ID Barang',
            'namaBarang' => 'Nama Barang',
            'jenisBarang' => 'Jenis Barang',
            'stok' => 'Stok',
            'satuan' => 'Satuan',
            'ubahPassword' => 'Ubah Password',
            'logout' => 'Logout',
            'entriData' => 'Entri Data',
            'entri' => 'Entri',
            'aksi' => 'Aksi',
            'menampilkan' => 'Menampilkan',
            'sampai' => 'Sampai',
            'dari' => 'Dari',
            'pilih' => 'Pilih',
            'stokMinimum' => 'Stok Minimum',
            'fotoBarang' => 'Foto Barang',
            'tipeFileYangBisaDiunggahAdalahJpgAtauPng' => 'Tipe file yang bisa diunggah adalah Jpg atau Png',
            'ukuranFileYangBisaDiunggahMaksimal1Mb' => 'Ukuran file yang bisa diunggah maksimal 1Mb',
            'simpan' => 'Simpan',
            'batal' => 'Batal',
            'export' => 'Export',
            'iDTransaksi' => 'ID Transaksi',
            'tanggal' => 'Tanggal',
            'jumlahMasuk' => 'Jumlah Masuk',
            'dokumenPabean' => 'Dokumen Pabean',
            'nomorDokumen' => 'Nomor Dokumen',
            'jumlahKeluar' => 'Jumlah Keluar',
            'kodeBarang' => 'Kode Barang',
            'kategoriBarang' => 'Kategori Barang',
            'kategori' => 'Kategori',
            'jumlahBarang' => 'Jumlah Barang',
            'saldoAwal' => 'Saldo Awal',
            'jumlahPemasukanBarang' => 'Jumlah Pemasukan Barang',
            'jumlahPengeluaranBarang' => 'Jumlah Pengeluaran Barang',
            'saldoAkhir' => 'Saldo Akhir',
            'keterangan' => 'Keterangan',
            'jumlahPenyesuaian' => 'Jumlah Penyesuaian',
            'stok' => 'Stok',
            'totalStok' => 'Total Stok',
            'tampilkanHalaman' => 'Tampilkan Halaman',
            'adjustment' => 'Adjustment',
            'laporanAdjustment' => 'Laporan Penyesuaian',
            "jenisBarangtidakbolehkosong" => 'Jenis barang tidak boleh kosong', 
            "namabarangtidakbolehkosong" => 'Nama barang tidak boleh kosong',
            "stokminimumtidakbolehkosong" => 'Stok minimum tidak boleh kosong',
            "satuantidakbolehkosong" => 'Satuan tidak boleh kosong',
            "entriDataJenisBarang" => 'Entri Data Jenis Barang',
            "entriDataSatuan" => 'Entri Data Satuan',
            "dokumenPabean" => 'Dokumen Pabean',
            "entriDataBarangMasuk" => 'Entri Data Barang Masuk',
            "namaPengirim" => 'Nama Pengirim',
            "nomorDokumen" => 'Nomor Dokumen',
            "tanggalDokumen" => 'Tanggal Dokumen',
            "entriDataBarangKeluar" => "Entri Data Barang Keluar",
            "sisaStok" => "Sisa Stok",
            "namaPenerima" => "Nama Penerima",
            "barangAdjustment" => "Barang Adjustment",
            "satuanBarang" => "Satuan Barang",
            "laporanStatusApi" => "Laporan Status Api",
            "profilUsaha" => "Profil Usaha",
            "cleansingDataPercobaan" => "Cleansing Data Percobaan",
            "dokumenBarang" => "Dokumen Barang",
            "saldoAwalFinal" => "Saldo Awal Final",
            "proses" => "Proses",
            "prosesData" => "Proses Data",
            "npwp" => "NPWP",
            "dataStokOpname" => "Data Stok Opname",
            "jumlah" => "Jumlah",
            "tidakadadatayangtersedia" => "Tidak ada data yang tersedia",
            "entriDataBarangAdjustment" => "Entri Data Barang Adjustment",
            "entriDataStokOpname" => "Entri Data Stok Opname",
            "seluruh" => "Seluruh",
            "filterDataStok" => "Filter Data Stok",
            "tanggalAwal" => "Tanggal Awal",
            "tanggalAkhir" => "Tanggal Akhir",
            "tampilkan" => "Tampilkan",
            "cetak" => "Cetak",
            "laporanStokSeluruhBarang" => "Laporan Stok Seluruh Barang",
            "laporanStokSeluruhJenisBarang" => "Laporan Stok Seluruh Jenis Barang",
            "laporanStokBarang" => "Laporan Stok Barang",
            "laporanStokJenisBarang" => "Laporan Stok Jenis Barang",
            "pemasukan" => "Pemasukan",
            "pengeluaran" => "Pengeluaran",
            "saldoBarang" => "Saldo Barang",
            "stockOpname" => "Stock Opname",
            "selisih" => "Selisih",
            "laporanBarangMasuk" => "Laporan Barang Masuk",
            "filterDataBarangMasuk" => "Filter Data Barang Masuk",
            "laporanDataBarangMasukTanggal" => "Laporan Data Barang Masuk Tanggal",
            "Bukti Penerimaan Barang/ Good Receive Note/ dok. lain yang sejenis" => "Bukti Penerimaan Barang/ Good Receive Note/ dok. lain yang sejenis",
            "jenisDokumen" => "Jenis Dokumen",
            "nomorDaftarDokumen" => "Nomor Daftar Dokumen",
            "tanggalDaftar" => "Tanggal Daftar",
            "laporanBarangKeluar" => "Laporan Barang Keluar",
            "filterDataBarangKeluar" => "Filter Data Barang Keluar",
            "laporanDataBarangKeluarTanggal" => "Laporan Data Barang Keluar Tanggal",
            "statusAPIINSW" => "Status API INSW",
            "dataStatusAPIINSW" => "Data Status API INSW",
            "modul" => "Modul",
            "uraian" => "Uraian",
            "noTransaksi" => "No Transaksi",
            "profilPerusahaan" => "Profil Perusahaan",
            "profil" => "Profil",
            "ubah" => "Ubah",
            "ubahData" => "Ubah Data",
            "namaPerusahaan" => "Nama Perusahaan",
            "nPWP" => "NPWP",
            "nIB" => "NIB",
            "user" => "User",
            "namaUser" => "Nama User",
            "Selamat Datang di Aplikasi Persediaan Barang Gudang Material" => "Selamat Datang di Aplikasi Persediaan Barang Gudang Material",
            "namaUser" => "Nama User",
            "username" => "Username",
            "hakAkses" => "Hak Akses",
            "entriDataUser" => "Entri Data User",
            "password" => "Password",
            "tipe" => "Tipe",
            "iD" => "ID",
            "kodeDokumen" => "Kode Dokumen",
            "entriDataBarang" => "Entri Data Barang",
            "Nama barang tidak boleh kosong" => "Nama barang tidak boleh kosong",
            "Jenis Barang tidak boleh kosong" => "Jenis Barang tidak boleh kosong",
            "iDBarang" => "ID Barang",
            "Stok minimum tidak boleh kosong" => "Stok minimum tidak boleh kosong",
            "Stok Minimum" => "Stok Minimum",
            "Satuan tidak boleh kosong" => "Satuan tidak boleh kosong",
            "ubahDataBarang" => "Ubah Data Barang",
            "Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png" => "Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png",
            "Ubah Data Jenis Barang" => "Ubah Data Jenis Barang",
            "Jenis barang tidak boleh kosong" => "Jenis barang tidak boleh kosong",
            "Ubah Data Satuan" => "Ubah Data Satuan",
            "Satuan tidak boleh kosong" => "Satuan tidak boleh kosong",
            "Data barang berhasil disimpan" => "Data barang berhasil disimpan",
            "Data barang berhasil diubah" => "Data barang berhasil diubah",
            "Data barang berhasil dihapus" => "Data barang berhasil dihapus",
            "Data barang tidak bisa dihapus karena sudah tercatat pada Data Transaksi" => "Data barang tidak bisa dihapus karena sudah tercatat pada Data Transaksi",
            "Sukses" => "Sukses",
            "Gagal" => "Gagal",
            "Anda yakin ingin menghapus data barang" => "Anda yakin ingin menghapus data barang",
            "Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb" => "Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb",
            "Detail" => "Detail",
            "Kembali" => "Kembali",
            "Detail Data Barang" => "Detail Data Barang",
            "Data jenis barang berhasil disimpan" => "Data jenis barang berhasil disimpan",
            "Data jenis barang berhasil diubah" => "Data jenis barang berhasil diubah",
            "Data jenis barang berhasil dihapus" => "Data jenis barang berhasil dihapus",
            "sudah ada. Silahkan ganti nama jenis barang yang Anda masukan" => "sudah ada. Silahkan ganti nama jenis barang yang Anda masukan",
            "Data jenis barang tidak bisa dihapus karena sudah tercatat pada Data Barang" => "Data jenis barang tidak bisa dihapus karena sudah tercatat pada Data Barang",
            "Data berhasil disimpan" => "Data berhasil disimpan",
            "Data berhasil diubah" => "Data berhasil diubah",
            "Data berhasil dihapus" => "Data berhasil dihapus",
            "Data tersebut sudah ada" => "Data tersebut sudah ada",
            "Data tidak bisa dihapus karena sudah tercatat" => "Data tidak bisa dihapus karena sudah tercatat",
            "Anda yakin ingin menghapus data" => "Anda yakin ingin menghapus data",
            "hakAkses" => "Hak Akses",
            "Data hak akses berhasil disimpan" => "Data hak akses berhasil disimpan",
            "Data hak akses berhasil diubah" => "Data hak akses berhasil diubah",
            "Data hak akses berhasil dihapus" => "Data hak akses berhasil dihapus",
            "sudah ada. Silahkan ganti nama hak akses yang Anda masukan" => "sudah ada. Silahkan ganti nama hak akses yang Anda masukan",
            "sudah ada. Silahkan ganti nama hak akses yang Anda masukan" => "sudah ada. Silahkan ganti nama hak akses yang Anda masukan",
            "dataHakAkses" => "Data Hak Akses",
            "menuAplikasi" => "Menu Aplikasi",
            "akses" => "Akses",
            "Administrator" => "Administrator",
            "Admin Gudang" => "Admin Gudang",
            "Kepala Gudang" => "Kepala Gudang",
            "Submit" => "Submit",
            "Save" => "Save",
            "Role Akses" => "Role Akses",
            "Hak akses tidak boleh kosong" => "Hak akses tidak boleh kosong",
            "Ubah Data User" => "Ubah Data User",
            "Load Akses" => "Load Akses",
            "Tanggal tidak boleh kosong" => "Tanggal tidak boleh kosong",
            "Barang tidak boleh kosong" => "Barang tidak boleh kosong",
            "Jumlah masuk tidak boleh kosong" => "Jumlah masuk tidak boleh kosong",
            "Jumlah penyesuaian tidak boleh kosong" => "Jumlah penyesuaian tidak boleh kosong",
            "Jumlah tidak boleh kosong" => "数量不能为空",

        ],
        'Mandarin' => [
            'welcome' => '欢迎',
            'dashboard' => '仪表板',
            'master' => '主',
            'barang' => '商品',
            'transaksi' => '交易',
            'barangMasuk' => '入库商品',
            'barangKeluar' => '出库商品',
            'penyesuaian' => '调整',
            'stokOpname' => '库存盘点',
            'laporan' => '报告',
            'laporanStok' => '库存报告',
            'laporanBarangMasuk' => '入库商品报告',
            'laporanBarangKeluar' => '出库商品报告',
            'pengaturan' => '设置',
            'manajemenUser' => '用户管理',
            'dataBarang' => '商品数据',
            'dataBarangMasuk' => '入库商品数据',
            'dataBarangKeluar' => '出库商品数据',
            'dataJenisBarang' => '商品类型数据',
            'dataSatuan' => '单位数据',
            'dataUser' => '用户数据',
            'stokBarangTelahMencapaiBatasMinimum' => '库存商品已达到最低限额',
            'tampilkan' => '显示',
            'data' => '数据',
            'cari' => '搜索',
            'no' => '编号',
            'idBarang' => '商品编号',
            'namaBarang' => '商品名称',
            'jenisBarang' => '商品类型',
            'stok' => '库存',
            'satuan' => '单位',
            'ubahPassword' => '修改密码',
            'logout' => '注销',
            'entriData' => '数据录入',
            'entri' => '录入',
            'aksi' => '行动',
            'menampilkan' => '显示',
            'sampai' => '直到',
            'dari' => '从',
            'pilih' => '选择',
            'stokMinimum' => '最低库存',
            'fotoBarang' => '商品照片',
            'tipeFileYangBisaDiunggahAdalahJpgAtauPng' => '可上传的文件类型为 *.jpg 或 *.png',
            'ukuranFileYangBisaDiunggahMaksimal1Mb' => '可上传的文件大小最大为 1 Mb',
            'simpan' => '保存',
            'batal' => '取消',
            'export' => '导出',
            'iDTransaksi' => '交易编号',
            'tanggal' => '日期',
            'jumlahMasuk' => '入库数量',
            'dokumenPabean' => '报关文件',
            'nomorDokumen' => '文件编号',
            'jumlahKeluar' => '出库数量',
            'kodeBarang' => '商品代码',
            'kategoriBarang' => '商品类别',
            'kategori' => '类别',
            'jumlahBarang' => '商品数量',
            'saldoAwal' => '初始余额',
            'jumlahPemasukanBarang' => '商品收入数量',
            'jumlahPengeluaranBarang' => '商品支出数量',
            'saldoAkhir' => '末余额',
            'keterangan' => '说明',
            'jumlahPenyesuaian' => '调整数量',
            'stok' => '库存',
            'totalStok' => '总库存',
            'tampilkanHalaman' => '显示页面',
            'adjustment' => '调整',
            'laporanAdjustment' => '调整报告',
            "jenisBarangtidakbolehkosong" => '商品类型不能为空', 
            "namabarangtidakbolehkosong" => '商品名称不能为空',
            "stokminimumtidakbolehkosong" => '最低库存不能为空',
            "satuantidakbolehkosong" => ' 单位不能为空',
            "entriDataJenisBarang" => '输入商品类型数据',
            "entriDataSatuan" => '输入单位数据',
            "dokumenPabean" => '海关文件',
            "entriDataBarangMasuk" => '进口商品数据录入',
            "namaPengirim" => '寄件人姓名',
            "nomorDokumen" => '文件编号',
            "tanggalDokumen" => '文件日期',
            "entriDataBarangKeluar" => "出货数据录入",
            "sisaStok" => "剩余库存",
            "namaPenerima" => "收件人姓名",
            "barangAdjustment" => "商品调整",
            "satuanBarang" => "商品单位",
            "laporanStatusApi" => "API 状态报告",
            "profilUsaha" => "企业简介",
            "cleansingDataPercobaan" => "试验数据清理",
            "dokumenBarang" => "货物文件",
            "saldoAwalFinal" => "期初余额终结",
            "proses" => "过程",
            "prosesData" => "数据处理",
            "npwp" => "纳税人识别号",
            "dataStokOpname" => "库存盘点数据",
            "jumlah" => "数量",
            "tidakadadatayangtersedia" => "没有可用的数据",
            "entriDataBarangAdjustment" => "库存调整数据录入",
            "entriDataStokOpname" => "盘点数据录入",
            "seluruh" => "全部",
            "filterDataStok" => "过滤库存数据",
            "tanggalAwal" => "起始日期",
            "tanggalAkhir" => "结束日期",
            "tampilkan" => "显示",
            "cetak" => "打印",
            "laporanStokSeluruhBarang" => "所有商品库存报告",
            "laporanStokSeluruhJenisBarang" => "所有种类商品库存报告",
            "laporanStokBarang" => "商品库存报告",
            "laporanStokJenisBarang" => "商品类别库存报告",
            "pemasukan" => "收入",
            "pengeluaran" => "支出",
            "saldoBarang" => "商品余额",
            "stockOpname" => "库存盘点",
            "selisih" => "差异",
            "laporanBarangMasuk" => "商品入库报告",
            "filterDataBarangMasuk" => "过滤商品入库数据",
            "laporanDataBarangMasukTanggal" => "按日期的商品入库数据报告",
            "Bukti Penerimaan Barang/ Good Receive Note/ dok. lain yang sejenis" => "商品接收凭证/收货单/类似文件",
            "jenisDokumen" => "文档类型",
            "nomorDaftarDokumen" => "文档编号",
            "tanggalDaftar" => "登记日期",
            "laporanBarangKeluar" => "出库报告",
            "filterDataBarangKeluar" => "过滤出库数据",
            "laporanDataBarangKeluarTanggal" => "出库数据报告日期",
            "statusAPIINSW" => "INSW API 状态",
            "dataStatusAPIINSW" => "INSW API 状态数据",
            "modul" => "模块", 
            "uraian" => "描述",
            "noTransaksi" => "交易号码",
            "profilPerusahaan" => "公司简介",
            "profil" => "个人资料",
            "ubah" => "更改",
            "ubahData" => "更改数据",
            "namaPerusahaan" => "公司名称",
            "nPWP" => "通常不翻译",
            "nIB" => "企业注册号",
            "user" => "用户",
            "Selamat Datang di Aplikasi Persediaan Barang Gudang Material" => "欢迎使用物料仓库库存管理应用程序",
            "namaUser" => "用户名",
            "username" => "用户名",
            "hakAkses" => "访问权限",
            "entriDataUser" => "用户数据录入",
            "password" => "密码",
            "tipe" => "类型",
            "iD" => "标识符",
            "kodeDokumen" => "文档编号",
            "entriDataBarang" => "商品数据录入",
            "Nama barang tidak boleh kosong" => "商品名称不能为空",
            "Jenis Barang tidak boleh kosong" => "商品类型不能为空",
            "iDBarang" => "商品ID",
            "Stok minimum tidak boleh kosong" => "最低库存不能为空",
            "Stok Minimum" => "最低库存",
            "Satuan tidak boleh kosong" => "单位不能为空",
            "ubahDataBarang" => "修改商品数据",
            "Tipe file tidak sesuai. Harap unggah file yang memiliki tipe *.jpg atau *.png" => "文件类型不正确。请上传 *.jpg 或 *.png 格式的文件",
            "Ubah Data Jenis Barang" => "修改商品类别数据",
            "Jenis barang tidak boleh kosong" => "商品类别不能为空",
            "Ubah Data Satuan" => "修改单位数据",
            "Satuan tidak boleh kosong" => "单位不能为空",
            "Data barang berhasil disimpan" => "商品数据保存成功",
            "Data barang berhasil diubah" => "商品数据修改成功",
            "Data barang berhasil dihapus" => "商品数据删除成功",
            "Data barang tidak bisa dihapus karena sudah tercatat pada Data Transaksi" => "商品数据无法删除，因为已经记录在交易数据中",
            "Sukses" => "成功",
            "Gagal" => "失败",
            "Anda yakin ingin menghapus data barang" => "您确定要删除商品数据吗",
            "Ukuran file lebih dari 1 Mb. Harap unggah file yang memiliki ukuran maksimal 1 Mb" => "文件大小超过 1 Mb。请上传最大为 1 Mb 的文件",
            "Detail" => "详细信息",
            "Kembali" => "返回",
            "Detail Data Barang" => "商品数据详情",
            "Data jenis barang berhasil disimpan" => "商品类别数据保存成功",
            "Data jenis barang berhasil diubah" => "商品类别数据修改成功",
            "Data jenis barang berhasil dihapus" => "商品类别数据删除成功",
            "sudah ada. Silahkan ganti nama jenis barang yang Anda masukan" => "已经存在。请更改您输入的商品类别名称",
            "Data jenis barang tidak bisa dihapus karena sudah tercatat pada Data Barang" => "商品类别数据无法删除，因为已经记录在商品数据中",
            "Data berhasil disimpan" => "数据保存成功",
            "Data berhasil diubah" => "数据修改成功",
            "Data berhasil dihapus" => "数据删除成功",
            "Data tersebut sudah ada" => "该数据已存在",
            "Data tidak bisa dihapus karena sudah tercatat" => "数据无法删除，因为已经被记录",
            "Anda yakin ingin menghapus data" => "您确定要删除数据吗",
            "hakAkses" => "访问权限",
            "Data hak akses berhasil disimpan" => "访问权限数据已成功保存",
            "Data hak akses berhasil diubah" => "访问权限数据已成功修改",
            "Data hak akses berhasil dihapus" => "访问权限数据已成功删除",
            "sudah ada. Silahkan ganti nama hak akses yang Anda masukan" => "已存在。请更改您输入的访问权限名称",
            "sudah ada. Silahkan ganti nama hak akses yang Anda masukan" => "访问权限数据无法删除，因为它已经记录在用户数据中",
            "dataHakAkses" => "访问权限数据",
            "menuAplikasi" => "应用菜单",
            "akses" => "访问",
            "Administrator" => "管理员",
            "Admin Gudang" => "仓库管理员",
            "Kepala Gudang" => "仓库主管",
            "Submit" => "提交",
            "Save" => "保存",
            "Role Akses" => "访问角色",
            "Hak akses tidak boleh kosong" => "访问权限不能为空",
            "Ubah Data User" => "修改用户数据",
            "Load Akses" => "加载访问",
            "Tanggal tidak boleh kosong" => "日期不能为空",
            "Barang tidak boleh kosong" => "商品不能为空",
            "Jumlah masuk tidak boleh kosong" => "J输入数量不能为空",
            "Jumlah penyesuaian tidak boleh kosong" => "调整数量不能为空",
            "Jumlah tidak boleh kosong" => "数量不能为空",

        ],
    );

    $translate = $lang[$code][$word];
    return $translate;
}

?>