<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Supplier.xls");

?>
<h2>LAPORAN DATA SUPPLIER </h2>
<table class="table-list" width="739" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="34" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="66" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="148" bgcolor="#F5F5F5"><strong>Nama Supplier </strong></td>
    <td width="351" bgcolor="#F5F5F5"><strong>Alamat Lengkap </strong></td>
    <td width="114" bgcolor="#F5F5F5"><strong>No. Telepon </strong></td>
  </tr>
  <?php
  	// Skrip menampilkan data dari database
	$mySql = "SELECT * FROM supplier ORDER BY nm_supplier ASC";
	$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_supplier']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['alamat']; ?></td>
    <td><?php echo $myData['no_telepon']; ?></td>
  </tr>
  <?php } ?>
</table>