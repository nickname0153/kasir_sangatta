<?php 
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";
error_reporting(0);
if(isset($_POST['btnSimpan'])){
	$kode 		= $_POST['txtKode'];
	$bayar 		= $_POST['txtBayar'];
	$tgl 		= date('Y-m-d'); 
	$kodeUser	= $_SESSION['SES_LOGIN'];

	mysql_query("INSERT INTO penjualan_bayar (kd_pelanggan,tgl_bayar,uang_bayar,kd_kasir)
				VALUES('$kode','$tgl','$bayar','$kodeUser')");

	header('location:?open=Bayar&Kode=$kode');

}

# TAMPILKAN DATA LOGIN UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT p.*, pi.*, pl.nm_pelanggan, pl.no_anggota,
              SUM(pi.harga_jual * pi.jumlah) as semua,
              SUM(pi.harga_jual * pi.jumlah) - (p.uang_bayar) as sisa1,
              SUM(pi.harga_jual * b.diskon / 100) * pi.jumlah as discount,
              SUM(p.uang_bayar) as dp
              FROM penjualan as p
              LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
              LEFT JOIN pelanggan pl ON p.kd_pelanggan = pl.kd_pelanggan
              LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
              WHERE p.keterangan = 'Kredit' AND pl.kd_pelanggan = '$Kode'
              GROUP BY p.kd_pelanggan
              ORDER BY p.no_penjualan ASC";
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query data salah: ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

$query = mysql_query("SELECT COALESCE(penjualan_bayar.uang_bayar,0) as sisa FROM penjualan_bayar WHERE kd_pelanggan = '$Kode' ");

  while($data = mysql_fetch_array($query)){
    $cicilan = $cicilan + $data['sisa'];
  }
  $duit = $myData['dp'] + $myData['discount'];
  $sisaTotal = $cicilan + $duit - $myData['semua'];

?>

<div class="box-widget widget-module">
	<div class="widget-head clearfix">
	<span class="h-icon"><i class="fa fa-bars"></i></span>
		<h4>Pembayaran Hutang</h4>
	</div>
		<div class="widget-container">
			<div class=" widget-block">
<form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
  <table width="100%" class="table table-striped table-responsive" border="0" cellpadding="4" cellspacing="1">
    <tr>
      <td width="181"><strong>Kode</strong></td>
      <td width="3">:</td>
      <td width="1019"><div class="col-md-6">
      	<input name="textfield" class="form-control" value="<?php echo $myData['kd_pelanggan']; ?>" size="10" maxlength="10" readonly="readonly"/></div>
      <input name="txtKode" type="hidden" value="<?php echo $myData['kd_pelanggan']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Nama Pelanggan </strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtNama" readonly class="form-control" value="<?php echo $myData['nm_pelanggan']; ?>" size="70" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Hutang</strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtHutang" readonly class="form-control" value="<?php echo "Rp.".number_format($myData['semua'] - $myData['discount']); ?>" size="70" maxlength="100" /></div></td>
    </tr>
     <tr>
      <td><strong>Sisa</strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtSisa" readonly class="form-control" value="<?php echo "Rp.".number_format($sisaTotal); ?>" size="70" maxlength="100" /></div></td>
    </tr>
    </tr>
     <tr>
      <td><strong>Bayar (Rp)</strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtBayar" class="form-control" va size="70" maxlength="100" /></div></td>
    </tr>
    <tr class="success">
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>
      	<input type="submit" <?php if ($sisaTotal == 0) { echo "disabled"; }else{} ?> class="btn btn-primary" name="btnSimpan" value="Simpan">
      	<a href="../pembayaran_piutang" class="btn btn-danger">Kembali</a></td>
    </tr>
</table>
</form>

</div>
</div>
</div>

<div class="box-widget widget-module">
  <div class="widget-head clearfix">
  <span class="h-icon"><i class="fa fa-credit-card"></i></span>
    <h4>Catatan Pembayaran</h4>
  </div>
    <div class="widget-container">
      <div class=" widget-block">

<table class="table table-hover table-bordered">
  <tr>
    <th width="5%">No</th>
    <th width="30%">Tanggal</th>
    <th>Pembayaran</th>
    <th width="15%">Aksi</th>
  </tr>
  <?php $qy = mysql_query("SELECT penjualan_bayar.tgl_bayar, penjualan_bayar.no_jualbayar, penjualan_bayar.uang_bayar  FROM penjualan_bayar
                              INNER JOIN penjualan ON penjualan_bayar.kd_pelanggan = penjualan.kd_pelanggan 
                              WHERE penjualan_bayar.kd_pelanggan = '$Kode' AND penjualan.keterangan = 'Kredit'
                              GROUP BY penjualan_bayar.no_jualbayar
                              ORDER BY penjualan_bayar.no_jualbayar DESC ");
  $no=1;
  while($rs = mysql_fetch_array($qy)):
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo IndonesiaTgl($rs['tgl_bayar']); ?></td>
    <td><?php echo "Rp. ".number_format($rs['uang_bayar']); ?></td>  
    <td><a class="btn btn-danger" href="bayar_del.php?id=<?php echo $rs['no_jualbayar']; ?>&kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBAYARAN INI ... ?')">Hapus</a></td>
  </tr>
  <?php
  $subtotal = $subtotal + $rs['uang_bayar'];
   $no++;endwhile; 
   ?>
  <tr>
    <td colspan="2"><b>SubTotal : </b></td>
    <td colspan="2"><?php 
    $qy2 = mysql_query("SELECT SUM(penjualan.uang_bayar) as uang_bayar FROM penjualan WHERE kd_pelanggan = '$Kode' AND keterangan = 'Kredit' ");
    $sg = mysql_fetch_array($qy2);
    echo "Rp. ".number_format($subtotal)." + (DP)"."Rp. ".number_format($sg['uang_bayar']); ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Total : </b></td>
    <td colspan="2"><?php echo "Rp. ".number_format($subtotal + $sg['uang_bayar']); ?> </td>
  </tr>
</table>

</div>
</div>
</div>