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
	$txtHarga		= $_POST['txtHarga'];
	$txtDisc		= $_POST['txtDisc'];
	$txtJumlah		= $_POST['txtJumlah'];
	$cmbPelanggan	= $_POST['cmbPelanggan'];

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
	if (trim($txtDisc)=="" or ! is_numeric(trim($txtDisc))) {
		$pesanError[] = "Data <b>Disc (%) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	if (trim($txtJumlah)=="" or ! is_numeric(trim($txtJumlah))) {
		$pesanError[] = "Data <b>Jumlah Barang (Qty) belum diisi</b>, silahkan <b>isi dengan angka</b> !";		
	}
	
	# Cek Stok, jika stok Opname (stok bisa dijual) < kurang dari Jumlah yang dibeli, maka buat Pesan Error
	$cekSql	= "SELECT * FROM barang WHERE kd_barang='$txtBarcode' OR barcode ='$txtBarcode'";
	$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
	$cekRow = mysql_fetch_array($cekQry);
	if ($cekRow['stok'] <= 0 AND $cekRow['stok_opname'] <= 0) {
		$pesanError[] = "Jumlah <b>Stok</b> Barang tidak mencukupi, tidak dapat dijual!";
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
			if ($cmbPelanggan == "P001") {
				$harga_msk		= $myData['harga_jual'];
			}
			else {
				$harga_msk		= $myData['harga_member'];
			}
			
			$diskon_msk		= $myData['diskon'];

			# Jika sudah pernah dipilih, cukup datanya di update jumlahnya			
			$cekSql ="SELECT * FROM tmp_penjualan WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
			$cekQry = mysql_query($cekSql, $koneksidb) or die ("Gagal Query".mysql_error());
			if(mysql_num_rows($cekQry) >= 1) {
				// Jika tadi sudah dipilih, cukup jumlahnya diupdate
				$tmpSql = "UPDATE tmp_penjualan SET harga='$harga_msk', diskon='$diskon_msk', jumlah = jumlah + $txtJumlah 
							WHERE kd_barang='$kodeBarang' AND kd_user='$kodeUser'"; 
				mysql_query($tmpSql, $koneksidb) or die ("Gagal Query : ".mysql_error());
			}
			else {
				// Jika di dalam tabel tmp belum ada, maka data diinput baru ke tmp (keranjang belanja)
				$tmpSql 	= "INSERT INTO tmp_penjualan (kd_barang, harga, jumlah, diskon, kd_user) 
								VALUES ('$kodeBarang', '$harga_msk', '$txtJumlah', '$diskon_msk', '$kodeUser')";
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

	if(trim($txtKeterangan)=="") {
		$pesanError[] = "Data <b>Keterangan</b> belum diisi !";		
	}

	if ($txtKeterangan == "Cash") {
		if(trim($txtUangBayar) < trim($txtTotBayar)) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($txtTotBayar)."</b>";		
		}
	}

	if ($cmbPelanggan == "P001") {
		if(trim($txtUangBayar) < trim($txtTotBayar)) {
		$pesanError[] = "Data <b> Uang Bayar Belum Cukup</b>.  
						 Total belanja adalah <b> Rp. ".format_angka($txtTotBayar)."</b>";		
		}
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
		echo '<div class="alert alert-danger" role="alert">';
			$noPesan=0;
			foreach ($pesanError as $indeks=>$pesan_tampil) { 
			$noPesan++;
				echo "&nbsp;&nbsp; $noPesan. $pesan_tampil<br>";	
			} 
		echo "</div> <br>"; 
	}else {
		if($txtKeterangan == "Kredit" AND $cmbPelanggan == "P001"){
		echo '<div class="alert alert-danger" role="alert">Maaf user ini tidak dapat melakukan transaksi dengan akad <b>kredit</b></div>';
		}else{
		# SIMPAN DATA KE DATABASE
		# Jika jumlah error pesanError tidak ada, maka penyimpanan dilakukan. Data dari tmp dipindah ke tabel penjualan dan penjualan_item
		$noTransaksi = buatKode("penjualan", "JL");
		$mySql	= "INSERT INTO penjualan (no_penjualan, tgl_penjualan, kd_pelanggan, keterangan, uang_bayar, kd_user) 
						VALUES ('$noTransaksi', '$txtTanggal', '$cmbPelanggan', '$txtKeterangan', '$txtUangBayar', '$kodeUser')";
		mysql_query($mySql, $koneksidb) or die ("Gagal query 1".mysql_error());
		
		# …LANJUTAN, SIMPAN DATA
		# Ambil semua data barang yang dipilih, berdasarkan user yg login
		$tmpSql ="SELECT barang.harga_beli, tmp.* FROM barang, tmp_penjualan As tmp
					WHERE barang.kd_barang = tmp.kd_barang AND tmp.kd_user='$kodeUser'";
		$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
		while ($tmpData = mysql_fetch_array($tmpQry)) {
			// Baca data dari tabel barang dan jumlah yang dibeli dari TMP
			$dataKode 		= $tmpData['kd_barang'];
			$dataSn 		= $tmpData['sn'];
			$dataHrgModal	= $tmpData['harga_beli']; // dari tabel barang
			$dataHrgJual	= $tmpData['harga'];       // Dari tabel tmp
			$dataDiskon		= $tmpData['diskon'];      // dari tabel tmp
			$dataJumlah		= $tmpData['jumlah'];      // dari tabel tmp
			
			// MEMINDAH DATA, Masukkan semua data di atas dari tabel TMP ke tabel ITEM
			$itemSql = "INSERT INTO penjualan_item (no_penjualan, kd_barang, sn, harga_beli, harga_jual, diskon, jumlah) 
						VALUES ('$noTransaksi', '$dataKode', '$dataSn', '$dataHrgModal', '$dataHrgJual', '$dataDiskon', '$dataJumlah') ";
			mysql_query($itemSql, $koneksidb) or die ("Gagal Query 2".mysql_error());
			
			$noSql = mysql_query("SELECT * FROM barang WHERE kd_barang='$dataKode'");
			$rs = mysql_fetch_array($noSql);
			if ($rs['stok'] > 0) {
				// Skrip Update stok
				$stokSql = "UPDATE barang SET stok = stok - $dataJumlah WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}else{
				$stokSql = "UPDATE barang SET stok_opname = stok_opname - $dataJumlah WHERE kd_barang='$dataKode'";
				mysql_query($stokSql, $koneksidb) or die ("Gagal Query Edit Stok".mysql_error());
			}
		}
		
		# Kosongkan Tmp jika datanya sudah dipindah
		$hapusSql = "DELETE FROM tmp_penjualan WHERE kd_user='$kodeUser'";
		mysql_query($hapusSql, $koneksidb) or die ("Gagal kosongkan tmp".mysql_error());
		
		//Refresh form
		//echo "<meta http-equiv='refresh' content='0; url=penjualan_nota.php?noNota=$noTransaksi'>";
		$query_ambil = mysql_query("SELECT penjualan.*, user.nm_user,pelanggan.nm_pelanggan FROM penjualan
        LEFT JOIN user ON penjualan.kd_user=user.kd_user 
        LEFT JOIN pelanggan ON penjualan.kd_pelanggan = pelanggan.kd_pelanggan
        WHERE no_penjualan='$noTransaksi'");

        $data_ambil = mysql_fetch_array($query_ambil);
        $total_musti_bayar = $data_ambil['uang_bayar'];

        # Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
	  $notaSql = "SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
      LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
      WHERE penjualan_item.no_penjualan='$noTransaksi'
      ORDER BY barang.kd_barang ASC";
		$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list salah : ".mysql_error());
		$nomor  = 0;  
		while($notaData = mysql_fetch_array($notaQry)) {
		  $nomor++;
		  $hargaDiskon  = $notaData['harga_jual'] - ( $notaData['harga_jual'] * $notaData['diskon']/100);
		  $subSotal   = $notaData['jumlah'] * $hargaDiskon;
		  $totalBayar = $totalBayar + $subSotal;
		  $jumlahBarang = $jumlahBarang + $notaData['jumlah'];
		  $uangKembali = $total_musti_bayar - $totalBayar;
		}
		echo "<script>";
		echo "window.open('penjualan_nota.php?noNota=$noTransaksi')";
	//	echo "jQuery('#bukatutupa').show();
	//		  jQuery('#bukatutupb').hide();
	//		  jQuery('#kembalian').val(".$uangKembali.");
	//		  ";//set atribut btn print
		echo "</script>";
		}
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
	$bacaSql ="SELECT barang.* FROM barang WHERE kd_barang='$txtBarcode' OR barcode ='$txtBarcode'"; 
	$bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	if(mysql_num_rows($bacaQry) >= 1) {	
		$bacaData = mysql_fetch_array($bacaQry);

		// Membaca kode barang/ produk
		$kodeBarcode	= $bacaData['barcode'];
		$hargaJual		= $bacaData['harga_jual'];
		$hargaA			= $bacaData['harga_member'];
		$diskonJual		= $bacaData['diskon'];
		$namaBarang		= $bacaData['nm_barang'];
	}
	else {
		$kodeBarcode	= "";
		$hargaJual		= "";
		$hargaA			= "";
		$diskonJual		= "";
		$namaBarang		= "";
	}
}
else {
	$kodeBarcode	= "";
	$hargaJual		= "";
	$hargaA			= "";
	$diskonJual		= "";
	$namaBarang		= "";
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

function tutup() {
	jQuery('#bukatutupa').hide();
	jQuery('#bukatutupb').show();
}

			  
</SCRIPT>
<body onload="tutup()"></body>
<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Penjualan Barang</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										<li class="active-page">Penjualan Baru</li>
										<li><a href="?open=Penjualan-Tampil">Tampil Penjualan</a> </li>
										<li><a href="?open=Penjualan-Barcode">Tampil Penjualan Barcode</a></li>
										<li><a href="?open=Penjualan-Kasir">Tampil Penjualan per Kasir</a></li>
									</ul>
								</div>
							</div>
						</div>
				</div>
</div>

<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" class="form-horizontal" name="form1" target="_self">

<div class="col-md-4">
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
											<div class="col-lg-8">
												<input name="txtBarcode" autofocus id="txtBarcode" size="30" class="form-control" maxlength="20" value="<?php echo $kodeBarcode; ?>" onchange="javascript:ea();" />											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Nama Barang</label>
											<div class="col-lg-6">
												<input name="txtNama" id="txtNama" size="80" class="form-control" maxlength="200" value="<?php echo $namaBarang; ?>" readonly="readonly"/>											</div>
										<div class="col-lg-2">
											<a href="../?open=Cari-Barang-Penjualan&popup=yes" 
        onclick="javascript:void window.open('../?open=Cari-Barang-Penjualan&popup=yes','1444475672556','width=700,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=1,resizable=1,left=0,top=0');return false;"><b>Cari Barang</b></a>
										</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Harga Jual (Rp)</label>
											<div class="col-lg-8">
												<input name="txtHarga" id="txtHarga" size="20" maxlength="12" class="form-control" value="<?php echo $hargaJual; ?>" readonly="readonly"/>											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Harga Anggota (Rp)</label>
											<div class="col-lg-8">
												<input name="txtHargaA" id="txtHargaA" size="20" maxlength="12" class="form-control" value="<?php echo $hargaA; ?>" readonly="readonly"/>											</div>
										</div>
										
										<div class="form-group">
											<label class="col-lg-4 control-label">Disc(%)</label>
											<div class="col-lg-8">
												<input name="txtDisc" id="txtDisc" size="4" maxlength="4" class="form-control" value="<?php if (empty($diskonJual)) {
													echo "0";
												}else{echo $diskonJual;}  ?>" />											</div>
										</div>

										<div class="form-group">
											<label class="col-lg-4 control-label">Jumlah</label>
											<div class="col-lg-4">
												<input name="txtJumlah" size="4" class="form-control" maxlength="4" value="1" 
												 onblur="if (value == '') {value = '1'}" 
												 onfocus="if (value == '1') {value =''}"/>
												</div>
											<div class="col-lg-2"><input name="btnTambah" type="submit" style="cursor:pointer;" class="btn btn-success" value=" Tambah " /></div>
										</div>

								</div>
							</div>
						</div>
					</div>

					<div class="col-md-8">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-list-ul"></i></span>
								<h4>Daftar Barang</h4>
							</div>
							<div class="widget-container">
								<div class=" widget-block">
  <table class="table table-striped table-responsive" id="tableBarang" width="985" border="0" cellspacing="1" cellpadding="2" style="margin-top:-15px;">
    <tr>
      <td width="28" ><strong>No</strong></td>
      <td width="68" ><strong>Kode</strong></td>
      <td colspan="4" width="415" ><strong>Item </strong></td>
      <td width="95" align="right" ><strong>Harga (Rp) </strong></td>
      <td width="56" align="right" ><strong>Disc(%)</strong></td>
      <td width="48" align="right" ><strong>Jumlah</strong></td>
      <td width="170" align="right" ><strong>SubTotal(Rp) </strong></td>
      <td width="39" align="center" >&nbsp;</td>
    </tr>
<?php
// deklarasi variabel
$hargaDiskon= 0; 
$totalBayar	= 0; 
$jumlahbarang	= 0;

// Qury menampilkan data dalam Grid TMP_Penjualan 
$tmpSql ="SELECT barang.nm_barang, tmp.* 
		FROM barang, tmp_penjualan As tmp
		WHERE barang.kd_barang=tmp.kd_barang AND tmp.kd_user='$kodeUser'
		ORDER BY barang.kd_barang ";
$tmpQry = mysql_query($tmpSql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
$nomor=0;  
while($tmpData = mysql_fetch_array($tmpQry)) {
	$nomor++;
	$id				= $tmpData['id'];
	$hargaDiskon	= $tmpData['harga'] - ( $tmpData['harga'] * $tmpData['diskon']/100);
	$subSotal 		= $tmpData['jumlah'] * $hargaDiskon;
	$totalBayar		= $totalBayar + $subSotal;
	$jumlahbarang	= $jumlahbarang + $tmpData['jumlah'];
?>
    <tr>
      <td><?php echo $nomor; ?></td>
      <td><?php echo $tmpData['kd_barang']; ?></b></td>
      <td colspan="4"><?php echo $tmpData['nm_barang']; ?></td>
      <td align="right"><?php echo format_angka($tmpData['harga']); ?></td>
      <td align="right"><?php echo $tmpData['diskon']; ?></td>
      <td align="right"><?php echo $tmpData['jumlah']; ?></td>
      <td align="right"><?php echo format_angka($subSotal); ?></td>
      <td><a href="?open=Penjualan-Baru&Aksi=Delete&id=<?php echo $id; ?>" target="_self" class="btn btn-sm btn-danger"> <i class="fa fa-trash"></i> </a></td>
    </tr>
<?php } ?>
    <tr>
      <td colspan="7" align="right" ><strong>GRAND TOTAL BELANJA  (Rp.) : </strong></td>
      <td align="right">&nbsp;</td>
      <td align="right" ><b><?php echo $jumlahbarang; ?></b></td>
      <td align="right" ><b><?php echo format_angka($totalBayar); ?></b></td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="7" align="right" bgcolor="#F5F5F5"><strong>UANG BAYAR (Rp.) : </strong></td>
      <td colspan="2" bgcolor="#F5F5F5"><div class="col-md-4"><input name="txtTotBayar" class="form-control" type="hidden" value="<?php echo $totalBayar; ?>" /></div></td>
      <td bgcolor="#F5F5F5"><div class="col-md-12"><input autocomplete="off" name="txtUangBayar" class="form-control" value="<?php echo $dataUangBayar; ?>" size="18" maxlength="12"/></div></td>
      <td bgcolor="#F5F5F5">&nbsp;</td>
    </tr>
    <tr>
      <td colspan="11" align="right">
          <input name="btnSimpan" id="btnSimpan" class="btn btn-primary" type="submit" style="cursor:pointer;" value=" SIMPAN TRANSAKSI " />
      
      </td>
    </tr>
  </table>
</div>
</div>
</div>
</div>


					<div class="col-md-12">
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
												<input name="txtNomor" value="<?php echo $noTransaksi; ?>" class="form-control" size="20" maxlength="20" readonly="readonly"/>
											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Tgl. Penjualan</label>
											<div class="col-lg-8">
												<input name="txtTanggal" class="form-control" type="text" class="tcal" value="<?php echo $tglTransaksi; ?>" size="17" maxlength="20" />											</div>
										</div>
										<div class="form-group">
											<label class="col-lg-4 control-label">Pelanggan</label>
											<div class="col-lg-6">
												<select name="cmbPelanggan" id="cmbPelanggan" class="form-control select2" onchange="edit_harga()">
        <option value="Kosong">....</option>
        <?php
	  $bacaSql = "SELECT * FROM pelanggan ORDER BY kd_pelanggan";
	  $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
	  while ($bacaData = mysql_fetch_array($bacaQry)) {
		if ($bacaData['kd_pelanggan'] == $dataPelanggan) {
			$cek = " selected";
		} else { $cek=""; }
		$code = $bacaData['no_anggota']." - ";
		echo "<option value='$bacaData[kd_pelanggan]' $cek>$code $bacaData[nm_pelanggan]</option>";
	  }
	  ?>
      </select>
											</div>
											<div class="col-lg-2">
												<a href="../?open=Pelanggan-Add&popup=yes" onclick="javascript:void window.open('../?open=Pelanggan-Add&popup=yes','1444475531021','width=700,height=500,toolbar=0,menubar=0,location=0,status=0,scrollbars=0,resizable=1,left=0,top=0');return false;"><b>Tambah Pelanggan</b></a>
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
								</div>
							</div>
						</div>
				</div>
  


</form>

<script type="text/javascript">

function insert_sn(focusedRow,kd_barang){
	var table = document.getElementById("tableBarang");
	var sn=document.getElementsByName('dynamic'+focusedRow)[0].value;
	jQuery.ajax({
		  type:"GET",
	      url:"insertSN.php",
	      data:"kd_barang="+kd_barang+"&sn="+sn,
		//dataType:"json",
	      success:function(html){
	      }
	})
}

function input(){
	(function($){
		var barcode = $("#txtBarcode1").val();
		var nama = $("#txtNama1").val();
		var sn = $("#txtSn1").val();
		var harga = $("#txtHarga1").val();
		var dis = $("#txtDisc1").val();
		var jumlah = $("#txtJumlah1").val();

   	$.ajax({
   		type:"GET",
   		url:"insert_item.php",
   		data:"barcode="+barcode+"&nama="+nama+"&sn="+sn+"&harga="+harga+"&dis="+dis+"&jumlah="+jumlah,
   		success:function(html){

   		}
   	})

	})(jQuery);
}
function edit_harga(){
	var pelanggan = document.getElementById("cmbPelanggan").value;
	$.ajax({
		type:"get",
		url:"update_harga.php",
		data:'kd_pelanggan='+pelanggan,
		success:function(html){}
	})
}

(function($){

    $('#tabel').hide();

})(jQuery);

function onloading(){
	(function($){

    $('#tabel').show(500);

})(jQuery);
}

function cancel(){
(function($){

    $('#tabel').hide(500);

})(jQuery);
}
</script>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
