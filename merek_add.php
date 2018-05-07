<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_merek'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtNama	= $_POST['txtNama'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Merek</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("merek", "M");
		$mySql	= "INSERT INTO merek (kd_merek, nm_merek) VALUES('$kodeBaru', '$txtNama')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Merek-Data'>";
		}
		exit;
	}	
}

# VARIABEL DATA UNTUK DIBACA FORM
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode	= buatKode("merek", "M");
$dataNama	= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
?>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Tambah Data Merek</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
  <table width="100%" class="table table-striped table-responsive" border="0" cellpadding="4" cellspacing="1">
    <tr>
      <td width="181"><strong>Kode</strong></td>
      <td width="3">:</td>
      <td width="1019"><div class="col-md-2">
      <input name="textfield" value="<?php echo $dataKode; ?>" size="10" maxlength="10" class="form-control" readonly="readonly"/></div></td>
    </tr>
    <tr>
      <td><strong>Nama Merek </strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtNama" value="<?php echo $dataNama; ?>" size="70" maxlength="100" class="form-control"/></div></td>
    </tr>
    <tr class="success">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<input type="submit" name="btnSimpan" value="Simpan" class="btn btn-primary">
      	<a href="?open=Merek-Data" class="btn btn-danger">Kembali</a></td>
    </tr>
  </table>
</form>
</div>
</di>
</div>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
