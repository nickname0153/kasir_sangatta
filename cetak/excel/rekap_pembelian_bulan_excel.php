<?php 
include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Rekap_pembelian_bulan.xls");

$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

# MEMBUAT SQL FILTER PER BULAN & TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(p.tgl_pembelian,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND MID(p.tgl_pembelian,6,2)='$dataBulan' AND LEFT(p.tgl_pembelian,4)='$dataTahun'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}

 ?>

 <h2>LAPORAN REKAP PEMBELIAN BARANG PER BULAN/ TAHUN</h2>
<table width="500" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#CCCCCC"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="134"><strong> Bulan Penjualan </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="337"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="56" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="487" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="59" align="center" bgcolor="#CCCCCC"><strong>Jumlah</strong></td>
    <td width="147" align="right" bgcolor="#CCCCCC"><strong> Total Belanja (Rp) </strong></td>
  </tr>
  <?php
	// variabel
	$jumlahBeli = 0;
	$jumlahBelanja = 0;
	
	// Menampilkan daftar Baran yang dibeli pada Bulan terpilih
	$mySql = "SELECT barang.kd_barang, barang.nm_barang 
				FROM pembelian As p, pembelian_item As pi
				LEFT JOIN barang ON pi.kd_barang= barang.kd_barang
				WHERE p.no_pembelian = pi.no_pembelian 
				GROUP BY barang.kd_barang
				$filterSQL ORDER BY barang.kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_barang'];
		
		// Menghitung / rekap total belanja per Kode barang
		$my2Sql = "SELECT SUM(jumlah) As total_barang, SUM(harga_beli * jumlah) As total_belanja 
				  FROM pembelian_item WHERE kd_barang ='$Kode'"; 
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		$jumlahBeli = $jumlahBeli + $my2Data['total_barang'];
		$jumlahBelanja = $jumlahBelanja + $my2Data['total_belanja'];
		
		// gradasi warna
		if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
	?>
  <tr bgcolor="<?php echo $warna; ?>">
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="center"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="3" align="right"><strong>GRAND TOTAL :</strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong><?php echo format_angka($jumlahBeli); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($jumlahBelanja); ?></strong></td>
  </tr>
</table>