<?php
session_start();
include_once "../library/inc.seslogin.php";
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

// Membuat daftar bulan
$listBulan = array("01" => "Januari", "02" => "Februari", "03" => "Maret",
				 "04" => "April", "05" => "Mei", "06" => "Juni", "07" => "Juli",
				 "08" => "Agustus", "09" => "September", "10" => "Oktober",
				 "11" => "November", "12" => "Desember");

// Membaca data Bulan dan Tahun dari URL
$dataTahun = isset($_GET['tahun']) ? $_GET['tahun'] : date('Y');
$dataBulan = isset($_GET['bulan']) ? $_GET['bulan'] : date('m');

# MEMBUAT FILTER BERDASARKAN TANGGAL & TAHUN
if($dataBulan and $dataTahun) {
	if($dataBulan=="00") {
		// Filter tahun
		$filterSQL	= "AND LEFT(r.tgl_returjual,4)='$dataTahun'";
		
		$infoBulan	= "";
	}
	else {
		// Filter bulan dan tahun
		$filterSQL = "AND LEFT(r.tgl_returjual,4)='$dataTahun' AND MID(r.tgl_returjual,6,2)='$dataBulan'";
		
		$infoBulan	= $listBulan[$dataBulan].", ";
	}
}
else {
	$filterSQL = "";
}
?>
<html>
<head>
<title> :: Laporan Rekap Retur Barang per Bulan/Tahun - Program Minimarket</title>
<link href="../styles/styles_cetak.css" rel="stylesheet" type="text/css">
</head>
<body>
<h2>LAPORAN REKAP RETUR BARANG PER BULAN/ TAHUN</h2>
<table width="400" border="0"  class="table-list">
  <tr>
    <td colspan="3" bgcolor="#F5F5F5"><strong>KETERANGAN</strong></td>
  </tr>
  <tr>
    <td width="147"><strong>Periode Bulan/Tahun </strong></td>
    <td width="15"><strong>:</strong></td>
    <td width="224"><?php echo $infoBulan.$dataTahun; ?></td>
  </tr>
</table>
<br />
<table class="table-list" width="900" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="26" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="51" bgcolor="#F5F5F5"><b>Kode</b></td>
    <td width="448" bgcolor="#F5F5F5"><b>Nama Barang </b></td>
    <td width="136" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
    <td width="136" bgcolor="#F5F5F5"><strong>Merek</strong></td>
    <td width="72" align="right" bgcolor="#F5F5F5"><b>Jumlah</b></td>
  </tr>
  <?php
	// variabel
	$jumlahRetur = 0;
	
	// Menampilkan daftar Barang yang diretur pada Bulan terpilih
	$mySql = "SELECT barang.kd_barang, barang.nm_barang, jenis.nm_jenis, merek.nm_merek 
				FROM returjual As r, returjual_item As ri
				LEFT JOIN barang ON ri.kd_barang= barang.kd_barang
				LEFT JOIN jenis ON barang.kd_jenis = jenis.kd_jenis
				LEFT JOIN merek ON barang.kd_merek = merek.kd_merek
				WHERE r.no_returjual = ri.no_returjual 
				$filterSQL ORDER BY barang.kd_barang ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
	$nomor = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$Kode	= $myData['kd_barang'];
		
		// Menghitung / rekap total belanja per Kode barang
		$my2Sql = "SELECT SUM(jumlah) As total_barang FROM returjual_item WHERE kd_barang ='$Kode'"; 
		$my2Qry = mysql_query($my2Sql, $koneksidb) or die ("Error 2 Query".mysql_error());
		$my2Data= mysql_fetch_array($my2Qry);

		$jumlahRetur = $jumlahRetur + $my2Data['total_barang'];
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><strong> TOTAL :</strong></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($jumlahRetur); ?></strong></td>
  </tr>
</table>
<img src="../images/btn_print.png" height="20" onClick="javascript:window.print()" />
</body>
</html>