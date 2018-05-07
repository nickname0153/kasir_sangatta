<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_penjualan'] == "Yes") {

# MEMBACA KASIR YANG LOGIN
$kodeUser	= $_SESSION['SES_LOGIN'];

# HAPUS DAFTAR barang DI TMP
if(isset($_GET['Aksi'])){
	$Aksi	= $_GET['Aksi'];
	$id		= $_GET['id'];
	
	if(trim($Aksi)=="Delete"){
		# Hapus Tmp jika datanya sudah dipindah
		$mySql = "DELETE FROM tmp_penjualan WHERE id='$id' AND kd_user='$kodeUser'";
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
	$txtBarcode		= $_POST['txtBarcode'];

	# Validasi Form
	$pesanError = array();
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
				
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN KE DATABASE (tmp_penjualan)	

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
			$hargaJual		= $bacaData['harga_jual'];
			$diskonJual		= $bacaData['diskon'];

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
			$cekSql ="SELECT * FROM tmp_penjualan WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_penjualan SET jumlah = jumlah + 1 WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql = "INSERT INTO tmp_penjualan (kd_barang, harga, diskon, jumlah,  kd_user) 
							VALUES ('$kodeBarang', '$hargaJual', '$diskonJual', '$txtJumlah', '$kodeUser')";
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
	$cmbPelanggan	= $_POST['cmbPelanggan'];
	$txtKeterangan	= $_POST['txtKeterangan'];
	$txtUangBayar	= $_POST['txtUangBayar'];
	$txtTotBayar	= $_POST['txtTotBayar'];
			
	# Validasi Form
	$pesanError = array();
	if(trim($txtTanggal)=="") {
		$pesanError[] = "Data <b>Tgl. Transaksi</b> belum diisi, pilih pada combo !";		
	}
	if(trim($cmbPelanggan)=="Kosong") {
		$pesanError[] = "Data <b>Nama Pelanggan</b> belum dipilih, silahkan dilengkapi !";		
	}
	if(trim($txtUangBayar)==""  or ! is_numeric(trim($txtUangBayar))) {
		$pesanError[] = "Data <b>Uang Bayar</b> belum diisi, harus berupa angka !";		
	}
	if(trim($txtUangBayar) < trim($txtTotBayar)) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($txtTotBayar)."</b>";		
	}
	
	# Periksa apakah sudah ada barang yang dimasukkan
	$tmpSql = "SELECT COUNT(*) As qty FROM tmp_penjualan WHERE kd_user='$kodeUser'";
	$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$tmpData= mysql_fetch_array($tmpQry);
	if ($tmpData['qty'] < 1) {
		$pesanError[] = "<b>DAFTAR BARANG MASIH KOSONG</b>, belum ada barang yang dimasukan, <b>minimal 1 barang</b>.";
	}
	
			
	# JIKA ADA PESAN ERROR DARI VALIDASI
	if (count($pesanError)>=1 ){
		echo "<div class='mssgBox'>";
		echo "<img src='../images/attention.png'> <br><hr>";
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}
	else {
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
		$noTransaksi = buatKode("penjualan", "JL");
		$mySql	= "INSERT INTO penjualan (no_penjualan, tgl_penjualan, pelanggan, keterangan, uang_bayar, kd_user) 
						VALUES ('$noTransaksi', '$txtTanggal', '$cmbPelanggan', '$txtKeterangan', '$txtUangBayar', '$kodeUser')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query 1".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan user yg login
		$tmpSql ="SELECT barang.harga_beli, barang.diskon, tmp.* 
					FROM barang, tmp_penjualan As tmp
					WHERE barang.kd_barang = tmp.kd_barang AND tmp.kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 		= $tmpData['kd_barang'];
			$dataHrgModal	= $tmpData['harga_beli'];
			$dataHrgJual	= $tmpData['harga_jual'];
			$dataDiskon		= $tmpData['diskon'];
			$dataJumlah		= $tmpData['jumlah'];
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO penjualan_item (no_penjualan, kd_barang, harga_beli, harga_jual, diskon, jumlah) 
						VALUES ('$noTransaksi', '$dataKode', '$dataHrgModal', '$dataHrgJual', '$dataDiskon', '$dataJumlah') ";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query 2".mysql_error());
			
			// Skrip Update stok
			$stokSql = "UPDATE barang SET stok = stok - $dataJumlah WHERE kd_barang='$dataKode'";
			mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		// Refresh form
		//echo "<meta http-equiv='refresh' content='0; url=penjualan_nota.php?noNota=$noTransaksi'>";
		echo "<script>";
		echo "window.open('penjualan_nota.php?noNota=$noTransaksi', width=330,height=330,left=100, top=25)";
		echo "</script>";

	}	
}

