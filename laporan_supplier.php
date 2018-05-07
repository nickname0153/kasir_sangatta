<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mlap_supplier'] == "Yes") {
?>


<div class="page-breadcrumb">
          <div class="row">
            <div class="col-md-7">
              <div class="page-breadcrumb-wrap">
                <div class="page-breadcrumb-info">
                  <h2 class="breadcrumb-titles">Laporan Data Supplier</h2>
                  <ul class="list-page-breadcrumb">
                    <li><a href="#">Home</a>
                    <li ><a href="?open=Laporan-Master-Data">Laporan Master Data</a></li>
                    <li class="active-page">Laporan Data Supplier</li>
                  </ul>
                  </ul>
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
                <span class="h-icon"><i class="fa fa-truck"></i></span>
                <h4>Laporan Data Supplier</h4>
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
                      <td width="27" align="center" ><strong>No</strong></td>
                      <td width="55" ><strong>Kode</strong></td>
                      <td width="166" ><strong>Nama Supplier </strong></td>
                      <td width="349" ><strong>Alamat Lengkap  </strong></td>  
                      <td width="116" ><strong>No Telepon </strong></td>
                    </tr>
                   <?php
                    // Skrip menampilkan data dari Database
                    $mySql = "SELECT * FROM supplier ORDER BY nm_supplier ASC";
                    $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
                    $nomor  = 0; 
                    while ($myData = mysql_fetch_array($myQry)) {
                      $nomor++;
                    ?>
                    <tr>
                      <td align="center"><?php echo $nomor; ?></td>
                      <td><?php echo $myData['kd_supplier']; ?></td>
                      <td><?php echo $myData['nm_supplier']; ?></td>
                      <td><?php echo $myData['alamat']; ?></td>
                      <td><?php echo $myData['no_telepon']; ?></td>
                    </tr>
                    <?php } ?>
                  </table>
                  <br>
                  <div class="form-group">
                  <div class="col-lg-3">
                    <a href="cetak/supplier.php" target="_blank"><img src="images/btn_print2.png" height="18" border="0" title="Cetak ke Format HTML"/></a>
                    | <a href="cetak/excel/supplier_excel.php" class="btn btn-default">Export ke Excel</a>
                </div>
                </div>
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
