<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_penjualan_barang_periode'] == "Yes") {

# Deklarasi variabel
$filterPeriode = ""; 
$tglAwal	= ""; 
$tglAkhir	= "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal 	= isset($_POST['txtTglAwal']) ? $_POST['txtTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['txtTglAkhir']) ? $_POST['txtTglAkhir'] : date('d-m-Y');
$kasir    = $_POST['kasir'];
// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."' ) AND p.kd_user = '".$kasir."'";
}


else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "WHERE p.keterangan = 'Cash' OR p.keterangan = 'Kredit' AND ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."' )";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/penjualan_kasir_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT p.* FROM penjualan as p LEFT JOIN user u ON p.kd_user = u.kd_user
            $filterPeriode
            GROUP BY p.tgl_penjualan";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Penjualan Kasir Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Data Penjualan Kasir Per Periode</li>
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
    <div class="col-lg-1"><strong>Kasir </strong></div>
      <div class="col-md-4"> 
        <div class="input-daterange input-group">
            <select name="kasir" class="form-control">
              <?php
              $sqal = "SELECT * FROM user";
              $quare = mysql_query($sqal, $koneksidb);
              while ($data = mysql_fetch_array($quare)) { ?>
                <option value="<?=$data['kd_user']?>"><?=$data['nm_user']?></option>
              <?php }
              ?>
            </select>
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
                <h4>Data </h4>
                <ul class="widget-action-bar pull-right">
                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <table class="table table-responsive table-striped" width="985" border="0" cellspacing="1" cellpadding="2">
  <tr>
  <th width="22" align="center">No</th>
    <th width="77">Tanggal </th>
    <th width="177">Nama Kasir</th>
    <th width="150">Pendapatan</th>
  </tr>
  <?php
  
  # Perintah untuk menampilkan data Rawat dengan filter Periode
 $mySql = "SELECT p.*, u.nm_user, p.tgl_penjualan, 
            SUM(b.harga_jual * pi.jumlah) as maho,
            SUM((b.harga_jual - (b.harga_jual * b.diskon/100)) * pi.jumlah) as odore
            FROM penjualan as p LEFT JOIN user u ON p.kd_user = u.kd_user
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
            $filterPeriode
            GROUP BY p.kd_user, p.tgl_penjualan ORDER BY p.tgl_penjualan DESC";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $hal; 
  $totalJual = 0;
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;   
   ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['nm_user']; ?></td>
    <td><?php echo format_angka($ew = $myData['odore']); ?></td>  </tr>
  <?php $totalJual += $ew; } ?>
  <tr>
    <td colspan="3" align="right"><strong>GRAND TOTAL:</strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalJual); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jml; ?></td>
    <td colspan="8" align="right"><strong>Halaman ke :</strong>
        <?php
  for ($h = 1; $h <= $max; $h++) {
    $list[$h] = $row * $h - $row;
    echo " <a href='?open=Laporan-Penjualan-Kasir-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?></td>
  </tr>
</table>
<a href="cetak/penjualan_kasir_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_kasir_periode_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>">Export ke Excel</a>

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
