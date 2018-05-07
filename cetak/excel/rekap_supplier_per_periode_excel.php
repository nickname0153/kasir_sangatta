<?php
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Supplier_per_periode.xls");
# MEMBACA TANGGAL PERIODE
$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

# MEMBUAT SQL FILTER DATA
if($_GET) {
	$filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title>:: Laporan Rekap Penjualan Barang per Periode - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css"></head>
<body>
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
<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="24" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="64" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></td>
    <td width="365" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Supplier  </strong></td>
    <td colspan="4" align="center" bgcolor="#999999"><strong>DETIL PEMBELIAN </strong></td>
  </tr>
  <tr class="success success-active">
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Pembelian Cash (Rp) </strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Pembelian Kredit (Rp)</strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
  </tr>
  <?php
    // deklarasi variabel
  $totalHarga = 0;
  $totalBarang  = 0;
  
  # Perintah untuk menampilkan data Rawat dengan filter Periode
  $mySql = "SELECT p.no_pembelian, p.tgl_pembelian, supplier.nm_supplier,supplier.kd_supplier, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah
        FROM pembelian As p 
        LEFT JOIN pembelian_item As pi ON p.no_pembelian = pi.no_pembelian
        LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
        LEFT JOIN supplier ON p.kd_supplier = supplier.kd_supplier
        $filterPeriode  
        GROUP BY  p.kd_supplier,p.tgl_pembelian
        ORDER BY no_pembelian ASC LIMIT $halaman, $baris";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $halaman; 
  while ($myData = mysql_fetch_array($myQry)) {
    $kd_supplier = $myData['kd_supplier'];
    $tgl_pembelian = $myData['tgl_pembelian'];
    $nomor++;   
    
    # Rekap data
    $totalHarga = $totalHarga + $myData['harga_beli'];  // Menghitung total modal beli
    $totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual

    $query1 = mysql_query("SELECT p.*,pi.*, SUM(pi.jumlah * pi.harga_beli) as kredit FROM pembelian as p 
                          LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian
                          WHERE p.kd_supplier = '$kd_supplier' AND p.keterangan = 'Kredit' 
                          AND p.tgl_pembelian = '$tgl_pembelian'");
    $rs1 = mysql_fetch_array($query1);

    $query2 = mysql_query("SELECT p.*,pi.*, SUM(pi.jumlah * pi.harga_beli) as cash FROM pembelian as p 
                          LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian
                          WHERE p.kd_supplier = '$kd_supplier' AND p.keterangan = 'Cash' 
                          AND p.tgl_pembelian = '$tgl_pembelian' ");
    $rs2 = mysql_fetch_array($query2);


    $query3 = mysql_query("SELECT p.*,pi.*, SUM(pi.jumlah * pi.harga_beli) as total FROM pembelian as p 
                          LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian
                          WHERE p.kd_supplier = '$kd_supplier' AND p.tgl_pembelian = '$tgl_pembelian' ");
    $rs3 = mysql_fetch_array($query3);

  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td align="right"><?php echo format_angka($rs2['cash']); ?></td>
    <td align="right"><?php echo format_angka($rs1['kredit']); ?></td>
    <td align="right"><?php echo format_angka($rs3['total']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="5" align="right"><strong>Halaman ke :</strong>
  <?php
  for ($h = 1; $h <= $maksData; $h++) {
    $list[$h] = $baris * $h - $baris;
    echo " <a href='?open=Laporan-Pembelian-Barang-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>