<?php
include_once "../library/inc.connection.php";
    if( isset($_GET['kd_barang']) && isset($_GET['sn'])){
        $kd_barang=$_GET['kd_barang'];
        $sn=$_GET['sn'];
        $mySql = "UPDATE tmp_penjualan SET sn='$sn' WHERE kd_barang='$kd_barang'";
        mysql_query($mySql, $koneksidb) or die ("Gagal Query : ".mysql_error());
    }
?>