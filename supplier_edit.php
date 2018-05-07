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
		# SIMPAN PERUBAHAN DATA, Jika jumlah error pesanError tidak ada, simpan datanya
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE supplier SET nm_supplier='$txtSupplier', alamat='$txtAlamat',
					no_telepon='$txtTelepon' WHERE kd_supplier ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Supplier-Data'>";
		}
		exit;
	}	
} // Penutup POST

# TAMPILKAN DATA supplier
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql	= "SELECT * FROM supplier WHERE kd_supplier='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $myData['kd_supplier'];
	$dataNama	= isset($_POST['txtSupplier']) ? $_POST['txtSupplier'] : $myData['nm_supplier'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
?>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
		<span class="h-icon"><i class="fa fa-bars"></i></span>
			<h4>Ubah Data Supplier</h4>
		</div>
			<div class="widget-container">
				<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table class="table table-striped table-responsive" width="100%" style="margin-top:0px;">
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><div class="col-md-2">
	  	<input name="textfield" class="form-control" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/></div>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></td></tr>
	<tr>
	  <td><b>Nama Supplier </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtSupplier" type="text" value="<?php echo $dataNama; ?>" class="form-control" size="80" maxlength="100" /></div></td></tr>
	<tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-8">
	  	<input name="txtAlamat" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" class="form-control" /></div></td>
    </tr>
	<tr>
      <td><b>No Telepon </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" maxlength="20" class="form-control" /></div></td>
    </tr>
	<tr class="success"><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><div class="col-md-4">
	  	<input type="submit" class="btn btn-primary" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;"></div></td>
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

