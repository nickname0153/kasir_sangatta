<?php
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_PembelianPeriode.xls");
if($_GET) {
	# Set Tanggal skrg
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

	$filterPeriode = " AND ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')
  AND p.keterangan = 'Cash'";
}
else {
	$filterPeriode = "";
}
?>
<html>
<head>
<title>:: Laporan Penjualan Barang Cash per Periode - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN  PENJUALAN BARANG CASH PER PERIODE</h2>
<table width="500" border="0"  class="table-list">
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
 <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="22" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl.Nota</strong></td>
    <td width="62" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="50" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="295" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td colspan="6" align="center" bgcolor="#999999"><strong>HASIL PENJUALAN</strong></td>
  </tr>
  <tr class="warning">
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Modal (Rp)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Jual (Rp) </strong></td>
    <td width="56" align="right" bgcolor="#CCCCCC"><strong>Disc(%)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Diskon(Rp) </strong></td>
    <td width="35" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
    <td width="85" align="right" bgcolor="#CCCCCC"><strong>Untung (Rp) </strong></td>
  </tr>
  <?php
    // deklarasi variabel
  $subTotalLaba   = 0;
  $totalModal   = 0;
  $totalOmset   = 0;
    $totalPendapatan = 0; 
  $totalBarang  = 0;
  
  # Perintah untuk menampilkan data Rawat dengan filter Periode
  $mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.harga_jual, pi.jumlah, pi.diskon
        FROM penjualan As p, penjualan_item As pi
        LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
        WHERE p.no_penjualan = pi.no_penjualan 
        $filterPeriode
        GROUP BY p.no_penjualan
        ORDER BY no_penjualan ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $hal; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;   
    # Hitung
    $hargaDiskon  = $myData['harga_jual'] - ( $myData['harga_jual'] * $myData['diskon']/100);
    $nilaiLaba    = $hargaDiskon - $myData['harga_beli'];
    $subTotalLaba = $nilaiLaba * $myData['jumlah'];
    
    # Rekap data
    $totalModal   = $totalModal + ( $myData['harga_beli'] * $myData['jumlah']);  // Menghitung total modal beli
    $totalOmset   = $totalOmset + ( $hargaDiskon * $myData['jumlah']);
    $totalBarang  = $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
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
  <tr class="info">
    <td colspan="8" align="right"><strong>TOTAL OMSET PENJUALAN (Rp.) : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalOmset); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalPendapatan); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>