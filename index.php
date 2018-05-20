<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
error_reporting(E_ALL & ~E_NOTICE);
// Baca Jam pada Komputer
date_default_timezone_set("Asia/Makassar");
?>


<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="A Components Mix Bootstarp 3 Admin Dashboard Template">
<meta name="author" content="Westilian">
<title>TinyLite POS</title>
<!-- All Stylesheets Here -->
<link rel="shortcut icon" type="image/x-icon" href="assets1/images/teteslogo2.png" />
<link rel="stylesheet" href="assets1/css/style.css" type="text/css"> 
<link rel="stylesheet" href="assets1/css/font-awesome.css" type="text/css">
<link rel="stylesheet" href="assets1/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="assets1/css/animate.css" type="text/css">
<link rel="stylesheet" href="assets1/css/waves.css" type="text/css">
<link rel="stylesheet" href="assets1/css/layout.css" type="text/css">
<link rel="stylesheet" href="assets1/css/components.css" type="text/css">
<link rel="stylesheet" href="assets1/css/plugins.css" type="text/css">
<link rel="stylesheet" href="assets1/css/common-styles.css" type="text/css">
<link rel="stylesheet" href="assets1/css/pages.css" type="text/css">
<link rel="stylesheet" href="assets1/css/responsive.css" type="text/css">
<link rel="stylesheet" href="assets1/css/matmix-iconfont.css" type="text/css">
<link rel="stylesheet" type="text/css" href="assets1/css/switchery.css" />
<link rel="stylesheet" type="text/css" href="assets1/css/loader.css">

<script src="assets1/js/jquery-1.11.2.min.js"></script>
<script src="assets1/js/jquery-migrate-1.2.1.min.js"></script>
<script type='text/javascript'>
            window.addEventListener('load',function(){
                jQuery('.mod').fadeOut(500);
            });
</script>
</head>

<body>

<section class="mod model-4">
  <div class="spinner"></div>
</section>

<div class="page-container iconic-view">
<!--Leftbar Start Here -->
<div class="left-aside desktop-view">
    <div class="aside-branding">
        <a href="index.php" class="iconic-logo"><img style="width:60px; height:60px;" src="assets1/images/teteslogo2.png" alt="Matmix Logo">
        </a>
        <a href="index.php" class="large-logo"><img style="width:183px; height:60px;" src="assets1/images/tinylite2.png" alt="Matmix Logo">
        </a><span class="aside-pin waves-effect"><i class="fa fa-thumb-tack"></i></span>
        <span class="aside-close waves-effect"><i class="fa fa-times"></i></span>
    </div>
    <div class="left-navigation">
        <ul class="list-accordion">
           <?php include 'menu.php'; ?>
        </ul>
    </div>
