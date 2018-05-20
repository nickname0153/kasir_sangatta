<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_pembelian'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];
	
	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_pembelian WHERE id='$id' AND kd_user='$kodeUser'";
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
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtBarcode		= $_POST['txtBarcode'];
	$txtKode		= $_POST['txtKode'];
	$txtHarga		= $_POST['txtHarga'];
	$txtJumlah		= $_POST['txtJumlah'];
	$diskon 		= $_POST['txtDisc'];
	$dp 			= $_POST['dp'];
	
			
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($cmbSupplier)=="") {
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
	if (trim($txtHarga)=="" or ! is_numeric(trim($txtHarga))) {
		$pesanError[] = "Data <b>Harga Pembelian (Rp) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
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
		# AREA SKRIP SIMPAN KE DATABASE (tmp_pembelian)	

		# Kode barang Baru, membuka tabel barang
		# Cek data di dalam tabel barang, mungkin yang diinput dari form adalah Barcode dan mungkin Kode-nya
		$mySql ="SELECT * FROM barang WHERE kd_barang='$txtKode'";
		$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query cek barang".mysql_error());
		$myData = mysql_fetch_array($myQry);
		$myQty = mysql_num_rows($myQry);
		if($myQty >= 1) {
			// Membaca kode barang/ barang
			$kodeBarang		= $myData['kd_barang'];
			//$kodeBarcode	= $myData['barcode'];
			$harga_msk		= $txtHarga;
			$diskon_msk		= $myData['diskon'];

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
			$cekSql ="SELECT * FROM tmp_pembelian WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_pembelian SET jumlah = jumlah + $txtJumlah WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_pembelian (kd_supplier, kd_barang, harga, diskon, jumlah,  kd_user) 
								VALUES ('$cmbSupplier', '$kodeBarang', '$harga_msk', '$diskon_msk', '$txtJumlah',  '$kodeUser')";
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query tmp : ".mysql_error());
			}
		}
	}
}
// ============================================================================

