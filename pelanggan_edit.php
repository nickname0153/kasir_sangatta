<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_pelanggan'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Form
	$txtPelanggan	= $_POST['txtPelanggan'];
	$txtAlamat		= $_POST['txtAlamat'];
	$txtTelepon		= $_POST['txtTelepon'];
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtPelanggan)=="") {
		$pesanError[] = "Data <b>Nama Pelanggan</b> tidak boleh kosong !";		
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
		$mySql	= "UPDATE pelanggan SET nm_pelanggan='$txtPelanggan', alamat='$txtAlamat',
					no_telepon='$txtTelepon' WHERE kd_pelanggan ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Pelanggan-Data'>";
		}
		exit;
	}	
} // Penutup POST

# TAMPILKAN DATA supplier
$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql	= "SELECT * FROM pelanggan WHERE kd_pelanggan='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$myData = mysql_fetch_array($myQry);

	# MASUKKAN DATA KE VARIABEL
	$dataKode	= $myData['kd_pelanggan'];
	$dataNama	= isset($_POST['txtPelanggan']) ? $_POST['txtPelanggan'] : $myData['nm_pelanggan'];
	$dataNo     = isset($_POST['txtKdpelanggan']) ? $_POST['txtKdpelanggan'] : $myData['no_anggota'];
	$dataAlamat = isset($_POST['txtAlamat']) ? $_POST['txtAlamat'] : $myData['alamat'];
	$dataTelepon = isset($_POST['txtTelepon']) ? $_POST['txtTelepon'] : $myData['no_telepon'];
?>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
		<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Ubah Data Pelanggan</h4>
	</div>
	<div class="widget-container">
		<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="frmedit">
<table width="100%" class="table table-striped table-responsive" style="margin-top:0px;">
	<tr>
	  <td width="15%"><b>Kode</b></td>
	  <td width="1%"><b>:</b></td>
	  <td width="84%"><div class="col-md-2"><input name="textfield" class="form-control" value="<?php echo $dataKode; ?>" size="8" maxlength="4"  readonly="readonly"/>
    <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></div></td></tr>
	<td><b>Kode Anggota </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtKdpelanggan" class="form-control" value="<?php echo $dataNo; ?>" size="80" maxlength="100" readonly="readonly" /></div></td>
	</tr>
	<tr>
	<tr>
	  <td><b>Nama Pelanggan </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtPelanggan" class="form-control" type="text" id="txtPelanggan" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></div></td></tr>
	<tr>
      <td><b>Alamat Lengkap </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-8"><input name="txtAlamat" class="form-control" value="<?php echo $dataAlamat; ?>" size="80" maxlength="200" /></div></td>
    </tr>
	<tr>
      <td><b>No. Telepon </b></td>
	  <td><b>:</b></td>
	  <td><div class="col-md-6">
	  	<input name="txtTelepon" value="<?php echo $dataTelepon; ?>" size="20" class="form-control" maxlength="20" /></div></td>
    </tr>
	<tr class="success"><td>&nbsp;</td>
	  <td>&nbsp;</td>
	  <td><input type="submit" class="btn btn-primary" name="btnSimpan" value=" SIMPAN " style="cursor:pointer;">
	  	<a href="?open=Pelanggan-Data" class="btn btn-danger">Kembali</a></td>
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

