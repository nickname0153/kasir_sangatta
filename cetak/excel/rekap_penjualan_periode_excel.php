<?php 
  include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Penjualan_Periode.xls");

# MEMBACA TANGGAL PERIODE
$tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

# MEMBUAT SQL FILTER DATA
if($_GET) {
  $filterSQL = " WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  $filterSQL = "";
}

 ?>

<h2>LAPORAN REKAP PENJUALAN BARANG PER PERIODE</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="116"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="255"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="52"  bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="424" bgcolor="#F5F5F5"><b>Nama Barang </b></td>
    <td width="200" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="50" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
    <td width="120" align="right" bgcolor="#F5F5F5"><b> Total Harga(Rp) </b></td>
  </tr>
  <?php
	// variabel
	$jumlahJual = 0;
	$jumlahBelanja = 0;
	
	// Menampilkan daftar Barang yang dibeli pada Bulan terpilih
$mySql = "SELECT barang.kd_barang, barang.nm_barang, merek.nm_merek 
        FROM penjualan As p 
        LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
        LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
        LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
         $filterSQL
        GROUP BY barang.kd_barang
        ORDER BY barang.kd_barang ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $nomor = 0; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_barang'];

    // Menghitung / rekap total belanja per Kode barang
    $my2Sql = "SELECT SUM(jumlah) As total_barang, 
              harga_jual * SUM(jumlah) - (harga_jual * diskon/100 * SUM(jumlah)) As total_belanja  
          FROM penjualan_item WHERE kd_barang ='$Kode'"; 
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		$jumlahJual = $jumlahJual + $my2Data['total_barang'];
		$jumlahBelanja = $jumlahBelanja + $my2Data['total_belanja'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" align="right"><strong>GRAND TOTAL :</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($jumlahJual); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($jumlahBelanja); ?></strong></td>
  </tr>
</table>
