<?php 

include_once "../../library/inc.connection.php";
include_once "../../library/inc.library.php";

header("Content-type=application/vhd.ms-excel");
header("Content-disposition:attachment;filename=Laporan_User.xls");

?>

<h2>LAPORAN DATA USER </h2>
<table class="table-list" width="800" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="25" align="center" bgcolor="#F5F5F5"><strong>No</strong></td>
    <td width="47" bgcolor="#F5F5F5"><strong>Kode</strong></td>
    <td width="465" bgcolor="#F5F5F5"><strong>Nama User </strong></td>
    <td width="131" bgcolor="#F5F5F5"><strong>Username</strong></td>
    <td width="106" bgcolor="#F5F5F5"><strong>Level</strong></td>
  </tr>
  <?php
		// Skrip menampilkan data dari database
		$mySql 	= "SELECT * FROM user ORDER BY kd_user";
		$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor  = 0; 
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_user']; ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo $myData['username']; ?></td>
    <td><?php echo $myData['level']; ?></td>
  </tr>
  <?php } ?>
</table>