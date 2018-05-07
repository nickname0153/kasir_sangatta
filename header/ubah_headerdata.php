<?php

include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_header'] == "Yes") {

error_reporting(0);
?>
<div class="box-widget widget-module">
  <div class="widget-head clearfix">
  <span class="h-icon"><i class="fa fa-bars"></i></span>
    <h4>Ubah Data Perushaan</h4>
  </div>
    <div class="widget-container">
      <div class=" widget-block">
	<table class="table table-striped table-responsive" width="100%" border="0" cellspacing="1" cellpadding="2">
        <?php 
      	$mySql = "SELECT * FROM tb_header ORDER BY nama ASC";
		$myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
		$no  = 1; 
		$myData = mysql_fetch_array($myQry)

        ?>
        <tr>
            <td width="15%">Nama Perusahaan</td>
            <td width="1%">:</td>
        	<td width='80%'><?php echo $myData['nama']; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $myData['alamat']; ?></td>
       </tr>
       <tr>
            <td>Telepon</td>
            <td>:</td>
            <td><?php echo $myData['telp']; ?></td>
       </tr>
      <?php /**       <tr>
            <td>Preview Logo</td>
            <td>:</td>
            <td><?php echo "<img src='images/$myData[thumbnail]' height='60' width='520' >" ?></td>
       </tr> **/ ?>
       <tr>
        <td colspan="3"><a class="btn btn-primary" href="?open=Ubah-Profil&Kode=<?php echo $myData['id']; ?>">Ubah</a></td>
       </tr>
	</table>
</div>
</div>
</div>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>