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
                  <h2 class="breadcrumb-titles">Laporan Retur</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li class="active-page">Laporan Retur</a></li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>


<?php if($aksesData['mlap_returbeli_periode'] == "Yes") { ?>
	
<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returbeli-Periode" class="ico-cirlce-widget w_bg_teal">
			<span><i class="fa fa-cart-arrow-down"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Beli per Periode</span>
		</div>
	</div>
</div>

	<?php } if($aksesData['mlap_returbeli_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returbeli-Bulan" class="ico-cirlce-widget w_bg_green">
			<span><i class="fa fa-calendar"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Beli per Bulan & Tahun</span>
		</div>
	</div>
</div>

	
	<?php } if($aksesData['mlap_returbeli_barang_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returbeli-Bulan" class="ico-cirlce-widget w_bg_blue_grey">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Beli Barang per Periode</span>
		</div>
	</div>
</div>

	
	<?php } if($aksesData['mlap_returbeli_barang_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returbeli-Barang-Bulan" class="ico-cirlce-widget w_bg_blue">
			<span><i class="ico-truck"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Beli Barang per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_returbeli_rekap_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Returbeli-Periode" class="ico-cirlce-widget w_bg_orange">
			<span><i class="ico-bookmarks"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Beli Retur per Periode </span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_returbeli_rekap_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Returbeli-Bulan" class="ico-cirlce-widget w_bg_red">
			<span><i class="ico-pin"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Beli Retur per Bulan & Tahun </span>
		</div>
	</div>
</div>
					
					<div style="margin-bottom:430px;"></div>
<!--Hijab-->

	<?php } if($aksesData['mlap_returbeli_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returjual-Periode" class="ico-cirlce-widget w_bg_cyan">
			<span><i class="fa fa-cart-arrow-down"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Jual per Periode</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_returbeli_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returjual-Bulan" class="ico-cirlce-widget w_bg_green">
			<span><i class="fa fa-calendar"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Jual per Bulan & Tahun</span>
		</div>
	</div>
</div>

	<?php } if($aksesData['mlap_returbeli_barang_periode'] == "Yes") { ?>
<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returjual-Barang-Periode" class="ico-cirlce-widget w_bg_orange">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Jual Barang per Periode</span>
		</div>
	</div>
</div>

	<?php } if($aksesData['mlap_returbeli_barang_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Returjual-Barang-Bulan" class="ico-cirlce-widget w_bg_red">
			<span><i class="ico-truck"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Retur Jual Barang per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_returbeli_rekap_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Returjual-Periode" class="ico-cirlce-widget w_bg_purple">
			<span><i class="ico-bookmarks"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Retur Jual per Periode</span>
		</div>
	</div>
</div>

	<?php } if($aksesData['mlap_returbeli_rekap_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Returjual-Bulan" class="ico-cirlce-widget w_bg_grey">
			<span><i class="ico-pin"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Retur Jual per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php
}
}
?>