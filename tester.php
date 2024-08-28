<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";

//'Administrator','Admin Gudang','Kepala Gudang'

$akses_nama_a = ['Administrator','Admin Gudang','Kepala Gudang'];
foreach ($akses_nama_a as $akses_nama) {
    $id_akses = strtoupper(uniqid('AKS-'));
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_akses(id_akses, akses_nama) 
                                     VALUES('$id_akses', '$akses_nama')")
                                     or die('Ada kesalahan pada query insert: ' . mysqli_error($mysqli));
    print_r($id_akses);
}


$menu_nama_a = [
    [
        'id_menu' => '100.001',
        'menu_nama' => 'Dashboard',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.002',
        'menu_nama' => 'Barang',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Group',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.002.001',
        'menu_nama' => 'Data Barang',
        'menu_group_id' => '100.002',
        'menu_group' => 'Barang',
        'menu_type' => 'Item',
        'menu_level' => 1,
    ], 
    [
        'id_menu' => '100.002.002',
        'menu_nama' => 'Jenis Barang',
        'menu_group_id' => '100.002',
        'menu_group' => 'Barang',
        'menu_type' => 'Item',
        'menu_level' => 1,
    ], 
    [
        'id_menu' => '100.002.003',
        'menu_nama' => 'Satuan',
        'menu_group_id' => '100.002',
        'menu_group' => 'Barang',
        'menu_type' => 'Item',
        'menu_level' => 1,
    ], 
    [
        'id_menu' => '100.002.004',
        'menu_nama' => 'Saldo Awal Final',
        'menu_group_id' => '100.002',
        'menu_group' => 'Barang',
        'menu_type' => 'Item',
        'menu_level' => 1,
    ], 
    [
        'id_menu' => '100.003',
        'menu_nama' => 'Barang Masuk',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.004',
        'menu_nama' => 'Barang Keluar',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.005',
        'menu_nama' => 'Penyesuaian',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.006',
        'menu_nama' => 'Stok Opname',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
    [
        'id_menu' => '100.006',
        'menu_nama' => 'Stok Opname',
        'menu_group_id' => '',
        'menu_group' => '',
        'menu_type' => 'Item',
        'menu_level' => 0,
    ], 
];
foreach ($menu_nama_a as $menu_nama) {
    $insert = mysqli_query($mysqli, "INSERT INTO tbl_menu_app(id_menu, menu_nama,menu_nama_display,menu_group,menu_type,menu_level) 
                                     VALUES('$id_menu', '$menu_nama', '$menu_nama_display', '$menu_group', '$menu_type', '$menu_level')")
                                     or die('Ada kesalahan pada query insert: ' . mysqli_error($mysqli));
    print_r($id_menu);
}
