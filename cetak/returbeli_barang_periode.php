<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# MEMBACA PERIODE TANGGAL DARI BROWSER
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

# MEMBUAT SQL FILTER PERIODE
if($_GET) {
	$filterSQL = " AND ( tgl_returbeli BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title> :: Laporan Retur Barang per Periode - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN RETUR BARANG PER PERIODE</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="71" bgcolor="#F5F5F5"><strong>Tgl. Nota </strong></td>
    <td width="71" bgcolor="#F5F5F5"><strong>No. Retur </strong></td>
    <td width="56" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="310" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td width="140" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td width="136" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="48" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT r.no_returbeli, r.tgl_returbeli, ri.kd_barang, ri.jumlah, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
				FROM returbeli As r, returbeli_item As ri
				LEFT JOIN barang ON ri.kd_barang = barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returbeli = ri.no_returbeli
				$filterSQL
				ORDER BY no_returbeli, kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
		# Rekap data
		$totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_returbeli']); ?></td>
    <td><?php echo $myData['no_returbeli']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="7" align="right"><strong>GRAND TOTAL:</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>