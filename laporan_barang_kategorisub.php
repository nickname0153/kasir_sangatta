<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_kategorisub'] == "Yes") {

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membaca data dari filter Kategori Sub
$kodeKatSub			= isset($_GET['kodeKatSub']) ? $_GET['kodeKatSub'] : "Semua";
$dataKategoriSub 	= isset($_POST['cmbKategoriSub']) ? $_POST['cmbKategoriSub'] : $kodeKatSub;

// Membuat Sub SQL dengan Filter
if(trim($dataKategoriSub)=="Semua") {
	$filterSQL = "WHERE jenis.kd_kategorisub != '$dataKategoriSub'";
}
else {
	$filterSQL = "WHERE jenis.kd_kategorisub = '$dataKategoriSub'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/barang_kategorisub.php?kodeKategoriSub=$dataKategoriSub', width=330)";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("Error paging:".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<h2> LAPORAN DATA BARANG PER SUB KATEGORI</h2>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="985" class="table table-responsive table-striped" border="0"  class="table-list">
    <tr class="danger">
      <td colspan="3" bgcolor="#CCCCCC"><strong>FILTER DATA </strong></td>
    </tr>
    <tr>
      <td width="109"><strong> Kategori &amp; Sub </strong></td>
      <td width="5"><strong>:</strong></td>
      <td width="372">
        <div class="col-md-4">
	  <select name="cmbKategori" class="form-control" onchange="javascript:submitform();" >
        <option value="Semua">....</option>
        <?php
	  $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_kategori'] == $dataKategori) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
	  }
	  ?>
      </select>
    </div>
	  
    <div class="col-md-4">
      <select class="form-control" name="cmbKategoriSub">
        <option value="Kosong">....</option>
        <?php
			  $bacaSql = "SELECT * FROM kategori_sub WHERE kd_kategori='$dataKategori' ORDER BY kd_kategorisub";
			  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
			  while ($bacaData = mysql_fetch_array($bacaQry)) {
				if ($bacaData['kd_kategorisub'] == $dataKategoriSub) {
					$cek = " selected";
				} else { $cek=""; }
				echo "<option value='$bacaData[kd_kategorisub]' $cek> $bacaData[nm_kategorisub]</option>";
			  }
			  ?>
      </select></div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div class="col-md-4">
        <input name="btnTampilkan" class="btn btn-success" type="submit" value=" Tampilkan  "/>
        <input name="btnCetak" class="btn btn-primary" type="submit" value=" Cetak " /></div></td>
    </tr>
  </table>
</form>

<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="23" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="45" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong> Barcode </strong></td>
    <td width="385" bgcolor="#CCCCCC"><strong>Nama Barang</strong></td>
    <td width="115" bgcolor="#CCCCCC"><strong>Jenis</strong></td>
    <td width="46" bgcolor="#CCCCCC"><strong>Satuan</strong></td>
    <td width="31" align="right" bgcolor="#CCCCCC"><strong>Stok</strong></td>
    <td width="100" align="right" bgcolor="#CCCCCC"><strong>Hrg Jual (Rp) </strong></td>
    <td width="39" align="right" bgcolor="#CCCCCC"><strong>Disc</strong></td>
  </tr>
  <?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT barang.*, jenis.nm_jenis FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
				LEFT JOIN kategori_sub ON jenis.kd_kategorisub = kategori_sub.kd_kategorisub 
				$filterSQL 
				ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td> <?php echo $nomor; ?> </td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td> <?php echo $myData['barcode']; ?> </td>
    <td> <?php echo $myData['nm_barang']; ?> </td>
    <td> <?php echo $myData['nm_jenis']; ?> </td>
    <td> <?php echo $myData['satuan_jual']; ?> </td>
    <td align="right"> <?php echo $myData['stok']; ?> </td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?> %</td>
  </tr>
  <?php } ?>
  <tr class="selKecil">
    <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td colspan="5" align="right">
	<strong>Halaman ke :</strong>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Laporan-Barang-Kategorisub&hal=$list[$h]&kodeKat=$dataKategori&kodeKatSub=$dataKategoriSub'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<a href="cetak/barang_kategorisub.php?kodeKategoriSub=<?php echo $dataKategoriSub; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
