<link rel="stylesheet" href="/resources/demos/style.css"><link rel="stylesheet" href="/resources/demos/style.css">
  <script src="asset/js/jquery-1.12.4.js"></script>
  <script src="asset/js/jquery-ui.js"></script> 
  <script>
  $( function() {
        $( "#datepicker" ).datepicker({dateFormat:'yy-mm-dd'});
        $( "#datepicker2" ).datepicker({dateFormat:'yy-mm-dd'});
  } );
  </script>
<?php
    //cek session
    if(empty($_SESSION['admin'])){
        $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
        header("Location: ./");
        die();
    } else {

        if($_SESSION['admin'] != 1 AND $_SESSION['admin'] != 4){
            echo '<script language="javascript">
                    window.alert("ERROR! Anda tidak memiliki hak akses untuk menambahkan data");
                    window.location.href="./admin.php?page=praktek_industri";
                  </script>';
        } else {

            if(isset($_REQUEST['submit'])){

                //validasi form kosong
                if($_REQUEST['id_pi'] == "" || $_REQUEST['mahasiswa'] == "" || $_REQUEST['dosen'] == ""){
                    $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {

                    $id_pi = $_REQUEST['id_pi'];
                    $mahasiswa = $_REQUEST['mahasiswa']; 
                    $dosen = $_REQUEST['dosen']; 
                    $judul_laporan = $_REQUEST['judul_laporan']; 
                    $tanggal_pengajuan = $_REQUEST['tanggal_pengajuan']; 
                    $tgl_pelaksanaan = $_REQUEST['tgl_pelaksanaan']; 
                    $perusahaan= $_REQUEST['perusahaan'];
                    $status = '1'; 
                    $id_user = $_SESSION['admin'];

                    //validasi input data 
                        if(!preg_match("/^[a-zA-Z0-9.,\/ -]*$/", $mahasiswa)){
                            $_SESSION['namaref'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.), koma(,) dan minus(-)';
                            echo '<script language="javascript">window.history.back();</script>';
                        } else {

                            if(!preg_match("/^[a-zA-Z0-9.,()\/\r\n -]*$/", $uraian)){
                                $_SESSION['uraian'] = 'Form Uraian hanya boleh mengandung karakter huruf, angka, spasi, titik(.), koma(,), minus(-), garis miring(/), dan kurung()';
                                echo '<script language="javascript">window.history.back();</script>';
                            } else {
 

                                    $query = mysqli_query($config, "UPDATE praktek_industri SET judul_laporan='$judul_laporan'
                                                                    WHERE id_pi='".$_REQUEST['id_pi']."'");

                                    if($query != false){
                                         $_SESSION['succEdit'] = 'SUKSES! Data berhasil diupdate';
                                        header("Location: ./admin.php?page=praktek_industri");
                                        die();
                                    } else {
                                       $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                                       echo '<script language="javascript">window.history.back();</script>';
                                    } 
                            }
                        } 
                }
            } else {?>
                <!-- Row Start -->
                <div class="row">
                    <!-- Secondary Nav START -->
                    <div class="col s12">
                        <nav class="secondary-nav">
                            <div class="nav-wrapper blue-grey darken-1">
                                <ul class="left">
                                    <li class="waves-effect waves-light"><a href="?page=praktek_industri&act=Edit" class="judul"><i class="material-icons">bookmark</i> Edit Praktek Industri</a></li>
                                </ul>
                            </div>
                        </nav>
                    </div>
                    <!-- Secondary Nav END -->
                </div>
                <!-- Row END -->

                <?php
                    if(isset($_SESSION['errQ'])){
                        $errQ = $_SESSION['errQ'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card red lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errQ.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['errQ']);
                    }
                    if(isset($_SESSION['errEmpty'])){
                        $errEmpty = $_SESSION['errEmpty'];
                        echo '<div id="alert-message" class="row">
                                <div class="col m12">
                                    <div class="card red lighten-5">
                                        <div class="card-content notif">
                                            <span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$errEmpty.'</span>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        unset($_SESSION['errEmpty']);
                    }
                    
                      $sql =mysqli_query($config,"SELECT * FROM praktek_industri WHERE id_pi='".$_REQUEST['id_pi']."'");
                      $edit=mysqli_fetch_array($sql);  
                ?>

                <!-- Row form Start -->
                <div class="">
                
                    <!-- Form START -->
                    <form class=" " method="post" action="?page=praktek_industri&act=edit">
                        <table style="width: 100%;">
                            <tr>
                                <td style="width: 20%;">ID Praktek Industri</td>
                                <td> <input id="kd" type="text" class="validate" maxlength="30" name="id_pi" value="<?php echo $_REQUEST['id_pi']; ?>" readonly="" required></td>
                            </tr>
                            <tr>     
                                <td style="width: 20%;">Mahasiswa  </td>
                                <td><?php if ($_SESSION['admin']==1){
									?>
                                     <select name="mahasiswa"> 
                                        <?php
                                            $sql =mysqli_query($config,"SELECT * FROM mahasiswa WHERE nim='".$edit['nim']."'");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['nim']."'>$row[nama]</option>"; 
                                                        }  
                                                     ?>
                                     </select> 
								<?php }else{  ?>
									<input id="namamahasiswa" type="text" class="validate" maxlength="30" name="namamahasiswa" value="<?php echo $_SESSION['nama']; ?>" readonly="">
									<input id="mahasiswa" type="hidden" name="mahasiswa" value="<?php echo $_SESSION['username']; ?>" readonly="">
								<?php  } ?>
									 </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Dosen Pembimbing</td>
                                <td>
                                     <select name="dosen">  
                                        <?php
                                            $sql =mysqli_query($config,"SELECT * FROM dosen WHERE id_dosen='".$edit['nip']."'");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id_dosen']."'>$row[nama]</option>"; 
                                                        }  
                                                     ?>
                                     </select> </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Kegiatan Keahlian</td>
                                <td> <input type="text" id="judul_laporan" class="validate" value="<?php echo $edit['judul_laporan']; ?>" name="judul_laporan" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Tanggal Pengajuan</td>
                                <td>
                                <input   type="text" class="validate" name="tanggal_pengajuan" readonly="" value="<?php echo $edit['tgl_pengajuan_pi']; ?>" placeholder="" required></td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Tanggal Pelaksanaan</td>
                                <td>
                                <input   type="text" class="validate" name="tgl_pelaksanaan" readonly="" value="<?php echo $edit['tgl_pelaksanaan']; ?>"  placeholder="" required> </td>
                            </tr>
                            <tr>
                                <td style="width: 20%;">Perusahaan</td>
                                <td>
                                     <select name="perusahaan"> 
                                        <?php
                                            $sql =mysqli_query($config,"SELECT * FROM perusahaan WHERE id_perusahaan='".$edit['id_perusahaan']."'");  
                                                    while($row = mysqli_fetch_array($sql))
                                                       {
                                                         echo "<option value='".$row['id_perusahaan']."'>$row[nama_perusahaan]</option>"; 
                                                        }  
                                                     ?>
                                     </select></td>
                            </tr>
                            <tr>
                                <td colspan="2"><center>
                                    <div class="row">
                                        <div class="col 6">
                                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                                        </div>
                                        <div class="col 6">
                                            <a href="?page=praktek_industri" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                                        </div>
                                    </div></center></td>
                            </tr>
                        </table>
                         
                        <!-- Row in form END -->

                    </form>
                    <!-- Form END -->

                </div>
                <!-- Row form END -->

<?php
            }
        }
    }
?>
