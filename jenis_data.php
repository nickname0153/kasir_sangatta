<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_jenis'] == "Yes") {
?>

 <div class="section-header">
      <h2>Data Jenis</h2>
        <a href="?open=Jenis-Add" class="btn btn-primary">Tambah Data</a>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="3%"><strong><center>No</center></strong></th>
        <th width="15%"><strong>Kode</strong></th>
        <th width="25%"><strong>Nama Jenis</strong></th>
        <th width="25%"><strong>Kategori</strong></th>
        <td align="center"><strong>Aksi</strong></td>
                  <th style="display:none;"></th>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $mySql = "SELECT jenis.*, kategori.nm_kategori FROM jenis
          INNER JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
          ORDER BY jenis.kd_jenis ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_jenis'];
  
    ?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td ><?php echo $myData['kd_jenis']; ?></td>
        <td ><?php echo $myData['nm_jenis']; ?></td>
        <td > <a href="?open=Kategori-Data&nama=<?php echo $myData['nm_kategori']; ?>"> <?php echo $myData['nm_kategori']; ?> </a></td>
        <td width="7%" align="center"><a class='btn btn-success' href="?open=Jenis-Edit&Kode=<?php echo $Kode; ?>" target="_self">Ubah</a></td>
        <td width="7%" align="center"><a class='btn btn-danger' href="?open=Jenis-Delete&Kode=<?php echo $Kode; ?>" target="_self" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA JENIS INI ... ?')">Hapus</a></td>
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

