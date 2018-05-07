<?php
if($_GET['open']) {
# KONTROL MENU PROGRAM
	// Jika mendapatkan variabel URL ?page
	switch($_GET['open']){
		case '' :
			if(!file_exists ("main.php")) die ("Empty Main Page!");
			include "main.php";	break;

		case 'Halaman-Utama' :
			if(!file_exists ("main.php")) die ("File tidak ditemukan  !");
			include "main.php";	break;

		case 'Login' :
			if(!file_exists ("login.php")) die ("File tidak ditemukan  !");
			echo '<meta http-equiv="refresh" content="0; URL=login.php">';
			break;

		case 'Login-Validasi' :
			if(!file_exists ("login_validasi.php")) die ("File tidak ditemukan  !");
			include "login_validasi.php"; break;

		case 'Logout' :
			if(!file_exists ("login_out.php")) die ("File tidak ditemukan  !");
			include "login_out.php"; break;

		# Profil Perusahaan

		case 'Ubah-Profil' :
			if(!file_exists ("header/ubah_header.php")) die ("File tidak ditemukan  !");
			include "header/ubah_header.php"; break;

		# DATA USER
		case 'User-Data' :
			if(!file_exists ("user_data.php")) die ("File tidak ditemukan  !");
			include "user_data.php";	 break;
		case 'User-Add' :
			if(!file_exists ("user_add.php")) die ("File tidak ditemukan  !");
			include "user_add.php";	 break;
		case 'User-Delete' :
			if(!file_exists ("user_delete.php")) die ("File tidak ditemukan  !");
			include "user_delete.php"; break;
		case 'User-Edit' :
			if(!file_exists ("user_edit.php")) die ("File tidak ditemukan  !");
			include "user_edit.php"; break;

		# MEREK BARANG
		case 'Merek-Data' :
			if(!file_exists ("merek_data.php")) die ("File tidak ditemukan  !");
			include "merek_data.php"; break;
		case 'Merek-Add' :
			if(!file_exists ("merek_add.php")) die ("File tidak ditemukan  !");
			include "merek_add.php";	break;
		case 'Merek-Delete' :
			if(!file_exists ("merek_delete.php")) die ("File tidak ditemukan  !");
			include "merek_delete.php"; break;
		case 'Merek-Edit' :
			if(!file_exists ("merek_edit.php")) die ("File tidak ditemukan  !");
			include "merek_edit.php"; break;

		# KATEGORI BARANG
		case 'Kategori-Data' :
			if(!file_exists ("kategori_data.php")) die ("File tidak ditemukan  !");
			include "kategori_data.php"; break;
		case 'Kategori-Add' :
			if(!file_exists ("kategori_add.php")) die ("File tidak ditemukan  !");
			include "kategori_add.php";	break;
		case 'Kategori-Delete' :
			if(!file_exists ("kategori_delete.php")) die ("File tidak ditemukan  !");
			include "kategori_delete.php"; break;
		case 'Kategori-Edit' :
			if(!file_exists ("kategori_edit.php")) die ("File tidak ditemukan  !");
			include "kategori_edit.php"; break;

		# KONTROL FORM SUB KATEGORI
		case 'Kategori-Sub-Data' :
			if(!file_exists ("kategori_sub_data.php")) die ("File tidak ada!");
			include "kategori_sub_data.php"; break;
		case 'Kategori-Sub-Add' :
			if(!file_exists ("kategori_sub_add.php")) die ("File tidak ada!");
			include "kategori_sub_add.php";	break;
		case 'Kategori-Sub-Delete' :
			if(!file_exists ("kategori_sub_delete.php")) die ("File tidak ada!");
			include "kategori_sub_delete.php"; break;
		case 'Kategori-Sub-Edit' :
			if(!file_exists ("kategori_sub_edit.php")) die ("File tidak ada!");
			include "kategori_sub_edit.php"; break;

		# JENIS BARANG
		case 'Jenis-Data' :
			if(!file_exists ("jenis_data.php")) die ("Sorry Empty Page!");
			include "jenis_data.php"; break;
		case 'Jenis-Add' :
			if(!file_exists ("jenis_add.php")) die ("Sorry Empty Page!");
			include "jenis_add.php"; break;
		case 'Jenis-Delete' :
			if(!file_exists ("jenis_delete.php")) die ("Sorry Empty Page!");
			include "jenis_delete.php"; break;
		case 'Jenis-Edit' :
			if(!file_exists ("jenis_edit.php")) die ("Sorry Empty Page!");
			include "jenis_edit.php"; break;

		# DATA BARANG
		case 'Barang-Data' :
			if(!file_exists ("barang_data.php")) die ("File tidak ditemukan  !");
			include "barang_data.php"; break;
		case 'Barang-Add' :
			if(!file_exists ("barang_add.php")) die ("File tidak ditemukan  !");
			include "barang_add.php"; break;
		case 'Barang-Delete' :
			if(!file_exists ("barang_delete.php")) die ("File tidak ditemukan  !");
			include "barang_delete.php"; break;
		case 'Barang-Edit' :
			if(!file_exists ("barang_edit.php")) die ("File tidak ditemukan  !");
			include "barang_edit.php"; break;
		case 'Barang-C' :
			if(!file_exists ("barang_cari.php")) die ("File tidak ditemukan  !");
			include "barang_cari.php"; break;

		# BAGIAN PENCARIAN
		case 'Barang-Cari' :
			if(!file_exists ("pembelian/pencarian_barang.php")) die ("File tidak ditemukan  !");
			include "pembelian/pencarian_barang.php"; break;

		case 'Cari-Barang-Penjualan' :
			if(!file_exists ("penjualan/pencarian_barang.php")) die ("File tidak ditemukan  !");
			include "penjualan/pencarian_barang.php"; break;

		case 'Cari-Barang-Retur' :
			if(!file_exists ("returbeli/pencarian_barang.php")) die ("File tidak ditemukan  !");
			include "returbeli/pencarian_barang.php"; break;


		# CETAK BARCODE
		case 'Cetak-Barcode' :
			if(!file_exists ("cetak_barcode.php")) die ("Sorry Empty Page!");
			include "cetak_barcode.php"; break;
		# SUPPLIER
		case 'Supplier-Data' :
			if(!file_exists ("supplier_data.php")) die ("File tidak ditemukan  !");
			include "supplier_data.php"; break;
		case 'Supplier-Add' :
			if(!file_exists ("supplier_add.php")) die ("File tidak ditemukan  !");
			include "supplier_add.php"; break;
		case 'Supplier-Delete' :
			if(!file_exists ("supplier_delete.php")) die ("File tidak ditemukan  !");
			include "supplier_delete.php"; break;
		case 'Supplier-Edit' :
			if(!file_exists ("supplier_edit.php")) die ("File tidak ditemukan  !");
			include "supplier_edit.php"; break;

		# PELANGGAN
		case 'Pelanggan-Data' :
			if(!file_exists ("pelanggan_data.php")) die ("File tidak ditemukan  !");
			include "pelanggan_data.php"; break;
		case 'Pelanggan-Add' :
			if(!file_exists ("pelanggan_add.php")) die ("File tidak ditemukan  !");
			include "pelanggan_add.php"; break;
		case 'Pelanggan-Delete' :
			if(!file_exists ("pelanggan_delete.php")) die ("File tidak ditemukan  !");
			include "pelanggan_delete.php"; break;
		case 'Pelanggan-Edit' :
			if(!file_exists ("pelanggan_edit.php")) die ("File tidak ditemukan  !");
			include "pelanggan_edit.php"; break;


		# REPORT INFORMASI / LAPORAN DATA
		case 'Laporan' :
				if(!file_exists ("menu_laporan.php")) die ("File tidak ditemukan  !");
				include "menu_laporan.php"; break;

		case 'Laporan-Pembelian' :
				if(!file_exists ("menu/pembelian.php")) die ("File tidak ditemukan  !");
				include "menu/pembelian.php"; break;

		case 'Laporan-Penjualan' :
				if(!file_exists ("menu/penjualan.php")) die ("File tidak ditemukan  !");
				include "menu/penjualan.php"; break;

		case 'Laporan-Retur' :
				if(!file_exists ("menu/retur.php")) die ("File tidak ditemukan  !");
				include "menu/retur.php"; break;

		case 'Laporan-Master-Data' :
				if(!file_exists ("menu/master_data.php")) die ("File tidak ditemukan  !");
				include "menu/master_data.php"; break;

			# LAPORAN MASTER DATA
			case 'Laporan-User' :
				if(!file_exists ("laporan_user.php")) die ("File tidak ditemukan  !");
				include "laporan_user.php"; break;

			case 'Laporan-Supplier' :
				if(!file_exists ("laporan_supplier.php")) die ("File tidak ditemukan  !");
				include "laporan_supplier.php"; break;

			case 'Laporan-Pelanggan' :
				if(!file_exists ("laporan_pelanggan.php")) die ("File tidak ditemukan  !");
				include "laporan_pelanggan.php"; break;

			case 'Laporan-Kategori' :
				if(!file_exists ("laporan_kategori.php")) die ("File tidak ditemukan  !");
				include "laporan_kategori.php"; break;

			case 'Laporan-Merek' :
				if(!file_exists ("laporan_merek.php")) die ("File tidak ditemukan  !");
				include "laporan_merek.php"; break;

			case 'Laporan-Barang-Kategori' :
				if(!file_exists ("laporan_barang_kategori.php")) die ("File tidak ditemukan  !");
				include "laporan_barang_kategori.php"; break;

			case 'Laporan-Barang-KategoriSub' :
				if(!file_exists ("laporan_barang_kategorisub.php")) die ("File tidak ditemukan  !");
				include "laporan_barang_kategorisub.php"; break;

			case 'Laporan-Stok-Barang':
				if(!file_exists ("laporan_stok_barang.php")) die ("File tidak ditemukan  !");
				include "laporan_stok_barang.php"; break;

			case 'Laporan-Penjualan-Kasir-Periode' :
				if(!file_exists ("laporan_penjualan_kasir_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_kasir_periode.php"; break;


			# LAPORAN PEMBELIAN
			case 'Laporan-Pembelian-Periode' :
				if(!file_exists ("laporan_pembelian_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_periode.php"; break;

			case 'Laporan-Hutang-Periode' :
				if(!file_exists ("laporan_hutang.php")) die ("File tidak ditemukan  !");
				include "laporan_hutang.php"; break;

			case 'Laporan-Pembelian-Bulan' :
				if(!file_exists ("laporan_pembelian_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_bulan.php"; break;

			case 'Laporan-Pembelian-Supplier' :
				if(!file_exists ("laporan_pembelian_supplier.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_supplier.php"; break;

			case 'Laporan-Pembelian-Barang-Periode' :
				if(!file_exists ("laporan_pembelian_barang_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_barang_periode.php"; break;

			case 'Laporan-Pembelian-Barang-Bulan' :
				if(!file_exists ("laporan_pembelian_barang_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_barang_bulan.php"; break;

			case 'Laporan-Rekap-Pembelian-Periode' :
				if(!file_exists ("laporan_rekap_pembelian_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_rekap_pembelian_periode.php"; break;

			case 'Laporan-Rekap-Pembelian-Bulan' :
				if(!file_exists ("laporan_rekap_pembelian_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_rekap_pembelian_bulan.php"; break;

			case 'Laporan-Pembelian-Barang-Cash' :
				if(!file_exists ("laporan_pembelian_barang_cash.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_barang_cash.php"; break;

			case 'Laporan-Pembelian-Barang-Kredit' :
				if(!file_exists ("laporan_pembelian_barang_kredit.php")) die ("File tidak ditemukan  !");
				include "laporan_pembelian_barang_kredit.php"; break;

			case 'Laporan-Rekap-Supplier-Per-Periode' :
				if(!file_exists ("laporan_rekap_supplier_per_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_rekap_supplier_per_periode.php"; break;

			# LAPORAN RETUR BELI (PEMBELIAN)
			case 'Laporan-Returbeli-Periode' :
				if(!file_exists ("laporan_returbeli_periode.php")) die ("File tidak ada !");
				include "laporan_returbeli_periode.php"; break;

			case 'Laporan-Returbeli-Bulan' :
				if(!file_exists ("laporan_returbeli_bulan.php")) die ("File tidak ada !");
				include "laporan_returbeli_bulan.php"; break;

			case 'Laporan-Returbeli-Barang-Periode' :
				if(!file_exists ("laporan_returbeli_barang_periode.php")) die ("File tidak ada !");
				include "laporan_returbeli_barang_periode.php"; break;

			case 'Laporan-Returbeli-Barang-Bulan' :
				if(!file_exists ("laporan_returbeli_barang_bulan.php")) die ("File tidak ada !");
				include "laporan_returbeli_barang_bulan.php"; break;

			case 'Laporan-Rekap-Returbeli-Periode' :
				if(!file_exists ("laporan_rekap_returbeli_periode.php")) die ("File tidak ada !");
				include "laporan_rekap_returbeli_periode.php"; break;

			case 'Laporan-Rekap-Returbeli-Bulan' :
				if(!file_exists ("laporan_rekap_returbeli_bulan.php")) die ("File tidak ada !");
				include "laporan_rekap_returbeli_bulan.php"; break;

			# LAPORAN RETUR JUAL (PENJUALAN)
			case 'Laporan-Returjual-Periode' :
				if(!file_exists ("laporan_returjual_periode.php")) die ("File tidak ada !");
				include "laporan_returjual_periode.php"; break;

			case 'Laporan-Piutang-Periode' :
				if(!file_exists ("laporan_piutang.php")) die ("File tidak ditemukan  !");
				include "laporan_piutang.php"; break;

			case 'Laporan-Returjual-Bulan' :
				if(!file_exists ("laporan_returjual_bulan.php")) die ("File tidak ada !");
				include "laporan_returjual_bulan.php"; break;

			case 'Laporan-Returjual-Barang-Periode' :
				if(!file_exists ("laporan_returjual_barang_periode.php")) die ("File tidak ada !");
				include "laporan_returjual_barang_periode.php"; break;

			case 'Laporan-Returjual-Barang-Bulan' :
				if(!file_exists ("laporan_returjual_barang_bulan.php")) die ("File tidak ada !");
				include "laporan_returjual_barang_bulan.php"; break;

			case 'Laporan-Rekap-Returjual-Periode' :
				if(!file_exists ("laporan_rekap_returjual_periode.php")) die ("File tidak ada !");
				include "laporan_rekap_returjual_periode.php"; break;

			case 'Laporan-Rekap-Returjual-Bulan' :
				if(!file_exists ("laporan_rekap_returjual_bulan.php")) die ("File tidak ada !");
				include "laporan_rekap_returjual_bulan.php"; break;

			# LAPORAN PENJUALAN
			case 'Laporan-Penjualan-Periode' :
				if(!file_exists ("laporan_penjualan_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_periode.php"; break;

			case 'Laporan-Penjualan-Bulan' :
				if(!file_exists ("laporan_penjualan_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_bulan.php"; break;

			# LAPORAN PENDAPATAN
			case 'Laporan-Penjualan-Barang-Periode' :
				if(!file_exists ("laporan_penjualan_barang_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_barang_periode.php"; break;

			case 'Laporan-Penjualan-Barang-Bulan' :
				if(!file_exists ("laporan_penjualan_barang_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_barang_bulan.php"; break;

			case 'Laporan-Penjualan-Barang-Tahun' :
				if(!file_exists ("laporan_penjualan_barang_tahun.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_barang_tahun.php"; break;

			case 'Laporan-Rekap-Penjualan-Periode' :
				if(!file_exists ("laporan_rekap_penjualan_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_rekap_penjualan_periode.php"; break;

			case 'Laporan-Rekap-Penjualan-Bulan' :
				if(!file_exists ("laporan_rekap_penjualan_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_rekap_penjualan_bulan.php"; break;

			case 'Laporan-Penjualan-Terlaris' :
				if(!file_exists ("laporan_penjualan_terlaris.php")) die ("File tidak ada !");
				include "laporan_penjualan_terlaris.php"; break;

			case 'Laporan-Penjualan-Barang-Kredit' :
				if(!file_exists ("laporan_penjualan_barang_kredit.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_barang_kredit.php"; break;

			case 'Laporan-Penjualan-Barang-Cash' :
				if(!file_exists ("laporan_penjualan_barang_cash.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_barang_cash.php"; break;

			case 'Laporan-Penjualan-Keseluruhan-Bulan' :
				if(!file_exists ("laporan_penjualan_keseluruhan_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_keseluruhan_bulan.php"; break;

			case 'Laporan-Penjualan-Kasir-Periode' :
				if(!file_exists ("laporan_penjualan_kasir_periode.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_kasir_periode.php"; break;

			case 'Laporan-Penjualan-Keseluruhan-Bulan' :
				if(!file_exists ("laporan_penjualan_keseluruhan_bulan.php")) die ("File tidak ditemukan  !");
				include "laporan_penjualan_keseluruhan_bulan.php"; break;


				/**
				Tambahan Untuk ATK
				**/

			#Penjualan

			case 'Penjualan-ATK' :
				if(!file_exists ("atk/penjualan/penjualan_baru.php")) die ("File tidak ditemukan  !");
				include "atk/penjualan/penjualan_baru.php"; break;

			case 'Penjualan-ATK-Tampil' :
				if(!file_exists ("atk/penjualan/penjualan_tampil.php")) die ("File tidak ditemukan  !");
				include "atk/penjualan/penjualan_tampil.php"; break;

			#Pembelian

			case 'Pembelian-ATK' :
				if(!file_exists ("atk/pembelian/pembelian_baru.php")) die ("File tidak ditemukan  !");
				include "atk/pembelian/pembelian_baru.php"; break;

			case 'Pembelian-ATK-Tampil' :
				if(!file_exists ("atk/pembelian/pembelian_tampil.php")) die ("File tidak ditemukan  !");
				include "atk/pembelian/pembelian_tampil.php"; break;

			#Laporan

			case 'Laporan-ATK' :
				if(!file_exists ("atk/laporan/index.php")) die ("File tidak ditemukan  !");
				include "atk/laporan/index.php"; break;

			#Barang

			case 'Barang-Jasa-ATK' :
				if(!file_exists ("atk/barang/list.php")) die ("File tidak ditemukan  !");
				include "atk/barang/list.php"; break;

			case 'Barang-Jasa-ATK-Tambah' :
				if(!file_exists ("atk/barang/add.php")) die ("File tidak ditemukan  !");
				include "atk/barang/add.php"; break;

			/** The end of ATK **/

		default:
			if(!file_exists ("main.php")) die ("Empty Main Page!");
			include "main.php";
		break;
	}
}
else {
	// Jika tidak mendapatkan variabel URL : ?page
	if(!file_exists ("main.php")) die ("Empty Main Page!");
	include "main.php";
}
?>