# ========================================================================================================
# JIKA TOMBOL SIMPAN TRANSAKSI DIKLIK
if(isset($_POST['btnSimpan'])){
	# Baca variabel data from
	$txtTanggal 	= $_POST['txtTanggal'];
	$cmbSupplier	= $_POST['cmbSupplier'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$dp 			= $_POST['dp'];
	$txtTempo 		= $_POST['txtTempo'];
	
	# Validasi Kotak isi Form
	$pesanError = array();
	if (trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada kalender !";		
	}
	if (trim($cmbSupplier)=="Kosong") {
		$pesanError[] = "Data <b>Supplier</b> belum ada yang dipilih, pilih pada combo !";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql ="SELECT COUNT(*) As qty FROM tmp_pembelian WHERE kd_user='$kodeUser'";
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
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel pembelian dan pembelian_item
		$noTransaksi = buatKode("pembelian", "BL");
		$mySql	= "INSERT INTO pembelian SET 
						no_pembelian='$noTransaksi', 
						tgl_pembelian='".InggrisTgl($txtTanggal)."', 
						kd_supplier='$cmbSupplier', 
						keterangan='$txtKeterangan',
						dp='$dp', 
						kd_user='$kodeUser',
						tgl_tempo='".InggrisTgl($txtTempo)."'";
		mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan user yg login
		$tmpSql ="SELECT * FROM  tmp_pembelian WHERE kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 	= $tmpData['kd_barang'];
			$dataHarga	= $tmpData['harga'];
			$dataJumlah	= $tmpData['jumlah'];
			$dataDiskon = $tmpData['diskon'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO pembelian_item SET 
									no_pembelian='$noTransaksi', 
									kd_barang='$dataKode', 
									harga_beli='$dataHarga',
									diskon='$dataDiskon', 
									jumlah='$dataJumlah'";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query ".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok + $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			
			// Skrip Update Harga Kulak (Modal)
			$stokSql = "UPDATE barang SET harga_beli = $dataHarga WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Harga Modal".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_pembelian WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		echo "<meta http-equiv='refresh' content='0; url=?open=Pembelian-Tampil'>";
	}	
}

# ===============================
# PADA SAAT ADA KODE PLU/ BARCODE DIINPUT DENGAN BARCODE SCANNER, ATAU KOPI PASTE (LALU KURSOR PINDAH TEMPAT)
if(isset($_POST['btnTambah'])){
	# Baca Variabel from
	//$txtBarcode	= $_POST['txtBarcode'];
	$txtKode= $_POST['txtKode'];

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
		//$kodeBarcode	= $bacaData['barcode'];
		//$kd_Barang		= $bacaData[''];
		$namaBarang		= $bacaData['nm_barang'];
		$hargaBeli		= $bacaData['harga_beli'];
	}
	else {
		$kodeBarcode	= "";
		$namaBarang		= "";
		$hargaBeli		= "";
	}
}
else {
	$kodeBarcode	= "";
	$namaBarang		= "";
	$hargaBeli		= "";
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("pembelian", "BL");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$tglTempo 		= isset($_POST['txtTempo']) ? $_POST['txtTempo'] : '';
$dataSupplier	= isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : '';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataKategori	= isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : '';
?>
<SCRIPT language="JavaScript">

jQuery(".form-control").keyup(function (event) {
    if (event.keyCode == 13) {
        textboxes = jQuery("input.form-control");
        currentBoxNumber = textboxes.index(this);
        if (textboxes[currentBoxNumber + 1] != null) {
            nextBox = textboxes[currentBoxNumber + 1];
            nextBox.focus();
            nextBox.select();
        }
        event.preventDefault();
        return false;
    }
});

</SCRIPT> 
<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Pembelian Barang</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										</li>
										<li class="active-page"> Pembelian Barang</li>
										</li>
										<li><a href="?open=Pembelian-Tampil">Data Transaksi Pembelian</a> </li>
									</ul>
									</ul>
								</div>
							</div>
						</div>
				</div>
</div>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" class="form-horizontal">
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
											<label class="col-lg-4 control-label">No. Pembelian</label>
											<div class="col-lg-8">
												<input name="txtNomor" class="form-control" value="<?php echo $noTransaksi; ?>" size="23" maxlength="20" readonly="readonly"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tgl. Pembelian</label>
											<div class="col-lg-8">
												<input name="txtTanggal" type="text" id="tgl" class="form-control" value="<?php echo $tglTransaksi; ?>" size="20" maxlength="20" />
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
												<select name="txtKeterangan" class="form-control">
													<option value="Cash">Cash</option>
													<option value="Kredit">Kredit</option>
												</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tgl. Jatuh Tempo (Diisi Jika Ket Kredit)</label>
											<div class="col-lg-8">
												<input name="txtTempo" type="text" id="tgl" class="form-control" value="<?php echo $tglTempo; ?>" size="20" maxlength="20" placeholder="Hari-Bulan-Tahun (30-12-2018)" />
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
									<label class="col-lg-4 control-label"></label>
										<div class="col-lg-8">
												<a href="../?open=Barang-Cari&popup=yes" onclick="javascript:void window.open('../?open=Barang-Cari&popup=yes','1444475672556','width=900,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');return false;"><b>Cari Barang</b></a>
											</div>
									</div>
									<div class="form-group">
											<label class="col-lg-4 control-label">Kode Barang</label>
											<div class="col-lg-8">
												<input name="txtKode" class="form-control" id="txtKode" value="<?php echo $kd_Barang; ?>" size="30" maxlength="20" readonly="readonly"/>
											</div>
										</div>
									<div class="form-group">
											<label class="col-lg-4 control-label">Barcode / PLU</label>
											<div class="col-lg-8">
												<input name="txtBarcode" class="form-control" id="txtBarcode" value="<?php echo $kodeBarcode; ?>" size="30" maxlength="20" readonly="readonly"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Harga Beli/ Modal (Rp)</label>
											<div class="col-lg-8">
												<input autofocus name="txtHarga" class="form-control" id="txtHarga" value="<?php echo $hargaBeli; ?>" size="20" maxlength="12"/>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-lg-4 control-label">Nama Barang</label>
											<div class="col-lg-8">
												<input name="txtNama" class="form-control" id="txtNama" size="80" maxlength="200" value="<?php echo $namaBarang; ?>" readonly="readonly"/>
											</div>
											
										</div>
										
										<div class="form-group">
											<label class="col-lg-4 control-label">Disc(%)</label>
											<div class="col-lg-8">
												<input name="txtDisc" id="txtDisc" size="4" maxlength="4" class="form-control" value="<?php if (empty($diskonJual)) {
													echo "0";}else{echo $diskonJual;} ?>" />
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Jumlah</label>
											<div class="col-lg-4">
												<input class="form-control" name="txtJumlah" size="4" maxlength="4" value="1" 
													 onblur="if (value == '') {value = '1'}" 
													 onfocus="if (value == '1') {value =''}"/>
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
									    <tr >
									      <td width="29" ><strong>No</strong></td>
									      <td width="85" ><strong>Kode</strong></td>
									      <td width="432"><strong>Nama Barang </strong></td>
									      <td width="85" align="right"><strong>Harga (Rp) </strong></td>
									      <td width="60" align="right"><strong>Diskon (%)</strong></td>
									      <td width="48" align="right"><strong>Jumlah</strong></td>
									      <td width="100" align="right"><strong>Sub Total(Rp) </strong></td>
									      <td width="22" align="center">&nbsp;</td>
									    </tr>
									<?php
									// deklarasi variabel
									$hargaDiskon= 0; 
									$totalBayar	= 0; 
									$jumlahbarang	= 0;

									// Qury menampilkan data dalam Grid TMP_Pembelian 
									$tmpSql ="SELECT barang.*, tmp.id, tmp.harga, tmp.jumlah, tmp.diskon FROM barang, tmp_pembelian As tmp
											WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser'
											ORDER BY barang.kd_barang ";
									$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
									$nomor=0;  
									while($tmpData = mysql_fetch_array($tmpQry)) {
										$nomor++;
										$id			= $tmpData['id'];
										$hargaDiskon= $tmpData['harga'] - ( $tmpData['harga'] * $tmpData['diskon']/100);
										$subSotal 	= $tmpData['jumlah'] * $hargaDiskon ;
										$totalBayar	= $totalBayar + $subSotal;
										$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
									?>
									    <tr>
									      <td><?php echo $nomor; ?></td>
									      <td><?php echo $tmpData['kd_barang']; ?></b></td>
									      <td><?php echo $tmpData['nm_barang']; ?></td>
									      <td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
									      <td align="right"><?php echo $tmpData['diskon']; ?></td>
									      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
									      <td align="right"><?php echo format_angka($subSotal); ?></td>
									      <td><a href="?Aksi=Delete&id=<?php echo $id; ?>" target="_self" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a></td>
									    </tr>
									<?php } ?>
									    <tr>
									      <td colspan="5" align="right" ><strong>GRAND TOTAL BELANJA  (Rp.) : </strong></td>
									      <td align="right" ><b><?php echo $jumlahbarang; ?></b></td>
									      <td align="right" ><b><?php echo format_angka($totalBayar); ?></b></td>
									      <td >&nbsp;</td>
									    </tr>
									    <tr>
									      <td colspan="5" align="right" ><strong>DP (Rp.) : </strong></td>
									      <td align="right" ><b>&nbsp;</b></td>
									      <td align="right" ><b><input type="text" name="dp" value="0" class="form-control"></b></td>
									      <td >&nbsp;</td>
									    </tr>
									    <tr>
									    	<td colspan="6">&nbsp;</td>
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
