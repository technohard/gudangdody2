<?php
// panggil file "database.php" untuk koneksi ke database
require_once "config/database.php";


$query = mysqli_query($mysqli, "SELECT * FROM tbl_menu_app")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

while ($data = mysqli_fetch_assoc($query)) {

    $id_menu = $data['id_menu'];
    $menu_nama = $data['menu_nama'];
    $menu_nama_mdr = $data['menu_nama_mdr'];
    $menu_level = $data['menu_level'];

    $menu_nama_display = $menu_nama;
    $menu_nama_display_mdr = $menu_nama_mdr;
    if($menu_level>0){
        $menu_nama_display = str_repeat("&nbsp;", $menu_level * 5).'|'.str_repeat("-", $menu_level * 5) . $menu_nama ;
        $menu_nama_display_mdr = str_repeat("&nbsp;", $menu_level * 5).'|'.str_repeat("-", $menu_level * 5) . $menu_nama_mdr ;
    }

    $query2 = mysqli_query($mysqli, "UPDATE tbl_menu_app SET 
    menu_nama_display = '$menu_nama_display',
    menu_nama_display_mdr = '$menu_nama_display_mdr'
    WHERE id_menu = '$id_menu'
     ")
    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

    echo '<br>';
    echo $menu_nama_display.' '.$menu_nama_display_mdr.' '.$id_menu;

}

//'Administrator','Admin Gudang','Kepala Gudang'

// $akses_nama_a = ['Administrator', 'Admin Gudang', 'Kepala Gudang'];
// foreach ($akses_nama_a as $akses_nama) {
//     $id_akses = strtoupper(uniqid('AKS-'));
//     $insert = mysqli_query($mysqli, "INSERT INTO tbl_akses(id_akses, akses_nama) 
//                                      VALUES('$id_akses', '$akses_nama')")
//         or die('Ada kesalahan pada query insert: ' . mysqli_error($mysqli));
//     print_r($id_akses);
// }


// $query = mysqli_query($mysqli, "SELECT * FROM tbl_akses")
//     or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));


// while ($data = mysqli_fetch_assoc($query)) {
//     $id_akses = $data['id_akses'];
//     $akses_nama = $data['akses_nama'];

//     $query2 = mysqli_query($mysqli, "SELECT * FROM tbl_menu_app ORDER BY id_menu ASC")
//     or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));

//     while ($data2 = mysqli_fetch_assoc($query2)) {

//         $id_menu = $data2['id_menu'];
        
//         $id_akses_menu = strtoupper(uniqid('ACM-'));
//         $insert = mysqli_query($mysqli, "INSERT INTO tbl_akses_menu(id_akses_menu, id_akses_fk,id_menu_fk) 
//                                       VALUES('$id_akses_menu', '$id_akses', '$id_menu')")
//         or die('Ada kesalahan pada query insert: ' . mysqli_error($mysqli));

//         echo '<br>';
//         echo $id_akses_menu.' '.$id_akses.' '.$id_menu;

//     }

// }
