<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Jenis</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA JENIS</h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="75" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="241" bgcolor="#F5F5F5"><strong>Nama Jenis</strong></td>
    <td width="235" bgcolor="#F5F5F5">Sub Kategori</td>
  </tr>
  <?php
  // Skrip menampilkan data dari database
	$mySql 	= "SELECT jenis.*, kategori_sub.nm_kategorisub FROM jenis
					LEFT JOIN kategori_sub ON jenis.kd_kategorisub = kategori_sub.kd_kategorisub
					ORDER BY jenis.kd_jenis";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_jenis']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_kategorisub']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>