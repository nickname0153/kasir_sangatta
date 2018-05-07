<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_returbeli'] == "Yes") {

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(returbeli.tgl_returbeli,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(returbeli.tgl_returbeli,4)='$dataTahun' AND MID(returbeli.tgl_returbeli,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$hal 		= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM returbeli $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Data Transaksi Retur Pembelian</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										</li>
										<li><a href="?open=Returbeli-Baru">Retur Pembelian Baru</a>
										</li>
										<li class="active-page">Tampil Retur Pembelian</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
</div>


<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
 
 <div class="row">
					<div class="col-md-12">
						<div class="box-widget widget-module">
							<div class="widget-head clearfix">
								<span class="h-icon"><i class="fa fa-search"></i></span>
								<h4>Filter Data</h4>
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
									 <div class="col-md-2">
									 	Bulan Retur
									 </div>
									 <div class="col-md-2">
									 	<select name="cmbBulan" class="form-control">
								          <?php
										// Membuat daftar Nama Bulan
										$listBulan = array("00" => "....", "01" => "01. Januari", "02" => "02. Februari", "03" => "03. Maret",
														 "04" => "04. April", "05" => "05. Mei", "06" => "06. Juni", "07" => "07. Juli",
														 "08" => "08. Agustus", "09" => "09. September", "10" => "10. Oktober",
														 "11" => "11. November", "12" => "12. Desember");
														 
										// Menampilkan Nama Bulan ke ComboBox (List/Menu)
										foreach($listBulan as $bulanKe => $bulanNm) {
											if ($bulanKe == $dataBulan) {
												$cek = " selected";
											} else { $cek=""; }
											echo "<option value='$bulanKe' $cek>$bulanNm</option>";
										}
									  ?>
								        </select>
									 </div>
									 <div class="col-md-2">
									 	<select name="cmbTahun" class="form-control">
								            <?php
										# Baca tahun terendah(awal) di tabel Transaksi
										$thnSql = "SELECT MIN(LEFT(tgl_returbeli,4)) As tahun FROM returbeli";
										$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
										$thnRow	= mysql_fetch_array($thnQry);
										$thnTerkecil = $thnRow['tahun'];
										
										// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
										for($thn= $thnTerkecil; $thn <= date('Y'); $thn++) {
											if ($thn == $dataTahun) {
												$cek = " selected";
											} else { $cek=""; }
											echo "<option value='$thn' $cek>$thn</option>";
										}
									  ?>
								        </select>
									 </div>
									 <input name="btnTampil" type="submit" class="btn btn-primary btn-sm" value="Tampil" />

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
									 <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="30" align="center"><strong>No</strong></th>
    <th width="90"><strong>Tgl. Retur </strong></th>
    <th width="91"><strong>No. Retur </strong></th>
    <th width="201"><strong>Supplier </strong></th>
    <th width="303"><strong>Keterangan</strong></th>
    <th width="250" align="center"><strong>Barang</strong></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
  </tr>
  <?php
	$mySql = "SELECT returbeli.*, supplier.nm_supplier 
			 FROM returbeli 
			 LEFT JOIN supplier ON returbeli.kd_supplier = supplier.kd_supplier
			 ORDER BY no_returbeli DESC LIMIT $hal, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_returbeli'];
		
		// Skrip menghitung total retur dari tiap Nomor Transaksi
		$my2Sql = "SELECT SUM(jumlah) AS total_barang FROM returbeli_item WHERE no_returbeli = '$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_returbeli']); ?></td>
    <td><?php echo $myData['no_returbeli']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td width="42" align="center"><a href="../cetak/returbeli_cetak.php?noNota=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
    <td width="42" align="center"><a href="?open=Returbeli-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA RETUR INI ... ?')">Delete</a></td>
  <?php } ?>
  </tr>
  <tr>
    <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b></td>
    <td colspan="4" align="right"><b>Halaman ke :</b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Returbeli-Tampil&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
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
