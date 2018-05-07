<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_bulan'] == "Yes") {

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
		$filterSQL = "WHERE LEFT(tgl_returbeli,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE MID(tgl_returbeli,6,2)='$dataBulan' AND LEFT(tgl_returbeli,4)='$dataTahun'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/returbeli_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 50;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM returbeli $filterSQL";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Retur Pembelian per Bulan / Tahun</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Retur">Laporan Data Retur</a></li>
                    <li class="active-page">Laporan Data Retur Pembelian per Bulan / Tahun</li>
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
    <td width="26" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="73" bgcolor="#CCCCCC"><strong>Tgl. Retur </strong></td>
    <td width="85" bgcolor="#CCCCCC"><strong>No. Retur </strong></td>
    <td width="250" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="241" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="52" align="right" bgcolor="#CCCCCC"><strong>Jumlah </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
	# Perintah untuk menampilkan retur dengan Filter Periode
	$mySql = "SELECT returbeli.*, supplier.nm_supplier FROM returbeli 
			LEFT JOIN supplier ON returbeli.kd_supplier = supplier.kd_supplier
			$filterSQL ORDER BY no_returbeli DESC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $hal;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode retur/ Nomor transaksi
		$noNota = $myData['no_returbeli'];
		
		# Menghitung Total Belanja
		$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returbeli_item WHERE no_returbeli='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_returbeli']); ?></td>
    <td><?php echo $myData['no_returbeli']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td width="37" align="center"><a href="cetak/returbeli_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jml; ?></strong></td>
    <td colspan="4" align="right"><strong>Halaman ke :
      <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?page=Laporan-Returbeli-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
<br>
<a href="cetak/returbeli_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/returbeli_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
