<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<ul>
	<?php if($aksesData['mlap_user'] == "Yes") { ?>
	<li><a href="?open=Laporan-User">Laporan Data User</a></li>
	
	<?php } if($aksesData['mlap_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Supplier">Laporan Data Supplier</a></li>
	
	<?php } if($aksesData['mlap_pelanggan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pelanggan">Laporan Data Pelanggan</a></li>
	
	<?php } if($aksesData['mlap_merek'] == "Yes") { ?>
	<li><a href="?open=Laporan-Merek">Laporan Data Merek</a></li>
	
	<?php } if($aksesData['mlap_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Kategori">Laporan Data Kategori</a></li>
	
	<?php } if($aksesData['mlap_barang_kategori'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-Kategori">Laporan Data Barang per Kategori</a></li>
	
	<?php } if($aksesData['mlap_barang_kategorisub'] == "Yes") { ?>
	<li><a href="?open=Laporan-Barang-KategoriSub">Laporan Data Barang per Sub Kategori</a></li>
	
	<?php } if($aksesData['mlap_pembelian_periode'] == "Yes") { ?>
	<br />
	<li><a href="?open=Laporan-Pembelian-Periode">Laporan Pembelian per Periode</a></li>
	
	<?php } if($aksesData['mlap_pembelian_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Bulan">Laporan Pembelian per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_pembelian_supplier'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Supplier">Laporan Pembelian per Supplier</a></li>
	
	<?php } if($aksesData['mlap_pembelian_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Barang-Periode">Laporan Pembelian Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Pembelian-Barang-Bulan">Laporan Pembelian Barang per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_pembelian_rekap_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Pembelian-Periode">Laporan Rekap Pembelian per Periode</a></li>
	
	<?php } if($aksesData['mlap_pembelian_rekap_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Pembelian-Bulan">Laporan Rekap Pembelian per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_returbeli_periode'] == "Yes") { ?>
	<br />
	<li><a href="?open=Laporan-Returbeli-Periode">Laporan Retur per Periode</a></li>
	
	<?php } if($aksesData['mlap_returbeli_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Bulan">Laporan Retur per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_returbeli_barang_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Barang-Periode">Laporan Retur Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_returbeli_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Returbeli-Barang-Bulan">Laporan Retur Barang per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_returbeli_rekap_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Returbeli-Periode">Laporan Rekap Retur per Periode</a></li>
	
	<?php } if($aksesData['mlap_returbeli_rekap_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Returbeli-Bulan">Laporan Rekap Retur per Bulan & Tahun</a></li>
	
	<?php }  if($aksesData['mlap_penjualan_periode'] == "Yes") { ?>
	<br />
	<li><a href="?open=Laporan-Penjualan-Periode">Laporan Penjualan per Periode</a></li>
	
	<?php } if($aksesData['mlap_penjualan_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Bulan">Laporan Penjualan per Bulan</a></li>
	
	<?php } if($aksesData['mlap_penjualan_barang_periode'] == "Yes") { ?>
	<br />
	<li><a href="?open=Laporan-Penjualan-Barang-Periode">Laporan Penjualan Barang per Periode</a></li>
	
	<?php } if($aksesData['mlap_penjualan_barang_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Barang-Bulan">Laporan Penjualan Barang per Bulan</a></li>
	
	<?php } if($aksesData['mlap_penjualan_rekap_periode'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Penjualan-Periode">Laporan Rekap Penjualan per Periode</a></li>
	
	<?php } if($aksesData['mlap_penjualan_rekap_bulan'] == "Yes") { ?>
	<li><a href="?open=Laporan-Rekap-Penjualan-Bulan">Laporan Rekap Penjualan per Bulan & Tahun</a></li>
	
	<?php } if($aksesData['mlap_penjualan_terlaris'] == "Yes") { ?>
	<li><a href="?open=Laporan-Penjualan-Terlaris">Laporan Penjualan Berang Terlaris</a></li>
	<?php } ?>
</ul>	
<?php
}
?>