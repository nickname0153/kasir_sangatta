<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

if($_GET) {
	# Set Tanggal skrg
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

	$filterPeriode = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterPeriode = "";
}
?>
<html>
<head>
<title> :: Laporan Stok Barang per Periode - TinyLite</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
<h2>LAPORAN STOK BARANG PER PERIODE</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td width="134"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table width="1055" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22"  align="center" ><strong>No</strong></td>
    <td width="60"  ><strong>Barcode</strong></td>
    <td width="190"  ><strong>Nama Barang </strong></td>
    <td width="120" ><strong>Jumlah Stok Barang</strong></td>
    <td width="150" ><strong>Harga Satuan </strong></td>
    <td width="150" ><strong>Jumlah Harga </strong></td>
    <td width="70"  ><strong>Jumlah Stok Terjual </strong></td>
    <td width="120" ><strong>Jumlah Harga Terjual </strong></td>
    <td width="70"><strong>Jumlah Persediaan </strong></td>
    <td width="210" colspan="2"  ><strong>Jumlah Harga Persediaan </strong></td>
  </tr>

  <?php
  // Skrip menampilkan data dari database
                  $mySql  = "SELECT barang.barcode, barang.nm_barang, 
                  ( barang.stok + barang.stok_opname ) AS stok_awal, barang.harga_jual, (
                  ( barang.stok + barang.stok_opname )) * barang.harga_jual AS 
                  jumlah_harga, 
                  SUM( pi.jumlah ) AS stok_terjual, 
                  SUM( pi.jumlah ) * barang.harga_jual AS harga_terjual, 
                  (barang.stok + barang.stok_opname) AS stok_tersedia, 
                  (barang.stok + barang.stok_opname) * barang.harga_beli AS harga_persediaan
                  FROM barang
                  LEFT JOIN penjualan_item pi ON barang.kd_barang = pi.kd_barang
                  LEFT JOIN penjualan p ON pi.no_penjualan = p.no_penjualan
                  $filterSQL 
                  GROUP BY pi.kd_barang
                  ORDER BY barang.nm_barang ";
                  $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
                  $nomor  = $halaman; 
                  while ($myData = mysql_fetch_array($myQry)) :
                    $nomor++;
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['barcode']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="center"><?php echo $myData['stok_awal']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_jual']); ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['jumlah_harga']); ?></td>
    <td align="center"><?php echo $myData['stok_terjual']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_terjual']); ?></td>
    <td align="center"><?php echo $myData['stok_tersedia']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_persediaan']); ?></td>
  </tr>
<?php endwhile; ?>
 
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>