<?php 
include_once "../library/inc.seslogin.php";
include_once "../library/inc.hakakses.php";

if(isset($_POST['btnSimpan'])){
	$kode 		= $_POST['txtKode'];
	$bayar 		= $_POST['txtBayar'];
	$tgl 		= date('Y-m-d'); 
	$kodeUser	= $_SESSION['SES_LOGIN'];

	mysql_query("INSERT INTO pembelian_bayar (kd_supplier,tgl_bayar,uang_bayar,kd_kasir)
				VALUES('$kode','$tgl','$bayar','$kodeUser')");

	//header('location:?open=Bayar&Kode=$kode');

}
$cicilan = 0;
# TAMPILKAN DATA LOGIN UNTUK DIEDIT
$Kode	 = $_GET['Kode']; 
$mySql	 = "SELECT p.*,s.nm_supplier, s.kd_supplier, 
              SUM(pi.harga_beli * pi.jumlah) as semua
              FROM pembelian as p
              LEFT JOIN pembelian_item pi ON p.no_pembelian = pi.no_pembelian 
              LEFT JOIN supplier s ON p.kd_supplier = s.kd_supplier
              WHERE p.keterangan = 'Kredit' AND s.kd_supplier = '$Kode' 
              GROUP BY p.kd_supplier
              ORDER BY p.no_pembelian ASC"; //seng salah ndek pembelian_item bro
$myQry	 = mysql_query($mySql, $koneksidb)  or die ("Query data salah: ".mysql_error());
$myData	 = mysql_fetch_array($myQry);

//Sisa htg
$sql = mysql_query("SELECT SUM(p.dp) as ew
              FROM pembelian as p
              LEFT JOIN supplier s ON p.kd_supplier = s.kd_supplier
              WHERE p.keterangan = 'Kredit' AND s.kd_supplier = '$Kode' 
              GROUP BY p.kd_supplier
              ORDER BY p.no_pembelian ASC");
$rs  = mysql_fetch_array($sql);

//

 $query = mysql_query("SELECT COALESCE(pembelian_bayar.uang_bayar,0) as sisa FROM pembelian_bayar WHERE kd_supplier = '$Kode' ");

  while($data = mysql_fetch_array($query)){
    $cicilan = $cicilan + $data['sisa'];
  }

  $duit = $rs['ew'];
  $sisaTotal = $duit + $cicilan - $myData['semua'];


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
      	<input name="textfield" class="form-control" value="<?php echo $myData['kd_supplier']; ?>" size="10" maxlength="10" readonly="readonly"/></div>
      <input name="txtKode" type="hidden" value="<?php echo $myData['kd_supplier']; ?>" /></td>
    </tr>
    <tr>
      <td><strong>Nama Supplier </strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtNama" readonly class="form-control" value="<?php echo $myData['nm_supplier']; ?>" size="70" maxlength="100" /></div></td>
    </tr>
    <tr>
      <td><strong>Hutang</strong></td>
      <td>:</td>
      <td><div class="col-md-6">
      	<input name="txtHutang" readonly class="form-control" value="<?php echo "Rp.".number_format($myData['semua']); ?>" size="70" maxlength="100" /></div></td>
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
      	<input type="submit"  <?php if ($sisaTotal == 0) { echo "disabled"; }else{} ?> class="btn btn-primary" name="btnSimpan" value="Simpan">
      	<a href="../pembayaran_hutang" class="btn btn-danger">Kembali</a></td>
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
  <?php $qy = mysql_query("SELECT pembelian_bayar.tgl_bayar, pembelian_bayar.uang_bayar, pembelian_bayar.no_belibayar  FROM pembelian_bayar
                              INNER JOIN pembelian ON pembelian_bayar.kd_supplier = pembelian.kd_supplier 
                              WHERE pembelian_bayar.kd_supplier = '$Kode' AND pembelian.keterangan = 'Kredit'
                              GROUP BY pembelian_bayar.no_belibayar
                              ORDER BY pembelian_bayar.no_belibayar DESC ");
  $no=1;
  while($rs = mysql_fetch_array($qy)):
  ?>
  <tr>
    <td><?php echo $no; ?></td>
    <td><?php echo IndonesiaTgl($rs['tgl_bayar']); ?></td>
    <td><?php echo "Rp. ".number_format($rs['uang_bayar']); ?></td>  
    <td><a class="btn btn-danger" href="bayar_del.php?id=<?php echo $rs['no_belibayar']; ?>&kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA PEMBAYARAN INI ... ?')">Hapus</a></td>  
  </tr>
  <?php
  $subtotal = $subtotal + $rs['uang_bayar'];
   $no++;endwhile; 
   ?>
  <tr>
    <td colspan="2"><b>SubTotal : </b></td>
    <td colspan="2"><?php 
    $qy2 = mysql_query("SELECT SUM(dp) as dp FROM pembelian WHERE kd_supplier = '$Kode' AND keterangan = 'Kredit' ");
    $sg = mysql_fetch_array($qy2);
    echo "Rp. ".number_format($subtotal)." + (DP)"."Rp. ".number_format($sg['dp']); ?></td>
  </tr>
  <tr>
    <td colspan="2"><b>Total : </b></td>
    <td colspan="2"><?php echo "Rp. ".number_format($subtotal + $sg['dp']); ?> </td>
  </tr>
</table>

</div>
</div>
</div>