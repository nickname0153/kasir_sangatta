<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_rekap_periode'] == "Yes") {

# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( p.tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( p.tgl_pembelian BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/rekap_pembelian_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Pembelian Barang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Pembelian">Laporan Data Pembelian</a></li>
                    <li class="active-page">Laporan Data Pembelian Barang Per Periode</li>
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
                <span class="h-icon"><i class="fa fa-calendar"></i></span>
                <h4>Periode Tanggal</h4>
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
                <h4><strong>Hasil Rekap Pembelian Barang per Periode </strong>, dari <b><?php echo $tglAwal; ?></b> s/d <b><?php echo $tglAkhir; ?></b></h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="30" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="80" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="474" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="60" align="center" bgcolor="#CCCCCC"><b>Jumlah</b></td>
    <td width="130" align="right" bgcolor="#CCCCCC"><b> Total Belanja (Rp) </b></td>
  </tr>
  <?php
  // variabel
  $jumlahBeli = 0;
  $jumlahBelanja = 0;
  
  // Menampilkan daftar Baran yang dibeli pada Bulan terpilih
  $mySql = "SELECT barang.kd_barang, barang.nm_barang 
        FROM pembelian As p, pembelian_item As pi
        LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
        WHERE p.no_pembelian = pi.no_pembelian 
        GROUP BY barang.kd_barang
        $filterPeriode ORDER BY barang.kd_barang ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $nomor = 0; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_barang'];
    
    // Menghitung / rekap total belanja per Kode barang
    $my2Sql = "SELECT SUM(jumlah) As total_barang, SUM(harga_beli * jumlah) As total_belanja 
          FROM pembelian_item WHERE kd_barang ='$Kode'"; 
    $my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
    $my2Data= mysql_fetch_array($my2Qry);

    $jumlahBeli = $jumlahBeli + $my2Data['total_barang'];
    $jumlahBelanja = $jumlahBelanja + $my2Data['total_belanja'];
    
    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
  ?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="3" align="right"><strong>GRAND TOTAL :</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahBeli); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($jumlahBelanja); ?></strong></td>
  </tr>
</table>
<br>
<a href="cetak/rekap_pembelian_periode.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/rekap_pembelian_periode_excel.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>">Export ke Excel</a>

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
