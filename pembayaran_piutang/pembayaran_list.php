<?php
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_jenis'] == "Yes") {
?>

 <div class="section-header">
      <h2>Data Piutang</h2>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="3%"><strong><center>No</center></strong></th>
        <th width="15%"><strong>No. Anggota</strong></th>
        <th width="15%"><strong>Tanggal</strong></th>
        <th width="25%"><strong>Nama</strong></th>
        <th width="25%"><strong>Hutang (Rp)</strong></th>
         <th width="20%"><strong>Keterangan</strong></th>
        <td width="5%" align="center"><strong>Aksi</strong></td>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $mySql = "SELECT p.*, pi.*, pl.nm_pelanggan, pl.no_anggota,
              SUM(pi.harga_jual * pi.jumlah) as semua,
              SUM(pi.harga_jual * b.diskon / 100) * pi.jumlah as discount,
              SUM(p.uang_bayar) as ew,
              p.tgl_penjualan
              FROM penjualan as p
              LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
              LEFT JOIN pelanggan pl ON p.kd_pelanggan = pl.kd_pelanggan
              LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
              WHERE p.keterangan = 'Kredit'
              GROUP BY p.kd_pelanggan
              ORDER BY p.no_penjualan ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_jenis'];
       $kds = $myData['kd_pelanggan'];

       $query25 = mysql_query("SELECT SUM(penjualan_bayar.uang_bayar) as sisa FROM penjualan_bayar WHERE kd_pelanggan = '$kds' ");
     $rs = mysql_fetch_array($query25);
     $cicilan = $rs['sisa'];
     $duit = $myData['ew'] + $myData['discount'];
     $sisaTotal = $duit + $cicilan - $myData['semua'];
  
    ?>
      <tr >
        <td align="center"><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_pelanggan']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
        <td><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo number_format($myData['semua'] - $myData['discount']); ?></td>
         <?php if ($sisaTotal == 0) { echo "<td class='success' align='center'><b>LUNAS</b></td>"; }else{ echo "<td class='danger' align='center'><b>BELUM LUNAS</b></td>"; } ?>
        <td> <a href="?open=Bayar&Kode=<?php echo $myData['kd_pelanggan']; ?>" 
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

