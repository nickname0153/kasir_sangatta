<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Variabel SQL
$filterSQL	= "";

# Temporary Variabel form
$kodeKategori	= isset($_GET['kodeKategori']) ? $_GET['kodeKategori'] : '';

if($_GET) {
	# PILIH KATEGORI
	if ($kodeKategori =="Semua") {
		$filterSQL = "";
		$namaKategori= "-";
	}
	else {
		$filterSQL = " WHERE kategori.kd_kategori='$kodeKategori'";
		
		// Mendapatkan informasi
		$infoSql = "SELECT * FROM kategori WHERE kd_kategori='$kodeKategori'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		$namaKategori= $infoData['nm_kategori'];
	}
} // End GET
else {
	$kategoriSQL= "";
}
?>
<html>
<head>
<title> :: Laporan Data Barang per Kategori</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN DATA BARANG - PER KATEGORI</h2>
<table width="400" border="0"  class="table-list">
<tr>
  <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN </strong></td>
</tr>
<tr>
  <td width="109"><b>Nama Kategori </b></td>
  <td width="15"><b>:</b></td>
  <td width="262"><?php echo $namaKategori; ?></td>
</tr>
</table>
  
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="45" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="70" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
    <td width="385" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
    <td width="115" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td width="46" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
    <td width="31" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
    <td width="100" align="right" bgcolor="#F5F5F5"><strong>Hrg Jual (Rp) </strong></td>
    <td width="39" align="right" bgcolor="#F5F5F5"><strong>Disc</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
				$filterSQL 
				ORDER BY barang.kd_barang ASC";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td><?php echo $nomor; ?> </td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['barcode']; ?> </td>
    <td><?php echo $myData['nm_barang']; ?> </td>
    <td><?php echo $myData['nm_jenis']; ?> </td>
    <td><?php echo $myData['satuan_jual']; ?> </td>
    <td align="right"><?php echo $myData['stok']; ?> </td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?> %</td>
  </tr>
  <?php } ?>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>