<?php
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Keseluruhan_per_periode.xls");

if($_GET) {
  
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');

  $filterSQL = " WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."') ";

}
else {
  $filterSQL = "";
}
?>
<html>
<head>
<title> :: Laporan Rekap Penjualan Keseluruhan Per Periode - TinyLite POS</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>Laporan Rekap Penjualan Keseluruhan Per Periode</h2>
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
                   
<table class="table table-bordered table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr >
    <td width="100" rowspan="2" align="center" class="info" ><b>Tanggal</b></td>
    <td class="danger" colspan="3" align="center" bgcolor="#CCCCCC"><b>Penjualan Cash Umum </b></td>
    <td class="warning" colspan="3" align="center" bgcolor="#CCCCCC"><strong>Penjualan Cash Anggota</strong></td>
    <td class="success" colspan="3" align="center" bgcolor="#CCCCCC"><b>Penjualan Kredit Anggota</b></td>
    <td width="150" rowspan="2" align="center"><b>Jumlah</b></td>
  </tr>
   <tr>
    <td class="danger" align="center">Jumlah (Rp)</td>
    <td class="danger" align="center">Modal (Rp)</td>
    <td class="danger" align="center">Laba (Rp)</td>
    <td class="warning" align="center">Jumlah (Rp)</td>
    <td class="warning" align="center">Modal (Rp)</td>
    <td class="warning" align="center">Laba (Rp)</td>
    <td class="success" align="center">Jumlah (Rp)</td>
    <td class="success" align="center">Modal (Rp)</td>
    <td class="success" align="center">Laba (Rp)</td>
  </tr>
  <?php
   // variabel
  $jumlahJual     = 0;
  $jumlahBelanja  = 0;
  $nomor          = 0;
  $megaTotal      = 0;
  $totalJml1      = 0;
  $totallaba1     = 0;
  $totalmodal1    = 0;
  $totalJml2      = 0;
  $totallaba2     = 0;
  $totalmodal2    = 0;
  $totalJml3      = 0;
  $totalmodal3    = 0;
  $totallaba3     = 0;
  // Menampilkan daftar Barang yang dibeli pada Bulan terpilih
  $mySql = "SELECT p.tgl_penjualan,
            SUM(pi.harga_beli * pi.jumlah) as Modal,
            SUM(pi.harga_jual * pi.jumlah) - SUM(pi.harga_beli * pi.jumlah) as Laba
            FROM penjualan as p 
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            $filterSQL
            GROUP BY p.tgl_penjualan";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
  $tgl_penjualan = $myData['tgl_penjualan'];
  
  ?>
  <tr>
    <td align="center"><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
       <?php 
        $qy1=mysql_query("SELECT COALESCE(SUM(pi.harga_beli * pi.jumlah),0) as Modal,
            COALESCE(SUM(pi.harga_jual * pi.jumlah) - SUM(pi.harga_beli * pi.jumlah),0) as Laba,
            SUM(pi.harga_jual * pi.diskon / 100) * pi.jumlah as discount
            FROM penjualan as p 
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            WHERE p.keterangan = 'Cash' AND p.kd_pelanggan = 'P001' AND tgl_penjualan = '$tgl_penjualan' "); 
        $myData1 = mysql_fetch_array($qy1);
        $jumlah1 = ($myData1['Laba'] + $myData1['Modal'] - $myData1['discount']);
    ?>
    <td><?php echo number_format($jumlah1); ?></td>
    <td><?php echo number_format($myData1['Modal']); ?></td>
    <td><?php echo number_format($myData1['Laba'] - $myData1['discount']); ?></td>
    <?php 
        $qy2=mysql_query("SELECT COALESCE(SUM(pi.harga_beli * pi.jumlah),0) as Modal,
            COALESCE(SUM(pi.harga_jual * pi.jumlah) - SUM(pi.harga_beli * pi.jumlah),0) as Laba,
            SUM(pi.harga_jual * pi.diskon / 100) * pi.jumlah as discount
            FROM penjualan as p 
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            WHERE p.keterangan = 'Cash' AND p.kd_pelanggan != 'P001' AND tgl_penjualan = '$tgl_penjualan' "); 
        $myData2 = mysql_fetch_array($qy2);
        $jumlah2 = ($myData2['Laba'] + $myData2['Modal'] - $myData2['discount']);
    ?>
    <td><?php echo number_format($jumlah2); ?></td>
    <td><?php echo number_format($myData2['Modal']); ?></td>
    <td><?php echo number_format($myData2['Laba'] - $myData2['discount']); ?></td>
    <?php 
        $qy3=mysql_query("SELECT COALESCE(SUM(pi.harga_beli * pi.jumlah),0) as Modal,
            COALESCE(SUM(pi.harga_jual * pi.jumlah) - SUM(pi.harga_beli * pi.jumlah),0) as Laba,
            SUM(pi.harga_jual * pi.diskon / 100) * pi.jumlah as discount
            FROM penjualan as p 
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            WHERE p.keterangan = 'Kredit' AND p.kd_pelanggan != 'P001' 
            AND tgl_penjualan = '$tgl_penjualan' "); 
        $myData3 = mysql_fetch_array($qy3);
        $jumlah3 = ($myData3['Laba'] + $myData3['Modal'] - $myData3['discount']);
    ?>
    <td><?php echo number_format($jumlah3); ?></td>
    <td><?php echo number_format($myData3['Modal']); ?></td>
    <td><?php echo number_format($myData3['Laba'] - $myData3['discount']); ?></td>
<?php  

  $totalJml1    += $jumlah1;
  $totallaba1   += $myData1['Laba'] - $myData1['discount'];
  $totalmodal1  += $myData1['Modal'];

  $totalJml2    += $jumlah2;
  $totallaba2   += $myData2['Laba'] - $myData2['discount'];
  $totalmodal2  += $myData2['Modal'];

  $totalJml3    += $jumlah3;
  $totallaba3   += $myData3['Laba'] - $myData3['discount'];
  $totalmodal3  += $myData3['Modal']; ?>
    <td><?php echo number_format($grandTotal = $jumlah1 + $jumlah2 + $jumlah3); ?></td>
    </tr>
  <?php 

  $megaTotal += $grandTotal; 
  } ?>
  <tr>
    <td class="info" align="left"><strong>TOTAL</strong></td>
    <td class="danger" ><b><?php echo $totalJml1; ?></b></td>
    <td class="danger"><b><?php echo $totalmodal1; ?></b></td>
    <td class="danger"><b><?php echo $totallaba1; ?></b></td>
    <td class="warning"><b><?php echo $totalJml2; ?></b></td>
    <td class="warning"><b><?php echo $totalmodal2; ?></b></td>
    <td class="warning"><b><?php echo $totallaba2; ?></b></td>
    <td class="success"><b><?php echo $totalJml3; ?></b></td>
    <td class="success"><b><?php echo $totalmodal3; ?></b></td>
    <td class="success"><b><?php echo $totallaba3; ?></b></td>
    <td><b><?php echo $megaTotal; ?></b></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>