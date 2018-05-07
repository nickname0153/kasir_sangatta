<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.library.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_barang'] == "Yes") { ?>

    <div class="section-header">
      <h2>Data Barang</h2>
        
        <form class="form-inline" method="post" action="?open=Barang-C&katakunci=<?php echo $_POST['katakunci']?>">
        <div class="form-group">
        <a href="?open=Barang-Add" class="btn btn-primary">Tambah Data</a>
        </div>
        <div class="form-group pull-right">
          <label>Pencarian</label>
          <input class="form-control text-right" type="text" name="katakunci" >
          <input type="submit" class="btn btn-primary" name="cari" value="Cari">
          <a href="?open=Barang-Data" class="btn btn-warning">Reset Pencarian</a>
          </div>
        </form>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table">
            <thead>
              <tr>
                <th width="5" rowspan="2">No</th> <!-- column 1 -->
                <th rowspan="2">Barcode</th> <!-- column 1 -->
                <th width="215" rowspan="2">Nama Barang</th> <!-- column 1 -->

                <th colspan="5"><center>INFO STOK<center></th>
                <th rowspan="2">Harga Beli(Rp)</th>
                <th rowspan="2">Harga Jual(Rp)</th>
                <th rowspan="2">Diskon</th>

                <th colspan="3"><center>Aksi</center></th>

              </tr>
             <tr>
                <th>Pembelian</th> <!-- column 2 -->
                <th>Opname</th> <!-- column 3 -->
                <th>Min</th> <!-- column 4 -->
                <th>Max</th> <!-- column 5 -->
                <th>Total</th>

                <th width="10"><center><i class="fa fa-barcode"></i></center></th>
                <th width="6"><center><i class="fa fa-pencil"></i></center></th>
                <th width="6"><center><i class="fa fa-trash"></i></center></th>
             </tr>
            </thead>
            <tbody>
            <?php
              // Skrip menampilkan data dari database
              // dibuat edi
              $katakunci =  $_POST['katakunci'];
              $halaman = 100; //batasan halaman
              $page = isset($_GET['halaman'])? (int)$_GET["halaman"]:1;
              $mulai = ($page>1) ? ($page * $halaman) - $halaman : 0;
              $result = mysql_query("SELECT barang.* FROM barang");
              $total = mysql_num_rows($result);
              $pages = ceil($total/$halaman); 
              
              $mySql = "SELECT barang.* FROM barang LEFT JOIN jenis ON barang.kd_jenis=jenis.kd_jenis
                    WHERE barcode LIKE '%$katakunci%' OR nm_barang LIKE '%$katakunci%' ORDER BY barang.nm_barang, barang.barcode  LIMIT $mulai, $halaman";
              $myQry = mysql_query($mySql, $koneksidb)  or die ("Query salah : ".mysql_error());
              
              //tambahan edi
              //$nomor = $halaman;
              
              $no = $mulai+1;

              while ($myData = mysql_fetch_array($myQry)) {
                //$nomor++;
                
                $Kode = $myData['kd_barang'];
                ?>
                  <tr>
                    <td align="center"><?php echo $no++; ?></td>
                    <td><?php echo $myData['barcode']; ?></td>
                    <td><?php echo $myData['nm_barang']; ?></td>
                    <td align="center"><?php echo $myData['stok']; ?></td>
                    <td align="center"><?php echo $myData['stok_opname']; ?></td>
                    <td align="center"><?php echo $myData['stok_minimal']; ?></td>
                    <td align="center"><?php echo $myData['stok_maksimal']; ?></td>
                    <td align="center"><?php //stok keseluruhan
                                             $stok = $myData['stok'];
                                             $op = $myData['stok_opname'];
                                             $hasil = ($stok + $op); echo $hasil; ?></td>
                    <td align="right"><?php echo format_angka($myData['harga_beli']); ?></td>
                    <td align="right"><?php echo format_angka($myData['harga_jual']); ?></td>
                    <td align="center"><?php echo format_angka($myData['diskon']); ?></td>
                    <td width="45" align="center"><a href="barcode128_print.php?Kode=<?php echo $Kode; ?>" target="_blank"><img src="images/btn_barcode.png" width="22"  border="0" /></a></td>
                    <td width="45" align="center"><a class="btn btn-success" href="?open=Barang-Edit&Kode=<?php echo $Kode; ?>" target="_self" alt="Edit Data">Ubah</a></td>
                    <td width="45" align="center"><a class="btn btn-danger" href="?open=Barang-Delete&Kode=<?php echo $Kode; ?>" target="_self" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA BARANG INI ... ?')">Hapus</a></td>
                  </tr>
                  <?php } ?>


                 </tbody>
                  </table>
                    
                  <nav aria-label="Page navigation">
                    <ul class="pagination">
                      <li>
                        <a href="#" aria-label="Previous">
                          <span aria-hidden="true">&laquo;</span>
                        </a>
                      </li>
                      <?php for ($i=1; $i<=$pages ; $i++){ ?>
                      <li><a href="?open=Barang-Data&halaman=<?php echo $i; ?>"><?php echo $i; ?></a></li>
                      <?php } ?>
                      
                      <li>
                        <a href="#" aria-label="Next">
                          <span aria-hidden="true">&raquo;</span>
                        </a>
                      </li>
                    </ul>
                  </nav>
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
