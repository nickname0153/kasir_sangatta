<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_pembelian_supplier'] == "Yes") {

// Baca variabel URL browser
$kodeSupplier = isset($_GET['kodeSupplier']) ? $_GET['kodeSupplier'] : 'SEMUA'; 
// Baca variabel dari Form setelah di Post
$kodeSupplier = isset($_POST['cmbSupplier']) ? $_POST['cmbSupplier'] : $kodeSupplier;

// Membuat filter SQL
if ($kodeSupplier=="SEMUA") {
	//Query #1 (semua data)
	$filterSQL 	= "";
}
else {
	//Query #2 (filter)
	$filterSQL 	= " WHERE pembelian.kd_supplier ='$kodeSupplier'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/pembelian_supplier.php?kodeSupplier=$kodeSupplier')";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$barisData 	= 50;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM pembelian $filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jumData	= mysql_num_rows($pageQry);
$maksData	= ceil($jumData/$barisData);
?>

<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Pembelian Per Supplier</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Pembelian">Laporan Data Pembelian</a></li>
                    <li class="active-page">Laporan Data Pembelian Per Supplier</li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div


<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-filter"></i></span>
                <h4>Filter Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li>
                  <div class="widget-switch">
                    <input type="checkbox" class="w-on-off" checked/>
                  </div>
                 </li>
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
      <div class="col-lg-1"><strong>Supplier :</strong></div>
  <div class="col-md-4">
    <select name="cmbSupplier" class="form-control">
          <option value="SEMUA">....</option>
          <?php
    $bacaSql = "SELECT * FROM supplier ORDER BY kd_supplier";
    $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
    while ($bacaData = mysql_fetch_array($bacaQry)) {
    if ($bacaData['kd_supplier'] == $kodeSupplier) {
      $cek = " selected";
    } else { $cek=""; }
    echo "<option value='$bacaData[kd_supplier]' $cek>$bacaData[kd_supplier] - $bacaData[nm_supplier]</option>";
    }
    ?>
        </select></div>
          <input name="btnTampilkan" type="submit" class="btn btn-success" value=" Tampilkan  "/>
    
        <input name="btnCetak" type="submit" class="btn btn-primary" value=" Cetak " />
                </div>
              </div>
            </div>
          </div>
</div>
</form>

<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-truck"></i></span>
                <h4>Laporan Pembelian per Supplier</h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   
<table class="table table-striped table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr class="success success-active">
    <td width="24" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="69" bgcolor="#CCCCCC"><strong>Tanggal</strong></td>
    <td width="100" bgcolor="#CCCCCC"><strong>No. Pembelian </strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Supplier</strong></td>
    <td width="214" bgcolor="#CCCCCC"><strong>Keterangan</strong></td>
    <td width="90" align="right" bgcolor="#CCCCCC"><strong>Total Barang</strong> </td>
    <td width="120" align="right" bgcolor="#CCCCCC"><strong>Total Belanja (Rp) </strong></td>
    <td align="center" bgcolor="#CCCCCC"><strong>Tools</strong></td>
  </tr>
  <?php
    // Variabel data
  $grandTotalHarga  = 0;
  $grandTotalBarang = 0;
  
  # Perintah untuk menampilkan pembelian dengan Filter Periode
  $mySql = "SELECT pembelian.*, supplier.nm_supplier FROM pembelian 
      LEFT JOIN supplier ON pembelian.kd_supplier = supplier.kd_supplier
      $filterSQL ORDER BY no_pembelian DESC LIMIT $halaman, $barisData";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
  $nomor = $halaman;
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;
    # Membaca Kode pembelian/ Nomor transaksi
    $noNota = $myData['no_pembelian'];
    
    # Menghitung Total Tiap Transaksi
    $my2Sql = "SELECT SUM(harga_beli * jumlah) As total_belanja,
              SUM(jumlah) As total_barang 
              FROM pembelian_item WHERE no_pembelian='$noNota'";
    $my2Qry = mysql_query($my2Sql, $koneksidb)  or die ("Query 1 salah : ".mysql_error());
    $my2Data= mysql_fetch_array($my2Qry);
    
    // Menjumlah Total Semua Transaksi yang ditampilkan
    $grandTotalHarga  = $grandTotalHarga + $my2Data['total_belanja'];
    $grandTotalBarang = $grandTotalBarang + $my2Data['total_barang'];
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_pembelian']); ?></td>
    <td><?php echo $myData['no_pembelian']; ?></td>
    <td><?php echo $myData['nm_supplier']; ?></td>
    <td><?php echo $myData['keterangan']; ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_barang']); ?></td>
    <td align="right"><?php echo format_angka($my2Data['total_belanja']); ?></td>
    <td width="42" align="center"><a href="cetak/pembelian_cetak.php?noNota=<?php echo $noNota; ?>" target="_blank">Cetak</a></td>
  </tr>
  <?php } ?>
  <tr class="info info-active">
    <td colspan="5" align="right"><strong>GRAND TOTAL : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($grandTotalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong>Rp. <?php echo format_angka($grandTotalHarga); ?></strong></td>
    <td align="right">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :<?php echo $jumData; ?></strong></td>
    <td colspan="5" align="right"><strong>Halaman ke :
      <?php
  for ($h = 1; $h <= $maksData; $h++) {
    $list[$h] = $barisData * $h - $barisData;
    echo " <a href='?open=Laporan-Pembelian-Supplier&hal=$list[$h]&kodeSupplier=$kodeSupplier'>$h</a> ";
  }
  ?>
    </strong></td>
  </tr>
</table>

<a href="cetak/pembelian_supplier.php?kodeSupplier=<?php echo $kodeSupplier; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/pembelian_supplier_excel.php?kodeSupplier=<?php echo $kodeSupplier; ?>">Export ke Excel</a>

                </div>
              </div>
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
