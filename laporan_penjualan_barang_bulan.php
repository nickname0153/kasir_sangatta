<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_bulan'] == "Yes") {

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	$filterBulan = "AND LEFT(p.tgl_penjualan,4)='$dataTahun' AND MID(p.tgl_penjualan,6,2)='$dataBulan'";
}
else {
	$filterBulan = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penjualan_barang_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan As p, penjualan_item As pi WHERE p.no_penjualan = pi.no_penjualan 
			$filterBulan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Penjualan Barang Per Bulan</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Data Penjualan Barang Per Bulan</li>
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
                <h4>Filter Penjualan</h4>
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
      <div class="col-lg-2"><strong>Bulan Penjualan </strong></div>
      	<div class="col-md-2">
	  <select name="cmbBulan" class="form-control">
      <?php
		// Membuat daftar Nama Bulan
		$listBulan = array("01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
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
        </select></div><div class="col-md-2">
          <select name="cmbTahun" class="form-control">
            <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_penjualan,4)) As tahun FROM penjualan";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		$thnTerkecil = $thnRow['tahun'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnTerkecil; $thn <= date('Y'); $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select></div>
        <input name="btnTampil" class="btn btn-success" type="submit" value=" Tampilkan " />
	  <input name="btnCetak" type="submit"  value=" Cetak " class="btn btn-primary" />
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
                   <table class="table table-striped table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="22" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl.Nota</strong></td>
    <td width="61" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="51" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="295" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td colspan="6" align="center" bgcolor="#999999"><strong>HASIL PENJUALAN</strong></td>
  </tr>
  <tr class="warning">
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Modal (Rp)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Jual (Rp) </strong></td>
    <td width="56" align="right" bgcolor="#CCCCCC"><strong>Disc(%)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Diskon(Rp) </strong></td>
    <td width="35" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
    <td width="85" align="right" bgcolor="#CCCCCC"><strong>Untung (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$subTotalLaba 	= 0;
	$totalModal		= 0;
	$totalOmset		= 0;
  	$totalPendapatan = 0; 
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.harga_jual, pi.jumlah, pi.diskon
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_penjualan = pi.no_penjualan
				$filterBulan
				GROUP BY p.no_penjualan
				ORDER BY no_penjualan ASC LIMIT $hal, $row";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $hal; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		# Hitung
		$hargaDiskon	= $myData['harga_jual'] - ( $myData['harga_jual'] * $myData['diskon']/100);
		$nilaiLaba		= $hargaDiskon - $myData['harga_beli'];
		$subTotalLaba	= $nilaiLaba * $myData['jumlah'];
		
		# Rekap data
		$totalModal		= $totalModal + ( $myData['harga_beli'] * $myData['jumlah']);  // Menghitung total modal beli
		$totalOmset		= $totalOmset + ( $hargaDiskon * $myData['jumlah']);
		$totalBarang	= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
		$totalPendapatan= $totalPendapatan + $subTotalLaba;  // Menghitung total keuntungan bersih
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?></td>
    <td align="right"><?php echo format_angka($hargaDiskon); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalLaba); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="8" align="right"><strong>TOTAL OMZET PENJUALAN (Rp.) : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalOmset); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalPendapatan); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jml; ?></td>
    <td colspan="8" align="right"><strong>Halaman ke :</strong>
        <?php
	for ($h = 1; $h <= $max; $h++) {
		$list[$h] = $row * $h - $row;
		echo " <a href='?open=Laporan-Penjualan-Barang-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/penjualan_barang_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_barang_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
