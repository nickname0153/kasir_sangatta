<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_rekap_periode'] == "Yes") {

# Deklarasi variabel
$filterSQL = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "AND ( r.tgl_returjual BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "AND ( r.tgl_returjual BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/rekap_returjual_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Retur Barang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Retur">Laporan Data Retur</a></li>
                    <li class="active-page">Laporan Retur Barang Per Periode</li>
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
                <h4><strong>Hasil Rekap Retur Barang per Periode </strong>, dari <b><?php echo $tglAwal; ?></b> s/d <b><?php echo $tglAkhir; ?></b></h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-striped table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="26" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="50" bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="465" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Jenis</strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="68" align="right" bgcolor="#CCCCCC"><b>Jumlah</b></td>
  </tr>
  <?php
  // variabel
  $jumlahRetur = 0;
  
  // Menampilkan daftar Barang yang diretur pada Bulan terpilih
  $mySql = "SELECT barang.kd_barang, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
        FROM returjual As r, returjual_item As ri
        LEFT JOIN barang ON ri.kd_barang= barang.kd_barang
        LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
        LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
        WHERE r.no_returjual = ri.no_returjual 
        $filterSQL ORDER BY barang.kd_barang ASC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $nomor = 0; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_barang'];
    
    // Menghitung / rekap total belanja per Kode barang
    $my2Sql = "SELECT SUM(jumlah) As total_barang FROM returjual_item WHERE kd_barang ='$Kode'"; 
    $my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
    $my2Data= mysql_fetch_array($my2Qry);

    $jumlahRetur = $jumlahRetur + $my2Data['total_barang'];
    
    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
  ?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['nm_jenis']; ?></td>
    <td bgcolor="<?php echo $warna; ?>"><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="5" align="right"><strong> TOTAL :</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahRetur); ?></strong></td>
  </tr>
</table>
<br>
<a href="cetak/rekap_returjual_periode.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/rekap_returjual_periode_excel.php?<?php echo "tglAwal=$tglAwal&tglAkhir=$tglAkhir"; ?>" >Export ke Excel</a>

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
