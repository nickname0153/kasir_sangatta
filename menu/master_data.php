<?php
if(isset($_SESSION['SES_LOGIN'])){
# JIKA YANG LOGIN LEVEL ADMIN, menu di bawah yang dijalankan
	include_once "library/inc.hakakses.php";
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Master Data</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li class="active-page">Laporan Master Data</a></li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>


<?php if($aksesData['mlap_user'] == "Yes") { ?>
<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-User" class="ico-cirlce-widget w_bg_red">
			<span><i class="ico-users"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Data User</span><br>
		</div>
	</div>
</div>
<?php } if($aksesData['mlap_supplier'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Supplier" class="ico-cirlce-widget w_bg_yellow">
			<span><i class="fa fa-truck"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Data Supplier</span><br>
		</div>
	</div>
</div>

<?php } if($aksesData['mlap_pelanggan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pelanggan" class="ico-cirlce-widget w_bg_blue">
			<span><i class="fa fa-user"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Data Pelanggan</span><br>
		</div>
	</div>
</div>

<?php } if($aksesData['mlap_merek'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Merek" class="ico-cirlce-widget w_bg_green">
			<span><i class="ico-turned-in"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Data Merek</span><br>
		</div>
	</div>
</div>

<?php } if($aksesData['mlap_kategori'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Kategori" class="ico-cirlce-widget w_bg_teal">
			<span><i class="ico-folder-close"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Data Kategori</span><br>
		</div>
	</div>
</div>

<?php } if($aksesData['mlap_barang_kategori'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Barang-Kategori" class="ico-cirlce-widget w_bg_orange">
			<span><i class="fa fa-tasks"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Data Barang per Kategori</span><br>
		</div>
	</div>
</div>


<?php
}
}
?>