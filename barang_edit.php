<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_barang'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel Data Form
	$txtBarcode			= $_POST['txtBarcode'];
	$txtNama			= $_POST['txtNama'];
	$cmbKategori		= $_POST['cmbKategori'];
	$cmbKategoriSub		= $_POST['cmbKategoriSub'];
	$cmbJenis			= $_POST['cmbJenis'];
	$cmbMerek			= $_POST['cmbMerek'];
	$cmbSatuanBeli		= $_POST['cmbSatuanBeli'];
	$txtBeliIsi			= $_POST['txtBeliIsi'];
	$cmbSatuanJual		= $_POST['cmbSatuanJual'];
	$txtHargaBeli		= $_POST['txtHargaBeli'];
	$txtHargaJual		= $_POST['txtHargaJual'];
	$txtDiskon			= $_POST['txtDiskon'];	
	$txtStokOpname		= $_POST['txtStokOpname'];	
	$txtStokMin			= $_POST['txtStokMin'];	
	$txtStokMax			= $_POST['txtStokMax'];	
	$txtHargaMember			= $_POST['txtHargaMember'];
	// Menghilangkan tanda petik pada teks masukan
	$txtBarcode 		= str_replace("'","&acute;",$txtBarcode);
	$txtNama 			= str_replace("'","&acute;",$txtNama);
	
	# Validasi form, jika kosong sampaikan pesan error
	$pesanError = array();
	if (trim($txtBarcode)=="") {
		$pesanError[] = "Data <b>Kode Barcode/ PLU</b> tidak boleh kosong !";		
	}
	// else {
	// 	// Validasi Kode Barcode/PLU tidak boleh ada yang kembar
	// 	$Kode	= $_POST['txtKode'];
	// 	$cekSql	= "SELECT * FROM barang WHERE barcode='$txtBarcode' AND NOT(kd_barang='$Kode')";
	// 	$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
	// 	if(mysql_num_rows($cekQry) >= 1) {
	// 		$pesanError[] = "Data <b>Kode Barcode/PLU Sudah Dipakai</b>, data sudah ada dalam database !";
	// 	}
	// }
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama Barang</b> tidak boleh kosong !";		
	}
	if (trim($cmbJenis)=="Kosong") {
		$pesanError[] = "Data <b>Jenis</b> belum ada yang dipilih !";		
	}
	if (trim($cmbMerek)=="Kosong") {
		$pesanError[] = "Data <b>Merek</b> belum ada yang dipilih !";		
	}
	if (trim($cmbSatuanBeli)=="Kosong") {
		$pesanError[] = "Data <b>Satuan Beli</b> belum ada yang dipilih !";		
	}
	if (trim($txtBeliIsi)=="" or ! is_numeric(trim($txtBeliIsi))) {
		$pesanError[] = "Data <b>Beli isi</b> harus diisi angka !";		
	}
	if (trim($cmbSatuanJual)=="Kosong") {
		$pesanError[] = "Data <b>Satuan Jual</b> belum ada yang dipilih !";		
	}
	if (trim($txtHargaBeli)=="" or ! is_numeric(trim($txtHargaBeli))) {
		$pesanError[] = "Data <b>Harga Beli (Rp.)</b> harus diisi angka!";		
	}
	if (trim($txtHargaJual)=="" or ! is_numeric(trim($txtHargaJual))) {
		$pesanError[] = "Data <b>Harga Jual (Rp.)</b> harus diisi angka!";		
	}
	else {
		// Periksa untung rugi, selisih antara Beli dan Jual
		if (trim($txtHargaBeli) >= trim($txtHargaJual)) {
			$pesanError[] = "Data <b>Harga Jual (Rp.) Masih Rugi</b>, belum ada keuntungan !";	
		}
	}
	if (trim($txtDiskon)=="" or ! is_numeric(trim($txtDiskon))) {
		$pesanError[] = "Data <b>Diskon (%)</b> harus diisi angka, atau 0!";		
	}

	if (trim($txtStokOpname)=="" or ! is_numeric(trim($txtStokOpname))) {
		$pesanError[] = "Data <b>Stok Opname</b> harus diisi angka, atau diisi 0 !";		
	}
	if (trim($txtStokMin)=="" or ! is_numeric(trim($txtStokMin))) {
		$pesanError[] = "Data <b>Stok Minimal</b> harus diisi angka, atau diisi 0 !";		
	}
	if (trim($txtStokMax)=="" or ! is_numeric(trim($txtStokMax))) {
		$pesanError[] = "Data <b>Stok Maksimal</b> harus diisi angka, atau diisi 0 !";		
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
		# SIMPAN DATA KE DATABASE 
		// Jika tidak menemukan error, simpan data ke database
		$Kode	= $_POST['txtKode'];
		$mySql	= "UPDATE barang SET 
								barcode			= '$txtBarcode',
								nm_barang		= '$txtNama',
								kd_jenis		= '$cmbJenis',
								kd_merek		= '$cmbMerek',
								satuan_beli		= '$cmbSatuanBeli',
								beli_isi		= '$txtBeliIsi',
								satuan_jual		= '$cmbSatuanJual',
								harga_beli		= '$txtHargaBeli',
								harga_jual		= '$txtHargaJual',
								harga_member	= '$txtHargaMember',
								diskon			= '$txtDiskon',
								stok_opname		= '$txtStokOpname',
								stok_minimal	= '$txtStokMin',
								stok_maksimal	= '$txtStokMax'
						WHERE kd_barang ='$Kode'";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
		exit;
	}
} // Penutup POST
	
	
# TAMPILKAN DATA UNTUK DIEDIT
$Kode	= $_GET['Kode']; 
$mySql 	= "SELECT barang.* FROM barang 
			LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
			LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
			WHERE barang.kd_barang='$Kode'";
