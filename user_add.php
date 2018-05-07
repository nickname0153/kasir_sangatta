<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_user'] == "Yes") {

# SKRIP SAAT TOMBOL SIMPAN DIKLIK
if(isset($_POST['btnSimpan'])){
	# BACA DATA DALAM FORM, masukkan datake variabel
	$txtNama		= $_POST['txtNama'];
	$txtNoTelepon	= $_POST['txtNoTelepon'];
	$txtUsername	= $_POST['txtUsername'];
	$txtPassword	= $_POST['txtPassword'];
	$cmbLevel		= $_POST['cmbLevel'];

	
	// Membaca Form Hak Akses
	$rbDataUser			=  $_POST['rbDataUser'];
	$rbDataPelanggan	=  $_POST['rbDataPelanggan'];
	$rbDataSupplier		=  $_POST['rbDataSupplier'];
	$rbDataMerek		=  $_POST['rbDataMerek'];
	$rbDataKategori		=  $_POST['rbDataKategori'];
	$rbDataKategoriSub	=  $_POST['rbDataKategoriSub'];
	$rbDataJenis		=  $_POST['rbDataJenis'];
	$rbDataBarang		=  $_POST['rbDataBarang'];
	$Header				=  $_POST['HeaderLogo'];
	$rbLapStokBarang	=  $_POST['rbLapStokBarang'];
	$rbCetakBarcode		=  $_POST['rbCetakBarcode'];
	$rbPembelian		=  $_POST['rbPembelian'];
	$rbReturbeli		=  $_POST['rbReturbeli'];
	$rbReturjual		=  $_POST['rbReturjual'];
	$rbPenjualan		=  $_POST['rbPenjualan'];
	$rbLapUser			=  $_POST['rbLapUser'];
	$rbLapPelanggan		=  $_POST['rbLapPelanggan'];
	$rbLapSupplier		=  $_POST['rbLapSupplier'];
	$rbLapMerek			=  $_POST['rbLapMerek'];
	$rbLapKategori		=  $_POST['rbLapKategori'];
	$rbLapKategoriSub	=  $_POST['rbLapKategoriSub'];
	$rbLapJenis			=  $_POST['rbLapJenis'];
	$rbLapBarangMerek	=  $_POST['rbLapBarangMerek'];
	$rbLapBarangKategori		=  $_POST['rbLapBarangKategori'];
	$rbLapBarangKategoriSub		=  $_POST['rbLapBarangKategoriSub'];
	
	$rbLapPembelianPeriode		=  $_POST['rbLapPembelianPeriode'];
	$rbLapPembelianBulan		=  $_POST['rbLapPembelianBulan'];
	$rbLapPembelianSupplier		=  $_POST['rbLapPembelianSupplier'];
	$rbLapPembelianBarangPeriode=  $_POST['rbLapPembelianBarangPeriode'];
	$rbLapPembelianBarangBulan	=  $_POST['rbLapPembelianBarangBulan'];
	$rbLapPembelianRekapPeriode	=  $_POST['rbLapPembelianRekapPeriode'];
	$rbLapPembelianRekapBulan	=  $_POST['rbLapPembelianRekapBulan'];
	
	$rbLapReturbeliPeriode		=  $_POST['rbLapReturbeliPeriode'];
	$rbLapReturbeliBulan		=  $_POST['rbLapReturbeliBulan'];
	$rbLapReturbeliBarangPeriode=  $_POST['rbLapReturbeliBarangPeriode'];
	$rbLapReturbeliBarangBulan	=  $_POST['rbLapReturbeliBarangBulan'];
	$rbLapReturbeliRekapPeriode	=  $_POST['rbLapReturbeliRekapPeriode'];
	$rbLapReturbeliRekapBulan	=  $_POST['rbLapReturbeliRekapBulan'];
	
	$rbLapPenjualanPeriode		=  $_POST['rbLapPenjualanPeriode'];
	$rbLapPenjualanBulan		=  $_POST['rbLapPenjualanBulan'];
	$rbLapPenjualanBarangPeriode=  $_POST['rbLapPenjualanBarangPeriode'];
	$rbLapPenjualanBarangBulan	=  $_POST['rbLapPenjualanBarangBulan'];
	$rbLapPenjualanRekapPeriode	=  $_POST['rbLapPenjualanRekapPeriode'];
	$rbLapPenjualanRekapBulan	=  $_POST['rbLapPenjualanRekapBulan'];
	
	$rbLapPenjualanTerlaris		=  $_POST['rbLapPenjualanTerlaris'];
	
	# VALIDASI FORM, jika ada kotak yang kosong, buat pesan error ke dalam kotak $pesanError
	$pesanError = array();
	if (trim($txtNama)=="") {
		$pesanError[] = "Data <b>Nama User</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtNoTelepon)=="") {
		$pesanError[] = "Data <b>No. Telepon</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtUsername)=="") {
		$pesanError[] = "Data <b>Username</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($txtPassword)=="") {
		$pesanError[] = "Data <b>Password</b> tidak boleh kosong, silahkan diisi !";		
	}
	if (trim($cmbLevel)=="Kosong") {
		$pesanError[] = "Data <b>Level</b> belum ada yang dipilih !";		
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
		$kodeBaru	= buatKode("user", "U");
		$mySql  	= "INSERT INTO user (kd_user, nm_user, no_telepon, username, password, level)
						VALUES ('$kodeBaru', '$txtNama', '$txtNoTelepon',
								'$txtUsername', MD5('$txtPassword'), '$cmbLevel')";
		$myQry=mysql_query($mySql, $koneksidb) or die ("Gagal query".mysql_error());
		if($myQry){
			// Input Hak Akses
			$my2Sql  = "INSERT INTO hak_akses SET 
							mu_data_user = '$rbDataUser', 
							mu_data_supplier = '$rbDataSupplier', 
							mu_data_merek = '$rbDataMerek', 
							mu_data_pelanggan = '$rbDataPelanggan', 
							mu_data_kategori = '$rbDataKategori', 
							mu_data_kategorisub = '$rbDataKategoriSub', 
							mu_data_jenis = '$rbDataJenis', 
							mu_data_barang = '$rbDataBarang', 
							mu_pencarian = 'Yes', 
							mu_barcode = '$rbCetakBarcode', 
							mu_trans_pembelian = '$rbPembelian', 
							mu_trans_returbeli = '$rbReturbeli', 
							mu_trans_returjual = '$rbReturjual', 
							mu_trans_penjualan = '$rbPenjualan', 
							mu_laporan = 'Yes', 
							mlap_user = '$rbLapUser', 
							mlap_supplier = '$rbLapSupplier', 
							mlap_pelanggan = '$rbLapPelanggan', 
							mlap_merek = '$rbLapMerek', 
							mlap_kategori = '$rbLapKategori', 
							mlap_kategorisub = '$rbLapKategoriSub', 
							mlap_jenis = '$rbLapJenis', 
							mlap_barang_kategori = '$rbLapBarangKategori', 
							mlap_barang_kategorisub = '$rbLapBarangKategoriSub', 
							mlap_barang_merek = '$rbLapBarangMerek', 
							mlap_pembelian_periode = '$rbLapPembelianPeriode', 
							mlap_pembelian_bulan = '$rbLapPembelianBulan', 
							mlap_pembelian_supplier = '$rbLapPembelianSupplier', 
							mlap_pembelian_barang_periode = '$rbLapPembelianBarangPeriode', 
							mlap_pembelian_barang_bulan = '$rbLapPembelianBarangBulan', 
							mlap_pembelian_rekap_periode = '$rbLapPembelianRekapPeriode', 
							mlap_pembelian_rekap_bulan = '$rbLapPembelianRekapBulan',
							mlap_returbeli_periode = '$rbLapReturbeliPeriode',
							mlap_returbeli_bulan = '$rbLapReturbeliBulan',
							mlap_returbeli_barang_periode = '$rbLapReturbeliBarangPeriode',
							mlap_returbeli_barang_bulan = '$rbLapReturbeliBarangBulan',
							mlap_returbeli_rekap_periode = '$rbLapReturbeliRekapPeriode',
							mlap_returbeli_rekap_bulan = '$rbLapReturbeliRekapBulan',
							mlap_penjualan_periode = '$rbLapPenjualanPeriode',
							mlap_penjualan_bulan = '$rbLapPenjualanBulan',
							mlap_penjualan_barang_periode = '$rbLapPenjualanBarangPeriode',
							mlap_penjualan_barang_bulan = '$rbLapPenjualanBarangBulan',
							mlap_penjualan_rekap_periode = '$rbLapPenjualanRekapPeriode',
							mlap_penjualan_rekap_bulan = '$rbLapPenjualanRekapBulan',
							mlap_penjualan_terlaris = '$rbLapPenjualanTerlaris',
							mu_header = '$Header',
							mlap_stok_barang = '$rbLapStokBarang',
							kd_user='$kodeBaru'";
			mysql_query($my2Sql, $koneksidb) or die ("Gagal query 2 ".mysql_error());

			echo "<meta http-equiv='refresh' content='0; url=?open=User-Data'>";
		}
		exit;
	}	
} // Penutup POST

