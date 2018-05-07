<?php
session_start();
include_once "library/inc.connection.php";
include_once "library/inc.library.php";
error_reporting(E_ALL & ~E_NOTICE);
// Baca Jam pada Komputer
date_default_timezone_set("Asia/Jakarta");
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="A Components Mix Bootstarp 3 Admin Dashboard Template">
<meta name="author" content="Westilian">
<title>Login TinyLite</title>
<link rel="shortcut icon" type="image/x-icon" href="assets1/images/teteslogo.png" />
<link rel="stylesheet" type="text/css" href="assets1/css/loader.css">
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
<link href="http://fonts.googleapis.com/css?family=Roboto:400,300,400italic,500,500italic" rel="stylesheet" type="text/css">
<link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet" type="text/css">
<script src="assets1/js/jquery-1.11.2.min.js"></script>
</head>
<script type='text/javascript'>
            window.addEventListener('load',function(){
                jQuery('.mod').fadeOut(1500);
            });
</script>
<script type="text/javascript">
    
    function cek(){
        var user = jQuery('#user').val();
        var pass = jQuery('#pass').val();
        jQuery.ajax({
            type:"GET",
            url:"library/login_val.php",
            data:"user="+user+"&pass="+pass,
            success:function(html){
                jQuery("#error_val").html(html)
            }
        })
    }

</script>
<?php if ($_GET['err']==1): 
     $err = '<div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-triangle"></i> <b>Username</b> atau <b>Password</b> anda salah!
                     </div>';  
else:
    $err = "";
endif;
?>
<body class="login-page">
<section class="mod model-4">
  <div class="spinner"></div>
</section>
    <div class="page-container">
        <div class="login-branding">
            <a href="#"><img style="width:240px; height:80px;" src="assets1/images/tinylite.png" alt="logo"></a>
            <?php 
  $query1 = "SELECT * FROM tb_header WHERE id=1";
            $qu = mysql_query($query1) or die('mysql_error()');
            $data = mysql_fetch_array($qu);
 ?>
<!-- 
<section align="center">
          <h3 style="color:#009fb3;"><?php // echo $data['nama']; ?></h3>
</section> -->
        </div>
        <div class="login-container">
            <form action="login_validasi.php" method="post" name="form1" class="form-signin" target="_self">
                <input type="text" id="user"  name="txtUser"  class="form-control floatlabel " autocomplete="off" placeholder="Username" required autofocus>
                <input type="password" name="txtPassword" id="pass"  class="form-control floatlabel " placeholder="Password" required>
              
                <button class="btn btn-primary btn-block btn-signin" id="btn"  name="btnLogin" type="submit">Sign In</button>
            </form>
            <br>
                <div id="error_val"><?php echo $err; ?></div>

        </div>

        <div class="login-footer">
           <a href="http://green-nusa.net">Green Nusa Computindo</a><i class="glyphicon glyphicon-copyright-mark"></i> 2016

        </div>

    </div>
    
    <script src="assets1/js/jquery-migrate-1.2.1.min.js"></script>
    <script src="assets1/js/jRespond.min.js"></script>
    <script src="assets1/js/bootstrap.min.js"></script>
    <script src="assets1/js/nav-accordion.js"></script>
    <script src="assets1/js/hoverintent.js"></script>
    <script src="assets1/js/waves.js"></script>
    <script src="assets1/js/switchery.js"></script>
    <script src="assets1/js/jquery.loadmask.js"></script>
    <script src="assets1/js/icheck.js"></script>
    <script src="assets1/js/bootbox.js"></script>
    <script src="assets1/js/animation.js"></script>
    <script src="assets1/js/colorpicker.js"></script>
    <script src="assets1/js/bootstrap-datepicker.js"></script>
    <script src="assets1/js/floatlabels.js"></script>

    <script src="assets1/js/smart-resize.js"></script>
    <script src="assets1/js/layout.init.js"></script>
    <script src="assets1/js/matmix.init.js"></script>
    <script src="assets1/js/retina.min.js"></script>
</body>

</html>
