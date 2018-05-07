<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_kategorisub'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama	= $_POST['txtNama'];
	$cmbKategori	= $_POST['cmbKategori'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Sub Kategori</b> tidak boleh kosong !";		
	}
	if (trim($cmbKategori)=="Kosong") {
		$pesanError[] = "Data <b>Kategori</b> belum ada yang dipilih !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("kategori_sub", "KS");
		$mySql	= "INSERT INTO kategori_sub (kd_kategorisub, nm_kategorisub, kd_kategori) VALUES('$kodeBaru', '$txtNama', '$cmbKategori')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Kategori-Sub-Data'>";
		}
		exit;
	}	
}

# VARIABEL DATA UNTUK DIBACA FORM
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode	= buatKode("kategori_sub", "KS");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="100%" class="table table-striped table-responsive" border="0" cellpadding="4" cellspacing="1">
    <tr class='danger'>
      <th colspan="3" scope="col">TAMBAH SUB KATEGORI </th>
    </tr>
    <tr>
      <td width="181"><strong>Kode</strong></td>
      <td width="3">:</td>
      <td width="1019"><div class='col-md-2'><input name="textfield" value="<?php echo $dataKode; ?>" size="10" class='form-control' maxlength="10" readonly="readonly"/></div></td>
    </tr>
    <tr>
      <td><strong>Nama Sub Kategori </strong></td>
      <td>:</td>
      <td><div class='col-md-6'><input name="txtNama" value="<?php echo $dataNama; ?>" class='form-control' size="70" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><strong>:</strong></td>
      <td> <div class='col-md-4'>
      	<select name="cmbKategori" class='form-control'>
          <option value="Kosong">....</option>
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
      </select></div></td>
    </tr>
    <tr class='success'>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td><div class='col-md-4'>
      	<input type="submit" name="btnSimpan" class='btn btn-primary' value=" SIMPAN "></div></td>
    </tr>
  </table>
</form>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