# MASUKKAN DATA KE VARIABEL
// Supaya saat ada pesan error, data di dalam form tidak hilang. Jadi, tinggal meneruskan/memperbaiki yg salah
$dataKode		= buatKode("user", "U");
$dataNama		= isset($_POST['txtNama']) ? $_POST['txtNama'] : '';
$dataNoTelepon	= isset($_POST['txtNoTelepon']) ? $_POST['txtNoTelepon'] : '';
$dataUsername	= isset($_POST['txtUsername']) ? $_POST['txtUsername'] : '';
$dataPassword	= isset($_POST['txtPassword']) ? $_POST['txtPassword'] : '';
$dataLevel	 	= isset($_POST['cmbLevel']) ? $_POST['cmbLevel'] : '';

// Data Hak Akses
$dataUser	   	= isset($_POST['rbDataUser']) ? $_POST['rbDataUser'] : 'No';
	if($dataUser =="No") { $pilihUserN = "checked"; $pilihUserY = ""; } else { $pilihUserN = ""; $pilihUserY = "checked"; }

$dataPelanggan 	= isset($_POST['rbDataPelanggan']) ? $_POST['rbDataPelanggan'] : 'No';
	if($dataPelanggan =="No") { $pilihPelangganN = "checked"; $pilihPelangganY = ""; } else { $pilihPelangganN = ""; $pilihPelangganY = "checked"; }

