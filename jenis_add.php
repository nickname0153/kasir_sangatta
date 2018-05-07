<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_jenis'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama		= $_POST['txtNama'];
	$cmbKategori	= $_POST['cmbKategori'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Jenis</b> tidak boleh kosong, silahkan dilengkapi !";		
	}
	
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo '<div class="alert alert-danger" role="alert">';
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
				$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE. 
		// Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("jenis", "J");
		$mySql	= "INSERT INTO jenis (kd_jenis, nm_jenis, kd_kategori) 
						VALUES('$kodeBaru', '$txtNama', '$cmbKategori')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Jenis-Data'>";
		}
		exit;
	}	
}

# VARIABEL DATA UNTUK DIBACA FORM
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("jenis", "J");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT> 
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Tambah Data Jenis</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="100%" class="table table-striped table-responsive" border="0" cellpadding="4" cellspacing="1">
    <tr>
      <td width="181"><strong>Kode</strong></td>
      <td width="3"><strong>:</strong></td>
      <td width="1019"><div class='col-md-2'>
      	<input name="textfield" value="<?php echo $dataKode; ?>" class='form-control' size="10" maxlength="10" readonly="readonly"/></div></td>
    </tr>
    <tr>
      <td><strong>Nama Jenis</strong></td>
      <td><strong>:</strong></td>
      <td><div class='col-md-6'><input name="txtNama" class='form-control' value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Kategori</strong></td>
      <td><strong>:</strong></td>
      <td><div class='col-md-4'><select class='form-control' name="cmbKategori" onchange="javascript:submitform();" >
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
      </select></div>
</td>
    </tr>
    <tr class='success'>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<input type="submit" name="btnSimpan" class='btn btn-primary' value="Simpan">	
      	<a href="?open=Jenis-Data" class="btn btn-danger">Kembali</a></td>
    </tr>
</table>
</form>
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
