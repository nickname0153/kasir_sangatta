<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_user'] == "Yes") {

	// Membaca data dari URL
	$Kode	= $_GET['Kode'];
	if(isset($Kode)){
		// Skrip menghapus data dari tabel database
		$mySql 	= "DELETE FROM user WHERE kd_user='$Kode' AND username !='admin'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Error query 1 ".mysql_error());
		
		if($myQry) {
			// Skrip menghapus Hak Akses dari tabel database
			$my2Sql = "DELETE FROM hak_akses WHERE kd_user='$Kode'";
			mysql_query($my2Sql, $koneksidb) or die ("Error query 2 ".mysql_error());
		}
		
		// Refresh
		echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
	}
	else {
		echo "Data yang dihapus tidak ada";
	}

// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
