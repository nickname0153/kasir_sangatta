<?php

include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

error_reporting(0);

// Hak akses
if($aksesData['mu_header'] == "Yes") {
	
	if($_POST){

	$id = $_POST['id'];
	$nama = $_POST['nama'];
	$alamat = $_POST['alamat'];
	$telp = $_POST['telp'];

	$fileName = $_FILES['thumbnail']['name'];

	if($id && $nama)

	{ 
    if (empty($fileName)){
    	$q = "UPDATE tb_header SET nama = '$nama',
    							   alamat = '$alamat',
    							   telp = '$telp' WHERE id = '$id' ";
    	mysql_query($q, $koneksidb)  or die ("Query salah : ".mysql_error());
    	echo '<div class="alert alert-success" role="alert">
										 Data Profil Perusahaan <strong>Berhasil</strong> diubah. 
									</div>';
    }else{
    	$q = "UPDATE tb_header SET nama = '$nama',
    							   alamat = '$alamat',
    							   telp = '$telp',
    							   thumbnail = '$fileName'
    							   WHERE id = '$id' ";
    	mysql_query($q, $koneksidb)  or die ("Query salah : ".mysql_error());
    	move_uploaded_file($_FILES['thumbnail']['tmp_name'], "images/".$_FILES['thumbnail']['name']);
    	echo '<div class="alert alert-success" role="alert">
										 Data Profil Perusahaan <strong>Berhasil</strong> diubah. 
									</div>';
    }

	}else{
		echo '<div class="alert alert-danger" role="alert">
										 Data Profil Perusahaan <strong>Gagal</strong> diubah. 
									</div>';
	}
}


$Kode	= isset($_GET['Kode']) ?  $_GET['Kode'] : $_POST['txtKode']; 
$mySql	= "SELECT * FROM tb_header WHERE id='$Kode'";
$myQry	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
$row = mysql_fetch_array($myQry);
?>

<style type="text/css">
	i{
		font-size: 11px;
	}
</style>
<div class="box-widget widget-module">
  <div class="widget-head clearfix">
  <span class="h-icon"><i class="fa fa-bars"></i></span>
    <h4>Ubah Data Perushaan</h4>
  </div>
    <div class="widget-container">
      <div class=" widget-block">
<form method="post" action="<?php $_SERVER['PHP_SELF']; ?>" enctype="multipart/form-data">

<table class="table table-responsive table-striped" width="100%" >
	<tr>
		<input type="hidden" name="id" value="<?php echo $row['id'] ?>">
		<td width="181" >Nama</td>
		<td width="3"> : </td>
		<td><div class="col-md-6">
			<input type="text" name="nama" placeholder="Nama Perusahaan" class="form-control" value="<?php echo $row['nama'] ?>" required>
		</div></td>
	</tr>
	<tr>
		<td width="181" >Alamat</td>
		<td width="3"> : </td>
		<td><div class="col-md-6">
			<textarea class="form-control" name="alamat" placeholder="Alamat Perusahaan" required><?php echo $row['alamat'] ?></textarea>
		</div></td>
	</tr>
	<tr>
		<td width="181" >Telepon</td>
		<td width="3"> : </td>
		<td><div class="col-md-6">
			<input class="form-control" name="telp" value="<?php echo $row['telp']; ?>" placeholder="Telepon" required>
		</div></td>
	</tr>
	<?php /** <tr>
		<td>Logo</td>
		<td> : </td>
		<td><div class="col-md-6">
			<input type="file" name="thumbnail" class="form-control">
			<i>*)Tidak perlu diisi bila ingin dihapus</i><br>
			<i>**)Ukuran yang direkomendasikan 700x90 px</i>
		</div>
		</td>
	</tr>
	 **/ ?>
	<tr class="success">
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td><div class="col-md-6">
			<input type="submit" name="submit" value="submit" class="btn btn-primary">
		</div></td>
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