$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query data salah : ".mysql_error());
$myData	= mysql_fetch_array($myQry);
	// Membaca data, lalu disimpan dalam variabel data
	$dataKode		=  $myData['kd_barang'];
	$dataBarcode	= isset($_POST['txtBarcode']) ? $_POST['txtBarcode'] : $myData['barcode'];
	$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : $myData['nm_barang'];
	$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $myData['kd_kategori'];
	$dataKategoriSub= isset($_POST['cmbKategoriSub']) ? $_POST['cmbKategoriSub'] : $myData['kd_kategorisub'];
	$dataJenis		= isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : $myData['kd_jenis'];
	$dataMerek		= isset($_POST['cmbMerek']) ? $_POST['cmbMerek'] : $myData['kd_merek'];
	$dataSatuanBeli	= isset($_POST['cmbSatuanBeli']) ? $_POST['cmbSatuanBeli'] : $myData['satuan_beli'];
	$dataBeliIsi	= isset($_POST['txtBeliIsi']) ? $_POST['txtBeliIsi'] : $myData['beli_isi'];
	$dataSatuanJual	= isset($_POST['cmbSatuanJual']) ? $_POST['cmbSatuanJual'] : $myData['satuan_jual'];
	$dataHargaBeli	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : $myData['harga_beli'];
	$dataHargaJual	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : $myData['harga_jual'];
	$dataDiskon		= isset($_POST['txtDiskon']) ? $_POST['txtDiskon'] : $myData['diskon'];
	$dataStokOpname = isset($_POST['txtStokOpname']) ? $_POST['txtStokOpname'] : $myData['stok_opname'];
	$dataStokMin	= isset($_POST['txtStokMin']) ? $_POST['txtStokMin'] : $myData['stok_minimal'];
	$dataStokMax	= isset($_POST['txttokMax']) ? $_POST['txttokMax'] : $myData['stok_maksimal'];
	$dataHargaMember	= isset($_POST['txtHargaMember']) ? $_POST['txtHargaMember'] : $myData['harga_member'];
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Ubah Data Barang</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table table-striped table-responsive" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <th colspan="3" scope="col">UBAH DATA BARANG</th>
    </tr>
    <tr>
      <td width="16%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="83%"><div class="col-md-2">
      	<input name="textfield" class="form-control" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"/>
      <input name="txtKode" type="hidden" value="<?php echo $dataKode; ?>" /></div></td>
    </tr>
    
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-6">
      	<input name="txtNama" class="form-control" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Jenis</strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4"><select name="cmbKategori" class="form-control" onchange="javascript:submitform();" >
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
<div class="col-md-4">
<select name="cmbJenis" class="form-control">
        <option value="Kosong">....</option>
        <?php
	  $bacaSql = "SELECT * FROM jenis ORDER BY kd_jenis";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_jenis'] == $dataJenis) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_jenis]' $cek>$bacaData[nm_jenis]</option>";
	  }
	  ?>
      </select></div></td>
    </tr>
    <tr>
      <td><strong>Merek</strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<select name="cmbMerek" class="form-control">
        <option value="Kosong">....</option>
        <?php
	  $bacaSql = "SELECT * FROM merek ORDER BY kd_merek";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_merek'] == $dataMerek) {
			$cek = " selected";
		} else { $cek=""; }
		echo "<option value='$bacaData[kd_merek]' $cek>$bacaData[nm_merek]</option>";
	  }
	  ?>
      </select></div></td>
    </tr>
    <tr>
      <td><b>Satuan Beli </b></td>
      <td><b>:</b></td>
      <td><b><div class="col-md-2">
        <select name="cmbSatuanBeli" class="form-control">
          <option value="Kosong">....</option>
          <?php
		  $bacaSql = "SELECT * FROM pilih_satuan ORDER BY id";
		  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($bacaData = mysql_fetch_array($bacaQry)) {
			if ($bacaData['satuan'] == $dataSatuanBeli) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bacaData[satuan]' $cek> $bacaData[satuan]</option>";
		  }
          ?>
        </select></div>
      </b></td>
    </tr>
    <tr>
      <td><strong>Beli Isi </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-2"><input name="txtBeliIsi" class="form-control" id="txtBeliIsi" 
				onfocus="if (value == '0') {value =''}" 
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataBeliIsi; ?>" size="20" maxlength="4"/></div></td>
    </tr>
    <tr>
      <td><b>Satuan Jual </b></td>
      <td><b>:</b></td>
      <td><b><div class="col-md-2">
        <select name="cmbSatuanJual" class="form-control">
          <option value="Kosong">....</option>
          <?php
		  $bacaSql = "SELECT * FROM pilih_satuan ORDER BY id";
		  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
		  while ($bacaData = mysql_fetch_array($bacaQry)) {
			if ($bacaData['satuan'] == $dataSatuanJual) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$bacaData[satuan]' $cek> $bacaData[satuan]</option>";
		  }
		  ?>
        </select></div>
      </b></td>
    </tr>
    <tr>
      <td><strong>Harga Beli (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<input name="txtHargaBeli" class="form-control" id="txtHargaBeli" 
				onfocus="if (value == '0') {value =''}" 
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12"/></div></td>
    </tr>
    <tr>
      <td><strong>Harga Jual (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4"><input name="txtHargaJual" class="form-control" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12" 
	  			onblur="if (value == '') {value = '0'}" 
				onfocus="if (value == '0') {value =''}"/></div></td>
    </tr>
    <tr>
      <td><strong>Harga member (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<input name="txtHargaMember" class="form-control" value="<?php echo $dataHargaMember; ?>" size="20" maxlength="12"
	  			onblur="if (value == '') {value = '0'}"
				onfocus="if (value == '0') {value =''}"/></div></td>
    </tr>
    <tr>
      <td><strong>Diskon (%) </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-2"><input name="txtDiskon" class="form-control" value="<?php echo $dataDiskon; ?>" size="6" maxlength="4"/></div></td>
    </tr>
    <tr class="danger">
      <td bgcolor="#F5F5F5"><strong>INFO</strong></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td><strong>Stok Opname </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-2">
      	<input name="txtStokOpname" class="form-control" value="<?php echo $dataStokOpname; ?>" size="6" maxlength="4"/></div></td>
    </tr>
    <tr>
      <td><strong>Stok Minimal </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-2">
      	<input name="txtStokMin" class="form-control" value="<?php echo $dataStokMin; ?>" size="6" maxlength="4"/></div></td>
    </tr>
    <tr>
      <td><strong>Stok Maksimal</strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-2">
      	<input name="txtStokMax" class="form-control" value="<?php echo $dataStokMax; ?>" size="6" maxlength="4"/></div></td>
    </tr>
    <tr>
      <td><strong>Barcode/ PLU </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<input name="txtBarcode" class="form-control" value="<?php echo $dataBarcode; ?>" size="30" maxlength="20" /></div></td>
    </tr>
    <tr class="success">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan" style="cursor:pointer;"> 
      	<a href="?open=Barang-Data" class="btn btn-danger">Kembali</a></td>
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