$dataSupplier 	= isset($_POST['rbDataSupplier']) ? $_POST['rbDataSupplier'] : 'No';
	if($dataSupplier =="No") { $pilihSupplierN = "checked"; $pilihSupplierY = ""; } else { $pilihSupplierN = ""; $pilihSupplierY = "checked"; }

$dataMerek 		= isset($_POST['rbDataMerek']) ? $_POST['rbDataMerek'] : 'No';
	if($dataMerek =="No") { $pilihMerekN = "checked"; $pilihMerekY = ""; } else { $pilihMerekN = ""; $pilihMerekY = "checked"; }

$dataKategori 		= isset($_POST['rbDataKategori']) ? $_POST['rbDataKategori'] : 'No';
	if($dataKategori =="No") { $pilihKategoriN = "checked"; $pilihKategoriY = ""; } else { $pilihKategoriN = ""; $pilihKategoriY = "checked"; }

$dataKategoriSub 		= isset($_POST['rbDataKategoriSub']) ? $_POST['rbDataKategoriSub'] : 'No';
	if($dataKategoriSub =="No") { $pilihKategoriSubN = "checked"; $pilihKategoriSubY = ""; } else { $pilihKategoriSubN = ""; $pilihKategoriSubY = "checked"; }

$dataJenis 		= isset($_POST['rbDataJenis']) ? $_POST['rbDataJenis'] :'No';
	if($dataJenis =="No") { $pilihJenisN = "checked"; $pilihJenisY = ""; } else { $pilihJenisN = ""; $pilihJenisY = "checked"; }

$dataBarang 		= isset($_POST['rbDataBarang']) ? $_POST['rbDataBarang'] : 'No';
	if($dataBarang =="No") { $pilihBarangN = "checked"; $pilihBarangY = ""; } else { $pilihBarangN = ""; $pilihBarangY = "checked"; }

	$Header 		= isset($_POST['HeaderLogo']) ? $_POST['HeaderLogo'] : 'No';
		if($Header =="No") { $HeaderLogoN = "checked"; $HeaderLogoY = ""; } else { $HeaderLogoN = ""; $HeaderLogoY = "checked"; }


$dataBarcode 		= isset($_POST['rbCetakBarcode']) ? $_POST['rbCetakBarcode'] : 'No';
	if($dataBarcode =="No") { $pilihBarcodeN = "checked"; $pilihBarcodeY = ""; } else { $pilihBarcodeN = ""; $pilihBarcodeY = "checked"; }

	
//
$dataPembelian 		= isset($_POST['rbPembelian']) ? $_POST['rbPembelian'] : 'No';
	if($dataPembelian =="No") { $pilihPembelianN = "checked"; $pilihPembelianY = ""; } else { $pilihPembelianN = ""; $pilihPembelianY = "checked"; }

$dataReturbeli 		= isset($_POST['rbReturbeli']) ? $_POST['rbReturbeli'] : 'No';
	if($dataReturbeli =="No") { $pilihReturbeliN = "checked"; $pilihReturbeliY = ""; } else { $pilihReturbeliN = ""; $pilihReturbeliY = "checked"; }

$dataReturjual 		= isset($_POST['rbReturjual']) ? $_POST['rbReturjual'] : 'No';
	if($dataReturjual =="No") { $pilihReturjualN = "checked"; $pilihReturjualY = ""; } else { $pilihReturjualN = ""; $pilihReturjualY = "checked"; }


$dataPenjualan 		= isset($_POST['rbPenjualan']) ? $_POST['rbPenjualan'] : 'No';
	if($dataPenjualan =="No") { $pilihPenjualanN = "checked"; $pilihPenjualanY = ""; } else { $pilihPenjualanN = ""; $pilihPenjualanY = "checked"; }

$lapUser 			= isset($_POST['rbLapUser']) ? $_POST['rbLapUser'] : 'No';
	if($lapUser =="No") { $pilihLapUserN = "checked"; $pilihLapUserY = ""; } else { $pilihLapUserN = ""; $pilihLapUserY = "checked"; }

$lapPelanggan 		= isset($_POST['rbLapPelanggan']) ? $_POST['rbLapPelanggan'] : 'No';
	if($lapPelanggan =="No") { $pilihLapPelangganN = "checked"; $pilihLapPelangganY = ""; } else { $pilihLapPelangganN = ""; $pilihLapPelangganY = "checked"; }

$lapSupplier 		= isset($_POST['rbLapSupplier']) ? $_POST['rbLapSupplier'] : 'No';
	if($lapSupplier =="No") { $pilihLapSupplierN = "checked"; $pilihLapSupplierY = ""; } else { $pilihLapSupplierN = ""; $pilihLapSupplierY = "checked"; }

