<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca noNota dari URL
if(isset($_GET['user'])){
  $user = $_GET['user'];
  $tgl  = $_GET['tgl'];
  // Perintah untuk mendapatkan data dari tabel penjualan
  $mySql = "SELECT SUM(b.harga_jual - (b.harga_jual * b.diskon/100)) * pi.jumlah AS 
            pendapatan, p.tgl_penjualan, u.nm_user, u.kd_user 
            FROM penjualan as p LEFT JOIN user u ON p.kd_user = u.kd_user
            LEFT JOIN penjualan_item pi ON p.no_penjualan = pi.no_penjualan
            LEFT JOIN barang b ON pi.kd_barang = b.kd_barang
            WHERE p.kd_user = '$user' AND p.tgl_penjualan ='$tgl'
            GROUP BY p.tgl_penjualan";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $myData = mysql_fetch_array($myQry);
}
else {
  echo "user tidak ditemukan!";
  exit;
}
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Cetak Nota Penjualan per Kasir - Program Kasir Toko Minimarket</title>
<script type="text/javascript">
  window.print();
  window.onfocus=function(){ window.close();}
</script>
<style type="text/css">

  strong {
    font-size: 60px;
  }
  .teks{
    font-size: 60px;
  }
  .head strong{
    font-size: 70px;
  }
  h1{
    font-size: 95px;
  }
  p{
    font-size: 60px;
    font-weight: bold;
  }
  b{
    font-size: 60px;
  }

  .grs{
    font-size: 61px;
  }

</style>
</head>
<body onLoad="window.print()">
<!-- Default : width='1560' -->
<table width="1460" border="0" cellspacing="0" cellpadding="2">
<tr>
  <td colspan="5"><h1>TUTUP KASIR</h1></td>
</tr>
<tr>
 <td colspan="5"class="grs">-------------------------------- ------------------------------------ </td></tr>
  <tr>
    <td><strong>Kode Kasir</strong></td>
    <td><b> : </b></td>
    <td colspan="3" align="right"><div class="teks"> <?php echo $myData['kd_user']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr><td><strong>Nama Kasir</strong></td>
  <td><b> : </b></td>
    <td colspan="3" align="right"><div class="teks"> <?php echo $myData['nm_user']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </td>
  </tr>
  <tr>
    <td><strong>Tanggal</strong> </td>
    <td><b> : </b></td>
    <td colspan="3" align="right"><div class="teks"> <?php echo $myData['tgl_penjualan']; ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<tr>
  <td colspan="5"class="grs">-------------------------------- ------------------------------------ </td>
  <tr>
    <td><strong>TUNAI </strong> </td>
    <td><b> : </b></td>
    <td colspan="3" align="right"><div class="teks"> <?php echo "Rp. ".number_format($myData['pendapatan']); ?></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>

<tr>
  <td colspan="5"class="grs">-------------------------------- ------------------------------------ </td>
</tr>
  <tr>
    <td colspan="2"><p>Kasir,</p></td>
    <td>&nbsp;</td>
    <td colspan="2" align="right"><p>Kep. Kasir,</p></td>
  </tr>
</table>
</body>
</html>