# PADA SAAT ADA KODE PLU/ BARCODE DIINPUT DENGAN BARCODE SCANNER, ATAU KOPI PASTE (LALU KURSOR PINDAH TEMPAT)
if(isset($_POST['txtBarcode'])){
	# Baca Variabel from
	$txtBarcode	= $_POST['txtBarcode'];

	// Membaca data barang
	$bacaSql ="SELECT * FROM barang WHERE stok >=1 AND ( kd_barang='$txtBarcode' OR barcode ='$txtBarcode' )"; 
	$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($bacaQry) >= 1) {	
		$bacaData = mysql_fetch_array($bacaQry);

		// Membaca kode barang/ produk
		$kodeBarang		= $bacaData['kd_barang'];
		$kodeBarcode	= $bacaData['barcode'];
		$hargaJual		= $bacaData['harga_jual'];
		$diskonJual		= $bacaData['diskon'];

		// Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
		$cekSql ="SELECT * FROM tmp_penjualan WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
		$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query Select : ".mysql_error());
		if(mysql_num_rows($cekQry) >= 1) {
			// Jika tadi sudah dipilih, cukup jumlahnya di-update
			$tmpSql = "UPDATE tmp_penjualan SET jumlah = jumlah + 1 WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Update : ".mysql_error());
		}
		else {
			// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
			$tmpSql = "INSERT INTO tmp_penjualan (kd_barang, harga, diskon, jumlah,  kd_user) 
						VALUES ('$kodeBarang', '$hargaJual', '$diskonJual', 1, '$kodeUser')";
			mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Insert : ".mysql_error());
		}
	}
}

# TAMPILKAN DATA KE FORM
$noTransaksi 	= buatKode("penjualan", "JL");
$tglTransaksi 	= isset($_POST['txtTanggal']) ? $_POST['txtTanggal'] : date('d-m-Y');
$dataPelanggan	= isset($_POST['cmbPelanggan']) ? $_POST['cmbPelanggan'] : 'P001';
$dataKeterangan	= isset($_POST['txtKeterangan']) ? $_POST['txtKeterangan'] : '';
$dataUangBayar	= isset($_POST['txtUangBayar']) ? $_POST['txtUangBayar'] : '';
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
									<h2 class="breadcrumb-titles">Penjualan Barang</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										<li ><a href="?open=Penjualan-Baru">Penjualan Baru</a></li>
										<li><a href="?open=Penjualan-Tampil">Tampil Penjualan</a> </li>
										<li class="active-page">Tampil Penjualan Barcode</li>
										<li><a href="?open=Penjualan-Kasir">Tampil Penjualan per Kasir</a></li>
									</ul>
									</ul>
								</div>
							</div>
						</div>
				</div>
