<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_kategorisub'] == "Yes") {
?>
<h2> DAFTAR SUB KATEGORI </h2>
<table class="table-list" width="600" border="0" cellspacing="1" cellpadding="2">
  <tr>
    <td width="23" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="83" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="240" bgcolor="#CCCCCC"><strong>Nama Sub Kategori </strong></td>
    <td width="233" bgcolor="#CCCCCC"><strong>Kategori </strong></td>
  </tr>
	<?php
	// Skrip menampilkan data dari database
	$mySql 	= "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori_sub
					LEFT JOIN kategori ON kategori_sub.kd_kategori = kategori.kd_kategori
					ORDER BY kategori_sub.kd_kategorisub";
	$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
	$nomor  = 0; 
	while ($myData = mysql_fetch_array($myQry)) {
		$nomor++;
	?>
  <tr>
    <td align="center"><?php echo $nomor; ?></td>
    <td><?php echo $myData['kd_kategorisub']; ?></td>
    <td><?php echo $myData['nm_kategorisub']; ?></td>
    <td><?php echo $myData['nm_kategori']; ?></td>
  </tr>
  <?php } ?>
</table>
<a href="cetak/kategori_sub.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
