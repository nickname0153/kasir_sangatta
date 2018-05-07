<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Sub Kategori</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA SUB KATEGORI </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="75" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="241" bgcolor="#F5F5F5"><strong>Nama Sub Kategori </strong></td>
    <td width="235" bgcolor="#F5F5F5">Kategori</td>
  </tr>
  <?php
  // Skrip menampilkan data dari database
	$mySql 	= "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori_sub
					LEFT JOIN kategori ON kategori_sub.kd_kategori = kategori.kd_kategori
					ORDER BY kategori_sub.kd_kategorisub";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategorisub']; ?></td>
    <td><?php echo $myData['nm_kategorisub']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>