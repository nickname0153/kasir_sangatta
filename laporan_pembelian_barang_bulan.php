<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") {

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "AND LEFT(p.tgl_pembelian,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "AND LEFT(p.tgl_pembelian,4)='$dataTahun' AND MID(p.tgl_pembelian,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pembelian_barang_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembelian As p, pembelian_item As pi
			WHERE p.no_pembelian = pi.no_pembelian 
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
                  <h2 class="breadcrumb-titles">Laporan Data Pembelian Barang Per Bulan / Tahun</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Pembelian">Laporan Data Pembelian</a></li>
                    <li class="active-page">Laporan Data Pembelian Barang Per Bulan / Tahun</li>
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
      <div class="col-lg-2"><strong>Periode Bulan :</strong></div>
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
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pembelian,4)) As tahun_kecil, MAX(LEFT(tgl_pembelian,4)) As tahun_besar FROM pembelian";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
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
      	<input class="btn btn-success" name="btnTampil" type="submit" value=" Tampilkan " />
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
                <span class="h-icon"><i class="fa fa-calendar"></i></span>
                <h4>Laporan Pembelian Barang per Bulan / Tahun</h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="24" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="64" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></td>
    <td width="64" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota  </strong></td>
    <td width="50" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="365" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td colspan="3" align="center" bgcolor="#999999"><strong>DETIL PEMBELIAN </strong></td>
  </tr>
  <tr class="success success-active">
    <td width="112" align="right" bgcolor="#CCCCCC"><strong>Harga (Rp) </strong></td>
    <td width="50" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="80" align="right" bgcolor="#CCCCCC"><strong>Total (Rp) </strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalHarga	= 0;
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT p.no_pembelian, p.tgl_pembelian, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.jumlah,
				(pi.harga_beli * pi.jumlah) As total_harga
				FROM pembelian As p, pembelian_item As pi
				LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
				WHERE p.no_pembelian = pi.no_pembelian
				$filterSQL
				ORDER BY no_pembelian, kd_barang ASC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;		
		
		# Rekap data
		$totalHarga	= $totalHarga + $myData['total_harga'];  // Menghitung total modal beli
		$totalBarang= $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
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
  </tr>
  <?php } ?>
  <tr class="info info-active">
    <td colspan="6" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalHarga); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="5" align="right"><strong>Halaman ke :</strong>
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Pembelian-Barang-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>

<a href="cetak/pembelian_barang_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/pembelian_barang_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
