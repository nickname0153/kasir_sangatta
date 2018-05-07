<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_supplier'] == "Yes") {
?>

 <div class="section-header">
              <h2>Data Supplier</h2>
              <a href="?open=Supplier-Add" class="btn btn-primary">Tambah Data</a>
            </div>
           <div class="box-widget widget-module">
              <div class="widget-container">
                <div class=" widget-block">
                  <table class="table dt-table">
                  <thead>
                  <tr>
                    <th width="29" align="center"><b>No</b></th>
        <th width="50"><b><center>Kode</center></b></th>
        <th><b><center>Nama Supplier </center></b></th>
        <th><b><center>Alamat</center></b></th>
        <th><b><center>No. Telp</center></b></th>
        <th><b>Aksi</b></th>
                      <th style="display:none;"></th>
                  </tr>
                  </thead>
                  <tbody>
                 <?php
    // Skrip menampilkan data dari database
    $mySql = "SELECT * FROM supplier $filterSQL ORDER BY kd_supplier ASC ";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor  = 0; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_supplier'];
    ?>
      <tr>
        <td ><?php echo $nomor; ?></td>
        <td ><?php echo $myData['kd_supplier']; ?></td>
        <td ><?php echo $myData['nm_supplier']; ?></td>
        <td ><?php echo $myData['alamat']; ?></td>
        <td ><?php echo $myData['no_telepon']; ?></td>
        <td width="43" align="center"><a href="?open=Supplier-Edit&Kode=<?php echo $Kode; ?>" class="btn btn-success" target="_self" alt="Edit Data">Ubah</a></td>
        <td width="47" align="center"><a href="?open=Supplier-Delete&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-danger" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA SUPPLIER INI ... ?')">Hapus</a></td>
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
