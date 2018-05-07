<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/laporan_piutang.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 100;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT p.* FROM penjualan as p
              LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
              LEFT JOIN pelanggan pl ON p.kd_pelanggan = pl.kd_pelanggan
              LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
              WHERE p.keterangan = 'Kredit' $filterPeriode
              GROUP BY p.kd_pelanggan";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData 	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Piutang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Pembelian">Laporan Data Pembelian</a></li>
                    <li class="active-page">Laporan Data Piutang Per Periode</li>
                  </ul>
                  </ul>
                </div>
              </div>
            </div>
        </div>
</div>

<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-calendar"></i></span>
                <h4>Periode Tanggal</h4>
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
  <div class="col-lg-1"><strong>Periode </strong></div>
      <div class="col-md-4"> 
        <div class="input-daterange input-group">
            <input type="text" class="form-control" value="<?php echo $tglAwal; ?>" name="txtTglAwal"/>
                  <span class="input-group-addon">s/d</span>
                  <input type="text" name="txtTglAkhir" class="form-control" value="<?php echo $tglAkhir; ?>"  />
        </div>
      </div>
        <input name="btnTampil" class="btn btn-success" type="submit" value=" Tampilkan " />        
    <input name="btnCetak" type="submit" class="btn btn-primary" value=" Cetak " />
</form>

                </div>
              </div>
            </div>
          </div>
</div>


<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-list"></i></span>
                <h4>Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <table class="table table-responsive table-bordered" width="985" border="0" cellspacing="1" cellpadding="2">
                   <thead>
                <tr>
                  <th width="3%"><strong><center>No</center></strong></th>
                  <th width="15%"><strong>Kode Supplier</strong></th>
                   <th width="15%"><strong>Tanggal</strong></th>
                  <th width="25%"><strong>Nama Supplier</strong></th>
                  <th width="25%"><strong>Piutang (Rp)</strong></th>
                  <th width="10%"><strong>Status</strong></th>
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
              WHERE p.keterangan = 'Kredit' $filterPeriode
              GROUP BY p.kd_pelanggan
              ORDER BY p.no_penjualan ASC";
    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
    $nomor = $halaman; 
    $fulltotal = 0;
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
        <td><?php echo $myData['no_anggota']; ?></td>
        <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
        <td><?php echo $myData['nm_pelanggan']; ?></td>
        <td><?php echo number_format( $ew = $myData['semua'] - $myData['discount']); ?></td>
         <?php if ($sisaTotal == 0) { echo "<td class='success' align='center'><b>LUNAS</b></td>"; }else{ echo "<td class='danger' align='center'><b>BELUM LUNAS</b></td>"; } ?>
      
      </tr>
  <?php $fulltotal += $ew; } ?>         
  <tr class="info">
    <td colspan="4"><b>Total</b></td>
    <td colspan="2"><?php echo number_format($fulltotal); ?></td>
  </tr>
  <tr>
    <td colspan="2"><strong>Jumlah Data :</strong><?php echo $jmlData; ?></td>
    <td colspan="4" align="right"><strong>Halaman ke :</strong>
  <?php
  for ($h = 1; $h <= $maksData; $h++) {
    $list[$h] = $baris * $h - $baris;
    echo " <a href='?open=Laporan-Piutang-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?></td>
  </tr>
    </tbody>
</table>
<br>
<a href="cetak/laporan_piutang.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/laporan_piutang_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>">Export ke Excel</a>

                </div>
              </div>
            </div>
          </div>
</div>

