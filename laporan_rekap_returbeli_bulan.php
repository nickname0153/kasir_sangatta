<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_rekap_bulan'] == "Yes") {

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
		$filterSQL = "AND LEFT(r.tgl_returbeli,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "AND LEFT(r.tgl_returbeli,4)='$dataTahun' AND MID(r.tgl_returbeli,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/rekap_returbeli_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Rekap Retur Barang Per Bulan / Tahun</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Retur">Laporan Data Retur</a></li>
                    <li class="active-page">Laporan Rekap Retur Barang Per Bulan / Tahun</li>
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
      <div class="col-md-2"><strong>Bulan/ Tahun  </strong></div>
      	<div class="col-md-2">
      	<select name="cmbBulan" class="form-control">
          <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("00" => "....", "01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
						 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
						 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
						 "11" => "11. November", "12" => "12. Desember");
						 
		// Menampilkan Nama Bulan ke ComboBox (List/Menu)
		foreach($listBulan as $bulanKe => $bulanNm) {
			if ($bulanKe == $dataBulan) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bulanKe' $cek>$bulanNm</option>";
		}
	  ?>
        </select></div>
        <div class="col-md-2">
          <select name="cmbTahun" class="form-control">
            <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_returbeli,4)) As tahun_kecil, MAX(LEFT(tgl_returbeli,4)) As tahun_besar FROM returbeli";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select></div>
      	<input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-success" />
      <input name="btnCetak" type="submit" value=" Cetak " class="btn btn-primary" />
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
                   <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
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
				FROM returbeli As r, returbeli_item As ri
				LEFT JOIN barang ON ri.kd_barang= barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returbeli = ri.no_returbeli 
				$filterSQL ORDER BY barang.kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_barang'];
		
		// Menghitung / rekap total belanja per Kode barang
		$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returbeli_item WHERE kd_barang ='$Kode'"; 
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
<a href="cetak/rekap_returbeli_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<a class="btn btn-default" href="cetak/excel/rekap_returbeli_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
