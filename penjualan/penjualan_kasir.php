<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_penjualan'] == "Yes") {
?>
<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Penjualan Barang</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										<li><a href="?open=Penjualan-Baru">Penjualan Baru</a></li>
										<li><a href="?open=Penjualan-Tampil">Tampil Penjualan</a></li>
										<li><a href="?open=Penjualan-Barcode">Tampil Penjualan Barcode</a></li>
										<li class="active-page">Tampil Penjualan per Kasir</li>
									</ul>
									</ul>
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
								 <table class="table dt-table">
              <thead>
                <tr>
                  <th width="5%" align="center">No</th>
    <th >Tanggal </th>
    <th >Nama Kasir</th>
    <th >Pendapatan</th>
    <th align="center"><strong>Aksi</strong></th>
                </tr>
              </thead>
            <tbody>
<?php
   $query = mysql_query("SELECT SUM((b.harga_jual - (b.harga_jual * b.diskon/100)) * pi.jumlah) AS 
            pendapatan, p.tgl_penjualan, u.nm_user, u.kd_user 
            FROM penjualan as p LEFT JOIN user u ON p.kd_user = u.kd_user
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
            GROUP BY p.tgl_penjualan");   

  $no=1;
  		while($myData = mysql_fetch_array($query)):
 	$ambilJam = substr($myData['waktu'], 12,8); 
    ?>
      <tr>
        <td><?php echo $no; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo format_angka($myData['pendapatan']); ?></td>
    <td><a href="kasir_nota.php?user=<?php echo $myData['kd_user']; ?>&tgl=<?php echo $myData['tgl_penjualan']; ?>" target="_blank">Nota</a>
    </td>
      </tr>
  <?php $no++;endwhile; ?>      
                 </tbody>
                  </table>
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
