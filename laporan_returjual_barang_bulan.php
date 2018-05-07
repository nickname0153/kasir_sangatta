<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_barang_bulan'] == "Yes") {

# FILTER PEMBELIAN PER BULAN/TAHUN
// Bulan Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

// Tahun Terpilih
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# MEMBUAT SQL FILTER BULAN DAN TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "AND LEFT(r.tgl_returjual,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "AND MID(r.tgl_returjual,6,2)='$dataBulan' AND LEFT(r.tgl_returjual,4)='$dataTahun'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/returjual_barang_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM returjual As r, returjual_item As ri
			WHERE r.no_returjual = ri.no_returjual 
			$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Retur Barang Per Bulan / Tahun</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Retur">Laporan Data Retur</a></li>
                    <li class="active-page">Laporan Retur Barang Per Bulan / Tahun</li>
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
                <h4>Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <table class="table table-responsive table-striped" width="909850" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Tg. Nota  </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>No. Retur  </strong></td>
    <td width="49" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="340" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Jenis</strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="56" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT r.no_returjual, r.tgl_returjual, ri.kd_barang, ri.jumlah, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
				FROM returjual As r, returjual_item As ri
				LEFT JOIN barang ON ri.kd_barang = barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returjual = ri.no_returjual
				$filterSQL
				ORDER BY no_returjual, kd_barang ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
		# Rekap data
		$totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_returjual']); ?></td>
    <td><?php echo $myData['no_returjual']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
  </tr>
  <?php } ?>
  <tr class=
  "info">
    <td colspan="7" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="5" align="right"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-returjual-Barang-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<br>
<a href="cetak/returjual_barang_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/returjual_barang_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
