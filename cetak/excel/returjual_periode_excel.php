<?php

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_returjual_barang_Bulan.xls");


# MEMBACA PERIODE TANGGAL DARI BROWSER
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

# MEMBUAT SQL FILTER PERIODE
if($_GET) {
	$filterSQL = " WHERE ( tgl_returjual BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}
?>
<h2>LAPORAN DATA RETUR PER PERIODE</h2>
<table width="500"RETURborder="0"  class="table-list">
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
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="76" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="96" bgcolor="#CCCCCC"><strong>No. Retur </strong></td>
    <td width="256" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="207" bgcolor="#CCCCCC"><strong>Keterangan </strong></td>
    <td width="106" align="right" bgcolor="#CCCCCC"><strong>Jumlah </strong></td>
  </tr>
<?php
# Perintah untuk menampilkan returjual dengan Filter Periode
$mySql = "SELECT returjual.*, supplier.nm_supplier FROM returjual 
			LEFT JOIN supplier ON returjual.kd_supplier = supplier.kd_supplier 
			$filterSQL ORDER BY no_returjual DESC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$nomor = 0; $totalRetur = 0;
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$noNota	= $myData['no_returjual'];
	
	# Menghitung Total Belanja
	$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returjual_item WHERE no_returjual='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	$totalRetur = $totalRetur + $my2Data['total_barang'];
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_returjual']); ?></td>
    <td><?php echo $myData['no_returjual']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOTAL  : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalRetur); ?></strong></td>
  </tr>
</table>