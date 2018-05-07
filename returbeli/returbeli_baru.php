<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_returbeli'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];

	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_returbeli WHERE id='$id' AND kd_user='$kodeUser'";
		mysql_query($mySql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
	}
	if(trim($Aksi)=="Sucsses"){
		echo "<b>DATA BERHASIL DISIMPAN</b> <br><br>";
	}
}
// =========================================================================


# TOMBOL TAMBAH (KODE barang) DIKLIK
if(isset($_POST['btnTambah'])){
	# Baca Data dari Form
	$cmbSupplier		= $_POST['cmbSupplier'];
	$txtBarcode			= $_POST['txtBarcode'];
	$txtKeteranganBrg	= $_POST['txtKeteranganBrg'];
	$txtKeteranganBrg	= str_replace("'","&acute;", $txtKeteranganBrg);
	$txtJumlah			= $_POST['txtJumlah'];

	# Validasi Form
	$pesanError = array();
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";
	}
	if (trim($txtBarcode)=="") {
		$pesanError[] = "Data <b>Kode Barcode/ PLU belum diisi</b>, ketik Kode dari Keyboard atau dari <b>Tools Barcode Reader</b> !";
	}
	else {
		// Validasi Kode Barcode/PLU apakah ada dalam database
		$cekSql	= "SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$cekQry	= mysql_query($cekSql, $koneksidb) or die ("Error cek ".mysql_error());
		if(mysql_num_rows($cekQry) < 1) {
			$pesanError[] = "Data <b>Kode Barcode/PLU Tidak Dikenali</b>, data sudah ada dalam database !";
		}
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";
	}
	if (trim($txtKeteranganBrg)=="") {
		$pesanError[] = "Data <b>Keterangan Barang belum diisi</b>, silahkan dilengkapi !";
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
		# SIMPAN KE DATABASE (tmp_returbeli)

		# Kode barang Baru, membuka tabel barang
		# Cek data di dalam tabel barang, mungkin yang diinput dari form adalah Barcode dan mungkin Kode-nya
		$mySql ="SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode='$txtBarcode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query cek barang".mysql_error());
		$myData = mysql_fetch_array($myQry);
		$myQty = mysql_num_rows($myQry);
		if($myQty >= 1) {
			// Membaca kode barang/ barang
			$kodeBarang		= $myData['kd_barang'];
			$kodeBarcode	= $myData['barcode'];

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya
			$cekSql ="SELECT * FROM tmp_returbeli WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'";
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_returbeli SET jumlah = jumlah + $txtJumlah WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_returbeli (kd_supplier, kd_barang,jumlah,  keterangan, kd_user)
					VALUES ('$cmbSupplier', '$kodeBarang', '$txtJumlah', '$txtKeteranganBrg',  '$kodeUser')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			}
		}
	}

}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca Variabel from
	$txtTanggal 	= InggrisTgl($_POST['txtTanggal']);
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];

	# Validasi Form
	$pesanError = array();
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";
	}
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tanggal Transaksi</b> belum diisi, pilih pada kalender !";
	}
	if (trim($cmbSupplier)=="") {
		$pesanError[] = "Data <b>Supplier</b> belum diisi, pilih pada combo !";
	}

	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_returbeli WHERE kd_user='$kodeUser'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData = mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang/Barang</b>.";
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
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel returbeli dan returbeli_item
		$noTransaksi = buatKode("returbeli", "RB");
		$mySql	= "INSERT INTO returbeli (no_returbeli, tgl_returbeli, kd_supplier, keterangan, kd_user)
						VALUES ('$noTransaksi', '$txtTanggal', '$cmbSupplier', '$txtKeterangan', '$kodeUser')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());

		# �LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan user yg login
		$tmpSql ="SELECT * FROM tmp_returbeli WHERE kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataJumlah	= $tmpData['jumlah'];
			$dataKeterangan	= $tmpData['keterangan'];

			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO returbeli_item SET
									no_returbeli='$noTransaksi',
									kd_barang='$dataKode',
									jumlah='$dataJumlah',
									keterangan='$dataKeterangan'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());

			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok - $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}

		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_returbeli WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());

		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?open=Returbeli-Baru'>";
	}

}

