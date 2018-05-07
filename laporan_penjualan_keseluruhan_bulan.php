<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_rekap_bulan'] == "Yes") {
# Deklarasi variabel
$filterSQL = ""; 
$tglAwal  = ""; 
$tglAkhir = "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal  = isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir   = isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');


// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  // Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
  // Membaca data tanggal dari URL, saat menu Pages diklik
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
  
  // Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penjualan_keseluruhan_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
		echo "</script>";
}
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Rekap Penjualan Keseluruhan Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Rekap Penjualan Keseluruhan Per Periode</li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>


<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-filter"></i></span>
                <h4>Filter Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li>
                  <div class="widget-switch">
                    <input type="checkbox" class="w-on-off" checked/>
                  </div>
                 </li>
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <div class="col-lg-1"><strong>Periode :</strong></div>
		<div class="col-md-4"> 
        <div class="input-daterange input-group">
            <input type="text" class="form-control" value="<?php echo $tglAwal; ?>" name="cmbTglAwal"/>
                  <span class="input-group-addon">s/d</span>
                  <input type="text" name="cmbTglAkhir" class="form-control" value="<?php echo $tglAkhir; ?>"  />
        </div>
      </div>
      	<input name="btnTampil" type="submit" class="btn btn-success" value=" Tampilkan " />
</form>
                </div>
              </div>
            </div>
          </div>
</div>


<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-list"></i></span>
                <h4><strong>Hasil Rekap Penjualan</strong></h4>
                <ul class="widget-action-bar pull-right">
                  
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
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
    <td class="danger" ><b><?php echo "Rp. ".number_format($totalJml1); ?></b></td>
    <td class="danger"><b><?php echo "Rp. ".number_format($totalmodal1); ?></b></td>
    <td class="danger"><b><?php echo "Rp. ".number_format($totallaba1); ?></b></td>
    <td class="warning"><b><?php echo "Rp. ".number_format($totalJml2); ?></b></td>
    <td class="warning"><b><?php echo "Rp. ".number_format($totalmodal2); ?></b></td>
    <td class="warning"><b><?php echo "Rp. ".number_format($totallaba2); ?></b></td>
    <td class="success"><b><?php echo "Rp. ".number_format($totalJml3); ?></b></td>
    <td class="success"><b><?php echo "Rp. ".number_format($totalmodal3); ?></b></td>
    <td class="success"><b><?php echo "Rp. ".number_format($totallaba3); ?></b></td>
    <td><b><?php echo "Rp. ".number_format($megaTotal); ?></b></td>
  </tr>
</table>
<br>
<a href="cetak/penjualan_keseluruhan_bulan.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_keseluruhan_bulan_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" >Export ke Excel</a>

                </div>
              </div>
            </div>
          </div>
</div>

<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