</div>
    <div class="page-content">
    <!--Topbar Start Here -->
    <?php 
    if($_GET['popup']=='yes'): 
        echo " <script type='text/javascript'>
            window.addEventListener('load',function(){
                jQuery('.mod').fadeOut(1500);
            });
    </script>";
    else:
    ?>
    <header class="top-bar">
        <div class="container-fluid top-nav">
            
            <div class="row">
                <div class="col-md-2">
                    <div class="clearfix top-bar-action">
                        <span class="leftbar-action desktop waves-effect"><i class="fa fa-bars "></i></span>
                        <span onclick="window.location='?open=Logout'" class="rightbar-action waves-effect"><i class="glyphicon glyphicon-off"></i></span>
                    </div>
                </div>
                <div class="col-md-2 responsive-fix top-right">
                <div class="notification-nav">
                        <ul class="clearfix">
                            <li class="dropdown"><a href="#" data-toggle="dropdown" class="hide-small-device waves-effect "><i class="fa fa-bell"></i><span class="alert-bubble">
                                <?php
                                    $qr = "SELECT COUNT(*) as total1 FROM `barang` WHERE stok + stok_opname <= stok_minimal + 20";
                                    $qe = mysql_query($qr, $koneksidb);
                                    $fetch = mysql_fetch_array($qe);
                                    $stok = $fetch['total1'];
                                    $qr1 = "SELECT COUNT(*) as total2 FROM pembelian WHERE DATE(NOW()) <= `tgl_tempo`";
                                    $qe1 = mysql_query($qr1, $koneksidb);
                                    $fetch1 = mysql_fetch_array($qe1);
                                    $tempo = $fetch1['total2'];
                                    echo $total = $stok + $tempo;
                                ?>
                            </span></a>
                            <div role="menu" class="dropdown-menu notification-dropdown fadeInUp">
                                <div class="notification-wrap">
                                    <h4>Anda mempunyai <?=$stok?> notifikasi baru</h4>
                                    <ul>
                                    <?php
                                        $sql1 = "SELECT * FROM barang WHERE stok <= stok_minimal";
                                        $myQuery = mysql_query($sql1, $koneksidb);
                                        while ($data = mysql_fetch_array($myQuery)) { ?>
                                        <li><a href="#" class="clearfix"><span class="ni w-green"></span><span class="notification-message">Barang <?=$data['nm_barang']?> <?=$data['stok']?> Hampir Mendekati Stok Minimal yaitu <?=$data['stok_minimal']?></span></a>
                                        </li>
                                        <?php }
                                        $sql2 = "SELECT * FROM pembelian WHERE DATE(NOW()) <= `tgl_tempo`";
                                        $myQuery1 = mysql_query($sql2, $koneksidb);
                                        while ($data1 = mysql_fetch_array($myQuery1)) { ?>
                                        <li><a href="#" class="clearfix"><span class="ni w-orange"></span><span class="notification-message">No Pembelian <?=$data1['no_pembelian']?>, Pembelian Tanggal <?=$data1['tgl_pembelian']?>, Akan Jatuh Tempo 
                                        <?php 
                                            $tanggal1 = new DateTime($data1['tgl_tempo']);
                                            $tanggal2 = new DateTime();
                                            $perbedaan = $tanggal2->diff($tanggal1)->format("%a");
                                            echo $perbedaan;
                                        ?> Hari</span></a>
                                        </li>
                                        <?php }

                                         ?>
                                        
                                    </ul>
                                </div>
                            </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 responsive-fix">
                <div style="padding-top:20px; padding-left:110px; font-size:14px; font-weight:bold;">
                    <?php $query = "SELECT * FROM tb_header";
                    $rs = mysql_fetch_array(mysql_query($query));
                    echo $rs['nama']; ?>
                </div>
                </div>
                <div class="col-md-4 responsive-fix">
                    <div class="top-aside-right">
                        <div class="user-nav" style="font-weight:bold;  padding-top:20px;">
                        <?php echo date('d-m-Y / H:i'); ?>
                        </div>
                      <span onclick="window.location='?open=Logout'" class="rightbar-action waves-effect"><i class="glyphicon glyphicon-off"></i></span>
                    </div>
                </div>
            </div>
        </div>
    </header>
  <?php endif; ?>
        <div class="main-container">
            <div class="container-fluid">
                <div class="page-breadcrumb">
                    <div class="row">
                        <br>                        
                                    <?php include "buka_file.php"; ?>
                    </div>
                </div>
</div>
</div>
</div>
</div>
</body>

<!--Load Mask-->
<script src="assets1/js/jquery.loadmask.js"></script>
<script src="assets1/js/jRespond.min.js"></script>
<script src="assets1/js/bootstrap.min.js"></script>
<script src="assets1/js/nav-accordion.js"></script>
<script src="assets1/js/hoverintent.js"></script>
<!--Materialize Effect-->
<script src="assets1/js/waves.js"></script>
<!--iCheck-->
<script src="assets1/js/icheck.js"></script>
<!--Select2-->
<script src="assets1/js/select2.js"></script>
<!--jquery.mentionsInput-->
<script src="assets1/js/underscore.js"></script>
<script src="assets1/js/jquery.elastic.js"></script>
<script src="assets1/js/jquery.events.input.js"></script>
<script src="assets1/js/jquery.mentionsInput.js"></script>
<!--Text Editor-->
<script src="assets1/js/summernote.min.js"></script>
<!--CHARTS-->
<script src="assets1/js/chart/sparkline/jquery.sparkline.js"></script>
<script src="assets1/js/chart/easypie/jquery.easypiechart.min.js"></script>
<!--Smart Resize-->
<script src="assets1/js/smart-resize.js"></script>
<!--Data Tables-->
<script src="assets1/js/jquery.dataTables.js"></script>
<script src="assets1/js/dataTables.responsive.js"></script>
<script src="assets1/js/dataTables.tableTools.js"></script>
<script src="assets1/js/dataTables.bootstrap.js"></script>
<script src="assets1/js/stacktable.js"></script>
<!--Layout Initialize-->
<script src="assets1/js/layout.init.js"></script>
<!--Template Plugins Initialize-->
<script src="assets1/js/matmix.init.js"></script>
<!--High Resolution Ready-->
<script src="assets1/js/retina.min.js"></script>
<script src="assets1/js/switchery.js"></script>



</html>
