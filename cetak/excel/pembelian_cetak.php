<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Pembelian_Cetak.xls");

	# Baca variabel URL
	$noNota = $_GET['noNota'];
	
	# Perintah untuk mendapatkan data dari tabel pembelian
	$mySql = "SELECT pembelian.*,  supplier.nm_supplier, user.nm_user FROM pembelian 
			  LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
			  LEFT JOIN user ON pembelian.kd_user = user.kd_user
			  WHERE pembelian.no_pembelian='$noNota'";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$myData = mysql_fetch_array($myQry);

?>
<h2> PEMBELIAN </h2>
<table width="450" border="0" cellspacing="1" cellpadding="4" class="table-print">
  <tr>
    <td width="154"><b>No. Nota </b></td>
    <td width="10"><b>:</b></td>
    <td width="258" valign="top"><strong><?php echo $myData['no_pembelian']; ?></strong></td>
  </tr>
  <tr>
    <td><b>Tgl. Nota </b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
  </tr>
  <tr>
    <td><b>Supplier</b></td>
    <td><b>:</b></td>
    <td valign="top"><?php echo $myData['nm_supplier']; ?></td>
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

<p><strong>DAFTAR  BARANG </strong></p>
<table class="table-list" width="700" border="0" cellspacing="1" cellpadding="2">
  
  <tr>
    <td width="27" align="center" bgcolor="#F5F5F5"><b>No</b></td>
    <td width="66" bgcolor="#F5F5F5"><strong>Kode </strong></td>
    <td width="320" bgcolor="#F5F5F5"><b>Nama Barang</b></td>
    <td width="92" align="right" bgcolor="#F5F5F5"><b> Harga (Rp) </b></td>
    <td width="60" align="right" bgcolor="#F5F5F5"><b> Jumlah </b></td>
    <td width="104" align="right" bgcolor="#F5F5F5"><strong>SubTotal(Rp) </strong></td>
  </tr>
  <?php
  	// Buat variabel
	$subTotalHarga	= 0;
	$grandTotalHarga	= 0;
	
	// SQL menampilkan item barang yang dijual
	$mySql ="SELECT pembelian_item.*, barang.nm_barang FROM pembelian_item
			  LEFT JOIN barang ON pembelian_item.kd_barang=barang.kd_barang 
			  WHERE pembelian_item.no_pembelian='$noNota'
			  ORDER BY pembelian_item.kd_barang";
	$myQry = mysql_query($mySql, $koneksidb) or die ("Gagal Query Tmp".mysql_error());
	$nomor  = 0;  
	while($myData = mysql_fetch_array($myQry)) {
		$nomor++;
		$subTotalHarga 	= $myData['jumlah'] * $myData['harga_beli'];
		$grandTotalHarga	= $grandTotalHarga + $subTotalHarga;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalHarga); ?></td>
  </tr>
  <?php } ?>
  <tr>
    <td colspan="5" align="right"><b> TOTAL (Rp)  : </b></td>
    <td align="right" bgcolor="#F5F5F5"><strong><?php echo format_angka($grandTotalHarga); ?></strong></td>
  </tr>
</table>