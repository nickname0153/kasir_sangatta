<?php
include_once "library/inc.seslogin.php";
include_once "library/inc.hakakses.php";

// Hak akses
if($aksesData['mu_data_user'] == "Yes") {
?>

 <div class="section-header">
      <h2>Data Pengguna</h2>
        <a href="?open=User-Add" class="btn btn-primary">Tambah Data</a>
    </div>
      <div class="box-widget widget-module">
        <div class="widget-container">
          <div class=" widget-block">
            <table class="table dt-table">
              <thead>
                <tr>
                  <th width="21"><b>No</b></th>
                  <th width="40"><b>Kode</b></th>
                  <th width="383"><b>Nama User </b></th>
                  <th width="130"><b>Username</b></th>
                  <th width="100"><b>Level</b></th>
                  <td  align="center" ><strong>Aksi</strong></td>
                  <th style="display:none;"></th>
                </tr>
              </thead>
            <tbody>
<?php
    // Skrip menampilkan data dari database
    $mySql  = "SELECT * FROM user ORDER BY kd_user ASC";
    $myQry  = mysql_query($mySql, $koneksidb)  or die ("Query  salah : ".mysql_error());
    $nomor  = 0; 
    while ($myData = mysql_fetch_array($myQry)) {
      $nomor++;
      $Kode = $myData['kd_user'];
      
      // gradasi warna
      if($nomor%2==1) { $warna=""; } else {$warna="#F5F5F5";}
    ?>
      <tr bgcolor="<?php echo $warna; ?>">
        <td><?php echo $nomor; ?></td>
        <td><?php echo $myData['kd_user']; ?></td>
        <td><?php echo $myData['nm_user']; ?></td>
        <td><?php echo $myData['username']; ?></td>
        <td><?php echo $myData['level']; ?></td>
        <td width="39" align="center"><a href="?open=User-Edit&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-success" alt="Edit Data">Edit</a></td>
        <td width="45" align="center"><a href="?open=User-Delete&Kode=<?php echo $Kode; ?>" target="_self" class="btn btn-danger" alt="Delete Data" onclick="return confirm('ANDA YAKIN AKAN MENGHAPUS DATA KASIR INI ... ?')">Delete</a></td>
      </tr>
      <?php } ?>       
                 </tbody>
                  </table>
              </div>
            </div>
           </div>

            <?php /** echo '<div class="box-widget widget-module">
              <div class="widget-head clearfix">
                <span class="h-icon"><i class="fa fa-toggle-on"></i></span>
                <h4>On/Off Switch</h4>
              </div>
              <div class="widget-container">
                <div class=" widget-block">
                  <form class="form-horizontal">
                    <div class="form-group">
                      <label class=" col-md-4 control-label">Large</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-large" checked/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" col-md-4 control-label">Medium</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-m" checked/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" col-md-4 control-label pt-0">Small</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-small" checked/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" col-md-4 control-label">Off</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-m"/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" col-md-4 control-label">Disable</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-m" checked disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class=" col-md-4 control-label">Custom Color</label>
                      <div class=" col-md-8">
                        <div class="input-group">
                          <input type="checkbox" class="switch-c" checked/>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>'; **/?>
<?php 
// Penutup Hak Akses
}
else {
	echo "TIDAK BOLEH MENGAKSES HALAMAN INI";
}
?>
