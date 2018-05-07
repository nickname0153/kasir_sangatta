<?php
if(isset($_SESSION['SES_LOGIN'])) {
?>
<!--
<script type="text/javascript">
    $(function() {
         window.MyProjectNamespace = {};
         window.MyProjectNamespace.phpVars = <?php
            $phpVars = array('year' => '2011', 'purchase' => '1000', 'sale' => '600', 'profit' => '400');
            echo json_encode($phpVars);
            ?>;

        // AREA CHART
        var area = new Morris.Area({
            element: 'revenue-chart',
            resize: true,
            data: [
                {y: window.MyProjectNamespace.phpVars.year, purchase: "500", sale: "1000", profit: "500"},
                {y: "2012", purchase: "600", sale: "1100", profit: "500"},
                {y: "2013", purchase: "500", sale: "1050", profit: "550"}
            ],
            xkey: 'y',
            ykeys: ['profit', 'purchase', 'sale'],
            labels: ['Profit', 'Purchase', 'Sale'],
            lineColors: ['#a0d0e0', '#3c8dbc', '#000000'],
            hideHover: 'auto'
        });
    });
</script>
-->
<!-- Small boxes (Stat box) -->

<!--Waktu-->
<script type="text/javascript">
$ (document). ready(function(){
    $(".jam"). clock ({"format":"24"."calender":false});
});
</script>


<div class="row">
        <div class="col-md-3 col-sm-6">
            <div class="iconic-w-wrap number-rotate">
                <span class="stat-w-title">ORDER KESELURUHAN</span>
                <a href="#" class="ico-cirlce-widget w_bg_cyan">
                    <span><i class="fa fa-cart-plus"></i></span>
                </a>
                <div class="w-meta-info">
                  <?php $MySQL1 = mysql_query("SELECT count(*) as id FROM penjualan");
                        $fetch1 = mysql_fetch_array($MySQL1);
                        $MySQL2 = mysql_query("SELECT count(*) as id FROM pembelian");
                        $fetch2 = mysql_fetch_array($MySQL2);
                        $hasil1 = $fetch1['id'];
                        $hasil2 = $fetch2['id'];
                        $hasil = ($hasil1 + $hasil2);
                   ?>
                    <span class="w-meta-value number-animate" data-value="<?php echo $hasil ?>" data-animation-duration="1500"><?php echo $hasil ?></span>
                    <span class="w-meta-title">Order Transaksi</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="iconic-w-wrap iconic-w-wrap">
                <span class="stat-w-title">KESELURUHAN TRANSAKSI</span>
                <a href="#" class="ico-cirlce-widget w_bg_grey">
                    <span><i class="fa fa-money"></i></span>
                </a>
                <div class="w-meta-info">
                  <?php 
                  $MySQL = mysql_query("SELECT SUM(StockBalance.jumlah * StockBalance.harga_jual) AS total FROM penjualan_item StockBalance LEFT JOIN penjualan p ON StockBalance.no_penjualan = p.no_penjualan WHERE YEAR(p.tgl_penjualan) = YEAR(CURRENT_DATE)");
                  $fetch = mysql_fetch_array($MySQL);
                   ?>
                    <span class="w-meta-value number-animate" data-value="<?php echo $fetch['total']; ?>" data-animation-duration="1500">Rp. <?php echo number_format($fetch['total']); ?></span>
                    <span class="w-meta-title">Transaksi per Tahun</span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="iconic-w-wrap iconic-w-wrap">
                <span class="stat-w-title">KESELURUHAN PENGGUNA</span>
                <a href="#" class="ico-cirlce-widget w_bg_blue_grey">
                    <span><i class="ico-users"></i></span>
                </a>
                <?php 
                    $MySQL3 = mysql_query("SELECT count(*) as id FROM user");
                    $fetch3 = mysql_fetch_array($MySQL3);
                   ?>

                <div class="w-meta-info ">
                    <span class="w-meta-value number-animate" data-value="<?php echo $fetch3['id']; ?>" data-animation-duration="1500"><?php echo $fetch3['id']; ?></span>
                    <span class="w-meta-title">Semua User</span>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-sm-6">
            <div class="iconic-w-wrap iconic-w-wrap">
                <span class="stat-w-title">KESELURUHAN PELANGGAN</span>
                <a href="#" class="ico-cirlce-widget w_bg_green">
                    <span><i class="ico-chart"></i></span>
                </a>
                <?php $MySQL4 = mysql_query("SELECT count(*) as id FROM pelanggan");
                        $fetch4 = mysql_fetch_array($MySQL4); ?>
                <div class="w-meta-info">
                    <span class="w-meta-value number-animate" data-value="<?php echo $fetch4['id']; ?>" data-animation-duration="1500"><?php echo $fetch4['id']; ?></span>
                    <span class="w-meta-title">Semua Pelanggan</span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
                        <div class="w-info-graph">
                                    <div class="w-info-chart" style="margin-left:10px;">
                                        <?php $qs = mysql_query("SELECT SUM(jumlah) as hitung FROM penjualan_item");
                                               $rs = mysql_fetch_array($qs); ?>
                                            <h2><?php echo $rs['hitung']; ?> Sold Items</h2>
                                            <p>
                                                 Grafik Pendapatan perhari
                                            </p>
                                        </div>
                                        <div class="mini-chart-list">
                                            <ul>
                                             <?php $query1 = mysql_query("SELECT SUM(stok + stok_opname) as barang FROM barang");
                                                   $query2 = mysql_query("SELECT SUM(jumlah) as jumlah FROM penjualan_item");
                                                   $rs1 = mysql_fetch_array($query1);
                                                   $rs2 = mysql_fetch_array($query2);

                                                   if ($rs1['barang'] != 0 or $rs2['jumlah'] != 0 ) {
                                                       $seluruh = $rs1['barang'] + $rs2['jumlah'];
                                                       $persen = ($rs2['jumlah'] / $seluruh * 100);
                                                       $results = ceil($persen);
                                                   }else{
                                                        $results = 0;
                                                   }
                                                    ?>
                                                <li>
                                                <span class="epie-chart" data-percent="<?php echo $results; ?>" data-barcolor="#4caf50" data-tcolor="#e0e0e0" data-scalecolor="#e0e0e0" data-linecap="butt" data-linewidth="3" data-size="80" data-animate="2000"><span class="percent"></span>
                                                </span>
                                                <span class="chart-sub-title">Barang Terjual</span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="line-chart-container">
                                            <?php 
                                            $stringJual = "SELECT SUM(pi.harga_jual * pi.jumlah - pi.diskon) as jual
                                             FROM penjualan As p, penjualan_item As pi
                                             LEFT JOIN barang ON pi.kd_barang = barang.kd_barang
                                             WHERE p.no_penjualan = pi.no_penjualan
                                             GROUP BY p.tgl_penjualan ORDER BY p.tgl_penjualan DESC LIMIT 0,15";
                                            $Query = mysql_query($stringJual);
                                             ?>
                                            <div class="sparkline" data-type="line" data-resize="true" data-height="200" data-width="100%" data-line-width="1" data-line-color="#00acc1" data-spot-color="#00838f" data-fill-color="rgba(240,240,240,0.5)" data-highlight-line-color="#e1e5e9" data-highlight-spot-color="#ff8a65" data-spot-radius="4" 
                                            data-data="[<?php echo '0'; while($row = mysql_fetch_array($Query)){ echo ','.$row['jual']; } ?>]" >
                                            </div>
                               </div>         
                    </div>
                </div>
            </div>



<?php //include 'library/chart-init.php'; ?>

           
    <script src="assets1/js/chart/flot/excanvas.min.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.min.js"></script>
    <script src="assets1/js/chart/flot/curvedLines.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.time.min.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.stack.min.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.axislabels.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.resize.min.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.tooltip.min.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.spline.js"></script>
    <script src="assets1/js/chart/flot/jquery.flot.pie.min.js"></script>
    <script src="assets1/js/smart-resize.js"></script>
    <script src="assets1/js/layout.init.js"></script>
    <script src="assets1/js/matmix.init.js"></script>
    <script src="assets1/js/retina.min.js"></script>

<?php
}
else {
    ?>
  <script type="text/javascript">
  window.location = '?open=Login';
  </script>
  <?php
    //echo "<h2>Selamat datang di PROGRAM KASIR  !</h2>";
    //echo "<b>Anda belum login, silahkan <a href='?open=Login' alt='Login'>login </a>untuk mengakses sitem ini ";  
}
?>