$lapMerek 		= isset($_POST['rbLapMerek']) ? $_POST['rbLapMerek'] : 'No';
	if($lapMerek =="No") { $pilihLapMerekN = "checked"; $pilihLapMerekY = ""; } else { $pilihLapMerekN = ""; $pilihLapMerekY = "checked"; }

$lapKategori 		= isset($_POST['rbLapKategori']) ? $_POST['rbLapKategori'] : 'No';
	if($lapKategori =="No") { $pilihLapKategoriN = "checked"; $pilihLapKategoriY = ""; } else { $pilihLapKategoriN = ""; $pilihLapKategoriY = "checked"; }

$lapKategoriSub 		= isset($_POST['rbLapKategoriSub']) ? $_POST['rbLapKategoriSub'] : 'No';
	if($lapKategoriSub =="No") { $pilihLapKategoriSubN = "checked"; $pilihLapKategoriSubY = ""; } else { $pilihLapKategoriSubN = ""; $pilihLapKategoriSubY = "checked"; }

$lapJenis 		= isset($_POST['rbLapJenis']) ? $_POST['rbLapJenis'] : 'No';
	if($lapJenis =="No") { $pilihLapJenisN = "checked"; $pilihLapJenisY = ""; } else { $pilihLapJenisN = ""; $pilihLapJenisY = "checked"; }

$lapBarangMerek 		= isset($_POST['rbLapBarangMerek']) ? $_POST['rbLapBarangMerek'] : 'No';
	if($lapBarangMerek =="No") { $pilihLapBarangMerekN = "checked"; $pilihLapBarangMerekY = ""; } 
	else { $pilihLapBarangMerekN = ""; $pilihLapBarangMerekY = "checked"; }

$lapBarangKategori 		= isset($_POST['rbLapBarangKategori']) ? $_POST['rbLapBarangKategori'] : 'No';
	if($lapBarangKategori =="No") { $pilihLapBarangKategoriN = "checked"; $pilihLapBarangKategoriY = ""; } 
	else { $pilihLapBarangKategoriN = ""; $pilihLapBarangKategoriY = "checked"; }

$lapBarangKategoriSub 		= isset($_POST['rbLapBarangKategoriSub']) ? $_POST['rbLapBarangKategoriSub'] : 'No';
	if($lapBarangKategoriSub =="No") { $pilihLapBarangKategoriSubN = "checked"; $pilihLapBarangKategoriSubY = ""; } 
	else { $pilihLapBarangKategoriSubN = ""; $pilihLapBarangKategoriSubY = "checked"; }

$lapPembelianPeriode 		= isset($_POST['rbLapPembelianPeriode']) ? $_POST['rbLapPembelianPeriode'] : 'No';
	if($lapPembelianPeriode =="No") { $pilihLapPembelianPeriodeN = "checked"; $pilihLapPembelianPeriodeY = ""; } 
	else { $pilihLapPembelianPeriodeN = ""; $pilihLapPembelianPeriodeY = "checked"; }

$lapPembelianBulan 		= isset($_POST['rbLapPembelianBulan']) ? $_POST['rbLapPembelianBulan'] : 'No';
	if($lapPembelianBulan =="No") { $pilihLapPembelianBulanN = "checked"; $pilihLapPembelianBulanY = ""; } 
	else { $pilihLapPembelianBulanN = ""; $pilihLapPembelianBulanY = "checked"; }

$lapPembelianSupplier 		= isset($_POST['rbLapPembelianSupplier']) ? $_POST['rbLapPembelianSupplier'] : 'No';
	if($lapPembelianSupplier =="No") { $pilihLapPembelianSupplierN = "checked"; $pilihLapPembelianSupplierY = ""; } 
	else { $pilihLapPembelianSupplierN = ""; $pilihLapPembelianSupplierY = "checked"; }

$lapPembelianBarangPeriode 		= isset($_POST['rbLapPembelianBarangPeriode']) ? $_POST['rbLapPembelianBarangPeriode'] : 'No';
	if($lapPembelianBarangPeriode =="No") { $pilihLapPembelianBarangPeriodeN = "checked"; $pilihLapPembelianBarangPeriodeY = ""; } 
	else { $pilihLapPembelianBarangPeriodeN = ""; $pilihLapPembelianBarangPeriodeY = "checked"; }

$lapPembelianBarangBulan 		= isset($_POST['rbLapPembelianBarangBulan']) ? $_POST['rbLapPembelianBarangBulan'] : 'No';
	if($lapPembelianBarangBulan =="No") { $pilihLapPembelianBarangBulanN = "checked"; $pilihLapPembelianBarangBulanY = ""; } 
	else { $pilihLapPembelianBarangBulanN = ""; $pilihLapPembelianBarangBulanY = "checked"; }

$lapPembelianRekapPeriode 		= isset($_POST['rbLapPembelianRekapPeriode']) ? $_POST['rbLapPembelianRekapPeriode'] : 'No';
	if($lapPembelianRekapPeriode =="No") { $pilihLapPembelianRekapPeriodeN = "checked"; $pilihLapPembelianRekapPeriodeY = ""; } 
	else { $pilihLapPembelianRekapPeriodeN = ""; $pilihLapPembelianRekapPeriodeY = "checked"; }

