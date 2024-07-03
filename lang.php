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
            'idTransaksi' => 'ID Transaksi',
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
            'adjustment' => 'Penyesuaian',
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
            'idTransaksi' => '交易编号',
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


        ],
    );

    $translate = $lang[$code][$word];
    return $translate;
}

?>