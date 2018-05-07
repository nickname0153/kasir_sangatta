<?php 
  include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=laporan_piutang_excel.xls");

if($_GET) {
  # Set Tanggal skrg
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

  $filterPeriode = " AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  $filterPeriode = "";
}
 ?>

<h2>LAPORAN REKAP PIUTANG PER PERIODE</h2>
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
                  <th width="25%"><strong>Piutang (Rp)</strong></th>
                </tr>
  <?php
	 // Skrip menampilkan data dari database
    $mySql = "SELECT p.*, pi.*, pl.nm_pelanggan, pl.no_anggota,
              SUM(pi.harga_jual * pi.jumlah) as semua,
              SUM(pi.harga_jual * b.diskon / 100) * pi.jumlah as discount,
              SUM(p.uang_bayar) as ew,
              p.tgl_penjualan
              FROM penjualan as p
              LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
              LEFT JOIN pelanggan pl ON p.kd_pelanggan = pl.kd_pelanggan
              LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
              WHERE p.keterangan = 'Kredit' $filterPeriode
              GROUP BY p.kd_pelanggan
              ORDER BY p.no_penjualan ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    $fulltotal = 0;
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_jenis'];
       $kds = $myData['kd_pelanggan'];

       $query25 = mysql_query("SELECT SUM(penjualan_bayar.uang_bayar) as sisa FROM penjualan_bayar WHERE kd_pelanggan = '$kds' ");
     $rs = mysql_fetch_array($query25);
     $cicilan = $rs['sisa'];
     $duit = $myData['ew'] + $myData['discount'];
     $sisaTotal = $duit + $cicilan - $myData['semua'];
  
    ?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['no_anggota']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
        <td><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo number_format( $ew = $myData['semua'] - $myData['discount']); ?></td>
         <?php if ($sisaTotal == 0) { echo "<td class='success' align='center'><b>LUNAS</b></td>"; }else{ echo "<td class='danger' align='center'><b>BELUM LUNAS</b></td>"; } ?>
      
      </tr>
  <?php $fulltotal += $ew; } ?>         
  <tr class="info">
    <td colspan="4"><b>Total</b></td>
    <td colspan="2"><?php echo number_format($fulltotal); ?></td>
  </tr>
</table>