<?php
include_once "inc.connection.php";

// Membaca Login
$kodeUser	= $_SESSION['SES_LOGIN'];

// Membaca Hak Akses
$aksesSql ="SELECT * FROM hak_akses WHERE kd_user ='$kodeUser'";
$aksesQry = mysql_query($aksesSql, $koneksidb) or die ("Gagal Query Hak Akses ".mysql_error());
$aksesData= mysql_fetch_array($aksesQry);
?>