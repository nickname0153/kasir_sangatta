<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_kategorisub'] == "Yes") {

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM kategori_sub";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<table width="985" border="0" cellpadding="2" cellspacing="1" class="table-border">
  <tr>
    <td colspan="2" align="left"><h1><b>DATA SUB KATEGORI</b></h1></td>
  </tr>
  <tr>
    <td colspan="2"><a href="?open=Kategori-Sub-Add" target="_self"><img src="images/btn_add_data.png" height="30" border="0"  /></a></td>
  </tr>
  <tr>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2">
	<table class="table table-striped table-responsive"  width="100%" border="0" cellspacing="1" cellpadding="3">
      <tr>
        <th width="3%"><strong>No</strong></th>
        <th width="11%"><strong>Kode</strong></th>
        <th width="35%"><strong>Nama Sub Kategori </strong></th>
        <th width="37%">Kategori</th>
        <td colspan="2" align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
        </tr>
		<?php
		// Skrip menampilkan data dari database
		$mySql = "SELECT kategori_sub.*, kategori.nm_kategori FROM kategori_sub
					LEFT JOIN kategori ON kategori_sub.kd_kategori = kategori.kd_kategori
					ORDER BY kategori_sub.kd_kategorisub ASC LIMIT $halaman, $baris";
		$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$nomor = $halaman; 
		while ($myData = mysql_fetch_array($myQry)) {
			$nomor++;
			$Kode = $myData['kd_kategorisub'];
			
			// gradasi warna
			if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
		?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_kategorisub']; ?></td>
        <td><?php echo $myData['nm_kategorisub']; ?></td>
        <td><?php echo $myData['nm_kategori']; ?></td>
        <td width="7%" align="center"><a class='btn btn-success' href="?open=Kategori-Sub-Edit&Kode=<?php echo $Kode; ?>" target="_self">Edit</a></td>
        <td width="7%" align="center"><a class='btn btn-danger' href="?open=Kategori-Sub-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SUB KATEGORI INI ... ?')">Delete</a></td>
      </tr>
	<?php } ?>
    </table></td>
  </tr>
  <tr class="selKecil">
    <td width="350"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
    <td width="339" align="right"><strong>Halaman ke :</strong> 
	<?php
	for ($h = 1; $h <= $maksData; $h++) {
		$list[$h] = $baris * $h - $baris;
		echo " <a href='?open=Kategori-Sub-Data&hal=$list[$h]'>$h</a> ";
	}
	?></td>
  </tr>
</table>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>

