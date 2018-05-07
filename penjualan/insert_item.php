<?php 
	include_once "../library/inc.hakakses.php";
	$kodeUser	= $_SESSION['SES_LOGIN'];
    if( isset($_GET['barcode']) && isset($_GET['nama']) && isset($_GET['sn']) && isset($_GET['harga']) && isset($_GET['dis']) && isset($_GET['jumlah']) ){
        $barcode = isset($_GET['barcode']);
        $nama = isset($_GET['nama']);
        $sn = isset($_GET['sn']);
        $harga = isset($_GET['harga']);
        $dis = isset($_GET['dis']);
        $jumlah = isset($_GET['jumlah']);

//buat table baru
//sesuaikan spt tmp_penjualan
        //buat seleksi
        //apabila data record ada di tmp_item maka masukan jg ke pembelian_item

       $tmpSql 	= "INSERT INTO tmp_penjualan (kd_barang, nama, sn, harga,  diskon, jumlah, kd_user) 
					VALUES ('$kodeBarang', '$txtHarga', '$txtJumlah', '$txtDisc', '$kodeUser')";
	mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
    }
 ?> 