$lapPembelianRekapBulan 		= isset($_POST['rbLapPembelianRekapBulan']) ? $_POST['rbLapPembelianRekapBulan'] : 'No';
	if($lapPembelianRekapBulan =="No") { $pilihLapPembelianRekapBulanN = "checked"; $pilihLapPembelianRekapBulanY = ""; } 
	else { $pilihLapPembelianRekapBulanN = ""; $pilihLapPembelianRekapBulanY = "checked"; }

//

$lapReturbeliPeriode 		= isset($_POST['rbLapReturbeliPeriode']) ? $_POST['rbLapReturbeliPeriode'] : 'No';
	if($lapReturbeliPeriode =="No") { $pilihLapReturbeliPeriodeN = "checked"; $pilihLapReturbeliPeriodeY = ""; } 
	else { $pilihLapReturbeliPeriodeN = ""; $pilihLapReturbeliPeriodeY = "checked"; }

$lapReturbeliBulan 		= isset($_POST['rbLapReturbeliBulan']) ? $_POST['rbLapReturbeliBulan'] : 'No';
	if($lapReturbeliBulan =="No") { $pilihLapReturbeliBulanN = "checked"; $pilihLapReturbeliBulanY = ""; } 
	else { $pilihLapReturbeliBulanN = ""; $pilihLapReturbeliBulanY = "checked"; }

$lapReturbeliBarangPeriode 		= isset($_POST['rbLapReturbeliBarangPeriode']) ? $_POST['rbLapReturbeliBarangPeriode'] : 'No';
	if($lapReturbeliBarangPeriode =="No") { $pilihLapReturbeliBarangPeriodeN = "checked"; $pilihLapReturbeliBarangPeriodeY = ""; } 
	else { $pilihLapReturbeliBarangPeriodeN = ""; $pilihLapReturbeliBarangPeriodeY = "checked"; }

$lapReturbeliBarangBulan 		= isset($_POST['rbLapReturbeliBarangBulan']) ? $_POST['rbLapReturbeliBarangBulan'] : 'No';
	if($lapReturbeliBarangBulan =="No") { $pilihLapReturbeliBarangBulanN = "checked"; $pilihLapReturbeliBarangBulanY = ""; } 
	else { $pilihLapReturbeliBarangBulanN = ""; $pilihLapReturbeliBarangBulanY = "checked"; }

$lapReturbeliRekapPeriode 		= isset($_POST['rbLapReturbeliRekapPeriode']) ? $_POST['rbLapReturbeliRekapPeriode'] : 'No';
	if($lapReturbeliRekapPeriode =="No") { $pilihLapReturbeliRekapPeriodeN = "checked"; $pilihLapReturbeliRekapPeriodeY = ""; } 
	else { $pilihLapReturbeliRekapPeriodeN = ""; $pilihLapReturbeliRekapPeriodeY = "checked"; }

$lapReturbeliRekapBulan 		= isset($_POST['rbLapReturbeliRekapBulan']) ? $_POST['rbLapReturbeliRekapBulan'] : 'No';
	if($lapReturbeliRekapBulan =="No") { $pilihLapReturbeliRekapBulanN = "checked"; $pilihLapReturbeliRekapBulanY = ""; } 
	else { $pilihLapReturbeliRekapBulanN = ""; $pilihLapReturbeliRekapBulanY = "checked"; }
//

$lapPenjualanPeriode 		= isset($_POST['rbLapPenjualanPeriode']) ? $_POST['rbLapPenjualanPeriode'] : 'No';
	if($lapPenjualanPeriode =="No") { $pilihLapPenjualanPeriodeN = "checked"; $pilihLapPenjualanPeriodeY = ""; } 
	else { $pilihLapPenjualanPeriodeN = ""; $pilihLapPenjualanPeriodeY = "checked"; }

$lapPenjualanBulan 		= isset($_POST['rbLapPenjualanBulan']) ? $_POST['rbLapPenjualanBulan'] : 'No';
	if($lapPenjualanBulan =="No") { $pilihLapPenjualanBulanN = "checked"; $pilihLapPenjualanBulanY = ""; } 
	else { $pilihLapPenjualanBulanN = ""; $pilihLapPenjualanBulanY = "checked"; }

$lapPenjualanBarangPeriode 		= isset($_POST['rbLapPenjualanBarangPeriode']) ? $_POST['rbLapPenjualanBarangPeriode'] : 'No';
	if($lapPenjualanBarangPeriode =="No") { $pilihLapPenjualanBarangPeriodeN = "checked"; $pilihLapPenjualanBarangPeriodeY = ""; } 
	else { $pilihLapPenjualanBarangPeriodeN = ""; $pilihLapPenjualanBarangPeriodeY = "checked"; }

