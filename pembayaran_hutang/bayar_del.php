<?php 
include_once "../library/inc.connection.php";


	// Membaca data dari URL
	$id	= $_GET['id'];
	$Kode = $_GET['kode'];
	if(isset($id)){
		// Skrip menghapus data dari tabel database
		$mySql = "DELETE FROM pembelian_bayar WHERE no_belibayar='$id'";
		mysql_query($mySql, $koneksidb) or die ("Error query : ".mysql_error());
		
		// Refresh
		echo "<meta http-equiv='refresh' content='0; url=./?open=Bayar&Kode=$Kode'>";
	}
	else {
		echo "Data yang dihapus tidak ada";
	}
	
// Penutup Hak Akses

?>
