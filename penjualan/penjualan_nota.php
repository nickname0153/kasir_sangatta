<?php
include_once "../library/inc.connection.php";
include_once "../library/inc.library.php";

# Baca noNota dari URL
if(isset($_GET['noNota'])){
  $noNota = $_GET['noNota'];
  
  // Perintah untuk mendapatkan data dari tabel penjualan
  $mySql = "SELECT penjualan.*, user.nm_user,pelanggan.nm_pelanggan FROM penjualan
        LEFT JOIN user ON penjualan.kd_user=user.kd_user 
        LEFT JOIN pelanggan ON penjualan.kd_pelanggan = pelanggan.kd_pelanggan
        WHERE no_penjualan='$noNota'";
  $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
  $myData = mysql_fetch_array($myQry);
}
else {
  echo "Nomor Nota (noNota) tidak ditemukan";
  exit;
}
?>
<head>
<title>Cetak Nota Penjualan - Program Kasir Toko Minimarket</title>
<script type="text/javascript">
  window.print();
  window.onfocus=function(){ window.close();}
</script>
<style type="text/css">

.garisatas{
  border-top:1px solid #000;
}

.garisbawah{
  border-bottom:1px solid #000;
}

.teks{
  font-size: 11px;
}

.teks2{
  font-size: 12px;
}

body{
  margin:0px auto 0px;
  padding:3px;
  width:100%;
  font-size: 14px;
  background-position:top;
}
.table-list {
  font-size: 14px;
  clear: both;
  text-align: left;
  border-collapse: collapse;
  margin: 0px 0px 12px 0px;
}

.table-tok {
  font-size: 14px;
  clear: both;
  text-align: left;
  margin: 0px 0px 12px 0px;
}

.table-list tr:first-child {
  color: #000;
  font-size: 14px;
  border-collapse: collapse;
  vertical-align: center;
  padding: 3px 5px;
  border-bottom:1px #000 solid;
}

</style>
</head>
<body onLoad="window.print()">
<!-- Default : width='1560' Last : width='1460' -->
<table style=" margin-top: 0px; margin-left: 0px;" class="table-tok" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr>
    <td height="87" colspan="5" style=¡±font-size:13px¡± align="center">
      <div class="head">
      <?php   
      $query = "SELECT * FROM tb_header";
      $exe = mysql_query($query, $koneksidb)  or die ("Query salah : ".mysql_error());
      $rs = mysql_fetch_array($exe);
  ?>
    <?php echo $rs['nama']; ?><br />
        <?php echo $rs['alamat']; ?><br />
        <?php echo $rs['telp']; ?>
        
      </td>
  </div>
  </tr>
  </table>
  <table style="margin-top: -15px;">
   <tr class="teks">
    <td colspan="2">Tanggal </td>
    <td> : </td>
    <td colspan="3" align="left"> <?php echo IndonesiaTgl($myData['tgl_penjualan']); ?> </td>
  </tr>
  
  </table>
  <div style="border-bottom: #000 solid 2px; margin-left: 0px; width: 100%;">&nbsp;</div>
  <table style="margin-left: 0px; padding-top: 15px;" class="table-list" width="100%" border="0" cellspacing="0" cellpadding="2">
  <tr class="teks2">
    <td width="103" bgcolor="#F5F5F5">Nama </td>
    <td width="49" align="right" bgcolor="#F5F5F5">Harga</td>
    <td width="22" align="right" bgcolor="#F5F5F5">%</td>
    <td width="22" align="right" bgcolor="#F5F5F5">Qty</td>
    <td width="103" align="right" bgcolor="#F5F5F5">Subtotal </strong></td>
  </tr>
  </div>
<?php
# Baca variabel
$totalBayar = 0; 
$jumlahBarang = 0;  
$uangKembali=0;

# Menampilkan List Item barang yang dibeli untuk Nomor Transaksi Terpilih
$notaSql = "SELECT penjualan_item.*, barang.nm_barang FROM penjualan_item
      LEFT JOIN barang ON penjualan_item.kd_barang=barang.kd_barang 
      WHERE penjualan_item.no_penjualan='$noNota'
      ORDER BY barang.kd_barang ASC";
$notaQry = mysql_query($notaSql, $koneksidb)  or die ("Query list salah : ".mysql_error());
$nomor  = 0;  
while($notaData = mysql_fetch_array($notaQry)) {
  $nomor++;
  $hargaDiskon  = $notaData['harga_jual'] - ( $notaData['harga_jual'] * $notaData['diskon']/100);
  $subSotal   = $notaData['jumlah'] * $hargaDiskon;
  $totalBayar = $totalBayar + $subSotal;
  $jumlahBarang = $jumlahBarang + $notaData['jumlah'];
  $uangKembali= $myData['uang_bayar'] - $totalBayar;
?>
  <tr>
    <td>
    <div class="teks"><?php echo $notaData['nm_barang']; ?></div></td>
    <td align="right"><div class="teks"><?php echo format_angka($notaData['harga_jual']); ?></div></td>
    <td align="right"><div class="teks"><?php echo $notaData['diskon']; ?></div></td>
    <td align="right"><div class="teks"><?php echo $notaData['jumlah']; ?></div></td>
    <td align="right"><div class="teks"><?php echo format_angka($subSotal); ?></div></td>
  </tr>
  <?php } ?>
  <tr class="garisatas teks2">
    <td colspan="3" align="left">Total Belanja (Rp) : </td>
    <td colspan="3" align="right" bgcolor="#F5F5F5"><?php echo format_angka($totalBayar); ?></td>
  </tr>
  <tr class="teks2">
    <td  colspan="3" align="left"> Uang Bayar (Rp) : </td>
    <td colspan="3" align="right"><?php echo format_angka($myData['uang_bayar']); ?></td>
  </tr>
  
  <tr class="garisbawah teks2">
    <td colspan="3" align="left">Uang Kembali (Rp) : </td>
    <td colspan="3" align="right"><?php echo format_angka($uangKembali); ?></td>
  </tr>
  
</table>
<table style="margin-left: 0px;">
  <tr>
    <td colspan="2"><div class="teks">Kasir :</div></td>
    <td colspan="3" align="right"><div class="teks"> <?php echo $myData['nm_user']; ?> </div></td>
  </tr>
</table>
</body>
</html>