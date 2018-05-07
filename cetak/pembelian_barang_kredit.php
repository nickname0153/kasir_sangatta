<?php 

session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";;

if($_GET) {
  # Set Tanggal skrg
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

  $filterPeriode = "AND ( tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."') AND keterangan = 'Kredit'";
}
else {
  $filterSQL = "";
}
 ?>

<h2>LAPORAN DATA PEMBELIAN KREDIT PER PERIODE</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong>Periode Tanggal </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $tglAwal; ?> <strong>s/d</strong> <?php echo $tglAkhir; ?></td>
  </tr>
</table>
<br />
 <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="24" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="64" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></td>
    <td width="64" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota  </strong></td>
    <td width="50" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="365" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td colspan="5" align="center" bgcolor="#999999"><strong>DETIL PEMBELIAN </strong></td>
  </tr>
  <tr class="success success-active">
    <td width="112" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><strong>DP (Rp) </strong></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><strong>Sisa (Rp) </strong></td>
  </tr>
  <?php
    // deklarasi variabel
  $totalHarga = 0;
  $totalBarang  = 0;
  $totalbeli = 0;
  
  # Perintah untuk menampilkan data Rawat dengan filter Periode
  $mySql = "SELECT p.no_pembelian, p.tgl_pembelian, p.keterangan, p.dp, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah,
        (pi.harga_beli * pi.jumlah) As total_harga
        FROM pembelian As p, pembelian_item As pi
        LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
        WHERE p.no_pembelian = pi.no_pembelian
        $filterPeriode
        ORDER BY no_pembelian ASC ";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $halaman; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;   
    
    # Rekap data
    $totalbeli = $totalbeli + $myData['harga_beli'];  // Menghitung total modal beli
    $totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual

    $sisa = $myData['total_harga'] - $myData['dp'];
    $totalDp = $totalDp + $myData['dp'];
    $totalSisa = $totalSisa + $sisa;
    $totalHarga += $myData['total_harga'];
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($myData['total_harga']); ?></td>

    <td align="right"><?php echo format_angka($myData['dp']); ?></td>
    <td align="right"><?php echo format_angka($sisa); ?></td>
  </tr>
  <?php } ?>
  <tr class="info info-active">
    <td colspan="5" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalbeli); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalHarga); ?></strong></td>

    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalDp); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalSisa); ?></strong></td>
  </tr>

</table>