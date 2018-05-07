<?php 
	include_once "../library/inc.hakakses.php";
    $kd_pelanggan = isset($_GET['kd_pelanggan']);
    $SQL = "SELECT * FROM tmp_penjualan";
    $quer = mysql_query($SQL) or die("Gagal Query tmp : ".mysql_error());
    while ($data = mysql_fetch_array($quer)) {
        $kd_barang = $data['kd_barang'];
        $sss = mysql_query("SELECT * FROM barang where kd_barang='$kd_barang'");
        while ($data2 = mysql_fetch_array($sss)) {
            if ($kd_pelanggan == "P001") {
                $hrg = $data2['harga_jual'];
            }
            else{
                $hrg = $data2['harga_member'];
            }
            $tmpSql     = "UPDATE tmp_penjualan SET harga = '$hrg' WHERE kd_barang = '$kd_barang'";
            mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
        }
    }
 ?> 