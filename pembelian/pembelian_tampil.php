<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_trans_pembelian'] == "Yes") {

# FILTER PEMBELIAN PER BULAN/TAHUN
# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataBulan and $dataTahun) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "WHERE LEFT(pembelian.tgl_pembelian,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "WHERE LEFT(pembelian.tgl_pembelian,4)='$dataTahun' AND MID(pembelian.tgl_pembelian,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error paging: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<div class="page-breadcrumb">
					<div class="row">
						<div class="col-md-7">
							<div class="page-breadcrumb-wrap">
								<div class="page-breadcrumb-info">
									<h2 class="breadcrumb-titles">Data Transaksi Pembelian</h2>
									<ul class="list-page-breadcrumb">
										<li><a href="#">Home</a>
										</li>
										<li><a href="?open=Pembelian-Baru">Pembelian Barang</a>
										</li>
										<li class="active-page"> Data Transaksi Pembelian</li>
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
									 <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
 	<div class="col-md-2"><strong>Bulan Pembelian : </strong></div>
      	<div class="col-md-2">
      	<select class="form-control" name="cmbBulan">
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
          <select class="form-control" name="cmbTahun">
            <?php
		# Baca tahun terendah(awal) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pembelian,4)) As tahun FROM pembelian";
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
    
</form>
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
									 <table class="table table-striped table-responsive" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <th width="20" align="center"><strong>No</strong></th>
    <th width="85"><strong>Tgl. Nota </strong></th>
    <th width="78"><strong>No. Nota </strong></th>
    <th width="225"><strong>Supplier </strong></th>
    <th width="195"><strong>Keterangan</strong></th>
    <th width="35" align="right"><strong>Diskon</strong></th>
    <th width="130" align="right"><strong>Total Belanja(Rp) </strong></th>
    <th width="130" align="right"><strong>DP(Rp) </strong></th>
    <th width="130" align="right"><strong>Sisa(Rp) </strong></th>
    <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Aksi</strong></td>
  </tr>
  <?php
	  // Skrip menampilkan data dari database
	$mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
			 LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			 $filterSQL
			 ORDER BY no_pembelian DESC LIMIT $halaman, $baris";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor = $halaman; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode = $myData['no_pembelian'];
		
		// Skrip menghitung total belanja dari tiap Nomor Transaksi
		$my2Sql = "SELECT SUM(harga_beli * jumlah) AS total_belanja, 
						   SUM(jumlah) AS total_barang
						   FROM pembelian_item WHERE no_pembelian = '$Kode'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my2Data = mysql_fetch_array($my2Qry);

		// Counting Sisa

		$query = "SELECT SUM(pembelian_item.harga_beli * pembelian_item.jumlah - pembelian.dp) 
					AS sisa
					FROM pembelian_item RIGHT JOIN pembelian 
					ON pembelian_item.no_pembelian = pembelian.no_pembelian
					WHERE pembelian_item.no_pembelian = '$Kode'";
		$my3Qry = mysql_query($query, $koneksidb)  or die ("Query salah : ".mysql_error());
		$my3Data = mysql_fetch_array($my3Qry);
		
		if ($myData['keterangan'] == 'Kredit') {
			$sisa = $my3Data['sisa'];
		}else{
			$sisa = 0;
		}
		

			// gradasi warna
			if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td><?php echo $myData['diskon']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td align="right"><?php echo format_angka($myData['dp']); ?></td>
    <td align="right"><?php echo format_angka($sisa); ?></td>
    <td width="43" align="center"><a href="../cetak/pembelian_cetak.php?noNota=<?php echo $Kode; ?>" target="_blank">Cetak</a></td>
    <td width="43" align="center"><a href="?open=Pembelian-Hapus&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBELIAN INI ... ?')">Hapus</a></td>
  </tr>
   <?php } ?>
 <tr>
    <td colspan="4"><b>Jumlah Data : <?php echo $jmlData; ?></b> </td>
    <td colspan="6" align="right"><b>Halaman ke : </b>
      <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Pembelian-Tampil&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
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
