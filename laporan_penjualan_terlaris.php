<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_terlaris'] == "Yes") {

# Jumlah terpilih
$dataJumlah 	= isset($_POST['cmbJumlah']) ? $_POST['cmbJumlah'] : 10;  

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "AND LEFT(p.tgl_penjualan,4)='$dataTahun' AND MID(p.tgl_penjualan,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penjualan_terlaris.php?bulan=$dataBulan&tahun=$dataTahun&jumlah=$dataJumlah')";
		echo "</script>";
}

?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Penjualan Barang Terlaris</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Data Penjualan Barang Terlaris</li>
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
      <div class="col-lg-2"><strong>Periode Bulan/Tahun :</strong></div>
      	<div class="col-md-6">
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
        </select></div><div class="col-md-4">
          <select name="cmbTahun" class="form-control">
            <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_penjualan,4)) As tahun_kecil, MAX(LEFT(tgl_penjualan,4)) As tahun_besar FROM penjualan";
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
        <div class="col-lg-12">&nbsp;</div>
      <div class="col-lg-2"><strong>Jumlah Barang :</strong></div>
      <div class="col-md-4">
      	<select name="cmbJumlah" class="form-control">
        <?php
		// Angka kecil
		$angka 	= 5;
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		while($angka <= 100) {
			if ($angka == $dataJumlah) {
				$cek = " selected";
			} else { $cek=""; }
			
			echo "<option value='$angka' $cek>$angka</option>";
			$angka 	= $angka + 5;
		}
	  ?>
      </select></div>
        <input name="btnTampil" class="btn btn-success" type="submit" value=" Tampilkan " />
        <input name="btnCetak" type="submit" class="btn btn-primary"  value=" Cetak " />
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
                <span class="h-icon"><i class="fa fa-line-chart"></i></span>
                <h4>Laporan Penjualan Barang Terlaris</h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="25" align="center" bgcolor="#CCCCCC"><b>No</b></td>
    <td width="55"  bgcolor="#CCCCCC"><b>Kode</b></td>
    <td width="429" bgcolor="#CCCCCC"><b>Nama Barang </b></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Kategori</strong></td>
    <td width="140" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="80" align="center" bgcolor="#CCCCCC"><b>Qty Terjual </b></td>
  </tr>
	<?php
	// variabel
	$jumlahJual = 0;
	
	// Menampilkan daftar Barang yang dibeli pada Bulan terpilih
	$mySql = "SELECT barang.kd_barang, barang.nm_barang, jenis.nm_jenis, merek.nm_merek, SUM(pi.jumlah) As total_terjual
				FROM penjualan As p, penjualan_item As pi
				LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE p.no_penjualan = pi.no_penjualan 
				$filterSQL
				GROUP BY barang.kd_barang ORDER BY total_terjual DESC
				LIMIT $dataJumlah";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		
		// Menghitung Total
		$jumlahJual = $jumlahJual + $myData['total_terjual'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="center"><?php echo format_angka($myData['total_terjual']); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="5" align="right"><strong> TOTAL :</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahJual); ?></strong></td>
  </tr>
</table>
<br>
<a href="cetak/penjualan_terlaris.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>&jumlah=<?php echo $dataJumlah; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_terlaris_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>&jumlah=<?php echo $dataJumlah; ?>" >Export ke Excel</a>

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
