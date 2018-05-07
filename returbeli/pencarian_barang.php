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
    <div class="col-md-1">
          	<input type="text" name="kode" autofocus placeholder="Cari Barang ..." class="form-control"></input>
          </div>
          <br>
          <div class="col-md-1">
          	<input type="submit" name="submit" value="Cari" class="btn btn-primary"></input>
          </div>
          <br>
      <div class="box-widget widget-module">
        <div class="widget-container">

          <div class=" widget-block">
            <table class="table table-bordered table-responsive">
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
			        <td width="101" align="right" ><strong>Hrg Beli (Rp)</strong></td>
                </tr>
              </thead>
            <tbody>
                  <?php
     if (isset($_POST['submit'])) {
     	$kd_brg = $_POST['kode'];
		# MENJALANKAN QUERY FILTER DI ATAS
		$mySql 	= "SELECT barang.*, jenis.nm_jenis FROM barang
					LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis
					WHERE barang.kd_barang LIKE '%$kd_brg%' OR barang.barcode
					LIKE '%$kd_brg%' OR barang.nm_barang LIKE '%$kd_brg%'
				ORDER BY barang.kd_barang ";
		$myQry 	= mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
		$nomor = 1;
		while ($myData = mysql_fetch_array($myQry)) {
	?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td>
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.close();"> <b><?php echo $myData['kd_barang']; ?> </b> </a>		</td>
        <td>
			<a href="#" onClick="window.opener.document.getElementById('txtBarcode').value = '<?php echo $myData['barcode']; ?>';
								 window.opener.document.getElementById('txtNama').value = '<?php echo $myData['nm_barang']; ?>';
								 window.close();"> <b><?php echo $myData['barcode']; ?> </b> </a>		</td>
        <td><?php echo $myData['nm_barang']; ?></td>
        <td><?php echo $myData['satuan_jual']; ?></td>
        <td><?php echo $myData['nm_jenis']; ?></td>
        <td align="center"><?php echo $myData['diskon']; ?></td>
        <td align="center" bgcolor="<?php echo $warna_stok; ?>"><?php echo $myData['stok']; ?></td>
        <td align="right" bgcolor="<?php echo $warna_harga; ?>"><?php echo format_angka($myData['harga_beli']); ?></td>
        </tr>
      <?php $nomor++; }
      } ?>
                 </tbody>
                  </table>
              </div>
            </div>
           </div>
       </form>

</body>
</html>
