<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_merek'] == "Yes") { ?>

<div class="section-header">
      <h2>Data Merek</h2>
        <a href="?open=Merek-Add" class="btn btn-primary">Tambah Data</a>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="8%"><strong>No</strong></th>
                  <th ><strong>Kode </strong></th>
                  <th ><strong>Nama Merek</strong></th>
                  <th ><strong><center>Aksi</center></strong></th>
                  <th style="display:none;"></th>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $mySql = "SELECT * FROM merek $filterSQL ORDER BY kd_merek ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = 0; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_merek'];
      
    ?>
      <tr >
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_merek']; ?></td>
        <td><?php echo $myData['nm_merek']; ?></td>
        <td width="7%" align="center"><a href="?open=Merek-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-success" target="_self">Ubah</a></td>
        <td width="7%" align="center"><a href="?open=Merek-Delete&Kode=<?php echo $Kode; ?>" class="btn btn-danger" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA MEREK INI ... ?')">Hapus</a></td>
      </tr>
  <?php } ?>       
                 </tbody>
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

