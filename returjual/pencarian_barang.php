<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";

?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>PENCARIAN BARANG</title>
<link href="../styles/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self" id="form1">
<div class="section-header">
      <h2>Data Barang</h2>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <td width="23"><strong>No</strong></td>
              <td width="54" ><strong>Kode</strong></td>
              <td width="102"><strong>Barcode/ PLU</strong></td>
              <td width="360"><strong>Nama Barang </strong></td>
              <td width="46" ><strong>Satuan</strong></td>
              <td width="135"><strong>Jenis</strong></td>
              <td width="22" align="center" ><strong>Diskon</strong></td>
              <td width="32" align="center" ><strong>Stok</strong></td>
              <td width="101" align="right" ><strong>Hrg Jual (Rp)</strong></td>
                </tr>
              </thead>
            <tbody>
                  <?php
  # MENJALANKAN QUERY FILTER DI ATAS
  $mySql  = "SELECT barang.*, jenis.nm_jenis FROM barang 
          LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis 
        ORDER BY barang.kd_barang ";
  $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
  $nomor  = $hal; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    $Kode = $myData['kd_barang'];

    // gradasi warna
    if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
    
    // Warna peringatan Harga (jika sama / rugi)
    if($myData['harga_jual'] <= $myData['harga_beli']) {
      $warna_harga  = "#FF3300";
    }
    else {
      $warna_harga  = "";
    }
    
    // Warna peringatan Stok Opname
    if($myData['stok'] > 3) {
      $warna_stok = "";
    }
    elseif($myData['stok'] >= 0) {
      $warna_stok = "#FFCC00"; // Merah
    }
    else {
      $warna_stok = "";
    }
  ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td> 
      <a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
                 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
                 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual']; ?>';
                 window.opener.document.getElementById('txtDisc').value = '<?php echo $myData['diskon']; ?>';
                 window.close();"> <b><?php echo $myData['kd_barang']; ?> </b> </a>   </td>
        <td>
      <a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
                 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
                 window.opener.document.getElementById('txtHarga').value = '<?php echo $myData['harga_jual']; ?>';
                 window.opener.document.getElementById('txtDisc').value = '<?php echo $myData['diskon']; ?>';
                 window.close();"> <b><?php echo $myData['barcode']; ?> </b> </a>   </td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['satuan_jual']; ?></td>
        <td><?php echo $myData['nm_jenis']; ?></td>
        <td align="center"><?php echo $myData['diskon']; ?></td>
        <td align="center" bgcolor="<?php echo $warna_stok; ?>"><?php echo $myData['stok']; ?></td>
        <td align="right" bgcolor="<?php echo $warna_harga; ?>"><?php echo format_angka($myData['harga_jual']); ?></td>
        </tr>
      <?php } ?>      
                 </tbody>
                  </table>
              </div>
            </div>
           </div>
       </form>

</body>
</html>
 