<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
	<!--<li><a href='?open' title='Halaman Utama'><i class="fa fa-link"></i>Home</a></li>-->
	 <?php if($aksesData['mu_data_user'] != "Yes" && $aksesData['mu_data_pelanggan'] != "Yes" && $aksesData['mu_data_supplier'] != "Yes" &&
	 $aksesData['mu_data_merek'] != "Yes" && $aksesData['mu_data_kategori'] != "Yes" && $aksesData['mu_data_kategorisub'] != "Yes" && $aksesData['mu_data_jenis'] != "Yes" &&
	 $aksesData['mu_data_barang'] != "Yes" ){}else{
	 ?>
	  <li><a class="waves-effect"><span class="nav-icon"><i class="fa fa-database"></i></span><span class="nav-label">Master Data</span></a>
                <ul>
                    
					<?php if($aksesData['mu_data_pelanggan'] == "Yes") { ?>
					<li><a href='?open=Pelanggan-Data' title='Pelanggan'><i class="fa fa-circle-o"></i> Data Pelanggan</a></li>
					<?php } if($aksesData['mu_data_supplier'] == "Yes") { ?>
					<li><a href='?open=Supplier-Data' title='Supplier'><i class="fa fa-circle-o"></i> Data Supplier</a></li>
					<?php } if($aksesData['mu_data_merek'] == "Yes") { ?>
					<li><a href='?open=Merek-Data' title='Merek'><i class="fa fa-circle-o"></i> Data Merek</a></li>
					<?php } if($aksesData['mu_data_kategori'] == "Yes") { ?>
					<li><a href='?open=Kategori-Data' title='Kategori'><i class="fa fa-circle-o"></i> Data Kategori</a></li>
					<?php } if($aksesData['mu_data_kategorisub'] == "Yes") { ?>
					<!--<li><a href='../?open=Kategori-Sub-Data' title='Sub Kategori'><i class="fa fa-link"></i>Data Sub Kategori</a></li>-->
					<?php } if($aksesData['mu_data_jenis'] == "Yes") { ?>
					<li><a href='?open=Jenis-Data' title='Jenis'><i class="fa fa-circle-o"></i> Data Jenis</a></li>
					<?php } if($aksesData['mu_data_barang'] == "Yes") { ?>
					<li><a href='?open=Barang-Data' title='Barang'><i class="fa fa-circle-o"></i> Data Barang</a></li>
					<?php } ?>

                </ul>
            </li>
            <li><a  class="waves-effect"><span class="nav-icon"><i class="fa fa-cart-plus"></i></span><span class="nav-label">Transaksi</span></a>
                <ul>
                    <?php if($aksesData['mu_trans_pembelian'] == "Yes") { ?>
					<li><a href='pembelian/' title='Pembelian' ><i class="fa fa-circle-o"></i> Pembelian Barang</a> </li>
					<?php } if($aksesData['mu_trans_penjualan'] == "Yes") { ?>
					<li><a href='penjualan/' title='Penjualan' ><i class="fa fa-circle-o"></i> Penjualan Barang</a> </li>
					<?php } if($aksesData['mu_trans_returbeli'] == "Yes") { ?>
					<li><a href='returbeli/' title='Retur Pembelian' ><i class="fa fa-circle-o"></i> Retur Pembelian</a> </li>
					<?php } if($aksesData['mu_trans_returjual'] == "Yes") { ?>
					<li><a href='returjual/' title='Retur Penjualan'><i class="fa fa-circle-o"></i> Retur Penjualan</a> </li>
					<?php } if($aksesData['mu_barcode'] == "Yes") { ?>
					<?php } ?>
					<li><a href='pembayaran_hutang/' title='Pembayaran Hutang' ><i class="fa fa-circle-o"></i> Pembayaran Hutang</a> </li>

					<li><a href='pembayaran_piutang/' title='Pembayaran Piutang' ><i class="fa fa-circle-o"></i> Pembayaran Piutang</a> </li>
                </ul>
            </li>
  
            <?php if($aksesData['mu_laporan'] == "Yes") { ?>
           <li><a class="waves-effect"><span class="nav-icon"><i class="fa fa-folder-open"></i></span><span class="nav-label">Laporan</span></a>
                <ul>
                    <li><a href='?open=Laporan-Master-Data' title='Laporan Master Data'><i class="fa fa-book"></i> Bagian Master Data</a></li>
					<li><a href='?open=Laporan-Pembelian' title='Laporan Pembelian'><i class="fa fa-book"></i> Bagian Pembelian</a></li>
					<li><a href='?open=Laporan-Penjualan' title='Laporan Penjualan'><i class="fa fa-book"></i> Bagian Penjualan</a></li>
					<li><a href='?open=Laporan-Retur' title='Laporan Retur'><i class="fa fa-book"></i> Bagian Retur</a></li>
			   </ul>
            </li>
            <?php } ?>

             <li><a class="waves-effect"><span class="nav-icon"><i class="fa fa-cog"></i></span><span class="nav-label">Pengaturan</span></a>
                <ul>
                    <?php if($aksesData['mu_data_user'] == "Yes") { ?>
					<li><a href='?open=User-Data' title='User Login'><i class="fa fa-users"></i> Data Pengguna</a></li>
					<?php } ?>
					<?php if($aksesData['mu_header'] == "Yes") : ?>
					<li><a href='?open=Ubah-Profil&Kode=1' title='Profil Perusahaan'><i class="fa fa-briefcase"></i> Data Profil</a></li>
					<?php endif; ?>
                </ul>
            </li>



            
	<!--
	<li><a href='?open=Logout' title='Logout (Exit)'><i class="fa fa-link"></i>Logout</a></li>
	-->
<?php
}
# JIKA BELUM LOGIN (BELUM ADA SESION LEVEL YG DIBACA)
?>

<?php
}
?>

<!--	<li><a href='?open=Cetak-Barcode' title='Cetak Barcode'><i class="fa fa-cirlce-o"></i>Cetak Label Barcode</a></li> -->

<!--Waktu-->
<script type="text/javascript">
$ (document). ready(function(){
    $(".jam"). clock ({"format":"24"."calender":false});
});
</script>