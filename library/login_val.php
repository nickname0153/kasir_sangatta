<?php 
	include_once "inc.connection.php";	

    $user = $_GET['user'];
    $pass = $_GET['pass'];

    $query = mysql_query("SELECT * FROM user WHERE username = '$user' AND password = md5('$pass') ") or die('gagal');
    $rs = mysql_fetch_array($query);

    if (empty($rs)) {
    	echo '<div class="alert alert-danger" role="alert">
            <i class="fa fa-exclamation-triangle"></i> <b>Username</b> atau <b>Password</b> anda salah!
                     </div>';

        echo "<script> jQuery('#btn').prop('disabled', true);  </script>";
    }else{
        echo "<script> jQuery('#btn').prop('disabled', false);  </script>";
    }