</div>
<form class="form-horizontal" action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
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
											<label class="col-lg-4 control-label">No. Penjualan</label>
											<div class="col-lg-8">
												<input name="txtNomor" value="<?php echo $noTransaksi; ?>" class="form-control" size="23" maxlength="20" readonly="readonly"/>					
											</div>
									</div>

									<div class="form-group">
											<label class="col-lg-4 control-label">Tgl. Penjualan</label>
											<div class="col-lg-8">
												<input name="txtTanggal" type="text" class="form-control" value="<?php echo $tglTransaksi; ?>" size="20" maxlength="20" />					
											</div>
									</div>

									<div class="form-group">
											<label class="col-lg-4 control-label">Pelanggan</label>
											<div class="col-lg-8">
												<select name="cmbPelanggan" class="form-control select2">
										        <option value="Kosong">....</option>
										        <?php
											  $bacaSql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan";
											  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
											  while ($bacaData = mysql_fetch_array($bacaQry)) {
												if ($bacaData['kd_pelanggan'] == $dataPelanggan) {
													$cek = " selected";
												} else { $cek=""; }
												echo "<option value='$bacaData[kd_pelanggan]' $cek>$bacaData[nm_pelanggan]</option>";
											  }
											  ?>
										      </select>			
											</div>
									</div>

									<div class="form-group">
											<label class="col-lg-4 control-label">Keterangan</label>
											<div class="col-lg-8">
													<input name="txtKeterangan" value="<?php echo $dataKeterangan; ?>" class="form-control" size="60" maxlength="100" />					
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
								<div class="widget-block">
									<div class="form-group">
											<label class="col-lg-4 control-label">Barcode / PLU</label>
											<div class="col-lg-6">
												<input name="txtBarcode" class="form-control" id="txtBarcode" size="30" maxlength="20" onchange="javascript:submitform();" />
											</div>
											<div class="col-lg-2">
												<input name="btnTambah" class="btn btn-success btn-sm" type="submit" style="cursor:pointer;" value=" Tambah " />
											</div>
										</div>
							</div>
							</div>
						</div>
				</div>

<div class="row">
					<div class="col-md-12">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-bars"></i></span>
								<h4>Data</h4>
								<ul class="widget-action-bar pull-right">
								
									<li><span class="widget-collapse waves-effect w-collapse"><i class="fa fa-angle-down"></i></span>
									</li>
									
									<li>
									<div class="widget-check">
										<input class="w-i-check" type="checkbox" checked>
									</div>
									</li>
									<li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
									</li>
								</ul>
							</div>
							<div class="widget-container">
								<div class="widget-block">
  <table class="table table-striped table-responsive" width="800" border="0" cellspacing="1" cellpadding="2" style="margin-top: -15px;">
    <tr>
      <td width="27" bgcolor="#F5F5F5"><strong>No</strong></td>
      <td width="65" bgcolor="#F5F5F5"><strong>Kode</strong></td>
      <td width="403" bgcolor="#F5F5F5"><strong>Nama Barang </strong></td>
      <td width="80" align="right" bgcolor="#F5F5F5"><strong>Harga (Rp) </strong></td>
      <td width="48" align="right" bgcolor="#F5F5F5"><strong>Jumlah</strong></td>
      <td width="99" align="right" bgcolor="#F5F5F5"><strong>Sub Total(Rp) </strong></td>
      <td width="42" align="center" bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
<?php
// deklarasi variabel
$hargaDiskon= 0; 
$totalBayar	= 0; 
$jumlahbarang	= 0;

// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT barang.nm_barang, barang.harga_jual, barang.diskon, tmp.* 
		FROM barang, tmp_penjualan As tmp
		WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id				= $tmpData['id'];
	$hargaDiskon	= $tmpData['harga_jual'] - ( $tmpData['harga_jual'] * $tmpData['diskon']/100);
	$subSotal 		= $tmpData['jumlah'] * $hargaDiskon;
	$totalBayar		= $totalBayar + $subSotal;
	$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td><?php echo $tmpData['nm_barang']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga_jual']); ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?open=Penjualan-Barcode&Aksi=Delete&id=<?php echo $id; ?>" target="_self">Delete</a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="4" align="right" ><strong>GRAND TOTAL BELANJA  (Rp.) : </strong></td>
      <td align="right" ><b><?php echo $jumlahbarang; ?></b></td>
      <td align="right" ><b><?php echo format_angka($totalBayar); ?></b></td>
      <td >&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="right" bgcolor="#F5F5F5"><strong>UANG BAYAR (Rp.) : </strong></td>
      <td bgcolor="#F5F5F5"><input name="txtTotBayar" type="hidden" value="<?php echo $totalBayar; ?>" /></td>
      <td bgcolor="#F5F5F5"><input name="txtUangBayar" class="form-control" value="<?php echo $dataUangBayar; ?>" size="16" maxlength="12"/></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="6" align="right"><div class="col-md-16"><input name="btnSimpan" type="submit" class="btn btn-primary" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " /></div></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
								</div>
							</div>
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
