<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Pembelian_Supplier.xls");


# Temporary Variabel form
$kodeSupplier	= isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : '';

if($_GET) {
	# PILIH KATEGORI
	if ($kodeSupplier =="SEMUA") {
		$filterSQL = "";
		$namaSupplier= "-";
	}
	else {
		$filterSQL = " WHERE pembelian.kd_supplier='$kodeSupplier'";
		
		// Mendapatkan informasi
		$infoSql = "SELECT * FROM supplier WHERE kd_supplier='$kodeSupplier'";
		$infoQry = mysql_query($infoSql, $koneksidb);
		$infoData= mysql_fetch_array($infoQry);
		$namaSupplier= $infoData['kd_supplier']." / ".$infoData['nm_supplier'];
	}
} // End GET
else {
	$filterSQL = "";
}
?>
<h2>LAPORAN DATA PEMBELIAN PER SUPPLIER</h2>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="28" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="70" bgcolor="#F5F5F5"><strong>Tanggal</strong></td>
    <td width="97" bgcolor="#F5F5F5"><strong>No. Pembelian </strong></td>
    <td width="176" bgcolor="#F5F5F5"><strong>Supplier</strong></td>
    <td width="166" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
    <td width="91" align="right" bgcolor="#F5F5F5"><strong>Total Barang</strong> </td>
    <td width="136" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp)</strong></td>
  </tr>
<?php
// Variabel data
$grandTotalHarga	= 0;
$grandTotalBarang	= 0;
# Perintah untuk menampilkan pembelian dengan Filter Periode
$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier 
			$filterSQL ORDER BY no_pembelian DESC";
$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
$nomor = 0;
while ($myData = mysql_fetch_array($myQry)) {
	$nomor++;
	$noNota	= $myData['no_pembelian'];
	
	# Menghitung Total Tiap Transaksi
	$my2Sql = "SELECT SUM(harga_beli * jumlah) As total_belanja,
					  SUM(jumlah) As total_barang 
					  FROM pembelian_item WHERE no_pembelian='$noNota'";
	$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$my2Data= mysql_fetch_array($my2Qry);
	
	// Menjumlah Total Semua Transaksi yang ditampilkan
	$grandTotalHarga	= $grandTotalHarga + $my2Data['total_belanja'];
	$grandTotalBarang	= $grandTotalBarang + $my2Data['total_barang'];
?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right">Rp. <?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
<?php } ?>
  <tr>
    <td colspan="5" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><?php echo format_angka($grandTotalBarang); ?></td>
    <td align="right" bgcolor="#F5F5F5"><strong>Rp. <?php echo format_angka($grandTotalHarga); ?></strong></td>
  </tr>
</table>