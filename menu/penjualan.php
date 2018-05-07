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
                  <h2 class="breadcrumb-titles">Laporan Data Penjualan</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li class="active-page">Laporan Data Penjualan</a></li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>


	<?php if($aksesData['mlap_penjualan_barang_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Barang-Periode" class="ico-cirlce-widget w_bg_green">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan Barang per Periode</span>
		</div>
	</div>
</div>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Piutang-Periode" class="ico-cirlce-widget w_bg_teal">
			<span><i class="fa fa-credit-card"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Piutang per Periode<br>&nbsp;<br></span>
		</div>
	</div>
</div>


<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Kasir-Periode" class="ico-cirlce-widget w_bg_blue_grey">
			<span><i class="fa fa-desktop"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan per Kasir Periode</span>
		</div>
	</div>
</div>

	
	<?php } if($aksesData['mlap_penjualan_barang_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Barang-Bulan" class="ico-cirlce-widget w_bg_yellow">
			<span><i class="fa fa-bar-chart"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan Barang per Bulan</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_penjualan_rekap_periode'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Penjualan-Periode" class="ico-cirlce-widget w_bg_red">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Penjualan per Periode</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_penjualan_rekap_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Rekap-Penjualan-Bulan" class="ico-cirlce-widget w_bg_purple">
			<span><i class="fa fa-bar-chart"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Rekap Penjualan per Bulan & Tahun</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_penjualan_terlaris'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Terlaris" class="ico-cirlce-widget w_bg_blue">
			<span><i class="fa fa-line-chart"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan Barang Terlaris</span>
		</div>
	</div>
</div>

	<?php }  if($aksesData['mlap_penjualan_periode'] == "Yes") { ?>

	<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Periode" class="ico-cirlce-widget w_bg_cyan">
			<span><i class="fa fa-clock-o"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan per Periode<br>&nbsp;</span>
		</div>
	</div>
</div>
	
	<?php } if($aksesData['mlap_penjualan_bulan'] == "Yes") { ?>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Bulan" class="ico-cirlce-widget w_bg_pink">
			<span><i class="fa fa-bar-chart"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan per Bulan<br>&nbsp;</span>
		</div>
	</div>
</div>

<div class="col-md-3">
	<div class="iconic-w-wrap icon-only">
		<a href="?open=Laporan-Penjualan-Keseluruhan-Bulan" class="ico-cirlce-widget w_bg_light_green">
			<span><i class="fa fa-th-list"></i></span></a>
		<div class="w-meta-info">
			<span class="w-meta-value">Laporan Penjualan Keseluruhan per Bulan</span>
		</div>
	</div>
</div>

<?php
}
}
?>