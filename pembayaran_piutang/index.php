<?php
session_start();
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";
error_reporting(E_ALL & ~E_NOTICE);
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
<title>Pembayaran Piutang - TinyLite POS </title>
<!-- All Stylesheets Here -->
<link rel="shortcut icon" type="image/x-icon" href="../assets1/images/teteslogo2.png" />
<link rel="stylesheet" href="../assets1/css/style.css" type="text/css"> 
<link rel="stylesheet" href="../assets1/css/font-awesome.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/bootstrap.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/animate.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/waves.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/layout.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/components.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/plugins.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/common-styles.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/pages.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/responsive.css" type="text/css">
<link rel="stylesheet" href="../assets1/css/matmix-iconfont.css" type="text/css">

</head>

<body>
<div class="page-container iconic-view">
<!--Leftbar Start Here -->
<div class="left-aside desktop-view">
    <div class="aside-branding">
        <a href="../index.php" class="iconic-logo"><img style="width:60px; height:60px;" src="../assets1/images/teteslogo2.png" alt="TinyLite Logo">
        </a>
        <a href="../ndex.php" class="large-logo"><img style="width:183px; height:60px;" src="../assets1/images/tinylite2.png" alt="TinyLite Logo">
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
    else:
    ?>
    <header class="top-bar">
        <div class="container-fluid top-nav">
            
            <div class="row">
                <div class="col-md-2">
                    <div class="clearfix top-bar-action">
                        <span class="leftbar-action-mobile waves-effect"><i class="fa fa-bars "></i></span>
                        <span class="leftbar-action desktop waves-effect"><i class="fa fa-bars "></i></span>
                        <span onclick="window.location='../?open=Logout'" class="rightbar-action waves-effect"><i class="glyphicon glyphicon-off"></i></span>
                    </div>
                </div>
                <div class="col-md-2 responsive-fix top-right">
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
                      <span onclick="window.location='../?open=Logout'" class="rightbar-action waves-effect"><i class="glyphicon glyphicon-off"></i></span>
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
                        <?php 
# KONTROL MENU PROGRAM
if(isset($_GET['open'])) {
  // Jika mendapatkan variabel URL ?open
  switch($_GET['open']){        
   case 'Bayar' :
      if(!file_exists ("bayar.php")) die ("File tidak ditemukan  !"); 
      include "bayar.php"; break;  
  }
}
else {
  include "pembayaran_list.php";
}
?>
                    </div>
                </div>
</div>
</div>
</div>
</div>
</body>


<script src="../assets1/js/jquery-1.11.2.min.js"></script>
<script src="../assets1/js/jquery-migrate-1.2.1.min.js"></script>
<!--Load Mask-->
<script src="../assets1/js/jquery.loadmask.js"></script>
<script src="../assets1/js/jRespond.min.js"></script>
<script src="../assets1/js/bootstrap.min.js"></script>
<script src="../assets1/js/nav-accordion.js"></script>
<script src="../assets1/js/hoverintent.js"></script>
<!--Materialize Effect-->
<script src="../assets1/js/waves.js"></script>
<!--iCheck-->
<script src="../assets1/js/icheck.js"></script>
<!--Select2-->
<script src="../assets1/js/select2.js"></script>
<!--jquery.mentionsInput-->
<script src="../assets1/js/underscore.js"></script>
<script src="../assets1/js/jquery.elastic.js"></script>
<script src="../assets1/js/jquery.events.input.js"></script>
<script src="../assets1/js/jquery.mentionsInput.js"></script>
<!--Text Editor-->
<script src="../assets1/js/summernote.min.js"></script>
<!--CHARTS-->
<script src="../assets1/js/chart/sparkline/jquery.sparkline.js"></script>
<script src="../assets1/js/chart/easypie/jquery.easypiechart.min.js"></script>
<!--Smart Resize-->
<script src="../assets1/js/smart-resize.js"></script>
<!--Data Tables-->
<script src="../assets1/js/jquery.dataTables.js"></script>
<script src="../assets1/js/dataTables.responsive.js"></script>
<script src="../assets1/js/dataTables.tableTools.js"></script>
<script src="../assets1/js/dataTables.bootstrap.js"></script>
<script src="../assets1/js/stacktable.js"></script>
<!--Layout Initialize-->
<script src="../assets1/js/layout.init.js"></script>
<!--Template Plugins Initialize-->
<script src="../assets1/js/matmix.init.js"></script>
<!--High Resolution Ready-->
<script src="../assets1/js/retina.min.js"></script>
</html>
