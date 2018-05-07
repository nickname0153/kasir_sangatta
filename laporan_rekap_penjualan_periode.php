<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_rekap_periode'] == "Yes") {

# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$awal	 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : "01-".date('m-Y');
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : $awal;

$akhir 		= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : date('d-m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : $akhir;

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	$filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($awal)."' AND '".InggrisTgl($akhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/rekap_penjualan_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Rekap Penjualan Barang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Rekap Penjualan Barang Per Periode</li>
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
  <div class="col-lg-1"><strong>Periode </strong></div>
      <div class="col-md-4"> 
        <div class="input-daterange input-group">
            <input type="text" class="form-control" value="<?php echo $tglAwal; ?>" name="cmbTglAwal"/>
                  <span class="input-group-addon">s/d</span>
                  <input type="text" name="cmbTglAkhir" class="form-control" value="<?php echo $tglAkhir; ?>"  />
        </div>
      </div>
        <input name="btnTampil" class="btn btn-success" type="submit" value=" Tampilkan " />        
    <input name="btnCetak" type="submit" class="btn btn-primary" value=" Cetak " />
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
                <h4><strong>Hasil Rekap Penjualan Barang per Periode </strong>, dari <b><?php echo $tglAwal; ?></b> s/d <b><?php echo $tglAkhir; ?></b></h4>
                <ul class="widget-action-bar pull-right">

                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class=
  "success">
    <td width="23" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="52"  bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="424" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="200" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></td>
    <td width="120" align="right" bgcolor="#CCCCCC"><b> Total Harga(Rp) </b></td>
  </tr>
  <?php
  // variabel
  $jumlahJual = 0;
  $jumlahBelanja = 0;
  
  // Menampilkan daftar Barang yang dibeli pada Bulan terpilih
  $mySql = "SELECT barang.kd_barang, barang.nm_barang, merek.nm_merek 
        FROM penjualan As p 
        LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
        LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
        LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
        $filterSQL
        GROUP BY barang.kd_barang
         ORDER BY barang.kd_barang ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $nomor = 0; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_barang'];

    // Menghitung / rekap total belanja per Kode barang
    $my2Sql = "SELECT SUM(jumlah) As total_barang, 
            harga_jual * SUM(jumlah) - (harga_jual * diskon/100 * SUM(jumlah)) As total_belanja  
          FROM penjualan_item WHERE kd_barang ='$Kode'"; 
    $my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
    $my2Data= mysql_fetch_array($my2Qry);

    $jumlahJual = $jumlahJual + $my2Data['total_barang'];
    $jumlahBelanja = $jumlahBelanja + $my2Data['total_belanja'];
    
    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
  ?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="4" align="right"><strong>GRAND TOTAL :</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahJual); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahBelanja); ?></strong></td>
  </tr>
</table>
<br>
<a href="cetak/rekap_penjualan_periode.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/rekap_penjualan_periode_excel.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>">Export ke Excel</a>

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
