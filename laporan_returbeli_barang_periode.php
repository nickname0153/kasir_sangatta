<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_returbeli_barang_periode'] == "Yes") {

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
	$filterSQL = "AND ( r.tgl_returbeli BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterSQL = "AND ( r.tgl_returbeli BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/returbeli_barang_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM returbeli As r, returbeli_item As ri
			WHERE r.no_returbeli = ri.no_returbeli 
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
                  <h2 class="breadcrumb-titles">Laporan Data Retur Barang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Retur">Laporan Data Retur</a></li>
                    <li class="active-page">Laporan Data Retur Barang Per Periode</li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>

<h2>LAPORAN RETUR BARANG PER PERIODE</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="985" border="0"  class="table table-responsive table-striped">
    <tr class="danger">
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="116"><strong>Periode Tanggal </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="415"><div class="col-md-4">
        <input name="txtTglAwal" type="text" class="form-control" id="txtTglAwal" value="<?php echo $tglAwal; ?>" size="18" /></div>
        <div class="col-md-1">
        &nbsp;&nbsp;s/d</div><div class="col-md-4">
        <input name="txtTglAkhir" type="text" class="form-control" id="txtTglAkhir" value="<?php echo $tglAkhir; ?>" size="18" /></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div class="col-md-8">
        <input name="btnTampil" type="submit" value=" Tampilkan " class="btn btn-success" />
          <input name="btnCetak" type="submit" id="btnCetak" value=" Cetak " class="btn btn-primary" /></div></td>
    </tr>
  </table>
</form>

<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="24" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" bgcolor="#CCCCCC"><strong>Tg. Nota </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>No. Retur </strong></td>
    <td width="49" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="340" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Jenis</strong></td>
    <td width="130" bgcolor="#CCCCCC"><strong>Merek</strong></td>
    <td width="56" align="right" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
  </tr>
  <?php
  	// deklarasi variabel
	$totalBarang	= 0;
	
	# Perintah untuk menampilkan data Rawat dengan filter Periode
	$mySql = "SELECT r.no_returbeli, r.tgl_returbeli, ri.kd_barang, ri.jumlah, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
				FROM returbeli As r, returbeli_item As ri
				LEFT JOIN barang ON ri.kd_barang = barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returbeli = ri.no_returbeli
				$filterSQL
				ORDER BY no_returbeli, kd_barang ASC LIMIT $halaman, $baris";
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
    <td><?php echo IndonesiaTgl2($myData['tgl_returbeli']); ?></td>
    <td><?php echo $myData['no_returbeli']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="7" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="5" align="right"><strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Returbeli-Barang-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/returbeli_barang_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/returbeli_barang_periode_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>">Export ke Excel</a>
 <?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
