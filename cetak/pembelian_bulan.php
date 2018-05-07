<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(tgl_pembelian,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND MID(tgl_pembelian,6,2)='$dataBulan' AND LEFT(tgl_pembelian,4)='$dataTahun'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Data Pembelian per Bulan/ Tahun - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN DATA PEMBELIAN PER BULAN/ TAHUN</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong> Bulan Penjualan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="81" bgcolor="#F5F5F5"><strong>Tgl. Nota </strong></td>
    <td width="81" bgcolor="#F5F5F5"><strong>No. Nota  </strong></td>
    <td width="120" bgcolor="#F5F5F5"><strong>Supplier</strong></td>
    <td width="217" bgcolor="#F5F5F5"><strong>Keterangan </strong></td>
    <td width="96" align="right" bgcolor="#F5F5F5"><strong>Total Barang</strong> </td>
    <td width="146" align="right" bgcolor="#F5F5F5"><strong>Total Belanja (Rp)</strong></td>
  </tr>
  <?php
// Variabel data
$grandTotalHarga	= 0;
$grandTotalBarang	= 0;
# Perintah untuk menampilkan pembelian dengan Filter Periode
$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier 
			$filterSQL
			ORDER BY no_pembelian DESC";
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
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>