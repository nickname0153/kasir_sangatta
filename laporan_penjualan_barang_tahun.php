<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_tahun'] == "Yes") {

// Membaca tahun
$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun) {
	$filterTahun = "AND LEFT(p.tgl_penjualan,4)='$dataTahun'";
}
else {
	$filterTahun = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/penjualan_barang_tahun.php?tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan As p, penjualan_item As pi WHERE p.no_penjualan = pi.no_penjualan 
			$filterTahun
			GROUP BY p.no_penjualan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<h2>LAPORAN HASIL PENJUALAN BARANG PER TAHUN </h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="500" border="0"  class="table-list">
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER PENJUALAN </strong></td>
    </tr>
    <tr>
      <td width="119"><strong>Tahun Penjualan </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="362">
	  <select name="cmbTahun">
      <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
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
        </select>
	  <input name="btnTampil" type="submit" value=" Tampilkan " />
      <input name="btnCetak" type="submit"  value=" Cetak " /></td>
    </tr>
  </table>
</form>

<table class="table-list" width="1006" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="22" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl.Nota</strong></td>
    <td width="62" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota  </strong></td>
    <td width="50" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="295" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang  </strong></td>
    <td colspan="6" align="center" bgcolor="#999999"><strong>HASIL PENJUALAN</strong></td>
  </tr>
  <tr>
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
				$filterTahun
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
  <tr>
    <td colspan="8" align="right"><strong>TOTAL OMSET PENJUALAN (Rp.) : </strong></td>
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
		echo " <a href='?open=Laporan-Penjualan-Barang-Tahun&hal=$list[$h]&tahun=$dataTahun'>$h</a> ";
	}
	?></td>
  </tr>
</table>

<a href="cetak/penjualan_barang_tahun.php?tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_barang_tahun_excel.php?tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
