<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_Excel.xls");

?>

<h2>LAPORAN DATA MEREK </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="29" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="86" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="469" bgcolor="#F5F5F5"><strong>Nama Merek </strong></td>
  </tr>
  <?php
  // Skrip menampilkan data dari database
	$mySql 	= "SELECT * FROM merek ORDER BY kd_merek";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_merek']; ?></td>
    <td><?php echo $myData['nm_merek']; ?></td>
  </tr>
  <?php } ?>
</table>