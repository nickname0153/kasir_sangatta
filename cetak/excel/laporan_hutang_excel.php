<?php 
  include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=laporan_hutang_excel.xls");

if($_GET) {
  # Set Tanggal skrg
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

  $filterPeriode = " AND ( p.tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  $filterPeriode = "";
}
 ?>

<h2>LAPORAN REKAP HUTANG PER PERIODE</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="116"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="255"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
      <th width="3%"><strong><center>No</center></strong></th>
        <th width="15%"><strong>Kode Supplier</strong></th>
         <th width="15%"><strong>Tanggal</strong></th>
        <th width="25%"><strong>Nama Supplier</strong></th>
        <th width="25%"><strong>Hutang (Rp)</strong></th>
        <th width="10%"><strong>Keterangan</strong></th> 
  </tr>
  <?php
	     // Skrip menampilkan data dari database
    $fulltotal = 0;
    $cicilan = 0;
    $mySql = "SELECT p.*,s.nm_supplier, s.kd_supplier,
              p.tgl_pembelian,
              SUM(pi.harga_beli * pi.jumlah) as semua,
              SUM(p.dp) as ew
              FROM pembelian as p
              LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian
              LEFT JOIN supplier s ON p.kd_supplier = s.kd_supplier
              WHERE p.keterangan = 'Kredit' $filterPeriode
              GROUP BY p.kd_supplier
              ORDER BY p.no_pembelian ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_jenis'];
      $kds = $myData['kd_supplier']; 

    $query25 = mysql_query("SELECT SUM(pembelian_bayar.uang_bayar) as sisa FROM pembelian_bayar WHERE kd_supplier = '$kds' ");
     $rs = mysql_fetch_array($query25);
     $cicilan = $rs['sisa'];
     $duit = $myData['ew'];
     $sisaTotal = $duit + $cicilan - $myData['semua'];

    ?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $kds; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
        <td><?php echo $myData['nm_supplier']; ?></td>
        <td><?php echo number_format($myData['semua']); ?></td>
       <?php if ($sisaTotal == 0) { echo "<td class='success' align='center'><b>LUNAS</b></td>"; }else{ echo "<td class='danger' align='center'><b>BELUM LUNAS</b></td>"; } ?>
      </tr>
  <?php $fulltotal += $myData['semua']; } ?>      
  <tr class="info">
    <td colspan="4"><b>Total</b></td>
    <td colspan="2"><?php echo number_format($fulltotal); ?></td>
  </tr>
</table>