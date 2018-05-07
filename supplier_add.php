<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_supplier'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtSupplier= $_POST['txtSupplier'];
	$txtAlamat	= $_POST['txtAlamat'];
	$txtTelepon	= $_POST['txtTelepon'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtSupplier)=="") {
		$pesanError[] = "Data <b>Nama Supplier</b> tidak boleh kosong !";		
	}
	if (trim($txtAlamat)=="") {
		$pesanError[] = "Data <b>Alamat Lengkap</b> tidak boleh kosong !";		
	}
	if (trim($txtTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong !";		
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
		$kodeBaru	= buatKode("supplier", "S");
		$mySql	= "INSERT INTO supplier (kd_supplier, nm_supplier, alamat, no_telepon) 
					VALUES ('$kodeBaru',
							'$txtSupplier',
							'$txtAlamat',
							'$txtTelepon')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
		}
		exit;
	}	
} // Penutup POST
	
# MASUKKAN DATA KE VARIABEL
$dataKode	= buatKode("supplier", "S");
$dataNama	= isset($_POST['txtSupplier']) ? $_POST['txtSupplier'] : '';
$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : '';
$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : '';
?>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
		<span class="h-icon"><i class="fa fa-bars"></i></span>
			<h4>Tambah Data Supplier</h4>
		</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmadd">
<table width="100%" cellpadding="2" cellspacing="1" class="table table-striped table-responsive" style="margin-top:0px;">
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><div class="col-md-2">
	  	<input name="textfield" class="form-control" value="<?php echo $dataKode; ?>" size="10" maxlength="4" readonly="readonly"/></div></td></tr>
	<tr>
	  <td><b>Nama Supplier </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtSupplier" value="<?php echo $dataNama; ?>" class="form-control" size="80" maxlength="100" /></div></td>
	</tr>
	<tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-8">
	  	<input name="txtAlamat" value="<?php echo $dataAlamat; ?>" class="form-control" size="80" maxlength="200" /></div></td>
    </tr>
	<tr>
      <td><b>No Telepon </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtTelepon" value="<?php echo $dataTelepon; ?>" class="form-control" size="20" maxlength="20" /></div></td>
    </tr>
	<tr class="success"><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" name="btnSimpan" value="Simpan" class="btn btn-primary" style="cursor:pointer;">
	  	<?php if($_GET['popup'] == 'yes'): ?>
	  	<?php else: ?>
	  	<a href="?open=Supplier-Data" class="btn btn-danger">Kembali</a>
	  <?php endif ?>
	  </td>
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
