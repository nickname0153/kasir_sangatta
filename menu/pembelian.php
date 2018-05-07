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
                  <h2 class="breadcrumb-titles">Laporan Data Pembelian</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li class="active-page">Laporan Data Pembelian</a></li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>

	<?php if($aksesData['mlap_pembelian_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pembelian-Periode" class="ico-cirlce-widget w_bg_red">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Pembelian per Periode</span>
		</div>
	</div>
</div>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Hutang-Periode" class="ico-cirlce-widget w_bg_teal">
			<span><i class="fa fa-credit-card"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Hutang per Periode<br>&nbsp;<br></span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_pembelian_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pembelian-Bulan" class="ico-cirlce-widget w_bg_yellow">
			<span><i class="fa fa-calendar"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Pembelian per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_pembelian_supplier'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pembelian-Supplier" class="ico-cirlce-widget w_bg_green">
			<span><i class="fa fa-truck"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Pembelian per Supplier</span>
		</div>
	</div>
</div>

	<?php } if($aksesData['mlap_pembelian_barang_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pembelian-Barang-Periode" class="ico-cirlce-widget w_bg_blue">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Pembelian Barang per Periode</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_pembelian_barang_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Pembelian-Barang-Bulan" class="ico-cirlce-widget w_bg_purple">
			<span><i class="fa fa-calendar"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Pembelian Barang per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_pembelian_rekap_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Pembelian-Periode" class="ico-cirlce-widget w_bg_pink">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Pembelian per Periode</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_pembelian_rekap_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Pembelian-Bulan" class="ico-cirlce-widget w_bg_orange">
			<span><i class="fa fa-calendar"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Pembelian per Bulan & Tahun</span>
		</div>
	</div>
</div>
<?php
}
}
?>