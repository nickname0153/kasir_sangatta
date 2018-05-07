<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_barcode'] == "Yes") {

$merekSQL	= "";
$kategoriSQL= "";
$cariSQL 	= "";

// Membaca data dari filter Kategori
$kodeMerek		= isset($_GET['kodeMerek']) ? $_GET['kodeMerek'] : "Semua";
$dataMerek		= isset($_POST['cmbMerek']) ? $_POST['cmbMerek'] : $kodeMerek;

// Membaca data dari filter Kategori
$kodeKat		= isset($_GET['kodeKat']) ? $_GET['kodeKat'] : "Semua";
$dataKategori 	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membaca data dari filter Kategori Sub
$kodeKatSub			= isset($_GET['kodeKatSub']) ? $_GET['kodeKatSub'] : "Semua";
$dataKategoriSub 	= isset($_POST['cmbKategoriSub']) ? $_POST['cmbKategoriSub'] : $kodeKatSub;

$kataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';
$dataKataKunci	= isset($_POST['txtKataKunci']) ? $_POST['txtKataKunci'] : '';

# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnTampil'])) {
	# PILIH MEREK
	if(trim($dataMerek)=="Semua") {
		$merekSQL = "";
	}
	else {
		$merekSQL = "AND barang.kd_merek='$dataMerek'";
	}
	
	# PILIH KATEGORI
	if(trim($dataKategoriSub)=="Semua") {
		$kategoriSQL = "";
	}
	else {
		$kategoriSQL = "AND jenis.kd_kategorisub = '$dataKategoriSub'";
	}

}
else {
	//Query #1 (all)
	$merekSQL	= "";
	$kategoriSQL= "";
}


# PENCARIAN DATA BERDASARKAN FILTER DATA (Kode Type Kamar)
if(isset($_POST['btnCari'])) {
	$Kode			= trim($dataKataKunci);
	$cariSQL		= " AND ( barang.nm_barang LIKE '%$dataKataKunci%' OR barang.kd_barang='$Kode' OR barang.barcode ='$Kode' )";
	
	// Pencarian Multi String (beberapa kata)
	$keyWord 		= explode(" ", $txtKataKunci);
	if(count($keyWord) > 1) {
		foreach($keyWord as $kata) {
			$cariSQL	.= " OR barang.nm_barang LIKE '%$kata%'";
		} 
	}
}
else {
	//Query #1 (all)
	$cariSQL 	= "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM barang  LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
			WHERE barang.kd_barang !='' $merekSQL $kategoriSQL $cariSQL"; 

$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
<table width="100%" border="0" cellpadding="2" cellspacing="1" class="table table-striped table-responsive">
<tr class="warning">
  <th colspan="3"><b>FILTER DATA  </b></th>
</tr>
<tr>
  <td><strong>Nama Merek </strong></td>
  <td><b>:</b></td>
  <td><div class="col-md-4">
  	<select class="form-control" name="cmbMerek">
    <option value="Semua">....</option>
    <?php
	  $bacaSql = "SELECT * FROM merek ORDER BY kd_merek";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
	  	if ($bacaData['kd_merek']== $dataMerek) {
			$cek = " selected";
		} else { $cek=""; }
	  	echo "<option value='$bacaData[kd_merek]' $cek> $bacaData[nm_merek]</option>";
	  }
	  ?>
  </select></div></td>
</tr>
<tr >
  <td width="186"><b>Nama Kategori </b></td>
  <td width="5"><b>:</b></td>
  <td width="1007"><div class="col-md-4">
  	<select class="form-control" name="cmbKategori" onchange="javascript:submitform();" >
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
  </select></div>
<div class="col-md-4">
<select name="cmbKategoriSub" class="form-control">
  <option value="Semua">....</option>
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
</select>
</div></td>
</tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  <td><div class="col-md-4">
  	<input name="btnTampil" class="btn btn-warning" type="submit" value=" Tampilkan " /></div></td>
</tr>
<tr class="success">
  <th colspan="3"><strong>PENCARIAN DATA </strong></th>
  </tr>
<tr>
  <td><strong>Nama Barang </strong></td>
  <td><strong>:</strong></td>
  <td>
  	<div class="col-md-4">
  	<input name="txtKataKunci" type="text" class="form-control" value="<?php echo $dataKataKunci; ?>" size="45" maxlength="100" />
     <br>
      <input name="btnCari" type="submit" class="btn btn-success" value=" Cari Barang " /></div></td>
</tr>
</table>
</form>

<form action="cetak_barcode_print.php" method="post" name="form2" target="_blank">
<table class="table table-striped table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="4" align="right"><input name="btnCetak" type="submit" class="btn btn-primary" id="btnCetak" value=" Cetak Barcode " /></td>
    </tr>
  <tr class="info">
    <th width="23">No</th>
    <th width="50">Kode</th>
    <th width="439">Nama Barang </th>
    <th width="132">Merek</th>
    <th width="28" align="center">Cek</th>
    <th width="41" align="center">Stok</th>
    <th width="100" align="right">Hrg Jual  (Rp) </th>
    <td width="46" align="center" bgcolor="#CCCCCC">BCode</td>
  </tr>
  <?php
	# MENJALANKAN QUERY , 
	$mySql = "SELECT barang.*, jenis.nm_jenis, merek.nm_merek FROM barang
				 LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis
				 LEFT JOIN merek ON barang.kd_merek=merek.kd_merek 
				WHERE barang.kd_barang !=''  $merekSQL $kategoriSQL $cariSQL
				ORDER BY barang.kd_barang ASC LIMIT  $halaman, $baris";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['kd_barang'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="center"><input name="cbKode[]" type="checkbox" id="cbKode" value="<?php echo $Kode; ?>" /></td>
    <td align="center">
      <select name="cmbQty[<?php echo $Kode; ?>]">
	  <?php
	  // Menampilkan jumlah stok pada ComboBox Pilihan
	  for($qty=1; $qty <= $myData['stok']; $qty++) {
	  	echo "<option value='$qty' $cek>$qty</option>";
	  }
	  ?>
      </select>      </td>
    <td align="right"><b><?php echo format_angka($myData['harga_jual']); ?></b></td>
    <td align="center"><a href="barcode128_print.php?Kode=<?php echo $Kode; ?>" target="_blank"><img src="images/btn_barcode.png" width="22"  border="0" /></a></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="4" bgcolor="#CCCCCC"><b>Jumlah Data :</b> <?php echo $jmlData; ?> </td>
    <td colspan="4" align="right" bgcolor="#CCCCCC"><b>Halaman ke :</b>
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Cetak-Barcode&hal=$list[$h]&kodeMerek=$dataMerek&kodeKat=$dataKategori&kodeKatSub=$dataKategoriSub'>$h</a> ";
	}
	?>    </td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
    <td colspan="4" align="right"><input name="btnCetak" class="btn btn-info" type="submit" value=" Cetak Barcode " /></td>
  </tr>
</table>
<p><strong>* Note:</strong> Centang dulu pada <strong>Cek</strong>, baru pilih jumlah <strong>Stok</strong> (jumlah barcode yang dibuat) </p>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