$lapPenjualanBarangBulan 		= isset($_POST['rbLapPenjualanBarangBulan']) ? $_POST['rbLapPenjualanBarangBulan'] : 'No';
	if($lapPenjualanBarangBulan =="No") { $pilihLapPenjualanBarangBulanN = "checked"; $pilihLapPenjualanBarangBulanY = ""; } 
	else { $pilihLapPenjualanBarangBulanN = ""; $pilihLapPenjualanBarangBulanY = "checked"; }

$lapPenjualanRekapPeriode 		= isset($_POST['rbLapPenjualanRekapPeriode']) ? $_POST['rbLapPenjualanRekapPeriode'] : 'No';
	if($lapPenjualanRekapPeriode =="No") { $pilihLapPenjualanRekapPeriodeN = "checked"; $pilihLapPenjualanRekapPeriodeY = ""; } 
	else { $pilihLapPenjualanRekapPeriodeN = ""; $pilihLapPenjualanRekapPeriodeY = "checked"; }

$lapPenjualanRekapBulan 		= isset($_POST['rbLapPenjualanRekapBulan']) ? $_POST['rbLapPenjualanRekapBulan'] : 'No';
	if($lapPenjualanRekapBulan =="No") { $pilihLapPenjualanRekapBulanN = "checked"; $pilihLapPenjualanRekapBulanY = ""; } 
	else { $pilihLapPenjualanRekapBulanN = ""; $pilihLapPenjualanRekapBulanY = "checked"; }

$lapPenjualanTerlaris 		= isset($_POST['rbLapPenjualanTerlaris']) ? $_POST['rbLapPenjualanTerlaris'] : 'No';
	if($lapPenjualanTerlaris =="No") { $pilihLapPenjualanTerlarisN = "checked"; $pilihLapPenjualanTerlarisY = ""; } 
	else { $pilihLapPenjualanTerlarisN = ""; $pilihLapPenjualanTerlarisY = "checked"; }

$LapStokBarang	=  isset($_POST['rbLapStokBarang']) ? $_POST['rbLapStokBarang'] : 'No';
	if($LapStokBarang =="No") { $rbLapStokBarangN = "checked"; $rbLapStokBarangY = ""; } 
	else { $rbLapStokBarangN = ""; $rbLapStokBarangY = "checked"; }

?>
<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Tambah Data Pengguna</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" border="0" cellspacing="1" cellpadding="4" class="table table-striped table-responsive">
    <tr>
      <td width="151"><b>Kode</b></td>
      <td width="5"><b>:</b></td>
      <td width="930"><div class="col-md-2">
       <input name="textfield" type="text" value="<?php echo $dataKode; ?>" class="form-control col-md-4" size="10"  maxlength="6" readonly="readonly"/></div></td>
    </tr>
    <tr>
      <td><b>Nama User </b></td>
      <td><b>:</b></td>
      <td><div class="col-md-6">
      	<input name="txtNama" type="text" value="<?php echo $dataNama; ?>" class="form-control" size="80" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><b>No. Telepon </b></td>
      <td><b>:</b></td>
      <td><div class="col-md-6">
      	<input name="txtNoTelepon" class="form-control" type="text" value="<?php echo $dataNoTelepon; ?>" size="40" maxlength="20" /></div></td>
    </tr>
    <tr>
      <td><b>Username</b></td>
      <td><b>:</b></td>
      <td><div class="col-md-6"> 
      	<input name="txtUsername" type="text"  value="<?php echo $dataUsername; ?>" size="40" class="form-control" maxlength="20" /></div></td>
    </tr>
    <tr>
      <td><b>Password</b></td>
      <td><b>:</b></td>
      <td><div class="col-md-6">
      	<input name="txtPassword" class="form-control" type="password" size="40" maxlength="20" />
      </div></td>
    </tr>
    <tr>
      <td><b>Level</b></td>
      <td><b>:</b></td>
      <td><b><div class="col-md-4">
        <select name="cmbLevel" class="form-control">
          <option value="Kosong">....</option>
          <?php
		  $pilihan	= array("Kasir", "Gudang", "Admin");
          foreach ($pilihan as $nilai) {
            if ($dataLevel==$nilai) {
                $cek=" selected";
            } else { $cek = ""; }
            echo "<option value='$nilai' $cek>$nilai</option>";
          }
          ?></div>
        </select>
      </b></td>
    </tr>
    <tr class="success">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
        <input type="submit" name="btnSimpan" class="btn btn-primary" value="Simpan" /> <a href="?open=User-Data" class="btn btn-danger">Kembali</a>   </td>
    </tr>
</table>
</div>
</div>
</div>

