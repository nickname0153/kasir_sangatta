<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_bulan'] == "Yes") {

# Bulan dan Tahun Terpilih
$bulan		= isset($_GET['bulan']) ? $_GET['bulan'] : date('m'); // Baca dari URL, jika tidak ada diisi bulan sekarang
$dataBulan 	= isset($_POST['cmbBulan']) ? $_POST['cmbBulan'] : $bulan; // Baca dari form Submit, jika tidak ada diisi dari $bulan

$tahun	   	= isset($_GET['tahun']) ? $_GET['tahun'] : date('Y'); // Baca dari URL, jika tidak ada diisi tahun sekarang
$dataTahun 	= isset($_POST['cmbTahun']) ? $_POST['cmbTahun'] : $tahun; // Baca dari form Submit, jika tidak ada diisi dari $tahun

# Membuat Filter Bulan
if($dataTahun and $dataBulan) {
	if($dataBulan == "00") {
		// Jika tidak memilih bulan
		$filterSQL = "AND LEFT(p.tgl_pembelian,4)='$dataTahun'";
	}
	else {
		// Jika memilih bulan dan tahun
		$filterSQL = "AND LEFT(p.tgl_pembelian,4)='$dataTahun' AND MID(p.tgl_pembelian,6,2)='$dataBulan'";
	}
}
else {
	$filterSQL = "";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
		// Buka file
		echo "<script>";
		echo "window.open('cetak/pembelian_bulan.php?bulan=$dataBulan&tahun=$dataTahun')";
		echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM pembelian As p, pembelian_item As pi
			WHERE p.no_pembelian = pi.no_pembelian 
			$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Pembelian Per Bulan / Tahun</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Pembelian">Laporan Data Pembelian</a></li>
                    <li class="active-page">Laporan Data Pembelian Per Bulan / Tahun</li>
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
                <span class="h-icon"><i class="fa fa-filter"></i></span>
                <h4>Filter Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li>
                  <div class="widget-switch">
                    <input type="checkbox" class="w-on-off" checked/>
                  </div>
                 </li>
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <div class="col-md-2"><strong>Periode Bulan :</strong></div>
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
        </select></div>
        <div class="col-md-2">
          <select name="cmbTahun" class="form-control">
            <?php
		# Baca tahun terendah(kecil), dan tahun tertinggi(besar) di tabel Transaksi
		$thnSql = "SELECT MIN(LEFT(tgl_pembelian,4)) As tahun_kecil, MAX(LEFT(tgl_pembelian,4)) As tahun_besar FROM pembelian";
		$thnQry	= mysql_query($thnSql, $koneksidb) or die ("Error".mysql_error());
		$thnRow	= mysql_fetch_array($thnQry);
		
		// Membaca tahun
		$thnKecil = $thnRow['tahun_kecil'];
		$thnBesar = $thnRow['tahun_besar'];
		
		// Menampilkan daftar Tahun, dari tahun terkecil sampai Terbesar (tahun sekarang)
		for($thn= $thnKecil; $thn <= $thnBesar; $thn++) {
			if ($thn == $dataTahun) {
				$cek = " selected";
			} else { $cek=""; }
			echo "<option value='$thn' $cek>$thn</option>";
		}
	  ?>
        </select></div>
      	<input name="btnTampil" class="btn btn-success" type="submit" value=" Tampilkan " />
          <input name="btnCetak" class="btn btn-primary" type="submit"  value=" Cetak " />
    
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
                <span class="h-icon"><i class="fa fa-calendar"></i></span>
                <h4><strong>Transaksi Penjualan Barang per Bulan: <?php echo $listBulan[$dataBulan]; ?> , <?php echo $dataTahun; ?></strong></h4>
                <ul class="widget-action-bar pull-right">
               
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="21" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="80" bgcolor="#CCCCCC"><strong>Tgl. Nota </strong></td>
    <td width="90" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="172" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="226" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Total Barang</strong> </td>
    <td width="140" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
  	// Variabel data
	$grandTotalHarga	= 0;
	$grandTotalBarang	= 0;
	
	# Perintah untuk menampilkan pembelian dengan Filter Periode
	$mySql = "SELECT p.*, supplier.nm_supplier FROM pembelian_item As pi, pembelian As p
			LEFT JOIN supplier ON p.kd_supplier = supplier.kd_supplier
			WHERE p.no_pembelian = pi.no_pembelian
			$filterSQL 
			ORDER BY p.no_pembelian DESC LIMIT $halaman, $barisData";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = $halaman;
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		# Membaca Kode pembelian/ Nomor transaksi
		$noNota = $myData['no_pembelian'];
		
		# Menghitung Total Tiap Transaksi
		$my2Sql = "SELECT SUM(harga_beli * jumlah) As total_belanja,
						  SUM(jumlah) As total_barang 
						  FROM pembelian_item WHERE no_pembelian='$noNota'";
		$my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);
		
	// Menjumlah Total Semua Transaksi yang ditampilkan
	$grandTotalHarga	= $grandTotalHarga + $my2Data['total_belanja'];
	$grandTotalBarang	= $grandTotalBarang + $my2Data['total_barang'];
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td width="40" align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr class="info info-active">
    <td colspan="5" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($grandTotalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($grandTotalHarga); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="5" align="right"><strong>Halaman ke :
    <?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $barisData * $h - $barisData;
		echo " <a href='?open=Laporan-Pembelian-Bulan&hal=$list[$h]&bulan=$dataBulan&tahun=$dataTahun'>$h</a> ";
	}
	?>
    </strong></td>
  </tr>
</table>
<a href="cetak/pembelian_bulan.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/pembelian_bulan_excel.php?bulan=<?php echo $dataBulan; ?>&tahun=<?php echo $dataTahun; ?>">Export ke Excel</a>

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
