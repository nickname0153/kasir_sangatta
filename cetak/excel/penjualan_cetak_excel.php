<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Pembelian_Cetak.xls");

	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel Penjualan
	$mySql = "SELECT penjualan.*, pelanggan.nm_pelanggan, user.nm_user FROM penjualan 
				LEFT JOIN user ON penjualan.kd_user = user.kd_user 
				LEFT JOIN pelanggan ON penjualan.kd_pelanggan = pelanggan.kd_pelanggan
				WHERE penjualan.no_penjualan='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);

?>

<h2> PENJUALAN </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="142"><b>No. Nota </b></td>
    <td width="10"><b>:</b></td>
    <td width="270" valign="top"><strong><?php echo $myData['no_penjualan']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Nota </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
  </tr>
  <tr>
    <td><b>Pelanggan</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_pelanggan']; ?></td>
  </tr>
  <tr>
    <td><strong>Keterangan</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['keterangan']; ?></td>
  </tr>
  <tr>
    <td><strong>Kasir</strong></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_user']; ?></td>
  </tr>
  <tr>
    <td align="center">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
</table>

<table class="table-list" width="750" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td colspan="7" bgcolor="#CCCCCC"><strong>DAFTAR BARANG </strong></td>
  </tr>
  <tr>
    <td width="29" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="61" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="312" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="104" align="right" bgcolor="#F5F5F5"><b> Harga (Rp) </b></td>
    <td width="55" align="right" bgcolor="#F5F5F5"><strong>Disc(%)</strong></td>
    <td width="55" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
    <td width="98" align="right" bgcolor="#F5F5F5"><strong>SubTotal(Rp) </strong></td>
  </tr>
  <?php
  	// Buat variabel
	$hasilSubTotal	= 0;
	$hasilGrandTotal	= 0;
	
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
			  LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
			  WHERE penjualan_item.no_penjualan='$noNota'
			  ORDER BY penjualan_item.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$hargaDiskon	= $myData['harga_jual'] - ( $myData['harga_jual'] * $myData['diskon']/100);
		$hasilSubTotal 	= $myData['jumlah'] * $hargaDiskon;
		$hasilGrandTotal= $hasilGrandTotal + $hasilSubTotal;
	?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($hasilSubTotal); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="6" align="right"><b> TOTAL (Rp)  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($hasilGrandTotal); ?></strong></td>
  </tr>
</table>