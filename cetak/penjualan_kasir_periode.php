<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	# Set Tanggal skrg
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

	$filterPeriode = " WHERE p.keterangan = 'Cash' AND ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterPeriode = "";
}
?>
<html>
<head>
<title> :: Laporan Penjualan Kasir per Periode - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN PENJUALAN KASIR PER PERIODE</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="850" border="0" cellspacing="1" cellpadding="2">
   <tr>
  <th width="22" align="center">No</th>
    <th width="77">Tanggal </th>
    <th width="177">Nama Kasir</th>
    <th width="150">Pendapatan</th>
  </tr>
  <?php
  
 # Perintah untuk menampilkan data Rawat dengan filter Periode
  $mySql = "SELECT p.*, u.nm_user, p.tgl_penjualan, 
            SUM(b.harga_jual * pi.jumlah) as maho,
            b.harga_jual * SUM(pi.jumlah) - (b.harga_jual * pi.diskon/100 * SUM(pi.jumlah)) as odore
            FROM penjualan as p LEFT JOIN user u ON p.kd_user = u.kd_user
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
            $filterPeriode
            GROUP BY p.kd_user, p.tgl_penjualan ORDER BY p.tgl_penjualan DESC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $hal; 
  $totalJual = 0;
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;   
   ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo format_angka($ew = $myData['maho'] - $myData['odore']); ?></td>  </tr>
  <?php $totalJual += $ew; } ?>
  <tr>
    <td colspan="3" align="right"><strong>GRAND TOTAL:</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalJual); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>