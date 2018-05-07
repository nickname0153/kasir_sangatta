<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_jenis'] == "Yes") {
?>
<h2> DAFTAR JENIS</h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="83" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="240" bgcolor="#CCCCCC"><strong>Nama Jenis</strong></td>
    <td width="233" bgcolor="#CCCCCC"><strong>Sub Kategori </strong></td>
  </tr>
	<?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT jenis.*, kategori_sub.nm_kategorisub FROM jenis
					LEFT JOIN kategori_sub ON jenis.kd_kategorisub = kategori_sub.kd_kategorisub
					ORDER BY jenis.kd_jenis";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_jenis']; ?></td>
    <td><?php echo $myData['nm_jenis']; ?></td>
    <td><?php echo $myData['nm_kategorisub']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="cetak/jenis.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
