<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses


# Deklarasi variabel
$filterSQL = ""; 
$tglAwal  = ""; 
$tglAkhir = "";

# Membaca tanggal dari form, jika belum di-POST formnya, maka diisi dengan tanggal sekarang
$tglAwal  = isset($_POST['cmbTglAwal']) ? $_POST['cmbTglAwal'] : "01-".date('m-Y');
$tglAkhir   = isset($_POST['cmbTglAkhir']) ? $_POST['cmbTglAkhir'] : date('d-m-Y');
$txtCari   = isset($_POST['cari']) ? $_POST['cari'] : "";

// Jika tombol filter tanggal (Tampilkan) diklik
if (isset($_POST['btnTampil'])) {
  // Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')
                AND barang.nm_barang LIKE '%".$txtCari."%' OR barang.barcode LIKE '%".$txtCari."%' ";
}
else {
  // Membaca data tanggal dari URL, saat menu Pages diklik
  $tglAwal  = isset($_GET['tglAwal']) ? $_GET['tglAwal'] : $tglAwal;
  $tglAkhir   = isset($_GET['tglAkhir']) ? $_GET['tglAkhir'] : $tglAkhir; 
  
  // Membuat sub SQL filter data berdasarkan 2 tanggal (periode)
  $filterSQL = "WHERE ( p.tgl_penjualan BETWEEN '".InggrisTgl($tglAwal)."' AND '".InggrisTgl($tglAkhir)."')";
}

# TMBOL CETAK DIKLIK
if (isset($_POST['btnCetak'])) {
  // Buka file
  echo "<script>";
  echo "window.open('cetak/laporan_stok_barang_periode.php?tglAwal=$tglAwal&tglAkhir=$tglAkhir')";
  echo "</script>";
}

# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris    = 25;
$halaman  = isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql = "SELECT barang.*
                  FROM barang
                  LEFT JOIN penjualan_item pi ON barang.kd_barang = pi.kd_barang
                  LEFT JOIN penjualan p ON pi.no_penjualan = p.no_penjualan
                  $filterSQL
                  GROUP BY pi.kd_barang";
$pageQry  = mysql_query($pageSql, $koneksidb) or die ("Error: ".mysql_error());
$jmlData  = mysql_num_rows($pageQry);
$maksData = ceil($jmlData/$baris);
?>
<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Stok Barang per Periode</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Master-Data">Laporan Master Data</a></li>
                    <li class="active-page">Laporan Data Stok Barang per Periode</li>
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
    <div class="col-sm-1"><strong>Perioe </strong></div>
      
      <div class="col-md-4"> 
        <div class="input-daterange input-group">
            <input type="text" class="form-control" value="<?php echo $tglAwal; ?>" name="cmbTglAwal"/>
                  <span class="input-group-addon">s/d</span>
                  <input type="text" name="cmbTglAkhir" class="form-control" value="<?php echo $tglAkhir; ?>"/>
        </div>
      </div>

        <div class="col-md-4">
         <div class="input-group">
             <span class="input-group-addon"><i class="fa fa-search"></i></span>
            <input type="text" class="form-control" name="cari" >
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
                   <table class="table table-responsive table-striped" width="1055" border="0" cellspacing="1" cellpadding="2">
  <tr class="success">
    <td width="22"  align="center" bgcolor="#CCCCCC"><strong>No</strong></td>
    <td width="60"  bgcolor="#CCCCCC"><strong>Barcode</strong></td>
    <td width="190"  bgcolor="#CCCCCC"><strong>Nama Barang </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Jumlah Stok Barang</strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Harga Satuan </strong></td>
    <td width="150" bgcolor="#CCCCCC"><strong>Jumlah Harga </strong></td>
    <td width="70"  bgcolor="#CCCCCC"><strong>Jumlah Stok Terjual </strong></td>
    <td width="120" bgcolor="#CCCCCC"><strong>Jumlah Harga Terjual </strong></td>
    <td width="70" bgcolor="#CCCCCC"><strong>Jumlah Persediaan </strong></td>
    <td width="190" colspan="2"  bgcolor="#CCCCCC"><strong>Jumlah Harga Persediaan </strong></td>
  </tr>

  <?php
  // Skrip menampilkan data dari database
                  $mySql  = "SELECT barang.barcode, barang.nm_barang, 
                  ( barang.stok + barang.stok_opname ) AS stok_awal, barang.harga_jual, (
                  ( barang.stok + barang.stok_opname )) * barang.harga_jual AS 
                  jumlah_harga, 
                  SUM( pi.jumlah ) AS stok_terjual, 
                  SUM( pi.jumlah ) * barang.harga_jual AS harga_terjual, 
                  (barang.stok + barang.stok_opname) AS stok_tersedia, 
                  (barang.stok + barang.stok_opname) * barang.harga_beli AS harga_persediaan
                  FROM barang
                  LEFT JOIN penjualan_item pi ON barang.kd_barang = pi.kd_barang
                  LEFT JOIN penjualan p ON pi.no_penjualan = p.no_penjualan
                  $filterSQL 
                  GROUP BY pi.kd_barang
                  ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
                  $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
                  $nomor  = $halaman; 
                  while ($myData = mysql_fetch_array($myQry)) :
                    $nomor++;
  ?>
  <tr>
    <td><?php echo $nomor; ?></td>
    <td><?php echo $myData['barcode']; ?></td>
    <td><?php echo $myData['nm_barang']; ?></td>
    <td align="center"><?php echo $myData['stok_awal']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_jual']); ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['jumlah_harga']); ?></td>
    <td align="center"><?php echo $myData['stok_terjual']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_terjual']); ?></td>
    <td align="center"><?php echo $myData['stok_tersedia']; ?></td>
    <td align="left"><?php echo "Rp. ".number_format($myData['harga_persediaan']); ?></td>
  </tr>
<?php endwhile; ?>
  <tr>
    <td colspan="2"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?></td>
    <td colspan="8" align="right"><strong>Halaman ke :</strong>
    <?php
  for ($h = 1; $h <= $maksData; $h++) {
    $list[$h] = $baris * $h - $baris;
    echo " <a href='?open=Laporan-Stok-Barang&hal=$list[$h]&tglAwal=$tglAwal&tglAkhir=$tglAkhir'>$h</a> ";
  }
  ?>
      </td>
  </tr>
</table>
<a href="cetak/laporan_stok_barang_periode.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
 | <a target="__blank" class="btn btn-default" href="cetak/excel/laporan_stok_barang_periode_excel.php?tglAwal=<?php echo $tglAwal; ?>&tglAkhir=<?php echo $tglAkhir; ?>">Export ke Excel</a>

                </div>
              </div>
            </div>
          </div>
</div>