<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Hak Akses</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<table width="100%" class="table table-striped table-responsive">
    <tr>
      <td width="300"><strong> Data User </strong></td>
      <td width="1"><b>:</b></td>
      <td >
      	<input name="rbDataUser" type="radio" class="switch-m" value="No" <?php echo $pilihUserN; ?>/> No
          <input name="rbDataUser" type="radio" class="switch-m" value="Yes" <?php echo $pilihUserY; ?>/> Yes </td>
    </tr>
    <tr>
      <td><strong> Data Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataPelanggan" type="radio" value="No"  <?php echo $pilihPelangganN; ?> /> No
  		<input name="rbDataPelanggan" type="radio" value="Yes" <?php echo $pilihPelangganY; ?>/> Yes </td>
    </tr>
    <tr>
      <td><strong> Data Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataSupplier" type="radio" value="No"  <?php echo $pilihSupplierN; ?> /> No
  		<input name="rbDataSupplier" type="radio" value="Yes" <?php echo $pilihSupplierY; ?>/> Yes </td>
    </tr>
    <tr>
      <td><strong> Data Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataMerek" type="radio" value="No" <?php echo $pilihMerekN; ?> /> No
 	 <input name="rbDataMerek" type="radio" value="Yes" <?php echo $pilihMerekY; ?>/> Yes </td>
    </tr>
    <tr>
      <td><strong> Data Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataKategori" type="radio" value="No" <?php echo $pilihKategoriN; ?> /> No
  		<input name="rbDataKategori" type="radio" value="Yes" <?php echo $pilihKategoriY; ?>/> Yes </td>
    </tr>
   
    <tr>
      <td><strong> Data Jenis </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataJenis" type="radio" value="No" <?php echo $pilihJenisN; ?> /> No
  		<input name="rbDataJenis" type="radio" value="Yes" <?php echo $pilihJenisY; ?>/> Yes </td>
    </tr>
    <tr>
      <td><strong> Data Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbDataBarang" type="radio" value="No" <?php echo $pilihBarangN; ?> /> No
  		<input name="rbDataBarang" type="radio" value="Yes" <?php echo $pilihBarangY; ?>/> Yes </td>
    </tr>

    <tr>
      <td><strong> Data Stok Barang </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapStokBarang" type="radio" value="No" <?php echo $rbLapStokBarangN; ?> /> No
  		<input name="rbLapStokBarang" type="radio" value="Yes" <?php echo $rbLapStokBarangY; ?>/> Yes </td>
    </tr>

     <tr>
      <td><strong> Ubah Header Logo </strong></td>
      <td><b>:</b></td>
      <td><input name="HeaderLogo" type="radio" value="No" <?php echo $HeaderLogoN; ?> /> No
  		<input name="HeaderLogo" type="radio" value="Yes" <?php echo $HeaderLogoY; ?>/> Yes </td>
    </tr>

    <tr>
      <td><strong> Cetak Barcode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbCetakBarcode" type="radio" value="No" <?php echo $pilihBarcodeN; ?> /> No
  		<input name="rbCetakBarcode" type="radio" value="Yes" <?php echo $pilihBarcodeY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong> Transaksi Pembelian </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPembelian" type="radio" value="No" <?php echo $pilihPembelianN; ?> /> No
  		<input name="rbPembelian" type="radio" value="Yes" <?php echo $pilihPembelianY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Menu Transaksi Retur Pembelian</strong></td>
      <td><b>:</b></td>
      <td><input name="rbReturbeli" type="radio" value="No" <?php echo $pilihReturbeliN; ?> /> No
  		<input name="rbReturbeli" type="radio" value="Yes" <?php echo $pilihReturbeliY; ?>/> Yes</td>
    </tr>
     <tr>
      <td><strong>Menu Transaksi Retur Penjualan</strong></td>
      <td><b>:</b></td>
      <td><input name="rbReturjual" type="radio" value="No" <?php echo $pilihReturjualN; ?> /> No
  		<input name="rbReturjual" type="radio" value="Yes" <?php echo $pilihReturjualY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Menu Transaksi Penjualan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbPenjualan" type="radio" value="No" <?php echo $pilihPenjualanN; ?> /> No
  		<input name="rbPenjualan" type="radio" value="Yes" <?php echo $pilihPenjualanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan User </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapUser" type="radio" value="No" <?php echo $pilihLapUserN; ?> /> No
  		<input name="rbLapUser" type="radio" value="Yes" <?php echo $pilihLapUserY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Pelanggan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPelanggan" type="radio" value="No" <?php echo $pilihLapPelangganN; ?> /> No
  		<input name="rbLapPelanggan" type="radio" value="Yes" <?php echo $pilihLapPelangganY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapSupplier" type="radio" value="No" <?php echo $pilihLapSupplierN; ?> /> No
  		<input name="rbLapSupplier" type="radio" value="Yes" <?php echo $pilihLapSupplierY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapMerek" type="radio" value="No" <?php echo $pilihLapMerekN; ?> /> No
  		<input name="rbLapMerek" type="radio" value="Yes" <?php echo $pilihLapMerekY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapKategori" type="radio" value="No" <?php echo $pilihLapKategoriN; ?> /> No
  		<input name="rbLapKategori" type="radio" value="Yes" <?php echo $pilihLapKategoriY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Jenis </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapJenis" type="radio" value="No" <?php echo $pilihLapJenisN; ?> /> No
  		<input name="rbLapJenis" type="radio" value="Yes" <?php echo $pilihLapJenisY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Barang per Merek </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangMerek" type="radio" value="No" <?php echo $pilihLapBarangMerekN; ?> /> No
  		<input name="rbLapBarangMerek" type="radio" value="Yes" <?php echo $pilihLapBarangMerekY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Berang per Kategori </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangKategori" type="radio" value="No" <?php echo $pilihLapBarangKategoriN; ?> /> No
  		<input name="rbLapBarangKategori" type="radio" value="Yes" <?php echo $pilihLapBarangKategoriY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Berang per Kategori Sub </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapBarangKategoriSub" type="radio" value="No" <?php echo $pilihLapBarangKategoriSubN; ?> /> No
  		<input name="rbLapBarangKategoriSub" type="radio" value="Yes" <?php echo $pilihLapBarangKategoriSubY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Pembelian per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianPeriode" type="radio" value="No" <?php echo $pilihLapPembelianPeriodeN; ?> /> No
  		<input name="rbLapPembelianPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianPeriodeY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBulan" type="radio" value="No" <?php echo $pilihLapPembelianBulanN; ?> /> No
  		<input name="rbLapPembelianBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianBulanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian per Supplier </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianSupplier" type="radio" value="No" <?php echo $pilihLapPembelianSupplierN; ?> /> No
  		<input name="rbLapPembelianSupplier" type="radio" value="Yes" <?php echo $pilihLapPembelianSupplierY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBarangPeriode" type="radio" value="No" <?php echo $pilihLapPembelianBarangPeriodeN; ?> /> No
  		<input name="rbLapPembelianBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianBarangPeriodeY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianBarangBulan" type="radio" value="No" <?php echo $pilihLapPembelianBarangBulanN; ?> /> No
  		<input name="rbLapPembelianBarangBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianBarangBulanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianRekapPeriode" type="radio" value="No" <?php echo $pilihLapPembelianRekapPeriodeN; ?> /> No
  		<input name="rbLapPembelianRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapPembelianRekapPeriodeY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Pembelian Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPembelianRekapBulan" type="radio" value="No" <?php echo $pilihLapPembelianRekapBulanN; ?> /> No
  		<input name="rbLapPembelianRekapBulan" type="radio" value="Yes" <?php echo $pilihLapPembelianRekapBulanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Retur per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliPeriode" type="radio" value="No" <?php echo $pilihLapReturbeliPeriodeN; ?> /> No
        <input name="rbLapReturbeliPeriode" type="radio" value="Yes" <?php echo $pilihLapReturbeliPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliBulan" type="radio" value="No" <?php echo $pilihLapReturbeliBulanN; ?> /> No
        <input name="rbLapReturbeliBulan" type="radio" value="Yes" <?php echo $pilihLapReturbeliBulanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliBarangPeriode" type="radio" value="No" <?php echo $pilihLapReturbeliBarangPeriodeN; ?> /> No
        <input name="rbLapReturbeliBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapReturbeliBarangPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliBarangBulan" type="radio" value="No" <?php echo $pilihLapReturbeliBarangBulanN; ?> /> No
        <input name="rbLapReturbeliBarangBulan" type="radio" value="Yes" <?php echo $pilihLapReturbeliBarangBulanY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliRekapPeriode" type="radio" value="No" <?php echo $pilihLapReturbeliRekapPeriodeN; ?> /> No
        <input name="rbLapReturbeliRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapReturbeliRekapPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Retur Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapReturbeliRekapBulan" type="radio" value="No" <?php echo $pilihLapReturbeliRekapBulanN; ?> /> No
        <input name="rbLapReturbeliRekapBulan" type="radio" value="Yes" <?php echo $pilihLapReturbeliRekapBulanY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan Penjualan per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanPeriodeN; ?> /> No
        <input name="rbLapPenjualanPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBulan" type="radio" value="No" <?php echo $pilihLapPenjualanBulanN; ?> /> No
        <input name="rbLapPenjualanBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanBulanY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanBarangPeriodeN; ?> /> No
        <input name="rbLapPenjualanBarangPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Brg per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanBarangBulan" type="radio" value="No" <?php echo $pilihLapPenjualanBarangBulanN; ?> /> No
        <input name="rbLapPenjualanBarangBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanBarangBulanY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Rekap per Periode </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanRekapPeriode" type="radio" value="No" <?php echo $pilihLapPenjualanRekapPeriodeN; ?> /> No
        <input name="rbLapPenjualanRekapPeriode" type="radio" value="Yes" <?php echo $pilihLapPenjualanRekapPeriodeY; ?>/>Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Rekap per Bulan </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanRekapBulan" type="radio" value="No" <?php echo $pilihLapPenjualanRekapBulanN; ?> /> No
        <input name="rbLapPenjualanRekapBulan" type="radio" value="Yes" <?php echo $pilihLapPenjualanRekapBulanY; ?>/> Yes</td>
    </tr>
    <tr>
      <td><strong>Laporan  Penjualan Barang Terlaris </strong></td>
      <td><b>:</b></td>
      <td><input name="rbLapPenjualanTerlaris" type="radio" value="No" <?php echo $pilihLapPenjualanTerlarisN; ?> /> No
        <input name="rbLapPenjualanTerlaris" type="radio" value="Yes" <?php echo $pilihLapPenjualanTerlarisY; ?>/> Yes</td>
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
