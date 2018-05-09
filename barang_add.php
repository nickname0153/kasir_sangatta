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
	// 	$cekSql	= "SELECT * FROM barang WHERE barcode='$txtBarcode'";
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
		# SIMPAN DATA KE DATABASE. // Jika tidak menemukan error, simpan data ke database
		$kodeBaru	= buatKode("barang", "B");
		$mySql	= "INSERT INTO barang (kd_barang, barcode, nm_barang, kd_jenis, kd_merek, satuan_beli, beli_isi, satuan_jual,
								harga_beli, harga_jual, harga_member, diskon, stok_opname, stok_minimal, stok_maksimal)
						VALUES ('$kodeBaru',
								'$txtBarcode',
								'$txtNama',
								'$cmbJenis',
								'$cmbMerek',
								'$cmbSatuanBeli',
								'$txtBeliIsi',
								'$cmbSatuanJual',
								'$txtHargaBeli',
								'$txtHargaJual',
								'$txtHargaMember',
								'$txtDiskon',
								'$txtStokOpname',
								'$txtStokMin',
								'$txtStokMax')";
		$myQry	= mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Refresh
			echo "<meta http-equiv='refresh' content='0; url=?open=Barang-Data'>";
		}
		exit;
	}
} // Penutup POST


# VARIABEL DATA UNTUK DIBACA FORM
$dataKode		= buatKode("barang", "B");
$dataNama 		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataBarcode	= isset($_POST['txtBarcode']) ? $_POST['txtBarcode'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
$dataKategoriSub= isset($_POST['cmbKategoriSub']) ? $_POST['cmbKategoriSub'] : '';
$dataJenis	    = isset($_POST['cmbJenis']) ? $_POST['cmbJenis'] : '';
$dataMerek	    = isset($_POST['cmbMerek']) ? $_POST['cmbMerek'] : '';
$dataSatuanBeli	= isset($_POST['cmbSatuanBeli']) ? $_POST['cmbSatuanBeli'] : '';
$dataBeliIsi	= isset($_POST['txtBeliIsi']) ? $_POST['txtBeliIsi'] : '0';
$dataSatuanJual	= isset($_POST['cmbSatuanJual']) ? $_POST['cmbSatuanJual'] : '';
$dataHargaBeli	= isset($_POST['txtHargaBeli']) ? $_POST['txtHargaBeli'] : '0';
$dataHargaJual	= isset($_POST['txtHargaJual']) ? $_POST['txtHargaJual'] : '0';
$dataDiskon	    = isset($_POST['txtDiskon']) ? $_POST['txtDiskon'] : '0';
$dataStokOpname = isset($_POST['txtStokOpname']) ? $_POST['txtStokOpname'] : '0';
$dataStokMin	= isset($_POST['txtStokMin']) ? $_POST['txtStokMin'] : '0';
$dataStokMax	= isset($_POST['txttokMax']) ? $_POST['txttokMax'] : '0';
$dataHargaMember	= isset($_POST['txtHargaMember']) ? $_POST['txtHargaMember'] : '0';

?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Tambah Data Barang</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table class="table table-striped table-responsive" width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td width="16%"><strong>Kode</strong></td>
      <td width="1%"><strong>:</strong></td>
      <td width="83%"><div class="col-md-2">
      	<input name="textfield" class="form-control" value="<?php echo $dataKode; ?>" size="14" maxlength="10" readonly="readonly"/></div></td>
    </tr>
    <tr>
      <td><strong>Barcode/ PLU </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<input class="form-control" name="txtBarcode" value="<?php echo $dataBarcode; ?>" size="30" maxlength="20" /> </div>     </td>
    </tr>
    <tr>
      <td><strong>Nama Barang </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-6">
      	<input name="txtNama" class="form-control" value="<?php echo $dataNama; ?>" size="80" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Kategori / Jenis</strong></td>
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
<select class="form-control" name="cmbJenis">
          <option value="Kosong">....</option>
          <?php
	  $bacaSql = "SELECT * FROM jenis WHERE kd_kategori='$dataKategori' ORDER BY kd_jenis";
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
          <option value="Kosong" >....</option>
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
      <td><div class="col-md-2">
      	<input name="txtBeliIsi" class="form-control" id="txtBeliIsi"
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
      	<input name="txtHargaBeli" id="txtHargaBeli" class="form-control"
				onfocus="if (value == '0') {value =''}"
	  			onblur="if (value == '') {value = '0'}" value="<?php echo $dataHargaBeli; ?>" size="20" maxlength="12"/></div></td>
    </tr>
    <tr>
      <td><strong>Harga Jual (Rp.) </strong></td>
      <td><strong>:</strong></td>
      <td><div class="col-md-4">
      	<input name="txtHargaJual" class="form-control" value="<?php echo $dataHargaJual; ?>" size="20" maxlength="12"
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
      <td><div class="col-md-2">
      	<input name="txtDiskon" class="form-control" value="<?php echo $dataDiskon; ?>" size="6" maxlength="4"/></div></td>
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
      	<input name="txtStokOpname" class="form-control" value="<?php echo $dataStokOpname; ?>" size="6" maxlength="4"/>
      </div></td>
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
      <td><div class="col-md-2"><input name="txtStokMax" class="form-control" value="<?php echo $dataStokMax; ?>" size="6" maxlength="4"/></div></td>
    </tr>
    <tr class="success">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<input type="submit" class="btn btn-primary" name="btnSimpan" value="Simpan">
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
