<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_ReturPembelian_perPeriode.xls");


# MEMBACA TANGGAL DARI URL BROWSER
$tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

# MEMBUAT SQL FILTER PERIODE
if($_GET) {
  $filterSQL = " AND ( r.tgl_returbeli BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  $filterSQL = "";
}

?>
 
 <h2>LAPORAN REKAP RETUR BARANG PER PERIODE</h2>
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
    <td width="26" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="51" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="448" bgcolor="#F5F5F5"><b>Nama Barang </b></td>
    <td width="136" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td width="136" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="72" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
  </tr>
  <?php
	// variabel
	$jumlahRetur = 0;
	
	// Menampilkan daftar Barang yang diretur pada Bulan terpilih
	$mySql = "SELECT barang.kd_barang, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
				FROM returbeli As r, returbeli_item As ri
				LEFT JOIN barang ON ri.kd_barang= barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returbeli = ri.no_returbeli 
				$filterSQL ORDER BY barang.kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_barang'];
		
		// Menghitung / rekap total belanja per Kode barang
		$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returbeli_item WHERE kd_barang ='$Kode'"; 
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		$jumlahRetur = $jumlahRetur + $my2Data['total_barang'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong> TOTAL :</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($jumlahRetur); ?></strong></td>
  </tr>
</table>
