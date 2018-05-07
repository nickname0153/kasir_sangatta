<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');

# Membuat Filter Tahun
if($dataTahun) {
	$filterTahun = "AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
}
else {
	$filterTahun = "";
}
?>
<html>
<head>
<title>:: Laporan Penjualan Barang per Tahun - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN  PENJUALAN BARANG PER TAHUN</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Tahun Penjualan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="1006" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="27" rowspan="2" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="69" rowspan="2" bgcolor="#F5F5F5"><strong>Tgl.Nota </strong></td>
    <td width="69" rowspan="2" bgcolor="#F5F5F5"><strong>No. Nota </strong></td>
    <td width="56" rowspan="2" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="256" rowspan="2" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
    <td colspan="6" align="center" bgcolor="#CCCCCC"><strong>HASIL PENJUALAN</strong></td>
  </tr>
  <tr>
    <td width="93" align="right" bgcolor="#F5F5F5"><strong>H Modal (Rp)</strong></td>
    <td width="92" align="right" bgcolor="#F5F5F5"><strong>H Jual (Rp) </strong></td>
    <td width="61" align="right" bgcolor="#F5F5F5"><strong>Disc(%)</strong></td>
    <td width="98" align="right" bgcolor="#F5F5F5"><strong>H Diskon(Rp) </strong></td>
    <td width="39" align="right" bgcolor="#F5F5F5"><strong>Qty</strong></td>
    <td width="90" align="right" bgcolor="#F5F5F5"><strong>Untung (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$subTotalLaba 	= 0;
	$totalModal		= 0;
	$totalOmset		= 0;
  	$totalPendapatan = 0; 
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.harga_jual, pi.jumlah, pi.diskon
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterTahun
				GROUP BY p.no_penjualan
				ORDER BY no_penjualan ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung
		$hargaDiskon	= $myData['harga_jual'] - ( $myData['harga_jual'] * $myData['diskon']/100);
		$nilaiLaba		= $hargaDiskon - $myData['harga_beli'];
		$subTotalLaba	= $nilaiLaba * $myData['jumlah'];
		
		# Rekap data
		$totalModal		= $totalModal + ( $myData['harga_beli'] * $myData['jumlah']);  // Menghitung total modal beli
		$totalOmset		= $totalOmset + ( $hargaDiskon * $myData['jumlah']);
		$totalBarang	= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
		$totalPendapatan= $totalPendapatan + $subTotalLaba;  // Menghitung total keuntungan bersih
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?></td>
    <td align="right"><?php echo format_angka($hargaDiskon); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalLaba); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="8" align="right"><strong>TOTAL OMSET PENJUALAN (Rp.) : </strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalOmset); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($totalPendapatan); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>