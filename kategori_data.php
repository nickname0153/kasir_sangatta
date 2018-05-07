<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_kategori'] == "Yes") { ?>

<div class="section-header">
      <h2>Data Kategori</h2>
        <a href="?open=Kategori-Add" class="btn btn-primary">Tambah Data</a>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="8%"><strong>No</strong></th>
                  <th width="15%"><strong>Kode</th>
                  <th><strong>Nama Kategori </strong></th>
                  <td align="center"><strong>Aksi</strong></td>
                  <th style="display:none;"></th>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $mySql = "SELECT * FROM kategori $filterSQL ORDER BY kd_kategori ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_kategori'];
      
    ?>
      <tr=>
        <td ><?php echo $nomor; ?></td>
        <td ><?php echo $myData['kd_kategori']; ?></td>
        <td ><?php echo $myData['nm_kategori']; ?></td>
        <td width="7%" align="center"><a href="?open=Kategori-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-success" target="_self">Ubah</a></td>
        <td width="7%" align="center"><a href="?open=Kategori-Delete&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-danger" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA KATEGORI INI ... ?')">Hapus</a></td>
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

