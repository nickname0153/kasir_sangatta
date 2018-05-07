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
$tglAwal 	= isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir 	= isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}
else {
	// Membaca data tanggal dari URL, saat menu Pages diklik
	$tglAwal 	= isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
	$tglAkhir 	= isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
	
	// Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
	$filterPeriode = "AND ( tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/penjualan_barang_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
	echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$row = 100;
$hal = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT * FROM penjualan, penjualan_item 
			WHERE penjualan.no_penjualan = penjualan_item.no_penjualan 
			$filterPeriode";
$pageQry = mysql_query($pageSql, $koneksidb) or die ("error paging: ".mysql_error());
$jml	 = mysql_num_rows($pageQry);
$max	 = ceil($jml/$row);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Penjualan Barang Per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Penjualan">Laporan Data Penjualan</a></li>
                    <li class="active-page">Laporan Data Penjualan Barang Per Periode</li>
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
            <input type="text" class="form-control" value="<?php echo $tglAwal; ?>" name="cmbTglAwal"/>
                  <span class="input-group-addon">s/d</span>
                  <input type="text" name="cmbTglAkhir" class="form-control" value="<?php echo $tglAkhir; ?>"  />
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
  <tr class="success">
    <td width="22" rowspan="2" align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60" rowspan="2" bgcolor="#CCCCCC"><strong>Tgl.Nota</strong></td>
    <td width="62" rowspan="2" bgcolor="#CCCCCC"><strong>No. Nota </strong></td>
    <td width="50" rowspan="2" bgcolor="#CCCCCC"><strong>Kode</strong></td>
    <td width="295" rowspan="2" bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td colspan="6" align="center" bgcolor="#999999"><strong>HASIL PENJUALAN</strong></td>
  </tr>
  <tr class="warning">
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Modal (Rp)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Jual (Rp) </strong></td>
    <td width="56" align="right" bgcolor="#CCCCCC"><strong>Disc(%)</strong></td>
    <td width="95" align="right" bgcolor="#CCCCCC"><strong>H Diskon(Rp) </strong></td>
    <td width="35" align="right" bgcolor="#CCCCCC"><strong>Qty</strong></td>
    <td width="85" align="right" bgcolor="#CCCCCC"><strong>Untung (Rp) </strong></td>
  </tr>
  <?php
    // deklarasi variabel
  $subTotalLaba   = 0;
  $totalModal   = 0;
  $totalOmset   = 0;
    $totalPendapatan = 0; 
  $totalBarang  = 0;
  
  # Perintah untuk menampilkan data Rawat dengan filter Periode
  $mySql = "SELECT p.no_penjualan, p.tgl_penjualan, pi.kd_barang, barang.nm_barang, pi.harga_beli, pi.harga_jual, pi.jumlah, pi.diskon
        FROM penjualan As p, penjualan_item As pi
        LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
        WHERE p.no_penjualan = pi.no_penjualan
        $filterPeriode
        ORDER BY no_penjualan ASC LIMIT $hal, $row";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $nomor = $hal; 
  while ($myData = mysql_fetch_array($myQry)) {
    $nomor++;   
    # Hitung
    $hargaDiskon  = $myData['harga_jual'] - ( $myData['harga_jual'] * $myData['diskon']/100);
    $nilaiLaba    = $hargaDiskon - $myData['harga_beli'];
    $subTotalLaba = $nilaiLaba * $myData['jumlah'];
    
    # Rekap data
    $totalModal   = $totalModal + ( $myData['harga_beli'] * $myData['jumlah']);  // Menghitung total modal beli
    $totalOmset   = $totalOmset + ( $hargaDiskon * $myData['jumlah']);
    $totalBarang  = $totalBarang + $myData['jumlah'];      // Menghitung total barang terjual
    $totalPendapatan= $totalPendapatan + $subTotalLaba;  // Menghitung total keuntungan bersih
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo IndonesiaTgl2($myData['tgl_penjualan']); ?></td>
    <td><?php echo $myData['no_penjualan']; ?></td>
    <td><?php echo $myData['kd_barang']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
    <td align="right"><?php echo $myData['diskon']; ?></td>
    <td align="right"><?php echo format_angka($hargaDiskon); ?></td>
    <td align="right"><?php echo $myData['jumlah']; ?></td>
    <td align="right"><?php echo format_angka($subTotalLaba); ?></td>
  </tr>
  <?php } ?>
  <tr class="info">
    <td colspan="8" align="right"><strong>TOTAL OMSET PENJUALAN (Rp.) : </strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalOmset); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalBarang); ?></strong></td>
    <td align="right" bgcolor="#CCCCCC"><strong><?php echo format_angka($totalPendapatan); ?></strong></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Jumlah Data :</strong><?php echo $jml; ?></td>
    <td colspan="8" align="right"><strong>Halaman ke :</strong>
        <?php
  for ($h = 1; $h <= $max; $h++) {
    $list[$h] = $row * $h - $row;
    echo " <a href='?open=Laporan-Penjualan-Barang-Periode&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?></td>
  </tr>
</table>
<a href="cetak/penjualan_barang_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a class="btn btn-default" href="cetak/excel/penjualan_barang_periode_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>">Export ke Excel</a>

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
