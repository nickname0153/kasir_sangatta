<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_barang_kategori'] == "Yes") {

// Baca variabel URL browser
$kodeKat	 = isset($_GET['kodeKat']) ? $_GET['kodeKat'] : 'Semua';
// Baca variabel dari Form setelah di Post
$dataKategori = isset($_POST['cmbKategori']) ? $_POST['cmbKategori'] : $kodeKat;

// Membuat Sub SQL dengan Filter
if(trim($dataKategori)=="Semua") {
	$filterSQL = "WHERE kategori.kd_kategori != '$dataKategori'";
}
else {
	$filterSQL = "WHERE kategori.kd_kategori = '$dataKategori'";
}

# TMBOL CETAK DIKLIK
if(isset($_POST['btnCetak'])) {
	// Buka file
	echo "<script>";
	echo "window.open('cetak/barang_kategori.php?kodeKategori=$dataKategori', width=330)";
	echo "</script>";
}


# UNTUK PAGING (PEMBAGIAN HALAMAN)
$baris 		= 25;
$halaman 	= isset($_GET['hal']) ? $_GET['hal'] : 0;
$pageSql 	= "SELECT * FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis
									LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
									$filterSQL";
$pageQry 	= mysql_query($pageSql, $koneksidb) or die("Error paging:".mysql_error());
$jmlData	= mysql_num_rows($pageQry);
$maksData	= ceil($jmlData/$baris);
?>

<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Barang per Kategori</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Master-Data">Laporan Master Data</a></li>
                    <li class="active-page">Laporan Data Barang per Kategori</li>
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
                <span class="h-icon"><i class="fa fa-search"></i></span>
                <h4>Filter Data</h4>
                <ul class="widget-action-bar pull-right">
                  <li>
                  <div class="widget-switch">
                    <input type="checkbox" class="w-on-off" checked/>
                  </div>

                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" name="form1" target="_self">
                   <div class="col-sm-2"> <strong>Kategori :</strong> </div>

                      <div  class="col-lg-3">
                      <select name="cmbKategori" class="form-control">
                          <option value="Semua">....</option>
                          <?php
                      $bacaSql = "SELECT * FROM kategori ORDER BY kd_kategori";
                      $bacaQry = mysql_query($bacaSql, $koneksidb) or die ("Gagal Query".mysql_error());
                      while ($bacaData = mysql_fetch_array($bacaQry)) {
                      if ($bacaData['kd_kategori'] == $dataKategori) {
                        $cek = " selected";
                      } else { $cek=""; }
                      echo "<option value='$bacaData[kd_kategori]' $cek>$bacaData[nm_kategori]</option>";
                      }
                      ?>
                        </select></div>

                        <input name="btnTampilkan" class="btn btn-success" type="submit" value=" Tampilkan  "/>
                        <input name="btnCetak" type="submit" value=" Cetak " class="btn btn-primary" />

                  </form>
                </div>
              </div>
            </div>
          </div>
</div>



<div class="form-horizontal">
<div class="row">
          <div class="col-md-12">
            <div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-tasks"></i></span>
                <h4>Laporan Data Barang per Kategori</h4>
                <ul class="widget-action-bar pull-right">
                  <li>
                  <div class="widget-switch">
                    <input type="checkbox" class="w-on-off" checked/>
                  </div>

                  <li><span class="widget-remove waves-effect w-remove"><i class="ico-cross"></i></span>
                  </li>
                </ul>
              </div>
              <div class="widget-container">
                <div class="widget-block">
                   <table class="table table-bordered table-responsive" width="985" border="0" cellspacing="1" cellpadding="2">
                    <tr>
                      <td width="23" bgcolor="#F5F5F5"><strong>No</strong></td>
                      <td width="45" bgcolor="#F5F5F5"><strong>Kode</strong></td>
                      <td width="70" bgcolor="#F5F5F5"><strong> Barcode </strong></td>
                      <td width="385" bgcolor="#F5F5F5"><strong>Nama Barang</strong></td>
                      <td width="115" bgcolor="#F5F5F5"><strong>Jenis</strong></td>
                      <td width="46" bgcolor="#F5F5F5"><strong>Satuan</strong></td>
                      <td width="31" align="right" bgcolor="#F5F5F5"><strong>Stok</strong></td>
                      <td width="100" align="right" bgcolor="#F5F5F5"><strong>Hrg Jual (Rp) </strong></td>
                      <td width="39" align="right" bgcolor="#F5F5F5"><strong>Disc</strong></td>
                    </tr>
                     <?php
                  // Skrip menampilkan data dari database
                  $mySql  = "SELECT barang.*, jenis.nm_jenis FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis
                        LEFT JOIN kategori ON jenis.kd_kategori = kategori.kd_kategori
                        $filterSQL
                        ORDER BY barang.kd_barang ASC LIMIT $halaman, $baris";
                  $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
                  $nomor  = $halaman;
                  while ($myData = mysql_fetch_array($myQry)) {
                    $nomor++;
                  ?>
                  <tr>
                    <td> <?php echo $nomor; ?> </td>
                    <td><?php echo $myData['kd_barang']; ?></td>
                    <td> <?php echo $myData['barcode']; ?> </td>
                    <td> <?php echo $myData['nm_barang']; ?> </td>
                    <td> <?php echo $myData['nm_jenis']; ?> </td>
                    <td> <?php echo $myData['satuan_jual']; ?> </td>
                    <td align="right"> <?php echo $myData['stok']; ?> </td>
                    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
                    <td align="right"><?php echo $myData['diskon']; ?> %</td>
                  </tr>
                  <?php } ?>
                  <tr class="selKecil">
                  <td colspan="4"><strong>Jumlah Data :</strong> <?php echo $jmlData; ?> </td>
                    <td colspan="5" align="right">
                  <strong>Halaman ke :</strong>


                    <?php
                  for ($h = 1; $h <= $maksData; $h++) {
                    $list[$h] = $baris * $h - $baris; ?>

											<a href='?open=Laporan-Barang-Kategori&hal=<?=$list[$h]?>&kodeKat=<?=$dataKategori?>'><?=$h?></a>

										<?php
                  }
                  ?>

								</td>
                  </tr>
                  </table>

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
