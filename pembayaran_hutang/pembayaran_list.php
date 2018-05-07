<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_jenis'] == "Yes") {
?>

 <div class="section-header">
      <h2>Data Hutang</h2>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="3%"><strong><center>No</center></strong></th>
        <th width="15%"><strong>Kode Supplier</strong></th>
         <th width="15%"><strong>Tanggal</strong></th>
        <th width="25%"><strong>Nama Supplier</strong></th>
        <th width="25%"><strong>Hutang (Rp)</strong></th>
        <th width="10%"><strong>Keterangan</strong></th> 
        <td width="5%" align="center"><strong>Aksi</strong></td>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $cicilan = 0;
    $mySql = "SELECT p.*,s.nm_supplier, s.kd_supplier,
              p.tgl_pembelian,
              SUM(pi.harga_beli * pi.jumlah) as semua,
              SUM(p.dp) as ew
              FROM pembelian as p
              LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian
              LEFT JOIN supplier s ON p.kd_supplier = s.kd_supplier
              WHERE p.keterangan = 'Kredit'
              GROUP BY p.kd_supplier
              ORDER BY p.no_pembelian ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_jenis'];
      $kds = $myData['kd_supplier']; 

    $query25 = mysql_query("SELECT SUM(pembelian_bayar.uang_bayar) as sisa FROM pembelian_bayar WHERE kd_supplier = '$kds' ");
     $rs = mysql_fetch_array($query25);
     $cicilan = $rs['sisa'];
     $duit = $myData['ew'];
     $sisaTotal = $duit + $cicilan - $myData['semua'];

    ?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $kds; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_pembelian']); ?></td>
        <td><?php echo $myData['nm_supplier']; ?></td>
        <td><?php echo number_format($myData['semua']); ?></td>
       <?php if ($sisaTotal == 0) { echo "<td class='success' align='center'><b>LUNAS</b></td>"; }else{ echo "<td class='danger' align='center'><b>BELUM LUNAS</b></td>"; } ?>
        <td> <a href="?open=Bayar&Kode=<?php echo $myData['kd_supplier']; ?>"
         class="btn btn-success">Detail</a> </td>
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

