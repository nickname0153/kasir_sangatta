<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
?>
<html>
<head>
<title>:: Laporan Data Pelanggan</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA PELANGGAN </h2>
<table class="table-list" width="739" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="34" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="66" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="148" bgcolor="#F5F5F5"><strong>Nama Pelanggan </strong></td>
    <td width="351" bgcolor="#F5F5F5"><strong>Alamat Lengkap </strong></td>
    <td width="114" bgcolor="#F5F5F5"><strong>No. Telepon </strong></td>
  </tr>
  <?php
  	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM pelanggan ORDER BY nm_pelanggan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_pelanggan']; ?></td>
    <td><?php echo $myData['nm_pelanggan']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>