# ===============================
# PADA SAAT ADA KODE PLU/ BARCODE DIINPUT DENGAN BARCODE SCANNER, ATAU KOPI PASTE (LALU KURSOR PINDAH TEMPAT)
if(isset($_POST['txtBarcode'])){
	# Baca Variabel from
	$txtBarcode	= $_POST['txtBarcode'];

	// Mengosongkan INPUT BARANG
	if(isset($_POST['btnTambah'])){
		$txtBarcode		= "";
	}

	// Membaca data barang
	$bacaSql ="SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode ='$txtBarcode'";
	$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($bacaQry) >= 1) {
		$bacaData = mysql_fetch_array($bacaQry);

		// Membaca kode barang/ produk
		$kodeBarang		= $bacaData['kd_barang'];
		$kodeBarcode	= $bacaData['barcode'];
		$namaBarang		= $bacaData['nm_barang'];
	}
	else {
		$kodeBarang		= "";
		$kodeBarcode	= "";
		$namaBarang		= "";
	}
}
else {
	$kodeBarang		= "";
	$kodeBarcode	= "";
	$namaBarang		= "";
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("returbeli", "RB");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<SCRIPT language="JavaScript">
function submitform() {
	document.form1.submit();
}
</SCRIPT>


<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Retur Pembelian Barang</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										</li>
										<li class="active-page">Retur Pembelian Baru</li>
										</li>
										<li><a href="?open=Returbeli-Tampil">Tampil Retur Pembelian</a> </li>
									</ul>
									</ul>
								</div>
							</div>
						</div>
				</div>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" class="form-horizontal">
<div class="col-md-6">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-credit-card"></i></span>
								<h4>Data Transaksi</h4>
								<ul class="widget-action-bar pull-right">

									<li><span class="widget-collapse waves-effect w-collapse"><i class="fa fa-angle-down"></i></span>
									</li>

									<li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
									</li>
								</ul>
							</div>
							<div class="widget-container">
								<div class="widget-block">
										<div class="form-group">
											<label class="col-lg-4 control-label">No. Retur</label>
											<div class="col-lg-8">
												<input name="txtNomor" value="<?php echo $noTransaksi; ?>" size="23" class="form-control" maxlength="20" readonly="readonly"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tgl. Retur</label>
											<div class="col-lg-8">
												<input name="txtTanggal" type="text" class="form-control" class="form-control" value="<?php echo $tglTransaksi; ?>" size="20" maxlength="20" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Supplier</label>
											<div class="col-lg-6">
												<select name="cmbSupplier" class="form-control">
												        <option value="Kosong">....</option>
												        <?php
													  $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
													  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
													  while ($bacaData = mysql_fetch_array($bacaQry)) {
														if ($bacaData['kd_supplier'] == $dataSupplier) {
															$cek = " selected";
														} else { $cek=""; }
														echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[nm_supplier]</option>";
													  }
													  ?>
												      </select>
											</div>
											<div class="col-lg-2">
												<a href="../?open=Supplier-Add&popup=yes" onclick="javascript:void window.open('../?open=Supplier-Add&popup=yes','1444475531021','width=700,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=1,left=0,top=0');return false;"><b>Tambah Supplier</b></a>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Keterangan</label>
											<div class="col-lg-8">
												<input name="txtKeterangan" class="form-control" value="<?php echo $dataKeterangan; ?>" size="60" maxlength="100" />
											</div>
										</div>
								</div>
							</div>
						</div>
					</div>
				<div class="col-md-6">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-cart-plus"></i></span>
								<h4>Input Barang</h4>
								<ul class="widget-action-bar pull-right">

									<li><span class="widget-collapse waves-effect w-collapse"><i class="fa fa-angle-down"></i></span>
									</li>

									<li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
									</li>
								</ul>
							</div>
							<div class="widget-container">
								<div class=" widget-block">
										<div class="form-group">
											<label class="col-lg-4 control-label">Barcode / PLU</label>
											<div class="col-lg-8">
												<input name="txtBarcode" class="form-control" id="txtBarcode" value="<?php echo $kodeBarcode; ?>" size="30" maxlength="20" onchange="javascript:submitform();" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Nama Barang</label>
											<div class="col-lg-6">
												<input name="txtNama" class="form-control" id="txtNama" size="80" maxlength="200" value="<?php echo $namaBarang; ?>" readonly="readonly"/>
											</div>
											<div class="col-lg-2">
												<a href="../?open=Cari-Barang-Retur&popup=yes" onclick="javascript:void window.open('../?open=Cari-Barang-Retur&popup=yes','1444475672556','width=900,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');return false;"><b>Cari Barang</b></a>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Keterangan</label>
											<div class="col-lg-8">
												<input name="txtKeteranganBrg" size="40" class="form-control" maxlength="100"/>
											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-4 control-label">Jumlah</label>
											<div class="col-lg-4">
												<input class="form-control" name="txtJumlah" size="4" maxlength="4" value="10"
													 onblur="if (value == '') {value = '10'}"
													 onfocus="if (value == '10') {value =''}"/>
											</div>
											<div class="col-lg-4">
												<input name="btnTambah" type="submit" style="cursor:pointer;" class="btn btn-success" value=" Tambah " />
											</div>
										</div>

								</div>
							</div>
						</div>
					</div>

<div class="col-md-12">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-list-ul"></i></span>
								<h4>Daftar Barang</h4>
							</div>
							<div class="widget-container">
								<div class=" widget-block">
									<table class="table table-striped table-responsive"  style="margin-top: -10px;" width="800" border="0" cellspacing="1" cellpadding="2">
									    <tr>
									       	<td width="23" ><strong>No</strong></td>
										      <td width="70" ><strong>Kode</strong></td>
										      <td width="390" ><strong>Nama Barang </strong></td>
										      <td width="199"><strong>Keterangan Barang </strong></td>
										      <td width="48" align="right" ><strong>Jumlah</strong></td>
										      <td width="39" align="center">&nbsp;</td>
									    </tr>
									<?php
// Qury menampilkan data dalam Grid TMP_returbeli
$tmpSql ="SELECT barang.nm_barang, tmp.* FROM tmp_returbeli As tmp
		LEFT JOIN barang ON tmp.kd_barang = barang.kd_barang
		WHERE tmp.kd_user='$kodeUser' ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  $jumlahbarang = 0;
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id				= $tmpData['id'];
	$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td><?php echo $tmpData['keterangan']; ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td><a href="?Aksi=Delete&id=<?php echo $id; ?>" target="_self" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a></td>
    </tr>
<?php } ?>
									    <tr>
									      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>TOTAL BARANG : </strong></td>
									      <td align="right" bgcolor="#F5F5F5"><b><?php echo $jumlahbarang; ?></b></td>
									      <td bgcolor="#F5F5F5">&nbsp;</td>
									    </tr>
									    <tr>
									    	<td colspan="4">&nbsp;</td>
									    	<td >
												<input name="btnSimpan" type="submit" class="btn btn-primary" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " />
											</td>
											<td>&nbsp;</td>
									    </tr>
									  </table>
								</div>
							</div>
						</div>
					</div>

</form>
<?php
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
